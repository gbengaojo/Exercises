<?php

echo '<pre>';

$a = 1;
$b = &$a;
echo "b1: " . $b . "\n";

$b = "2$b";

echo $a . "\n";
echo $b . "\n";
