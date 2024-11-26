<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Propietarios extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('propietarios_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('propietarios');
        $this->load->view('includes/footer');
    }

    function propietariosListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->propietarios_model->propietariosListingCount($searchText);
	      $returns = $this->paginationCompress( "propietariosListing/", $count, 30 );

        $data['propietariosRecords'] = $this->propietarios_model->propietariosListing($searchText, $returns["page"], $returns["segment"]);

        $data['roleUser'] = $this->role;
        $userId = $this->session->userdata('userId');

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Propietarios listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('propietarios', $data);
        $this->load->view('includes/footer');
    }

    function addNewPropietario()
    {
        $this->global['pageTitle'] = 'CECAITRA : Agregar propietario';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewPropietario');
        $this->load->view('includes/footer');
    }

    function addNewPropietario2()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewPropietario();
        } else {
            $descrip       = trim( $this->input->post('descrip') );
            $activo        = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $propietarioNew = array('descrip'=>$descrip,'activo'=>$activo, 'observaciones'=>$observaciones,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $this->load->model('propietarios_model');
            $result = $this->propietarios_model->addNewPropietario($propietarioNew);

            if($result > 0) {
                $this->session->set_flashdata('success', 'Nuevo propietario creado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al crear propietario');
            }

            redirect('addNewPropietario');
        }
    }

    function editOldPropietario($propietarioId = NULL)
    {
        if($propietarioId == null){
            redirect('propietariosListing');
        }

        $data['propietarioInfo'] = $this->propietarios_model->getPropietarioInfo($propietarioId);

        $this->global['pageTitle'] = 'CECAITRA : Editar propietario';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldPropietario', $data);
        $this->load->view('includes/footer');
    }


    function editPropietario()
    {
        $propietarioId = $this->input->post('propietarioId');

        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldPropietario($propietarioId);
        } else {
            $descrip       = $this->input->post('descrip');
            $activo        = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            $propietarioInfo = array('descrip'=>$descrip,'activo'=>$activo, 'observaciones'=>$observaciones);

            $result = $this->propietarios_model->editPropietario($propietarioInfo, $propietarioId);

            if($result == true){
                $this->session->set_flashdata('success', 'Propietario actualizado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar propietario');
            }

            redirect('propietariosListing');
        }
    }

    function deletePropietario()
    {
        $propietarioId   = $this->input->post('propietarioId');
        $propietarioInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));
        $result          = $this->propietarios_model->deletePropietario($propietarioId, $propietarioInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }
}

?>
