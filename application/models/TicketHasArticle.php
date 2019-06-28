<?php

class TicketHasArticle extends ActiveRecord\Model
{
    public static $table_name = 'ticket_has_articles';

    public static $has_many = [
        ['article_has_attachments', 'foreign_key' => 'article_id']
    ];

    public static $belongs_to = [
        ['ticket'],
        ['user'],
        [
            'client',
            'foreign_key' => 'email',
            'primary_key' => 'from',
        ],
    ];
}