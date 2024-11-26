<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MunicipioApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('municipios_model');
    }
    
    public function proyectoListado()
    {
        $searchText = $this->input->get('search_text');
        $criterio = $this->input->get('criterio');
        $page = $this->input->get('page');
        $segment = $this->input->get('segment');
        $role = $this->input->get('role');
        $userId = $this->input->get('userId');
        
        $count = $this->municipios_model->proyectoListado($searchText,$criterio,$page,$segment,$role,$userId);
        
        echo json_encode($count);
    }
}