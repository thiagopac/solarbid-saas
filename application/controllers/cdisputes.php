<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class cDisputes extends MY_Controller
{
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
    }

    function disputelist(){

        $comp_has_disps = $this->view_data['comp_has_disps'] = Dispute::getDisputes(10, 10, $this->client->company_id);

//        $this->view_data['message_list_page_next'] = $con + $max_value;
//        $this->view_data['message_list_page_prev'] = $con - $max_value;
        $this->theme_view = 'ajax';

        $this->content_view = 'disputes/client/list';
    }
    function filter($condition = FALSE, $con = FALSE)
    {
        $max_value = 60;
        if (is_numeric($con)) {
            $limit = $con . ',';
        } else {
            $limit = false;
        }

        $this->view_data['filter'] = ucfirst($condition);
        $this->view_data['message'] = Privatemessage::getMessagesWithFilter($limit, $max_value, $condition, $this->client->id, true);

        $this->view_data['message_list_page_next'] = $con + $max_value;
        $this->view_data['message_list_page_prev'] = $con - $max_value;


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
    function update($id = FALSE, $getview = FALSE)
    {
        if($_POST){
            unset($_POST['send']);
            unset($_POST['_wysihtml5_mode']);
            unset($_POST['files']);
            $id = $_POST['id'];
            $message = Privatemessage::find($id);
            $message->update_attributes($_POST);
            if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));}
            else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));}
            if(isset($view)){redirect('cdisputes/view/'.$id);}else{redirect('cdisputes');}

        }else
        {
            $this->view_data['id'] = $id;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_message');
            $this->view_data['form_action'] = 'cdisputes/update';
            $this->content_view = 'disputes/client/_messages_update';
        }
    }

    function attachment($id = FALSE){
        $this->load->helper('download');
        $this->load->helper('file');

        $attachment = Privatemessage::find_by_id($id);

        $file = './files/media/'.$attachment->attachment_link;
        $mime = get_mime_by_extension($file);

        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($attachment->attachment));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            ob_clean();
            flush();
            exit;
        }
    }

    function view($id = false) {
        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'disputes',
        );

        $dispute = Dispute::getDispute($id);

        $this->view_data["dispute"] = $dispute;
        $this->theme_view = 'ajax';

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

//        foreach ($dispute->dispute_object->dispute_object_has_files as $file){
//            if ($file->kind == 'area'){
//                $media_area = $file;
//            }
//        }

        $this->view_data['media'] = $media;
    }


}