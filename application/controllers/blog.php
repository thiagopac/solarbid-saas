<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');
require('mail.php');

class Blog extends MY_Controller
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
                if ($value->link == 'blog') {
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

    public function index() {
        $this->view_data['posts'] = BlogPost::find('all', ['conditions' => ['deleted != ?', 1]]);
        $this->content_view = 'blog/all';
    }

    public function post($post_id = false) {

        $core_settings = Setting::first();

        if ($_POST) {

            $_POST['active'] = $_POST['active'] == 'on' ? 1 : 0;

            if ($_FILES['userfile']['name'] != ''){
                //begin image upload
                $config['upload_path'] = './files/media/blog/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';

                $full_path = $core_settings->domain."/files/media/blog/";

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors('', ' ');
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect("blog/post/$post_id");
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
                    $config['source_image']   = './files/media/blog/'.$_POST['savename'];
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
            }

            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);

            if ($post_id == null){
                BlogPost::create($_POST);
                $post = BlogPost::last();
            }else{
                $post = BlogPost::find($post_id);
                $post->update_attributes($_POST);
            }

            if (!$post) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_updated_post_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_updated_post_success'));
            }

            redirect("blog/post/$post->id");

        }else{

            if ($post_id) {
                $this->view_data['post'] = BlogPost::find($post_id);
            }

            $this->content_view = 'blog/post';
        }
    }

    public function image_upload($post_id = false){

        $core_settings = Setting::first();

        if ($_POST) {

            $_POST['active'] = $_POST['active'] == 'on' ? 1 : 0;

            if ($_FILES['userfile']['name'] != ''){
                //begin image upload
                $config['upload_path'] = './files/media/blog/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';

                $full_path = $core_settings->domain."/files/media/blog/";

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors('', ' ');
                    $this->session->set_flashdata('message', 'error:'.$error);
                    redirect("blog/post/$post_id");
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
                    $config['source_image']   = './files/media/blog/'.$_POST['savename'];
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
            }

            unset($_POST['send']);
            unset($_POST['userfile']);
            unset($_POST['files']);

            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_image_success'));

            redirect("blog/post/$post_id");

        }else{
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_media');
            $this->view_data['form_action'] = 'blog/image_upload/';
            $this->content_view = 'blog/_image';
        }

    }

    public function image_server() {

        $path    = './files/media/blog';
        $files = array_diff(scandir($path), array('.', '..'));
        $clean_files = array();

        for($i = 2; $i < count($files); $i++){
            if (preg_match("/^[^\.].*$/", $files[$i])) {
                array_push($clean_files, $files[$i]);
            }
        }

        $this->view_data['files'] = $clean_files;

        $this->theme_view = 'modal_large';
        $this->content_view = 'blog/_image_server';
        $this->view_data['title'] = $this->lang->line('application_images_in_server');
    }

}
