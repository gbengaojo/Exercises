<?php
include 'init.php';

$round = -1;

// get round times
$query  = "SELECT `start`, `tie1`, `tie2`, `tie3`, `round` FROM game WHERE game_id = $game_id";
$result = mysql_query($query);
$state  = mysql_fetch_assoc($result); // game state

$start = strtotime($state['start']);
$end   = $start + GAME_DURATION;
$tie1  = strtotime($state['tie1']);
$tie2  = strtotime($state['tie2']);
$tie3  = strtotime($state['tie3']);

print_r($state);
echo "\ntime: " . time();

if (($start <= time()) && (time() <= $end)) {
   $round = ROUND_INIT;
} else if (($end < time()) && (time() <= $tie1)) {
   $round = ROUND_TIE_ONE;
} else if (($tie1 < time()) && (time() <= $tie2)) {
   $round = ROUND_TIE_TWO;
} else if (($tie2 < time()) && (time() <= $tie3)) {
   $round = ROUND_TIE_THREE;
}

// set game round
echo "\nUpdating game round...\n";
$query = "UPDATE game SET `round` = $round WHERE game_id = $game_id";
mysql_query($query);
