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


        $this->view_data['all_proposals'] = BidHasProposal::find('all', ['conditions' => ['dispute_id = ? AND company_id = ? ORDER BY id DESC', $id, $this->client->company_id]]);


        $all_bids_in_dispute = $this->view_data['all_bids_in_dispute'] = DisputeHasBid::find('all', ['conditions' => ['dispute_id = ? AND company_id = ?', $id, $this->client->company_id], 'include' => 'bid_has_proposals']);

        //all bids for the dispute and the sum
        $this->view_data['bids'] = $all_bids_in_dispute;
        $this->view_data['sent'] = array_sum(array_column($all_bids_in_dispute, 'bid_sent'));

        //viewing bid - last bid in array
        $viewing_bid = $this->view_data['viewing_bid'] = $all_bids_in_dispute[count($all_bids_in_dispute)-1];

        $sum_values_percent = 'equal';
        $sum_values_direct_own = '100';
        $at_least_one_wrong_percent = true;
        $arr_incorrect_proposals = array();

        foreach ($viewing_bid->bid_has_proposals as $proposal){
            $arr_values_sum = array_sum(explode(',',$proposal->own_installment_values));

            if ($arr_values_sum > 100){
                $sum_values_percent = 'higher';
            }else if ($arr_values_sum < 100){
                $sum_values_percent = 'lower';
            }else if ($arr_values_sum == 100){
                $sum_values_percent = 'equal';
            }

            $sum_values_direct_own = ($proposal->direct_billing_percentage + $proposal->own_installment_percentage);

            if ($sum_values_direct_own > 100 || $arr_values_sum > 100){
                array_push($arr_incorrect_proposals, $proposal->id);
                $at_least_one_wrong_percent = true;
            }
        }

        $this->view_data['sum_values_direct_own'] = $sum_values_direct_own;
        $this->view_data['sum_values_percent'] = $sum_values_percent;
        $this->view_data['at_least_one_wrong_percent'] = $at_least_one_wrong_percent;
        $this->view_data['arr_incorrect_proposals'] = $arr_incorrect_proposals;


        $plants_with_proposal = array();

        foreach ($viewing_bid->bid_has_proposals as $proposal){
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
            if ($bid->bid_sent == true) $sent++;
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

            /*- begin payment conditions code -*/

            $arr_installment_values = array();

            if ($_POST['own_installment_payment_trigger'] == 'per_month'){
                unset($_POST['event']);
                foreach ($_POST['month_percent'] as $month_percent){
                    if ($month_percent != '0'){
                        array_push($arr_installment_values, $month_percent);
                    }
                }
            }else if($_POST['own_installment_payment_trigger'] == 'per_event'){
                foreach ($_POST['event_percent'] as $event_percent){
                    if ($event_percent != '0'){
                        array_push($arr_installment_values, $event_percent);
                    }
                }
            }

            $arr_installment_values = array_slice($arr_installment_values, 0, $_POST['own_installment_quantity']); //values needs to store only the number of quantity filled
            $str_installment_values = implode(',', $arr_installment_values);

            $arr_events = array_filter($_POST['event'], 'strlen');
            $arr_events = array_slice($arr_events, 0, $_POST['own_installment_quantity']); //events needs to store only the number of quantity filled
            $str_events = implode(',', $arr_events);

            unset($_POST['month_percent']);
            unset($_POST['event_percent']);
            unset($_POST['event']);

            /*- end payment conditions code -*/

            $proposal = new BidHasProposal();
            $proposal->dispute_id = $dispute_id;
            $proposal->bid_id = $bid_id;
            $proposal->plant_id = $plant_id;
            $proposal->client_id  = $this->client->id;
            $proposal->company_id = $this->client->company_id;
            $proposal->value = $_POST['value'];
            $proposal->rated_power_mod = $_POST['rated_power_mod'];
            $proposal->module_brands = $_POST['module_brands'];
            $proposal->inverter_brands = $_POST['inverter_brands'];
            $proposal->delivery_time = $_POST['delivery_time'];
            $proposal->payment_conditions = $_POST['payment_conditions'];
            $proposal->direct_billing_percentage = $_POST['direct_billing_percentage'];
            $proposal->own_installment_percentage = $_POST['own_installment_percentage'];
            $proposal->own_installment_payment_trigger = $_POST['own_installment_payment_trigger'];
            $proposal->own_installment_quantity = $_POST['own_installment_quantity'];
            $proposal->own_installment_values = $str_installment_values;
            $proposal->own_installment_payment_events = $str_events;

            $proposal->save();

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

            //payment load data
            $this->view_data['payment_events'] = PaymentEvent::find('all');

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
            $this->view_data['title'] = $this->lang->line('application_create_proposal')." (".$this->lang->line('application_plant')." ".DisputeObjectHasPlant::plantNickname($plant_id).")";

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

            /*- begin payment conditions code -*/

            $arr_installment_values = array();

            if ($_POST['own_installment_payment_trigger'] == 'per_month'){
                unset($_POST['event']);
                foreach ($_POST['month_percent'] as $month_percent){
                    if ($month_percent != '0'){
                        array_push($arr_installment_values, $month_percent);
                    }
                }
            }else if($_POST['own_installment_payment_trigger'] == 'per_event'){
                foreach ($_POST['event_percent'] as $event_percent){
                    if ($event_percent != '0'){
                        array_push($arr_installment_values, $event_percent);
                    }
                }
            }

            $arr_installment_values = array_slice($arr_installment_values, 0, $_POST['own_installment_quantity']); //values needs to store only the number of quantity filled
            $str_installment_values = implode(',', $arr_installment_values);

            $arr_events = array_filter($_POST['event'], 'strlen');
            $arr_events = array_slice($arr_events, 0, $_POST['own_installment_quantity']); //events needs to store only the number of quantity filled
            $str_events = implode(',', $arr_events);

            unset($_POST['month_percent']);
            unset($_POST['event_percent']);
            unset($_POST['event']);

            /*- end payment conditions code -*/

            $proposal = BidHasProposal::find_by_id($proposal_id);
            $proposal->value = $_POST['value'];
            $proposal->rated_power_mod = $_POST['rated_power_mod'];
            $proposal->module_brands = $_POST['module_brands'];
            $proposal->inverter_brands = $_POST['inverter_brands'];
            $proposal->delivery_time = $_POST['delivery_time'];
            $proposal->payment_conditions = $_POST['payment_conditions'];
            $proposal->direct_billing_percentage = $_POST['direct_billing_percentage'];
            $proposal->own_installment_percentage = $_POST['own_installment_percentage'];
            $proposal->own_installment_payment_trigger = $_POST['own_installment_payment_trigger'];
            $proposal->own_installment_quantity = $_POST['own_installment_quantity'];
            $proposal->own_installment_values = $str_installment_values;
            $proposal->own_installment_payment_events = $str_events;

            $proposal->save();

            $this->theme_view = 'ajax';

            if (!$proposal) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_proposal_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_proposal_success'));
            }

        } else {
            $proposal = $this->view_data['proposal'] = BidHasProposal::find($proposal_id);

            $this->view_data['proposal_id'] = $proposal_id;

            //payment load data
            $this->view_data['payment_events'] = PaymentEvent::find('all');
            $this->view_data['payment_events_selected'] = explode(',', $proposal->own_installment_payment_events);
            //same column - the differece is what the value stands for, an event or a month
            $this->view_data['event_values'] = explode(',', $proposal->own_installment_values);
            $this->view_data['months'] = explode(',', $proposal->own_installment_values);


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
            $this->view_data['title'] = $this->lang->line('application_edit_proposal')." (".$this->lang->line('application_plant')." ".DisputeObjectHasPlant::plantNickname($proposal->plant_id).")";

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

            $bid->bid_sent = 1;

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