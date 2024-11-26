<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Componentes extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('componentes_model');
        $this->load->model('eventos_model');
        $this->load->model('equiposconfig_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('componentes');
        $this->load->view('includes/footer');
    }

    function componentesListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->componentes_model->componentesListingCount($searchText);
	      $returns = $this->paginationCompress( "componentesListing/", $count, 30 );

        $data['componentesRecords'] = $this->componentes_model->componentesListing($searchText, $returns["page"], $returns["segment"]);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = $data['pageTitle'] = 'CECAITRA: Componentes listado';
        $data['link'] = 'componentesListing';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('componentes', $data);
        $this->load->view('includes/footer');

    }

    function compNoAsigListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->componentes_model->compNoAsigListingCount($searchText);
        $returns = $this->paginationCompress( "compNoAsigListing/", $count, 30 );

        $data['componentesRecords'] = $this->componentes_model->compNoAsigListing($searchText, $returns["page"], $returns["segment"]);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = $data['pageTitle'] = 'Componentes NO Asignados listado';
        $data['link'] = 'compNoAsigListing';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('componentes', $data);
        $this->load->view('includes/footer');
    }

    function addNewComp()
    {
        $data['tipos'] = $this->componentes_model->getComponenteTipos();
        $data['marcas'] = $this->componentes_model->getComponenteMarcas();
        $data['eventos'] = $this->eventos_model->getEventos('C');

        $this->global['pageTitle'] = 'CECAITRA : Agregar Componente ';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewComp', $data);
        $this->load->view('includes/footer');
    }

    function addNewComponente()
    {
        $this->form_validation->set_rules('serie','Serie','trim|required|max_length[30]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewComp();
        } else {
            $serie         = ucwords( strtolower( $this->input->post('serie') ) );
            $idequipo      = $this->input->post('idequipo');
            $descrip       = trim( $this->input->post('descrip') );
            $idmarca       = $this->input->post('marca');
            $idtipo        = $this->input->post('tipo');
            $evento_actual = $this->input->post('evento');
            $modelo        = $this->input->post('modelo');
            $activo        = $this->input->post('activo');

            $componenteNew =  array('serie'=>$serie, 'idequipo'=>$idequipo, 'descrip'=>$descrip, 'idmarca'=> $idmarca,'idtipo'=>$idtipo,'evento_actual'=>$evento_actual,'modelo'=>$modelo, 'activo'=>$activo, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $this->load->model('componentes_model');
            $result = $this->componentes_model->addNewComponente($componenteNew);

            //Historial
            if($result > 0){
                $idequipo     = $idequipo;
                $idcomponente = $result;
                $idevento     = $evento_actual;
                $idestado     = 0; //Sin identificar
                $origen       = "ALTA";
                $detalle      = "Ingreso al Sistema";
                $reubicacion  = null;

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addHistorial($historialNew);
                //Fin Historial

                $this->session->set_flashdata('success', 'Nuevo componente creado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al crear componente');
            }

            redirect('addNewComp');
        }
    }


    function editOldComponente($componenteId = NULL)
    {
        if($componenteId == null){
            redirect('componentesListing');
        }

        $data['tipos']          = $this->componentes_model->getComponenteTipos();
        $data['marcas']         = $this->componentes_model->getComponenteMarcas();
        $data['eventos']        = $this->eventos_model->getEventos('C');
        $data['componenteInfo'] = $this->componentes_model->getComponenteInfo($componenteId);

        $this->global['pageTitle'] = 'CECAITRA : Editar Componente';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldComponente', $data);
        $this->load->view('includes/footer');
    }

    function editComponente()
    {
        $componenteId = $this->input->post('componenteId');

        $this->form_validation->set_rules('tipo','Tipo','trim|required|is_natural_no_zero|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldComponente($componenteId);
        } else {
            $serie         = ucwords( strtolower( $this->input->post('serie') ) );
            $idequipo      = $this->input->post('idequipo');
            $descrip       = trim( $this->input->post('descrip') );
            $idmarca       = $this->input->post('marca');
            $idtipo        = $this->input->post('tipo');
            $evento_actual = $this->input->post('evento');
            $modelo        = $this->input->post('modelo');
            $activo        = $this->input->post('activo');

            $componenteInfo =  array('serie'=>$serie, 'idequipo'=>$idequipo, 'descrip'=>$descrip, 'idmarca'=> $idmarca,'idtipo'=>$idtipo,'evento_actual'=>$evento_actual,'modelo'=>$modelo, 'activo'=>$activo, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $result = $this->componentes_model->editComponente($componenteInfo, $componenteId);

            if($result == true){
                $this->session->set_flashdata('success', 'Componente actualizado correctamente');
                //Historial
                $idequipo = 0;
                $idcomponente = $componenteId;
                $idevento = $evento_actual;
                $idestado = 0; //Sin identificar
                $origen = "MODIFICA";
                $detalle = $descrip;
                $reubicacion = null;

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addHistorial($historialNew);
                //Fin Historial
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar Componente');
            }
            redirect('componentesListing');
        }
    }

  	//SIN Serie
  	function editOldComponente2($tipoId = NULL, $marcaId = NULL)
  	{
  			if($tipoId == null && $marcaId == null) {
  				redirect('componentesListing');
  			}

  			$data['tipos']          = $this->componentes_model->getComponenteTipos();
  			$data['marcas']         = $this->componentes_model->getComponenteMarcas();
  			$data['eventos']        = $this->eventos_model->getEventos('C');
  			$data['componenteInfo'] = $this->componentes_model->getComponenteInfo2($tipoId,$marcaId);

  			$this->global['pageTitle'] = 'CECAITRA : Editar Componente';
  			$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
  			$this->load->view('editOldComponente2', $data);
  			$this->load->view('includes/footer');

  	}

    function editComponente2()
    {
        $cantidad   = $this->input->post('cantidad');
        $idtipoOld  = $this->input->post('tipoIdOld');
        $idmarcaOld = $this->input->post('marcaIdOld');

        $this->form_validation->set_rules('cantidad','Cantidad','trim|required|max_length[4]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldComponente2($idtipoOld, $idmarcaOld);
        } else {
            $descrip       = trim( $this->input->post('descrip') );
            $idmarcaNew    = $this->input->post('marca');
            $idtipoNew     = $this->input->post('tipo');
            $evento_actual = $this->input->post('evento');
            $activo        = $this->input->post('activo');
            $modelo        = $this->input->post('modelo');

            $componenteInfo =  array('descrip'=>$descrip, 'idmarca'=> $idmarcaNew,'idtipo'=>$idtipoNew,'evento_actual'=>$evento_actual,'activo'=>$activo, 'modelo'=>$modelo, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $result = $this->componentes_model->editComponente2($componenteInfo, $cantidad, $idmarcaOld, $idtipoOld);

            if($result > 0){
                $this->session->set_flashdata('success', 'Componente sin serie actualizado ok');
                //Historial
                $idequipo     = 0;
                $idcomponente = $result;
                $idevento     = $evento_actual;
                $idestado     = 0; //Sin identificar
                $origen       = "MODIFICA";
                $detalle      = $descrip;
                $reubicacion  = null;

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addHistorial($historialNew);
                //Fin Historial
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar Componente sin serie');
            }

            redirect('compNoAsigListing');
        }
    }

    function deleteComponente()
    {
        $componenteids = $this->input->post('componenteid');

        $componenteInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:s'));

        $ids = explode("|", $componenteids);
        if( count($ids) == 1 ) {
            $componenteid = $porciones[0];
            $result = $this->componentes_model->deleteComponente($componenteid, $componenteInfo);
        } else {
            $idtipo = $porciones[0];
            $idmarca = $porciones[1];
            $result = $this->componentes_model->deleteComponenteSinSerie($idtipo, $idmarca, $componenteInfo);
        }

        //affected_rows Componente CON Serie
        if ($result == 1) {
            //Historial
            $idequipo = 0;
            $idcomponente = $componenteid;
            $idevento = 100; //Pasa a NO Activo, evento interno
            $idestado = 0; //Sin identificar
            $origen = "NOACTIVO";
            $detalle = "NO Activo";

            $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
            $this->load->model('historial_model');
            $result = $this->historial_model->addHistorial($historialNew);
            //Fin Historial
        }

        //affected_rows Componente SIN Serie
        if ($result > 1) {
            $data['componentesIds'] = $this->componentes_model->componentesSinSerieListing($idtipo, $idmarca);
            if(!empty($componentesRecords)) {
                foreach($componentesIds as $record) {

                     //Historial
                    $idequipo = 0;
                    $idcomponente = $record->id;
                    $idevento = 100; //Pasa a NO Activo, evento interno
                    $idestado = 0; //Sin identificar
                    $origen = "NOACTIVO";
                    $detalle = "NO Activo";

                    $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                    $this->load->model('historial_model');
                    $result = $this->historial_model->addHistorial($historialNew);
                    //Fin Historial
                }
            }
        }

        echo(json_encode(array('status'=>$result)));
    }


    function deleteCompRelacion()
    {
        $compid = $this->input->post('compid');
        $compInfo = array('idequipo'=>0,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:s'));

        $result = $this->componentes_model->deleteCompRelacion($compid, $compInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }


    function addNewComp2()
    {
        $data['tipos']   = $this->componentes_model->getComponenteTipos();
        $data['marcas']  = $this->componentes_model->getComponenteMarcas();
        $data['eventos'] = $this->eventos_model->getEventos('C');

        $this->global['pageTitle'] = 'CECAITRA : Agregar Componente sin número de serie';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewComp2', $data);
        $this->load->view('includes/footer');
    }


    function addNewComponente2()
    {
        $this->form_validation->set_rules('cantidad','Cantidad','trim|required|max_length[4]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewComp2();
        } else {
            $descrip       = trim( $this->input->post('descrip') );
            $idmarca       = $this->input->post('marca');
            $idtipo        = $this->input->post('tipo');
            $evento_actual = $this->input->post('evento');
            $activo        = $this->input->post('activo');
            $modelo        = $this->input->post('modelo');
            $cantidad      = $this->input->post('cantidad');

            $componenteNew =  array('descrip'=>$descrip, 'idmarca'=> $idmarca,'idtipo'=>$idtipo,'evento_actual'=>$evento_actual, 'modelo'=>$modelo, 'activo'=>$activo, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $this->load->model('componentes_model');
            $result = $this->componentes_model->addNewComponente2($componenteNew, $cantidad);

            //Historial
            if($result == true) {
                $idequipo     = 0;
                $idcomponente = $result;
                $idevento     = $evento_actual;
                $idestado     = 0; //Sin identificar
                $origen       = "ALTA";
                $detalle      = "Ingreso al Sistema";
                $reubicacion  = null;

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addHistorial($historialNew);
                //Fin Historial

                $this->session->set_flashdata('success', 'Nuevos componentes creados correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al crear los componentes');
            }
            redirect('addNewComp2');
        }

    }

    function asigComponente()
    {
    	if ($this->input->post('idmodelo')) {
    		$idequipo = $this->input->post('idequipo');
    		// Obtengo configuración de componentes para ese modelo de equipo
    		$config = $this->equiposconfig_model->getEquiposConfigByModel($this->input->post('idmodelo'));
    		$newconfig = array(); $ulttipo = 0; $cant = 0;
    		foreach ($config as $row) {
    			// Compruebo si existen componentes de ese tipo
    			$comps = $this->componentes_model->getComponentesByTipo($row->id_comp_tipo);
    			if (!$comps) {
    				$row->existe = 0;
    			} else {
    				$row->existe = 1;
    				$row->disponibles = $this->componentes_model->getComponentesByTipoEquipoCount($row->id_comp_tipo,0);
    				if ($ulttipo != $row->id_comp_tipo) {
    					// Comprobar cuantos de ese tipo hay asignados al equipo
    					$ulttipo = $row->id_comp_tipo;
    					$cant = $this->componentes_model->getComponentesByTipoEquipoCount($row->id_comp_tipo,$idequipo);
    				}
    				$row->cant = $cant;
    				if ($row->seriado) {
    					$equipo = array(0,$idequipo);
    					$comps = $this->componentes_model->getComponentesByTipo($row->id_comp_tipo, $row->seriado, $equipo);
    					// Asigno el listado de componentes al row, para luego pasarlo a la view
    					$row->comps = $comps;
    					// Obtengo los series del tipo de componente, basado en el Nº de $offset
    					$comps_asig = $this->componentes_model->getComponentesByTipo($row->id_comp_tipo,$row->seriado,$idequipo);
    					$row->comps_asig = $comps_asig;
    				}
    			}
    			// Comprobar cuantos de ese tipo pueden haber
    			for ($i=1; $i <= $row->cantidad; $i++) {
    				$newconfig[] = $row;
    			}
    		}
    			if ($config) {
    				$mensaje = '';
    			} else {
    				$mensaje= '<div class="alert alert-danger" role="alert"><strong>Error:</strong> No se ha cargado ninguna configuración para este modelo de equipo.</div>';
    			}
    	} else {
    		$mensaje= '<div class="alert alert-danger" role="alert"><strong>Error:</strong> No se ha cargado el modelo del equipo seleccionado.</div>';
    	}
    	$equipo           = $this->equipos_model->getEquipoInfo($idequipo);
    	$data['serie']    = $equipo[0]->serie;
    	$data['idequipo'] = $idequipo;
    	$data['idmodelo'] = $this->input->post('idmodelo');
    	$data['config']   = $newconfig;
    	$data['mensaje']  = $mensaje;

      $this->global['pageTitle'] = 'CECAITRA: Asignación de componentes';
    	$this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
    	$this->load->view('equiposconfig', $data);
    	$this->load->view('includes/footer');
    }

    function guardarAsigComp()
    {
    	if (!empty($_POST)) {
    		$idequipo = $this->input->post('idequipo');
    		$noseriados = array();
    		$config = $this->equiposconfig_model->getEquiposConfigByModel($this->input->post('idmodelo'));
    		foreach ($config as $row) {
    			if (!$row->seriado) {
    				// veo cuantos componentes de ese tipo habían asignados a este equipo antes
    				$noseriados[$row->id_comp_tipo]['antes'] = $this->componentes_model->getComponentesByTipoEquipoCount($row->id_comp_tipo,$idequipo);
    			}
    		}
    		$ulttipo = 0; $offset = 0; $seriado = 1;
    		foreach ($_POST as $key => $val) {
    			$expl = explode('_',$key);
    			if ($expl[0]=='c' && $val=='noserie') {
    				// veo cuantos de ese tipo hay asignados ahora
    				$noseriados[$expl[1]]['ahora']++;
    			} elseif ($expl[0]=='c') {
    				if ($expl[1]==$ulttipo) {
    					$offset++;
    				} else {
    					$offset = 0;
    					$ulttipo = $expl[1];
    				}
    				$comp = $this->componentes_model->getComponentesByTipo($ulttipo,$seriado,$idequipo,$offset);
    				if ($comp[0]->idcomponente != $val) {
    					$update = array(
    							'idequipo' => 0
    					);
    					$this->componentes_model->editComponente($update,$comp[0]->idcomponente);
    					if ($val) {
    						$update = array(
    								'idequipo' => $idequipo
    						);
    						$this->componentes_model->editComponente($update,$val);
    					}

    				}
    			}
    		}
    		$seriado = 0;
    		// ahora controlo los no seriados, si da diferencia en la cantidad con la que había antes, asigno o desasigno como corresponda
    		foreach ($noseriados as $tipocomp => $cant) {
    			if (!isset($cant['ahora'])) $cant['ahora'] = 0;
     			if ($cant['antes']<$cant['ahora']) {
    				// si la cantidad que habían antes es menor a la que hay ahora, debo asignar más componentes
     				$equipo = array('0');
     				$comp = $this->componentes_model->getComponentesByTipo($tipocomp,$seriado,$equipo);
     				$max = $cant['ahora']-$cant['antes'];
    				for ($i = 1; $i <= $max; $i++) {
    					$update = array(
    							'idequipo' => $idequipo
    					);
    					$this->componentes_model->editComponente($update,$comp[$i-1]->idcomponente);
    				}
     			} elseif ($cant['antes']>$cant['ahora']) {
    				// si la cantidad que habían antes es mayor a la que hay ahora, debo desasignar componentes
    				$equipo = array($idequipo);
    				$comp = $this->componentes_model->getComponentesByTipo($tipocomp,$seriado,$equipo);
    				$max = $cant['antes']-$cant['ahora'];
    				for ($i = 1; $i <= $max; $i++) {
    					$update = array(
    							'idequipo' => '0'
    					);
    					$this->componentes_model->editComponente($update,$comp[$i-1]->idcomponente);
    				}
    			}
    		}
    		$mensaje          = '<div class ="alert alert-success" role ="alert">Los componentes se han asignado al equipo exitosamente.</div>';
    		$data['idequipo'] = $idequipo;
    		$data['config']   = $newconfig;
    		$data['mensaje']  = $mensaje;

        $this->global['pageTitle'] = 'CECAITRA: Asignación de componentes';
    		$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    		$this->load->view('equiposconfig', $data);
    		$this->load->view('includes/footer');
    	} else {
    		redirect('equiposListing');
    	}
    }
}
?>
