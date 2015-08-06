<?php
/*-----------------------------------------------------------
Class: Primality.php
Author: Gbenga Ojo <gbenga@lucidmediaconcepts.com>
Origin Date: August 6, 2015
Modified Date: August 6, 2015

A class to test for primality using the sieve of Eratosthenes
------------------------------------------------------------*/

class Primality
{
   /**
    * construct
    */
   public function __construct() {
   }

   /**
    * determine if a given # is prime
    *
    * @param: (int) candidate
    * @retrun: (bool) true if prime
    * @throws: (exception)
    */
   public function isPrime($candidate) {
      if (!is_numeric($candidate))
         throw Exception $e;

      $isComposite = array();

      try {
         int $candidate_sqrt = sqrt($candidate);

         for ($i = 2; $i <= $candidate_sqrt; $i++) {
            if (! $isComposite[$i]) {
               echo $i + " ";
               for ($j = $i * $i; $j <= $candidate; $j += $i)
                  $isComposite[$j] = true;
            }
         }
      } catch (Exception $e) {
         echo "error";
      }
   }
}
