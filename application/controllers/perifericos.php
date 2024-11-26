<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Perifericos extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('perifericos_model');
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Adminstracion';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios');
        $this->load->view('includes/footer',$this->global);
    }

//////////// VISTAS ///////////////

    function perifericos_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $opciones = array(0 => 'Todos',
        'PE.id' => 'ID' ,
        'PE.serie' => 'Serie',
        'PT.nombre_tipo' => 'Tipo',
        'EM.serie' => 'Equipo',
        'EP.descrip' => 'Socio',
        'PE.comunicacion' => 'Transmitiendo',
        'MUN.descrip' => 'Proyecto',
        'PE.fecha_alta' => 'Fecha',
        'PE.estado' => 'Estado');

        $count = $this->perifericos_model->listadoPerifericos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $returns = $this->paginationCompress( "perifericos_listado/", $count, CANTPAGINA );
        $data['perifericos'] = $this->perifericos_model->listadoPerifericos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Perifericos';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->perifericos_model->listadoPerifericos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Ingreso listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('perifericos/perifericos', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function agregar_periferico()
    {
        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['tipos_periferico'] = $this->perifericos_model->tiposPerifericos();
        $data['asociados'] = $this->equipos_model->getAsociados();

        $data['tipoItem'] = 'Agregar';

        $this->global['pageTitle'] = 'CECAITRA: Agregar Periferico';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('perifericos/perifericos_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function editar_periferico($id_periferico = NULL)
    {
        if (!$id_periferico) {
          $this->session->set_flashdata('error', 'Error al editar periferico');
          redirect('perifericos_listado');
        }
        $data['periferico'] = $this->perifericos_model->getPeriferico($id_periferico);
        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['tipos_periferico'] = $this->perifericos_model->tiposPerifericos();
        $data['asociados'] = $this->equipos_model->getAsociados();

        $data['tipoItem'] = 'Editar';

        $this->global['pageTitle'] = 'CECAITRA: Agregar Periferico';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('perifericos/perifericos_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function ver_periferico($id_periferico = NULL)
    {
        if (!$id_periferico) {
          $this->session->set_flashdata('error', 'No existe periferico.');
          redirect('perifericos_listado');
        }

        $data['periferico'] = $this->perifericos_model->getPeriferico($id_periferico);
        $data['historiales'] = $this->perifericos_model->historialPeriferico($id_periferico);

        $this->global['pageTitle'] = 'CECAITRA: Ver Periferico';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('perifericos/perifericos_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }

    ////////////////// ACCIONES ///////////////////

    function agregar_editar_perifericos()
    {
        $serie = trim($this->input->post('serie'));
        $id_tipo = $this->input->post('id_tipo');
        $socio = $this->input->post('socio');
        $idequipo = $this->input->post('idequipo');
        $idEquipo = $this->input->post('idEquipo');
        $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));
        $tipoItem = $this->input->post('tipoItem');

        if ($idequipo) {
          $id_equipo = $idequipo[0];
        }else {
          $id_equipo = $idEquipo;
        }

        $perifericoInfo  = array('serie'=>$serie,
        'id_tipo'=>$id_tipo,
        'socio'=>$socio,
        'descrip'=>$observacion,
        'id_equipo'=>$id_equipo
        );

        if ($tipoItem == "Agregar") {
          array_push($perifericoInfo['creado_por'] = $this->vendorId);
          array_push($perifericoInfo['fecha_alta'] = date('Y-m-d H:i:s'));

          $evento = 10;
          $result = $this->perifericos_model->agregarPeriferico($perifericoInfo);
          $id_periferico = $result;

          $success = "Nuevo periferico agregado correctamente.";
          $error = "Error al agregar periferico.";
          $link = "agregar_periferico";
        } else {
          array_push($perifericoInfo['modificado_por'] = $this->vendorId);
          array_push($perifericoInfo['fecha_modificacion'] = date('Y-m-d H:i:s'));

          $evento = 20;
          $id_periferico = $this->input->post('id_periferico');
          $periferico = $this->perifericos_model->getPeriferico($id_periferico);
          $tipo_periferico = $this->perifericos_model->getTipoPeriferico($id_tipo);
          $nombre_socio = $this->equipos_model->getSocio($socio);
          $equipo_serie = $this->equipos_model->getSerie($id_equipo);
          $result = $this->perifericos_model->editarPeriferico($perifericoInfo, $id_periferico);

          $success = "Periferico editado correctamente.";
          $error = "Error al editar periferico.";
          $link = "perifericos_listado";
        }

        if($result == TRUE){
          $perifericoHistorial = array('id_periferico'=>$id_periferico, 'evento'=>$evento, 'observacion'=>$observacion, 'usuario'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

          if ($tipoItem == "Editar") {
            $detalle .= $this->perifericos_model->comparacionHistorial("El periferico",$tipo_periferico,$periferico->nombre_tipo);
            $detalle .= $this->perifericos_model->comparacionHistorial("El socio",$nombre_socio,$periferico->socio_descrip);
            $detalle .= $this->perifericos_model->comparacionHistorial("El equipo",$equipo_serie,$periferico->EM_serie);

            array_push($perifericoHistorial['detalle'] = $detalle);
          }

          $result2 = $this->perifericos_model->agregarHistorial($perifericoHistorial);
          $this->session->set_flashdata('success', $success);
        }else{
          $this->session->set_flashdata('error', $error);
        }
        redirect($link);
    }


    function estado_periferico()
    {
      $estado = $this->input->post('estado');
      $id_periferico = $this->input->post('id_periferico');
      $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

      if ($estado == 1) {
        $estado = 0;
        $evento = 40;
        $success = "Periferico desactivado correctamente.";
        $error = "Error al desactivar periferico.";
      } else {
        $estado = 1;
        $evento = 30;
        $success = "Periferico activado correctamente.";
        $error = "Error al activar periferico.";
      }

      $perifericoInfo = array('estado' => $estado, 'modificado_por' => $this->vendorId, 'fecha_modificacion' => date('Y-m-d H:i:s'));

      $result = $this->perifericos_model->editarPeriferico($perifericoInfo,$id_periferico);

      if ($result) {
        $perifericoHistorial = array('id_periferico'=>$id_periferico, 'evento'=>$evento, 'observacion'=>$observacion, 'usuario'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

        $result2 = $this->perifericos_model->agregarHistorial($perifericoHistorial);

        $this->session->set_flashdata('success', $success);
      }else{
        $this->session->set_flashdata('error', $error);
      }

      redirect('perifericos_listado');
    }

    function estado_comunicacion()
    {
      $comunicacion = $this->input->post('comunicacion');
      $id_periferico = $this->input->post('id_periferico');
      $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

      if ($comunicacion == 1) {
        $comunicacion = 0;
        $evento = 60;
        $success = "Comunicacion desactivada correctamente.";
        $error = "Error al desactivar comunicacion.";
      } else {
        $comunicacion = 1;
        $evento = 50;
        $success = "Comunicacion activada correctamente.";
        $error = "Error al activar comunicacion.";
      }

      $perifericoInfo = array('comunicacion' => $comunicacion, 'modificado_por' => $this->vendorId, 'fecha_modificacion' => date('Y-m-d H:i:s'));

      $result = $this->perifericos_model->editarPeriferico($perifericoInfo,$id_periferico);

      if ($result) {
        $perifericoHistorial = array('id_periferico'=>$id_periferico, 'evento'=>$evento, 'observacion'=>$observacion, 'usuario'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

        $result2 = $this->perifericos_model->agregarHistorial($perifericoHistorial);
        $this->session->set_flashdata('success', $success);
      }else{
        $this->session->set_flashdata('error', $error);
      }

      redirect('perifericos_listado');
    }



    ///////////////////// AJAX //////////////////////////

    function perifericos_equipos()
    {
      $equipos = $this->equipos_model->getEquipos($this->input->post('proyecto'),TRUE);
      echo json_encode($equipos);
    }




}


?>
