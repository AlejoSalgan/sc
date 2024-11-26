<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Precintos extends BaseController
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
        $this->load->model('precintos_model');
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
        $this->load->view('includes/footer',$this->global);
    }
    
    
    function carga_precinto()
    {
        /**
         * Este método es usado para cargar precintos para el sector 
         * de reparaciones. EL usuario puede cargar desde un precinto
         * a un rango de precintos.
         *
         * @access public
         * @param ninguno   
         * @return ninguno
         */
       /**
         * @author Cristian Lencina <clencina@cecaitra.org.ar>
         */
        //Recibe desde el FORM el numero inicial del rango a insertar
        $desde = $this->input->post('desde'); 
        
        if ($desde <= 0) {
            redirect('reparaciones/precintado');
        }
        //Recibe desde el FORM el numero Final del rango a insertar
        $hasta = $this->input->post('hasta');
        
        if ($hasta <= $desde && $hasta != "" ) {
            redirect('reparaciones/precintado');
        } else {
            //Diferencia para determinar el rango a insertar
            $diferencia = $hasta - $desde;
            
            if ($diferencia > 500) {
                $this->session->set_flashdata('error',"<strong>"."El rango de precintos debe ser menor o igual a 500"."<strong>");
                redirect('reparaciones/precintado');
            }
            //Funcion del modelo para insertar precintos a DB
            $result = $this->precintos_model->insert_precinto($desde,$hasta);
            
            if ($result[0]) {
                $this->session->set_flashdata('success','<span class="glyphicon glyphicon-ok"></span>'."<strong>"."  Precintos cargados correctamente"."<strong>");
               redirect('reparaciones/precintado');
            } else {
               $this->session->set_flashdata('error',"Numero de precinto "."<strong>".$result[1]."</strong>"." ya existente");
               redirect('reparaciones/precintado');
            }
        }
    }
    
    function download_plantilla()
    {
       /**
        * Este método es usado para descargar la plantilla
        * utilizada para cargar puntos de precintados
        *
        * @access public
        * @param ninguno
        * @return ninguno
        */
       /**
        * @author Cristian Lencina <clencina@cecaitra.org.ar>
        */
        //SC - SCDEV
        $ruta = '/var/www/documentacion/plantillas/';
        
        //Localhost
        //$ruta = '/var/www/html/sistemac/documentacion/reparaciones/';
        
        $destino = $ruta."template_precintos.xlsx";
        
        // Nos aseguramos que el archivo exista
        if (file_exists($destino)) {
            // Establecemos el nombre del archivo
            header('Content-Disposition: attachment;filename="'. 'Plantilla_'.date('dmYHis').'.xlsx"');
            header('Content-Type: application/vnd.ms-excel');
            // Indicamos el tamaño del archivo
            header('Content-Length: '.filesize($destino));
            // Evitamos que sea cachedo
            header('Cache-Control: max-age=0');
            // Realizamos la salida del fichero
            readfile($destino);
            // Fin del cuento
            exit;
        } else {
            $this->session->set_flashdata('error', '<b> No se encuentra el archivo </b>');
            redirect('reparaciones/precintado');
        }
    }
    
    function reparacionesPrecintado()
    { 
       /**
        * Este método carga la vista inicial de Precintos y actualiza la misma 
        * si se elimina un precinto cargado.
        * 
        * @access public
        * @param ninguno
        * @return ninguno
        */
       /**
        * @author Cristian Lencina <clencina@cecaitra.org.ar>
        */ 
        $viewdata = array();
        $this->global['pageTitle'] = 'CECAITRA: Precintado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $NumPRecinto = $this->input->post('precinto');
        
        if (isset($_POST['precinto'])) {
            $this->precintos_model->eliminarPrecinto($NumPRecinto);
            $viewdata['precintos'] = $this->precintos_model->get_precintos();
            $this->session->set_flashdata('success','<span class="glyphicon glyphicon-ok"></span>'.'  Precinto '.'<b>'.'Nº'.$NumPRecinto.'</b>'.' eliminado correctmente');
            redirect('reparaciones/precintado');
        } else {
            
            $viewdata['precintos'] = $this->precintos_model->get_precintos();
            $this->load->view('SEC_precintado', $viewdata);
            $this->load->view("includes/footer");
            
        }
      
    }
}
?>
