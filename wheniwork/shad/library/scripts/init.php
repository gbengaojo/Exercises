<?php
@include '../../application/configs/config.php';

if ($_SERVER['USER'] == 'gbenga') {
   mysql_connect('localhost', '', '');
   mysql_select_db('shadowandactfilms');
   $path = '/home/gbenga/dev/shadowandactfilms/www/shad/library/scripts/';
} else {
   mysql_connect('localhost', '', '');
   mysql_select_db('shadowandactfilms');
   $path = '/home/orion/shadowandactfilms/library/scripts/';
}

$query = "SELECT game_id FROM game WHERE active = 1 LIMIT 1";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$game_id = $row['game_id'];
