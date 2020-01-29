<?php

class Project extends ActiveRecord\Model{

    static $table_name = 'project';

    public static $belongs_to = [
        ['company'],
    ];

    public static $has_many = [
        ['project_step'],
    ];

}