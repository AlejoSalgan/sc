<?php

$mysqli = new mysqli("localhost", "root", "", "cias");

if ($mysqli->connect_errno) {
    echo "Lo sentimos, SSTI está experimentando problemas de conexión.";
    exit;
}

?>