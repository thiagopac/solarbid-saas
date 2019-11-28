<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PvKits extends MY_Controller {

    public function __construct() {

        parent::__construct();
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

        $this->view_data['submenu'] = [
            $this->lang->line('application_valids') => 'pvkits/filter/valid',
            $this->lang->line('application_expireds') => 'pvkits/filter/expired'
        ];

    }

    public function index() {

        $options = ['conditions' => ['deleted != ?', '1'], 'order' => 'id DESC', 'include' => ['structure_type']];
        $this->view_data['pv_kits'] = PvKit::find('all', $options);
        $this->view_data['filter'] = $this->lang->line('application_all');

        $this->content_view = 'pvkits/all';
    }

    public function filter($condition) {

        $this->view_data['ticketFilter'] = $this->lang->line('application_all');
        $this->view_data['queues'] = Queue::find('all', ['conditions' => ['inactive=?', '0']]);

        switch ($condition) {
            case 'open':
                $option = 'status = "open"';
                $this->view_data['ticketFilter'] = $this->lang->line('application_opened');
                break;
            case 'closed':
                $option = 'status = "closed"';
                $this->view_data['ticketFilter'] = $this->lang->line('application_closed');
                break;
            case 'reopened':
                $option = 'status = "reopened"';
                $this->view_data['ticketFilter'] = $this->lang->line('application_ticket_status_reopened');
                break;
            case 'assigned':
                $option = 'status != "closed" AND user_id = ' . $this->user->id;
                $this->view_data['ticketFilter'] = $this->lang->line('application_my_tickets');
                break;
        }
        if ($this->user->admin == 0) {
            $comp_array = [];
            $thisUserHasNoCompanies = (array) $this->user->companies;
            if (!empty($thisUserHasNoCompanies)) {
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $options = ['conditions' => [$option . ' AND company_id in (?)', $comp_array]];
            } else {
                $options = ['conditions' => [$option . ' AND (user_id = ? OR queue_id = ?)', $this->user->id, $this->user->queue]];
            }
        } else {
            $options = ['conditions' => [$option]];
        }

        $this->view_data['ticket'] = Ticket::find('all', $options);
        $this->content_view = 'tickets/all';
    }

    public function bulk($action) {
        $this->load->helper('notification');
        if ($_POST) {
            if (empty($_POST['list'])) {
                redirect('tickets');
            }
            $list = explode(',', $_POST['list']);

            switch ($action) {
                case 'close':
                    $attr = ['status' => 'closed'];
                    $email_message = $this->lang->line('messages_bulk_ticket_closed');
                    $success_message = $this->lang->line('messages_bulk_ticket_closed_success');
                    break;

                default:
                    redirect('tickets');
                    break;
            }

            foreach ($list as $value) {
                $ticket = Ticket::find_by_id($value);
                $ticket->update_attributes($attr);
                send_ticket_notification($ticket->user->email, '[Ticket#' . $ticket->reference . '] - ' . $ticket->subject, $email_message, $ticket->id);
                if (!$ticket) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_ticket_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $success_message);
                }
            }
            redirect('tickets');

        } else {
            $this->view_data['ticket'] = Ticket::find($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_close');
            $this->view_data['form_action'] = 'tickets/close';
            $this->content_view = 'tickets/_close';
        }
    }

    public function create() {

        if ($_POST) {

            unset($_POST['send']);

            $_POST['start_at'] = strtotime($_POST['start_at']);
            $_POST['stop_at'] = strtotime($_POST['stop_at']);

            //price come as 12.345,67 and need back to database type 12345.67
            $_POST['price'] = str_replace('.', '', $_POST['price']);
            $_POST['price'] = str_replace(',', '.', $_POST['price']);

            $pv_kit = PvKit::create($_POST);

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_created_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_created_pv_kit_success'));
            }
            redirect('pvkits');
        } else {

            $this->view_data['kit_providers'] = PvProvider::all();
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
            $config['allowed_types'] = 'gif|jpg|png';

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

            //end image upload

            $pv_kit->update_attributes($_POST);

            if (!$pv_kit) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_pv_kit_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_pv_kit_success'));
            }
            redirect('pvkits');
        } else {
            $pv_kit = PvKit::find($pv_kit_id);
            $this->view_data['pv_kit'] = $pv_kit;
            $this->view_data['kit_providers'] = PvProvider::all();
            $this->view_data['inverters'] = InverterManufacturer::all();
            $this->view_data['modules'] = ModuleManufacturer::all();
            $this->view_data['structure_types'] = StructureType::all();
            $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_pv_kit');
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

    function preview_photo($pv_kit_id) {

        $pv_kit = PvKit::find($pv_kit_id);

        $this->theme_view = 'modal';
        $this->view_data['kit'] = $pv_kit;
        $this->content_view = 'pvkits/_preview';
        $this->view_data['title'] = $this->lang->line('application_preview_photo_media');
    }


}
