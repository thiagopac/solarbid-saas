<?php

class CompanyPhoto extends ActiveRecord\Model {
    static $table_name = 'company_photo';

    static $belongs_to = array(
     array('company')
  );

}