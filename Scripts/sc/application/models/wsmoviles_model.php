<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Wsmoviles_model extends CI_Model
{

    function obtenerCoordenadas()
    {
        $curl = curl_init();
        
        $datos = array(
            CURLOPT_URL => "http://gps.cecaitra.com/API/Wservice.js",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '
            {
                "user":"faraujo",
                "pwd":"sistemas411",
                "action": "DATOSACTUALES"
            }',
            CURLOPT_HTTPHEADER => array( "Content-Type: application/json" )
        );
        
        curl_setopt_array($curl, $datos);
        
        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
