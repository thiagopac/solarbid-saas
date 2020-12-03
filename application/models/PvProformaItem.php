<?php

class PvProformaItem extends ActiveRecord\Model {
    static $table_name = 'pv_proforma_item';

    static $belongs_to = array(
        ['pv_proforma'],
        ['pv_item', 'foreign_key' => 'pv_item_id'],
    );

    static $has_many = array(

    );

}