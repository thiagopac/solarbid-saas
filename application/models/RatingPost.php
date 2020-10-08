<?php

class RatingPost extends ActiveRecord\Model {

    static $table_name = 'rating_post';

    public static $belongs_to = [
        ['company']
    ];

}
