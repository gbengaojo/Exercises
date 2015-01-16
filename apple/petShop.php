<?php

require "Cat.php";
require "Dog.php";
require "Data.php";

// chose not to define $table and $data outside
// of their respective functions, as I generally
// try to avoid global variables. Could easily
// be implemented that way, and would consider
// doing so in a longer script

/**
* create a cat and dog with a name and save to db
*/
function saveTest() {
   $table = 'pet';
   $cat   = new Cat("Sarah");
   $dog   = new Dog("Rufus");
   $data  = new Data("database");

   // begin transaction, and write to db
   $data->beginTran();
   $data->insert($table, $cat);
   $data->insert($table, $dog);
   $data->commit();
}

/**
 * create three nameless cats and dogs and save to db
 */
function savePetShop() {
   $table = 'pet';
   $data  = new Data("database");

   for ($i = 0; $i < 3; $i++) {
      $cats[] = new Cat();
      $dogs[] = new Dog();
   }

   // begin transaction and commit
   $data->beginTran();
   for ($i = 0; $i < 3; $i++) {
      // insert cat and check persistence
      $data->insert($table, $cats[$i]);

      // See Data::isPersisted() for implementation --
      // check for persistence *note*, will always test false
      // as there is no actual database to test against.
      if ($data->isPersisted($table, $cats[$i]))
         echo "Data persisted";
      else
         echo "Data not persisted\n";

      // insert dog and check persistence
      $data->insert($table, $dogs[$i]);

      if ($data->isPersisted($table, $cats[$i]))
         echo "Data persisted";
      else
         echo "Data not persisted\n";
   }
   $data->commit();
}

/**
 * log script execution information
 */
function logUsage() {
   $usage = getrusage();
   echo "Logging data...\n";
   echo "number of swaps: " . $usage["ru_nswap"] . "\n";
   echo "number of page faults: " . $usage["ru_majflt"] . "\n";
   echo "time used (secs): " . $usage["ru_utime.tv_sec"] . "\n";
   echo "time used (microseconds): " . $usage["ru_utime.tv_usec"] . "\n";
}

saveTest();
echo "\n"; // entering some whitespace to output
savePetShop();
echo "\n"; // whitespace...
logUsage();
