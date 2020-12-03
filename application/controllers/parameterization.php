<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parameterization extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $access = false;
        unset($_POST['DataTables_Table_0_length']);
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'parameterization') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }

        $this->view_data['submenu'] = [
            $this->lang->line('application_departments') => 'parameterization/departments',
            'devider1' => 'devider',
            $this->lang->line('application_pv_providers') => 'parameterization/pv_providers',
            $this->lang->line('application_modules') => 'parameterization/modules',
            $this->lang->line('application_inverters') => 'parameterization/inverters',
            'devider2' => 'devider',
            $this->lang->line('application_proformas') => 'parameterization/proformas',
            $this->lang->line('application_proforma_items') => 'parameterization/proforma_items',
            $this->lang->line('application_pv_item') => 'parameterization/pv_items',
            'devider3' => 'devider',
            $this->lang->line('application_energy_dealers') => 'parameterization/dealers',
            $this->lang->line('application_activities') => 'parameterization/activities',
            $this->lang->line('application_tariffs') => 'parameterization/tariffs',
            'devider4' => 'devider',
            $this->lang->line('application_structure_types') => 'parameterization/structure_types',
            'devider5' => 'devider',
            $this->lang->line('application_faq_customers') => 'parameterization/faq_customer',
            $this->lang->line('application_faq_integrators') => 'parameterization/faq_integrator',
            'devider6' => 'devider',
            $this->lang->line('application_integrator_benefits') => 'parameterization/integrator_benefits',
            $this->lang->line('application_integrators_plans') => 'parameterization/integrator_plans',
            $this->lang->line('application_pricing_schemas') => 'parameterization/pricing_schemas',
            $this->lang->line('application_pricing_fields') => 'parameterization/pricing_fields',
            $this->lang->line('application_pricing_schema_fields') => 'parameterization/pricing_schema_fields',
            'devider7' => 'devider',
            $this->lang->line('application_countries') => 'parameterization/countries',
            $this->lang->line('application_states') => 'parameterization/states',
            $this->lang->line('application_regions') => 'parameterization/regions',
            $this->lang->line('application_cities') => 'parameterization/cities/mg',
            'devider8' => 'devider',
            $this->lang->line('application_card_interest') => 'parameterization/card_interest',
        ];

        $this->view_data['iconlist'] = [
            'parameterization/departments' => 'dripicons-network-1',
            'parameterization/pv_providers' => 'dripicons-stack',
            'parameterization/modules' => 'dripicons-view-thumb',
            'parameterization/inverters' => 'dripicons-pulse',
            'parameterization/proformas' => 'dripicons-article',
            'parameterization/proforma_items' => 'dripicons-article',
            'parameterization/pv_items' => 'dripicons-article',
            'parameterization/dealers' => 'dripicons-lightbulb',
            'parameterization/activities' => 'dripicons-store',
            'parameterization/tariffs' => 'dripicons-to-do',
            'parameterization/structure_types' => 'dripicons-vibrate',
            'parameterization/faq_customer' => 'dripicons-question',
            'parameterization/faq_integrator' => 'dripicons-question',
            'parameterization/integrator_benefits' => 'dripicons-checklist',
            'parameterization/integrator_plans' => 'dripicons-jewel',
            'parameterization/pricing_fields' => 'dripicons-view-list-large',
            'parameterization/pricing_schemas' => 'dripicons-view-list-large',
            'parameterization/pricing_schema_fields' => 'dripicons-view-list-large',
            'parameterization/countries' => 'dripicons-location',
            'parameterization/states' => 'dripicons-location',
            'parameterization/regions' => 'dripicons-location',
            'parameterization/cities/mg' => 'dripicons-location',
            'parameterization/card_interest' => 'dripicons-card',
        ];

        $this->config->load('defaults');
    }

    public function index(){
        $this->departments();
    }

    //wildcard_listing
    public function departments(){

        //master data class
        $class_name = 'Department';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_departments');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_departments');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_department');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function modules(){

        //master data class
        $class_name = 'ModuleManufacturer';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_modules');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_modules');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_module');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function inverters() {

        //master data class
        $class_name = 'InverterManufacturer';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_inverters');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_inverters');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_inverter');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function dealers() {
        $this->view_data['breadcrumb'] = $this->lang->line('application_dealers');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $dealers = EnergyDealer::find('all');
        $this->view_data['dealers'] = $dealers;
        $this->content_view = 'parameterization/dealers';
    }

    public function dealer_update($dealer_id = false){
        $dealer = EnergyDealer::find($dealer_id);

        if ($_POST) {
            $dealer->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));
            redirect('parameterization/dealers');
        } else {
            $this->view_data['dealer'] = $dealer;
            $this->view_data['states'] = State::all();
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_energy_dealer');
            $this->view_data['form_action'] = 'parameterization/dealer_update/' . $dealer->id;
            $this->content_view = 'parameterization/_dealerform';
        }
    }

    public function dealer_create(){

        if ($_POST) {
            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $dealer_exists = EnergyDealer::find($options);
            if (empty($dealer_exists)) {
                $dealer = EnergyDealer::create($_POST);
                if (!$dealer) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_exists'));
            }
            redirect('parameterization/dealers');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['states'] = State::all();
            $this->view_data['title'] = $this->lang->line('application_energy_dealer');
            $this->view_data['form_action'] = 'parameterization/dealer_create/';
            $this->content_view = 'parameterization/_dealerform';
        }
    }

    public function dealer_delete($dealer_id = false){

        $dealer = EnergyDealer::find($dealer_id);
        $dealer->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));

        redirect('parameterization/dealers');
    }

    public function proforma_items() {
        $this->view_data['breadcrumb'] = $this->lang->line('application_proforma_items');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = $this->user->admin == 1;

        $proforma_items = PvProformaItem::find('all');
        $this->view_data['proforma_items'] = $proforma_items;
        $this->content_view = 'parameterization/proforma_items';
    }

    public function proforma_item_update($proforma_item_id = false){
        $proforma_item = PvProformaItem::find($proforma_item_id);

        if ($_POST) {
            $proforma_item->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));
            redirect('parameterization/proforma_items');
        } else {
            $this->view_data['proforma_item'] = $proforma_item;
            $this->view_data['proformas'] = $proformas = PvProforma::all();
            $this->view_data['pv_items'] = PvItem::all();
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_proforma_item');
            $this->view_data['form_action'] = 'parameterization/proforma_item_update/' . $proforma_item->id;
            $this->content_view = 'parameterization/_proforma_item_form';
        }
    }

    public function proforma_item_create(){

        if ($_POST) {
            $proforma_item = PvProformaItem::create($_POST);

            if (!$proforma_item) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
            }

            redirect('parameterization/proforma_items');
        } else {
            $this->view_data['proformas'] = $proformas = PvProforma::all();
            $this->view_data['pv_items'] = PvItem::all();
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_proforma_item');
            $this->view_data['form_action'] = 'parameterization/proforma_item_create/';
            $this->content_view = 'parameterization/_proforma_item_form';
        }
    }

    public function proforma_item_delete($proforma_item_id = false){

        $proforma_item = PvProformaItem::find($proforma_item_id);
        $proforma_item->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));

        redirect('parameterization/proforma_items');
    }

    //wildcard_listing
    public function activities() {

        //master data class
        $class_name = 'Activity';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_activities');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_activities');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ["conditions"=>['deleted = 0']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_activity');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;

    }

    //wildcard_listing
    public function tariffs() {

        //master data class
        $class_name = 'DealerActivityTariff';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_tariffs');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_tariffs');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ['include'=>['energy_dealer','activity']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_energy_dealer'),$this->lang->line('application_activity'),$this->lang->line('application_value'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self', 'energy_dealer','activity','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name','name','value'];

        //wildcard modal behavior elements
        $this->view_data['update_method'] = 'parameterization/tariff_update';
        $this->view_data['create_method'] = 'parameterization/tariff_create';
        $this->view_data['delete_method'] = 'parameterization/tariff_delete';
    }

    public function tariff_update($object_id = false){
        $object = DealerActivityTariff::find($object_id);

        if ($_POST) {
            $object->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));
            redirect('parameterization/tariffs');
        } else {
            $this->view_data['object'] = $object;
            $this->view_data['dealers'] = EnergyDealer::find('all');
            $this->view_data['activities'] = Activity::find('all',['conditions'=>['deleted = 0']]);
            $this->theme_view = 'modal';
            $this->content_view = 'parameterization/_tariffform';

            $this->view_data['title'] = $this->lang->line('application_tariff');
            $this->view_data['form_action'] = 'parameterization/tariff_update/' . $object->id;

        }
    }

    public function tariff_create(){

        if ($_POST) {
            $options = ['conditions' => ['energy_dealer_id = ? AND activity_id = ?', $_POST['energy_dealer_id'],$_POST['activity_id']]];
            $object_exists = DealerActivityTariff::find($options);
            if (empty($object_exists)) {
                $object = DealerActivityTariff::create($_POST);
                if (!$object) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_exists'));
            }
            redirect('parameterization/tariffs');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['dealers'] = EnergyDealer::find('all');
            $this->view_data['activities'] = Activity::find('all',['conditions'=>['deleted = 0']]);
            $this->view_data['title'] = $this->lang->line('application_tariff');
            $this->view_data['form_action'] = 'parameterization/tariff_create/';
            $this->content_view = 'parameterization/_tariffform';
        }
    }

    //wildcard_listing
    public function pv_providers() {

        //master data class
        $class_name = 'PvProvider';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_pv_providers');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_pv_providers');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pv_provider');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;

    }

    public function structure_types() {

        //master data class
        $class_name = 'StructureType';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_structure_types');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_structure_types');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_structure_type');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function faq_customer() {

        $class_name = "FaqCustomer";

        $this->view_data['breadcrumb'] = $this->lang->line('application_faq_customers');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = $this->user->admin == 1;

        $this->view_data['table_title'] = $this->lang->line('application_faq_customers');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_question'),$this->lang->line('application_answer'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'question', 'answer'];

        $this->view_data['update_method'] = 'parameterization/faq_customer_update/';
        $this->view_data['create_method'] = 'parameterization/faq_customer_create/';
        $this->view_data['delete_method'] = 'parameterization/faq_customer_delete/';

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';
    }

    public function faq_customer_update($object_id = false){
        $object = FaqCustomer::find($object_id);

        if ($_POST) {
            $object->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));
            redirect('parameterization/faq_customer');
        } else {
            $this->view_data['object'] = $object;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_question');
            $this->view_data['form_action'] = 'parameterization/faq_customer_update/' . $object->id;
            $this->content_view = 'parameterization/_faqform';
        }
    }

    public function faq_customer_create(){

        if ($_POST) {
            if (1==1) {
                $object = FaqCustomer::create($_POST);
                if (!$object) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_exists'));
            }
            redirect('parameterization/faq_customer');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_question');
            $this->view_data['form_action'] = 'parameterization/faq_customer_create/';
            $this->content_view = 'parameterization/_faqform';
        }
    }

    public function faq_customer_delete($object_id = false){

        //Physical deletion
        $object = FaqCustomer::find($object_id);
        $object->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));

        redirect('parameterization/faq_customer');
    }

    public function faq_integrator() {

        $class_name = "FaqIntegrator";

        $this->view_data['breadcrumb'] = $this->lang->line('application_faq_integrators');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = $this->user->admin == 1;

        $this->view_data['table_title'] = $this->lang->line('application_faq_integrators');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_question'),$this->lang->line('application_answer'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'question', 'answer'];

        $this->view_data['update_method'] = 'parameterization/faq_integrator_update/';
        $this->view_data['create_method'] = 'parameterization/faq_integrator_create/';
        $this->view_data['delete_method'] = 'parameterization/faq_integrator_delete/';

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';
    }

    public function faq_integrator_update($object_id = false){
        $object = FaqIntegrator::find($object_id);

        if ($_POST) {
            $object->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));
            redirect('parameterization/faq_integrator');
        } else {
            $this->view_data['object'] = $object;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_question');
            $this->view_data['form_action'] = 'parameterization/faq_integrator_update/' . $object->id;
            $this->content_view = 'parameterization/_faqform';
        }
    }

    public function faq_integrator_create(){

        if ($_POST) {
            if (1==1) {
                $object = FaqIntegrator::create($_POST);
                if (!$object) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_exists'));
            }
            redirect('parameterization/faq_integrator');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_question');
            $this->view_data['form_action'] = 'parameterization/faq_integrator_create/';
            $this->content_view = 'parameterization/_faqform';
        }
    }

    public function faq_integrator_delete($object_id = false){

        //Physical deletion
        $object = FaqIntegrator::find($object_id);
        $object->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));

        redirect('parameterization/faq_integrator');
    }

    //wildcard_listing
    public function integrator_benefits() {

        //master data class
        $class_name = 'IntegratorBenefit';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_integrator_benefits');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_integrator_benefits');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_integrator_benefit');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function integrator_plans() {

        $class_name = "IntegratorPlan";

        $this->view_data['breadcrumb'] = $this->lang->line('application_integrators_plans');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = false;
        $this->view_data['show_edit_button'] = true;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_integrators_plans');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_price'),$this->lang->line('application_benefits'),$this->lang->line('application_pricing_schemas'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self', 'self', 'self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'price', 'benefits', 'pricing_schemas'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_integrators_plan');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
        //None of these methods are created yet

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';
    }

    //wildcard_listing
    public function pricing_schemas() {

        $class_name = "PricingSchema";

        $this->view_data['breadcrumb'] = $this->lang->line('application_pricing_schemas');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_pricing_schemas');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
            $this->lang->line('application_name'),
            $this->lang->line('application_description'),
            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'descr'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function pricing_fields() {

        $class_name = "PricingField";

        $this->view_data['breadcrumb'] = $this->lang->line('application_pricing_fields');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_pricing_fields');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                             $this->lang->line('application_power_bottom'),
                                             $this->lang->line('application_power_top'),
                                             $this->lang->line('application_distance_bottom'),
                                             $this->lang->line('application_distance_top'),
                                             $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'power_bottom', 'power_top', 'distance_bottom', 'distance_top'];
        
        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_field');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function pricing_schema_fields() {

        $class_name = "PricingSchemaField";

        $this->view_data['breadcrumb'] = $this->lang->line('application_pricing_schemas');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_pricing_schema_fields');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_pricing_schema'),
                                            $this->lang->line('application_pricing_field'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','pricing_schema','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'field_id'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema_fields');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function countries() {

        $class_name = "Country";

        $this->view_data['breadcrumb'] = $this->lang->line('application_countries');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_countries');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_name'),
                                            $this->lang->line('application_iso_code'),
                                            $this->lang->line('application_status'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'iso_code','status'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema_fields');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function regions() {

        $class_name = "Region";

        $this->view_data['breadcrumb'] = $this->lang->line('application_regions');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_regions');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_name'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema_fields');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function cities($state_abbr = false) {

        $class_name = "City";

        $this->view_data['breadcrumb'] = $this->lang->line('application_cities');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = false;
        $this->view_data['show_edit_button'] =$this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_cities');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all',['conditions'=> ["state = ?", $state_abbr]]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_name'),
                                            $this->lang->line('application_state'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'state'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema_fields');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function states() {

        $class_name = "State";

        $this->view_data['breadcrumb'] = $this->lang->line('application_states');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_states');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_name'),
                                            $this->lang->line('application_letter'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'letter'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_pricing_schema_fields');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function card_interest() {

        $class_name = "Interest";

        $this->view_data['breadcrumb'] = $this->lang->line('application_card_interest');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = false; //$this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_card_interest');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_value'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'value'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_card_interest');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function proformas() {

        $class_name = "PvProforma";

        $this->view_data['breadcrumb'] = $this->lang->line('application_proformas');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_proformas');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
                                            $this->lang->line('application_name'),
                                            $this->lang->line('application_modules_manufacturer'),
                                            $this->lang->line('application_inverter_manufacturer'),
                                            $this->lang->line('application_structure_type'),
                                            $this->lang->line('application_insurance'),
                                            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self', 'module_manufacturer', 'inverter_manufacturer', 'structure_type', 'self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'name', 'name', 'name', 'insurance'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_proforma');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    //wildcard_listing
    public function pv_items() {

        $class_name = "PvItem";

        $this->view_data['breadcrumb'] = $this->lang->line('application_items');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_items');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),
            $this->lang->line('application_name'),
            $this->lang->line('application_description'),
            $this->lang->line('application_action')];

        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'description'];

        $objects = $class_name::find('all');
        $this->view_data['objects'] = $objects;
        $this->content_view = 'parameterization/wildcard_listing';

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_item');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    /*
     * WILDCARD CRUDs
     *
     * CRUD for simple master data tables, having only id, name and deleted columns (only logical deletion)
     * How-to: duplicate wildcard_listing method, set master data class, view, table, wildcard modal behavior elements
     * No need to duplicate update, create and delete methods
     *
     */

    //wildcard_form used for ONE FIELD "NAME" forms
    public function wildcard_update($class_name = false, $title = false, $modal_content_view = false, $redirect = false, $object_id = false){

        if ($_POST) {

            //post values
            $redirect = $_POST['redirect'];
            $class_name = $_POST['class_name'];
            $object = $class_name::find($_POST['id']);

            //unset unwanted values
            unset($_POST['class_name']);
            unset($_POST['redirect']);

            //update
            $object->update_attributes($_POST);

            //output
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_success'));

            //redirect
            redirect('parameterization/'.$redirect);
        } else {

            //object instance
            $object = $class_name::find($object_id);

            //set view propeties
            $this->view_data['object'] = $object;
            $this->theme_view = 'modal_nojs';
            $this->view_data['class_name'] = $class_name;

            //pass the name of properties not to draw
            $this->view_data['object_properties_not_draw'] = ['id', 'deleted', 'created_at', 'updated_at'];

            $this->view_data['title'] = $title;
            $this->view_data['redirect'] = $redirect;
            $this->view_data['form_action'] = 'parameterization/wildcard_update/'.$object->id;
            $this->content_view = 'parameterization/'.$modal_content_view;
        }
    }

    //wildcard_form used for ONE FIELD "NAME" forms
    public function wildcard_create($class_name = false, $title = false, $modal_content_view = false, $redirect = false){

        if ($_POST) {

            //post values
            $redirect = $_POST['redirect'];
            $class_name = $_POST['class_name'];

            //unset unwanted values
            unset($_POST['class_name']);
            unset($_POST['redirect']);

            $where = '';

            //set all received fields in a filter to prevent duplicate registries
            foreach ($_POST as $key => $value){
                if ($value != null){
                    $where.= " AND $key = '$value'";
                }
            }

            $options = ['conditions' => ["1 = 1 $where"]];

            $object_exists = $class_name::find($options);

            if (empty($object_exists)) {
                $object = $class_name::create($_POST);
                if (!$object) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_exists'));
            }

            //redirect
            redirect('parameterization/'.$redirect);
        } else {

            //set view propeties
            $this->theme_view = 'modal_nojs';

            $this->view_data['title'] = $title;
            $this->view_data['class_name'] = $class_name;
            $this->view_data['redirect'] = $redirect;
            $this->view_data['form_action'] = 'parameterization/wildcard_create';
            $this->content_view = 'parameterization/'.$modal_content_view;
        }
    }

    //wildcard_delete used for ONE FIELD "NAME" forms
    //logical deletion
    public function wildcard_delete($class_name = false, $object_id = false){

        //object instance
        $object = $class_name::find($object_id);
        $object->deleted = 1;
        $object->save();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));
    }

}
