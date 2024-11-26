<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class External extends BaseController {

    function __construct()
    {
        parent::__construct();        
        $this->load->database();
    }

	public function desencriptados() {

        $protocolos = [];

        $id = isset($_GET['id']) ? $_GET['id'] : "";

        $fields = 'protocolos_main_temp.id,
                    protocolos_main_temp.municipio,
                    protocolos_main_temp.idequipo,
                    protocolos_main_temp.equipo_serie,
                    protocolos_main_temp.fecha,
                    protocolos_main_temp.usuario,
                    protocolos_main_temp.ip,
                    protocolos_main_temp.estado,
                    protocolos_main_temp.fecha_inicial,
                    protocolos_main_temp.fecha_final,
                    protocolos_main_temp.cantidad,
                    protocolos_main_temp.tipo_equipo,
                    protocolos_main_temp.estado_exportacion,
                    protocolos_main_temp.numero_exportacion,
                    protocolos_main_temp.archivos,
                    protocolos_main_temp.registros,
                    protocolos_main_temp.entrada,
                    protocolos_main_temp.idexportacion,
                    protocolos_main_temp.encolar,
                    protocolos_main_temp.encolar_prioridad,
                    protocolos_main_temp.decripto,
                    protocolos_main_temp.incorporacion_estado,
                    protocolos_main_temp.incorporacion_fecha,
                    protocolos_main_temp.ts';

        if ($id === '')
        {
            
            $protocolos = $this->db->select($fields)->
                from('protocolos_main_temp')->
                where('protocolos_main_temp.decripto', 4)->
                get()->
                result();
            
                echo json_encode($protocolos);
    
        } else {

            $protocolo = $this->db->select($fields)->
                from('protocolos_main_temp')->
                where('protocolos_main_temp.id', $id)->
                get()->
                result();
                                        
                echo json_encode($protocolo);
            
        }
    }
	
	
	public function entrada() {
		$entradas = [];
	
		$protocoloId = $_GET['protocolo'];
		
		if (!isset($_GET['protocolo'])) {
			return header("HTTP/1.0 400 Bad Request");
		}
		
		$fields = 'entrada_temp.id,
				entrada_temp.falta,
				entrada_temp.origen,
				entrada_temp.tipo,
				entrada_temp.infraccion,
				entrada_temp.fabricante,
				entrada_temp.serie,
				entrada_temp.operativo,
				entrada_temp.lugar,
				entrada_temp.fecha_toma,
				entrada_temp.hora_toma,
				entrada_temp.velper,
				entrada_temp.velreg,
				entrada_temp.dominio,
				entrada_temp.tipo_vehiculo,
				entrada_temp.ruta_imagenes,
				entrada_temp.imagen1,
				entrada_temp.imagen2,
				entrada_temp.imagen3,
				entrada_temp.imagen4,
				entrada_temp.video,
				entrada_temp.barrio,
				entrada_temp.comuna,
				entrada_temp.autoridad,
				entrada_temp.agente,
				entrada_temp.calle,
				entrada_temp.calle_numero,
				entrada_temp.coordenadas,
				entrada_temp.coordenadas_archivo,
				entrada_temp.sentido,
				entrada_temp.carril,
				entrada_temp.tiempo_encendio,
				entrada_temp.tiempo_luz_roja,
				entrada_temp.tiempo_luz_amarilla,
				entrada_temp.tiempo_luz_verde,
				entrada_temp.clip_video,
				entrada_temp.notificado,
				entrada_temp.usuario,
				entrada_temp.ts,
				entrada_temp.estado,
				entrada_temp.idprotocolo,
				entrada_temp.fecha_exportacion,
				entrada_temp.nocturno,
				entrada_temp.numero_exportacion,
				entrada_temp.fecha_proceso,
				entrada_temp.hora_proceso,
				entrada_temp.matricula,
				entrada_temp.nombre,
				entrada_temp.jerarquia,
				entrada_temp.jur_const,
				entrada_temp.jur_aplic,
				entrada_temp.aut_const,
				entrada_temp.ejido,
				entrada_temp.mano,
				entrada_temp.cp,
				entrada_temp.localidad,
				entrada_temp.fbajada,
				entrada_temp.imp_ley,
				entrada_temp.imp_art,
				entrada_temp.imp_inc,
				entrada_temp.idedicion,
				entrada_temp.codigo_descarte,
				entrada_temp.imagen_zoom,
				entrada_temp.observ,
				entrada_temp.usuario_supervision,
				entrada_temp.fecha_supervision,
				entrada_temp.autoaprobacion,
				entrada_temp.idexportacion,
				entrada_temp.fecha_cd,
				entrada_temp.fecha_alta,
				entrada_temp.idpresuncion';				
		
		$entradas = $this->db->select($fields)->
                    from('entrada_temp')->
                    where('entrada_temp.idprotocolo', $protocoloId)->
                    get()->
                    result();
					
		echo json_encode($entradas);
	}
	
    public function protocolos() {

        $protocolos = [];

        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $all = isset($_GET['all']) ? true : false;

        $fields = 'protocolos_main.id,
                    protocolos_main.municipio,
                    protocolos_main.idequipo,
                    protocolos_main.equipo_serie,
                    protocolos_main.fecha,
                    protocolos_main.usuario,
                    protocolos_main.ip,
                    protocolos_main.estado,
                    protocolos_main.fecha_inicial,
                    protocolos_main.fecha_final,
                    protocolos_main.cantidad,
                    protocolos_main.tipo_equipo,
                    protocolos_main.estado_exportacion,
                    protocolos_main.numero_exportacion,
                    protocolos_main.archivos,
                    protocolos_main.registros,
                    protocolos_main.entrada,
                    protocolos_main.idexportacion,
                    protocolos_main.encolar,
                    protocolos_main.encolar_prioridad,
                    protocolos_main.decripto,
                    protocolos_main.incorporacion_estado,
                    protocolos_main.incorporacion_fecha,
                    protocolos_main.ts,
                    ordenesb_main.id as ordenId,
                    ordenesb_main.idproyecto,
                    ordenesb_main.idsupervisor,
                    ordenesb_main.iddominio,
                    ordenesb_main.conductor,
                    ordenesb_main.tecnico,
                    ordenesb_main.idequipo as ordenIdequipo,
                    ordenesb_main.fecha_visita,
                    ordenesb_main.descrip as ordenDescrip,
                    ordenesb_main.creadopor,
                    ordenesb_main.fecha_alta,
                    ordenesb_main.fecha_baja,
                    ordenesb_main.activo,
                    ordenesb_main.eliminado,
                    ordenesb_main.seriado,
                    ordenesb_main.imei,
                    ordenesb_main.protocolo,
                    ordenesb_main.bajada_fecha,
                    ordenesb_main.bajada_lat,
                    ordenesb_main.bajada_long,
                    ordenesb_main.bajada_tiempo,
                    ordenesb_main.bajada_sat,
                    ordenesb_main.bajada_archivos,
                    ordenesb_main.bajada_desde,
                    ordenesb_main.bajada_hasta,
                    ordenesb_main.bajada_observ,
                    ordenesb_main.subida_repetidos,
                    ordenesb_main.subida_errores,
                    ordenesb_main.subida_envios,
                    ordenesb_main.subida_vencidos,
                    ordenesb_main.subida_fotos,
                    ordenesb_main.subida_videos,
                    ordenesb_main.subida_fabrica,
                    ordenesb_main.subida_ingresados,
                    ordenesb_main.subida_FD,
                    ordenesb_main.subida_FH,
                    ordenesb_main.subida_cant,
                    ordenesb_main.subida_observ,
                    ordenesb_main.subida_creadopor,
                    ordenesb_main.subida_fecha,
                    ordenesb_main.enviado,
                    ordenesb_main.enviado_fecha,
                    ordenesb_main.ack,
                    ordenesb_main.nro_msj,
                    ordenesb_main.recibido,
                    ordenesb_main.recibido_fecha,
                    ordenesb_main.ord_procesado,
                    ordenesb_main.procesado_fecha';

        if ($id === '')
        {
            if ($all) {
                $protocolos = $this->db->select($fields)->
                    from('protocolos_main')->
                    join('ordenesb_main', 'protocolos_main.id=ordenesb_main.protocolo')->
                    where('ordenesb_main.activo', 1)->
                    get()->
                    result();
            } else {
                $protocolos = $this->db->select($fields)->
                    from('protocolos_main')->
                    join('ordenesb_main', 'protocolos_main.id=ordenesb_main.protocolo')->
                    where('ordenesb_main.subida_ingresados', null)->
                    where('ordenesb_main.activo', 1)->
                    get()->
                    result();
            }

            if ($protocolos)
            {
                echo json_encode($protocolos);
            }
            else
            {
                header("HTTP/1.0 404 Not Found");
            }
        } else {

            $protocolo = $this->db->select($fields)->
                from('protocolos_main')->
                join('ordenesb_main', 'protocolos_main.id=ordenesb_main.protocolo')->
                where('protocolos_main.id', $id)->
                get()->
                result();
                                        
            if (!empty($protocolo))
            {
                echo json_encode($protocolo);
            }
            else
            {
                header("HTTP/1.0 404 Not Found");
            }    
        }
    }

    public function equipos() {

        $equipos = [];

        $serie = isset($_GET['serie']) ? $_GET['serie'] : "";
        if ($serie === '') {

            $equipos = $this->db->get('equipos_main')->result();
            if ($equipos)
            {
                echo json_encode($equipos);
            }
            else
            {
                header("HTTP/1.0 404 Not Found");
            }

        } else {

            $equipo = $this->db->where('serie', $serie)->get('equipos_main')->result();
            if (!empty($equipo))
            {
                echo json_encode($equipo);
            }
            else
            {
                header("HTTP/1.0 404 Not Found");
            }    
        }                
    }

    public function municipios() {

        $municipios = [];

        $municipios = $this->db->get('municipios')->result();
        if ($municipios)
        {
            echo json_encode($municipios);
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
        }                
    }    

    public function protocolo_update() {
        
        $var = json_decode(file_get_contents('php://input'), true);

    }
    
}