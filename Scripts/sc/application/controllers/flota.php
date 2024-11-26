<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Flota extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('flota_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('municipios_model');
        $this->load->library('fechas'); //utils Fechas
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('flota');
        $this->load->view('includes/footer');
    }

    function flotaListing()
    {
        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->flota_model->flotaListingCount($searchText);
	      $returns = $this->paginationCompress( "flotaListing/", $count, 30 );

        $data['flotaRecords'] = $this->flota_model->flotaListing($searchText, $returns["page"], $returns["segment"]);

        $userId = $this->session->userdata('userId');
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA: Vehículos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('flota', $data);
        $this->load->view('includes/footer');
    }

    function addNewFlota()
    {
        $data['propietarios']   = $this->equipos_model->getEquiposPropietarios();
        $data['municipios']     = $this->municipios_model->getMunicipios();
        $data['empleados']      = $this->user_model->getEmpleados(0);
        $data['destinos']       = $this->flota_model->getDestinos();
        $data['responsables']   = $this->user_model->getResponsables();

        $this->global['pageTitle'] = 'CECAITRA : Agregar Vehículo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('addNewFlota', $data);
        $this->load->view('includes/footer');
    }

    function addNewFlotaVeh()
    {
        $this->form_validation->set_rules('dominio','Dominio','trim|required|max_length[7]|xss_clean');

        $movilnro       = $this->input->post('movilnro');
        $existenro      = $this->flota_model->getVehiculoNro($movilnro);

        if($this->form_validation->run() == FALSE || $existenro > 0){
            $this->addNewFlota();
            $this->session->set_flashdata('error', 'Dominio no válido o número de móvil duplicado');
        } else {
            $dominio          = strtoupper(trim( $this->input->post('dominio') ));
            $movilnro         = $this->input->post('movilnro');
            $marca            = trim( $this->input->post('marca') );
            $modelo           = trim( $this->input->post('modelo') );
            $motor            = strtoupper(trim( $this->input->post('motor') ));
            $chasis           = strtoupper(trim( $this->input->post('chasis') ));
            $anio             = $this->input->post('anio') ;
            $propietario      = $this->input->post('propietario') ;
            $destino          = $this->input->post('destino') ;
            $idchofer1        = $this->input->post('chofer1') ;
            $idchofer2        = $this->input->post('chofer2') ;
            $idproyecto       = $this->input->post('proyecto') ;
            $segmento         = trim( $this->input->post('segmento') );

            $nro_poliza       = trim( $this->input->post('nro_poliza') );
            $tipo_poliza      = trim( $this->input->post('tipo_poliza') );
            $fecha_autoparte  = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_autoparte')) ;
            $venc_cedulaverde = $this->fechas->cambiaf_a_mysql($this->input->post('venc_cedulaverde')) ;
            $venc_seguro      = $this->fechas->cambiaf_a_mysql($this->input->post('venc_seguro')) ;
            $venc_vtv         = $this->fechas->cambiaf_a_mysql($this->input->post('venc_vtv')) ;
            $venc_matafuego   = $this->fechas->cambiaf_a_mysql($this->input->post('venc_matafuego')) ;
            $venc_cert_hidro  = $this->fechas->cambiaf_a_mysql($this->input->post('venc_cert_hidro')) ;
            $venc_ruta        = $this->fechas->cambiaf_a_mysql($this->input->post('venc_ruta')) ;
            $responsable      = $this->input->post('responsable') ;
            $acc_kit          = $this->input->post('acc_kit') ;
            $acc_cargador     = $this->input->post('acc_cargador') ;
            $acc_conos        = $this->input->post('acc_conos') ;
            $acc_chalecos     = $this->input->post('acc_chalecos') ;

            $flotaNew = array('dominio'=>$dominio, 'movilnro'=>$movilnro, 'marca'=>$marca, 'modelo'=>$modelo,
                        'motor'=>$motor, 'chasis'=>$chasis,'anio'=>$anio, 'propietario'=>$propietario, 'destino'=>$destino, 'segmento'=>$segmento, 'nro_poliza'=>$nro_poliza, 'tipo_poliza'=>$tipo_poliza, 'fecha_autoparte'=>$fecha_autoparte, 'venc_cedulaverde'=>$venc_cedulaverde, 'venc_seguro'=>$venc_seguro, 'venc_vtv'=>$venc_vtv, 'venc_matafuego'=>$venc_matafuego, 'venc_cert_hidro'=>$venc_cert_hidro, 'venc_ruta'=>$venc_ruta, 'responsable'=>$responsable, 'acc_kit'=>$acc_kit, 'acc_cargador'=>$acc_cargador, 'acc_conos'=>$acc_conos, 'acc_chalecos'=>$acc_chalecos, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));
            if($idchofer1 != 0){
                $flota_asigNew = array('dominio'=>$dominio, 'idchofer1'=>$idchofer1, 'idchofer2'=>$idchofer2, 'idproyecto'=>$idproyecto);
                $result2 = $this->flota_model->addNewFlotaAsig($flota_asigNew);
            }

            $result1 = $this->flota_model->addNewFlota($flotaNew);

            if( $result1 > 0 ){
                $this->session->set_flashdata('success', 'Nuevo Vehículo creado ok');

                //Historial
                $dominio = $dominio;
                $idevento = 10; //Ingreso al sistema va a depósito
                $idestado = 1; //Alta va a depósito
                $origen = "ALTA";
                $detalle = "Móvil nro.: " . $movilnro;
                $historialNew = array('dominio'=>$dominio, 'idevento'=>$idevento,'idestado'=>$idestado,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addFlotaHistorial($historialNew);
                //Fin Historial
            } else{
                $this->session->set_flashdata('error', 'Error al crear Vehículo');
            }

            redirect('addNewFlota');
        }
    }


    function editOldFlota($flotaId = NULL)
    {
        if($flotaId == null){
            redirect('flotaListing');
        }

        $data['flotaInfo']      = $this->flota_model->getFlotaInfo($flotaId);
        $data['propietarios']   = $this->equipos_model->getEquiposPropietarios();
        $data['municipios']     = $this->municipios_model->getMunicipios();
        $data['empleados']      = $this->user_model->getEmpleados(0);
        $data['destinos']       = $this->flota_model->getDestinos();
        $data['responsables']   = $this->user_model->getResponsables();

        $this->global['pageTitle'] = 'CECAITRA : Editar Vehículo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('editOldFlota', $data);
        $this->load->view('includes/footer');
    }

    function editFlota()
    {
        $flotaId = $this->input->post('flotaId');

        $this->form_validation->set_rules('dominio','Dominio','trim|required|max_length[7]|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->editOldFlota($flotaId);
        } else {
            $dominio            = strtoupper(trim( $this->input->post('dominio') ));
            $movilnro           = $this->input->post('movilnro');
            $marca              = trim( $this->input->post('marca') );
            $modelo             = trim( $this->input->post('modelo') );
            $motor              = strtoupper(trim( $this->input->post('motor') ));
            $chasis             = strtoupper(trim( $this->input->post('chasis') ));
            $anio               =  $this->input->post('anio') ;
            $propietario        =  $this->input->post('propietario') ;
            $destino            =  $this->input->post('destino') ;
            $idchofer1          =  $this->input->post('chofer1') ;
            $idchofer2          =  $this->input->post('chofer2') ;
            $idproyecto         =  $this->input->post('proyecto') ;
            $segmento           = trim( $this->input->post('segmento') );

            $nro_poliza         = trim( $this->input->post('nro_poliza') );
            $tipo_poliza        = trim( $this->input->post('tipo_poliza') );
            $fecha_autoparte    =  $this->fechas->cambiaf_a_mysql($this->input->post('fecha_autoparte')) ;
            $venc_cedulaverde   =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_cedulaverde')) ;
            $venc_seguro        =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_seguro')) ;
            $venc_vtv           =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_vtv')) ;
            $venc_matafuego     =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_matafuego')) ;
            $venc_cert_hidro    =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_cert_hidro')) ;
            $venc_ruta          =  $this->fechas->cambiaf_a_mysql($this->input->post('venc_ruta')) ;
            $responsable        =  $this->input->post('responsable') ;
            $acc_kit            =  $this->input->post('acc_kit') ;
            $acc_cargador       =  $this->input->post('acc_cargador') ;
            $acc_conos          =  $this->input->post('acc_conos') ;
            $acc_chalecos       =  $this->input->post('acc_chalecos') ;

            $flotaInfo = array('dominio'=>$dominio, 'movilnro'=>$movilnro, 'marca'=>$marca, 'modelo'=>$modelo, 'motor'=>$motor, 'chasis'=>$chasis,'anio'=>$anio, 'propietario'=>$propietario, 'segmento'=>$segmento, 'nro_poliza'=>$nro_poliza, 'tipo_poliza'=>$tipo_poliza, 'fecha_autoparte'=>$fecha_autoparte, 'venc_cedulaverde'=>$venc_cedulaverde, 'venc_seguro'=>$venc_seguro, 'venc_vtv'=>$venc_vtv, 'venc_matafuego'=>$venc_matafuego, 'venc_cert_hidro'=>$venc_cert_hidro, 'venc_ruta'=>$venc_ruta, 'responsable'=>$responsable, 'acc_kit'=>$acc_kit, 'acc_cargador'=>$acc_cargador, 'acc_conos'=>$acc_conos, 'acc_chalecos'=>$acc_chalecos, 'destino'=>$destino,
                'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

            if($idchofer1 != 0){
                $flota_asigInfo = array('dominio'=>$dominio, 'idchofer1'=>$idchofer1, 'idchofer2'=>$idchofer2, 'idproyecto'=>$idproyecto);
                $result2 = $this->flota_model->editFlotaAsig($flota_asigInfo, $dominio);
            }

            $result1 = $this->flota_model->editFlota($flotaInfo, $flotaId);

            if($result1){
                $this->session->set_flashdata('success', 'Vehículo actualizado ok');
                //Historial
                $dominio = $dominio;
                $idevento = 0; //Modificación, no hay evento
                $idestado = 2; //Modifica
                $origen = "MODIFICA";
                $detalle = "Móvil nro.: " . $movilnro;
                $historialNew = array('dominio'=>$dominio, 'idevento'=>$idevento,'idestado'=>$idestado,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:sa'));
                $this->load->model('historial_model');
                $result = $this->historial_model->addFlotaHistorial($historialNew);
                //Fin Historial
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar Vehículo');
            }

            redirect('editOldFlota/'.$flotaId);
        }
    }

    function deleteFlota()
    {
        $flotaId = $this->input->post('flotaId');
        $flotaInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));

        $result = $this->flota_model->deleteFlota($flotaId, $flotaInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>$result)));
        } else {
          echo(json_encode(array('status'=>$result)));
        }
    }
}

?>
