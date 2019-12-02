<?php

class Freight extends ActiveRecord\Model{

    static $table_name = 'freight';

    public static $belongs_to = [
        ['pv_kit', 'foreign_key' => 'pv_kit_id'],
        ['state', 'foreign_key' => 'state_id'],
    ];

//    public static $has_many = [
////        ['pricing_field', 'foreign_key' => 'id'],
////    ];


}