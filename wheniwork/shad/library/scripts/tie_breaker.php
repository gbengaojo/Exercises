<?php
include 'init.php';

$query = "SELECT * FROM player";
$result = mysql_query($query);

$scores = array();

while ($row = mysql_fetch_assoc($result)) {
   $scores[] = $row['score'];
}

// exit if no score data
if (count($scores) <= 0 ) {
   exit(0);
}

$maxscore = max($scores);

print_r($scores);
echo "\n\n";
echo "max: " . max($scores) . "\n";


$query = "SELECT user_id FROM player WHERE score = $maxscore";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
   $tie_breakers[] = $row['user_id'];
}

if (count($tie_breakers) > 1) {
   echo "\ntie scenario...\n";
   $query = "UPDATE game SET tie_breaker = 1 WHERE game_id = $game_id";
   mysql_query($query);
} else {
   // turn tie-breaker mode off
   echo "\nnon-tie scenario...\n";
   $query = "UPDATE game SET tie_breaker = 0";
   mysql_query($query);
}
