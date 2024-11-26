<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Instalaciones_model extends CI_Model
{
  // LISTADOS //

    function listadoSolicitudes($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL)
    {
        $this->db->select('RE.id, MUN.descrip as proyecto, ET.descrip as tipos_equipo, RE.direccion, IP.tipo_prioridad, ITO.tipo as tipoOrden, IE.tipo_estado, TU.name as solicitado_name, RE.solicitado_por, IP.label as prioridad_label, RE.fecha_ts');
        $this->db->from('instalaciones_relevamiento as RE');
        $this->db->join('municipios as MUN', 'MUN.id = RE.id_proyecto','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = RE.id_tipo_equipo','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = RE.id_prioridad','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = RE.tipo_orden','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = RE.estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = RE.solicitado_por','left');
        $this->db->where('RE.tipo_orden', 10);
        $this->db->where('RE.estado', 10);

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }






















    function listadoRelevamientos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL)
    {
        $this->db->select('RE.id, MUN.descrip as proyecto, ET.descrip as tipos_equipo, RE.direccion, IP.tipo_prioridad, ITO.tipo as tipoOrden, IE.tipo_estado, TU.name as solicitado_name, RE.solicitado_por, IP.label as prioridad_label, RE.fecha_ts');
        $this->db->from('instalaciones_relevamiento as RE');
        $this->db->join('municipios as MUN', 'MUN.id = RE.id_proyecto','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = RE.id_tipo_equipo','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = RE.id_prioridad','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = RE.tipo_orden','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = RE.estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = RE.solicitado_por','left');
        $this->db->where('RE.tipo_orden', 11);
        $this->db->where('RE.estado', 10);

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }
























    function listadoFinalizadas($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL)
    {
        $this->db->select('RE.id, MUN.descrip as proyecto, ET.descrip as tipos_equipo, RE.direccion, IP.tipo_prioridad, ITO.tipo as tipoOrden, IE.tipo_estado, TU.name as solicitado_name, RE.solicitado_por, IP.label as prioridad_label, RE.fecha_ts');
        $this->db->from('instalaciones_relevamiento as RE');
        $this->db->join('municipios as MUN', 'MUN.id = RE.id_proyecto','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = RE.id_tipo_equipo','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = RE.id_prioridad','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = RE.tipo_orden','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = RE.estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = RE.solicitado_por','left');
        $estado = array(30,40,50);
        $this->db->where_in('RE.estado', $estado);

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }









    function listadoDesintalacion($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL,$estado = NULL)
    {
        $this->db->select('ID.id, MUN.descrip as proyecto, IP.tipo_prioridad, IE.tipo_estado, IE.color, TU.name as solicitado_name, ID.solicitado_por, IP.label as prioridad_label, EM.serie as equipoSerie, ID.id_equipo, ID.fecha_visita, ID.estado, IDV.fecha_visita');
        $this->db->from('instalaciones_desintalacion as ID');
        $this->db->join('equipos_main as EM', 'ID.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = ID.id_proyecto','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = ID.id_prioridad','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = ID.estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = ID.solicitado_por','left');
        $this->db->join('instalaciones_desinstalacion_visitas as IDV', 'IDV.id_orden = ID.id AND IDV.id = (SELECT MAX(id) FROM instalaciones_desinstalacion_visitas )','left');

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if (!is_null($estado)) {
            if (is_array($estado)) {
                $this->db->where_in('ID.estado', $estado);
            } else {
                $this->db->where('ID.estado =', $estado);
            }
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }




    function listadoSolicitudesInstalacion($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL)
    {
        $this->db->select('IIG.id, MUN.descrip as proyecto, IP.tipo_prioridad, TU.name as solicitado_name, IIG.solicitado_por, IP.label as prioridad_label, IIG.cantidad, IIG.fecha_solicitacion, IIG.aprobado');
        $this->db->from('instalaciones_instalacion_grupo as IIG');
        $this->db->join('municipios as MUN', 'MUN.id = IIG.id_proyecto','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = IIG.id_prioridad','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IIG.solicitado_por','left');

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }











    function listadoInstalacion($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL,$estado = NULL)
    {
        $this->db->select('II.id, ET.descrip as tipo_equipo_descrip, EM.serie as equipo_serie, II.fecha_limite, II.direccion, MUN.descrip as proyecto, II.id_grupo, IE.tipo_estado, IE.color, II.estado, IIV.fecha_visita');
        $this->db->from('instalaciones_instalacion as II');
        $this->db->join('equipos_tipos as ET', 'ET.id = II.tipo_equipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = II.id_equipo','left');
        $this->db->join('instalaciones_instalacion_grupo as IIG', 'IIG.id = II.id_grupo','left');
        $this->db->join('municipios as MUN', 'MUN.id = IIG.id_proyecto','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = II.estado','left');
        $this->db->join('instalaciones_instalacion_visitas as IIV', 'IIV.id_orden = II.id AND IIV.id = (SELECT MAX(id) FROM instalaciones_instalacion_visitas )','left');


        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }

        if (!is_null($estado)) {
            if (is_array($estado)) {
                $this->db->where_in('II.estado', $estado);
            } else {
                $this->db->where('II.estado =', $estado);
            }
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }































    function tiposPrioridades()
    {
      $this->db->select('IP.id, IP.tipo_prioridad');
      $this->db->from('instalaciones_prioridades as IP');
      $this->db->order_by('IP.tipo_prioridad',ASC);

      $query = $this->db->get();
      return $query->result();
    }


    function getEquiposDesintalacion($proyecto = NULL)
    {
      $this->db->select('EM.id, EM.serie, EV.descrip,');
      $this->db->from('equipos_main as EM');
      $this->db->join('eventos as EV', 'EV.id = EM.evento_actual','left');

      if ($proyecto) {
    		$this->db->where('EM.municipio', $proyecto);
    	}

      //Equipos Fijos
      $this->db->where('EM.tipo_equipo', 0);
      $this->db->order_by('EM.serie',ASC);

      $query = $this->db->get();
      return $query->result();
    }

    function getElementos()
    {
      $this->db->select('IE.id, IE.elemento');
      $this->db->from('instalaciones_elementos as IE');
      $this->db->where('IE.estado', 1);
      $this->db->order_by('IE.elemento',ASC);

      $query = $this->db->get();
      return $query->result();
    }



    function eventosRelevamientos($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('IRE.id, IRE.observacion, IRE.usuario, IRE.fecha, TU.name, IE.tipo_estado, IE.color as estado_label');
        $this->db->from('instalaciones_relevamiento_eventos as IRE');
        $this->db->join('instalaciones_estados as IE', 'IE.id = IRE.id_estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IRE.usuario','left');
        $this->db->where('IRE.id_orden', $id_orden);

        $query = $this->db->get();
        return $query->result();
    }

    function eventosDesintalacion($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('IDE.id, IDE.observacion, IDE.usuario, IDE.fecha, TU.name, IE.tipo_estado, IE.color as estado_label');
        $this->db->from('instalaciones_desintalacion_eventos as IDE');
        $this->db->join('instalaciones_estados as IE', 'IE.id = IDE.id_estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IDE.usuario','left');
        $this->db->where('IDE.id_orden', $id_orden);

        $query = $this->db->get();
        return $query->result();
    }

    function eventosInstalacion($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('IIE.id, IIE.observacion, IIE.usuario, IIE.fecha, TU.name, IE.tipo_estado, IE.color as estado_label');
        $this->db->from('instalaciones_instalacion_eventos as IIE');
        $this->db->join('instalaciones_estados as IE', 'IE.id = IIE.id_estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IIE.usuario','left');
        $this->db->where('IIE.id_orden', $id_orden);

        $query = $this->db->get();
        return $query->result();
    }

    function getElementosAsignados($id_orden)
    {
        $this->db->select('IEA.id_elemento');
        $this->db->from('instalaciones_elementos_asignaciones as IEA');
        $this->db->where('IEA.id_orden', $id_orden);

        $query = $this->db->get();
        $result = $query->result();
        $salida = array();

        foreach ($result as $valor) {
          $salida[] = $valor->id_elemento;
        }

        return $salida;
    }

    function getElementosIDasignados($id_orden, $reutilizacion = NULL)
    {
        $this->db->select('IEA.id');
        $this->db->from('instalaciones_elementos_asignaciones as IEA');
        $this->db->where('IEA.id_orden', $id_orden);
        if ($reutilizacion == 1) {
          $this->db->where('IEA.reutilizacion', 1);
        }

        $query = $this->db->get();
        $result = $query->result();
        $salida = array();

        foreach ($result as $valor) {
          $salida[] = $valor->id;
        }

        return $salida;
    }


    function verElementosAsignados($id_orden)
    {
        $this->db->select('IEA.id, IEA.id_elemento, IE.elemento');
        $this->db->from('instalaciones_elementos_asignaciones as IEA');
        $this->db->join('instalaciones_elementos as IE', 'IE.id = IEA.id_elemento','left');
        $this->db->where('IEA.id_orden', $id_orden);

        $query = $this->db->get();
        return $query->result();
    }



    function getArchivosInstalaciones($id_orden, $tipo_orden = NULL, $estado = 0, $count = NULL)
    {
        $this->db->select('IA.id, IA.nombre_archivo, IA.tipo_documentacion, IA.observacion, IA.archivo, IA.tipo, IA.creado_por, IA.fecha_ts, U.name');
        $this->db->from('instalaciones_archivos as IA');
        $this->db->join('tbl_users as U', 'IA.creado_por = U.userId','left');
        $this->db->where('IA.orden', $id_orden);
        $this->db->where('IA.tipo_orden', $tipo_orden);
        $this->db->where('IA.estado', $estado);
        $this->db->where('IA.activo', 1);


        $query = $this->db->get();
        if ($count == NULL) {
          return $query->result();
        } else {
          return count($query->result());
        }
    }

    function getSolicitudesInstalaciones($id_orden)
    {
        $this->db->select('II.id, ET.descrip as tipo_equipo_descrip, EM.serie as equipo_serie, II.fecha_limite, II.direccion, II.observaciones');
        $this->db->from('instalaciones_instalacion as II');
        $this->db->join('equipos_tipos as ET', 'ET.id = II.tipo_equipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = II.id_equipo','left');
        $this->db->where('II.id_grupo', $id_orden);

        $query = $this->db->get();
        return $query->result();
    }


//////////////// AGREGAR /////////////

    function agregarSolicitud($relevamientoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('instalaciones_relevamiento', $relevamientoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }


    function addEvento($eventoInfo,$tabla)
    {
      $this->db->trans_start();
      $this->db->insert($tabla, $eventoInfo);

      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();

      return TRUE;
    }


    function agregarOrdenDesintalacion($desintalacionInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('instalaciones_desintalacion', $desintalacionInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function addEventoDesintalacion($eventoInfo)
    {
      $this->db->trans_start();
      $this->db->insert('instalaciones_desintalacion_eventos', $eventoInfo);

      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();

      return TRUE;
    }

    function agregarElemento($elemento) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('instalaciones_elementos_asignaciones', $elemento);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }



    function addGrupoInstalacion($grupoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('instalaciones_instalacion_grupo', $grupoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function addOrdenInstalacion($ordenInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('instalaciones_instalacion', $ordenInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }




    function addVisita($visitaInfo,$tabla_visitas)
    {
      $this->db->trans_start();
      $this->db->insert($tabla_visitas, $visitaInfo);

      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();

      return TRUE;
    }



    //////////////// MODIFICAR /////////////

    function editarSolicitud($relevamientoInfo, $id_orden)
    {
        $this->db->where('id', $id_orden);
        $this->db->update('instalaciones_relevamiento', $relevamientoInfo);

        return TRUE;
    }

    function editarDesintalacion($desintalacionInfo, $id_orden)
    {
        $this->db->where('id', $id_orden);
        $this->db->update('instalaciones_desintalacion', $desintalacionInfo);

        return TRUE;
    }

    function editarAsignacionElemento($asignacionInfo, $id_asignado)
    {
        $this->db->where('id', $id_asignado);
        $this->db->update('instalaciones_elementos_asignaciones', $asignacionInfo);

        return TRUE;
    }

    function reiniciarUtilizacionElemento($asignacionInfo, $id_orden)
    {
        $this->db->where('id_orden', $id_orden);
        $this->db->update('instalaciones_elementos_asignaciones', $asignacionInfo);

        return TRUE;
    }

    function editarGrupoInstalacion($grupoInfo, $id_grupo)
    {
        $this->db->where('id', $id_grupo);
        $this->db->update('instalaciones_instalacion_grupo', $grupoInfo);

        return TRUE;
    }

    function editarInstalacion1($instalacionInfo, $id_grupo)
    {
        $this->db->where('id_grupo', $id_grupo);
        $this->db->update('instalaciones_instalacion', $instalacionInfo);

        return TRUE;
    }

    function editarInstalacion2($instalacionInfo, $id_orden)
    {
        $this->db->where('id', $id_orden);
        $this->db->update('instalaciones_instalacion', $instalacionInfo);

        return TRUE;
    }

    function editarOrdenGeneral($ordenInfo, $id_orden, $tabla)
    {
        $this->db->where('id', $id_orden);
        $this->db->update($tabla, $ordenInfo);

        return TRUE;
    }

    //////////////// ELIMINAR /////////////

    function eliminarElementos($id_orden)
    {
      $this->db->where('id_orden', $id_orden);
      $this->db->delete('instalaciones_elementos_asignaciones');

      return TRUE;
    }

    function eliminarSolicitudInstalacion($id_orden)
    {
      $this->db->where('id', $id_orden);
      $this->db->delete('instalaciones_instalacion');

      return TRUE;
    }

    ///////////// OBTENER INFORMACION  ///////////////////////


    function getOrden($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('RE.id, MUN.descrip as proyecto, ET.descrip as tipos_equipo, RE.direccion, IP.tipo_prioridad, ITO.tipo as tipoOrden, IE.tipo_estado, TU.name as solicitado_name, RE.solicitado_por, IP.label as prioridad_label, RE.fecha_ts, RE.id_tipo_equipo, RE.id_prioridad, RE.id_proyecto, RE.observaciones, RE.tipo_orden, IE.color as estado_label');
        $this->db->from('instalaciones_relevamiento as RE');
        $this->db->join('municipios as MUN', 'MUN.id = RE.id_proyecto','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = RE.id_tipo_equipo','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = RE.id_prioridad','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = RE.tipo_orden','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = RE.estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = RE.solicitado_por','left');
        $this->db->where('RE.id', $id_orden);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    function getOrdenDesintalacion($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('ID.id, MUN.descrip as proyecto, IP.tipo_prioridad, IE.tipo_estado, IE.color, TU.name as solicitado_name, ID.solicitado_por, IP.label as prioridad_label, EM.serie as equipoSerie, ID.id_equipo, ID.fecha_visita, ID.id_proyecto, ID.id_prioridad, ID.observaciones, ID.motivo, ID.destino, ID.destino_detalle, ID.elementos_detalles, IE.color as estado_label, ITO.tipo as tipoOrden, ID.tipo_orden');
        $this->db->from('instalaciones_desintalacion as ID');
        $this->db->join('equipos_main as EM', 'ID.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = ID.id_proyecto','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = ID.id_prioridad','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = ID.estado','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = ID.tipo_orden','left');
        $this->db->join('tbl_users as TU', 'TU.userId = ID.solicitado_por','left');
        $this->db->where('ID.id', $id_orden);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }


    function getOrdenInstalacion($id_orden) //Obtengo la informacion del remito.
    {
        $this->db->select('II.id, ET.descrip as tipo_equipo_descrip, EM.serie as equipo_serie, II.fecha_limite, II.direccion, MUN.descrip as proyecto, II.id_grupo, IE.tipo_estado, IE.color, IE.color as estado_label, II.estado, ITO.tipo as tipoOrden, II.tipo_orden, II.fecha_ts, TU.name as solicitado_name, IIG.solicitado_por, IIG.fecha_solicitacion, IIV.fecha_visita, IIV.observacion as observaciones_visita, TU.imei, IIG.id_proyecto, IIG.cantidad');
        $this->db->from('instalaciones_instalacion as II');
        $this->db->join('equipos_tipos as ET', 'ET.id = II.tipo_equipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = II.id_equipo','left');
        $this->db->join('instalaciones_instalacion_grupo as IIG', 'IIG.id = II.id_grupo','left');
        $this->db->join('municipios as MUN', 'MUN.id = IIG.id_proyecto','left');
        $this->db->join('instalaciones_estados as IE', 'IE.id = II.estado','left');
        $this->db->join('instalaciones_tipo_ordenes as ITO', 'ITO.id = II.tipo_orden','left');
        $this->db->join('instalaciones_instalacion_visitas as IIV', 'IIV.id_orden = II.id','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IIG.solicitado_por','left');
        $this->db->where('II.id', $id_orden);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }






    function getGrupoInfo($id_orden)
    {
        $this->db->select('IIG.id, MUN.descrip as proyecto, IP.tipo_prioridad, TU.name as solicitado_name, IIG.solicitado_por, IP.label as prioridad_label, IIG.cantidad, IIG.fecha_solicitacion');
        $this->db->from('instalaciones_instalacion_grupo as IIG');
        $this->db->join('municipios as MUN', 'MUN.id = IIG.id_proyecto','left');
        $this->db->join('instalaciones_prioridades as IP', 'IP.id = IIG.id_prioridad','left');
        $this->db->join('tbl_users as TU', 'TU.userId = IIG.solicitado_por','left');
        $this->db->where('IIG.id', $id_orden);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }



    function ultimoElemento()
    {
        $this->db->select_max('id');
        $this->db->from('instalaciones_elementos');

        $query = $this->db->get();
        $result = $query->row();
        return $result->id;
    }

    /*

    function comparacionHistorial($texto, $valor_ant, $valor_actual)
    {
      if ($valor_ant != $valor_actual) {
        return "$texto <strong>$valor_ant</strong> se cambio por <span class='text-primary'>$valor_actual</span>. <br>";
      } else {
        return FALSE;
      }
    }


*/











}

?>
