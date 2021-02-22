<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require('mail.php');

class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $core_settings = Setting::first();
        if ($core_settings->registration != 1) {
            redirect('login');
        }

        if ($_POST) {

            $this->load->library('parser');
            $this->load->helper('file');
            $this->load->helper('notification');
            $client = Client::find_by_email(trim(htmlspecialchars($_POST['email'])));
            if ($client->inactive == 1) {
                $client = false;
            }
            $check_company = Company::find_by_name(trim(htmlspecialchars($_POST['name'])));

            if (!$client && !$check_company && trim(htmlspecialchars($_POST['name'])) != '' && trim(htmlspecialchars($_POST['email'])) != '' && $_POST['password'] != '' && $_POST['firstname'] != '' && $_POST['lastname'] != '' && $_POST['confirmcaptcha'] != '') {
                $company_attr = [];
                $company_attr['name'] = trim(htmlspecialchars($_POST['name']));
                $company_attr['corporate_name'] = trim(htmlspecialchars($_POST['corporate_name']));
                $company_attr['registered_number'] = $_POST['registered_number'];
                $company_attr['email'] = $_POST['email'];
                $company_attr['phone'] = trim(htmlspecialchars($_POST['phone']));
                $company_attr['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $company_attr['address'] = trim(htmlspecialchars($_POST['address']));
                $company_attr['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $company_attr['city'] = trim(htmlspecialchars($_POST['city']));
                $company_attr['country'] = trim(htmlspecialchars("Brasil"));
                $company_attr['state'] = trim(htmlspecialchars($_POST['state']));

                $core_settings->save();

                $company = ScreeningCompany::create($company_attr);

                if (!$company) {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_request_registration_error'));
                    redirect('register');
                }

                $client_attr = [];
                $client_attr['email'] = trim(htmlspecialchars($_POST['email']));
                $client_attr['firstname'] = trim(htmlspecialchars($_POST['firstname']));
                $client_attr['lastname'] = trim(htmlspecialchars($_POST['lastname']));
                $client_attr['phone'] = trim(htmlspecialchars($_POST['phone']));
                $client_attr['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $client_attr['access'] = $core_settings->default_client_modules;

                $client_attr['company_id'] = $company->id;

                $client = ScreeningClient::create($client_attr);

                $last_inserted_company = ScreeningCompany::last();
                $last_inserted_client = ScreeningClient::last();

                //
                $last_inserted_company->client_id = $last_inserted_client->id;
                $last_inserted_company->save();

                if ($client) {
                    $client->password = $client->set_password($_POST['password']);
                    $client->save();
                    $company->client_id = $client->id;
                    $company->save();


                    $data = array();
                    $data['name'] =  $client_attr['firstname'];
                    $data['client_company'] = $last_inserted_company->name;
                    $data['to'] =  $client_attr['email'];


                    $mail = new Mail();
                    $mail->register_mail($data);

                    send_notification($core_settings->email,
                                      $this->lang->line('application_new_client_has_registered'),
                                '<strong>' . $company_attr['name'] . '</strong><br>' . $client_attr['firstname'] . ' ' . $client_attr['lastname'] . '<br>' . $client_attr['email'],
                                      $this->lang->line('application_new_client_has_registered')
                                     );

                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_request_registration_success'));
                    redirect('login');
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_request_registration_error'));
                    redirect('login');
                }
            } else {
                if ($client) {
                    $this->view_data['error'] = $this->lang->line('messages_email_already_taken');
                }
                if ($check_company) {
                    $this->view_data['error'] = $this->lang->line('application_company_name_already_taken');
                }
                $this->theme_view = 'login';
                $this->content_view = 'auth/register';
                $this->view_data['form_action'] = 'register';
                $_POST['name'] = trim(htmlspecialchars($_POST['name']));
                $_POST['phone'] = trim(htmlspecialchars($_POST['phone']));
                $_POST['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $_POST['address'] = trim(htmlspecialchars($_POST['address']));
                $_POST['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $_POST['city'] = trim(htmlspecialchars($_POST['city']));
                $_POST['country'] = trim(htmlspecialchars($_POST['country']));
                $_POST['state'] = trim(htmlspecialchars($_POST['state']));
                $_POST['email'] = trim(htmlspecialchars($_POST['email']));
                $_POST['firstname'] = trim(htmlspecialchars($_POST['firstname']));
                $_POST['lastname'] = trim(htmlspecialchars($_POST['lastname']));
                $this->view_data['registerdata'] = array_map('htmlspecialchars', $_POST);
            }
        } else {
            $this->view_data['error'] = 'false';
            $this->theme_view = 'login';
            $this->content_view = 'auth/register';
            $this->view_data['states'] = State::find('all');
            $this->view_data['form_action'] = 'register';
        }
    }
}
