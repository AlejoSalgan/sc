<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Deposito extends BaseController
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
        $this->load->view('includes/footer',$this->global);
    }

//////////// VISTAS ///////////////

    function ingresos_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(10);
        $opciones = array(0 => 'Todos', 'DE.id' => 'ID' , 'EM.serie' => 'Equipo', 'MUN.descrip' => 'Proyecto', 'DE.id_orden' => 'Orden', 'RC.descrip' => 'Categoria', 'DE.ts_creado' => 'Fecha');

        $count = $this->deposito_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $returns = $this->paginationCompress( "ingresos_listado/", $count, CANTPAGINA );
        $data['remitos'] = $this->deposito_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Ingresos';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->deposito_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Ingreso listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function custodia_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(20);
        $opciones = array(0 => 'Todos', 'DE.id' => 'ID' , 'EM.serie' => 'Equipo', 'MUN.descrip' => 'Proyecto', 'DE.id_orden' => 'Orden', 'DE.num_remito' => 'Nº Remito', 'DE.fecha_recibido' => 'Fecha de Recibido', 'U.name' => 'Recibido Por');

        $count = $this->deposito_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $returns = $this->paginationCompress( "custodia_listado/", $count, CANTPAGINA);
        $data['remitos'] = $this->deposito_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Custodia';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->deposito_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Custodia listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function egresos_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(30);
        $opciones = array(0 => 'Todos', 'DE.id' => 'ID' , 'EM.serie' => 'Equipo', 'MUN.descrip' => 'Proyecto', 'DE.id_orden' => 'Orden', 'DE.num_remito' => 'Nº Remito', 'DE.categoria' => 'Categoria', 99 => 'Fecha Egreso');

        $count = $this->deposito_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $returns = $this->paginationCompress( "egresos_listado/", $count, CANTPAGINA );
        $data['remitos'] = $this->deposito_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones,1);

        $data['titulo'] = 'Egresos';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->deposito_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $data['opciones'] = $opciones;

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $this->global['pageTitle'] = 'CECAITRA: Egresos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function finalizadas_listado()
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(40,50);
        $opciones = array(0 => 'Todos', 'DE.id' => 'ID' , 'EM.serie' => 'Equipo', 'MUN.descrip' => 'Proyecto', 'DE.id_orden' => 'Orden', 'DE.num_remito' => 'Nº Remito', 'DE.categoria' => 'Estado');

        $count = $this->deposito_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $returns = $this->paginationCompress( "finalizadas_listado/", $count, CANTPAGINA );
        $data['remitos'] = $this->deposito_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado,$opciones);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Finalizadas';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->deposito_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado,$opciones);
        $data['opciones'] = $opciones;

        $this->global['pageTitle'] = 'CECAITRA: Finalizadas listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito', $data);
        $this->load->view('includes/footer',$this->global);

    }

    function deposito_archivos($id_remito = NULL) //Vista para solicitar un presupuesto.
    {
        if($id_remito == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('custodia_listado');
        }

        $data['remitoInfo'] = $this->deposito_model->getRemito($id_remito);
        //$data['presupuestos'] = $this->socios_model->getPresupuestos($data['remitoInfo']->num_remito);
        //$data['cant_presupuestos'] = count($data['presupuestos']);


        if (!$data['remitoInfo']) { //Valido que el remito exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('custodia_listado');
        }


        $data['tipo_bread'] = "Deposito";
        $data['id_orden'] = $id_remito;
        $data['serie'] = $data['remitoInfo']->serie;
        $data['archivos'] = $this->adjuntar_model->getArchivos($id_remito);
        $data['cant_archivos'] = $this->adjuntar_model->getArchivos($id_remito,1);
        $data['guardar'] = 'guardar_archivos';
        $data['cargar'] = 'cargar_archivos';
        $data['descargar'] = 'descargar_archivos';
        $data['eliminar'] = 'eliminar_archivos';

        $this->global['pageTitle'] = 'CECAITRA : Solicitar Presupuesto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('sectores/SEC_adjArchivos', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function remito_deposito($id_remito = NULL)
    {
        $data['remito'] = $this->deposito_model->getRemito($id_remito);
        $data['eventos'] = $this->deposito_model->eventosRemito($id_remito);
        $data['total_eventos'] =  count($this->deposito_model->eventosRemito($id_remito));

        $data['archivos'] = $this->adjuntar_model->getArchivos($id_remito,NULL,1);
        $data['cant_archivos'] = $this->adjuntar_model->getArchivos($id_remito,1,1);

        $data['descargar'] = 'descargar_archivos';

        $this->global['pageTitle'] = 'CECAITRA: Remito Deposito';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }


    function nuevo_ingreso()
    {
        $data['municipios'] = $this->municipios_model->getMunicipios(NULL, NULL, NULL, NULL, NULL,1);

        $this->global['pageTitle'] = 'CECAITRA: Nuevo Ingreso';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('deposito/deposito_nuevo_ingreso', $data);
        $this->load->view('includes/footer',$this->global);
    }

//////////// VISTAS ///////////////


//////////// AJAX ///////////////
    function destinoDeposito()
    {
      if ($this->input->post('proyecto') >= 0) {
            $equipos = $this->deposito_model->equiposIngresar($this->input->post('proyecto'));
            echo json_encode($equipos);
          } else {
            show_404();
          }
    }


//////////// AJAX ///////////////

//////////// ACCIONES ///////////////

    function nuevo_recibir()
    {
      $equipos = $this->input->post('idequipo');
      $proyecto = $this->input->post('idproyecto');
      $error = "";
      $success_equipos = "";

      foreach ($equipos as $key => $equipo) {
        $id_estado = $this->equipos_model->getIDEstado($equipo);
        $serie = $this->equipos_model->getSerie($equipo);
        $ord_reparacion = $this->ordenes_model->ordenes_abiertas($serie,REPA_ABIERTAS,'R');
        $ord_socio = $this->socios_model->existeOrden($equipo);
        $estado = array(10,20,30);
        $remito_deposito = $this->deposito_model->existeEnDeposito($equipo,$estado);

        $i = 0;

        if ($id_estado > 3) {
            $error .= "El equipo $serie no se encuentra en el Deposito o Proyecto, revisar el historial.<br>";
            $i++;
          }

        if ($ord_reparacion) {
          $error .= "El equipo $serie tiene una orden de Reparacion abierta, solicite a Reparaciones que se lo envie. Si es que se encuentra en Oficina Tecnica Reparaciones.<br>";
          $i++;
        }

        if ($ord_socio) {
            $error .= "El equipo $serie tiene una orden de trabajo abierta en el Socio, espere a que el Socio se lo entregue.<br>";
            $i++;
          }

        if ($remito_deposito) {
            $error .= "El equipo $serie se encuentra en Ingreso/Custodia/Egreso. Revisar los otros menus.<br>";
            $i++;
          }

        if ($i > 0) {
          $error .= "<br>";
          continue;
        }

        $remitoInfo = array(
            'id_equipo'=>$equipo,
            'id_proyecto'=>$proyecto,
            'id_orden'=>NULL,
            'categoria'=>10,
            'estado'=>10,
            'creado_por'=>$this->vendorId,
            'ts_creado'=>date('Y-m-d H:i:s')
        );

        $result = $this->deposito_model->agregarRemito($remitoInfo);
        $success_equipos .= "$serie, ";
      }

      //Quito el ultimo <br> del string del error.
      if ($error != '') {
        $titulo = "No se ingresaron los siguientes Equipos:<br>";
        $error = substr($error, 0, -4);
        $error1 = $titulo.$error;
      }
      $success_equipos = substr($success_equipos, 0, -2);

      if ($result) {
        $this->session->set_flashdata('success', "Los equipos se agregaron correctamente: $success_equipos");
        $this->session->set_flashdata('error', $error1);
      } else {
        $this->session->set_flashdata('error', $error1);
      }

      redirect('nuevo_ingreso');
    }

    function recibir_deposito()
    {
        $observaciones= "";
        $id_remito = $this->input->post('id_remito');
        $observacion = $this->input->post('observacion');
        $aprobar = $this->input->post('aprobar');
        $id_orden = $this->input->post('id_orden');
        $orden = $this->ordenes_model->getOrden($id_orden);

        if($aprobar == 'Recibir'){
            $estado = 20;
            $mensaje = "Equipo recibido correctamente";
            $tipo = 18;
            $categoria = 10;
        }else{
            $estado = 50;
            $mensaje = "Equipo rechazado correctamente";
            $tipo = 19;
            $categoria = $this->input->post('categoria');
        }

        $depositoInfo = array('estado' => $estado, 'fecha_recibido'=> date('Y-m-d H:i:s'), 'usuario_recibido'=> $this->vendorId);

        if($aprobar == 'Recibir'){
          $num_remito = $this->input->post('num_remito');

/*
Lo comento porque a Gaston no le dejaba ingresar varios equipos con el mismo numero de remito.
          if ($num_remito) {
            $existe = $this->deposito_model->getNumRemito($num_remito);

            if ($existe != NULL && $num_remito != NULL) {
              $this->session->set_flashdata('error', 'El numero de remito que ingresaste ya fue utilizado para otro Equipo. Por favor revisa que sea el correcto.');
              redirect('ingresos_listado');
            }

            array_push($depositoInfo['num_remito']  = $num_remito);
          }
*/
          $depositoInfo['num_remito']  = $num_remito;




        }

        $resultD = $this->deposito_model->actualizarRemito($depositoInfo,$id_remito);

        if($resultD == TRUE){
            $deposito = $this->deposito_model->getRemito($id_remito);

            $eventoinfo = array('id_deposito'=> $id_remito, 'observacion'=> $observacion, 'estado'=> $estado, 'fecha'=> date('Y-m-d H:i:s'), 'usuario'=> $this->vendorId);

            $resultE = $this->deposito_model->agregarEvento($eventoinfo);

            if($categoria == 10){
              $update_equipo = array('estado' => 1);
              if (!$id_orden) {
                $update_equipo['evento_actual']  = 10;
              }

              $infoAnt    = $this->equipos_model->getEquipoInfo($deposito->id_equipo);

              $resultEU = $this->equipos_model->editEquipo($update_equipo,$deposito->id_equipo);

              if($resultEU == true){ //Historial
              	$idequipo       = $deposito->id_equipo;
              	$idcomponente   = 0;
              	$idevento       = $update_equipo['evento_actual']; //Modificación, no hay evento
              	$idestado       = $update_equipo['estado']; //$estado;
              	$origen         = "EVENTOS";
              	$tipo_historial = "NUEVO EVENTO";
              	$reubicacion    = 0; //$municipio;

              	foreach($infoAnt as $infoInd){
              		$old_estado = $infoInd->estado;
              		$old_evento = $infoInd->evento_actual;
              	}

              	if ($old_estado != $update_equipo['estado']) {
              		$estado_ant     = $this->equipos_model->getEstado($old_estado);
              		$estado_descrip = $this->equipos_model->getEstado($update_equipo['estado']);
              		$infoH = "El estado anterior era: <strong>".$estado_ant."</strong>, se cambio por <strong>".$estado_descrip."</strong>. <br>";
              	}

              	if ($old_evento != $update_equipo['evento_actual']) {
              		$evento_ant     = $this->equipos_model->getEvento($old_evento);
              		$evento_descrip = $this->equipos_model->getEvento($update_equipo['evento_actual']);
              		$infoH .= "El evento anterior era: <strong>".$evento_ant."</strong>, se cambio por <strong>".$evento_descrip."</strong>. <br>";
              	}

              	if (($infoH != NULL) OR ($observaciones != NULL)) {
              		if ($infoH == NULL) {
              			$infoH = "Sin detalles.";
              		}

                    $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen, 'tipo'=>$tipo_historial, 'detalle'=>$infoH, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));
                    $result2 = $this->historial_model->addHistorial($historialNew);
                }

              }

            }


            if ($id_orden) {
              $data_estado = array(
                          'orden'	=> $id_orden,
                          'usuario' => $this->session->userdata('userId'),
                          'fecha' => date('Y-m-d H:i:s'),
                          'observ' => $this->input->post('observacion'),
                          'tipo' => $tipo,
                          'asignado_categoria' => $categoria
              );

              //Inserto un nuevo evento a la orden de reparacion.
              $this->ordenes_model->insertarEstado($data_estado);

              //Actualizo el estado del equipo y de la orden.

              //El estado de recibido y la categoria deposito
              $update = array ('ultimo_estado' => $tipo, 'ultimo_categoria'=> $categoria);
              $this->ordenes_model->updateOrden($id_orden,$update);

            }

            $this->session->set_flashdata('success', $mensaje);

        }else{
            $this->session->set_flashdata('error', 'Error al recibir o rechazar el equipo.');
        }

        redirect('ingresos_listado');

    }


    function agregar_observacion() //Agrego las observaciones al remito.
    {
        $id_remito  = intval($this->input->post('id_remito'));
        $observacion = trim($this->input->post('observacion'));
        $estado = $this->input->post('estado');

        //Agrego un nuevo evento al remito.
        $eventoInfo  = array('id_deposito'=>$id_remito, 'observacion'=>$observacion, 'estado'=>$estado,'fecha'=>date('Y-m-d H:i:s'),  'usuario'=>$this->vendorId);
        $result = $this->deposito_model->agregarEvento($eventoInfo);

        if($result == TRUE){
            $this->session->set_flashdata('success', 'Nueva observacion agregada correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al agregar observación');
        }
        redirect('custodia_listado');
    }


    function guardar_archivos()
    {
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $id_orden = $this->input->post('id_orden');
      $observacion = $this->input->post('observacion');

      if ($_FILES['archivo']['size'] > 1048576) {
          $this->session->set_flashdata('info', $observacion); // En caso de que el archivo sea mayor a 1MB devuelvo el dato al formulario.
          $this->session->set_flashdata('error', 'No se puede adjuntar porque el archivo pesa mas de un 1MB.');
          redirect('calibraciones_adjuntar/'.$id_orden);
        }

      if ($observacion == '' || $observacion == NULL) {
        $observacion = 'Sin observaciones.';
      }

      $nombre_actual = $_FILES['archivo']['name'];
      $nombre_temp   = $_FILES['archivo']['tmp_name'];
      $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));
      $fecha         = date('Ymd-His');
      $sector = 'deposito';

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = "/var/www/html/sistemac/documentacion/reparaciones/".$id_orden."_$fecha"."$ext";
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$id_orden."_$fecha"."$ext";
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
        redirect('deposito_archivos/'.$id_orden);
      }

      $archivoInfo  = array('orden'=>$id_orden, 'nombre_archivo'=>$nombre_archivo, 'tipo_documentacion'=>$tipo_documentacion, 'observacion'=>$observacion, 'archivo'=>$id_orden."_$fecha"."$ext", 'tipo'=>$ext, 'creado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));

      $flash = $this->adjuntar_model->moverArchivo($nombre_temp, $destino, $archivoInfo, $id_orden);

      $this->session->set_flashdata($flash[0],$flash[1]);
      redirect('deposito_archivos/'.$id_orden);

    }


    function descargar_archivos()
    {
      $name = $this->input->post('name');
      $tipo = $this->input->post('tipo');
      $id_orden = $this->input->post('id_orden');
      $ref = $this->input->post('ref');
      $searchText = $this->input->post('searchText');
      $direccion = $this->input->post('direccion');
      //$sector = explode('/',$ref);
      $sector = 'deposito';

      //$link = $direccion."?ref=".$ref."&searchText=".$searchText;

      $link = $direccion;

      if (array_key_exists($tipo, tipos_mime)) {
        $tipo = tipos_mime[$tipo];
      } else {
        $this->session->set_flashdata('error', 'Error al descargar el archivo.');
        redirect($link);
      }

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = '/var/www/html/sistemac/documentacion/reparaciones/'.$name;
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$name;
      }

      if (!file_exists($destino)) {
        $this->session->set_flashdata('error', 'No existe el archivo para esta orden.');
        redirect($link);
      }

      $this->utilidades_model->descargar_archivos($name,$tipo,$destino);
    }


    function eliminar_archivos($id = NULL)
    {
      $id_orden = $this->input->get('orden');
      $ref = $this->input->get('ref');
      $searchText = $this->input->get('searchText');

      if($id == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('deposito_archivos/'.$id_orden);
      }

      $archivo = $this->adjuntar_model->getArchivo($id);

      if (!$archivo) { //Valido que el remito exista.
          $this->session->set_flashdata('error', 'No existe este archivo.');
          redirect('deposito_archivos/'.$id_orden);
      }

      //$sector = explode('/',$ref);
      $sector = 'deposito';

      if($_SERVER['HTTP_HOST'] === "localhost"){
        //Localhost
        $destino = '/var/www/html/sistemac/documentacion/reparaciones/'.$archivo->archivo;
      }else{
        //SC - SCDEV
        $destino = documentacion.$sector.'/'.$archivo->archivo;
      }

      $archivoInfo  = array('activo'=>0, 'modificado_por'=>$this->vendorId, 'fecha_ts'=>date('Y-m-d H:i:s'));

      $flash = $this->adjuntar_model->eliminarArchivo($destino, $archivoInfo, $id);

      $this->session->set_flashdata($flash[0],$flash[1]);
      redirect('deposito_archivos/'.$id_orden);

    }

    function cargar_archivos($id_orden = NULL)
    {
      if ($id_orden == NULL) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('custodia_listado');
      }

      $data['remitoInfo'] = $this->deposito_model->getRemito($id_orden);

      if (!$data['remitoInfo']) {
         $this->session->set_flashdata('error', 'No existe informacion de este remito.');
         redirect('custodia_listado');
      }

      $archivoInfo = array('estado'=> 1);
      $result = $this->adjuntar_model->updateArchivos($archivoInfo, $id_orden);

      if($result == TRUE){ // Agrego un nuevo evento.
          $this->session->set_flashdata('success', 'Archivos cargados correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al cargar archivos.');
      }
      redirect('deposito_archivos/'.$id_orden);

    }


  function equipo_destino()
    {
      $id_remito = $this->input->post('id_remito');
      $destino = $this->input->post('destino');
      $id_orden = $this->input->post('id_orden');
      $serie = $this->input->post('serie');
      $id_equipo = $this->input->post('id_equipo');
      $observacion = $this->input->post('observacion');
      $id_proyecto = $this->input->post('id_proyecto');

      $orden = $this->ordenes_model->getOrden($id_orden);

      switch($destino):
        case 1: //Enviar a Reparaciones

            //Si no exdiste la orden desde deposito creara la Orden de Reparacion.
            if (!$orden) {
              $data_orden = array(
                  'tipo' => 'R',
                  'ultimo_estado' => 19,
                  'serie' => $serie,
                  'idproyecto' => $id_proyecto,
                  'falla' => 63, //Prueba
                  'nro_msj' => date('Ymd His'),
                  'ultimo_categoria' => 10,
                  'equipo_operativo' => 1
              );

              $data_estado = array(
                  'tipo' => 19,
                  'usuario' => $this->session->userdata('userId'),
                  'fecha' => date('Y-m-d H:i:s'),
                  'observ' => $observacion,
                  'asignado_categoria' => 10
              );

              //Crea la orden y su evento inicial.
              $result2 = $this->ordenes_model->altaNuevaOrden($data_orden,$data_estado);

              //El ID de la orden de reparacion se le asignara al Remito de Deposito.
              $depositoInfo = array('id_orden' => $result2);
              $this->deposito_model->actualizarRemito($depositoInfo,$id_remito);
            } else {
              $data_estado = array(
                          'orden'	=> $id_orden,
                          'usuario' => $this->session->userdata('userId'),
                          'fecha' => date('Y-m-d H:i:s'),
                          'observ' => $this->input->post('observacion'),
                          'tipo' => 19,
                          'asignado_categoria' => 10
              );

              //Inserto un nuevo evento a la orden de reparacion.
              $this->ordenes_model->insertarEstado($data_estado);

              $update = array ('ultimo_estado' => 19, 'ultimo_categoria'=> 10);
              $this->ordenes_model->updateOrden($id_orden,$update);

              $result2 = $this->ordenes_model->updateOrden($id_orden,$update);
            }

            if ($result2) {
              /*
              if ($result2 == TRUE) {
                $this->mail_model->enviarMail(7, $orden->rm_serie, $idorden, $data_estado['observ'], date('d/m/Y',strtotime($orden->re_fecha)),NULL, NULL, NULL, NULL,$propietario);
              }
              */

              $this->session->set_flashdata('success',"Se envio a reparaciones el equipo $serie.");
              $estado = 30;
            } else {
              $this->session->set_flashdata('error',"Error al enviar a reparaciones el equipo $serie.");
            }

        break;
        case 5: //Enviar a Socio.

            $equipoInfo = $this->equipos_model->existeAsociado($serie);

            if (!$equipoInfo->idmodelo || $equipoInfo->idmodelo == 0 || $equipoInfo->idmodelo == NULL) {
              $this->session->set_flashdata('error',"Falta el modelo del equipo, no se puede enviar la orden al socio, $serie.");
              redirect('custodia_listado');
            }

            if (!$equipoInfo->asociado || $equipoInfo->asociado == NULL || $equipoInfo->asociado == "") {
              $this->session->set_flashdata('error',"Falta el asociado al modelo del equipo, no se puede enviar la orden al socio, $serie.");
              redirect('custodia_listado');
            }

            if (!$orden) {
              $idOrden = NULL;
              $idEquipo = $id_equipo;
            } else {
              $idOrden = $id_orden;
              $idEquipo = $orden->em_id;
            }

            $remitoInfo = array('id_equipo'=>$idEquipo, 'id_orden'=>$idOrden, 'deposito'=>$id_remito);
            $result = $this->socios_model->agregarRemito($remitoInfo);

            if ($result) {
              $data_estado = array(
                        'orden'	=> $id_orden,
                        'usuario' => $this->session->userdata('userId'),
                        'fecha' => date('Y-m-d H:i:s'),
                        'observ' => $this->input->post('observacion'),
                        'tipo' => 14,
                        'asignado_categoria' => 10
                  );

              if ($orden) {
                $this->ordenes_model->insertarEstado($data_estado);
                $update = array ('ultimo_estado' => 14,'ultimo_categoria'=> 10);
                $result2 = $this->ordenes_model->updateOrden($id_orden,$update);

                /*
                if ($result2 == TRUE) {
                           $this->mail_model->enviarMail(7, $orden->rm_serie, $idorden, $data_estado['observ'], date('d/m/Y',strtotime($orden->re_fecha)),NULL, NULL, NULL, NULL,$propietario);
                }
                */
              }

              $this->session->set_flashdata('success',"Se envio al socio el equipo $serie.");
              $estado = 30;
            } else {
              $this->session->set_flashdata('error',"Error al enviar al socio el equipo $serie.");
            }

        break;

        case 11: //Se entrega al Proyecto.
          $id_estado = $this->equipos_model->getIDEstado($id_equipo);

          if ($id_estado != 1) {
            $this->session->set_flashdata('error',"El equipo $serie no se encuentra en Deposito, revisar el historial.");
            redirect('custodia_listado');
          }

          $ord_reparacion = $this->ordenes_model->ordenes_abiertas($serie,REPA_ABIERTAS,'R');

          if ($ord_reparacion) {
            $this->session->set_flashdata('error',"El equipo $serie tiene una orden de Reparacion, el equipo en algun momento debera volver a Reparaciones para continuar el circuito de su orden hasta que se cierre.");
            redirect('custodia_listado');
          }

          $ord_socio = $this->socios_model->existeOrden($id_equipo);

          if ($ord_socio) {
            $this->session->set_flashdata('error',"El equipo $serie tiene una orden de trabajo abierta en el Socio, revisar esta incongruencia.");
            redirect('custodia_listado');
          }

          $equipoInfo = array('estado' => 2, 'evento_actual'=> 40);
          $result = $this->equipos_model->editEquipo($equipoInfo, $id_equipo);

          if ($result) {
            $this->session->set_flashdata('success',"Se ha enviado el equipo $serie al Proyecto.");
          } else {
            $this->session->set_flashdata('error',"Error al enviar el equipo $serie al Proyecto.");
          }

          $estado = 40;
        break;


      endswitch;

      $depositoInfo = array('estado' => $estado, 'categoria'=> $destino);
      $resultD = $this->deposito_model->actualizarRemito($depositoInfo,$id_remito);

      if($resultD == TRUE){
          $eventoinfo = array('id_deposito'=> $id_remito, 'observacion'=> $observacion, 'estado'=> $estado, 'fecha'=> date('Y-m-d H:i:s'), 'usuario'=> $this->vendorId);

          $this->deposito_model->agregarEvento($eventoinfo);
      }

      redirect('custodia_listado');

    }


}

?>
