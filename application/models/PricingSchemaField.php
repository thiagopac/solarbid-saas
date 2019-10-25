<?php

class PricingSchemaField extends ActiveRecord\Model{

    static $table_name = 'pricing_schema_field';

    public static $belongs_to = [
        ['pricing_schema', 'foreign_key' => 'schema_id'],
    ];

    public static $has_many = [
        ['pricing_field', 'foreign_key' => 'id'],
    ];


}