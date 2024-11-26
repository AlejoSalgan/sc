<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Socios_model extends CI_Model
{
  // LISTADOS //
    function listadoRemitos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$estado = NULL) //Obtengo la lista de los remitos y a la vez los cuento.
    {
        $this->db->select('SO.id, SO.fecha_ingreso, SO.id_estado, SO.num_remito, SO.id_orden, SE.estado as tipo_estado, SE.label, EM.serie, EM.id as idEquipo, MUN.descrip, P.descrip AS descripPropietario, PE.serie as serie_periferico, PT.nombre_tipo as tipo_periferico');
        $this->db->from('socios as SO');
        $this->db->join('equipos_main as EM', 'SO.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = EM.municipio','left');
        $this->db->join('socios_estados as SE', 'SE.id_estado = SO.id_estado','left');
        $this->db->join('equipos_propietarios as P', 'P.id = EM.idpropietario','left');
        $this->db->join('perifericos as PE', 'PE.id_equipo = SO.id_equipo ','left');
        $this->db->join('perifericos_tipos as PT', 'PT.id = PE.id_tipo','left');

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(SO.num_remito  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(MUN.descrip  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(SO.num_remito  LIKE '%".$searchText."%' OR  EM.serie  LIKE '%".$searchText."%' OR  MUN.descrip  LIKE '%".$searchText."%')";
                    break;
            }
            $this->db->where($likeCriteria);
        }

        switch ($role) {
            case 60:
            case 61:
            case 62:
            case 63:
            /*
                    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
                    $this->db->join('equipos_propietarios as EP', 'EP.descrip = EMOD.asociado','left');
                    $this->db->join('tbl_users as U', 'U.asociado = EP.id','left');
                    $this->db->where('U.userId', $userId);
            */
                    $this->db->join('tbl_users as U', 'U.asociado = SO.id_asociado','left');
                    $this->db->where('U.userId', $userId);
               break;
        }

        if (!is_null($estado)) {
            if (is_array($estado)) {
                $this->db->where_in('SE.id_estado', $estado);
            } else {
                $this->db->where('SE.id_estado =', $estado);
            }
        }

        $this->db->group_by('SO.id');
        $this->db->order_by('id', 'DESC');

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }

        return count($query->result());
    }


// AGREGAR //
    function agregarRemito($remitoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('socios', $remitoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarEvento($eventoInfo) //Agrego un nuevo evento.
    {
        $this->db->trans_start();
        $this->db->insert('socios_eventos', $eventoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarPresupuesto($presupuestoInfo) //Agrego un nuevo evento.
    {
        $this->db->trans_start();
        $this->db->insert('socios_presupuestos', $presupuestoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

// MODIFICAR //
    function updateRemito($remitoInfo, $id_remito) //Modifico un remito.
    {
        $this->db->where('id', $id_remito);
        $this->db->update('socios', $remitoInfo);

        return TRUE;
    }

    function updateArchivo($presupuestoInfo, $id) //Modifico un remito.
    {
        $this->db->where('id', $id);
        $this->db->update('socios_presupuestos', $presupuestoInfo);

        return TRUE;
    }

// OBTENER INFORMACION //
    function getRemito($id_remito) //Obtengo la informacion del remito.
    {
      $this->db->select('SO.id, SO.fecha_ingreso, SO.id_estado, SO.num_remito, SO.id_orden, SO.deposito, SO.id_equipo, SE.estado as tipo_estado, SE.label, SE.descrip, EM.serie, MUN.descrip, U.name as nameCreadoPor, P.descrip AS descripPropietario, MUN.id as id_proyecto');
      $this->db->from('socios as SO');
      $this->db->join('equipos_main as EM', 'SO.id_equipo = EM.id','left');
      $this->db->join('municipios as MUN', 'MUN.id = EM.municipio','left');
      $this->db->join('socios_estados as SE', 'SE.id_estado = SO.id_estado','left');
      $this->db->join('tbl_users as U', 'U.userId = SO.creado_por','left');
      $this->db->join('equipos_propietarios as P', 'P.id = EM.idpropietario','left');
      $this->db->where('SO.id', $id_remito);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }

    function getObservaciones($num_remito) //Obtengo las observaciones del remito.
    {
      $this->db->select('SEV.id, SEV.fecha, SEV.observacion, U.name, R.role');
      $this->db->from('socios_eventos as SEV');
      $this->db->join('tbl_users as U', 'U.userId = SEV.creado_por','left');
      $this->db->join('tbl_roles as R', 'R.roleId = U.roleId','left');
      $this->db->where('SEV.num_remito', $num_remito);

      $query = $this->db->get();
      return $query->result();
    }

    function contarRemitos($userId,$role,$tipo) //Cuentos los remitos.
    {
      $this->db->select('SO.id');
      $this->db->from('socios as SO');
      $this->db->join('equipos_main as EM', 'SO.id_equipo = EM.id','left');
      switch ($role) {
          case 60:
          case 61:
          case 62:
          case 63:
                  $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
                  $this->db->join('equipos_propietarios as EP', 'EP.descrip = EMOD.asociado','left');
                  $this->db->join('tbl_users as U', 'U.asociado = EP.id','left');
                  $this->db->where('U.userId', $userId);
             break;
      }
      $this->db->where('SO.id_estado', $tipo);

      $query = $this->db->get();
      return count($query->result());
    }

    function getPresupuestos($id_remito) //Obtengo las observaciones del remito.
    {
      $this->db->select('SP.id, SP.tipo, SP.num_presupuesto, SP.fecha_presupuesto, SP.observacion, SP.archivo');
      $this->db->from('socios_presupuestos as SP');
      $this->db->where('SP.id_remito', $id_remito);
      $this->db->where('SP.activo', 1);

      $query = $this->db->get();
      return $query->result();
    }

    function getArchivo($id) //Obtengo las observaciones del remito.
    {
      $this->db->select('SP.id, SP.id_remito, SP.archivo');
      $this->db->from('socios_presupuestos as SP');
      $this->db->where('SP.id', $id);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }

    function existeNumRemito($num_remito) //Si existe un numero de remito.
    {
      $this->db->select('S.id');
      $this->db->from('socios as S');
      $this->db->where('S.num_remito', $num_remito);

      $query = $this->db->get();
	    return $query->num_rows();
    }

    function existeNumPresupuesto($num_presupuesto) //Si existe un numero de presupuesto.
    {
      $this->db->select('SP.id');
      $this->db->from('socios_presupuestos as SP');
      $this->db->where('SP.num_presupuesto', $num_presupuesto);

      $query = $this->db->get();
	    return $query->num_rows();
    }


    function existeOrden($id_equipo)
    {
      $this->db->select('SO.id');
      $this->db->from('socios as SO');
      $this->db->where('SO.id_equipo', $id_equipo);
      $this->db->where('SO.id_estado <', 4);

      $query = $this->db->get();
	    return $query->num_rows();
    }

    function equipo_enviado_al_socio_no_resuelto($rm_id) {
      $this->db->select('COUNT(*) AS equipo_enviado_al_socio_no_resuelto');
      $this->db->from('socios');
      $this->db->where('id_orden', $rm_id);
      $this->db->where_not_in('id_estado', [4, 5]);

      $query = $this->db->get();
      return $query->row()->equipo_enviado_al_socio_no_resuelto;
    }

}

?>
