<?php

class SimulatorFlow extends ActiveRecord\Model {
    static $table_name = 'flow';
    public $installation_local;

    public static $belongs_to = [
        ['city', 'foreign_key' => 'city'],
        ['state', 'foreign_key' => 'state'],
        ['activity', 'foreign_key' => 'activity'],

        ['energy_dealer', 'foreign_key' => 'dealer'],
        ['structure_type', 'foreign_key' => 'structure_type_id'],
        ['purchase', 'foreign_key' => 'code'],
        ['financing_request', 'foreign_key' => 'code'],
        ['installation_local', 'foreign_key' => 'code'],

        ['city_obj', 'foreign_key' => 'city', 'class_name' => 'City'],
        ['state_obj', 'foreign_key' => 'state', 'class_name' => 'State'],
        ['activity_obj', 'foreign_key' => 'activity', 'class_name' => 'Activity']
    ];

    public function getFlowByCode($code){

        $flow = SimulatorFlow::find('first', ['conditions' => ['code = ?', $code]]);
        return $flow;
    }

}