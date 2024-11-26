

<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class EmpresaApi extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('empresas');
    }

    public function get() {
        $queryParams = $this->input->get();
        $result_query = $this->empresas->get($queryParams);
        echo json_encode($result_query);
    }
        
    public function get_all()
    {
        $result = $this->empresas->getAll();
        echo json_encode($result);
    }
}