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

    function write($ajax = FALSE)
    {
        if($_POST){

            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = TRUE;
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);
            $this->load->helper('notification');

            unset($_POST['userfile']);
            unset($_POST['file-name']);

            unset($_POST['send']);
            unset($_POST['note-codable']);
            unset($_POST['files']);
            $message = $_POST['message'];
            $receiverart = substr($_POST['recipient'], 0, 1);
            $receiverid = substr($_POST['recipient'], 1, 9999);
            if( $receiverart == "u"){
                $receiver = User::find($receiverid);
                $receiveremail = $receiver->email;
                $receiverPushActive = $receiver->push_active;
            }
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['message'] = $message;
            $_POST['time'] = date('Y-m-d H:i', time());
            $_POST['sender'] = "c".$this->client->id;
            $_POST['status'] = "New";

            if ( ! $this->upload->do_upload())
            {
                $error = $this->upload->display_errors('', ' ');

                if($error != "You did not select a file to upload."){
                    //$this->session->set_flashdata('message', 'error:'.$error);
                }
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                $_POST['attachment'] = $data['upload_data']['orig_name'];
                $_POST['attachment_link'] = $data['upload_data']['file_name'];

            }

            if(!isset($_POST['conversation'])){$_POST['conversation'] = random_string('sha1');}
            if(isset($_POST['previousmessage'])){
                $status = Privatemessage::find_by_id($_POST['previousmessage']);
                if($receiveremail == $this->client->email){
                    $receiverart = substr($status->recipient, 0, 1);
                    $receiverid = substr($status->recipient, 1, 9999);
                    $_POST['recipient'] = $status->recipient;

                    if( $receiverart == "u"){
                        $receiver = User::find($receiverid);
                        $receiveremail = $receiver->email;
                        $receiverId = $receiver->id;
                        $receiverPushActive = $receiver->push_active;
                    }
                }
                $status->status = 'Replied';
                $status->save();
                unset($_POST['previousmessage']);
            }
            $message = Privatemessage::create($_POST);
            $push_receivers = array();
            if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));}
            else{
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');
//       				send_notification($receiveremail, $message->subject, $this->lang->line('application_notification_new_message').'<br><hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>'.$_POST['message'].'<hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>');

                $attributes = array('user_id' => $receiverId, 'message' => $this->lang->line('application_notification_new_message').' de <b>'.$this->client->firstname.'</b>', 'url' => base_url().'disputes');
                Notification::create($attributes);

                if ($receiverPushActive == 1) {
                    array_push($push_receivers, $receiveremail);
                    Notification::sendPushNotification($push_receivers, $this->client->firstname . ' te enviou uma mensagem', base_url() . 'disputes');
                }


            }
            if($ajax != "reply"){ redirect('cdisputes'); }else{
                $this->theme_view = 'ajax';
            }
        }else
        {
            $this->view_data['users'] = $this->client->company->users; // User::find('all',array('conditions' => array('status=?','active')));
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_write_message');
            $this->view_data['form_action'] = 'cdisputes/write';
            $this->content_view = 'disputes/client/_messages';
        }
    }

    function view($id = false) {

        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'disputes',
        );

        $dispute = Dispute::getDispute($id);

        $this->view_data["dispute"] = $dispute;
        $this->theme_view = 'ajax';

//        $this->view_data['bids'] = $bids = DisputeHasBid::find('all', array('conditions' => array("company_id = ? AND dispute_id = ? ORDER BY id DESC", $this->client->company_id, $id)));

        $this->view_data['form_action'] = 'cdisputes/write';
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

    public function participateDispute($id = false) {

        $this->theme_view = 'ajax';

        $dispute_has_bid = new DisputeHasBid();

        $dispute_has_bid->dispute_id = $id;
        $dispute_has_bid->client_id = $this->client->id;
        $dispute_has_bid->company_id = $this->client->company_id;
        $dispute_has_bid->save();

//        $last_dispute_has_bid = DisputeHasBid::find('all', ['conditions' => ['id = ?', $dispute_has_bid->id]]);
        $bids = DisputeHasBid::find('all', ['conditions' => ['dispute_id = ? ORDER BY id DESC', $id]]);

        $data = array('bids' => object_to_array($bids, false));

        if (!isset($dispute_has_bid)) {
            json_response("error", htmlspecialchars($this->lang->line('messages_participating_dispute_error')), $data);
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_participating_dispute_error'));
        } else {
            json_response("success", htmlspecialchars($this->lang->line('messages_participating_dispute_success')), $data);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_participating_dispute_success'));
        }

        redirect('disputes/client/view');
    }

    public function participateDisputeService($id = false){

        $this->theme_view = 'blank';

        $dispute_has_bid = new DisputeHasBid();

        $dispute_has_bid->dispute_id = $id;
        $dispute_has_bid->client_id = $this->client->id;
        $dispute_has_bid->company_id = $this->client->company_id;
        $dispute_has_bid->save();

//        $bids = DisputeHasBid::find('all', array('conditions' => array("dispute_id = ? ORDER BY id DESC", $id)));
        $bids = DisputeHasBid::find('all', ['conditions' => ['dispute_id = ? ORDER BY id DESC', $id]]);

        $data = array('bids' => object_to_array($bids, false));

        if (!isset($dispute_has_bid)) {
            return json_response("error", htmlspecialchars($this->lang->line('messages_participating_dispute_error')), $data);
        } else {
            return json_response("success", htmlspecialchars($this->lang->line('messages_participating_dispute_success')), $data);
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


}