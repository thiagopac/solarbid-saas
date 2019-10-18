<?php

class PricingTable extends ActiveRecord\Model{

    static $table_name = 'pricing_table';

    public static $belongs_to = [
     ['company'],
     ['pricing_schema', 'foreign_key' => 'schema_id'],
  ];

    public static $has_many = [
    ['pricing_record'],
    ];

//    public static function newTicketCount($userId, $comp_array)
//    {
//        $filter = '';
//        if ($comp_array != false) {
//            $comp_array = ($comp_array == '') ? 0 : $comp_array;
//            $filter = "(user_id = $userId OR company_id in (" . $comp_array . ')) AND ';
//        }
//
//        $ticketCount = Ticket::count(
//                ['conditions' => $filter . "status = 'New'"]
//            );
//        return $ticketCount;
//    }
//
//    public function getLastArticle()
//    {
//        $article = end($this->ticket_article);
//        return $article;
//    }
}