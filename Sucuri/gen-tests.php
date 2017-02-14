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
      
      
/**
 * generate a (pseudo) random string
 *
 * note that these values are extremely  pseudo-random; i.e., there
 * will be noticeable repitition. However, values should be
 * sufficiently randomized for the challenge purposes
 *
 * @param: (string) keyspace
 * @return: (string)
 */
function random_str($keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=./\|{}[]";') {
   $str = '';
   $max = mb_strlen($keyspace, '8bit') - 1;

   for ($i = 0; $i < mt_rand(1, 100); ++$i) {
      $str .= $keyspace[mt_rand(0, $max)];
   }

   return $str;
}

/**
 * generates a (pseudo) random timestamp, with boundary possibilities
 *
 * @return: (int)
 */
function random_timestamp() {
   $time[] = time() + mt_rand(0, 3000) * mt_rand(0, 365) * 24 * 3600; // 3000 years from now
   $time[] = 0;
   $time[] = -1;
   return $time[mt_rand(0, sizeof($time) - 1)];
}

/**
 * generates a (pseudo) random integer with boundary possibilities
 *
 * @return: (int)
 */
function random_int() {
   $rand_val[] = random_str('0123456789');
   $rand_val[] = 0;
   $rand_val[] = -1;
   $rand_val[] = "";
   return (int) $rand_str[mt_rand(0, sizeof($rand_str) - 1)];
}

/**
 * generate pseudo random groupId
 *
 * @return (string)
 */
function random_groupId() {
   $groupId[] = 'foo';
   $groupId[] = 'bar';
   $groupId[] = 'fizz';
   $groupId[] = 'buzz';
   $groupId[] = random_str();
   $groupId[] = "";
}
   

for ($i = 0; $i < 20; ++$i) {
    echo "++++++++++++++++++++++\n";
    echo "test_type: $test_type" . "; random_timestamp: " . random_timestamp() . "; random_int: " . random_int() . "\n";
}
