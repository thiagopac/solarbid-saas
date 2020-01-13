<?php

class PricingSchemaField extends ActiveRecord\Model{

    static $table_name = 'pricing_schema_field';


    public static $belongs_to = [
        ['pricing_field', 'foreign_key' => 'field_id'],
        ['pricing_schema', 'foreign_key' => 'schema_id'],
    ];


}