<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class reporte_actas extends BaseController
{
    public function __construct() // This is default constructor of the class
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('equipos_model');    
        $this->load->model('municipios_model');
        $this->load->model('reportes_model');
        $this->load->library('export_excel');
        $this->load->library('fechas');
        $this->load->library('archivos_lib');
        $this->load->library('carpetas_lib');
    }

    public function index() // This function used to load the first screen of the user
    {
        $data['municipio'] = $this->municipios_model->traerListaMunicipio();
        $data['equipo'] = $this->equipos_model->traerListaProyecto();
        $this->global['title'] = "Reportes pdf's";

        $this->global['pageTitle'] = 'CECAITRA : Reportes Actas';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('reporte_actas/visualizado_pdf_dppsv', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function busquedaDeSalidaPPSVdePDF()
    {
        $urlDestino ="http://186.122.177.30/WS/ws_busquedaSalidaDPPSV.php";

        $provincia = $this->input->post('provincia');
        $fDesde = $this->input->post('fDesde');
        $fHasta = $this->input->post('fHasta');
        $municipio = $this->input->post('municipio');
        $seriesEquipos = $this->input->post('seriesEquipos');
        $nombreEquipos = $this->input->post('nombreEquipos');


        $datosArray = array(
            'fDesde' => $fDesde,
            'fHasta' => $fHasta,
            'municipio' => $municipio,
            'provincia' => $provincia,
            'seriesEquipos' => $seriesEquipos,
            'nombreEquipos' => $nombreEquipos,
        );

        $datass = http_build_query($datosArray);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlDestino);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);


        $respuesta = array('datos' => json_decode($respuesta));
        echo json_encode($respuesta);
    }

    function generarCsv()
    {
        $urlDestino = "http://186.122.177.30/WS/ws_generalCsvDPPSV.php";

        $proto = $this->input->post('proto');
        $expo  = $this->input->post('expo');


        $datosArray = array(
            'proto' => $proto,
            'expo' => $expo,
        );

        $datass = http_build_query($datosArray);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlDestino);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datass);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = json_decode(curl_exec($ch));
        curl_close($ch);

        // var_dump($respuesta);die;

        $this->export_excel->to_excel($respuesta, 'Generacion_PDF_DPPSV_' . date('Y-m-d'));
    }

}
