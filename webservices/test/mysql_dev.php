<?php

$server='192.168.3.233';
$db='scdev';
$user='scdev';
$pass='8ryYddjSngmJR4CX';

$mysqli = new mysqli($server, $user, $pass, $db);

if ($mysqli->connect_errno) {
 echo "Lo sentimos, SSTI está experimentando problemas de conexión.";
 exit;
} 

?>