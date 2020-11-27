<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//include_once(dirname(__FILE__).'/../../system/helpers/download_helper.php');

class cProjects extends MY_Controller {
    function __construct() {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cprojects"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('cprojects');
        }else{
            redirect('login');
        }

        $this->view_data['submenu'] = [
            $this->lang->line('application_all') => 'inbox',
            $this->lang->line('application_pendings') => 'inbox/filter/pending',
            $this->lang->line('application_sent') => 'inbox/filter/sent',
        ];

    }

    function index() {

        $steps = ProjectStep::find('all', ['conditions' => ['1 = 1 ORDER BY idx ASC']]);
        $this->view_data['steps'] = $steps;

        $items = Project::find('all', ['conditions' => ['company_id = ? ORDER BY project_step_id ASC, id DESC', $this->client->company_id]]);
        $this->view_data['items'] = $items;

        $this->content_view = 'projects/client/all';
    }

    function view($id = false) {

        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'cinbox',
        );

        $flow = null;
        $item = Project::find($id);
        if ($item->flow_id != null){
            $flow = SimulatorFlow::find('first', ['conditions' => ['code = ?', $item->flow_id]]);
        }else{
            $flow = StoreFlow::find('first', ['conditions' => ['code = ?', $item->store_flow_id]]);
        }

        $this->view_data["flow"] = $flow;
        $this->view_data["item"] = $item;
        $this->theme_view = 'ajax';

        $this->content_view = 'projects/client/view';
    }

}