<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Disputes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cmessages');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'disputes') {
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
                        $this->lang->line('application_all') => 'disputes',
                        $this->lang->line('application_pendings') => 'disputes/filter/pending',
                        $this->lang->line('application_sent') => 'disputes/filter/sent',
                        ];
    }

    public function index()
    {
//        $options = ['conditions' => ['estimate != ?', 1]];
//        $this->view_data['disputes'] = Disputes::find('all', $options);

        $this->view_data['disputes'] = Dispute::all();

        $this->content_view = 'disputes/all';
    }


    public function filter($condition = false)
    {

        switch ($condition) {
                case 'pending':
                    $option = 'dispute_sent = "no"';
                    break;
                case 'sent':
                    $option = 'dispute_sent = "yes"';
                    break;
                default:
                    $option = '1=1';
                    break;
            }

        $options = ['conditions' => [$option]];
        $this->view_data['disputes'] = Dispute::find('all', $options);

        $this->content_view = 'disputes/all';
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $dispute = Dispute::create($_POST);
            $new_dispute_reference = $_POST['dispute_reference'] + 1;

            $dispute_reference = Setting::first();
            $dispute_reference->update_attributes(['dispute_reference' => $new_dispute_reference]);
            if (!$dispute) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_dispute_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_dispute_success'));
            }
            redirect('disputes');
        } else {

            $this->view_data['next_reference'] = Dispute::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_dispute');
            $this->view_data['dispute_objects'] = DisputeObject::all(['conditions' => ['inactive != ?', 'yes']]);
            $this->view_data['form_action'] = 'disputes/create';
            $this->content_view = 'disputes/_dispute';
        }
    }

    public function update($id = false, $getview = false)
    {
        if ($_POST) {

            $id = $_POST['id'];
            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }
            unset($_POST['view']);
            unset($_POST['send']);

            $dispute = Dispute::find($id);

            $dispute->update_attributes($_POST);

            if (!$dispute) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_dispute_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_dispute_success'));
            }
            if ($view == 'true') {
                redirect('disputes/view/' . $id);
            } else {
                redirect('disputes');
            }
        } else {
            $this->view_data['dispute'] = Dispute::find($id);

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_dispute');

            $this->view_data['dispute_objects'] = DisputeObject::all(['conditions' => ['inactive != ?', 'yes']]);
            $this->view_data['form_action'] = 'disputes/update';
            $this->content_view = 'disputes/_dispute';
        }
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [$this->lang->line('application_back') => 'disputes'];

        $dispute = $this->view_data['dispute'] = Dispute::find($id);

        $data['core_settings'] = Setting::first();

        $this->view_data['plants'] = DisputeObjectHasPlant::find('all', array('conditions' => array('id in (?)', explode(',', $dispute->plants))));

        //mostrar os lances
        $this->view_data['bids'] = $dispute->dispute_has_bids;

        $core_settings = Setting::first();

        $str_days = $this->lang->line('application_days');

        foreach ($dispute->dispute_has_bids as $bid){

            $proposals_html = "<table class='table detail-table no-footer' role='grid' cellspacing='0' cellpadding='0'><thead>";
            $tr = "";

            foreach ($bid->bid_has_proposals as $proposal) {

                $bid->custom = $bid->custom + $proposal->value;

                $plant_nickname = DisputeObjectHasPlant::plantNickname($proposal->plant_id);

                $tr.= "<tr role='row'>
                            <td style='tabindex='0' colspan='1' rowspan='1' width='2%'>&nbsp;</td>
                            <td style='width: 45px;' tabindex='0' colspan='1' rowspan='1' width='4%'>&nbsp;</td>
                            <td style='width: 234px;' tabindex='0' colspan='1' rowspan='1' width='15%'>".$this->lang->line('application_plant')." $proposal->plant_id ($plant_nickname) </td>
                            <td style='text-align: center; width: 146px;' tabindex='0' colspan='1' rowspan='1' width='10%'>".$core_settings->money_symbol." ".display_money(sprintf('%01.2f', $proposal->value))."</td>
                            <td style='text-align: center; width: 110px;' tabindex='0' colspan='1' rowspan='1' width='5%'>$proposal->rated_power_mod $core_settings->rated_power_measurement</td>
                            <td style='text-align: center; width: 239px;' tabindex='0' colspan='1' rowspan='1' width='15%'>$proposal->module_brands</td>
                            <td style='text-align: center; width: 239px;' tabindex='0' colspan='1' rowspan='1' width='15%'>$proposal->inverter_brands</td>
                            <td style='text-align: center; width: 109px;' tabindex='0' colspan='1' rowspan='1' width='8%'>".date($core_settings->date_format." ".$core_settings->date_time_format, strtotime($bid->timestamp))."</td>
                            <td style='text-align: right; width: 172px;' tabindex='0' colspan='1' rowspan='1' width='8%'>$proposal->delivery_time $str_days</td>
                        </tr>";

                $proposals_html.= $tr;
                $tr = "";
            }

            $proposals_html.= "</thead></table>";

            if (count($bid->bid_has_proposals) < 2) {
                $bid->html = "";
            }

            $bid->html = $proposals_html;
        }

        $this->content_view = 'disputes/view';
    }


    public function delete($id = false)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        $this->content_view = 'invoices/all';
        if (!$invoice) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_invoice_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_invoice_success'));
        }
        redirect('invoices');
    }

    public function preview($id = false, $attachment = false)
    {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $data['invoice'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $invoice_project = (is_object($data['invoice']->project)) ? $data['core_settings']->invoice_prefix . $data['invoice']->project->reference . ' - ' . $data['invoice']->project->name : '';


        $due_date = date($data['core_settings']->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
        $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'due_date' => $due_date,
                                'invoice_project' => $invoice_project,
                                'invoice_id' => $data['core_settings']->invoice_prefix . $data['invoice']->reference,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'client_link' => $data['core_settings']->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $data['core_settings']->company,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'

                                ];
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->invoice_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);

        $filename = $this->lang->line('application_invoice') . '_' . $data['core_settings']->invoice_prefix . $data['invoice']->reference;
        pdf_create($html, $filename, true, $attachment);
    }

    public function previewHTML($id = false)
    {
        $this->load->helper(['file']);
        $this->load->library('parser');
        $data['htmlPreview'] = true;
        $data['invoice'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $invoice_project = (is_object($data['invoice']->project)) ? $data['core_settings']->invoice_prefix.$data['invoice']->project->reference.' - '.$data['invoice']->project->name : '';

        $due_date = date($data['core_settings']->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
        $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'due_date' => $due_date,
                                'invoice_project' => $invoice_project,
                                'invoice_id' => $data['core_settings']->invoice_prefix . $data['invoice']->reference,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'client_link' => $data['core_settings']->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $data['core_settings']->company,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'

                                ];
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->invoice_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);
        $this->theme_view = 'blank';
        $this->content_view = 'invoices/_preview';
    }

    public function assignPlant($id = false) {

        if ($_POST) {
            unset($_POST['send']);
            $id = addslashes($_POST['id']);

            if (!empty($_POST['plants_ids'])) {
                $_POST['plants'] = implode(',', $_POST['plants_ids']);
            } else {
                $_POST['plants'] = implode(',', $_POST['plants_ids']);
            }

            unset($_POST['plants_ids']);

            $dispute = Dispute::find($id);

            $dispute->update_attributes($_POST);

            if (!isset($dispute)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_dispute_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_dispute_success'));
            }
            redirect('disputes/view/' . $id);
        } else {

            $dispute = $this->view_data['dispute'] = Dispute::find($id);

            $this->view_data['plants'] = DisputeObjectHasPlant::find('all', ['conditions' => ['dispute_object_id = ?', $dispute->dispute_object->id]]);

            $plants_ids = explode(',', $dispute->plants);

            $dispute_plants = array();

            foreach ($plants_ids as $plant_id) {

                if (is_numeric($plant_id)){
                    $value = DisputeObjectHasPlant::find($plant_id);
                    $dispute_plants[$value->id] = $value->id;
                }
            }

            $this->view_data['dispute_plants'] = $dispute_plants;

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_assign_plants_to_dispute');
            $this->view_data['form_action'] = 'disputes/assignplant';
            $this->content_view = 'disputes/_assign_plants';
        }
    }

    public function ruleParticipation($id = false) {

        if ($_POST) {
            unset($_POST['send']);
            $id = addslashes($_POST['id']);

            if ($_POST['rule_name'] == 'city'){
                if (!empty($_POST['cities_ids'])) {
                    $_POST['rule_value'] = implode(',', $_POST['cities_ids']);
                }
            }

            if ($_POST['rule_name'] == 'state'){
                if (!empty($_POST['states_ids'])) {
                    $_POST['rule_value'] = implode(',', $_POST['states_ids']);
                }
            }

            if ($_POST['rule_name'] == 'country'){
                if (!empty($_POST['countries_ids'])) {
                    $_POST['rule_value'] = implode(',', $_POST['countries_ids']);
                }
            }

            unset($_POST['cities_ids']);
            unset($_POST['states_ids']);
            unset($_POST['countries_ids']);

            $dispute = Dispute::find($id);

            $dispute->range_participants = 0; //zerar para calcular novamente

            $dispute->update_attributes($_POST);

            if (!isset($dispute)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_dispute_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_dispute_success'));
            }
            redirect('disputes/view/' . $id);
        } else {

            $dispute = $this->view_data['dispute'] = Dispute::find($id);

            $this->view_data['cities'] = City::find('all');

            $this->view_data['states'] = State::find('all');

            $this->view_data['countries'] = Country::find('all', ['conditions' => ['status = ?', 1]]);

            $rule_values_ids = explode(',', $dispute->rule_value);

            $dispute_cities = array();
            $dispute_states = array();
            $dispute_countries = array();

            foreach ($rule_values_ids as $value_id) {

                if (is_numeric($value_id)) {

                    if ($dispute->rule_name == "city"){
                        $value = City::find($value_id);
                        $dispute_cities[$value->id] = $value->id;
                    }elseif ($dispute->rule_name == "state"){
                        $value = State::find($value_id);
                        $dispute_states[$value->id] = $value->id;
                    }elseif ($dispute->rule_name == "country"){
                        $value = Country::find($value_id);
                        $dispute_countries[$value->id] = $value->id;
                    }
                }
            }

            $this->view_data['dispute_cities'] = $dispute_cities;
            $this->view_data['dispute_states'] = $dispute_states;
            $this->view_data['dispute_countries'] = $dispute_countries;

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_select_dispute_participation_rule');
            $this->view_data['form_action'] = 'disputes/ruleparticipation';
            $this->content_view = 'disputes/_rule_participation';
        }
    }

    public function calculateParticipants($id = false) {

        $this->content_view = 'disputes/view' . $id;
        $this->theme_view = 'ajax';

        $dispute = Dispute::find($id);

        switch ($dispute->rule_name) {
            case 'city':
                $collection_by_rule = City::find_by_sql("SELECT name FROM cities WHERE id in ($dispute->rule_value)");
                break;

            case 'state':
                $collection_by_rule = State::find_by_sql("SELECT letter as name FROM states WHERE id in ($dispute->rule_value)"); //alias name p/ utilizar name ao invés de letter
                break;

            case 'country':
                $collection_by_rule = Country::find_by_sql("SELECT name FROM countries WHERE id in ($dispute->rule_value)");
                break;

            default:
        }

        $arr_str_rule = array();
        $arr_id_rule = array();

        foreach ($collection_by_rule as $value){
            array_push($arr_str_rule, $value->name);
        }

        $companies_by_rule = Company::find('all', array('conditions' => array(" $dispute->rule_name in (?) and level >= ?", $arr_str_rule, $dispute->rule_level)));

        foreach ($companies_by_rule as $value){
            array_push($arr_id_rule, $value->id);
        }

        $str_participants = implode(",", $arr_id_rule);
        $dispute->participants = $str_participants;
        $dispute->range_participants = count($companies_by_rule);

        $dispute->save();

        if (!isset($dispute)) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_range_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_range_success'));
        }

        redirect('disputes/view/' . $id);
    }

    public function participants($id = false){

        $dispute = Dispute::find($id);

        $companies = Company::find('all', array('conditions' => array(" id in (?)", explode(',', $dispute->participants))));

        $this->view_data['participants'] = $companies;

        $this->view_data['title'] = $this->lang->line('application_participants');
        $this->content_view = 'disputes/_participants';
        $this->theme_view = 'modal';
    }

    public function startDispute($id = false){

        $this->load->helper('notification');

        $core_settings = Setting::first();
        $dispute = Dispute::find($id);

        $prefix = $core_settings->dispute_prefix;
        $reference = $dispute->dispute_reference;

        $this->content_view = 'disputes/view' . $id;
        $this->theme_view = 'ajax';

        $push_receivers = array();

        if ($dispute->dispute_sent == "no"){
            $ids_participants = explode(",", $dispute->participants);

            foreach ($ids_participants as $id_participant){
                CompanyHasDispute::create(['company_id' => $id_participant, 'dispute_id' => $id]);

                $arr_clients = Client::all(['conditions' => ['company_id = ? AND inactive = ?', $id_participant, 0]]);

                foreach ($arr_clients as $client) {

                    if ($client->push_active == 1) {
                        array_push($push_receivers, $client->email);
                    }

                    $attributes = array('client_id' => $client->id, 'message' => "<b>".$prefix.$reference."</b> - ".$this->lang->line('application_new_dispute_started'), 'url' => base_url()."cdisputes");
                    ClientNotification::create($attributes);

                    send_notification($client->email, "[".$prefix.$reference."] - ".$this->lang->line('application_new_dispute_started'), $this->lang->line('application_new_dispute_started').'<br><strong>'.$prefix.$dispute->dispute_reference.'</strong>', false, base_url()."cdisputes", $this->lang->line('application_new_dispute_started'));
                }
            }
        }

        ClientNotification::sendPushNotification($push_receivers, "[".$prefix.$reference."] - ".$this->lang->line('application_new_dispute_started'), base_url());

        $dispute->dispute_sent = 'yes';

        $dispute->save();

        if (!isset($dispute)) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_started_dispute_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_started_dispute_success'));
        }

        redirect('disputes/view/' . $id);
    }

}
