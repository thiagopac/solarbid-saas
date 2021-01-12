<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//include_once(dirname(__FILE__).'/../../system/helpers/download_helper.php');

class cHelp extends MY_Controller {
    function __construct() {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "chelp"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('chelp');
        }else{
            redirect('login');
        }

    }

    function index() {

        $this->content_view = 'help/client/view';
    }
}