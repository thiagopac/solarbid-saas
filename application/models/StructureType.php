<?php

class StructureType extends ActiveRecord\Model {
    static $table_name = 'structure_type';

	static $has_many = array(
        ['pv_kit'],
        ['simulator_flow', 'foreign_key' => 'id']
    );

}