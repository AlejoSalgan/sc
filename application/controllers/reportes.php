<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Reportes extends BaseController
{
    public function __construct() // This is default constructor of the class

    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('equipos_model');
        $this->load->model('eventos_model');
        $this->load->model('municipios_model');
        $this->load->model('reportes_model');
        $this->load->model('calib_model');
        $this->load->library('export_excel');
        $this->load->library('fechas');
        $this->load->library('archivos_lib');
        $this->load->library('carpetas_lib');
    }

    public function index() // This function used to load the first screen of the user

    {
        $data['tipos'] = $this->equipos_model->getEquiposTipos();
        $data['marcas'] = $this->equipos_model->getEquiposMarcas();
        $data['modelos'] = $this->equipos_model->getEquiposModelos();
        $data['municipios'] = $this->municipios_model->listarMunicipios($this->role, $this->vendorId, 1);
        $data['propietarios'] = $this->equipos_model->getEquiposPropietarios(null);
        $data['estados'] = $this->equipos_model->getEstados();
        $data['eventos'] = $this->eventos_model->getEventos('E');
        $data['administraciones'] = $this->equipos_model->getEquiposPropietarios(1);
        $data['equipos'] = $this->equipos_model->getEquipos();

        //Calibraciones
        $data['proyectosCalibrar'] = $this->municipios_model->getProyectosCalibrar($this->role, $this->vendorId);
        $data['tipo_ordenes'] = $this->calib_model->getTipoOrdenes();
        $data['equiposCalibrar'] = $this->calib_model->getEquiposCalibrar();
        $data['servicios'] = $this->calib_model->getTipoServicio();

        $this->global['pageTitle'] = 'CECAITRA : Reportes equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('reportes', $data);
        $this->load->view('includes/footer',$this->global);
    }

    public function reportesRapidos() //Recopila la informacion necesaria para armar el reporte de excel.

    {
        $role = $this->role;
        $userId = $this->session->userdata('userId');
        $reportes_rapidos = $this->input->post('reportes_rapidos');

        switch ($reportes_rapidos) {
            case 1:
                $calibra_vence = "0";
                $municipio = "-1";
                $tipo = "0";
                $marca = "0";
                $modelo = "0";
                $serieNro = "";
                $estado = "0";
                $evento = "0";
                $propietarios = "0";
                $administracion = "0";
                $activo = null;
                $reportes_reparaciones = "0";
                break;

            case 2:
                $calibra_vence = "0";
                $municipio = "-1";
                $tipo = "0";
                $marca = "0";
                $modelo = "0";
                $serieNro = "";
                $estado = "0";
                $evento = "0";
                $propietarios = "0";
                $activo = "1";
                $reportes_reparaciones = "0";
                $administracion = null;
                break;

            case 3:
                $calibra_vence = "60";
                $municipio = "-1";
                $tipo = "0";
                $marca = "0";
                $modelo = "0";
                $serieNro = "";
                $estado = "0";
                $evento = "0";
                $propietarios = "0";
                $administracion = "0";
                $activo = null;
                $reportes_reparaciones = "0";
                break;

            case 4:
                $result = $this->reportes_model->rapidoReparaciones($role, $userId);
                if (count($result) > 0) {
                    $this->export_excel->to_excel($result, 'Equipos_en_Reparación_' . date('Y-m-d'));
                    $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
                } else {
                    $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
                    redirect('reportes');
                }
                break;

            default:
                $calibra_vence = $this->input->post('calibra_vence');
                $municipio = $this->input->post('municipio');
                $tipo = $this->input->post('tipo');
                $marca = $this->input->post('marca');
                $modelo = $this->input->post('modelo');
                $serieNro = trim($this->input->post('serieNro'));
                $estado = $this->input->post('estado');
                $evento = $this->input->post('evento');
                $propietarios = $this->input->post('propietarios');
                $administracion = $this->input->post('administracion');
                break;
        }

        $fecha_desde = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde'));
        $fecha_hasta = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta'));

        if (strlen($serieNro) > 0) {
            $serie = trim($this->input->post('serie'));
        } else {
            $serie = "";
        }

        $result = $this->reportes_model->getReporteRapido($modelo, $tipo, $marca, $municipio, $calibra_vence, $serie, $estado, $fecha_desde, $fecha_hasta, $propietarios, $evento, $administracion, $activo, $role, $userId);

        if (count($result) > 0) {
            switch ($reportes_rapidos) {
                case '1':
                    $this->export_excel->to_excel($result, 'Reporte_Completo_' . date('Y-m-d'));
                    break;

                case '2':
                    $this->export_excel->to_excel($result, 'Equipos_Activos_' . date('Y-m-d'));
                    break;

                case '3':
                    $this->export_excel->to_excel($result, 'Calibraciones_A_Vencer_' . date('Y-m-d'));
                    break;

                default:
                    $this->export_excel->to_excel($result, 'Personalizado_' . date('Y-m-d'));
                    break;
            }

            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }
    }

    public function reportesReparaciones() //Recopila la informacion necesaria para armar el reporte de excel.

    {
        $role = $this->role;
        $userId = $this->session->userdata('userId');

        $reportes_reparaciones = $this->input->post('reportes_reparaciones');

        $fecha_desde2 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde2'));
        $fecha_hasta2 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta2'));
        $fecha_desde4 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde4'));
        $fecha_hasta4 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta4'));

        $result = $this->reportes_model->getReporteReparaciones($fecha_desde2, $fecha_hasta2, $fecha_desde4, $fecha_hasta4, $role, $userId, $reportes_reparaciones);

        if (count($result) > 0) {
            switch ($reportes_reparaciones) {
                case '100':
                    $this->export_excel->to_excel($result, 'Reporte_DDPSV_Abiertas_' . date('Y-m-d'));
                    break;

                case '101':
                    $this->export_excel->to_excel($result, 'Reporte_DDPSV_Cerradas_' . date('Y-m-d'));
                    break;

                case '102':
                    $this->export_excel->to_excel($result, 'Ordenes_Abiertas_' . date('Y-m-d'));
                    break;

                case '103':
                    $this->export_excel->to_excel($result, 'Ordenes_Cerradas_' . date('Y-m-d'));
                    break;
            }
            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }
    }

    public function reportesBajada() //Recopila la informacion necesaria para armar el reporte de excel.

    {
        
        $role = $this->role;
        $userId = $this->session->userdata('userId');

        $reportes_bajada = $this->input->post('reportes_bajada');

        $fecha_desde3 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde3'));
        $fecha_hasta3 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta3'));
        $fecha_desde5 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde5'));
        $fecha_hasta5 = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta5'));

        $municipio2 = $this->input->post('municipio2');
        
        if($municipio2 == "PBA" ){


            if(!$fecha_desde3 || !$fecha_hasta3){
                $this->session->set_flashdata('error', 'Sin datos para el reporte, complete las fechas.');
                redirect('reportes');
            }


            ini_set('memory_limit', '256M');  // ESTA CONSULTA DEBE SER REFACTORIZADA

            $result = $this->reportes_model->getReportePBA($fecha_desde3, $fecha_hasta3);
            if (count($result) > 0) {
                // echo"<pre>";
                // var_dump($result);die;
                $this->export_excel->to_excel($result, 'Bajada_Memoria_pba_' . date('Y-m-d'));
                $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
            }else {
                $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
                redirect('reportes');
            }

        }else{

            // lionel -> bloque comentado para que genere la descarga el form Equipos|Reportes Excel|Bajada de memoria|Total archivos ingresados (24/10/24)
            // if(!$fecha_desde3 || !$fecha_hasta3){
            //     $this->session->set_flashdata('error', 'Sin datos para el reporte, complete las fechas.');
            //     redirect('reportes');
            // }
            // lionel -> fin bloque comentado

            $result = $this->reportes_model->getReporteBajada($fecha_desde3, $fecha_hasta3, $fecha_desde5, $fecha_hasta5, $role, $userId, $reportes_bajada, $municipio2);

            if (count($result) > 0) {
                switch ($reportes_bajada) {
                    case '200':
                        $this->export_excel->to_excel($result, 'Bajada_Memoria_' . date('Y-m-d'));
                        break;

                    case '201':
                        $this->export_excel->to_excel($result, 'Total_De_Archivos_' . date('Y-m-d'));
                        break;
                }
                $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
            } 
            
            else {
                $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
                redirect('reportes');
            }

        }
    }

    public function reportesCalibraciones() //Recopila la informacion necesaria para armar el reporte de excel.

    {
        $reportes_calibraciones = $this->input->post('reportes_calibraciones');
        switch ($reportes_calibraciones) {
            case '300':
                if ($this->input->post('fecha_proxima') == "") {
                    $fecha_proxima = null;
                } else {
                    $fecha_proxima = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_proxima'));
                }

                $result = $this->reportes_model->getReporteCalib($fecha_proxima, $this->role, $this->vendorId, $reportes_calibraciones);
                $name = 'Calibraciones_proximas_';
                break;

            case '301':
                $proyecto = $this->input->post('proyecto');
                $tipo_orden = $this->input->post('tipo_orden');
                $tipo_servicio = $this->input->post('tipo_servicio');
                $tipo_equipo = $this->input->post('tipo_equipo');

                $result = $this->reportes_model->getOrdenesCalibraciones($proyecto, $tipo_orden, $tipo_servicio, $tipo_equipo);
                $name = 'Ordenes_Calibraciones_';
                break;
        }

        if (count($result) > 0) {
            $this->export_excel->to_excel($result, '' . $name . '' . date('Y-m-d'));
            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }
    }

    public function reportesInstalaciones()
    {
        $proyecto = $this->input->post('proyecto');

        switch ($this->input->post('tipo_orden')) {
            case 'A':
                $tipo_orden = "3,4,5,6,10,11";
                break;
            case 'F':
                $tipo_orden = "7";
                break;
            default:
                $tipo_orden = "0";
                break;
        }

        if ($this->input->post('rango_fecha') == 7 || $this->input->post('rango_fecha') == 14 || $this->input->post('rango_fecha') == 30) {

            $dias = 'P' . $this->input->post('rango_fecha') . 'D';

            $hoy = new DateTime(date('Y-m-d H:i:s'));
            $fecha_hasta = $hoy->format('Y-m-d H:i:s');
            $hoy->sub(new DateInterval($dias));
            $fecha_desde = $hoy->format('Y-m-d 00:00:00');

        } elseif ($this->input->post('rango_fecha') == 1) {
            $fecha_desde = $this->fechas->cambiaf_a_mysql($this->input->post('fd_insta'));
            $fecha_hasta = $this->fechas->cambiaf_a_mysql($this->input->post('fh_insta'));
        }

        $result = $this->reportes_model->getOrdenesInstalaciones($proyecto, $tipo_orden, $this->role, $this->vendorId, $fecha_desde, $fecha_hasta);

        if (count($result) > 0) {
            $this->export_excel->to_excel($result, 'Ordenes_instalacion' . date('Y-m-d'));
            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }

    }

    public function diasOperativos()
    {
        if (!$this->input->post('fecha_desde6') || !$this->input->post('fecha_hasta6')) {
            redirect('reportes');
        }
        $role = $this->role;
        $userId = $this->session->userdata('userId');

        $fecha_desde = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde6'));
        $fecha_hasta = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta6'));
        $proyecto = $this->input->post('municipio3');
        $tipo_equipo = $this->input->post('tipo');
        $serie = $this->input->post('equipo');

        $result = $this->reportes_model->getEquiposDiasOperativos($fecha_desde, $fecha_hasta, $proyecto, $tipo_equipo, $serie[0]);
        $cant = count($result);
        $previo = null;

        for ($i = 0; $i <= $cant - 1; $i++) {
            if (!is_null($previo) && $result[$i]->equipo == $result[$previo]->equipo) {
                $result[$previo]->dias_reparacion += $result[$i]->dias_reparacion;
                $result[$previo]->porcentaje += $result[$i]->porcentaje;
                unset($result[$i]);
            } else {
                $previo = $i;
            }
        }

        if (count($result) > 0) {
            $this->export_excel->diasOperativos($result, 'Dias_equipos_reparaciones_' . date('Y-m-d'), $fecha_desde, $fecha_hasta);
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }
    }

    public function ultima_bajada()
    {
        $proyecto = $this->input->post('proyecto_ultimaBajada');
        $fecha_maxima = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_ultimaBajada'));

        $result = $this->reportes_model->getUltimaBajada($proyecto, $fecha_maxima, $this->role, $this->vendorId);

        if (count($result) > 0) {
            $this->export_excel->to_excel($result, 'ultima_bajada' . date('Y-m-d'));
            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
            redirect('reportes');
        }
    }

    public function estadisticas_equipo()
    {
        $this->global['pageTitle'] = 'CECAITRA : Estadisticas Equipo';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $viewdata['proyectos'] = $this->municipios_model->getProyectos();
        $viewdata["informe"] = false;

        $this->load->view('reportes/estadisticas_equipo', $viewdata);
        $this->load->view('includes/footer',$this->global);
    }

    public function equipos_by_modelo()
    {
        if ($this->input->is_ajax_request()) {
            $proyecto = $this->input->post('proyecto');
            $modelo = $this->input->post('modelo');
            $modelos = $this->reportes_model->listado_equipos_byModelo($proyecto, $modelo);
            // $modelos[0] = array('id' => 0, 'descrip' => 'Todos los equipos');
            echo json_encode($modelos);
        } else {
            echo "No direct script allowed";
        }
    }

    public function equipos_modelos_ssti()
    {
        $proyecto = $this->input->post('proyecto');
        $modelos = $this->reportes_model->listado_modelos($proyecto);
        // $modelos[0] = array('id' => 0, 'descrip' => 'Todos los equipos');
        echo json_encode($modelos);
    }

    public function estadisticas_excel()
    {

        $proyecto = $this->input->post('idproyecto');
        $modelo = $this->input->post('idmodelo');
        $idequipo = $this->input->post('idequipo');
        $fecha = $this->input->post('fecha');
        $separator_dates = explode("/", $fecha);
        $fecha_desde = $separator_dates['0'];
        $fecha_hasta = $separator_dates['1'];

        if ($idequipo != 0) {
            $serie = $this->equipos_model->getIDxSerie($idequipo[0]);
        } else { // en el caso que se solicitan todos los equipos
            $serie = $idequipo[0];
        }
        if ($modelo == '4' || $modelo == '63' || $modelo == '68') {
            $data = 0;
            $datos = $this->reportes_model->estadisticas_vel($serie, $fecha_desde, $fecha_hasta);
            //Recibir el array
            if (count($datos) > 0) {
                $this->export_excel->to_excel($datos, 'Estadisticas-' . $idequipo[0] . '-' . date('Y-m-d'));
                echo json_encode($data);
                $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');

            } else {
                $this->session->set_flashdata('error', 'Sin datos para el informe, intentar con otros datos.');
                redirect('reportes/estadisticas_equipo');
            }

        } else {
            $data = 0;
            $datos = $this->reportes_model->estadisticas_enf($serie, $fecha_desde, $fecha_hasta);
            //Recibir el array
            if (count($datos) > 0) {
                $this->export_excel->to_excel($datos, 'Estadisticas-' . $idequipo[0] . '-' . date('Y-m-d'));
                $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
            } else {
                $this->session->set_flashdata('error', 'Sin datos para el informe, intentar con otros datos.');
                redirect('estadisticas_equipo');
            }
        }

    }

//------ este controlador tiene la mayoria de sus cosas hechas en la vista ya que se trabaja con ajax--
    public function salida_de_edicion()
    {
        $datosSalidaEdicion = $this->input->post('datos');

        $data = explode(",", $datosSalidaEdicion);

        $protocolos = $this->reportes_model->salida_edicion($incorporacion_estado = $data[0], $decripto = $data[1], $estado = $data[2], $municipio = $data[3]);

        if (empty($protocolos)) {
            echo "0"; //imprimo 0 para desde la vista saber que no devolvio nada asi puedo imprimir un cartel
        } else {
            $protocolos = json_encode($protocolos, true);
            echo $protocolos;
        }

    }

    public function exportaciones()
    { 
        $j = 0;
        //obtengo los protocolos que seleccionados por el usuario via get(FORMULARIO)
        $protocolos_usuario = $this->input->post('protocolos_check');

        //si el usuario apreta el boton sin seleccionar ningun protocolo devuelvo un cartel de error
        if (empty($protocolos_usuario)) {
            $this->session->set_flashdata('error', 'DEBE SELECCIONAR POR LO MENOS UN PROTOCOLO PARA EXPORTAR');
            redirect('reportes');
        }
        //me llevo el usuario que esta ejecutando el script

        $serie = $this->reportes_model->getSerie($protocolos_usuario[0]); //solamente uso el usuario posicion 0 ya que no le permito elegir luces y no luces
        //la serie va a ser de luces o de no luces si o si porque lo limito desde la vista, por ende con la primer posicion me alcanza
        if (strpos($serie[0]->equipo_serie, 'DTV2') !== false || strpos($serie[0]->equipo_serie, 'LUTEC') !== false) {
            //  Equipos que son de luces
            foreach ($protocolos_usuario as $proto) {
                $excel[$j]->protocolo = $proto; //se cargan los protocolos para el array de objetos que necesita el excel
                //verifico si algun estado esta en 26 en la tabla entrada
                $estado = json_decode(json_encode(file_get_contents("http://ssti.cecaitra.com/WS/estado_26_luces.php?protocolo=$proto.php")));
                // $estado = json_decode(json_encode(file_get_contents("http://localhost/project3226/estado_26_luces.php?protocolo=$proto")))
     
                if ($estado == "null") { //el web servise lo devuelve un "null" si no encotro ningun estado en 26 para el protocolo

                    $this->reportes_model->updateProtocoloMain($proto); //hago un update en 63 incorporacion estado
                    $excel[$j]->fallidos_update = "Protocolo :{$proto}-> incorporacion_estado actualizado a 63 por no tener ningun estado de Entrada en 26";
                    $excel[$j]->estado = null;
                    $excel[$j]->insert_exportacion = null;
                    $excel[$j]->exportaciones = null;
                    $j++;
                    $fallidos[] = $proto;
                    //se van agregando a un array los protocolos se pasaron la incorporacion_estado a
                } else {
                    $excel[$j]->fallidos_update = null;
                    $j++;

                }
            }
            
            $exitosos = array_diff($protocolos_usuario, $fallidos); //si son de luces no verifico el impacto asi que exporto todos los protocolos
         
        } else { // Equipos que NO son luces
            $j = 0;
            foreach ($protocolos_usuario as $protocolo) { //ciclar primeros webservice para fijarme cuales estan bien impactados y cuales no

                $excel[$j]->protocolo = $protocolo;
                $verificarImpacto = "http://ssti.cecaitra.com/WS/verificar_impacto.php?protocolo=$protocolo";
                // $verificarImpacto = "http://localhost/project3226/verificar_impacto.php?protocolo=$protocolo";
                $dataWS = json_decode(json_encode(file_get_contents($verificarImpacto), true));
                //precargo las columnas que van a completarse si la exportacion tiene que realizarse y no fallo el impacto 
                $excel[$j]->incorporacion_estado = json_decode($dataWS)->fallidos_update;
                $excel[$j]->estado = null;
                $excel[$j]->insert_exportacion = null;
                $excel[$j]->exportaciones = null;
                $j++;

                $fallidos1[] = (json_decode($dataWS)->fallido);
                $fallidos = array_filter($fallidos1, function ($value) {
                    return $value !== null;
                });
            }

            $exitosos = array_diff($protocolos_usuario, $fallidos);

        } //fin de equipos NO luces

        //CODIGO QUE EJECUTAN TODOS LOS PROTOCOLOS SIN IMPORTAR QUE TIPO DE EQUIPO SON
        
        
        //datos para el insert en exportaciones_main
        $numeroExportacion = json_decode(json_encode(file_get_contents("http://ssti.cecaitra.com/WS/get_numero_exportacion.php")));
        // $numeroExportacion = json_decode(json_encode(file_get_contents("http://localhost/project3226/get_numero_exportacion.php")));
        $proyecto = $this->reportes_model->getMunicipioEdicion($protocolos_usuario[0]); //le paso solo la posicion 0 ya que todos los protocolos van a pertenecer al mismo municipio/proyecto porque los listo por ajax con el municipio como parametro de la consulta
        $usuario = $this->vendorId; //cargo el usuario que esta ejecutando el sc
        $i = 0;

        $j = 0; //j es el iterador de las filas del excel
        //con este foreach voy armando el excel segun corresponda con los protocolos que me quedaron como exitosos
        foreach ($protocolos_usuario as $exitoso) {
            if ($excel[$j]->protocolo == "$exitoso" && in_array($exitoso, $fallidos)) {
                //el protocolo de la linea de excel es fallido setteo los demas campos a null
                $excel[$j]->estado = null;
                $excel[$j]->insert_exportacion = null;
                $excel[$j]->exportaciones = null;
                $j++;
                // continue;
            } else {
           
                $ultimoId = json_decode(json_encode(file_get_contents("http://ssti.cecaitra.com/WS/get_last_id_exportacion.php", true)));
                $ultimoId = intval(substr($ultimoId, 1, -1));

                $wsValidacion = json_decode(json_encode(file_get_contents("http://ssti.cecaitra.com/WS/validacion_exportacion.php?protocolo=$exitoso")));
                //validacion pára ver si el protocolo esta en exportaciones_aux
                if (json_decode($wsValidacion)->cantidad != null) { //si es distinto de null significa que exta repetido el protocolo en exportaciones_au
               
                    $idExpoFallido = json_decode($wsValidacion)->idexportacion;

                   
                    $excel[$j]->protocolo_repetido = "Protocolo {$exitoso} ya ingresado en exportaciones_aux con el numero : {$idExpoFallido} ,porfavor modificarlo manualmente";
                    $j++;
                 
                    continue; //si no realizo el continue el controlador sigue ejecutando el protocolo que no debo realizar la exportacion
                }
                $webServiceInsert = "http://ssti.cecaitra.com/WS/incorporar_exportacion.php?usuario=$usuario&municipio=$proyecto&numero=$numeroExportacion";
                $wsInsert[] = json_decode(json_encode(file_get_contents($webServiceInsert), true));

                $ultimoId = json_decode(json_encode(file_get_contents("http://ssti.cecaitra.com/WS/get_last_id_exportacion.php", true)));
                $ultimoId = intval(substr($ultimoId, 1, -1)) + $k;
                $k++; // se lo sumo al ultimo id, en la primer vuelta devuelve bien, pero siempre me devuelve el anterior

                if ($ultimoId > 0 && in_array($exitoso, $exitosos)) {
                    
                    $ws_final = "http://ssti.cecaitra.com/WS/ws_final.php?numeroExportacion=$numeroExportacion&idprotocolo=$exitoso&idexportacion=$ultimoId&proyecto=$proyecto";
                    $idExpoAux[] = json_decode(json_encode(file_get_contents($ws_final), true));
                 
                    $excel[$j]->estado = json_decode($idExpoAux[$i])->inco;
                    $excel[$j]->insert_exportacion = json_decode($idExpoAux[$i])->insert_exporAux;
                    $excel[$j]->exportaciones = "Protocolo : {$exitoso} -> Se genero la exportacion # $numeroExportacion Con el Id :  $ultimoId Del proyecto $proyecto";
                   
                }
                $j++;
                $i++;

            }

        }         
        $this->export_excel->to_excel($excel, "Salida de Edicion - " . date("Y-m-d"));
    }

    /* function cargar_estadisticas()
    {
    $this->global['pageTitle'] = 'CECAITRA : Estadisticas Equipo';
    $this->load->view('includes/header', $this->global);
    $this->load->view('includes/menu', $this->menu);
    $this->load->view('reportes/estadisticas_carga');
    $this->load->view('includes/footer',$this->global);
    } */

    /* function cargar_estadisticas_archivo()
    {
    $data = array();
    $this->global['pageTitle'] = 'CECAITRA : Cargar Estadisticas ';
    $this->load->view('includes/header', $this->global);
    $this->load->view('includes/menu', $this->menu);

    $nombre_actual = $_FILES['archivo']['name'];
    $nombre_temp   = $_FILES['archivo']['tmp_name'];
    $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));

    $protocolo = 1234;

    // die(var_dump($this->input->post()));

    if($_SERVER['HTTP_HOST'] === "localhost"){
    //Localhost
    $directorio_archivos = "/var/www/html/archivos/";
    $nombre_carpeta = "protocolo".$protocolo;
    $destino_carpeta =  $directorio_archivos.$nombre_carpeta;
    }else{
    //SC - SCDEV
    //$destino = documentacion.$sector.'/'.$parametro."_$fecha"."$ext";
    //$nombre_carpeta = "protocolo".$protocolo;
    }

    //
    if ($result_crear_dir = Carpetas_lib::crear_carpeta($directorio_archivos,$nombre_carpeta,0777)){
    $result_mover_archivo = Archivos_lib::archivo_moverArchivo($nombre_temp,$destino_carpeta);

    die('carlos');
    }else{
    die('carlitos');
    } */

    /* if (count($data["archivos"]) > 0) {
    $this->session->set_flashdata('success',  count($data["archivos"]).' Informe de Excel descargado correctamente.');
    //  redirect('cargar_estadisticas');
    } else {
    $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
    // redirect('cargar_estadisticas');
    }*/

    /* $this->load->view('reportes/estadisticas_carga');
    $this->load->view('includes/footer',$this->global);
    } */

    /* function estadisticas_form()
    {
    $data = array();
    $this->global['pageTitle'] = 'CECAITRA : Estadisticas Equipo';
    $this->load->view('includes/header', $this->global);
    $this->load->view('includes/menu', $this->menu);

    $data["id_equipo"] = $this->input->post('idequipo');
    $data["municipio"] = $this->input->post('municipio');

    $this->obtener_archivos($data["archivos"]);
    $this->leer_archivos($data["archivos"]);

    if (count($data["archivos"]) > 0) {
    $this->session->set_flashdata('success',  count($data["archivos"]).' Informe de Excel descargado correctamente.');
    redirect('estadisticas_equipo');
    } else {
    $this->session->set_flashdata('error', 'Sin datos para el reporte, intentar con otros datos.');
    redirect('estadisticas_equipo');
    }
    }  */

    /* function obtener_archivos(&$array)
    {
    $path = "/var/www/html/archivos/enforcer/";
    $ficheros = new RecursiveIteratorIterator(new RecursiveDirectoryIterator( $path));

    foreach ($ficheros as $file) {
    if (!$file->isDir()){
    $array[] = $file->getPath()."/".$file->getFilename();
    }
    }
    } */

    /* function leer_archivos(&$ruta_archivos)
    {

    $data = array();
    $index = count($ruta_archivos);

    for ($i=0; $i < $index; $i++) {

    if($lineas = file($ruta_archivos[$i])) {
    foreach ($lineas as $linea) {
    $data[] = explode(',', $linea);
    }
    }

    }

    } */

    public function reportes_sistemas()
    {
        $fecha_desde = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_desde7'));
        $fecha_hasta = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_hasta7'));

        $result = $this->reportes_model->reportes_sistemas($fecha_desde, $fecha_hasta);
        $result[0]->registros = intval($result[0]->registros);

        $aprobadas = json_decode(file_get_contents("http:\\201.216.208.202/integral/exportar/_ws_resumen_produccion.php?fd=$fecha_desde&fh=$fecha_hasta"), true);

        if ($aprobadas != false) {
            $result[0]->aprobadas = $aprobadas['aprobadas'];
        } else {
            $result[0]->aprobadas = '#SIN DATO';
        }

        $exportaciones_totales = json_decode(file_get_contents("http://ssti.cecaitra.com/WS/exportaciones_totales.php?fd=$fecha_desde&fh=$fecha_hasta"), true);

        if ($exportaciones_totales != false) {
            //si esto no funciona es culpa de rudzki
            foreach ($exportaciones_totales as $iey => $value) {
                $result[0]->$iey = $value;
            }
        } else {
            //esto se hace asi ya que al no saber los valores de las keys que llegan por webservice
            $result[0]->sinDato1 = '#SIN DATO';
            $result[0]->sinDato2 = '#SIN DATO';
            $result[0]->sinDato3 = '#SIN DATO';
        }

        if (count($result) > 0 && !is_null($result[0]->aprobadas)) {
            $this->export_excel->to_excel($result, 'Produccion' . date('Y-m-d'));
            $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
            redirect('reportes');
        } else {
            $this->session->set_flashdata('Error', 'Sin datos para el informe, intentar con otros datos.');
            redirect('reportes');
        }
    }

    
    public function trazabilidad_reportes_excel(){
        $fecha_desde = $this->input->post('fecha_desde8');
        $fecha_hasta = $this->input->post('fecha_hasta8');
        $proyecto = $this->input->post('proyecto');
        $municipios = json_decode($this->input->post('municipios'),true);
        $fecha_desde = date('Y-m-d', strtotime($fecha_desde));
        $fecha_hasta = date('Y-m-d', strtotime($fecha_hasta));
        $userId = $this->session->userdata('userId');
        // Obtener los datos de la base de datos
        if($userId == '101' or $userId == '275' ){ //se agrego alex como usuario para probar
            $data = $this->reportes_model->get_trazabilidad_por_proyecto_martin($proyecto, $fecha_desde, $fecha_hasta, $municipios);
        }else{
            $data = $this->reportes_model->get_trazabilidad_por_proyecto($proyecto, $fecha_desde, $fecha_hasta, $municipios);
        }

        $this->export_excel->to_excel($data, "Trazabilidad Por Proyecto" . date("Y-m-d"));
        $this->session->set_flashdata('success', 'Informe de Excel descargado correctamente.');
    }
    
    


}
