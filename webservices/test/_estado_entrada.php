<?php

include("mysql_dev.php"); 

if ($_GET["id"]) {
  $identrada = $_GET["id"];
} else {
  echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
  exit;
}

if ($_GET["e"]) {
  $estado = $_GET["e"];
} else {
  echo "Lo sentimos, SSTI está experimentando problemas de consultas.";
  exit;
}

$sql2 = "UPDATE entrada AS EN SET estado = $estado, idedicion = 0
WHERE id = $identrada";
$resultado = $mysqli->query($sql2);

if ($resultado) {
  $result = TRUE;
} else {
  $result = FALSE;
}

echo json_encode($result);
exit();
?>
