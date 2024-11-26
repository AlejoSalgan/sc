<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


// Hay una funcion de editar protocolos_main que esta duplicada, la que hace update.
class Protocolos_model extends CI_Model
{
    function protocolosCount($searchText = '',$tipo,$criterio,$userId, $role) // Ordenes de Servicio que fueron creadas (Contadas)
    {
        $this->db->select('OM.id');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->join('ordenesb_transferencia_estado as OTE', 'OTE.id_estado = OM.transferidos_estado','left');

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
				}

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;

                case 4:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;

                case 5:
                    $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                    break;

                case 6:
                    $likeCriteria = "(OM.bajada_desde  LIKE '%".$searchText."%')";
                    break;

                case 7:
                    $likeCriteria = "(OM.bajada_hasta  LIKE '%".$searchText."%')";
                    break;

                case 8:
                    $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                    break;

                case 9:
                    $likeCriteria = "(OTE.nombre_estado  LIKE '%".$searchText."%')";
                    break;

                case 10:
                    $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                    break;

                default:   // Falta configurar esto y probar el buscador
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                        OR  OM.protocolo  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  PM.fecha  LIKE '%".$searchText."%'
                                        OR  OM.bajada_desde  LIKE '%".$searchText."%'
                                        OR  OM.bajada_hasta  LIKE '%".$searchText."%'
                                        OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                        OR  OTE.nombre_estado  LIKE '%".$searchText."%'
                                        OR  EMOD.descrip  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        switch ($tipo) {
            case "Pendiente":
                //$this->db->where('OM.subida_ingresados IS NULL');
                $this->db->where('OM.bajada_archivos >= 0');
                $this->db->where('OM.subida_estado = 0');
                $this->db->where('OM.subida_activo = 1');
                break;

            case "Ingresado":
                //$this->db->where('OM.subida_ingresados IS NOT NULL');
                $this->db->where('OM.bajada_archivos > 0');
                $this->db->where('OM.subida_activo = 1');
                $where = "(OM.subida_estado = 1 OR OM.subida_estado = 4)";
                $this->db->where($where);
                break;

            case "Cero":
                $this->db->where('OM.subida_estado = 2');
                //$this->db->where('OM.subida_activo = 1');
                break;

            case "Anulado":
                $where = "(OM.subida_estado = 3 OR OM.subida_activo = 0)";
                $this->db->where($where);
                break;

            case "Aprobados": //Ordenes aprobadas por Cesar
                $this->db->where('(OM.transferidos_estado = 20 && OM.transferido_tipo < 2 && OM.subida_estado = 0 && OM.subida_activo = 1)');
                break;
        }

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

        $this->db->where('OM.protocolo IS NOT NULL');
        if ($tipo == "Pendiente") {
          $this->db->order_by("OM.transferidos_estado", "DESC");
          $this->db->order_by("OM.protocolo", "DESC");
        } else {
          $this->db->order_by("OM.protocolo", "DESC");
        }

        $query = $this->db->get();
        return count($query->result());
    }


    function protocolosList($searchText = '', $page, $segment,$tipo,$criterio,$userId, $role) // Ordenes de Servicio que fueron creadas.
    {
        $this->db->select('OM.bajada_desde, OM.bajada_hasta, OM.bajada_archivos, OM.id, OM.descrip, OM.activo, OM.fecha_visita, OM.enviado, OM.recibido, OM.protocolo, OM.subida_ingresados, OM.subida_vencidos, OM.subida_errores, OM.subida_cant, OM.subida_FD, OM.subida_FH, OM.subida_estado, OM.idequipo, PE.label, PE.estado, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, UT.name AS nameTecnico, F.dominio, PM.fecha as fecha_procesado, PM.estado as estado_expo, PM.decripto, PM.idexportacion, EM.doc_fechavto, ET.requiere_calibracion, OM.transferidos_MRM, OM.transferidos_estado, OTE.nombre_estado as estado_transferencia, OTE.label as transferido_label, OTE.id_estado, Mun.ubicacion, PM.id as pm_protocolo, EM.idmodelo');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
        $this->db->join('equipos_tipos as ET', 'ET.id = EM.tipo','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->join('protocolos_estados as PE', 'PE.id_tipo = OM.subida_estado','right');
        $this->db->join('ordenesb_transferencia_estado as OTE', 'OTE.id_estado = OM.transferidos_estado','left');

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
				}

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;

                case 4:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;

                case 5:
                    $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                    break;

                case 6:
                    $likeCriteria = "(OM.bajada_desde  LIKE '%".$searchText."%')";
                    break;

                case 7:
                    $likeCriteria = "(OM.bajada_hasta  LIKE '%".$searchText."%')";
                    break;

                case 8:
                    $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                    break;

                case 9:
                    $likeCriteria = "(OTE.nombre_estado  LIKE '%".$searchText."%')";
                    break;

                case 10:
                    $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                    break;

                default:   // Falta configurar esto y probar el buscador
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                        OR  OM.protocolo  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  PM.fecha  LIKE '%".$searchText."%'
                                        OR  OM.bajada_desde  LIKE '%".$searchText."%'
                                        OR  OM.bajada_hasta  LIKE '%".$searchText."%'
                                        OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                        OR  OTE.nombre_estado  LIKE '%".$searchText."%'
                                        OR  EMOD.descrip  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        switch ($tipo) {
            case "Pendiente":
                //$this->db->where('OM.subida_ingresados IS NULL');
                $this->db->where('OM.bajada_archivos >= 0');
                $this->db->where('OM.subida_estado = 0');
                $this->db->where('OM.subida_activo = 1');
                break;

            case "Ingresado":
                //$this->db->where('OM.subida_ingresados IS NOT NULL');
                $this->db->where('OM.bajada_archivos > 0');
                $this->db->where('OM.subida_activo = 1');
                $where = "(OM.subida_estado = 1 OR OM.subida_estado = 4)";
                $this->db->where($where);
                break;

            case "Cero":
                $this->db->where('OM.subida_estado = 2');
                //$this->db->where('OM.subida_activo = 1');
                break;

            case "Anulado":
                $where = "(OM.subida_estado = 3 OR OM.subida_activo = 0)";
                $this->db->where($where);
                break;

            case "Aprobados": //Ordenes aprobadas por Cesar
                $this->db->where('(OM.transferidos_estado = 20 && OM.transferido_tipo < 2 && OM.subida_estado = 0 && OM.subida_activo = 1)');
                break;
        }

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

        $this->db->where('OM.protocolo IS NOT NULL');
        if ($tipo == "Pendiente") {
          $this->db->order_by("OM.transferidos_estado", "DESC");
          $this->db->order_by("OM.protocolo", "DESC");
        } else {
          $this->db->order_by("OM.protocolo", "DESC");
        }

        $this->db->limit($page, $segment);

        $query = $this->db->get();
        return $query->result();
    }









/*------------------------------------------------------------------------------*/


function protocolosCount_ing($searchText = '',$tipo,$criterio,$userId, $role)
{
    $this->db->select('OM.id');
    $this->db->from('ordenesb_main as OM');
    $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
    $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
    $this->db->join('tbl_users as U', 'U.userId = OM.subida_creadopor','left');
    $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
    $this->db->join('ordenesb_transferencia_estado as OTE', 'OTE.id_estado = OM.transferidos_estado','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
    }

    if(!empty($searchText)) {
        switch ($criterio) {
            case 1:
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                break;
            case 2:
                $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                break;
            case 3:
                $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                break;
            case 4:
                $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                break;
            case 5:
                $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                break;
            case 8:
                $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                break;
            case 10:
                $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                break;

            default:   // Falta configurar esto y probar el buscador
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                    OR  OM.protocolo  LIKE '%".$searchText."%'
                                    OR  Mun.descrip  LIKE '%".$searchText."%'
                                    OR  EM.serie  LIKE '%".$searchText."%'
                                    OR  PM.fecha  LIKE '%".$searchText."%'
                                    OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                    OR  EMOD.descrip  LIKE '%".$searchText."%'
                                )";
                break;
        }

        $this->db->where($likeCriteria);
    }

    $this->db->where('OM.bajada_archivos > 0');
    $this->db->where('OM.subida_activo = 1');
    $this->db->where('PM.remoto',0);
    $where = "(OM.subida_estado = 1 OR OM.subida_estado = 4)";
    $this->db->where($where);

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->where('OM.protocolo IS NOT NULL');
    $this->db->order_by("OM.subida_fecha", "DESC");

    $query = $this->db->get();
    return count($query->result());
}



    function protocolos_ingresados($searchText = '', $page, $segment,$tipo,$criterio,$userId, $role) // Ordenes de Servicio que fueron creadas.
    {
        $this->db->select('OM.protocolo, OM.id,
        OM.idequipo, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto,
        PM.fecha as fecha_procesado, OM.subida_fecha, U.name as subido_por,
        OM.subida_ingresados, OM.subida_cant, OM.bajada_archivos,
        PM.estado as pm_estado, PM.idexportacion as id_expo, PM.decripto, PM.incorporacion_estado, PM.numero_exportacion as num_expo,
        OM.transferidos_MRM, OM.transferidos_estado, OTE.nombre_estado as estado_transferencia, OTE.label as transferido_label, OM.transferido_tipo, Mun.ubicacion, PM.id as pm_protocolo, PM.est_verificacion');

        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.subida_creadopor','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->join('ordenesb_transferencia_estado as OTE', 'OTE.id_estado = OM.transferidos_estado','left');

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
				}

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                    break;
                case 8:
                    $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                    break;
                case 10:
                    $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                    break;
                default:   // Falta configurar esto y probar el buscador
                    $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                        OR  OM.protocolo  LIKE '%".$searchText."%'
                                        OR  Mun.descrip  LIKE '%".$searchText."%'
                                        OR  EM.serie  LIKE '%".$searchText."%'
                                        OR  PM.fecha  LIKE '%".$searchText."%'
                                        OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                        OR  EMOD.descrip  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        $this->db->where('OM.bajada_archivos > 0');
        $this->db->where('OM.subida_activo',1);
        $this->db->where('PM.remoto',0);
        $where = "(OM.subida_estado = 1 OR OM.subida_estado = 4)";
        $this->db->where($where);

        if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

        $this->db->order_by("OM.subida_fecha", "DESC");
        $this->db->limit($page, $segment);

        $query = $this->db->get();
        return $query->result();
    }

/*-------------------------------------------------------------------------------*/

function protocolosCount_anu($searchText = '',$tipo,$criterio,$userId, $role)
{
    $this->db->select('OM.id');
    $this->db->from('ordenesb_main as OM');
    $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
    $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
    $this->db->join('tbl_users as U', 'U.userId = OM.subida_creadopor','left');
    $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
    }

    if(!empty($searchText)) {
        switch ($criterio) {
            case 1:
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                break;
            case 2:
                $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                break;
            case 3:
                $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                break;
            case 4:
                $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                break;
            case 5:
                $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                break;
            case 8:
                $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                break;
            case 10:
                $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                break;

            default:   // Falta configurar esto y probar el buscador
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                    OR  OM.protocolo  LIKE '%".$searchText."%'
                                    OR  Mun.descrip  LIKE '%".$searchText."%'
                                    OR  EM.serie  LIKE '%".$searchText."%'
                                    OR  PM.fecha  LIKE '%".$searchText."%'
                                    OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                    OR  EMOD.descrip  LIKE '%".$searchText."%'
                                )";
                break;
        }

        $this->db->where($likeCriteria);
    }

    $where = "(OM.subida_estado = 3 OR OM.subida_activo = 0)";
    $this->db->where($where);

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->where('OM.protocolo IS NOT NULL');
    $this->db->order_by("OM.protocolo", "DESC");

    $query = $this->db->get();
    return count($query->result());
}


function protocolos_anulados($searchText = '', $page, $segment,$tipo,$criterio,$userId, $role)
{
    $this->db->select('OM.protocolo, OM.id,
    OM.idequipo, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto,
    PM.fecha as fecha_procesado, OM.subida_fecha as fecha_anulacion, U.name as anulado_por,
    OM.bajada_archivos, OM.subida_observ as motivo');

    $this->db->from('ordenesb_main as OM');
    $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
    $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
    $this->db->join('tbl_users as U', 'U.userId = OM.subida_creadopor','left');
    $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
    }

    if(!empty($searchText)) {
        switch ($criterio) {
            case 1:
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                break;
            case 2:
                $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                break;
            case 3:
                $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                break;
            case 4:
                $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                break;
            case 5:
                $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                break;
            case 8:
                $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                break;
            case 10:
                $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                break;
            default:   // Falta configurar esto y probar el buscador
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                    OR  OM.protocolo  LIKE '%".$searchText."%'
                                    OR  Mun.descrip  LIKE '%".$searchText."%'
                                    OR  EM.serie  LIKE '%".$searchText."%'
                                    OR  PM.fecha  LIKE '%".$searchText."%'
                                    OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                    OR  EMOD.descrip  LIKE '%".$searchText."%'
                                )";
                break;
        }

        $this->db->where($likeCriteria);
    }

    $where = "(OM.subida_estado = 3 OR OM.subida_activo = 0)";
    $this->db->where($where);

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->order_by("OM.protocolo", "DESC");
    $this->db->limit($page, $segment);

    $query = $this->db->get();
    return $query->result();
}




















/*-------------------------------------------------------------------------------*/

function protocolosCount_ceros($searchText = '',$tipo,$criterio,$userId, $role)
{
    $this->db->select('OM.id');
    $this->db->from('ordenesb_main as OM');
    $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
    $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
    $this->db->join('tbl_users as U', 'U.userId = OM.subida_creadopor','left');
    $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
    //$this->db->join('reparacion_main as RM', 'RM.nro_msj = OM.nro_msj','inner');
    //$this->db->join('fallas_main as FM', 'FM.id = RM.falla','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
    }

    if(!empty($searchText)) {
        switch ($criterio) {
            case 1:
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                break;
            case 2:
                $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                break;
            case 3:
                $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                break;
            case 4:
                $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                break;
            case 5:
                $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                break;
            case 8:
                $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                break;
            case 10:
                $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                break;

            default:   // Falta configurar esto y probar el buscador
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                    OR  OM.protocolo  LIKE '%".$searchText."%'
                                    OR  Mun.descrip  LIKE '%".$searchText."%'
                                    OR  EM.serie  LIKE '%".$searchText."%'
                                    OR  PM.fecha  LIKE '%".$searchText."%'
                                    OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                    OR  EMOD.descrip  LIKE '%".$searchText."%'
                                )";
                break;
        }

        $this->db->where($likeCriteria);
    }

    $this->db->where('OM.subida_estado',2);

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->where('OM.protocolo IS NOT NULL');
    $this->db->order_by("OM.protocolo", "DESC");

    $query = $this->db->get();
    return count($query->result());
}



function protocolos_ceros($searchText = '', $page, $segment,$tipo,$criterio,$userId, $role)
{
    $this->db->select('OM.protocolo, OM.id,
    OM.idequipo, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto,
    PM.fecha as fecha_procesado,

    U.name as tecnico, OM.bajada_observ,');

    //FM.descrip as falla_descrip, RM.id as id_ord_repa
    $this->db->from('ordenesb_main as OM');
    $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
    $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
    $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');
    $this->db->join('tbl_users as U', 'U.userId = OM.tecnico','left');
    $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
    //$this->db->join('reparacion_main as RM', 'RM.nro_msj = OM.nro_msj','left');
    //$this->db->join('fallas_main as FM', 'FM.id = RM.falla','left');

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = Mun.id','left');
    }

    if(!empty($searchText)) {
        switch ($criterio) {
            case 1:
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%')";
                break;
            case 2:
                $likeCriteria = "(OM.protocolo  LIKE '%".$searchText."%')";
                break;
            case 3:
                $likeCriteria = "(Mun.descrip  LIKE '%".$searchText."%')";
                break;
            case 4:
                $likeCriteria = "(EM.serie  LIKE '%".$searchText."%')";
                break;
            case 5:
                $likeCriteria = "(PM.fecha  LIKE '%".$searchText."%')";
                break;
            case 8:
                $likeCriteria = "(OM.bajada_archivos  LIKE '%".$searchText."%')";
                break;
            case 10:
                $likeCriteria = "(EMOD.descrip  LIKE '%".$searchText."%')";
                break;
            default:   // Falta configurar esto y probar el buscador
                $likeCriteria = "(OM.id  LIKE '%".$searchText."%'
                                    OR  OM.protocolo  LIKE '%".$searchText."%'
                                    OR  Mun.descrip  LIKE '%".$searchText."%'
                                    OR  EM.serie  LIKE '%".$searchText."%'
                                    OR  PM.fecha  LIKE '%".$searchText."%'
                                    OR  OM.bajada_archivos  LIKE '%".$searchText."%'
                                    OR  EMOD.descrip  LIKE '%".$searchText."%'
                                )";
                break;
        }

        $this->db->where($likeCriteria);
    }

    $this->db->where('OM.subida_estado',2);

    if (in_array($role,array(101,102,103,104,105))) {
      $this->db->where('MA.usuario',$userId);
    }

    $this->db->order_by("OM.protocolo", "DESC");
    $this->db->limit($page, $segment);

    $query = $this->db->get();
    return $query->result();
}
















/*-------------------------------------------------------------------------------*/






    function editProtocolos($protocolosInfo, $protocolo)
    {
        $this->db->where('protocolo', $protocolo);
        $this->db->update('ordenesb_main', $protocolosInfo);

        switch ($protocolosInfo['subida_estado']) {
          case 1:
            $tipo = "INGRESADO";
            break;
          case 2:
            $tipo = "CANTIDAD CERO";
            break;
          case 3:
            $tipo = "ANULADO";
            break;
          case 4:
            $tipo = "ORDEN MODIFICADA";
            break;
        }

        if ($tipo != NULL) {
          $ordenProtocolo = $this->getProtocoloInfo($protocolo);

          if ($protocolosInfo['subida_estado'] == 1 OR $protocolosInfo['subida_estado'] == 4) {
            $observacion = $ordenProtocolo->subida_observ;
          } else {
            $observacion = $protocolosInfo['subida_observ'];
          }

          $this->load->model('historial_model');
      		$registro = array(
      					'idequipo'      => $ordenProtocolo->idequipo,
                        'idcomponente'  => 0,
      					'idevento'      => 0,
                        'idestado'      => 0,
      					'tipo'          => $tipo,
      					'creadopor'     => $this->session->userdata('userId'),
      					'fecha'         => date('Y-m-d H:i:s'),
      					'detalle'       => "$ordenProtocolo->protocolo---$ordenProtocolo->id",
      					'observaciones' => $observacion,
      					'origen'        => 'PROTOCOLOS'
      				);
      		$this->historial_model->addHistorial($registro);
        }
        return TRUE;
    }

    function getProtocoloInfo($protocolo)  // Revisar esta consulta a futuro.
    {
        $this->db->select("OM.id, OM.idequipo, OM.subida_observ, OM.protocolo", FALSE);
        $this->db->from("ordenesb_main AS OM");
        $this->db->where("OM.protocolo", $protocolo);

        $query = $this->db->get();
  			return $query->row();
    }

    //ORDENES DE BAJADA DE MEMORIA OBTENER INFORMACION//

    function getOrdenesbInfo($ordenesbId)  // Revisar esta consulta a futuro.
    {
        $this->db->select("OM.id, OM.idproyecto, OM.idequipo, OM.subida_observ, OM.subida_documentos, OM.ord_procesado, OM.recibido, OM.subida_envios, OM.subida_errores, OM.subida_repetidos, OM.subida_vencidos, OM.subida_videos, OM.subida_fotos, OM.subida_ingresados, OM.bajada_fecha, OM.bajada_lat, OM.bajada_long, OM.bajada_observ, OM.bajada_desde, OM.bajada_hasta, OM.bajada_archivos, OM.protocolo, OM.bajada_archivos ,OM.activo, OM.descrip, OM.idproyecto, OM.idsupervisor, OM.iddominio, OM.conductor, OM.tecnico, OM.idequipo, OM.subida_fotos, OM.subida_videos, OM.subida_fabrica, OM.subida_envios, OM.subida_errores, OM.subida_vencidos, OM.subida_sbd, OM.subida_repetidos, OM.subida_ingresados, OM.subida_observ, OM.subida_FD, OM.subida_FH, OM.subida_fecha, OM.subida_creadopor, OM.subida_cant, OM.recibido_fecha, OM.enviado_fecha, OM.procesado_fecha, DATE_FORMAT(OM.fecha_visita, '%d-%m-%Y') AS fecha_visita, OM.fecha_alta, OM.subida_estado, PD.descrip as estadoDecripto, PE.descrip as ingresoEstado, EM.serie AS equipoSerie, EM.geo_lat AS geoLat, EM.geo_lon AS geoLon, EM.ubicacion_calle AS calle_equipo, Mun.descrip AS descripProyecto, U.name AS nameSupervisor, UC.name AS nameConductor, UT.name AS nameTecnico, F.dominio, PM.fecha as fecha_procesado, US.name as nameSubida, PE.label, PE.estado, PM.decripto, PM.incorporacion_estado , PD.color, PM.idexportacion", FALSE);
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as U', 'U.userId = OM.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico','left');
        $this->db->join('tbl_users as US', 'US.userId = OM.subida_creadopor','left');
        $this->db->join('protocolos_main as PM', 'PM.nro_msj = OM.nro_msj','left');
        $this->db->join('protocolos_estados as PE', 'PE.id_tipo = OM.subida_estado','left');
        $this->db->join('protocolos_decripto as PD', 'PM.decripto = PD.id_decripto','left');
        $this->db->from("ordenesb_main AS OM");
        $this->db->where("OM.id", $ordenesbId);

        $query = $this->db->get();
        return $query->result();
    }



    function protocolo_info($protocolo)  
    {
        $this->db->select("PM.id as id_protocolo, PM.equipo_serie, PM.fecha as fecha_alta, PM.fecha_inicial, PM.fecha_final, PM.cantidad, PM.info_fecha_sincronizacion, PM.info_desencriptados, PM.info_filtro_velocidad, PM.info_velocidad_0, PM.info_velocidad_150, PM.info_danados, PM.info_editables, PM.info_edicion, PM.info_aprobados, PM.info_descartados, PM.info_verificacion, PM.incorporacion_fecha, PM.decripto, PM.incorporacion_estado, PM.estado as pm_estado, PM.idexportacion as id_expo, PM.numero_exportacion as num_expo, PM.est_verificacion, PM.nro_msj, MUN.descrip as proyecto_name, MUN.ubicacion, PM.remoto");
        $this->db->from("protocolos_main AS PM");
        $this->db->join('municipios as MUN', 'MUN.id = PM.municipio','left');
        $this->db->where("PM.id", $protocolo);

        $query = $this->db->get();
        return $query->row();
    }


    function bajada_info($protocolo)  
    {
        $this->db->select("OM.id, OM.subida_fotos, OM.subida_videos, OM.subida_fabrica, OM.subida_documentos, OM.subida_vencidos, OM.subida_sbd, OM.subida_repetidos, OM.subida_envios, OM.subida_errores, OM.subida_ingresados,");
        $this->db->from('ordenesb_main as OM');
        $this->db->where("OM.protocolo", $protocolo);

        $query = $this->db->get();
        return $query->row();
    }



    function gruposListing()  //Grupo de bajada de memoria
    {
        $this->db->select('COUNT(*) as cantidad, OM.idproyecto, OM.tecnico, MUN.descrip AS descripProyecto,F.dominio, UT.name AS nameTecnico, UC.name AS nameConductor, OM.fecha_visita, SUM(OM.bajada_archivos) AS cantidadArchivos');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('municipios as MUN', 'MUN.id = OM.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = OM.iddominio','left');
        $this->db->join('tbl_users as UT', 'UT.userId = OM.tecnico ','left');
        $this->db->join('tbl_users as UC', 'UC.userId = OM.conductor','left');

        $this->db->where('OM.subida_estado = 0');
        $this->db->where('OM.bajada_archivos >= 0');
        $this->db->where('OM.subida_activo = 1');
        $this->db->where('OM.activo = 1');

        $this->db->group_by('OM.idproyecto');
        $this->db->group_by('OM.fecha_visita');
        $this->db->order_by("OM.fecha_visita", "ASC");
        $this->db->order_by("MUN.descrip", "ASC");

        $query = $this->db->get();
        return $query->result();
    }

    function modelos_pendientes()
    {
        $this->db->select('EMOD.descrip as modelo_equipo, SUM(OM.bajada_archivos) AS total_archivos, COUNT(*) as cantidad_equipos, ROUND((SUM(OM.bajada_archivos)/EMOD.divide_x)) as registros');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');

        $this->db->where('OM.subida_estado = 0');
        $this->db->where('OM.bajada_archivos >= 0');
        $this->db->where('OM.subida_activo = 1');
        $this->db->where('OM.activo = 1');

        $this->db->group_by('EMOD.id');
        $this->db->order_by('EMOD.descrip', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function total_modelos()
    {
        $this->db->select('SUM(OM.bajada_archivos) AS archivos, COUNT(*) as equipos');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('equipos_main as EM', 'EM.id = OM.idequipo','left');
        $this->db->join('equipos_modelos as EMOD', 'EMOD.id = EM.idmodelo','left');

        $this->db->where('OM.subida_estado = 0');
        $this->db->where('OM.bajada_archivos >= 0');
        $this->db->where('OM.subida_activo = 1');
        $this->db->where('OM.activo = 1');

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    //Listado de los protocolos remotos
    function remotosListing($searchText = '', $criterio = NULL, $page = NULL, $segment = NULL,$userId, $role,$opciones)
    {
        $this->db->select('PM.id, PM.equipo_serie, PM.idequipo, MUN.descrip AS descripProyecto, PM.fecha AS fecha_protocolo, PM.fecha_inicial_remoto, PM.fecha_final_remoto, PM.cantidad, OM.id as id_orden');
        $this->db->from('ordenesb_main as OM');
        $this->db->join('protocolos_main as PM', 'PM.id = OM.protocolo','left');
        $this->db->join('municipios as MUN', 'MUN.id = PM.municipio','left');


        if (in_array($role,array(101,102,103,104,105))) {
          $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = MUN.id','left');
        }

        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria = "(";
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

        $this->db->where('PM.remoto',1);
        $this->db->where('PM.estado_remoto',1);
        $this->db->order_by('PM.fecha', 'DESC');

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }

    function newProtocolo($protocoloInfo)
    {
        $this->db->trans_start();
        $this->db->insert('protocolos_main', $protocoloInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function editRemoto($protocoloInfo, $protocolo) //Modifico un remito.
    {
        $this->db->where('id', $protocolo);
        $this->db->update('protocolos_main', $protocoloInfo);

        return TRUE;
    }

    function editarProtocolo($protocoloInfo, $protocolo) //Modifico un remito.
    {
        $this->db->where('protocolo', $protocolo);
        $this->db->update('ordenesb_main', $protocoloInfo);

        return TRUE;
    }

    function protocolo999($idequipo) //Modifico un remito.
    {
        $sql = "UPDATE ordenesb_main
        INNER JOIN protocolos_main ON ordenesb_main.nro_msj = protocolos_main.nro_msj
        SET ordenesb_main.protocolo = protocolos_main.id
        WHERE ordenesb_main.protocolo = 999
        AND ordenesb_main.idequipo = $idequipo";

        $query = $this->db->query($sql);
        return TRUE;
    }



    function ordenes_aprobar()
	{
        $this->db->select('OM.id');
        $this->db->from('ordenesb_main as OM');
        $this->db->where('OM.transferidos_estado',10);

		$query = $this->db->get();
        return count($query->result());
	}




    function getEventos($id_orden)
    {
        $this->db->select('OEV.id, OEV.observacion, OES.nombre_estado, OES.label,TU.name as nameUsuario, OEV.fecha');
        $this->db->from('ordenesb_eventos as OEV');
        $this->db->join('ordenesb_estados as OES', 'OES.id_estado = OEV.id_estado','left');
        $this->db->join('tbl_users as TU', 'TU.userId = OEV.usuario','left');
        $this->db->where("OEV.id_orden", $id_orden);

        $query = $this->db->get();
        return $query->result();
    }


    function getErrores($id_orden)
    {
        $this->db->select('OFE.errores');
        $this->db->from('ordenesb_files_errores as OFE');
        $this->db->where("OFE.id_orden", $id_orden);

        $query = $this->db->get();
        return $query->result();
    }




    function sin_ordenes()
    {
        $sql = "SELECT PM.id, PM.municipio, PM.idequipo, PM.fecha as fecha_protocolo, PM.cantidad, PM.fecha_inicial_remoto, PM.fecha_final_remoto, PM.nro_msj, PM.equipo_serie, MUN.descrip as descripProyecto
        FROM protocolos_main as PM
        LEFT JOIN municipios as MUN ON MUN.id = PM.municipio
        LEFT OUTER JOIN ordenesb_main as OM ON PM.id = OM.protocolo
        WHERE OM.protocolo IS NULL
        AND PM.remoto = 1
        ORDER BY PM.id DESC
        LIMIT 15";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getProtocoloRemoto($protocolo)
    {
        $this->db->select('PM.id as protocolo, PM.municipio as idproyecto, PM.idequipo, PM.fecha as fecha_protocolo, PM.cantidad, PM.fecha_inicial_remoto, PM.fecha_final_remoto, PM.nro_msj, PM.equipo_serie, PM.usuario');
        $this->db->from('protocolos_main as PM');
        $this->db->where("PM.id", $protocolo);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }



















    function Sql_FechaOrdenesb($fecha)
    {
        $consulta =
            "SELECT idequipo, idproyecto
            FROM `ordenesb_main`
            WHERE bajada_fecha LIKE '$fecha%'
			AND ord_procesado IN (1,2)
            AND bajada_desde NOT LIKE '0000-00-00 00:00:00'
            AND bajada_hasta NOT LIKE '0000-00-00 00:00:00'
            AND descrip NOT LIKE 'Bajada remota'
            AND protocolo NOT LIKE '0'";

        $query = $this->db->query($consulta);
        return $query->result();
    }


    function sql_fechaProtocolos($fecha)
    {
        $consulta =
             "SELECT idequipo, municipio
             FROM `protocolos_main`
             WHERE fecha LIKE '$fecha%'
             AND fecha_inicial NOT LIKE '0000-00-00'
             AND fecha_final NOT LIKE '0000-00-00'
             AND remoto IN (0)";

        $query = $this->db->query($consulta);
        return $query->result();
    }



    function get_Protocolosmain($id)
    {
        $consulta=
            "SELECT id AS protocolo, idequipo, fecha_inicial, fecha_final, cantidad , nro_msj
            FROM `protocolos_main`
            WHERE idequipo =$id
            AND fecha_inicial NOT LIKE '0000-00-00'
            AND fecha_final NOT LIKE '0000-00-00'
            AND remoto IN (0)
            ORDER BY id DESC
            LIMIT 10";

        $query = $this->db->query($consulta);
        return $query->result();
    }




    function get_ordenebmain($id)
    {
        $consulta =
            "SELECT protocolo,idequipo,
            DATE_FORMAT( bajada_desde, '%Y-%m-%d')  AS fecha_inicial,
            DATE_FORMAT( bajada_hasta, '%Y-%m-%d' ) AS fecha_final,
            bajada_archivos AS cantidad, nro_msj
            FROM `ordenesb_main`
            WHERE idequipo =$id
            AND ord_procesado IN (1,2)
            AND bajada_desde NOT LIKE '0000-00-00 00:00:00'
            AND bajada_hasta NOT LIKE '0000-00-00 00:00:00'
            AND descrip NOT LIKE'Bajada remota'
            AND protocolo NOT LIKE '0'
            ORDER BY id DESC
            LIMIT 10";

        $query = $this->db->query($consulta);
        return $query->result();
    }


    function get_actualizaProtocolosCruzados($protocolo,$id)
    {
        $consulta = "UPDATE `ordenesb_main` SET protocolo=$protocolo WHERE id=$id";
        $query = $this->db->query($consulta);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /// UPDATE ///

    function updateProtocolosMain($protocoloInfo, $protocolo) 
    {
        $this->db->trans_begin();
        $this->db->where('id', $protocolo);
        $this->db->update('protocolos_main', $protocoloInfo);

        if ($this->db->trans_status() === FALSE){      
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();      
            return FALSE;    
        }else{      
            //La consulta se hizo correctamente.  
            $this->db->trans_commit();    
            return TRUE;    
        }  
    }


    // 
    function getDesencriptacion($idmodelo)  
    {
        $this->db->select('DE.id');
        $this->db->from('desencriptacion AS DE');
        $this->db->where("DE.id_modelo", $idmodelo);
        $this->db->where("DE.estado", 1);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    function get_protocolo_estados($id_protocolo) 
    {
        $this->db->select('estado, decripto, incorporacion_estado, est_verificacion');
        $this->db->from('protocolos_main');
        $this->db->where("id", $id_protocolo);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    function get_protocolos_estados_for_protocolo($decripto, $pm_estado, $incorporacion_estado, $est_verificacion)
    {
        // return "desde get_protocolos_estados_for_protocolo()";
        $this->db->select('*');
        $this->db->from('protocolos_estados');
        $this->db->where("decripto", $decripto);
        $this->db->where("pm_estado", $pm_estado);
        $this->db->where("incorporacion_estado", $incorporacion_estado);
        $this->db->where("est_verificacion", $est_verificacion);
        $this->db->where("activo", 1);
        $this->db->limit(1);
        $exec_query = $this->db->get();
        return $exec_query->row();
        // $row = $query->row();
        // return $row;
    }
}

?>
