<?php

class Company extends ActiveRecord\Model {

    static $table_name = 'company';

	static $has_many = array(
        array('clients', 'conditions' => 'inactive != 1'),
        array("company_admin"),
        array('user', 'through' => 'company_admin'),
        array('integrator_plan', 'foreign_key' => 'plan_id'),
    );

    static $belongs_to = array(
        array('client', 'conditions' => 'inactive != 1')
    );
}