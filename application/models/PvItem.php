<?php

class PvItem extends ActiveRecord\Model {
    static $table_name = 'pv_item';

    static $belongs_to = array(
        ['pv_proforma_item'],
    );

}