<?php

class DisputeObjectHasPlant extends ActiveRecord\Model {

    static $table_name = 'dispute_object_has_plants';

    public static $belongs_to = array(
        array('dispute_object', 'foreign_key' => 'dispute_object_id'),
    );

}
