<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class cDisputes extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cdisputes"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('disputes');
        }else{

            redirect('login');
        }

        $this->view_data['submenu'] = [
                        $this->lang->line('application_all') => 'disputes',
                        $this->lang->line('application_pendings') => 'disputes/filter/pending',
                        $this->lang->line('application_sent') => 'disputes/filter/sent',
                        ];
    }

    public function index(){
        $this->content_view = 'disputes/client/all';
        $this->view_data['company_last_bid'] = "TESTEEEEE";
    }

    function disputelist(){

        $comp_has_disps = $this->view_data['comp_has_disps'] = Dispute::getDisputes(10, 10, $this->client->company_id);

//        $this->view_data['message_list_page_next'] = $con + $max_value;
//        $this->view_data['message_list_page_prev'] = $con - $max_value;
        $this->theme_view = 'ajax';

        $this->content_view = 'disputes/client/list';
    }

    function view($id = false) {

        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'disputes',
        );

        $dispute = Dispute::getDispute($id);

        $this->view_data["dispute"] = $dispute;
        $this->theme_view = 'ajax';

        $this->view_data['out_of_date'] = strtotime($dispute->due_date) < time() ? true : false;

        $bids = DisputeHasBid::find('all', array('conditions' => array("company_id = ? AND dispute_id = ? ORDER BY id DESC", $this->client->company_id, $id))); //last bid first

        $sent = 0;
        foreach ($bids as $bid) {
            if ($bid->bid_sent == 'yes') $sent++;
        }

        //all bids for the dispute and the sum
        $this->view_data['bids'] = $bids;
        $this->view_data['sent'] = $sent;

        //viewing bid
        $this->view_data['viewing_bid'] = $bids[0];

        $this->view_data['proposals'] = $proposals = BidHasProposal::find('all', ['conditions' => ['dispute_id = ? AND company_id = ? AND bid_id = ?', $id, $this->client->company_id, $bids[0]->id]]);

        $plants_with_proposal = array();

        foreach ($proposals as $proposal){
            array_push($plants_with_proposal, $proposal->plant_id);
        }

        $this->view_data['plants_with_proposal'] = $plants_with_proposal;

        $this->view_data['id'] = $id;
        $this->content_view = 'disputes/client/view';
    }

    function media($dispute_id = false, $plant_id = false){

        $this->content_view = 'disputes/client/_media';
        $this->theme_view = 'modal';
        $this->view_data['title'] = $this->lang->line('application_file');

        $dispute = Dispute::find($dispute_id);

        $media = DisputeObjectHasFile::find('first', ['conditions' => ['dispute_object_id = ? AND plant_id = ? AND kind = ?', $dispute->dispute_object_id, $plant_id, 'area']]);

        $this->view_data['media'] = $media;
    }

    public function participateDispute($id = false, $getview = false){

        if ($_POST) {

            $id = $_POST['id'];
            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }

            unset($_POST['view']);
            unset($_POST['send']);

            $dispute = Dispute::find($id);

            $out_of_date = strtotime($dispute->due_date) < time() ? true : false;

            if ($dispute->inactive == 'no' && $out_of_date == false){
                $dispute_has_bid = new DisputeHasBid();

                $dispute_has_bid->dispute_id = $id;
                $dispute_has_bid->client_id = $this->client->id;
                $dispute_has_bid->company_id = $this->client->company_id;
                $dispute_has_bid->save();
            }

            $this->theme_view = 'ajax';

            if (!isset($dispute_has_bid)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_participating_dispute_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_participating_dispute_success'));
            }

//            return json_response("success", htmlspecialchars($this->lang->line('messages_updated_proposal_success')));

        } else {

            $this->view_data['dispute'] = Dispute::find($id);

            $bids = DisputeHasBid::find('all', array('conditions' => array("company_id = ? AND dispute_id = ? ORDER BY id DESC", $this->client->company_id, $id)));

            $title = count($bids) > 0 ? $this->lang->line('application_new_participate_dispute') : $this->lang->line('application_participate_dispute') ;

            $again = count($bids) > 0 ? '_again' : '';
            $this->view_data['again'] = $again;

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $title;

            $this->view_data['form_action'] = 'cdisputes/participateDispute/'.$id;
            $this->content_view = 'disputes/client/_participate';
        }
    }

    public function allBidsByCompanyInDispute($company_id = false, $dispute_id = false){

        $this->theme_view = 'blank';

        $bids = DisputeHasBid::find('all', array('conditions' => array("company_id = ? AND dispute_id = ? ORDER BY id DESC", $company_id, $dispute_id))); //last bid first

        $sent = 0;
        foreach ($bids as $bid) {
            if ($bid->bid_sent == 'yes') $sent++;
        }

        $data = array('bids' => object_to_array($bids), 'bids_sent' => $sent);

        return json_response("success", htmlspecialchars($this->lang->line('messages_registries_retrieved_success')), $data);
    }

    public function proposalsInBid($bid_id){

        $this->theme_view = 'blank';

        $proposals = BidHasProposal::find('all', array('conditions' => array("bid_id = ?", $bid_id)));

        $data = array('proposals' => object_to_array($proposals));

        return json_response("success", htmlspecialchars($this->lang->line('messages_registries_retrieved_success')), $data);
    }

    public function createProposal($dispute_id = false, $bid_id = false, $plant_id = false, $getview = false){

        if ($_POST) {

            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }
            unset($_POST['view']);
            unset($_POST['send']);
            unset($_POST['id']);
            unset($_POST['proposal_id']);

            $_POST['dispute_id'] = $dispute_id;
            $_POST['bid_id'] = $bid_id;
            $_POST['plant_id'] = $plant_id;
            $_POST['client_id'] = $this->client->id;
            $_POST['company_id'] = $this->client->company_id;

            if (!empty($_POST['modules_arr'])) {
                $_POST['module_brands'] = implode(',', $_POST['modules_arr']);
            } else {
                $_POST['module_brands'] = implode(',', $_POST['modules_arr']);
            }
            unset($_POST['modules_arr']);

            if (!empty($_POST['inverters_arr'])) {
                $_POST['inverter_brands'] = implode(',', $_POST['inverters_arr']);
            } else {
                $_POST['inverter_brands'] = implode(',', $_POST['inverters_arr']);
            }
            unset($_POST['inverters_arr']);

            $_POST['value'] = str_replace('.', '', $_POST['value']);
            $_POST['value'] = str_replace(',', '.', $_POST['value']);

            $proposal = BidHasProposal::create($_POST);

            $this->theme_view = 'ajax';

            if (!$proposal) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_proposal_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_proposal_success'));
            }

        } else {

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }

            $modules = array();
            $all_modules = ModuleManufacturer::all();
            foreach ($all_modules as $module){
                array_push($modules, $module->name);
            }
            $this->view_data['modules'] = $modules;

            $inverters = array();
            $all_inverters = InverterManufacturer::all();
            foreach ($all_inverters as $inverter){
                array_push($inverters, $inverter->name);
            }
            $this->view_data['inverters'] = $inverters;

            $this->view_data['dispute_id'] = $dispute_id;
            $this->view_data['bid_id'] = $bid_id;
            $this->view_data['plant_id'] = $plant_id;

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_proposal')." (".$this->lang->line('application_plant')." ".strtoupper(substr(md5($plant_id), 20, 5)).")";

            $this->view_data['form_action'] = 'cdisputes/createProposal/'.$dispute_id."/".$bid_id."/".$plant_id;
            $this->content_view = 'disputes/client/_proposal';
        }
    }

    public function updateProposal($dispute_id = false, $proposal_id = false, $getview = false){

        if ($_POST) {

            $proposal_id = $_POST['proposal_id'];
            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }
            unset($_POST['view']);
            unset($_POST['send']);
            unset($_POST['proposal_id']);

            if (!empty($_POST['modules_arr'])) {
                $_POST['module_brands'] = implode(',', $_POST['modules_arr']);
            } else {
                $_POST['module_brands'] = implode(',', $_POST['modules_arr']);
            }
            unset($_POST['modules_arr']);

            if (!empty($_POST['inverters_arr'])) {
                $_POST['inverter_brands'] = implode(',', $_POST['inverters_arr']);
            } else {
                $_POST['inverter_brands'] = implode(',', $_POST['inverters_arr']);
            }
            unset($_POST['inverters_arr']);

            $_POST['value'] = str_replace('.', '', $_POST['value']);
            $_POST['value'] = str_replace(',', '.', $_POST['value']);

            $proposal = BidHasProposal::find_by_id($proposal_id);

            $proposal->update_attributes($_POST);

            $this->theme_view = 'ajax';

            if (!$proposal) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_proposal_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_proposal_success'));
            }

        } else {
            $proposal = $this->view_data['proposal'] = BidHasProposal::find($proposal_id);

            $this->view_data['proposal_id'] = $proposal_id;

            $modules = array();
            $all_modules = ModuleManufacturer::all();
            foreach ($all_modules as $module){
                array_push($modules, $module->name);
            }
            $this->view_data['modules'] = $modules;

            $inverters = array();
            $all_inverters = InverterManufacturer::all();
            foreach ($all_inverters as $inverter){
                array_push($inverters, $inverter->name);
            }
            $this->view_data['inverters'] = $inverters;

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_proposal')." (".$this->lang->line('application_plant')." ".strtoupper(substr(md5($proposal->plant_id), 20, 5)).")";

            $this->view_data['form_action'] = 'cdisputes/updateProposal';
            $this->content_view = 'disputes/client/_proposal';
        }
    }

    public function sendBid($dispute_id = false, $bid_id = false, $getview = false){

        if ($_POST) {

            $bid_id = $_POST['bid_id'];
            $dispute_id = $_POST['dispute_id'];
            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }
            unset($_POST['view']);
            unset($_POST['send']);


            $bid = DisputeHasBid::find($bid_id);

            $bid->bid_sent = 'yes';

            $bid->save();

            $this->theme_view = 'ajax';

            if (!$bid) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_send_bid_error'));
            }else{
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_bid_success'));
            }

        }else{

            $this->view_data['bid_id'] = $bid_id;
            $this->view_data['dispute_id'] = $dispute_id;

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_send_bid');

            $this->view_data['form_action'] = 'cdisputes/sendBid';
            $this->content_view = 'disputes/client/_send';
        }
    }


}