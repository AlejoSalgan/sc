<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Insta extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('insta_model');
        $this->load->model('equipos_model');
        $this->load->model('user_model');
        $this->load->model('flota_model');
        $this->load->model('mensajes_model');
        $this->load->model('municipios_model');
        $this->load->library('fechas'); //utils Fechas
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('insta');
        $this->load->view('includes/footer',$this->global);
    }

    /**
     * This function is used to load the user list
     */
    function instaListing()
    {

            $this->load->model('insta_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->insta_model->instaListingCount($searchText);

			$returns = $this->paginationCompress( "instaListing/", $count, 30 );

            $data['instaRecords'] = $this->insta_model->instaListing($searchText, $returns["page"], $returns["segment"]);

            //var_dump($data['instaRecords']);

            $this->global['pageTitle'] = 'CECAITRA: Ordenes Instalación listado';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('insta', $data);
            $this->load->view('includes/footer',$this->global);

    }
    /**
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    /**
     * This function is used to load the add new form
     */
    function addNewInsta()
    {
        $data['municipios'] = $this->municipios_model->getMunicipios();
            $data['ordenNro'] = $this->insta_model->getProxOrden();
            $data['empleados'] = $this->user_model->getEmpleados(503);
            $data['supervisores'] = $this->user_model->getEmpleados(502);
            $data['vehiculos'] = $this->flota_model->getVehiculos(4); //destino 4.- "instalaciones"

            $this->global['pageTitle'] = 'CECAITRA : Crear Orden de Instalación';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('addNewInsta', $data);
            $this->load->view('includes/footer',$this->global);
    }

    /**
     * This function is used to add new ... to the system
     */
    function addNewInstalacion()
    {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('idproyecto','Proyecto','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('idsupervisor','Supervisor','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('iddominio','Dominio','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('conductor','Conductor','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('tecnico','Tecnico','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('fecha_visita','Fecha Visita','required|exact_length[10]|xss_clean');
            //$this->form_validation->set_rules('idequipo','Equipo Serie','required|is_natural_no_zero|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->addNewInsta();
            }
            else
            {
                $idequipo = $this->input->post('idequipo');
                foreach ($idequipo as $key => $equipo) {

                    $idproyecto                 = $this->input->post('idproyecto');
                    $diagnostico_previo         = trim( $this->input->post('diagnostico_previo') );
                    $idsupervisor               = $this->input->post('idsupervisor');
                    $iddominio                  = $this->input->post('iddominio');
                    $conductor                  = $this->input->post('conductor');
                    $tecnico                    = $this->input->post('tecnico');
                    $fecha_visita               = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
                    $idequipo1                  = $equipo;
                    $imei                       = $this->input->post('imei');
                    $ord_procesado              = 0;

                    $instaNew = array('idproyecto'=>$idproyecto, 'diagnostico_previo'=>$diagnostico_previo, 'idsupervisor'=>$idsupervisor, 'iddominio'=>$iddominio, 'conductor'=>$conductor, 'tecnico'=>$tecnico, 'fecha_visita'=>$fecha_visita, 'idequipo'=>$idequipo1, 'imei'=>$imei, 'ord_procesado'=>$ord_procesado, 'creadopor'=>$this->vendorId, 'fecha_alta'=>date('Y-m-d H:i:sa'));

                    //$this->load->model('insta_model');
                    $result = $this->insta_model->addNewInsta($instaNew);

                }

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Nueva Orden de Instalación creada correctamente');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Error al crear Orden de Instalación');
                }

                redirect('addNewInsta');
            }
    }


    function editOldInsta($instaId = NULL)
    {
            if($instaId == null)
            {
                redirect('instaListing');
            }

            $data['municipios'] = $this->municipios_model->getMunicipios();
            $data['ordenNro'] = $this->insta_model->getProxOrden();
            $data['empleados'] = $this->user_model->getEmpleados(503);
            $data['supervisores'] = $this->user_model->getEmpleados(502);
            $data['vehiculos'] = $this->flota_model->getVehiculos(4); //destino 4.- "insta"
            $data['instaInfo'] = $this->insta_model->getinstaInfo($instaId);

            //var_dump($data['instaInfo']); die();

            $this->global['pageTitle'] = 'CECAITRA : Editar Orden Instalación';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('editOldInsta', $data);
            $this->load->view('includes/footer',$this->global);
    }


    /**
     * This function is used to edit the user information
     */
    function editInsta()
    {
            $this->load->library('form_validation');

            $instaId = $this->input->post('instaId');

            $this->form_validation->set_rules('idproyecto','Proyecto','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('idsupervisor','Supervisor','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('iddominio','Dominio','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('conductor','Conductor','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('tecnico','Tecnico','required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('fecha_visita','Fecha Visita','required|exact_length[10]|xss_clean');
            $this->form_validation->set_rules('idequipo','Equipo Serie','required|is_natural_no_zero|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->editOldInsta($instaId);
            }
            else
            {

                $idproyecto             = $this->input->post('idproyecto');
                $diagnostico_previo     = $this->input->post('diagnostico_previo');
                $idsupervisor           = $this->input->post('idsupervisor');
                $iddominio              = $this->input->post('iddominio');
                $conductor              = $this->input->post('conductor');
                $tecnico                = $this->input->post('tecnico');
                $fecha_visita           = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_visita'));
                $idequipo               = $this->input->post('idequipo');
                $imei                   = $this->input->post('imei');
                $activo                 = $this->input->post('activo');

                $instaInfo = array('diagnostico_previo'=>$diagnostico_previo,'idproyecto'=>$idproyecto,'idsupervisor'=>$idsupervisor,'iddominio'=>$iddominio,'conductor'=>$conductor,'tecnico'=>$tecnico,'fecha_visita'=>$fecha_visita,'idequipo'=>$idequipo,'imei'=>$imei,'activo'=>$activo);
                 /*var_dump($instaInfo);
                 die();  */
                $result = $this->insta_model->editInsta($instaInfo, $instaId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Orden Instalación actualizada ok');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Error al actualizar Orden Instalación');
                }

                redirect('instaListing');
            }

    }

    function verInsta($instaId = NULL)
    {

            if($instaId == null)
            {
                redirect('instaListing');
            }

            $data['instaInfo'] = $this->insta_model->getInstaInfo($instaId);

            //var_dump($data['instaInfo']); die();

            $this->global['pageTitle'] = 'CECAITRA : Detalle Orden Instalación';
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/menu', $this->menu);
            $this->load->view('verInsta', $data);
            $this->load->view('includes/footer',$this->global);

    }



    function deleteInsta()
    {
            $instaId = $this->input->post('instaId');
            $instaInfo = array('activo'=>0,'creadopor'=>$this->vendorId, 'fecha_baja'=>date('Y-m-d H:i:s'));
            //var_dump($instaInfo);
           // die($instaId);
            $result = $this->insta_model->deleteInsta($instaId, $instaInfo);

            if ($result > 0) { echo(json_encode(array('status'=>$result))); }
            else { echo(json_encode(array('status'=>$result))); }
    }

//enviarInsta
    function enviarInsta()
    {
        $instaId = $this->input->post('instaId');

        $data['instaInfo'] = $this->insta_model->getInstaEnvio($instaId);
        $imei           = $data['instaInfo'][0]->imei;
        $tipo_msj       = "2009";
        $origen         = 1;
        $enviado        = 1;
        //$nroazar        = str_pad((string)rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $nro_msj        = date('Ymd His');// . "-" . $nroazar;
        $equipoSerie    = $data['instaInfo'][0]->equipoSerie;
        $fecha_alta     = $data['instaInfo'][0]->fecha_alta;
        $descrip        = str_replace(",", "", $data['instaInfo'][0]->diagnostico_previo);
        $datos          = $data['instaInfo'][0]->id . "," . $data['instaInfo'][0]->fecha_visita. "," . $descrip;
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

//var_dump($data['instaInfo']);
//echo "<pre>" . print_r ($data['instaInfo'][0]->imei) . "</pre>";
//echo $cadena;
//die(" fin ");

        //guardar datos ordenes
        $instaInfo = array('nro_msj'=>$nro_msj,'enviado'=>$enviado,'enviado_fecha'=>date('Y-m-d H:i:s'));
        $result1 = $this->insta_model->editinsta($instaInfo, $instaId);

        //guardar datos mensajes
        $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen);
        $result2 = $this->mensajes_model->addNewMensaje($mensajesInfo);

            if ($result1 > 0) { echo(json_encode(array('status'=>$result1))); }
            else { echo(json_encode(array('status'=>$result1))); }

            //var_dump($data['instaInfo']);
//echo "<pre>" . print_r ($data['instaInfo'][0]->imei) . "</pre>";
//echo $cadena;
//die(" fin ");

    }

    function enviarTodo()
    {
        $sinenviar = $this->insta_model->getSinEnviar(); //obtener todas las ordenes que no se enviaron
        foreach($sinenviar as $row)
        {
            $ordenesbId = $row->id;
            $data['ordenesbInfo'] = $this->insta_model->getInstaEnvio($ordenesbId);
            $imei           = $data['ordenesbInfo'][0]->imei;
            $tipo_msj       = "2009";
            $origen         = 1;
            $enviado        = 1;
            //$nroazar        = str_pad((string)rand(0, 9999), 4, "0", STR_PAD_LEFT);
            $nro_msj        = date('Ymd His');// . "-" . $nroazar;
            $equipoSerie    = $data['ordenesbInfo'][0]->equipoSerie;
            $fecha_alta     = $data['ordenesbInfo'][0]->fecha_alta;
            $descrip        = str_replace(",", "", $data['ordenesbInfo'][0]->diagnostico_previo);
            $datos          = $data['ordenesbInfo'][0]->id . "," . $data['ordenesbInfo'][0]->fecha_visita. "," . $descrip;

            //guardar datos ordenes
            $ordenesbInfo = array('nro_msj'=>$nro_msj,'enviado'=>$enviado,'enviado_fecha'=>date('Y-m-d H:i:s'));
            $result1 = $this->ordenesb_model->editOrdenesb($ordenesbInfo, $ordenesbId);

            //guardar datos mensajes
            $mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen);
            $result2 = $this->mensajes_model->addNewMensaje($mensajesInfo);
        }

        if ($result1 > 0) { echo(json_encode(array('status'=>$result))); }
        else { echo(json_encode(array('status'=>$result))); }

    }




}

?>
