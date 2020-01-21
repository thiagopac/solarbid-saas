<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Automate extends MY_Controller
{
    public function index() {
        $this->theme_view = 'blank';
        $core_settings = Setting::first();
        $this->load->library('parser');

        /* Check if messaging option is enabled */
        if ($core_settings->automate != '1') {
            log_message('error', '[automate] Automate link has been called but option is not enabled in settings.');
            show_error('Automate link has been called but option is not enabled!', 403);
            return false;
        }

//        redirect('automate');
    }

    public function message_chosen_company($flow_code, $type) {

        $this->theme_view = 'blank';

        if ($type == 'simulator'){
            $flow = SimulatorFlow::find('first', ['conditions' => ['code = ?', $flow_code]]);
        }else{
            $flow = StoreFlow::find('first', ['conditions' => ['code = ?', $flow_code]]);
        }

        $integrator =  json_decode($flow->integrator);

        /* new Message registry */
        $message = new Message();
        $message->company_id = $integrator->company_id;
        $message->title = $this->lang->line('application_company_chosen_title');
        $message->content.= sprintf($this->lang->line('application_company_chosen_content'), $flow->code);
        $message->save();

        /* send Push Notification */
        $push_receivers = array();

        $clients = Client::find('all', ['conditions' => ['company_id = ?', $integrator->company_id]]);
        foreach ($clients as $client){
            if ($client->push_active == 1){
                array_push($push_receivers, $client->email);
            }

            $attributes = array('client_id' => $client->id, 'message' => $this->lang->line('application_company_chosen_notification'), 'url' => base_url().'cinbox');
            ClientNotification::create($attributes);
        }

        ClientNotification::sendPushNotification($push_receivers, $this->lang->line('application_company_chosen_notification'), base_url());


       return json_response("success", htmlspecialchars($this->lang->line('messages_routine_success')));
    }
}
