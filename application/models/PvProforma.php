<?php

class PvProforma extends ActiveRecord\Model {
    static $table_name = 'pv_proforma';

	static $has_many = array(
        ['pv_kit'],
    );

    static $belongs_to = array(
        ['structure_type'],
        ['inverter_manufacturer'],
        ['module_manufacturer']
    );

}