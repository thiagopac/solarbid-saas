<?php

class StructureType extends ActiveRecord\Model {
    static $table_name = 'structure_type';

	static $has_many = array(
        array("pv_kit")
    );

}