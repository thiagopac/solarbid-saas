<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Approvals extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $access = false;
        unset($_POST['DataTables_Table_0_length']);
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'approvals') {
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
            $this->lang->line('application_feedbacks') => 'approvals/feedbacks',
        ];

        $this->view_data['iconlist'] = [
            'approvals/feedbacks' => 'dripicons-star',
        ];

        $this->config->load('defaults');
    }

    public function index(){
        //master data class
        $class_name = 'RatingPost';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_feedbacks');
        $this->view_data['breadcrumb_id'] = 'feedbacks';
        $this->view_data['table_title'] = $this->lang->line('application_feedbacks');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'approvals/wildcard_listing';
        $this->view_data['show_add_button'] = 0;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ["conditions"=>['1 = 1'], 'include'=>['company']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_company'),$this->lang->line('application_firstname'), $this->lang->line('application_lastname'), $this->lang->line('application_comment'), $this->lang->line('application_approved')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','company', 'self', 'self', 'self', 'self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'firstname', 'lastname', 'comment', 'approved'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_feedback');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'approvals/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'approvals/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'approvals/wildcard_delete/'.$class_name;

    }

    public function feedbacks() {

        //master data class
        $class_name = 'RatingPost';

        //view elements
        $this->view_data['breadcrumb'] = $this->lang->line('application_feedbacks');
        $this->view_data['breadcrumb_id'] = __FUNCTION__;
        $this->view_data['table_title'] = $this->lang->line('application_feedbacks');
        $this->view_data['add_button_title'] = $this->lang->line('application_add_new');
        $this->content_view = 'approvals/wildcard_listing';
        $this->view_data['show_add_button'] = 0;
        $this->view_data['show_edit_button'] = $this->user->admin == 1;
        $this->view_data['show_delete_button'] = false;

        //table elements
        $this->view_data['collection_objects'] = $class_name::find('all', ["conditions"=>['1 = 1'], 'include'=>['company']]);
        $this->view_data['column_titles'] = [$this->lang->line('application_id'),$this->lang->line('application_company'),$this->lang->line('application_firstname'), $this->lang->line('application_lastname'), $this->lang->line('application_comment'), $this->lang->line('application_approved')];
        //to print properties of nested objects, specify the model name or use 'self' for current collection object class
        $this->view_data['object_classes_draw'] = ['self','company', 'self', 'self', 'self', 'self'];
        //pass the name of properties to draw. Follow the order of the object_classes_draw
        $this->view_data['object_properties_draw'] = ['id', 'name', 'firstname', 'lastname', 'comment', 'approved'];

        //wildcard modal behavior elements
        $modal_title = $this->lang->line('application_feedback');
        $modal_content_view = '_wildcardform';
        $redirect = __FUNCTION__;

        $this->view_data['update_method'] = 'approvals/wildcard_update/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['create_method'] = 'approvals/wildcard_create/'.$class_name.'/'.$modal_title.'/'.$modal_content_view.'/'.$redirect;
        $this->view_data['delete_method'] = 'approvals/wildcard_delete/'.$class_name;

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
            redirect('approvals/'.$redirect);
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
            $this->view_data['form_action'] = 'approvals/wildcard_update/'.$object->id;
            $this->content_view = 'approvals/'.$modal_content_view;
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
                    $where.= " AND $key = $value";
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
            redirect('approvals/'.$redirect);
        } else {

            //set view propeties
            $this->theme_view = 'modal_nojs';

            $this->view_data['title'] = $title;
            $this->view_data['class_name'] = $class_name;
            $this->view_data['redirect'] = $redirect;
            $this->view_data['form_action'] = 'approvals/wildcard_create';
            $this->content_view = 'approvals/'.$modal_content_view;
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
