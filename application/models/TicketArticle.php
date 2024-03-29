<?php

class TicketArticle extends ActiveRecord\Model
{
    public static $table_name = 'ticket_article';

    public static $has_many = [
        ['article_attachment', 'foreign_key' => 'article_id']
    ];

    public static $belongs_to = [
        ['ticket'],
        ['user'],
        ['client', 'foreign_key' => 'email', 'primary_key' => 'from'],
    ];
}