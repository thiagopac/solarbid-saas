<?php

class ProjectStep extends ActiveRecord\Model{

    static $table_name = 'project_step';

    public static $belongs_to = [
        ['project'],
    ];

}