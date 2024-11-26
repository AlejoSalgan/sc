<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data, $exit = null)
{
    echo "<pre>";
	if($exit == "v") {
		var_dump($data);
		echo "</pre>";
	} else if($exit == "pe") {
		print_r($data);
		exit;
	} else if($exit == "ve") {
		var_dump($data);
		exit;
	} else {
		print_r($data);
		echo "</pre>";
	}
}

function tag()
{
    // $tags = shell_exec('git tag --sort=-version:refname');
    // $espacio_en_blanco = strpos($tags, '.', 6);
    // $ult_tag = substr($tags, 0, $espacio_en_blanco-1);
    $ult_tag = "7.11.4";
    return $ult_tag;
}


function equipo_semaforo($equipo_nombre)
{
    $equipos_tipos = array("SS", "SMART_RED", "REVO_SD", "REDCAM","SF1100");
    $semaforo = 0;

    foreach ($equipos_tipos as $tipo) {
        if (strpos(strtoupper($equipo_nombre), $tipo) !== false) {
            $semaforo = 1;
            break;
        }
    }


    return $semaforo;
}




if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}



function sector_mail($data)
{
    $equipo = $data['Equipo'];
    $proy = $data['proyecto_desc'];
    $socio = $data['socio'];
    $respuesta = array();


    //Deposito
    if($data['Estado_nue'] == 1 && $data['Categoria_nue'] == 8){
        $respuesta['mail']='grodriguez@cecaitra.org.ar';
        $respuesta['subject']='Modificacion de Equipo de '.$proy.'.';
        $respuesta['Texto']='Equipo '.$equipo.' reasignado a deposito.';

    }

    //Gest Proy
    if($data['Categoria_nue'] == 6 && $data['proyecto']==1){
        //se envia a gest de proyecto
        $respuesta['mail']='mminutti@cecaitra.org.ar';
        $respuesta['subject']='Modificacion de Equipo de '.$proy.' .';    
        $respuesta['Texto']='Equipo '.$equipo.' reasignado a area de gestion de proyectos.';

    }

    //Proovedor
    if($data['Categoria_nue'] == 5 && $data['socio'] == 'MS-TRAFFIC'){
        //enviar mail a proove
        $respuesta['mail']='rgarcia@adminempresas.com.ar, laboratorio@mstraffic.com.ar';
        $respuesta['subject']='Modificacion de Equipo de '.$proy.' .';    
        $respuesta['Texto']='Equipo '.$equipo.' reasignado a socio.';

    }




    //REPARACIONES
    if($data['Estado_ant'] == 3  && $data['Categoria_ant'] == 5 && $data['Categoria_nue'] == 5 && $data['socio'] == 'MS-TRAFFIC' ){
        //viene del inti
        $respuesta['mail']='acasas@cecaitra.org.ar';
        $respuesta['subject']='Vuelve del socio Equipo de '.$proy.' .';    
        $respuesta['Texto']='Equipo '.$equipo.' vuelve de socio: '.$socio.'.';

    }

    //Instalaciones
    if($data['Categoria_nue'] == 3 ){
        //enviamos mail a reparaciones
        $respuesta['mail']='enieves@cecaitra.org.ar,gsourigues@cecaitra.org.ar';
        $respuesta['subject']='Modificacion de Equipo de '.$proy.' .';    
        $respuesta['Texto']='Equipo '.$equipo.' reasignado a Instalaciones.';
    }

    //FALTA MAIL A BAJADA DE MEMORIA
    if($data['Categoria_nue'] == 1 && $data['Estado_ant']== 2 && $data['Estado_nue'] != 2){
        //enviamos mail a reparaciones
        $respuesta['mail']='cmelgarejo@mrmlogisticaintegral.com.ar';
        $respuesta['subject']='Retiro de Equipo de '.$proy.' .';    
        $respuesta['Texto']='Equipo '.$equipo.' se retiro del proyecto para su reparacion. Tener en cuenta por ordenes de trabajo.';

    }

    // Valmex
    if($data['Categoria_nue'] == 11){
        if(ENVIRONMENT == "development"){
            $respuesta['mail']=["lprats@cecaitra.org.ar", "rhernandez@cecaitra.org.ar", "twagner@cecaitra.org.ar"];
        } else {
            $respuesta['mail']=["storreblanca@valmex.com.ar", "famado@valmex.com.ar", "hscrosoppi@valmex.com.ar"];
        }
        $respuesta['subject']='Título de prueba mail Valmex';    
        $respuesta['Texto']='Cuerpo del mail de prueba, mail Valmex';
    }

return $respuesta;


/*
ESTADOS
    1	Depósito	
	2	Proyecto	
	3	Socio	
	4	INTI	
	5	Of. Técnica Reparaciones	
	6	Robado	
	7	Vandalizado	
	8	Apagado en el lugar	
	9	Cambió número de serie
*/


/*
CATEGORIA
   
	1	Reparaciones mail
	2	Mantenimiento 
	3	Instalaciones  mail
	4	Calibraciones  ->cuando vuelve mail
	5	Socio	 -> solo mstrafic
	6	Gestión de proyectos mail	
	7	Dirección de Operaciones	
	8	Servicios Generales mail
	9	Capacitación	
	10	Deposito  mail
*/


    //iF socio - MStrafic + se suma


    //if gestion de proyectos - pba

    //if instalacion - (proyecto  e )

    //if vuelve de inti
    //if va a deposito
    //

}

// ------------- funciones globales para llamados a la API de factory y manipular las respuestas -----------------------------------

function callAPI($method, $url, $data = false)
{
    // $data = array(
    //     "id" => 15,
    //     "fields" => ["id", "dominio"],
    //     "dominio" => "JWI609",
    //     "wherein" => ["id", "777,888,999"],
    //     "joins" => array(
    //          "equipos_modelos AS EMO,EMO.id=equipos_main.idmodelo,left",
    //     ),
    // );
    // $response = callAPI("GET", API_GESTION["componente_get"]["development"], $data);
    // http://localhost/sc_corte/api/flota/get_all_delimited_fields?id=15&fields[]=id&fields[]=dominio&dominio=JWI609&wherein[]=id&wherein[]=777,888,999

    $curl = curl_init();

    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
        default:
            if ($data) {
                // Usa http_build_query para manejar correctamente los arrays en la query string
                $queryString = http_build_query($data);
                $url = sprintf("%s?%s", $url, $queryString);
            }
    }

    // Opciones comunes para todas las peticiones
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $result = curl_exec($curl);
    if(!$result){
        die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}

/* 
    - esta funcion recibe una consulta local y retorna un array cuyos elementos son solo los valores del dato recibido en $field
    - soporta las opciones: excluir campos vacios, exlcuir duplicados, y ordenar de manera ASC
 */
function get_list_field_in_array($array, $field, $options = null) {
    // $options = array(
    //     "exclude_empty_fields" => true,
    //     "exclude_duplicate_fields" => true,
    //     "sort_list_by_field" => true
    // );
    // $idEquipos = get_list_field_in_array($result_query, "id", $options);

    $idEquipos = array_map(function($item) use ($field) {
        return $item->$field;
    }, $array);
    
    if($options) {
        if(array_key_exists("exclude_empty_fields", $options) && $options["exclude_empty_fields"]) {
            $idEquipos = array_filter($idEquipos, function($item) {
                return $item != "";
            }); 
        }
        if(array_key_exists("exclude_duplicate_fields", $options) && $options["exclude_duplicate_fields"]) {
            $idEquipos = array_unique($idEquipos);
        }
        if(array_key_exists("sort_list_by_field", $options) && $options["sort_list_by_field"]) {
            sort($idEquipos);
        }
    }   

    return $idEquipos;
}

/*
    - esta funcion recibe un string y un substring 
    - busca el substring dentro del string 
    - funciona como un LIKE de SQL pudiendo usar opcionalmente los comodines (%)
*/
function like($string, $substring) {
    $string = mb_strtolower($string);
    $substring = mb_strtolower($substring);
    
    if (substr($substring, 0, 1) === '%') {
        $substring = substr($substring, 1);
        $startWithWildcard = true;
    } else {
        $startWithWildcard = false;
    }
    if (substr($substring, -1) === '%') {
        $substring = substr($substring, 0, -1);
        $endWithWildcard = true;
    } else {
        $endWithWildcard = false;
    }
    if ($startWithWildcard && $endWithWildcard) {
        return stripos($string, $substring) !== false;
    } elseif ($startWithWildcard) {
        return substr($string, -strlen($substring)) === $substring;
    } elseif ($endWithWildcard) {
        return stripos($string, $substring) === 0;
    } else {
        return $string === $substring;
    }
}

/**
 * Filtra un array usando limit y offset similares a SQL.
 *
 * @param array $array El array original.
 * @param int $limit La cantidad máxima de elementos a retornar.
 * @param int $offset La cantidad de elementos a descartar al inicio.
 * @return array El array filtrado según el límite y el desplazamiento.
 */
function arrayLimitOffset($array, $limit, $offset) {
    // Asegurarse de que el offset no sea negativo
    if ($offset < 0 || $offset == false) {
        $offset = 0;
    }
    // Aplicar el offset para descartar los elementos iniciales
    $array = array_slice($array, $offset);
    // Aplicar el límite para obtener solo la cantidad deseada de elementos
    $array = array_slice($array, 0, $limit);
    return $array;
}

?>