<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ordenesb_model extends CI_Model
{
    function ordenesCount($searchText = '',$tipo,$criterio,$userId, $role) // Ordenes de Servicio que fueron creadas (Contadas)
    {
        $this->db->select('OM.id');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(F.dominio  LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(UT.name  LIKE '%".$searchText."%')";
                    break;
                case 6:
                    $likeCriteria = "(OM.fecha_visita  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  F.dominio  LIKE '%".$searchText."%'
                                        OR  UT.name  LIKE '%".$searchText."%'
                                        OR  OM.fecha_visita  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        switch ($tipo) {
            case "Ordenes":
                $this->db->where('OM.enviado IS NULL');
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.activo = 1');
                $where = "(OM.ord_procesado = 0 OR OM.ord_procesado = 2)";
                $this->db->where($where);
                break;

            case "SR":
                $this->db->where('OM.enviado = 1');
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.ord_procesado = 0');
                $this->db->where('OM.activo = 1');
                break;

            case "SP":
                $this->db->where('OM.enviado = 1');
                $this->db->where('OM.recibido = 1');
                $this->db->where('OM.ord_procesado = 0');
                $this->db->where('OM.activo = 1');
                break;

            case "Procesado":
                $where = "(OM.ord_procesado = 1 OR OM.ord_procesado = 2) AND OM.enviado = 1 AND OM.recibido = 1 && OM.protocolo > 0 && OM.activo = 1";
                $this->db->where($where);
                break;

            case "Anulado":
                $this->db->where('OM.activo = 0');
                break;

            case "Cero":
                $where = "(OM.ord_procesado = 1 OR OM.ord_procesado = 2) AND OM.enviado = 1 AND OM.recibido = 1 && OM.protocolo = 0 && OM.activo = 1";
                $this->db->where($where);
                break;
        }

        /*

        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                    $this->db->where("Mun.director LIKE '%" . $userId . "%'");
               break;
           case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                    $this->db->where("Mun.gerente LIKE '%" . $userId . "%'");
               break;
            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                    $this->db->where("Mun.gestor LIKE '%" . $userId . "%'");
               break;
            case 103: //Gestión de Proyectos (Ayudantes)
                    $this->db->where("Mun.ayudantes LIKE '%" . $userId . "%'");
               break;
            case 104: //Gestión de Proyectos - Auditoria
                    $this->db->where("Mun.auditor LIKE '%" . $userId . "%'");
               break;
        }


        */

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->where('MA.usuario',$userId);
        }

        $this->db->order_by("OM.id", "DESC");
        $this->db->order_by("Mun.descrip", "DESC");
        $this->db->order_by("EM.serie", "DESC");

        $query = $this->db->get();
        return count($query->result());
    }


    function ordenesList($searchText = '', $page, $segment,$tipo,$criterio,$userId, $role) // Ordenes de Servicio que fueron creadas.
    {
        $this->db->select('OM.id, OM.idequipo, OM.descrip, OM.activo, OM.conductor, OM.tecnico, OM.fecha_visita, OM.enviado, OM.recibido, OM.ord_procesado, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, UT.name AS nameTecnico, UC.name AS nameConductor, UG.name as nameGestor, Mun.gestor, F.dominio');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(F.dominio  LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(UT.name  LIKE '%".$searchText."%')";
                    break;
                case 6:
                    $likeCriteria = "(OM.fecha_visita  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  F.dominio  LIKE '%".$searchText."%'
                                        OR  UT.name  LIKE '%".$searchText."%'
                                        OR  OM.fecha_visita  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        switch ($tipo) {
            case "Ordenes":
                $this->db->where('OM.enviado IS NULL');
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.activo = 1');
                $where = "(OM.ord_procesado = 0 OR OM.ord_procesado = 2)";
                $this->db->where($where);
                break;

            case "SR":
                $this->db->where('OM.enviado = 1');
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.ord_procesado = 0');
                $this->db->where('OM.activo = 1');
                break;

            case "SP":
                $this->db->where('OM.enviado = 1');
                $this->db->where('OM.recibido = 1');
                $this->db->where('OM.ord_procesado = 0');
                $this->db->where('OM.activo = 1');
                break;

            case "Procesado":
                $where = "(OM.ord_procesado = 1 OR OM.ord_procesado = 2) AND OM.enviado = 1 AND OM.recibido = 1 && OM.protocolo > 0 && OM.activo = 1";
                $this->db->where($where);
                break;

            case "Anulado":
                $this->db->where('OM.activo = 0');
                break;

            case "Cero":
                $where = "(OM.ord_procesado = 1 OR OM.ord_procesado = 2) AND OM.enviado = 1 AND OM.recibido = 1 && OM.protocolo = 0 && OM.activo = 1";
                $this->db->where($where);
                break;
        }

        /*

        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                    $this->db->where("Mun.director LIKE '%" . $userId . "%'");
               break;
           case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                    $this->db->where("Mun.gerente LIKE '%" . $userId . "%'");
               break;
            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                    $this->db->where("Mun.gestor LIKE '%" . $userId . "%'");
               break;
            case 103: //Gestión de Proyectos (Ayudantes)
                    $this->db->where("Mun.ayudantes LIKE '%" . $userId . "%'");
               break;
            case 104: //Gestión de Proyectos - Auditoria
                    $this->db->where("Mun.auditor LIKE '%" . $userId . "%'");
               break;
        }

        */

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->where('MA.usuario',$userId);
        }

        $this->db->order_by("OM.id", "DESC");
        $this->db->order_by("Mun.descrip", "DESC");
        $this->db->order_by("EM.serie", "DESC");
        $this->db->limit($page, $segment);

        $query = $this->db->get();
        return $query->result();
    }

//ORDENES DE BAJADA DE MEMORIA GRUPOS//

    function gruposListing($enviado = NULL, $recibido = NULL, $procesado)  //Grupo de bajada de memoria
    {
        $this->db->select('COUNT(*) as cantidad, OM.idproyecto, OM.conductor, OM.tecnico, MUN.descrip AS descripProyecto,F.dominio, UT.name AS nameTecnico, UC.name AS nameConductor, OM.fecha_visita, SUM(OM.bajada_archivos) AS cantidadArchivos, MAX(OM.id) as orden_max, MIN(OM.id) as orden_min');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as MUN', 'MUN.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico ','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');

        $this->db->where('OM.enviado', $enviado);
        $this->db->where('OM.recibido',$recibido);
        $this->db->where('OM.ord_procesado', $procesado);
        $this->db->where('OM.activo = 1');

        $this->db->group_by('OM.idproyecto');
        $this->db->group_by('OM.tecnico');
        $this->db->group_by('OM.fecha_visita');

        $this->db->order_by("nameTecnico", "ASC");
        $this->db->order_by("OM.fecha_visita", "ASC");
        $this->db->order_by("descripProyecto", "ASC");

        $query = $this->db->get();
        return $query->result();
    }

    function grupos_equipos($recibido,$tecnico,$idproyecto,$fecha_visita, $tipo = 0)
    {
        $this->db->select('OM.id, OM.imei, OM.fecha_alta, OM.fecha_visita, OM.descrip, OM.tecnico, OM.conductor, OM.iddominio, OM.nro_msj, EM.serie AS equipoSerie, EM.ubicacion_calle, EM.ubicacion_altura ,MUN.descrip AS descripProyecto, UT.name AS nameTecnico, UC.name AS nameConductor, F.dominio, OM.ord_procesado');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as MUN', 'MUN.id = OM.idproyecto','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico ','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');

        $this->db->where('OM.tecnico', $tecnico);
        $this->db->where('OM.idproyecto', $idproyecto);
        $this->db->where('OM.fecha_visita', $fecha_visita);

        switch ($recibido) {
            case "0":
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.enviado IS NULL');
                $this->db->where('OM.ord_procesado = 0');
                break;

            case "2":
                $this->db->where('OM.enviado = 1');
                $this->db->where('OM.recibido IS NULL');
                $this->db->where('OM.ord_procesado = 0');
                break;

            case "1":
                $this->db->where('OM.recibido',$recibido);
                $this->db->where('OM.ord_procesado = 0');
                break;

            case "3":
                $this->db->where('OM.ord_procesado = 2');
                break;
        }

        $this->db->where('OM.activo = 1');
        $this->db->order_by('EM.serie');
        $query = $this->db->get();

        switch ($tipo) {
          case 0:
            return $query->result();
            break;

          case 1:
            return count($query->result());
            break;

          case 2:
            $row = $query->row();
            return $row;
            break;
        }


    }














    function equipos_imprimir($orden_min, $orden_max)
    {
        $this->db->select('OM.fecha_alta, OM.fecha_visita, MUN.descrip AS descripProyecto, UT.name AS nameTecnico, F.dominio, UC.name AS nameConductor, EM.serie AS equipoSerie, EM.ubicacion_calle, EM.ubicacion_altura');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as MUN', 'MUN.id = OM.idproyecto','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico ','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');

        $this->db->where('OM.id >=', $orden_min);
        $this->db->where('OM.id <=', $orden_max);
        $this->db->where('OM.activo = 1');
        $this->db->order_by('EM.serie');

        $query = $this->db->get();
        return $query->result();

    }





//ORDENES DE BAJADA DE MEMORIA OBTENER INFORMACION//

    function getOrdenesbInfo($ordenesbId)
    {
        $this->db->select("OM.id, OM.subida_observ, OM.ord_procesado, OM.recibido, OM.subida_envios, OM.subida_errores, OM.subida_repetidos, OM.subida_vencidos, OM.subida_videos, OM.subida_fotos, OM.subida_ingresados, OM.bajada_fecha, OM.bajada_lat, OM.bajada_long, OM.bajada_observ, OM.bajada_desde, OM.bajada_hasta, OM.bajada_archivos, OM.protocolo, OM.bajada_archivos ,OM.activo, OM.descrip, OM.idproyecto, OM.idsupervisor, OM.iddominio, OM.conductor, OM.tecnico, OM.idequipo, OM.subida_fotos, OM.subida_videos, OM.subida_fabrica, OM.subida_envios, OM.subida_errores, OM.subida_vencidos, OM.subida_sbd, OM.subida_repetidos, OM.subida_ingresados, OM.subida_observ, OM.subida_FD, OM.subida_FH, OM.subida_fecha, OM.subida_creadopor, OM.subida_cant, OM.recibido_fecha, OM.enviado_fecha, OM.procesado_fecha, DATE_FORMAT(OM.fecha_visita, '%d-%m-%Y') AS fecha_visita, OM.fecha_alta, OM.creadopor, OM.fecha_baja, EM.serie AS equipoSerie, EM.geo_lat AS geoLat, EM.geo_lon AS geoLon, EM.ubicacion_calle AS calle_equipo, Mun.descrip AS descripProyecto, U.name AS nameSupervisor, UC.name AS nameConductor, UT.name AS nameTecnico, F.dominio, PM.fecha as fecha_procesado, US.name as nameSubida, UCP.name AS nameCreadoPor", FALSE);
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as US', 'US.userId = OM.subida_creadopor','left');
        $this->db->join('tbl_users as UCP', 'UCP.userId = OM.creadopor','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->from("ordenesb_main AS OM");
        $this->db->where("OM.id", $ordenesbId);

        $query = $this->db->get();

        $row = $query->row();
        return $row;
    }




    function getBajada($ordenesbId)
    {
        $this->db->select("OM.id as idbajada, OM.fecha_alta, OM.creadopor, UCP.name AS nameCreadoPor, OM.descrip,

        OM.enviado_fecha, OM.recibido_fecha, OM.fecha_visita, OM.conductor, UC.name AS nameConductor, OM.tecnico, UT.name AS nameTecnico, F.dominio,

        OM.protocolo, OM.bajada_fecha, PM.fecha as fecha_procesado, OM.idequipo, EM.serie AS equipoSerie, OM.idproyecto, MUN.descrip AS descripProyecto, OM.bajada_desde, OM.bajada_hasta, OM.bajada_archivos, OM.bajada_observ,

        EM.geo_lat, EM.geo_lon, OM.bajada_lat, OM.bajada_long,

        FM.descrip as falla_descrip, RM.id as id_rm, OTE.descrip as orden_estado, RM.ultimo_estado,

        M.id as id_mensaje, M.tipo as tipo_mensaje, M.codigo as codigo_mensaje, M.coords, M.datos as datos_mensaje, M.ts, M.fecha_ack, M.intentos, M.estado,

        EM.ubicacion_calle AS calle_equipo, OM.enviado, OM.recibido, OM.activo, OM.ord_procesado,

        OM.imei, OM.seriado, OM.bajada_fecha, OM.iddominio,

        OM.transferidos_estado, OM.transferido_tipo






        ");
        $this->db->from("ordenesb_main AS OM");
        $this->db->join('tbl_users as UCP', 'UCP.userId = OM.creadopor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('municipios as MUN', 'MUN.id = OM.idproyecto','left');
        $this->db->join('reparacion_main as RM', 'RM.nro_msj = OM.nro_msj','left');
        $this->db->join('fallas_main as FM', 'FM.id = RM.falla','left');
        $this->db->join('ordenes_tipo_estados as OTE', 'OTE.id = RM.ultimo_estado','left');
        $this->db->join('mensajes as M', 'M.codigo = OM.nro_msj','left');
        $this->db->where("OM.id", $ordenesbId);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

//AGREGAR NUEVA ORDEN DE BAJADA DE MEMORIA//

    function addNewOrdenesb($ordenesbInfo)
    {
        $this->db->trans_start();
        $this->db->insert('ordenesb_main', $ordenesbInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function getPersonal($roleId = 0){ //0.- Todos
        $this->db->select('U.userId, U.name, U.mobile, U.imei');
        $this->db->from('tbl_users AS U');
        $this->db->where('U.roleId =', $roleId);
        $this->db->where('U.isDeleted =', 0);
        $this->db->order_by('name', 'asc');

        $query = $this->db->get();
        return $query->result();

    }

//??//

    function getOrdenesbEnvio($ordenesbId)
    {
        $this->db->select('OM.id, OM.imei, OM.fecha_alta, OM.fecha_visita, OM.descrip, EM.serie AS equipoSerie, OM.nro_msj');
        $this->db->from('ordenesb_main AS OM');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->where('OM.id', $ordenesbId);

        $query = $this->db->get();
        return $query->result();
    }


//OBTENER COORDENADAS DE LA ULTIMA BAJADA DE MEMORIA//

    function getCoordUltBaj($ordenesbId)
    {
        $this->db->select('OM.id, OM.imei, OM.fecha_alta, OM.fecha_visita, OM.descrip, EM.serie AS equipoSerie, OM.nro_msj');
        $this->db->from('ordenesb_main AS OM');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->where('OM.id', $ordenesbId);

        $query = $this->db->get();
        return $query->result();
    }

//ORDENES DE BAJADA DE MEMORIA SIN ENVIAR//

    function getSinEnviar()
    {
        $this->db->select('OM.id');
        $this->db->from('ordenesb_main AS OM');
        $where = "enviado IS NULL OR enviado = 0";
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

//EDITAR UNA ORDEN DE BAJADA DE MEMORIA x PROTOCOLO//

function editOrdenesb_protocolo($protocolo,$observacion) 
{
    
    $this->db->where('protocolo', $protocolo);
    $this->db->update('ordenesb_main', $observacion);

    return TRUE;
}


//EDITAR UNA ORDEN DE BAJADA DE MEMORIA//

    function editOrdenesb($ordenesbInfo, $ordenesbId) //deprecated se usa addNewMensaje de mensajes_model
    {
        $this->db->where('id', $ordenesbId);
        $this->db->update('ordenesb_main', $ordenesbInfo);

        /*
        if ($ordenesbInfo['activo'] == 0) {
          $this->load->model('historial_model');
      		$registro = array(
      					'idequipo'      => $ordenesbInfo['idEquipo'],
      					'idevento'      => 0,
      					'tipo'          => 'BAJA',
      					'creadopor'     => $this->session->userdata('userId'),
      					'fecha'         => date('Y-m-d H:i:s'),
      					'detalle'       => ' Orden de bajada de memoria Nº <a href="'.base_url("verOrdenb/{$ordenesbId}").'">'.$ordenesbId.'</a>'." BAJA",
      					'observaciones' => $ordenesbInfo['descrip'],
      					'origen'        => 'BAJADA'
      				);
      		$this->historial_model->addHistorial($registro);
        }
        */

        return TRUE;
    }

//ANULAR UNA ORDEN DE BAJADA DE MEMORIA//

    function deleteOrdenesb($ordenesbId, $ordenesbInfo)
    {
        $this->db->where('id', $ordenesbId);
        $this->db->update('ordenesb_main', $ordenesbInfo);

        return $ordenesbInfo;
    }

//OBTENER EL PROXIMO ID DE UNA ORDEN DE BAJADA DE MEMORIA//

    function getProxOrden()
    {
        $this->db->select_max('id');
        $result = $this->db->get('ordenesb_main')->row();
        $data = $result->id + 1;

        return $data;
    }


    function ultima_bajadaEquipo($equipo)
    {
      $this->db->select('PM.equipo_serie as Equipo, MAX(PM.fecha) as Ultima_bajada, DATEDIFF(NOW(),MAX(PM.fecha)) as Dias');
      $this->db->from('protocolos_main as PM');
      $this->db->where('PM.equipo_serie',$equipo);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }


    function protocolo_unico($protocolo)
    {
      $this->db->select('PM.id, PM.equipo_serie, PM.fecha, PM.nro_msj, PM.fecha_inicial, PM.fecha_final, PM.cantidad');
      $this->db->from('protocolos_main as PM');
      $this->db->where('PM.id',$protocolo);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }



    function protocolos_equipo($id_equipo)
    {
      $this->db->select('PM.id, PM.equipo_serie, PM.fecha, PM.nro_msj, PM.fecha_inicial, PM.fecha_final, PM.cantidad');
      $this->db->from('protocolos_main as PM');
      $this->db->join('equipos_main as EM', 'EM.serie = PM.equipo_serie','left');
      $this->db->where('EM.id',$id_equipo);
      $this->db->order_by("PM.id", "DESC");
      $this->db->limit(5);

      $query = $this->db->get();
      return $query->result();
    }


    function bajadas_equipo($id_equipo)
    {
      $this->db->select('OM.id, EM.serie, OM.fecha_visita, OM.protocolo, OM.bajada_desde, OM.bajada_hasta, OM.nro_msj, OM.ord_procesado, OM.bajada_archivos');
      $this->db->from('ordenesb_main as OM');
      $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
      $this->db->where('OM.idequipo',$id_equipo);
      $this->db->order_by("OM.id", "DESC");
      $this->db->limit(5);

      $query = $this->db->get();
      return $query->result();
    }


    function protocolo_nro_msj($protocolo)
    {
        $sql = "UPDATE protocolos_main
        LEFT JOIN ordenesb_main ON ordenesb_main.protocolo = protocolos_main.id
        SET protocolos_main.nro_msj = ordenesb_main.nro_msj
        WHERE protocolos_main.id = $protocolo";

        $query = $this->db->query($sql);

        if ($query) {
          return TRUE;
        } else {
          return FALSE;
        }

    }


    function actualizar_datos($id_orden)
    {
        $sql = "UPDATE ordenesb_main
        LEFT JOIN protocolos_main ON protocolos_main.id = ordenesb_main.protocolo
        LEFT JOIN mensajes ON mensajes.idprotocolo = ordenesb_main.protocolo
        SET ordenesb_main.bajada_archivos = protocolos_main.cantidad,
        ordenesb_main.bajada_desde = protocolos_main.fecha_inicial,
        ordenesb_main.bajada_hasta = protocolos_main.fecha_final,
        ordenesb_main.bajada_lat = SUBSTRING_INDEX( mensajes.coords, ',', 1 ),
        ordenesb_main.bajada_long = SUBSTRING_INDEX( SUBSTRING_INDEX( mensajes.coords, ',', 2 ) , ',' , -1 ),
        ordenesb_main.ord_procesado = 1
        WHERE ordenesb_main.id = $id_orden";

        $query = $this->db->query($sql);

        if ($query) {
          return TRUE;
        } else {
          return FALSE;
        }

    }


    function ordenEnviada($idEquipo = NULL)
    {
       $this->db->select('OM.id, OM.protocolo, OM.ord_procesado, EM.serie as equipo, MUN.descrip as municipio, TU.imei, OM.nro_msj');
       $this->db->from('ordenesb_main AS OM');
       $this->db->join('equipos_main AS EM', 'EM.id = OM.idequipo', 'left');
       $this->db->join('municipios AS MUN', 'MUN.id = OM.idproyecto', 'left');
       $this->db->join('tbl_users AS TU', 'TU.userId = OM.tecnico', 'left');
       $this->db->where('OM.activo',1);
       $this->db->where('OM.eliminado',0);
       $this->db->where('OM.enviado',1);
       $this->db->where('OM.recibido',1);
       $this->db->where('OM.ord_procesado !=',1);
       $this->db->where('OM.ord_procesado !=',2);
       $this->db->where('OM.idequipo',$idEquipo);

       $query = $this->db->get();
       return $query->result();
    }


    function equipos_enlazar($proyecto = NULL)
    {
      $this->db->select('EM.id, EM.serie');
      $this->db->from('equipos_main as EM');
      $this->db->where('EM.municipio', $proyecto);
      $this->db->where('LENGTH(EM.serie) >', 1);
      $this->db->not_like('EM.serie','-baj');
      $this->db->order_by('EM.serie','ASC');

      $query = $this->db->get();
      return $query->result();
    }



}

?>
