#!/usr/bin/php5
<?php
/*
   +----------------------------------------------------------------------+
   | gen-tests.php                                                        |
   +----------------------------------------------------------------------+
   | Generates a series of test CSV files for the Sucuri Challenge        |
   +----------------------------------------------------------------------+
   | Author: Gbenga Ojo <gbenga.a.ojo@gmail.com>                          |
   | Origin Date: Feb 13, 2017                                            | 
   +----------------------------------------------------------------------+
 */

$usage_msg = <<<EOT

Usage:
gen-tests.php TYPE
   TYPEs:
   -c, --common:
      generates a CSV file holding common values
   -f, --fringe:
      generates a CSV file holding fringe cases


EOT;

if (count($argv) <= 1) {
   printf($usage_msg);
   exit(0);
}

$prog_name = array_shift($argv);

while (count($argv) > 0) {
   $arg = array_shift($argv);

   if (preg_match('/^-[h|\?]/', $arg)) {
      print($usage_msg);
      exit(0);
   }

   elseif (preg_match('/^-c|^--common/', $arg)) {
      $test_type = "common";
   } elseif (preg_match('/^-f|^--fringe/', $arg)) {
      $test_type = "fringe";
   } else {
      print($usage_msg);
      exit(0);
   }
      
}

// based on switch (--common or --fringe), generate CSV strings
// and write to file 'test-$test_type.csv'

function generateCSV($test_type) {
   if ($test_type == 'common') {
   }

   if ($test_type == 'fringe') {
   }
}

/**
 * generate random edge case data
 */
function generateFringeData($datatype) {
   switch ($datatype) {
      case 'int' :

      break;

      case 'timestamp' :
         
      break;

      case 'float' :

      break;

      case 'string' :

      break;
   }
}
      
      
function random_str() {
   $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=./\|{}[]";';
   $str = '';
   $max = mb_strlen($keyspace, '8bit') - 1;

   for ($i = 0; $i < mt_rand(1, 100); ++$i) {
      $str .= $keyspace[mt_rand(0, $max)];
   }

   return $str;
}

function random_timestamp() {
   $time[] = time() + mt_rand(0, 30) * mt_rand(0, 365) * 24 * 3600;
   $time[] = 0;
   $time[] = -1;
   $time[] = pow(10, 100000000);
   return $time[mt_rand(0, sizeof($time) - 1)];
}




echo "test_type: $test_type\n";
echo random_timestamp() . "\n";
