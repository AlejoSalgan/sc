<?php

include("mysql_locahost.php"); 

if (!$_GET["p"]) {
	echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
	exit; 
}



$idprotocolo = $_GET['p'];
$registros = $_GET['r'];

$resultado = FALSE;

foreach($registros as $registro){


	$identrada = $registro["identrada"];
	 
	$sql_identrada = "UPDATE entrada SET estado = 27 WHERE id = $identrada AND idprotocolo = $idprotocolo";
	
	$resultado_query = $mysqli->query($sql_identrada);

	if($resultado_query){
		$resultado = TRUE;
	}

}

echo $resultado;

?>
