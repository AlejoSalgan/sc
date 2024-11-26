<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Perifericos_model extends CI_Model
{
  // LISTADOS //

    function listadoPerifericos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones = NULL)
    {
        $this->db->select('PE.id, PE.serie, PE.estado, PE.fecha_alta, PT.nombre_tipo, EM.serie as EM_serie, PE.id_equipo, MUN.descrip as proyecto, PES.nombre_estado, PES.label, PE.comunicacion, PE.id_tipo, EP.descrip as socio');
        $this->db->from('perifericos as PE');
        $this->db->join('perifericos_tipos as PT', 'PT.id = PE.id_tipo','left');
        $this->db->join('equipos_main as EM', 'PE.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = EM.municipio','left');
        $this->db->join('perifericos_estados as PES', 'PES.id_estado = PE.estado','left');
        $this->db->join('equipos_propietarios as EP', 'EP.id = PE.socio','left');

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


    function tiposPerifericos()
    {
      $this->db->select('PT.id, PT.nombre_tipo');
      $this->db->from('perifericos_tipos as PT');
      $this->db->order_by('PT.nombre_tipo',ASC);

      $query = $this->db->get();
      return $query->result();
    }


//////////////// AGREGAR /////////////



    function agregarPeriferico($perifericoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('perifericos', $perifericoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }


    function agregarHistorial($perifericoHistorial) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('perifericos_historial', $perifericoHistorial);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    //////////////// MODIFICAR /////////////


    function editarPeriferico($perifericoInfo,$id_periferico) //Modifico un remito.
    {
        $this->db->where('id', $id_periferico);
        $this->db->update('perifericos', $perifericoInfo);

        return TRUE;
    }


    ///////////// OBTENER INFORMACION  ///////////////////////


    function getPeriferico($id_periferico) //Obtengo la informacion del remito.
    {
        $this->db->select('PE.id, PE.id_equipo, EM.municipio, PE.id_tipo, PE.socio, PE.descrip as observacion,
        PE.serie, PE.estado, PE.fecha_alta, PT.nombre_tipo, EM.serie as EM_serie, MUN.descrip as proyecto, PES.nombre_estado, PES.label, EP.descrip as socio_descrip, PE.creado_por, U.name');
        $this->db->from('perifericos as PE');
        $this->db->join('perifericos_tipos as PT', 'PT.id = PE.id_tipo','left');
        $this->db->join('equipos_main as EM', 'PE.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = EM.municipio','left');
        $this->db->join('perifericos_estados as PES', 'PES.id_estado = PE.estado','left');
        $this->db->join('equipos_propietarios as EP', 'EP.id = PE.socio','left');
        $this->db->join('tbl_users as U', 'U.userId = PE.creado_por','left');
        $this->db->where('PE.id', $id_periferico);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }


    function comparacionHistorial($texto, $valor_ant, $valor_actual)
    {
      if ($valor_ant != $valor_actual) {
        return "$texto <strong>$valor_ant</strong> se cambio por <span class='text-primary'>$valor_actual</span>. <br>";
      } else {
        return FALSE;
      }
    }


    function getTipoPeriferico($id_tipo)
    {
        $this->db->select('nombre_tipo');
        $this->db->from('perifericos_tipos');
        $this->db->where('id', $id_tipo);
        $query = $this->db->get();

        $result = $query->row();
        return $result->nombre_tipo;
    }


    function SociosAsignados($id_equipo)
    {
        $this->db->select('PE.socio, EP.descrip');
        $this->db->distinct();
        $this->db->from('perifericos as PE');
        $this->db->join('equipos_propietarios as EP', 'EP.id = PE.socio','left');
        $this->db->where('id_equipo', $id_equipo);

        $query = $this->db->get();
        return $query->result();
    }

    function historialPeriferico($id_periferico) //Obtengo la informacion del remito.
    {
        $this->db->select('PH.id, PH.detalle, PH.observacion, PH.usuario, PH.fecha, U.name, PEV.nombre_evento, PEV.label_evento');
        $this->db->from('perifericos_historial as PH');
        $this->db->join('perifericos_eventos as PEV', 'PEV.id_evento = PH.evento','left');
        $this->db->join('tbl_users as U', 'U.userId = PH.usuario','left');
        $this->db->where('PH.id_periferico', $id_periferico);

        $query = $this->db->get();
        return $query->result();
    }
































}

?>
