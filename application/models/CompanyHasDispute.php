<?php

class CompanyHasDispute extends ActiveRecord\Model {
    static $table_name = 'company_has_disputes';

    public static $belongs_to = array(
        array('company', 'foreign_key' => 'company_id'),
        array('dispute', 'foreign_key' => 'dispute_id'),
    );
  
}