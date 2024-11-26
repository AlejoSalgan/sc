#!/usr/bin/php
<?php
	
	include_once("/home/lprats/helpers.php"); 
	insert_log_scdev(__FILE__, get_defined_vars());

	if (!isset($argv[1]) || !$argv[1]>0) die("Codigo de Proyecto?(1)");
	if (!isset($argv[2]) || !$argv[2]>0) die("Exportacion?(2)");
	if (!isset($argv[3]) || !$argv[3]>0) die("Protocolo a Eliminar?(1)");
	
	if ($argv[1]==7) die("Solo para proyectos distintos a CABA\n");
	
	include("mysql.php");
	
	$codmunicipio="000";
	$municipio=str_pad($argv[1],3,"0",STR_PAD_LEFT);
	$envio="1";
	$idprotocolo=$argv[3];
	$idmunicipio=$argv[1];
	
	$query_expo="SELECT id FROM exportaciones_main WHERE municipio=" . $idmunicipio . " AND numero=" . $argv[2]; 
	$result_expo=mysql_query($query_expo);
	echo mysql_error(); 
	if (mysql_num_rows($result_expo)>0) {
		$row_expo=mysql_fetch_array($result_expo);
		
		$query_aux="SELECT id FROM exportaciones_aux WHERE idexportacion=" . $row_expo['id'] . " AND idprotocolo=" . $idprotocolo;
		$result_aux=mysql_query($query_aux);
		
		if (mysql_num_rows($result_aux)>0) {
			
		} else {
			die("El protocolo no esta incluido en la exportacion?\n");
		}
		
	} else {
		die("Protocolo/Exportacion NO Valida?");
	}
	
	$query_prot="SELECT id, equipo_serie, DATE_FORMAT(fecha,'%d%m%y') AS fecha FROM protocolos_main WHERE id=" . $idprotocolo; 
	$result_prot=mysql_query($query_prot);
	if (mysql_num_rows($result_prot)>0) {
		$row_prot=mysql_fetch_array($result_prot);
	} else {
		die("Protocolo NO Valido?"); 
	}
	
	$serie=$row_prot['equipo_serie'];
	$fecha_prot=$row_prot['fecha'];
	
	
    $query_fecha="SELECT DATE_FORMAT(MAX(fecha_toma),'%d%m%y') AS fbajada FROM entrada WHERE idprotocolo=" . $idprotocolo; 
    $result_fecha=mysql_query($query_fecha);
    if (mysql_num_rows($result_fecha)>0) {
        $row_fecha=mysql_fetch_array($result_fecha);
        $fecha_prot=$row_fecha['fbajada'];    
    } else {
        echo "\nERROR!\n No puedo determinar fecha... tiene registros?\n\n";
        die();
    }	

    $query_municipio="SELECT codigo_municipio FROM municipios WHERE id=" . $idmunicipio; 
    $result_municipio=mysql_query($query_municipio); 
    if (mysql_num_rows($result_municipio)>0) {
		$row_municipio=mysql_fetch_array($result_municipio);
		$codmunicipio=str_pad(trim($row_municipio['codigo_municipio']),3,"0",STR_PAD_LEFT);     
    	//echo "EL CODIGO MUNICIPIO ES: " . $codmunicipio . "\n";
	} else {
		$codmunicipio="000";
    }
	
	
	echo "\n";
	
	$protocolo="M" . $codmunicipio . "-" . $municipio . "-" . $envio . "-" . $idprotocolo . "-" . trim($serie) . "-" . $fecha_prot;

	echo "Protocolo: " . $protocolo . "\n";

	$carpeta_expo="/mnt/Expo/Expo" . $municipio . "-" . $argv[2];
	echo "Carpeta  : " . $carpeta_expo . "\n";
	
	if (!is_dir($carpeta_expo)) {
    	    $carpeta_expo="/mnt/Expo/Expo" . $municipio . "-" . $argv[2] . "-PENDAP";
	    if (!is_dir($carpeta_expo)) {
		echo "Carpeta  : " . $carpeta_expo . "\n";
		die("** CARPETA DE EXPO NO VALIDA O NO ENCONTRADA **");
	    }
	}
	
	$carpeta_protocolo=$carpeta_expo . "/" . $protocolo . "/";
	
	if (!is_dir($carpeta_expo)) die("** CARPETA DE PROTOCOLO NO VALIDA O NO ENCONTRADA **");
	
	
	
	$archivo_csv=$carpeta_expo . "/" . $protocolo . ".txt";
	
	echo "Archivo CSV: " . $archivo_csv . "\n"; 
	
	if (file_exists($archivo_csv)) {
		echo "Debe eliminarse el archivo CSV\n";
	} else {
		echo "El archivo CSV No existe\n";
	}

	if (is_dir($carpeta_protocolo)) { 
		$archivos=scandir($carpeta_protocolo);	
	
		$cantidad_archivos=count($archivos)-2;
	
		echo "Cantidad de Archivos a Eliminar: " . $cantidad_archivos . "\n";
	
		if ($cantidad_archivos>0) {
	
			$contador=0; 
			foreach ($archivos as $archivo) {
				if ($archivo=="." || $archivo=="..") continue;
				$archivo_eliminar=$carpeta_protocolo . $archivo;
				if (file_exists($archivo_eliminar)) {
					$contador++;
					echo "Eliminando " . $contador . " " . $archivo_eliminar;
					unlink($archivo_eliminar);
					echo "\n";
					if ($contador>=5000) die("**** Limite de archivos alcanzado, volver a ejecutar ****\n");
				} 
			}
		}
	} else {
		echo "No se encuentra la carpeta del protocolo\n";
	}
	
	if (file_exists($archivo_csv)) {
		unlink($archivo_csv);
		echo "Archivo CSV Eliminado\n"; 
	}
	
	if (is_dir($carpeta_protocolo)) {
		rmdir($carpeta_protocolo);
		echo "Carpeta Protocolo Eliminada\n";
	} else {
		echo "No se elimina la carpeta del protocolo porque no existe.\n";
	}
		
	echo "Proceso Finalizado\n";
	echo "\n"; 		
		
?>