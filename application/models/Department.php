<?php

class Department extends ActiveRecord\Model {
    static $table_name = 'department';

	static $has_many = array(
        array("department_worker")
    );

}