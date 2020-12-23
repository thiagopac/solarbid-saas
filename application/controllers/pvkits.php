<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PvKits extends MY_Controller {

    public $login_url;
    public $custom_orders_url;
    public $custom_orders_list_params;
    private $login_email;
    private $login_password;

    public function __construct() {

        parent::__construct();


        { //bot kit config
            $this->login_url = "https://api-integrator.appsolar.com.br/api/login";
            $this->custom_orders_url = "https://api-integrator.appsolar.com.br/api/custom-orders";
            $this->custom_orders_list_params = "?descending=false&page=1&rowsPerPage=0&rowsNumber=23&currentStatus=%7B%22name%22:null%7D&itemsPerPage=0";

            $this->login_email = "thiago@solarbid.com.br";
            $this->login_password = "Tpac@123!@#";
        }

        $access = false;
        $link = '/' . $this->uri->uri_string();

        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'pvkits') {
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

        $submenu = array();
        $structure_types = StructureType::all();

        array_push($submenu, [ $this->lang->line('application_all') => 'pvkits/']);

        foreach ($structure_types as $structure_type){
            array_push($submenu, [$structure_type->name => 'pvkits/filter/'.$structure_type->id]);
        }

        $this->view_data['submenu'] = $submenu;

    }

    public function index() {

        $options = ['conditions' => ['deleted != ?', '1'], 'order' => 'id DESC', 'include' => ['structure_type']];
        $this->view_data['pv_kits'] = PvKit::find('all', $options);
        $this->view_data['all_filter'] = $this->lang->line('application_all');

        $this->content_view = 'pvkits/all';
    }

    public function view_all() {

        $submenu = array();
        $structure_types = StructureType::all();

        foreach ($structure_types as $structure_type){
            array_push($submenu, [$structure_type->name => 'pvkits/template_filter/'.$structure_type->id]);
        }

        $this->view_data['submenu'] = $submenu;

        $options = ['conditions' => ['deleted != ?', '1'], 'order' => 'id DESC', 'include' => ['structure_type']];
        $this->view_data['pv_kits'] = PvKit::find('all', $options);
        $this->view_data['template_filter'] = $this->lang->line('application_all');

        $this->content_view = 'pvkits/view_all';
    }

    public function filter($condition) {

        $structure_type = StructureType::find($condition);

        $this->view_data['all_filter'] = $structure_type->name;

        $options = ['conditions' => ['deleted != ? AND structure_type_id = ?', 1, $condition], 'order' => 'id DESC', 'include' => ['structure_type']];
        $this->view_data['pv_kits'] = PvKit::find('all', $options);
        $this->content_view = 'pvkits/all';
    }

    public function bulk($action) {

        if ($_POST) {


            if (empty($_POST['list'])) {
                redirect('pvkits');
            }

            $list = explode(',', $_POST['list']);

            switch ($action) {
                case 'inactivate':
                    $attr = ['inactive' => 1];
                    break;

                case 'activate':
                    $attr = ['inactive' => 0];
                    break;

                case 'start_at_today':
                    $attr = ['start_at' => date("Y-m-d H:i:s")];
                    break;

                case 'start_at_blank':
                    $attr = ['start_at' => ''];
                    break;

                case 'stop_at_today':
                    $attr = ['stop_at' => date("Y-m-d H:i:s")];
                    break;

                case 'stop_at_blank':
                    $attr = ['stop_at' => ''];
                    break;

                case 'delete':
                    $attr = ['deleted' => 1, 'inactive' => 1];
                    break;

                default:
                    redirect('pvkits');
                    break;
            }

            foreach ($list as $value) {
                $pvkit = PvKit::find_by_id($value);
                $pvkit->update_attributes($attr);

                if (!$pvkit) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_bulk_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_bulk_success'));
                }
            }
            redirect('pvkits');

        }else{
            redirect('pvkits');
        }
    }

    public function create() {

        $core_settings = Setting::first();

        if ($_POST) {

            //price come as 12.345,67 and need back to database type 12345.67
            $_POST['price'] = str_replace('.', '', $_POST['price']);
            $_POST['price'] = str_replace(',', '.', $_POST['price']);

            if ($_POST['userfile'] != null){

                //begin image upload
                $config['upload_path'] = './files/media/pvkits/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';

                $full_path = $core_settings->domain."files/media/pvkits/";

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors('', ' ');
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect('pvkits');
                } else {
                    $data = array('upload_data' => $this->upload->data());

                    $_POST['image'] = $full_path.$data['upload_data']['file_name'];

                    //check image processor extension
                    if (extension_loaded('gd2')) {
                        $lib = 'gd2';
                    } else {
                        $lib = 'gd';
                    }

                    $config['image_library']  = $lib;
                    $config['source_image']   = './files/media/pvkits/'.$_POST['savename'];
                    $config['maintain_ratio'] = true;
                    $config['max_width']          = 2048;
                    $config['max_height']         = 2048;
                    $config['master_dim']     = "height";
                    $config['quality']        = "100%";

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }

                $_POST = array_map('htmlspecialchars', $_POST);
                //end image upload
            }

            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);

            $pv_kit = PvKit::create($_POST);

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_created_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_created_pv_kit_success'));
            }
            redirect('pvkits');
        } else {

            $this->view_data['kit_providers'] = PvProvider::all();
            $this->view_data['all_kits'] = PvKit::find('all', ['conditions' => ['deleted != 1']]);
            $this->view_data['inverters'] = InverterManufacturer::all();
            $this->view_data['modules'] = ModuleManufacturer::all();
            $this->view_data['structure_types'] = StructureType::all();
            $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_pv_kit');
            $this->view_data['form_action'] = 'pvkits/create/';

            $this->content_view = 'pvkits/_pvkit';
        }
    }

    public function update($pv_kit_id = false) {

        $core_settings = Setting::first();

        if ($_POST) {


            $pv_kit = PvKit::find($_POST['id']);

            //price come as 12.345,67 and need back to database type 12345.67
            $_POST['price'] = str_replace('.', '', $_POST['price']);
            $_POST['price'] = str_replace(',', '.', $_POST['price']);


            //begin image upload
            $config['upload_path'] = './files/media/pvkits/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $full_path = $core_settings->domain."/files/media/pvkits/";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
//                $this->session->set_flashdata('message', 'error:'.$error);
//                redirect('pvkits');
            } else {
                $data = array('upload_data' => $this->upload->data());

                $_POST['image'] = $full_path.$data['upload_data']['file_name'];

                //check image processor extension
                if (extension_loaded('gd2')) {
                    $lib = 'gd2';
                } else {
                    $lib = 'gd';
                }

                $config['image_library']  = $lib;
                $config['source_image']   = './files/media/pvkits/'.$_POST['savename'];
                $config['maintain_ratio'] = true;
                $config['max_width']          = 2048;
                $config['max_height']         = 2048;
                $config['master_dim']     = "height";
                $config['quality']        = "100%";

                $this->load->library('image_lib');
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }

//            $_POST = array_map('htmlspecialchars', $_POST);
            //end image upload

            if ($_POST['image']){
                $_POST['image'] = $_POST['image'];
            }else{
                unset($_POST['image']);
            }


            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);

//            var_dump($pv_kit);
//            exit;

            $pv_kit->update_attributes($_POST);

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pv_kit_success'));
            }
            redirect('pvkits');
        } else {
            $pv_kit = PvKit::find($pv_kit_id);
            $this->view_data['all_kits'] = PvKit::find('all', ['conditions' => ['deleted != 1']]);
            $this->view_data['pv_kit'] = $pv_kit;
            $this->view_data['kit_providers'] = PvProvider::all();
            $this->view_data['inverters'] = InverterManufacturer::all();
            $this->view_data['modules'] = ModuleManufacturer::all();
            $this->view_data['structure_types'] = StructureType::all();
            $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_update_pv_kit');
            $this->view_data['form_action'] = 'pvkits/update/';

            $this->content_view = 'pvkits/_pvkit';
        }
    }

    public function delete($pv_kit_id = false) {

        $pv_kit = PvKit::find($pv_kit_id);
        $pv_kit->deleted = 1;
        $pv_kit->save();

        if (!$pv_kit) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_deleted_pv_kit_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_deleted_pv_kit_success'));
        }
        redirect('pvkits');
    }

    public function duplicate($pv_kit_id = false) {

        $pv_kit = PvKit::find($pv_kit_id);

//        var_dump($pv_kit);exit;

        $clone = new PvKit();

        $pv_kit_attr = (array) $pv_kit->attributes();
        unset($pv_kit_attr['id']); //do not copy id

        $clone->create($pv_kit_attr);

        if (!$clone) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_duplicated_pv_kit_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_duplicated_pv_kit_success'));
        }
        redirect('pvkits');
    }

    function preview_photo($pv_kit_id) {

        $pv_kit = PvKit::find($pv_kit_id);

        $this->theme_view = 'modal';
        $this->view_data['kit'] = $pv_kit;
        $this->content_view = 'pvkits/_preview';
        $this->view_data['title'] = $this->lang->line('application_preview_photo_media');
    }

    function freight($pv_kit_id) {

        if ($_POST) {

            // var_dump($_POST);

            unset($_POST['send']);

            $kit_id = $pv_kit_id;

            $this->load->dbforge();
            $this->db->query('USE `' . $this->db->database . '`;');

            foreach (array_keys($_POST) as $key){
                if ($_POST[$key] == null){
                    unset($_POST[$key]);
                }
            }

            foreach (array_keys($_POST) as $key){

                $field_id = explode("_", $key);
                $state_id = $field_id[0];
                $type_value = $field_id[1]."_value";
                $value = $_POST[$key];

                //value come as 12.345,67 and need back to database type 12345.67
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);

                $existing_freight = Freight::find('first', ['conditions' => ['pv_kit_id = ? AND state_id = ?', $pv_kit_id,$state_id]]);

                if ($existing_freight == null){
                    $new_freight = new Freight();
                    $new_freight->pv_kit_id = $kit_id;
                    $new_freight->state_id = $state_id;
                    $type_value == "capital_value" ? $new_freight->capital_value = $value : $new_freight->inland_value = $value;

                    $new_freight->save();

                }else{
                    $type_value == "capital_value" ? $existing_freight->capital_value = $value : $existing_freight->inland_value = $value;
                    $existing_freight->save();
                }

//                $sql = "REPLACE INTO freight (pv_kit_id, state_id, $type_value)
//                                     VALUES('$kit_id',
//                                            '$state_id',
//                                            '$value')";

//                $this->db->query($sql);
            }

            if (1 != 1) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_freight_updated_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_freight_updated_success'));
            }

            redirect('pvkits');

        }else{
            $pv_kit = PvKit::find($pv_kit_id);

            $this->view_data['states'] = State::find('all');
            $this->view_data['freights'] = Freight::find('all', ['conditions' => ['pv_kit_id = ?', $pv_kit_id]]);

            $this->theme_view = 'modal';
            $this->view_data['kit'] = $pv_kit;
            $this->content_view = 'pvkits/_freight';
            $this->view_data['title'] = $this->lang->line('application_freight')." [".$this->lang->line('application_pvkit')." ".$pv_kit_id."]";
            $this->view_data['form_action'] = 'pvkits/freight/'.$pv_kit_id;
        }

    }

////////////////////// BOT KIT

    function login() {
        $url = $this->login_url;
        $login_email = $this->login_email;
        $login_password = $this->login_password;

        $ch = curl_init($url);
        $header = array(
            "Accept: application/json",
            'Content-Type:application/json'
        );

        $payload = array(
            'email' => $login_email,
            'password' => $login_password
        );

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $resp = curl_exec($ch);
        curl_close($ch);

        if ($resp === FALSE) {
            throw new Exception("cURL call failed", "403");
        } else {
            return $resp;
        }
    }

    function get_custom_orders() {

        $url = $this->custom_orders_url.$this->custom_orders_list_params;

        $login_obj = json_decode($this->login());

        $ch = curl_init($url);
        $header = array(
            "Accept: application/json",
            'Content-Type:application/json',
            'x-access-token: Bearer '. $login_obj->access_token
        );

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $resp = curl_exec($ch);
        curl_close($ch);

        if ($resp === FALSE) {
            throw new Exception("cURL call failed", "403");
        } else {
            return $resp;
        }
    }

    function get_custom_order($external_id) {

        $url = $this->custom_orders_url.'/'.$external_id;

        $login_obj = json_decode($this->login());

        $ch = curl_init($url);
        $header = array(
            "Accept: application/json",
            'Content-Type:application/json',
            'x-access-token: Bearer '. $login_obj->access_token
        );

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $resp = curl_exec($ch);
        curl_close($ch);

        if ($resp === FALSE) {
            throw new Exception("cURL call failed", "403");
        } else {
            return $resp;
        }
    }

    public function get_edmond_kits() {

        $custom_orders_response = $this->get_custom_orders();
        $custom_orders_obj = json_decode($custom_orders_response);

        $all_kits = array();

        $external_ids = PvKit::all(['conditions' => ['external_id IS NOT NULL'], 'select'=> 'external_id']);

        $external_ids_str = array();
        foreach ($external_ids as $value){
            array_push($external_ids_str, $value->external_id);
        }

        foreach ($custom_orders_obj->data as $obj){
            $obj->imported = in_array($obj->_id, $external_ids_str);
            array_push($all_kits, $obj);

        }

        $this->view_data['all_kits'] = $all_kits;
        $this->content_view = 'pvkits/view_all_edmond';
    }

    public function update_edmond_kit($external_id = false) {

        $core_settings = Setting::first();

        if ($_POST) {

            //price come as 12.345,67 and need back to database type 12345.67
            $_POST['price'] = str_replace('.', '', $_POST['price']);
            $_POST['price'] = str_replace(',', '.', $_POST['price']);

            if ($_POST['userfile'] != null){

                //begin image upload
                $config['upload_path'] = './files/media/pvkits/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';

                $full_path = $core_settings->domain."/files/media/pvkits/";

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors('', ' ');
//                $this->session->set_flashdata('message', 'error:'.$error);
//                redirect('pvkits');
                } else {
                    $data = array('upload_data' => $this->upload->data());

                    $_POST['image'] = $full_path.$data['upload_data']['file_name'];

                    //check image processor extension
                    if (extension_loaded('gd2')) {
                        $lib = 'gd2';
                    } else {
                        $lib = 'gd';
                    }

                    $config['image_library']  = $lib;
                    $config['source_image']   = './files/media/pvkits/'.$_POST['savename'];
                    $config['maintain_ratio'] = true;
                    $config['max_width']          = 2048;
                    $config['max_height']         = 2048;
                    $config['master_dim']     = "height";
                    $config['quality']        = "100%";

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                }

//            $_POST = array_map('htmlspecialchars', $_POST);
                //end image upload

                if ($_POST['image']){
                    $_POST['image'] = $_POST['image'];
                }else{
                    unset($_POST['image']);
                }


                unset($_POST['send']);
                unset($_POST['userfile']);
                unset($_POST['files']);

            $pv_kit = PvKit::create($_POST);

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_created_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_created_pv_kit_success'));
            }
            redirect('pvkits');

        } else {

            $custom_order_response = $this->get_custom_order($external_id);
            $custom_order_obj = json_decode($custom_order_response);

//            $custom_order_obj = $custom_order_obj->data[0];

            //building properties to import
            $pv_kit = new PvKit();
            $pv_kit->kit_provider = 'EDMOND';
            $pv_kit->kit_power = $custom_order_obj->totalModulePower;

            $proforma_components = array();

            foreach ($custom_order_obj->kits[0]->components as $item){

                if ($item->vendorComponent->component->family == 'inverter'){
                    $pv_kit->pv_inverter = $item->vendorComponent->component->maker->name;
                    $pv_kit->desc_inverter = $item->quantity.' INVERSOR '.strtoupper($item->vendorComponent->component->maker->name).' '.$item->vendorComponent->component->partNumber;
                }

                if ($item->vendorComponent->component->family == 'module'){
                    $pv_kit->pv_module = $item->vendorComponent->component->maker->name;
                    $pv_kit->desc_module = $item->quantity.' MÓDULOS '.strtoupper($item->vendorComponent->component->maker->name).' '.$item->vendorComponent->component->techData->stc->pMax.'W';
                }

                $component_obj = new stdClass();
                $component_obj->qty = $item->quantity;
                $component_obj->name = $item->vendorComponent->component->name;
                array_push($proforma_components, $component_obj);
            }

            $pv_kit->structure_type_id = null;
            $pv_kit->country = 'Brasil';

            $pv_kit->external_id = $external_id;

            $pv_kit->price = $custom_order_obj->finalPrice;

            $pv_kit->insurance = 'Seguro Risco Engenharia. Seguro Responsabilidade. Seguro Total Protect 1 ano.';

            $pv_kit->proforma = json_encode($proforma_components);
            $pv_kit->inactive = 1;

            $this->view_data['pv_kit'] = $pv_kit;

            $this->view_data['all_kits'] = PvKit::find('all', ['conditions' => ['deleted != 1']]);

            $this->view_data['kit_providers'] = PvProvider::all();
            $this->view_data['inverters'] = InverterManufacturer::all();
            $this->view_data['modules'] = ModuleManufacturer::all();
            $this->view_data['structure_types'] = StructureType::all();
            $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_import_pv_kit');
            $this->view_data['form_action'] = 'pvkits/update_edmond_kit/';

            $this->content_view = 'pvkits/_pvkit_edmond';
        }
    }

}
