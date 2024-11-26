<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class socios extends BaseController
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
        $this->load->model('municipios_model');
        $this->load->model('mail_model');
        $this->load->model('utilidades_model');
        $this->load->model('deposito_model');
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

//Vistas de Socios//
    function solicitudes_listado() //Vista de solicitidus.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(0);

        $count = $this->socios_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "solicitudes_listado/", $count, CANTPAGINA );

        $data['remitos'] = $this->socios_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Solicitudes';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->socios_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Solicitudes listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function remitos_listado() //Vista de remitos.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(1,2,3);

        $count = $this->socios_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "remitos_listado/", $count, CANTPAGINA );

        $data['remitos'] = $this->socios_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Remitos';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->socios_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Remitos listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function finalizados_listado() //Vista de remitos finalizados.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(4);

        $count = $this->socios_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "finalizados_listado/", $count, CANTPAGINA );

        $data['remitos'] = $this->socios_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Finalizados';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->socios_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Finalizado listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function rechazados_listado() //Vista de remitos rechazados.
    {
        $searchText = $this->input->post('searchText');
        $criterio   = $this->input->post('criterio');
        $data['searchText'] = $searchText;
        $data['criterio']   = $criterio;
        $estado = array(5);

        $count = $this->socios_model->listadoRemitos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);
        $returns = $this->paginationCompress( "rechazados_listado/", $count, CANTPAGINA );

        $data['remitos'] = $this->socios_model->listadoRemitos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'),$estado);

        $data['permisosInfo'] = $this->user_model->getPermisosInfo($this->session->userdata('userId'));

        $data['titulo'] = 'Rechazados';
        $data['total'] =  $count;
        $data['total_tabla'] =  $this->socios_model->listadoRemitos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'),$estado);

        $this->global['pageTitle'] = 'CECAITRA: Rechazados listado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function verRemito($id_remito = NULL) //Vista de un remito.
    {
        if($id_remito == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('remitos_listado');
        }

        $data['remitoInfo'] = $this->socios_model->getRemito($id_remito);

        if (!$data['remitoInfo']) { //Valido que el remito tenga informacion.
            $this->session->set_flashdata('error', 'No hay informacion de este remito.');
            redirect('remitos_listado');
        }

        $data['observaciones'] = $this->socios_model->getObservaciones($id_remito);
        $data['reparaciones']   = $this->ordenes_model->getEstados($data['remitoInfo']->id_orden);

        $this->global['pageTitle'] = 'CECAITRA : Ver remito';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios_ver', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function presupuesto($id_remito = NULL) //Vista para solicitar un presupuesto.
    {
        if($id_remito == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('remitos_listado');
        }

        $data['remitoInfo'] = $this->socios_model->getRemito($id_remito);
        $data['presupuestos'] = $this->socios_model->getPresupuestos($data['remitoInfo']->num_remito);
        $data['cant_presupuestos'] = count($data['presupuestos']);

        if (!$data['remitoInfo']) { //Valido que el remito exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('remitos_listado');
        }

        $data['id_remito'] = $id_remito;

        $this->global['pageTitle'] = 'CECAITRA : Solicitar Presupuesto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios_presupuesto', $data);
        $this->load->view('includes/footer',$this->global);
    }

    function ver_presupuesto($id_remito = NULL) //Vista para ver el presupuesto.
    {
        if($id_remito == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('remitos_listado');
        }

        $data['remitoInfo'] = $this->socios_model->getRemito($id_remito);

        /*
        if (!$data['remitoInfo']) { //Valido que el remito exista.
            $this->session->set_flashdata('error', 'No existe este remito.');
            redirect('remitos_listado');
        }
        */

        $data['presupuestos'] = $this->socios_model->getPresupuestos($data['remitoInfo']->num_remito);
        $data['id_remito'] = $id_remito;

        $this->global['pageTitle'] = 'CECAITRA : Ver Presupuesto';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('socios_verPresupuesto', $data);
        $this->load->view('includes/footer',$this->global);
    }

//Acciones de los Socios//

    function recibir_equipo() //Confirmo que recibo el equipo por parte de reparaciones.
    { 
        $num_remito     = $this->input->post('num_remito');

         /*if (!preg_match('/[0-9]{5}[1-9]/',$num_remito)) {
           $this->session->set_flashdata('error', 'No es un numero de remito valido.');
          redirect('solicitudes_listado');
         }*/

        switch (strlen($num_remito)) {
           case 5:
              $num_remito = "0".$num_remito;
              break;
            case 4:
              $num_remito = "00".$num_remito;
              break;
            case 3:
              $num_remito = "000".$num_remito;
              break;
            case 2:
              $num_remito = "0000".$num_remito;
              break;
            case 1:
              $num_remito = "00000".$num_remito;
              break;
        }


        if ($this->socios_model->existeNumRemito($num_remito) > 0) {
          $this->session->set_flashdata('error', 'El numero de remito ya esta asignado a una orden de trabajo, por favor ingresar otro.');
          redirect('solicitudes_listado');
        }

        $id_remito      = $this->input->post('id_remito');
        $fecha_recibido = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_recibido'));
        $num_remito     = $this->input->post('num_remito');

        $remitoInfo = array('num_remito'=>$id_remito, 'fecha_ingreso'=>$fecha_recibido, 'creado_por'=>$this->vendorId, 'fecha_aceptar'=>date('Y-m-d H:i:s'), 'id_estado'=>1);

        //Actualizo el remito con la informacion confirmada por parte del socio.
        $result = $this->socios_model->updateRemito($remitoInfo, $id_remito);

        if($result == TRUE){
            if (!$this->input->post('observacion')) {
                $observacion = 'Sin observaciones';
            } else {
                $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));
            }

            //Agrego un nuevo evento al remito.
            $eventoInfo  = array('num_remito'=>$num_remito, 'fecha'=>$fecha_recibido, 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
            $this->socios_model->agregarEvento($eventoInfo);
            
            $idorden = $this->input->post('id_orden');
            $orden   = $this->ordenes_model->getOrden($idorden);

            $data_estado = array(
      				'orden'	=> $idorden,
      				'usuario' => $this->session->userdata('userId'),
      				'fecha' => date('Y-m-d H:i:s'),
              'observ' => $observacion,
      				'tipo' => 15,
              'asignado_categoria' => 5
      		  );
            //Inserto un nuevo evento a la orden de reparacion.
            $this->ordenes_model->insertarEstado($data_estado);

            //Actualizo el estado del equipo y de la orden.

            //Si el fallo es el de daño de periferico, el estado del equipo quedara en el proyecto si no quedara en socio.
            if ($orden->rm_falla == 108) {
              $estado = 2;
            }else {
              $estado = 3;
            }

            $update_equipo = array('estado' => $estado);
            $remitoSocio = $this->socios_model->getRemito($id_remito);
            $this->equipos_model->editEquipo($update_equipo,$remitoSocio->id_equipo);

            $update = array ('ultimo_estado' => 15, 'ultimo_categoria'=> 5);
        		$this->ordenes_model->updateOrden($idorden,$update);
        		
            // al recibir el socio un equipo, genero un nuvo batch para la ot del equipo que esta recibiendo el socio, con las categoias actuales + la categoria socio
            $categorias_vigentes_ot = $this->ordenes_model->get_categorias_vigentes_ot($idorden);
            $nuevo_batch_categorias_ot = $this->ordenes_model->get_last_batch_categorias_ot($idorden) + 1;
            foreach ($categorias_vigentes_ot as $categoria) {
              $this->ordenes_model->insert_categoria_reparacion(array(
                "reparacion_main_id" => $idorden,
                "reparacion_categorias_id" => $categoria->id,
                "batch" => $nuevo_batch_categorias_ot
              ));
            }
            $this->ordenes_model->ordenes_model->insert_categoria_reparacion(array(
              "reparacion_main_id" => $idorden,
              "reparacion_categorias_id" => 5,
              "batch" => $nuevo_batch_categorias_ot
            ));
            
            $this->session->set_flashdata('success', 'Remito de trabajo aceptado correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al aceptar remito de trabajo.');
        }
        redirect('solicitudes_listado');
    }

    function nuevo_evento() //Agrego las observaciones al remito.
    {
        $id_remito  = $this->input->post('id_remito');
        $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

        //Agrego un nuevo evento al remito.
        $eventoInfo  = array('num_remito'=>$id_remito, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
        $result = $this->socios_model->agregarEvento($eventoInfo);

        if($result == TRUE){
            $this->session->set_flashdata('success', 'Nueva observacion agregada correctamente.');
        }else{
            $this->session->set_flashdata('error', 'Error al agregar observación');
        }
        redirect('remitos_listado');
    }

    function finalizarRemito() //Finaliza el trabajo por parte del Socio.
    {
        $id_remito  = $this->input->post('id_remito');
        $remitoInfo = array('id_estado'=>4);

        $result = $this->socios_model->updateRemito($remitoInfo, $id_remito);

        if($result == TRUE){ // Actualiza el remito para cerrarlo.
            $num_remito  = $this->input->post('num_remito');
            $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

            $eventoInfo  = array('num_remito'=>$id_remito, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
            $result = $this->socios_model->agregarEvento($eventoInfo);//Agrego el evento que cierra el remito.

            $remitoInfo = $this->socios_model->getRemito($id_remito);

            if(is_null($remitoInfo->deposito)){
              $categoria = 1; //Categoria Reparaciones.
              $orden = $this->ordenes_model->getOrden($remitoInfo->id_orden);//obtengo el id de la orden de reparacion.

              $lugar = "Reparaciones";
            } else {
              $categoria = 5; //Categoria Deposito.

              $depositoInfo = array('estado' => 10, 'categoria'=> 5);
              $resultD = $this->deposito_model->actualizarRemito($depositoInfo,$remitoInfo->deposito);

              if($resultD == TRUE){
                  $eventoinfo = array('id_deposito'=> $remitoInfo->deposito, 'observacion'=> $observacion, 'estado'=> 10, 'fecha'=> date('Y-m-d H:i:s'), 'usuario'=> $this->vendorId);

                  $this->deposito_model->agregarEvento($eventoinfo);
              }

              $lugar = "Deposito";
            }

            $data_estado = array(
      				'orden'	=> $remitoInfo->id_orden,
      				'usuario' => $this->session->userdata('userId'),
      				'fecha' => date('Y-m-d H:i:s'),
              'observ' => $observacion,
      				'tipo' => 16,
              'asignado_categoria' => $categoria
      		);

          
          $list = $this->municipios_model->traerListaMunicipio();

          $found = false;
  
          foreach ($list as $item) {
            if ($item->id == $orden->mu_id) {
                $found = true;
                break;
            }
          }


          $data_mail = array(
            // 'orden'	=> $orden,
            'fecha' => date('Y-m-d H:i:s'),
            'observ' => $this->input->post('observacion_enviar'),
            'Estado_nue' => $this->input->post('estado'),
            'Categoria_nue' =>5,          
            'proyecto'	=> $found,
            'proyecto_desc'	=> $orden->mu_descrip,
            'socio'	=> $orden->emo_asociado,
            'Estado_ant'	=> $orden->em_estado,
            'Categoria_ant'	=> $orden->rc_id,
            'Equipo'	=> $orden->em_serie_int,
          );
      
          

          
          
          $respuesta = sector_mail($data_mail);
          
          
  
  
          if($respuesta){
  
            $content2 = $this->call_web_service(
              "_email",
              [
                  "p" => $respuesta
              ]);
          }
            //Inserto un nuevo evento a la orden de reparacion.
            $this->ordenes_model->insertarEstado($data_estado);
            $update = array ('ultimo_estado' => 16, 'ultimo_categoria'=> $categoria);
            $this->ordenes_model->updateOrden($remitoInfo->id_orden,$update);

            // lio -> si el socio devuelve un equipo enviado desde reparaciones actualizo las categorias vigentes de la OT eliminando la categoria socio del nuevo batch (por ahora omito esta accion si el equipo es enviado desde el deposito, pero habrá que agregarlo)
            if($lugar == "Reparaciones") {
              $categorias_vigentes_ot = $this->ordenes_model->get_categorias_vigentes_ot($remitoInfo->id_orden);
              $ids_categorias_vigentes = array_map(function($categoria) {
                  return $categoria->id;
              }, $categorias_vigentes_ot);
              $categorias_vigentes_actualizada = array_filter($ids_categorias_vigentes, function($categoria) {
                  return $categoria != 5;
              });
              $nuevo_batch_categorias_ot = $this->ordenes_model->get_last_batch_categorias_ot($remitoInfo->id_orden) + 1;
              foreach ($categorias_vigentes_actualizada as $rc_id) {
                  $this->ordenes_model->insert_categoria_reparacion(array(
                      "reparacion_main_id" => $remitoInfo->id_orden,
                      "reparacion_categorias_id" => $rc_id,
                      "batch" => $nuevo_batch_categorias_ot
                  ));
              }
            }

            //Se envia un mail a Reparaciones que el trabajo esta finalizado.
            //$this->mail_model->enviarMail(10, $orden->rm_serie, $remitoInfo->id_orden, $observacion, date('d/m/Y',strtotime(date('Y-m-d'))),NULL, NULL, NULL, NULL, NULL);

            //Busco los datos para armar el mail
            $datos_mail = $this->mail_model->mail_config(12);

            //Buscar todos los gestores y ayudantes para enviar en un futuro, segun el proyecto
            $gestores_to = $this->mail_model->mail_gestores(12,$remitoInfo->id_proyecto,1);
            $gestores_cc = $this->mail_model->mail_gestores(12,$remitoInfo->id_proyecto,2);
            $gestores_cco = $this->mail_model->mail_gestores(12,$remitoInfo->id_proyecto,3);

            //Buscar los que quieran recibir una copia
            $gral_to = $this->mail_model->mail_gral(12,1);
            $gral_cc = $this->mail_model->mail_gral(12,2);
            $gral_cco = $this->mail_model->mail_gral(12,3);

            //todos los merge necesarios
            $mails_to = array_merge($gestores_to,$gral_to);
            $mails_cc = array_merge($gestores_cc,$gral_cc);
            $mails_cco = array_merge($gestores_cco,$gral_cco);

            $resultado = $this->mail_model->mail_enviado($datos_mail,$mails_to,$mails_cc,$mails_cco,$remitoInfo->serie,$remitoInfo->descrip);

            $this->session->set_flashdata('success', "Remito de trabajo finalizado correctamente. Equipo devuelto al sector de $lugar");
        }else{
            $this->session->set_flashdata('error', 'Error al finalizar remito de trabajo.');
        }
        redirect('remitos_listado');
    }

    function cancelar_remito()
    {
       $id_remito     = $this->input->post('id_remito');

      if ($id_remito == NULL) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      $remito = $this->socios_model->getRemito($id_remito);

      if (!$remito) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      $remitoInfo = array('id_estado'=> 5);
      $result = $this->socios_model->updateRemito($remitoInfo, $id_remito);


      if($result == TRUE){ // Agrego un nuevo evento.
          $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

          $eventoInfo  = array('num_remito'=>$id_remito, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
          $result = $this->socios_model->agregarEvento($eventoInfo);

          $id_orden = $this->input->post('id_orden');
          $orden   = $this->ordenes_model->getOrden($id_orden);

          if(is_null($remito->deposito)){
            $categoria = 1; //Categoria Reparaciones.
            $estado = 5; //Estado Of Tecnica Reparaciones.
          } else {
            $categoria = 10; //Categoria Deposito.
            $estado = 1; //Estado Deposito.

            $depositoInfo = array('estado' => 10, 'categoria'=> 5);
            $resultD = $this->deposito_model->actualizarRemito($depositoInfo,$remito->deposito);

            if($resultD == TRUE){
                $eventoinfo = array('id_deposito'=> $remito->deposito, 'observacion'=> $observacion, 'estado'=> 10, 'fecha'=> date('Y-m-d H:i:s'), 'usuario'=> $this->vendorId);

                $this->deposito_model->agregarEvento($eventoinfo);
            }
          }

          $data_estado = array(
            'orden'	=> $id_orden,
            'usuario' => $this->session->userdata('userId'),
            'fecha' => date('Y-m-d H:i:s'),
            'observ' => $observacion,
            'tipo' => 16,
            'asignado_categoria' => $categoria
          );
          //Inserto un nuevo evento a la orden de reparacion.
          $this->ordenes_model->insertarEstado($data_estado);

          //Actualizo el estado del equipo y de la orden.
          $update_equipo = array('estado' => $estado);
          $this->equipos_model->editEquipo($update_equipo,$orden->em_id);

          $update = array ('ultimo_estado' => 16, 'ultimo_categoria'=> $categoria);
          $this->ordenes_model->updateOrden($id_orden,$update);

          //Se envia un mail a Reparaciones que la solicitud fue cancelada.
          $this->mail_model->enviarMail(10, $orden->rm_serie, $id_orden, $observacion, date('d/m/Y',strtotime(date('Y-m-d'))),NULL, NULL, NULL, NULL, NULL);

          $this->session->set_flashdata('success', 'Solicitud cancelada correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al cancelar solicitud');
      }
      redirect('solicitudes_listado');
    }

    function guardar_presupuesto() //Funcion para guardar un presupuesto.
    {
      $id                = $this->input->post('id_remito');
      $num_presupuesto   = $this->input->post('num_presupuesto');

      switch (strlen($num_presupuesto)) {
        case 5:
          $num_presupuesto = "0".$num_presupuesto;
          break;
        case 4:
          $num_presupuesto = "00".$num_presupuesto;
          break;
        case 3:
          $num_presupuesto = "000".$num_presupuesto;
          break;
        case 2:
          $num_presupuesto = "0000".$num_presupuesto;
          break;
        case 1:
          $num_presupuesto = "00000".$num_presupuesto;
          break;
      }

      if ($this->socios_model->existeNumPresupuesto($num_presupuesto) > 0) {
        $this->session->set_flashdata('error', 'El numero de presupuesto ya esta asignado a un presupuesto, por favor ingresar otro.');
        redirect('presupuesto/'.$id);
      }

      $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

      if ($_FILES['archivo']['size'] > 1048576) {
          $fecha_presupuesto = $this->input->post('fecha_presupuesto');
          $info              = $num_presupuesto.",".$fecha_presupuesto.",".$observacion;

          $this->session->set_flashdata('info', $info); // En caso de que el archivo sea mayor a 1MB devuelvo el dato al formulario.
          $this->session->set_flashdata('error', 'No se puede adjuntar porque el archivo pesa mas de un 1MB.');

          redirect('presupuesto/'.$id);
        }

        $num_remito        = $this->input->post('num_remito');
        $fecha_presupuesto = $this->fechas->cambiaf_a_mysql($this->input->post('fecha_presupuesto'));

        if ($observacion == '' || $observacion == NULL) {
          $observacion = 'Sin observaciones.';
        }

        $formatos      = array('.pdf', '.doc', '.docx', '.xls', '.xlsx');
        $nombre_actual = $_FILES['archivo']['name'];
        $nombre_temp   = $_FILES['archivo']['tmp_name'];
        $ext           = substr($nombre_actual, strrpos($nombre_actual, '.'));
        $fecha         = date('Y-m-d-H:i:s', time());

        //SC - SCDEV
        $destino     = "/var/www/documentacion/socios/".$id."_$num_remito"."_$fecha"."$ext";
        //Localhost
        //$destino = '/var/www/html/sistemac/documentacion/socios/' .$id."_$num_remito"."_$fecha"."$ext";

        if (in_array($ext, $formatos)){
          if (move_uploaded_file($nombre_temp,$destino)){

            $presupuestoInfo  = array('id_remito'=>$num_remito,
                                      'num_presupuesto'=>$num_presupuesto,
                                      'observacion'=>$observacion,
                                      'tipo'=>$ext,
                                      'archivo'=>$id."_$num_remito"."_$fecha"."$ext",
                                      'fecha_presupuesto'=>$fecha_presupuesto,
                                      'activo'=>1,
                                      'creado_por'=>$this->vendorId,
                                      'fecha_ts'=>date('Y-m-d H:i:s')
                                      );
            $resultado = $this->socios_model->agregarPresupuesto($presupuestoInfo);//Agrego el los presupuesto.
            $this->session->set_flashdata('success', 'Presupuesto solicitado correctamente para el remito Nº '.$num_remito.'');
          }else{
            $this->session->set_flashdata('error', 'Error al guardar presupuesto para el remito Nº '.$num_remito.'');
          }
        }else{
          $this->session->set_flashdata('error', 'Formato de archivo no aceptado o no se adjunto archivo.');
        }
        redirect('presupuesto/'.$id);
    }

    function eliminar_presupuesto($id) //Vista para solicitar un presupuesto.
    {
        if($id == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este archivo.');
            redirect('remitos_listado');
        }

        $presupuesto = $this->socios_model->getArchivo($id);

        if (!$presupuesto) { //Valido que el remito exista.
            $this->session->set_flashdata('error', 'No existe este archivo.');
            redirect('presupuesto/'.$id);
        }

        $id_interno = explode("_", $presupuesto->archivo);

        //SC - SCDEV
        $destino = "/var/www/documentacion/socios/";
        //Localhost
        //$destino = '/var/www/html/sistemac/documentacion/socios/';


        if (unlink($destino.$presupuesto->archivo)) {
          $presupuestoInfo  = array('activo'=>0,
                                    'modificado_por'=>$this->vendorId,
                                    'fecha_ts'=>date('Y-m-d H:i:s')
                                    );
          $resultado = $this->socios_model->updateArchivo($presupuestoInfo, $id);
          $this->session->set_flashdata('success', 'Archivo adjunto borrado.');
        } else {
          $this->session->set_flashdata('error', 'Error al borrar el archivo adjuntado.');
        }

        redirect('presupuesto/'.$id_interno[0]);
    }

    function solicitar_presupuesto($id_remito = NULL)
    {
      if ($id_remito == NULL) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      $remito = $this->socios_model->getRemito($id_remito);

      if (!$remito) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      $remitoInfo = array('id_estado'=> 3);
      $result = $this->socios_model->updateRemito($remitoInfo, $id_remito);

      if($result == TRUE){ // Agrego un nuevo evento.
          $observacion = "Solicitando presupuesto";

          $eventoInfo  = array('num_remito'=>$id_remito, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
          $result = $this->socios_model->agregarEvento($eventoInfo);

          //Se envia un mail a SSGG para pedir el presupuesto.

          $this->mail_model->enviarMail(11, $remito->serie, $remito->num_remito, NULL, date('d/m/Y',strtotime(date('Y-m-d'))),NULL, $remito->descrip, NULL, NULL, $remito->descripPropietario);

          $this->session->set_flashdata('success', 'Presupuesto solicitado correctamente.');
      }else{
          $this->session->set_flashdata('error', 'Error al solicitar presupuesto.');
      }
      redirect('remitos_listado');
    }


    function aprobar_presupuesto()
    {
      $id_remito = $this->input->post('id_remito');

      if ($id_remito == NULL) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      $remito = $this->socios_model->getRemito($id_remito);

      if (!$remito) {
         $this->session->set_flashdata('error', 'No existe este remito.');
         redirect('remitos_listado');
      }

      if ($this->input->post('aprobar') == 'Aprobar presupuesto') {
        $id_estado = 2;
        $mensaje = "Presupuesto aprobado correctamente.";
        $tipo = "success";
      } else {
        $id_estado = 5;
        $mensaje = "Presupuesto dasaprobado correctamente.";
        $tipo = "info";
      }

      $remitoInfo = array('id_estado'=> $id_estado);
      $result = $this->socios_model->updateRemito($remitoInfo, $id_remito);

      if($result == TRUE){ // Agrego un nuevo evento.
          $observacion = trim(ucfirst(strtolower($this->input->post('observacion'))));

          if ($observacion == '' || $observacion == NULL) {
            $observacion = 'Sin observaciones';
          }

          $eventoInfo  = array('num_remito'=>$id_remito, 'fecha'=>date('Y-m-d H:i:s'), 'observacion'=>$observacion, 'creado_por'=>$this->vendorId);
          $result = $this->socios_model->agregarEvento($eventoInfo);

          //A partir de aca se lo enviamos a reparaciones con mail.
          if ($id_estado == 5) {
            $orden = $this->ordenes_model->getOrden($remito->id_orden);

            $data_estado = array(
              'orden'	=> $remito->id_orden,
              'usuario' => $this->session->userdata('userId'),
              'fecha' => date('Y-m-d H:i:s'),
              'observ' => $observacion,
              'tipo' => 16,
              'asignado_categoria' => 1
            );
            //Inserto un nuevo evento a la orden de reparacion.
            $this->ordenes_model->insertarEstado($data_estado);

            //Actualizo el estado del equipo y de la orden.
            /*$update_equipo = array('estado' => 5);
            $this->equipos_model->editEquipo($update_equipo,$orden->em_id);*/

            $update = array ('ultimo_estado' => 16, 'ultimo_categoria'=> 1);
            $this->ordenes_model->updateOrden($remito->id_orden,$update);

            //Se envia un mail a Reparaciones que el presupuesto fue rechazado.
            $this->mail_model->enviarMail(10, $orden->rm_serie, $remito->id_orden, $observacion, date('d/m/Y',strtotime(date('Y-m-d'))),NULL, NULL, NULL, NULL, NULL);
          }

          $this->session->set_flashdata($tipo, $mensaje);
      }else{
          $this->session->set_flashdata('error', 'Error al confirmar presupuesto.');
      }
      redirect('remitos_listado');
    }

    function descargar_presupuesto()
    {
      $name = $this->input->post('name');
      $tipo = $this->input->post('tipo');
      $id   = $this->input->post('id');

      switch ($tipo) {
        case 'pdf':
          $tipo = "application/pdf";
          break;
        case 'doc':
          $tipo = "application/msword";
          break;
        case 'docx':
          $tipo = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
          break;
        case '.xls':
           $tipo = "application/vnd.ms-excel";
           break;
       case '.xlsx':
          $tipo = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
          break;
      }

      //SC - SCDEV
      $ruta = '/var/www/documentacion/socios/';
      //Localhost
      //$ruta = '/var/www/html/sistemac/documentacion/socios/';
      $destino = $ruta.$name;

      if (!file_exists($destino)) {
        $this->session->set_flashdata('error', 'No existe el archivo para este remito.');
        redirect('ver_presupuesto/'.$id);
      }

      $this->utilidades_model->descargar_archivos($name,$tipo,$destino);
    }


}

?>
