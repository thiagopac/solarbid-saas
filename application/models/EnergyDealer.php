<?php

class EnergyDealer extends ActiveRecord\Model{

    static $table_name = 'energy_dealer';

//    public static $belongs_to = [
//        ['dealer_activity_tariff', "foreign_key" => 'id'],
//    ];

    public static $has_many = [
        ['dealer_activity_tariff', 'foreign_key' => 'id'],
    ];


}