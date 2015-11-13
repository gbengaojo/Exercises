<?php
include 'init.php';

// check if winner table is empty - if not, there was no tie, and the winner was already declared
/* executing in heartbeat now
$query = "SELECT COUNT(*) FROM winner";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if ($row[0] != 0) {
   echo "NO TIES - TABLE NOT EMPTY - WINNER ALREADY DECLARED\n\n";
   die;
} */

$query = "SELECT game_id FROM game WHERE active = 1 LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$game_id = $row['game_id'];
$scores = array();
$existing = array();

$query = "SELECT * FROM player";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
   $scores[] = $row['score'];
}

print_r($scores);

if (count($scores) <= 0) {
   exit("exiting...\n");
}

$maxscore = max($scores);

echo "\nSCORES: ";
print_r($scores);
echo "\n\nmax: " . max($scores) . "\n";

$query = "SELECT user_id, score FROM player WHERE score = $maxscore";
$result = mysql_query($query);
echo "\n$query\n";

while ($row = mysql_fetch_assoc($result)) {
   echo "\nINSERTING USER " . $row['user_id'] . "\n";
   $winner_user_id = $row['user_id'];
   $score          = $row['score'];

   // don't enter duplicates
   $query = "SELECT user_id FROM winner";
   $result1 = mysql_query($query);

   while ($row1 = mysql_fetch_assoc($result1)) {
      $existing[] = $row1['user_id'];
   }

   // check if duplicate - update if so
   if (!in_array($winner_user_id, $existing)) {
      // enter new highest score as winner
      $query = "INSERT INTO winner (user_id, game_id, score) VALUES ($winner_user_id, $game_id, $score)";
   } else {
      $query = "UPDATE winner SET score = $score WHERE user_id = $winner_user_id";
   }
   mysql_query($query);
echo "$query\n";

   // delete any score below highest
   $query = "DELETE FROM winner WHERE `score` < $maxscore";
   mysql_query($query);
echo "$query\n";
}
