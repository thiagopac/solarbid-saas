<?php

class Mail extends MY_Controller {

    public function emailqueueApiCall($endpoint, $key, $messages = false) {
        $curl = curl_init();

        $request = [
            "key" => $key,
            "messages" => $messages
        ];

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ["q" => json_encode($request)]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

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

            $to = trim(htmlspecialchars($_POST['to']));
            $from = $core_settings->email;

            $this->email->from($core_settings->email, $core_settings->company);
            $this->email->to($to);

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


            $this->emailqueueApiCall(
                "http://localhost/emailqueue/",
                "e8944908c584976c",
                [
                    [
                        "from" => "$from",
                        "to" => "$to",
                        "sender" => "$core_settings->company",
                        "subject" => "$subject",
                        "content" => "$message"
                    ]
                ]
            );

//            $this->email->send();
        }

        $this->theme_view = 'ajax';


    }
}