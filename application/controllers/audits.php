<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Audits extends MY_Controller{

    public $do_not_render = ['PwReset', 'Setting', 'CompanyAppointment'];

    public function __construct(){

        parent::__construct();
        $access = false;
        $link = '/' . $this->uri->uri_string();

        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'audits') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            $cookie = [
                   'name' => 'saas_link',
                   'value' => $link,
                   'expire' => '500',
               ];

            $this->input->set_cookie($cookie);
            redirect('login');
        }

        $this->view_data['submenu'] = [
                        $this->lang->line('application_inserts') => 'audits/filter/insert',
                        $this->lang->line('application_updates') => 'audits/filter/update',
                        ];
    }

    public function index(){
        $this->view_data['registries'] = $registries =  Audit::all(['conditions' => ['1 = ? ORDER BY created_at DESC', 1]]);

        $related_objects = array();

        foreach ($registries as $registry){

            if (!in_array($registry->subject, $this->do_not_render)) {

                try{
                    $model = $registry->subject;
                    $related_object = $model::find($registry->pk);
                    array_push($related_objects, $related_object);
                }catch(Exception $e){
                    print_r($e);
                }


            }else{
                array_push($related_objects, $registry);
            }
        }

        $this->view_data['do_not_render'] = $this->do_not_render;
        $this->view_data['related_objects'] = (array) $related_objects;

        $this->content_view = 'audits/all';
    }

    public function filter($condition) {
        $this->view_data['auditFilter'] = $this->lang->line('application_all');
        switch ($condition) {
            case 'insert':
                $option = 'type = "INSERT"';
                $this->view_data['auditFilter'] = $this->lang->line('application_inserts');
                break;
            case 'update':
                $option = 'type = "UPDATE"';
                $this->view_data['auditFilter'] = $this->lang->line('application_updates');
                break;
        }
        $options = ['conditions' => [$option]];

        $this->view_data['registries'] = Audit::find('all', $options);
        $this->content_view = 'audits/all';
    }

    public function view_registry($id = false){

        $this->view_data['registry'] = $registry = Audit::find($id);

        $class_name = $registry->subject;
        $this->view_data['object'] = $object = $class_name::find($registry->pk);

        $this->content_view = 'audits/view';
    }

    public function relation_record($model = false, $id = false){

        $this->view_data['object'] = $object = $model::find($id);
        $this->theme_view = 'modal';
        $this->view_data['title'] = 'Registro <span style="text-transform: none;">'.$model.'</span>';
        $this->content_view = 'audits/_related';
    }


}
