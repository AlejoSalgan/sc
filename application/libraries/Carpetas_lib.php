<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Carpetas_lib {
    private $CI;
    public function __construct()
    {
        $CI =& get_instance();
    }

    static function crear_carpeta($ruta, $nombre, $permisos)
    {
      $ruta_destino = $ruta.$nombre;
      if (!is_dir($ruta_destino)) {
          mkdir($ruta_destino,$permisos, true);
          if (file_exists($ruta_destino)){
            $data = array('success'=>'El archivo ya existe o no es un directorio');
          }else{
            $data = array('error'=>'no se pudo crear la carpeta');
          }
      }else{
        $data = array('error'=>'El archivo ya existe o no es un directorio');
      }
      return $data;
    }
}
