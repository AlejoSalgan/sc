<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Tiposeq extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('tiposeq_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('tiposeq');
        $this->load->view('includes/footer',$this->global);
    }

    function tiposeqListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->tiposeq_model->tiposeqListingCount($searchText);
	      $returns = $this->paginationCompress( "tiposeqListing/", $count, 30 );

        $data['tiposeqRecords'] = $this->tiposeq_model->tiposeqListing($searchText, $returns["page"], $returns["segment"]);
        $data['roleUser'] = $this->role;

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Tipos Equipos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('tiposeq', $data);
        $this->load->view('includes/footer',$this->global);

    }

    function addNewTipoeq()
    {
        $this->global['pageTitle'] = 'CECAITRA : Agregar tipo equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewTipoeq');
        $this->load->view('includes/footer',$this->global);
    }

    function addNewTipoequipo()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewTipoeq();
        } else {
            $descrip = trim( $this->input->post('descrip') );
            $activo = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $tipoeqNew = array('descrip'=>$descrip, 'activo'=>$activo, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $result = $this->tiposeq_model->addNewTipoeq($tipoeqNew);

            if($result > 0){
                $this->session->set_flashdata('success', 'Nuevo tipo de equipo creado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al crear tipo de equipo');
            }
            redirect('addNewTipoeq');
        }
    }

    function editOldTipoeq($tipoeqId = NULL)
    {
        if($tipoeqId == null){
            redirect('tiposeqListing');
        }

        $data['tipoeqInfo'] = $this->tiposeq_model->getTipoeqInfo($tipoeqId);

        $this->global['pageTitle'] = 'CECAITRA : Editar Tipo de equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldTipoeq', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function editTipoeq()
    {
        $tipoeqId = $this->input->post('tipoeqId');

        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldTipoeq($tipoeqId);
        } else {
            $descrip = $this->input->post('descrip');
            $activo = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $tipoeqInfo = array('descrip'=>$descrip,'activo'=>$activo,'observaciones'=>$observaciones);

            $result = $this->tiposeq_model->editTipoeq($tipoeqInfo, $tipoeqId);

            if($result == true){
                $this->session->set_flashdata('success', 'Tipo equipo actualizado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar tipo de equipo');
            }

            redirect('tiposeqListing');
        }
    }

    function deleteTipoeq()
    {
        $tipoeqId = $this->input->post('tipoeqId');
        $tipoeqInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->tiposeq_model->deleteTipoeq($tipoeqId, $tipoeqInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }
}

?>
