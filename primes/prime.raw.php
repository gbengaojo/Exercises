<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function prime() {
   // this will be our brute force attach, testing numbers that
   // begin and end with 3 for primality, and selecting the 333rd
   // one found.

   // we can assume that 3 is not included, based on the reqs

   // candidate #s will be of the following form:
   /*
   303, 313, ... 383, 393
   3003, 3013, ... 3983, 3993
   .
   .
   3n3; where n is any valid integer
   */

   $count = 0;

   // first, construct the first set of candidates
   $candidates[] = 33;
   for ($e = 1; $e <= 4; $e++) {
       for ($i = 0; $i < pow(10, $e); $i++) {
          $sub = sprintf("%0{$e}d", $i);
          $candidates[] = intval("3{$sub}3");
       }
   }

   // test for primality
   foreach ($candidates as $candidate) {
      $prime = true;
      for ($i = 2; $i < ceil(sqrt($candidate)); $i++) {
         if ($candidate % $i == 0) {
            // not prime
            $prime = false;
            continue;
         }
      }

      // assign primes to array and retrieve the
      // 333rd value
      if ($prime) {
         $primes[] = $candidate;
         if (count($primes) >= 333)
         break;
      }
   }
            
   echo "<pre>";
   echo "primes:\n"; print_r($primes);
   echo "candidates:\n"; print_r($candidates);
   echo $count;
}

prime();
