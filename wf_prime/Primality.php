<?php
/*-----------------------------------------------------------
Class: Primality.php
Author: Gbenga Ojo <gbenga@lucidmediaconcepts.com>
Origin Date: August 6, 2015

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
      // input sanitization
      if (!is_numeric($candidate))
         throw new Exception('input sanitization error');
      
      // trivial exception handling
      try {
         // Eratosthenes' Sieve
         $candidate_sqrt = ceil(sqrt($candidate));

         for ($i = 2; $i <= $candidate_sqrt; $i++) {
            if (! $isComposite[$i]) {
               $primes[] = $i;
               for ($j = $i * $i; $j <= $candidate; $j += $i)
                  $isComposite[$j] = true;
            }
         }
         for ($i = $candidate_sqrt; $i <= $candidate; $i++) {
            if (! $isComposite[$i])
               $primes[] = $i;
         }
      } catch (Exception $e) {
         echo "error";
      }

      // echo '<pre>'; print_r($primes); echo '</pre>';

      if (in_array($candidate, $primes))
         return true;

      return false;
   }

   /**
    * db manipulation example -- just executing arbitrary SQL
    * to retrieve user data and echoing results
    */
   public function db() {
      global $wpdb;
      $query = "SELECT * FROM wp_users";
      $result = $wpdb->get_results($query);

      echo '<h3>Trivial DB Manipulation to retrieve user data</h3>';
      echo '<pre>';
      print_r($result);
      echo '</pre>';
   }
}
