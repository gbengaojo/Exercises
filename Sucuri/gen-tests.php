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
gen-tests.php
   Options:
   -c: generates a CSV file holding common values
   -f: generates a CSV file holding fringe cases


EOT;

if (count($argv) <= 1) {
   printf($usage_msg);
   exit(0);
}

$prog_name = array_shift($argv);

while (count($argv) > 0) {
   $arg = array_shift($argv);

   if (preg_match('/^-[h|\-help|\?]/', $arg)) {
      print($usage_msg);
      exit(0);
   }

   elseif (preg_match('/^[\-c|\-\-common]/', $arg))
      $test_type = "common";
   elseif (preg_match('/^[\-f|\-\-fringe]/', $arg))
      $test_type = "fringe";
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
