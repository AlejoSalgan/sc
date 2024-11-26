<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Verificacion_model extends CI_Model
{
  function verificacionListing($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$estados = NULL,$opciones)
  {
    $this->db->select('PM.id AS id_protocolo, PM.municipio, MUN.descrip as proyecto, PM.equipo_serie, EM.id AS id_equipo, PM.cantidad, PM.ts, VE.nombre as verificacion_nombre, PM.est_verificacion, VA.aprobados, VA.descartados, U.name as name_verificador');
    $this->db->from('protocolos_main AS PM');
    $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
    $this->db->join('municipios AS MUN', 'MUN.id = PM.municipio','left');
    $this->db->join('verificacion_estado AS VE', 'VE.id = PM.est_verificacion','left');
    $this->db->join('verificacion_asignados AS VA', 'VA.id_protocolo = PM.id','left');
    $this->db->join('tbl_users as U', 'U.userId = VA.usuario','left');

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




  function getListadoFotosEA($protocolo,$estado)
  {
    $this->db->select('EA.idprotocolo, EA.identrada, EA.imagen1, EA.estado, EA.imagen2, EA.imagen3, EA.imagen4');
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



  function getAsignacion($id_protocolo)
  {
      $this->db->select('VA.aprobados, VA.descartados');
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

//hay protocolos con estado verificacion en null?
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

// agregar

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
      $this->db->update('verificacion_asignados', $asignacionInfo);

      return TRUE;
  }

  // Eliminar 

  function eliminarProtocolo($id_protocolo)
  {
    $this->db->where('idprotocolo', $id_protocolo);
    $this->db->delete('entrada_auxiliar');

    return TRUE;
  }










}

?>
