<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Protocolos_lib {

    public function get_UnificoConsultas($sql_fechaProtocolos,$Sql_FechaOrdenesb){
        $array_Fechaprotocolos=[];
        $diferencias=[];
        
        foreach($sql_fechaProtocolos as $recorro){
            array_push($array_Fechaprotocolos,$recorro);
        }    
        
        $diferencias=array_diff_key($Sql_FechaOrdenesb,$sql_fechaProtocolos);
        foreach($diferencias as $recor){
            array_push($array_Fechaprotocolos,$recor);
        }
        return $array_Fechaprotocolos;
    }

    function get_difProtocolob($array_protocolos,$array_ordenes)
    {
        $dato= array();
        foreach($array_protocolos as $valor){
            if(!in_array($valor,$array_ordenes)){
               array_push($dato,$valor);
            }
        }

        return $dato;
    }
         
    function get_difOrdenesb($array_ordenes,$array_protocolos)
    {
        $dato= array();
        foreach($array_ordenes as $valor){
            if(!in_array($valor,$array_protocolos)){ 
               array_push($dato,$valor);               
            }
        }
         
        return $valor;
    }
        
    function get_noConsecutivoProtocolosb($array_protocolos)
    {
        $dato= array();
        foreach ($array_protocolos as $verifico){
            if($verifico->fecha_inicial > $verifico->fecha_final){ 
                array_push($dato,$verifico);
            }
        }
         
        return $dato;
    }
        
        
    function get_noConsecutivoOrdenesb($array_ordenes)
    {
        $dato= array(); 
        foreach ($array_ordenes as $verifico){
            if($verifico->fecha_inicial > $verifico->fecha_final){ 
                array_push($dato,$verifico);
            }   
        }
         
        return $dato;
    }
 
    function get_FechasNoconsecutivasProtob($array_protocolos)
    {
        $longitud=count($array_protocolos);
        $dato= array();
        for ($i=0 ; $i < $longitud ; $i++){            
            $suma=$i;
            for ($j=$suma+1 ; $j < $longitud ; $j++) {
                if($array_protocolos[$suma]->fecha_inicial < $array_protocolos[$j]->fecha_final){
                    array_push($dato,$array_protocolos[$j]);
                } 
            }       
        }
        
        return $dato;            
    }
     
    function get_FechasNoconsecutivasOrdenesb($array_ordenes)
    {
        $longitud=count($array_ordenes);
        $dato= array();
        for ($i=0 ; $i < $longitud ; $i++){            
            $suma=$i;
            for ($j=$suma+1 ; $j < $longitud ; $j++) {
                if($array_ordenes[$suma]->fecha_inicial < $array_ordenes[$j]->fecha_final){
                    array_push($dato,$array_ordenes[$j]);
                } 
            }       
        }
        
        return $dato;
    }

    



}
?>