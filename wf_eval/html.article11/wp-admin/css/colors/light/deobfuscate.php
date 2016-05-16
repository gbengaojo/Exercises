<?php
/*------------------------------------------------------------------------------
Class: DeObfuscate
Author: Gbenga Ojo
Origin Date: May 15, 2016
Modified:
------------------------------------------------------------------------------*/

class DeObfuscate {
   protected $cyphertext;
   protected $cypherhash;
   protected $plaintext;

   /**
    * construct
    *
    * @param: (string) $filename
    * @param: (array) $cyberhash
    * @throws:
    */
   public function __construct($filename, $cypherhash) {
      $this->cyphertext = file_get_contents($filename);
      $this->cypherhash = $cypherhash;   

      $this->decode();

      // echo $this->cyphertext;
   }

   /**
    *
    */
   public function decode() {
      $decoded = $this->cypherhash;
      $pattern = '/\$(GLOBALS\[\'hec78724\'\])\[(\d+)\]\.*/';
      $replacement = '$decoded[$2]';


      $plaintext = preg_replace($pattern, $replacement, $this->cyphertext);
      
      echo $plaintext;
   }
}

$deo = new DeObfuscate('article11.php', array());
