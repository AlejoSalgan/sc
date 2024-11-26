<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Ordenesb extends BaseController
{

    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('ordenesb_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('flota_model');
        $this->load->model('mensajes_model');
        $this->load->model('historial_model');
        $this->load->model('municipios_model');
        $this->load->model('utilidades_model');
        $this->load->model('calib_model');

        $this->load->library('pagination');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('form_validation');
    }

    public function index() //This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas');
        $this->load->view('includes/footer');
    }

//LISTING DE BAJADA DE MEMORIA

    function ordenesbListing() //Ordenes de bajada de memoria que fueron creadas.
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "Ordenes";
        $tipo = "Ordenes";

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$userId, $role);
        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );

        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$userId, $role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');
    }

    //Ordenes de bajada de memoria que fueron enviadas pero no recibieron al celular.
    function ordenesbSRListing()
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "Recibir";
        $tipo = "SR";

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$userId, $role);
        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );

        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$userId, $role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');

    }

    function ordenesbSPListing() //Ordenes de bajada de memoria que no fueron procesadas por el tecnico.
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "SP";
        $tipo = "SP";

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$userId, $role);

        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );

        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$userId, $role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$userId, $role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');

    }

    function ordenesbProcListing() //Ordenes de bajada de memoria que fueron procesadas.
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "Procesado";
        $tipo = "Procesado";

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$userId, $role);

        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );

        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$userId, $role);

        $userId = $this->session->userdata('userId');

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$userId, $role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');

    }

    function ordenesAnuladas() //Ordenes de bajada de memoria que fueron procesadas.
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "Anulado";
        $tipo = "Anulado";

        $role   = $this->role;
        $userId = $this->session->userdata('userId');

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$userId, $role);
        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );

        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$userId, $role);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$userId, $role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');

    }

    //Ordenes de bajada de memoria que fueron procesadas fuera del cerco y como resultado tienen protocolo cero.
    function ordenesCero()
    {
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $data['tipoItem'] = "Cero";
        $tipo = "Cero";

        $count = $this->ordenesb_model->ordenesCount($searchText,$tipo,$criterio,$this->session->userdata('userId'), $this->role);
        $returns = $this->paginationCompress( "ordenesList/", $count, 15 );
        $data['ordenesbRecords'] = $this->ordenesb_model->ordenesList($searchText, $returns["page"], $returns["segment"], $tipo,$criterio,$this->session->userdata('userId'), $this->role);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->ordenesb_model->ordenesCount('',$tipo,NULL,$this->session->userdata('userId'), $this->role);

        $this->global['pageTitle'] = 'CECAITRA: Ordenes Retiro de Memorias listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas', $data);
        $this->load->view('includes/footer');

    }
//GRUPOS DE BAJADA//

    function gruposSE() //Grupos de bajada de memoria indicando los que no se enviaron.
    {
        $data['gruposRecords'] = $this->ordenesb_model->gruposListing(NULL,NULL,0);
        $data['gruposSR'] = $this->ordenesb_model->gruposListing(1,NULL,0);
        $data['gruposSP'] = $this->ordenesb_model->gruposListing(1,1,0);
        //$data['gruposRecords2'] = $this->ordenesb_model->gruposListing2(NULL,NULL,2);

        $data['cantidad_sinEnviar'] = count($data['gruposRecords']);
        $data['cantidad_sinRecibir'] = count($data['gruposSR']);
        $data['cantidad_sinProcesar'] = count($data['gruposSP']);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA: Grupos de Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_grupos', $data);
        $this->load->view('includes/footer');
    }

/*
    function gruposSR() //Grupos de bajada de memoria indicando los que no se recibieron.
    {
        if($this->isAdmin() == TRUE OR $this->isBajada() OR $this->isIngreso())
        {
            $data['tipoItem'] = "GSR"; //Grupo Sin Recibir.
            $data['gruposRecords'] = $this->ordenesb_model->gruposListing2(NULL,1,0);

            $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

            $this->global['pageTitle'] = 'CECAITRA: Grupos de Bajada de Memoria';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('bajadas_grupos', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            $this->loadThis();
        }
    }


    function gruposSP() //Grupos de bajada de memoria indicando la cantidad de equipos restantes por proyecto.
    {
        if($this->isAdmin() == TRUE OR $this->isBajada() OR $this->isIngreso())
        {
            $data['tipoItem'] = "GSP"; //Grupo Sin Procesar.
            $data['gruposRecords'] = $this->ordenesb_model->gruposListing2(1,1,0);

            $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

            $this->global['pageTitle'] = 'CECAITRA: Grupos de Bajada de Memoria';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('bajadas_grupos', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            $this->loadThis();
        }
    }


    function gruposPFC() //Grupos de bajada de memoria indicando la cantidad de equipos restantes por proyecto.
    {
        if($this->isAdmin() == TRUE OR $this->isBajada() OR $this->isIngreso() )
        {
            $data['tipoItem'] = "GPC"; //Grupo Cerco.
            $data['gruposRecords'] = $this->ordenesb_model->gruposListing2(1,1,2);

            $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

            $this->global['pageTitle'] = 'CECAITRA: Grupos de Bajada de Memoria';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('bajadas_grupos', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            $this->loadThis();
        }
    }
    */

    //Conservo esta funcion para mejorar la que esta abajo. POR FAVOR NO BORRAR
    /*
    function grupos_equipos($orden_min, $orden_max)
    {
        $data['grupos_equipos'] = $this->ordenesb_model->equipos_imprimir($orden_min,$orden_max);

        if ($orden_min != $orden_max) {
          $data['total_equipos'] = ($orden_max - $orden_min) + 1;
          $data['nro_orden'] = (string)$orden_min." AL ".(string)$orden_max;
        } else {
          $data['total_equipos'] = 1;
          $data['nro_orden'] = $orden_min;
        }

        $data['cant_pag'] = ceil(($data['total_equipos']+2)/6);

        $this->global['pageTitle'] = 'CECAITRA: Orden de Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_gruposEquipos', $data);
        $this->load->view('includes/footer');
    }
    */

    function grupos_equipos($recibido, $tecnico,$idproyecto,$fecha_visita)
    {
        $data['grupos_equipos'] = $this->ordenesb_model->grupos_equipos($recibido, $tecnico,$idproyecto,$fecha_visita,0);
        $data['total_equipos']  = $this->ordenesb_model->grupos_equipos($recibido, $tecnico,$idproyecto,$fecha_visita,1);
        $data['grupo_datos']  = $this->ordenesb_model->grupos_equipos($recibido, $tecnico,$idproyecto,$fecha_visita,2);

        $data['nro_orden'] = (string)$data['grupo_datos']->id." AL ".(string)($data['grupo_datos']->id + $data['total_equipos'] - 1);
        $data['cant_pag'] = ceil(($data['total_equipos']+2)/6);

        $this->global['pageTitle'] = 'CECAITRA: Orden de Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_gruposEquipos', $data);
        $this->load->view('includes/footer');
    }

    function grupos_edit($recibido, $tecnico,$idproyecto,$fecha_visita)
    {
        $data['empleados']    = $this->user_model->getEmpleados(603);
        $data['supervisores'] = $this->user_model->getEmpleados(602);
        $tipos = array(1,3);
        $data['vehiculos']    = $this->flota_model->getVehiculos($tipos); //destino 1.- "bajada de memoria" 3.- "Mantenimiento"

        $data['grupos_equiposRecords'] = $this->ordenesb_model->grupos_equipos($recibido, $tecnico,$idproyecto,$fecha_visita);

        $this->global['pageTitle'] = 'CECAITRA : Editar Ordenes Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_gruposEditOrdenes', $data);
        $this->load->view('includes/footer');
    }

    function gruposEditAprob() // Edita todas las ordenes de un proyecto agrupado.
    {
        $recibido         = $this->input->post('recibido');
        $tecnico_Old      = $this->input->post('tecnico_Old');
        $idproyecto       = $this->input->post('idproyecto');
        $fecha_visita_Old = $this->input->post('fecha_visita_Old');

        $iddominio        = $this->input->post('iddominio');
        $conductor        = $this->input->post('conductor');
        $tecnico          = $this->input->post('tecnico');
        $fecha_visita     = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
        $imei             = $this->user_model->getIMEI($tecnico);

        $bajadas = $this->ordenesb_model->grupos_equipos($recibido,$tecnico_Old,$idproyecto,$fecha_visita_Old);

        if (!$bajadas) {
            redirect('gruposSE');
        }

        foreach ($bajadas as $bajada) {
            $ordenesbInfo = array('iddominio'=>$iddominio,'conductor'=>$conductor,'tecnico'=>$tecnico,'fecha_visita'=>$fecha_visita,'imei'=>$imei );

            $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $bajada->id);
        }

        if ($result > 0) {
            echo(json_encode(array('status'=>$result)));
        } else {
            echo(json_encode(array('status'=>$result)));
        }

        redirect('gruposSE');
    }

    function cancelarEnvOrdenesG($recibido,$tecnico,$idproyecto,$fecha_visita) //Cancelar el envio de todos los equipos de un proyecto.
    {
        $recibido     = $this->uri->segment(2);
        $tecnico      = $this->uri->segment(3);
        $idproyecto   = $this->uri->segment(4);
        $fecha_visita = $this->uri->segment(5);
        $bajadas      = $this->ordenesb_model->grupos_equipos($recibido,$tecnico,$idproyecto,$fecha_visita);

        $imei         = $this->user_model->getIMEI($tecnico);
        $tipo         = "3010";
        $equipo       = "Borrar Registro";
        $origen       = 1;
        $intentos     = 0;
        $estado       = 0;

        if (!$bajadas) {
            redirect('gruposSE');
        }

        foreach ($bajadas as $bajada) {
            $ordenesbInfo = array('enviado'=>NULL, 'recibido'=>NULL, 'enviado_fecha'=>NULL, 'recibido_fecha'=>NULL, 'nro_msj'=>"");

            $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $bajada->id);
            $result2 = $this->mensajes_model->deleteMensaje($bajada->id);

            $codigo       = date('Ymd His');
            $datos        = $bajada->nro_msj;

            $mensajesInfo = array('imei'=>$imei,
            'tipo'=>$tipo,
            'codigo'=>$codigo,
            'equipo'=>$equipo,
            'datos'=>$datos,
            'origen'=>$origen,
            'intentos'=>$intentos,
            'estado'=>$estado,
            'fecha_recepcion'=>date('Y-m-d'));

            $result2 = $this->mensajes_model->addNewMensaje($mensajesInfo);
            sleep(2);
        }

        if ($result > 0) {
                echo(json_encode(array('status'=>$result)));
            } else {
                echo(json_encode(array('status'=>$result)));
            }

        if ($result2 > 0) {
                echo(json_encode(array('status'=>$result2)));
            } else {
                echo(json_encode(array('status'=>$result2)));
            }

        redirect('gruposSE');
    }

    function enviarTodo($tecnico,$idproyecto,$fecha_visita) //Envia todas las ordenes al celular del tecnico.
    {
        $recibido     = 0;
        $tecnico      = $this->uri->segment(2);
        $idproyecto   = $this->uri->segment(3);
        $fecha_visita = $this->uri->segment(4);

        $bajadas      = $this->ordenesb_model->grupos_equipos($recibido,$tecnico,$idproyecto,$fecha_visita);

        foreach($bajadas as $bajada)
        {
            $imei                 = $bajada->imei;
            $tipo_msj             = "2002";
            $origen               = 1;
            $enviado              = 1;
            $nro_msj              = date('Ymd His');// . "-" . $nroazar;
            $equipoSerie          = $bajada->equipoSerie;
            $fecha_alta           = $bajada->fecha_alta;
            $descrip              = str_replace(",", "", $bajada->descrip);
            $datos                = $bajada->id . "," . $bajada->fecha_visita. "," . $descrip;

            //Guardar datos de las ordenes
            $ordenesbInfo = array('nro_msj'=>$nro_msj,'enviado'=>$enviado,'enviado_fecha'=>date('Y-m-d H:i:s'));

            //Guardar datos mensajes
            $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen,'ordenesb_ID'=>$bajada->id);
            $result = $this->mensajes_model->addNewMensajeTransac($mensajesInfo, $ordenesbInfo, $bajada->id);

            sleep(2);
        }

        echo json_encode(array('status'=>$result));
    }

//AGREGAR UNA NUEVA ORDEN DE BAJADA//

    function agregar_orden()
    {
        if ($this->role == 99) { //
          $data['superadmins'] = $this->user_model->getEmpleados(99);
          $proyecto = NULL;
          $bajada = NULL;
        } else {
          $proyecto = 1;
          $bajada = 1;
        }

        $data['municipios'] = $this->municipios_model->getMunicipios(NULL,NULL,NULL,$proyecto,$bajada);
        $data['empleados']  = $this->ordenesb_model->getPersonal(603);

        $tipos = array(1,3); // 1:Bajada de memoria, 3: Mantenimiento.
        $data['vehiculos'] = $this->flota_model->getVehiculos($tipos);
        $data['tipoItem'] = "Agregar";

     		$this->global['pageTitle'] = 'CECAITRA : Crear Orden Bajada de Memoria';
    		$this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
    		$this->load->view('bajadas_AddEditOrdenes', $data);
    		$this->load->view('includes/footer');
    }

//EDITAR UNA ORDEN DE BAJADA//

    function editar_orden($ordenesbId = NULL)
    {
        if($ordenesbId == NULL){
            redirect('ordenesbListing');
        }

        $data['municipios']   = $this->municipios_model->getMunicipios();
        $data['empleados']    = $this->ordenesb_model->getPersonal(603);
        $tipos = array(1,3); // 1:Bajada de memoria, 3: Mantenimiento.
        $data['vehiculos'] = $this->flota_model->getVehiculos($tipos);

        $data['ordenesbInfo'] = $this->ordenesb_model->getOrdenesbInfo($ordenesbId);

        if ($this->role == 99) {
          $data['superadmins'] = $this->user_model->getEmpleados(99);
        }

        $data['tipoItem'] = "Editar";

        $this->global['pageTitle'] = 'CECAITRA : Editar Orden Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_AddEditOrdenes', $data);
        $this->load->view('includes/footer');
    }

    function agregar_editar_ordenes()
    {
        $tipoItem   = $this->input->post('tipoItem');

        $fecha_visita = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
        $idproyecto   = $this->input->post('idproyecto');
        $idequipo     = $this->input->post('idequipo');
        $conductor    = $this->input->post('conductor');
        $tecnico      = $this->input->post('tecnico');
        $imei         = $this->user_model->getIMEI($tecnico);
        $iddominio    = $this->input->post('iddominio');
        $descrip      = trim( $this->input->post('descrip'))==''?'Sin observaciones':trim($this->input->post('descrip'));

        if ($tipoItem == "Agregar") {
            $count = 0;
            $count2 = 0;

            foreach ($idequipo as $key => $equipo) {
                $idequipo1 = $equipo;

                $ordenesbNew = array('idproyecto'=>$idproyecto, 'descrip'=>$descrip, 'idsupervisor'=> 46, 'iddominio'=>$iddominio, 'conductor'=>$conductor, 'tecnico'=>$tecnico, 'fecha_visita'=>$fecha_visita, 'idequipo'=>$idequipo1, 'imei'=>$imei, 'ord_procesado'=> 0,'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

                $infoEquipo = $this->equipos_model->getEquipoInfo($idequipo1);

              if ($infoEquipo[0]->operativo == 1 || $this->role == 99) {
                  $result = $this->ordenesb_model->addNewOrdenesb($ordenesbNew);

                  if($result > 0){
                      $count++;
                      $detalle = "Orden de bajada de memoria Nº <a href=\"" . base_url('verOrdenb/'.$result) . "\">" . $result. "</a>";

                      $historialNew = array('idequipo'=>$equipo,'idcomponente'=> 0,'idevento'=> 0,'idestado'=> 0,'origen'=> "BAJADA",'tipo'=> "ALTA",'detalle'=> $detalle,'creadopor'=> $this->vendorId,'fecha'=> date('Y-m-d H:i:sa'));

                      $result2 = $this->historial_model->addHistorial($historialNew);
                  }
                } else {
                  $serie = $this->equipos_model->getSerie($idequipo1);
                  $count2++;
                  $info .= $serie." - ";
                }
            }

            $success = ($count == 1) ? "Nueva orden creada correctamente." : "Nuevas ordenes creadas correctamente.";
            $error   = ($count == 1) ? "Error al crear Ordenes Bajada de Memoria." : "Error al crear Orden Bajada de Memoria.";
            $link = 'agregar_orden';

        } else {
            $ordenesbId = $this->input->post('ordenesbId');

            $ordenesbInfo = array(
            'fecha_visita'=>$fecha_visita,
            'conductor'=>$conductor,
            'tecnico'=>$tecnico,
            'iddominio'=>$iddominio,
            'descrip'=>$descrip,
            'idsupervisor'=>46, //cesar Melgarejo.
            'imei'=>$imei,
            'activo'=>1);

            $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $ordenesbId);

            $success = "Orden editada correctamente.";
            $error   = "Error al editar Orden Bajada de Memoria.";
            $link    = 'ordenesbListing';
        }

        if($result > 0){
            $this->session->set_flashdata('success', $success);
        } else{
            $this->session->set_flashdata('error', $error);

        }

        if ($count2 > 0) {
          $this->session->set_flashdata('info', "Los siguientes equipos no se crearon ordenes: ".$info);
        }

        redirect($link);
    }

//VER UNA ORDEN DE BAJADA//

    function verOrdenb($ordenesbId = NULL)
    {
        if($ordenesbId == null){
            redirect('equiposListing');
        }

        $data['bajada'] = $this->ordenesb_model->getBajada($ordenesbId);

        if (($data['bajada']->ord_procesado == 0 || $data['bajada']->ord_procesado == 2) && $data['bajada']->enviado == NULL && $data['bajada']->recibido == NULL && $data['bajada']->activo == 1) {
          $data['color'] = "primary";
          $data['estado'] = "Orden sin enviar";
          $data['orden_estado'] = 10;

        } elseif ($data['bajada']->enviado == 1 && $data['bajada']->recibido == NULL && $data['bajada']->ord_procesado == 0 && $data['bajada']->activo == 1) {
          $data['color'] = "warning";
          $data['estado'] = "Orden sin recibir";
          $data['orden_estado'] = 20;

        } elseif ($data['bajada']->enviado == 1 && $data['bajada']->recibido == 1 && $data['bajada']->ord_procesado == 0 && $data['bajada']->activo == 1) {
          $data['color'] = "warning";
          $data['estado'] = "Orden sin procesar, en espera de recibir informacion del tecnico";
          $data['orden_estado'] = 30;

        } elseif (($data['bajada']->ord_procesado == 1 || $data['bajada']->ord_procesado == 2) && $data['bajada']->enviado == 1 && $data['bajada']->recibido == 1 && $data['bajada']->protocolo > 0 && $data['bajada']->activo == 1) {
          $data['color'] = "success";
          $data['estado'] = "Orden procesada";
          $data['orden_estado'] = 40;

        } elseif ($data['bajada']->activo == 0) {
          $data['color'] = "danger";
          $data['estado'] = "Orden anulada";
          $data['orden_estado'] = 0;

        } elseif (($data['bajada']->ord_procesado == 1 || $data['bajada']->ord_procesado == 2) && $data['bajada']->enviado == 1 && $data['bajada']->recibido == 1 && $data['bajada']->protocolo == 0 && $data['bajada']->activo == 1) {
          $data['color'] = "warning";
          $data['estado'] = "Orden procesada fuera del cerco";
          $data['orden_estado'] = 45;
        }

        if ($data['orden_estado'] >= 40) {
          if ($data['bajada']->bajada_lat != 0 || $data['bajada']->bajada_long != 0) {
            $data['distancia'] = $this->utilidades_model->distance($data['bajada']->geo_lat, $data['bajada']->geo_lon, $data['bajada']->bajada_lat, $data['bajada']->bajada_long);
          } else {
            $data['distancia'] = NULL;
          }

        }

        $data['roleId'] = $this->role;

        $this->global['pageTitle'] = 'CECAITRA : Detalle Orden Bajada de Memoria';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('bajadas_ver', $data);
        $this->load->view('includes/footer');
    }

//ACCIONES DE UNA ORDEN

    function anularOrden() //Desactivar una orden de bajada.
    {
        $idOrden  = $this->input->post('idOrden');
        $idEquipo = $this->input->post('idEquipo');
        $observ   = $this->input->post('observ');

        $ordenesbInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'descrip'=>$observ ,'fecha_baja'=>date('Y-m-d H:i:s'), 'idEquipo'=>$idEquipo);

        $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $idOrden);

        if($result == TRUE){
            $this->session->set_flashdata('success', 'Orden desactivada correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al desactivar orden.');
        }

        redirect('ordenesbListing');
    }

    function limpiarCelular() //Borra la base de datos de un telefono.
    {
        $imei   = $this->input->post('celularid');

        $tipo         = "3009";
        $codigo       = date('Ymd His');
        $equipo       = "Borrar Tablas";
        $datos        = "1,1,0,1,0,0"; // Borra las tablas
        $origen       = 1;
        $intentos     = 0;
        $estado       = 0;

        $mensajesInfo = array('imei'=>$imei,
            'tipo'=>$tipo,
            'codigo'=>$codigo,
            'equipo'=>$equipo,
            'datos'=>$datos,
            'origen'=>$origen,
            'intentos'=>$intentos,
            'estado'=>$estado,
            'fecha_recepcion'=>date('Y-m-d'));

        $result = $this->mensajes_model->addNewMensaje($mensajesInfo);

        if ($result = true) {
                echo(json_encode(array('status'=>$result)));
            } else {
                echo(json_encode(array('status'=>$result)));
            }

        redirect('limpiezaCelulares');
    }

    function cancelarEnvOrdenesb() //Cancelar una orden de bajada para volver a enviar o reasignar.
    {
        $ordenesbId   = $this->input->post('ordenesbId');
        $ordenesbInfo = array('enviado'=>NULL, 'recibido'=>NULL, 'enviado_fecha'=>NULL, 'recibido_fecha'=>NULL, 'nro_msj'=>"");

        $data['ordenesbInfo'] = $this->ordenesb_model->getOrdenesbEnvio($ordenesbId);

        $result = $this->ordenesb_model->editOrdenesb($ordenesbInfo,$ordenesbId);
        $result2 = $this->mensajes_model->deleteMensaje($ordenesbId);

        //borrar la orden en el celular / APP
        $imei                 = $data['ordenesbInfo'][0]->imei;
        $tipo_msj             = "3010";
        $nro_msj              = date('Ymd His');
        $equipoSerie          = "Borrar Registro";
        $datos                = $data['ordenesbInfo'][0]->nro_msj;
        $fecha_alta           = date('Y-m-d H:i:s');
        $origen               = 1;

        $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen, 'ordenesb_ID'=>$ordenesbId);
        $result3 = $this->mensajes_model->addNewMensaje($mensajesInfo);

        if ($result > 0 AND $result2 > 0)
          { echo(json_encode(array('status'=>$result))); }
        else { echo(json_encode(array('status'=>$result))); }
    }

//ENVIAR ORDENES AL CELULAR//

    function enviarOrdenesb()
    {
        $ordenesbId           = $this->input->post('ordenesbId');
        $data['ordenesbInfo'] = $this->ordenesb_model->getOrdenesbEnvio($ordenesbId);
        $imei                 = $data['ordenesbInfo'][0]->imei;
        $tipo_msj             = "2002";
        $origen               = 1;
        $enviado              = 1;
        //$nroazar            = str_pad((string)rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $nro_msj              = date('Ymd His');// . "-" . $nroazar;
        $equipoSerie          = $data['ordenesbInfo'][0]->equipoSerie;
        $fecha_alta           = $data['ordenesbInfo'][0]->fecha_alta;
        $descrip              = str_replace(",", "", $data['ordenesbInfo'][0]->descrip);
        $datos                = $data['ordenesbInfo'][0]->id . "," . $data['ordenesbInfo'][0]->fecha_visita. "," . $descrip;
        //$cadena         = $imei . "|" . $tipo_msj . "|" . $nro_msj . "|" . $equipoSerie . "|" . $datos;


        /*
        //enviar orden al servidor
        $postdata = http_build_query(
            array(
                'cadena' => $cadena
            )
        );
        $opts = array('http' =>
                            array(
                                'method'  => 'POST',
                                'header'  => 'Content-type: application/x-www-form-urlencoded',
                                'content' => $postdata
                            )
                    );
        $context = stream_context_create($opts);
        $result = FALSE;
        $enviado = 0;
        do { //mientras no responda TRUE
            $enviado++;
            $result = file_get_contents('http://stock.cecaitra.com/app/appcecaitra.php', false, $context);
        } while ($result == FALSE);
        */

        //guardar datos ordenes
        $ordenesbInfo = array('nro_msj'=>$nro_msj,'enviado'=>$enviado,'enviado_fecha'=>date('Y-m-d H:i:s'));
        //$result1 = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $ordenesbId);

        //guardar datos mensajes
        $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen, 'ordenesb_ID'=>$ordenesbId);
        $result2 = $this->mensajes_model->addNewMensajeTransac($mensajesInfo, $ordenesbInfo, $ordenesbId);

            if ($result2 > 0) {
              echo(json_encode(array('status'=>$result)));
            } else {
              echo(json_encode(array('status'=>$result)));
            }
    }

    /*function enviarTodo() //Esta funcion no se esta utilizando. Se reacondiciono para usarla en enviar por grupo.
    {
        $sinenviar = $this->ordenesb_model->getSinEnviar(); //obtener todas las ordenes que no se enviaron
        foreach($sinenviar as $row)
        {
            $ordenesbId           = $row->id;
            $data['ordenesbInfo'] = $this->ordenesb_model->getOrdenesbEnvio($ordenesbId);
            $imei                 = $data['ordenesbInfo'][0]->imei;
            $tipo_msj             = "2002";
            $origen               = 1;
            $enviado              = 1;
            //$nroazar            = str_pad((string)rand(0, 9999), 4, "0", STR_PAD_LEFT);
            $nro_msj              = date('Ymd His');// . "-" . $nroazar;
            $equipoSerie          = $data['ordenesbInfo'][0]->equipoSerie;
            $fecha_alta           = $data['ordenesbInfo'][0]->fecha_alta;
            $descrip              = str_replace(",", "", $data['ordenesbInfo'][0]->descrip);
            $datos                = $data['ordenesbInfo'][0]->id . "," . $data['ordenesbInfo'][0]->fecha_visita. "," . $descrip;

            //guardar datos ordenes
            $ordenesbInfo = array('nro_msj'=>$nro_msj,'enviado'=>$enviado,'enviado_fecha'=>date('Y-m-d H:i:s'));
            $result1 = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $ordenesbId);

            //guardar datos mensajes
            $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen);
            $result2 = $this->mensajes_model->addNewMensaje($mensajesInfo);
        }

        if ($result1 > 0) { echo(json_encode(array('status'=>$result))); }
        else { echo(json_encode(array('status'=>$result))); }

    }*/

//LISTA DE EQUIPOS//

  function bajada_enlazar_orden()
  {
    if ($this->vendorId != 105 && $this->vendorId != 27 && $this->vendorId != 146 && $this->vendorId != 38 && $this->vendorId != 277 && $this->vendorId != 68) {
      redirect('dashboard');
    }

    $data['proyectos'] = $this->municipios_model->getProyectos();

    $protocolo = $this->input->post('protocolo');
    $idequipo = $this->input->post('idequipo');

    if ($protocolo) {
      $data['protocolo_unico'] = $this->ordenesb_model->protocolo_unico($protocolo);
      $data['protocolos'] = $this->ordenesb_model->protocolos_equipo($idequipo[0]);
      $data['ordenes'] = $this->ordenesb_model->bajadas_equipo($idequipo[0]);
      $data['equipo'] = $this->equipos_model->getSerie($idequipo[0]);
    }

    $this->global['pageTitle'] = 'CECAITRA : Enlazar Ordenes de bajada';
    $this->load->view('includes/header', $this->global);
    $this->load->view('includes/menu', $this->menu);
    $this->load->view('bajada/enlazar_orden', $data);
    $this->load->view('includes/footer');

  }

// VISTAS //



// ACCIONES


  function actualizar_orden()
  {
    $protocolo = $this->input->post('protocolo2');
    $id_orden = $this->input->post('id_orden');

    $ordenesbInfo = array('protocolo' => $protocolo);

    $result1 = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $id_orden);

    if($result1 != TRUE){
        $this->session->set_flashdata('error', 'Error al actualizar la orden.');
        redirect('bajada_enlazar_orden');
    }

    $result2 = $this->ordenesb_model->protocolo_nro_msj($protocolo);

    if($result2 != TRUE){
        $this->session->set_flashdata('error', 'Error al actualizar el numero de mensaje.');
        redirect('bajada_enlazar_orden');
    }

    $result3 = $this->ordenesb_model->actualizar_datos($id_orden);

    if($result3 != TRUE){
        $this->session->set_flashdata('error', 'Error al actualizar el numero de mensaje.');
        redirect('bajada_enlazar_orden');
    }

    $this->session->set_flashdata('success', "La orden Nº $id_orden fue actualizada correctamente.");
    redirect('bajada_enlazar_orden');
  }


//AJAX

    function equiposajax()
    {
    	if ($this->input->post('proyecto')) {
        if ($this->role != 99) {
          $operativo = 1;
        }
        $equiposCalibrar = $this->calib_model->getEquiposCalibrar(1);
    		$equipos = $this->equipos_model->getEquipos($this->input->post('proyecto'),TRUE,$operativo,$equiposCalibrar);
    		echo json_encode($equipos);
    	} else {
    		show_404();
    	}
    }


    function equipos_enlace()
    {
    		$equipos = $this->ordenesb_model->equipos_enlazar($this->input->post('proyecto'));
    		echo json_encode($equipos);
    }




    function liberar_bajada($id_tecnico,$liberado)
    {
        if (!in_array($this->vendorId, array(27,103,105,140,219))) {
          $this->session->set_flashdata('error', 'No estas autorizazdo.');
          redirect('limpiezaCelulares');
        }

        if ($liberado == 1) {
          $liberado = 0;
          $success = "Telefono bloqueado correctamente.";
          $error = "Error al bloquear el telefono.";
        } else {
          $liberado = 1;
          $success = "Telefono liberado correctamente.";
          $error = "Error al liberar el telefono.";
        }

        $userInfo = array('liberado' => $liberado);
        $result = $this->user_model->editUser($userInfo, $id_tecnico);

        if ($result) {
          $this->session->set_flashdata('success', $success);
        }else{
          $this->session->set_flashdata('error', $error);
        }

        redirect('limpiezaCelulares');
    }










}

?>
