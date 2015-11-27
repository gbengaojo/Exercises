<?php

function solution($N, $A) {
   // init $N
   $init_n = $N;
   $N = array();

   for ($i = 0; $i < $init_n; $i++)
      $N[] = 0;

   for ($i = 0; $i < count($A); $i++) {
      if ($A[$i] >= 1 && $A[$i] <= $init_n) {
         $N[$A[$i] - 1] += 1;
      } else if ($A[$i] == $init_n + 1) {
         $max = max($N);
         for ($j = 0; $j < count($N); $j++) {
            $N[$j] = $max;
         }
      }
   }

   return $N;
}


$solution = solution(5, array(3, 4, 4, 6, 1, 4, 4));
