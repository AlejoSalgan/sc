<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Tiposcomp extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('tiposcomp_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('tiposcomp');
        $this->load->view('includes/footer',$this->global);
    }

    function tiposcompListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->tiposcomp_model->tiposcompListingCount($searchText);
	      $returns = $this->paginationCompress( "tiposcompListing/", $count, 30 );

        $data['tiposcompRecords'] = $this->tiposcomp_model->tiposcompListing($searchText, $returns["page"], $returns["segment"]);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Tipos Componentes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('tiposcomp', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function addNewTipocomp()
    {
        $this->global['pageTitle'] = 'CECAITRA : Agregar tipo Componente';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewTipoComp');
        $this->load->view('includes/footer',$this->global);
    }

    function addNewTipocomponente()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewTipocomp();
        } else {
            $descrip = trim( $this->input->post('descrip') );
            $activo = $this->input->post('activo');
            $seriado = $this->input->post('seriado');
            $observaciones = $this->input->post('observaciones');

            $tipocompNew = array('descrip'=>$descrip, 'activo'=>$activo, 'seriado'=>$seriado, 'observaciones'=>$observaciones,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $result = $this->tiposcomp_model->addNewTipocomp($tipocompNew);

            if($result > 0){
                $this->session->set_flashdata('success', 'Nuevo tipo de Componente creado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al crear tipo de Componente');
            }

            redirect('addNewTipocomp');
        }
    }

    function editOldTipocomp($tipocompId = NULL)
    {
        if($tipocompId == null){
            redirect('tiposcompListing');
        }

        $data['tipocompInfo'] = $this->tiposcomp_model->getTipocompInfo($tipocompId);

        $this->global['pageTitle'] = 'CECAITRA : Editar Tipo de Componente';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldTipocomp', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function editTipocomp()
    {
        $tipocompId = $this->input->post('tipocompId');

        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldTipocomp($tipocompId);
        } else {
            $descrip = $this->input->post('descrip');
            $activo = $this->input->post('activo');
            $seriado = $this->input->post('seriado');
            $observaciones = $this->input->post('observaciones');

            $tipocompInfo = array('descrip'=>$descrip,'activo'=>$activo,'seriado'=>$seriado,'observaciones'=>$observaciones);

            $result = $this->tiposcomp_model->editTipocomp($tipocompInfo, $tipocompId);

            if($result == true){
                $this->session->set_flashdata('success', 'Tipo Componente actualizado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar tipo de Componente');
            }

            redirect('tiposcompListing');
        }
    }

    function deleteTipocomp()
    {
        $tipocompId = $this->input->post('tipocompId');
        $tipocompInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->tiposcomp_model->deleteTipocomp($tipocompId, $tipocompInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }

}

?>
