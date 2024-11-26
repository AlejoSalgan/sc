<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class landing extends BaseController
{

    public function __construct() // This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('dashboard_model');
        $this->load->model('user_model');
        $this->load->model('municipios_model');
        $this->load->model('ordenes_model');
        $this->load->model('protocolos_model');
        $this->load->model('ordenesb_model');
        $this->load->model('socios_model');
        $this->load->model('equipos_model');
        $this->load->model('calib_model');
        $this->load->model('utilidades_model');
    }

    public function index() // Index Page for this controller.
    {
        $this->global['pageTitle'] = 'CECAITRA: Sistema';

        $role        = $this->role;
        $userId      = $this->session->userdata('userId');
        $grupoGestor = $this->user_model->getGrupoUser($userId);


        // $data['equiposRecords'] = $this->equipos_model->equiposListing($searchText, $returns["page"], $returns["segment"], $searchNum, $columna,$criterio,$evento, $userId, $rol,$calib,$grupoGestor,$fecha);


        $array['usuarios'] = $this->user_model->getUserTest();
        // pre($array);
        // pre($this->user_model->getPuestos());




        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('landing', $array);
        $this->load->view('includes/footer',$this->global);
    }
}

?>
