<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;

        if ($this->client) {
            redirect('cdashboard');
        } elseif ($this->user) {
            if (in_array('dashboard', $this->view_data['module_permissions'])) {
                $access = true;
            }
            if (!$access && !empty($this->view_data['menu'][0])) {
                redirect($this->view_data['menu'][0]->link);
            } elseif (empty($this->view_data['menu'][0])) {
                $this->view_data['error'] = 'true';
                $this->session->set_flashdata('message', 'error: You have no access to any modules!');
                redirect('login');
            }
        } else {
            redirect('login');
        }

    }

    public function index() {
        $this->content_view = 'dashboard/dashboard';
    }

    public function taskfilter($filter){

        if ($this->user->admin == 0) {

            switch ($filter) {
                case 'all':
//                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ?', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
            }

        }

        $this->view_data['tasks'] = "";
        $this->view_data['active_task_filter'] = $filter;

        $this->content_view = 'dashboard/dashboard';
    }

}
