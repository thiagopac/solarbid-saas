<?php

class PricingLimit extends ActiveRecord\Model{

    static $table_name = 'pricing_limit';

    public static $belongs_to = [
        ['pricing_field', 'foreign_key' => 'field_id']
    ];

}