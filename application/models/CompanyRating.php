<?php

class CompanyRating extends ActiveRecord\Model {
    static $table_name = 'company_rating';

    static $belongs_to = array(
     array('company')
  );
  
}