<?php

include("mysql_dev.php"); 

if (!$_GET["p"]) {
	echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
	exit; 
}
  

$idprotocolo = $_GET['p'];


$sql_identrada = "UPDATE entrada SET estado = 26 WHERE protocolo = $idprotocolo AND estado in (0, 25)";
$resultado = $mysqli->query($sql_identrada);

if(!$resultado){
	print "el protocolo $idprotocolo no se actualizo";
	
}else{
	print "el protocolo $idprotocolo se actualizo";

}



?>
