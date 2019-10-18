<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class cPricing extends MY_Controller
{
    function __construct() {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cpricing"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('pricing');
        }else{
            redirect('login');
        }
        $this->view_data['submenu'] = array(
            $this->lang->line('application_all') => 'cpricing',
        );

    }

    function index() {

        $options = array('conditions' => 'company_id = '.$this->client->company_id, "order" => 'id DESC', 'include' => ['pricing_schema']);
        $pricing_tables = PricingTable::all($options);
        $this->view_data['pricing_tables'] = $pricing_tables;

        $this->content_view = 'pricing/client/tables';
    }

    function view($id = false) {

//        $options = array('conditions' => 'company_id = '.$this->client->company_id);
//        $this->view_data['pricing_tables'] = PricingTable::all($options);

        $this->content_view = 'pricing/client/records';
    }




}