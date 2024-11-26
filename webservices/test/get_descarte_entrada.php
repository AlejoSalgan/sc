<?php


include("mysql_dev.php"); 

if (!$_GET["p"]) {
  echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
  exit; 
}


$idprot = $_GET['p'];



$consulta = "SELECT  EN.id as identrada
             FROM entrada AS EN
             WHERE EN.estado = 27 AND EN.idprotocolo = ".$idprot." LIMIT 5";


// Ejecutar la consulta
$resultado = $mysqli->query($consulta);

// var_dump($resultado->fetch_object());die;

while($row = $resultado->fetch_object() ) { 
  $imagenes[] = $row;
}

if (!$imagenes) {
  echo "No hay registros en estado Aprobados (26). ";
  die;
}else{
  echo json_encode($imagenes);
  // echo $imagenes;
}

exit();


?>
