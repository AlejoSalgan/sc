<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Instalaciones extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('equipos_model');
        $this->load->model('utilidades_model');
        $this->load->model('instalaciones_model');
        $this->load->model('adjuntar_model');
        $this->load->model('municipios_model');
        $this->load->model('user_model');
        $this->load->model('flota_model');
        $this->load->model('mensajes_model');
        $this->load->library('fechas');
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

    function instalaciones_solicitudes()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $opciones = array(0 => 'Todos', 'RE.id' => 'ID',
         'MUN.descrip' => 'Proyecto',
         'RE.direccion' => 'Direccion',
         'ET.descrip' => 'Tipo Equipo',
         'IP.tipo_prioridad' => 'Prioridad',
         'TU.name' => 'Solicitado por',
         'RE.fecha_ts' => 'Fecha');

        $count = $this->instalaciones_model->listadoSolicitudes($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $returns = $this->paginationCompress( "instalaciones_solicitudes/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoSolicitudes($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Solicitudes Relevamiento';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoSolicitudes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Solicitudes de Instalaciones';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/solicitudes', $data);
        $this->load->view('includes/footer',$this->global);
    }







    function ordenes_relevamiento()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $opciones = array(0 => 'Todos', 'RE.id' => 'ID',
         'MUN.descrip' => 'Proyecto',
         'RE.direccion' => 'Direccion',
         'ET.descrip' => 'Tipo Equipo',
         'IP.tipo_prioridad' => 'Prioridad',
         'TU.name' => 'Solicitado por',
         'RE.fecha_ts' => 'Fecha');

        $count = $this->instalaciones_model->listadoRelevamientos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $returns = $this->paginationCompress( "ordenes_relevamiento/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoRelevamientos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Relevamiento';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoSolicitudes('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Ordenes de Relevamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/ordenes_relevamientos', $data);
        $this->load->view('includes/footer',$this->global);
    }







    function finalizadas_relevamiento()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $opciones = array(0 => 'Todos', 'RE.id' => 'ID',
         'MUN.descrip' => 'Proyecto',
         'RE.direccion' => 'Direccion',
         'ET.descrip' => 'Tipo Equipo',
         'IP.tipo_prioridad' => 'Prioridad',
         'TU.name' => 'Solicitado por',
         'RE.fecha_ts' => 'Fecha');

        $count = $this->instalaciones_model->listadoFinalizadas($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $returns = $this->paginationCompress( "finalizadas_relevamiento/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoFinalizadas($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Finalizadas Relevamiento';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoFinalizadas('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Finalizadas de Relevamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/finalizadas_relevamientos', $data);
        $this->load->view('includes/footer',$this->global);
    }




    function ordenes_desintalacion()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(100,120);

        $opciones = array(0 => 'Todos',
         'ID.id' => 'ID',
         'EM.serie' => 'Equipo',
         'MUN.descrip' => 'Proyecto',
         'IP.tipo_prioridad' => 'Prioridad',
         'IE.tipo_estado' => 'Estado',
         'TU.name' => 'Solicitado por',
         'ID.fecha_visita' => 'Fecha Visita'
       );

        $count = $this->instalaciones_model->listadoDesintalacion($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $returns = $this->paginationCompress( "ordenes_desintalacion/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoDesintalacion($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones,$estado);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Desintalacion';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoDesintalacion('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Ordenes de Desintalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/ordenes_desintalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function finalizadas_desintalacion()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(31,50,51);

        $opciones = array(0 => 'Todos',
         'ID.id' => 'ID',
         'EM.serie' => 'Equipo',
         'MUN.descrip' => 'Proyecto',
         'IP.tipo_prioridad' => 'Prioridad',
         'IE.tipo_estado' => 'Estado',
         'TU.name' => 'Solicitado por',
         'ID.fecha_visita' => 'Fecha Visita'
       );

        $count = $this->instalaciones_model->listadoDesintalacion($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $returns = $this->paginationCompress( "finalizadas_desintalacion/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoDesintalacion($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones,$estado);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Finalizadas Desintalacion';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoDesintalacion('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Finalizadas de Desintalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/ordenes_finalizadas_desintalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function solicitudes_instalacion()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $opciones = array(0 => 'Todos',
         'IIG.id' => 'ID',
         'MUN.descrip' => 'Proyecto',
         'IIG.cantidad' => 'Cantidad',
         'IIG.tipo_prioridad' => 'Prioridad',
         'TU.name' => 'Solicitado por',
         'IIG.fecha_solicitacion' => 'Fecha Solicitacion'
       );

        $count = $this->instalaciones_model->listadoSolicitudesInstalacion($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $returns = $this->paginationCompress( "solicitudes_instalacion/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoSolicitudesInstalacion($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Solicitudes Instalacion';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoSolicitudesInstalacion('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Solicitudes de Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/solicitudes_instalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }




    function ordenes_instalacion()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(80,120);

        $opciones = array(0 => 'Todos',
         'ID.id' => 'ID',
         'EM.serie' => 'Equipo',
         'MUN.descrip' => 'Proyecto',
         'ET.descrip' => 'Tipo Equipo',
         'II.direccion' => 'Direccion',
         'II.fecha_limite' => 'Fecha Limite',
         'IE.tipo_estado' => 'Estado'
       );

        $count = $this->instalaciones_model->listadoInstalacion($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $returns = $this->paginationCompress( "ordenes_instalacion/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoInstalacion($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones,$estado);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ordenes Instalacion';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoDesintalacion('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Ordenes de Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/ordenes_instalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function finalizadas_instalacion()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(31,50,51);

        $opciones = array(0 => 'Todos',
         'ID.id' => 'ID',
         'EM.serie' => 'Equipo',
         'MUN.descrip' => 'Proyecto',
         'ET.descrip' => 'Tipo Equipo',
         'II.direccion' => 'Direccion',
         'II.fecha_limite' => 'Fecha Limite',
         'IE.tipo_estado' => 'Estado'
       );

        $count = $this->instalaciones_model->listadoInstalacion($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $returns = $this->paginationCompress( "finalizadas_instalacion/", $count, CANTPAGINA );
        $data['ordenes'] = $this->instalaciones_model->listadoInstalacion($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$opciones,$estado);

        //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Finalizadas Instalacion';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->instalaciones_model->listadoDesintalacion('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$opciones,$estado);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Finalizadas de Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/ordenes_finalizadas_instalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function agregar_solicitud_insalacion()
    {
        $data['tipoItem'] = 'Agregar';

        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['prioridades'] = $this->instalaciones_model->tiposPrioridades();
        $data['tipos_equipo']        = $this->equipos_model->getEquiposTipos();


        $this->global['pageTitle'] = 'CECAITRA: Agregar Solicitud de Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/solicitud_instalacion_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }




    function agregar_nueva_solicitud_instalacion($id_grupo = NULL)
    {
        $data['tipoItem'] = 'Agregar';
        $data['tipos_equipo'] = $this->equipos_model->getEquiposTipos();
        $data['id_grupo'] = $id_grupo;

        $this->global['pageTitle'] = 'CECAITRA: Agregar Solicitud de Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/addEdit_solicitud_instalacion', $data);
        $this->load->view('includes/footer',$this->global);
    }










    function agregar_orden_desintalacion()
    {
        $data['tipoItem'] = 'Agregar';

        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['prioridades'] = $this->instalaciones_model->tiposPrioridades();
        $data['elementos'] = $this->instalaciones_model->getElementos();

        $this->global['pageTitle'] = 'CECAITRA: Agregar Orden de Desinstalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/orden_desintalacion_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function editar_orden_desintalacion($id_orden = NULL)
    {
        $data['tipoItem'] = 'Editar';

        $data['orden'] = $this->instalaciones_model->getOrdenDesintalacion($id_orden);
        $data['elementos_asignados'] = $this->instalaciones_model->getElementosAsignados($id_orden);

        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['prioridades'] = $this->instalaciones_model->tiposPrioridades();
        $data['elementos'] = $this->instalaciones_model->getElementos();

        $this->global['pageTitle'] = 'CECAITRA: Editar Orden de Desinstalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/orden_desintalacion_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }






    function agregar_solicitud()
    {
        $data['tipoItem'] = 'Agregar';

        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['tipos_equipos'] = $this->equipos_model->getEquiposTipos();
        $data['prioridades'] = $this->instalaciones_model->tiposPrioridades();

        $this->global['pageTitle'] = 'CECAITRA: Agregar Solicitud de Instalaciones';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/solicitudes_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function editar_solicitud($id_orden = NULL)
    {
        if($id_orden == NULL){
          $this->session->set_flashdata('error', 'No existe informacion de esta solicitud.');
          redirect('instalaciones_solicitudes');
        }

        $data['solicitud'] = $this->instalaciones_model->getOrden($id_orden);

        if (!$data['solicitud']) {
          $this->session->set_flashdata('error', 'No existe informacion de esta solicitud.');
          redirect('instalaciones_solicitudes');
        }

        $data['tipoItem'] = 'Editar';

        $data['proyectos'] = $this->municipios_model->getProyectos();
        $data['tipos_equipos'] = $this->equipos_model->getEquiposTipos();
        $data['prioridades'] = $this->instalaciones_model->tiposPrioridades();

        $this->global['pageTitle'] = 'CECAITRA: Editar Solicitud de Instalaciones';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/solicitudes_addEdit', $data);
        $this->load->view('includes/footer',$this->global);
    }




    function ver_relevamiento($id_orden = NULL)
    {
        $data['orden'] = $this->instalaciones_model->getOrden($id_orden);

        if ($data['orden']->tipo_orden == 10) {
          $data['link'] = "instalaciones_solicitudes";
          $data['titulo'] = "Solicitudes listado";
        }else {
          $data['link'] = "ordenes_relevamiento";
          $data['titulo'] = "Relevamientos listado";
        }

        $data['eventos'] = $this->instalaciones_model->eventosRelevamientos($id_orden);
        $data['archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'R',1);
        $data['cant_archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'R',1,1);

        $this->global['pageTitle'] = 'CECAITRA: Detalles de Relevamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/relevamientos_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function ver_grupo($id_grupo = NULL)
    {
        $data['grupo'] = $this->instalaciones_model->getGrupoInfo($id_grupo);
        $data['ordenes'] = $this->instalaciones_model->getSolicitudesInstalaciones($id_grupo);

        $this->global['pageTitle'] = 'CECAITRA: Detalles de Relevamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/grupos_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function ver_desintalacion($id_orden = NULL)
    {
        $data['orden'] = $this->instalaciones_model->getOrdenDesintalacion($id_orden);

        if ($data['orden']->tipo_orden == 31) {
          $data['link'] = "ordenes_desintalacion";
          $data['titulo'] = "Desintalacion listado";
        }else {
          $data['link'] = "finalizadas_desintalacion";
          $data['titulo'] = "Desintalacion listado";
        }

        $data['eventos'] = $this->instalaciones_model->eventosDesintalacion($id_orden);
        $data['elementos'] = $this->instalaciones_model->verElementosAsignados($id_orden);
        $data['archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'D',1);
        $data['cant_archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'D',1,1);

        $this->global['pageTitle'] = 'CECAITRA: Detalles de la Desintalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/desintalacion_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }



    function ver_instalacion($id_orden = NULL)
    {
        $data['orden'] = $this->instalaciones_model->getOrdenInstalacion($id_orden);

        $data['link'] = "ordenes_instalacion";
        $data['titulo'] = "Instalacion listado";

        $data['eventos'] = $this->instalaciones_model->eventosInstalacion($id_orden);
        //$data['archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'I',1);
        //$data['cant_archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_orden,'I',1,1);

        $this->global['pageTitle'] = 'CECAITRA: Detalles de la Instalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/instalacion_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function agregar_visitas($id_orden = NULL, $tipo_orden = NULL)
    {
        switch ($tipo_orden) {
          case 'I':
            $data['link'] = "ordenes_instalacion";
            $data['titulo'] = "Instalacion listado";
            $data['tabla_visitas'] = "instalaciones_instalacion_visitas";
            $data['tabla_eventos'] = "instalaciones_instalacion_eventos";
            break;

          case 'R':
            $data['link'] = "ordenes_relevamiento";
            $data['titulo'] = "Relevamiento listado";
            $data['tabla_visitas'] = "instalaciones_relevamiento_visitas";
            $data['tabla_eventos'] = "instalaciones_relevamiento_eventos";

            break;

          case 'D':
            $data['link'] = "ordenes_desintalacion";
            $data['titulo'] = "Desintalacion listado";
            $data['tabla_visitas'] = "instalaciones_desinstalacion_visitas";
            $data['tabla_eventos'] = "instalaciones_desintalacion_eventos";

            break;

          default:
            // code...
            break;
        }

        $rango = array(array(500,599));
        $data['vehiculos'] = $this->flota_model->getVehiculos(4);
        $data['usuarios']  = $this->user_model->getEmpleadosPorSector($rango,11);//Puesto tecnico
        $data['id_orden'] = $id_orden;

        $this->global['pageTitle'] = 'CECAITRA: Agregar visitas';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/agregar_visitas', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function relevamiento_archivos($id_relevamiento = NULL)
    {
        $data['titulo'] = "Relevamientos Adjuntar";
        $data['pagina'] = "Relevamientos listado";
        $data['regreso'] = "ordenes_relevamiento";

        $data['pagina_actual'] = "relevamiento_archivos";
        $data['parametro'] = $id_relevamiento;
        $data['sector'] = "instalaciones";
        $data['tabla'] = "instalaciones_archivos";

        $data['archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_relevamiento,'R',0);
        $data['cant_archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_relevamiento,'R',0,1);

        $data['guardar'] = 'archivo_guardar';
        $data['descargar'] = 'archivo_descargar';
        $data['eliminar'] = 'archivo_eliminar';
        $data['cargar'] = 'archivos_cargar';

        $this->global['pageTitle'] = 'CECAITRA : Archivos Relevamiento';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('archivos/archivos', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function desintalacion_archivos($id_desintalacion = NULL)
    {
        $data['titulo'] = "Desintalacion Adjuntar";
        $data['pagina'] = "Desintalacion listado";
        $data['regreso'] = "ordenes_desintalacion";

        $data['pagina_actual'] = "desintalacion_archivos";
        $data['parametro'] = $id_desintalacion;
        $data['sector'] = "instalaciones";
        $data['tabla'] = "instalaciones_archivos";

        $data['archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_desintalacion,'D',0);
        $data['cant_archivos'] = $this->instalaciones_model->getArchivosInstalaciones($id_desintalacion,'D',0,1);

        $data['guardar'] = 'archivo_guardar';
        $data['descargar'] = 'archivo_descargar';
        $data['eliminar'] = 'archivo_eliminar';
        $data['cargar'] = 'archivos_cargar';

        $this->global['pageTitle'] = 'CECAITRA : Archivos Desintalacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('archivos/archivos', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function verificacion_elementos($id_orden = NULL)
    {
        $data['orden'] = $this->instalaciones_model->getOrdenDesintalacion($id_orden);
        $data['elementos'] = $this->instalaciones_model->verElementosAsignados($id_orden);
        $data['elementos_verificados'] = $this->instalaciones_model->getElementosIDasignados($id_orden,1);

        $this->global['pageTitle'] = 'CECAITRA: Verifiaciaon de Elementos';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('instalaciones/desintalacion_verificacion_elementos', $data);
        $this->load->view('includes/footer',$this->global);
    }




//////////// VISTAS ///////////////


//////////// AJAX ///////////////

function desintalacion_equipos()
{
  $equipos = $this->instalaciones_model->getEquiposDesintalacion($this->input->post('proyecto'));
  echo json_encode($equipos);
}

//////////// AJAX ///////////////

//////////// ACCIONES ///////////////

function agregar_editar_solicitudes()
{
    $idproyecto = $this->input->post('idproyecto');
    $direccion = trim($this->input->post('direccion'));
    $tipo_equipo = $this->input->post('tipo_equipo');
    $prioridad = $this->input->post('prioridad');
    $observaciones = $this->input->post('observacion')?trim($this->input->post('observacion')):"Sin observaciones.";
    $tipoItem = $this->input->post('tipoItem');

    $relevamientoInfo = array(
    'id_proyecto'=>$idproyecto,
    'id_tipo_equipo'=>$tipo_equipo,
    'direccion'=>$direccion,
    'id_prioridad'=>$prioridad,
    'tipo_orden'=>10,
    'estado'=>10,
    'observaciones'=>$observaciones
    );

    $tabla = 'instalaciones_relevamiento_eventos';


    if ($tipoItem == "Agregar") {
      array_push($relevamientoInfo['solicitado_por'] = $this->vendorId);

      $result = $this->instalaciones_model->agregarSolicitud($relevamientoInfo);

      if ($result) {
        $eventoInfo = array('id_orden'=>$result, 'observacion'=>$observaciones, 'id_estado'=>60, 'usuario'=>$this->vendorId);
        $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);
      }

      $success = "Nueva solicitud de Relevamiento agregada correctamente.";
      $error = "Error al agregar solicitud de Relevamiento.";
      $link = "agregar_solicitud";
    } else {

      $id_orden = $this->input->post('id_orden');
      $result = $this->instalaciones_model->editarSolicitud($relevamientoInfo, $id_orden);

      if ($result) {
        $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observaciones, 'id_estado'=>70, 'usuario'=>$this->vendorId);
        $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);
      }

      $success = "Solicitud de Relevamiento editada correctamente.";
      $error = "Error al editar la solicitud de Relevamiento.";
      $link = "instalaciones_solicitudes";
    }

    if($result == TRUE){
      $this->session->set_flashdata('success', $success);
    }else{
      $this->session->set_flashdata('error', $error);
    }

    redirect($link);

}





function agregar_editar_orden_desintalacion()
{
    $idproyecto = $this->input->post('idproyecto');
    $idequipo = $this->input->post('idequipo');
    $idEquipo = $this->input->post('idEquipo');
    $prioridad = $this->input->post('prioridad');
    $observaciones = $this->input->post('observaciones')?trim($this->input->post('observaciones')):"Sin observaciones.";
    $motivo = $this->input->post('motivo')?trim($this->input->post('motivo')):"Sin motivos.";

    if ($idequipo) {
      $id_equipo = $idequipo[0];
    }else {
      $id_equipo = $idEquipo;
    }

    $elementos_detalles = $this->input->post('elementos_detalles')?trim($this->input->post('elementos_detalles')):"Sin detalles.";

    $destino = $this->input->post('destino');
    $destino_detalle = $this->input->post('destino_detalle')?trim($this->input->post('elementos_detalles')):"Sin detalles.";

    $tipoItem = $this->input->post('tipoItem');

    $desintalacionInfo = array(
    'id_equipo'=>$id_equipo,
    'id_proyecto'=>$idproyecto,
    'observaciones'=>$observaciones,
    'motivo'=>$motivo,
    'elementos_detalles'=>$elementos_detalles,
    'destino'=>$destino,
    'destino_detalle'=>$destino_detalle,
    'id_prioridad'=>$prioridad,
    'tipo_orden'=>31,
    'estado'=>100
    );

    if ($tipoItem == "Agregar") {
      array_push($desintalacionInfo['solicitado_por'] = $this->vendorId);
      array_push($desintalacionInfo['fecha_solicitacion'] = date('Y-m-d H:i:s'));

      $result = $this->instalaciones_model->agregarOrdenDesintalacion($desintalacionInfo);

      if ($result) {
        $N = $this->instalaciones_model->ultimoElemento();

        for ($i=1; $i <= $N ; $i++) {
          if ($this->input->post($i)) {
            $elemento = array('id_orden' => $result, 'id_elemento' => $this->input->post($i));
            $this->instalaciones_model->agregarElemento($elemento);
          }
        }

        $eventoInfo = array('id_orden'=>$result, 'observacion'=>$observaciones, 'id_estado'=>100, 'usuario'=>$this->vendorId);
        $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);
      }

      $success = "Nueva Orden de Desintalacion agregada correctamente.";
      $error = "Error al agregar Orden de Desintalacion.";
      $link = "agregar_orden_desintalacion";
    } else {

      $id_orden = $this->input->post('id_orden');
      $result = $this->instalaciones_model->editarDesintalacion($desintalacionInfo, $id_orden);

      if ($result) {
        $this->instalaciones_model->eliminarElementos($id_orden);
        $N = $this->instalaciones_model->ultimoElemento();

        for ($i=1; $i <= $N ; $i++) {
          if ($this->input->post($i)) {
            $elemento = array('id_orden' => $id_orden, 'id_elemento' => $this->input->post($i));
            $this->instalaciones_model->agregarElemento($elemento);
          }
        }

        $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observaciones, 'id_estado'=>70, 'usuario'=>$this->vendorId);
        $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);
      }

      $success = "Orden de Desintalacion editada correctamente.";
      $error = "Error al editar la Orden de Desintalacion.";
      $link = "ordenes_desintalacion";
    }

    if($result == TRUE){
      $this->session->set_flashdata('success', $success);
    }else{
      $this->session->set_flashdata('error', $error);
    }

    redirect($link);

}










  function insta_agregar_observacion() //Agrego las observaciones al remito.
    {
        //Para futuro pasas la tabla de los eventos y el link a donde queres qeu se redireccione.
        $id_orden = $this->input->post('id_orden');
        $link = $this->input->post('link');
        $tabla = $this->input->post('tabla');

        $observacion = trim($this->input->post('observacion'));

        $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>90, 'usuario'=>$this->vendorId);
        $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);

        if($resultado){
            $this->session->set_flashdata('success', 'Nueva observacion agregada correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al agregar observación');
        }
        redirect($link);
    }


    function cancelar_relevamiento() //Agrego las observaciones al remito.
      {
          $id_orden = $this->input->post('id_orden');
          $observacion = trim($this->input->post('observacion'));
          $tabla = 'instalaciones_relevamiento_eventos';
          $link = $this->input->post('link');

          $relevamientoInfo = array('estado'=>50, 'fecha_finalizacion'=> date('Y-m-d H:i:s'));
          $resultado = $this->instalaciones_model->editarSolicitud($relevamientoInfo, $id_orden);

          if($resultado){
              $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>50, 'usuario'=>$this->vendorId);
              $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);

              $this->session->set_flashdata('success', 'Solicitud rechazada correctamente.');
          }else{
              $this->session->set_flashdata('error', 'Error al rechazar la solicitud.');
          }
          redirect($link);
      }


      function aceptar_relevamiento() //Agrego las observaciones al remito.
      {
          //Para futuro pasas la tabla de los eventos y el link a donde queres qeu se redireccione.
          $id_orden = $this->input->post('id_orden');
          $observacion = trim($this->input->post('observacion'));
          $tabla = 'instalaciones_relevamiento_eventos';

          $relevamientoInfo = array('tipo_orden'=>11);
          $resultado = $this->instalaciones_model->editarSolicitud($relevamientoInfo, $id_orden);

          if($resultado){
              $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>80, 'usuario'=>$this->vendorId);
              $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);

              $this->session->set_flashdata('success', 'Solicitud aceptada correctamente en una Orden de Relevamiento.');
          }else{
              $this->session->set_flashdata('error', 'Error al aceptar la solicitud.');
          }
          redirect('instalaciones_solicitudes');
      }


      function finalizar_relevamiento() //Agrego las observaciones al remito.
      {
          $id_orden = $this->input->post('id_orden');
          $observacion = trim($this->input->post('observacion'));
          $estado = $this->input->post('estado');
          $tabla = 'instalaciones_relevamiento_eventos';

          $relevamientoInfo = array('estado'=>$estado, 'fecha_finalizacion'=> date('Y-m-d H:i:s'));
          $resultado = $this->instalaciones_model->editarSolicitud($relevamientoInfo, $id_orden);

          if($resultado){
              $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>$estado, 'usuario'=>$this->vendorId);
              $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);

              $this->session->set_flashdata('success', 'Orden de Relevamiento finalizada correctamente.');
          }else{
              $this->session->set_flashdata('error', 'Error al finalizar la orden de Relevamiento.');
          }
          redirect('ordenes_relevamiento');
      }





      function cancelar_desintalacion() //Agrego las observaciones al remito.
        {
            //Para futuro pasas la tabla de los eventos y el link a donde queres qeu se redireccione.
            $id_orden = $this->input->post('id_orden');
            $observacion = trim($this->input->post('observacion'));
            $link = $this->input->post('link');

            $desintalacionInfo = array('estado'=>50, 'fecha_finalizacion'=> date('Y-m-d H:i:s'));
            $resultado = $this->instalaciones_model->editarDesintalacion($desintalacionInfo, $id_orden);

            if($resultado){
                $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>50, 'usuario'=>$this->vendorId);
                $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);

                $this->session->set_flashdata('success', 'Orden rechazada correctamente.');
            }else{
                $this->session->set_flashdata('error', 'Error al rechazar la orden.');
            }
            redirect($link);
        }




        function insta_enviar_orden($id_orden = NULL)
          {
              $ordenInfo = array('estado'=>120);
              $resultado = $this->instalaciones_model->editarDesintalacion($ordenInfo, $id_orden);

              if($resultado){
                  $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>120, 'usuario'=>$this->vendorId);
                  $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);

                  $this->session->set_flashdata('success', 'Orden enviada correctamente.');
              }else{
                  $this->session->set_flashdata('error', 'Error al enviar la orden.');
              }
              redirect('ordenes_desintalacion');
          }



          //A futuro hacer que esta funcion sea uno solo con la de arriba.
          function insta_enviar_orden2()
            {
              $id_orden = $this->input->post('id_orden');
              $link = $this->input->post('link');
              $tabla_eventos = $this->input->post('tabla_eventos');
              $tabla = $this->input->post('tabla');
              $tipo = $this->input->post('tipo');
              $observaciones_envio = trim($this->input->post('observaciones_envio'));

              $orden = $this->instalaciones_model->getOrdenInstalacion($id_orden);
              $equipo_serie = ($orden->equipo_serie == NULL) ? 'A designar' : $orden->equipo_serie ;

              $nro_msj              = date('Ymd His');
              $tipo_min = strtoupper(substr($tipo, 9, 3));
              $observacion_visita    = str_replace(",", "", $orden->observaciones_visita);
              $observacion_envio    = str_replace(",", "", $observaciones_envio);
              $descrip = "$tipo: $observacion_visita; Nota: $observacion_envio; ***$tipo_min";

              $datos = $id_orden . "," . $orden->fecha_visita. "," . $descrip;

              $mensajesInfo = array('imei'=>$orden->imei, 'tipo'=>"2009", 'codigo'=>$nro_msj, 'equipo'=>$equipo_serie, 'datos'=>$datos, 'fecha_recepcion'=>date('Y-m-d H:i:s'), 'origen'=>1, 'ordenesb_ID'=>$id_orden);

              $result = $this->mensajes_model->addNewMensaje($mensajesInfo);

              if ($result) {
                $ordenInfo = array('estado'=>120, 'nro_msj'=>$nro_msj);
                $resultado = $this->instalaciones_model->editarOrdenGeneral($ordenInfo, $id_orden, $tabla);

                $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>120, 'usuario'=>$this->vendorId);
                $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla_eventos);

                $this->session->set_flashdata('success', 'Se envio correctamente la orden al Tecnico.');
              } else {
                $this->session->set_flashdata('error', 'Error al enviar la orden al Tecnico.');
              }

              redirect($link);
            }

            function finalizar_instalacion()
            {
                $id_orden = $this->input->post('id_orden');
                $observacion = trim($this->input->post('observacion'));
                $tabla = 'instalaciones_instalacion_eventos';

                $instalacionInfo = array('estado'=>31, 'fecha_finalizacion'=> date('Y-m-d H:i:s'));
                $resultado = $this->instalaciones_model->editarInstalacion2($instalacionInfo, $id_orden);

                if($resultado){
                    $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>31, 'usuario'=>$this->vendorId);
                    $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);

                    $this->session->set_flashdata('success', 'Orden de Instalacion finalizada correctamente.');
                }else{
                    $this->session->set_flashdata('error', 'Error al finalizar la orden de Instalacion.');
                }
                redirect('ordenes_instalacion');
            }







          function finalizar_desintalacion() //Agrego las observaciones al remito.
          {
              $id_orden = $this->input->post('id_orden');
              $observacion = trim($this->input->post('observacion'));

              $desintalacionInfo = array('estado'=>31, 'fecha_finalizacion'=> date('Y-m-d H:i:s'));
              $resultado = $this->instalaciones_model->editarDesintalacion($desintalacionInfo, $id_orden);

              if($resultado){
                  $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>31, 'usuario'=>$this->vendorId);
                  $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);

                  $this->session->set_flashdata('success', 'Orden de Desintalacion finalizada correctamente.');
              }else{
                  $this->session->set_flashdata('error', 'Error al finalizar la orden de Desintalacion.');
              }
              redirect('ordenes_desintalacion');
          }



    function reutilizacion_elementos()
    {
        $id_orden = $this->input->post('id_orden');
        $observacion = $this->input->post('observacion');
        $elementos = $this->instalaciones_model->getElementosIDasignados($id_orden);

        $asignacionInfo = array('reutilizacion' => 0);
        $this->instalaciones_model->reiniciarUtilizacionElemento($asignacionInfo,$id_orden);

        for ($i=min($elementos); $i <= max($elementos) ; $i++) {
          if ($this->input->post($i)) {
            $asignacionInfo = array('reutilizacion' => 1);
            $resultado = $this->instalaciones_model->editarAsignacionElemento($asignacionInfo,$this->input->post($i));
          }
        }

        if($resultado){
            $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>130, 'usuario'=>$this->vendorId);
            $resultado = $this->instalaciones_model->addEventoDesintalacion($eventoInfo);

            $this->session->set_flashdata('success', 'Verificacion de elementos correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al verificar elementos.');
        }
        redirect('ordenes_desintalacion');
    }



    function add_solicitud_instalacion()
    {
      $idproyecto = $this->input->post('idproyecto');
      $prioridad = $this->input->post('prioridad');
      $i = 0;

      $grupoInfo = array('id_proyecto'=>$idproyecto, 'id_prioridad'=>$prioridad, 'cantidad'=>0, 'solicitado_por'=>$this->vendorId, 'fecha_solicitacion'=>date('Y-m-d H:i:s'));

      $id_grupo = $this->instalaciones_model->addGrupoInstalacion($grupoInfo);

      if (!$id_grupo) {
        $this->session->set_flashdata('error', 'Error al solicitudes de Instalacion.');
        redirect('agregar_solicitud_insalacion');
      }


      if ($this->input->post('tipo_equipo_1')) {
        $tipo_equipo_1 = $this->input->post('tipo_equipo_1');
        $idequipo_1 = $this->input->post('idequipo_1');
        $fecha_limite_1 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_limite_1'));
        $direccion_1 = $this->input->post('direccion_1');
        $observacion_1 = $this->input->post('observacion_1');

        $ordenInfo = array('tipo_equipo'=>$tipo_equipo_1, 'id_equipo'=>$idequipo_1[0], 'id_grupo'=>$id_grupo, 'fecha_limite'=>$fecha_limite_1, 'direccion'=>$direccion_1, 'observaciones'=>$observacion_1, 'tipo_orden'=>20, 'estado'=>60);

        $resultado = $this->instalaciones_model->addOrdenInstalacion($ordenInfo);
        $i++;
      }


      if ($this->input->post('tipo_equipo_2')) {
        $tipo_equipo_2 = $this->input->post('tipo_equipo_2');
        $idequipo_2 = $this->input->post('idequipo_2');
        $fecha_limite_2 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_limite_2'));
        $direccion_2 = $this->input->post('direccion_2');
        $observacion_2 = $this->input->post('observacion_2');

        $ordenInfo = array('tipo_equipo'=>$tipo_equipo_2, 'id_equipo'=>$idequipo_2[0], 'id_grupo'=>$id_grupo, 'fecha_limite'=>$fecha_limite_2, 'direccion'=>$direccion_2, 'observaciones'=>$observacion_2, 'tipo_orden'=>20, 'estado'=>60);

        $resultado = $this->instalaciones_model->addOrdenInstalacion($ordenInfo);
        $i++;
      }

      if ($this->input->post('tipo_equipo_2')) {
        $tipo_equipo_3 = $this->input->post('tipo_equipo_3');
        $idequipo_3 = $this->input->post('idequipo_3');
        $fecha_limite_3 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_limite_3'));
        $direccion_3 = $this->input->post('direccion_3');
        $observacion_3 = $this->input->post('observacion_3');

        $ordenInfo = array('tipo_equipo'=>$tipo_equipo_3, 'id_equipo'=>$idequipo_3[0], 'id_grupo'=>$id_grupo, 'fecha_limite'=>$fecha_limite_3, 'direccion'=>$direccion_3, 'observaciones'=>$observacion_3, 'tipo_orden'=>20, 'estado'=>60);

        $resultado = $this->instalaciones_model->addOrdenInstalacion($ordenInfo);
        $i++;
      }

      $grupoInfo = array('cantidad'=>$i);
      $this->instalaciones_model->editarGrupoInstalacion($grupoInfo, $id_grupo);

      $this->session->set_flashdata('success', 'Solicitudes de Instalacion agregadas correctamente.');
      redirect('solicitudes_instalacion');

    }




    function aprobar_solicitud_instalacion($id_grupo = NULL) //Agrego las observaciones al remito.
    {

        $grupoInfo = array('aprobado'=>1);
        $instalacionInfo = array('tipo_orden'=>21, 'estado'=>80);

        $resultado = $this->instalaciones_model->editarGrupoInstalacion($grupoInfo, $id_grupo);
        $resultado2 = $this->instalaciones_model->editarInstalacion1($instalacionInfo, $id_grupo);

        if($resultado){
            /*
            $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>80, 'usuario'=>$this->vendorId);
            $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla);
            */

            $this->session->set_flashdata('success', 'Solicitud aceptada correctamente en Ordenes de Instalacion.');
        }else{
            $this->session->set_flashdata('error', 'Error al aceptar las Solicitudes.');
        }
        redirect('solicitudes_instalacion');
    }



    function add_visita_instalacion() //Agrego las observaciones al remito.
    {
        $conductor = $this->input->post('conductor');
        $tecnico = $this->input->post('tecnico');
        $fecha_visita = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
        $vehiculo = $this->input->post('vehiculo');
        $observacion = $this->input->post('observacion');
        $tabla_visitas = $this->input->post('tabla_visitas');
        $tabla_eventos = $this->input->post('tabla_eventos');
        $link = $this->input->post('link');
        $id_orden = $this->input->post('id_orden');

        $visitaInfo = array('id_orden'=>$id_orden, 'conductor'=>$conductor, 'tecnico'=>$tecnico, 'fecha_visita'=>$fecha_visita, 'vehiculo'=>$vehiculo,
        'observacion'=>$observacion, 'creado_por'=>$this->vendorId);

        $resultado = $this->instalaciones_model->addVisita($visitaInfo,$tabla_visitas);


        if($resultado){
            $eventoInfo = array('id_orden'=>$id_orden, 'observacion'=>$observacion, 'id_estado'=>70, 'usuario'=>$this->vendorId);
            $resultado = $this->instalaciones_model->addEvento($eventoInfo,$tabla_eventos);

            $this->session->set_flashdata('success', 'Visita agregada correctamente');
        }else{
            $this->session->set_flashdata('error', 'Error al agregar visitas.');
        }
        redirect($link);
    }







    function addEdit_nueva_solicitud_instalacion()
    {
        $id_grupo = $this->input->post('id_grupo');
        $tipoItem = $this->input->post('tipoItem');

        $tipo_equipo = $this->input->post('tipo_equipo');
        $fecha_limite = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_limite'));
        $direccion = $this->input->post('direccion');
        $observacion = $this->input->post('observacion');

        $ordenInfo = array('tipo_equipo'=>$tipo_equipo, 'id_grupo'=>$id_grupo, 'fecha_limite'=>$fecha_limite, 'direccion'=>$direccion, 'observaciones'=>$observacion, 'tipo_orden'=>20, 'estado'=>60);

        if ($tipoItem == "Agregar") {
          $resultado = $this->instalaciones_model->addOrdenInstalacion($ordenInfo);
          $success = "Soliciutd de Instalacion agregada correctamente.";
          $error = "Error al agregar una Solicitud de Instalacion.";
          $link = 'agregar_nueva_solicitud_instalacion/'.$id_grupo;

          $grupo = $this->instalaciones_model->getGrupoInfo($id_grupo);
          $grupo->cantidad++;
          $grupoInfo = array('cantidad'=>$grupo->cantidad);
          $resultado = $this->instalaciones_model->editarGrupoInstalacion($grupoInfo, $id_grupo);
        } else {
          //$resultado = $this->instalaciones_model->addOrdenInstalacion($ordenInfo);
        }

        if($resultado == TRUE){
          $this->session->set_flashdata('success', $success);
        }else{
          $this->session->set_flashdata('error', $error);
        }

        redirect($link);
    }

    function eliminar_solicitud_instalacion($id_orden = NULL)
    {
      $orden = $this->instalaciones_model->getOrdenInstalacion($id_orden);
      $resultado = $this->instalaciones_model->eliminarSolicitudInstalacion($id_orden);

      if ($resultado) {
        $orden->cantidad--;
        $grupoInfo = array('cantidad'=>$orden->cantidad);
        $this->instalaciones_model->editarGrupoInstalacion($grupoInfo, $orden->id_grupo);

        $this->session->set_flashdata('success', 'Solicitud eliminada correctamente.');
      } else {
        $this->session->set_flashdata('error', 'Error al eliminar Solicitud.');
      }

      redirect('ver_grupo/'.$orden->id_grupo);
    }





}

?>
