<?php
// PHP implementation of Python Dynamic Coin Changing

function dynamic_coin_changing($C, $k) {
   $n = count($C);

   // create two-dimensional array with all zeros
   for ($i = 0; $i <= $n; $i++) {
      for ($j = 0; $j <= $k; $j++) {
         $dp[$i][$j] = 0;
      }
   }

   // set first row of "infinite" values (see documentation)
   for ($j = 1; $j <= $k; $j++)
      $dp[0][$j] = 1000;


   // calculate sub-problem solutions for remainder of table
   for ($i = 1; $i <= $n; $i++) {
      for ($j = 0; $j <= $C[$i - 1]; $j++)
         $dp[$i][$j] = $dp[$i - 1][$j];
      for ($j = $C[$i - 1]; $j <= $k; $j++)
         $dp[$i][$j] = min($dp[$i][$j - $C[$i - 1]] + 1, $dp[$i - 1][$j]);
   }


   print_r($dp);
}

dynamic_coin_changing(array(1, 3, 4), 6);
