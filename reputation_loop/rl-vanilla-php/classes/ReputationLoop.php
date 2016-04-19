<?php
/*-----------------------------------------------------------
Class: ReputationLoop
Author: Gbenga Ojo <gbenga@lucidmediaconcepts.com>
Origin Date: October 8, 2015
Modified: April 18, 2016

(null) construct()
(obj) rlAPI(string)
------------------------------------------------------------*/

class ReputationLoop
{
   /**
    * construct
    */
   public function __construct() {
   }

   /**
    * call API
    *
    * @param: (string) $url
    * @throws: ..
    * @return: (Object) the object to be used in the simple view (we're not using
    *    a classic MVC for this challenge, but will instead pass the object to 
    *    the "view", and obtain required data there for display. No getter/setter
    *    methods should be needed. The $url param will be passed in the URL
    *    called by the user; i.e., the test URL provided.
    */
   public function rlAPI($url) {
      // API call
      // get response
      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $url);  
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

      $response = curl_exec($curl);
      curl_close($curl);

      return $response;
   }
}

$rl  = new ReputationLoop();
$url = "http://test.localfeedbackloop.com/api?apiKey=61067f81f8cf7e4a1f673cd230216112&noOfReviews=10&internal=1&yelp=1&google=1&offset=50&threshold=1"; 
$rl_response   = json_decode($rl->rlAPI($url));
$business_info = $rl_response->business_info;
$reviews       = $rl_response->reviews;
