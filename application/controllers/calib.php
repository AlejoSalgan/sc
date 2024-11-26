<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Calib extends BaseController
{
    public function __construct() // This is default constructor of the class
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('calib_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('flota_model');
        $this->load->model('tiposeq_model');
        $this->load->model('municipios_model');
        $this->load->model('utilidades_model');
        $this->load->model('ordenes_model');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }


    public function index() // This function used to load the first screen of the user
    {
        $this->global['pageTitle'] = 'CECAITRA: Calibraciones';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib');
        $this->load->view('includes/footer',$this->global);
    }

/* Vistas */

    function calibraciones_solicitudes() //Vista de solicitidus.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(10,20);

        $count = $this->calib_model->listadoOrdenes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "calibraciones_solicitudes/", $count, CANTPAGINA );

        $data['solicitudes'] = $this->calib_model->listadoOrdenes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));
        $data['equiposCalibrar'] = $this->calib_model->getEquiposCalibrar();

        $data['titulo'] = 'Solicitudes';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->calib_model->listadoOrdenes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Solicitudes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_solicitudes', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function calibraciones_ordenes() //Vista de ordenes.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(30,40,51,60,61);

        $count = $this->calib_model->listadoOrdenes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,1);
        $returns = $this->paginationCompress( "calibraciones_ordenes/", $count, CANTPAGINA );

        $data['ordenes'] = $this->calib_model->listadoOrdenes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,1);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));
        $data['titulo'] = 'Ordenes';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->calib_model->listadoOrdenes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_ordenes', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function calibraciones_pendientes() //Vista de ordenes.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(80,81);

        $count = $this->calib_model->listadoOrdenes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "calibraciones_pendientes/", $count, CANTPAGINA );

        $data['ordenes'] = $this->calib_model->listadoOrdenes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Pendientes';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->calib_model->listadoOrdenes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_pendientes', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function calibraciones_rechazadas() //Vista de ordenes.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = 99;

        $count = $this->calib_model->listadoOrdenes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "calibraciones_rechazadas/", $count, CANTPAGINA );

        $data['ordenes'] = $this->calib_model->listadoOrdenes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Rechazadas';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->calib_model->listadoOrdenes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_rechazadas', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function calibraciones_finalizadas() //Vista de ordenes.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(70,71);

        $count = $this->calib_model->listadoOrdenes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "calibraciones_finalizadas/", $count, CANTPAGINA );

        $data['ordenes'] = $this->calib_model->listadoOrdenes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Finalizadas';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->calib_model->listadoOrdenes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_finalizadas', $data);
        $this->load->view('includes/footer',$this->global);
    }


    //Carga la vista para agregar una solicitud de calibracion por parte del sector de proyectos.
    function agregar_SG()
    {
        $data['municipios'] = $this->municipios_model->getProyectosCalibrar($this->role,$this->vendorId);
        $data['servicios']   = $this->calib_model->getTipoServicio();
        $data['prioridades'] = $this->calib_model->getPrioridades();
        $data['tipo_equipo'] = $this->tiposeq_model->tiposeqListing(NULL,NULL,NULL);
        $data['tipoItem']    = "Agregar";

        $this->global['pageTitle'] = 'CECAITRA : Crear Solicitud de Calibración';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_AddEditSolicitud', $data);
        $this->load->view('includes/footer',$this->global);
    }

    //Carga la vista para editar una solicitud de calibracion por parte del sector de proyectos.
    function editar_SG($calibId = NULL)
    {
        if($calibId == null){
            redirect('calibraciones_solicitudes');
        }

        $data['municipios']  = $this->municipios_model->getMunicipios();
        $data['calibInfo']   = $this->calib_model->getCalibInfo($calibId);
        $data['servicios']   = $this->calib_model->getTipoServicio();
        $data['prioridades'] = $this->calib_model->getPrioridades();
        $data['tipoItem']    = "Editar";

        $this->global['pageTitle'] = 'CECAITRA : Editar Solicitud Revisión Técnica';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_AddEditSolicitud', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function editOldAprob($calibId = NULL) // Vista que agrega los datos Calibraciones.
    {
        if($calibId == null){
            redirect('calibraciones_solicitudes');
        }

        $data['municipios'] = $this->municipios_model->getMunicipios();
        $data['ordenNro'] = $this->calib_model->getProxOrden();
        $data['calibInfo'] = $this->calib_model->getCalibInfo($calibId);
        $data['servicios'] = $this->calib_model->getTipoServicio();
        $data['prioridades'] = $this->calib_model->getPrioridades();

        $this->global['pageTitle'] = 'CECAITRA : Editar Solicitud Aprobación Calibración';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_editPedidoSoli', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function editOldCalib($calibId = NULL) // Vista para editar una orden de Calibracion.
    {
        if($calibId == null){
            redirect('calibraciones_ordenes');
        }

        $data['municipios']   = $this->municipios_model->getMunicipios();
        $data['ordenNro']     = $this->calib_model->getProxOrden();
        $data['empleados']    = $this->user_model->getEmpleados(703);
        $data['supervisores'] = $this->user_model->getEmpleados(702);
        $data['vehiculos']    = $this->flota_model->getVehiculos(8); //destino 8.- "Calibraciones"
        $data['calibInfo']    = $this->calib_model->getCalibInfo($calibId);
        $data['servicios']    = $this->calib_model->getTipoServicio();
        $data['prioridades']  = $this->calib_model->getPrioridades();
        $data['tipoequipo']   = $this->equipos_model->getTipoEquipo();

        $tipo_equipo = $data['calibInfo'][0]->tipo_equipo;
        $servicio = $data['calibInfo'][0]->tipo_servicio;
        $horario = $data['calibInfo'][0]->horario_calib;
        $distancia = $data['calibInfo'][0]->distancia_inti;
        $carriles = $data['calibInfo'][0]->multicarril;

        //die(var_dump("Tipo_equipo:".$tipo_equipo."-------Servicio:".$servicio."--------Horario:".$horario."---------Distancia:".$distancia."---------N_carriles:".$carriles));

        $data['numeros_ot'] = $this->calib_model->getNumerosOT($tipo_equipo,$servicio,$horario,$distancia,$carriles);

        //die(var_dump($data['numeros_ot']));

        $this->global['pageTitle'] = 'CECAITRA : Editar Orden Calibración';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_editOrden', $data);
        $this->load->view('includes/footer',$this->global);
    }


    // Listado de aprobaciones.
    function calibraciones_parciales()
    {
        $data['tipos'] = $this->calib_model->getEquiposCalibrar();
        $pedidos = [];
        foreach ($data['tipos'] as $tipo) {
          $pedidos[$tipo->id] = $this->calib_model->getPedidos($tipo->id);
        }

        $restantes = [];
        foreach ($pedidos as $pedido => $value) {
          foreach ($value as $valor => $value2) {
              $restantes[$value2->id] = $this->calib_model->getRestantes($value2->id);
          }
        }

        $data['pedidos'] = $pedidos;
        $data['restantes'] = $restantes;
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA: Aprobaciones de equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_aprobaciones', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function ver_pedido($id_pedido = NULL)
    {
        if ($id_pedido == NULL) {
          $this->session->set_flashdata('error', 'No existe informacion de este pedido.');
          redirect('calibraciones_parciales');
        }

        $data['pedido'] = $this->calib_model->getPedido($id_pedido);

        if (!$data['pedido']) {
          $this->session->set_flashdata('error', 'No existe informacion de este pedido.');
          redirect('calibraciones_parciales');
        }

        $data['parciales'] = $this->calib_model->getParciales($id_pedido);

        $this->global['pageTitle'] = 'CECAITRA: Ver Parciales';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_verPedido', $data);
        $this->load->view('includes/footer',$this->global);
    }

    // Listado de los equipos para aprobar.
    function pedido_compra($id_pedido = NULL)
    {
      if ($id_pedido == NULL) {
        $this->session->set_flashdata('error', 'No existe informacion de este pedido.');
        redirect('calibraciones_parciales');
      }

      $pedidoInfo = $this->calib_model->getPedido($id_pedido);

      if (!$pedidoInfo) {
        $this->session->set_flashdata('error', 'No existe informacion de este pedido.');
        redirect('calibraciones_parciales');
      }

      if ($pedidoInfo->id_compra == NULL) {
        $data['tipoItem'] = 'Agregar';
      } else {
        $data['tipoItem'] = 'Editar';
        $data['compra'] = $this->calib_model->getCompra($pedidoInfo->id_compra);
      }

      $data['id_pedido'] = $id_pedido;

      $this->global['pageTitle'] = 'CECAITRA: Pedido de compra';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('calibraciones/calib_addEditCompra', $data);
      $this->load->view('includes/footer',$this->global);
    }

    function verCalib($calibId = NULL)
    {
        if($calibId == null){
            redirect('calibListing');
        }

        $data['calibInfo'] = $this->calib_model->getCalibInfo($calibId);
        $data['eventos'] = $this->calib_model->getEventos($calibId);
        $data['cantidad'] = $this->calib_model->getEventos($calibId,1);
        $data['grupos_eventos'] = $this->calib_model->getGrupoEventos($calibId);
        $sectores = [];

        foreach ($data['grupos_eventos'] as $grupo) {
          $porcentaje = $this->utilidades_model->porcentaje($grupo->cantidad,$data['cantidad'],0);
          $sectores[$grupo->color] = $porcentaje;
        }

        $data['sectores'] = $sectores;
        $estados = array(3,4,5,6,9,10,11,14,15,16);
        $data['ordenes'] =  $this->ordenes_model->ordenes_abiertas($data['calibInfo'][0]->equipoSerie,$estados,'R');

        $this->global['pageTitle'] = 'CECAITRA : Detalle Orden Calibración';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function calibraciones_adjuntar($idorden = NULL)
    {
      if ($idorden == NULL) {
         $this->session->set_flashdata('error', 'No existe esta orden.');
         redirect('calibraciones_ordenes');
      }

      $data['calibInfo'] = $this->calib_model->getCalibInfo($idorden);

      if (!$data['calibInfo']) {
         $this->session->set_flashdata('error', 'No existe informacion de esta orden.');
         redirect('calibraciones_ordenes');
      }

      /*$estados = array(1,2,7,8,9,10,12);
      if (in_array($orden->rm_ultimo_estado, $estados)) {
        $this->session->set_flashdata('error', 'Esta orden no se puede adjuntar archivo');
        redirect($this->input->get('ref'));
      }*/

      $viewdata['id_orden'] = $data['calibInfo'][0]->id;
      $viewdata['serie'] = $data['calibInfo'][0]->equipoSerie;
      $viewdata['tipo_orden'] = $data['calibInfo'][0]->tipo_orden;
      $viewdata['archivos'] = $this->ordenes_model->getArchivos($idorden);
      $viewdata['cant_archivos'] = $this->ordenes_model->getArchivos($idorden,1);
      $viewdata['guardar'] = 'guardar_certificado';
      $viewdata['cargar'] = 'cargar_certificado';
      $viewdata['descargar'] = 'descargar_certificado';
      $viewdata['eliminar'] = 'eliminar_certificado';


      $this->global['pageTitle'] = 'CECAITRA: Adjuntar archivos';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('sectores/SEC_adjArchivos',$viewdata);
      $this->load->view('includes/footer',$this->global);
    }

/* Vistas */

/* Consultas Ajax */

    function numeros_parciales()
    {
      $parcial = $this->calib_model->getListParciales($this->input->post('id_pedido'));
      echo json_encode($parcial);
    }

    function equipos_calibrar()
    {
      $tipos = $this->calib_model->getEquiposCalibrar(1);
      $equipos = $this->calib_model->getEquipos($this->input->post('proyecto'),$tipos);
      echo json_encode($equipos);
    }

/* Consultas Ajax */


/* Acciones */
function agregar_editar_SG() // Funcion que agrega o edita la solicitud de calibracion.
{
    $tipoItem = $this->input->post('tipoItem');
    $calibId  = $this->input->post('calibId');
    $tipo = "";
    $ord_tipo = "";

        switch ($tipoItem) {
            case 'Agregar':
                $idequipo = $this->input->post('idequipo');
                foreach ($idequipo as $key => $equipo) {

                    $idproyecto                 = $this->input->post('idproyecto');
                    $idequipo1                  = $equipo;

                    $direccion                  = $this->input->post('direccion');
                    $tipo_equipo                = $this->input->post('tipo_equipo');
                    $velocidad                  = $this->input->post('velper');
                    $multicarril                = $this->input->post('multicarril');

                    
                    

                    if ($tipo_equipo != 1) {
                      if ($direccion == "" || $direccion == " " || $direccion == NULL) {
                        $this->session->set_flashdata('error', 'Falta la direccion al equipo. Por favor completar este dato.');
                        redirect('agregar_SG');
                      }

                      if ($velocidad == "" || $velocidad == " " || $velocidad == NULL || $velocidad == 0) {
                        $this->session->set_flashdata('error', 'Falta la velocidad al equipo. Por favor completar este dato.');
                        redirect('agregar_SG');
                      }

                      if ($multicarril == "" || $multicarril == " " || $multicarril == NULL || $multicarril == 0) {
                        $this->session->set_flashdata('error', 'Falta la cantidad de carriles al equipo. Por favor completar este dato.');
                        redirect('agregar_SG');
                      }
                    }

                    $fecha_desde                = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde'));
                    $fecha_hasta                = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta'));
                    $tipo_servicio              = $this->input->post('tipo_servicio');
                    $prioridad                  = $this->input->post('prioridad');

                    $observaciones_gestor       = trim( $this->input->post('observaciones_gestor') );
                    if ($observaciones_gestor == '' || $observaciones_gestor == NULL) {
                        $observaciones_gestor = 'Sin observaciones';
                    } else {
                        $observaciones_gestor = trim($this->input->post('observaciones_gestor'));
                    }

                    $calibNew = array('idproyecto'=>$idproyecto, 'idequipo'=>$idequipo1, 'direccion'=>$direccion, 'tipo_equipo'=>$tipo_equipo, 'fecha_desde'=>$fecha_desde, 'fecha_hasta'=>$fecha_hasta, 'tipo_servicio'=>$tipo_servicio, 'prioridad'=>$prioridad, 'velocidad'=>$velocidad, 'observaciones_gestor'=> $observaciones_gestor, 'tipo'=> $tipo, 'ord_tipo'=> $ord_tipo, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:s'), 'multicarril'=>$multicarril);
                    $result = $this->calib_model->addNewSolic($calibNew);
                }
            break;

            case 'Editar':
                $idproyecto                 = $this->input->post('idproyecto');
                $idequipo                   = $this->input->post('idequipo');
                $tipo_servicio              = $this->input->post('tipo_servicio');
                $prioridad                  = $this->input->post('prioridad');
                $fecha_desde                = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde'));
                $fecha_hasta                = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta'));
                $observaciones_gestor       = trim( $this->input->post('observaciones_gestor') );
                $activo                     = $this->input->post('activo');

                $calibInfo = array('idproyecto'=>$idproyecto,'idequipo'=>$idequipo, 'tipo_servicio'=>$tipo_servicio, 'prioridad'=>$prioridad, 'fecha_desde'=>$fecha_desde, 'fecha_hasta'=>$fecha_hasta, 'observaciones_gestor'=> $observaciones_gestor,'activo'=>$activo, 'ord_tipo'=>$ord_tipo,);
                $result = $this->calib_model->editCalib($calibInfo, $calibId);

            break;
        }

        if($result > 0){
            if ($tipoItem == "Agregar") {
                $this->session->set_flashdata('success', 'Nueva solicitud de Calibración creada correctamente.');

                $categoria  = $this->calib_model->getCategoria($this->role);

                $eventoInfo  = array('num_orden'=>$result, 'estado'=>10, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observaciones_gestor, 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);
                $this->calib_model->agregarEvento($eventoInfo);

            } else {
                $this->session->set_flashdata('success', 'Solicitud de Calibración editada correctamente.');
            }
        } else{
            if ($tipoItem == "Agregar") {
                $this->session->set_flashdata('error', 'Error al crear solicitud de Calibración.');
            } else {
                $this->session->set_flashdata('error', 'Error al editar solicitud de Calibración.');
            }
        }

        if ($tipoItem == "Agregar") {
            redirect('agregar_SG');
        } else {
            redirect('calibraciones_solicitudes');
        }

    }

    function deleteCalib()
    {
        $calibId      = $this->input->post('id_orden');
        $observacion  = trim($this->input->post('observacion'));
        $carateres = strlen($observacion);

        if ($carateres < 50) {
          $this->session->set_flashdata('error', 'La observacion que escribiste tiene menos de 50 caracteres.');
          redirect('calibraciones_solicitudes');
        }

        if($calibId == null){
            redirect('calibraciones_solicitudes');
        }

        $calibInfo1   = $this->calib_model->getCalibInfo($calibId);

        foreach($calibInfo1 as $info){
          $tipo_orden = $info->tipo_orden;
        }

        if ($tipo_orden == 10 || $tipo_orden == 20) {
          $link = 'calibraciones_solicitudes';
        } elseif ($tipo_orden == 40 || $tipo_orden == 51 || $tipo_orden == 60 || $tipo_orden == 61) {
          $link = 'calibraciones_ordenes';
        } elseif ($tipo_orden == 80 || $tipo_orden == 81) {
          $link = 'calibraciones_pendientes';
        }

        $calibInfo = array('tipo_orden'=>99,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->calib_model->deleteCalib($calibId, $calibInfo);

        if ($result) {
          $categoria  = $this->calib_model->getCategoria($this->role);

          $eventoInfo  = array('num_orden'=>$calibId, 'estado'=>99, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);
          $this->calib_model->agregarEvento($eventoInfo);

          $this->session->set_flashdata('success', 'Orden de calibracion cancelada correctamente.');

        } else {
          $this->session->set_flashdata('error', 'Error al cancelar la Orden de calibracion.');
        }


        redirect($link);
    }



    function aprobarSoliG($calibId = NULL) //Pedido de solicitud a Calibraciones.
    {
        $calibInfo   = $this->calib_model->getCalibInfo($calibId);

        foreach($calibInfo as $info){
          $tipo_equipo = $info->tipo_equipo;
        }

        if ($tipo_equipo == '1') {
            $tipo_orden = 30;
            $calibInfo = array('tipo_orden'=>$tipo_orden, 'distancia_inti'=>'+100', 'horario_calib'=>'D');
        } else {
            $tipo_orden = 20;
            $calibInfo = array('tipo_orden'=>$tipo_orden);
        }

        $result = $this->calib_model->editCalib($calibInfo,$calibId);

        $categoria  = $this->calib_model->getCategoria($this->role);
        $eventoInfo  = array('num_orden'=>$calibId, 'estado'=>$tipo_orden, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>'Pedido de solicitud a Calibraciones.', 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);
        $this->calib_model->agregarEvento($eventoInfo);

        $this->session->set_flashdata('success', 'Solicitud de calibracion pedida correctamente.');
        redirect('calibraciones_solicitudes');
    }


    function editAprob() // Funcion guardar de lo que edita calibraciones
    {
        $calibId = $this->input->post('calibId');

        $idproyecto            = $this->input->post('idproyecto');
        $idequipo              = $this->input->post('idequipo');
        $distancia_inti        = $this->input->post('distancia_inti');
        $horario_calib         = $this->input->post('horario_calib');
        $observacion_solicalib = $this->input->post('observacion_solicalib');

        $calibInfo = array('idproyecto'=>$idproyecto, 'idequipo'=>$idequipo, 'distancia_inti'=>$distancia_inti, 'horario_calib'=>$horario_calib, 'observacion_solicalib'=>$observacion_solicalib);

        $result = $this->calib_model->editCalib($calibInfo, $calibId);

        if($result == true){
            $this->session->set_flashdata('success', 'Solicitud Calibración actualizada correctamente');
        } else{
            $this->session->set_flashdata('error', 'Error al actualizar Solicitud Calibración');
        }
        redirect('calibraciones_solicitudes');
    }


    function solicitarSG($calibId = NULL) //Solicitud de aprobacion de Calibraciones a SSGG.
    {
        if($calibId == null){
            redirect('calibraciones_solicitudes');
        }

        $calibInfo = array('tipo_orden'=> 30);

        $result = $this->calib_model->editCalib($calibInfo,$calibId);

        $categoria  = $this->calib_model->getCategoria($this->role);
        $eventoInfo  = array('num_orden'=>$calibId, 'estado'=>30, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>'Pedido de solicitud a Servicios Generales.', 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);
        $this->calib_model->agregarEvento($eventoInfo);

        $this->session->set_flashdata('success', 'Pedido de aprobacion solicitada correctamente.');
        redirect('calibraciones_solicitudes');
    }



    function editCalib() //Guarda informacion de una orden en proceso.
    {
        $calibId    = $this->input->post('calibId');
        $tipoequipo = $this->input->post('tipoequipo');

        $idproyecto          = $this->input->post('idproyecto');
        $idequipo            = $this->input->post('idequipo');
        $tipoequipo          = $this->input->post('tipoequipo');

        $fecha_visita        = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));

        $idsupervisor        = $this->input->post('idsupervisor');
        $iddominio           = $this->input->post('iddominio');
        $conductor           = $this->input->post('conductor');
        $tecnico             = $this->input->post('tecnico');
        $observaciones_calib = $this->input->post('observaciones_calib');

        $imei                = $this->input->post('imei');
        //$nro_ot              = $this->input->post('nro_ot');
        $nro_ot              = "";

        $fecha_pasadas       = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_pasadas'));
        $fecha_simulacion    = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_simulacion'));
        $fecha_informe       = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_informe'));
        $fecha_certificado   = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_certificado'));

        $pasadas_aprob       = $this->input->post('pasadas_aprob');
        $simulacion_aprob    = $this->input->post('simulacion_aprob');
        $tipo                = $this->input->post('tipo');
        $tipo_ver            = $this->input->post('tipo_ver');
        $pasadas_aprob       = $this->input->post('pasadas_aprob');
        $simulacion_aprob    = $this->input->post('simulacion_aprob');

        $id_pedido  = $this->input->post('num_ot');
        $id_parcial = $this->input->post('num_parcial');

        if ($fecha_pasadas == NULL) {
            $pasadas_aprob = 0;
        }

        if ($fecha_simulacion == NULL) {
            $simulacion_aprob = 0;
        }

        if ($pasadas_aprob == 2 OR $simulacion_aprob == 2) {
            $fecha_informe      = NULL;
            $fecha_certificado  = NULL;
        }

        if ($id_pedido != "" && $id_parcial != "") {
          $parcialInfo = array('num_orden'=>$calibId , 'usuario_orden' =>$this->vendorId , 'ts_orden' => date('Y-m-d H:i:s'));
          $resultado = $this->calib_model->editarParcial($parcialInfo,$id_parcial);
        }

        $calibInfo1   = $this->calib_model->getCalibInfo($calibId);

        foreach($calibInfo1 as $info){
          $tipo_orden = $info->tipo_orden;
        }

        if ($tipo_orden != 80 && $tipo_orden != 81) {
            switch ($tipo_ver) {
                case 'Primitiva':
                    if ($fecha_pasadas != NULL and $fecha_simulacion != NULL and $fecha_informe == NULL /*and $nro_ot != ''*/ and $pasadas_aprob == 1 and $simulacion_aprob == 1) {
                        $tipo_orden = 60;
                    } elseif ($fecha_pasadas != NULL and $fecha_simulacion != NULL and $fecha_informe != NULL /*and $nro_ot != ''*/ and $pasadas_aprob == 1 and $simulacion_aprob == 1) {
                        $tipo_orden = 61;
                    } elseif (($fecha_pasadas != NULL OR $fecha_simulacion != NULL /*and $nro_ot != ''*/) and ($pasadas_aprob == 2 OR $simulacion_aprob == 2)) {
                        $tipo_orden = 51;
                    } else {
                        $tipo_orden = 40;
                    }
                    break;

                case 'Periodica':
                    switch ($tipoequipo) {
                        case 0:
                            if ($fecha_pasadas != NULL and $fecha_simulacion != NULL /*and $nro_ot != ''*/ and $pasadas_aprob == 1 and $simulacion_aprob == 1) {
                              $tipo_orden   = 61; //antes 22
                            } elseif (($fecha_pasadas != NULL OR $fecha_simulacion != NULL /*and $nro_ot != ''*/) and ($pasadas_aprob == 2 OR $simulacion_aprob == 2)) {
                                $tipo_orden = 51;
                            } else {
                                $tipo_orden = 40;
                            }
                            break;

                        case 1:
                            if ($fecha_pasadas != NULL and $fecha_simulacion != NULL /*and $nro_ot != '' */and $pasadas_aprob == 1 and $simulacion_aprob == 1) {
                                $tipo_orden = 61;
                            } elseif (($fecha_pasadas != NULL OR $fecha_simulacion != NULL /*and $nro_ot != ''*/) and ($pasadas_aprob == 2 OR $simulacion_aprob == 2)) {
                                $tipo_orden = 51;
                            } elseif ($fecha_visita != '00-00-0000') {
                                $tipo_orden = 40;
                            }
                            break;
                    }
                    break;
            }

        }

        /*if ($fecha_certificado != NULL) { //Faltaria un AND preguntando por el archivo adjunto del certificado y actualizando la fecha de calibracion del equipo
            $tipo_orden = 22;
        }*/

        $calibInfo = array('idproyecto'=>$idproyecto, 'idequipo'=>$idequipo, 'fecha_visita'=>$fecha_visita, 'idsupervisor'=>$idsupervisor,'iddominio'=>$iddominio,'conductor'=>$conductor, 'tecnico'=>$tecnico, 'observaciones_calib'=>$observaciones_calib, 'imei'=>$imei, 'nro_ot'=>$nro_ot, 'fecha_pasadas'=>$fecha_pasadas, 'fecha_simulacion'=>$fecha_simulacion,
        'fecha_informe'=>$fecha_informe, 'fecha_certificado'=>$fecha_certificado, 'pasadas_aprob'=>$pasadas_aprob, 'simulacion_aprob'=>$simulacion_aprob, 'tipo_orden'=> $tipo_orden);

        $result = $this->calib_model->editCalib($calibInfo, $calibId);

        if($result == true){
            $this->session->set_flashdata('success', 'Orden Calibración actualizada correctamente');
        } else{
            $this->session->set_flashdata('error', 'Error al actualizar Orden Calibración');
        }

        if ($tipo_orden == 40 || $tipo_orden == 51 || $tipo_orden == 60 || $tipo_orden == 61) {
          $link = 'calibraciones_ordenes';
        } elseif ($tipo_orden == 80 || $tipo_orden == 81) {
          $link = 'calibraciones_pendientes';
        }

        redirect($link);
    }


    function espera($calibId = NULL) //Pasar a pendiente una calibracion.
    {
        if($calibId == null){
            redirect('calibraciones_ordenes');
        }

        $calibInfo   = $this->calib_model->getCalibInfo($calibId);

        foreach($calibInfo as $info){
          $tipo_orden = $info->tipo_orden;
        }

        if ($tipo_orden == 60) {
          $valor_tipoOrden = 80;
        } else {
          $valor_tipoOrden = 81;
        }

        $calibInfo = array('tipo_orden'=>$valor_tipoOrden);

        $result = $this->calib_model->editCalib($calibInfo,$calibId);

        if ($result) {
          $categoria  = $this->calib_model->getCategoria($this->role);
          $mensaje = "Orden pasada a Pendiente correctamente.";

          $eventoInfo  = array('num_orden'=>$calibId, 'estado'=>$valor_tipoOrden, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$mensaje, 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);

          $this->calib_model->agregarEvento($eventoInfo);

          $this->session->set_flashdata('success', $mensaje);

        } else {
          $this->session->set_flashdata('error', 'Error al pasar la Orden.');
        }

        redirect('calibraciones_ordenes');
    }


    function finalizar($calibId = NULL) //Pasar a pendiente una calibracion.
    {
        if($calibId == null){
            redirect('calibraciones_ordenes');
        }

        $calibInfo   = $this->calib_model->getCalibInfo($calibId);

        foreach($calibInfo as $info){
          $tipo_orden = $info->tipo_orden;
        }

        switch ($tipo_orden) {
          case 51:
            $valor_tipoOrden = 71;
            $link = 'calibraciones_ordenes';
            break;

          case 80:
          case 81:
            $valor_tipoOrden = 70;
            $link = 'calibraciones_pendientes';
            break;

          default:
            redirect('calibraciones_ordenes');
            break;
        }

        $calibInfo = array('tipo_orden'=>$valor_tipoOrden);

        $result = $this->calib_model->editCalib($calibInfo,$calibId);


        if ($result) {
          $nueva_fechacal = $this->calib_model->getCertificado($calibId);

          if ( $nueva_fechacal != NULL) {
              $equipoId = $this->calib_model->getIDEquipo($calibId);
              $nueva_fechavto = strtotime ( '+364 day' , strtotime ($nueva_fechacal) ) ;
              $nueva_fechavto = date ( 'Y-m-d' , $nueva_fechavto );
              $equipoInfo = array('doc_fechacal'=>$nueva_fechacal, 'doc_fechavto'=>$nueva_fechavto);
              $result2 = $this->equipos_model->editEquipo($equipoInfo, $equipoId);
          }

          $categoria  = $this->calib_model->getCategoria($this->role);
          $mensaje = "Orden finalizada correctamente.";

          $eventoInfo  = array('num_orden'=>$calibId, 'estado'=>$valor_tipoOrden, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$mensaje, 'usuario'=>$this->vendorId, 'rol_categoria'=>$categoria);

          $this->calib_model->agregarEvento($eventoInfo);

          $this->session->set_flashdata('success', $mensaje);

        } else {
          $this->session->set_flashdata('success', 'Error al finalizar la Orden.');
        }

        redirect($link);
    }

    function aprobarSoliSG($verificacion,$multicarril=0,$horario=0,$distancia=0)
    {
        $verificacion  = $this->uri->segment(2);
        $multicarril   = $this->uri->segment(3);
        $horario       = $this->uri->segment(4);
        $distancia     = $this->uri->segment(5);
        $calibraciones = $this->calib_model->aprobacion_equipo($verificacion,$multicarril,$horario,$distancia);

        if (!$calibraciones) {
          $this->session->set_flashdata('error', 'No existen solicitudes para aprobar.');
          redirect('aprobacionesListing');
        }

        foreach ($calibraciones as $calibracion) {
            $calibInfo = array('tipo_orden'=>40);
            $result = $this->calib_model->editCalib($calibInfo, $calibracion->id);
        }

        if ($result > 0) {
            $this->session->set_flashdata('success', 'Solicitudes aprobadas correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al aprobar solicitudes.');
        }

        redirect('aprobacionesListing');
    }

    // Funcion para aprobar colocando el numero y la fecha de orden de compra.
    function agregar_compra()
    {
      $tipoItem = $this->input->post('tipoItem');
      $id_pedido = $this->input->post('id_pedido');
      $num_compra = $this->input->post('num_compra');
      $fecha_ot = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_ot'));
      $presupuesto = $this->input->post('presupuesto');
      $num_ot = $this->input->post('num_ot');
      $observacion_compra = $this->input->post('observacion_compra');
      $fecha_ordCompra = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_ordenCompra'));
      $fecha_presupuesto = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_presupuesto'));

      $compraInfo = array('num_compra' => $num_compra, 'fecha_ot' => $fecha_ot, 'presupuesto' => $presupuesto, 'num_ot' => $num_ot, 'fecha_ordCompra' => $fecha_ordCompra, 'fecha_presupuesto' => $fecha_presupuesto, 'observacion_compra' => $observacion_compra, 'usuario_compra' => $this->vendorId, 'ts_compra' => date('Y-m-d H:i:s'));

      if ($tipoItem == 'Agregar') {
        $resultado = $this->calib_model->agregarCompra($compraInfo);
      } else {
        $id_compra = $this->input->post('id_compra');
        $resultado = $this->calib_model->editarCompra($compraInfo,$id_compra);
      }

      if($resultado > 0){
        $pedidoInfo = array('id_compra' => $resultado);
        $resultado2 = $this->calib_model->editarPedido($pedidoInfo,$id_pedido);
        $this->session->set_flashdata('success', 'Se agrego correctamente la orden de compra.');
      } else{
        $this->session->set_flashdata('error', 'Error al agregar la orden de compra.');
      }

      redirect('calibraciones_parciales');
    }

    function agregar_pedidos()
    {
      $tipo_equipo = $this->input->post('tipo_equipo');
      $cantidad   = $this->input->post('cantidad');
      $tipo_servicio = $this->input->post('tipo_servicio');
      $observacion = $this->input->post('observacion');
      $bandera = "";
      $infoPedidos = array('tipo_equipo' => $tipo_equipo, 'cantidad' => $cantidad, 'servicio' => $tipo_servicio,'observacion' => $observacion, 'usuario_pedido'=>$this->vendorId, 'ts_pedido'=>date('Y-m-d H:i:s'));

      if ($tipo_equipo == 2402 || $tipo_equipo == 2 || $tipo_equipo == 2407 || $tipo_equipo == 400) {
        $infoPedidos['horario'] = $this->input->post('horario');
        $infoPedidos['distancia'] = $this->input->post('distancia');
      }

      if ($tipo_equipo == 2 || $tipo_equipo == 2407 || $tipo_equipo == 400) {
        $infoPedidos['carriles'] = $this->input->post('carriles');
      }

      if ($tipo_equipo == 2402) {
        $infoPedidos['carriles'] = 1;
      }

      if ($tipo_equipo == 1) {
        $infoPedidos['carriles'] = 0;
      }

      $id_pedido = $this->calib_model->agregarPedido($infoPedidos);

      if ($id_pedido > 0) {
        for ($i=1; $i <= $cantidad; $i++) {
          $insertParcial = array('id_pedido' => $id_pedido, 'num_parcial' => $i);
          $id_parcial = $this->calib_model->agregarParcial($insertParcial);
          if ($id_parcial == 0) {
            $bandera = 1;
            break;
          }
        }

        if ($bandera == 1) {
          $this->calib_model->eliminarParcial($id_pedido);
          $this->calib_model->eliminarPedido($id_pedido);

          $this->session->set_flashdata('error', 'Error al solicitar numeros de parciales.');
          redirect('calibraciones_solicitudes');
        }

          $this->session->set_flashdata('success', 'Numeros de parciales solicitados correctamente.');
      } else{
          $this->session->set_flashdata('error', 'Error al solicitar numeros de parciales.');
      }

      redirect('calibraciones_solicitudes');
    }

    function aprobacion_compra($id_pedido = NULL)
    {
      if ($id_pedido == NULL) {
        $this->session->set_flashdata('error', 'No existe informacion de este pedido.');
        redirect('calibraciones_parciales');
      }

      $pedidoInfo = $this->calib_model->getPedido($id_pedido);

      if (!$pedidoInfo->num_compra || !$pedidoInfo->num_ot || !$pedidoInfo->id_compra) {
        $this->session->set_flashdata('error', 'No existe datos de la Orden de Compra para este pedido.');
        redirect('calibraciones_parciales');
      }

      $compraInfo = array('estado' => 1, 'usuario_aprobacion' => $this->vendorId, 'ts_aprobacion' => date('Y-m-d H:i:s'));
      $resultado = $this->calib_model->editarCompra($compraInfo, $pedidoInfo->id_compra);

      if ($resultado > 0) {
        $this->session->set_flashdata('success', 'Pedido aprobado correctamente.');
      } else{
        $this->session->set_flashdata('error', 'Error al aprobar el pedido.');
      }

      redirect('calibraciones_parciales');
    }




    function guardar_certificado()
    {
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $id_orden = $this->input->post('id_orden');
      $observacion = $this->input->post('observacion');


      if ($_FILES['archivo']['size'] > 1048576) {
          $this->session->set_flashdata('info', $observacion); // En caso de que el archivo sea mayor a 1MB devuelvo el dato al formulario.
          $this->session->set_flashdata('error', 'No se puede adjuntar porque el archivo pesa mas de un 1MB.');
          redirect('calibraciones_adjuntar/'.$id_orden);
        }

      if ($observacion == '' || $observacion == NULL) {
        $observacion = 'Sin observaciones.';
      }

      $nombre_actual = $_FILES['archivo']['name'];
      $nombre_temp   = $_FILES['archivo']['tmp_name'];
      $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));
      $fecha         = date('Ymd-His');
      //$sector        = explode('/',$ref);

      $sector = 'calibraciones';

      //SC - SCDEV
      $destino = documentacion.$sector.'/'.$id_orden."_$fecha"."$ext";
      //Localhost
      //$destino = "/var/www/html/sistemac/documentacion/reparaciones/".$id_orden."_$fecha"."$ext";


      $tipo_documentacion = $this->input->post('tipo_documentacion');

      if ($tipo_documentacion == 7) {
        $nombre_archivo = NULL;
      } else {
        $nombre_archivo = $this->input->post('nombre_archivo');
      }

      if (in_array($ext, tipo_doc)){
        if (move_uploaded_file($nombre_temp,$destino)){
          $archivoInfo  = array('orden'=>$id_orden,
          'nombre_archivo'=>$nombre_archivo,
          'tipo_documentacion'=>$tipo_documentacion,
                                    'observacion'=>$observacion,
                                    'archivo'=>$id_orden."_$fecha"."$ext",
                                    'tipo'=>$ext,
                                    'creado_por'=>$this->vendorId,
                                    'fecha_ts'=>date('Y-m-d H:i:s')
                                    );

          $resultado = $this->ordenes_model->agregarArchivo($archivoInfo);//Agrego el los presupuesto.

          $this->session->set_flashdata('success', 'Archivo guardado correctamente para la orden de trabajo Nº '.$id_orden.'');
        }else{
          $this->session->set_flashdata('error', 'Error al guardar archivo para la orden de trabajo Nº '.$id_orden.'');
        }
      }else{
        $this->session->set_flashdata('error', 'Formato de archivo no aceptado o no se adjunto archivo.');
      }
      redirect('calibraciones_adjuntar/'.$id_orden);

    }

    function cargar_certificado($id_orden = NULL)
    {
      $ref = $this->input->get('ref');
      $searchText = $this->input->get('searchText');

      if ($id_orden == NULL) {
         $this->session->set_flashdata('error', 'No existe esta orden.');
         redirect('calibraciones_ordenes');
      }

      $data['calibInfo'] = $this->calib_model->getCalibInfo($id_orden);

      if (!$data['calibInfo']) {
         $this->session->set_flashdata('error', 'No existe informacion de esta orden.');
         redirect('calibraciones_ordenes');
      }

      /*$estados = array(1,2,7,8,9,10,12);
      if (in_array($orden->rm_ultimo_estado, $estados)) {
        $this->session->set_flashdata('error', 'Esta orden no se puede adjuntar archivo');
        redirect($this->input->get('ref'));
      }*/

      $archivoInfo = array('estado'=> 1);
      $result = $this->ordenes_model->updateArchivos($archivoInfo, $id_orden);

      if($result == TRUE){ // Agrego un nuevo evento.
          $this->session->set_flashdata('success', 'Archivos cargados correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al cargar archivos.');
      }
      redirect('calibraciones_adjuntar/'.$id_orden);

    }

    function descargar_certificado()
    {
      $name = $this->input->post('name');
      $tipo = $this->input->post('tipo');
      $id_orden = $this->input->post('id_orden');
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $direccion = $this->input->post('direccion');
      //$sector = explode('/',$ref);
      $sector = 'calibraciones';

      //$link = $direccion."?ref=".$ref."&searchText=".$searchText;

      $link = $direccion;

      if (array_key_exists($tipo, tipos_mime)) {
        $tipo = tipos_mime[$tipo];
      } else {
        $this->session->set_flashdata('error', 'Error al descargar el archivo.');
        redirect($link);
      }

      //SC - SCDEV
      $destino = documentacion.$sector.'/'.$name;
      //Localhost
      //$destino = '/var/www/html/sistemac/documentacion/reparaciones/'.$name;

      if (!file_exists($destino)) {
        $this->session->set_flashdata('error', 'No existe el archivo para esta orden.');
        redirect($link);
      }

      $this->utilidades_model->descargar_archivos($name,$tipo,$destino);
    }

    function eliminar_certificado($id = NULL)
    {
      $id_orden = $this->input->get('orden');
      $ref = $this->input->get('ref');
      $searchText = $this->input->get('searchText');

      if($id == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('calibraciones_adjuntar/'.$id_orden);
      }

      $archivo = $this->ordenes_model->getArchivo($id);

      if (!$archivo) { //Valido que el remito exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('calibraciones_adjuntar/'.$id_orden);
      }

      //$sector = explode('/',$ref);
      $sector = 'calibraciones';


      //SC - SCDEV
      $destino = documentacion.$sector.'/';
      //Localhost
      //$destino = '/var/www/html/sistemac/documentacion/reparaciones/';

      if (unlink($destino.$archivo->archivo)) {
        $archivoInfo  = array('activo'=>0, 'modificado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));
        $this->ordenes_model->updatearchivo($archivoInfo, $id);
        $this->session->set_flashdata('success', 'Archivo adjunto borrado.');
      } else {
        $this->session->set_flashdata('error', 'Error al borrar el archivo adjuntado.');
      }

      redirect('calibraciones_adjuntar/'.$id_orden);

    }


/* Acciones*/






































    //Ordenes o solicitudes de calibraciones que fueron creadas.
    function calibListing($value, $filtro = 0)
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $count = $this->calib_model->calibListingCount($searchText,$filtro,$criterio);
	      $returns = $this->paginationCompress( "calibListing/", $count, 30 );

        $data['calibRecords'] = $this->calib_model->calibListing($searchText, $returns["page"], $returns["segment"], $filtro,$criterio);
        $data['filtro'] = $filtro;
        $data['roleUser'] = $this->role;

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        switch ($filtro){
            case 0:
                $this->global['pageTitle'] = 'CECAITRA: Solicitud de Calibracion listado';
            break;
            case 1:
                $this->global['pageTitle'] = 'CECAITRA: Ordenes Calibración listado';
            break;
            case 2:
                $this->global['pageTitle'] = 'CECAITRA: Ordenes Calibración Pendientes listado';
            break;
            case 3:
                $this->global['pageTitle'] = 'CECAITRA: Ordenes Calibración Finalizadas listado';
            break;
        }

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calib', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function parcialesListing() // Listado de parciales.
    {
        $tipo1 = 2402;
        $tipo2 = 2;
        $tipo3 = 1;

        $data['parciales_monoRecords']  = $this->calib_model->parcialesListing($tipo1);
        $data['parciales_multiRecords'] = $this->calib_model->parcialesListing($tipo2);
        $data['parciales_movilRecords'] = $this->calib_model->parcialesListing($tipo3);

        $this->global['pageTitle'] = 'CECAITRA: Numero de Paricales listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('calibraciones/calib_parciales', $data);
        $this->load->view('includes/footer',$this->global);
    }



}

?>
