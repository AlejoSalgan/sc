<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Ordenes extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('ordenes_model');
        $this->load->model('user_model');
        $this->load->model('flota_model');
        $this->load->model('equipos_model');
        $this->load->model('fallas_model');
        $this->load->model('estados_model');
        $this->load->model('diagnosticos_model');
        $this->load->model('mail_model');
        $this->load->model('img_reportes_model');
        $this->load->model('socios_model');
        $this->load->model('mail_model');
        $this->load->model('utilidades_model');
        $this->load->model('precintos_model');
        $this->load->model('deposito_model');
        $this->load->model('ordenesb_model');
        $this->load->model('perifericos_model');
        $this->load->model('mensajes_model');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('pagination');
    }

    function reportesFallas() // Sin permiso a la vista
    {
        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['fallas']    = $this->ordenes_model->getOrdenes(1,NULL,NULL,$this->input->get('search'),$userId, $role);
        $viewdata['search']    = $this->input->get('search');
        $viewdata['repetidas'] = $this->ordenes_model->getOrdenesAbiertas();

        $viewdata['total']    = count($viewdata['fallas']);
        $viewdata['roleUser'] = $this->role;

        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Reportes de fallas';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('fallas',$viewdata);
        $this->load->view('includes/footer');
    }

    function verFalla($idfalla) // Sin permiso a la vista
    {
      	if (!isset($idfalla) || !($viewdata['falla'] = $this->ordenes_model->getOrden($idfalla,1))) {
      		redirect('fallas');
      	}
      	$this->global['pageTitle'] = 'CECAITRA: Reporte de falla';

  	   	$viewdata['imagenes'] = $this->ordenes_model->getImagenes($viewdata['falla']->rm_serie,date('Y-m-d',strtotime($viewdata['falla']->re_fecha)));
  	   	$viewdata['abiertas'] = $this->ordenes_model->getIdsOrdenesAbiertas($viewdata['falla']->rm_serie);

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('falla',$viewdata);
      	$this->load->view('includes/footer');
    }

    function altasolicitud()
    {
        if (!$this->input->post('id')) {
    		redirect('fallas');
    	} else {
    	    if (!$this->input->post('observ')) {
    	        $observ = 'Sin observaciones.';
    	    } else {
    	        $observ = trim($this->input->post('observ'));
    	    }
    		$id_array = $this->input->post('id');
    		$sector = $this->input->post('sector');

    	}
    	foreach ($id_array as $id) {
            //getEstados ***
            $temp['estados'] = $this->ordenes_model->getEstados($id);
            $observ = ($observ == 'Sin observaciones.') ? $temp['estados'][0]->re_observ : $observ; //$temp['estados']->re_observ
    	    switch ($sector) {
    	        case 'R':
    	            $categoria = 1;
    	            $operativo = $this->input->post('operativo');
    	            break;
    	        case 'M':
    	            $categoria = 2;
    	            $operativo = TRUE;
    	            break;
    	        case 'I':
    	            $categoria = 3;
    	            $operativo = TRUE;
    	            break;
    	    }
    		$data = array(
					'orden' => $id,
					'usuario' => $this->session->userdata('userId'),
					'fecha' => date('Y-m-d H:i:s'),
					'tipo' => 2,
					'observ' => $observ,
					'asignado_categoria' => $categoria
    		);

    		if (!$this->ordenes_model->altaSolicitud($id,$data,$sector,$categoria,$operativo)) {
    			die("Error al ingresar el id {$id}");
    		}
    	}
    	redirect('fallas');
    }

    function mantenimientoSolicitudes()
    {
        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['search']      = $this->input->get('search');
        $viewdata['solicitudes'] = $solicitudes = $this->ordenes_model->getOrdenes(2,'M',NULL,$this->input->get('search'),$userId, $role);
        $viewdata['usuarios']    = $this->user_model->getUsuariosConIMEI();
        $viewdata['vehiculos']   = $this->flota_model->getVehiculos(3);
        $viewdata['roleUser']    = $this->role;
        $viewdata['repetidas'] = $this->ordenes_model->getOrdenesAbiertas('M');

    	  $count = count($viewdata['solicitudes']);

    	  $this->global['pageTitle'] = 'CECAITRA: Solicitudes de mantenimiento';

        $viewdata['titulo']    = 'Mantenimiento';
        $viewdata['subtitulo'] = 'Solicitudes';

        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_solicitudes',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function reparacionesSolicitudes()
    {
        $role   = $this->role;
        $userId = $this->session->userdata('userId');

    	$viewdata['search'] = $this->input->get('search');

        $count = count($viewdata['solicitudes']);

    	$viewdata['solicitudes'] = $this->ordenes_model->getOrdenes(2,'R',NULL,$this->input->get('search'),$userId, $role);

        $viewdata['usuarios']  = $this->user_model->getUsuariosConIMEI();
        $viewdata['vehiculos'] = $this->flota_model->getVehiculos(6);
        $viewdata['roleUser']  = $this->role;
        $viewdata['repetidas'] = $this->ordenes_model->getOrdenesAbiertas('R');

    	  $this->global['pageTitle'] = 'CECAITRA: Solicitudes de reparación';

        $viewdata['titulo']    = 'Reparaciones';
        $viewdata['subtitulo'] = 'Solicitudes';

        $userId = $this->session->userdata('userId');

        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_solicitudes',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function instalacionesSolicitudes()
    {
        $role   = $this->role;
        $userId = $this->session->userdata('userId');

    	  $viewdata['search'] = $this->input->get('search');
        $count = count($viewdata['instalaciones']);

    	  $viewdata['solicitudes'] = $this->ordenes_model->getOrdenes(2,'I',NULL,$this->input->get('search'),$userId, $role);

        $viewdata['usuarios']  = $this->user_model->getUsuariosConIMEI();
        $viewdata['vehiculos'] = $this->flota_model->getVehiculos(4);
        $viewdata['roleUser']  = $this->role;
        $viewdata['repetidas'] = $this->ordenes_model->getOrdenesAbiertas('I');

    	  $this->global['pageTitle'] = 'CECAITRA: Solicitudes de instalación';

        $viewdata['titulo']    = 'Instalaciones';
        $viewdata['subtitulo'] = 'Solicitudes';
        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_solicitudes',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function verSolicitud($idorden)
    {
      	if (!isset($idorden) || !($viewdata['orden'] = $this->ordenes_model->getOrden($idorden,2))) {
      		redirect('fallas');
      	}

      	switch ($viewdata['orden']->rm_tipo) {
      		case 'R':
      			$viewdata['titulo'] = 'Reparaciones';
      			break;
      		case 'M':
      			$viewdata['titulo'] = 'Mantenimiento';
      			break;
      		case 'I':
      			$viewdata['titulo'] = 'Instalaciones';
      			break;
      		default:
      			die('Error: Falta tipo de solicitud/orden');
      	}

    	  $this->global['pageTitle'] = "CECAITRA: Ver solicitud de {$viewdata['titulo']}";

        $viewdata['subtitulo'] = 'Solicitudes';
        $viewdata['estados']   = $this->ordenes_model->getEstados($viewdata['orden']->rm_id);
        $viewdata['imagenes']  = $this->ordenes_model->getImagenes($viewdata['orden']->rm_serie,date('Y-m-d',strtotime($viewdata['estados'][0]->re_fecha)));

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_solicitud',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function altaorden()
    {
    	if (!$this->input->post('estado')) {
    		redirect($this->input->get('ref'));
    	} else {
    	    if (!$this->input->post('observ')) {
    	        $observ = 'Sin observaciones.';
    	    } else {
    	        $observ = trim($this->input->post('observ'));
    	    }
    	}

    	$id_array = $this->input->post('id');
    	foreach ($id_array as $id) {
    	    $orden = $this->ordenes_model->getOrden($id);
    		$data_estado = array(
    				'orden'	=> $id,
    				'usuario' => $this->session->userdata('userId'),
    				'fecha' => date('Y-m-d H:i:s'),
    				'observ' => $observ,
                    'asignado_categoria' => $orden->rm_ultimo_categoria,
    		);
    		switch ($this->input->post('estado')) {
    			// Aprobar solicitud
    			case 'a':
    				$data_estado['tipo'] = 3;

    				if (!$this->ordenes_model->altaOrden($id,$data_estado)) {
    					die("Error al aprobar la solicitud {$id} (error de transacción)");
    				}
    				break;
    			// Rechazar solicitud
    			case 'r':
    				$data_estado['tipo'] = 8;
    				if (!$this->ordenes_model->rechazarSolicitud($id,$data_estado, $orden)) {
    					die("Error al rechazar la solicitud {$id} (error de transacción)");
    				}
    				break;
    			default:
    				redirect($this->input->get('ref'));
    		}
    	}
    	redirect($this->input->get('ref'));
    }

    function mantenimientoOrdenes()
    {
    	  $estados = array(3,4,5,6,9,10,11);

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $searchText = $this->input->get('searchText');
        $viewdata['searchText'] = $searchText;

        $count   = $this->ordenes_model->getCountOrdenes($estados,'M',NULL,$searchText,$userId, $role);
        $contPag = 15;

        $viewdata['categorias'] = $this->ordenes_model->getCategorias();
        $viewdata['estados']    = $this->estados_model->getEstados();
        $viewdata['diagnosticos']    = $this->diagnosticos_model->getDiagnosticos();

        $rango = array(array(600,699));
        $tipos = array(1,3);
        $viewdata['vehiculos'] = $this->flota_model->getVehiculos($tipos);
        $viewdata['usuarios']  = $this->user_model->getEmpleadosPorSector($rango,11);//Puesto tecnico

        $returns = $this->paginationCompress( "mantenimiento/ordenes/", $count, $contPag, 3);

        $viewdata['ordenes'] =  $this->ordenes_model->getOrdenes($estados,'M',NULL,$searchText,$userId, $role, $returns["page"], $returns["segment"]);

    	  for ($i = 0; $i < count($viewdata['ordenes']); $i++) {
      		$viewdata['ordenes'][$i]->total = $this->ordenes_model->tiempoTotal($viewdata['ordenes'][$i]->rm_id);
      		$viewdata['ordenes'][$i]->cat_total = $this->ordenes_model->tiempoCatTotal($viewdata['ordenes'][$i]->rm_id,$viewdata['ordenes'][$i]->rc_id);
      		$viewdata['ordenes'][$i]->eve_total = $this->ordenes_model->tiempoEveTotal($viewdata['ordenes'][$i]->rm_id);

    	    switch ($viewdata['ordenes'][$i]->rc_id) {
    	        case 5:
    	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->ema_id;
    	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->ema_descrip;
    	            break;
    	        case 6:
    	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->mu_id;
    	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->mu_descrip;
    	            break;
    	        default:
    	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->rc_id;
    	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->rc_descrip;
    	    }
    	  }

      	$this->global['pageTitle'] = 'CECAITRA: Órdenes de mantenimiento';

        $viewdata['titulo']    = 'Mantenimiento';
        $viewdata['subtitulo'] = 'Órdenes';
        $viewdata['roleUser']  = $this->role;
        $viewdata['ordenes_fechas'] = $this->ordenes_model->ordenes_fechas();
        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_ordenes',$viewdata);
      	$this->load->view('includes/footer');
    }

    function reparacionesOrdenes()
    {
        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $searchText = $this->input->get('searchText');
        $viewdata['searchText'] = $searchText;

        $count   = $this->ordenes_model->getCountOrdenes(REPA_ABIERTAS,'R',NULL,$searchText,$userId, $role);
        $contPag = 15;

        $viewdata['categorias']   = $this->ordenes_model->getCategorias();
        $tipo = array('T','R'); //T-Todos y E- Equipos.
        $viewdata['estados'] = $this->estados_model->getEstados($tipo,1);
        $viewdata['diagnosticos'] = $this->diagnosticos_model->getDiagnosticos();

        $rango = array(array(200,299));
        $viewdata['vehiculos'] = $this->flota_model->getVehiculos(6);
        $viewdata['usuarios']  = $this->user_model->getEmpleadosPorSector($rango,11);//Puesto tecnico

        $returns = $this->paginationCompress( "reparaciones/ordenes/", $count, $contPag, 3);
        $viewdata['ordenes']    = $this->ordenes_model->getOrdenes(REPA_ABIERTAS,'R',NULL,$searchText,$userId, $role, $returns["page"], $returns["segment"]);

        //die('<pre>'.print_r($socios,TRUE).'<pre>');

      	for ($i = 0; $i < count($viewdata['ordenes']); $i++) {
      		$viewdata['ordenes'][$i]->total = $this->ordenes_model->tiempoTotal($viewdata['ordenes'][$i]->rm_id);
          $viewdata['ordenes'][$i]->cat_total = $this->ordenes_model->tiempoCatTotal($viewdata['ordenes'][$i]->rm_id,$viewdata['ordenes'][$i]->rc_id);
          $viewdata['ordenes'][$i]->eve_total = $this->ordenes_model->tiempoEveTotal($viewdata['ordenes'][$i]->rm_id);

      	    switch ($viewdata['ordenes'][$i]->rc_id) {
      	        case 5:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->ema_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->ema_descrip;
      	            break;
      	        case 6:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->mu_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->mu_descrip;
      	            break;
      	        default:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->rc_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->rc_descrip;
      	    }
      	}

    	  $this->global['pageTitle'] = 'CECAITRA: Órdenes de reparación';

        $viewdata['titulo']    = 'Reparaciones';
        $viewdata['subtitulo'] = 'Órdenes';
        $viewdata['roleUser']  = $this->role;
        $viewdata['ordenes_fechas'] = $this->ordenes_model->ordenes_fechas();
        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_ordenes',$viewdata);
      	$this->load->view('includes/footer');
    }

    function instalacionesOrdenes()
    {
    	  $estados = array(3,4,5,6,9,10,11,17);

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['search']     = $this->input->get('search');
        $viewdata['ordenes']    = $this->ordenes_model->getOrdenes($estados,'I',NULL,$this->input->get('search'),$userId, $role);
        $viewdata['categorias'] = $this->ordenes_model->getCategorias();
        $viewdata['estados']    = $this->estados_model->getEstados();
        $viewdata['diagnosticos']    = $this->diagnosticos_model->getDiagnosticos();

        $rango = array(array(500,599));
        $viewdata['vehiculos'] = $this->flota_model->getVehiculos(4);
        $viewdata['usuarios']  = $this->user_model->getEmpleadosPorSector($rango,11);//Puesto tecnico

      	$count = count($viewdata['ordenes']);
      	for ($i = 0; $i < $count; $i++) {
      		$viewdata['ordenes'][$i]->total = $this->ordenes_model->tiempoTotal($viewdata['ordenes'][$i]->rm_id);
      		$viewdata['ordenes'][$i]->cat_total = $this->ordenes_model->tiempoCatTotal($viewdata['ordenes'][$i]->rm_id,$viewdata['ordenes'][$i]->rc_id);
      		$viewdata['ordenes'][$i]->eve_total = $this->ordenes_model->tiempoEveTotal($viewdata['ordenes'][$i]->rm_id);
      	    switch ($viewdata['ordenes'][$i]->rc_id) {
      	        case 5:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->ema_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->ema_descrip;
      	            break;
      	        case 6:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->mu_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->mu_descrip;
      	            break;
      	        default:
      	            $viewdata['ordenes'][$i]->ra_id = $viewdata['ordenes'][$i]->rc_id;
      	            $viewdata['ordenes'][$i]->ra_descrip = $viewdata['ordenes'][$i]->rc_descrip;
      	    }
      	}

    	  $this->global['pageTitle'] = 'CECAITRA: Órdenes de instalación';

        $viewdata['titulo']    = 'Instalaciones';
        $viewdata['subtitulo'] = 'Órdenes';
        $viewdata['roleUser']  = $this->role;
        $viewdata['ordenes_fechas'] = $this->ordenes_model->ordenes_fechas();
        $viewdata['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_ordenes',$viewdata);
      	$this->load->view('includes/footer');
    }

    function verOrden($idorden)
    {
      	if (!isset($idorden) || !($viewdata['orden'] = $this->ordenes_model->getOrden($idorden))) {
      		redirect($this->input->get('ref'));
      	} else {
      		$estados = array(3,4,5,6,7,8,9,10,11,14,15,16,17,18,19);
      		if (!in_array($viewdata['orden']->rm_ultimo_estado, $estados)) {
      			redirect($this->input->get('ref'));
  	   		}
  	   		if ($this->ordenes_model->getEstado($idorden,2)) {
  	   		    $viewdata['orden'] = $this->ordenes_model->getOrden($idorden,$viewdata['orden']->rm_ultimo_estado,2);
  	   		} else {
  	   		    $viewdata['orden'] = $this->ordenes_model->getOrden($idorden,$viewdata['orden']->rm_ultimo_estado);
  	   		}
      	}

        $ref = explode('/',$this->input->get('ref'));
        $sector = substr(ucfirst($ref[0]), 0, 1);

        if (empty($sector)) { //Cuando redirecciono desde la funcion agregarObservacion y la orden existe no trae el sector por $ref viene vacio.
          $sector = $this->ordenes_model->getTipoOrden($idorden);
          $sector = $sector->tipo;
        }

        switch ($sector) {
      		case 'R':
              $viewdata['titulo']    = 'Reparaciones';
              $viewdata['vehiculos'] = $this->flota_model->getVehiculos(6);
        			$rango = array(array(200,299));
      			break;
      		case 'M':
        			$viewdata['titulo'] = 'Mantenimiento';
        			$tipos = array(1,3);
        			$viewdata['vehiculos'] = $this->flota_model->getVehiculos($tipos);
        			$rango = array(array(600,699));
      			break;
      		case 'I':
              $viewdata['titulo']    = 'Instalaciones';
              $viewdata['vehiculos'] = $this->flota_model->getVehiculos(4);
        			$rango = array(array(500,599));
              $viewdata['cortes']  = $this->ordenes_model->getCortes($idorden);
              $viewdata['cant_cortes']  = $this->ordenes_model->getCountCortes($idorden);

      			break;
      		default:
      			 die('Error: Falta tipo de solicitud/orden');
      	}
      	$this->global['pageTitle'] = "CECAITRA: Ver orden de {$viewdata['titulo']}";

        $viewdata['subtitulo'] = 'Órdenes';
        $viewdata['usuarios']  = $this->user_model->getEmpleadosPorSector($rango,11);//Puesto tecnico
        $viewdata['imagenes']  = $this->ordenes_model->getImagenes($viewdata['orden']->rm_serie,date('Y-m-d',strtotime($viewdata['orden']->re_fecha)));
        $viewdata['estados']   = $this->ordenes_model->getEstados($viewdata['orden']->rm_id);
        $viewdata['visitas']  = $this->ordenes_model->getVisitas($idorden);
        $viewdata['ultima_visita'] = $this->ordenes_model->ordenes_fechas($idorden);
        $viewdata['archivos'] = $this->ordenes_model->getArchivos($idorden,NULL,1);
        $viewdata['cant_archivos'] = $this->ordenes_model->getArchivos($idorden,1,1);

        $viewdata['roleUser'] = $this->role;

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_orden',$viewdata);
      	$this->load->view('includes/footer');
    }

    function fechaCorte($idorden)
    {
      	if (!isset($idorden) || !($viewdata['orden'] = $this->ordenes_model->getOrden($idorden))) {
      		redirect($this->input->get('ref'));
      	}
        $viewdata['titulo'] = 'Instalaciones';

        $this->global['pageTitle'] = "CECAITRA: Agregar fecha de corte";
      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_alta_fechaCorte',$viewdata);
      	$this->load->view('includes/footer');
    }

    function addfechaCorte()
    {
        $fecha_desde = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde'));
        $fecha_hasta = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta'));
        $hora_desde  = date("H:i:s", strtotime($this->input->post('hora_desde')));
        $hora_hasta  = date("H:i:s", strtotime($this->input->post('hora_hasta')));
        $id_orden    = $this->input->post('id_orden');
        $orden       = $this->ordenes_model->getOrden($id_orden);

        $fechaDesde_corte = $fecha_desde." ".$hora_desde;
        $fechaHasta_corte = $fecha_hasta." ".$hora_hasta;

        if (!$this->input->post('observ')) {
            $observacion = 'Sin observaciones.';
        } else {
            $observacion = trim($this->input->post('observ'));
        }

        $fechaInfo = array('id_orden'=>$id_orden,
                            'fecha_desde'=>$fechaDesde_corte,
                            'fecha_hasta'=>$fechaHasta_corte,
                            'observacion'=>$observacion,
                            'creado_por'=>$this->vendorId);

        $result     = $this->ordenes_model->addCorte($fechaInfo);

        if($result == true){
          $this->session->set_flashdata('success', "Nueva fecha de corte asignada correctamente para el equipo $orden->rm_serie.");
        } else {
            $this->session->set_flashdata('error',"Error al asignar fecha de corte para el equipo $orden->rm_serie.");
        }

        redirect('instalaciones/ordenes');
    }

    function updateOrden()
    {
      	if ($this->input->post('fecha_visita') && $this->input->post('conductor') && $this->input->post('tecnico') && $this->input->post('idflota') && $this->input->post('id')) {

      		$fecha_visita = DateTime::createFromFormat('d/m/Y', $this->input->post('fecha_visita'));

      		$data = array(
      				'fecha_visita' => $fecha_visita->format('Y-m-d'),
      				'conductor' => $this->input->post('conductor'),
      				'tecnico' => $this->input->post('tecnico'),
      				'idflota' => $this->input->post('idflota')
      		);

      		$this->ordenes_model->updateOrden($this->input->post('id'),$data);
      		redirect($this->input->get('ref'));
      	} else {
      		if ($this->input->get('ref2')) {
      			redirect($this->input->get('ref2'));
      		} else {
      			redirect('dashboard');
      		}
      	}
    }

    function actualizarVisita()
    {
      	if ($this->input->post('fecha_visita') && $this->input->post('conductor') && $this->input->post('tecnico') && $this->input->post('idflota') && $this->input->post('id')) {

      		$fecha_visita = DateTime::createFromFormat('d/m/Y', $this->input->post('fecha_visita'));
          $serie = $this->input->post('serie');

      		$visitaInfo = array(
      				'fecha_visita' => $fecha_visita->format('Y-m-d'),
      				'conductor' => $this->input->post('conductor'),
      				'tecnico' => $this->input->post('tecnico'),
      				'idflota' => $this->input->post('idflota'),
              'observacion' => $this->input->post('ult_observ'),
              'creado_por'=>$this->vendorId
      		);

      		$result = $this->ordenes_model->updateVisita($this->input->post('id_visita'),$visitaInfo);

          if($result == true){
            $this->session->set_flashdata('success', "Nueva fecha de visita actualizada correctamente para el equipo $serie.");
          }else{
            $this->session->set_flashdata('error',"Error al actualizar fecha de visita para el equipo $serie.");
          }

      		redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
      	} else {
      		if ($this->input->get('ref2')) {
      			redirect($this->input->get('ref2'));
      		} else {
      			redirect('dashboard');
      		}
      	}
    }

    function enviarOrden()
    {
    	if ($this->input->post('idorden')) {
    	    if (!$this->input->post('observ')) {
    	        $observ = 'Sin observaciones.';
    	    } else {
    	        $observ = trim($this->input->post('observ'));
    	    }

    	    $orden = $this->ordenes_model->getOrden($this->input->post('idorden'));
          if ($orden->rm_ultimo_categoria == 3 && $this->ordenes_model->getEstados($this->input->post('idorden'),1) != 3) { //Si la ultima categoria y la primera es distinta de instalaciones entonces agregamos este dato.
            $origen  = '***REPAIRS'; // Una palabra para identificar que viene de otro sector y no de la misma de instalaciones.
            $observ .= $origen;
          }

    		  $data_estado = array(
            				'orden'	=> $this->input->post('idorden'),
            				'usuario' => $this->session->userdata('userId'),
            				'fecha' => date('Y-m-d H:i:s'),
                    'observ' => $observ,
            				'tipo' => 11,
                    'asignado_categoria' => $orden->rm_ultimo_categoria
    		);

    		$this->ordenes_model->visitaProgramada($this->input->post('idorden'),$data_estado,$origen);
        redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
    	} else {
    		redirect('dashboard');
    	}
    }

    function mantenimientoRechazadas()
    {
    	  $estados = 8;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

    	  $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'M',NULL,$this->input->get('search'),$userId, $role);

    	  $count = count($viewdata['ordenes']);

    	  $this->global['pageTitle'] = 'CECAITRA: Órdenes de mantenimiento';

        $viewdata['titulo']    = 'Mantenimiento';
        $viewdata['subtitulo'] = 'Órdenes rechazadas';

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_rechazadas',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function reparacionesRechazadas()
    {
    	  $estados = 8;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['search']  = $this->input->get('search');
        $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'R',NULL,$this->input->get('search'),$userId, $role);

    	  $count = count($viewdata['ordenes']);

    	  $this->global['pageTitle'] = 'CECAITRA: Órdenes de reparación';

        $viewdata['titulo']    = 'Reparaciones';
        $viewdata['subtitulo'] = 'Órdenes rechazadas';

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_rechazadas',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function instalacionesRechazadas()
    {
    	  $estados = 8;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['search']  = $this->input->get('search');
        $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'I',NULL,$this->input->get('search'),$userId, $role);

    	  $count = count($viewdata['ordenes']);

    	  $this->global['pageTitle'] = 'CECAITRA: Órdenes de instalación';

        $viewdata['titulo']    = 'Instalaciones';
        $viewdata['subtitulo'] = 'Órdenes rechazadas';

    	  $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    	  $this->load->view('SEC_rechazadas',$viewdata);
    	  $this->load->view('includes/footer');
    }

    function mantenimientoFinalizadas()
    {
    	  $estados = 7;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $searchText = $this->input->post('searchText');
        $viewdata['searchText'] = $searchText;

        $count = $this->ordenes_model->getCountOrdenes($estados,'M','desc',$searchText,$userId, $role);
        $contPag = 15;
        $returns = $this->paginationCompress( "mantenimiento/finalizadas/", $count, $contPag, 3);

        $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'M','desc',$searchText,$userId, $role,
            $returns["page"], $returns["segment"]);

      	foreach ($viewdata['ordenes'] as $orden) {
      	    $orden->total = $this->ordenes_model->tiempoFinalizada($orden->rm_id);
      	}

        $viewdata['titulo']    = 'Mantenimiento';
        $viewdata['subtitulo'] = 'Órdenes finalizadas';

        $this->global['pageTitle'] = 'CECAITRA: Órdenes de mantenimiento';
      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_finalizadas',$viewdata);
      	$this->load->view('includes/footer');
    }

    function reparacionesFinalizadas()
    {
      	$estados = 7;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $searchText = $this->input->post('searchText');
        $viewdata['searchText'] = $searchText;

        $count = $this->ordenes_model->getCountOrdenes($estados,'R',NULL,$searchText,$userId, $role);
        $contPag = 15;

        $returns = $this->paginationCompress( "reparaciones/finalizadas/", $count, $contPag, 3);

        $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'R','desc',$searchText,$userId, $role,
            $returns["page"], $returns["segment"]);

        foreach ($viewdata['ordenes'] as $orden) {
            $orden->total = $this->ordenes_model->tiempoFinalizada($orden->rm_id);
        }

      	$this->global['pageTitle'] = 'CECAITRA: Órdenes de reparación';

        $viewdata['titulo']    = 'Reparaciones';
        $viewdata['subtitulo'] = 'Órdenes finalizadas';

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_finalizadas',$viewdata);
      	$this->load->view('includes/footer');
    }

    function instalacionesFinalizadas()
    {
        $estados = array(7,18);

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $viewdata['search']  = $this->input->get('search');
        $viewdata['ordenes'] = $this->ordenes_model->getOrdenes($estados,'I','desc',$this->input->get('search'),$userId, $role);
        foreach ($viewdata['ordenes'] as $orden) {
            $orden->total = $this->ordenes_model->tiempoFinalizada($orden->rm_id);
        }

      	$count = count($viewdata['ordenes']);

      	$this->global['pageTitle'] = 'CECAITRA: Órdenes de instalación';

        $viewdata['titulo']    = 'Instalaciones';
        $viewdata['subtitulo'] = 'Órdenes finalizadas';

      	$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
      	$this->load->view('SEC_finalizadas',$viewdata);
      	$this->load->view('includes/footer');
    }


    function finalizarorden()
    {
      //Migrar lo de reparaciones a un controlador especifico.
      //Campos Recibidos
            $observ = trim($this->input->post('observ'));
            $carateres = strlen($observ);
            $fecha = date('Y-m-d H:i:s');
            $id_orden = $this->input->post('idorden');

            if ($carateres < 50) {
                $this->session->set_flashdata('error', 'La observacion que escribiste tiene menos de 50 caracteres.');
                redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
            }

            //Creo que esta es mas resumida que la linea siguiente hay que acomodar la segunda para que estas dos sean una sola con sus modelos correspondientes.
            $tipoOrden = $this->ordenes_model->getTipoOrden($id_orden);//Obtengo el tipo de orden.
            $orden = $this->ordenes_model->getOrden($id_orden);

            //Para una orden de instalacion que originalmente se creo en reparaciones tiene que volver a este sector
            switch ($tipoOrden->tipo) {
              case 'R':
              $primerEstado = $this->ordenes_model->primerEvento($id_orden);
              $titulo = explode('/',$this->input->get('ref'));

              if ($primerEstado != 3 && $titulo[0] == 'instalaciones') {
                $data_estado = array(
                    'orden'	=> $id_orden,
                    'usuario' => $this->session->userdata('userId'),
                    'fecha' => date('Y-m-d H:i:s'),
                    'observ' => $observ,
                    'tipo' => 3,
                    'asignado_categoria' => 1
                );

                //2 (estado del equipo), 3 (ultimo estado)
                $this->ordenes_model->reasignarOrden($id_orden,$data_estado,2,3);
              } else {
                $data_estado = array(
                        'orden'	=> $id_orden,
                        'usuario' => $this->session->userdata('userId'),
                        'fecha' => $fecha,
                        'observ' => $observ,
                        'tipo' => 7,
                        'asignado_categoria' => $orden->rm_ultimo_categoria
                );

                $remitoDeposito = $this->deposito_model->getIDremito($id_orden);

                if($remitoDeposito){
                  $depositoInfo = array('estado' => 40);
                  $result = $this->deposito_model->actualizarRemito($depositoInfo,$remitoDeposito->id);

                  $eventoInfo  = array('id_deposito'=>$remitoDeposito->id, 'observacion'=>$observ, 'estado'=>40,'fecha'=>date('Y-m-d H:i:s'),  'usuario'=>$this->vendorId);
                  $result = $this->deposito_model->agregarEvento($eventoInfo);
                }

                //La orden se finaliza en el proyecto o se entrega a Deposito.

                if ($this->input->post('estado') == 1) {
                  //Oficina Tecnica Reparacion
                  $estado = 5;

                  $remitoInfo = array(
                      'id_equipo'=>$orden->em_id,
                      'id_proyecto'=>$orden->rm_idproyecto,
                      'categoria'=>$orden->rm_ultimo_categoria,
                      'estado'=>10,
                      'creado_por'=>$this->vendorId,
                      'ts_creado'=>date('Y-m-d H:i:s')
                  );
                  $result = $this->deposito_model->agregarRemito($remitoInfo);

                } else {
                  $estado = $this->input->post('estado');
                }

                $this->ordenes_model->finalizarOrden($id_orden,$data_estado,$this->input->post('ultimo_estado'),$estado,$this->input->post('diagnostico'));


                //Busco los datos para armar el mail
                $datos_mail = $this->mail_model->mail_config(1);

                //Buscar todos los gestores y ayudantes para enviar en un futuro, segun el proyecto
                $gestores_to = $this->mail_model->mail_gestores(1,$orden->rm_idproyecto,1);
                $gestores_cc = $this->mail_model->mail_gestores(1,$orden->rm_idproyecto,2);
                $gestores_cco = $this->mail_model->mail_gestores(1,$orden->rm_idproyecto,3);

                //Buscar los que quieran recibir una copia
                $gral_to = $this->mail_model->mail_gral(1,1);
                $gral_cc = $this->mail_model->mail_gral(1,2);
                $gral_cco = $this->mail_model->mail_gral(1,3);

                //todos los merge necesarios
                $mails_to = array_merge($gestores_to,$gral_to);
                $mails_cc = array_merge($socios_cc,$gestores_cc,$gral_cc);
                $mails_cco = array_merge($socios_cco,$gestores_cco,$gral_cco);

                $resultado = $this->mail_model->mail_enviado($datos_mail,$mails_to,$mails_cc,$mails_cco,$orden->rm_serie,$orden->mu_descrip,$observ,$fecha,$id_orden);

              }
              break;

              case 'M':
              case 'I':
                  $data_estado = array(
                          'orden'	=> $this->input->post('idorden'),
                          'usuario' => $this->session->userdata('userId'),
                          'fecha' => $fecha,
                          'observ' => $observ,
                          'tipo' => 7,
                          'asignado_categoria' => $orden->rm_ultimo_categoria
                  );
                  $this->ordenes_model->finalizarOrden($this->input->post('idorden'),$data_estado,$this->input->post('ultimo_estado'),$this->input->post('estado'),$this->input->post('diagnostico'));
                  break;

              default:
                die("Error al finalizar la orden.");
                break;
            }
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));

    }

    function reparacionesIndicadores()
    {
        $this->global['pageTitle'] = 'CECAITRA: Órdenes de reparación';

        $viewdata['titulo']        = 'Indicadores';

        //Ejemplos para los indicadores.

        $viewdata['nombre1']      = 'Porcentaje de Equipos Operativos';
        $viewdata['puesto']       = 'Gerente de reparaciones';
        $viewdata['periodicidad'] = 'Mensual';
        $viewdata['descripcion1'] = 'Se obtiene el porcentaje de la cantidad de Equipos Operativos respecto del total
        instalado.';
        $viewdata['valorMinimo1'] = '80';
        $viewdata['valorMaximo1'] = '100';
        $viewdata['valorTotal1']  = '2000';
        $viewdata['formula1']     = $this->ordenes_model->porcentaje(834,$viewdata['valorTotal1'],2);
        $viewdata['cantidad1']    = $this->ordenes_model->cantidad($viewdata['formula1'],$viewdata['valorTotal1'],0);
        $viewdata['nombreBarra1'] = 'Equipos Operativos';

        $viewdata['nombre2']      = 'Porcentaje de Solicitudes Atendidas';
        $viewdata['descripcion2'] = 'Se contabiliza la cantidad de solicitudes e incidentes atendidos.';
        $viewdata['valorMinimo2'] = '95';
        $viewdata['valorMaximo2'] = '100';
        $viewdata['valorTotal2']  = '1000';
        $viewdata['formula2']     = $this->ordenes_model->porcentaje(950,$viewdata['valorTotal2'],2);
        $viewdata['cantidad2']    = $this->ordenes_model->cantidad($viewdata['formula2'],$viewdata['valorTotal2'],0);
        $viewdata['nombreBarra2'] = 'Solicitudes Atendidas';

        $viewdata['nombre3']      = 'Tiempo de Respuesta Primera Intervención';
        $viewdata['descripcion3'] = 'Se controla el tiempo transcurrido desde la apertura de un requirimiento hasta la primera intervención del area.';
        $viewdata['valorMinimo3'] = '0';
        $viewdata['valorMaximo3'] = '7';
        $viewdata['valorTotal3']  = '0';
        $viewdata['formula3']     = $this->ordenes_model->porcentaje(0,$viewdata['valorTotal3'],2);
        $viewdata['cantidad3']    = $this->ordenes_model->cantidad($viewdata['formula3'],$viewdata['valorTotal3'],0);
        $viewdata['nombreBarra3'] = 'Tiempo de Respuesta';

        $viewdata['nombre4']      = 'Tiempo Promedio de Respuesta Cierre';
        $viewdata['descripcion4'] = 'Se establece un tiempo promedio de duracion de una Orden de Trabajo abierta, controlando la fecha de apertura y cierre de la misma';
        $viewdata['valorMinimo4'] = '1';
        $viewdata['valorMaximo4'] = '15';
        $viewdata['valorTotal4']  = '0';
        $viewdata['formula4']     = $this->ordenes_model->porcentaje(0,$viewdata['valorTotal4'],2);
        $viewdata['cantidad4']    = $this->ordenes_model->cantidad($viewdata['formula4'],$viewdata['valorTotal4'],0);
        $viewdata['nombreBarra4'] = 'Tiempo Promedio';

        $viewdata['nombre5']      = 'Tiempo transcurrido cierre ordenes (CABA)';
        $viewdata['descripcion5'] = 'Considerando las penalidades impuestas en el convenio firmado con CABA referido al cumplimiento en tiempo y forma de las reparaciones de los equipos, se medirá el tiempo transcurrido desde que se solicita la reparación hasta que el equipo quede reparado. El tiempo maximo exigido por el convenio es cinco dias para la reparación';
        $viewdata['valorMinimo5'] = '1';
        $viewdata['valorMaximo5'] = '5';
        $viewdata['valorTotal5']  = '0';
        $viewdata['formula5']     = $this->ordenes_model->porcentaje(0,$viewdata['valorTotal5'],2);
        $viewdata['cantidad5']    = $this->ordenes_model->cantidad($viewdata['formula5'],$viewdata['valorTotal5'],0);
        $viewdata['nombreBarra5'] = 'Tiempo Transcurrido';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('SEC_indicadores',$viewdata);
        $this->load->view('includes/footer');
    }

    function desestimarReporte()
    {
        if ($this->input->post('idreporte')) {
            if (!$this->input->post('observ')) {
                $observ = 'Sin observaciones.';
            } else {
                $observ = trim($this->input->post('observ'));
            }
            $orden = $this->ordenes_model->getOrden($this->input->post('idreporte'));
            $data_estado = array(
                'orden'	=> $this->input->post('idreporte'),
                'usuario' => $this->session->userdata('userId'),
                'fecha' => date('Y-m-d H:i:s'),
                'observ' => $observ,
                'tipo' => 12,
                'asignado_categoria' => $orden->rm_ultimo_categoria
            );
            $this->ordenes_model->desestimarReporte($this->input->post('idreporte'),$data_estado);
        }
        redirect("fallas?search={$this->input->post('ref')}");
    }

    function reportesDesestimados()
    {
        $estados = 12;
        $viewdata['searchText'] = $this->input->get('search');

        $count   = $this->ordenes_model->getCountOrdenes($estados,NULL,NULL,$searchText,$this->session->userdata('userId'), $this->role);
        $returns = $this->paginationCompress( "reportes-desestimados/", $count, CANTPAGINA );
        $viewdata['ordenes']    = $this->ordenes_model->getOrdenes($estados,NULL,NULL,$viewdata['searchText'],$this->session->userdata('userId'), $this->role, $returns["page"], $returns["segment"]);

        $viewdata['titulo']    = 'Reportes';
        $viewdata['subtitulo'] = 'Desestimados';

        $this->global['pageTitle'] = 'CECAITRA: Reportes desestimados';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('desestimados',$viewdata);
        $this->load->view('includes/footer');
    }

    function verDesestimado($idfalla) // Sin permiso a la vista
    {
        if (!isset($idfalla) || !($viewdata['falla'] = $this->ordenes_model->getDesestimada($idfalla,1))) {
            redirect('fallas');
        }
        $this->global['pageTitle'] = 'CECAITRA: Reporte de falla';

        $viewdata['imagenes'] = $this->ordenes_model->getImagenes($viewdata['falla']->rm_serie,date('Y-m-d',strtotime($viewdata['falla']->re_fecha)));
        $viewdata['estados']  = $this->ordenes_model->getEstados($viewdata['falla']->rm_id);
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('desestimado',$viewdata);
        $this->load->view('includes/footer');
    }

    function agregarObservacion()
    {
        if ($this->input->post('observ') && $this->input->post('rm_ultimo_estado')) {
            $observ = trim($this->input->post('observ'))==''?'Sin observaciones.':trim($this->input->post('observ'));
            $orden = $this->ordenes_model->getOrden($this->input->post('rm_id'));
            $data_estado = array(
                'orden'	=> $this->input->post('rm_id'),
                'usuario' => $this->session->userdata('userId'),
                'fecha' => date('Y-m-d H:i:s'),
                'observ' => $observ,
                'tipo' => $this->input->post('rm_ultimo_estado'),
                'asignado_categoria' => $orden->rm_ultimo_categoria
            );
            $this->ordenes_model->insertarEstado($data_estado);
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
        }
        redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
    }

    function alta()
    {
        $this->global['pageTitle'] = 'CECAITRA: Alta de orden';

        $ref = explode('/',$this->input->get('ref'));
        $viewdata['ref'] = $this->input->get('ref');
        $viewdata['titulo']    = ucfirst($ref[0]);
        $viewdata['subtitulo'] = 'Alta de orden nueva';
        $viewdata['sector']    = substr($viewdata['titulo'], 0, 1);
        switch ($viewdata['titulo']) {
			     case 'Reparaciones':
				      $viewdata['equipos']   = $this->equipos_model->getEquipos();
				   break;
			     case 'Mantenimiento':
			     case 'Instalaciones':
				      $viewdata['equipos']   = $this->equipos_model->getEquiposFijos2();
				   break;
        }

        $viewdata['fallas']    = $this->fallas_model->getFallas();

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('SEC_alta_orden',$viewdata);
        $this->load->view('includes/footer');
    }

    function alta_solicitud()
    {
        $ref = explode('/',$this->input->get('ref'));

        $viewdata['titulo']    = ucfirst($ref[0]);
        $viewdata['subtitulo'] = 'Alta de solicitud nueva';
        $viewdata['sector']    = substr($viewdata['titulo'], 0, 1);
        $viewdata['equipos']   = $this->equipos_model->getEquipos();

        if ($ref[0] === 'instalaciones') {
          $viewdata['fallas']    = $this->fallas_model->getFallasSector($viewdata['sector'],61);
        } else {
          $viewdata['fallas']    = $this->fallas_model->getFallas();
        }

        $this->global['pageTitle'] = 'CECAITRA: Alta de solicitud';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('SEC_alta_solicitud',$viewdata);
        $this->load->view('includes/footer');
    }

    function altanuevaorden()
    {
        if (!$this->input->post('equipo') || !$this->input->post('problema')) {
            redirect($this->input->post('ref'));
        } else {
            $idequipo = $this->input->post('equipo');
            $equipo = $this->equipos_model->getEquipoInfo($idequipo[0]);
            $problema = $this->input->post('problema');

            //ACA PREGUNTAR SI EXISTE UN EQUIPO EN DEPOSITO ESTADO 20
            // SI DEVUELVE VERDADERO FLASHDATA CON ERROR Y REDIRECCIONO A LA MISMA VISTA
            if($this->ordenes_model->estadoEquipo($idequipo[0],20) && $this->input->post('sector') == "R") {
                $this->session->set_flashdata('error',"El equipo se encuentra en Custodia, solicitarlo a Deposito.");
                redirect("ordenes/alta?ref=reparaciones/ordenes");
            }

            $bajadas = $this->ordenesb_model->ordenEnviada($idequipo[0]);

            if ($bajadas) {
              foreach ($bajadas as $bajada) {
                  $ordenesbInfo = array('enviado'=>NULL, 'recibido'=>NULL, 'enviado_fecha'=>NULL, 'recibido_fecha'=>NULL, 'nro_msj'=>"");

                  $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $bajada->id);
                  $result2 = $this->mensajes_model->deleteMensaje($bajada->id);

                  $mensajesInfo = array(
                  'imei'=>$bajada->imei,
                  'tipo'=>"3010",
                  'codigo'=>date('Ymd His'),
                  'equipo'=>"Borrar Registro",
                  'datos'=>$bajada->nro_msj,
                  'origen'=>1,
                  'intentos'=>0,
                  'estado'=>0,
                  'fecha_recepcion'=>date('Y-m-d'));

                  $result3 = $this->mensajes_model->addNewMensaje($mensajesInfo);
                  sleep(2);
              }
            }

        }

        if (!$this->input->post('observ')) {
            $observ = 'Sin observaciones.';
        } else {
            $observ = trim($this->input->post('observ'));
        }

        switch ($this->input->post('sector')) {
            case 'R':
                $categoria = 1;
                if ($problema[0] === '108') {
                  $operativo = 1;
                } else {
                  $operativo = $this->input->post('operativo');
                }
                break;
            case 'M':
                $categoria = 2;
                break;
            case 'I':
                $categoria = 3;
                break;
        }


        $data_orden = array(
            'tipo' => $this->input->post('sector'),
            'ultimo_estado' => 3,
            'serie' => $equipo[0]->serie,
            'idproyecto' => $equipo[0]->municipio,
            'falla' => $problema[0],
            'nro_msj' => date('Ymd His'),
            'ultimo_categoria' => $categoria,
            'equipo_operativo' => $operativo?1:0
        );

        $data_estado = array(
            'tipo' => 3,
            'usuario' => $this->session->userdata('userId'),
            'fecha' => date('Y-m-d H:i:s'),
            'observ' => $observ,
            'asignado_categoria' => $categoria
        );

        $gestor = $this->mail_model->getGestor($data_orden['idproyecto']); // obtengo nombre y mail del gestor

        $equipoSerie = $data_orden['serie'];
        $detalle = $data_estado['observ'];
        $fecha = $data_estado['fecha'];
        $nameTo = $gestor->name;
        $emailTo = $gestor->email;

        if(!$this->ordenes_model->altaNuevaOrden($data_orden,$data_estado)){
          $this->session->set_flashdata('error',"Error al aprobar la solicitud {$id} (error de transacción)");
        }else{
            $this->mail_model->enviarMail(8, $equipoSerie, NULL, $detalle, $fecha, NULL,
                $categoria, $emailTo, $nameTo);
            $this->session->set_flashdata('success',"Orden creada correctamente para el equipo ". $equipo[0]->serie ."" );
        }

        redirect("ordenes/alta?ref={$this->input->post('ref')}");
    }

    function altanuevasolicitud()
    {
        if (!$this->input->post('equipo') || !$this->input->post('problema')) {
            redirect($this->input->get('ref'));
        } else {
            $idequipo = $this->input->post('equipo');
            $equipo   = $this->equipos_model->getEquipoInfo($idequipo[0]);
            $problema = $this->input->post('problema');

            //ACA PREGUNTAR SI EXISTE UN EQUIPO EN DEPOSITO ESTADO 20
            // SI DEVUELVE VERDADERO FLASHDATA CON ERROR Y REDIRECCIONO A LA MISMA VISTA
            if($this->ordenes_model->estadoEquipo($idequipo[0],20)) {
                $this->session->set_flashdata('error',"El equipo se encuentra en Custodia, solicitarlo a Deposito.");
                redirect("ordenes/alta_solicitud?ref=reparaciones/solicitudes");
            }
        }

        if (!$this->input->post('observ')) {
            $observ = 'Sin observaciones.';
        } else {
            $observ = trim($this->input->post('observ'));
        }
        switch ($this->input->post('sector')) {
            case 'R':
                $categoria = 1;
                $operativo = $this->input->post('operativo');
                $redirect = 'reparaciones';
                break;
            case 'M':
                $categoria = 2;
                $operativo = TRUE;
                $redirect = 'mantenimiento';
                break;
            case 'I':
                $categoria = 3;
                $operativo = TRUE;
                $redirect = 'instalaciones';
                break;
        }
        $data_orden = array(
            'tipo' => $this->input->post('sector'),
            'ultimo_estado' => 2,
            'serie' => $equipo[0]->serie,
            'idproyecto' => $equipo[0]->municipio,
            'falla' => $problema[0],
            'nro_msj' => date('Ymd His'),
            'ultimo_categoria' => $categoria,
            'equipo_operativo' => $operativo?1:0
        );

        $data_estado = array(
            'tipo' => 2,
            'usuario' => $this->session->userdata('userId'),
            'fecha' => date('Y-m-d H:i:s'),
            'observ' => $observ,
            'asignado_categoria' => $categoria
        );

        if (!$this->ordenes_model->altaNuevaSolicitud($data_orden,$data_estado)) {
            die("Error al aprobar la solicitud {$id} (error de transacción)");
        }

        redirect("{$redirect}/solicitudes");
    }

    function reasignarOrden()
    {
        if (!$this->input->post('idorden') && !$this->input->get('ref')) {
            redirect('dashboard');
        }

        if (!$this->input->post('observ')) {
            $observ = 'Sin observaciones.';
        } else {
            $observ = trim($this->input->post('observ'));
        }

        $fecha = date('Y-m-d H:i:s');
        $id_orden = $this->input->post('idorden');
        $estado_equipo = $this->input->post('estado');
        $orden = $this->ordenes_model->getOrden($id_orden);

        $data_estado = array(
            'orden'	=> $id_orden,
            'usuario' => $this->session->userdata('userId'),
            'fecha' => $fecha,
            'observ' => $observ,
            'tipo' => $this->input->post('ultimo_estado'),
            'asignado_categoria' => $this->input->post('categoria')
        );

        $this->ordenes_model->reasignarOrden($id_orden,$data_estado,$estado_equipo);

        //Busco los datos para armar el mail
        $datos_mail = $this->mail_model->mail_config(3);

        //Buscar todos los gestores y ayudantes para enviar en un futuro, segun el proyecto
        $gestores_to = $this->mail_model->mail_gestores(3,$orden->rm_idproyecto,1);
        $gestores_cc = $this->mail_model->mail_gestores(3,$orden->rm_idproyecto,2);
        $gestores_cco = $this->mail_model->mail_gestores(3,$orden->rm_idproyecto,3);

        //Buscar los que quieran recibir una
        $gral_to = $this->mail_model->mail_gral(3,1);
        $gral_cc = $this->mail_model->mail_gral(3,2);
        $gral_cco = $this->mail_model->mail_gral(3,3);

        //todos los merge necesarios
        $mails_to = array_merge($gestores_to,$gral_to);
        $mails_cc = array_merge($socios_cc,$gestores_cc,$gral_cc);
        $mails_cco = array_merge($socios_cco,$gestores_cco,$gral_cco);

        $resultado = $this->mail_model->mail_enviado($datos_mail,$mails_to,$mails_cc,$mails_cco,$orden->rm_serie,$orden->mu_descrip,$observ,$fecha,$id_orden);

        redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
    }

    function agregarVisitas()
    {
        $id_orden     = $this->input->post('id_orden');
        $dir_uri      = $this->input->post('dir_uri');
        $serie        = $this->input->post('serie');

        $ref          = explode('/',$dir_uri);
        $area         = ucfirst($ref[0]);
        $tipo         = substr($area, 0, 1);

        $conductor    = $this->input->post('conductor');
        $tecnico      = $this->input->post('tecnico');
        $fecha_visita = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
        $vehiculo     = $this->input->post('vehiculo');
        $observacion  = $this->input->post('observacion');

        if (!$this->input->post('observacion')) {
            $observacion = 'Sin observaciones.';
        } else {
            $observacion = trim($this->input->post('observacion'));
        }

        $visitaInfo = array('id_orden'=>$id_orden,
                            'tipo'=>$tipo,
                            'fecha_visita'=>$fecha_visita,
                            'tecnico'=>$tecnico,
                            'conductor'=>$conductor,
                            'idflota'=>$vehiculo,
                            'observacion'=>$observacion,
                            'creado_por'=>$this->vendorId);

        $result     = $this->ordenes_model->addVisita($visitaInfo);

        if($result == true){
          $this->session->set_flashdata('success', "Nueva fecha de visita asignada correctamente para el equipo $serie.");
        }else{
            $this->session->set_flashdata('error',"Error al asignar fecha de visita para el equipo $serie.");
        }

        redirect($dir_uri."?searchText=".$this->input->get('searchText'));
    }

    function getStatsOrden()
    {
        if ($this->input->post('idorden')) {
            $out = $this->ordenes_model->getCategoriasOrden($this->input->post('idorden'));
            echo json_encode($out);
        }
    }

    function getFechaUltEvento()
    {
        if ($this->input->post('idorden')) {
            $out = $this->ordenes_model->getUltimoEvento($this->input->post('idorden'));
            echo json_encode($out);
        }
    }

    function altaNovedad()
    {
        $this->global['pageTitle'] = 'CECAITRA: Alta de novedad';

        $viewdata['titulo']    = 'Novedades';
        $viewdata['subtitulo'] = 'Crear novedad';
        $viewdata['equipos']   = $this->equipos_model->getEquipos();
        $viewdata['fallas']    = $this->fallas_model->getFallas();

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('alta_novedad',$viewdata);
        $this->load->view('includes/footer');
    }

    function altaNuevaNovedad()
    {
        if (!$this->input->post('equipo') || !$this->input->post('problema')) {
            redirect('alta_novedad');
        } else {
            $idequipo = $this->input->post('equipo');
            $equipo   = $this->equipos_model->getEquipoInfo($idequipo[0]);
            $problema = $this->input->post('problema');
        }

        if (!$this->input->post('observ')) {
            $observ = 'Sin observaciones.';
        } else {
            $observ = trim($this->input->post('observ'));
        }

        $data_orden = array(
            'ultimo_estado' => 1,
            'serie' => $equipo[0]->serie,
            'idproyecto' => $equipo[0]->municipio,
            'falla' => $problema[0],
            'nro_msj' => date('Ymd His'),
            'ultimo_categoria' => 6
        );

        $data_estado = array(
            'tipo' => 1,
            'usuario' => $this->session->userdata('userId'),
            'fecha' => date('Y-m-d H:i:s'),
            'observ' => $observ,
            'asignado_categoria' => 6
        );

        $id = $this->ordenes_model->altaNuevaSolicitud($data_orden,$data_estado);
        // Si no tiene id, es porque no se pudo crear la orden
        if (!$id) {
            $viewdata['mensaje_orden'] = '<div class="alert alert-danger">Error: no se pudo crear novedad (error de transacción).</div>';
        } else {
            $viewdata['mensaje_orden'] = '<div class="alert alert-info">La orden se creó correctamente.</div>';
            $viewdata['mensajes'] = array(); $allowedExts = array("jpg","jpeg"); $cant = count($_FILES['archivos']['error'])-1;
            for ($i = 0; $i <= $cant; $i++) {
                if ($_FILES['archivos']['error'][$i] === UPLOAD_ERR_OK) {
                    $extension = end(explode(".", $_FILES["archivos"]["name"][$i]));
                    if (!in_array(strtolower($extension), $allowedExts)) {
                        $viewdata['mensajes'][] = '<div class="alert alert-warning">La extensión del archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> que está intentando cargar no está permitida. Sólo se aceptan archivos de <strong>imagen en formato JPG</strong>.</div>';
                    } elseif ($_FILES["archivos"]["type"][$i] != "image/jpeg") {
                        $viewdata['mensajes'][] = '<div class="alert alert-warning">El tipo de archivo (MIME type) de <strong>'.$_FILES["archivos"]["name"][$i].'</strong> que está intentando cargar no está permitido. Sólo se pueden subir archivos de <strong>imagen en formato JPG</strong>.</div>';
                    } else {
                        $ruta = getcwd().'/img_reportes/';
                        $fechahora = date('Ymd His');
                        $archivo = $fechahora.'-Bajada de Memorias-'.$equipo[0]->serie.'.jpg';
                        if (!move_uploaded_file($_FILES["archivos"]["tmp_name"][$i],$ruta.$archivo)) {
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">El archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> no se pudo guardar.</div>';
                        } else {
                            $data = array(
                                'codigo' => $fechahora,
                                'sector' => 'B',
                                'equipo' => $equipo[0]->serie,
                                'nombre_archivo' => $archivo,
                                'fecha_archivo' => date('Y-m-d')
                            );
                            $this->img_reportes_model->insertar($data);
                            $viewdata['mensajes'][] = '<div class="alert alert-success">El archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> se subió correctamente.</div>';
                        }
                    }
                } else {
                    switch ($_FILES['archivos']['error'][$i]) {
                        case UPLOAD_ERR_INI_SIZE:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">El archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> excede el tamaño máximo permitido por el servidor</div>';
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">El archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> excede el tamaño máximo permitido</div>';
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">El archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> sólo pudo ser subido de forma parcial</div>';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">No se pudo subir el archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong>.</div>';
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">No se pudo subir el archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong>. Falta la carpeta temporal</div>';
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">No se pudo subir el archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong>. Fallo de escritura en el disco</div>';
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">La subida del archivo <strong>'.$_FILES["archivos"]["name"][$i].'</strong> se detuvo por extensión</div>';
                            break;
                        default:
                            $viewdata['mensajes'][] = '<div class="alert alert-warning">No se pudo subir <strong>'.$_FILES["archivos"]["name"][$i].'</strong>. Error de subida desconocido</div>';
                            break;
                    }
                }
                sleep(1);
            }
            $this->global['pageTitle'] = 'CECAITRA: Alta de novedad';

            $viewdata['titulo']    = 'Novedades';
            $viewdata['subtitulo'] = 'Crear novedad';

            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('fallas_resultado',$viewdata);
            $this->load->view('includes/footer');
        }
    }

    function enviarSocio($idorden = NULL)
    {
        if (!$idorden || !$this->input->get('ref')) {
          $this->session->set_flashdata('error',"Error al enviar al socio.");
          redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
        }

        $destino = $this->input->post('destino');
        $orden = $this->ordenes_model->getOrden($idorden);

        if($destino == 5){ //Envio al Socio//
          $equipoInfo = $this->equipos_model->existeAsociado($orden->rm_serie);
          $asociado = $this->input->post('asociado');

          if (!$asociado || $asociado == "") {
            $this->session->set_flashdata('error',"No se selecciono el Asociado., $orden->rm_serie.");
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
          }

          if (!$equipoInfo->idmodelo || $equipoInfo->idmodelo == 0 || $equipoInfo->idmodelo == NULL) {
            $this->session->set_flashdata('error',"Falta el modelo del equipo, no se puede enviar la orden al socio, $orden->rm_serie.");
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
          }

          if (!$equipoInfo->asociado || $equipoInfo->asociado == NULL || $equipoInfo->asociado == "") {
            $this->session->set_flashdata('error',"Falta el asociado al modelo del equipo, no se puede enviar la orden al socio, $orden->rm_serie.");
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
          }

          $remitoInfo = array('id_equipo'=>$orden->em_id, 'id_orden'=>$idorden, 'id_asociado'=>$asociado);
          $result = $this->socios_model->agregarRemito($remitoInfo);
          $tipo = 14;

        }else{ //Envio a Deposito//

          $tipo = 17;
          $remitoDeposito = $this->deposito_model->getIDremito($idorden,30);

          if($remitoDeposito){
            $depositoInfo = array('estado' => 10);
            $result = $this->deposito_model->actualizarRemito($depositoInfo,$remitoDeposito->id);
          }else{
            $remitoInfo = array(
                'id_equipo'=>$orden->em_id,
                'id_proyecto'=>$orden->rm_idproyecto,
                'id_orden'=>$idorden,
                'categoria'=>$orden->rm_ultimo_categoria,
                'estado'=>10,
                'creado_por'=>$this->vendorId,
                'ts_creado'=>date('Y-m-d H:i:s')
            );

            $result = $this->deposito_model->agregarRemito($remitoInfo);
          }

        }

        if ($result) {
          $data_estado = array(
              'orden'	=> $idorden,
              'usuario' => $this->session->userdata('userId'),
              'fecha' => date('Y-m-d H:i:s'),
              'observ' => $this->input->post('observacion_enviar'),
              'tipo' => $tipo,
              'asignado_categoria' => $orden->rm_ultimo_categoria
          );

          $this->ordenes_model->insertarEstado($data_estado);
          $update = array ('ultimo_estado' => $tipo);
          $result2 = $this->ordenes_model->updateOrden($idorden,$update);

          if ($result2 == TRUE && $destino = 5) {
            //$this->mail_model->enviarMail(7, $orden->rm_serie, $idorden, $data_estado['observ'], date('d/m/Y',strtotime($orden->re_fecha)),NULL, NULL, NULL, NULL,$propietario);

            //Busco los datos para armar el mail
            $datos_mail = $this->mail_model->mail_config(7);

            //Busco todos los mail que esten asociados a este socio y se puedan enviar
            $socios_to = $this->mail_model->mail_socios(7,$asociado,1);
            $socios_cc = $this->mail_model->mail_socios(7,$asociado,2);
            $socios_cco = $this->mail_model->mail_socios(7,$asociado,3);

            //Buscar todos los gestores y ayudantes para enviar en un futuro, segun el proyecto
            $gestores_to = $this->mail_model->mail_gestores(7,$orden->rm_idproyecto,1);
            $gestores_cc = $this->mail_model->mail_gestores(7,$orden->rm_idproyecto,2);
            $gestores_cco = $this->mail_model->mail_gestores(7,$orden->rm_idproyecto,3);

            //Buscar los que quieran recibir una copia
            $gral_to = $this->mail_model->mail_gral(7,1);
            $gral_cc = $this->mail_model->mail_gral(7,2);
            $gral_cco = $this->mail_model->mail_gral(7,3);

            //todos los merge necesarios
            $mails_to = array_merge($socios_to,$gestores_to,$gral_to);
            $mails_cc = array_merge($socios_cc,$gestores_cc,$gral_cc);
            $mails_cco = array_merge($socios_cco,$gestores_cco,$gral_cco);

            $resultado = $this->mail_model->mail_enviado($datos_mail,$mails_to,$mails_cc,$mails_cco,$orden->rm_serie,$orden->mu_descrip);
          }

          $this->session->set_flashdata('success',"Se envio el equipo $orden->rm_serie.");
        } else {
          $this->session->set_flashdata('error',"Error al enviar el equipo $orden->rm_serie.");
        }

        redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
    }

    function recibirSocio($idorden = NULL)
    {
        if ($idorden && $this->input->get('ref')) {
            $orden = $this->ordenes_model->getOrden($idorden);
            $update = array ('ultimo_estado' => 3, 'ultimo_categoria'=> 1);

            $result = $this->ordenes_model->updateOrden($idorden,$update);

            if ($result) {
              $data_estado = array(
        				'orden'	=> $idorden,
        				'usuario' => $this->session->userdata('userId'),
        				'fecha' => date('Y-m-d H:i:s'),
                        'observ' => 'Equipo recibido.',
        				'tipo' => 3,
                        'asignado_categoria' => 1
              );
              $this->ordenes_model->insertarEstado($data_estado);

              //Si el fallo es el de daño de periferico, el estado del equipo quedara en el proyecto si no quedara en socio.
              if ($orden->rm_falla == 108) {
                $estado = 2;
              }else {
                $estado = 5;
              }

              $update_equipo = array('estado' => $estado);
        			$this->equipos_model->editEquipo($update_equipo,$orden->em_id);

              $this->session->set_flashdata('success',"Se recibio elequipo $orden->rm_serie.");
            } else {
              $this->session->set_flashdata('error',"Error al recibir el equipo $orden->rm_serie.");
            }

            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
        } else {
            $this->session->set_flashdata('error',"Error al recibir equipo del socio.");
            redirect($this->input->get('ref')."?searchText=".$this->input->get('searchText'));
        }
    }


    function adjuntar_archivo($idorden = NULL)
    {
      if ($idorden == NULL) {
         $this->session->set_flashdata('error', 'No existe esta orden.');
         redirect($this->input->get('ref'));
      }

      $orden = $this->ordenes_model->getOrden($idorden);

      if (!$orden) {
         $this->session->set_flashdata('error', 'No existe informacion de esta orden.');
         redirect($this->input->get('ref'));
      }

      $estados = array(1,2,7,8,9,10,12);
      if (in_array($orden->rm_ultimo_estado, $estados)) {
        $this->session->set_flashdata('error', 'Esta orden no se puede adjuntar archivo');
        redirect($this->input->get('ref'));
      }

      $viewdata['id_orden'] = $idorden;
      $viewdata['serie'] = $orden->rm_serie;
      $viewdata['archivos'] = $this->ordenes_model->getArchivos($idorden);
      $viewdata['cant_archivos'] = $this->ordenes_model->getArchivos($idorden,1);
      $viewdata['guardar'] = 'guardar_archivo';
      $viewdata['cargar'] = 'cargar_archivo';
      $viewdata['descargar'] = 'descargar_archivo';
      $viewdata['eliminar'] = 'eliminar_archivo';


      $this->global['pageTitle'] = 'CECAITRA: Adjuntar archivos';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('sectores/SEC_adjArchivos',$viewdata);
      $this->load->view('includes/footer');
    }

    function guardar_archivo()
    {
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $id_orden = $this->input->post('id_orden');
      $observacion = $this->input->post('observacion');

      if ($_FILES['archivo']['size'] > 1048576) {
          $this->session->set_flashdata('info', $observacion); // En caso de que el archivo sea mayor a 1MB devuelvo el dato al formulario.
          $this->session->set_flashdata('error', 'No se puede adjuntar porque el archivo pesa mas de un 1MB.');
          redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
        }

      if ($observacion == '' || $observacion == NULL) {
        $observacion = 'Sin observaciones.';
      }

      $nombre_actual = $_FILES['archivo']['name'];
      $nombre_temp   = $_FILES['archivo']['tmp_name'];
      $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));
      $fecha         = date('Ymd-His');
      $sector        = explode('/',$ref);

      //SC - SCDEV
        $destino = documentacion.$sector[0].'/'.$id_orden."_$fecha"."$ext";
      //Localhost
      //$destino = "/var/www/html/sistemac/documentacion/reparaciones/".$id_orden."_$fecha"."$ext";

      $tipo_documentacion = $this->input->post('tipo_documentacion');
      /*$sector[0] == "reparaciones" && */
      if ($tipo_documentacion == 7) {
          $nombre_archivo = $nombre_actual;
      } else {
        $nombre_archivo = $this->input->post('nombre_archivo');
      }

      if (in_array($ext, tipo_doc)){
        if (move_uploaded_file($nombre_temp,$destino)){
            //Acta de reparaciones
            if ($sector[0] == "reparaciones" && $tipo_documentacion == 7){
                $idacta = $this->reparacionesPrecintado($destino, $id_orden, $ref, $fecha, $ext , $searchText);
            }

          $archivoInfo  = array('orden'=>$id_orden,
              'nombre_archivo'=>$nombre_archivo,
              'tipo_documentacion'=>$tipo_documentacion,
              'observacion'=>$observacion,
              'archivo'=>$id_orden."_$fecha"."$ext",
               'tipo'=>$ext,
              'creado_por'=>$this->vendorId,
               'fecha_ts'=>date('Y-m-d H:i:s')
              );


          $resultado = $this->ordenes_model->agregarArchivo($archivoInfo);//Agrego el los presupuesto.

          if ($sector[0] == "reparaciones" && $tipo_documentacion == 7){
              $this->precintos_model->update_archivoID($resultado, $idacta);
          }
          $this->session->set_flashdata('success', 'Archivo guardado correctamente para la orden de trabajo Nº '.$id_orden.'');
        }else{
          $this->session->set_flashdata('error', 'Error al guardar archivo para la orden de trabajo Nº '.$id_orden.'');
        }
      }else{
        $this->session->set_flashdata('error', 'Formato de archivo no aceptado o no se adjunto archivo.');
      }
      redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
    }

    function cargar_archivo($id_orden = NULL)
    {
      $ref = $this->input->get('ref');
      $searchText = $this->input->get('searchText');

      if ($id_orden == NULL) {
         $this->session->set_flashdata('error', 'No existe esta orden.');
         redirect($ref);
      }

      $orden = $this->ordenes_model->getOrden($id_orden);

      if (!$orden) {
         $this->session->set_flashdata('error', 'No existe informacion de esta orden.');
         redirect($ref);
      }

      $estados = array(1,2,7,8,9,10,12);
      if (in_array($orden->rm_ultimo_estado, $estados)) {
        $this->session->set_flashdata('error', 'Esta orden no se puede adjuntar archivo');
        redirect($this->input->get('ref'));
      }

      $archivoInfo = array('estado'=> 1);
      $result = $this->ordenes_model->updateArchivos($archivoInfo, $id_orden);

      if($result == TRUE){ // Agrego un nuevo evento.
          $this->session->set_flashdata('success', 'Archivos cargados correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al cargar archivos.');
      }
      redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);

    }


    function descargar_archivo()
    {
      $name = $this->input->post('name');
      $tipo = $this->input->post('tipo');
      $id_orden = $this->input->post('id_orden');
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $direccion = $this->input->post('direccion');
      $sector = explode('/',$ref);
      $link = $direccion."?ref=".$ref."&searchText=".$searchText;

      if (array_key_exists($tipo, tipos_mime)) {
        $tipo = tipos_mime[$tipo];
      } else {
        $this->session->set_flashdata('error', 'Error al descargar el archivo.');
        redirect($link);
      }
      //SC - SCDEV
        $destino = documentacion.$sector[0].'/'.$name;
      //Localhost
      //$destino = '/var/www/html/sistemac/documentacion/reparaciones/'.$name;

      if (!file_exists($destino)) {
        $this->session->set_flashdata('error', 'No existe el archivo para esta orden.');
        redirect($link);
      }
      $this->utilidades_model->descargar_archivos($name,$tipo,$destino);
    }

    function eliminar_archivo($id = NULL)
    {
      $id_orden = $this->input->get('orden');
      $ref = $this->input->get('ref');
      $searchText = $this->input->get('searchText');

      if($id == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
      }

      $archivo = $this->ordenes_model->getArchivo($id);

      if (!$archivo) { //Valido que el remito exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
      }

      $sector = explode('/',$ref);
      //SC - SCDEV
        $destino = documentacion.$sector[0].'/';
      //Localhost
      //$destino = '/var/www/html/sistemac/documentacion/reparaciones/';

      if (unlink($destino.$archivo->archivo)) {

          if ($archivo->tipo_documentacion == 7 ){

              $this->precintos_model->eliminar_acta($id);
          }

        $archivoInfo  = array('activo'=>0, 'modificado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));

        $this->ordenes_model->updatearchivo($archivoInfo, $id);

        $this->session->set_flashdata('success', 'Archivo adjunto borrado.');
      } else {
        $this->session->set_flashdata('error', 'Error al borrar el archivo adjuntado.');
      }
      redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
    }

   /* Precintos */
   /**
    *
    *Este método es usado para validar que los campos obligatorios del acta esten cargados.
    *
    * @access public
    * @param id de acta , ruta de archivo a reemplazar.
    * @return array
    *
    * @author Cristian Lencina <clencina@cecaitra.org.ar>
    */
    function validar_excel_reparaciones($archivo)
    {
        require_once (APPPATH.'/third_party/PHPExcel.php'); // Libreria phpExcel.
        //$campo_control = Array();
        $modific_instrum = array();
        $campos_equipo = array();

        //claves de las columnas a recorrer del Excel.
        $claves = array( 0 => "C7",  1 => "C9" ,  2 => "C10",  3 => "H9");
        //Campos.
        $campos =  array( 0 => "Fecha",  1 => "Marca", 2 =>"Modelo", 3 => "Serie");
        $col_excel = array( 0 => "B",  1 => "D" ,  2 => "F",  3 => "H");
        $filas_modificacion_intr = array( 0 => "B40", 1 => "B41", 2 => "B42", 3 => "B43");
        $campos_precintos =  array( 0 => "Punto Precintado",  1 => "Precinto Anterior" ,  2 => "Estado",  3 => "Precinto Nuevo");
        $control = TRUE;
        $con = 0;
        $con2 = 0;
        //Lectura del Excel Cargado
        $inputFileType = PHPExcel_IOFactory::identify($archivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $objPHPExcel = $objReader->load($archivo);

        //Se lee la hoja activa del Excel, es decir la primera que aparece cuando ejecutas el archivo.
        $sheet = $objPHPExcel->getActiveSheet();

     /* //Metodo que optiene la ultima fila del archivo.
        $highestRow = $sheet->getHighestRow();
        // Metodo que optiene la ultima columna del archivo.
        $highestColumn = $sheet->getHighestColumn();
        //array que guarda los puntos de precintado del Excel.
        $puntos_precintado = array();
      */
        //valor maximo del indice para que recorra el "FOR"
        $max = count($claves);

        $date = $sheet->getCell("C7")->getFormattedValue();
        $date = date('d-m-Y', strtotime($date));
        $serie = $sheet->getCell("H9")->getValue();

        while ($control && $i != 4) {
            for ($i = 0; $i < 4; $i++) {
                if ( empty( $sheet->getCell($claves[$i])->getValue())) {
                    $campo_control .= "Falta el campo "."<strong>".$campos[$i]."</strong>"." en la celda "."<strong>".$claves[$i]."</strong>";
                    $control = FALSE;
                    break;
                } else {
                    if ($i == 0) {
                        $date = $sheet->getCell("C7")->getFormattedValue();
                        $date = date('d-m-Y', strtotime($date));
                        $campos_equipo[] = $date;
                    } else {
                        $campos_equipo[] = $sheet->getCell($claves[$i])->getValue();
                    }
                }
            }
        }

        if ($control) {
            $indice = 0;
            $punto_precintado = array();
            //Ciclo For que recorre el inicio de la tabla dondese encuentran los datos (celda B14).
            for ($row = 14; $row < 38; $row++) {
                if ($row < 29 || $row > 30) {
                    $result = $sheet->getCell( "B".$row )->getValue();
                    if ( empty($result) == FALSE) {
                        $punto_precintado[$indice][] = $result;
                        for ($i = 2 ; $i < $max; $i++) {
                            $punto_precintado[$indice][1] = $sheet->getCell($col_excel[1].$row)->getValue();
                            $result2 = $sheet->getCell($col_excel[$i].$row)->getValue();
                            if (empty($result2)) {
                                $campo_control.= "En la Fila "."<strong>".$row."</strong>"." Falta el Campo "."<strong>".$campos_precintos[$i]." - "."</strong>"."<br>";
                                $control = FALSE;
                                break;
                            } else {
                                $punto_precintado[$indice][] = $result2;
                            }
                        }
                        $indice++;
                     } else {
                         $cont_puntos = 0;
                         for ($i = 2 ; $i < $max; $i++) {

                             $result2 = $sheet->getCell($col_excel[$i].$row)->getValue();

                             if (!empty($result2)) {
                                 $cont_puntos++;
                             }
                         }
                         if ($cont_puntos != 0) {
                             $campo_control.= "En la Fila "."<strong>".$row."</strong>"." Falta el Campo "."<strong>"."Puntos de Precintado "."</strong>"."<br>";
                             $control = FALSE;
                         }
                         $con2++;
                         $campo_control_puntos .= "En la Fila "."<strong>".$row."</strong>"." Falta el campo "."<strong>"."Puntos de Precintado "."</strong>"."-"."<br>";

                     }
                }
            }
        }

        if ($con2 == 22) {
            $datos = array(0, $campo_control_puntos);
            $control = FALSE;
            return $datos;
            exit;
        }

        if ($control) {
            for ($i = 0; $i < 4; $i++) {
                $campo_modif = $sheet->getCell($filas_modificacion_intr[$i])->getValue();
                if ( empty($campo_modif)) {
                    $con++;
                } else {
                    $modific_instrum[] =  $campo_modif."-";
                }
            }
            if ($con == 4) {
                $control = FALSE;
                $campo_control .= "Falta el campo "."<strong>"."Modificación del instrumento"."</strong>"."<br>";
            }
        }

//          var_dump($control);
//          var_dump($campo_control_puntos);
//          var_dump($campo_control);
//          die("carlos");

        if ($control) {
            $datos = array(1,$campos_equipo,$punto_precintado,$modific_instrum);
            return $datos;
        } else {
            $datos = array(0, $campo_control);
            return $datos;
        }
    }

   /**
    * Este método es usado para reemplazar el acta cargada por el acta
    * que se decarga con los datos completos del equipo,ademas de los datos
    * del acta en si.
    *
    * @access public
    * @param id de acta , ruta de archivo a reemplazar.
    * @return ninguno.
    *
    * @author Cristian Lencina <clencina@cecaitra.org.ar>
    */
    function descargarExcel($idActa,$archivo)
    {
        // Libreria phpExcel.
        require_once (APPPATH.'/third_party/PHPExcel.php');

        //scdev
        //$archivo_ruta = documentacion.'plantillas/Plantilla_equipo_descarga.xlsx';
        $archivo_ruta = "/var/www/documentacion/plantillas/Plantilla_equipo_descarga.xlsx";

        //localhost
        //$archivo_ruta = '/var/www/html/sistemac/documentacion/reparaciones/Plantilla_equipo_descarga.xlsx';

        //Ruta del archivo a reemplazar
        $ruta_archivoreplace  = $archivo;

        //Lectura del Excel Cargado mediante phpExcel
        $inputFileType = PHPExcel_IOFactory::identify($archivo_ruta);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivo_ruta);
        $sheet = $objPHPExcel->getActiveSheet();//Se lee la hoja activa del Excel, es decir la primera que aparece cuando ejecutas el archivo.
        $id_acta = $idActa;
        $info_acta = $this->precintos_model->get_info($id_acta);

        //Consultas en DB
        $id_equipo = $info_acta[0]->id_equipo;
        $equipo = $this->precintos_model->get_equipo($id_equipo);
        $marca = $this->precintos_model->get_marca($equipo->marca);
        $modelo = $this->precintos_model->get_modelo($equipo->idmodelo);
        $municipio = $this->precintos_model->get_municipio($info_acta[0]->id_equipo);
        $ubicacion_sentido = $equipo->ubicacion_sentido;

        switch ($ubicacion_sentido)
        {
            case '5':
                $ubicacion_sentido = "ASC.";
                break;
            case '6':
                $ubicacion_sentido = "DESC.";
                break;
            default:
                $ubicacion_sentido = "A designar" ;
                break;
        }

        $tipo = $equipo->tipo_equipo;
        switch ($tipo)
        {
            case '0':
                $tipo = "FIJO";
                break;
            case '1':
                $tipo = "MÓVIL";
                break;
            default:
                $tipo = "A designar";
                break;
        }
        //Estilo para excel
        $styleArray = array( 'font' => array( 'bold' => FALSE, 'color' => array('rgb' => '000000'), 'size' => 8, 'name' => 'Verdana' ));

        // Establecer propiedades
        $objPHPExcel->getProperties()
        ->setTitle("ACTA DE CAMBIO DE PRECINTADO")
        ->setSubject("Documento Excel")
        ->setDescription("Acta Reparacion")
        ->setKeywords("Excel Office 2007 php")
        ->setCategory("Excel");

        $objPHPExcel->getActiveSheet()
        ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())
        ->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B18:I41')->applyFromArray($styleArray);

        //Establece los valores de escritura para las celdas definidas por el metodo SetCellValue de la libreria phpExcel.
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C6', $info_acta[0]->codigo_interno)//Numero interno.
        ->setCellValue('C7', $info_acta[0]->fecha_acta)//Fecha.
        ->setCellValue('C8', $tipo)//Instrumento.
        ->setCellValue('C9',  $marca)//Marca.
        ->setCellValue('C10', $modelo)//Modelo.
        ->setCellValue('C11', $equipo->serie)//Serie.
        ->setCellValue('C12', 'CECAITRA') //Propietario.
        ->setCellValue('C14', $equipo->ubicacion_calle)//Calle.
        ->setCellValue('C15', $equipo->ubicacion_localidad)//Localidad.
        ->setCellValue('F9', '') //Codigo de aprobación.
        ->setCellValue('F11', '')//Numero de informe.
        ->setCellValue('F14', $equipo->ubicacion_altura)//Altura.
        ->setCellValue('F15', $municipio)//Provincia.
        ->setCellValue('I14', $ubicacion_sentido);//Sentido.
        $modif = explode("-",$info_acta[0]->modificacion_instrumento );

        //Se insertan los valores para el campo modificación del instrumento.
        $ind = 44;
        for ($i = 0; $i < (count($modif)-1); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$ind, $modif[$i]);//.
            $ind++;
        }

        $max = count($info_acta);
        //Array de las columnas de Excel a recorrer.
        $col_excel = array( 0 => "B",  1 => "D" ,  2 => "F",  3 => "H");
        //$campos_precintos =  array( 0 => "id_puntos_precintado",  1 => "id_precinto_anterior" ,  2 => "id_estados",  3 => "id_precinto_nuevo");
        //settype( $campos_precintos, "array");

       //Ciclo for para insertar los datos obtenidos en DB
        $ind = 18;
        for ($i = 0; $i < $max; $i++) {
            for ($x = 0; $x < 4; $x++) {
                //obtengo por ID los estados y los puntos de precintado.
                $estado = $this->precintos_model->get_estados($info_acta[$i]->id_estados);
                $punto = $this->precintos_model->get_punto($info_acta[$i]->id_puntos_precintado);
                $datos = array( $punto, $info_acta[$i]->id_precinto_anterior, $estado, $info_acta[$i]->id_precinto_nuevo );

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($col_excel[$x].$ind, $datos[$x]);//Numero interno.
            }
            $ind++;
        }

       //Header para descarga del navegador.
       /*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="Plantilla_Equipo_descarga_prueba.xlsx"');
         header('Cache-Control: max-age=0');*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save('php://output'); // PAra descarga en navegador
        $objWriter->save(str_replace(__FILE__, $ruta_archivoreplace ,__FILE__));//Guardo el archivo reemplazando el acta subida por la nueva con los datos del equipo.

    }

  /**
    * Este método es usado despues de la validación del archivo para corroborar
    * que los datos ingresados en el acto existan en DB
    *
    * @access public
    * @param Ruta del archivo excel a leer, id la orden, referencia del sector, fecha , extension , searchText.
    * @return (id) de archivo.
    *
    *
    *  @author Cristian Lencina <clencina@cecaitra.org.ar>
    **/
    function reparacionesPrecintado($destino, $id_orden, $ref, $fecha, $ext, $searchText)
    {
        $puntos_precintado = array();

        $archivo = $destino;
        //Funcion para validar los campos del Acta cargada.
        $validacion = $this->validar_excel_reparaciones($archivo);

        //Si los datos estan correctos se obtiene la serie del equipo.
        if ($validacion[0] == 1) {

            $max_index = count($validacion[2]);//cantidad de Puntos de precintado.
            $serie =  trim($validacion[1][3]);//serie del equipo
            $nro_interno = $serie."_".str_replace("-","", $validacion[1][0]);//armo nombre de control interno (Ej:DV2_0226)

            //buscamos el equipo por serie.
            $data_equipo = $this->precintos_model->getEquipoBySerie($serie);

            if  (!$data_equipo) {
                //IF es FALSE
                $this->session->set_flashdata('error', "La serie "."<strong>".$serie."</strong>"." no existe en nuestra base de datos");
                redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
            }

          //Guardamos los puntos de precintados obtenidos del acta.
            $ind = 0;
            foreach($validacion[2] as $punto)
            {
                $puntos_precintado[$ind] = $punto[0];
                $ind++;
            }

            $id_puntos_precintos = $this->precintos_model->get_PuntosPrecintos($puntos_precintado, $data_equipo[0]->idmodelo);

          /* $indice_max = count($id_puntos_precintos);
             for ($i = 0; $i < $indice_max; $i++) {
             if ($id_puntos_precintos[$i] == NULL){
             $no_existe_punto_en_db[] = $puntos_precintado[$i];
                }
             }
           // $idpuntos_filtrados = array_filter($id_puntos_precintos);*/

            //Consulta para corroborar los puntos de precintados correspondan al modelo de equipo.
            $result_config = $this->precintos_model->configuracion_precintos( $data_equipo[0]->idmodelo, $id_puntos_precintos );

            if ( !$result_config ) {
                //If false.. Puntos de precintos no corresponden al modelo. segun DB.
                $this->session->set_flashdata('error', "Los precintos cargados no corresponde al Equipo");
                unlink($archivo);//se borra el acta subida al servidor..
                redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
            }
            //Consulta por el estado de los numeros de precintos.
            $result_num_precinto = $this->precintos_model->precinto($validacion[2]);

            $array = is_array($result_num_precinto);

            if ($result_num_precinto[0] == 0) {
                //IF False.. se informa del error.
                $this->session->set_flashdata('error', $result_num_precinto[1]);
                unlink($archivo);//se borra el acta subida al servidor..
                redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
            } else {

                //Consulta por los numeros de precintos que no esten utilizados en otras actas
                $result_precinto_acta = $this->precintos_model->precintoExist_acta($validacion[2]);
                //$array = is_array($result_precinto_acta);

                if ($result_precinto_acta ) {
                    //IF False, se informa error y el destino de los precintos si fueroa usados
                    $this->session->set_flashdata('error', $result_precinto_acta);
                    unlink($archivo);//se borra el acta subida al servidor..
                    redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
                } else {

                    $precinto_estado_Nuevo = $this->precintos_model->precinto_estado_Nuevo($validacion[2]);
                    //$array = is_array($result_num_precinto);
                    if (is_string($precinto_estado_Nuevo)) {
                        $this->session->set_flashdata('error', $precinto_estado_Nuevo);
                        unlink($archivo);//se borra el acta subida al servidor..
                        redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
                    } else {
                        $id = $this->precintos_model->insert_actaReparaciones($data_equipo[0]->id,$id_puntos_precintos,$validacion);
                        $this->session->set_flashdata('success', "Acta "."<b>".$nro_interno."</b>"." cargada correctamente");
                        $this->descargarExcel($id, $archivo);
                        return $id;
                        //redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
                    }
                }
            }

        } else {

            $this->session->set_flashdata('error', $validacion[1]);
            redirect('adjuntar_archivo/'.$id_orden."?ref=".$ref."&searchText=".$searchText);
        }
    }
   /*Fin de Precintos */

   function cancelar_orden()
   {
     if (!$this->input->post('id_orden') || !$this->input->post('ref')) {
       $this->session->set_flashdata('error',"Error al cancelar la orden.");
       redirect($this->input->post('ref')."?searchText=".$this->input->post('searchText'));
     }

     $observ = $this->input->post('obseracion_cancelar');
     $orden = $this->ordenes_model->getOrden($this->input->post('id_orden'));

     $data_estado = array(
       'orden'	=> $this->input->post('id_orden'),
       'usuario' => $this->session->userdata('userId'),
       'fecha' => date('Y-m-d H:i:s'),
       'observ' => $observ,
       'tipo' => 8,
       'asignado_categoria' => $orden->rm_ultimo_categoria
     );

     $this->ordenes_model->insertarEstado($data_estado);
     $update = array ('ultimo_estado' => 8);
     $result = $this->ordenes_model->updateOrden($this->input->post('id_orden'),$update);

     if ($result) {
       $this->session->set_flashdata('success',"Se cancelo la orden del equipo $orden->rm_serie.");
     } else {
       $this->session->set_flashdata('error',"Error al cancelar la orden del $orden->rm_serie.");
     }

     redirect($this->input->post('ref')."?searchText=".$this->input->post('searchText'));
   }

   // Instalaciones

      // Solicito o Entrego el equipo a Deposito.
      function solicitud_deposito()
      {
        //die(var_dump($this->input->post('id_orden')));

        if (!$this->input->post('id_orden') || !$this->input->post('ref')) {
          $this->session->set_flashdata('error',"Error al enviar al socio.");
          redirect($this->input->get('ref')."?searchText=".$this->input->post('searchText'));
        }

        $idorden = $this->input->post('id_orden');
        $orden = $this->ordenes_model->getOrden($idorden);

        $id_falla = $this->input->post('id_falla');
        $observacion = $this->input->post('observacion_deposito');
        $tipo = 17;

        if ($id_falla == 90) {

          $remitoDeposito = $this->deposito_model->getIDremito($idorden,30);
          $estado = 10;

          if($remitoDeposito){
            $depositoInfo = array('estado' => $estado);
            $id_remito = $remitoDeposito->id;
            $result = $this->deposito_model->actualizarRemito($depositoInfo,$id_remito);

          }else{
            $remitoInfo = array(
                'id_equipo'=>$orden->em_id,
                'id_proyecto'=>$orden->rm_idproyecto,
                'id_orden'=>$idorden,
                'categoria'=>$orden->rm_ultimo_categoria,
                'estado'=>$estado,
                'creado_por'=>$this->vendorId,
                'ts_creado'=>date('Y-m-d H:i:s')
            );

            $id_remito = $this->deposito_model->agregarRemito($remitoInfo);

            //Agrego un nuevo evento al remito.

          }

          $eventoInfo  = array('id_deposito'=>$id_remito, 'observacion'=>$observacion, 'estado'=>$estado,'fecha'=>date('Y-m-d H:i:s'),  'usuario'=>$this->vendorId);
          $result = $this->deposito_model->agregarEvento($eventoInfo);

          if ($result) {
            $data_estado = array(
                'orden'	=> $idorden,
                'usuario' => $this->session->userdata('userId'),
                'fecha' => date('Y-m-d H:i:s'),
                'observ' => $this->input->post('observacion_enviar'),
                'tipo' => $tipo,
                'asignado_categoria' => $orden->rm_ultimo_categoria
            );


            $this->ordenes_model->insertarEstado($data_estado);
            $update = array ('ultimo_estado' => $tipo);
            $result2 = $this->ordenes_model->updateOrden($idorden,$update);
          }

          $this->session->set_flashdata('success',"Equipo entregado a Deposito. La Orden finalizara una vez que confirmen su ingreso.");

          redirect($this->input->post('ref')."?searchText=".$this->input->post('searchText'));


        } //FIN del IF

        /*

        else {
          // code...
        }

        */


      }
}
