<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Clients extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cdashboard');
        } elseif ($this->user) {
            $this->view_data['project_access'] = false;
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'clients') {
                    $access = true;
                }
                if ($value->link == 'projects') {
                    $this->view_data['project_access'] = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function index() {

        $this->content_view = 'clients/options';
    }

    public function companies() {

        $this->view_data['companies'] = Company::find('all', ['conditions' => ['deleted != ?', 1]]);
        $this->content_view = 'clients/all_companies';
    }

    public function screening_companies() {

        $this->view_data['screening_companies'] = ScreeningCompany::find('all', ['conditions' => ['deleted != ?', 1]]);
        $this->content_view = 'clients/all_screening_companies';

    }

    public function create($company_id = false)
    {
        if ($_POST) {
            $config['upload_path'] = './files/media/user/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $data = ['upload_data' => $this->upload->data()];

                $_POST['userpic'] = $data['upload_data']['file_name'];
            } else {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload. ') {
                    $this->session->set_flashdata('message', 'error:' . $error);
                    redirect('clients');
                }
            }

            unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

            if (isset($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            } else {
                unset($_POST['access']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['company_id'] = $company_id;
            $client = Client::create($_POST);
            $client->password = $client->set_password($_POST['password']);
            $client->save();
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_client_add_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_client_add_success'));
                $company = Company::find($company_id);
                if (!isset($company->client->id)) {
                    $client = Client::last();
                    $company->update_attributes(['client_id' => $client->id]);
                }
            }
            redirect('clients/view/' . $company_id);
        } else {
            $this->view_data['clients'] = Client::find('all', ['conditions' => ['inactive=?', '0']]);
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
            $this->view_data['next_reference'] = Client::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_new_contact');
            $this->view_data['form_action'] = 'clients/create/' . $company_id;
            $this->content_view = 'clients/_client';
        }
    }

    public function update($id = false, $getview = false) {
        if ($_POST) {
            $id = $_POST['id'];
            $client = Client::find($id);
            $config['upload_path'] = './files/media/user/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $data = ['upload_data' => $this->upload->data()];

                $_POST['userpic'] = $data['upload_data']['file_name'];
            } else {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload. ') {
                    $this->session->set_flashdata('message', 'error:' . $error);
                    redirect('clients');
                }
            }

            unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

            if (empty($_POST['password'])) {
                unset($_POST['password']);
            } else {
                $_POST['password'] = $client->set_password($_POST['password']);
            }
            if (!empty($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            }

            if (isset($_POST['view'])) {
                $view = $_POST['view'];
                unset($_POST['view']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);

            $client->update_attributes($_POST);
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_client_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_client_success'));
            }
            redirect('clients/view/' . $client->company->id);
        } else {
            $this->view_data['client'] = Client::find($id);
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_client');
            $this->view_data['form_action'] = 'clients/update';
            $this->content_view = 'clients/_client';
        }
    }

    public function update_screening($id = false, $getview = false) {
        if ($_POST) {
            $id = $_POST['id'];
            $client = ScreeningClient::find($id);
            $config['upload_path'] = './files/media/user';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $data = ['upload_data' => $this->upload->data()];

                $_POST['userpic'] = $data['upload_data']['file_name'];
            } else {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload. ') {
                    $this->session->set_flashdata('message', 'error:' . $error);
                    redirect('clients');
                }
            }

            unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

            if (empty($_POST['password'])) {
                unset($_POST['password']);
            } else {
                $_POST['password'] = $client->set_password($_POST['password']);
            }
            if (!empty($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            }

            if (isset($_POST['view'])) {
                $view = $_POST['view'];
                unset($_POST['view']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);

            $client->update_attributes($_POST);
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_client_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_client_success'));
            }
            redirect('clients/view_screening/' . $client->company->id);
        } else {
            $this->view_data['client'] = ScreeningClient::find($id);
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_client');
            $this->view_data['form_action'] = 'clients/update_screening';
            $this->content_view = 'clients/_screening_client';
        }
    }

    public function notes($id = false) {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $project = Company::find($id);
            $project->update_attributes($_POST);
        }
        $this->theme_view = 'ajax';
    }

    public function company($condition = false, $id = false) {
        switch ($condition) {
            case 'create':
            if ($_POST) {
                unset($_POST['send']);
                $_POST["city"] = substr($_POST["city"], 0, -3);

                $company = Company::create($_POST);
                $last_company = Company::last();
                $attributes = ['company_id' => $last_company->id, 'user_id' => $this->user->id];
                $adminExists = CompanyAdmin::exists($attributes);
                if (!$adminExists) {
                    $addUserAsClientAdmin = CompanyAdmin::create($attributes);
                }

                $new_company_reference = $_POST['reference'] + 1;
                $company_reference = Setting::first();
                $company_reference->update_attributes(['company_reference' => $new_company_reference]);

                $rating_categories = RatingCategory::all();

                foreach ($rating_categories as $rating_category){
                    $company_rating = new CompanyRating();
                    $company_rating->company_id = $last_company->id;
                    $company_rating->rating_category_id = $rating_category->id;
                    $company_rating->value = 2.5;
                    $company_rating->save();
                }

                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_company_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_company_add_success'));
                }
                redirect('clients/view/' . $last_company->id);
            } else {
                $this->view_data['clients'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);

                $this->view_data['cities'] = City::find('all');
                $this->view_data['states'] = State::find('all');
                $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
                $this->view_data['plans'] = IntegratorPlan::find('all');

                $this->view_data['next_reference'] = Company::last();
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_add_new_company');
                $this->view_data['form_action'] = 'clients/company/create';
                $this->content_view = 'clients/_company';
            }
            break;
            case 'update':
            if ($_POST) {
                unset($_POST['send']);
                $id = $_POST['id'];
                if (isset($_POST['view'])) {
                    $view = $_POST['view'];
                    unset($_POST['view']);
                }
                $company = Company::find_by_id($id);

                $_POST["city"] = substr($_POST["city"], 0, -3);

                $company->update_attributes($_POST);
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_company_success'));
                }
                redirect('clients/view/' . $id);
            } else {
                $company = $this->view_data['company'] = Company::find_by_id($id);

                $this->view_data['cities'] = City::find('all', ['conditions' => ['state = ?', $company->state], 'order' => 'name ASC']);
                $this->view_data['states'] = State::find('all');
                $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
                $this->view_data['plans'] = IntegratorPlan::find('all');

                $company_city = $company->city.'/'.$company->state;
                $this->view_data['company_city'] = $company_city;

                $company_state = $company->state;
                $this->view_data['company_state'] = $company_state;

                $company_country = $company->country;
                $this->view_data['company_country'] = $company_country;

                $company_plan = $company->plan_id;
                $this->view_data['company_plan'] = $company_plan;

                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_edit_company');
                $this->view_data['form_action'] = 'clients/company/update';
                $this->content_view = 'clients/_company';
            }
                break;
                case 'delete':
                $company = Company::find_by_id($id);
                $company->inactive = '1';
                $company->save();
                foreach ($company->clients as $value) {
                    $client = Client::find_by_id($value->id);
                    $client->inactive = '1';
                    $client->save();
                }
                $this->content_view = 'clients/all_companies';
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_company_success'));
                }
                    redirect('clients');
                break;
        }
    }

    public function screening_company($condition = false, $id = false) {
        switch ($condition) {
            case 'update':
                if ($_POST) {
                    unset($_POST['send']);
                    $id = $_POST['id'];
                    if (isset($_POST['view'])) {
                        $view = $_POST['view'];
                        unset($_POST['view']);
                    }
                    $company = ScreeningCompany::find_by_id($id);

                    $_POST["city"] = substr($_POST["city"], 0, -3);

                    $company->update_attributes($_POST);
                    if (!$company) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_company_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_company_success'));
                    }
                    redirect('clients/view_screening/' . $id);
                } else {
                    $company = $this->view_data['company'] = ScreeningCompany::find_by_id($id);

                    $this->view_data['cities'] = City::find('all', ['conditions' => ['state = ?', $company->state], 'order' => 'name ASC']);
                    $this->view_data['states'] = State::find('all');
                    $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);

                    $company_city = $company->city.'/'.$company->state;
                    $this->view_data['company_city'] = $company_city;

                    $company_state = $company->state;
                    $this->view_data['company_state'] = $company_state;

                    $company_country = $company->country;
                    $this->view_data['company_country'] = $company_country;

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_company');
                    $this->view_data['form_action'] = 'clients/screening_company/update';
                    $this->content_view = 'clients/_screening_company';
                }
                break;
            case 'promote':
                $screening_company = ScreeningCompany::find_by_id($id);
                $screening_company->promoted = '1';
                $screening_company->save();

                $company = new Company();

                $company_attr = (array) $screening_company->attributes();

                unset($company_attr['id']); //do not copy screening company id, need new one
                $company->create($company_attr);

                $last_company = Company::last();

                foreach ($screening_company->screening_clients as $value) {
                    $screening_client = ScreeningClient::find_by_id($value->id);

                    $client = new Client();
                    $client_attr = (array) $screening_client->attributes();
                    unset($client_attr['id']); //do not copy screening client id, need new one
                    unset($client_attr['company_id']); //do not copy screening client company_id, need created company id

                    $client_attr['company_id'] = $last_company->id;

                    $client->create($client_attr);
                }


                //create company full profile
                {
                    $company_profile = new CompanyProfile();
                    $company_profile->company_id = $last_company->id;
                    $company_profile->warranty_lowest = 0;
                    $company_profile->warranty_highest = 0;
                    $company_profile->power_plants_installed = 0;
                    $company_profile->power_executed = 0;
                    $company_profile->save();

                    $rating_categories = RatingCategory::all();
                    foreach ($rating_categories as $rating_category){
                        $company_rating = new CompanyRating();
                        $company_rating->company_id = $last_company->id;
                        $company_rating->rating_category_id = $rating_category->id;
                        $company_rating->value = 2.5;
                        $company_rating->save();
                    }
                }

                $this->content_view = 'clients/all_screening_companies';
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_promote_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_promote_company_success'));
                }
                redirect('clients/screening_companies');
                break;
            case 'delete':
                $company = ScreeningCompany::find_by_id($id);
                $company->inactive = '1';
                $company->deleted = '1';
                $company->save();
                foreach ($company->screening_clients as $value) {
                    $client = ScreeningClient::find_by_id($value->id);
                    $client->inactive = '1';
                    $client->save();
                }
                $this->content_view = 'clients/all_screening_companies';
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_company_success'));
                }
                redirect('clients/screening_companies');
                break;
        }
    }

    public function assign($id = false)
    {
        $this->load->helper('notification');
        if ($_POST) {
            unset($_POST['send']);
            $id = addslashes($_POST['id']);
            $company = Company::find_by_id($id);

            $users_query = $company->company_admin;
            $still_assigned_users = [];
            //remove unselected users
            foreach ($users_query as $value) {
                if (!in_array($value->user_id, $_POST['user_id'])) {
                    $delete = CompanyAdmin::find_by_id($value->id);
                    $delete->delete();
                } else {
                    array_push($still_assigned_users, $value->user_id);
                }
            }
            //add selected users
            foreach ($_POST['user_id'] as $value) {
                if (!in_array($value, $still_assigned_users)) {
                    $attributes = ['company_id' => $id, 'user_id' => $value];
                    $create = CompanyAdmin::create($attributes);
                }
            }

            if (!isset($delete) && !isset($create)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_client_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_client_success'));
            }
            redirect('clients/view/' . $id);
        } else {
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);
            $this->view_data['company'] = Company::find_by_id($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_assign_to_agents');
            $this->view_data['form_action'] = 'clients/assign';
            $this->content_view = 'clients/_assign';
        }
    }

    public function removeassigned($id = false, $companyid = false)
    {
        $delete = CompanyAdmin::find(['conditions' => ['user_id = ? AND company_id = ?', $id, $companyid]]);
        $delete->delete();
        $this->theme_view = 'ajax';
    }

    public function delete($id = false)
    {
        $client = Client::find($id);
        $client->inactive = '1';
        $client->save();
        $this->content_view = 'clients/all_companies';
        if (!$client) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_client_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_client_success'));
        }
        redirect('clients');
    }

    public function view($id = false) {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'clients',
                        ];
        $this->view_data['company'] = Company::find($id);
        if ($this->user->admin != 1) {
            $comp_array = [];
            foreach ($this->user->companies as $value) {
                array_push($comp_array, $value->id);
            }
            if (!in_array($this->view_data['company']->id, $comp_array)) {
                redirect('clients');
            }
        }

        $company_profile = CompanyProfile::first(['conditions' => ['company_id = ?', $id]]);
        $this->view_data['company_profile'] = $company_profile;

        $company_photos = CompanyPhoto::all(['conditions' => ['company_id = ? AND deleted != 1', $id], 'order' => 'id DESC']);
        $this->view_data['company_photos'] = $company_photos;

        $this->content_view = 'clients/view';
    }

    public function view_screening($id = false) {
        $this->view_data['submenu'] = [
            $this->lang->line('application_back') => 'clients',
        ];
        $this->view_data['screening_company'] = ScreeningCompany::find($id);


        $this->content_view = 'clients/view_screening';
    }

    public function credentials($id = false, $email = false, $newPass = false)
    {
        if ($email) {
            $this->load->helper('file');
            $client = Client::find($id);
            $timestamp = time();
            $token = hash('sha256', md5($timestamp . $client->id . $client->firstname));
            $attributes = ['email' => $client->email, 'timestamp' => $timestamp, 'token' => $token, 'user' => 0];
            PwReset::create($attributes);

            $setting = Setting::first();
            $this->email->from($setting->email, $setting->company);
            $this->email->to($client->email);
            $this->email->subject($setting->credentials_mail_subject);
            $this->load->library('parser');
            $parse_data = [
                                'client_contact' => $client->firstname . ' ' . $client->lastname,
                                'first_name' => $client->firstname,
                                'last_name' => $client->lastname,
                                'client_company' => $client->company->name,
                                'client_link' => $setting->domain,
                                'company' => $setting->company,
                                'username' => $client->email,
                                'password' => $newPass,
                                'link' => base_url() . 'forgotpass/token/' . $token,
                                'logo' => '<img src="' . base_url() . '' . $setting->logo . '" alt="' . $setting->company . '"/>',
                                'solarbid_logo' => '<img src="' . base_url() . '' . $setting->solarbid_logo . '" alt="' . $setting->company . '"/>'
                                ];

            $message = read_file('./application/views/' . $setting->template . '/templates/email_credentials.html');
            $message = $this->parser->parse_string($message, $parse_data);
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_login_details_success'));
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_send_login_details_error'));
            }
            redirect('clients/view/' . $client->company_id);
        } else {
            $this->view_data['client'] = Client::find($id);
            $this->theme_view = 'modal';

            function random_password($length = 8)
            {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $password = substr(str_shuffle($chars), 0, $length);
                return $password;
            }

            $this->view_data['new_password'] = random_password();
            $this->view_data['title'] = $this->lang->line('application_login_details');
            $this->view_data['form_action'] = 'clients/credentials';
            $this->content_view = 'clients/_credentials';
        }
    }

    public function hash_passwords()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $pass = $client->password_old;
            $client->password = $client->set_password($pass);
            $client->save();
        }
        redirect('clients');
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
        $this->content_view = 'clients/_preview';
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
        redirect('clients/view/'.$company_photo->company_id);
    }

    public function edit_profile($company_id) {

        $company_profile = CompanyProfile::find($company_id);

        if ($_POST) {
            $company_profile->update_attributes($_POST);
            if (!$company_profile) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_company_profile_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_company_profile_success'));
            }
            redirect('clients/view/'.$company_id);
        } else {

            $this->view_data['company_profile'] = $company_profile;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_profile_and_portfolio');
            $this->view_data['form_action'] = 'clients/edit_profile/'.$company_id;
            $this->content_view = 'clients/_profile';
        }
    }

    public function add_photo($company_id) {

        $core_settings = Setting::first();

        if ($_POST) {

            $config['upload_path'] = './files/media/portfolio/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $_POST['company_id'] = $company_id;
            $_POST['path'] = $core_settings->domain."files/media/portfolio/";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                $this->session->set_flashdata('message', 'error:'.$error);
                redirect('clients/view/'.$company_id);
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
            redirect('clients/view/'.$company_id);
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_media');
            $this->view_data['form_action'] = 'clients/add_photo/'.$company_id;
            $this->content_view = 'clients/_photo';
        }
    }

    public function find() {

        if ($_POST) {

            $company = Company::find(['conditions' => ['registered_number = ?', $_POST['registered_number']]]);

            if ($company != null){
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_viewing_company')." ".$company->name);
                redirect('clients/view/'.$company->id);
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_find_company_error'));
                redirect('clients');
            }

        }else{
            $this->theme_view = 'modal';
            $this->content_view = 'clients/_find';
            $this->view_data['title'] = $this->lang->line('application_find_company');
        }
    }


}
