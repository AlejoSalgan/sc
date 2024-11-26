
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class EquipoApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('equipos_model');
    }
        
    public function get_all()
    {
        $result = $this->equipos_model->getAll();
        echo json_encode($result);
    }

    public function get()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->equipos_model->get($queryParams);
        echo json_encode($result_query);
    }

    function get_data_tabla_relacionada ()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->equipos_model->get_data_tabla_relacionada($queryParams);
        echo json_encode($result_query);
    }

    public function get_data_equipo_by_id($id)
    {
        $response = $this->equipos_model->get_data_equipo_by_id($id);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}