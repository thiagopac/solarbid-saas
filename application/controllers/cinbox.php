<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//include_once(dirname(__FILE__).'/../../system/helpers/download_helper.php');

class cInbox extends MY_Controller {
    function __construct() {
        parent::__construct();
        $access = FALSE;
        if($this->client){
            foreach ($this->view_data['menu'] as $key => $value) {
                if($value->link == "cinbox"){ $access = TRUE;}
            }
            if(!$access){redirect('login');}
        }elseif($this->user){
            redirect('cinbox');
        }else{
            redirect('login');
        }

        $this->view_data['submenu'] = [
            $this->lang->line('application_all') => 'inbox',
            $this->lang->line('application_pendings') => 'inbox/filter/pending',
            $this->lang->line('application_sent') => 'inbox/filter/sent',
        ];

    }

    function index() {
        $this->content_view = 'inbox/client/all';
    }

    function itemslist(){

        $this->view_data['items'] = Message::get_messages($this->client);
        $this->theme_view = 'ajax';

        $this->content_view = 'inbox/client/list';
    }

    function view($id = false) {

        $this->view_data['submenu'] = array(
            $this->lang->line('application_back') => 'cinbox',
        );

        $item = Message::find($id);

        if ($item->status == 'new'){
            $item->status = 'read';
            $item->save();
        }


        $this->view_data["item"] = $item;
        $this->theme_view = 'ajax';



        $this->content_view = 'inbox/client/view';
    }

}