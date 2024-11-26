<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Municipios extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('municipios_model');
        $this->load->model('gestores_model');
        $this->load->model('user_model');
        $this->load->model('equipos_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos');
        $this->load->view('includes/footer',$this->global);
    }

    function municipiosListing()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $count = $this->municipios_model->proyectoListado($searchText,$criterio,NULL,NULL,$this->session->userdata('userId'),$this->role);

        $returns = $this->paginationCompress( "municipiosListing/", $count, 15 );

        $data['proyectos'] =
        $this->municipios_model->proyectoListado($searchText,$criterio ,$returns["page"], $returns["segment"],$this->role, $this->session->userdata('userId'));

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->municipios_model->proyectoListado('',NULL,NULL,NULL,$this->session->userdata('userId'),$this->role);

        $this->global['pageTitle'] = 'CECAITRA: Municipios listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos/proyectos', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function ver_proyecto($municipioId = NULL)
    {
        if($municipioId == null){
            $this->session->set_flashdata('error', 'No existe este proyecto.');
            redirect('municipiosListing');
        }

        $data['municipioInfo'] = $this->municipios_model->getMunicipioInfo($municipioId);

        if (!$data['municipioInfo'] ) {
            $this->session->set_flashdata('error', 'No hay informacion de este proyecto.');
            redirect('municipiosListing');
        }

        $data['gestiones']  = $this->municipios_model->gestionAsignaciones($municipioId);

        $data['estados'] = $this->equipos_model->getEstadosPorProyectos($data['municipioInfo']->id);

        $data['tipos'] = $this->equipos_model->getTiposPorProyectos($data['municipioInfo']->id);
        $data['total'] = $this->equipos_model->getEquiposPorProyectos($data['municipioInfo']->id);

        $this->global['pageTitle'] = 'CECAITRA : Ver proyecto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos/proyectos_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function agregar_proyecto()
    {
        $data['tipoItem'] = 'Agregar';

        $this->global['pageTitle'] = 'CECAITRA : Agregar proyecto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos/proyectos_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function editar_proyecto($id_proyecto = NULL)
    {
        $data['proyecto']  = $this->municipios_model->getProyecto($id_proyecto);

        $data['tipoItem'] = 'Editar';

        $this->global['pageTitle'] = 'CECAITRA : Agregar proyecto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos/proyectos_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function proyecto_asignaciones($id_proyecto = NULL)
    {

        if($id_proyecto == null){
            $this->session->set_flashdata('error', 'No existe este proyecto.');
            redirect('municipiosListing');
        }

        $data['proyecto']  = $this->municipios_model->getProyecto($id_proyecto);

        if (!$data['proyecto']) {
            $this->session->set_flashdata('error', 'No hay informacion de este proyecto.');
            redirect('municipiosListing');
        }

        $data['gestiones']  = $this->municipios_model->gestionAsignaciones($id_proyecto);

        $roles = array(101,102,103,104,105);
        $data['gestores']  = $this->user_model->usuarios_rol($roles);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA : Agregar proyecto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('proyectos/proyectos_addEditAsignaciones', $data);
        $this->load->view('includes/footer',$this->global);
    }

///////////// ACCIONES ////////////

function agregar_editar_proyecto()
{
    $nombre = trim($this->input->post('nombre'));
    $iniciales = strtoupper(trim($this->input->post('iniciales')));
    $codigo = $this->input->post('codigo');
    $administracion = $this->input->post('administracion');
    $observaciones = $this->input->post('observaciones');
    $tipoItem = $this->input->post('tipoItem');


    $proyectoInfo = array('descrip'=>$nombre,
    'orden'=>1,
    'iniciales'=>$iniciales,
    'codigo_municipio'=>$codigo,
    'adminstracion'=>$administracion,
    'observaciones'=>$observaciones
    );

    if ($tipoItem == "Agregar") {
      $proyectoInfo['creadopor'] = $this->vendorId;
      $proyectoInfo['fecha_alta'] = date('Y-m-d H:i:s');

      $result = $this->municipios_model->agregarProyecto($proyectoInfo);

      $success = "Nuevo proyecto agregado correctamente.";
      $error = "Error al agregar proyecto.";
      $link = "agregar_proyecto";
    } else {
      $id_proyecto = $this->input->post('id_proyecto');
      $result = $this->municipios_model->editarProyecto($proyectoInfo, $id_proyecto);

      $success = "Proyecto editado correctamente.";
      $error = "Error al editar el proyecto.";
      $link = "municipiosListing";
    }

    if($result == TRUE){
      /*
      $perifericoHistorial = array('id_periferico'=>$id_periferico, 'evento'=>$evento, 'observacion'=>$observacion, 'usuario'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

      if ($tipoItem == "Editar") {
        $detalle .= $this->perifericos_model->comparacionHistorial("El periferico",$tipo_periferico,$periferico->nombre_tipo);
        $detalle .= $this->perifericos_model->comparacionHistorial("El socio",$nombre_socio,$periferico->socio_descrip);
        $detalle .= $this->perifericos_model->comparacionHistorial("El equipo",$equipo_serie,$periferico->EM_serie);

        array_push($perifericoHistorial['detalle'] = $detalle);
      }

      $result2 = $this->perifericos_model->agregarHistorial($perifericoHistorial);

      */

      $this->session->set_flashdata('success', $success);
    }else{
      $this->session->set_flashdata('error', $error);
    }
    redirect($link);
}



function estado_remoto()
{
  $remoto = $this->input->post('remoto');
  $id_proyecto = $this->input->post('id_proyecto');
  $observacion = $this->input->post('observacion');

  if ($remoto == 1) {
    $remoto = 0;
    $success = "Proyecto desactivado como remoto correctamente.";
    $error = "Error al desactivar proyecto como Remoto.";
  } else {
    $remoto = 1;
    $success = "Proyecto activado como Remoto correctamente.";
    $error = "Error al activar proyecto como Remoto.";
  }

  $proyectoInfo = array('remoto' => $remoto);

  $result = $this->municipios_model->editarProyecto($proyectoInfo, $id_proyecto);

  if ($result) {
    $this->session->set_flashdata('success', $success);
  }else{
    $this->session->set_flashdata('error', $error);
  }

  redirect('municipiosListing');

}



function estado_proyecto()
{
  $estado = $this->input->post('estado');
  $id_proyecto = $this->input->post('id_proyecto');
  $observacion = $this->input->post('observacion');

  if ($estado == 1) {
    $estado = 0;
    $success = "Proyecto desactivado correctamente.";
    $error = "Error al desactivar proyecto.";
  } else {
    $estado = 1;
    $success = "Proyecto activado correctamente.";
    $error = "Error al activar proyecto.";
  }

  $proyectoInfo = array('activo' => $estado);

  $result = $this->municipios_model->editarProyecto($proyectoInfo, $id_proyecto);

  if ($result) {
    $this->session->set_flashdata('success', $success);
  }else{
    $this->session->set_flashdata('error', $error);
  }

  redirect('municipiosListing');

}


function agregar_asignacion()
{
  $usuarios = $this->input->post('usuarios');
  $id_proyecto = $this->input->post('id_proyecto');

  foreach ($usuarios as $usuario => $value) {
    $infoAsignacion = array('id_proyecto'=>$id_proyecto, 'usuario'=>$value);
    $this->municipios_model->agregarAsignacion($infoAsignacion);
  }

  if ($id_proyecto > 0) {
    $this->session->set_flashdata('success', 'Usuario asignado correctamente.');
  } else {
    $this->session->set_flashdata('error', 'Error al asignar usuario correctamente.');
  }

  redirect('proyecto_asignaciones/'.$id_proyecto);
}



function eliminar_asignacion($id_asignacion = NULL) //Vista de un remito.
{
  if($id_asignacion == null){ //Valido que exista.
      $this->session->set_flashdata('error', 'No existe esta asignacion.');
      redirect('municipiosListing');
  }

  $asignacion = $this->municipios_model->getAsignacion($id_asignacion);

  $result = $this->municipios_model->eliminarAsignacion($id_asignacion);

  if ($result == TRUE) {
    $this->session->set_flashdata('success', 'Asignacion eliminada correctamente.');
  } else {
    $this->session->set_flashdata('error', 'Error al eliminar asignacion.');
  }

  redirect('proyecto_asignaciones/'.$asignacion->id_proyecto);
}





function estado_prioridad($id_asignacion = NULL)
{
  $asignacion = $this->municipios_model->getAsignacion($id_asignacion);


  if ($asignacion->prioridad == 1) {
    $prioridad = 0;
    $success = "Prioridad desactivada correctamente.";
    $error = "Error al desactivar prrioridad.";
  } else {
    $prioridad = 1;
    $success = "Prioridad activada correctamente.";
    $error = "Error al activar prioridad.";
  }

  $asignacionInfo = array('prioridad' => $prioridad);

  $result = $this->municipios_model->editarAsignacion($asignacionInfo, $id_asignacion);

  if ($result) {
    $this->session->set_flashdata('success', $success);
  }else{
    $this->session->set_flashdata('error', $error);
  }

  redirect('proyecto_asignaciones/'.$asignacion->id_proyecto);
}






/////////////////////////////////////////////////////////////////////////
    function addNewMunicipio()
    {
        $data['gestores'] = $this->gestores_model->getGestores();

        $this->global['pageTitle'] = 'CECAITRA : Agregar municipio';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewMunicipio', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function addNewMunicipio2()
    {
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->addNewMunicipio();
        } else {
            $descrip = trim( $this->input->post('descrip') );
            $iniciales = trim( $this->input->post('iniciales') );
            $codigo_municipio = trim( $this->input->post('codigo_municipio') );
            $activo = $this->input->post('activo');
            $observaciones = $this->input->post('observaciones');
            $gestor = $this->input->post('gestor');

            $municipioNew = array('descrip'=>$descrip, 'iniciales'=>$iniciales,'codigo_municipio'=>$codigo_municipio,'activo'=>$activo, 'observaciones'=>$observaciones, 'gestor'=>$gestor,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            $this->load->model('municipios_model');
            $result = $this->municipios_model->addNewMunicipio($municipioNew);

            if($result > 0) {
                $this->session->set_flashdata('success', 'Nueva municipio creado ok');
            } else {
                $this->session->set_flashdata('error', 'Error al crear municipio');
            }

            redirect('addNewMunicipio');
        }
    }

    function editOldMunicipio($municipioId = NULL)
    {
        if($municipioId == null){
            redirect('municipiosListing');
        }

        $data['municipioInfo'] = $this->municipios_model->getMunicipioInfo($municipioId);
        $data['gestores'] = $this->gestores_model->getGestores();

        $this->global['pageTitle'] = 'CECAITRA : Editar municipio';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldMunicipio', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function editMunicipio()
    {
        $municipioId = $this->input->post('municipioId');
        $this->form_validation->set_rules('descrip','Descripción','trim|required|max_length[100]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldMunicipio($municipioId);
        } else {
            $descrip          = $this->input->post('descrip');
            $iniciales        = $this->input->post('iniciales');
            $codigo_municipio = $this->input->post('codigo_municipio');
            $activo           = $this->input->post('activo');
            $observaciones    = $this->input->post('observaciones');
            $gestor           = $this->input->post('gestor');

            $municipioInfo = array('descrip'=>$descrip,'iniciales'=>$iniciales,'codigo_municipio'=>$codigo_municipio,'activo'=>$activo, 'observaciones'=>$observaciones, 'gestor'=>$gestor);

            $result = $this->municipios_model->editMunicipio($municipioInfo, $municipioId);

            if($result == true) {
                $this->session->set_flashdata('success', 'Municipio actualizada ok');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar municipio');
            }
            redirect('municipiosListing');
        }
    }

    function deleteMunicipio()
    {
        $municipioId   = $this->input->post('municipioId');
        $municipioInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));
        $result = $this->municipios_model->deleteMunicipio($municipioId, $municipioInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }

}

?>
