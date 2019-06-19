<?php

class Dispute extends ActiveRecord\Model {

    static $table_name = 'disputes';

    public static $belongs_to = [
        ['dispute_object']
    ];
    public static $has_many = [
        ['dispute_has_bids']
    ];

    public static function getDisputes($limit, $max_value, $company_id){

        $options = ['conditions' => ['company_id = ?', $company_id], 'order' => 'id DESC', 'include' => ['company', 'dispute']];
        $disputes = CompanyHasDispute::find('all', $options);

        return $disputes;
    }

    public static function getDispute($dispute_id){

        $options = ['conditions' => ['id = ?', $dispute_id], 'include' => ['dispute_object', 'dispute_has_bids']];
        $dispute = Dispute::find('first', $options);

        return $dispute;
    }

}
