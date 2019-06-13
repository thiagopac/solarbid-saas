<?php

class DisputeObject extends ActiveRecord\Model {

    static $table_name = 'dispute_objects';

//    public static $belongs_to = [
//        ['company']
//    ];

    public static $has_many = array(
        array("dispute_object_has_bills", 'foreign_key' => 'dispute_object_id'),
        array("dispute_object_has_files", 'foreign_key' => 'dispute_object_id'),
        array("dispute_object_has_plants", 'foreign_key' => 'dispute_object_id'),
    );

}
