<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class socios extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('socios_model');
        $this->load->model('user_model');
        $this->load->model('ordenes_model');
        $this->load->model('equipos_model');
        $this->load->model('mail_model');
        $this->load->model('utilidades_model');
        $this->load->model('deposito_model');
        $this->load->library('fechas');
        $this->load->library('pagination');
    }

    

//Vistas//
    function salida_edicion() 
    {       
      $data['fotos'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,26);
      $data['eliminados'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,27);

      $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);
      $data['id_protocolo'] = $id_protocolo;
      $data['titulo'] = "preverificacion";

      $this->global['pageTitle'] = 'CECAITRA : preverificacion';
      $this->load->view('includes/header_layout', $this->global);
      
      $this->load->view('verificacion/preverificacion', $data);
      $this->load->view('includes/footer',$this->global);
    }

    function impacto_verifiacion() 
    {
       
    }


    function ver_estados_pm() 
    {
        
    }

    //procesos salida_edicion






}

?>
