<?php

class My_Controller extends CI_Controller
{
    public $user = false;
    public $client = false;
    public $core_settings = false;
    // Theme functionality
    protected $theme_view = 'application';
    protected $content_view = '';
    protected $view_data = array();

    public function remove_bad_tags_from($field){
        $_POST[$field] = preg_replace('/(&lt;|<)\?php(.*)(\?(&gt;|>))/imx', '[php] $2 [php]', $_POST[$field]);
        $_POST[$field] = preg_replace('/((&lt;|<)(\s*|\/)script(.*?)(&gt;|>))/imx', ' [script] ', $_POST[$field]);
        $_POST[$field] = preg_replace('/((&lt;|<)(\s*)link(.*?)\/?(&gt;|>))/imx', '[link $4 ]', $_POST[$field]);
        $_POST[$field] = preg_replace('/((&lt;|<)(\s*)(\/*)(\s*)style(.*?)(&gt;|>))/imx', ' [style] ', $_POST[$field]);
    }

    public function __construct()
    {
        parent::__construct();

        /* XSS Filtering */
        if (!empty($_POST)) {
            $fieldList = array("description", "message", "terms", "note", "smtp_pass", "password", "ticket_config_pass", "css-area");
            $ignoreXSS = array("mail_body");

            foreach ($_POST as $key => $value) {
                if (in_array($key, $fieldList)) {
                    $this->remove_bad_tags_from($key);
                } elseif (!in_array($key, $ignoreXSS)) {
                    $_POST[$key] = $this->security->xss_clean($_POST[$key]);
                }
            }
        }

        $this->view_data['core_settings'] = Setting::first();

        //Timezone
        if ($this->view_data['core_settings']->timezone != "") {
            date_default_timezone_set($this->view_data['core_settings']->timezone);
        }

        $this->view_data['datetime'] = date('Y-m-d H:i', time());
        $date = date('Y-m-d', time());

        //Languages
        if ($this->input->cookie('saas_language') != "") {
            $language = $this->input->cookie('saas_language');
        } else {
            if (isset($this->view_data['language'])) {
                $language = $this->view_data['language'];
            } else {
                if (!empty($this->view_data['core_settings']->language)) {
                    $language = $this->view_data['core_settings']->language;
                } else {
                    $language = "english";
                }
            }
        }
        $this->view_data['time24hours'] = "true";
        switch ($language) {

            case "english":
                $this->view_data['langshort'] = "en";
                $this->view_data['timeformat'] = "h:i K";
                $this->view_data['dateformat'] = "F j, Y";
                $this->view_data['time24hours'] = "false";
                break;
            case "portuguese":
                $this->view_data['langshort'] = "pt";
                $this->view_data['timeformat'] = "H:i";
                $this->view_data['dateformat'] = "d/m/Y";
                break;
            default:
                $this->view_data['langshort'] = "en";
                $this->view_data['timeformat'] = "h:i K";
                $this->view_data['dateformat'] = "F j, Y";
                $this->view_data['time24hours'] = "false";
                break;

        }

        //fetch installed languages
        $installed_languages = array();
        if ($handle = opendir('application/language/')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != ".DS_Store") {
                    array_push($installed_languages, $entry);
                }
            }
            closedir($handle);
        }

        $this->lang->load('application', $language);
        $this->lang->load('messages', $language);
        $this->lang->load('event', $language);
        $this->view_data['current_language'] = $language;
        $this->view_data['installed_languages'] = $installed_languages;


        //userdata
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : false;
        $this->client = $this->session->userdata('client_id') ? Client::find_by_id($this->session->userdata('client_id')) : false;


        if ($this->user || $this->client) {

            //check if user or client
            if ($this->user) {
                $access = explode(",", $this->user->access);
                $update = $this->user;
                $email = 'u' . $this->user->id;
                $userIsSuperAdmin = ($this->user->admin == '1') ? true : false;
                $comp_array = false;
                //Create client access list if active user is not super admin
                if (!$userIsSuperAdmin) {
                    $comp_array = array();
                    $thisUserHasCompanies = (array)$this->user->companies;
                    if (!empty($thisUserHasCompanies)) {
                        foreach ($this->user->companies as $value) {
                            array_push($comp_array, $value->id);
                        }
                        $comp_array = "'" . implode(',', $comp_array) . "'";
                    } else {
                        $comp_array = 0;
                    }
                }


                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'main')));
                $this->view_data['module_permissions'] = array();
                $notification_list = array();
                foreach ($this->view_data['menu'] as $key => $value) {
                    array_push($this->view_data['module_permissions'], $value->link);
                }

                $this->view_data['widgets'] = Module::find('all', array('conditions' => array('id in (?) AND type = ?', $access, 'widget')));
                $this->view_data['user_online'] = User::all(array('conditions' => array('last_active+(30 * 60) > ? AND status = ?', time(), "active")));
                $this->view_data['client_online'] = Client::all(array('conditions' => array('last_active+(30 * 60) > ? AND inactive = ?', time(), "0")));

                $this->view_data['tickets_access'] = false;
                if (in_array("tickets", $this->view_data['module_permissions'])) {
                    $this->view_data['tickets_access'] = true;
                    $this->view_data['tickets_new'] = Ticket::newTicketCount($this->user->id, $comp_array);
                }

                $notification_list = Notification::get_notifications($this->user);

                $hasUnredNotifications = 0;

                foreach ($notification_list as $notification) {
                    if ($notification->status == "new") {
                        $hasUnredNotifications = $hasUnredNotifications + 1;
                    }
                }

                $this->view_data["unread_notifications"] = $hasUnredNotifications;

                krsort($notification_list);
                $this->view_data["notification_list"] = $notification_list;
                $this->view_data["notification_count"] = count($notification_list);
            } else {
                $notification_list = array();
                $notification_list = ClientNotification::get_notifications($this->client);

                $hasUnredNotifications = 0;

                foreach ($notification_list as $notification) {
                    if ($notification->status == "new") {
                        $hasUnredNotifications = $hasUnredNotifications + 1;
                    }
                }

                $this->view_data["unread_notifications"] = $hasUnredNotifications;

                krsort($notification_list);
                $this->view_data["notification_list"] = $notification_list;
                $this->view_data["notification_count"] = count($notification_list);

                $this->theme_view = 'application_client';
                $access = $this->client->access;
                $access = explode(",", $access);
                $email = 'c' . $this->client->id;
                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'client')));
                $update = Client::find($this->client->id);

                //platform integrators listing issues and inconsistencies

                $active_pricing_table = PricingTable::find('first', array('conditions' => array('company_id = ? AND active = 1', $this->client->company_id)));

                $company = Company::first($this->client->company_id);

                if ($active_pricing_table != null){
                    $this->view_data['integrator_online'] = true;
                    $integrator_status_desc = "Tudo certo! Todas as configurações estão corretas e você está sendo apresentado corretamente na plataforma.";
                }else{
                    $this->view_data['integrator_online'] = false;
                    $integrator_status_desc = "Você não tem uma tabela de preços ativa na plataforma. Corrija este problema para ficar ativo.";
                }

                if ($active_pricing_table->end != null){
                    if (strtotime($active_pricing_table->start) > strtotime(date("Y-m-d"))  || (strtotime($active_pricing_table->end) < strtotime(date("Y-m-d")) && $active_pricing_table->expiration_locked == 0)){
                        $this->view_data['integrator_online'] = false;
                        $integrator_status_desc = "Você não possui nenhuma tabela de preços com período de validade funcional. Corrija este problema para ficar ativo.";
                    }
                }

                if ($company->inactive == 1 || $company->deleted == 1){
                    $this->view_data['integrator_online'] = false;
                    $integrator_status_desc = "Sua empresa está com o cadastro bloqueado e se encontra inativa na plataforma. Para resolver este problema, entre en contato com a equipe Solarbid através de um Ticket.";
                }

                $this->view_data['integrator_status_desc'] = $integrator_status_desc;

            }

            //Update user last active
            $update->last_active = time();
            $update->save();
        }


        $this->view_data["note_templates"] = "";

        /* save current url */
        $url = explode('/', $this->uri->uri_string());
        $no_link = array('login', 'register', 'logout', 'language', 'forgotpass', 'postmaster', 'cronjob', 'agent', 'api');
        if (!in_array($this->uri->uri_string(), $no_link) && empty($_POST) && (!isset($url[1]) || $url[1] == "view")) {
            $link = '/' . $this->uri->uri_string();
            $cookie = array(
                'name' => 'saas_link',
                'value' => $link,
                'expire' => '500',
            );

            $this->input->set_cookie($cookie);
        }
    }

    public function _output($output)
    {
        // set the default content view
        if ($this->content_view !== false && empty($this->content_view)) {
            $this->content_view = $this->router->class . '/' . $this->router->method;
        }
        //render the content view
        $yield = file_exists(APPPATH . 'views/' . $this->view_data['core_settings']->template . '/' . $this->content_view . EXT) ? $this->load->view($this->view_data['core_settings']->template . '/' . $this->content_view, $this->view_data, true) : false;

        //render the theme
        if ($this->theme_view) {
            echo $this->load->view($this->view_data['core_settings']->template . '/' . 'theme/' . $this->theme_view, array('yield' => $yield), true);
        } else {
            echo $yield;
        }

        echo $output;
    }

//    Debug para php + javascript
    public function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

}
