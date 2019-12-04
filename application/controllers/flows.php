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

}
