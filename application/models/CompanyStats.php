<?php

class CompanyStats extends ActiveRecord\Model {
    static $table_name = 'company_stats';

    static $belongs_to = array(
     array('company')
  );
  
}