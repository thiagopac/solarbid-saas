<?php

class PvKit extends ActiveRecord\Model {
    static $table_name = 'pv_kit';

    static $belongs_to = array(
     array('structure_type')
  );

}