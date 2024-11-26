<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ReparacionApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reparacion_model');
    }
    
    public function get()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->reparacion_model->get($queryParams);
        echo json_encode($result_query);
    }
}