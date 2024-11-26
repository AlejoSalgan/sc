<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Equipamiento extends BaseController
{
    function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        
        $this->load->model('equipos_model');
        $this->load->model('municipios_model');
        $this->load->model('equipamiento_model');
        
    }

    function solicitud()
    {
        $viewdata['userId'] = $this->session->userdata('userId');
        $this->global['pageTitle'] = 'CECAITRA: Añadir evento';
        $viewdata['equipos_tipos'] = $this->equipos_model->getEquiposTipos();
        $viewdata['municipios'] = $this->municipios_model->getMunicipios();
//         die("<pre>".print_r($viewdata['equipos'],TRUE)."</pre>");
        $this->global['pageTitle'] = 'CECAITRA: Añadir solicitud de provisión de equipamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipamiento_solicitud',$viewdata);
        $this->load->view('includes/footer');
        
    }
    
    function listado()
    {
        
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipamiento_ABM');
        $this->load->view('includes/footer');
       // die('listado');
    }
    
    function getTipos()
    {
        if ($this->input->post('es_equipo') === '0') { 
            
            echo json_encode($this->equipamiento_model->getEquipamientoTipos());
            
        } elseif ($this->input->post('es_equipo') === '1') {
            
            echo json_encode($this->equipos_model->getEquiposTipos());
            
        } else {
            
            echo json_encode(array('error'=>1));
        }
    }
     
}