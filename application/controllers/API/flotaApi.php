<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class FlotaApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('flota_model');
    }
    
    public function get_dominio_vehiculo_by_id()
    {
        $id = $this->input->get('id_vehiculo');
        $result = $this->flota_model->getDominio($id);
        echo json_encode($result);
    }
    
    public function get_all()
    {
        $result = $this->flota_model->getAll();
        echo json_encode($result);
    }
    
    public function get_all_delimited_fields()
    {
        $fields = $this->input->get('fields');
        $result = $this->flota_model->getAllDelimitedFields($fields);
        echo json_encode($result);
    }
    
    public function get()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->flota_model->get($queryParams);
        echo json_encode($result_query);
    }
    
    public function get_vehiculos_api()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->flota_model->getVehiculosApi($queryParams);
        echo json_encode($result_query);
    }
}