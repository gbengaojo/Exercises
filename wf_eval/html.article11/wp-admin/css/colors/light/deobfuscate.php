<?php
/*------------------------------------------------------------------------------
Class: DeObfuscate
Author: Gbenga Ojo
Origin Date: May 15, 2016
Modified:
------------------------------------------------------------------------------*/

class DeObfuscate {
   protected $cyphertext;
   protected $cypherhash;
   protected $plaintext;

   /**
    * construct
    *
    * @param: (string) $filename
    * @param: (array) $cyberhash
    * @throws:
    */
   public function __construct($filename, $cypherhash) {
      $this->cyphertext = file_get_contents($filename);
      $this->cypherhash = $cypherhash;   

      $this->decode();

      // echo $this->cyphertext;
   }

   /**
    * rudimentary deobfuscation
    *
    * @throws:
    * @return: (string) partially deobfuscated code
    */
   public function decode() {
      $decoded = $this->cypherhash;
      $pattern = '/\$(GLOBALS\[\'hec78724\'\])\[(\d+)\]\.*/';
      $replacement = '~$2~';

      $plaintext = preg_replace($pattern, $replacement, $this->cyphertext);

      for ($i = 0; $i <= 98; $i++) {
         $arr[$i] = "/~$i~/";
      }

      $this->plaintext = $output = preg_replace($arr, $decoded, $plaintext);
      return $output;
   }
}

$cypherhash[0] = "J";
$cypherhash[1] = "4";
$cypherhash[2] = "_";
$cypherhash[3] = "(";
$cypherhash[4] = "Y";
$cypherhash[5] = "*";
$cypherhash[6] = "2";
$cypherhash[7] = ")";
$cypherhash[8] = "}";
$cypherhash[9] = "e";
$cypherhash[10] = ";";
$cypherhash[11] = "L";
$cypherhash[12] = "P";
$cypherhash[13] = "";
$cypherhash[14] = "?";
$cypherhash[15] = "C";
$cypherhash[16] = "+";
$cypherhash[17] = "S";
$cypherhash[18] = ":";
$cypherhash[19] = "H";
$cypherhash[20] = "U";
$cypherhash[21] = "7";
$cypherhash[22] = "r";
$cypherhash[23] = "I";
$cypherhash[24] = "y";
$cypherhash[25] = "V";
$cypherhash[26] = "f";
$cypherhash[27] = "@";
$cypherhash[28] = "R";
$cypherhash[29] = "v";
$cypherhash[30] = " ";
$cypherhash[31] = "A";
$cypherhash[32] = "b";
$cypherhash[33] = ">";
$cypherhash[34] = "~";
$cypherhash[35] = "\\";
$cypherhash[36] = "z";
$cypherhash[37] = "/";
$cypherhash[38] = "|";
$cypherhash[39] = "Q";
$cypherhash[40] = "g";
$cypherhash[41] = "1";
$cypherhash[42] = "B";
$cypherhash[43] = "T";
$cypherhash[44] = "s";
$cypherhash[45] = "&";
$cypherhash[46] = "#";
$cypherhash[47] = "F";
$cypherhash[48] = "!";
$cypherhash[49] = "a";
$cypherhash[50] = "X";
$cypherhash[51] = "h";
$cypherhash[52] = "=";
$cypherhash[53] = "q";
$cypherhash[54] = "i";
$cypherhash[55] = "-";
$cypherhash[56] = "9";
$cypherhash[57] = "x";
$cypherhash[58] = "k";
$cypherhash[59] = "3";
$cypherhash[60] = "D";
$cypherhash[61] = "W";
$cypherhash[62] = "8";
$cypherhash[63] = "c";
$cypherhash[64] = "M";
$cypherhash[65] = "Z";
$cypherhash[66] = "t";
$cypherhash[67] = ".";
$cypherhash[68] = "]";
$cypherhash[69] = "o";
$cypherhash[70] = "";
$cypherhash[71] = "K";
$cypherhash[72] = "n";
$cypherhash[73] = "N";
$cypherhash[74] = "<";
$cypherhash[75] = " ";
$cypherhash[76] = "5";
$cypherhash[77] = "u";
$cypherhash[78] = "0";
$cypherhash[79] = "l";
$cypherhash[80] = '"';
$cypherhash[81] = "[";
$cypherhash[82] = "O";
$cypherhash[83] = "$";
$cypherhash[84] = "^";
$cypherhash[85] = "d";
$cypherhash[86] = "j";
$cypherhash[87] = "\"";
$cypherhash[88] = "w";
$cypherhash[89] = "`";
$cypherhash[90] = "m";
$cypherhash[91] = "p";
$cypherhash[92] = "%";
$cypherhash[93] = "6";
$cypherhash[94] = "{";
$cypherhash[95] = "G";
$cypherhash[96] = "E";
$cypherhash[97] = ",";
$deo = new DeObfuscate("article11.php", $cypherhash);
