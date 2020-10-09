<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class cAppointments extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cappointments"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('cappointments');
        }else{
            redirect('login');
        }
    }

    public function index(){


        $simulator_flows = SimulatorFlow::all(['conditions' => ['company_id = ?', $this->client->company_id], 'select'=> 'code', 'order' => 'id DESC']);
        $store_flows = StoreFlow::all(['conditions' => ['company_id = ?', $this->client->company_id], 'select'=> 'code', 'order' => 'id DESC']);
        $codes = array_merge($simulator_flows, $store_flows);
        $str_codes = array();

        foreach ($codes as $item) {
            array_push($str_codes, $item->code);
        }

        if (count($str_codes) > 0){
            $appointments = CompanyAppointment::all(['conditions' => ['flow_id in (?) OR store_flow_id in (?)', $str_codes, $str_codes], 'order' => 'id DESC']);
        }

        $manha_start = '08:00';
        $manha_end = '12:00';
        $tarde_start = '14:00';
        $tarde_end = '18:00';

        $event_list = '';
        foreach ($appointments as $value) {
            $code = $value->flow_id != null ? $value->flow_id : $value->store_flow_id;
            $object = $value->flow_id != null ? SimulatorFlow::getFlowByCode($code) : StoreFlow::getFlowByCode($code);
            $shift_start = $value->appointment_time_id == 1 ? $manha_start : $tarde_start;
            $shift_name = $shift_start == $manha_start ? '[Manhã]' : '[Tarde]';
            $bgColor = $shift_start == $manha_start ? '#0abde3' : '#ff9f43';
            $visit_concluded = '';
            if ($value->completed == true){
                $bgColor = '#27ae60';
                $visit_concluded = $this->lang->line('application_concluded_visit');
            }else{
                $visit_concluded = $this->lang->line('application_pending_visit');
            }

            $shift_end = $value->appointment_time_id == 1 ? $manha_end : $tarde_end;
            $event_list .= "{
                          title:'"."Token: #".addslashes($object->code)." \\n"." ".$shift_name." ".$visit_concluded."',
                          start: '".date('Y-m-d', strtotime($value->date))." ".$shift_start."',
                          end: '".date('Y-m-d', strtotime($value->date))." ".$shift_end."',
                          url: '".base_url().'cappointments/edit_event/'.$code."/cappointments',
                          className: '".$value->id."',
                          modal: 'true',
                          description: '".addslashes(preg_replace("/\r|\n/", '', $code))."',
                          bgColor: '".$bgColor."'
                          
                      },";
        }

        $this->view_data['core_settings'] = Setting::first();
        $this->view_data['events_list'] = $event_list;
        $this->content_view = 'appointments/client/full';
    }

    public function edit_event($token = false, $view = false) {
        if ($_POST) {
            unset($_POST['send']);

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $_POST['token']]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $_POST['token']]]);

            if ($is_simulator_flow != null){
                $event = CompanyAppointment::find(['conditions' => ['flow_id = ?', $is_simulator_flow->code]]);
            }else{
                $event = CompanyAppointment::find(['conditions' => ['store_flow_id = ?', $is_store_flow->code]]);
            }

            $view = $_POST['view'];

            unset($_POST['token']);
            unset($_POST['view']);

            $event = $event->update_attributes($_POST);
            if (!$event) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_event_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_event_success'));
            }
            if ($view == 'cappointments'){
                redirect('cappointments');
            }else if ($view == 'ctokens-simulator'){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_event_success').": ".$is_simulator_flow->code);
                redirect('ctokens/view_simulator_token/'.$is_simulator_flow->code);
            }else if ($view == 'ctokens-store'){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_event_success').": ".$is_store_flow->code);
                redirect('ctokens/view_store_token/'.$is_store_flow->code);
            }

        } else {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $event = null;
            $flow = null;
            if ($is_simulator_flow != null){
                $flow = $is_simulator_flow;
                $event = CompanyAppointment::find(['conditions' => ['flow_id = ?', $is_simulator_flow->code]]);
            }else{
                $flow = $is_store_flow;
                $event = CompanyAppointment::find(['conditions' => ['store_flow_id = ?', $is_store_flow->code]]);
            }

            $appointment_times = AppointmentTime::find('all');
            $this->view_data['appointment_times'] = $appointment_times;

            $this->view_data['integrator_approved'] = boolval($flow->integrator_approved);
            $this->view_data['view'] = $view;
            $this->view_data['event'] = $event;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_update_appointment');
            $this->view_data['form_action'] = 'cappointments/edit_event';
            $this->content_view = 'appointments/client/_event';
        }
    }
}
