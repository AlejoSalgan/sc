<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Agenda extends BaseController
{
	function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
		$this->menuPermisos();
        $this->load->model('agenda_model');
        $this->load->model('user_model');
    }

    function calendario()
    {
    	$viewdata['userId'] = $this->session->userdata('userId');
        $this->global['pageTitle'] = 'CECAITRA: Calendario';
        $viewdata['tiposeventos'] = $this->agenda_model->getEventosTipos();

		$this->load->view('includes/header', $this->global);
		$this->load->view('includes/menu', $this->menu);
		$this->load->view('agenda',$viewdata);
		$this->load->view('includes/footer');
    }

    function add()
    {
    		$viewdata['userId'] = $this->session->userdata('userId');
				if ($this->input->post('tipo')) {
					$fecha_inicio = $this->input->post('fecha_inicio');
					if (($this->input->post('fecha_fin')) && ($this->input->post('hora_fin'))) {
						$fecha_inicio .= ' '.$this->input->post('hora_inicio');
						$fecha_fin = $this->input->post('fecha_fin').' '.$this->input->post('hora_fin');
						$diacompleto = FALSE;
					} else {
				if ($this->input->post('tipo') === '2') {
					$fecha_fin = $this->input->post('fecha_fin').' 23:59';
				} else {
					$fecha_fin = $this->input->post('fecha_inicio').' 23:59';
					$diacompleto = TRUE;
				}
				$fecha_inicio .= ' 00:00';
			}
			// Si el evento que se está agregando es 1 (reunión)
			if ($this->input->post('tipo') === '1') {
				// Debo comprobar si los asistentes ya están ocupados en esa fecha
				// Si es reunión, agrego a los invitados
				$data['asistentes'] = $this->input->post('asistentes');
			}
			// Inicializo array de asistentes, uno mismo siempre asiste al evento que crea
			$data['asistentes'][] = $viewdata['userId'];
			// Obtengo aquellos que estén ocupados
			$ocupados = $this->agenda_model->getUsuariosOcupados($data['asistentes'],$fecha_inicio,$fecha_fin);
			if ($ocupados) {
				$viewdata['asistentes'] = $data['asistentes'];
				$eventos = $this->agenda_model->getEventos($viewdata['asistentes'],TRUE);
				$i = 0; $output = array();
				foreach ($eventos as $evento) {
					if ($evento->diacompleto) {
						$output[$i]['allDay'] = TRUE;
						$output[$i]['start']= date('Y-m-d',strtotime($evento->fecha_inicio));
					} else {
						$output[$i]['allDay'] = FALSE;
						$output[$i]['start'] = $evento->fecha_inicio;
						$output[$i]['end'] = $evento->fecha_fin;
					}
					// Rojo
					$output[$i]['backgroundColor'] = '#f56954';
					$output[$i]['borderColor'] = '#f56954';
					$i++;
				}
				$viewdata['eventos'] = $output;
				$viewdata['ocupados'] = $ocupados;
				// Le vuelvo a pasar datos por POST así deja el formulario como antes de enviarlo, excepto asistentes
				$viewdata['post'] = $_POST;
				// Si hay invitados ocupados en esa fecha, vuelvo a agregar evento
				$this->global['pageTitle'] = 'CECAITRA: Añadir evento';

				$this->load->view('includes/header', $this->global);
				$this->load->view('includes/menu', $this->menu);
				$viewdata['tipos'] = $this->agenda_model->getEventosTipos();
				$asistentes = $this->user_model->getUsuariosJoinPuestos($viewdata['userId']);

				$viewdata['puestos'] = array();
				foreach ($asistentes as $row) {
					$viewdata['puestos'][$row->puesto][$row->id] = $row->nombre;
				}
				$this->load->view('addAgendaEvento',$viewdata);
				$this->load->view('includes/footer');
			} else {
				// Si no hay invitados ocupados en esa fecha, inserto en la BD
				$data['evento'] = array(
					'nombre' => $this->input->post('nombre'),
					'ubicacion' => $this->input->post('ubicacion'),
					'fecha_inicio' => $fecha_inicio,
					'fecha_fin' => $fecha_fin,
					'descripcion' => $this->input->post('descripcion'),
					'tipo' => $this->input->post('tipo'),
					'creadopor' => $this->input->post('creadopor')
				);
				if ($diacompleto) {
					$data['evento']['diacompleto'] = 1;
				}
				$this->agenda_model->addEvento($data);
				$this->session->set_flashdata('success', 'Evento agregado a la agenda correctamente');

				redirect('agenda-calendario');
			}
		} else {
			$this->global['pageTitle'] = 'CECAITRA: Añadir evento';

			$this->load->view('includes/header', $this->global);
			$this->load->view('includes/menu', $this->menu);
			$viewdata['tipos'] = $this->agenda_model->getEventosTipos();
			$asistentes = $this->user_model->getUsuariosJoinPuestos($viewdata['userId']);

			$viewdata['puestos'] = array();
			foreach ($asistentes as $row) {
				$viewdata['puestos'][$row->puesto][$row->id] = $row->nombre;
			}

			$this->load->view('addAgendaEvento',$viewdata);
			$this->load->view('includes/footer');
		}
    }

    function invitaciones()
    {
	    	if ($this->input->post('evento')) {
	    		$data = array('confirmo' => $this->input->post('confirmo'), 'razon' => $this->input->post('razon'));
	    		$where = array('evento' => $this->input->post('evento'), 'invitado' => $this->session->userdata('userId'));
	    		$this->agenda_model->editInvitacion($data,$where);
	     		redirect('agenda-invitaciones');
	    	} else {
	    		$viewdata['invitaciones']= $this->agenda_model->getInvitaciones($this->session->userdata('userId'),$returns["page"], $returns["segment"]);
	    		$this->global['pageTitle'] = 'CECAITRA: Listado de invitaciones';

	    		$this->load->view('includes/header', $this->global);
					$this->load->view('includes/menu', $this->menu);
	    		$this->load->view('invitaciones',$viewdata);
	    		$this->load->view('includes/footer');
	    	}
    }

    function eventos()
    {
    	$output = array();
    	if ($this->input->post('userId')) {
    		$userId = array($this->input->post('userId'));
    		$eventos = $this->agenda_model->getEventos($userId);
    		$i = 0;
    		foreach ($eventos as $evento) {
    			$output[$i]['title'] = "{$evento->nombre}";
    			if ($evento->diacompleto) {
    				$output[$i]['allDay'] = TRUE;
    				$output[$i]['start']= date('Y-m-d',strtotime($evento->fecha_inicio));
    			} else {
    				$output[$i]['allDay'] = FALSE;
    				$output[$i]['start'] = $evento->fecha_inicio;
    				$output[$i]['end'] = $evento->fecha_fin;
    			}
    			$eventostipos = $this->agenda_model->getEventosTipos();
    			switch ($evento->tipo) {
    				case 2:
    					$output[$i]['backgroundColor'] = '#'.$eventostipos[1]->color;
    					$output[$i]['borderColor'] = '#'.$eventostipos[1]->color;
    					break;
    				case 3:
    					$output[$i]['backgroundColor'] = '#'.$eventostipos[2]->color;
    					$output[$i]['borderColor'] = '#'.$eventostipos[2]->color;
    					break;
    				case 4:
    					$output[$i]['backgroundColor'] = '#'.$eventostipos[3]->color;
    					$output[$i]['borderColor'] = '#'.$eventostipos[3]->color;
    					break;
    				case 5:
    					$output[$i]['backgroundColor'] = '#'.$eventostipos[4]->color;
    					$output[$i]['borderColor'] = '#'.$eventostipos[4]->color;
    					break;
    				default:
    					if ($this->agenda_model->getInvitadosEvento($evento->id,2)) {
    						// Rojo
    						$output[$i]['backgroundColor'] = '#f56954';
    						$output[$i]['borderColor'] = '#f56954';
    					} elseif ($this->agenda_model->getInvitadosEvento($evento->id,0)) {
    						// Amarillo
    						$output[$i]['backgroundColor'] = '#f39c12';
    						$output[$i]['borderColor'] = '#f39c12';
    					} else {
    						// Verde
    						$output[$i]['backgroundColor'] = '#00a65a';
    						$output[$i]['borderColor'] = '#00a65a';
    					}
    			}
    			$i++;
	   		}
    	}
		echo json_encode($output);
    }
}
