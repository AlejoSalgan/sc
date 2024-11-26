<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
		function contarOperativos($tipo,$userId, $role, $grupoGestor = NULL)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			$this->db->where('EM.operativo',$tipo);
			$this->db->where('EM.eliminado',0);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();

		}

   	public function get_count_record($userId, $role, $grupoGestor = NULL)
    {
        $sql = "SELECT count(*) as cantidad
                FROM (equipos_main as EM)
                LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor ";

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
        }

				switch ($role) {
          case 60:
          case 61:
          case 62:
          case 63: //Socios.
									$sql .= " LEFT JOIN equipos_modelos as EMOD ON EMOD.id = EM.idmodelo";
                  $sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMOD.asociado";
                  $sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
             break;
        }

        $sql .= "WHERE EM.eliminado = 0 AND serie NOT LIKE '%-baj%'";

        switch ($role) {
							case 60:
	 						case 61:
	 						case 62:
	 						case 63:
	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->cantidad;
    }

    public function get_count_activos($tipo) //$tipo 0 NO - 1 SI
    {
        $sql = "SELECT id
                FROM equipos_main
                WHERE exportable = " . $tipo ."
                AND serie NOT LIKE '%-baj%' ";
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    public function get_count_calib($tipo) //$tipo 0 NO - 1 SI
    {
        $sql = "SELECT EM.id
                FROM equipos_main EM
                WHERE requiere_calib = " . $tipo ."
                AND serie NOT LIKE '%-baj%' ";
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    public function get_count_estado($tipo, $evento = NULL,$userId, $role, $grupoGestor = NULL) //1.Depósito 2.Proyecto 3.Socio 4.INTI
    {
        $sql = "SELECT count(*) as cantidad
                FROM (equipos_main as EM)
                LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor ";

				if (in_array($role,array(101,102,103,104,105))) {
	        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
	      }

				switch ($role) {
			 				 case 60:
			 				 case 61:
			 				 case 62:
			 				 case 63: //Socios.
											 $sql .= " LEFT JOIN equipos_modelos as EMOD ON EMOD.id = EM.idmodelo";
											 $sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMOD.asociado";
											 $sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
			 						break;
 			  }

				$sql .= "WHERE EM.eliminado = 0 AND serie NOT LIKE '%-baj%'";
				$sql .= "AND EM.estado = " . $tipo ."";
        $sql .= ($evento != NULL) ? " AND EM.evento_actual = " . $evento : "" ;

        switch ($role) {
							case 60:
 	 						case 61:
 	 						case 62:
 	 						case 63:
 	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
 	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->cantidad;
    }

    public function get_count_evento($tipo,$userId, $role, $grupoGestor = NULL, $asignado = NULL) //10.Depósito 20.Reparación 30.Calibración 40.Afectación 60.Asignación 90.Desafectación
    {
        $sql = "SELECT count(*) as cantidad
                FROM (equipos_main as EM)
                LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor ";

				if (in_array($role,array(101,102,103,104,105))) {
	        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
	      }

				switch ($role) {
 							case 60:
 							case 61:
 							case 62:
 							case 63: //Socios.
 											$sql .= " LEFT JOIN equipos_modelos as EMOD ON EMOD.id = EM.idmodelo";
 											$sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMOD.asociado";
 											$sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
 								 break;
	 			 }

	 			 $sql .= "WHERE EM.eliminado = 0 AND serie NOT LIKE '%-baj%'";

				 if ($asignado == NULL) {
				 		$sql .= "AND EM.evento_actual = " . $tipo ."";
				 } else {
				 		$sql .= "AND EM.evento_actual IN (" . $tipo .",". $asignado .")";
				 }

				switch ($role) {
							case 60:
	 						case 61:
	 						case 62:
	 						case 63:
	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->cantidad;
    }

    function equipos_evento($tipo,$userId, $role, $grupoGestor = NULL, $limit = NULL, $tipoCantidad = NULL)
    {
				switch ($tipoCantidad) {
					case 1:
						$sql = "SELECT COUNT(BaseTbl.id) as cantidad, Mun.descrip AS muni ";
						break;
					case 2:
						$sql = "SELECT COUNT(BaseTbl.id) as cantidad, BaseTbl.tipo_equipo AS tipoEquipo ";
						break;
					case 3:
						$sql = "SELECT COUNT(BaseTbl.id) as cantidad ";
						break;
					default:
						$sql = "SELECT BaseTbl.id, BaseTbl.serie, Mun.descrip AS muni, EMod.descrip AS modelo, EMarc.descrip AS marca, G.name AS nombreGestor, G.userId as gestorId ";
						break;
				}

        $sql .= "FROM equipos_main as BaseTbl
                LEFT JOIN municipios as Mun ON Mun.id = BaseTbl.municipio
                LEFT JOIN equipos_modelos as EMod ON EMod.id = BaseTbl.idmodelo
                LEFT JOIN equipos_marcas as EMarc ON EMarc.id = BaseTbl.marca
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor";

								if (in_array($role,array(101,102,103,104,105))) {
					        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
					      }

								switch ($role) {
											case 60:
											case 61:
											case 62:
											case 63: //Socios.
															$sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMod.asociado";
															$sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
												 break;
								 }

        $sql .= " WHERE evento_actual = '" . $tipo ."' AND DATEDIFF(NOW(),ts) <= 7 AND estado = 2";

				switch ($role) {
							case 60:
 	 						case 61:
 	 						case 62:
 	 						case 63:
 	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
 	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

				if ($tipoCantidad == 1) {
					$sql .= " GROUP BY muni ";
				} elseif ($tipoCantidad == 2) {
					$sql .= " GROUP BY tipo_equipo ";
				}

        $sql .= " ORDER by ts DESC "; //7 días
				if ($limit != NULL) {
					$sql .= " LIMIT 5 ";
				}

        $query = $this->db->query($sql);

        return $query->result();
    }

    function equipos_calib_vence($userId, $role, $grupoGestor = NULL) //60 días
    {
        $sql = "SELECT BaseTbl.id, BaseTbl.serie, BaseTbl.doc_fechavto, Mun.descrip AS muni, EMod.descrip AS modelo, EMarc.descrip AS marca, G.name AS nombreGestor, G.userId as gestorId, ES.descrip AS descripEstado
                FROM equipos_main as BaseTbl
                LEFT JOIN municipios as Mun ON Mun.id = BaseTbl.municipio
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor
                LEFT JOIN equipos_modelos as EMod ON EMod.id = BaseTbl.idmodelo
                LEFT JOIN equipos_marcas as EMarc ON EMarc.id = BaseTbl.marca
                LEFT JOIN estados as ES ON ES.id = BaseTbl.estado ";

								if (in_array($role,array(101,102,103,104,105))) {
					        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
					      }

								switch ($role) {
											case 60:
											case 61:
											case 62:
											case 63: //Socios.
															$sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMod.asociado";
															$sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
												 break;
								 }

                $sql .= "WHERE  doc_fechavto IS NOT NULL
                AND doc_fechavto != '0000-00-00'
								AND BaseTbl.eliminado = 0
								AND BaseTbl.activo = 1
								AND requiere_calib = 1
								AND BaseTbl.serie NOT LIKE '%-baj%'
                AND DATEDIFF(NOW(),BaseTbl.doc_fechavto) >= -60
								AND BaseTbl.doc_fechavto > NOW()" ;



				switch ($role) {
							case 60:
 	 						case 61:
 	 						case 62:
 	 						case 63:
 	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
 	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $sql .= " ORDER by doc_fechavto ASC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function equipos_calib_vencidas($userId, $role, $grupoGestor = NULL) //vencidas
    {
	    	$sql = "SELECT BaseTbl.id, BaseTbl.serie, BaseTbl.doc_fechavto, Mun.descrip AS muni, EMod.descrip AS modelo, EMarc.descrip AS marca, G.name AS nombreGestor, ES.descrip AS descripEstado
	                FROM equipos_main as BaseTbl
	                LEFT JOIN municipios as Mun ON Mun.id = BaseTbl.municipio
	                LEFT JOIN equipos_modelos as EMod ON EMod.id = BaseTbl.idmodelo
	                LEFT JOIN equipos_marcas as EMarc ON EMarc.id = BaseTbl.marca
	                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor
	                LEFT JOIN estados as ES ON ES.id = BaseTbl.estado ";

									if (in_array($role,array(101,102,103,104,105))) {
						        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
						      }

				switch ($role) {
							case 60:
							case 61:
							case 62:
							case 63: //Socios.
											$sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMod.asociado";
											$sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
								 break;
				 }

				 $sql .= "WHERE  doc_fechavto IS NOT NULL
	                AND doc_fechavto != '0000-00-00'
									AND BaseTbl.eliminado = 0
									AND BaseTbl.activo = 1
									AND requiere_calib = 1
									AND BaseTbl.serie NOT LIKE '%-baj%'
									AND BaseTbl.doc_fechavto <= NOW() ";

				switch ($role) {
						  case 60:
	 						case 61:
	 						case 62:
	 						case 63:
	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $sql .= " ORDER by doc_fechavto ASC";
	    	$query = $this->db->query($sql);

	    	return $query->result();
    }

    public function get_count_prueba($tipo) //$tipo 0 NO se probaron - 1 SI se probaron
    {
        $sql = "SELECT id
                FROM equipos_main
                WHERE prueba = " . $tipo ."
                AND serie NOT LIKE '%-baj%' ";
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    public function get_count_activosP($userId, $role, $grupoGestor = NULL)
    {
        $sql = "SELECT count(*) as cantidad
                FROM (equipos_main as EM)
                LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
                LEFT JOIN tbl_users as G ON G.userId = Mun.gestor ";

								if (in_array($role,array(101,102,103,104,105))) {
					        $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
					      }

				switch ($role) {
 							case 60:
 							case 61:
 							case 62:
 							case 63: //Socios.
 											$sql .= " LEFT JOIN equipos_modelos as EMOD ON EMOD.id = EM.idmodelo";
 											$sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMOD.asociado";
 											$sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
 								 break;
	 			 }

	 			 $sql .= "WHERE EM.activo =  1 AND EM.eliminado = 0 AND serie NOT LIKE '%-baj%'";

				switch ($role) {
							case 60:
 	 						case 61:
 	 						case 62:
 	 						case 63:
 	 										$sql .= " AND U.userId LIKE '%" . $userId . "%'";
 	 							 break;
        }

				if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        $query = $this->db->query($sql);
        $row = $query->row();

        return $row->cantidad;
    }

		function direccion($datos,$tipos_equipos,$userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.ubicacion_calle', '0');
			$this->db->or_where('EM.ubicacion_calle', '-');
			$this->db->or_where('EM.ubicacion_calle', '');
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.activo',1);
			$this->db->where('EM.estado !=',6); //Robado
			$this->db->where('EM.evento_actual !=',90); //Desafectación
			$this->db->where('EM.evento_actual !=',110); //Prueba
			$this->db->where_not_in('EM.tipo', $tipos_equipos);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}

		function altura($datos,$tipos_equipos,$userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.ubicacion_altura', '0');
			$this->db->or_where('EM.ubicacion_altura', '-');
			$this->db->or_where('EM.ubicacion_altura', '');
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.activo',1);
			$this->db->where('EM.estado !=',6); //Robado
			$this->db->where('EM.evento_actual !=',90); //Desafectación
			$this->db->where('EM.evento_actual !=',110); //Prueba
			$this->db->where_not_in('EM.tipo', $tipos_equipos);
			//$this->db->where_in('EM.ubicacion_altura', $datos);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}


		function tipo($userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.tipo',0);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}

		function vencimiento($equiposCalibrar,$userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.activo',1);
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.estado !=',4); //INTI
			$this->db->where('EM.estado !=',6); //Robado
			$this->db->where('EM.evento_actual !=',30); //Calibracion
			$this->db->where('EM.evento_actual !=',90); //Desafectación
			$this->db->where('EM.evento_actual !=',110); //Prueba
			$this->db->where('EM.doc_fechavto','0000-00-00');
			$this->db->where_in('EM.tipo', $equiposCalibrar);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}

		function calibracion($equiposCalibrar,$userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.activo',1);
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.estado !=',4); //INTI
			$this->db->where('EM.estado !=',6); //Robado
			$this->db->where('EM.evento_actual !=',30); //Calibracion
			$this->db->where('EM.evento_actual !=',90); //Desafectación
			$this->db->where('EM.evento_actual !=',110); //Prueba
			$this->db->where('EM.doc_fechacal','0000-00-00');
			$this->db->where_in('EM.tipo', $equiposCalibrar);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}

		function sentido($tipos_equipos,$userId, $role, $grupoGestor)
		{
			$this->db->select('EM.id');
			$this->db->from('equipos_main as EM');
			$this->db->join('municipios as M', 'M.id = EM.municipio','left');
			$this->db->where('EM.eliminado',0);
			$this->db->where('EM.ubicacion_sentido',0);
			$this->db->where('EM.activo',1);
			$this->db->where('EM.estado !=',6); //Robado
			$this->db->where('EM.evento_actual !=',90); //Desafectación
			$this->db->where('EM.evento_actual !=',110); //Prueba
			$this->db->where_not_in('EM.tipo', $tipos_equipos);
			$this->db->not_like('EM.serie','-baj');

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
			}

			if (in_array($role,array(101,102,103,104,105))) {
				$this->db->where('MA.usuario',$userId);
			}

			$query = $this->db->get();
			return $query->num_rows();
		}


		function longitud($datos_geo,$tipos_equipos,$userId, $role, $grupoGestor = NULL)
    {
				$this->db->select('EM.id');
				$this->db->from('equipos_main as EM');
				$this->db->join('municipios as M', 'M.id = EM.municipio','left');
				$this->db->where('EM.eliminado',0);
				$this->db->where_not_in('EM.tipo', $tipos_equipos);
				$this->db->where_in('EM.geo_lon', $datos_geo);
				$this->db->like('EM.geo_lon', 'º');
				$this->db->like('EM.geo_lon', ',');
				$this->db->not_like('EM.serie','-baj');
				$where .= "EM.geo_lon REGEXP '[AZ]' OR EM.geo_lon REGEXP '[az]'";
				$this->db->where($where);

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
				}

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

				$query = $this->db->get();
				return $query->num_rows();
    }

		function latitud($datos_geo,$tipos_equipos,$userId, $role, $grupoGestor = NULL)
    {
				$this->db->select('EM.id');
				$this->db->from('equipos_main as EM');
				$this->db->join('municipios as M', 'M.id = EM.municipio','left');
				$this->db->where('EM.eliminado',0);
				$this->db->where_not_in('EM.tipo', $tipos_equipos);
				$this->db->where_in('EM.geo_lat', $datos_geo);
				$this->db->like('EM.geo_lat', 'º');
				$this->db->like('EM.geo_lat', ',');
				$this->db->not_like('EM.serie','-baj');
				$where .= "EM.geo_lat REGEXP '[AZ]' OR EM.geo_lat REGEXP '[az]'";
				$this->db->where($where);

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = M.id','left');
				}

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

				$query = $this->db->get();
				return $query->num_rows();
    }


		function repa_ofTecnica($estado,$estadosEquipos,$role,$userId)
    {
				$this->db->select('RM.id');
				$this->db->from('reparacion_main as RM');
				$this->db->join('equipos_main as EM', 'EM.serie = RM.serie','left');
				$this->db->join('estados as ES', 'EM.estado = ES.id','left');

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = RM.idproyecto','left');
				}

				$this->db->where_in('RM.ultimo_estado', $estado);
				$this->db->where('RM.tipo', 'R');

				if (!is_null($estadosEquipos)) {
					if (is_array($estadosEquipos)) {
						$this->db->where_in('EM.estado', $estadosEquipos);
					} else {
						$this->db->where('EM.estado', $estadosEquipos);
					}
				}

				if (in_array($role,array(101,102,103,104,105))) {
					$this->db->where('MA.usuario',$userId);
				}

				$query = $this->db->get();
				return $query->num_rows();
    }

















}
