<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Mapa extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('mensajes_model');
        $this->load->model('lugares_model');
        $this->load->model('user_model');
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->model('flota_model');
    }

    function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Mapa';
        $lugares = $this->mensajes_model->getLastCoords();
        $this->lugares_model->guardarLugares($lugares);
        $viewdata['usuarios'] = $this->user_model->getUsuariosConIMEI();

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('mapa',$viewdata);
        $this->load->view('includes/footer');
    }

    function mapaEquipos($equipoId = NULL) //Información de los equipos
    {
        $this->global['pageTitle'] = 'CECAITRA : Mapa Equipos';
        $data['municipios']  = $this->municipios_model->getMunicipios(TRUE);

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('mapaEquipos', $data);
        $this->load->view('includes/footer');
    }

    function mapaFlota($equipoId = NULL) // Flota vehículos
    {
        $this->global['pageTitle'] = 'CECAITRA : Mapa Flota Vehículos';
        $data['vehiculos']  = $this->flota_model->getVehiculos();
        
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('mapaFlota', $data);
        $this->load->view('includes/footer');
    }

    function localizacionvehiculos()
    {
        $this->load->model("wsmoviles_model");
        echo $this->wsmoviles_model->obtenerCoordenadas();
    }

    function mapaEquiposMoviles() // Flota vehículos
    {
        $data['vehiculos'] = $this->flota_model->getVehiculos(NULL, 1);
        $data['proyectos'] = $this->municipios_model->getMunicipios();

        $this->global['pageTitle'] = 'CECAITRA : Mapa Equipos Moviles';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('mapaFlotaEquipos', $data);
        $this->load->view('includes/footer');
    }
}
?>
