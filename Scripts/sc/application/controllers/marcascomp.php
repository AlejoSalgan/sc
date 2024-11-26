<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Marcascomp extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('marcascomp_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('marcascomp');
        $this->load->view('includes/footer');
    }

    function marcascompListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->marcascomp_model->marcascompListingCount($searchText);
	      $returns = $this->paginationCompress( "marcascompListing/", $count, 30 );

        $data['marcascompRecords'] = $this->marcascomp_model->marcascompListing($searchText, $returns["page"], $returns["segment"]);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Marcas componentes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('marcascomp', $data);
        $this->load->view('includes/footer');
    }

    function addNewMarcacomp()
    {
        $this->global['pageTitle'] = 'CECAITRA : Agregar marca componente';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewMarcacomp');
        $this->load->view('includes/footer');
    }

    function addNewMarcacomponente()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewMarcacomp();
        } else {
            $descrip       = trim( $this->input->post('descrip') );
            $activo        = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $marcacompNew = array('descrip'=>$descrip, 'activo'=>$activo, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $result = $this->marcascomp_model->addNewMarcacomp($marcacompNew);

            if($result > 0){
                $this->session->set_flashdata('success', 'Nueva marca de componente creado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al crear marca de componente');
            }

            redirect('addNewMarcacomp');
        }
    }


    function editOldMarcacomp($marcacompId = NULL)
    {
        if($marcacompId == null){
            redirect('marcascompListing');
        }

        $data['marcacompInfo'] = $this->marcascomp_model->getMarcacompInfo($marcacompId);

        $this->global['pageTitle'] = 'CECAITRA : Editar Marca de componente';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldmarcacomp', $data);
        $this->load->view('includes/footer');
    }

    function editMarcacomp()
    {
        $marcacompId = $this->input->post('marcacompId');
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldMarcacomp($marcacompId);
        } else {
            $descrip       = $this->input->post('descrip');
            $activo        = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $marcacompInfo = array('descrip'=>$descrip,'activo'=>$activo,'observaciones'=>$observaciones);

            $result = $this->marcascomp_model->editmarcacomp($marcacompInfo, $marcacompId);

            if($result == true){
                $this->session->set_flashdata('success', 'Marca componente actualizada ok');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar marca de componente');
            }

            redirect('marcascompListing');
        }
    }

    function deleteMarcacomp()
    {
        $marcacompId = $this->input->post('marcacompId');
        $marcacompInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->marcascomp_model->deleteMarcacomp($marcacompId, $marcacompInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }

}

?>
