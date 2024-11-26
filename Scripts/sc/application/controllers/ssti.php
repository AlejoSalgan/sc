<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class ssti extends BaseController
{
    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('ssti_model');
        $this->load->model('user_model');
        $this->load->model('utilidades_model');
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->model('verificacion_model');
        $this->load->library('fechas'); 
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->library('export_excel');
    }

    public function index() //This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('protocolos/protocolos');
        $this->load->view('includes/footer');
    }

    function exportaciones_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $count = $this->ssti_model->exportacionesList(0,$searchText,$criterio);
        $returns = $this->paginationCompress("exportaciones_listado/", $count, 15 );
        $data['exportaciones'] = $this->ssti_model->exportacionesList(1,$searchText,$criterio, $returns["page"], $returns["segment"]);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA: Exportaciones listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('ssti/exportaciones', $data);
        $this->load->view('includes/footer');
    }


    function verExportacion($num_Expo = NULL)
    {

        if($num_Expo == NULL){
            redirect('expo_listado');
        }

        $data['expo_protocolos'] = $this->ssti_model->getProtocolosExpo($num_Expo);
        $data['numExpo'] = $num_Expo;

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA : Detalle Exportacion';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('ssti/exportacion_ver', $data);
        $this->load->view('includes/footer');
    }


    function fotosDesencriptadas_listado()
    {
      $searchText = $this->input->post('searchText');
      $criterio   = $this->input->post('criterio');
      $data['searchText'] = $searchText;
      $data['criterio']   = $criterio;

      $opciones = array(0 => 'Todos', 'PM.id' => 'Nº Protocolo' , '1' => 'Equipo', 'M.descrip' => 'Proyecto', '2' => 'Cantidad APP', 'PM.ts' => 'Fecha TS');
      $data['protocolos'] = $this->ssti_model->fotosDesencriptadasListing($searchText,$criterio,$opciones,$this->role,$this->session->userdata('userId'));

      $data['titulo'] = 'Fotos Desencriptadas';
      $data['total'] = count($data['protocolos']);
      $data['total_tabla'] =  $this->ssti_model->fotosDesencriptadasListing('',$criterio,$opciones,$this->role,$this->session->userdata('userId'));
      $data['opciones'] = $opciones;

      $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

      $this->global['pageTitle'] = 'CECAITRA: Fotos Desencriptadas';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('ssti/fotos_desencriptadas',$data);
      $this->load->view('includes/footer');
    }

    function ver_fotos($id_protocolo = NULL, $pagina = NULL)
    {
      if (!$id_protocolo) {
        $this->session->set_flashdata('error', 'No existe este protocolo.');
        redirect('fotosDesencriptadas_listado');
      }

      $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);

      if (!$data['protocolo']) {
        $this->session->set_flashdata('error', 'No existe este protocolo.');
        redirect('fotosDesencriptadas_listado');
      } elseif ($data['protocolo']->decripto != 4) {
        $this->session->set_flashdata('error', 'Este protocolo no esta en decripto 4.');
        redirect('fotosDesencriptadas_listado');
      }

      $data['fotos'] = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/_imagen1.php?p=$id_protocolo"), true);

      if(!$data['fotos']){
        $this->session->set_flashdata('error', 'No hay fotos de este Protocolo.');
        redirect('fotosDesencriptadas_listado');
      }

      $data['id_protocolo'] = $id_protocolo;

      $data['titulo'] = "Ver Fotos";
      $this->global['pageTitle'] = 'CECAITRA: Ver Fotos Desencriptadas';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('ssti/ver_fotosDesencriptadas',$data);
      $this->load->view('includes/footer');
    }

    function ver_fotos_ssti()
    {
        if (isset($_GET['p'])) $p = $_GET['p'];
        if (isset($_GET['f'])) $f = $_GET['f'];
        if (isset($_GET['idedicion'])) $idedicion = $_GET['idedicion'];

        $imagen = rawurldecode($f);
        $imagen1 = str_replace(' ','%20',$imagen);

        if ($idedicion){
            $file = 'http://ssti.cecaitra.com/modulos/ver-imagen-zoom.php?idedicion='.$idedicion;
        }else{
            if ($_SERVER['HTTP_HOST'] === "sc.cecaitra.com") {
              $file = 'http://ssti.cecaitra.com/modulos/ver_foto.php?p='.$p.'&f='.$imagen1.'&c=50';
            } else {
              $file = 'http://192.168.3.20/modulos/ver-foto-tam-araujo.php?p='.$p.'&f='.$imagen1.'&c=50';
            }
        }

        header('Content-Type: image/jpeg');
        echo file_get_contents($file);
    }

    function verAprobadas($id_protocolo = NULL)
    {
        if($id_protocolo == NULL){
          $this->session->set_flashdata('error', 'Este protocolo no existe.');
          redirect('exportaciones_listado');
        }

        $data['fotos'] = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/_expoProtocolo.php?p=$id_protocolo&e=26"), true);

        $data['protocolo'] = $this->ssti_model->getIDprotocolo($id_protocolo);

        /*
        if (!$data['protocolo']) {
          $this->session->set_flashdata('error', 'Este protocolo no existe.');
          redirect('exportaciones_listado');
        }
        */

        $data['id_protocolo'] = $id_protocolo;
        $data['titulo'] = "Imagenes aprobadas";

        $this->global['pageTitle'] = 'CECAITRA : Imagenes aprobadas';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('ssti/exportacion_protocolo_A', $data);
        $this->load->view('includes/footer');
    }

    function verDesaprobadas($id_protocolo = NULL)
    {
        if($id_protocolo == NULL){
          $this->session->set_flashdata('error', 'Este protocolo no existe.');
          redirect('exportaciones_listado');
        }

        $data['fotos'] = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/_expoProtocolo.php?p=$id_protocolo&e=27"), true);

        $data['protocolo'] = $this->ssti_model->getIDprotocolo($id_protocolo);

        /*
        if (!$data['protocolo']) {
          $this->session->set_flashdata('error', 'Este protocolo no existe.');
          redirect('exportaciones_listado');
        }
        */

        $data['id_protocolo'] = $id_protocolo;
        $data['titulo'] = "Imagenes desaprobadas";

        $this->global['pageTitle'] = 'CECAITRA : Imagenes desaprobadas';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('ssti/exportacion_protocolo_D', $data);
        $this->load->view('includes/footer');
    }


    function productividad_informe()
    {
      $data['proyectos'] = $this->municipios_model->getProyectos();

      $this->global['pageTitle'] = 'CECAITRA : Productividad';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('ssti/productividad', $data);
      $this->load->view('includes/footer');
    }

    function equipos_ssti()
    {
      $proyecto = $this->input->post('proyecto');
      $equipos = $this->ssti_model->listado_equipos($proyecto);
      $equipos[0] = array('id' => 0, 'serie' => 'Todos los equipos');
      echo json_encode($equipos);
    }


    function descargar_productividad()
    {
      $fechas= $this->input->post('fecha');   
      $proyecto = $this->input->post('idproyecto');
      $idequipo = $this->input->post('idequipo');
      $noche = $this->input->post('foto_noche');
      $separator_dates=explode("/",$fechas);
      $fecha_desde = $separator_dates['0'];
      $fecha_hasta = $separator_dates['1'];
      
      if ($idequipo[0] != 0) {
        $serie = $this->equipos_model->getSerie($idequipo[0]);
      } else {
        $serie = $idequipo[0];
      }
      
      if ($noche == false){
        $noche = '0';
      }
      
      $datos = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/_productividad.php?fd=$fecha_desde&fh=$fecha_hasta&m=$proyecto&s=$serie&n=$noche") , true);
      
      //Recibir el array
      if (count($datos) > 0) {
        $this->export_excel->to_excel($datos, 'productividad_'.date('Y-m-d'));
        $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
      } else {
        $this->session->set_flashdata('error', 'Sin datos para el informe, intentar con otros datos.');
        redirect('productividad_informe');
      }
    }


    function consulta_editadas()
    {
      $searchText = $this->input->post('searchText');
      $criterio   = $this->input->post('criterio');
      $data['searchText'] = $searchText;
      $data['criterio']   = $criterio;

      $opciones = array(0 => 'Todos', 'PM.id' => 'Nº Protocolo' , 'PM.equipo_serie' => 'Equipo', 'M.descrip' => 'Proyecto', '1' => 'Cantidad APP', '2' => 'Fecha Protocolo');

      $data['protocolos'] = $this->ssti_model->editadas_listing($searchText,$criterio,$opciones,$this->role,$this->session->userdata('userId'));

      $data['titulo'] = 'Consulta de editadas';
      $data['total'] = count($data['protocolos']);
      $data['total_tabla'] =  $this->ssti_model->fotosDesencriptadasListing('',$criterio,$opciones,$this->role,$this->session->userdata('userId'));
      $data['opciones'] = $opciones;

      //$data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

      $this->global['pageTitle'] = 'CECAITRA: Consulta de editadas';
      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('ssti/consulta_editadas',$data);
      $this->load->view('includes/footer');
    }



    
//asi estaba



    function estado_entrada()
    {
      //esta funcion hace muchas cosas refactorizar

      if (!$this->input->is_ajax_request()) {
         exit('No direct script access allowed');
      } else {
        //este total de imangenes deberia ser igual a las aprobadas por edicion 
        $id_protocolo = $this->input->post('id_protocolo');
        $id_entradas = $this->input->post('checkbox_names');
        $total_imagenes = intval($this->input->post('totalImagenes'));
        $descartadas = count($id_entradas);
        
        if ($descartadas > 0) {
          //valores de las 2 tablas a modificar 
          $verificacion_asignaciones = $this->verificacion_model->getAsignacion($id_protocolo); //asignacion me llegan los campos de verificacion_asignaciones 
          $protocolos_main_info = $this->verificacion_model->getProtocolos_mainInfo($id_protocolo); //datos a settear en protocolos main 
          //calcular datos para verificacion_asignacion 
          $nuevas_aprobadas = $total_imagenes - $descartadas;
          $nuevas_descartadas = (int)$verificacion_asignaciones->descartados + $descartadas;
          // $nuevas_descartadas = ($total_imagenes + $asigancion['descartados']) - ($total_imagenes- $descartadas); //otra manera que pense para ver los descartes de verificacion
          //calcular datos para protocolos_main 
          $info_aprobadas = intval($protocolos_main_info['info_aprobados']) - $descartes;
          $info_descartadas = intval($protocolos_main_info['info_descartados']) + $descartadas;
          $info_editables = ($protocolos_main_info['info_editables'] == '0') ? $info_aprobadas + $info_descartadas :$protocolos_main_info['info_editables'];
          $info_verificacion = $protocolos_main_info['info_verificacion'] + $descartadas;
          
          $nuevos_valores_protocolos_main = array(
            'info_editables' => $info_editables,   
            'info_verificacion' => $info_verificacion, 
            'info_aprobados' => $nuevas_aprobadas,
            'info_descartados' => $info_descartadas
         );
         
         $asignacionInfo = array('aprobados'=> $nuevas_aprobadas, 'descartados'=> $nuevas_descartadas);
         
         $updates = $this->verificacion_model->actualizarAsignacionYProtocoloMain($id_protocolo, $asignacionInfo, $nuevos_valores_protocolos_main);
         //esta linea que no se va a ejecutar porque estoy en ajax con este controlador 
        } 
        
        foreach($id_entradas as $id_entrada) {
          $entradaInfo = array('estado' => 27);
          $this->ssti_model->updateEntradaAuxiliar($entradaInfo, $id_entrada);
          $mensaje .= "$id_entrada,";
        }

        $data = array('mensaje_subliminal' =>$nuevas_aprobadas );
      }
      echo json_encode($data);
      
    }
    

}
?>
