<?php

class Purchase extends ActiveRecord\Model {
    static $table_name = 'purchase';

    public static $belongs_to = [
        ['store_flow', 'foreign_key' => 'code'],
        ['simulator_flow', 'foreign_key' => 'code']
    ];

}