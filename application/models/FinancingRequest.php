<?php

class FinancingRequest extends ActiveRecord\Model {
    static $table_name = 'financing_request';

    public static $belongs_to = [
        ['store_flow', 'foreign_key' => 'store_flow_id'],
        ['simulator_flow', 'foreign_key' => 'flow_id']
    ];

}