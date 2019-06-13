<?php

class DisputeObjectHasBill extends ActiveRecord\Model {

    static $table_name = 'dispute_object_has_bills';

    public static $belongs_to = array(
        array('dispute_object', 'foreign_key' => 'dispute_object_id'),
    );
    /*public static $has_many = [
        ['dispute_object_has_bills'],
        ['dispute_object_has_files'],
    ];*/

}
