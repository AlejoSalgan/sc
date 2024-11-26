<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    public function __construct() // This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('user_model');
        $this->load->model('equipos_model');
        $this->load->model('mensajes_model');
		    $this->load->library('export_excel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }


    public function index() // This function used to load the first screen of the user.
    {
        $this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('dashboard');
        $this->load->view('includes/footer');
    }


    function userListing($value, $filtro = 0) //0.- TODOS 1.-Usuarios 2.-Empleados
    {
        
        $searchText = $this->input->post('searchText');
        $criterio = $this->input->post('criterio');

        $data['searchText'] = $searchText;
        $data['criterio'] = $criterio;

        $count = $this->user_model->userListingCount($searchText, $filtro,$criterio);
	      $returns = $this->paginationCompress ( "userListing/", $count, 200 ); // Arreglar esto de la paginado

        $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"], $filtro,$criterio);
        $data['filtro'] = $filtro;

        switch ($filtro):
            case 1:
                $this->global['pageTitle'] = 'CECAITRA: Usuarios listado';
            break;
            case 2:
                $this->global['pageTitle'] = 'CECAITRA: Empleados listado';
            break;
            default:
                $this->global['pageTitle'] = 'CECAITRA: Usuarios/Empleados listado';
            break;
        endswitch;

        $data['name'] = $this->session->userdata('name');
        $data['roleUser'] = $this->role;

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users', $data);
        $this->load->view('includes/footer');
    }


    function agregar_usuario()
    {
        $data['roles']       = $this->user_model->getUserRoles();
        $data['puestos']     = $this->user_model->getPuestos();
        $data['asociados']   = $this->equipos_model->getAsociados();
        $data['sedes']       = $this->user_model->getSedes();

        $data['tipoItem']    = "Agregar";
        $data['tipoUsuario'] = "Usuario";

        $this->global['pageTitle'] = 'CECAITRA : Agregar usuario';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_AddEdit', $data);
        $this->load->view('includes/footer');
    }


    function editar_usuario($userId = NULL)
    {
        if($userId == null){
            redirect('userListing/0/1');
        }

        $data['roles']       = $this->user_model->getUserRoles();
        $data['puestos']     = $this->user_model->getPuestos();
        $data['asociados']   = $this->equipos_model->getAsociados();
        $data['userInfo']    = $this->user_model->getUserInfo($userId,TRUE);
        $data['sedes']       = $this->user_model->getSedes();

        $data['tipoItem']    = "Editar";
        $data['tipoUsuario'] = "Usuario";
    
        $this->global['pageTitle'] = 'CECAITRA : Editar Usuario';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_AddEdit', $data);
        $this->load->view('includes/footer');
    }


    function agregar_empleado()
    {
        $data['roles']       = $this->user_model->getUserRoles();
        $data['puestos']     = $this->user_model->getPuestos();
        $data['asociados']   = $this->equipos_model->getAsociados();
        $data['sedes']       = $this->user_model->getSedes();

        $data['tipoItem']    = "Agregar";
        $data['tipoUsuario'] = "Empleado";

        $this->global['pageTitle'] = 'CECAITRA : Agregar empleado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_AddEdit', $data);
        $this->load->view('includes/footer');
    }

    function editar_empleado($userId = NULL)
    {
        if($userId == null){
            redirect('userListing/0/2');
        }

        $data['roles']       = $this->user_model->getUserRoles();
        $data['puestos']     = $this->user_model->getPuestos();
        $data['asociados']   = $this->equipos_model->getAsociados();
        $data['userInfo']    = $this->user_model->getUserInfo($userId,TRUE);
        $data['sedes']       = $this->user_model->getSedes();

        $data['tipoItem']    = "Editar";
        $data['tipoUsuario'] = "Empleado";

        $this->global['pageTitle'] = 'CECAITRA : Editar Empleado';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_AddEdit', $data);
        $this->load->view('includes/footer');
    }

    function solicitudes_app($userId = NULL)
    {
        if($userId == null){
            $this->session->set_flashdata('error', 'No existe este usuario.');
            redirect('userListing/0/2');
        }

        $data['userInfo'] = $this->user_model->getUserInfo($userId);

        if (!$data['userInfo']) {
            $this->session->set_flashdata('error', 'No hay informacion de este usuario.');
            redirect('userListing/0/2');
        }

        $this->global['pageTitle'] = 'CECAITRA : Solicitudes al terminal celular';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_app', $data);
        $this->load->view('includes/footer');
    }


    function acceso_listado()
    {
      $searchText = $this->input->post('searchText');
      $criterio   = $this->input->post('criterio');
      $data['searchText'] = $searchText;
      $data['criterio']   = $criterio;

      $count = $this->user_model->listadoAccesos($searchText,$criterio,NULL,NULL,$this->role,$this->session->userdata('userId'));
      $returns = $this->paginationCompress( "acceso_listado/", $count, CANTPAGINA );

      $data['accesos'] = $this->user_model->listadoAccesos($searchText,$criterio,$returns["page"], $returns["segment"],$this->role,$this->session->userdata('userId'));

      $data['total'] =  $count;
      $data['total_tabla'] =  $this->user_model->listadoAccesos('',NULL,NULL,NULL,$this->role,$this->session->userdata('userId'));

      $this->global['pageTitle'] = 'CECAITRA : Acceso Permisos';

      $this->load->view('includes/header', $this->global);
      $this->load->view('includes/menu', $this->menu);
      $this->load->view('usuarios/users_acceso', $data);
      $this->load->view('includes/footer');

    }


    function agregar_acceso()
    {
        $data['roles']       = $this->user_model->getUserRoles();

        $this->global['pageTitle'] = 'CECAITRA : Agregar acceso';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_AddEditAcceso', $data);
        $this->load->view('includes/footer');
    }


    function agregar_editar_accesos()
    {
      if (empty($this->input->post('icono'))) {
        $icono = NULL;
      } else {
        $icono = $this->input->post('icono');
      }
      $nombre = $this->input->post('nombre');
      $link = $this->input->post('link');

      if (!$this->input->post('orden')) {
        $orden = NULL;
      } else {
        $orden = $this->input->post('orden');
      }

      if (!$this->input->post('padre')) {
        $padre = NULL;
      } else {
        $padre = $this->input->post('padre');
      }

      $tipo = $this->input->post('tipo');
      $roles = $this->input->post('rol');

      array_push($roles['admin']  = '99');

      $accesoInfo = array('icono'=>$icono, 'nombre'=>$nombre, 'link'=>$link, 'orden'=>$orden, 'padre'=>$padre, 'tipo'=>$tipo);
      $id_menu = $this->user_model->agregarAcceso($accesoInfo);

      foreach ($roles as $rol => $value) {
        $infoPermiso = array('rol'=>$value, 'id_menu'=>$id_menu);
        $this->user_model->agregarMenuPermiso($infoPermiso);
      }

      if ($id_menu > 0) {
        $this->session->set_flashdata('success', 'Permiso agregado correctamente');
      } else {
        $this->session->set_flashdata('error', 'Error al agregar permiso correctamente');
      }

      redirect('agregar_acceso');
    }



    function ver_acceso($id_acceso = NULL) //Vista de un remito.
    {
        if($id_acceso == null){ //Valido que exista.
            $this->session->set_flashdata('error', 'No existe este acceso.');
            redirect('acceso_listado');
        }

        $data['accesoInfo'] = $this->user_model->getacceso($id_acceso);

        /*if (!$data['remitoInfo']) { //Valido que el remito tenga informacion.
            $this->session->set_flashdata('error', 'No hay informacion de este remito.');
            redirect('remitos_listado');
        }*/

        $data['roles'] = $this->user_model->getUserRoles();
        $data['nombre_acceso'] = $this->user_model->getMenu($id_acceso);


        $this->global['pageTitle'] = 'CECAITRA : Ver acceso';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_verAcceso', $data);
        $this->load->view('includes/footer');
    }


    function agregar_permiso()
    {
      $roles = $this->input->post('rol');
      $id_menu = $this->input->post('id_menu');

      foreach ($roles as $rol => $value) {
        $infoPermiso = array('rol'=>$value, 'id_menu'=>$id_menu);
        $this->user_model->agregarMenuPermiso($infoPermiso);
      }

      if ($id_menu > 0) {
        $this->session->set_flashdata('success', 'Permiso agregado correctamente');
      } else {
        $this->session->set_flashdata('error', 'Error al agregar permiso correctamente');
      }

      redirect('ver_acceso/'.$id_menu);
    }


    function eliminar_permiso($id_acceso = NULL) //Vista de un remito.
    {

      if($id_acceso == null){ //Valido que exista.
          $this->session->set_flashdata('error', 'No existe este acceso.');
          redirect('acceso_listado');
      }

      $permiso = $this->user_model->getPermiso($id_acceso);

      $result = $this->user_model->eliminarPermiso($id_acceso);

      if ($result == TRUE) {
        $this->session->set_flashdata('success', 'Permiso eliminado correctamente');
      } else {
        $this->session->set_flashdata('error', 'Error al eliminar permiso correctamente');
      }

      redirect('ver_acceso/'.$permiso->id_menu);
    }



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function mensajes_app()
    {
        $tipo   = $this->input->post('codigo_msj');
        $userId = $this->input->post('userId');
        $codigo = date('Ymd His');
        $imei   = $this->user_model->getIMEI($userId);

        $mensajesInfo = array('imei'=>$imei,
                              'tipo'=>$tipo,
                              'codigo'=>$codigo,
                              'origen'=>1,
                              'intentos'=>0,
                              'estado'=>0,
                              'fecha_recepcion'=>date('Y-m-d'));

        $this->mensajes_model->addNewMensaje($mensajesInfo);

        $unidad = $tipo%10;
        $decena = ($tipo%100 - $unidad)/10;
        $tipoResultado = '03'."$decena"."$unidad";
        $i = 0;

        while ($i <= 3000 && !$respuesta) { // 5 minutos
          $respuesta = $this->mensajes_model->getRespuesta($imei,$tipoResultado,$codigo);
          sleep(1);
          $i++;
        }

        if ($respuesta->datos) {
          $datosCelular = explode("--",$respuesta->datos);
          switch ($tipo) {
            case 3000:
              echo "Las coordenas del telefono son: ".$datosCelular[0].".";
              break;

            case 3008:
              echo "El telefono esta sonando.";
              break;

            case 3004:
              echo "El modelo y marca es un ".$datosCelular[0].".";
              break;

            case 3011:
              $j = count($datosCelular); // Contamos todas las aplicaciones instaladas.
              $j = $j - 2; // Las dos ultimas aplicaciones vienen con nombre "vacio" o 0(cero).
              $aplicaciones = []; //Creo un array para guardar el nombre de las aplicaciones.
              $cont = 0; // Contamos cuantas aplicaciones son distintas a las nativas.
              for ($i=1; $i <= $j ; $i++) {
                $texto = explode("->",$datosCelular[$i]); //Separamos la aplicacion de su servicio.
                if ($texto[0] != "" || $texto[0] != 0 || $texto[0] != NULL) { //Validamos por las dudas.
                  $samsung  = strpos($texto[1], "samsung"); //Aplicaciones nativas de Samsung.
                  $google   = strpos($texto[1], "google"); //Aplicaciones nativas de Google.
                  $motorola = strpos($texto[1], "motorola"); //Aplicaciones nativas de Motorola.
                  if ($samsung === false && $google === false && $motorola === false) {
                      $aplicaciones[] = $texto[0]; //Guardamos el nombre de la aplicacion.
                      $cont++; //Contamos.
                  }
                }
              }
              sort($aplicaciones); //Ordenamos alfabeticamente.
              for ($i=0; $i < $cont; $i++) {
                $apps .= "- ".$aplicaciones[$i]."<br>"; //Generamos el dato para imprimir.
              }

              echo "Las aplicaciones instaladas son:<br> ".$apps."";
              break;

            case 3001:
              echo "El operador de red es: ".$datosCelular[0].".";
              break;

            case 3002:
              echo "El tipo de red es: ".$datosCelular[0].".";
              break;

            case 3003:
              echo "El codigo de SIM operador es: ".$datosCelular[0].".";
              break;

            case 3005:
              echo "El porcentaje de la bateria del telefono es: ".$datosCelular[0].".";
              break;

            case 3006:
              $texto = explode(" ",$datosCelular[0]);
              echo "La temperatura del telefono es de: ".$texto[1].".";
              break;

            case 3007:
              $texto = explode(" ",$datosCelular[0]);
              echo "El voltaje de la bateria del telefono es de: ".$texto[4].".";
              break;

            default:
              echo $respuesta->datos; // Por default que imprima lo que este en este campo.
              break;
          }

        } else {
          echo "No hay respuesta del celular.";
        }
    }


    function agregar_editar_usuario()
    {
        $tipoItem = $this->input->post('tipoItem');
        $tipoUsuario = $this->input->post('tipoUsuario');
        $userId = $this->input->post('userId');

        $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('apellido','Apellido','trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('role','Role','trim|required|numeric');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
        $this->form_validation->set_rules('modelomov','modelo mov','trim|required|max_length[30]|xss_clean');

        if ($tipoUsuario == "Usuario") {
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
        }

        if($this->form_validation->run() == FALSE)
        {
            if ($tipoUsuario == "Usuario") {
                if ($tipoItem == "Agregar") {
                    $this->agregar_usuario();
                } else {
                    $this->editar_usuario($userId);
                }

            } else {
                if ($tipoItem == "Agregar") {
                    $this->agregar_empleado();
                } else {
                    $this->editar_empleado($userId);
                }
            }

        } else {
            $nombre    = ucwords(strtolower($this->input->post('nombre')));
            $apellido  = ucwords(strtolower($this->input->post('apellido')));
            $email     = $this->input->post('email');
            $password  = $this->input->post('password');
            $roleId    = $this->input->post('role');
            $mobile    = $this->input->post('mobile');
            $modelomov = $this->input->post('modelomov');
            $imei      = $this->input->post('imei');
            $puesto    = $this->input->post('puesto');
            $asociado  = $this->input->post('asociado');
            $sede      = $this->input->post('sede');
            $interno   = $this->input->post('interno');
            $tipo      = 2;

            if ($tipoUsuario == "Usuario") {
                if ($tipoItem == "Agregar") {
                    $userInfo = array('email'=>$email, 'password'=>md5($password), 'roleId'=>$roleId, 'name'=> $nombre." ".$apellido,
                                'nombre' =>$nombre, 'apellido' => $apellido, 'interno' => $interno, 'id_sede' => $sede, 'mobile'=>$mobile, 'modelomov'=>$modelomov,
                                'imei'=>$imei, 'puesto'=> $puesto, 'asociado'=> $asociado, 'createdBy'=>$this->vendorId,
                                'createdDtm'=>date('Y-m-d H:i:sa'));
                } else {
                    if(empty($password)){ //editar usuario
                        $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$nombre." ".$apellido, 'nombre' =>$nombre,
                                        'apellido' => $apellido, 'interno' => $interno, 'id_sede' => $sede, 'mobile'=>$mobile, 'modelomov'=>$modelomov, 'imei'=>$imei,
                                        'puesto'=> $puesto, 'asociado'=> $asociado, 'updatedBy'=>$this->vendorId,
                                        'updatedDtm'=>date('Y-m-d H:i:sa'));
                    } else {
                        $userInfo = array('email'=>$email, 'password'=>md5($password), 'roleId'=>$roleId, 'name'=>$nombre." ".$apellido,
                                        'nombre' =>$nombre, 'apellido' => $apellido, 'interno' => $interno, 'id_sede' => $sede, 'mobile'=>$mobile, 'modelomov'=>$modelomov,
                                        'imei'=>$imei, 'puesto'=> $puesto, 'asociado'=> $asociado, 'updatedBy'=>$this->vendorId,
                                        'updatedDtm'=>date('Y-m-d H:i:sa'));
                    }
                }

            } else {
                if ($tipoItem == "Agregar") {
                    $userInfo = array('tipo'=> $tipo, 'name'=> $nombre." ".$apellido, 'nombre' =>$nombre, 'apellido' => $apellido,
                             'roleId'=>$roleId,'mobile'=>$mobile, 'interno' => $interno, 'id_sede' => $sede, 'modelomov'=>$modelomov, 'imei'=>$imei,
                             'puesto'=> $puesto, 'asociado'=> $asociado,
                            'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:sa'));
                } else {
                    $userInfo = array('roleId'=>$roleId, 'name'=>$nombre." ".$apellido, 'nombre' =>$nombre,
                                'apellido' => $apellido,'mobile'=>$mobile, 'interno' => $interno, 'id_sede' => $sede, 'modelomov'=>$modelomov,
                                'imei'=>$imei, 'puesto'=> $puesto, 'asociado'=> $asociado,
                                'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:sa'));
                }
            }

            if ($tipoItem == "Agregar") {
                $result = $this->user_model->addNewUser($userInfo);
                $permisoID =  array('id_usuario' =>$result);
            } else {
                $result = $this->user_model->editUser($userInfo, $userId);
            }

            if($result == TRUE) {
                if ($tipoUsuario == "Usuario" AND $tipoItem == "Agregar" ) {
                    $this->session->set_flashdata('success', 'Usuario ingresado correctamente');

                    $result2 = $this->user_model->addIDPermiso($permisoID);
                } else {
                    $this->session->set_flashdata('success', 'Empleado ingresado correctamente');
                }
            } else {
                if ($tipoUsuario == "Usuario" AND $tipoItem == "Agregar") {
                    $this->session->set_flashdata('error', 'Error al ingresar Usuario');
                } else {
                    $this->session->set_flashdata('error', 'Error al ingresar Empleado');
                }
            }

            if ($tipoUsuario == "Usuario") {
                if ($tipoItem == "Agregar") {
                    redirect('agregar_usuario');
                } else {
                    redirect('userListing/0/1');
                }
            } else {
                if ($tipoItem == "Agregar") {
                    redirect('agregar_empleado');
                } else {
                    redirect('userListing/0/2');
                }
            }
        }
    }


    function deleteUser()
    {
        $userId = $this->input->post('userId');
        $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:sa'));

        $result = $this->user_model->deleteUser($userId, $userInfo);

        if ($result > 0) {
          echo(json_encode(array('status'=>TRUE)));
        } else {
          echo(json_encode(array('status'=>FALSE)));
        }
    }

    function ver_permisos($userId)
    {
        if($userId == null){
            redirect('userListing/0/1');
        }

        $data['userInfo'] = $this->user_model->getUserInfo($userId,TRUE);
        $data['permisosInfo'] = $this->user_model->getPermisosInfo($userId);

        $this->global['pageTitle'] = 'CECAITRA : Agregar permisos';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/users_permisos',$data);
        $this->load->view('includes/footer');
    }

    

    function password_random()
    { 
      $pass = $this->getPasswordRAndom();
      $encryptPass = md5($pass);
      $userId = $this->input->post('usuarioId');
      $userInfo['password'] = $encryptPass;
      
      $this->user_model->changePassword($userId,$userInfo);
      $this->session->set_flashdata('success','su contraseña nueva es: '.$pass);
      redirect('userListing/0/1');
     
    }

    function getPasswordRandom()
    {
      $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
      $original_string = implode("", $original_string);
      return substr(str_shuffle($original_string), 0, 6);
      
    }
    
 
//---------------------------------------  
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'CECAITRA : Cambiar Password';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('changePassword');
        $this->load->view('includes/footer');
    }

    function changePassword()
    {
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');

        if($this->form_validation->run() == FALSE){
            $this->loadChangePass();
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, md5($oldPassword));

            if(empty($resultPas)){
                $this->session->set_flashdata('nomatch', 'Tu anterior contraseña no es correcta');
                redirect('loadChangePass');
            } else {
                $usersData = array('password'=>md5($newPassword), 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:sa'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if($result > 0) {
                  $this->session->set_flashdata('success', 'Actualización de contraseña exitosa');
                } else {
                  $this->session->set_flashdata('error', 'Password updation failed');
                }

                redirect('loadChangePass');
            }
        }
    }

  	function verPersonal($userId = NULL)
  	{
        if($userId == null){
            redirect('users');
        }

        $data['roles']     = $this->user_model->getUserRoles();
        $data['puestos']   = $this->user_model->getPuestos();
        $data['asociados'] = $this->equipos_model->getAsociados();
        $data['userInfo']  = $this->user_model->getUserInfo($userId,TRUE);

        $this->global['pageTitle'] = 'CECAITRA : Detalle personal';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('usuarios/verPersonal', $data);
        $this->load->view('includes/footer');
  	}

  	function limpiezaCelulares()
  	{
  	    $data['userRecords'] = $this->user_model->userListingMemoria($searchText, $returns["page"], $returns["segment"], $filtro);

        $data['userId'] = $this->session->userdata('userId');

  	    $this->global['pageTitle'] = 'CECAITRA: Limpieza Celulares';
        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('limpiezaCelulares', $data);
        $this->load->view('includes/footer');
  	}


    function agregar_permisos() // Funcion para guardar los permisos de un usuario.
    {
        $userId = $this->input->post('userId');

        /*Equipos*/
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_agregar'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_evento'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_editar'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_historial'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_componentes'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_actDesact'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_ver'));
        $equipos_equipos .= $this->user_model->estadoPermiso($this->input->post('equipos_solicitud'));

        /*Equipos Marcas*/
        $equipos_marcas .= $this->user_model->estadoPermiso($this->input->post('marcas_agregar'));
        $equipos_marcas .= $this->user_model->estadoPermiso($this->input->post('marcas_editar'));
        $equipos_marcas .= $this->user_model->estadoPermiso($this->input->post('marcas_cancelar'));

        /*Equipos Tipos*/
        $equipos_tipos .= $this->user_model->estadoPermiso($this->input->post('tipos_agregar'));
        $equipos_tipos .= $this->user_model->estadoPermiso($this->input->post('tipos_editar'));
        $equipos_tipos .= $this->user_model->estadoPermiso($this->input->post('tipos_cancelar'));

        /*Equipos Modelos*/
        $equipos_modelos .= $this->user_model->estadoPermiso($this->input->post('modelos_agregar'));
        $equipos_modelos .= $this->user_model->estadoPermiso($this->input->post('modelos_editar'));
        $equipos_modelos .= $this->user_model->estadoPermiso($this->input->post('modelos_cancelar'));

        /*Equipos Propietarios*/
        $equipos_propietarios .= $this->user_model->estadoPermiso($this->input->post('propietarios_agregar'));
        $equipos_propietarios .= $this->user_model->estadoPermiso($this->input->post('propietarios_editar'));
        $equipos_propietarios .= $this->user_model->estadoPermiso($this->input->post('propietarios_cancelar'));

        /*Componentes*/
        $componentes_componentes .= $this->user_model->estadoPermiso($this->input->post('componentes_agregar'));
        $componentes_componentes .= $this->user_model->estadoPermiso($this->input->post('componentes_agregarS'));
        $componentes_componentes .= $this->user_model->estadoPermiso($this->input->post('componentes_editar'));
        $componentes_componentes .= $this->user_model->estadoPermiso($this->input->post('componentes_cancelar'));
        $componentes_componentes .= $this->user_model->estadoPermiso($this->input->post('componentes_historial'));

        /*SinAsignar*/
        $componentes_sinAsignar .= $this->user_model->estadoPermiso($this->input->post('sinAsginar_agregar'));
        $componentes_sinAsignar .= $this->user_model->estadoPermiso($this->input->post('sinAsginar_agregarS'));
        $componentes_sinAsignar .= $this->user_model->estadoPermiso($this->input->post('sinAsginar_editar'));
        $componentes_sinAsignar .= $this->user_model->estadoPermiso($this->input->post('sinAsginar_cancelar'));
        $componentes_sinAsignar .= $this->user_model->estadoPermiso($this->input->post('sinAsginar_historial'));


        /*Componentes Marcas*/
        $componentes_marcas .= $this->user_model->estadoPermiso($this->input->post('marcasC_agregar'));
        $componentes_marcas .= $this->user_model->estadoPermiso($this->input->post('marcasC_editar'));
        $componentes_marcas .= $this->user_model->estadoPermiso($this->input->post('marcasC_cancelar'));

        /*Componentes Tipos*/
        $componentes_tipos .= $this->user_model->estadoPermiso($this->input->post('tiposC_agregar'));
        $componentes_tipos .= $this->user_model->estadoPermiso($this->input->post('tiposC_editar'));
        $componentes_tipos .= $this->user_model->estadoPermiso($this->input->post('tiposC_cancelar'));

        /*Bajada Ordenes de Servicio*/
        $bajada_ordServ .= $this->user_model->estadoPermiso($this->input->post('OS_agregar'));
        $bajada_ordServ .= $this->user_model->estadoPermiso($this->input->post('OS_ver'));
        $bajada_ordServ .= $this->user_model->estadoPermiso($this->input->post('OS_editar'));
        $bajada_ordServ .= $this->user_model->estadoPermiso($this->input->post('OS_cancelar'));
        $bajada_ordServ .= $this->user_model->estadoPermiso($this->input->post('OS_enviar'));

        /*Bajada Ordenes de Servicio Sin recibir*/
        $bajada_ordSR .= $this->user_model->estadoPermiso($this->input->post('OSR_ver'));
        $bajada_ordSR .= $this->user_model->estadoPermiso($this->input->post('OSR_cancelarEnvio'));

        /*Bajada Ordenes de Servicio Sin Procesar*/
        $bajada_ordSP .= $this->user_model->estadoPermiso($this->input->post('OSP_ver'));
        $bajada_ordSP .= $this->user_model->estadoPermiso($this->input->post('OSP_cancelarEnvio'));

        /*Bajada Ordenes de Servicio Procesadas*/
        $bajada_ordProc .= $this->user_model->estadoPermiso($this->input->post('OP_ver'));
        $bajada_ordProc .= $this->user_model->estadoPermiso($this->input->post('OP_cancelarEnvio'));

        /*Bajada Ordenes de Servicio Anuladas*/
        $bajada_ordAnul .= $this->user_model->estadoPermiso($this->input->post('OA_ver'));

        /*Bajada Ordenes de Servicio Anuladas*/
        $bajada_ordCero .= $this->user_model->estadoPermiso($this->input->post('OCE_ver'));

        /*Bajada Grupo Sin Enviar*/
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_ver'));
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_editar'));
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_enviarOrd'));
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_verCerco'));
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_editarCerco'));
        $bajada_grupoSE .= $this->user_model->estadoPermiso($this->input->post('GSE_enviarCerco'));

        /*Bajada Grupo Sin Recibir*/
        $bajada_grupoSR .= $this->user_model->estadoPermiso($this->input->post('GSR_ver'));
        $bajada_grupoSR .= $this->user_model->estadoPermiso($this->input->post('GSR_cancelarEnvio'));

        /*Bajada Grupo Sin Procesar*/
        $bajada_grupoSP .= $this->user_model->estadoPermiso($this->input->post('GSP_ver'));
        $bajada_grupoSP .= $this->user_model->estadoPermiso($this->input->post('GSP_cancelarEnvio'));

        /*Bajada Grupo Procesado Fuera del cerco*/
        $bajada_grupoC .= $this->user_model->estadoPermiso($this->input->post('GC_ver'));
        $bajada_grupoC .= $this->user_model->estadoPermiso($this->input->post('GC_cancelarEnvio'));

        /*Ingreso de datos Pendientes*/
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_ver'));
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_editar'));
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_cancelar'));
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_finalizar'));
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_dividir'));
        $ingreso_pendientes .= $this->user_model->estadoPermiso($this->input->post('pendientes_enlazar'));


        /*Ingreso de datos Ingresados*/
        $ingreso_ingresados .= $this->user_model->estadoPermiso($this->input->post('ingresados_ver'));
        $ingreso_ingresados .= $this->user_model->estadoPermiso($this->input->post('ingresados_estado'));


        /*Ingreso de datos Anulados*/
        $ingreso_anulados .= $this->user_model->estadoPermiso($this->input->post('anulados_ver'));

        /*Ingreso de datos Cero*/
        $ingreso_cero .= $this->user_model->estadoPermiso($this->input->post('ceros_ver'));

        /*Ingreso de datos Remotos*/
        $ingreso_remotos .= $this->user_model->estadoPermiso($this->input->post('remotos_agregar'));
        $ingreso_remotos .= $this->user_model->estadoPermiso($this->input->post('remotos_anular'));
        $ingreso_remotos .= $this->user_model->estadoPermiso($this->input->post('remotos_decripto'));

        /*Novedades*/
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_envRepa'));
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_envMante'));
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_selec'));
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_ver'));
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_crear'));
        $novedades_novedades .= $this->user_model->estadoPermiso($this->input->post('nov_desestimar'));

        /*Mantenimiento Solicitudes*/
        $mantenimiento_solicitudes .= $this->user_model->estadoPermiso($this->input->post('mantS_crearOrdSelec'));
        $mantenimiento_solicitudes .= $this->user_model->estadoPermiso($this->input->post('mantS_rechazarSoli'));
        $mantenimiento_solicitudes .= $this->user_model->estadoPermiso($this->input->post('mantS_crearSoli'));
        $mantenimiento_solicitudes .= $this->user_model->estadoPermiso($this->input->post('mantS_seleccionar'));
        $mantenimiento_solicitudes .= $this->user_model->estadoPermiso($this->input->post('mantS_ver'));

        /*Mantenimiento Ordenes*/
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_ordenNueva'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_verEditar'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_enviar'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_finalizar'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_agregarVisitas'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_adjArchivo'));
        $mantenimiento_ordenes .= $this->user_model->estadoPermiso($this->input->post('mantO_cancelarOrden'));

        /*Reparacion Solicitudes*/
        $reparacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('repaS_crearOrdSelec'));
        $reparacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('repaS_rechazarSoli'));
        $reparacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('repaS_crearSoli'));
        $reparacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('repaS_seleccionar'));
        $reparacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('repaS_ver'));

        /*Reparacion Ordenes*/
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_ordenNueva'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_verEditar'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_reasignar'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_enviar'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_finalizar'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_agregarVisitas'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_enviarSocio'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_recibirEquipo'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_adjArchivo'));
        $reparacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('repaO_cancelarOrden'));

        /*Instalaciones Solicitudes*/
        $instalacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('instaS_crearOrdSelec'));
        $instalacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('instaS_rechazarSoli'));
        $instalacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('instaS_crearSoli'));
        $instalacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('instaS_seleccionar'));
        $instalacion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('instaS_ver'));

        /*Instalaciones Ordenes*/
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_ordenNueva'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_verEditar'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_reasignar'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_enviar'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_finalizar'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_agregarVisitas'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_agregarCortes'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_adjArchivo'));
        $instalacion_ordenes .= $this->user_model->estadoPermiso($this->input->post('instaO_cancelarOrden'));

        /*Calibraciones Solicitudes*/
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_SolicitarParciales'));
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_agregarSolicitud'));
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_ver'));

        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_editarG'));
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_editarC'));
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_cancelarG'));

        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_aprobarG'));
        $calibracion_solicitudes .= $this->user_model->estadoPermiso($this->input->post('CS_aprobarC'));

        /*Calibraciones Ordenes*/
        $calibracion_ordenes .= $this->user_model->estadoPermiso($this->input->post('CO_ver'));
        $calibracion_ordenes .= $this->user_model->estadoPermiso($this->input->post('CO_editar'));
        $calibracion_ordenes .= $this->user_model->estadoPermiso($this->input->post('CO_cancelar'));
        $calibracion_ordenes .= $this->user_model->estadoPermiso($this->input->post('CO_ordPendiente'));
        $calibracion_ordenes .= $this->user_model->estadoPermiso($this->input->post('CO_finalizar'));

        /*Calibraciones Ordenes Pendientes*/
        $calibracion_ordenesP .= $this->user_model->estadoPermiso($this->input->post('COP_ver'));
        $calibracion_ordenesP .= $this->user_model->estadoPermiso($this->input->post('COP_cancelar'));
        $calibracion_ordenesP .= $this->user_model->estadoPermiso($this->input->post('COP_editar'));
        $calibracion_ordenesP .= $this->user_model->estadoPermiso($this->input->post('COP_finalizar'));

        /*Calibraciones Ordenes Rechazadas*/
        $calibracion_rechazadas .= $this->user_model->estadoPermiso($this->input->post('COR_ver'));

        /*Calibraciones Ordenes Finalizadas*/
        $calibracion_finalizadas .= $this->user_model->estadoPermiso($this->input->post('COF_ver'));

        /*Calibraciones Ordenes Aprobaciones*/
        $calibracion_aprobacion .= $this->user_model->estadoPermiso($this->input->post('AP_ver'));
        $calibracion_aprobacion .= $this->user_model->estadoPermiso($this->input->post('AP_agregar'));
        $calibracion_aprobacion .= $this->user_model->estadoPermiso($this->input->post('AP_aprobar'));

        /*Flota*/
        $flota_flota .= $this->user_model->estadoPermiso($this->input->post('flota_agregar'));
        $flota_flota .= $this->user_model->estadoPermiso($this->input->post('flota_editar'));
        $flota_flota .= $this->user_model->estadoPermiso($this->input->post('flota_cancelar'));

        /*Socios Solicitudes*/
        $socios_solicitudes .= $this->user_model->estadoPermiso($this->input->post('SOSoli_recibir'));
        $socios_solicitudes .= $this->user_model->estadoPermiso($this->input->post('SOSoli_cancelar'));

        /*Socios Remitos*/
        $socios_remitos .= $this->user_model->estadoPermiso($this->input->post('SORemitos_ver'));
        $socios_remitos .= $this->user_model->estadoPermiso($this->input->post('SORemitos_agregar'));
        $socios_remitos .= $this->user_model->estadoPermiso($this->input->post('SORemitos_solicitar'));
        $socios_remitos .= $this->user_model->estadoPermiso($this->input->post('SORemitos_verPresupuesto'));
        $socios_remitos .= $this->user_model->estadoPermiso($this->input->post('SORemitos_finalizar'));

        /*Socios Finalizados*/
        $socios_finalizados .= $this->user_model->estadoPermiso($this->input->post('SOFin_ver'));

        /*Socios Rechazados*/
        $socios_rechazados .= $this->user_model->estadoPermiso($this->input->post('SORec_ver'));


        /*Deposito Ingresos*/
        $deposito_ingresos .= $this->user_model->estadoPermiso($this->input->post('DEPIngresos_ver'));
        $deposito_ingresos .= $this->user_model->estadoPermiso($this->input->post('DEPIngresos_recibir'));
        $deposito_ingresos .= $this->user_model->estadoPermiso($this->input->post('DEPIngresos_nuevo'));


        /*Deposito Custodia*/
        $deposito_custodia .= $this->user_model->estadoPermiso($this->input->post('DEPCustodia_ver'));
        $deposito_custodia .= $this->user_model->estadoPermiso($this->input->post('DEPCustodia_eventos'));
        $deposito_custodia .= $this->user_model->estadoPermiso($this->input->post('DEPCustodia_archivos'));
        $deposito_custodia .= $this->user_model->estadoPermiso($this->input->post('DEPCustodia_enviar'));

        /*Deposito Egreso*/
        $deposito_egreso .= $this->user_model->estadoPermiso($this->input->post('DEPEgreso_ver'));
        $deposito_egreso .= $this->user_model->estadoPermiso($this->input->post('DEPEgreso_eventos'));

        /*Deposito Finalizadas*/
        $deposito_finalizadas .= $this->user_model->estadoPermiso($this->input->post('DEPFinalizadas_ver'));

        /*Fotos Desencriptadas*/
        $fotos_desencriptadas .= $this->user_model->estadoPermiso($this->input->post('fotosD_ver'));

        $exportaciones_exportaciones .= $this->user_model->estadoPermiso($this->input->post('expo_ver'));

        $exportaciones_detalles .= $this->user_model->estadoPermiso($this->input->post('detalle_aprobadas'));
        $exportaciones_detalles .= $this->user_model->estadoPermiso($this->input->post('detalle_desaprobadas'));

        /*Proyectos*/
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_agregar'));
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_ver'));
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_editar'));
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_asignar'));
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_remoto'));
        $proyectos_proyectos .= $this->user_model->estadoPermiso($this->input->post('PROproyectos_estado'));

        $proyectos_asignaciones .= $this->user_model->estadoPermiso($this->input->post('PROasig_eliminar'));
        $proyectos_asignaciones .= $this->user_model->estadoPermiso($this->input->post('PROasig_prioridad'));
        $proyectos_asignaciones .= $this->user_model->estadoPermiso($this->input->post('PROasig_guardad'));

        $permisosInfo = array('equipos_equipos'=>$equipos_equipos, 'equipos_marcas'=>$equipos_marcas, 'equipos_tipos'=>$equipos_tipos, 'equipos_modelos'=>$equipos_modelos, 'equipos_propietarios'=>$equipos_propietarios,
            'componentes_componentes'=>$componentes_componentes, 'componentes_sinAsignar'=>$componentes_sinAsignar, 'componentes_marcas'=>$componentes_marcas, 'componentes_tipos'=>$componentes_tipos,
            'bajada_ordServ'=>$bajada_ordServ, 'bajada_ordSR'=>$bajada_ordSR, 'bajada_ordSP'=>$bajada_ordSP, 'bajada_ordProc'=>$bajada_ordProc,
            'bajada_ordAnul'=>$bajada_ordAnul, 'bajada_ordCero'=>$bajada_ordCero,
            'bajada_grupoSE'=>$bajada_grupoSE, 'bajada_grupoSR'=>$bajada_grupoSR, 'bajada_grupoSP'=>$bajada_grupoSP, 'bajada_grupoC'=>$bajada_grupoC,
            'ingreso_pendientes'=>$ingreso_pendientes, 'ingreso_ingresados'=>$ingreso_ingresados, 'ingreso_anulados'=>$ingreso_anulados, 'ingreso_cero'=>$ingreso_cero, 'ingreso_remotos'=>$ingreso_remotos,
            'novedades_novedades'=>$novedades_novedades,
            'mantenimiento_solicitudes'=>$mantenimiento_solicitudes, 'mantenimiento_ordenes'=>$mantenimiento_ordenes,
            'reparacion_solicitudes'=>$reparacion_solicitudes, 'reparacion_ordenes'=>$reparacion_ordenes,
            'instalacion_solicitudes'=>$instalacion_solicitudes, 'instalacion_ordenes'=>$instalacion_ordenes,
            'calibracion_solicitudes'=>$calibracion_solicitudes, 'calibracion_ordenes'=>$calibracion_ordenes,
            'calibracion_ordenesP'=>$calibracion_ordenesP, 'calibracion_rechazadas'=>$calibracion_rechazadas, 'calibracion_finalizadas'=>$calibracion_finalizadas, 'calibracion_aprobacion'=>$calibracion_aprobacion,
            'flota_flota'=>$flota_flota, 'socios_solicitudes'=>$socios_solicitudes,'socios_remitos'=>$socios_remitos,'socios_finalizados'=>$socios_finalizados,'socios_rechazados'=>$socios_rechazados,    'deposito_ingresos'=>$deposito_ingresos,'deposito_custodia'=>$deposito_custodia,'deposito_egreso'=>$deposito_egreso,'deposito_finalizadas'=>$deposito_finalizadas,
            'fotos_desencriptadas'=>$fotos_desencriptadas,
            'exportaciones_exportaciones'=>$exportaciones_exportaciones, 'exportaciones_detalles'=>$exportaciones_detalles,
            'proyectos_proyectos'=>$proyectos_proyectos,
            'proyectos_asignaciones'=>$proyectos_asignaciones




            );

        $result = $this->user_model->editPermiso($permisosInfo, $userId);

        if ($result == TRUE) {
          $this->session->set_flashdata('success', 'Permisos editado correctamente..');
        } else {
          $this->session->set_flashdata('error', 'Error al editar permisos.');
        }

        redirect('userListing/0/1');
    }




}
