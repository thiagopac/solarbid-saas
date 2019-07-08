<?php

class BidHasProposal extends ActiveRecord\Model {

    static $table_name = 'bid_has_proposals';

    static $belongs_to = array(
        array('dispute', 'foreign_key' => 'dispute_id'),
        array('client', 'foreign_key' => 'client_id'),
        array('company', 'foreign_key' => 'company_id'),
        array('dispute_has_bid', 'foreign_key' => 'bid_id'),
    );

}
