<?php
/*-----------------------------------------------------------
Class: Dog
Author: Gbenga Ojo <service@lucidmediaconcepts.com>
Origin Date: December 9, 2014
Modified: December 9, 2014

construct
string getName()
array getNames()
int getAge()
string getFavoriteFood()
int getAverageNameLength()
void setName(string)
void setAge(int)
void setFavoriteFood(string)
void speak(string)
------------------------------------------------------------*/

class Dog {
   protected $name;
   protected $age;
   protected $favoriteFood;
   protected $names; // an array of all names

   /**
    * construct
    */
   public function __construct($name = null) {
      $age = rand(5,10);
      $this->name         = $name;
      $this->age          = $age;
      $this->favoriteFood = null;

      // track initial name
      $this->names[] = $name;
   }

   /**
    * get the name of this dog
    *
    * @return: (string) name
    */
   public function getName() {
      return $this->name;
   }

   /**
    * get a list of all the dog's names
    *
    * @return: (array) names
    */
   public function getNames() {
      return $this->names;
   }

   /**
    * get the age of this dog
    *
    * @return: (int) age
    */
   public function getAge() {
      return $this->age;
   }

   /**
    * get this dog's favorite food
    *
    * @return: (string) favoriteFood
    */
   public function getFavoriteFood() {
      return $this->favoriteFood;
   }

   /**
    * get the average length of all the dog's
    *    names
    *
    * @return: (int) average
    */
   public function getAverageNameLength() {
      $length = 0;
      foreach ($this->names as $name) {
         $length += strlen($name);
      }

      // get average
      if ($length > 0) {
         $average = $length / count($this->names);
         return $average;
      }

      return 0;
   }

   /**
    * dummy function used to check persistence in
    *    step 2d, Part 2
    */
   public function getId() {
      return 0;
   }

   /**
    * set this dog's name
    *
    * @param: (string) newName
    * @return: (bool)
    */
   public function setName($newName) {
      if (!is_string($newName))
         return false;

      $this->name = $newName;

      // track subsequent names
      $this->names[] = $newName;

      return true;
   }

   /**
    * set this dog's age
    *
    * @param: (int) age
    * @return: (bool)
    */
   public function setAge($newAge) {
      if (!is_numeric($newAge))
         return false;

      $this->age = $newAge;

      return true;
   }

   /**
    * set dog's favorite food
    *
    * @param: (string) newFavoriteFood
    * @return: (bool)
    */
   public function setFavoriteFood($newFavoriteFood) {
      if (!is_string($newFavoriteFood))
         return false;

      $this->favoriteFood = $newFavoriteFood;
      return true;
   }

   /**
    * make the dog speak
    */
   public function speak($speech = "woof") {
      echo "$speech\n";
      $this->age += 1; // increae age every
                       // dog speaks
   }
}
