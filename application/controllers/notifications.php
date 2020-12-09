<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notifications extends MY_Controller
{
    public function index()
    {
        ini_set('max_execution_time', 300); //5 minutes
        $this->theme_view = 'blank';

        $timestamp = time();
        $core_settings = Setting::first();
        $date = date('Y-m-d');
        $this->load->helper('file');
        $this->load->helper('notification');

        /* Check if cronjob option is enabled */
        if ($core_settings->notifications != '1') {
            log_message('error', '[notifications cronjob] Notifications cronjob link has been called but cronjob option is not enabled in settings.');
            show_error('Notifications cronjob link has been called but cronjob option is not enabled!', 403);
            return false;
        }

        // Log cronjob execution time
        $core_settings->last_notification = time();
        $core_settings->save();
    }

    public function read($id = false, $type){
        $options = ['conditions' => ['id = ?', $id]];

        if ($type == "user"){
            $notification = Notification::find($options);
        }else{
            $notification = ClientNotification::find($options);
        }

//        $response = Notification::sendPushNotification(array("thiago.pires@ownergy.com.br"), "Você leu uma notificação");
//        $return["allresponses"] = $response;
//        $return = json_encode($return);
//
//        $data = json_decode($response, true);
//        var_dump($data);
//        $id = $data['id'];
//        var_dump($id);
//
//        var_dump("\n\nJSON received:\n");
//        var_dump($return);
//        var_dump("\n");

        $notification->status = "read";
        $notification->save();

    }

    public function read_all($type){

        if ($type == "user"){
            Notification::update_all([
                'set' => [
                    'status' => 'read'
                ],
                'conditions' => ['user_id = ? AND status = ?', $this->user->id, 'new']
            ]);
        }else{
            ClientNotification::update_all([
                'set' => [
                    'status' => 'read'
                ],
                'conditions' => ['client_id = ? AND status = ?', $this->client->id, 'new']
            ]);
        }

    }
}
