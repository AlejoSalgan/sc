<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class protocolos extends BaseController
{
    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('protocolos_model');
        $this->load->model('user_model');
        $this->load->model('ordenesb_model');
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('protocolos_lib'); 
    }

    public function index() //This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos');
        $this->load->view('includes/footer');
    }

//LISTING DE PROTOCOLOS//

    function protocolosListing() //Protocolos prendientes que faltan ingresar.
    {
        $searchText = trim($this->input->get('searchText'));
        $criterio   = $this->input->get('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->protocolos_model->protocolosCount($searchText,"Pendiente",$criterio,$userId, $role);
        $returns = $this->paginationCompress( "protocolosList/", $count, 15 );
        $data['protocolosRecords'] = $this->protocolos_model->protocolosList($searchText,$returns["page"],$returns["segment"],"Pendiente",$criterio,$userId,$role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->protocolos_model->protocolosList('', NULL, NULL, "Pendiente", NULL, $this->session->userdata('userId'),$this->role);

        $this->global['pageTitle'] = 'CECAITRA: Protocolos Pendientes';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_pendientes', $data);
        $this->load->view('includes/footer');
    }

    function protocolosingListing() //Protocolos que fueron ya ingresados.
    {
        $searchText = trim($this->input->get('searchText'));
        $criterio   = $this->input->get('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->protocolos_model->protocolosCount_ing($searchText,"Ingresado",$criterio,$userId, $role);
        $returns = $this->paginationCompress( "protocolosingListing/", $count, 15 );

        $data['protocolosRecords'] = $this->protocolos_model->protocolos_ingresados($searchText, $returns["page"], $returns["segment"],"Ingresado",$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->protocolos_model->protocolos_ingresados('', NULL, NULL, "Pendiente", NULL, $this->session->userdata('userId'),$this->role);

        $this->global['pageTitle'] = 'CECAITRA: Protocolos Ingresados';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_ingresados', $data);
        $this->load->view('includes/footer');
    }

    //Protocolos que fueron generados con cantidad igual a cero.
    function protocolosceroListing()
    {
        $searchText = trim($this->input->get('searchText'));
        $criterio   = $this->input->get('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->protocolos_model->protocolosCount_ceros($searchText,"Cero",$criterio,$userId, $role);
        $returns = $this->paginationCompress( "protocolosceroListing/", $count, 15 );

        $data['protocolosRecords'] = $this->protocolos_model->protocolos_ceros($searchText, $returns["page"], $returns["segment"],"Cero",$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->protocolos_model->protocolos_ceros('', NULL, NULL, "Cero", NULL, $this->session->userdata('userId'),$this->role);

        $this->global['pageTitle'] = 'CECAITRA: Protocolos Ceros';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_ceros', $data);
        $this->load->view('includes/footer');
    }

    function protocolosanuladoListing() //Protocolos que fueron anulados.
    {
        $searchText = trim($this->input->get('searchText'));
        $criterio   = $this->input->get('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->protocolos_model->protocolosCount_anu($searchText,"Anulado",$criterio,$userId, $role);
        $returns = $this->paginationCompress( "protocolosanuladoListing/", $count, 15 );

        $data['protocolosRecords'] = $this->protocolos_model->protocolos_anulados($searchText, $returns["page"], $returns["segment"],"Anulado",$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->protocolos_model->protocolos_anulados('', NULL, NULL, "Anulado", NULL, $this->session->userdata('userId'),$this->role);

        $this->global['pageTitle'] = 'CECAITRA: Protocolos Anulados';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_anulados', $data);
        $this->load->view('includes/footer');
    }

    function grupos_estados() //Detalle de los equipos para ingresar.
    {
        $data['gruposRecords'] = $this->protocolos_model->gruposListing();
        $data['modelos'] = $this->protocolos_model->modelos_pendientes();
        $data['total_modelos'] = $this->protocolos_model->total_modelos();

        $data['aprobar'] = $this->protocolos_model->ordenes_aprobar();


        $this->global['pageTitle'] = 'CECAITRA: Listado de Equipos';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_grupos', $data);
        $this->load->view('includes/footer');
    }


    function decriptos_listado()
    {
      $this->global['pageTitle'] = 'CECAITRA: Protocolos Desencriptando';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('protocolos/decriptos');
      $this->load->view('includes/footer');
    }

    //Listado de protocolos remotos.
    function protocolos_remotos()
    {
      $searchText = $this->input->post('searchText');
      $criterio   = $this->input->post('criterio');
      $data['searchText'] = $searchText;
      $data['criterio']   = $criterio;

      $role   = $this->role;
      $userId = $this->session->userdata('userId');

      $opciones = array('0' => 'Todos', 'PM.id' => 'Protocolo', 'PM.equipo_serie' => 'Equipo', 'MUN.descrip' => 'Proyecto', 'PM.fecha' => 'Fecha Protocolo', 'PM.fecha_inicial_remoto' => 'Fecha Desde', 'PM.fecha_final_remoto' => 'Fecha Hasta', 'PM.cantidad' => 'Archivos');

      $opciones2 = array('PM.fecha' => 'Fecha Protocolo', 'PM.fecha_inicial_remoto' => 'Fecha Desde', 'PM.fecha_final_remoto' => 'Fecha Hasta', 'PM.cantidad' => 'Archivos');

      $resultado_opc = array_diff($opciones,$opciones2);

      $count = $this->protocolos_model->remotosListing($searchText,$criterio,NULL,NULL,$userId, $role,$resultado_opc);
      $returns = $this->paginationCompress( "protocolos_remotos/", $count, 15 );
      $data['protocolos'] = $this->protocolos_model->remotosListing($searchText, $criterio, $returns["page"], $returns["segment"],$userId, $role,$resultado_opc);

      $data['opciones'] = $opciones;
      $data['total'] =  $count;
      $data['total_tabla'] =  $this->protocolos_model->remotosListing('',NULL,NULL,NULL,$userId, $role,$resultado_opc);

      $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

      $this->global['pageTitle'] = 'CECAITRA: Protocolos Remotos';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('protocolos/ingresos_remotos', $data);
      $this->load->view('includes/footer');
    }

    function agregar_remoto()
    {
      $data['municipios'] = $this->municipios_model->proyectosRemotos();

      $this->global['pageTitle'] = 'CECAITRA: Agregar Protocolo Remoto';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('protocolos/agregar_remotos',$data);
      $this->load->view('includes/footer');
    }

    function protocolos_sin_ordenes()
    {
      $data['protocolos'] = $this->protocolos_model->sin_ordenes();

      //die(var_dump($data['protocolos']));
      //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

      $this->global['pageTitle'] = 'CECAITRA: Protocolos sin ordenes';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('protocolos/protocolos_sin_ordenes', $data);
      $this->load->view('includes/footer');
    }


  ////////////////////////////////////////////////

    function addRemoto()
    {
      $proyecto = $this->input->post('idproyecto');
      $idequipo = $this->input->post('idequipo');
      $cantidad = $this->input->post('cantidad');

      $serie = $this->equipos_model->getSerie($idequipo[0]);

      $desde = str_replace('/', '-', $this->input->post('fecha_desde'));
      $fecha_hora_desde =  date('Y-m-d H:i', strtotime($desde));
      $fecha_desde =  date('Y-m-d', strtotime($desde));


      $hasta = str_replace('/', '-', $this->input->post('fecha_hasta'));
      $fecha_hora_hasta =  date('Y-m-d H:i', strtotime($hasta));
      $fecha_hasta =  date('Y-m-d', strtotime($hasta));


      $protocoloInfo = array('municipio' => $proyecto, 'idequipo' => $idequipo[0],'equipo_serie' => $serie, 'fecha' => date('Y-m-d H:i:s'), 'usuario' => $this->vendorId, 'ip' => '', 'nro_msj' => date('Ymd His'), 'estado' => 0,
      'fecha_inicial' => $fecha_desde, 'fecha_final' => $fecha_hasta, 'cantidad' => $cantidad,'tipo_equipo' => '', 'fecha_inicial_remoto' => $fecha_hora_desde, 'fecha_final_remoto' => $fecha_hora_hasta, 'remoto' => 1, 'estado_remoto' => 1, 'estado_exportacion' => 0, 'estado_ush' => 0, 'numero_exportacion' => 0,
      'archivos' => 0, 'registros' => 0, 'entrada' => 0, 'idexportacion' => 0, 'encolar' => 0, 'encolar_prioridad' => 0, 'decripto' => 0, 'incorporacion_estado' => 0, 'incorporacion_fecha' => '0000-00-00 00:00:00');

      $result = $this->protocolos_model->newProtocolo($protocoloInfo);

      if($result == true){
          $this->session->set_flashdata('success', 'Protocolo agregado correctamente.');
      } else {
          $this->session->set_flashdata('error', 'Error al ingresar el protocolo, verifique nuevamente los datos.');
      }

      redirect('agregar_remoto');
    }

// AJAX //

    function protocolos_decripto()
    {
      $data = json_decode(file_get_contents('http://ssti.cecaitra.com/WS/_decripto.php'), true);
      echo json_encode($data['data']);
    }

    function protocolos_registros()
    {
      $protocolo = $this->input->post('protocolo');
      $data = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/_infoProtocolo.php?p=$protocolo"), true);
      echo json_encode($data['data']);
    }

    function protocolos_equipos()
    {
      $equipos = $this->equipos_model->getEquipos($this->input->post('proyecto'),TRUE,1);
      echo json_encode($equipos);
    }


    function equipos_remotos()
    {
      $equipos = $this->equipos_model->getRemotos($this->input->post('proyecto'));
      echo json_encode($equipos);
    }



// AJAX //


//EDITAR PROTOCOLOS//

    function protocolos_editar($ordenesbId = NULL)
    {
        if($ordenesbId == null){
            redirect('protocolosListing');
        }

        $data['ordenesbInfo'] = $this->protocolos_model->getOrdenesbInfo($ordenesbId);

        $this->global['pageTitle'] = 'CECAITRA : Agregar Detalle de Protocolo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_edit', $data);
        $this->load->view('includes/footer');
    }

    function editProtocolos()
    {
        $protocolo = $this->input->post('protocolo');

          $subida_FD   = $this->fechas->cambiaf_a_mysql($this->input->post('subida_FD'));
          $subida_FH   = $this->fechas->cambiaf_a_mysql($this->input->post('subida_FH'));

        if ($this->input->post('subida_cant') == "") {
          $subida_cant = 0;
        } else {
          $subida_cant = $this->input->post('subida_cant');
        }

        $hora_hasta  = $this->input->post('hora_hasta');
        $hora_desde  = $this->input->post('hora_desde');

        if ($subida_FD == NULL) {
            $hora_desde = "00:00:00";
        }

        if ($subida_FH == NULL) {
            $hora_hasta = "00:00:00";
        }

        $hora_desdeC    = strtotime($hora_desde);
        $hora_desdeC    = date("H:i:s", $hora_desdeC);

        $hora_hastaC    = strtotime($hora_hasta);
        $hora_hastaC    = date("H:i:s", $hora_hastaC);

        $subida_fotos   = $this->input->post('subida_fotos');
        $subida_videos  = $this->input->post('subida_videos');
        $subida_fabrica = $this->input->post('subida_fabrica');
        $subida_envios  = $this->input->post('subida_envios');
        $subida_documentos  = $this->input->post('subida_documentos');

        if (trim($this->input->post('subida_errores')) == '') {
            $subida_errores  = NULL;
        } else {
            $subida_errores  = $this->input->post('subida_errores');
        }

        $subida_vencidos  = $this->input->post('subida_vencidos');
        $subida_repetidos = $this->input->post('subida_repetidos');
        $subida_sbd       = $this->input->post('subida_sbd');

        if (trim($this->input->post('subida_ingresados')) == '') {
            $subida_ingresados  = NULL;
        } else {
            $subida_ingresados  = $this->input->post('subida_ingresados');
        }

        $subida_observ = $this->input->post('subida_observ');

        $subida_NFD    = $subida_FD." ".$hora_desdeC;
        $subida_NFH    = $subida_FH." ".$hora_hastaC;


        if ($subida_FD == "") {
          $subida_NFD = NULL;
        } else {
          $subida_NFD  = $subida_FD." ".$hora_desdeC;
        }

        if ($subida_FH == "") {
          $subida_NFH = NULL;
        } else {
          $subida_NFH  = $subida_FH." ".$hora_hastaC;
        }

        $protocolosInfo = array('subida_fotos'=>$subida_fotos, 'subida_videos'=>$subida_videos,'subida_fabrica'=>$subida_fabrica,'subida_envios'=>$subida_envios,'subida_errores'=>$subida_errores,'subida_vencidos'=>$subida_vencidos,'subida_repetidos'=>$subida_repetidos, 'subida_sbd'=>$subida_sbd,'subida_ingresados'=>$subida_ingresados, 'subida_FD'=>$subida_NFD, 'subida_FH'=>$subida_NFH, 'subida_cant'=>$subida_cant,
        'subida_documentos'=>$subida_documentos, 'subida_observ'=>$subida_observ, 'subida_creadopor'=>$this->vendorId, 'subida_fecha'=>date('Y-m-d H:i:s'));

        $result = $this->protocolos_model->editProtocolos($protocolosInfo, $protocolo);

        if($result == true){
            $this->session->set_flashdata('success', 'Protocolo modificado correctamente, listo para finalizarlo.');
        } else {
            $this->session->set_flashdata('error', 'Error al modificar la informacion del protocolo, verifique nuevamente los datos.');
        }

        redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
    }

//VER UN PROTOCOLO//

    function verProtocolos($ordenesbId = NULL)
    {
        if($ordenesbId == null){
            redirect('equiposListing');
        }

        $data['ordenesbInfo'] = $this->protocolos_model->getOrdenesbInfo($ordenesbId);
        $data['eventos'] = $this->protocolos_model->getEventos($ordenesbId);
        $data['errores'] = $this->protocolos_model->getErrores($ordenesbId);

        if($data['ordenesbInfo'][0]->protocolo >= 241395 ){
            $data['protocolo_info'] = $this->protocolos_model->protocolo_info($data['ordenesbInfo'][0]->protocolo);
        }

        $data['tipoItem'] = "Protocolos";
        $data['id_usuario'] = $this->vendorId;

        $this->global['pageTitle'] = 'CECAITRA : Detalle del Protocolo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos_ver', $data);
        $this->load->view('includes/footer');
    }

    function detalle_protocolo()
    {
        $id_protocolo = $this->input->post('protocolo');

        if (!($id_protocolo > 0)) {
            die('No es un numero de Protocolo.');
        }

        $data['protocolo_info'] = $this->protocolos_model->protocolo_info($id_protocolo);
        $data['bajada_info'] = $this->protocolos_model->bajada_info($id_protocolo);


        $this->global['pageTitle'] = 'CECAITRA : Detalle del Protocolo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/detalle_protocolo', $data);
        $this->load->view('includes/footer');
    }

    function anular_protocolo()
    {   
        //Anulo el protocolo desde Ordenesb_main.
        $protocolosInfo = array('subida_activo'=>0, 'subida_estado'=>3, 'subida_observ'=>trim(ucfirst(strtolower($this->input->post('subida_observ')))),'subida_creadopor'=>$this->vendorId, 'subida_fecha'=>date('Y-m-d H:i:s'));

        $result = $this->protocolos_model->editProtocolos($protocolosInfo, $this->input->post('protocolo'));

        if($result){
            $this->session->set_flashdata('success', 'Protocolo anulado correctamente.');

            //Anulo el protocolo desde protocolos_main.
            $protocolo_anulado = array('decripto' =>5, 'incorporacion_estado' =>70, 'estado'=>70);
            $this->protocolos_model->updateProtocolosMain($protocolo_anulado, $this->input->post('protocolo'));
        }else{
            $this->session->set_flashdata('error', 'Error al anular protocolo.');
        }

        redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
    }

    function finalizar_protocolo()
    {
        $protocolo      = $this->input->post('protocolo');
        $subida_observ  = $this->input->post('subida_observ');
        $subida_estado  = $this->input->post('subida_estado');
        $idmodelo      = $this->input->post('idmodelo');

        $protocolosInfo = array('subida_creadopor'=>$this->vendorId, 'subida_fecha'=>date('Y-m-d H:i:s'));

        if ($subida_estado == 2) {
            array_push($protocolosInfo['subida_estado']  = 2);
            array_push($protocolosInfo['subida_observ']  = $subida_observ);
        } else {
            array_push($protocolosInfo['subida_estado']  = $subida_estado);
        }

        $result = $this->protocolos_model->editProtocolos($protocolosInfo, $protocolo);

        if($result == TRUE){
            $this->session->set_flashdata('success', 'Protocolo finalizado correctamente.');

            //Ver si el modelo esta en desencriptacion con una consulta.
            $resultado = $this->protocolos_model->getDesencriptacion($idmodelo);
            
            if($resultado){
                $protocolo_aprobado = array('decripto' =>110);
                $this->protocolos_model->updateProtocolosMain($protocolo_aprobado, $protocolo);
            }
            
        }else{
            $this->session->set_flashdata('error', 'Error al finalizar protocolo.');
        }

        redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
    }



    function anular_remoto()
    {
        //Anulo el protocolo desde Ordenesb_main.
        $protocolosInfo = array('subida_activo'=>0, 'subida_estado'=>3, 'subida_observ'=>trim(ucfirst(strtolower($this->input->post('subida_observ')))),'subida_creadopor'=>$this->vendorId, 'subida_fecha'=>date('Y-m-d H:i:s'));

        $result = $this->protocolos_model->editProtocolos($protocolosInfo, $this->input->post('protocolo'));

        if($result){
            $this->session->set_flashdata('success', 'Protocolo anulado correctamente.');

            //Anulo el protocolo desde protocolos_main.
            $protocolo_anulado = array('decripto' =>5, 'incorporacion_estado' =>70, 'estado'=>70, 'estado_remoto' => 9);
            $this->protocolos_model->updateProtocolosMain($protocolo_anulado, $this->input->post('protocolo'));
        }else{
            $this->session->set_flashdata('error', 'Error al anular protocolo.');
        }

        redirect('protocolos_remotos');
    }



    function decripto_remoto()
    {
        $protocolo     = $this->input->post('protocolo');
        $protocoloInfo = array('decripto' => 1);

        $result = $this->protocolos_model->editRemoto($protocoloInfo, $protocolo);

        if($result == TRUE){
            $this->session->set_flashdata('success', 'Protocolo cambiado de decripto correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al cambiar al decripto protocolo.');
        }

        redirect('protocolos_remotos');
    }


    //Funcion para cambiar el estado del protocolo.
    function estado_protocolo()
    {
        $protocolo     = $this->input->post('protocolo');
        $estado     = $this->input->post('estado');
        $protocoloInfo = array('subida_estado' => $estado);


        $result = $this->protocolos_model->editarProtocolo($protocoloInfo, $protocolo);

        if($result){
            $this->session->set_flashdata('success', 'Protocolo cambiado de estado correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al cambiar el estado del protocolo.');
        }

        redirect('protocolosingListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
    }


    function dividir_protocolo($id_bajada = NULL)
    {
        $bajada = $this->ordenesb_model->getBajada($id_bajada);

        if ($bajada->bajada_archivos < 10001) {
          $this->session->set_flashdata('error', 'Este protocolo es menor a 10000 en archivos.');
          redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
        }

        $serie = $this->equipos_model->getSerie($bajada->idequipo);
        $bajada_cantidad_original = $bajada->bajada_archivos;
        $entera = floor($bajada->bajada_archivos/10000);
        $resto = $bajada->bajada_archivos%10000;

        for ($i=1; $i <= $entera ; $i++) {
          $nro_msj = date('Ymd His');

          $protocoloInfo = array('municipio' => $bajada->idproyecto, 'idequipo' => $bajada->idequipo, 'equipo_serie' => $serie, 'fecha' => $bajada->fecha_procesado, 'usuario' => $bajada->tecnico, 'ip' => $bajada->imei, 'nro_msj' => $nro_msj, 'estado' => 0,
          'fecha_inicial' => $bajada->bajada_desde, 'fecha_final' => $bajada->bajada_hasta, 'cantidad' => 10000, 'tipo_equipo' => '', 'remoto' => 0, 'estado_remoto' => 0, 'estado_exportacion' => 0, 'estado_ush' => 0, 'numero_exportacion' => 0, 'archivos' => 0, 'registros' => 0, 'entrada' => 0, 'idexportacion' => 0, 'encolar' => 0, 'encolar_prioridad' => 0, 'decripto' => 0, 'incorporacion_estado' => 0, 'incorporacion_fecha' => '0000-00-00 00:00:00');

          $id_protocoloMain = $this->protocolos_model->newProtocolo($protocoloInfo);

          $bajada_nueva = array( 'idproyecto' => $bajada->idproyecto, 'idsupervisor' => 46, 'iddominio' => $bajada->iddominio, 'conductor' => $bajada->conductor, 'tecnico' => $bajada->tecnico, 'idequipo' => $bajada->idequipo, 'fecha_visita' => $bajada->fecha_visita, 'descrip' => $bajada->descrip,
          'creadopor' => 229, 'fecha_alta' => $bajada->fecha_alta, 'fecha_baja' => $bajada->idfecha_bajaequipo, 'activo' => $bajada->activo, 'eliminado' => $bajada->eliminado, 'seriado' => $bajada->seriado, 'imei' => $bajada->imei, 'protocolo' => $id_protocoloMain,
          'bajada_fecha' => $bajada->bajada_fecha, 'bajada_lat' => $bajada->bajada_lat, 'bajada_long' => $bajada->bajada_long, 'bajada_tiempo' => $bajada->bajada_tiempo, 'bajada_sat' => $bajada->bajada_sat, 'bajada_archivos' => 10000, 'bajada_desde' => $bajada->bajada_desde, 'bajada_hasta' => $bajada->bajada_hasta,
          'bajada_observ' => $bajada->bajada_observ, 'subida_estado' => 0, 'subida_activo' => 1, 'subida_fecha' => '0000-00-00 00:00:00', 'enviado' => 1, 'enviado_fecha' => $bajada->enviado_fecha, 'ack' => $bajada->ack, 'nro_msj' => $nro_msj, 'recibido' => 1,
          'recibido_fecha' => $bajada->recibido_fecha, 'ord_procesado' => $bajada->ord_procesado, 'procesado_fecha' => '0000-00-00 00:00:00', 'transferidos_estado' => $bajada->transferidos_estado, 'transferido_tipo' => $bajada->transferido_tipo);

          $result = $this->ordenesb_model->addNewOrdenesb($bajada_nueva);
          sleep(2);
        }

        $bajada_info = array('bajada_archivos' => $resto, 'protocolo_dividido' => 1, 'bajada_cantidad_original' => $bajada_cantidad_original);
        $result = $this->ordenesb_model->editOrdenesb($bajada_info, $id_bajada);

        $this->session->set_flashdata('success', 'Protocolo divido correctamente.');
        redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));

    }


    function enlazar_protocolo($id_bajada = NULL)
    {
        $bajada = $this->ordenesb_model->getBajada($id_bajada);
        $result = $this->protocolos_model->protocolo999($bajada->idequipo);

        if($result){
            $this->session->set_flashdata('success', 'Protocolo enlazado correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al enlazar el protocolo.');
        }

        redirect('protocolosListing'."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio'));
    }




    function orden_remota()
    {
        $protocolo     = $this->input->post('protocolo');
        $remoto = $this->protocolos_model->getProtocoloRemoto($protocolo);

        $ordenbInfo = array(
        'idproyecto' => $remoto->idproyecto,
        'idsupervisor' => NULL,
        'iddominio' => NULL,
        'conductor' => NULL,
        'tecnico' => NULL,
        'idequipo' => $remoto->idequipo,
        'fecha_visita' => $remoto->fecha_protocolo,
        'descrip' => 'Bajada remota',
        'creadopor' => $remoto->usuario,
        'fecha_alta' => $remoto->fecha_protocolo,
        'fecha_baja' => NULL,
        'activo' => 1,
        'eliminado' => 0,
        'seriado' => 1,
        'imei' => NULL,
        'protocolo' => $remoto->protocolo,
        'protocolo_dividido' => 0,
        'bajada_cantidad_original' => NULL,
        'bajada_fecha' => $remoto->fecha_protocolo,
        'bajada_lat' => NULL,
        'bajada_long' => NULL,
        'bajada_tiempo' => NULL,
        'bajada_sat' => NULL,
        'bajada_archivos' => $remoto->cantidad,
        'bajada_desde' => $remoto->fecha_inicial_remoto,
        'bajada_hasta' => $remoto->fecha_final_remoto,
        'bajada_observ' => NULL,
        'bajada_transferidos' => NULL,
        'transferidos_MRM' => NULL,
        'transferido_tipo' => 2,
        'transferidos_estado' => 20,
        'transferido_por' => $remoto->usuario,
        'transferido_fecha' => $remoto->fecha_protocolo,
        'transferido_modo' => 0,
        'subida_repetidos' => 0,
        'subida_sbd' => NULL,
        'subida_errores' => 0,
        'subida_envios' => NULL,
        'subida_vencidos' => NULL,
        'subida_fotos' => $remoto->cantidad,
        'subida_videos' => NULL,
        'subida_fabrica' => NULL,
        'subida_ingresados' => $remoto->cantidad,
        'subida_documentos' => NULL,
        'subida_FD' => NULL,
        'subida_FH' => NULL,
        'subida_cant' => NULL,
        'subida_observ' => NULL,
        'subida_estado' => 1,
        'subida_activo' => 1,
        'subida_creadopor' => $remoto->usuario,
        'subida_fecha' => '0000-00-00 00:00:00',
        'enviado' => NULL,
        'enviado_fecha' => NULL,
        'ack' => date('Y-m-d H:i:s'),
        'nro_msj' => $remoto->nro_msj,
        'recibido' => NULL,
        'recibido_fecha' => NULL,
        'ord_procesado' => 1,
        'procesado_fecha' => '0000-00-00 00:00:00'
       );

        $result = $this->ordenesb_model->addNewOrdenesb($ordenbInfo);

        if($result){
            $this->session->set_flashdata('success', 'Orden creada correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al crear la Orden');
        }

        redirect('protocolos_sin_ordenes');
    }

























    function protocolos_generados()
    {
        if ($this->vendorId != 105 && $this->vendorId != 27 && $this->vendorId != 103 && $this->vendorId != 219 && $this->vendorId != 68) {
            redirect('dashboard');
        }
        
        if ($this->input->post('fecha')) {
            $data['fecha'] = $this->input->post('fecha');
            $fechaProtocolos = $this->protocolos_model->Sql_FechaOrdenesb($data['fecha']);
            $fechaOrdenes = $this->protocolos_model->sql_fechaProtocolos($data['fecha']);
            $data['bajadas'] = $this->protocolos_lib->get_UnificoConsultas($fechaProtocolos,$fechaOrdenes);
        }

        $this->global['pageTitle'] = 'CECAITRA : Protocolos Generados';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/consuta_fechaBajada', $data);
        $this->load->view('includes/footer');
    }

  
    
    function protocolos_cruzados()
    {
        if ($this->vendorId != 105 && $this->vendorId != 27 && $this->vendorId != 103 && $this->vendorId != 219 && $this->vendorId != 68) {
            redirect('dashboard');
        }

        $idequipo = $this->input->post('idequipo');
    
        if ($idequipo != NULL) {
            $data1 = $this->protocolos_model->get_Protocolosmain($idequipo);
            $data2 = $this->protocolos_model->get_ordenebmain($idequipo);
            $data['idequipo'] = $this->ordenesb_model->bajadas_equipo($idequipo);
            $data['protocolosM'] = $this->protocolos_lib->get_difProtocolob($data1,$data2);
            $data['Ordenesb'] = $this->protocolos_lib->get_difProtocolob($data2,$data1);
            $data['noconsecutivosPro'] = $this->protocolos_lib->get_noConsecutivoProtocolosb($data1);
            $data['noconsecutivosOrd'] = $this->protocolos_lib->get_noConsecutivoOrdenesb($data2);
            $data['nocorrelaticoPro'] = $this->protocolos_lib->get_FechasNoconsecutivasProtob($data1);
            $data['nocorrelaticoOrd'] = $this->protocolos_lib->get_FechasNoconsecutivasOrdenesb($data2);
        }

        $this->global['pageTitle'] = 'CECAITRA : Protocolos Cruzados';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/enlazar_protocolo', $data);
        $this->load->view('includes/footer');
    }    

    function acomodar_protocolo()
    {
        $protocolo = $this->input->post('protocolo2');
        $id_orden = $this->input->post('id_orden');
       
        $result = $this->protocolos_model->get_actualizaProtocolosCruzados($protocolo,$id_orden);

        if($result != TRUE){
            $this->session->set_flashdata('error', 'Error al actualizar el numero de protocolo.');
            redirect('protocolos_cruzados');
        }
        
        $this->session->set_flashdata('success', "La orden Nº $id_orden fue actualizada con el numero de protocolo $protocolo.");
        redirect('protocolos_cruzados');
    }








}

?>
