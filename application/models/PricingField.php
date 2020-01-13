<?php

class PricingField extends ActiveRecord\Model{

    static $table_name = 'pricing_field';

    public static $belongs_to = [
        ['pricing_record', "foreign_key" => 'field_id'],
    ];

    public static $has_many = [
        ['pricing_schema_field', 'foreign_key' => 'id'],
    ];


}