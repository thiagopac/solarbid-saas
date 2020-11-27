<?php

class StoreFlow extends ActiveRecord\Model {
    static $table_name = 'store_flow';

    static $belongs_to = array(
        ['city', 'foreign_key' => 'city'],
        ['state', 'foreign_key' => 'state'],

        ['purchase', 'foreign_key' => 'code'],
        ['financing_request', 'foreign_key' => 'code'],
        ['installation_local', 'foreign_key' => 'code'],

        ['city_obj', 'foreign_key' => 'city', 'class_name' => 'City'],
        ['state_obj', 'foreign_key' => 'state', 'class_name' => 'State'],
    );

    public function getFlowByCode($code){

        $flow = StoreFlow::find('first', ['conditions' => ['code = ?', $code]]);
        return $flow;
    }

}