<?php

class StoreFlow extends ActiveRecord\Model {
    static $table_name = 'store_flow';

    static $has_many = array(
        array('city', 'foreign_key' => 'city'),
        array('state', 'foreign_key' => 'state'),
        array('pv_kit', 'foreign_key' => 'pv_kit_id'),
    );

}