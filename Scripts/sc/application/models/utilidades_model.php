<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class utilidades_model extends CI_Model
{
		function descargar_archivos($name = NULL,$tipo = NULL,$destino = NULL) //Descargar archivos.
		{
			header("Content-disposition: attachment; filename=".$name."");
			header("Content-type:".$tipo."");
			readfile("".$destino."");
		}

		function porcentaje($cantidad,$total,$decimales)
    {
        return number_format(($cantidad/$total)*100,$decimales);
    }

		function buscarFotos($ruta,$protocolo)
		{
			$directorio = $ruta.'/'.$protocolo.'/';
			$num_files = glob($directorio . "*.{JPG,jpeg,gif,png,bmp}", GLOB_BRACE);
			$carpeta = opendir($directorio);
			if (!$carpeta) {
				return FALSE;
			}
			if($num_files > 0){
			 while(false !== ($archivo = readdir($carpeta)))  {
			  $file_path = $directorio.$archivo;
			  $extension = strtolower(pathinfo($archivo ,PATHINFO_EXTENSION));
			  if($extension=='jpg' || $extension =='png' || $extension == 'gif' || $extension == 'bmp') {
					$data['fotos'][] = $archivo;
			  }}}
			closedir($carpeta);

			return $data['fotos'];
		}


		function distance($lat1, $lon1, $lat2, $lon2) {
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;

			return number_format($miles * 1.609344,3);
		}

}
