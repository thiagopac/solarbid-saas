<?php

class CompanyProfile extends ActiveRecord\Model {
    static $table_name = 'company_profile';

    static $belongs_to = array(
     array('company')
  );
  
}