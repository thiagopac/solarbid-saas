<?php

class InstallationLocal extends ActiveRecord\Model {
    static $table_name = 'installation_local';

    public static $belongs_to = [
        ['store_flow', 'foreign_key' => 'store_flow_id'],
        ['simulator_flow', 'foreign_key' => 'flow_id']
    ];

}