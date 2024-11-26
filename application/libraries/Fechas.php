<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fechas {
    private $CI;
    public function __construct()
    {
        $CI =& get_instance();
    }

    //devuelve el número de días entre dos fechas DD/MM/AAAA
    public function comparar_fechas ($primera, $segunda) {
        $valoresPrimera = explode ("/", $primera);
        $valoresSegunda = explode ("/", $segunda);
        $diaPrimera    = $valoresPrimera[0];
        $mesPrimera  = $valoresPrimera[1];
        $anyoPrimera   = $valoresPrimera[2];
        $diaSegunda   = $valoresSegunda[0];
        $mesSegunda = $valoresSegunda[1];
        $anyoSegunda  = $valoresSegunda[2];
        $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
        $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
        if ( !checkdate($mesPrimera, $diaPrimera, $anyoPrimera) ) {
            // "La fecha ".$primera." no es válida";
            return 0;
        } elseif ( !checkdate($mesSegunda, $diaSegunda, $anyoSegunda) ) {
            // "La fecha ".$segunda." no es válida";
            return 0;
        } else {
            return  $diasPrimeraJuliano - $diasSegundaJuliano;
        }
    }

    //sumar días a una determinada fecha viene como AAAA/MM/DD
    public function sumar_dias ($fecha, $dias) {
        $nuevafecha = strtotime ("+$dias day" , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'd-m-Y' , $nuevafecha );
        return $nuevafecha;
    }

	//restar días a una determinada fecha viene como AAAA/MM/DD
    public function restar_dias ($fecha, $dias) {
        $nuevafecha = strtotime ("-$dias day" , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'd-m-Y' , $nuevafecha );
        return $nuevafecha;
    }

    //cambiaf_a_mysql AAAA-MM-DD
    public function cambiaf_a_mysql($fecha){
    	if ((is_null($fecha)) || ($fecha == '')) {
    		return NULL;
    	}
    	return date('Y-m-d',strtotime($fecha));
    }

     //cambiaf_a_normal DD-MM-AAAA
    public function cambiaf_a_normal($fecha){
    	if ((is_null($fecha)) || ($fecha == '')) {
    		return NULL;
    	}
    	return date('d-m-Y',strtotime($fecha));
    }

	function cambiaf_a_arg($fecha)
	{
		if ((is_null($fecha)) || ($fecha == '')) {
			return NULL;
		}
		return date('d/m/Y',strtotime($fecha));
	}

	function cambiaf_a_arg_hor($fecha)
	{
		if ((is_null($fecha)) || ($fecha == '')) {
			return NULL;
		}
		return date('d/m/Y - H:i:s',strtotime($fecha));
	}

  //Formato DD/MM/AAAA HH:MM:SS
  function FHA_MYSQL($fechaHora_arg)
  {
    return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $fechaHora_arg)));
  }

  //Formato DD/MM/AAAA
  function FH_MYSQL($fecha_arg)
  {
    return date('Y-m-d', strtotime(str_replace('/', '-', $fecha_arg)));
  }

  //Formato DD/MM/AAAA HH:MM
  function horas_minutos_00($fecha)
  {
    $hora = explode(" ", $fecha);
    return date('H:i:00',strtotime($hora[1]));
  }

  //Formato DD/MM/AAAA HH:MM:SS
  function horas_minutos_segundos($fecha)
  {
    $hora = explode(" ", $fecha);
    return date('H:i:s',strtotime($fecha));
  }



}
