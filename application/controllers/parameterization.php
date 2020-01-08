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
            $this->lang->line('application_modules') => 'parameterization/modules',
            $this->lang->line('application_inverters') => 'parameterization/inverters',
            'devider2' => 'devider',
            $this->lang->line('application_energy_dealers') => 'parameterization/dealers',
            $this->lang->line('application_activities') => 'parameterization/activities',
            $this->lang->line('application_tariffs') => 'parameterization/tariffs',
        ];

        $this->view_data['iconlist'] = [
            'parameterization/departments' => 'dripicons-network-1',
            'parameterization/modules' => 'dripicons-view-thumb',
            'parameterization/inverters' => 'dripicons-pulse',
            'parameterization/dealers' => 'dripicons-lightbulb',
            'parameterization/activities' => 'dripicons-store',
            'parameterization/tariffs' => 'dripicons-to-do',
        ];

        $this->config->load('defaults');
    }

    public function index(){
        $this->view_data['breadcrumb'] = $this->lang->line('application_parameterization');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';

        $this->view_data['departments'] = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->content_view = 'parameterization/departments';

        $this->load->helper('curl');
    }

    public function departments(){
        $this->view_data['breadcrumb'] = $this->lang->line('application_departments');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';

        $options = ['conditions' => ['status != ?', 'deleted']];
        $departments = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['departments'] = $departments;
        $this->content_view = 'parameterization/departments';
    }

    public function department_update($department = false){
        $department = Department::find($department);

        if ($_POST) {

            $department->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_department_success'));
            redirect('parameterization/departments');
        } else {
            $this->view_data['department'] = $department;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_department');
            $this->view_data['form_action'] = 'parameterization/department_update/' . $department->id;
            $this->content_view = 'parameterization/_departmentform';
        }
    }

    public function department_create(){
        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $department_exists = Department::find($options);
            if (empty($department_exists)) {
                $department = Department::create($_POST);
                if (!$department) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_department_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_department_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_department_exists'));
            }
            redirect('parameterization/departments');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_department');
            $this->view_data['form_action'] = 'parameterization/department_create/';
            $this->content_view = 'parameterization/_departmentform';
        }
    }

    public function department_delete($department = false){

        if ($this->department->id != $department) {
            $options = ['conditions' => ['id = ?', $department]];
            $department = Department::find($options);
            $department->status = 'deleted';
            $department->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_department_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_department_error'));
        }
        redirect('parameterization/departments');
    }

    public function modules(){
        $this->view_data['breadcrumb'] = $this->lang->line('application_modules');
        $this->view_data['breadcrumb_id'] = 'parameterization/modules';

        $modules = ModuleManufacturer::find('all');
        $this->view_data['modules'] = $modules;
        $this->content_view = 'parameterization/modules';
    }

    public function module_update($module = false){
        $module = ModuleManufacturer::find($module);

        if ($_POST) {

            $module->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_module_success'));
            redirect('parameterization/modules');
        } else {
            $this->view_data['module'] = $module;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_module');
            $this->view_data['form_action'] = 'parameterization/module_update/' . $module->id;
            $this->content_view = 'parameterization/_moduleform';
        }
    }

    public function module_create(){
        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $module_exists = ModuleManufacturer::find($options);
            if (empty($module_exists)) {
                $module = ModuleManufacturer::create($_POST);
                if (!$module) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_module_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_module_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_module_exists'));
            }
            redirect('parameterization/modules');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_module');
            $this->view_data['form_action'] = 'parameterization/module_create/';
            $this->content_view = 'parameterization/_moduleform';
        }
    }

    public function module_delete($module_id = false)
    {
        $module = ModuleManufacturer::find($module_id);
        $module->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_module_success'));

        redirect('parameterization/modules');
    }

    public function inverters() {
        $this->view_data['breadcrumb'] = $this->lang->line('application_inverters');
        $this->view_data['breadcrumb_id'] = 'parameterization/inverters';

        $inverters = InverterManufacturer::find('all');
        $this->view_data['inverters'] = $inverters;
        $this->content_view = 'parameterization/inverters';
    }

    public function inverter_update($inverter = false){
        $inverter = InverterManufacturer::find($inverter);

        if ($_POST) {

            $inverter->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_inverter_success'));
            redirect('parameterization/inverters');
        } else {
            $this->view_data['inverter'] = $inverter;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_inverter');
            $this->view_data['form_action'] = 'parameterization/inverter_update/' . $inverter->id;
            $this->content_view = 'parameterization/_inverterform';
        }
    }

    public function inverter_create(){
        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $inverter_exists = InverterManufacturer::find($options);
            if (empty($inverter_exists)) {
                $inverter = InverterManufacturer::create($_POST);
                if (!$inverter) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_inverter_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_inverter_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_inverter_exists'));
            }
            redirect('parameterization/inverters');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_inverter');
            $this->view_data['form_action'] = 'parameterization/inverter_create/';
            $this->content_view = 'parameterization/_inverterform';
        }
    }

    public function inverter_delete($inverter_id = false){

        $inverter = InverterManufacturer::find($inverter_id);
        $inverter->delete();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_inverter_success'));

        redirect('parameterization/inverters');
    }

    public function dealers() {
        $this->view_data['breadcrumb'] = $this->lang->line('application_dealers');
        $this->view_data['breadcrumb_id'] = 'parameterization/dealers';

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
        $this->view_data['breadcrumb_id'] = 'parameterization/activities';
        $this->view_data['table_title'] = $this->lang->line('application_activities');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';

        //table elements
        $this->view_data['collection_objects'] = Activity::find('all', ["conditions"=>['deleted = 0']]);
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
        $this->view_data['breadcrumb_id'] = 'parameterization/tariffs';
        $this->view_data['table_title'] = $this->lang->line('application_tariffs');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'parameterization/wildcard_listing';

        //table elements
        $this->view_data['collection_objects'] = DealerActivityTariff::find('all', ['include'=>['energy_dealer','activity']]);
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
            $this->theme_view = 'modal';
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
            $this->theme_view = 'modal';

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
