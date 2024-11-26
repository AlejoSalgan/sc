<?php

include("mysql_dev.php"); 

if (!$_GET["p"]) {
  echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
  exit; 
}

$idprot = $_GET['p'];

$consulta = "SELECT EN.imagen1, EN.imagen2, EN.imagen3, EN.imagen4, EN.imagen_zoom, EN.id as identrada, EN.dominio as dominio_edicion, EN.dominio as dominio_final, EN.estado, EN.serie, EN.idprotocolo,EN.infraccion  
             FROM entrada AS EN
             WHERE EN.estado = 26 AND EN.idprotocolo = ".$idprot;
             
// Ejecutar la consulta
$resultado = $mysqli->query($consulta);

$imagenes=null;

while($row = $resultado->fetch_object() ) { 
  $row->estado = 26;
  $imagenes[] = $row;
}

if (!$imagenes) {
  return NULL;
}else{
  echo json_encode($imagenes);
}

exit();


?>
