<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos_lib {
    private $CI;
    public function __construct()
    {
        $CI =& get_instance();
    }


    static function archivo_tipoDocumento ($ext)
    {
     
      if (in_array($ext, tipo_arch_equipo)){
        $data = array('respuesta'=>"success", 'msj'=>"formato aceptado");
      }else{
        $data = array('respuesta'=>"error", 'msj'=>"Formato de archivo no aceptado o no se adjunto archivo.");
      }
      return $data;
    }

    static function  archivo_moverArchivo($nombre_temp){
      
      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = "/var/www/html/sistemac/documentacion/equipos/".$parametro."_$fecha"."$ext";
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$parametro."_$fecha"."$ext";
      }


      if (move_uploaded_file($nombre_temp,$destino)){
        $flash = array("success", "Archivo cargado correctamente");
      }else{
        $flash = array("error", "Error al procesar archivo");
      }
        return $flash;
    }


}
