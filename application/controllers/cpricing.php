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

    function view($table_id = false) {

        $pricing_table_options = array('conditions' => 'id = '.$table_id, "order" => 'id DESC');
        $pricing_table = PricingTable::find($pricing_table_options);

        $pricing_schema_field_options = array('conditions' => 'schema_id = '.$pricing_table->schema_id, "order" => 'id ASC', 'include' => ['pricing_field']);
        $pricing_schema_field = PricingSchemaField:: all($pricing_schema_field_options);

        $arr_field_ids = [];

        foreach ($pricing_schema_field as $row) {
            array_push($arr_field_ids, $row->field_id);
        }

        $this->view_data['pricing_schema_field'] = $pricing_schema_field;

        $pricing_field_options = ['conditions' => ['id IN (?)', $arr_field_ids], "order" => 'power_bottom ASC'];
        $pricing_fields = PricingField::all($pricing_field_options);

        $this->view_data['pricing_fields'] = $pricing_fields;

        $pricing_records_options = ['conditions' => ['field_id IN (?) AND table_id = (?) AND company_id = (?)', $arr_field_ids, $table_id, $pricing_table->company_id], "order" => 'id ASC'];
        $pricing_records = PricingRecord::all($pricing_records_options);

        $this->view_data['pricing_table'] = PricingTable::find($table_id);
        $this->view_data['pricing_records'] = $pricing_records;

//        $this->view_data['var_dump'] = $pricing_records;
        $this->content_view = 'pricing/client/records';

        $this->view_data['pricing_table_complete'] = 2*count($pricing_fields) === count($pricing_records) ? true : false;
    }

    public function update($pricing_record_id = false)
    {

        $pricing_record = PricingRecord::find($pricing_record_id);

        if ($_POST) {

            if (isset($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            } else {
                unset($_POST['access']);
            }

            $pricing_record->update_attributes($_POST);
            if (!$pricing_record) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pricing_record_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pricing_record_success'));
            }
            redirect('cpricing/view/'.$pricing_record->table_id);
        } else {
            $pricing_record = PricingRecord::find($pricing_record_id);
            $this->view_data['pricing_record'] = $pricing_record;
            $this->view_data['pricing_field'] = PricingField::find($pricing_record->field_id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_pricing_record');
            $this->view_data['form_action'] = 'cpricing/update/'.$pricing_record_id;
            $this->view_data['pricing_record_structure_types'] = $pricing_record->structure_type_ids;
            $this->content_view = 'pricing/client/_record';
        }
    }

    public function create($pricing_table_id = false, $pricing_field_id = false, $structures_type_ids = false) {

        if ($_POST) {

            if (isset($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            } else {
                unset($_POST['access']);
            }

            $_POST['company_id'] = $this->client->company_id;
            $_POST['table_id'] = $pricing_table_id;
            $_POST['field_id'] = $pricing_field_id;

            if ($structures_type_ids == '123'){
                $_POST['structure_type_ids'] = '1,2,3';
            }else{
                $_POST['structure_type_ids'] = '4,5';
            }

//            var_dump($_POST);

            $pricing_record = PricingRecord::create($_POST);

            if (!$pricing_record) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pricing_record_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pricing_record_success'));
            }
            redirect('cpricing/view/'.$pricing_table_id);
        } else {
            $this->view_data['pricing_field'] = PricingField::find($pricing_field_id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_pricing_record');
            $this->view_data['form_action'] = 'cpricing/create/'.$pricing_table_id.'/'.$pricing_field_id.'/'.$structures_type_ids;

            $this->content_view = 'pricing/client/_record';

            if ($structures_type_ids === '123'){
                $this->view_data['pricing_record_structure_types'] = '1,2,3';
            }else{
                $this->view_data['pricing_record_structure_types'] = '4,5';
            }
        }
    }

    public function activate($pricing_table_id = false) {

        if ($_POST) {

            $pricing_table = PricingTable::find($_POST['pricing_table_id']);

            unset($_POST['pricing_table_id']);

            $_POST['active'] = $pricing_table->active == true ? 0 : 1;

            //deactivate all active pricing_tables before change to chosen state
            PricingTable::update_all(['set' => [ 'active' => '0'], 'conditions' => [ 'company_id = ? AND active = 1', $this->client->company_id]]);

            $pricing_table->update_attributes($_POST);

            if (!$pricing_table) {

                if ($_POST['active'] == 0){
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_deactivated_pricing_table_error'));
                }else{
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_activated_pricing_table_error'));
                }

            } else {

                if ($_POST['active'] == 0){
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_deactivated_pricing_table_success'));
                }else{
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_activated_pricing_table_success'));
                }

            }
            redirect('cpricing/view/'.$pricing_table_id);
        } else {

            $pricing_table = PricingTable::find($pricing_table_id);

            $this->view_data['pricing_table'] = $pricing_table;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $pricing_table->active == true ? $this->lang->line('application_deactivate_pricing_table') : $this->lang->line('application_activate_pricing_table');
            $this->view_data['form_action'] = 'cpricing/activate/'.$pricing_table_id;
            $this->content_view = 'pricing/client/_activate';
        }
    }

    public function update_table($pricing_table_id = false) {

        $pricing_table = PricingTable::find($pricing_table_id);

        if ($_POST) {

            $pricing_table->update_attributes($_POST);
            if (!$pricing_table) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pricing_table_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pricing_table_success'));
            }
            redirect('cpricing/view/'.$pricing_table_id);
        } else {
            $pricing_table = PricingTable::find($pricing_table_id);
            $this->view_data['pricing_table'] = $pricing_table;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_pricing_table');
            $this->view_data['form_action'] = 'cpricing/update_table/'.$pricing_table_id;
            $this->content_view = 'pricing/client/_table';
        }
    }

    public function create_table() {

        $company = Company::find($this->client->company_id);

        if ($_POST) {

//            $_POST['schema_id'] = 1; //force pricing_schema to be 1 if needed

            $_POST['company_id'] = $company->id;
            $_POST['active'] = 0;

            $pricing_table = PricingTable::create($_POST);

            if (!$pricing_table) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_pricing_table_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_pricing_table_success'));
            }
            redirect('cpricing');
        } else {

            $plan_schemas = IntegratorPlan::first(['conditions' => ['id = ?', $company->plan_id], 'select'=>'pricing_schemas']);

            $pricing_schemas = PricingSchema::find('all', ['conditions' => ['id IN (?)', explode(',',$plan_schemas->pricing_schemas)]]);
            $this->view_data['pricing_schemas'] = $pricing_schemas;

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_pricing_table');
            $this->view_data['form_action'] = 'cpricing/create_table/';
            $this->content_view = 'pricing/client/_table';
        }
    }

}