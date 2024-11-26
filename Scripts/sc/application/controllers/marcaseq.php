<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Marcaseq extends BaseController
{
    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('marcaseq_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index() // This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('marcaseq');
        $this->load->view('includes/footer');
    }

    function marcaseqListing() //Listado de las marcas de los equipos.
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->marcaseq_model->marcaseqListingCount($searchText);
	      $returns = $this->paginationCompress( "marcaseqListing/", $count, 30 );

        $data['marcaseqRecords'] = $this->marcaseq_model->marcaseqListing($searchText, $returns["page"], $returns["segment"]);
        $data['roleUser'] = $this->role;

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Marcas Equipos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('marcaseq', $data);
        $this->load->view('includes/footer');
    }


    function agregar_marcaEQ() //Carga la vista para agregar una marca de un equipo.
    {
        $data['tipoItem']    = "Agregar";

        $this->global['pageTitle'] = 'CECAITRA : Agregar marca equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos_marcasAddEdit',$data);
        $this->load->view('includes/footer');
    }

    //Carga la vista para editar una marca de un equipo.
    function editar_marcaEQ($marcaeqId = NULL)
    {
        if($marcaeqId == null){
            redirect('marcaseqListing');
        }

        $data['marcaeqInfo'] = $this->marcaseq_model->getMarcaeqInfo($marcaeqId);
        $data['tipoItem']    = "Editar";

        $this->global['pageTitle'] = 'CECAITRA : Editar Marca de equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos_marcasAddEdit', $data);
        $this->load->view('includes/footer');
    }


    function agregar_editar_marcaEQ() // Funcion para guardar la marca de un equipo.
    {
        $tipoItem = $this->input->post('tipoItem');
        $marcaeqId = $this->input->post('marcaeqId');

        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            if ($tipoItem == "Agregar") {
                $this->agregar_marcaEQ();
            } else {
                $this->editar_marcaEQ($marcaeqId);
            }
        } else {
            $descrip       = trim( $this->input->post('descrip') );
            $activo        = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');

            if ($tipoItem == "Agregar") {
                $marcaeqNew = array('descrip'=>$descrip, 'activo'=>$activo, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

                $result = $this->marcaseq_model->addNewMarcaeq($marcaeqNew);

                if($result > 0) {
                    $this->session->set_flashdata('success', 'Nueva marca de equipo creada correctamente');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear marca de equipo');
                }

                redirect('agregar_marcaEQ');

            } else {
                $marcaeqInfo = array('descrip'=>$descrip,'activo'=>$activo,'observaciones'=>$observaciones);

                $result = $this->marcaseq_model->editMarcaeq($marcaeqInfo, $marcaeqId);

                if($result == true) {
                    $this->session->set_flashdata('success', 'Marca equipo actualizada correctamente');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar marca de equipo');
                }

                redirect('marcaseqListing');
            }
        }
    }


    function deleteMarcaeq() // Da de baja una marca de un equipo.
    {
        $marcaeqId   = $this->input->post('marcaeqId');
        $marcaeqInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->marcaseq_model->deleteMarcaeq($marcaeqId, $marcaeqInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }

}

?>
