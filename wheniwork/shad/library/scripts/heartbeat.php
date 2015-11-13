<?php
include 'init.php';

echo "executing...\n\n";

// truncate winner table
$query = "TRUNCATE winner";
mysql_query($query);

$end = time() + 300; // 5 minutes

while (time() < $end) {
   shell_exec("php -e $path" . "tie_breaker.php");
   shell_exec("php -e $path" . "set_round.php");
   echo "heartbeat..." . date('Y-m-d H:i:s') . "...\n";
   usleep(200000); // execute very fast
//   sleep(1);
}

// get winner
shell_exec("php -e $path" . "get_winner.php");

// reset game
$query = "UPDATE game SET active = 0, tie_breaker = 0";
mysql_query($query);
