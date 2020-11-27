<?php

class City extends ActiveRecord\Model {
    static $table_name = 'city';

    public static $has_many = [
        ['simulator_flow', 'foreign_key' => 'id']
    ];
}
