<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Calib_model extends CI_Model
{

/* Listado */
function listadoOrdenes($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$estado = NULL,$ordenesRepa = NULL) //Obtengo la lista de los remitos y a la vez los cuento.
    {
        if ($ordenesRepa == NULL) {
          $this->db->select('CA.id, CA.idequipo, CA.multicarril, CA.fecha_alta, CA.tipo_orden, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, ET.descrip as tipoEquipo, CS.verificacion as tipo_ver, PR.label, PR.descrip as descripPrioridad, CTO.estado as estado_descrip,
          CA.fecha_visita, UT.name AS nameTecnico, F.dominio, CA.fecha_certificado, CA.fecha_informe, CS.color_servicio, CTO.color_tipo,

          CA.tipo_servicio, ,CA.activo, CA.prioridad,  CA.fecha_desde,
          CA.fecha_hasta,  CA.observaciones_gestor, CA.distancia_inti, CA.horario_calib, CA.tipo, CA.ord_tipo, CA.tipo_equipo,
          CA.factura, CA.ord_tec, CA.nro_oc, CA.fecha_oc ');
        } else {
          $this->db->select('CA.id, CA.idequipo, CA.multicarril, CA.fecha_alta, CA.tipo_orden, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, ET.descrip as tipoEquipo, CS.verificacion as tipo_ver, PR.label, PR.descrip as descripPrioridad, CTO.estado as estado_descrip,
          CA.fecha_visita, UT.name AS nameTecnico, F.dominio, CA.fecha_certificado, CA.fecha_informe, CS.color_servicio, CTO.color_tipo,

          CA.tipo_servicio, ,CA.activo, CA.prioridad,  CA.fecha_desde,
          CA.fecha_hasta,  CA.observaciones_gestor, CA.distancia_inti, CA.horario_calib, CA.tipo, CA.ord_tipo, CA.tipo_equipo,
          CA.factura,  CA.ord_tec, CA.nro_oc, CA.fecha_oc,
          RM.id AS ord_repa');
        }

        $this->db->from('calibraciones as CA');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = CA.tipo_servicio','left');
        $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.id_tipoOrden = CA.tipo_orden','left');
        $this->db->join('prioridades as PR', 'PR.id = CA.prioridad','left');
        $this->db->join('municipios as Mun', 'Mun.id = CA.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = CA.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = CA.idequipo','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = CA.tipo_equipo','left');
        $this->db->join('tbl_users as U', 'U.userId = CA.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = CA.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = CA.tecnico','left');
        if ($ordenesRepa == 1) {
          $this->db->join('reparacion_main as RM', 'RM.serie = EM.serie AND RM.ultimo_estado IN (3, 4, 5, 6, 9, 10, 11, 14, 15, 16)','left');
        }

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(ET.descrip  LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(CS.verificacion  LIKE '%".$searchText."%')";
                    break;
                case 6:
                    $likeCriteria = "(PR.descrip  LIKE '%".$searchText."%')";
                    break;
                case 7:
                    $likeCriteria = "(CA.fecha_alta  LIKE '%".$searchText."%')";
                    break;
                case 8:
                    $likeCriteria = "(CTO.estado  LIKE '%".$searchText."%')";
                    break;
                case 9:
                    $likeCriteria = "(CA.multicarril  LIKE '%".$searchText."%')";
                    break;
                case 10:
                    $likeCriteria = "(CA.fecha_visita  LIKE '%".$searchText."%')";
                    break;
                case 11:
                    $likeCriteria = "(UT.name  LIKE '%".$searchText."%')";
                    break;
                case 12:
                    $likeCriteria = "(F.dominio  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  ET.descrip  LIKE '%".$searchText."%'
                                        OR  CS.verificacion  LIKE '%".$searchText."%'
                                        OR  PR.descrip  LIKE '%".$searchText."%'
                                        OR  CA.fecha_alta  LIKE '%".$searchText."%'
                                        OR  CTO.estado  LIKE '%".$searchText."%'
                                        OR  CA.multicarril  LIKE '%".$searchText."%'
                                        OR  CA.fecha_visita  LIKE '%".$searchText."%'
                                        OR  UT.name  LIKE '%".$searchText."%'
                                        OR  F.dominio  LIKE '%".$searchText."%'
                                    )";
                    break;
            }
            $this->db->where($likeCriteria);
        }

        if (!is_null($estado)) {
            if (is_array($estado)) {
                $this->db->where_in('CA.tipo_orden', $estado);
            } else {
                $this->db->where('CA.tipo_orden =', $estado);
            }
        }

        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->where('MA.usuario',$userId);
        }

        $this->db->group_by('CA.id');
        $this->db->order_by('CA.id', 'DESC');
        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }

    function getEventos($num_orden, $count = 0) //Obtengo los eventos de la orden.
    {
      $this->db->select('CE.id, CE.fecha, CE.observacion, CE.usuario, U.name, CR.sector, CR.color, CTO.estado');
      $this->db->from('calibraciones_eventos as CE');
      $this->db->join('tbl_users as U', 'U.userId = CE.usuario','left');
      $this->db->join('calibraciones_referencia as CR', 'CR.id = CE.rol_categoria','left');
      $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.id_tipoOrden = CE.estado','left');
      $this->db->where('CE.num_orden', $num_orden);

      $query = $this->db->get();
      if ($count == 1) {
        return count($query->result());
      } else {
        return $query->result();
      }
    }


    function getPedidos($tipo_equipo) //Obtengo los eventos de la orden.
    {
      $this->db->select('CP.id, CP.id_compra, CP.cantidad, CP.servicio, CP.horario, CP.distancia, CP.carriles, ET.descrip as tipoEquipo, CS.verificacion as tipo_servicio, CC.num_compra, CC.fecha_ot, CC.estado, CS.color_servicio');
      $this->db->from('calibraciones_pedidos as CP');
      $this->db->join('calibraciones_servicios as CS', 'CS.id = CP.servicio','left');
      $this->db->join('equipos_tipos as ET', 'ET.id = CP.tipo_equipo','left');
      $this->db->join('calibraciones_compras as CC', 'CC.id = CP.id_compra','left');
      $this->db->where('CP.tipo_equipo', $tipo_equipo);

      $query = $this->db->get();
      return $query->result();
    }


    function getPedido($id_pedido) //Obtengo los eventos de la orden.
    {
      $this->db->select('CP.id, CP.id_compra, CP.cantidad, CP.servicio, CP.horario, CP.distancia, CP.carriles, CP.observacion, CP.tipo_equipo, ET.descrip as tipoEquipo, CS.verificacion as tipo_servicio, CC.num_compra, CC.fecha_ot, CC.presupuesto, CC.num_ot, CC.usuario_compra, CC.ts_compra, CC.observacion_compra, UC.name as nameCompra, CP.usuario_pedido, U.name as namePedido, CP.ts_pedido');
      $this->db->from('calibraciones_pedidos as CP');
      $this->db->join('calibraciones_servicios as CS', 'CS.id = CP.servicio','left');
      $this->db->join('equipos_tipos as ET', 'ET.id = CP.tipo_equipo','left');
      $this->db->join('calibraciones_compras as CC', 'CC.id = CP.id_compra','left');
      $this->db->join('tbl_users as U', 'U.userId = CP.usuario_pedido','left');
      $this->db->join('tbl_users as UC', 'UC.userId = CC.usuario_compra','left');
      $this->db->where('CP.id', $id_pedido);

      $query = $this->db->get();
      $result = $query->row();
      return $result;
    }


    function getParciales($id_pedido)
    {
      $this->db->select('CP.id, CP.num_parcial, CP.num_orden, C.idequipo, E.serie, M.descrip');
      $this->db->from('calibraciones_parciales as CP');
      $this->db->join('calibraciones as C', 'C.id = CP.num_orden','left');
      $this->db->join('equipos_main as E', 'E.id = C.idequipo','left');
      $this->db->join('municipios as M', 'M.id = C.idproyecto','left');
      $this->db->where('CP.id_pedido', $id_pedido);

      $query = $this->db->get();
      return $query->result();
    }

    function getNumerosOT($tipo_equipo,$servicio,$horario,$distancia,$carriles)
    {
      $this->db->select('CP.id, CC.num_ot');
      $this->db->from('calibraciones_pedidos as CP');
      $this->db->join('calibraciones_compras as CC', 'CC.id = CP.id_compra','left');
      $this->db->where('CP.tipo_equipo', $tipo_equipo);
      $this->db->where('CP.servicio', $servicio);
      $this->db->where('CP.horario', $horario);
      $this->db->where('CP.distancia', $distancia);
      $this->db->where('CP.carriles', $carriles);
      $this->db->where('CP.id_compra !=', 'NULL');
      $this->db->where('CC.estado', 1);

      $query = $this->db->get();
      return $query->result();
    }

    function getListParciales($id_pedido)
    {
      $this->db->select('CPA.id, CPA.num_parcial, CPA.num_orden');
      $this->db->from('calibraciones_parciales as CPA');
      $this->db->where('CPA.id_pedido', $id_pedido);
      //$this->db->where('CPA.num_orden', NULL);
      $this->db->order_by('CPA.num_parcial', 'asc');

    	$query = $this->db->get();
    	return $query->result();
    }

    function getEquiposcalibrar($id = NULL){
      if (is_null($id)) {
        $this->db->select('ET.id, ET.descrip');
      } else {
        $this->db->select('ET.id');
      }
      $this->db->from('equipos_tipos as ET');
      $this->db->where('requiere_calibracion',1);
      $this->db->order_by('ET.descrip');

      $query = $this->db->get();

      if (!is_null($id)) {
        $salida = array();
        $result = $query->result();
        foreach ($result as $valor) {
          $salida[] = $valor->id;
        }
        return $salida;
      }

      return $query->result();
    }

    function getRestantes($id_pedido){
      $this->db->select('CPA.id');
      $this->db->from('calibraciones_parciales AS CPA');
      $this->db->where('CPA.id_pedido', $id_pedido);
      $this->db->where('CPA.num_orden', NULL);

      $query = $this->db->get();
      return count($query->result());
    }

    function getEquipos($id_proyecto = NULL, $tipos = NULL){
      $this->db->select('EM.id, EM.serie');
      $this->db->from('equipos_main as EM');
      $this->db->where('EM.municipio',$id_proyecto);
      $this->db->where('EM.eliminado',0);
      if (!is_null($tipos)) {
          if (is_array($tipos)) {
              $this->db->where_in('EM.tipo', $tipos);
          } else {
              $this->db->where('EM.tipo =', $tipos);
          }
      }
      $this->db->not_like('EM.serie','-baj');
      $this->db->order_by('EM.serie',ASC);

      $query = $this->db->get();
      return $query->result();
    }

    function getTipoOrdenes(){
      $this->db->select('CTO.id_tipoOrden, CTO.estado');
      $this->db->from('calibraciones_tipo_orden as CTO');
      $this->db->order_by('CTO.id_tipoOrden');

      $query = $this->db->get();
      return $query->result();
    }



/* Listado */



/* Agregar */
    function agregarEvento($eventoInfo) //Agrego un nuevo evento.
    {
        $this->db->trans_start();
        $this->db->insert('calibraciones_eventos', $eventoInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarPedido($infoPedidos)
    {
        $this->db->trans_start();
        $this->db->insert('calibraciones_pedidos', $infoPedidos);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarParcial($insertParcial)
    {
        $this->db->trans_start();
        $this->db->insert('calibraciones_parciales', $insertParcial);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function agregarCompra($compraInfo)
    {
        $this->db->trans_start();
        $this->db->insert('calibraciones_compras', $compraInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }
/* Agregar */

/* Editar */
    function editarPedido($pedidoInfo, $id_pedido)
    {
        $this->db->where('id', $id_pedido);
        $this->db->update('calibraciones_pedidos', $pedidoInfo);

        return TRUE;
    }

    function editarCompra($compraInfo, $id_compra)
    {
        $this->db->where('id', $id_compra);
        $this->db->update('calibraciones_compras', $compraInfo);

        return TRUE;
    }

    function editarParcial($parcialInfo,$id_parcial)
    {
        $this->db->where('id', $id_parcial);
        $this->db->update('calibraciones_parciales', $parcialInfo);

        return TRUE;
    }

/* Editar */

/* Consultas */
    function getCategoria($role){
        $this->db->select('id');
        $this->db->from('calibraciones_referencia');
        $this->db->like('roles', $role);

        $query = $this->db->get();
        $result = $query->row();

        return $result->id;
    }

    function getGrupoEventos($num_orden) //Obtengo los eventos de la orden.
    {
      $this->db->select('COUNT(CE.id) as cantidad, CR.sector, CR.color');
      $this->db->from('calibraciones_eventos as CE');
      $this->db->join('calibraciones_referencia as CR', 'CR.id = CE.rol_categoria','left');
      $this->db->where('CE.num_orden', $num_orden);
      $this->db->group_by('CE.rol_categoria');
      $this->db->order_by('cantidad',DESC);

      $query = $this->db->get();
      return $query->result();
    }

    function getCompra($id_compra)
    {
      $this->db->select('CC.id, CC.num_compra, CC.presupuesto, CC.num_ot, CC.fecha_ot, CC.observacion_compra, CC.fecha_ordCompra as fecha_ordenCompra, CC.fecha_presupuesto');
      $this->db->from('calibraciones_compras as CC');
      $this->db->where('CC.id', $id_compra);
      $query = $this->db->get();

      $row = $query->row();
      return $row;
    }
/* Consultas */

/* Borrar */
  function eliminarPedido($id_pedido)
  {
    $this->db->where('id', $id_pedido);
    $this->db->delete('calibraciones_pedidos');

    return TRUE;
  }

  function eliminarParcial($id_pedido)
  {
    $this->db->where('id_pedido', $id_pedido);
    $this->db->delete('calibraciones_parciales');

    return TRUE;
  }
/* Borrar*/




























    function calibListingCount($searchText = '', $filtro, $criterio)
    {
        $this->db->select('CA.id');
        $this->db->from('calibraciones as CA');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = CA.tipo_servicio','left');
        $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.codigo_tipo = CA.ord_tipo','left');
        $this->db->join('prioridades as PR', 'PR.id = CA.prioridad','left');
        $this->db->join('municipios as Mun', 'Mun.id = CA.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = CA.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = CA.idequipo','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = CA.tipo_equipo','left');
        $this->db->join('tbl_users as U', 'U.userId = CA.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = CA.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = CA.tecnico','left');

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;

                case 4:
                    $likeCriteria = "(ET.descrip  LIKE '%".$searchText."%')";
                    break;

                case 5:
                    $likeCriteria = "(CS.verificacion  LIKE '%".$searchText."%')";
                    break;

                case 6:
                    $likeCriteria = "(PR.descrip  LIKE '%".$searchText."%')";
                    break;

                case 7:
                    $likeCriteria = "(CA.fecha_alta  LIKE '%".$searchText."%')";
                    break;

                case 8:
                    $likeCriteria = "(CTO.estado  LIKE '%".$searchText."%')";
                    break;

                case 9:
                    $likeCriteria = "(CA.multicarril  LIKE '%".$searchText."%')";
                    break;

                case 10:
                    $likeCriteria = "(CA.fecha_visita  LIKE '%".$searchText."%')";
                    break;

                case 11:
                    $likeCriteria = "(UT.name  LIKE '%".$searchText."%')";
                    break;

                case 12:
                    $likeCriteria = "(F.dominio  LIKE '%".$searchText."%')";
                    break;

                default:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  ET.descrip  LIKE '%".$searchText."%'
                                        OR  CS.verificacion  LIKE '%".$searchText."%'
                                        OR  PR.descrip  LIKE '%".$searchText."%'
                                        OR  CA.fecha_alta  LIKE '%".$searchText."%'
                                        OR  CTO.estado  LIKE '%".$searchText."%'
                                        OR  CA.multicarril  LIKE '%".$searchText."%'
                                        OR  CA.fecha_visita  LIKE '%".$searchText."%'
                                        OR  UT.name  LIKE '%".$searchText."%'
                                        OR  F.dominio  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);

        }

        $this->db->order_by("CA.fecha_visita", "DESC");
        $this->db->order_by("F.dominio", "ASC");
        $this->db->where('CA.tipo =', $filtro);

        $query = $this->db->get();

        return count($query->result());
    }

    function calibListing($searchText = '', $page, $segment, $filtro, $criterio)
    {
        $this->db->select('CA.id, CA.idproyecto, CA.idequipo, CA.tipo_servicio, ,CA.activo, CA.prioridad, CA.fecha_alta, CA.fecha_desde, CA.fecha_hasta, CA.fecha_visita, CA.observaciones_gestor, CA.distancia_inti, CA.horario_calib, CA.tipo, CA.ord_tipo, CA.tipo_equipo, CA.factura, CA.multicarril, CA.ord_tec, CA.nro_oc, CA.fecha_oc, CA.fecha_certificado, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, CS.verificacion as tipo_ver, CTO.estado as estado_descrip, ET.descrip as tipoEquipo, PR.descrip as descripPrioridad, UT.name AS nameTecnico, F.dominio');
        $this->db->from('calibraciones as CA');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = CA.tipo_servicio','left');
        $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.codigo_tipo = CA.ord_tipo','left');
        $this->db->join('prioridades as PR', 'PR.id = CA.prioridad','left');
        $this->db->join('municipios as Mun', 'Mun.id = CA.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = CA.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = CA.idequipo','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = CA.tipo_equipo','left');
        $this->db->join('tbl_users as U', 'U.userId = CA.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = CA.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = CA.tecnico','left');

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;

                case 4:
                    $likeCriteria = "(ET.descrip  LIKE '%".$searchText."%')";
                    break;

                case 5:
                    $likeCriteria = "(CS.verificacion  LIKE '%".$searchText."%')";
                    break;

                case 6:
                    $likeCriteria = "(PR.descrip  LIKE '%".$searchText."%')";
                    break;

                case 7:
                    $likeCriteria = "(CA.fecha_alta  LIKE '%".$searchText."%')";
                    break;

                case 8:
                    $likeCriteria = "(CTO.estado  LIKE '%".$searchText."%')";
                    break;

                case 9:
                    $likeCriteria = "(CA.multicarril  LIKE '%".$searchText."%')";
                    break;

                case 10:
                    $likeCriteria = "(CA.fecha_visita  LIKE '%".$searchText."%')";
                    break;

                case 11:
                    $likeCriteria = "(UT.name  LIKE '%".$searchText."%')";
                    break;

                case 12:
                    $likeCriteria = "(F.dominio  LIKE '%".$searchText."%')";
                    break;

                default:
                    $likeCriteria = "(CA.id  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  ET.descrip  LIKE '%".$searchText."%'
                                        OR  CS.verificacion  LIKE '%".$searchText."%'
                                        OR  PR.descrip  LIKE '%".$searchText."%'
                                        OR  CA.fecha_alta  LIKE '%".$searchText."%'
                                        OR  CTO.estado  LIKE '%".$searchText."%'
                                        OR  CA.multicarril  LIKE '%".$searchText."%'
                                        OR  CA.fecha_visita  LIKE '%".$searchText."%'
                                        OR  UT.name  LIKE '%".$searchText."%'
                                        OR  F.dominio  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);

        }

        $this->db->order_by("CA.id", "DESC");
        $this->db->order_by("F.dominio", "ASC");

        $this->db->where('CA.tipo =', $filtro);

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

    function parcialesListing($tipo)
    {
        $sql = "SELECT COUNT(*) as cantidad, et.descrip, c.multicarril, CS.verificacion, c.horario_calib, c.distancia_inti, c.nro_oc, c.fecha_oc
        FROM `calibraciones` as c
        JOIN calibraciones_servicios as CS ON CS.id = c.tipo_servicio
        JOIN equipos_tipos as et ON et.id = c.tipo_equipo
        WHERE c.tipo = 1 and nro_ot = '' and c.tipo_equipo =".$tipo;
        $sql .= " GROUP BY c.tipo_equipo, c.multicarril, c.tipo_servicio, c.horario_calib, c.distancia_inti";
        $query = $this->db->query($sql);

        return $query->result();
    }


    function aprobacionesListing($tipo)
    {
        $this->db->select('COUNT(*) as cantidad, et.descrip, c.multicarril, c.tipo_servicio, CS.verificacion, c.horario_calib, c.distancia_inti,c.nro_oc, c.fecha_oc');
        $this->db->from('calibraciones as c');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = c.tipo_servicio','left');
        $this->db->join('equipos_tipos as et', 'et.id = c.tipo_equipo','left');

        $this->db->where('c.tipo_orden',30);
        $this->db->where('tipo_equipo', $tipo);

        $this->db->group_by('c.tipo_servicio');

        if ($tipo != 1) {
            $this->db->group_by('c.multicarril');
            $this->db->group_by('c.tipo_equipo');
            $this->db->group_by('c.horario_calib');
            $this->db->group_by('c.distancia_inti');
        }

        $query = $this->db->get();

        return $query->result();

    }

    function aprobacion_equipo($verificacion,$multicarril,$horario,$distancia)
    {

        $this->db->select('c.id, c.idequipo, c.multicarril, CS.verificacion, c.horario_calib, c.distancia_inti, c.tipo_servicio, c.nro_oc, c.fecha_oc, Mun.descrip AS descripProyecto, EM.serie AS equipoSerie, EM.doc_fechavto');
        $this->db->from('calibraciones as c');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = c.tipo_servicio','left');
        $this->db->join('municipios as Mun', 'Mun.id = c.idproyecto','left');
        $this->db->join('equipos_main as EM', 'EM.id = c.idequipo','left');

        $this->db->where('c.tipo_orden',30);

        if ($horario != 0) {
            $this->db->where('c.multicarril', $multicarril);
            $this->db->where('c.tipo_servicio', $verificacion);
            $this->db->where('c.horario_calib', $horario);
            $this->db->where('c.distancia_inti', $distancia);
        } else {
            $this->db->where('c.tipo_servicio', $verificacion);
            $this->db->where('c.tipo_equipo = 1');
        }

        $query = $this->db->get();

        return $query->result();
    }

    function addNewSolic($calibNew)
    {
        $this->db->trans_start();
        $this->db->insert('calibraciones', $calibNew);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function getCalibInfo($calibId)
    {
        $this->db->select("CA.id, CA.tipo_orden, CA.idproyecto, CA.idequipo, CA.tipo_servicio, ,CA.activo, CA.prioridad, CA.creadopor, CA.observaciones_gestor, CA.observaciones_calib, CA.tipo, CA.ord_tipo, CA.tipo_equipo, CA.direccion, CA.velocidad, CA.multicarril, DATE_FORMAT(CA.fecha_oc, '%d-%m-%Y') AS fecha_oc, CA.nro_oc, CA.observaciones_serv, CA.distancia_inti, CA.horario_calib, CA.observacion_solicalib ,CA.factura, CA.ord_tec, CA.observaciones_calib, CA.idsupervisor, CA.iddominio, CA.conductor, CA.tecnico, CA.nro_ot, CA.simulacion_aprob, CA.pasadas_aprob, DATE_FORMAT(CA.fecha_visita, '%d-%m-%Y') AS fecha_visita, DATE_FORMAT(CA.fecha_alta, '%d-%m-%Y') AS fecha_alta, DATE_FORMAT(CA.fecha_desde, '%d-%m-%Y') AS fecha_desde, DATE_FORMAT(CA.fecha_hasta, '%d-%m-%Y') AS fecha_hasta, DATE_FORMAT(CA.fecha_pasadas, '%d-%m-%Y') AS fecha_pasadas, DATE_FORMAT(CA.fecha_simulacion, '%d-%m-%Y') AS fecha_simulacion, DATE_FORMAT(CA.fecha_informe, '%d-%m-%Y') AS fecha_informe, DATE_FORMAT(CA.fecha_certificado, '%d-%m-%Y') AS fecha_certificado, DATE_FORMAT(EM.doc_fechavto, '%d-%m-%Y') AS fecha_vto, EM.tipo_equipo AS movil, EM.serie AS equipoSerie, ET.descrip as tipoEquipo, Mun.descrip AS descripProyecto, CS.verificacion as tipo_ver, PR.descrip as descripPrioridad, U.name AS nameSupervisor, UC.name AS nameConductor, UT.name AS nameTecnico, U.mobile, CTO.estado as estado_descrip, UCA.name as solicitud_creado, F.dominio", FALSE);
        $this->db->join('equipos_main as EM', 'EM.id = CA.idequipo','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = CA.tipo_equipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = CA.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = CA.iddominio','left');
        $this->db->join('calibraciones_servicios as CS', 'CS.id = CA.tipo_servicio','left');
        $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.codigo_tipo = CA.ord_tipo','left');
        $this->db->join('prioridades as PR', 'PR.id = CA.prioridad','left');
        $this->db->join('tbl_users as U', 'U.userId = CA.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = CA.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = CA.tecnico','left');
        $this->db->join('tbl_users as UCA', 'UCA.userId = CA.creadopor','left');
        $this->db->from('calibraciones as CA');
        $this->db->where("CA.id", $calibId);
        $query = $this->db->get();

        return $query->result();
    }

    function editCalib($calibInfo, $calibId)
    {
        $this->db->where('id', $calibId);
        $this->db->update('calibraciones', $calibInfo);

        return TRUE;
    }

    function deleteCalib($calibId, $calibInfo)
    {
        $this->db->where('id', $calibId);
        $this->db->update('calibraciones', $calibInfo);

        return $calibInfo;
    }

    function getProxOrden()
    {
        $this->db->select_max('id');
        $result = $this->db->get('calibraciones')->row();
        $data = $result->id + 1;

        return $data;
    }

    function getTipoServicio()
    {
        $this->db->select('id,verificacion');
        $this->db->from('calibraciones_servicios');
        $query = $this->db->get();

        return $query->result();
    }

    function getPrioridades()
    {
        $this->db->select('id,descrip');
        $this->db->from('prioridades');
        $query = $this->db->get();

        return $query->result();
    }


    public function getCertificado($calibId){
        $this->db->select('fecha_certificado');
        $this->db->from('calibraciones');
        $this->db->where('id', $calibId);

        $query = $this->db->get();
        $result = $query->row();

        return $result->fecha_certificado;
    }

    public function getIDEquipo($calibId){
        $this->db->select('idequipo');
        $this->db->from('calibraciones');
        $this->db->where('id', $calibId);

        $query = $this->db->get();
        $result = $query->row();

        return $result->idequipo;
    }
}
