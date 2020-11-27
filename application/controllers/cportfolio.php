<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//include_once(dirname(__FILE__).'/../../system/helpers/download_helper.php');

class cPortfolio extends MY_Controller {
    function __construct() {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cportfolio"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('cportfolio');
        }else{
            redirect('login');
        }

    }

    function index() {

        $company = Company::first(['conditions' => ['id = ?', $this->client->company_id]]);
        $this->view_data['company'] = $company;

        $company_profile = CompanyProfile::first(['conditions' => ['company_id = ?', $this->client->company_id]]);
        $this->view_data['company_profile'] = $company_profile;

        $company_photos = CompanyPhoto::all(['conditions' => ['company_id = ? AND deleted != 1', $this->client->company_id], 'order' => 'id DESC']);
        $this->view_data['company_photos'] = $company_photos;

        $this->content_view = 'portfolio/client/view';
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

    function download_photo($photo_id) {

        $company_photo = CompanyPhoto::find($photo_id);

        $this->load->helper('download');
        $this->load->helper('file');

        if($company_photo){
            $file = './files/media/portfolio/'.$company_photo->filename;
        }

        $mime = get_mime_by_extension($file);
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($company_photo->filename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            @ob_clean();
            @flush();
            exit;
        }

    }

    function preview_photo($photo_id) {

        $company_photo = CompanyPhoto::find($photo_id);

        $this->theme_view = 'modal';
        $this->view_data['company_photo'] = $company_photo;
        $this->content_view = 'portfolio/client/_preview';
        $this->view_data['title'] = $this->lang->line('application_preview_photo_media');
    }

    public function delete_photo($photo_id = false) {

        $company_photo = CompanyPhoto::find($photo_id);
        $company_photo->deleted = 1;
        $company_photo->save();

        if (!$company_photo) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_deleted_photo_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_deleted_photo_success'));
        }
        redirect('cportfolio');
    }

    public function edit_registration() {

        if ($_POST) {
            unset($_POST['send']);
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
                unset($_POST['view']);
            }
            $company = Company::find_by_id($this->client->company_id);


            if ($company->unlocked == true) {
                $_POST["city"] = substr($_POST["city"], 0, -3);
            }

            $company->update_attributes($_POST);
            if (!$company) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_company_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_company_success'));
            }
            redirect('cportfolio');
        } else {
            $company = $this->view_data['company'] = Company::find_by_id($this->client->company_id);

            $company_city = $company->city.'/'.$company->state;
            $company_state = $company->state;
            $company_country = $company->country;

            if($company->unlocked == true){
                $this->view_data['cities'] = City::find('all', ['conditions' => ['state = ?', $company->state], 'order' => 'name ASC']);
                $this->view_data['states'] = State::find('all');
                $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
            }else{
                $this->view_data['cities'] = City::find('all', ['conditions' => ['name = ? AND state = ?', $company->city, $company->state]]);
                $this->view_data['states'] = State::find('all', ['conditions' => ['letter = ?', $company->state]]);
                $this->view_data['countries'] = Country::find('all', ['conditions' => ['name = ? AND status = ?', $company->country, 1]]);
            }

            $this->view_data['company_city'] = $company_city;
            $this->view_data['company_state'] = $company_state;
            $this->view_data['company_country'] = $company_country;

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_registration');
            $this->view_data['form_action'] = 'cportfolio/edit_registration';
            $this->content_view = 'portfolio/client/_company';
        }

    }

    public function edit_profile() {

        $company_profile = CompanyProfile::find($this->client->company_id);

        if ($_POST) {
            $company_profile->update_attributes($_POST);
            if (!$company_profile) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_company_profile_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_company_profile_success'));
            }
            redirect('cportfolio');
        } else {

            $this->view_data['company_profile'] = $company_profile;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_profile_and_portfolio');
            $this->view_data['form_action'] = 'cportfolio/edit_profile/';
            $this->content_view = 'portfolio/client/_profile';
        }
    }

    public function add_photo() {

        $core_settings = Setting::first();

        if ($_POST) {

            $config['upload_path'] = './files/media/portfolio/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $_POST['company_id'] = $this->client->company_id;
            $_POST['path'] = $core_settings->domain."files/media/portfolio/";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                $this->session->set_flashdata('message', 'error:'.$error);
                redirect('cportfolio/');
            } else {
                $data = array('upload_data' => $this->upload->data());

                $_POST['filename'] = $data['upload_data']['file_name'];
                $_POST['type'] = $data['upload_data']['file_type'];

                //check image processor extension
                if (extension_loaded('gd2')) {
                    $lib = 'gd2';
                } else {
                    $lib = 'gd';
                }

                $config['image_library']  = $lib;
                $config['source_image']   = './files/media/portfolio/'.$_POST['savename'];
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

            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);
            $_POST = array_map('htmlspecialchars', $_POST);

            $company_photo = CompanyPhoto::create($_POST);
            if (!$company_photo) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));
            }
            redirect('cportfolio');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_media');
            $this->view_data['form_action'] = 'cportfolio/add_photo/';
            $this->content_view = 'portfolio/client/_photo';
        }
    }

}