<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Archivos extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('socios_model');
        $this->load->model('user_model');
        $this->load->model('ordenes_model');
        $this->load->model('equipos_model');
        $this->load->model('mail_model');
        $this->load->model('utilidades_model');
        $this->load->model('deposito_model');
        $this->load->model('adjuntar_model');
        $this->load->model('municipios_model');
        $this->load->model('historial_model');
        $this->load->library('fechas');
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->global['pageTitle'] = 'CECAITRA: Adminstracion';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios');
        $this->load->view('includes/footer');
    }

//////////// VISTAS ///////////////



    function equipos_archivos($id_equipo = NULL) //Vista para solicitar un presupuesto.
    {
        $link = "equiposListing";

        if($id_equipo == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este equipo.');
            redirect($link);
        }

        $serie = $this->equipos_model->getSerie($id_equipo);

        if (!$serie) {
          $this->session->set_flashdata('error', 'No existe este equipo.');
          redirect($link);
        }

        $data['titulo'] = "Equipo $serie";
        $data['pagina'] = "Equipos";
        $data['regreso'] = $link;

        $data['pagina_actual'] = "equipos_archivos";
        $data['parametro'] = $id_equipo;
        $data['sector'] = "equipos";
        $data['sector'] = "equipos_archivos";

        $data['archivos'] = $this->adjuntar_model->getArchivosEquipos($id_equipo);
        $data['cant_archivos'] = $this->adjuntar_model->getArchivosEquipos($id_equipo,1);

        $data['guardar'] = 'archivo_guardar';
        $data['cargar'] = 'archivos_cargar';
        $data['descargar'] = 'archivo_descargar';
        $data['eliminar'] = 'archivo_eliminar';

        $this->global['pageTitle'] = 'CECAITRA : Archivos Equipos';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('archivos/archivos', $data);
        $this->load->view('includes/footer');
    }


//////////// VISTAS ///////////////


//////////// ACCIONES ///////////////

    //A futuro usar solo esta funcion para las demas vistas que necesicen cargar archivos.
    function archivo_guardar()
    {
      //Futuro
      //$ref = $this->input->post('ref');
      //$searchText = $this->input->post('searchText');

      //Parametro es el id despues de la vista
      //Pagina actual es el nombre de la vista donde se guardaran o cargaran los archivos.
      //Sector es el sector que lo carga que tambien sera la carpeta donde se guardara los archivos.
      //Tabla es la tabla donde se van a guardar los datos del archivo

      $parametro = $this->input->post('parametro');
      $pagina_actual = $this->input->post('pagina_actual');
      $sector = $this->input->post('sector');
      $tabla = $this->input->post('tabla');


      $observacion = $this->input->post('observacion');

      if ($_FILES['archivo']['size'] > 1048576) {
          $this->session->set_flashdata('info', $observacion); // En caso de que el archivo sea mayor a 1MB devuelvo el dato al formulario.
          $this->session->set_flashdata('error', 'No se puede adjuntar porque el archivo pesa mas de un 1MB.');
          redirect("$pagina_actual/$parametro");
        }

      if ($observacion == '' || $observacion == NULL) {
        $observacion = 'Sin observaciones.';
      }

      $nombre_actual = $_FILES['archivo']['name'];
      $nombre_temp   = $_FILES['archivo']['tmp_name'];
      $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));
      $fecha         = date('Ymd-His');
      //$sector = 'deposito';

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = "/var/www/html/sistemac/documentacion/equipos/".$parametro."_$fecha"."$ext";
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$parametro."_$fecha"."$ext";
      }

      $tipo_documentacion = $this->input->post('tipo_documentacion');
      if ($tipo_documentacion == 7) {
        $nombre_archivo = NULL;
      } else {
        $nombre_archivo = $this->input->post('nombre_archivo');
      }

      $mensaje = $this->adjuntar_model->tipoDocumento($ext);

      if ($mensaje != TRUE){
        $this->session->set_flashdata('error', $mensaje);
        redirect("$pagina_actual/$parametro");
      }

      switch ($pagina_actual) {
        case 'relevamiento_archivos':
        $archivoInfo  = array(
            'tipo_orden'=>'R',
            'orden'=>$parametro,
            'nombre_archivo'=>$nombre_archivo,
            'tipo_documentacion'=>$tipo_documentacion,
            'observacion'=>$observacion,
            'archivo'=>$parametro."_$fecha"."$ext",
            'tipo'=>$ext,
            'creado_por'=>$this->vendorId,
             'fecha_ts'=>date('Y-m-d H:i:s')
            );
          break;

      case 'desintalacion_archivos':
      $archivoInfo  = array(
          'tipo_orden'=>'D',
          'orden'=>$parametro,
          'nombre_archivo'=>$nombre_archivo,
          'tipo_documentacion'=>$tipo_documentacion,
          'observacion'=>$observacion,
          'archivo'=>$parametro."_$fecha"."$ext",
          'tipo'=>$ext,
          'creado_por'=>$this->vendorId,
           'fecha_ts'=>date('Y-m-d H:i:s')
          );
        break;

        case 'equipos_archivos':
          $archivoInfo  = array('id_equipo'=>$parametro, 'nombre_archivo'=>$nombre_archivo, 'tipo_documentacion'=>$tipo_documentacion, 'observacion'=>$observacion, 'archivo'=>$parametro."_$fecha"."$ext", 'tipo'=>$ext, 'creado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));
          break;

        default:

          break;
      }


      $flash = $this->adjuntar_model->mover_Archivo($nombre_temp, $destino, $archivoInfo, $tabla);

      $this->session->set_flashdata($flash[0],$flash[1]);
      redirect("$pagina_actual/$parametro");

    }


    function archivo_descargar()
    {
      //A futuro pensar con el searchtext que no esta.
      //$ref = $this->input->post('ref');
      //$searchText = $this->input->post('searchText');
      $name = $this->input->post('name');
      $tipo = $this->input->post('tipo');
      $parametro = $this->input->post('parametro');
      $pagina_actual = $this->input->post('pagina_actual');
      $sector = $this->input->post('sector');
      $nombre_archivo = $this->input->post('nombre_archivo');
      $nombre_final = $nombre_archivo.$tipo;

      if (array_key_exists($tipo, tipos_mime)) {
        $tipo = tipos_mime[$tipo];
      } else {
        $this->session->set_flashdata('error', 'Error al descargar el archivo.');
        redirect("$pagina_actual/$parametro");
      }

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = '/var/www/html/sistemac/documentacion/equipos/'.$name;
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$name;
      }

      if (!file_exists($destino)) {
        $this->session->set_flashdata('error', 'No existe el archivo para esta orden.');
        redirect("$pagina_actual/$parametro");
      }

      $this->utilidades_model->descargar_archivos($nombre_final,$tipo,$destino);
    }


    function archivo_eliminar($id = NULL)
    {
      $parametro = $this->input->get('parametro');
      $pagina_actual = $this->input->get('pagina_actual');
      $sector = $this->input->get('sector');
      $tabla = $this->input->get('tabla');

      if($id == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect("$pagina_actual/$parametro");
      }

      $archivo = $this->adjuntar_model->get_Archivo($id, $tabla);

      if (!$archivo) { //Valido que el remito exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect("$pagina_actual/$parametro");
      }

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = '/var/www/html/sistemac/documentacion/equipos/'.$archivo->archivo;
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$archivo->archivo;
      }

      $archivoInfo  = array('activo'=>0, 'modificado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));

      $flash = $this->adjuntar_model->eliminar_Archivo($destino, $archivoInfo, $id, $tabla);

      $this->session->set_flashdata($flash[0],$flash[1]);
      redirect("$pagina_actual/$parametro");
    }

    function archivos_cargar($id = NULL)
    {
      $pagina_actual = $this->input->get('pagina_actual');
      $tabla = $this->input->get('tabla');

      //Futuro hacer dinamico para que consulte si existe el archivo.
      /*

      if($id_equipo == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este equipo.');
          redirect($link);
      }

      $serie = $this->equipos_model->getSerie($id_equipo);

      if (!$serie) {
        $this->session->set_flashdata('error', 'No existe este equipo.');
        redirect($link);
      }
      */

      $archivoInfo = array('estado'=> 1, 'modificado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));

      switch ($tabla) {
        case 'instalaciones_archivos':
          if ($pagina_actual == "relevamiento_archivos") {
            $tipo_orden = "R";
          } else {
            $tipo_orden = "D";
          }

          $result = $this->adjuntar_model->update_Archivo3($archivoInfo, $id, $tipo_orden);
          break;

        case 'equipos_archivos':
          $result = $this->adjuntar_model->update_Archivo2($archivoInfo, $id);
          break;

        default:
          break;
      }

      if($result == TRUE){ // Agrego un nuevo evento.
          $this->session->set_flashdata('success', 'Archivos cargados correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al cargar archivos.');
      }

      redirect("$pagina_actual/$id");
    }





}

?>
