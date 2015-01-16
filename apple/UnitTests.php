<?php

require "Cat.php";

#1.
function testInitialAge() {
   $cat = new Cat();
   $age = $cat->getAge();

   // assertion
   if ($age < 5 || $age > 10 || !is_numeric($age))
      echo "The initial age is NOT between 5 and 10\n";
   else
      echo "The initial age IS between 5 and 10\n";
}

#2.
function testBirthName() {
   $cat = new Cat("name");
   $name = $cat->getName();

   // assertion
   if (!is_string($name) || empty($name))
      echo "A name was NOT given at birth\n";
   else
      echo "A name WAS given at birth\n";
}

#3.
function testSpeech() {
   $cat = new Cat();
   $previous_age = $cat->getAge();
   $speech = $cat->speak();
   $subsequent_age = $cat->getAge();

   // assertion
   if (!is_string($speech) || empty($speech))
      echo "Your cat did NOT speak. Bad kitty.\n";
   else
      echo "Your cat DID speak. Good kitty -- you get a fish biscuit.\n";

   // assertion
   if ($previous_age = $subsequent_age - 1)
      echo "Your cat aged a year\n";
   else
      echo "You cat didn't age at all!";
}

testInitialAge();
testBirthName();
testSpeech();
