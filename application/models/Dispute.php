<?php

class Dispute extends ActiveRecord\Model {

    static $table_name = 'disputes';

    public static $belongs_to = [
        ['dispute_object']
    ];
    public static $has_many = [
        ['dispute_has_bids']
    ];

}
