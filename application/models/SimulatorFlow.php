<?php

class SimulatorFlow extends ActiveRecord\Model {
    static $table_name = 'flow';

    public static $belongs_to = [
        ['city', 'foreign_key' => 'city'],
        ['state', 'foreign_key' => 'state'],
        array('purchase', 'foreign_key' => 'code'),
        array('financing_request', 'foreign_key' => 'code'),
        array('installation_local', 'foreign_key' => 'code'),
    ];

}