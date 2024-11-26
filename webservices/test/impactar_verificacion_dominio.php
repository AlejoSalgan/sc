<?php

include("mysql_dev.php"); 

if (!$_GET["p"]) {
	echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
	exit; 
}
  
$idprotocolo = $_GET['p'];
$registros = $_GET['r'];

$resultado = FALSE;

foreach($registros as $registro){


	$identrada = $registro["identrada"];
	 
	$dominio = $registro["dominio_final"];

	$sql_identrada = "UPDATE entrada SET dominio = '$dominio' WHERE id = $identrada AND idprotocolo = $idprotocolo";
	
	$resultado_query = $mysqli->query($sql_identrada);

	if($resultado_query){
		$resultado = TRUE;
	}

}

echo $resultado;

?>
