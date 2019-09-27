<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class cDashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cdashboard"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('dashboard');
        }else{

            redirect('login');
        }
        $this->view_data['submenu'] = array(
            $this->lang->line('application_all') => 'cdashboard',
        );

    }

    function index() {

        $this->content_view = 'dashboard/client/dashboard';
    }

    function view($id = false) {

        $this->content_view = 'dashboard/client/dashboard';
    }


}