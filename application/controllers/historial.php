<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Historial extends BaseController
{
    public function __construct() // This is default constructor of the class
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('historial_model');
        $this->load->model('equipos_model');
        $this->load->model('componentes_model');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('pagination');
    }

    public function index() // This function used to load the first screen of the user
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('historial');
        $this->load->view('includes/footer',$this->global);
    }


    function historialEqListing($equipoId = NULL)
    {
        if($equipoId == null){
            redirect('equiposListing');
        }

        $count = $this->historial_model->historialEqListingCount($equipoId);
        $returns = $this->paginationCompress( "historialEqListing/", $count, 30 );
        
        //La consulta tardó 0.0003 seg C/U
        $data['historialEquipos']       = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "EQUIPOS");
        $data['historialEventos']       = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "EVENTOS");
        $data['historialBajada']        = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "BAJADA");
        $data['historialReparaciones']  = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "REPARACIÓN");
        $data['historialMantenimiento'] = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "MANTENIMIENTO");
        $data['historialProtocolos']    = $this->historial_model->historialEqListing($equipoId, $returns["page"], $returns["segment"], "PROTOCOLOS");
        
        // La consulta tardó 0.0007 seg   
        $data['serie'] = $this->equipos_model->getSerie($equipoId);
        
        // La consulta tardó 22.2231 seg  
        $data['historialNovedades']    = $this->historial_model->historialNovedades($data['serie']);

        // La consulta tardó 3.3804 seg  
        $data['historialDesestimados'] = $this->historial_model->historialDesestimados($data['serie']);
    
        // La consulta tardó 0.0622 seg  
        $data['ultimoEvento'] = $this->historial_model->getUltimoHistEq($equipoId);
        
        //  La consulta tardó 0.2023 seg c/u
        $data['countEquipos']       = $this->historial_model->historialCount($equipoId, "EQUIPOS");
        $data['countEventos']       = $this->historial_model->historialCount($equipoId, "EVENTOS");
        $data['countBajada']        = $this->historial_model->historialCount($equipoId, "BAJADA");
        $data['countReparaciones']  = $this->historial_model->historialCount($equipoId, "REPARACIÓN");
        $data['countMantenimiento'] = $this->historial_model->historialCount($equipoId, "MANTENIMIENTO");
        $data['countProtocolos'] = $this->historial_model->historialCount($equipoId, "PROTOCOLOS");
        
        // La consulta tardó 0.0001 seg
        // $data['countNovedades']     = $this->historial_model->countNovedades($data['serie']);
        $data['countNovedades'] = count($data['historialNovedades']);
        
        // La consulta tardó 2.8100 seg
        // $data['countDesestimados']  = $this->historial_model->countDesestimados($data['serie']);
        $data['countDesestimados'] = count($data['historialDesestimados']);
        
        ////////// HISTORIAL DEFINITIVO ///////
        // La consulta tardó 0.0047 seg
        $data['depositos'] = $this->historial_model->historialDeposito($equipoId);

        // La consulta tardó 0.0002 seg
        $data['calibraciones'] = $this->historial_model->historialCalibraciones($equipoId);
        
        //die('<pre>'.print_r($data['calibraciones'],TRUE).'</pre>');
        
        $this->global['pageTitle'] = 'CECAITRA: Equipos historial';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos/historial', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function historialCompListing($componenteId = NULL) // Listado de los componentes.
    {
        if($componenteId == null){
            redirect('componentesListing');
        }

        $count = $this->historial_model->historialCompListingCount($componenteId);
        $returns = $this->paginationCompress( "historialCompListing/", $count, 30 );

        $data['historialRecords'] = $this->historial_model->historialCompListing($componenteId, $returns["page"], $returns["segment"]);

        $data['itemInfo'] = $this->componentes_model->getComponenteInfo($componenteId);
        $data['tipoItem'] = "Componente";

        $this->global['pageTitle'] = 'CECAITRA: Componentes historial';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('historial', $data);
        $this->load->view('includes/footer',$this->global);
    }

}

?>
