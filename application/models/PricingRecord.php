<?php

class PricingRecord extends ActiveRecord\Model{

    static $table_name = 'pricing_record';

    public static $belongs_to = [
        ['company'],
        ['pricing_table'],
        ['pricing_field', 'foreign_key' => 'field_id']
    ];

}