<?php

class DealerActivityTariff extends ActiveRecord\Model{

    static $table_name = 'dealer_activity_tariff';

    public static $belongs_to = [
        ['energy_dealer', "foreign_key" => 'energy_dealer_id'],
        ['activity', "foreign_key" => 'activity_id'],
    ];

    public static $has_many = [
//        ['activity', 'foreign_key' => 'activity_id'],
//        ['energy_dealer', 'foreign_key' => 'id'],
    ];


}