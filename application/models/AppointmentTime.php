<?php

class AppointmentTime extends ActiveRecord\Model {
    static $table_name = 'appointment_time';

    static $has_many = array(
     array('company_appointment')
  );
  
}