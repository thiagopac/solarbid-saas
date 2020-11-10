<?php

class Mail extends MY_Controller {

    public function simple_mail() {

        //to, name, subject, title, message

        if ($_POST){

            $core_settings = Setting::first();

            $this->load->library('parser');
            $this->load->helper('notification');
            $this->load->helper('file');

            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $title = $_POST['title'];
            $message = $_POST['message'];

            $this->email->from($core_settings->email, $core_settings->company);
            $this->email->to(trim(htmlspecialchars($_POST['to'])));

            $this->email->subject($subject);
            $parse_data = [
                'company' => $core_settings->company,
                'title' => $title,
                'name' => $name,
                'message' => $message,
                'greetings' => "Equipe ".$core_settings->company,
                'solarbid_logo' => '<img src="' . base_url() . '' . $core_settings->colored_logo . '" alt="' . $core_settings->company . '"/>'
            ];
            $email = read_file('./application/views/' . $core_settings->template . '/templates/email_simple_mail.html');
            $message = $this->parser->parse_string($email, $parse_data);
            $this->email->message($message);
            $this->email->send();
        }

        $this->theme_view = 'ajax';


    }
}