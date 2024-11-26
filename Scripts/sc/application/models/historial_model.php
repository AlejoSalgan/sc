<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Historial_model extends CI_Model
{
    function addHistorial($historialInfo)
    {
        $this->db->trans_start();
        $this->db->insert('historial', $historialInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function getHistorialComp($componenteId)
    {
        $this->db->select('H.id, H.idequipo, H.idcomponente, H.idevento, H.origen, H.detalle, H.creadopor, H.fecha');
        $this->db->from('historial AS H');
        $this->db->where('H.idcomponente', $componenteId);

        $query = $this->db->get();
        return $query->result();
    }

    function getUltimoHistEq($equipoId)
    {
        $this->db->select('H.id, H.idequipo, H.idcomponente, H.idevento, H.reubicacion, H.origen, H.detalle, H.tipo, H.creadopor, H.fecha, H.creadopor, U.name as nameHistorial');
        $this->db->from('historial AS H');
        $this->db->join('tbl_users as U', 'U.userId = H.creadopor','left');
        $this->db->where('H.idequipo', $equipoId);
        $this->db->order_by("H.fecha", "desc");
        $this->db->limit(1);

        $query = $this->db->get();
        $row = $query->row();
		    return $row;
    }

    function historialEqListingCount($equipoId)
    {
        $this->db->select('H.id');
        $this->db->from('historial AS H');
        $this->db->join('equipos_main as E', 'E.id = H.idequipo','left');
        $this->db->where('H.idequipo', $equipoId);

        $query = $this->db->get();
        return count($query->result());
    }

    function historialEqListing($equipoId = '', $page, $segment, $origen)
    {
        $this->db->select('H.id, H.idequipo, H.idcomponente, H.idevento, H.reubicacion, H.origen, H.tipo, H.detalle, H.creadopor, H.observaciones, E.serie, EV.descrip AS descripEvento, Mun.descrip AS descripMuni, CT.descrip AS descripTipo, ES.descrip AS descripEstado, U.name as nameHistorial');
        $this->db->select("DATE_FORMAT(H.fecha, '%d-%m-%Y %H:%i:%s') AS fecha", FALSE);
        $this->db->from('historial AS H');
        $this->db->join('componentes_main as C', 'C.id = H.idcomponente','left');
        $this->db->join('eventos as EV', 'EV.id = H.idevento','left');
        $this->db->join('estados as ES', 'ES.id = H.idestado','left');
        $this->db->join('equipos_main as E', 'E.id = H.idequipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = H.reubicacion','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = E.tipo','left');
        $this->db->join('tbl_users as U', 'U.userId = H.creadopor','left');
        $this->db->where('H.idequipo', $equipoId);
        $this->db->where('H.origen', $origen);
        $this->db->order_by("H.fecha", "desc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    function historialCount($equipoId = '', $origen)
    {
        $this->db->select('H.id', FALSE);
        $this->db->from('historial AS H');
        $this->db->join('componentes_main as C', 'C.id = H.idcomponente','left');
        $this->db->join('eventos as EV', 'EV.id = H.idevento','left');
        $this->db->join('estados as ES', 'ES.id = H.idestado','left');
        $this->db->join('equipos_main as E', 'E.id = H.idequipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = H.reubicacion','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = E.tipo','left');
        $this->db->join('tbl_users as U', 'U.userId = H.creadopor','left');
        $this->db->where('H.idequipo', $equipoId);
        $this->db->where('H.origen', $origen);
        $this->db->order_by("H.fecha", "desc");

        $query = $this->db->get();
        return count($query->result());
    }

    function historialCompListingCount($componenteId)
    {
        $this->db->select('H.id');
        $this->db->from('historial AS H');
        $this->db->join('componentes_main as C', 'C.id = H.idcomponente','left');
        $this->db->where('H.idcomponente', $componenteId);

        $query = $this->db->get();
        return count($query->result());
    }

    function historialCompListing($componenteId = '', $page, $segment)
    {
        $this->db->select('H.id, H.idequipo, H.idcomponente, H.idevento, H.reubicacion, H.origen, H.detalle, H.creadopor, C.serie, EV.descrip AS descripEvento, CT.descrip AS descripTipo');
        $this->db->select("DATE_FORMAT(H.fecha, '%d-%m-%Y %H:%i:%s') AS fecha", FALSE);
        $this->db->from('historial AS H');
        $this->db->join('componentes_main as C', 'C.id = H.idcomponente','left');
        $this->db->join('eventos as EV', 'EV.id = H.idevento','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = C.idtipo','left');
        $this->db->where('H.idcomponente', $componenteId);
        $this->db->order_by("H.fecha", "desc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }

    function addFlotaHistorial($historialInfo)
    {
        $this->db->trans_start();
        $this->db->insert('flota_historial', $historialInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function historialNovedades($serie)
    {
        $this->db->select('FM.descrip as falla, OM.bajada_observ as observacion, OM.tecnico, RE.fecha, U.name as nameTecnico');
        $this->db->from('reparacion_main` AS RM');
        $this->db->join('ordenesb_main as OM', 'RM.nro_msj = OM.nro_msj','left');
        $this->db->join('fallas_main as FM', 'RM.falla = FM.id','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.tecnico','left');
        $this->db->join('reparacion_estados as RE', 'RE.orden = RM.id','left');

        $this->db->where('RM.serie', $serie);
        $this->db->where('RE.tipo', 1);
        $this->db->order_by("RE.fecha", "desc");

        $query = $this->db->get();
        return $query->result();
    }

    function historialDesestimados($serie)
    {
        $this->db->select('RE.fecha, RE.observ as observDesestimado, RE.orden, RE.usuario, U.name as nameUsuario');
        $this->db->from('reparacion_main` AS RM');
        $this->db->join('ordenesb_main as OM', 'RM.nro_msj = OM.nro_msj','left');
        $this->db->join('reparacion_estados as RE', 'RE.orden = RM.id','left');
        $this->db->join('tbl_users as U', 'U.userId = RE.usuario','left');

        $this->db->where('RM.serie', $serie);
        $this->db->where('RE.tipo', 12);
        $this->db->order_by("RE.fecha", "desc");

        $query = $this->db->get();
        return $query->result();
    }


    function countNovedades($serie)
    {
        $this->db->select('FM.descrip as falla, OM.bajada_observ as observacion, OM.tecnico, RE.fecha, U.name as nameTecnico');
        $this->db->from('reparacion_main` AS RM');
        $this->db->join('ordenesb_main as OM', 'RM.nro_msj = OM.nro_msj','left');
        $this->db->join('fallas_main as FM', 'RM.falla = FM.id','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.tecnico','left');
        $this->db->join('reparacion_estados as RE', 'RE.orden = RM.id','left');

        $this->db->where('RM.serie', $serie);
        $this->db->where('RE.tipo', 1);
        $this->db->order_by("RE.fecha", "desc");

        $query = $this->db->get();
        return count($query->result());
    }

    function countDesestimados($serie)
    {
        $this->db->select('RE.fecha, RE.observ as observDesestimado, RE.orden, RE.usuario, U.name as nameUsuario');
        $this->db->from('reparacion_main` AS RM');
        $this->db->join('ordenesb_main as OM', 'RM.nro_msj = OM.nro_msj','left');
        $this->db->join('reparacion_estados as RE', 'RE.orden = RM.id','left');
        $this->db->join('tbl_users as U', 'U.userId = RE.usuario','left');

        $this->db->where('RM.serie', $serie);
        $this->db->where('RE.tipo', 12);
        $this->db->order_by("RE.fecha", "desc");

        $query = $this->db->get();
        return count($query->result());
    }


    function historialDeposito($id_equipo)
    {
        $this->db->select('D.id, D.creado_por, D.ts_creado, US.name as name_creado, DEST.nombre_estado, DEST.label, (SELECT U.name FROM deposito_eventos as DEV LEFT JOIN tbl_users as U ON U.userID = DEV.usuario WHERE DEV.id_deposito = D.id ORDER BY DEV.id DESC LIMIT 1) as usuario_evento, (SELECT DEV.fecha FROM deposito_eventos as DEV WHERE DEV.id_deposito = D.id ORDER BY DEV.id DESC LIMIT 1) as fecha_evento, (SELECT DEV.observacion FROM deposito_eventos as DEV WHERE DEV.id_deposito = D.id ORDER BY DEV.id DESC LIMIT 1) as observacion');
        $this->db->from('deposito AS D');
        $this->db->join('deposito_estados as DEST', 'DEST.id_estado = D.estado','left');
        $this->db->join('tbl_users as US', 'US.userID = D.creado_por','left');
        $this->db->where('D.id_equipo', $id_equipo);
        $this->db->order_by('D.ts_creado');

        $query = $this->db->get();
        return $query->result();
    }


    function historialCalibraciones($id_equipo)
    {
        $this->db->select('CA.id, CTO.estado as estado_descrip, CTO.color_tipo, CS.verificacion as tipo_calibracion, CS.color_servicio, CA.fecha_alta, CA.creadopor, US.name as name_creado,

        (SELECT CAE.usuario
        FROM calibraciones_eventos as CAE
        WHERE CAE.num_orden = CA.id
        ORDER BY CAE.id DESC LIMIT 1) as id_usuario_evento,

        (SELECT U.name
        FROM calibraciones_eventos as CAE
        LEFT JOIN tbl_users as U ON U.userID = CAE.usuario
        WHERE CAE.num_orden = CA.id
        ORDER BY CAE.id DESC LIMIT 1) as usuario_evento,

        (SELECT CAE.fecha
        FROM calibraciones_eventos as CAE
        WHERE CAE.num_orden = CA.id
        ORDER BY CAE.id DESC LIMIT 1) as fecha_evento,

        (SELECT CAE.observacion
        FROM calibraciones_eventos as CAE
        WHERE CAE.num_orden = CA.id
        ORDER BY CAE.id DESC LIMIT 1) as observacion');

        $this->db->from('calibraciones as CA');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = CA.tipo_servicio','left');
        $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.id_tipoOrden = CA.tipo_orden','left');
        $this->db->join('tbl_users as US', 'US.userID = CA.creadopor','left');
        $this->db->where('CA.idequipo', $id_equipo);
        $this->db->order_by('CA.fecha_alta', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }






}
