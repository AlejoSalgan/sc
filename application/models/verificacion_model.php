<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Verificacion_model extends CI_Model
{
  function verificacionListing($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$estados = NULL,$opciones)
  {
    $this->db->select('PM.id AS id_protocolo, PM.municipio, MUN.descrip as proyecto, PM.equipo_serie, EM.id AS id_equipo, PM.cantidad, PM.ts, VE.nombre as verificacion_nombre, PM.est_verificacion, VA.cant_inicial, VA.aprobados, VA.descartados, U.name as name_verificador');
    $this->db->from('protocolos_main AS PM');
    $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
    $this->db->join('municipios AS MUN', 'MUN.id = PM.municipio','left');
    $this->db->join('verificacion_estado AS VE', 'VE.id = PM.est_verificacion','left');
    $this->db->join('verificacion_asignados AS VA', 'VA.id_protocolo = PM.id','left');
    $this->db->join('tbl_users as U', 'U.userId = VA.usuario','left');

    if (!is_null($estados)) {
      if (is_array($estados)) {
          $this->db->where_in('PM.est_verificacion', $estados);
      } else {
          $this->db->where('PM.est_verificacion =', $estados);
      }
    }

    if (in_array($role,array(20,21))) {
			$this->db->where('VA.usuario',$userId);
		}

    $this->db->order_by('PM.est_verificacion','DESC');
    $this->db->order_by('MUN.descrip','ASC');
    $this->db->order_by('PM.equipo_serie','ASC');
    $query = $this->db->get();

    if ($page != NULL) {
      return $query->result();
    }

    return count($query->result());
  }

  function getProtocolos_mainInfo($id_protocolo){
    $this->db->select('PM.id, PM.info_editables , PM.info_aprobados, PM.info_descartados, PM.info_verificacion');
    $this->db->from('protocolos_main AS PM');
    $this->db->where("PM.id", $id_protocolo);
    
    $query = $this->db->get();
    return $query->row_array();
  }


  function getProtocolos_impacto_final(){
    $this->db->select('PM.id');
    $this->db->from('protocolos_main AS PM');
    $this->db->where_in('PM.est_verificacion', 40);
    
    $query = $this->db->get();
    return $query->result();
  }


  function getListadoFotosEA($protocolo,$estado)
  {
    $this->db->select('EA.idprotocolo, EA.identrada, EA.imagen1, EA.estado, EA.imagen2, EA.imagen3, EA.imagen4,EA.dominio_edicion,EA.dominio_final,infraccion');
    $this->db->from('entrada_auxiliar AS EA');
    $this->db->where("EA.idprotocolo", $protocolo);
    $this->db->where("EA.estado", $estado);

    $query = $this->db->get();
    return $query->result();
  }

  function getFotosImpactar($protocolo,$estado)
  {
    $this->db->select('EA.identrada');
    $this->db->from('entrada_auxiliar AS EA');
    $this->db->where("EA.idprotocolo", $protocolo);
    $this->db->where("EA.estado", $estado);

    $query = $this->db->get();
    return $query->result();
  }

  function getDominiosImpactar($protocolo)
  {
    $this->db->select('EA.identrada,EA.dominio_final');
    $this->db->from('entrada_auxiliar AS EA');
    $this->db->where("EA.idprotocolo", $protocolo);
    $this->db->where('EA.dominio_edicion != EA.dominio_final');
    $query = $this->db->get();
    return $query->result();
  }

  function getInfraccionImpactar($protocolo)
{
    $this->db->select('EA.identrada, EA.infraccion');
    $this->db->from('entrada_auxiliar AS EA');
    $this->db->where("EA.idprotocolo", $protocolo);
    $this->db->where("EA.estado", "26");
    $this->db->where("(EA.infraccion = '98' OR EA.infraccion = '99')");
    $query = $this->db->get();
    return $query->result();
}





  function getProtocoloEntradaAux($protocolo)  // Trae todos los protocolso de una exportacion.
  {
      $this->db->select('EA.idprotocolo');
      $this->db->from('entrada_auxiliar AS EA');
      $this->db->where("EA.idprotocolo", $protocolo);
      $this->db->group_by('EA.idprotocolo');

      $query = $this->db->get();
      $row = $query->row();
      return $row;
  }



  function verificadores($verificadorRoles)
  {
    $this->db->select('U.userId, U.name');
    $this->db->from('tbl_users AS U');
    $this->db->where("U.isDeleted", 0);
    $this->db->where_in('U.roleId', $verificadorRoles);

    $query = $this->db->get();
    return $query->result();
  }


  function getIDprotocolo($id_protocolo)
  {
      $this->db->select('PM.id, PM.decripto, PM.equipo_serie, EM.id AS id_equipo, M.descrip as proyecto, PM.idexportacion');
      $this->db->from('protocolos_main AS PM');
      $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
      $this->db->join('municipios AS M', 'M.id = PM.municipio','left');
      $this->db->where('PM.id', $id_protocolo);
      $this->db->where('PM.decripto', 4);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
  }


  function getInfoProtocolo($id_protocolo)
  {
      $this->db->select('PM.id, PM.decripto, PM.equipo_serie, EM.id AS id_equipo, M.descrip as proyecto, PM.info_aprobados');
      $this->db->from('protocolos_main AS PM');
      $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
      $this->db->join('municipios AS M', 'M.id = PM.municipio','left');
      $this->db->where('PM.id', $id_protocolo);
      $this->db->where('PM.decripto', 4);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
  }


  function getAsignacion($id_protocolo)
  {
      $this->db->select('*');
      $this->db->from('verificacion_asignados AS VA');
      $this->db->where('VA.id_protocolo', $id_protocolo);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
  }


  
  function getProtocoloHabilitar($id_protocolo)
  {
      $this->db->select('PM.id, PM.decripto, PM.incorporacion_estado, PM.idexportacion, PM.numero_exportacion, PM.est_verificacion');
      $this->db->from('protocolos_main AS PM');
      $this->db->where('PM.id', $id_protocolo);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
  }


  function getProtocolosImpactados()
  {
      $this->db->select('PM.id');
      $this->db->from('protocolos_main AS PM');
      $this->db->where('PM.decripto', 4);
      $this->db->where('PM.incorporacion_estado', 65);
      $this->db->where('PM.idexportacion', 0);
      $this->db->where('PM.numero_exportacion', 0);
      $this->db->where('PM.est_verificacion', 0);

      $query = $this->db->get();
      return $query->result();
  }

  function getProtocolosProyectos($est_verificacion)
  {
      $this->db->select('COUNT(PM.id) AS cantidad, MUN.descrip as proyecto, PM.municipio as id_municipio');
      $this->db->from('protocolos_main AS PM');
      $this->db->join('municipios AS MUN', 'MUN.id = PM.municipio','left');
      $this->db->where('PM.decripto', 4);
      $this->db->where('PM.incorporacion_estado', 69);
      $this->db->where('PM.est_verificacion', $est_verificacion);
      $this->db->order_by('PM.municipio', 'ASC');
      $this->db->group_by('PM.municipio');

      $query = $this->db->get();
      return $query->result();
  }


  function listadoProtocolosProyectos($id_proyecto = NULL,$est_verificacion = NULL)
  {
      $this->db->select('PM.id');
      $this->db->from('protocolos_main AS PM');
      $this->db->where('PM.decripto', 4);
      $this->db->where('PM.incorporacion_estado', 69);
      $this->db->where('PM.est_verificacion', $est_verificacion);
      if (!is_null($id_proyecto)) {
        $this->db->where('PM.municipio', $id_proyecto);
      }

      $this->db->order_by('PM.id', 'ASC');

      $query = $this->db->get();
      return $query->result();
  }

// agregar- revisar porque no hay unique-key
  function addVerificacionAsignados($asignacionInfo) 
  {
      $this->db->trans_start();
      $this->db->insert('verificacion_asignados', $asignacionInfo);

      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();

      return $insert_id;
  }


// modificar
  function updateVerificacion($verificacionInfo, $protocolo)
    {
        $this->db->where('id', $protocolo);
        $this->db->update('protocolos_main', $verificacionInfo);

        return TRUE;
    }

  function updateAsignacion($asignacionInfo, $protocolo)
  {
      $this->db->where('id_protocolo', $protocolo);
      $result = $this->db->update('verificacion_asignados', $asignacionInfo);

      return $result;
  }


  //noo
  function updateProtocolosMainVerificacion($id_protocolo, $protocolos_mainInfo){
    $this->db->where('id', $id_protocolo);
    $result = $this->db->update('protocolos_main', $protocolos_mainInfo);

    return $result;
}
/***********/



//cambiar mal

  //template method de los 2 metodos de arriba , updateAsignacion 
  function actualizarAsignacionYProtocoloMain($id_protocolo, $asignacionInfo, $protocolos_mainInfo)
  {
    // Actualizar asignación
    $asignacion_actualizada = $this->updateAsignacion($asignacionInfo, $id_protocolo);

    // Actualizar protocolos_main
    $protocolo_main_actualizado = $this->updateProtocolosMainVerificacion($id_protocolo, $protocolos_mainInfo);

    // Devolver true si ambas actualizaciones fueron exitosas, false en caso contrario
    return $asignacion_actualizada && $protocolo_main_actualizado;
  }
/***********/


  // Eliminar 
  function eliminarProtocolo($id_protocolo)
  {
    $this->db->where('idprotocolo', $id_protocolo);
    $this->db->delete('entrada_auxiliar');

    return TRUE;
  }

  function eliminarVerificacionAsignados($id_protocolo)
  {
    $this->db->where('id_protocolo', $id_protocolo);
    $this->db->delete('verificacion_asignados');

    return TRUE;
  }



/***NUEVAS******/
  function update_entrada_auxiliar($id_26s,$id_27s){
      // Iniciar transacción
      $this->db->trans_start();

      // Actualizar registros con estado 26
      if (!empty($id_26s)) {
          foreach ($id_26s as $id) {
              $this->db->where('identrada', $id);
              $this->db->set('estado', 26);
              $this->db->update('entrada_auxiliar');
          }
      }

      // Actualizar registros con estado 27
      if (!empty($id_27s)) {
          foreach ($id_27s as $id) {
              $this->db->where('identrada', $id);
              $this->db->set('estado', 27);
              $this->db->update('entrada_auxiliar');
          }
      }

      // Completar transacción
      $this->db->trans_complete();

      // Verificar si la transacción se completó con éxito
      if ($this->db->trans_status() === FALSE) {
          // Si hay un error en la transacción, devuelve FALSE
          return FALSE;
      } else {
          // Si la transacción se completó con éxito, devuelve TRUE
          return TRUE;
      }
  }

  

  function update_verificacion_asignados($id_protocolo,$info_verificacion_asignados){

    $this->db->where('id_protocolo', $id_protocolo);
    $this->db->update('verificacion_asignados', $info_verificacion_asignados);

    return TRUE;
    
  }


  function update_entrada_auxiliar_dominio($modificados,$dominios_modificiados){
    // Iniciar transacción
    $this->db->trans_start();
    $total = count($modificados);
    // pre($modificados);
    // Actualizar registros con estado 26
    if (!empty($modificados)) {
        for($i =0 ; $i < $total; $i++) {
            // pre($i);
            // pre("dominio******");
            // pre($dominios_modificiados[$i]);
            // pre("id*******");
            // pre($modificados[$i]);

            $this->db->where('identrada', $modificados[$i]);
            $this->db->set('dominio_final', $dominios_modificiados[$i]);
            $this->db->update('entrada_auxiliar');
        }
    }  
    // die;
    // Completar transacción
    $this->db->trans_complete();

    // Verificar si la transacción se completó con éxito
    if ($this->db->trans_status() === FALSE) {
        // Si hay un error en la transacción, devuelve FALSE
        return FALSE;
    } else {
        // Si la transacción se completó con éxito, devuelve TRUE
        return TRUE;
    }
  }


  function update_entrada_auxiliar_infraccion($infraccion_modificada,$modificados){
  // Iniciar transacción
  $this->db->trans_start();
  $total = count($modificados);

  if (!empty($modificados)) {
      for($i =0 ; $i < $total; $i++) {
          $this->db->where('identrada', $modificados[$i]);
          $this->db->set('infraccion', $infraccion_modificada[$i]);
          $this->db->update('entrada_auxiliar');
      }
  }  
  // die;
  $this->db->trans_complete();

  if ($this->db->trans_status() === FALSE) {
      return FALSE;
  } else {
      return TRUE;
  }
  }





}



?>
