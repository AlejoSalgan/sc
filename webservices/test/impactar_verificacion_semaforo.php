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
	 
	
	if($registro["infraccion"] == "99") {
		$infraccion =  "Invasion Senda Peatonal";	
	}else{
		$infraccion =   "Cruce Semaforo en Luz Roja";	
	}

	$sql_identrada = "UPDATE entrada SET infraccion = '$infraccion' WHERE id = $identrada AND idprotocolo = $idprotocolo";
	
	$resultado_query = $mysqli->query($sql_identrada);

	if($resultado_query){
		$resultado = TRUE;
	}

}

echo $resultado;

?>
