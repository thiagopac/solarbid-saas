<?php

class Company extends ActiveRecord\Model {
	static $has_many = array(
	array('clients', 'conditions' => 'inactive != 1'),
    array('projects'),
    array("company_has_admins"),
    array('users', 'through' => 'company_has_admins'),
    array('dispute_has_bids'),
    );

    static $belongs_to = array(
    array('client', 'conditions' => 'inactive != 1')
    );
}