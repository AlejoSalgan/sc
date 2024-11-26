<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Municipios_model extends CI_Model
{

    function proyectoListado($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId)
    {
      $this->db->select('M.id, M.descrip as nombre_proyecto, M.remoto, M.activo,
      (SELECT COUNT(*)
      FROM `equipos_main` as EM
      WHERE  M.id = EM.municipio
      AND EM.activo = 1) AS "activos",

      (SELECT COUNT(*)
      FROM `equipos_main` as EM
      WHERE M.id = EM.municipio
      AND EM.activo = 0) AS "inactivos",

      (SELECT UG.name
      FROM `municipios_asignaciones` as MA2
      LEFT JOIN tbl_users as UG ON UG.userId = MA2.usuario
      WHERE M.id = MA2.id_proyecto
      AND UG.roleId = 102 AND MA2.prioridad = 1
      ) AS "gestor",

      (SELECT MA2.usuario
      FROM `municipios_asignaciones` as MA2
      LEFT JOIN tbl_users as UG ON UG.userId = MA2.usuario
      WHERE M.id = MA2.id_proyecto
      AND UG.roleId = 102 AND MA2.prioridad = 1
      ) AS "id_gestor"

      ');
      $this->db->from('municipios as M');
      $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');

      if(!empty($searchText)) {
          switch ($criterio) {
              case 1:
                  $likeCriteria = "(M.descrip  LIKE '%".$searchText."%')";
                  break;

              default:
                  $likeCriteria = "(M.descrip  LIKE '%".$searchText."%')";
                  break;
          }

          $this->db->where($likeCriteria);
      }

      $this->db->group_by("M.id");
      $this->db->order_by("M.descrip", "asc");

      if ($page != NULL) {
        $this->db->limit($page, $segment);
      }

      $query = $this->db->get();

      if ($page != NULL) {
        return $query->result();
      }
      return count($query->result());
    }


    function gestionAsignaciones($id_proyecto)
    {
      $this->db->select('MA.id, MA.usuario, R.role, U.name, MA.prioridad');
      $this->db->from('municipios_asignaciones as MA');
      $this->db->join('tbl_users as U', 'U.userId = MA.usuario','left');
      $this->db->join('tbl_roles as R', 'R.roleId = U.roleId','left');
      $this->db->where("MA.id_proyecto",$id_proyecto);
      $this->db->order_by("U.roleId","ASC");

      $query = $this->db->get();
      return $query->result();
    }

    function agregarProyecto($proyectoInfo)
    {
        $this->db->trans_start();
        $this->db->insert('municipios', $proyectoInfo);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();
        return $insert_id;
    }

    function getProyecto($id_proyecto)
    {
      $this->db->select('M.id, M.descrip, M.iniciales, M.codigo_municipio, M.observaciones, M.adminstracion');
      $this->db->from('municipios as M');
      $this->db->where("M.id",$id_proyecto);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }


    function editarProyecto($proyectoInfo, $id_proyecto)
    {
        $this->db->where('id', $id_proyecto);
        $this->db->update('municipios', $proyectoInfo);

        return TRUE;
    }


    function agregarAsignacion($infoAsignacion)
    {
        $this->db->trans_start();
        $this->db->insert('municipios_asignaciones', $infoAsignacion);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();
        return $insert_id;
    }

    function editarAsignacion($asignacionInfo, $id_asignacion)
    {
        $this->db->where('id', $id_asignacion);
        $this->db->update('municipios_asignaciones', $asignacionInfo);

        return TRUE;
    }

    function eliminarAsignacion($id_asignacion)
    {
      $this->db->where('id', $id_asignacion);
      $this->db->delete('municipios_asignaciones');

      return TRUE;
    }

    function getAsignacion($id_asignacion)
    {
      $this->db->select('MA.id, MA.id_proyecto, MA.prioridad');
      $this->db->from('municipios_asignaciones as MA');
      $this->db->where('MA.id',$id_asignacion);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }


///////////////////////////////////////////////////////////////////////////////////

    function municipiosListingCount($searchText = '', $criterio, $userId = NULL, $role = NULL, $grupoGestor = NULL, $estado = '')
    {
        $this->db->select('M.id');
        $this->db->from('municipios as M');
        $this->db->join('tbl_users as UG', 'UG.userId = M.gestor','left');
        $this->db->join('tbl_users as UA', 'UA.userId = M.ayudantes','left');

        if(!empty($searchText)) {
            $this->db->like('M.descrip', $searchText);
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(M.descrip  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(UG.name  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(UA.name  LIKE '%".$searchText."%')";
                    break;

                default:
                    $likeCriteria = "(M.descrip  LIKE '%".$searchText."%'
                                        OR UG.name  LIKE '%".$searchText."%'
                                        OR UA.name  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        switch ($role) {
    				case 100: // Gestión de Proyectos - Dirección (Directores)
    								$this->db->where("M.director LIKE '%" . $userId . "%'");
    					 break;

    			 case 101: //Gestión de Proyectos - Gerencia (Gerencia)
    								$this->db->where("M.gerente LIKE '%" . $userId . "%'");
    					 break;

    				case 102: //Gestión de Proyectos - Supervisión (Gestores)
                    if ($grupoGestor != 0) {
                      $this->db->where("M.grupo LIKE '%" . $grupoGestor . "%'");
                    } else {
                      $this->db->where("M.gestor LIKE '%" . $userId . "%'");
                    }
    					 break;

    				case 103: //Gestión de Proyectos (Ayudantes)
    								$this->db->where("M.ayudantes LIKE '%" . $userId . "%'");
    					 break;

    				case 104: //Gestión de Proyectos - Auditoria
    								$this->db->where("M.auditor LIKE '%" . $userId . "%'");
    					 break;
    		}

        if($estado) {
            $this->db->where("M.activo",$estado);
        } elseif ($estado === 0) {
            $this->db->where("M.activo",0);
        }

        $this->db->order_by("M.descrip", "asc");

        $query = $this->db->get();

        return count($query->result());
    }

    function municipiosListing($searchText = '', $criterio, $page, $segment,$role = NULL, $userId ,$grupoGestor = NULL)
    {
        $sql = "SELECT mun.id AS 'id', mun.iniciales AS Iniciales, mun.descrip AS Municipio, mun.activo, mun.director AS Director, mun.gestor AS Gestor, mun.gerente AS Gerente, mun.auditor AS Auditores, mun.ayudantes AS Ayudantes,

      	(SELECT COUNT(*)
      	FROM `equipos_main` as EM
      	WHERE  mun.id = EM.municipio) AS 'total_equipos',

      	(SELECT COUNT(*)
      	FROM `equipos_main` as EM
      	WHERE  mun.id = EM.municipio
      	AND EM.activo = 1) AS 'activos',

      	(SELECT COUNT(*) AS 'Activos'
      	FROM `equipos_main` as EM
      	WHERE  mun.id = EM.municipio
      	AND EM.activo = 0) AS 'inactivos'

        FROM (`municipios` AS mun)
        LEFT JOIN tbl_users as UG ON UG.userId = mun.gestor
        LEFT JOIN tbl_users as UA ON UA.userId = mun.ayudantes
        ";

        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                    $sql .= " WHERE mun.director LIKE '%" . $userId . "%'";
               break;

           case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                    $sql .= " WHERE mun.gerente LIKE '%" . $userId . "%'";
               break;

            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                    if ($grupoGestor != 0) {
                      $sql .= " WHERE mun.grupo LIKE '%" . $grupoGestor . "%'";
                    } else {
                      $sql .= " WHERE mun.gestor LIKE '%" . $userId . "%'";
                    }
               break;

            case 103: //Gestión de Proyectos (Ayudantes)
                    $sql .= " WHERE mun.ayudantes LIKE '%" . $userId . "%'";
               break;

            case 104: //Gestión de Proyectos - Auditoria
                    $sql .= " WHERE mun.auditor LIKE '%" . $userId . "%'";
               break;

               case 60:
               case 61:
               case 62:
               case 63:
                       $sql .= " WHERE U.userId LIKE '%" . $userId . "%'";
                  break;
        }

        if ($role == NULL && !empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $sql .= " WHERE mun.descrip  LIKE '%".$searchText."%'";
                    break;

                case 2:
                    $sql .= " WHERE UG.name  LIKE '%".$searchText."%'";
                    break;

                case 3:
                    $sql .= " WHERE UA.name  LIKE '%".$searchText."%'";
                    break;

                default:
                    $sql .= " WHERE (mun.descrip LIKE '%{$searchText}%' OR UG.name LIKE '%{$searchText}%' OR UA.name LIKE '%{$searchText}%' )";
                    break;
            }

        } elseif ($role != NULL && !empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $sql .= " AND mun.descrip  LIKE '%".$searchText."%'";
                    break;

                case 2:
                    $sql .= " AND UG.name  LIKE '%".$searchText."%'";
                    break;

                case 3:
                    $sql .= " AND UA.name  LIKE '%".$searchText."%'";
                    break;

                default:
                    $sql .= " AND (mun.descrip LIKE '%{$searchText}%' OR UG.name LIKE '%{$searchText}%' OR UA.name LIKE '%{$searchText}%' )";
                    break;
            }
        }


        $sql .= " ORDER BY `mun`.`descrip` asc";
        $segment = ( $segment == FALSE ) ? 0 : $segment;
        $sql .= " LIMIT $segment , $page ";

        $query = $this->db->query($sql);
        return $query->result();

    }



    function getMunicipioInfo($municipioId)
    {
        $this->db->select('id, descrip, activo, iniciales, codigo_municipio, observaciones, gestor,ayudantes,gerente,director,auditor');
        $this->db->from('municipios');
        $this->db->where('id', $municipioId);

        $query = $this->db->get();

        $row = $query->row();
        return $row;
    }

    function editMunicipio($municipioInfo, $municipioId)
    {
        $this->db->where('id', $municipioId);
        $this->db->update('municipios', $municipioInfo);

        return TRUE;
    }

    function deleteMunicipio($municipioId, $municipioInfo)
    {
        $this->db->where('id', $municipioId);
        $this->db->update('municipios', $municipioInfo);

        return $municipioInfo;
    }

    function getMunicipios($geoloc = NULL, $role = NULL, $userId = NULL, $activo = NULL, $bajada = NULL, $deposito = NULL)
    {
        $this->db->select('municipios.id, municipios.descrip, municipios.orden');
        $this->db->from('municipios');
        if (!is_null($geoloc)) {
            $this->db->distinct('municipios.descrip');
            $this->db->join('equipos_main','equipos_main.municipio = municipios.id');
            $this->db->not_like('equipos_main.serie','-baj');
            $this->db->where('equipos_main.serie !=','');
            $this->db->where('equipos_main.geo_lat !=','');
            $this->db->where('equipos_main.geo_lon !=','');
            $this->db->where('equipos_main.geo_lat !=',0);
            $this->db->where('equipos_main.geo_lon !=',0);
            $this->db->where('municipios.activo',1);
        }

        if (!is_null($role)) {
            $this->db->join('tbl_users as UG', 'UG.userId = municipios.gestor','left');

            switch ($role) {
                case 100: // Gestión de Proyectos - Dirección (Directores)
                        $this->db->where("municipios.director LIKE '%" . $userId . "%'");
                   break;

               case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                        $this->db->where("municipios.gerente LIKE '%" . $userId . "%'");
                   break;

                case 102: //Gestión de Proyectos - Supervisión (Gestores)
                        $this->db->where("municipios.gestor LIKE '%" . $userId . "%'");
                   break;

                case 103: //Gestión de Proyectos (Ayudantes)
                        $this->db->where("municipios.ayudantes LIKE '%" . $userId . "%'");
                   break;

                case 104: //Gestión de Proyectos - Auditoria
                        $this->db->where("municipios.auditor LIKE '%" . $userId . "%'");
                   break;
            }

        }

        if ($activo != NULL) {
          $this->db->where('municipios.activo',$activo);
        }

        if ($bajada != NULL) {
          $this->db->distinct('municipios.descrip');
          $this->db->join('equipos_main','equipos_main.municipio = municipios.id');
          $this->db->not_like('equipos_main.serie','-baj');
        	$this->db->where('equipos_main.serie !=','');
        	$this->db->where("(equipos_main.activo = 1 AND equipos_main.eliminado = 0)");
          $this->db->where('equipos_main.operativo',1);
          if ('equipos_tipo' == 1 || 'equipos_tipo' == 2 || 'equipos_tipo' == 400 || 'equipos_tipo' == 2402 || 'equipos_tipo' == 2407 || 'equipos_tipo' == 2412 ) {
            $where = "(equipos_main.doc_fechavto IS NOT NULL
            AND equipos_main.doc_fechavto != '0000-00-00'
            AND DATEDIFF(NOW(),equipos_main.doc_fechavto) <= 10)";
            $this->db->where($where);
          }
        }

        if ($deposito != NULL) {
          $this->db->distinct('municipios.descrip');
        }

        $this->db->order_by('orden', 'asc');
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getMunicipio($idproyecto_ant)
    {
        $this->db->select('descrip');
        $this->db->from('municipios');
        $this->db->where('id', $idproyecto_ant);

        $query = $this->db->get();

        $result = $query->row();
        return $result->descrip;
    }

    function getProyectosCalibrar($role = NULL, $userId = NULL)
    {
      $this->db->select('DISTINCT(MUN.id),MUN.descrip');
      $this->db->from('municipios as MUN');
      $this->db->join('equipos_main as EM','EM.municipio = MUN.id','left');
      $this->db->join('equipos_tipos as ET','ET.id = EM.tipo','left');

      if (in_array($role,array(101,102,103,104,105))) {
        $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = MUN.id','left');
      }

      if (in_array($role,array(101,102,103,104,105))) {
        $this->db->where('MA.usuario',$userId);
      }

      $this->db->where('ET.requiere_calibracion',1);
      $this->db->where('EM.eliminado',0);
      $this->db->not_like('EM.serie','-baj');

      $this->db->order_by('MUN.descrip',ASC);

      $query = $this->db->get();
      return $query->result();
    }

    function getProyectos()
    {
      $this->db->select('MUN.id,MUN.descrip');
      $this->db->from('municipios as MUN');
      $this->db->order_by('MUN.descrip',ASC);

      $query = $this->db->get();
      return $query->result();
    }

    function proyectosRemotos()
    {
      $this->db->select('MUN.id,MUN.descrip');
      $this->db->from('municipios as MUN');
      $this->db->where('MUN.remoto',1);
      $this->db->where('MUN.activo',1);
      $this->db->order_by('MUN.descrip',ASC);

      $query = $this->db->get();
      return $query->result();
    }



    function listarMunicipios($role = NULL, $userId = NULL, $activo = NULL)
    {
      $this->db->select('MUN.id,MUN.descrip');
      $this->db->from('municipios as MUN');
      
      if (in_array($role,array(101,102,103,104,105))){
        $this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = MUN.id','left');
        $this->db->where('MA.usuario',$userId);
      }
      $this->db->where('MUN.activo',$activo);
      $this->db->order_by('MUN.descrip', 'ASC');

      $query = $this->db->get();
      return $query->result();
    }











}
