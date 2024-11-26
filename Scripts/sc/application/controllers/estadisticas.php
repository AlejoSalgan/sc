<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Estadisticas extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('estadisticas_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Adminstracion';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios');
        $this->load->view('includes/footer');
    }

//////////// VISTAS ///////////////

    function estadisticas_archivos()
    {
      $searchText = trim($this->input->post('searchText'));
      $criterio   = $this->input->post('criterio');
      $data['searchText'] = $searchText;
      $data['criterio']   = $criterio;

      $opciones = array(0 => 'Todos',
        'EA.id' => 'ID' ,
        'EA.nombre_archivo' => 'Archivo',
        'EA.protocolo' => 'Protocolo',
        'EA.id_orden' => 'Nº Orden',
        'EA.copiado' => 'Copiado',
        'EA.desencriptado' => 'Desencriptado',
        'EA.procesado' => 'Procesado',
        'EA.decripto' => 'Decripto');

      $count = $this->estadisticas_model->listadoArchivos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
      $returns = $this->paginationCompress( "estadisticas_archivos/", $count, CANTPAGINA );

      $data['archivos'] = $this->estadisticas_model->listadoArchivos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones);
      $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

      $data['titulo'] = 'Estadisticas Archivos';
      $data['total'] =  $count;
      $data['total_tabla'] =  $this->estadisticas_model->listadoArchivos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
      $data['opciones'] = $opciones;

      $this->global['pageTitle'] = 'CECAITRA: Estadisticas Archivos';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('estadisticas/estadisticas_archivos', $data);
      $this->load->view('includes/footer');
    }

    ////////////////// ACCIONES ///////////////////

    function confirmar_desencriptacion($id_archivo)
    {
      $id_archivo = $this->uri->segment(2);
      $archivoInfo = array('desencriptado' => 1);
      $result = $this->estadisticas_model->editarArchivo($archivoInfo,$id_archivo);

      if ($result) {
        $this->session->set_flashdata('success', 'Archivo Desencriptado correctamente.');
      }else{
        $this->session->set_flashdata('error', 'Error al actualizar el campo desencriptacion.');
      }

      redirect('estadisticas_archivos');
    }


}


?>
