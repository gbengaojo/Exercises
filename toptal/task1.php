<?php

function solution($X, $A) {
   $mark = array();

   for ($i = 0; $i < count($A); $i++) {
      if ($A[$i] == $X)
         $mark[$i] = 1;
      else
         $mark[$i] = -1;
   }


   // find $i such that sum = 0 on both sides
   for ($i = 0; $i < count($mark); $i++) {
      $sum_l = array_sum(array_slice($mark, 0, $i));
      $sum_r = array_sum(array_slice($mark, $i + 1));

      for ($j = 0; $j < $i; $j++)
         $sum_l += $mark[$j];

      for ($k = $i + 1; $k < count($mark); $k++)
         $sum_r += $mark[$k];

echo "i=$i ==> l=$sum_l ,r=$sum_r\n";


      if ($sum_l == 0 && $sum_r == 0) {
         // return $i; 
      }
   }

}





// $solution = solution(5, array(5, 5, 1, 7, 2, 3, 5));
$solution = solution(5, array(5, 5, 5, 1, 7, 2, 3, 4, 5));

echo "solution: $solution\n";
