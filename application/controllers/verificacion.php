<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Verificacion extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('verificacion_model');
        $this->load->model('municipios_model');
        $this->load->model('equipos_model');
        $this->load->model('protocolos_model');
        $this->load->model('user_model');
        $this->load->model('ssti_model');
        $this->load->model('ordenesb_model');
        $this->load->library('pagination');
    }

    

//////////// VISTAS ///////////////

// vista general x proyecto
    
// vista x protocolo 

// vista verificacion rapida
    function preverificacion($id_protocolo)
    {

      $data['fotos'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,26);
      $data['eliminados'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,27);

      $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);
      $data['id_protocolo'] = $id_protocolo;
      $data['titulo'] = "preverificacion";

      $this->global['pageTitle'] = 'CECAITRA : preverificacion';
      $this->load->view('includes/header_layout', $this->global);
      
      $this->load->view('verificacion/preverificacion', $data);
      $this->load->view('includes/footer',$this->global);

    }
    



//verificacion con varias imagenes
    function ver_editadas($id_protocolo = NULL)
    {
        $data['fotos'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,26);
        $data['eliminados'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,27);
        $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);
        $data['id_protocolo'] = $id_protocolo;
        $data['titulo'] = "Ver editadas";
        $data['ultimo'] = $this->verificacion_model->getAsignacion($id_protocolo);

        $this->global['pageTitle'] = 'CECAITRA : Editadas aprobadas';
        $this->load->view('includes/header_layout', $this->global);
        
        $this->load->view('verificacion/editadas_aprobadas', $data);
        $this->load->view('includes/footer',$this->global);

    }

    //A revisar
    function verificacion_descartadas($id_protocolo = NULL)
    {
        $data['fotos'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,27);
        $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);

        $data['id_protocolo'] = $id_protocolo;
        $data['titulo'] = "Verificacion descartadas";

        $this->global['pageTitle'] = 'CECAITRA : Verificacion descartadas';
        $this->load->view('includes/header_layout', $this->global);
        //$this->load->view('includes/menu', $this->menu);
        $this->load->view('verificacion/imagenes_verificadas', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function verificacion_aprobadas($id_protocolo = NULL)
    {
        $data['fotos'] = $this->verificacion_model->getListadoFotosEA($id_protocolo,26);
        $data['protocolo'] = $this->verificacion_model->getIDprotocolo($id_protocolo);
        $data['id_protocolo'] = $id_protocolo;
        $data['titulo'] = "Verificacion aprobadas";

        $this->global['pageTitle'] = 'CECAITRA : Verificacion aprobadas';
        $this->load->view('includes/header_layout', $this->global);
        //$this->load->view('includes/menu', $this->menu);
        $this->load->view('verificacion/imagenes_verificadas', $data);
        $this->load->view('includes/footer',$this->global);
    }


    ////////////////// ACCIONES

    function impactar_protocolo($id_protocolo = NULL)
    {

      if($id_protocolo == NULL){
        $this->session->set_flashdata('error', 'Este protocolo no existe.');
        redirect('verificar_protocolos');
      }

      $data = $this->verificacion_model->getInfoProtocolo($id_protocolo);

      $dominios_modificiados = $this->verificacion_model->getDominiosImpactar($id_protocolo);

      $eliminados = $this->verificacion_model->getFotosImpactar($id_protocolo,27);

      $resultado = TRUE;
      


      if($this->anular_protocolo($eliminados,$data->info_aprobados,$id_protocolo)){
        return TRUE;
      }else{
        

        if(equipo_semaforo($data->equipo_serie)){
          
          $infracciones = $this->verificacion_model->getInfraccionImpactar($id_protocolo);

          if($infracciones){

            $resultado_ws_sf = $this->call_web_service(
              "impactar_verificacion_semaforo",
              [
                  "p" => $id_protocolo,
                  "r" => json_encode($infracciones)
                ],"post"
            );
                  
            if(!$resultado_ws_sf){              
              $resultado = FALSE;
            }      
          }

        }

        if($dominios_modificiados){

          $resultado_ws_sf = $this->call_web_service(
            "impactar_verificacion_dominio",
            [
                "p" => $id_protocolo,
                "r" => json_encode($dominios_modificiados)
            ],"post"
          );



          if(!$resultado_ws_sf){
            $resultado = FALSE;
          }  


        }

        if($eliminados){

          $resultado_ws_sf = $this->call_web_service(
            "impactar_verificacion_V2",
            [
                "p" => $id_protocolo,
                "r" => json_encode($eliminados)
              ],"post"
          );

          if(!$resultado_ws_sf){
            $resultado = FALSE;
          }  
        }      

        if(!$eliminados && $resultado){

          //Elimino los registros de este protocolo de la tabla Entrada Auxiliar.
          $this->verificacion_model->eliminarProtocolo($id_protocolo);

          //Actualizo protocolos_main. Si no se elimino nada
          $verificacionInfo = array('incorporacion_estado' => 65, 'decripto' => 4, 'est_verificacion' => 60);
          $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);

          
          return TRUE;
        }



        if ($resultado) {

          //Elimino los registros de este protocolo de la tabla Entrada Auxiliar.
          $this->verificacion_model->eliminarProtocolo($id_protocolo);

          // Consulto las aprobadas y descartadas para armar el array de datos de protocolos_main.
          $asignacion = $this->verificacion_model->getAsignacion($id_protocolo);
          $verificacionInfo = array('incorporacion_estado' => 65, 'decripto' => 4, 'est_verificacion' => 50, 'info_aprobados' => $asignacion->aprobados, 'info_verificacion' => $asignacion->descartados);

          //Actualizo protocolos_main.
          $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
        
          return TRUE;

        } else {
          return FALSE;

        }
      }
      
    }

    function anular_protocolo($eliminados,$info_aprobados,$id_protocolo)
    {
      if(count($eliminados)!=$info_aprobados){
        return false;
      }

      $motivo = "Eliminado totalmente en verificacion";

      $data_orden =array('subida_observ' => $motivo);

      $this->ordenesb_model->editOrdenesb_protocolo($id_protocolo,$data_orden);

      //Anulo el protocolo desde protocolos_main.
      $protocolo_anulado = array('decripto' => 5, 'incorporacion_estado' => 40, 'estado' => 0, 'est_verificacion' => 70);

      $this->protocolos_model->updateProtocolosMain($protocolo_anulado, $id_protocolo);
      $this->verificacion_model->eliminarProtocolo($id_protocolo);
      $this->verificacion_model->eliminarVerificacionAsignados($id_protocolo);
            
      return true;      

      
    }

    function actualizar_entrada($id_protocolo = NULL)
    {
      if($id_protocolo == NULL){
        $this->session->set_flashdata('error', 'Este protocolo no existe.');
        redirect('verificar_protocolos');
      }else{
        $result = $this->impactar_protocolo($id_protocolo);

        if($result){
            $this->session->set_flashdata('success', "Protocolo $id_protocolo impactado correctamente en Entrada.");
        }else{
          $this->session->set_flashdata('warning', "Protocolo $id_protocolo impactado parcialmente. los registros no se impactaron correctamente, por favor volver a impactar.");

        }

        redirect('verificar_protocolos');

      }

      
    }



    function actualizar_entrada_todos()
    {
      

      $protocolos = $this->verificacion_model->getProtocolos_impacto_final();

      if($protocolos){
        foreach ($protocolos as $protocolo) {
          $this->impactar_protocolo($protocolo->id);            
        }     
        $this->session->set_flashdata('success', "Se finalizo todos los protocolos.");
      } else {
        $this->session->set_flashdata('warning', "NO HAY PROTOCOLOS.");
      }
      
      redirect('verificar_protocolos');
    }


    function copiar_registros($proyecto,$id_protocolo = NULL)
    {

      if ($id_protocolo == NULL) {
          $this->session->set_flashdata('error', 'Este protocolo no existe.');
          redirect('verificar_protocolos');
      }

      $respuesta = $this->copiado_individual($proyecto,$id_protocolo);

      if($respuesta == 1){
        $this->session->set_flashdata('warning', "Error al realizar la solicitud ");
      }else if($respuesta == 2){
        $this->session->set_flashdata('warning', 'El protocolo aún no fue impactado de Edición. / Servidor ocupado, intentar más tarde.');
      }else if($respuesta == 3){
        $this->session->set_flashdata('error', 'El protocolo ya fue incorporado');                
      }else if($respuesta == 5){
        $this->session->set_flashdata('error', 'El protocolo no hay tiene registros Aprobados (26). Eliminado');                
      }else{
        $this->session->set_flashdata('success', 'Protocolo copiado correctamente al SC.');

      }
        
      
  
      redirect('verificar_protocolos');
    }

    function copiado_individual($proyecto,$id_protocolo = NULL){
      
      $listado_proyectos_impacto_directo =  array(112,114,115,116,117,118,119,131,132,133,134,135,136,137,139,140,144,146,147,150,151,154,155,156,157,158,159,160,161,162);

      if($proyecto == 7){

        $content2 = $this->call_web_service(
          "impactar_verificacion_caba",
          [
              "p" => $id_protocolo
          ]);

          if ($content2 === false) {
            return 1;
        }
      }

      if (in_array($proyecto, $listado_proyectos_impacto_directo)) {        

          $verificacionInfo = array('estado' => 0,'incorporacion_estado' => 65, 'decripto' => 4, 'est_verificacion' => 0);
          $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
          return 4;

      }else{
      
          $content = $this->call_web_service(
            "get_imagenes_entrada",
            [
                "p" => $id_protocolo
            ]
          );
          
          if ($content === false) {
              return 1;

          } else {
              
              if (!$content) {
                //No tiene material aprobado

                $content_discart = $this->call_web_service(
                  "get_descarte_entrada",
                  [
                      "p" => $id_protocolo
                  ]
                );

                if ($content_discart) {
                  //Tiene material desaprobado

                  $verificacionInfo = array('estado' => 0,'incorporacion_estado' => 30, 'decripto' => 5, 'est_verificacion' => 0);
                  $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
                  return 5;

                }else{
                  return 2;

                }
              }
      
              if ($this->verificacion_model->getAsignacion($id_protocolo)){
                // Incorporado con asignacion
                $verificacionInfo = array('est_verificacion' => 40);    
                $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
                return 3;

              }else{
                  // Incorporado 0

                  $i = 0;
                  
                  foreach ($content as $fotoinfo) {
                      $this->ssti_model->addProtocoloEA($fotoinfo);
                      $i++; //esto va a tener tendencia a buggear  
                  }//                                         -- Si
          
                  $asignacionInfo = array('id_protocolo' => $id_protocolo, 'cant_inicial' => $i, 'aprobados' => $i);
                  $verificacionInfo = array('est_verificacion' => 20);
                  $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
                  $this->verificacion_model->addVerificacionAsignados($asignacionInfo);
                              
                  return 4;

              }
          }

      }
    }
    function asignar_verificador()
    {
      $id_protocolo = $this->input->post('id_protocolo');
      $verificador = $this->input->post('verificador');


      $asignacionInfo = array('usuario'=> $verificador);
      $resultado = $this->verificacion_model->updateAsignacion($asignacionInfo, $id_protocolo);

      if ($resultado) {
        $verificacionInfo = array('est_verificacion'=> 30);
        $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);
      
        $this->session->set_flashdata('success', 'Verificador asignado correctamente.');
      } else {
        $this->session->set_flashdata('error', 'Error al asignar verificador.');
      }

      redirect('verificar_protocolos');
    }




    function cerrar_asignacion()
    {
      $id_protocolo = $this->input->post('id_protocolo');

      if($id_protocolo == NULL){
        $this->session->set_flashdata('error', 'Este protocolo no existe.');
        redirect('protocolos_asignados');
      }

      $verificacionInfo = array('est_verificacion'=> 40);
      
      $resultado = $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);

      if ($resultado) {
        $this->session->set_flashdata('success', 'Asignacion cerrada correctamente.');
      } else {
        $this->session->set_flashdata('error', 'Error al cerrar una asignacion');
      }

      redirect('protocolos_asignados');
    }


    function volver_asignar()
    {
      $id_protocolo = $this->input->post('id_protocolo');

      if($id_protocolo == NULL){
        $this->session->set_flashdata('error', 'Este protocolo no existe.');
        redirect('verificar_protocolos');
      }

      $verificacionInfo = array('est_verificacion'=> 30);
      $resultado = $this->verificacion_model->updateVerificacion($verificacionInfo, $id_protocolo);

      if ($resultado) {
        $this->session->set_flashdata('success', 'Protocolo re asignado correctamente.');
      } else {
        $this->session->set_flashdata('error', 'Error al reasingar el protocolo.');
      }

      redirect('verificar_protocolos');
    }



    function habilitar_verificacion()
    {
        $protocolos = $this->verificacion_model->getProtocolosImpactados();

        if ($protocolos) {
          $verificacionInfo = array('incorporacion_estado' => 69, 'decripto' => 4, 'est_verificacion' => 10);

          foreach ($protocolos as $key => $protocolo) {
            $this->verificacion_model->updateVerificacion($verificacionInfo, $protocolo->id);
          }

          $this->session->set_flashdata('success', 'Protocolos habilitados para su Verificacion correctamente.');

        } else {
          $this->session->set_flashdata('error', 'Aun no hay Protocolos impactados.');
          
        }

        redirect('control_verificacion');
    }




    function copiar_registros_proyecto($id_proyecto = NULL)
    {
        // Buscar todos los protocolos que están en estado 10 de todos o un proyecto en particular
        $protocolos = $this->verificacion_model->listadoProtocolosProyectos($id_proyecto, 10);
    
        if (!$protocolos) {
            $this->session->set_flashdata('error', 'No hay protocolos para verificar en el SC.');
            redirect('control_verificacion');
        }
    
        $contador = count($protocolos);
        // Recorro el listado de protocolos.
        foreach ($protocolos as $protocolo) {
          $respuesta = $this->copiado_individual($id_proyecto,$protocolo->id);
          if($respuesta == 4){
            $contador--;
          }
        }

        if($contador == count($protocolos)){
          $this->session->set_flashdata('error', "Error al realizar la solicitud ");        
        }else if($contador > 0){
          $this->session->set_flashdata('error', 'Error al procesar algunos protocolos no fueron copiados');                
        }else{
          $this->session->set_flashdata('success', 'Protocolo copiado correctamente al SC.');
        }
    
        redirect('control_verificacion');
    }
    




    function eliminar_protocolo ()
    {



       $id_protocolo = $this->input->post('id_protocolo');

       $motivo = $this->input->post('motivo_descarte');

       $data_orden =array('subida_observ' => $motivo);


       $this->ordenesb_model->editOrdenesb_protocolo($id_protocolo,$data_orden);

        //Anulo el protocolo desde protocolos_main.
        $protocolo_anulado = array('decripto' => 5, 'incorporacion_estado' => 40, 'estado' => 0, 'est_verificacion' => 70);

        $this->protocolos_model->updateProtocolosMain($protocolo_anulado, $id_protocolo);
        $this->verificacion_model->eliminarProtocolo($id_protocolo);
        $this->verificacion_model->eliminarVerificacionAsignados($id_protocolo);

        
        redirect('verificar_protocolos');

     
    }

    function estado_entrada_preverificacion()
    {
      //esta funcion hace muchas cosas refactorizar

      if (!$this->input->is_ajax_request()) {
         exit('No direct script access allowed');
      } else {
        //este total de imangenes deberia ser igual a las aprobadas por edicion 
        $id_protocolo = $this->input->post('id_protocolo');
        $id_entradas = $this->input->post('checkbox_names');
        $total_imagenes = intval($this->input->post('totalImagenes'));


        if ($id_entradas) {
          
          $descartadas = count($id_entradas);
        
          //valores de las 2 tablas a modificar 

          //1-asignacion me llegan los campos de verificacion_asignaciones 
          $verificacion_asignaciones = $this->verificacion_model->getAsignacion($id_protocolo); 
                    
          //2-datos a settear en protocolos main 
          $protocolos_main_info = $this->verificacion_model->getProtocolos_mainInfo($id_protocolo); 
          // pre($verificacion_asignaciones);
          //calcular datos para verificacion_asignacion 
          $nuevas_aprobadas = $total_imagenes - $descartadas;
          $nuevas_descartadas = (int)$verificacion_asignaciones->descartados + $descartadas;

          // $nuevas_descartadas = ($total_imagenes + $asigancion['descartados']) - ($total_imagenes- $descartadas); //otra manera que pense para ver los descartes de verificacion
          
          //calcular datos para protocolos_main 
          $info_aprobadas = intval($protocolos_main_info['info_aprobados']) - $descartadas;
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
          
          foreach($id_entradas as $id_entrada) {
            $entradaInfo = array('estado' => 27);
            $this->ssti_model->updateEntradaAuxiliar($entradaInfo, $id_entrada);
            // $mensaje .= "$id_entrada,";
          }
          
          $data = array('mensaje_subliminal' =>$nuevas_aprobadas );
        
          echo json_encode($data);
          
        }else{
          echo"1";
        }
      }
    }

    function procesar_protocolos(){
      die("estamos");
      $id_protocolo = $this->input->post('protocolo_enviar');
      $id_27s = json_decode($this->input->post('protocolos_eliminados'));
      $id_26s = json_decode($this->input->post('protocolos_aprobados'));

      $eliminados_anteriores = json_decode($this->input->post('eliminados_anteriores'));

      $modificados = json_decode($this->input->post('protocolos_modificados'));
      $dominios_modificiados = json_decode($this->input->post('dominios'));

      $ultimo_modificiado = $this->input->post('ultimo');

      $infraccion_modificada = json_decode($this->input->post('infraccion_modificada'));
      $id_infraccion_modificada = json_decode($this->input->post('id_infraccion_modificada'));

      if($modificados){
        $this->verificacion_model->update_entrada_auxiliar_dominio($modificados,$dominios_modificiados);
      }

      if($infraccion_modificada){
        $this->verificacion_model->update_entrada_auxiliar_infraccion($infraccion_modificada,$id_infraccion_modificada);
      }

      $info_verificacion_asignados = array('descartados' => count($eliminados_anteriores)+count($id_27s),'aprobados' => count($id_26s),'ultimo' => $ultimo_modificiado);
      
      $this->verificacion_model->update_verificacion_asignados($id_protocolo,$info_verificacion_asignados);
      

      $this->verificacion_model->update_entrada_auxiliar($id_26s,$id_27s);
    
      redirect('protocolos_asignados');

    }

    
}


?>
