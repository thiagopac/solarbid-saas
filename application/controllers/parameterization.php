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
            $this->lang->line('application_energy_dealers') => 'parameterization/dealers',
            $this->lang->line('application_activities') => 'parameterization/activities',
            $this->lang->line('application_tariffs') => 'parameterization/tariffs',
            'devider3' => 'devider',
            $this->lang->line('application_structure_types') => 'parameterization/structure_types',
            'devider4' => 'devider',
            $this->lang->line('application_faq_customers') => 'parameterization/faq_customer',
        ];

        $this->view_data['iconlist'] = [
            'parameterization/departments' => 'dripicons-network-1',
            'parameterization/pv_providers' => 'dripicons-stack',
            'parameterization/modules' => 'dripicons-view-thumb',
            'parameterization/inverters' => 'dripicons-pulse',
            'parameterization/dealers' => 'dripicons-lightbulb',
            'parameterization/activities' => 'dripicons-store',
            'parameterization/tariffs' => 'dripicons-to-do',
            'parameterization/structure_types' => 'dripicons-vibrate',
            'parameterization/faq_customer' => 'dripicons-question',
        ];

        $this->config->load('defaults');
    }

    public function index(){
        $this->view_data['breadcrumb'] = $this->lang->line('application_parameterization');
        $this->view_data['breadcrumb_id'] = 'departments';

        $this->view_data['departments'] = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->content_view = 'parameterization/departments';

        $this->load->helper('curl');
    }

    public function departments(){

        //master data class
        $class_name = 'Department';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_departments');
        $this->view_data['breadcrumb_id'] = 'departments';
        $this->view_data['table_title'] = $this->lang->line('application_departments');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_department');
        $content_view = '_wildcardform';
        $redirect = 'departments';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function modules(){

        //master data class
        $class_name = 'ModuleManufacturer';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_modules');
        $this->view_data['breadcrumb_id'] = 'modules';
        $this->view_data['table_title'] = $this->lang->line('application_modules');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_module');
        $content_view = '_wildcardform';
        $redirect = 'modules';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function inverters() {

        //master data class
        $class_name = 'InverterManufacturer';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_inverters');
        $this->view_data['breadcrumb_id'] = 'inverters';
        $this->view_data['table_title'] = $this->lang->line('application_inverters');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_inverter');
        $content_view = '_wildcardform';
        $redirect = 'inverters';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function dealers() {
        $this->view_data['breadcrumb'] = $this->lang->line('application_dealers');
        $this->view_data['breadcrumb_id'] = 'dealers';

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
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

    //wildcard_listing
    public function activities() {

        //master data class
        $class_name = 'Activity';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_activities');
        $this->view_data['breadcrumb_id'] = 'activities';
        $this->view_data['table_title'] = $this->lang->line('application_activities');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ["conditions"=>['deleted = 0']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_activity');
        $content_view = '_wildcardform';
        $redirect = 'activities';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;

    }

    //wildcard_listing
    public function tariffs() {

        //master data class
        $class_name = 'DealerActivityTariff';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_tariffs');
        $this->view_data['breadcrumb_id'] = 'tariffs';
        $this->view_data['table_title'] = $this->lang->line('application_tariffs');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ['include'=>['energy_dealer','activity']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_energy_dealer'),$this->lang->line('application_activity'),$this->lang->line('application_value'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self', 'energy_dealer','activity','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name','name','value'];

        //behavior elements
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
        $this->view_data['breadcrumb_id'] = 'pv_providers';
        $this->view_data['table_title'] = $this->lang->line('application_pv_providers');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_pv_provider');
        $content_view = '_wildcardform';
        $redirect = 'pv_providers';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;

    }

    public function structure_types() {

        //master data class
        $class_name = 'StructureType';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_structure_types');
        $this->view_data['breadcrumb_id'] = 'structure_types';
        $this->view_data['table_title'] = $this->lang->line('application_structure_types');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';
        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_name'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'name'];

        //behavior elements
        $modal_title = $this->lang->line('application_structure_type');
        $content_view = '_wildcardform';
        $redirect = 'structure_types';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;
    }

    public function faq_customer() {

        $class_name = "FaqCustomer";

        $this->view_data['breadcrumb'] = $this->lang->line('application_faq_customers');
        $this->view_data['breadcrumb_id'] = 'faq_customer';

        $this->view_data['show_add_button'] = $this->user->admin == 1;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;;
        $this->view_data['show_delete_button'] = false;

        $this->view_data['table_title'] = $this->lang->line('application_faq_customers');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all');
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_question'),$this->lang->line('application_answer'),$this->lang->line('application_action')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','self','self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properies_draw'] = ['id', 'question', 'answer'];

        $modal_title = $this->lang->line('application_question');
        $content_view = '_faqcustomerform';
        $redirect = 'faq_customer';

        $this->view_data['update_method'] = 'parameterization/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'parameterization/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'parameterization/wildcard_delete/'.$class_name;

        $objects = FaqCustomer::find('all');
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
            $this->content_view = 'parameterization/_faqcustomerform';
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
            $this->content_view = 'parameterization/_faqcustomerform';
        }
    }

    public function faq_customer_delete($dealer_id = false){

        $dealer = EnergyDealer::find($dealer_id);
        $dealer->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));

        redirect('parameterization/dealers');
    }

    /*
     * WILDCARD CRUDs
     *
     * CRUD for simple master data tables, having only id, name and deleted columns (only logical deletion)
     * How-to: duplicate wildcard_listing method, set master data class, view, table, behavior elements
     * No need to duplicate update, create and delete methods
     *
     */

    //wildcard_form used for ONE FIELD "NAME" forms
    public function wildcard_update($class_name = false, $title = false, $content_view = false, $redirect = false, $object_id = false){

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

            $this->view_data['title'] = $title;
            $this->view_data['redirect'] = $redirect;
            $this->view_data['form_action'] = 'parameterization/wildcard_update/'.$object->id;
            $this->content_view = 'parameterization/'.$content_view;
        }
    }

    //wildcard_form used for ONE FIELD "NAME" forms
    public function wildcard_create($class_name = false, $title = false, $content_view = false, $redirect = false){

        if ($_POST) {

            //post values
            $redirect = $_POST['redirect'];
            $class_name = $_POST['class_name'];

            //unset unwanted values
            unset($_POST['class_name']);
            unset($_POST['redirect']);

            $options = ['conditions' => ['name = ?', $_POST['name']]];
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
            $this->content_view = 'parameterization/'.$content_view;
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
