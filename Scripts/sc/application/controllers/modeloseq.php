<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Modeloseq extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('modeloseq_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('mail_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('modeloseq');
        $this->load->view('includes/footer');
    }

    function modeloseqListing()
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;
        $userId = $this->session->userdata('userId');

        $count = $this->modeloseq_model->modeloseqListingCount($searchText,$criterio);
	      $returns = $this->paginationCompress( "modeloseqListing/", $count, 30 );
        $data['modeloseqRecords'] = $this->modeloseq_model->modeloseqListing($searchText, $returns["page"], $returns["segment"],$criterio);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        $data['userId'] = $userId;

        $this->global['pageTitle'] = 'CECAITRA: Modelos Equipos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('modeloseq', $data);
        $this->load->view('includes/footer');
    }

    function addNewModeloeq()
    {
        $data['asociados'] = $this->equipos_model->getAsociados();

        $this->global['pageTitle'] = 'CECAITRA : Agregar Modelo equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewModeloeq', $data);
        $this->load->view('includes/footer');
    }

    function addNewModeloequipo()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewModeloeq();
        } else {
            $descrip        = trim( $this->input->post('descrip') );
            $descrip_alt    = trim( $this->input->post('descrip_alt') );
            $sigla          = trim( $this->input->post('sigla') );
            $activo         = $this->input->post('activo');
            $observaciones  = $this->input->post('observaciones');
            $asociado       = $this->input->post('asociado');
            $sistemas_aprob = 0;

            $modeloeqNew = array('descrip'=>$descrip, 'descrip_alt'=>$descrip_alt, 'sigla'=>$sigla,'activo'=>$activo,
                'observaciones'=>$observaciones , 'asociado'=> $asociado, 'sistemas_aprob'=>$sistemas_aprob, 'creadopor'=>$this->vendorId,
                'fecha_alta'=>date('Y-m-d H:i:sa'));

            $this->modeloseq_model->getModeloeqInfo($modeloeqId);

            if (!$this->modeloseq_model->validarModelo($sigla)){
                $result = $this->modeloseq_model->addNewModeloeq($modeloeqNew);

                if($result > 0){
                    $this->mail_model->enviarMail(9, $sigla, $reparacionNro = NULL, $detalle = NULL, $fecha = NULL, $reasignadoA = NULL,
                        $proyecto = NULL, $emailTo = NULL, $nameTo = NULL);
                    $this->session->set_flashdata('success', 'Nuevo Modelo de equipo ingresado correctamente');
                    $this->session->set_flashdata('error', 'SOLICITE A SISTEMAS LA ACTIVACIÓN DEL NUEVO MODELO');
                } else {
                    $this->session->set_flashdata('error', 'Error al ingresar Modelo de equipo');
                }
            } else {
                $this->session->set_flashdata('error', 'El modelo de equipo ya existe');
            }
            redirect('addNewModeloeq');
        }
    }


    function editOldModeloeq($modeloeqId = NULL)
    {
        if($modeloeqId == null) {
            redirect('modeloseqListing');
        }

        $data['modeloeqInfo'] = $this->modeloseq_model->getModeloeqInfo($modeloeqId);
        $data['asociados'] = $this->equipos_model->getAsociados();

        $this->global['pageTitle'] = 'CECAITRA : Editar Modelo de equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldModeloeq', $data);
        $this->load->view('includes/footer');
    }

    function editModeloeq()
    {
        $modeloeqId = $this->input->post('modeloeqId');

        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE) {
            $this->editOldModeloeq($modeloeqId);
        } else {
            $descrip       = $this->input->post('descrip');
            $activo        = $this->input->post('activo');
            $descrip_alt   = $this->input->post('descrip_alt');
            $sigla         = $this->input->post('sigla');
            $observaciones = $this->input->post('observaciones');
            $asociado      = $this->input->post('asociado');

            $modeloeqInfo = array('descrip'=>$descrip,'activo'=>$activo, 'observaciones'=>$observaciones,'descrip_alt'=>$descrip_alt,'sigla'=>$sigla, 'asociado'=> $asociado);

            $result = $this->modeloseq_model->editModeloeq($modeloeqInfo, $modeloeqId);

            if($result == true) {
                $this->session->set_flashdata('success', 'Modelo equipo actualizada correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar Modelo de equipo');
            }

            redirect('modeloseqListing');
        }
    }

    function deleteModeloeq()
    {
        $modeloeqId = $this->input->post('modeloeqId');

        $modeloeqInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->modeloseq_model->deleteModeloeq($modeloeqId, $modeloeqInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }

    function aprobar_equipo() //Aprobar un equipo.
    {
        $equipoid   = $this->input->post('equipoid');
        $activo     = $this->input->post('sistemas_aprob');

        if ($activo == 0) {
            $activo  = 1;
            $success = "Modelo aprobado correctamente.";
            $error   = "Error al aprobar el modelo.";
        }

        $equipoInfo = array('sistemas_aprob'=>$activo);

        $result     = $this->modeloseq_model->aprobarEquipo($equipoInfo, $equipoid);

        if($result == true){
            $this->session->set_flashdata('success', $success);
        }else{
            $this->session->set_flashdata('error', $error);
        }
        redirect('modeloseqListing');
    }

}

?>
