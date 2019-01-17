<?php
/*-----------------------------------------------------------
Class: News
Original Author: James U <james.u8582@gmail.com>
Modified By: Gbenga Ojo <gbenga.o@beplused.com>
Origin Date: June 1, 2012
Modified Date: June 4, 2012

News model
------------------------------------------------------------*/

class Application_Model_News
{
   protected $news_id;
   protected $network_id;
   protected $news_provider_id;
   protected $news_category_id;
   protected $link;
   protected $title;
   protected $content;
   protected $image;
   protected $date;

   private $db;
   private $valid_construct = true;

   /**
    * constructor
    */
   public function __construct($values = array()) {
      $this->db = Zend_Db_Table::getDefaultAdapter();

      // validate
      if (empty($values)) {
         $this->valid_construct = false;
         return;
      }

      if ($values['network_id'] == '' || $values['news_provider_id'] == '' ||
          $values['news_category_id'] = '' || $values['link']  == '' ||
          $values['title'] == '' || $values['news_id'] == '' ||
          $values['date'] == '') {
         $this->valid_construct = false;
         return;
      }

      if (!is_numeric($network_id) || !is_numeric($news_provider_id) ||
          !is_numeric($news_category_id) || (false)) {} // continue here
   }

   /**
    * write news to db
    */
   public function createNews() {}
}
