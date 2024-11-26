<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Equipos extends BaseController
{

    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('equipos_model');
        $this->load->model('eventos_model');
        $this->load->model('flota_model');
        $this->load->model('user_model');
        $this->load->model('municipios_model');
        $this->load->model('dashboard_model');
        $this->load->model('historial_model');
        $this->load->model('ordenes_model');
        $this->load->model('mail_model');
        $this->load->model('estados_model');
        $this->load->model('calib_model');
        $this->load->model('ordenesb_model');
        $this->load->model('adjuntar_model');
        $this->load->model('deposito_model');
        $this->load->library('export_excel');
        $this->load->library('fechas');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }


    public function index() // This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos');
        $this->load->view('includes/footer');
    }


    function equiposListing() // Trae todos los equipos en un listado.
    {
        $searchText = trim($this->input->post('searchText'));
        $criterio   = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;

        $searchNum = $this->input->post('searchNum');
        $columna   = $this->input->post('columna');
        $evento    = $this->input->post('evento');
        $calib     = $this->input->post('calib');

        if ($this->input->post('fecha')) {
            $fecha = new DateTime(date());
            $fecha->sub(new DateInterval('P7D'));
            $fecha = $fecha->format('Y-m-d H:i:s');
        }

        $cantPorPag = (strlen($columna) > 0) ? 999999 : 15; //Hardcode por el Franciso Araujo

        $data['roleUser'] = $this->role;
        $rol = $this->role;
        $userId = $this->session->userdata('userId');

        //Esto ya no se usa ver en un futuro de sacarlo
        $grupoGestor = $this->user_model->getGrupoUser($userId);

        $count  = $this->equipos_model->equiposListingCount($searchText, $searchNum, $columna,$criterio,$evento, $userId, $rol, $calib, $grupoGestor, $fecha);

        $returns = $this->paginationCompress( "equiposListing/", $count, $cantPorPag );

        $data['equiposRecords'] = $this->equipos_model->equiposListing($searchText, $returns["page"], $returns["segment"], $searchNum, $columna,$criterio,$evento, $userId, $rol,$calib,$grupoGestor,$fecha);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);
        echo "XXXXXXXXXXXXXXXXXXXX1CONTROLEr:PHP<br>";
        var_dump($data['permisosInfo']);
        echo "<br>";

        $data['eventos'] = $this->eventos_model->getEventos('E');
        $tipo = array('T','E'); //T-Todos y E- Equipos.
        $data['estados'] = $this->estados_model->getEstados($tipo,1);

        //Esto ya no se usa ver en un futuro de sacarlo.
        $rango = array(array(100,110));
        $data['usuarios']  = $this->user_model->getEmpleadosPorSector($rango);

        $data['total'] =  $count;
        $data['total_tabla'] =  $this->equipos_model->equiposListingCount('', '', '',$criterio,NULL, $userId, $rol, '', NULL, '');

        $this->global['pageTitle'] = 'CECAITRA: Equipos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos/equipos', $data);
        $this->load->view('includes/footer');
    }


    function agregar_equipo() // Carga la vista de agregar un equipo.
    {
        $data['tipos']        = $this->equipos_model->getEquiposTipos();
        $data['marcas']       = $this->equipos_model->getEquiposMarcas();
        $data['modelos']      = $this->equipos_model->getEquiposModelos();
        $data['municipios']   = $this->municipios_model->getMunicipios();
        $data['propietarios'] = $this->equipos_model->getEquiposPropietarios();
        $data['estados']      = $this->equipos_model->getEstados();
        $tipo = array('T'); //T-Todos y E- Equipos.
        $data['estados'] = $this->estados_model->getEstados($tipo,1);
        $data['vehiculos'] = $this->flota_model->getVehiculos(5); //destino 5.- "Proyectos"

        $data['tipoItem'] = "Agregar";

        $this->global['pageTitle'] = 'CECAITRA : Agregar equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos/equipos_AddEdit', $data);
        $this->load->view('includes/footer');
    }


    function addNewEquipo()  // Funcion para guardar un nuevo equipo
    {
        $this->form_validation->set_rules("serie","Serie","trim|required|max_length[20]|xss_clean|is_unique[equipos_main.serie]");
        //si no lo es mostramos un mensaje con set_message
        $this->form_validation->set_message('is_unique', 'El equipo ya existe. Los datos no se ingresaron.');

        if($this->form_validation->run() == FALSE){
            $this->agregar_equipo();
        } else {
            $modelo              = $this->input->post('modelo');
            $serie               = strtoupper( $this->input->post('serie') );
            $marca               = $this->input->post('marca');
            $tipo                = $this->input->post('tipo');
            $municipio           = $this->input->post('municipio');
            $idpropietario       = $this->input->post('propietario');
            $remito              = trim( $this->input->post('remito'));
            $pedido              = trim( $this->input->post('pedido'));
            $ordencompra         = trim( $this->input->post('ordencompra'));
            $vehiculoasig        = $this->input->post('vehiculoasig');
            $observ              = trim( $this->input->post('observ'));
            $estado              = 1;
            $evento_actual       = 10;

            $lt = array(1,2,400,2402,2407,2412);
            if (in_array($tipo, $lt)) {
                $requiere_calib = 1;
                $doc_certif          = "Primitiva";
            } else {
                $requiere_calib = 0;
                $doc_certif          = "No requiere";
            }

            if ($this->isAdmin() == TRUE) {
                $decriptador  = trim( $this->input->post('decriptador') );
                $exportable   = $this->input->post('exportable');
                $serie_int    = trim( $this->input->post('serie_int'));
                $ejido_urbano = trim( $this->input->post('ejido_urbano'));

                switch ($tipo) {
                    case 1:
                        $multicarril = 0;
                        break;
                    case 2402:
                        $multicarril = 1;
                        break;
                    default:
                        $multicarril = $this->input->post('multicarril');
                        break;
                }

                $ubicacion_calle     = $this->input->post('ubicacion_calle');
                $ubicacion_altura    = $this->input->post('ubicacion_altura');
                $ubicacion_mano      = $this->input->post('ubicacion_mano');
                $ubicacion_sentido   = $this->input->post('ubicacion_sentido');
                $ubicacion_localidad = $this->input->post('ubicacion_localidad');
                $ubicacion_cp        = $this->input->post('ubicacion_cp');
                $ubicacion_velper    = $this->input->post('ubicacion_velper');
                $velocidad_min    = $this->input->post('velocidad_min');
                $geo_lat             = $this->input->post('geo_lat');
                $geo_lon             = $this->input->post('geo_lon');

                if ($geo_lat != '' || $geo_lat != NULL) {
                  if ($geo_lat > -21.350556) {
                    $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la latitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');
                    redirect('agregar_equipo');

                  } elseif ($geo_lat < -55.165957) {
                    $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la latitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

                    redirect('agregar_equipo');
                  }
                }

                if ($geo_lon != '' || $geo_lon != NULL) {
                  if ($geo_lon < -72.623017) {
                    $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la longitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

                    redirect('agregar_equipo');

                  } elseif ($geo_lon > -53.232825) {
                    $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la longitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

                    redirect('agregar_equipo');
                  }
                }


                $doc_aprob           = $this->input->post('doc_aprob');
                $doc_normasic        = $this->input->post('doc_normasic');
                $doc_distancia       = $this->input->post('doc_distancia');
                $ftp_host            = $this->input->post('ftp_host');
                $ftp_user            = $this->input->post('ftp_user');
                $ftp_pass            = $this->input->post('ftp_pass');

                $equipoNew = array('serie'=>$serie, 'municipio'=>$municipio, 'decriptador'=>$decriptador, 'exportable'=> $exportable,'tipo'=>$tipo,'marca'=>$marca,'idmodelo'=>$modelo,'serie_int'=>$serie_int,'requiere_calib'=>$requiere_calib,'remito'=>$remito,'ejido_urbano'=>$ejido_urbano,'observ'=>$observ, 'creadopor'=>$this->vendorId, 'falta'=>date('Y-m-d H:i:s'), 'fecha_alta'=>date('Y-m-d H:i:s'),'idpropietario'=>$idpropietario,'estado'=>$estado, 'evento_actual'=>$evento_actual, 'vehiculoasig'=>$vehiculoasig, 'multicarril'=>$multicarril, 'ubicacion_calle'=>$ubicacion_calle,'ubicacion_altura'=>$ubicacion_altura,'ubicacion_mano'=>$ubicacion_mano,'ubicacion_sentido'=>$ubicacion_sentido,'ubicacion_localidad'=>$ubicacion_localidad,'ubicacion_cp'=>$ubicacion_cp,'ubicacion_velper'=>$ubicacion_velper,'velocidad_min'=>$velocidad_min,'geo_lat'=>$geo_lat,'geo_lon'=>$geo_lon,'doc_certif'=>$doc_certif,'doc_aprob'=>$doc_aprob,'doc_normasic'=>$doc_normasic,'doc_distancia'=>$doc_distancia,'ftp_host'=>$ftp_host,'ftp_user'=>$ftp_user,'ftp_pass'=>$ftp_pass,'pedido'=>$pedido,'ordencompra'=>$ordencompra);

            } elseif ($this->isAdmin() == FALSE) {
                $equipoNew = array('serie'=>$serie, 'municipio'=>$municipio, 'tipo'=>$tipo, 'marca'=>$marca,'idmodelo'=>$modelo,'requiere_calib'=>$requiere_calib,'remito'=>$remito,'observ'=>$observ, 'creadopor'=>$this->vendorId, 'falta'=>date('Y-m-d H:i:s'), 'fecha_alta'=>date('Y-m-d H:i:s'),'idpropietario'=>$idpropietario,'estado'=>$estado, 'evento_actual'=>$evento_actual, 'vehiculoasig'=>$vehiculoasig, 'pedido'=>$pedido,'ordencompra'=>$ordencompra);
            }

            $result = $this->equipos_model->addNewEquipo($equipoNew);

            if ($vehiculoasig != NULL) {
                $idproyecto         = $this->input->post('municipio');
                $dominio            = $this->flota_model->getDominio($vehiculoasig);

                if ($idproyecto != 0 && $dominio != NULL ) {
                    $flota_asigNew = array('dominio'=>$dominio, 'idproyecto'=>$idproyecto);
                    $this->flota_model->addNewFlotaAsig($flota_asigNew);
                }
            }

            if($result > 0) {
                //Historial
                $idequipo       = $result;
                $idcomponente   = 0;
                $idevento       = 10; //Ingreso al sistema va a depósito
                $idestado       = 1; //Alta va a depósito
                $origen         = "EQUIPOS";
                $tipo_historial = "ALTA";
                $detalle        = "Ingreso al Sistema"; //mantengo la observ tipeada: "Ingreso al Sistema";

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'origen'=>$origen, 'tipo'=>$tipo_historial, 'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

                $result = $this->historial_model->addHistorial($historialNew);
                //Fin Historial

                $remitoInfo = array(
                    'id_equipo'=>$idequipo,
                    'id_proyecto'=>$municipio,
                    'id_orden'=>NULL,
                    'categoria'=>0,
                    'estado'=>10,
                    'creado_por'=>$this->vendorId,
                    'ts_creado'=>date('Y-m-d H:i:s')
                );

                $resultDeposito = $this->deposito_model->agregarRemito($remitoInfo);

                //Busco los datos para armar el mail
                $datos_mail = $this->mail_model->mail_config(6);

                //Buscar los que quieran recibir una
                $mails_to = $this->mail_model->mail_gral(6,1);
                $mails_cc = $this->mail_model->mail_gral(6,2);
                $mails_cco = $this->mail_model->mail_gral(6,3);

                $resultado = $this->mail_model->mail_enviado($datos_mail,$mails_to,$mails_cc,$mails_cco,$serie,$municipio);

                $this->session->set_flashdata('success', 'Equipo ingresado correctamente. Aceptar el ingreso en Deposito.');

            } else {
                $this->session->set_flashdata('error', 'Error al ingresar equipo.');
            }

            redirect('agregar_equipo');
        }
    }


    function editar_equipo($equipoId = NULL) //Carga la vista para editar un equipo.
    {
        if($equipoId == null){
            redirect('equiposListing');
        }

        $data['tipos']        = $this->equipos_model->getEquiposTipos();
        $data['marcas']       = $this->equipos_model->getEquiposMarcas();
        $data['modelos']      = $this->equipos_model->getEquiposModelos();
        $data['municipios']   = $this->municipios_model->getMunicipios();
        $data['propietarios'] = $this->equipos_model->getEquiposPropietarios();
        $tipo = array('T','E'); //T-Todos y E- Equipos.
        $data['estados'] = $this->estados_model->getEstados($tipo,1);
        $data['vehiculos']    = $this->flota_model->getVehiculos(5); //destino 5.- "proyecto"

        $data['equipoInfo']      = $this->equipos_model->getEquipoInfo($equipoId);

      //die(var_dump($data['equipoInfo'] ));
        $data['componentesInfo'] = $this->equipos_model->getEquipoComponentes($equipoId);

        $data['tipoItem'] = "Editar";

        $this->global['pageTitle'] = 'CECAITRA : Editar Equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos/equipos_AddEdit', $data);
        $this->load->view('includes/footer');
    }


    function editEquipo() //Funcion para guardar un equipo cuando esta por editar
    {
        $equipoId = $this->input->post('equipoId');
        $serie    = $this->input->post('serie');

        //$this->form_validation->set_rules('remito','remito','trim|required|max_length[50]|xss_clean');
        //$this->form_validation->set_rules('vehiculoasig','vehiculoasig','trim|required|max_length[50]|xss_clean');

        /*if($this->form_validation->run() == FALSE)
         {
         $this->editOldEquipo($equipoId);
         }
         else
         { */

        //Detalles
        $modelo        = $this->input->post('modelo');
        $marca         = $this->input->post('marca');
        $tipo          = $this->input->post('tipo');
        $municipio     = $this->input->post('municipio');
        $idpropietario = $this->input->post('propietario');
        $estado        = $this->input->post('estado');
        $vehiculoasig  = $this->input->post('vehiculoasig');

        if ($vehiculoasig == 0) {
            $vehiculoasig = NULL;
        }

        //SSGG
        $remito      = trim( $this->input->post('remito'));
        $pedido      = trim( $this->input->post('pedido'));
        $ordencompra = trim( $this->input->post('ordencompra'));
        $observ      = trim( $this->input->post('observ'));
        if ($observ == NULL) {
            $observ = "Sin observaciones.";
        }

        //Ubicacion
        $ubicacion_calle     = $this->input->post('ubicacion_calle');
        $ubicacion_altura    = $this->input->post('ubicacion_altura');
        //$ubicacion_mano      = $this->input->post('ubicacion_mano');
        $ubicacion_sentido   = $this->input->post('ubicacion_sentido');
        $ubicacion_localidad = $this->input->post('ubicacion_localidad');
        $ubicacion_cp        = $this->input->post('ubicacion_cp');
        $ejido_urbano        = trim( $this->input->post('ejido_urbano'));
        $geo_lat             = $this->input->post('geo_lat');
        $geo_lon             = $this->input->post('geo_lon');

        if ($geo_lat != '' || $geo_lat != NULL) {
          if ($geo_lat > -21.350556) {
            $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la latitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');
            redirect('editar_equipo/'.$equipoId);

          } elseif ($geo_lat < -55.165957) {
            $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la latitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

            redirect('editar_equipo/'.$equipoId);
          }
        }

        if ($geo_lon != '' || $geo_lon != NULL) {
          if ($geo_lon < -72.623017) {
            $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la longitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

            redirect('editar_equipo/'.$equipoId);

          } elseif ($geo_lon > -53.232825) {
            $this->session->set_flashdata('error', 'Las coordenadas ingresadas para la longitud no corresponden al territorio Argentino, revisar simbolo menos y la cantidad de digitos');

            redirect('editar_equipo/'.$equipoId);
          }
        }

        //Calibración
        $ubicacion_velper    = $this->input->post('ubicacion_velper');
        $velocidad_min    = $this->input->post('velocidad_min');

        switch ($tipo) {
            case 1:
                $multicarril  = 0;
                break;
            case 2402:
                $multicarril  = 1;
                break;
            default:
                $multicarril  = $this->input->post('multicarril');
                break;
        }
        $carril_1       = $this->input->post('carril_1');
        $carril_2       = $this->input->post('carril_2');
        $carril_3       = $this->input->post('carril_3');
        $carril_4       = $this->input->post('carril_4');
        $carril_5       = $this->input->post('carril_5');
        $carril_6       = $this->input->post('carril_6');
        $carril_sentido = $carril_1.",".$carril_2.",".$carril_3.",".$carril_4.",".$carril_5.",".$carril_6;

        /*switch ($multicarril) {
         case 1:
         $carril_1       = $this->input->post('carril_1');
         $carril_sentido = $carril_1;
         break;

         case 2:
         $carril_1       = $this->input->post('carril_1');
         $carril_2       = $this->input->post('carril_2');
         $carril_sentido = $carril_1.",".$carril_2;
         break;

         case 3:
         $carril_1       = $this->input->post('carril_1');
         $carril_2       = $this->input->post('carril_2');
         $carril_3       = $this->input->post('carril_3');
         $carril_sentido = $carril_1.",".$carril_2.",".$carril_3;
         break;
         }*/

        $lt = array(1,2,400,2402,2407,2412);
        if (in_array($tipo, $lt)) {
            $requiere_calib = 1;
        } else {
            $requiere_calib = 0;
        }

        //al pasar a no calibrar elimino rastro de fechas de calibración
        if ($requiere_calib != 1 ){
            $equipoInfo['doc_fechacal'] = "0000-00-00";
            $equipoInfo['doc_fechavto'] = "0000-00-00";
        }

        $doc_fechacal = $this->fechas->cambiaf_a_mysql($this->input->post('doc_fechacal'));
        $doc_fechavto = $this->fechas->cambiaf_a_mysql($this->input->post('doc_fechavto'));
        $doc_informe  = $this->input->post('doc_informe');
        $nro_ot       = trim( $this->input->post('nro_ot'));

        if ($doc_fechacal == NULL) {
            $doc_fechacal = '0000-00-00';
        }

        if ($doc_fechavto == NULL) {
            $doc_fechavto = '0000-00-00';
        }

        $doc_certif    = $this->input->post('doc_certif');
        $doc_aprob     = $this->input->post('doc_aprob');
        $doc_normasic  = $this->input->post('doc_normasic');
        $doc_distancia = $this->input->post('doc_distancia');

        //Desencriptacion
        $serie_int   = trim( $this->input->post('serie_int'));
        $decriptador = $this->input->post('decriptador');
        $exportable  = $this->input->post('exportable');

        //Datos FTP
        $ftp_host = $this->input->post('ftp_host');
        $ftp_user = $this->input->post('ftp_user');
        $ftp_pass = $this->input->post('ftp_pass');

        $infoAnt = $this->equipos_model->getEquipoInfo($equipoId); //Trae la información anterior del equipo antes de actualizarla para comparar con la actual.

        if ($this->isAdmin() == TRUE) {
            $equipoInfo = array('idmodelo'=>$modelo, 'marca'=>$marca, 'tipo'=>$tipo, 'municipio'=>$municipio, 'idpropietario'=>$idpropietario, 'estado'=>$estado, 'vehiculoasig'=>$vehiculoasig, 'ubicacion_velper'=>$ubicacion_velper, 'multicarril'=>$multicarril, 'carril_sentido'=>$carril_sentido, 'observ'=>$observ, 'velocidad_min'=>$velocidad_min,
                'ubicacion_calle'=>$ubicacion_calle,'ubicacion_altura'=>$ubicacion_altura, 'ubicacion_sentido'=>$ubicacion_sentido,'ubicacion_localidad'=>$ubicacion_localidad,'ubicacion_cp'=>$ubicacion_cp, 'ejido_urbano'=>$ejido_urbano, 'geo_lat'=>$geo_lat,'geo_lon'=>$geo_lon,
                'remito'=>$remito, 'requiere_calib'=>$requiere_calib, 'pedido'=>$pedido, 'ordencompra'=>$ordencompra, 'doc_fechacal'=>$doc_fechacal, 'doc_fechavto'=>$doc_fechavto, 'doc_informe'=>$doc_informe, 'nro_ot'=>$nro_ot, 'doc_certif'=>$doc_certif,'doc_aprob'=>$doc_aprob,'doc_normasic'=>$doc_normasic,'doc_distancia'=>$doc_distancia,
                'serie_int'=>$serie_int,'decriptador'=>$decriptador, 'exportable'=>$exportable,
                'ftp_host'=>$ftp_host,'ftp_user'=>$ftp_user,'ftp_pass'=>$ftp_pass);

        } elseif ($this->isSSGG() == TRUE || $this->isDeposito() == TRUE) {
            $equipoInfo = array('idmodelo'=>$modelo, 'marca'=>$marca, 'tipo'=>$tipo, 'municipio'=>$municipio, 'idpropietario'=>$idpropietario, 'estado'=>$estado, 'vehiculoasig'=>$vehiculoasig, 'requiere_calib'=>$requiere_calib,
                'remito'=>$remito, 'pedido'=>$pedido, 'ordencompra'=>$ordencompra, 'observ'=>$observ,
                'ubicacion_calle'=>$ubicacion_calle,'ubicacion_altura'=>$ubicacion_altura, 'ubicacion_sentido'=>$ubicacion_sentido,'ubicacion_localidad'=>$ubicacion_localidad,'ubicacion_cp'=>$ubicacion_cp, 'ejido_urbano'=>$ejido_urbano, 'geo_lat'=>$geo_lat,'geo_lon'=>$geo_lon,
                'ubicacion_velper'=>$ubicacion_velper, 'velocidad_min'=>$velocidad_min, 'multicarril'=>$multicarril, 'carril_sentido'=>$carril_sentido,);

        } elseif ($this->isGestion() == TRUE) {
            $equipoInfo = array( 'ubicacion_calle'=>$ubicacion_calle,'ubicacion_altura'=>$ubicacion_altura,'ubicacion_sentido'=>$ubicacion_sentido,'ubicacion_localidad'=>$ubicacion_localidad,'ubicacion_cp'=>$ubicacion_cp,'ejido_urbano'=>$ejido_urbano,'geo_lat'=>$geo_lat,'geo_lon'=>$geo_lon,
                'ubicacion_velper'=>$ubicacion_velper, 'velocidad_min'=>$velocidad_min, 'multicarril'=>$multicarril, 'carril_sentido'=>$carril_sentido,);

        } elseif ($this->isCalibracion() == TRUE) {
            $equipoInfo = array('ubicacion_velper'=>$ubicacion_velper, 'velocidad_min'=>$velocidad_min, 'multicarril'=>$multicarril, 'carril_sentido'=>$carril_sentido,
                'doc_fechacal'=>$doc_fechacal, 'doc_fechavto'=>$doc_fechavto, 'doc_informe'=>$doc_informe, 'nro_ot'=>$nro_ot, 'doc_certif'=>$doc_certif,'doc_aprob'=>$doc_aprob,'doc_normasic'=>$doc_normasic,'doc_distancia'=>$doc_distancia);
        }

        $result = $this->equipos_model->editEquipo($equipoInfo, $equipoId);

        if ($tipo == 1 OR $tipo == 2403 OR $tipo == 2406 AND ($vehiculoasig != 0 OR $vehiculoasig != NULL)) {
            if ($vehiculoasig != NULL) {
                $idproyecto = $this->input->post('municipio');
                $dominio    = $this->flota_model->getDominio($vehiculoasig);

                if ($idproyecto != 0 && $dominio != NULL ) {
                    $flota_asigInfo = array('dominio'=>$dominio, 'idproyecto'=>$idproyecto);
                    $this->flota_model->editFlotaAsig($flota_asigInfo, $dominio);
                }
            }
        }

        if($result == true)
        {
            //Historial
            $idequipo       = $equipoId;
            $idcomponente   = 0;
            $idevento       = 0;//Modificación, no hay evento
            $idestado       = 0;//$estado;
            $origen         = "EQUIPOS";
            $tipo_historial = "MODIFICACIÓN";
            //$detalle      = $observ;
            $reubicacion    = 0;//$municipio;

            foreach($infoAnt as $infoInd){
                $idmodelo_ant            = $infoInd->idmodelo;
                $idmarca_ant             = $infoInd->marca;
                $idtipo_ant              = $infoInd->tipo;
                $idproyecto_ant          = $infoInd->municipio;
                $idpropietario_ant       = $infoInd->idpropietario;
                $idestado_ant            = $infoInd->estado;
                $idvehiculoasig_ant      = $infoInd->vehiculoasig;
                $ubicacion_velper_ant    = $infoInd->ubicacion_velper;
                $multicarril_ant         = $infoInd->multicarril;
                $carril_sentido_ant      = $infoInd->carril_sentido;

                $ubicacion_calle_ant     = $infoInd->ubicacion_calle;
                $ubicacion_altura_ant    = $infoInd->ubicacion_altura;
                //$ubicacion_mano_ant    = $infoInd->ubicacion_mano;
                $ubicacion_sentido_ant   = $infoInd->ubicacion_sentido;
                $ubicacion_localidad_ant = $infoInd->ubicacion_localidad;
                $ubicacion_cp_ant        = $infoInd->ubicacion_cp;
                $ejido_urbano_ant        = $infoInd->ejido_urbano;
                $geo_lat_ant             = $infoInd->geo_lat;
                $geo_lon_ant             = $infoInd->geo_lon;

                $remito_ant              = $infoInd->remito;
                $requiere_calib_ant      = $infoInd->requiere_calib;
                $pedido_ant              = $infoInd->pedido;
                $ordencompra_ant         = $infoInd->ordencompra;
                $doc_fechacal_ant        = $infoInd->doc_fechacal;
                $doc_fechavto_ant        = $infoInd->doc_fechavto;
                $doc_informe_ant         = $infoInd->doc_informe;
                $doc_certif_ant          = $infoInd->doc_certif;
                $doc_aprob_ant           = $infoInd->doc_aprob;
                $doc_normasic_ant        = $infoInd->doc_normasic;
                $doc_distancia_ant       = $infoInd->doc_distancia;
                $observ_ant              = $infoInd->observ;

                $nombreGestor            = $infoInd->nombreGestor;
                $emailGestor            = $infoInd->emailGestor;
            }

            if ($this->isSSGG() == TRUE OR $this->isAdmin() == TRUE || $this->isDeposito() == TRUE) {
                if ($idmodelo_ant != $modelo) {
                    $modelo_ant     = $this->equipos_model->getEquiposModelo($idmodelo_ant);
                    $modelo_descrip = $this->equipos_model->getEquiposModelo($modelo);
                    $infoH          = "El modelo anterior era: <strong>".$modelo_ant."</strong>, se cambió por <strong>".$modelo_descrip."</strong>. <br>";
                }

                if ($idmarca_ant != $marca) {
                    $marca_ant     = $this->equipos_model->getEquiposMarca($idmarca_ant);
                    $marca_descrip = $this->equipos_model->getEquiposMarca($marca);
                    $infoH .= "La marca anterior era: <strong>".$marca_ant."</strong>, se cambió por <strong>".$marca_descrip."</strong>. <br>";
                }

                if ($idtipo_ant != $tipo) {
                    $tipo_ant     = $this->equipos_model->getEquiposTipo($idtipo_ant);
                    $tipo_descrip = $this->equipos_model->getEquiposTipo($tipo);
                    $infoH .= "El tipo anterior era: <strong>".$tipo_ant."</strong>, se cambio por <strong>".$tipo_descrip."</strong>. <br>";
                }

                if ($idproyecto_ant != $municipio) {
                    $proyecto_ant     = $this->municipios_model->getMunicipio($idproyecto_ant);
                    if ($proyecto_ant == NULL) {
                        $proyecto_ant = "A designar";
                    }

                    $proyecto_descrip     = $this->municipios_model->getMunicipio($municipio);
                    if ($proyecto_descrip == NULL) {
                        $proyecto_descrip = "A designar";
                    }
                    $infoH .= "El proyecto anterior era: <strong>".$proyecto_ant."</strong>, se cambió por <strong>".$proyecto_descrip."</strong>. <br>";
                }

                if ($idpropietario_ant != $idpropietario) {
                    $propietario_ant  = $this->equipos_model->getEquiposPropietario($idpropietario_ant);
                    $propietario_descrip  = $this->equipos_model->getEquiposPropietario($idpropietario);
                    $infoH .= "El propietario anterior era: <strong>".$propietario_ant."</strong>, se cambió por <strong>".$propietario_descrip."</strong>. <br>";
                }

                if ($idestado_ant != $estado) {
                    $estado_ant       = $this->equipos_model->getEstado($idestado_ant);
                    $estado_descrip       = $this->equipos_model->getEstado($estado);
                    $infoH .= "El estado anterior era: <strong>".$estado_ant."</strong>, se cambió por <strong>".$estado_descrip."</strong>. <br>";
                }

                if ($tipo == 1 OR $tipo == 2403 OR $tipo == 2406 AND ($vehiculoasig != 0 OR $vehiculoasig != NULL)) {
                    if ($idvehiculoasig_ant != $vehiculoasig) {
                        $vehiculoasig_ant = $this->flota_model->getDominio($idvehiculoasig_ant);
                        $vehiculoasig_descrip = $this->flota_model->getDominio($vehiculoasig);
                        $infoH .= "El dominio que estaba asignado era: <strong>".$vehiculoasig_ant."</strong>, se cambió por <strong>".$vehiculoasig_descrip."</strong>. <br>";
                    }
                }
            }

            if ($this->isAdmin() == TRUE || $this->isSSGG() == TRUE || $this->isDeposito() == TRUE || $this->isGestion() == TRUE || $this->isCalibracion() == TRUE) {
                if ($ubicacion_velper_ant != $ubicacion_velper) {
                    if ($ubicacion_velper_ant == NULL) {
                        $ubicacion_velper_ant = "A designar";
                    }

                    if ($ubicacion_velper == NULL) {
                        $ubicacion_velper = "A designar";
                    }
                    $infoH .= "La velocidad máxima anterior era: <strong>".$ubicacion_velper_ant."</strong>, se cambió por <strong>".$ubicacion_velper."</strong>. <br>";
                }

                if ($multicarril_ant != $multicarril) {
                    switch ($multicarril_ant) {
                        case '0':
                            $multicarril_ant_descrip = "Sin carriles";
                            break;
                        default:
                            $multicarril_ant_descrip = $multicarril_ant;
                            break;
                    }

                    switch ($multicarril) {
                        case '0':
                            $multicarril_descrip = "Sin carriles";
                            break;
                        default:
                            $ubicacion_sentido_descrip = $multicarril;
                            break;
                    }
                    $infoH .= "La cantidad de carriles anterior era: <strong>".$multicarril_ant_descrip."</strong>, se cambió por <strong>".$multicarril_descrip."</strong>. <br>";
                }

                if ($carril_sentido_ant != $carril_sentido) {
                    $CS_ant = explode(',', $carril_sentido_ant);
                    $CS = explode(',', $carril_sentido);

                    if ($CS_ant[0] != $CS[0]) {
                        if ($CS_ant[0] == "1A") {
                            $CA1 = "Ascendente";
                        } elseif ($CS_ant[0] == "1D") {
                            $CA1 = "Descendente";
                        } elseif ($CS_ant[0] == NULL) {
                            $CA1 = "A designar";
                        }

                        if ($CS[0] == "1A") {
                            $C1 = "Ascendente";
                        } elseif ($CS[0] == "1D") {
                            $C1 = "Descendente";
                        } elseif ($CS[0] == NULL) {
                            $C1 = "A designar";
                        }
                        $infoH .= "El carril 1 anterior era: <strong>".$CA1."</strong>, se cambió por <strong>".$C1."</strong>. <br>";
                    }

                    if ($CS_ant[1] != $CS[1]) {
                        if ($CS_ant[1] == "2A") {
                            $CA2 = "Ascendente";
                        } elseif ($CS_ant[1] == "2D") {
                            $CA2 = "Descendente";
                        } elseif ($CS_ant[1] == NULL) {
                            $CA2 = "A designar";
                        }

                        if ($CS[1] == "2A") {
                            $C2 = "Ascendente";
                        } elseif ($CS[1] == "2D") {
                            $C2 = "Descendente";
                        } elseif ($CS[1] == NULL) {
                            $C2 = "A designar";
                        }
                        $infoH .= "El carril 2 anterior era: <strong>".$CA2."</strong>, se cambió por <strong>".$C2."</strong>. <br>";
                    }

                    if ($CS_ant[2] != $CS[2]) {
                        if ($CS_ant[2] == "3A") {
                            $CA3 = "Ascendente";
                        } elseif ($CS_ant[2] == "3D") {
                            $CA3 = "Descendente";
                        } elseif ($CS_ant[2] == NULL) {
                            $CA3 = "A designar";
                        }

                        if ($CS[2] == "3A") {
                            $C3 = "Ascendente";
                        } elseif ($CS[2] == "3D") {
                            $C3 = "Descendente";
                        } elseif ($CS[2] == NULL) {
                            $C3 = "A designar";
                        }
                        $infoH .= "El carril 3 anterior era: <strong>".$CA3."</strong>, se cambió por <strong>".$C3."</strong>. <br>";
                    }

                    if ($CS_ant[3] != $CS[3]) {
                        if ($CS_ant[3] == "4A") {
                            $CA4 = "Ascendente";
                        } elseif ($CS_ant[3] == "4D") {
                            $CA4 = "Descendente";
                        } elseif ($CS_ant[3] == NULL) {
                            $CA4 = "A designar";
                        }

                        if ($CS[3] == "4A") {
                            $C4 = "Ascendente";
                        } elseif ($CS[3] == "4D") {
                            $C4 = "Descendente";
                        } elseif ($CS[3] == NULL) {
                            $C4 = "A designar";
                        }
                        $infoH .= "El carril 4 anterior era: <strong>".$CA4."</strong>, se cambió por <strong>".$C4."</strong>. <br>";
                    }

                    if ($CS_ant[4] != $CS[4]) {
                        if ($CS_ant[4] == "5A") {
                            $CA5 = "Ascendente";
                        } elseif ($CS_ant[4] == "5D") {
                            $CA5 = "Descendente";
                        } elseif ($CS_ant[4] == NULL) {
                            $CA5 = "A designar";
                        }

                        if ($CS[4] == "5A") {
                            $C5 = "Ascendente";
                        } elseif ($CS[4] == "5D") {
                            $C5 = "Descendente";
                        } elseif ($CS[4] == NULL) {
                            $C5 = "A designar";
                        }
                        $infoH .= "El carril 5 anterior era: <strong>".$CA5."</strong>, se cambió por <strong>".$C5."</strong>. <br>";
                    }

                    if ($CS_ant[5] != $CS[5]) {
                        if ($CS_ant[5] == "6A") {
                            $CA6 = "Ascendente";
                        } elseif ($CS_ant[5] == "6D") {
                            $CA6 = "Descendente";
                        } elseif ($CS_ant[5] == NULL) {
                            $CA6 = "A designar";
                        }

                        if ($CS[5] == "6A") {
                            $C6 = "Ascendente";
                        } elseif ($CS[5] == "6D") {
                            $C6 = "Descendente";
                        } elseif ($CS[5] == NULL) {
                            $C6 = "A designar";
                        }
                        $infoH .= "El carril 6 anterior era: <strong>".$CA6."</strong>, se cambió por <strong>".$C6."</strong>. <br>";
                    }
                }
            }

            if ($this->isAdmin() == TRUE || $this->isSSGG() == TRUE || $this->isDeposito() == TRUE || $this->isGestion() == TRUE) {
                if ($ubicacion_calle_ant != $ubicacion_calle) {
                    if ($ubicacion_calle_ant == NULL) {
                        $ubicacion_calle_ant = "Sin Ubicación";
                    }

                    if ($ubicacion_calle == NULL) {
                        $ubicacion_calle = "Sin Ubicación";
                    }
                    $infoH .= "La calle/avenida/ruta anterior era: <strong>".$ubicacion_calle_ant."</strong>, se cambió por <strong>".$ubicacion_calle."</strong>. <br>";
                }

                if ($ubicacion_altura_ant != $ubicacion_altura) {
                    if ($ubicacion_altura_ant == NULL) {
                        $ubicacion_calle_ant = "Sin altura";
                    }

                    if ($ubicacion_altura == NULL) {
                        $ubicacion_altura = "Sin altura";
                    }
                    $infoH .= "La altura anterior era: <strong>".$ubicacion_altura_ant."</strong>, se cambió por <strong>".$ubicacion_altura."</strong>. <br>";
                }

                /*if ($ubicacion_mano_ant != $ubicacion_mano) {
                 if ($ubicacion_mano_ant == NULL) {
                 $ubicacion_mano_ant = "A designar";
                 }

                 if ($ubicacion_mano == NULL) {
                 $ubicacion_mano = "A designar";
                 }
                 $infoH .= "La mano anterior era: <strong>".$ubicacion_mano_ant."</strong>, se cambió por <strong>".$ubicacion_mano."</strong>. <br>";
                 }*/

                if ($ubicacion_sentido_ant != $ubicacion_sentido) {
                    switch ($ubicacion_sentido_ant) {
                        case '0':
                            $ubicacion_sentido_ant_descrip = "SELECCIONAR SENTIDO";
                            break;
                        case '5':
                            $ubicacion_sentido_ant_descrip = "Ascendente";
                            break;
                        case '6':
                            $ubicacion_sentido_ant_descrip = "Descendente";
                            break;
                    }

                    switch ($ubicacion_sentido) {
                        case '0':
                            $ubicacion_sentido_descrip = "SELECCIONAR SENTIDO";
                            break;
                        case '5':
                            $ubicacion_sentido_descrip = "Ascendente";
                            break;
                        case '6':
                            $ubicacion_sentido_descrip = "Descendente";
                            break;
                    }
                    $infoH .= "El sentido anterior era: <strong>".$ubicacion_sentido_ant_descrip."</strong>, se cambió por <strong>".$ubicacion_sentido_descrip."</strong>. <br>";
                }

                if ($ubicacion_localidad_ant != $ubicacion_localidad) {
                    if ($ubicacion_localidad_ant == NULL) {
                        $ubicacion_localidad_ant = "A designar";
                    }

                    if ($ubicacion_localidad == NULL) {
                        $ubicacion_localidad = "A designar";
                    }
                    $infoH .= "La localidad anterior era: <strong>".$ubicacion_localidad_ant."</strong>, se cambió por <strong>".$ubicacion_localidad."</strong>. <br>";
                }

                if ($ubicacion_cp_ant != $ubicacion_cp) {
                    if ($ubicacion_cp_ant == NULL) {
                        $ubicacion_cp_ant = "A designar";
                    }

                    if ($ubicacion_cp == NULL) {
                        $ubicacion_cp = "A designar";
                    }
                    $infoH .= "El código postal anterior era: <strong>".$ubicacion_cp_ant."</strong>, se cambió por <strong>".$ubicacion_cp."</strong>. <br>";
                }

                if ($ejido_urbano_ant != $ejido_urbano) {
                    switch ($ejido_urbano_ant) {
                        case 0:
                            $ejido_urbano_ant_descrip = "Seleccionar Ejido";
                            break;
                        case 1:
                            $ejido_urbano_ant_descrip = "DENTRO";
                            break;
                        case 2:
                            $ejido_urbano_ant_descrip = "FUERA";
                            break;
                    }

                    switch ($ejido_urbano) {
                        case 0:
                            $ejido_urbano_descrip = "Seleccionar Ejido";
                            break;
                        case 1:
                            $ejido_urbano_descrip = "DENTRO";
                            break;
                        case 2:
                            $ejido_urbano_descrip = "FUERA";
                            break;
                    }
                    $infoH .= "El ejido urbano anterior era: <strong>".$ejido_urbano_ant_descrip."</strong>, se cambió por <strong>".$ejido_urbano_descrip."</strong>. <br>";
                }

                if ($geo_lat_ant != $geo_lat) {
                    $infoH .= "La latitud anterior era: <strong>".$geo_lat_ant."</strong>, se cambió por <strong>".$geo_lat."</strong>. <br>";
                }

                if ($geo_lon_ant != $geo_lon) {
                    $infoH .= "La longitud anterior era: <strong>".$geo_lon_ant."</strong>, se cambió por <strong>".$geo_lon."</strong>. <br>";
                }
            }

            if ($this->isAdmin() == TRUE || $this->isSSGG() == TRUE || $this->isDeposito() == TRUE) {
                if ($remito_ant != $remito) {
                    $infoH .= "El numero de remito anterior era: <strong>".$remito_ant."</strong>, se cambió por <strong>".$remito."</strong>. <br>";
                }

                if ($requiere_calib_ant != $requiere_calib) {
                    $requiere_calib_ant_descrip = ($requiere_calib_ant == 1) ? "REQUIERE" : "NO REQUIERE";
                    $requiere_calib_descrip = ($requiere_calib == 1) ? "REQUIERE" : "NO REQUIERE";
                    $infoH .= "El equipo estaba en <strong>".$requiere_calib_ant_descrip."</strong> calibración y se cambió a <strong>".$requiere_calib_descrip."</strong> calibración. <br>";
                }

                if ($pedido_ant != $pedido) {
                    $infoH .= "El número de pedido anterior era: <strong>".$pedido_ant."</strong>, se cambió por <strong>".$pedido."</strong>. <br>";
                }

                if ($ordencompra_ant != $ordencompra) {
                    $infoH .= "El número de orden de compra anterior era: <strong>".$ordencompra_ant."</strong>, se cambió por <strong>".$ordencompra."</strong>. <br>";
                }

                $observaciones = $observ;
                /*if ($observ_ant != $observ) {
                 $infoH .= "La observación anterior era: <strong>".$observ_ant."</strong>, se cambió por <strong>".$observ."</strong>. <br>";
                 }*/
            }

            if ($this->isAdmin() == TRUE || $this->isCalibracion() == TRUE) {
                if ($doc_fechacal_ant != $doc_fechacal) {
                    $infoH .= "La fecha de calibración anterior era: <strong>".$doc_fechacal_ant."</strong>, se cambió por <strong>".$doc_fechacal."</strong>. <br>";
                }

                if ($doc_fechavto_ant != $doc_fechavto) {
                    $infoH .= "La fecha de vencimiento anterior era: <strong>".$doc_fechavto_ant."</strong>, se cambió por <strong>".$doc_fechavto."</strong>. <br>";
                }

                if ($doc_informe_ant != $doc_informe) {
                    $doc_informe_ant_descrip = ($doc_informe_ant == 1) ? "SI" : "NO";
                    $doc_informe_descrip = ($doc_informe == 1) ? "SI" : "NO";
                    $infoH .= "El equipo <strong>".$doc_informe_ant_descrip."</strong> tenia informe, se cambio por <strong>".$doc_informe_descrip."</strong> tiene informe. <br>";
                }

                if ($doc_certif_ant != $doc_certif) {
                    /*if ($doc_certif_ant == NULL) {
                     $doc_certif_ant = "Inexistente";
                     }

                     if ($doc_certif == NULL) {
                     $doc_certif = "Inexistente";
                     }*/
                    $infoH .= "El certificado anterior era: <strong>".$doc_certif_ant."</strong>, se cambió por <strong>".$doc_certif."</strong>. <br>";
                }

                if ($doc_aprob_ant != $doc_aprob) {
                    if ($doc_aprob_ant == NULL) {
                        $doc_aprob_ant = "Inexistente";
                    }

                    if ($doc_aprob == NULL) {
                        $doc_aprob = "Inexistente";
                    }
                    $infoH .= "La aprobación anterior era: <strong>".$doc_aprob_ant."</strong>, se cambió por <strong>".$doc_aprob."</strong>. <br>";
                }

                if ($doc_normasic_ant != $doc_normasic) {
                    if ($doc_normasic_ant == NULL) {
                        $doc_normasic_ant = "Inexistente";
                    }

                    if ($doc_normasic == NULL) {
                        $doc_normasic = "Inexistente";
                    }
                    $infoH .= "La norma anterior era: <strong>".$doc_normasic_ant."</strong>, se cambió por <strong>".$doc_normasic."</strong>. <br>";
                }

                if ($doc_distancia_ant != $doc_distancia) {
                    if ($doc_distancia_ant == NULL) {
                        $doc_distancia_ant = "Inexistente";
                    }

                    if ($doc_distancia == NULL) {
                        $doc_distancia = "Inexistente";
                    }
                    $infoH .= "La distancia entre espiras era: <strong>".$doc_distancia_ant."</strong>, se cambió por <strong>".$doc_distancia."</strong>. <br>";
                }

                //ENVIO DE MAIL A CALIBRACIONES

                if ($result == TRUE && $this->isCalibracion() == TRUE){
                    if ($doc_fechavto_ant != $doc_fechavto || $doc_fechacal_ant != $doc_fechacal || $doc_informe_ant != $doc_informe){
                        $detalle ='';
                        if ($doc_fechavto_ant != $doc_fechavto) {
                            $detalle .= "La fecha de vencimiento anterior era: <strong>".date('d/m/Y',strtotime($doc_fechavto_ant))."</strong>, se cambió por <strong>".date('d/m/Y',strtotime($doc_fechavto))."</strong>. <br>";
                        }if ($doc_fechacal_ant != $doc_fechacal) {
                            $detalle .= "La fecha de calibración anterior era: <strong>".date('d/m/Y',strtotime($doc_fechacal_ant))."</strong>, se cambió por <strong>".date('d/m/Y',strtotime($doc_fechacal))."</strong>. <br>";
                        }if ($doc_informe_ant != $doc_informe) {
                            $doc_informe_ant_descrip = ($doc_informe_ant == 1) ? "SI" : "NO";
                            $doc_informe_descrip = ($doc_informe == 1) ? "SI" : "NO";
                            $detalle .= "El equipo <strong>".$doc_informe_ant_descrip."</strong> tenia informe, se cambio por <strong>".$doc_informe_descrip."</strong> tiene informe. <br>";
                        }
                        $this->mail_model->enviarMail(5, $serie, NULL, $detalle, NULL,NULL,NULL,$emailGestor,$nombreGestor);
                    }
                }
                //FIN DE MAIL
            }

            if (($infoH != NULL) OR ($observ_ant != $observaciones)) {
                if ($infoH == NULL) {
                    $infoH = "Sin detalles.";
                }

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen, 'tipo'=>$tipo_historial, 'detalle'=>$infoH, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addHistorial($historialNew);
            } //Fin Historial

            $this->session->set_flashdata('success', 'Equipo actualizado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar equipo');
        }

        redirect('equiposListing');
    }


    function verEquipo($equipoId = NULL) //InformaciÃ³n de un equipo.
    {
        if($equipoId == null){
            $this->session->set_flashdata('error', 'No existe el equipo.');
            redirect('equiposListing');
        }

        $data = array();
        $data['equipo'] = $this->equipos_model->equipoInfo($equipoId);

        if (!$data['equipo']) {
          $this->session->set_flashdata('error', 'No existe informacion de este equipo.');
          redirect('equiposListing');
        }

        $this->equipos_model->campoCarril($data['equipo']->carril_sentido);
        $data['tipos_calibrar'] = $this->calib_model->getEquiposCalibrar(1);
        $data['componentesInfo'] = $this->equipos_model->getEquipoComponentes($equipoId);
        $data['ultima_bajada'] = $this->ordenesb_model->ultima_bajadaEquipo($data['equipo']->serie);
        $data['archivos'] = $this->adjuntar_model->getArchivosEquipos($equipoId, NULL, 1);

        $this->global['pageTitle'] = 'CECAITRA : Detalle del equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('equipos/equipos_ver', $data);
        $this->load->view('includes/footer');
    }

    function desactivar_equipo() //Desactiva un equipo.
    {
        $equipoid   = $this->input->post('equipoid');
        $observ     = $this->input->post('observ');
        $activo     = $this->input->post('activo');

        if ($activo == 0) {
            $activo  = 1;
            $success = "Equipo activado correctamente.";
            $error   = "Error al activar equipo.";
            $tipo = "ACTIVO";
        } elseif ($activo == 1) {
            $activo  = 0;
            $success = "Equipo desactivado correctamente.";
            $error   = "Error al desactivar equipo.";
            $tipo = "BAJA";
        }

        $equipoInfo = array('activo'=>$activo,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $getEquipo = $this->equipos_model->getEquipoInfo($equipoid);
        if ($getEquipo[0]->bajada == 1) {
          array_push($equipoInfo['operativo'] = $activo);
        }

        $result     = $this->equipos_model->editEquipo($equipoInfo, $equipoid);

        if($result == true){
            $this->session->set_flashdata('success', $success);

            //Historial
            $idequipo       = $equipoid;
            $idcomponente   = 0;
            $idevento       = 0; //Pasa a NO Activo, , no hay evento
            $idestado       = 1; //va a depósito x no activo
            $reubicacion    = 0;//$municipio;
            $origen         = "EQUIPOS";
            $tipo_historial = $tipo;
            $detalle        = $observ;

            $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen, 'tipo'=>$tipo_historial, 'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

            $result2 = $this->historial_model->addHistorial($historialNew);
            //Fin Historial
        }else{
            $this->session->set_flashdata('error', $error);
        }

        redirect('equiposListing');
    }

    function getequipo() //Obtiene en un combo despleglable todos los equipos.
    {
        if ($this->input->post('idequipo')) {
            $equipo = $this->equipos_model->getEquipo($this->input->post('idequipo'));
            echo json_encode($equipo);
        } else {
            show_404();
        }
    }

    function localizacionfijos()
    {
        echo json_encode($this->equipos_model->getEquiposFijos());
    }





    function solicitud_bajada() //Desactiva un equipo.
    {
        $equipoid   = $this->input->post('equipoid');
        $solicitud_observ     = $this->input->post('solicitud_observ');
        $estado_solicitud     = $this->input->post('estado_solicitud');

        if ($estado_solicitud == 0) {
            $solicitud_bajada  = 1;
            $success = "Solicitud de bajada activada correctamente.";
            $error   = "Error al activar Solicitud.";
            $tipo = "ACTIVO";
        } elseif ($estado_solicitud == 1) {
            $solicitud_bajada  = 0;
            $success = "Solicitud de bajada desactivada correctamente.";
            $error   = "Error al desactivar Solicitud.";
            $tipo = "BAJA";
        }

        $equipoInfo = array('solicitud_bajada'=>$solicitud_bajada);
        $result     = $this->equipos_model->editEquipo($equipoInfo, $equipoid);

        if($result == true){
            $this->session->set_flashdata('success', $success);

            //Historial
            $origen         = "EVENTOS";
            $historialNew = array('idequipo'=>$equipoid, 'idcomponente'=>0,'idevento'=>0,'idestado'=>0,'reubicacion'=>0,'origen'=>$origen, 'tipo'=>$tipo, 'detalle'=>$solicitud_observ, 'observaciones'=>" ", 'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));

            $result2 = $this->historial_model->addHistorial($historialNew);
            //Fin Historial
        }else{
            $this->session->set_flashdata('error', $error);
        }

        redirect('equiposListing');
    }
}
?>
