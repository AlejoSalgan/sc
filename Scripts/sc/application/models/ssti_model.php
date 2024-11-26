<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ssti_model extends CI_Model
{
  function fotosDesencriptadasListing($searchText = '', $criterio, $opciones,$role,$userId)
  {
    $this->db->select('PM.id AS id_protocolo, PM.municipio, M.descrip as proyecto, PM.equipo_serie, EM.id AS id_equipo, PM.cantidad, PM.ts');
    $this->db->from('protocolos_main AS PM');
    $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
    $this->db->join('municipios AS M', 'M.id = PM.municipio','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
    }

    $this->db->where('PM.decripto', 4);
    $this->db->where('PM.idexportacion', 0);
    $this->db->not_like('PM.equipo_serie','DTV2_');
    $this->db->not_like('PM.equipo_serie','DIVEC_');
    $this->db->not_like('PM.equipo_serie','LUTEC_');

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

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->order_by('PM.ts','DESC');
    $this->db->limit(150);

    $query = $this->db->get();
    return $query->result();
  }




  function exportacionesList($tipo,$searchText = '',$criterio,$page = NULL, $segment= NULL)  // Listado de las exportaciones.
  {
      $this->db->select('COUNT(PM.id) as cantidadProtocolos, PM.numero_exportacion, MUN.descrip as proyecto');
      $this->db->from('protocolos_main AS PM');
      //$this->db->join('ordenesb_main as OM', 'PM.id = OM.protocolo','left');
      $this->db->join('municipios as MUN', 'MUN.id = PM.municipio','left');
      //$this->db->where('PM.nro_msj = OM.nro_msj');
      $this->db->group_by('PM.numero_exportacion');
      $this->db->order_by('PM.numero_exportacion', 'DESC');

      if(!empty($searchText)) {
          switch ($criterio) {
              case 1:
                  $likeCriteria = "(PM.numero_exportacion  LIKE '%".$searchText."%')";
                  break;

              case 2:
                  $likeCriteria = "(MUN.descrip LIKE '%".$searchText."%')";
                  break;

              default:
                  $likeCriteria = "(PM.numero_exportacion  LIKE '%".$searchText."%'
                                      OR  MUN.descrip LIKE '%".$searchText."%'
                                  )";
                  break;
          }

          $this->db->where($likeCriteria);
      }

      if ($tipo == 0) {
        $query = $this->db->get();
        return $query->num_rows();
      } else {
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
      }
  }








  function editadas_listing($searchText = '', $criterio, $opciones,$role,$userId)
  {
    $this->db->select('PM.id AS id_protocolo, PM.municipio, M.descrip as proyecto, PM.equipo_serie, EM.id AS id_equipo, PM.cantidad, PM.fecha');
    $this->db->from('protocolos_main AS PM');
    $this->db->join('equipos_main AS EM', 'EM.serie = PM.equipo_serie','left');
    $this->db->join('municipios AS M', 'M.id = PM.municipio','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
    }

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

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->order_by('PM.ts','DESC');
    $this->db->limit(150);

    $query = $this->db->get();
    return $query->result();
  }













  function getProtocolosExpo($num_Expo)  // Trae todos los protocolos de una exportacion.
  {
      $this->db->select('PM.id, MUN.descrip, PM.idequipo, PM.equipo_serie, OM.id as idOrden', FALSE);
      $this->db->from('protocolos_main AS PM');
      $this->db->join('municipios as MUN', 'MUN.id = PM.municipio','left');
      $this->db->join('ordenesb_main as OM', 'PM.id = OM.protocolo','left');
      $this->db->where("PM.numero_exportacion", $num_Expo);

      $query = $this->db->get();
      return $query->result();
  }


  function listado_equipos($proyecto = NULL)
  {
    $this->db->select('EM.id, EM.serie');
    $this->db->from('equipos_main as EM');
    $this->db->where('EM.municipio', $proyecto);
    $this->db->where('LENGTH(EM.serie) >', 1);
    $this->db->not_like('EM.serie','-baj');
    $this->db->order_by('EM.serie',ASC);

    $query = $this->db->get();
    return $query->result();
  }

  


  function addProtocoloEA($fotosInfo) //Agrego un nuevo evento.
  {
      $this->db->trans_start();
      $this->db->insert('entrada_auxiliar', $fotosInfo);

      $insert_id = $this->db->insert_id();
      $this->db->trans_complete();

      return $insert_id;
  }

 


  function updateEntradaAuxiliar($entradaInfo, $id_entrada) //Modifico un remito.
  {
      $this->db->where('identrada', $id_entrada);
      $this->db->update('entrada_auxiliar', $entradaInfo);

      return TRUE;
  }


  






}

?>
