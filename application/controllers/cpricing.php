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

        $pricing_table_options = array('conditions' => 'id = '.$id, "order" => 'id DESC');
        $pricing_table = PricingTable::find($pricing_table_options);

        $pricing_schema_field_options = array('conditions' => 'schema_id = '.$pricing_table->schema_id, "order" => 'id ASC', 'include' => ['pricing_field']);
        $pricing_schema_field = PricingSchemaField:: all($pricing_schema_field_options);

        $arr_field_ids = [];

        foreach ($pricing_schema_field as $row) {
            array_push($arr_field_ids, $row->field_id);
        }


        $pricing_field_options =['conditions' => ['id IN (?)', $arr_field_ids]];
        $pricing_fields = PricingField::all($pricing_field_options);

        $this->view_data['pricing_schema_field'] = $pricing_schema_field;

        $this->view_data['pricing_fields'] = $pricing_fields;

//        $this->view_data['var_dump'] = $pricing_fields;
        $this->content_view = 'pricing/client/records';
    }




}