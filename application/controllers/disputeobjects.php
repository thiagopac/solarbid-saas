<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class DisputeObjects extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cmessages');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'disputeobjects') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }

    }

    public function index()
    {
//        $options = ['conditions' => ['estimate != ?', 1]];
//        $this->view_data['disputes'] = Disputes::find('all', $options);

        $this->view_data['disputeobjects'] = DisputeObject::all();

        $this->content_view = 'disputeobjects/all';
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $disputeobject = DisputeObject::create($_POST);
            $new_dispute_object_reference = $_POST['disputeobject_reference'] + 1;

            $disputeobject_reference = Setting::first();
            $disputeobject_reference->update_attributes(['disputeobject_reference' => $new_dispute_object_reference]);
            if (!$disputeobject) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_dispute_object_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_object_success'));
            }
            redirect('disputeobjects');
        } else {

            $this->view_data['next_reference'] = DisputeObject::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_dispute_object');
            $this->view_data['dispute_objects'] = DisputeObject::all();
            $this->view_data['form_action'] = 'disputeobjects/create';
            $this->content_view = 'disputeobjects/_disputeobject';
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

            $dispute = DisputeObject::find($id);

            $dispute->update_attributes($_POST);

            if (!$dispute) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_dispute_object_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_dispute_object_success'));
            }
            if ($view == 'true') {
                redirect('disputeobjects/view/' . $id);
            } else {
                redirect('disputeobjects');
            }
        } else {
            $this->view_data['disputeobject'] = DisputeObject::find($id);

            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_dispute_object');

            $this->view_data['form_action'] = 'disputeobjects/update';
            $this->content_view = 'disputeobjects/_disputeobject';
        }
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'disputeobjects',
                        ];

        $disputeobject = $this->view_data['disputeobject'] = DisputeObject::find($id);

        $data['core_settings'] = Setting::first();

        //mostrar os lances
        $this->view_data['disputes'] = Dispute::find_by_sql("SELECT * FROM disputes WHERE dispute_object_id = $id");

        $this->content_view = 'disputeobjects/view';
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

    public function bills($id = false, $condition = false, $bill_id = false) {
        $this->view_data['submenu'] = [
            $this->lang->line('application_back') => 'disputeobjects',
        ];
        switch ($condition) {
            case 'add':
                $this->content_view = 'disputeobjects/_bill';
                if ($_POST) {
                    unset($_POST['send']);

                    $_POST['dispute_object_id'] = $id;

                    $dispute_object_has_bills = DisputeObjectHasBill::create($_POST);

                    if (!$dispute_object_has_bills) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_bill_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_bill_success'));
                    }
                    redirect('disputeobjects/view/' . $id);
                } else {

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_add_bill');

                    $this->view_data['form_action'] = 'disputeobjects/bills/' . $id . '/add';
                    $this->content_view = 'disputeobjects/_bill';
                }
                break;
            case 'update':
                $this->content_view = 'disputeobjects/_bill';
                $this->view_data['bill'] = DisputeObjectHasBill::find($bill_id);

                if ($_POST) {

                    unset($_POST['send']);

                    $bill = DisputeObjectHasBill::find($bill_id);
                    $bill->update_attributes($_POST);

                    if (!$bill) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_bill_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_bill_success'));
                    }
                    redirect('disputeobjects/view/' . $id);
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_bill');

                    $this->view_data['bill'] = DisputeObjectHasBill::find($bill_id);

                    $this->view_data['form_action'] = 'disputeobjects/bills/' . $id . '/update/' . $bill_id;
                    $this->content_view = 'disputeobjects/_bill';
                }
                break;
            case 'delete':
                $bill = DisputeObjectHasBill::find($bill_id);

                $bill->delete();
                if (!$bill) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_bill_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_bill_success'));
                }
                redirect('disputeobjects/view/' . $id);
                break;
            default:
                $this->view_data['bill'] = DisputeObjectHasBill::find($bill_id);
                $this->content_view = 'disputeobjects/view/' . $id;
                break;
        }

    }

    public function dropzone($id = false){

        $attr = array();
        $config['upload_path'] = './files/media/';
        $config['encrypt_name'] = true;
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("file")) {
            $data = array('upload_data' => $this->upload->data());

            $attr['filename'] = $data['upload_data']['orig_name'];
            $attr['savename'] = $data['upload_data']['file_name'];
            $attr['type'] = $data['upload_data']['file_type'];
            $attr['date'] = date("Y-m-d H:i", time());
            $attr['description'] = "";

            $attr['dispute_object_id'] = $id;
//            $attr['user_id'] = $this->user->id;
            $media = DisputeObjectHasFile::create($attr);
            echo $media->id;

            //check image processor extension
            if (extension_loaded('gd2')) {
                $lib = 'gd2';
            } else {
                $lib = 'gd';
            }
            $config['image_library'] = $lib;
            $config['source_image'] = './files/media/'.$attr['savename'];
//            $config['new_image'] = './files/media/thumb_'.$attr['savename'];
            $config['create_thumb'] = false;
//            $config['thumb_marker'] = "";
            $config['maintain_ratio'] = true;
//            $config['width'] = 170;
//            $config['height'] = 170;
            $config['master_dim'] = "height";
            $config['quality'] = "100%";

            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));
        } else {
            echo "Upload failed";
            $error = $this->upload->display_errors('', ' ');
            $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));
            echo $error;
        }

        $this->theme_view = 'blank';
    }

    public function media($id = false, $condition = false, $media_id = false){

        switch ($condition) {
            case 'view':

                if ($_POST) {
                    unset($_POST['send']);
                    unset($_POST['_wysihtml5_mode']);
                    unset($_POST['files']);
                    //$_POST = array_map('htmlspecialchars', $_POST);
                    $_POST['text'] = $_POST['message'];
                    unset($_POST['message']);
                    $_POST['dispute_object_id'] = $id;
                    $_POST['media_id'] = $media_id;
                    $this->view_data['disputeobject'] = DisputeObject::find_by_id($id);
                    $this->view_data['media'] = DisputeObjectHasFile::find($media_id);
                }

                $this->content_view = 'disputeobjects/view_media';
                $this->view_data['media'] = DisputeObjectHasFile::find($media_id);
                $this->view_data['form_action'] = 'disputeobjects/media/'.$id.'/view/'.$media_id;
                $this->view_data['filetype'] = explode('.', $this->view_data['media']->filename);
                $this->view_data['filetype'] = $this->view_data['filetype'][1];
                $this->view_data['backlink'] = 'disputeobjects/view/'.$id;
                break;
            case 'add':
                $this->content_view = 'disputeobjects/_media';
                $this->view_data['disputeobject'] = DisputeObject::find($id);
                if ($_POST) {
                    $config['upload_path'] = './files/media/';
                    $config['encrypt_name'] = true;
                    $config['allowed_types'] = '*';

                    $this->load->library('upload', $config);

                    if (! $this->upload->do_upload()) {
                        $error = $this->upload->display_errors('', ' ');
                        $this->session->set_flashdata('message', 'error:'.$error);
                        redirect('disputeobjects/media/'.$id);
                    } else {
                        $data = array('upload_data' => $this->upload->data());

                        $_POST['filename'] = $data['upload_data']['orig_name'];
                        $_POST['savename'] = $data['upload_data']['file_name'];
                        $_POST['type'] = $data['upload_data']['file_type'];

                        //check image processor extension
                        if (extension_loaded('gd2')) {
                            $lib = 'gd2';
                        } else {
                            $lib = 'gd';
                        }
                        $config['image_library'] = $lib;
                        $config['source_image']    = './files/media/'.$_POST['savename'];
//                        $config['new_image']    = './files/media/thumb_'.$_POST['savename'];
                        $config['create_thumb'] = false;
//                        $config['thumb_marker'] = "";
                        $config['maintain_ratio'] = true;
//                        $config['width']    = 170;
//                        $config['height']    = 170;
                        $config['master_dim']    = "height";
                        $config['quality']    = "100%";

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }

                    unset($_POST['send']);
                    unset($_POST['userfile']);
                    unset($_POST['file-name']);
                    unset($_POST['files']);
                    $_POST = array_map('htmlspecialchars', $_POST);
                    $_POST['dispute_object_id'] = $id;
                    $media = DisputeObjectHasFile::create($_POST);
                    if (!$media) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));
                    }
                    redirect('disputeobjects/view/'.$id);
                } else {
                    $this->theme_view = 'modal';
                    $dispute_object = DisputeObject::find_by_id($id);
                    $this->view_data['plants'] = DisputeObjectHasPlant::find('all', ['conditions' => ['dispute_object_id = ?',$dispute_object->id]]);
                    $this->view_data['title'] = $this->lang->line('application_add_media');
                    $this->view_data['form_action'] = 'disputeobjects/media/'.$id.'/add';
                    $this->content_view = 'disputeobjects/_media';
                }
                break;
            case 'update':
                $this->content_view = 'disputeobjects/_media';
                $this->view_data['media'] = DisputeObjectHasFile::find($media_id);
                $this->view_data['disputeobject'] = DisputeObject::find($id);
                if ($_POST) {
                    unset($_POST['send']);
                    unset($_POST['_wysihtml5_mode']);
                    unset($_POST['files']);
//                    $_POST = array_map('htmlspecialchars', $_POST);
//                    $media_id = $_POST['id'];
                    $media = DisputeObjectHasFile::find($media_id);
                    $media->update_attributes($_POST);
                    if (!$media) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_media_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_media_success'));
                    }
                    redirect('disputeobjects/view/'.$id);
                } else {

                    $dispute_object = DisputeObject::find_by_id($id);
                    $this->theme_view = 'modal';
                    $this->view_data['plants'] = DisputeObjectHasPlant::find('all', ['conditions' => ['dispute_object_id = ?',$dispute_object->id]]);
                    $this->view_data['title'] = $this->lang->line('application_edit_media');
                    $this->view_data['form_action'] = 'disputeobjects/media/'.$id.'/update/'.$media_id;
                    $this->content_view = 'disputeobjects/_media';
                }
                break;
            case 'delete':
                $media = DisputeObjectHasFile::find($media_id);
                $media->delete();
                DisputeObjectHasFile::find_by_sql("DELETE FROM dispute_object_has_files WHERE id = $media_id");

                if (!$media) {
                    $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_media_error'));
                } else {
                    unlink('./files/media/'.$media->savename);
                    $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_media_success'));
                }
                redirect('disputeobjects/view/'.$id);
                break;
            default:
                $this->view_data['disputeobject'] = DisputeObject::find($id);
                $this->content_view = 'disputeobjects/view/'.$id;
                break;
        }
    }

    public function plants($id = false, $condition = false, $plant_id = false) {
        $this->view_data['submenu'] = [
            $this->lang->line('application_back') => 'disputeobjects',
        ];
        switch ($condition) {
            case 'add':
                $this->content_view = 'disputeobjects/_plant';
                if ($_POST) {
                    unset($_POST['send']);

                    $_POST['dispute_object_id'] = $id;

                    $dispute_object_has_plants = DisputeObjectHasPlant::create($_POST);

                    if (!$dispute_object_has_plants) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_plant_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_plant_success'));
                    }
                    redirect('disputeobjects/view/' . $id);
                } else {

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_add_plant');

                    $this->view_data['form_action'] = 'disputeobjects/plants/' . $id . '/add';
                    $this->content_view = 'disputeobjects/_plant';
                }
                break;
            case 'update':
                $this->content_view = 'disputeobjects/_plant';
                $this->view_data['plant'] = DisputeObjectHasPlant::find($plant_id);

                if ($_POST) {

                    unset($_POST['send']);

                    $plant = DisputeObjectHasPlant::find($plant_id);
                    $plant->update_attributes($_POST);

                    if (!$plant) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_plant_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_plant_success'));
                    }
                    redirect('disputeobjects/view/' . $id);
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_plant');

                    $this->view_data['plant'] = DisputeObjectHasPlant::find($plant_id);

                    $this->view_data['form_action'] = 'disputeobjects/plants/' . $id . '/update/' . $plant_id;
                    $this->content_view = 'disputeobjects/_plant';
                }
                break;
            case 'delete':
                $plant = DisputeObjectHasPlant::find($plant_id);

                $plant->delete();
                if (!$plant) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_plant_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_plant_success'));
                }
                redirect('disputeobjects/view/' . $id);
                break;
            default:
                $this->view_data['plant'] = DisputeObjectHasPlant::find($plant_id);
                $this->content_view = 'disputeobjects/view/' . $id;
                break;
        }

    }

}
