<?php

class SimulatorFlow extends ActiveRecord\Model {
    static $table_name = 'flow';

    public static $belongs_to = [
        ['city', 'foreign_key' => 'city'],
        ['state', 'foreign_key' => 'state']
    ];

}