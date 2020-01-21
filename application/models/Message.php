<?php

class Message extends ActiveRecord\Model {
    static $table_name = 'message';

    static $belongs_to = array(
     array('company')
  );

    public static function get_messages($user){
        $options = ['conditions' => ['company_id = ? ORDER BY created_at DESC', $user->company_id]];
        $messages = Message::all($options);

        return $messages;
    }
  
}