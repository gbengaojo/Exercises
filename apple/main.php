<?php

require "Cat.php";
require "Data.php";

$cat = new Cat();
echo "Name is currently " . $cat->getName() . "\n";
$cat->setName("Garfield");
echo "Name has been changed to " . $cat->getName() . "\n";
$data = new Data("database");
$data->insert("Cat", $cat);

// speak; default "meow", then use arg
$cat->speak();
$cat->speak("purr");

// add same names to keep track of
$cat->setName("Charlie");
$cat->setName("Brown");

// print those names
print_r($cat->getNames());

// check the average name length
echo "Average name length is " . $cat->getAverageNameLength() . "\n";
