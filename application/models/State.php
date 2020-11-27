<?php

class State extends ActiveRecord\Model {
    static $table_name = 'state';

    public static $has_many = [
        ['simulator_flow', 'foreign_key' => 'id']
    ];


}
