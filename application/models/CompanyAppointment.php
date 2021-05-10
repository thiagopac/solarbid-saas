<?php

class CompanyAppointment extends ActiveRecord\Model {
    static $table_name = 'company_appointment';

    static $belongs_to = array(
        array('company'),
        array('appointment_time', "foreign_key" => 'appointment_time_id')
    );
  
}