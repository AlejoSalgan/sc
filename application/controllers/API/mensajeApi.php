<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MensajeApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mensajes_model');
    }
    
    public function get()
    {
        $queryParams = $this->input->get();
        
        $result_query = $this->mensajes_model->get($queryParams);
        echo json_encode($result_query);
    }
}