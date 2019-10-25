<?php

class PricingSchema extends ActiveRecord\Model{

    static $table_name = 'pricing_schema';


    public static $has_many = [
        ['pricing_table', 'through' => 'id'],
    ];


}