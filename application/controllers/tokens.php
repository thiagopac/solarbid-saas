<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require('mail.php');

class Tokens extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $access = false;
        $link = '/' . $this->uri->uri_string();

        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'tokens') {
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

    }

    public function index() {

        $this->content_view = 'tokens/all';
    }

    public function list_simulator() {

        $this->view_data['simulator_flows'] = $simulator_flows =  SimulatorFlow::find('all',['limit' => '300', 'order' => 'id DESC', 'select'=> 'id, code, city, state, type, name, dealer, monthly_average, activity, structure_type_id, pv_kit, integrator, integrator_approved, customer_approved, solarbid_approved, created_at', 'include' => ['energy_dealer', 'state', 'city', 'activity', 'structure_type']]);
        foreach ($simulator_flows as $simulator_flow){
            $simulator_flow->installation_local = InstallationLocal::find(['conditions' => ['flow_id = ?', $simulator_flow->code]]);
        }

        $this->content_view = 'tokens/simulator_all';
    }

    public function list_store() {

        $this->view_data['store_flows'] = $store_flows = StoreFlow::find('all',['limit' => '300', 'order' => 'id DESC']);
        foreach ($store_flows as $store_flow){
            $store_flow->installation_local = InstallationLocal::find(['conditions' => ['store_flow_id = ?', $store_flow->code]]);
        }

        $this->content_view = 'tokens/store_all';
    }

    public function find() {

        if ($_POST) {

//            var_dump($_POST);exit;

            $is_simulator_flow = SimulatorFlow::first(['conditions' => ['code = ?', $_POST['code']]]);
            $is_store_flow = StoreFlow::first(['conditions' => ['code = ?', $_POST['code']]]);

            if ($is_simulator_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_token')." ".$is_simulator_flow->code);
                redirect('tokens/view_simulator_token/'.$is_simulator_flow->code);
            }else if($is_store_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_token')." ".$is_store_flow->code);
                redirect('tokens/view_store_token/'.$is_store_flow->code);
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_find_token_error'));
                redirect('tokens');
            }

        }else{
            $this->theme_view = 'modal';
            $this->content_view = 'tokens/_find';
            $this->view_data['title'] = $this->lang->line('application_find_token');
        }
    }

    public function view_simulator_token($simulator_flow_code = false) {

        $options = ['conditions' => ['code = ?', $simulator_flow_code], 'include' => ['installation_local']];
        $flow = SimulatorFlow::find($options);
        $appointment_purchase = AppointmentPurchase::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $purchase = Purchase::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $company_appointment = CompanyAppointment::find(['conditions' => ['flow_id = ?', $simulator_flow_code], 'include' => ['appointment_time']]);
        $appointment_webhooks = Webhook::all(['conditions' => ['pedido_id = ?', $appointment_purchase->processor_id]]);
        $purchase_webhooks  = Webhook::all(['conditions' => ['pedido_id = ?', $purchase->processor_id]]);
        $referral_code = ReferralCode::first(['conditions' => ['code = ?', $flow->referral_code]]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;
        $this->view_data['appointment_purchase'] = $appointment_purchase;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;
        $this->view_data['pv_kit_revised'] = json_decode($flow->pv_kit_revised);
        $this->view_data['complements_revised'] = json_decode($flow->complements_revised);
        $this->view_data['integrator_revised'] = json_decode($flow->integrator_revised);
        $this->view_data['appointment_webhooks'] = $appointment_webhooks;
        $this->view_data['purchase_webhooks'] = $purchase_webhooks;
        $this->view_data['referral_code'] = $referral_code;

        $this->content_view = 'tokens/view_simulator_token';
    }

    public function view_store_token($store_flow_code = false) {

        $options = ['conditions' => ['code = ?', $store_flow_code]];
        $flow = StoreFlow::find($options);
        $appointment_purchase = AppointmentPurchase::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $purchase = Purchase::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $financing_request = FinancingRequest::first(['conditions' => ['store_flow_id = ?', $flow->code]]);
        $installation_local = InstallationLocal::first('first', ['conditions' => ['store_flow_id = ?', $flow->code]]);
        $company_appointment = CompanyAppointment::find(['conditions' => ['store_flow_id = ?', $store_flow_code], 'include' => ['appointment_time']]);
        $appointment_webhooks = Webhook::all(['conditions' => ['pedido_id = ?', $appointment_purchase->processor_id]]);
        $purchase_webhooks  = Webhook::all(['conditions' => ['pedido_id = ?', $purchase->processor_id]]);
        $referral_code = ReferralCode::first(['conditions' => ['code = ?', $flow->referral_code]]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;
        $this->view_data['appointment_purchase'] = $appointment_purchase;
        $this->view_data['purchase'] = $purchase;
        $this->view_data['financing_request'] = $financing_request;
        $this->view_data['installation_local'] = $installation_local;
        $this->view_data['pv_kit_revised'] = json_decode($flow->pv_kit_revised);
        $this->view_data['complements_revised'] = json_decode($flow->complements_revised);
        $this->view_data['integrator_revised'] = json_decode($flow->integrator_revised);
        $this->view_data['appointment_webhooks'] = $appointment_webhooks;
        $this->view_data['purchase_webhooks'] = $purchase_webhooks;
        $this->view_data['referral_code'] = $referral_code;

        $this->content_view = 'tokens/view_store_token';
    }

    public function analyze_simulator_token($simulator_flow_code = false) {

        $options = ['conditions' => ['code = ?', $simulator_flow_code], 'include' => ['installation_local']];
        $flow = SimulatorFlow::find($options);
        $company_appointment = CompanyAppointment::find(['conditions' => ['flow_id = ?', $simulator_flow_code], 'include' => ['appointment_time']]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;

        $installation_local = InstallationLocal::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $this->view_data['installation_local'] = $installation_local;

        $pv_kit_json = $flow->pv_kit_revised != null ? $flow->pv_kit_revised : $flow->pv_kit;
        $pv_kit_obj = json_decode($pv_kit_json);
        $pv_kit_structure_type_id = $pv_kit_obj->structure_type_id;

        $integrator = json_decode($flow->integrator);

        $today_str = date('Y-m-d');
        $pricing_table = PricingTable::find('first', ['conditions' => ['company_id = ? AND active = ? AND ? BETWEEN start AND end', $flow->company_id, 1, $today_str]]);
        $pricing_field = PricingField::find('first', ['conditions' => ['? BETWEEN power_bottom AND power_top AND ? BETWEEN distance_bottom AND distance_top', $pv_kit_obj->kit_power, $integrator->distance]]);
        $pricing_record = PricingRecord::find('first', ['conditions' => ["company_id = ? AND table_id = ? AND field_id = ? AND structure_type_ids LIKE '%$pv_kit_structure_type_id%'", $flow->company_id, $pricing_table->id, $pricing_field->id]]);

        $current_price = $pricing_record->value * $pv_kit_obj->kit_power * 1000;

        $this->view_data['pricing_table'] = $pricing_table;
        $this->view_data['pricing_field'] = $pricing_field;
        $this->view_data['pricing_record'] = $pricing_record;
        $this->view_data['current_price'] = $current_price;
        $this->view_data['structure_type'] = StructureType::find($pv_kit_structure_type_id);

        $integrator_revised = json_decode($flow->integrator);
        $integrator_revised->price = strval($current_price);
        $integrator_revised = json_encode($integrator_revised);
        $flow->integrator_revised = $integrator_revised;
        $flow->save();

        $this->view_data['form_action_proposal'] = 'tokens/send_proposal/';

        $this->content_view = 'tokens/analyze_simulator_token';
    }

    public function analyze_store_token($store_flow_code = false) {

        $options = ['conditions' => ['code = ?', $store_flow_code], 'include' => ['installation_local']];
        $flow = StoreFlow::find($options);
        $company_appointment = CompanyAppointment::find(['conditions' => ['store_flow_id = ?', $store_flow_code], 'include' => ['appointment_time']]);

        $this->view_data['flow'] = $flow;
        $this->view_data['company_appointment'] = $company_appointment;

        $installation_local = InstallationLocal::first('first', ['conditions' => ['flow_id = ?', $flow->code]]);
        $this->view_data['installation_local'] = $installation_local;

        $pv_kit_json = $flow->pv_kit_revised != null ? $flow->pv_kit_revised : $flow->pv_kit;
        $pv_kit_obj = json_decode($pv_kit_json);
        $pv_kit_structure_type_id = $pv_kit_obj->structure_type_id;

        $integrator = json_decode($flow->integrator);

        $today_str = date('Y-m-d');
        $pricing_table = PricingTable::find('first', ['conditions' => ['company_id = ? AND active = ? AND ? BETWEEN start AND end', $flow->company_id, 1, $today_str]]);
        $pricing_field = PricingField::find('first', ['conditions' => ['? BETWEEN power_bottom AND power_top AND ? BETWEEN distance_bottom AND distance_top', $pv_kit_obj->kit_power, $integrator->distance]]);
        $pricing_record = PricingRecord::find('first', ['conditions' => ["company_id = ? AND table_id = ? AND field_id = ? AND structure_type_ids LIKE '%$pv_kit_structure_type_id%'", $flow->company_id, $pricing_table->id, $pricing_field->id]]);

        $current_price = $pricing_record->value * $pv_kit_obj->kit_power * 1000;

        $this->view_data['pricing_table'] = $pricing_table;
        $this->view_data['pricing_field'] = $pricing_field;
        $this->view_data['pricing_record'] = $pricing_record;
        $this->view_data['current_price'] = $current_price;
        $this->view_data['structure_type'] = StructureType::find($pv_kit_structure_type_id);

        $integrator_revised = json_decode($flow->integrator);
        $integrator_revised->price = strval($current_price);
        $integrator_revised = json_encode($integrator_revised);
        $flow->integrator_revised = $integrator_revised;
        $flow->save();

        $this->content_view = 'tokens/analyze_store_token';
    }

    public function update_pvkit($token = false) {

        if ($_POST) {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $flow = null;

            if ($is_simulator_flow != null){
                $flow =  $is_simulator_flow;
            }else{
                $flow = $is_store_flow;
            }

            $city = City::find($flow->city);
            $pv_kit = PvKit::find($_POST['pvkit_id']);
            unset($_POST['pvkit_id']);

            $is_capital = $city->class == 'Capital Estadual' ? true : false;


            $obj = new stdClass();
            $obj->id = $pv_kit->id;
            $obj->image = $pv_kit->image;
            $obj->price = $pv_kit->price;
            $obj->insurance = $pv_kit->insurance;
            $obj->kit_power = $pv_kit->kit_power;
            $obj->pv_module = $pv_kit->pv_module;
            $obj->desc_module = $pv_kit->desc_module;
            $obj->pv_inverter = $pv_kit->pv_inverter;
            $obj->desc_inverter = $pv_kit->desc_inverter;
            $obj->kit_provider = $pv_kit->kit_provider;
            $obj->structure_type_id = $pv_kit->structure_type_id;

            try {
                $freight = Freight::find($pv_kit->id);
                $freight_value = $is_capital == true ? $freight->capital_value : $freight->inland_value;
                $obj->freight = $freight_value;
            } catch (Exception $e) {
                $obj->freight = 0;

                echo 'Exception: ',  $e->getMessage();
            }

            $json_obj = json_encode($obj);

            $flow->pv_kit_revised = $json_obj;

            $flow->save();

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pv_kit_success'));
            }

            if ($is_simulator_flow != null){
                redirect('tokens/analyze_simulator_token/'.$token);
            }else{
                redirect('tokens/analyze_store_token/'.$token);
            }
        } else {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $flow_pvkit = null;

            if ($is_simulator_flow != null){
                $kit_column = $is_simulator_flow->pv_kit_revised ? 'pv_kit_revised' : 'pv_kit';
                $flow_pvkit = PvKit::first(json_decode($is_simulator_flow->$kit_column)->id);
            }else{
                $kit_column = $is_store_flow->pv_kit_revised ? 'pv_kit_revised' : 'pv_kit';
                $flow_pvkit = PvKit::first(json_decode($is_store_flow->$kit_column)->id);
            }

            $this->view_data['core_settings'] = Setting::first();
            $this->view_data['pvkit'] = $flow_pvkit;
            $this->view_data['pv_kits'] = PvKit::find('all', ['conditions' => ['deleted != 1 AND inactive != 1 AND start_at <= NOW() AND (stop_at is NULL OR stop_at >= NOW())'], 'order' => 'kit_power ASC']);
            $this->theme_view = 'modal_large';
            $this->view_data['title'] = $this->lang->line('application_change_pv_kit');

            $this->content_view = 'tokens/_pvkit';
        }
    }

    public function update_complements($token = false) {

        if ($_POST) {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $flow = null;

            if ($is_simulator_flow != null){
                $flow =  $is_simulator_flow;
            }else{
                $flow = $is_store_flow;
            }

            $arr_complements = array();

//            var_dump($_POST);

            foreach ($_POST as $key => $input){

                $obj = new stdClass();

                if (strpos($key, 'name_') !== 0){
                    $order_name = substr($key, 6);
                    $name = $input;
                }

                if (strpos($key, 'price_') !== 0) {
                    $order_price = substr($key, 5);
                    $price = $input;
                }

                if ($order_name == $order_price){
                    $obj->prop1 = $name;
                    $obj->prop2 = $price;
                }

                if ($obj->prop1 == null || $obj->prop2 == null){
                    $obj = null;
                }else{
                    $obj->name = $obj->prop2;
                    $obj->price = $obj->prop1;
                    unset($obj->prop1);
                    unset($obj->prop2);
                    array_push($arr_complements, $obj);
                }

            }

            if(count($arr_complements) < 1){
                $arr_complements = null;
            }else{
                $json_complements = json_encode($arr_complements);
            }


            $flow->complements_revised = $json_complements;
            $flow->save();

            if (!$flow) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_token_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_token_success'));
            }
            if ($is_simulator_flow != null){
                redirect('tokens/analyze_simulator_token/'.$token);
            }else{
                redirect('tokens/analyze_store_token/'.$token);
            }
        }else{

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $complements = null;

            if ($is_simulator_flow != null){
                $complements = json_decode($is_simulator_flow->complements_revised);
            }else{
                $complements = json_decode($is_store_flow->complements_revised);
            }

            $this->view_data['title'] = $this->lang->line('application_change_complements');
            $this->view_data['complements'] = $complements;
            $this->content_view = 'tokens/_complements';
            $this->theme_view = 'modal';
        }
    }

    public function kit_by_id($id){

        $this->theme_view = 'blank';

        $kit = PvKit::find('all', ['conditions' => ['id = ?', $id]]);

        $data = object_to_array($kit)[0];
        $data["price"] = display_money(strval($kit[0]->price));

        $structure_type = StructureType::find('all', ['conditions' => ['id = ?', $kit[0]->structure_type_id]]);
        $data["structure_type"] = object_to_array($structure_type)[0];

        return json_response("success", htmlspecialchars($this->lang->line('messages_registries_retrieved_success')), $data);
    }

    public function view_pricing_table($id = false) {

        $pricing_table = PricingTable::find($id);
        $pricing_records = PricingRecord::all(['conditions' => ['table_id = ? ORDER BY field_id ASC', $id]]);

        $this->theme_view = 'modal';
        $this->view_data['pricing_records'] = $pricing_records;
        $this->view_data['title'] = $this->lang->line('application_price_table').': '.$pricing_table->name;

        $this->content_view = 'tokens/_pricing';
    }

    public function solarbid_approve($token = false) {

        if ($_POST) {

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $_POST['code']]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $_POST['code']]]);

            $flow = null;

            if ($is_simulator_flow != null){
                $flow =  $is_simulator_flow;
            }else{
                $flow = $is_store_flow;
            }

            if ($flow->pv_kit_revised == null){
                $flow->pv_kit_revised = $flow->pv_kit;
            }

            $flow->solarbid_approved = 1;
            $flow->save();

            $_POST = array();
            $_POST['name'] =  'Solarbid';
            $_POST['subject'] = 'Novo projeto aprovado';
            $_POST['title'] = 'Novo projeto aprovado';
            $_POST['to'] =  'solarbid@solarbid.com.br';
            $_POST['message'] =  'Token: '.$flow->code;

            $company = Company::first($flow->company_id);
            $clients = Client::all(['conditions' => ['company_id = ?', $company->id]]);

            foreach ($clients as $client){

                $_POST = array();
                $_POST['name'] =  $client->firstname;
                $_POST['subject'] = 'Projeto aprovado pela Solarbid';
                $_POST['title'] = 'Projeto aprovado pela Solarbid';
                $_POST['to'] =  $client->email;
                $_POST['message'] =  'Seu projeto foi aprovado pela Solarbid! Verifique se houveram modificações no token sobre kit e complementos necessários para a instalação.<p></p><b>Token:</b> '.$flow->code;

                $mail = new Mail();
                $mail->simple_mail($_POST);
            }

            if ($is_simulator_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_approve_token_success').": ".$is_simulator_flow->code);
                redirect('tokens/analyze_simulator_token/'.$is_simulator_flow->code);
            }else if($is_store_flow != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_approve_token_success').": ".$is_store_flow->code);
                redirect('tokens/analyze_store_token/'.$is_store_flow->code);
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_approve_token_error'));
                redirect('tokens');
            }

        }else{

            $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
            $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

            $flow = null;

            if ($is_simulator_flow != null){
                $flow = $is_simulator_flow;
            }else{
                $flow = $is_store_flow;
            }

            $this->view_data['flow'] = $flow;
            $this->theme_view = 'modal';
            $this->content_view = 'tokens/_approve';
            $this->view_data['title'] = $this->lang->line('application_approve_project');
        }
    }

    public function send_proposal() {

//        var_dump($_POST);exit;

        $core_settings = Setting::first();

        $token = $_POST['token'];

        $is_simulator_flow = SimulatorFlow::find(['conditions' => ['code = ?', $token]]);
        $is_store_flow = StoreFlow::find(['conditions' => ['code = ?', $token]]);

        $path_type = null;

        if ($is_simulator_flow != null){
            $path_type =  'analyze_simulator_token';
        }else{
            $path_type = 'analyze_store_token';
        }

        if ($_POST) {

            var_dump($_POST['userfile']);exit;

            if ($_POST['userfile'] != null){

                //begin image upload
                $config['upload_path'] = './files/proposals/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'pdf';

                $full_path = $core_settings->domain."files/proposals/";

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors('', ' ');
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect('tokens/'.$path_type.'/'.$token);
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $proposal_file = $full_path.$data['upload_data']['file_name'];
                }

                $_POST = array_map('htmlspecialchars', $_POST);
                //end image upload
            }

            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);

//            $pv_kit = PvKit::create($_POST);

            if (!$proposal_file) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_proposal_sent_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_proposal_sent_success'));
            }
            redirect('tokens/'.$path_type.'/'.$token);
        }

        $this->theme_view = 'ajax';
    }

}
