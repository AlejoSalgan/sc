<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{   
    function getUserTest($userId=null){
        // SELECT userId, email, name
        // FROM tbl_users
        // LIMIT 10;
        $this->db->select('userId, email, name');
        $this->db->from('tbl_users');
        if(!empty($userId)){
            $this->db->where('userId', $userId); 
        }
        $this->db->limit(15);


        $query = $this->db->get();
        return $query->result();
    }
    

    function userListingCount($searchText = '', $filtro, $criterio)
    {
        $this->db->select('BaseTbl.userId');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->join('empresas as E', 'E.sedeID = BaseTbl.id_sede','left');
        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(BaseTbl.userId  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(BaseTbl.nombre  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(BaseTbl.apellido  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(BaseTbl.email LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(E.sede  LIKE '%".$searchText."%')";
                    break;
                case 6:
                    $likeCriteria = "(BaseTbl.interno  LIKE '%".$searchText."%')";
                    break;
                case 7:
                    $likeCriteria = "(BaseTbl.mobile  LIKE '%".$searchText."%')";
                    break;
                case 8:
                    $likeCriteria = "(Role.role  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(BaseTbl.userId  LIKE '%".$searchText."%'
                                        OR  BaseTbl.nombre  LIKE '%".$searchText."%'
                                        OR  BaseTbl.apellido  LIKE '%".$searchText."%'
                                        OR  BaseTbl.email  LIKE '%".$searchText."%'
                                        OR  E.sede  LIKE '%".$searchText."%'
                                        OR  BaseTbl.interno  LIKE '%".$searchText."%'
                                        OR  BaseTbl.mobile  LIKE '%".$searchText."%'
                                        OR  Role.role  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->where('BaseTbl.roleId !=', 99);
        $this->db->where('BaseTbl.tipo =', $filtro);
        $this->db->order_by("Role.role", "ASC");
        $this->db->order_by("BaseTbl.apellido", "ASC");

        $query = $this->db->get();
        return count($query->result());
    }


    function userListing($searchText = '', $page, $segment, $filtro, $criterio)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.mobile, Role.role, BaseTbl.nombre, BaseTbl.apellido, BaseTbl.name, BaseTbl.id_sede, BaseTbl.interno, E.sede as sede_descrip, E.telefono');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->join('empresas as E', 'E.sedeID = BaseTbl.id_sede','left');
        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(BaseTbl.userId  LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(BaseTbl.nombre  LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(BaseTbl.apellido  LIKE '%".$searchText."%')";
                    break;
                case 4:
                    $likeCriteria = "(BaseTbl.email LIKE '%".$searchText."%')";
                    break;
                case 5:
                    $likeCriteria = "(E.sede  LIKE '%".$searchText."%')";
                    break;
                case 6:
                    $likeCriteria = "(BaseTbl.interno  LIKE '%".$searchText."%')";
                    break;
                case 7:
                    $likeCriteria = "(BaseTbl.mobile  LIKE '%".$searchText."%')";
                    break;
                case 8:
                    $likeCriteria = "(Role.role  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(BaseTbl.userId  LIKE '%".$searchText."%'
                                        OR  BaseTbl.nombre  LIKE '%".$searchText."%'
                                        OR  BaseTbl.apellido  LIKE '%".$searchText."%'
                                        OR  BaseTbl.email  LIKE '%".$searchText."%'
                                        OR  E.sede  LIKE '%".$searchText."%'
                                        OR  BaseTbl.interno  LIKE '%".$searchText."%'
                                        OR  BaseTbl.mobile  LIKE '%".$searchText."%'
                                        OR  Role.role  LIKE '%".$searchText."%'
                                    )";
                    break;
            }

            $this->db->where($likeCriteria);

        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->where('BaseTbl.roleId !=', 99);
        $this->db->where('BaseTbl.tipo =', $filtro);
        $this->db->order_by("Role.role", "ASC");
        $this->db->order_by("BaseTbl.apellido", "ASC");

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }


    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $this->db->where('roleId !=', 99);
        $this->db->order_by('role', 'asc');

        $query = $this->db->get();
        return $query->result();
    }

    function getPuestos()
    {
        $this->db->select('id, descrip');
        $this->db->from('tbl_puestos');
        $this->db->order_by('descrip', 'asc');

        $query = $this->db->get();
        return $query->result();
    }

    function getJerarquiaByUser($userId)
    {
    	$this->db->select('p.jerarquia');
    	$this->db->from('tbl_users as u');
    	$this->db->join('tbl_puestos as p', 'p.id = u.puesto');
    	$this->db->where('u.userId', $userId);

    	$query = $this->db->get();
    	$row = $query->row();
    	return $row->jerarquia;
    }


    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    function getUserInfo($userId,$filtro = FALSE)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.name, BaseTbl.nombre, BaseTbl.apellido, BaseTbl.email, BaseTbl.mobile, BaseTbl.roleId, BaseTbl.puesto, BaseTbl.asociado, BaseTbl.imei, BaseTbl.modelomov, BaseTbl.tipo as u_tipo, BaseTbl.id_sede, BaseTbl.interno, BaseTbl.grupo');
        $this->db->from('tbl_users as BaseTbl');
        if ($filtro) {
            $this->db->select('role, tbl_puestos.descrip as u_puesto, equipos_propietarios.descrip as u_propiet,E.telefono, E.sede as sede_descrip, E.direccion');
            $this->db->join('tbl_roles','BaseTbl.roleId = tbl_roles.roleId');
            $this->db->join('tbl_puestos','tbl_puestos.id = BaseTbl.puesto');
            $this->db->join('equipos_propietarios','BaseTbl.asociado = equipos_propietarios.id','left');
            $this->db->join('empresas as E', 'E.sedeID = BaseTbl.id_sede','left');
        }

        $this->db->where('isDeleted', 0);
		    $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->where('userId', $userId);

        $query = $this->db->get();
        return $query->result();
    }

    function getPermisosInfo($userId)
    {
        $this->db->select('PE.equipos_equipos, PE.equipos_marcas, PE.equipos_tipos,
            PE.equipos_modelos, PE.equipos_propietarios,
            PE.componentes_componentes, PE.componentes_sinAsignar, PE.componentes_marcas, PE.componentes_tipos,
            PE.bajada_ordServ, PE.bajada_ordSR, PE.bajada_ordSP, PE.bajada_ordProc,
            PE.bajada_ordAnul, PE.bajada_ordCero,
            PE.bajada_grupoSE, PE.bajada_grupoSR, PE.bajada_grupoSP, PE.bajada_grupoC,
            PE.ingreso_pendientes, PE.ingreso_ingresados, PE.ingreso_anulados, PE.ingreso_cero, PE.ingreso_remotos,
            PE.novedades_novedades,
            PE.mantenimiento_solicitudes, PE.mantenimiento_ordenes,
            PE.reparacion_solicitudes, PE.reparacion_ordenes,
            PE.instalacion_solicitudes, PE.instalacion_ordenes,
            PE.calibracion_solicitudes, PE.calibracion_ordenes, PE.calibracion_ordenesP, PE.calibracion_rechazadas, PE.calibracion_finalizadas, PE.calibracion_aprobacion,
            PE.flota_flota,
            PE.socios_solicitudes, PE.socios_remitos, PE.socios_finalizados, PE.socios_rechazados,
            PE.deposito_ingresos, PE.deposito_custodia, PE.deposito_egreso, PE.deposito_finalizadas,
            PE.fotos_desencriptadas,
            PE.exportaciones_exportaciones, PE.exportaciones_detalles,
            PE.proyectos_proyectos,PE.proyectos_asignaciones
            ');
        $this->db->from('permisos as PE');
        $this->db->where('id_usuario', $userId);

        $query = $this->db->get();
        return $query->result();
    }

    function getGrupoUser($userId)
    {
        $this->db->select('grupo');
        $this->db->where('userId', $userId);
        $result = $this->db->get('tbl_users')->row();
        $data = $result->grupo;

        return $data;
    }


    function addIDPermiso($permisoID)
    {
        $this->db->trans_start();
        $this->db->insert('permisos', $permisoID);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }


    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);

        return TRUE;
    }

    function editPermiso($permisosInfo, $userId)
    {
        $this->db->where('id_usuario', $userId);
        $this->db->update('permisos', $permisosInfo);

        return TRUE;
    }



    /*function getPermiso($userId)
    {
        $sql = "SELECT equipos_equipos
        FROM permisos WHERE =".$userId;
        $this->db->select('equipos_equipos');
        $this->db->from('tbl_users');
        $query = $this->db->get($sql);

        return $query;
    }*/


    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }


    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId');
        $this->db->where('userId', $userId);
        $this->db->where('password', $oldPassword);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        return $query->result();
    }


    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }


	public function getUsuarios(){
		$this->db->select('name, email, mobile');
		$this->db->from('tbl_users');
        $this->db->order_by('name', 'asc');
		$query = $this->db->get();

		return $query;
	}

    public function getEmpleados($roleId = 0){ //0.- Todos
        $this->db->select('userId, name, email, mobile, imei');
        $this->db->from('tbl_users');

        if($roleId != 0){
            $this->db->where('roleId =', $roleId);
        }

        $this->db->order_by('name', 'asc');

        $query = $this->db->get();

        return $query->result();
    }

    public function getResponsables(){ // 2.Gerente 4.Encargado 5.Director 7.Supervisor 8.Presidente
        $this->db->select('userId, name, email, mobile, imei');
        $this->db->from('tbl_users');

        $puestos = array(2,4,5,7,8); // 2.Gerente 4.Encargado 5.Director 7.Supervisor 8.Presidente
        $this->db->where_in('puesto', $puestos);

        $this->db->order_by('name', 'asc');

        $query = $this->db->get();

        return $query->result();
    }

    function getUsuariosJoinPuestos($notid = FALSE){
    	$this->db->select('u.userId as id, u.name as nombre, p.descrip as puesto');
    	$this->db->from('tbl_users as u');
    	$this->db->join('tbl_puestos as p', 'p.id = u.puesto');
    	$this->db->where('u.tipo', 1);
    	$this->db->where('isDeleted', 0);
    	$this->db->where('roleId !=', 1);
    	// si hay una id que filtrar
    	if ($notid) {
    		$this->db->where('u.userId <>', $notid);
    	}
    	$this->db->order_by('p.jerarquia', 'desc');

    	$query = $this->db->get();

    	return $query->result();
    }

    function getUsuariosConIMEI(){
    	$this->db->select('u.userId, u.name, r.role, p.jerarquia');
    	$this->db->distinct();
    	$this->db->from('mensajes as m');
    	$this->db->join('tbl_users as u', 'm.imei = u.imei');
    	$this->db->join('tbl_puestos as p', 'p.id = u.puesto');
      $this->db->join('tbl_roles as r', 'r.roleId = u.roleId');

    	//$this->db->where('TRIM(m.imei) !=', '');
      $this->db->where('TRIM(m.imei) >', 250000000000000);
    	$this->db->order_by('u.name', 'asc');

    	$query = $this->db->get();

    	return $query->result();
    }

    public function getIMEI($idTecnico){
        $this->db->select('imei');
        $this->db->from('tbl_users');
        $this->db->where('userId =', $idTecnico);

        $query = $this->db->get();
        $result = $query->row();

        return $result->imei;
    }

    function getEmpleadosPorSector($rangos, $puesto = NULL)
    {
        $this->db->select('*');
        $this->db->from('tbl_users as u');
        $this->db->join('tbl_roles as r', 'r.roleId = u.roleId');
        $i = 1;
        foreach ($rangos as $rango) {
            if ($i == 1) {
                $this->db->where("u.roleId BETWEEN {$rango[0]} AND {$rango[1]}");
            } else {
                $this->db->or_where("u.roleId BETWEEN {$rango[0]} AND {$rango[1]}");
            }
            $i++;
        }
        if ($puesto != NULL) {
            $this->db->where('u.puesto =', $puesto);
        }
        $this->db->where('u.isDeleted =', 0);
        $this->db->order_by('name');
        $query = $this->db->get();

        return $query->result();
    }

    function getSedes(){
        $this->db->select('sedeID, sede');
        $this->db->from('empresas');
        $this->db->order_by('sede', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function userListingMemoria($searchText = '', $page, $segment, $filtro)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.mobile, Role.role, BaseTbl.name, BaseTbl.imei, BaseTbl.liberado');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId`', 603);
        $this->db->where('BaseTbl.asociado',107);
        $this->db->order_by('BaseTbl.liberado', 'DESC');
        $this->db->order_by('BaseTbl.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    function estadoPermiso($tipo){ // Devuelve activo o no un boton para una vista.
        if ($tipo == 1) {
          return "1,";
        } else {
          return "0,";
        }
    }

















    function listadoAccesos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId)
    {
        $this->db->select('AC.id, AC.nombre, AC.link, AC.orden, AC.padre, AC.tipo');
        $this->db->from('menu as AC');


        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(AC.id LIKE '%".$searchText."%')";
                    break;
                case 2:
                    $likeCriteria = "(AC.nombre LIKE '%".$searchText."%')";
                    break;
                case 3:
                    $likeCriteria = "(AC.link  LIKE '%".$searchText."%')";
                    break;
                default:
                    $likeCriteria = "(AC.id  LIKE '%".$searchText."%' OR  AC.nombre  LIKE '%".$searchText."%' OR  AC.link  LIKE '%".$searchText."%')";
                    break;
            }
            $this->db->where($likeCriteria);
        }


        $this->db->order_by('AC.id', 'DESC');
        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }


    function agregarAcceso($accesoInfo) //Agrego un nuevo menu.
    {
        $this->db->trans_start();
        $this->db->insert('menu', $accesoInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }


    function agregarMenuPermiso($infoPermiso) //Agrego un nuevo menu.
    {
        $this->db->trans_start();
        $this->db->insert('menu_permisos', $infoPermiso);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function getacceso($id_acceso)
    {
      $this->db->select('MP.id, MP.rol, MP.id_menu, AC.nombre, R.role');
      $this->db->from('menu_permisos as MP');
      $this->db->join('menu as AC','AC.id = MP.id_menu','left');
      $this->db->join('tbl_roles as R', 'R.roleId = MP.rol','left');
      $this->db->where('MP.id_menu',$id_acceso);
      $this->db->order_by('R.role',"ASC");

      $query = $this->db->get();
      return $query->result();
    }

    function eliminarPermiso($id_acceso)
    {
      $this->db->where('id', $id_acceso);
      $this->db->delete('menu_permisos');

      return TRUE;
    }


    function getPermiso($id_acceso)
    {
      $this->db->select('MP.id, MP.id_menu');
      $this->db->from('menu_permisos as MP');
      $this->db->where('MP.id',$id_acceso);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }

    function getMenu($id_acceso)
    {
      $this->db->select('AC.nombre');
      $this->db->from('menu as AC');
      $this->db->where('AC.id',$id_acceso);

      $query = $this->db->get();
      $row = $query->row();
      return $row->nombre;
    }

    function usuarios_rol($roles = NULL)
    {
        $this->db->select('U.userId, U.name');
        $this->db->from('tbl_users as U');

        if (!is_null($roles)) {
            if (is_array($roles)) {
                $this->db->where_in('U.roleId', $roles);
            } else {
                $this->db->where('U.roleId =', $roles);
            }
        }

        $this->db->where('U.isDeleted', 0);
        $this->db->order_by('U.name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
}
