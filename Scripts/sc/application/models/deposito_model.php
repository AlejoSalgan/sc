<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Deposito_model extends CI_Model
{
  // LISTADOS //

    function listadoRemitos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$estado = NULL,$opciones = NULL, $orden = NULL)
    {
        $this->db->select('DE.id, DE.id_equipo, DE.id_proyecto, DE.id_orden, DE.num_remito, DE.categoria, DE.estado, DE.creado_por, DE.ts_creado, EM.serie, MUN.descrip, RC.descrip as categoria_descrip, RC.color, DE.fecha_recibido, DE.usuario_recibido, U.name, DEST.nombre_estado, (SELECT DV.fecha FROM deposito_eventos as DV WHERE DV.id_deposito = DE.id ORDER BY DV.id DESC LIMIT 1) as fecha_evento');
        $this->db->from('deposito as DE');
        $this->db->join('equipos_main as EM', 'DE.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = EM.municipio','left');
        $this->db->join('reparacion_categorias as RC', 'RC.id = DE.categoria','left');
        $this->db->join('tbl_users as U', 'U.userId = DE.usuario_recibido','left');
        $this->db->join('deposito_estados as DEST', 'DEST.id_estado = DE.estado','left');

        if(!empty($searchText)) {
          if($criterio != '0' && $criterio != '99') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }elseif ($criterio == '99') {
            $date = str_replace('/', '-', $searchText);
            $fecha = date('Y-m-d', strtotime($date));
            $criterio = "(SELECT DV.fecha FROM deposito_eventos as DV WHERE DV.id_deposito = DE.id ORDER BY DV.id DESC LIMIT 1)";
            $likeCriteria = "(".$criterio. " LIKE '%".$fecha."%')";
          }else {
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
                $this->db->where_in('DE.estado', $estado);
            } else {
                $this->db->where('DE.estado =', $estado);
            }
        }

        if ($orden == NULL) {
          $this->db->order_by('DE.id', 'DESC');
        } else {
          $this->db->order_by('fecha_evento', 'ASC');
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

  function eventosRemito($id_remito)
  {
    $this->db->select('DEV.observacion, DEV.fecha, DES.label, DES.nombre_estado, U.name');
    $this->db->from('deposito_eventos as DEV');
    $this->db->join('deposito_estados as DES', 'DES.id_estado = DEV.estado','left');
    $this->db->join('tbl_users as U', 'U.userId = DEV.usuario','left');
    $this->db->where('DEV.id_deposito',$id_remito);
    $this->db->order_by('DEV.fecha', 'DESC');

    $query = $this->db->get();
    return $query->result();

  }


  function equiposIngresar($proyecto)
  {
    $sql .= "SELECT EM.id, EM.serie, ES.descrip as estado_descrip, EV.descrip as evento_descrip
              FROM (`equipos_main` AS EM)
              LEFT JOIN estados as ES ON ES.id = EM.estado
              LEFT JOIN eventos as EV ON EV.id = EM.evento_actual
              WHERE `EM`.`municipio` = $proyecto
              AND `EM`.`serie` != ''
              AND `EM`.`serie` NOT LIKE '%-baj%'
              ORDER BY `EM`.`serie` ASC ";

    $query = $this->db->query($sql);
    return $query->result();

  }


  // Esta funcion era para traer los equipos que no existan en reparacion. Por algun motivo no traia bien los equipos asi que se cambio por la de arriba. Por el momento no se va a usar.
  /*
  function getEquiposDeposito($proyecto = FALSE)
  {
    $sql .= "SELECT EM.id, EM.serie, RM.ultimo_estado
              FROM (`equipos_main` AS EM)
              LEFT JOIN `reparacion_main` AS RM ON `RM`.`serie` = `EM`.`serie`
              WHERE  NOT EXISTS
              ( SELECT * FROM reparacion_main as RM
                WHERE RM.ultimo_estado IN (3, 4, 5, 6, 9, 10, 11, 14, 15, 16, 17, 18, 19)
                AND RM.serie = EM.serie
              )

              AND NOT EXISTS
              ( SELECT * FROM deposito as DE
                WHERE DE.estado IN (10,20,30)
                AND DE.id_equipo = EM.id
              )

              /*
              AND NOT EXISTS
              ( SELECT * FROM socios as DE
                WHERE DE.estado IN (10,20,30)
                AND DE.id_equipo = EM.id
              )
              */
              /*
              AND `EM`.`municipio` = $proyecto
              AND `EM`.`serie` != ''
              AND `EM`.`serie` NOT LIKE '%-baj%'
              GROUP BY `EM`.`serie`
              ORDER BY `EM`.`serie` ASC ";

    $query = $this->db->query($sql);
    return $query->result();
  }

  */

// AGREGAR //

    function agregarRemito($remitoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('deposito', $remitoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarEvento($eventoInfo) //Agrego un remito.
    {
        $this->db->trans_start();
        $this->db->insert('deposito_eventos', $eventoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }


// MODIFICAR //

    function actualizarRemito($updateRemito, $id_remito) //Modifico un remito.
    {
        $this->db->where('id', $id_remito);
        $this->db->update('deposito', $updateRemito);

        return TRUE;
    }


// OBTENER INFORMACION //
    function getRemito($id_remito) //Obtengo la informacion del remito.
    {
        $this->db->select('DE.id, DE.id_equipo, DE.id_proyecto, DE.id_orden, DE.num_remito, DE.categoria, DE.estado, DE.creado_por, DE.ts_creado, EM.serie, MUN.descrip as municipio_descrip, RC.descrip as categoria_descrip, RC.color, DE.fecha_recibido, DE.usuario_recibido, U.name, DES.nombre_estado, DES.label,DES.tipo');
        $this->db->from('deposito as DE');
        $this->db->join('equipos_main as EM', 'DE.id_equipo = EM.id','left');
        $this->db->join('municipios as MUN', 'MUN.id = DE.id_proyecto','left');
        $this->db->join('reparacion_categorias as RC', 'RC.id = DE.categoria','left');
        $this->db->join('tbl_users as U', 'U.userId = DE.usuario_recibido','left');
        $this->db->join('deposito_estados as DES', 'DES.id_estado = DE.estado','left');
        $this->db->where('DE.id', $id_remito);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    //Busco un remito de Deposito solo por la Orden de Reparacion.
    function getIDremito($idorden)
    {
        $this->db->select('DE.id');
        $this->db->from('deposito as DE');
        $this->db->where('DE.id_orden', $idorden);
        $this->db->where('DE.estado', 30);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    function getNumRemito($num_remito)
    {
        $this->db->select('DE.num_remito');
        $this->db->from('deposito as DE');
        $this->db->where('DE.num_remito', $num_remito);

        $query = $this->db->get();
        $row = $query->row();
        return $row->num_remito;
    }



    function existeEnDeposito($idequipo,$estados)
    {
        $this->db->select('DE.id');
        $this->db->from('deposito as DE');
        $this->db->where('DE.id_equipo', $idequipo);
        $this->db->where_in('DE.estado', $estados);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }




}

?>
