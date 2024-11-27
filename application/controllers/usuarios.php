<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Usuarios extends BaseController
{
    public function __construct(){ // This is default constructor of the class.
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('usuarios_model');
        $this->load->model('equipos_model');
        $this->load->model('mensajes_model');
		$this->load->library('export_excel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function mostrarVista() {
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('listado');
      $this->load->view('includes/footer',$this->global);
    }

    public function index(){ // This function used to load the first screen of the user. 
        $this->global['pageTitle'] = 'CECAITRA: Stock';
        $data['usuarios'] = $this->usuarios_model->obtener_usuarios();

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('listado', $data);
        $this->load->view('includes/footer',$this->global);
    }

    public function ver_detalles($id_usuario){
        $data['usuario_detalles'] = $this->usuarios_model->ver_detalles($id_usuario);
        
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('ver_detalles', $data);
        $this->load->view('includes/footer',$this->global);
    }

    public function crear_usuario(){
        $nombre = $this->input->post('nombre');
        $email = $this->input->post('email');
        $data['name'] = $nombre;
        $data['email'] = $email;
        $result = $this->usuarios_model->crear_usuario($data);

        $this->session->set_flashdata('success', 'Usuario creado correctamente.');
        redirect('usuarios');
    }

    public function editar_usuario($id){
        $data['usuario_id'] = $this->usuarios_model->editar_usuario($id);
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editar_usuario', $data);
        $this->load->view('includes/footer',$this->global);
    }

    public function actualizar_datos(){
        $data['nuevo_nombreCompleto'] = $this->input->post('nombre_completo');
        $data['nuevo_nombre'] = $this->input->post('nombre');
        $data['nuevo_apellido'] = $this->input->post('apellido');
        $data['nuevo_email'] = $this->input->post('email');

        // $result = $this->usuarios_model->actualizar_datos($data);
        pre($data, 'pe');
        $this->session->set_flashdata('success', 'Usuario actualizado correctamente.');
        redirect('usuarios');
    }
}
