<?php

class DisputeHasBid extends ActiveRecord\Model {
    static $table_name = 'dispute_has_bids';

  	static $belongs_to = array(
     array('dispute', 'foreign_key' => 'dispute_id'),
     array('client', 'foreign_key' => 'client_id'),
     array('company', 'foreign_key' => 'company_id'),
  );

    public static $has_many = array(
        array("bid_has_proposals", 'foreign_key' => 'bid_id'),
    );
}
