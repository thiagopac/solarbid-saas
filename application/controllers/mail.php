<?php

define("EMAILQUEUE_DIR", "../emailqueue/"); // Set this to your Emailqueue's installation directory.
define("SUPPORT_DIR", __DIR__."../files/support/");


include_once EMAILQUEUE_DIR."config/application.config.inc.php"; // Include emailqueue configuration.
include_once EMAILQUEUE_DIR."config/db.config.inc.php"; // Include Emailqueue's database connection configuration.
include_once EMAILQUEUE_DIR."scripts/emailqueue_inject.class.php"; // Include Emailqueue's emailqueue_inject class.

class Mail extends MY_Controller {

    public function simple_mail() {

        if ($_POST){

            $core_settings = Setting::first();

            $this->load->library('parser');
            $this->load->helper('notification');
            $this->load->helper('file');

            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $title = $_POST['title'];
            $message = $_POST['message'];

            $company_name = $core_settings->company;

            $to = trim(htmlspecialchars($_POST['to']));
            $from = $core_settings->email;

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


            $emailqueue_inject = new Emailqueue\emailqueue_inject(EMAILQUEUE_DB_HOST, EMAILQUEUE_DB_UID, EMAILQUEUE_DB_PWD, EMAILQUEUE_DB_DATABASE);

            try {
                // Call the emailqueue_inject::inject method to inject an email
                $result = $emailqueue_inject->inject([
                    "foreign_id_a" => false, // Optional, an id number for your internal records. e.g. Your internal id of the user who has sent this email.
                    "foreign_id_b" => false, // Optional, a secondary id number for your internal records.
                    "priority" => 10, // The priority of this email in relation to others: The lower the priority, the sooner it will be sent. e.g. An email with priority 10 will be sent first even if one thousand emails with priority 11 have been injected before. Defaults to 10
                    "is_immediate" => true, // Set it to true to queue this email to be delivered as soon as possible. (doesn't overrides priority setting). Defaults to true.
                    "is_send_now" => false, // Set it to true to make this email be sent right now, without waiting for the next delivery call. This effectively gets rid of the queueing capabilities of emailqueue and can delay the execution of your script a little while the SMTP connection is done. Use it in those cases where you don't want your users to wait not even a minute to receive your message. Defaults to false.
                    "date_queued" => false, // If specified, this message will be sent only when the given timestamp has been reached. Leave it to false to send the message as soon as possible. (doesn't overrides priority setting)
                    "is_html" => true, // Whether the given "content" parameter contains HTML or not. Defaults to true.
                    "from" => "$from", // The sender email address
                    "from_name" => "$company_name", // The sender name
                    "to" => "$to", // The addressee email address
                    "replyto" => "$from", // The email address where replies to this message will be sent by default
                    "replyto_name" => "$company_name", // The name where replies to this message will be sent by default
                    "sender" => "$from",
                    "subject" => "$subject", // The email subject
                    "content" => "$message", // The email content. Can contain HTML (set is_html parameter to true if so).
                    "content_nonhtml" => false, // The plain text-only content for clients not supporting HTML emails (quite rare nowadays). If set to false, a text-only version of the given content will be automatically generated.
                    "list_unsubscribe_url" => false, // Optional. Specify the URL where users can unsubscribe from your mailing list. Some email clients will show this URL as an option to the user, and it's likely to be considered by many SPAM filters as a good signal, so it's really recommended.
//                    "is_embed_images" => true, // When set to true, Emailqueue will find all the <img ... /> tags in your provided HTML code on the "content" parameter and convert them into embedded images that are attached to the email itself instead of being referenced by URL. This might cause email clients to show the email straightaway without the user having to accept manually to load the images. Setting this option to true will greatly increase the bandwidth usage of your SMTP server, since each message will contain hard copies of all embedded messages. 10k emails with 300Kbs worth of images each means around 3Gb. of data to be transferred!
                    "custom_headers" => false // Optional. A hash array of additional headers where each key is the header name and each value is its value.
                ]);
            } catch (Exception $e) {
                echo "Emailqueue error: ".$e->getMessage()."<br>";
            }

            if($result)
                echo "Message correctly injected.<br>";
            else
                echo "Error while queing message.<br>";

//            $this->email->message($message);
//            $this->email->send();
        }

        $this->theme_view = 'ajax';
    }

    public function register_mail($data) {

        if ($data){

            $core_settings = Setting::first();

            $this->load->library('parser');
            $this->load->helper('notification');
            $this->load->helper('file');

            $name = $data['name'];
            $subject = $data['subject'];

            $company_name = $core_settings->company;

            $to = trim(htmlspecialchars($data['to']));
            $from = $core_settings->email;

            $parse_data = [
                'company' => $company_name,
                'first_name' => $name,
                'logo' => '<img src="' . base_url() . '' . $core_settings->logo . '" alt="' . $core_settings->company . '"/>',
                'solarbid_logo' => '<img src="' . base_url() . '' . $core_settings->colored_logo . '" alt="' . $core_settings->company . '"/>'
            ];

            $email = read_file('./application/views/' . $core_settings->template . '/templates/email_registered_account.html');
            $message = $this->parser->parse_string($email, $parse_data);


            $emailqueue_inject = new Emailqueue\emailqueue_inject(EMAILQUEUE_DB_HOST, EMAILQUEUE_DB_UID, EMAILQUEUE_DB_PWD, EMAILQUEUE_DB_DATABASE);

            try {
                // Call the emailqueue_inject::inject method to inject an email
                $result = $emailqueue_inject->inject([
                    "foreign_id_a" => false, // Optional, an id number for your internal records. e.g. Your internal id of the user who has sent this email.
                    "foreign_id_b" => false, // Optional, a secondary id number for your internal records.
                    "priority" => 10, // The priority of this email in relation to others: The lower the priority, the sooner it will be sent. e.g. An email with priority 10 will be sent first even if one thousand emails with priority 11 have been injected before. Defaults to 10
                    "is_immediate" => true, // Set it to true to queue this email to be delivered as soon as possible. (doesn't overrides priority setting). Defaults to true.
                    "is_send_now" => false, // Set it to true to make this email be sent right now, without waiting for the next delivery call. This effectively gets rid of the queueing capabilities of emailqueue and can delay the execution of your script a little while the SMTP connection is done. Use it in those cases where you don't want your users to wait not even a minute to receive your message. Defaults to false.
                    "date_queued" => false, // If specified, this message will be sent only when the given timestamp has been reached. Leave it to false to send the message as soon as possible. (doesn't overrides priority setting)
                    "is_html" => true, // Whether the given "content" parameter contains HTML or not. Defaults to true.
                    "from" => "$from", // The sender email address
                    "from_name" => "$company_name", // The sender name
                    "to" => "$to", // The addressee email address
                    "replyto" => "$from", // The email address where replies to this message will be sent by default
                    "replyto_name" => "$company_name", // The name where replies to this message will be sent by default
                    "sender" => "$from",
                    "subject" => "$subject", // The email subject
                    "content" => "$message", // The email content. Can contain HTML (set is_html parameter to true if so).
                    "content_nonhtml" => false, // The plain text-only content for clients not supporting HTML emails (quite rare nowadays). If set to false, a text-only version of the given content will be automatically generated.
                    "list_unsubscribe_url" => false, // Optional. Specify the URL where users can unsubscribe from your mailing list. Some email clients will show this URL as an option to the user, and it's likely to be considered by many SPAM filters as a good signal, so it's really recommended.
//                    "is_embed_images" => true, // When set to true, Emailqueue will find all the <img ... /> tags in your provided HTML code on the "content" parameter and convert them into embedded images that are attached to the email itself instead of being referenced by URL. This might cause email clients to show the email straightaway without the user having to accept manually to load the images. Setting this option to true will greatly increase the bandwidth usage of your SMTP server, since each message will contain hard copies of all embedded messages. 10k emails with 300Kbs worth of images each means around 3Gb. of data to be transferred!
                    "custom_headers" => false // Optional. A hash array of additional headers where each key is the header name and each value is its value.
                ]);
            } catch (Exception $e) {
                echo "Emailqueue error: ".$e->getMessage()."<br>";
            }

            if($result)
                echo "Message correctly injected.<br>";
            else
                echo "Error while queing message.<br>";

//            $this->email->message($message);
//            $this->email->send();
        }

        $this->theme_view = 'ajax';
    }

    public function welcome_mail($data) {

        if ($data){

            $core_settings = Setting::first();

            $this->load->library('parser');
            $this->load->helper('notification');
            $this->load->helper('file');

            $subject = $this->lang->line('application_your_account_is_ready');

            $name = $data['name'];
            $client_company = $data['client_company'];

            $platform_address = 'https://appsolarbid.com.br/';
            $document_address = $core_settings->domain.'/files/support/Precificação-Integradores.xlsx';

            $company_name = $core_settings->company;

            $to = trim(htmlspecialchars($data['to']));
            $from = $core_settings->email;

            $parse_data = [
                'company' => $core_settings->company,
                'platform_address' => $platform_address,
                'document_address' => $document_address,
                'client_company' => $client_company,
                'first_name' => $name,
                'logo' => '<img src="' . base_url() . '' . $core_settings->logo . '" alt="' . $core_settings->company . '"/>',
                'solarbid_logo' => '<img src="' . base_url() . '' . $core_settings->colored_logo . '" alt="' . $core_settings->company . '"/>'
            ];

            $email = read_file('./application/views/' . $core_settings->template . '/templates/email_welcome_account.html');
            $message = $this->parser->parse_string($email, $parse_data);


            $emailqueue_inject = new Emailqueue\emailqueue_inject(EMAILQUEUE_DB_HOST, EMAILQUEUE_DB_UID, EMAILQUEUE_DB_PWD, EMAILQUEUE_DB_DATABASE);

//            echo SUPPORT_DIR."/Precificação-Integradores.xlsx";
//            exit;

            try {
                // Call the emailqueue_inject::inject method to inject an email
                $result = $emailqueue_inject->inject([
                    "foreign_id_a" => false, // Optional, an id number for your internal records. e.g. Your internal id of the user who has sent this email.
                    "foreign_id_b" => false, // Optional, a secondary id number for your internal records.
                    "priority" => 10, // The priority of this email in relation to others: The lower the priority, the sooner it will be sent. e.g. An email with priority 10 will be sent first even if one thousand emails with priority 11 have been injected before. Defaults to 10
                    "is_immediate" => true, // Set it to true to queue this email to be delivered as soon as possible. (doesn't overrides priority setting). Defaults to true.
                    "is_send_now" => false, // Set it to true to make this email be sent right now, without waiting for the next delivery call. This effectively gets rid of the queueing capabilities of emailqueue and can delay the execution of your script a little while the SMTP connection is done. Use it in those cases where you don't want your users to wait not even a minute to receive your message. Defaults to false.
                    "date_queued" => false, // If specified, this message will be sent only when the given timestamp has been reached. Leave it to false to send the message as soon as possible. (doesn't overrides priority setting)
                    "is_html" => true, // Whether the given "content" parameter contains HTML or not. Defaults to true.
                    "from" => "$from", // The sender email address
                    "from_name" => "$company_name", // The sender name
                    "to" => "$to", // The addressee email address
                    "replyto" => "$from", // The email address where replies to this message will be sent by default
                    "replyto_name" => "$company_name", // The name where replies to this message will be sent by default
                    "sender" => "$from",
                    "subject" => "$subject", // The email subject
                    "content" => "$message", // The email content. Can contain HTML (set is_html parameter to true if so).
                    "content_nonhtml" => false, // The plain text-only content for clients not supporting HTML emails (quite rare nowadays). If set to false, a text-only version of the given content will be automatically generated.
                    "list_unsubscribe_url" => false, // Optional. Specify the URL where users can unsubscribe from your mailing list. Some email clients will show this URL as an option to the user, and it's likely to be considered by many SPAM filters as a good signal, so it's really recommended.
                    "attachments" => [ // Optional. An array of hash arrays specifying the files you want to attach to your email. See example.php for an specific description on how to build this array.
                        [
                            "path" => __DIR__."/Precificação-Integradores.xlsx"
                        ]
                    ],
//                    "is_embed_images" => true, // When set to true, Emailqueue will find all the <img ... /> tags in your provided HTML code on the "content" parameter and convert them into embedded images that are attached to the email itself instead of being referenced by URL. This might cause email clients to show the email straightaway without the user having to accept manually to load the images. Setting this option to true will greatly increase the bandwidth usage of your SMTP server, since each message will contain hard copies of all embedded messages. 10k emails with 300Kbs worth of images each means around 3Gb. of data to be transferred!
                    "custom_headers" => false // Optional. A hash array of additional headers where each key is the header name and each value is its value.
                ]);
            } catch (Exception $e) {
                echo "Emailqueue error: ".$e->getMessage()."<br>";
            }

            if($result)
                echo "Message correctly injected.<br>";
            else
                echo "Error while queing message.<br>";

//            $this->email->message($message);
//            $this->email->send();
        }

        $this->theme_view = 'ajax';
    }


}