<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Audits extends MY_Controller
{
    public function __construct()
    {
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
                        $this->lang->line('application_my_tickets') => 'audit/filter/insert',
                        $this->lang->line('application_Opened') => 'audit/filter/update',
                        ];
    }

    public function index(){
        $this->view_data['registries'] = Audit::all(['conditions' => ['1 = ? ORDER BY created_at DESC', 1]]);
        $this->content_view = 'audits/all';
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

    public function view($id = false){

    }
}
