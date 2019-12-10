<?php

class ScreeningCompany extends ActiveRecord\Model {

    static $table_name = 'screening_company';

	static $has_many = array(
        array('screening_clients', 'foreign_key' => 'company_id', 'conditions' => 'inactive != 1')
    );

    static $belongs_to = array(
        array('screening_client', 'conditions' => 'inactive != 1')
    );
}