<?php


function solution($n) {
   $binary_n = decbin($n) . "\n";
   $binary_arr = array_map('intval', str_split($binary_n));
   print_r($binary_arr);

   $max_binary_gap = 0;
   $current_binary_gap = 0;

   if (!in_array('1', $binary_arr))
      return 0;

   if (!in_array('0', $binary_arr))
      return 0;

   for ($i = 0; $i < count($binary_arr); $i++) {
   }
}



$stdin = fopen('php://stdin', 'r');
$n = trim(fgets(STDIN));
solution($n);


// 1000001001000000001     gap = 8
// 000010001               gap = 3
// 1001000000              gap = 2
// 11111000111111          gap = 3
// 000001111100000         gap = 0
// 0000                    gap = 0
// 1111                    gap = 0
