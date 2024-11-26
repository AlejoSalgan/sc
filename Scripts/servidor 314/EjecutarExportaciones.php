<?php

	include_once("/home/lprats/helpers.php"); 
	insert_log_scdev(__FILE__, get_defined_vars());

	$cmd="ls /mnt/Expo -1 | grep EnProceso";
	$lineas=explode("\n", shell_exec($cmd));
	//ejemplo Expo84-EnProceso-27698

	function customSort($a, $b) {
		// Verificar si alguno de los datos es vacío
		if (empty($a) || empty($b)) {
			// Si $a es vacío, colocar $b primero
			if (empty($a)) return 1;
			// Si $b es vacío, colocar $a primero
			if (empty($b)) return -1;
		}

		// Extraer números después de "Expo"
		preg_match('/Expo(\d+)/', $a, $matchesA);
		preg_match('/Expo(\d+)/', $b, $matchesB);

		// Verificar si se encontraron coincidencias
		if (empty($matchesA) || empty($matchesB)) {
			// Si no se encontró coincidencia en alguna de las cadenas, no se puede comparar
			return 0;
		}

		// Extraer los números encontrados
		$numberA = intval($matchesA[1]);
		$numberB = intval($matchesB[1]);

		// Comparar los números
		if ($numberA == $numberB) {
			return 0;
		}
		return ($numberA < $numberB) ? -1 : 1;
	}
	// Ordenar el array usando la función de comparación personalizada
	
	usort($lineas, "customSort");
	//var_dump($lineas);die;
	foreach ($lineas as $linea) {
		if (strlen($linea)>0) {
			$partes=explode("-", $linea);
			if (count($partes)==3) {
				if ($partes[1]=="EnProceso") {
					if ($partes[2]>0) {
						if (substr($partes[0],0,4)=="Expo") {
							$proyecto=substr($partes[0],4);
							$exportacion=$partes[2];

							echo "Proyecto " . $proyecto . " ";
							echo "Exportacion " . $exportacion . "\n"; 
							echo "\n";
							

							if ($proyecto<>7 && $proyecto<>9) {
								$proyecto=str_pad($proyecto,3,"0",STR_PAD_LEFT);
								//$cmd="screen -S Expo" . $proyecto . "-" . $exportacion . " -d -m php ProcExp.php " . $exportacion . " Expo" . $proyecto . "-" . $exportacion . " " . $proyecto;
								$cmd = "php ProcExp.php " . $exportacion . " Expo" . $proyecto . "-" . $exportacion . " " . $proyecto;
								passthru($cmd);
							}
							if ($proyecto==7 || $proyecto==9) { 
							    $proyecto=str_pad($proyecto,3,"0",STR_PAD_LEFT);
							    //$cmd="screen -S Expo" . $proyecto . "CABA-" . $exportacion . " -d -m php /home/municipios/ScriptsCABA/ProcesarExportacionCABA.php " . $exportacion;
							    $cmd = "php /home/municipios/ScriptsCABA/ProcesarExportacionCABA.php " . $exportacion;
							    passthru($cmd);
							}
						
						} 
					}
				}
			}
		}
	}

?>
