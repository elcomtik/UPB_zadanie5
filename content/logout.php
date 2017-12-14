<?php
//zrusime session
$_SESSION = array();
session_destroy();
//header("LOCATION: ".$_GET['go_page']);
header("LOCATION: http://192.168.56.102/udpb/www-vulnerable/index.php");
?>

