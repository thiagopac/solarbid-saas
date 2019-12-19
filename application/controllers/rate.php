<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Rate extends MY_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index() {

        redirect('login');
    }

    public  function error(){
        $this->theme_view = 'login';
        $this->content_view = 'auth/rate_message';
    }

    public  function success(){
        $this->theme_view = 'login';
        $this->content_view = 'auth/rate_message';
    }

    public function evaluation($code){

        $rating_post = RatingPost::find(['conditions'=>['used_code = ?', $code]]);

        if ($rating_post->comment != ''){
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_rate_code_used_error'));
            redirect('rate/error');
        }

        if ($_POST){

            $comment  = $_POST['comment'];
            unset($_POST['comment']);

            $rating_post->comment = $comment;
            $rating_post->save();

            foreach ($_POST as $key => $value){
                $rating_evaluation = new RatingEvaluation();
                $rating_evaluation->rating_post_id = $rating_post->id;
                $rating_evaluation->rating_category_id = $key;
                $rating_evaluation->value = $value;

                $rating_evaluation->save();
            }

            if (!$rating_post) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_rate_saved_error'));
                redirect('rate/error');
            }else{
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_rate_saved_success'));
                redirect('rate/success');
            }

        }else{

            $categories = RatingCategory::all();
            $this->view_data['categories'] = $categories;

            $this->view_data['company'] = Company::find($rating_post->company_id);
            $this->view_data['rating_post'] = $rating_post;

            $this->view_data['form_action'] = 'rate/evaluation/'.$code;

            $this->view_data['error'] = 'false';
            $this->theme_view = 'login';
            $this->content_view = 'auth/rate';
        }

    }



}
