<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parameterization extends MY_Controller
{
    public function __construct()
    {
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
            $this->lang->line('application_areas') => 'parameterization/areas',
            $this->lang->line('application_modules') => 'parameterization/modules',
            $this->lang->line('application_inverters') => 'parameterization/inverters',
        ];

        $this->view_data['iconlist'] = [
            'parameterization/departments' => 'dripicons-network-1',
            'parameterization/areas' => 'dripicons-network-3',
            'parameterization/modules' => 'dripicons-view-thumb',
            'parameterization/inverters' => 'dripicons-pulse',
        ];

        $this->config->load('defaults');
    }

    public function index()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_parameterization');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';

        $this->view_data['departments'] = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->content_view = 'parameterization/departments';

        $this->load->helper('curl');
    }

    public function departments()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_departments');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';

        $options = ['conditions' => ['status != ?', 'deleted']];
        $departments = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['departments'] = $departments;
        $this->content_view = 'parameterization/departments';
    }

    public function department_update($department = false)
    {
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

    public function department_create()
    {
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

    public function department_delete($department = false)
    {

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

    public function areas()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/areas';

        $options = array('conditions' => 'status != \'deleted\'', 'include' => array('department'));
        $areas = DepartmentHasArea::all($options);
        $this->view_data['areas'] = $areas;
        $this->content_view = 'parameterization/areas';
    }

    public function area_update($area = false)
    {
        $area = DepartmentHasArea::find($area);

        if ($_POST) {

            $area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_area_success'));
            redirect('parameterization/areas');
        } else {
            $this->view_data['area'] = $area;
            $this->theme_view = 'modal';

            $options = ['conditions' => ['status != ?', 'deleted']];
            $departments = Department::all($options);
            $this->view_data['bd_departments'] = $departments;


            $this->view_data['title'] = $this->lang->line('application_edit_area');
            $this->view_data['form_action'] = 'parameterization/area_update/' . $area->id;
            $this->content_view = 'parameterization/_areaform';
        }
    }

    public function area_create()
    {
        if ($_POST) {

            $area = DepartmentHasArea::create($_POST);
            if (!$area) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_area_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_area_success'));
            }
            redirect('parameterization/areas');
        } else {
            $this->theme_view = 'modal';

            $options = ['conditions' => ['status != ?', 'deleted']];
            $departments = Department::all($options);
            $this->view_data['bd_departments'] = $departments;

            $this->view_data['title'] = $this->lang->line('application_add_area');
            $this->view_data['form_action'] = 'parameterization/area_create/';
            $this->content_view = 'parameterization/_areaform';
        }
    }

    public function area_delete($area = false)
    {

        if ($this->area->id != $area) {
            $options = ['conditions' => ['id = ?', $area]];
            $area = DepartmentHasArea::find($options);
            $area->status = 'deleted';
            $area->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_area_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_area_error'));
        }
        redirect('parameterization/areas');
    }

    public function modules()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_modules');
        $this->view_data['breadcrumb_id'] = 'parameterization/modules';

        $modules = ModuleManufacturer::find('all');
        $this->view_data['modules'] = $modules;
        $this->content_view = 'parameterization/modules';
    }

    public function module_update($module = false)
    {
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

    public function module_create()
    {
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

    public function inverters()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_inverters');
        $this->view_data['breadcrumb_id'] = 'parameterization/inverters';

        $inverters = inverterManufacturer::find('all');
        $this->view_data['inverters'] = $inverters;
        $this->content_view = 'parameterization/inverters';
    }

    public function inverter_update($inverter = false)
    {
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

    public function inverter_create()
    {
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


}
