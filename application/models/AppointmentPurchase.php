<?php

class AppointmentPurchase extends ActiveRecord\Model {
    static $table_name = 'appointment_purchase';

    public static $belongs_to = [
        ['store_flow', 'foreign_key' => 'code'],
        ['simulator_flow', 'foreign_key' => 'code']
    ];

}