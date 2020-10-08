<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tokens extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $access = false;
        $link = '/' . $this->uri->uri_string();

        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'tokens') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            $cookie = [
                   'name' => 'saas_link',
                   'value' => $link,
                   'expire' => '500',
               ];

            $this->input->set_cookie($cookie);
            redirect('login');
        }

    }

    public function index() {

        $this->content_view = 'tokens/all';
    }

    public function list_simulator() {

        $this->view_data['simulator_flows'] = SimulatorFlow::find('all',['order' => 'id DESC', 'select'=> 'id, code, city, state, type, dealer, monthly_average, activity, structure_type_id, integrator, integrator_approved, created_at','include' => ['energy_dealer', 'state', 'city', 'activity', 'structure_type']]);
        $this->content_view = 'tokens/simulator_all';
    }

    public function list_store() {

        $this->view_data['store_flows'] = StoreFlow::find('all',['order' => 'id DESC']);

        $this->content_view = 'tokens/store_all';
    }

    public function find() {

        if ($_POST) {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $_POST['code']]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $_POST['code']]]);

            if ($is_simulator_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_token')." ".$is_simulator_flow->code);
                redirect('tokens/view_simulator_token/'.$is_simulator_flow->id);
            }else if($is_store_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_token')." ".$is_store_flow->code);
                redirect('tokens/view_store_token/'.$is_store_flow->id);
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_find_token_error'));
                redirect('tokens');
            }

        }else{
            $this->theme_view = 'modal';
            $this->content_view = 'tokens/_find';
            $this->view_data['title'] = $this->lang->line('application_find_token');
        }
    }

    public function view_simulator_token($simulator_flow_code = false) {

        $options = ['conditions' => ['code = ?', $simulator_flow_code], 'include' => ['installation_local']];
        $flow = SimulatorFlow::find($options);
        $purchase = Purchase::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $company_appointment = CompanyAppointment::find(['conditions' => ['flow_id = ?', $simulator_flow_code], 'include' => ['appointment_time']]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;
        $this->view_data['pv_kit_revised'] = json_decode($flow->pv_kit_revised);
        $this->view_data['complements_revised'] = json_decode($flow->complements_revised);
        $this->view_data['integrator_revised'] = json_decode($flow->integrator_revised);

        $this->content_view = 'tokens/view_simulator_token';
    }

    public function view_store_token($store_flow_code = false) {

        $options = ['conditions' => ['code = ?', $store_flow_code]];
        $flow = StoreFlow::find($options);
        $purchase = Purchase::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['store_flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $company_appointment = CompanyAppointment::find(['conditions' => ['store_flow_id = ?', $store_flow_code], 'include' => ['appointment_time']]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;
        $this->view_data['pv_kit_revised'] = json_decode($flow->pv_kit_revised);
        $this->view_data['complements_revised'] = json_decode($flow->complements_revised);
        $this->view_data['integrator_revised'] = json_decode($flow->integrator_revised);

        $this->content_view = 'tokens/view_store_token';
    }

}
