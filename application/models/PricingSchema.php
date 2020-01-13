<?php

class PricingSchema extends ActiveRecord\Model{

    static $table_name = 'pricing_schema';


    public static $has_many = [
        ['pricing_table', 'foreign_key' => 'id'],
        ['pricing_schema_field', 'foreign_key' => 'id'],
    ];


}