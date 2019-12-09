<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Flows extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $access = false;
        $link = '/' . $this->uri->uri_string();

        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'flows') {
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

        $this->content_view = 'flows/all';
    }

    public function list_simulator() {

        $this->view_data['simulator_flows'] = SimulatorFlow::find('all',['order' => 'id DESC']);
        $this->content_view = 'flows/simulator_all';
    }

    public function list_store() {

        $this->view_data['store_flows'] = StoreFlow::find('all',['order' => 'id DESC']);

        $this->content_view = 'flows/store_all';
    }

    public function find() {

        if ($_POST) {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $_POST['code']]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $_POST['code']]]);

            if ($is_simulator_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_flow')." ".$is_simulator_flow->code);
                redirect('flows/view_simulator_flow/'.$is_simulator_flow->id);
            }else if($is_store_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_flow')." ".$is_store_flow->code);
                redirect('flows/view_store_flow/'.$is_store_flow->id);
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_find_flow_error'));
                redirect('flows');
            }

        }else{
            $this->theme_view = 'modal';
            $this->content_view = 'flows/_find';
            $this->view_data['title'] = $this->lang->line('application_find_flow');
        }
    }

    public function view_simulator_flow($simulator_flow_id = false) {

        $options = ['conditions' => ['id = ?', $simulator_flow_id]];
        $flow = SimulatorFlow::find($options);
        $purchase = Purchase::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);

        $this->view_data['flow'] = $flow;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;

        $this->content_view = 'flows/view_simulator_flow';
    }

    public function view_store_flow($store_flow_id = false) {

        $options = ['conditions' => ['id = ?', $store_flow_id]];
        $flow = StoreFlow::find($options);
        $purchase = Purchase::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['store_flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);

        $this->view_data['flow'] = $flow;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;

        $this->content_view = 'flows/view_store_flow';
    }

}
