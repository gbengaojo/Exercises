<?php

/* ----------------------------------------------------
Class to create arbitrary XML file.


construct()
setRoot()
void setAttribute(string, string)

------------------------------------------------------*/

class XMLElement
{
   public $name;
   public $value;
   public $attributes;
   public $children;

   public static $depth = 0;

   public function __construct($name, $value = null) {
      $this->name = $name;
      $this->value = $value;
   }

   public function newElement($name, $value = null) {
      $element = new XMLElement($name, $value);
      $this->children[] = $element;
      return $element;
   }

   public function addAttribute($key, $value) {
      $this->attributes[] = array($key => $value);
   }

   public function printXML() {
      
      echo "<" . $this->name;

      /**
       * if this element has attributes
       */
      if (is_array($this->attributes)) {
         foreach ($this->attributes as $attr) {
            echo " " . key($attr) . "='" . $attr[key($attr)] . "'";
         }
      }

      echo ">";

      /**
       * if this element has children
       */
      if (is_array($this->children)) {
         self::$siblings = count($this->children);
         self::$depth += 1;

         foreach ($this->children as $child) {
            echo "\n";
            for ($i = 0; $i < self::$depth; $i++)
               echo "\t";

            $child->printXML();
         }
      // if self::$depth > 0, but there ARE NO children, decrement
      }

      /**
       * if this element has a value
       */
      if (!empty($this->value)) {
         echo $this->value;
      }
      
      echo "</" . $this->name . ">";

      self::$siblings -= 1;
   }
}




$root = new XMLElement('people');
$person = $root->newElement('person');
$person->addAttribute('id', '2222');
$person->addAttribute('DOB', '1/1/1111');

$fname = $person->newElement('firstname', 'John');
$lname = $person->newElement('lastname', 'Smith');
$address = $person->newElement('address');

$street = $address->newElement('street', '123 some st');
$city = $address->newElement('city', 'Dallas');
$zip = $address->newElement('zip', '32223');
$state = $address->newElement('state', 'tx');

$root->printXML();

echo "\n\n\n";
