<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model
{
      function enviarMail($caso, $equipoSerie = NULL, $reparacionNro = NULL, $detalle = NULL, $fecha = NULL, $reasignadoA = NULL,
          $proyecto = NULL, $emailTo = NULL, $nameTo = NULL, $propietario = NULL)
      {
                  $mail = new PHPMailer();
                  $mail->SetLanguage('es');
                  $mail->IsSMTP(); // establecemos que utilizaremos SMTP
                  $mail->SMTPAuth   = TRUE; // habilitamos la autenticación SMTP
                  $mail->SMTPSecure = "tls";  // establecemos el prefijo del protocolo seguro de comunicación con el servidor
                  $mail->Host       = "smtp.office365.com";      // establecemos nuestro servidor SMTP
                  $mail->Port       = 587;                   // establecemos el puerto SMTP en el servidor
                  $mail->Username   = "sistemas@cecaitra.org.ar";  // la cuenta de correo
                  $mail->Password   = "SisCec16";            // password de la cuenta
                  $mail->SetFrom('sistemas@cecaitra.org.ar', 'Sistemas CECAITRA'); // Quien envía el correo

                  //Casos particulares que solicitaron copia
                  if ($emailTo == 'sguerra@cecaitra.org.ar'){
                      $mail->AddCC      ("msgrignieri@cecaitra.org.ar", "Maximiliano Sgrignieri");
                  }
                  if ($emailTo == 'psorrentino@cecaitra.org.ar'){
                      $mail->AddCC      ("rgastaldi@cecaitra.org.ar", "Roberto Gastaldi");
                      $mail->AddCC      ("dmontenegro@cecaitra.org.ar", "Dylan Montenegro");
                  }
                  //Fin casos particulares

                  switch ($caso){
                        case '1': // (ORDEN FINALIZADA)
                            $aux = 0;
                            do{
                                $mail->AddAddress      ($emailTo[$aux], $nameTo[$aux]); // GESTORES + AYUDANTES
                                $aux++;
                            } while($aux < count($nameTo));

                            $municipio = $this->mail_model->getProyectoByEquipo($equipoSerie);
                            $mun = $municipio->descrip;



                        $mail->AddCC      ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                        $mail->AddReplyTo ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                        $mail->Subject    = "[SC]Reparación: ".$equipoSerie." (".$mun.") - Orden finalizada";
                        $mail->Body       = "<p>La orden de reparación abierta el día <strong>".$fecha."</strong>, con nro <strong>".$reparacionNro."</strong> del equipo <strong>".$equipoSerie. "</strong> está finalizada.\n</p>
                                             <p>Diagnóstico final: <strong>".$detalle."</strong> </p>\n\n<p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "Hola,\n\nLa orden de reparación nro ".$reparacionNro." del equipo ".$equipoSerie." está finalizada.";
                        break;

                        case '2':  // (ORDEN REASIGNADA)
                        $mail->AddReplyTo ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                        if ($reasignadoA == 'Reparaciones'){
                              $mail->AddAddress  ("gdondo@cecaitra.org.ar", "Gustavo Dondo");
                              $mail->AddCC ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                              $mail->AddCC ("rgastaldi@cecaitra.org.ar", "Roberto Gastaldi");
                              $mail->AddCC ("dmontenegro@cecaitra.org.ar", "Dylan Montenegro");
                              $mail->AddCC ("psorrentino@cecaitra.org.ar", "Pablo Sorrentino");
                        }elseif ($reasignadoA == 'Instalaciones'){
                              $mail->AddAddress   ("gsourigues@cecaitra.org.ar", "Gustavo Sourigues");
                              $mail->AddCC  ("emensi@cecaitra.org.ar", "Emiliano Mensi");
                              $mail->AddCC  ("mgimenez@cecaitra.org.ar", "Miguel Gimenez");
                              $mail->AddCC  ("enieves@cecaitra.org.ar", "Emanuel Nieves");
                        }elseif ($reasignadoA == 'Calibraciones'){
                              $mail->AddAddress   ("psorrentino@cecaitra.org.ar", "Pablo Sorrentino");
                        }/*elseif ($reasignadoA == 'Socio'){
                              $mail->AddAddress     ("copia@cecaitra.com"); (CASE 7)
                        }*/elseif ($reasignadoA == 'Gestión de proyectos'){
                              $mail->AddAddress  ("mminutti@cecaitra.org.ar", "Marcelo Minutti");
                        }elseif ($reasignadoA == 'Dirección de Operaciones'){
                            if ($proyecto == 7 || $proyecto == 9){
                                  $mail->AddAddress   ("ocarracedo@cecaitra.org.ar", "Osvaldo Carraced");
                                  $mail->AddCC  ("esosa@cecaitra.org.ar", "Ezequiel Sosa");
                            }else{
                                $mail->AddAddress  ("mminutti@cecaitra.org.ar", "Marcelo Minutti");
                                $mail->AddCC  ($emailTo, $nameTo);
                            }
                        }elseif ($reasignadoA == 'Servicios Generales'){
                              $mail->AddAddress ("grodriguez@cecaitra.org.ar", "Gastón Rodriguez");
                        }
                        $mail->AddCC      ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                        $mail->Subject    = "[SC]Reparación: ".$equipoSerie. " - Orden reasignada";
                        $mail->Body       = "<p>La orden de reparación abierta el día <strong>".$fecha."</strong>, con nro <strong>".$reparacionNro."</strong> del equipo <strong>".$equipoSerie."</strong> se reasignó.</p> \n\n<p>Nueva categoría: <strong>".$reasignadoA. "</strong></p>
                                             <p>Observaciones: <strong>".$detalle."</strong></p> \n\n<p><em><strong>No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "Hola,\n\nLa orden de reparación nro ".$reparacionNro." del equipo ".$equipoSerie." se reasignó";
                        $mail->AddAddress ($emailTo, $nameTo); //,
                        break;

                        case '3': //(SOLICITUD APROBADA: SE CONVIERTE EN ORDEN)
                        $mail->AddReplyTo ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                        $mail->AddCC      ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                        $mail->AddCC ("rgastaldi@cecaitra.org.ar", "Roberto Gastaldi");
                        $mail->AddCC ("dmontenegro@cecaitra.org.ar", "Dylan Montenegro");
                        $mail->AddCC ("psorrentino@cecaitra.org.ar", "Pablo Sorrentino");
                        $mail->Subject    = "[SC]Reparación: ".$equipoSerie." - Solicitud aprobada";
                        $mail->Body       = "<p>La solicitud de reparación del día <strong>".$fecha."</strong>, y nro <strong>".$reparacionNro."</strong>, del equipo <strong>".$equipoSerie."</strong> se Aprobó</p>
                                             <p>Observaciones: <strong>".$detalle." </strong></p>\n\n<p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "La solicitud de reparación nro ".$reparacionNro." del equipo ".$equipoSerie." se Aprobó";
                        $mail->AddAddress ($emailTo, $nameTo); //,
                        break;

                        case '4': // (ORDEN RECHAZADA)
                        $mail->AddReplyTo ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                        $mail->AddCC      ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                        $mail->AddCC ("rgastaldi@cecaitra.org.ar", "Roberto Gastaldi");
                        $mail->AddCC ("dmontenegro@cecaitra.org.ar", "Dylan Montenegro");
                        $mail->AddCC ("psorrentino@cecaitra.org.ar", "Pablo Sorrentino");
                        $mail->Subject    = "[SC]Reparación: ".$equipoSerie." - Rechazada";
                        $mail->Body       = "<p>La solicitud de reparación creada el día <strong>".$fecha."</strong>, con nro <strong>".$reparacionNro."</strong> del equipo <strong>".$equipoSerie."</strong> fue rechazada</p>
                                             <p>Observaciones: <strong>".$detalle." </strong></p>\n\n<p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "La orden de reparación nro ".$reparacionNro." del equipo ".$equipoSerie." fue rechazada";
                        $mail->AddAddress ($emailTo, $nameTo);
                        break;

                        case '5': //   (ORDEN CALIBRACION MODIFICADA)
                        $mail->AddReplyTo ('psorrentino@cecaitra.org.ar','Pablo Sorrentino');
                        $mail->Subject    = "[SC]Calibración: - Equipo modificado";
                        $mail->Body       = "<p>Se realizó la siguiente modificación en el equipo <strong>".$equipoSerie."</strong></p>
                                             <p>".$detalle."</p>\n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "<p>Se modificó el equipo ".$equipoSerie."</p>";
                        $mail->AddCC      ("mminutti@cecaitra.org.ar", 'Marcelo Minutti');
                        $mail->AddCC      ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                        $mail->AddCC      ("mcelli@cecaitra.org.ar", "Martín Celli");
                        $mail->AddCC      ("mesadeayuda@cecaitra.org.ar", "Mesa de Ayuda");
                        $mail->AddAddress ($emailTo, $nameTo);
                        break;

                        case '6': // (SE AGREGÓ EQUIPO NUEVO)
                        $mail->AddReplyTo ('sistemas@cecaitra.org.ar', 'Sistemas CECAITRA');
                        $mail->Subject    = "[SC]Equipo Nuevo";
                        $mail->Body       = "<p>Se agregó un nuevo equipo: <strong>".$equipoSerie."</strong></p>
                                         \n\n
                                         <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                        $mail->AltBody    = "<p>Se agregó un nuevo equipo: ".$equipoSerie."</p>";
                        $mail->AddAddress ("chazanas@cecaitra.org.ar", "Carlos Hazañas"); //
                        break;

                        case '7': // (EQUIPO ENVIADO AL SOCIO)
                            $mail->AddReplyTo ('sistemas@cecaitra.org.ar','Sistemas CECAITRA');
                            $mail->Subject    = "[SC]Equipo en socio";
                            $mail->Body       = "<p>El equipo <strong>".$equipoSerie."</strong> ha sido enviado al socio</p>
                                         \n\n
                                         <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                            $mail->AltBody    = "<p>Ha sido enviado al socio el equipo: ".$equipoSerie."</p>";

                            //$mail->AddAddress ($emailTo, $nameTo); //
                            //$mail->AddCC ("chazanas@cecaitra.org.ar", "Carlos Hazañas");

                            switch ($propietario) {
                              case 'ANCA':
                                break;
                              case 'BAV':
                                break;
                              case 'CECAITRA':
                                break;
                              case 'COORDIN':
                                break;
                              case 'DETECTRA':
                                break;
                              case 'ELECTRÓNICA JAF':
                              case 'ELECTRONICA JAF':
                                $mail->AddCC ("jaf2k@infovia.com.ar", "Juan Francese");
                                $mail->AddCC ("adrianafrancese@speedy.com.ar", "Adriana Francese");
                                break;
                              case 'EXULTA':
                                break;
                              case 'FULL COLLECT':
                                break;
                              case 'MRM LOGÍSTICA INTEGRAL':
                                break;
                              case 'MS TRAFFIC':
                                break;
                              case 'SERVITEC':
                                break;
                              case 'SIVSA':
                                break;
                              case 'SUMSER':
                                break;
                              case 'TECPLATE':
                                break;
                              case 'TRUCAR':
                                break;
                              case 'VIAL CONTROL':
                                break;
                              case 'VIALSEGS':
                                break;
                            }
                        break;

                        case '8': // (ALTA NUEVA ORDEN)
                            if($proyecto == 1){ // REPARACIONES
                                $equipo_info = $this->mail_model->getTipoEquipo($equipoSerie);
                                $tipo = ($equipo_info->tipo_equipo == 0) ? "Cinemometro Fijo":"Cinemometro Movil";
                                $mail->AddReplyTo ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                                $mail->AddCC ("rgastaldi@cecaitra.org.ar", "Roberto Gastaldi");
                                $mail->AddCC ("dmontenegro@cecaitra.org.ar", "Dylan Montenegro");
                                $mail->AddCC ("psorrentino@cecaitra.org.ar", "Pablo Sorrentino");
                                $mail->Subject    = "[SC]Reparaciónes: ".$equipoSerie." (".$tipo.") - Nueva Orden";
                                $mail->Body       = "<p>Se creó la orden del equipo <strong>".$equipoSerie."</strong> el día ".$fecha."</p>
                                             \n\n
                                             <p>Detalles: <strong>".$detalle."</strong></p>
                                             \n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                                $mail->AltBody    = "<p>Se creó la orden del equipo: ".$equipoSerie."</p>";
                                $mail->AddAddress ($emailTo, $nameTo); //
                                $mail->AddCC ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                                $mail->AddCC ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                                break;
                            }elseif($proyecto == 2){ // MANTENIMIENTO
                                $mail->AddReplyTo ('chazanas@cecaitra.org.ar','Carlos Hazañas');
                                $mail->Subject    = "[SC]Nueva Orden";
                                $mail->Body       = "<p>Se creó la orden del equipo <strong>".$equipoSerie."</strong> el día ".$fecha."</p>
                                             \n\n
                                             <p>Detalles: <strong>".$detalle."</strong></p>
                                             \n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                                $mail->AltBody    = "<p>Se creó la orden del equipo: ".$equipoSerie."</p>";
                                $mail->AddAddress ($emailTo, $nameTo); //
                                $mail->AddCC ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                                break;
                            }elseif($proyecto == 3){ // INSTALACIONES
                                //$mail->AddReplyTo ('instalaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                                $mail->Subject    = "[SC]Nueva Orden";
                                $mail->Body       = "<p>Se creó la orden del equipo <strong>".$equipoSerie."</strong> el día ".$fecha."</p>
                                             \n\n
                                             <p>Detalles: <strong>".$detalle."</strong></p>
                                             \n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                                $mail->AltBody    = "<p>Se creó la orden del equipo: ".$equipoSerie."</p>";
                                $mail->AddAddress ($emailTo, $nameTo); //
                                //$mail->AddCC ('instalaciones@cecaitra.org.ar','Reparaciones Cecaitra');
                                $mail->AddCC ("chazanas@cecaitra.org.ar", "Carlos Hazañas");
                                break;
                            }

                        case '9': // (ALTA NUEVO MODELO)
                            $mail->Subject    = "[SC]Nuevo Modelo";
                            $mail->Body       = "<p>Se agregó un nuevo modelo de equipo: <strong>".$equipoSerie."</strong></p>
                                         \n\n
                                         <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                            $mail->AltBody    = "<p>Se agregó un nuevo modelo de equipo: ".$equipoSerie."</p>";
                            $mail->AddAddress ('chazanas@cecaitra.org.ar', 'Carlos Hazañas'); //
                            break;

                        case '10': // (SE AGREGÓ EQUIPO NUEVO)
                            $mail->AddReplyTo ('sistemas@cecaitra.org.ar', 'Sistemas CECAITRA');
                            $mail->Subject    = "[SC]Equipo Terminado";
                            $mail->Body       = "<p>El socio finalizó el remito de trabajo del equipo : <strong>".$equipoSerie."</strong></p>
                                             \n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                            $mail->AltBody = "<p>Ha sido devuelto del socio el equipo: ".$equipoSerie."</p>";
                            $mail->AddAddress ('reparaciones@cecaitra.org.ar','Reparaciones Cecaitra');

                            break;

                        case '11': // Pedido de presupuesto
                            $mail->AddReplyTo ('sistemas@cecaitra.org.ar', 'Sistemas CECAITRA');
                            $mail->Subject    = "[SC]Pedido de presupuesto - Socio ". $propietario."";
                            $mail->Body       = "<p>Se solicita un presupuesto para el equipo: <strong>".$equipoSerie."</strong> del proyecto ".$proyecto."</p>
                            <p>Numero de remito: <strong>".$reparacionNro."</strong></p>
                                             \n\n
                                             <p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
                            $mail->AltBody    = "<p>Se agregó un nuevo equipo: ".$equipoSerie."</p>";
                            $mail->AddAddress ("grodriguez@cecaitra.org.ar", "Gaston Rodriguez"); //
                            break;
                  }
             //$mail->Send();
      }

      function getGestor($MunId){ //ByMunId
          $sql = "SELECT tu.name, tu.email, mun.gestor
                  FROM tbl_users AS tu
                  LEFT JOIN municipios AS mun ON tu.userId = mun.gestor
                  WHERE mun.id = $MunId";
          $query = $this->db->query($sql);
          return $query->row();
      }

      function getGestorByID($userId){
          $sql = "SELECT tu.name, tu.email, mun.descrip
                    FROM tbl_users AS tu
                    LEFT JOIN municipios AS mun ON tu.userId = mun.gestor
                    WHERE tu.userId = $userId
                    GROUP BY tu.userId";
          $query = $this->db->query($sql);
          return $query->row();
      }

      function getAyudantes($MunId){ //ByMunId
          $sql = "SELECT tu.name, tu.email, mun.ayudantes
                  FROM tbl_users AS tu
                  LEFT JOIN municipios AS mun ON tu.userId = mun.ayudantes
                  WHERE mun.id = $MunId";
          $query = $this->db->query($sql);
          return $query->row();
      }

      function getAyudantesByID($userId){
          $sql = "SELECT tu.name, tu.email, mun.descrip
                    FROM tbl_users AS tu
                    LEFT JOIN municipios AS mun ON tu.userId = mun.ayudantes
                    WHERE tu.userId = $userId
                    GROUP BY tu.userId";
          $query = $this->db->query($sql);
          return $query->row();
      }
      function getProyectoByEquipo($equipo){
          $sql = "SELECT mun.descrip
                  FROM municipios AS mun
                  INNER JOIN equipos_main AS em ON em.municipio = mun.id
                  WHERE em.serie_int = '$equipo' AND em.eliminado = 0";
          $query = $this->db->query($sql);
          return $query->row();
      }

      function getTipoEquipo($equipo){
          $sql = "SELECT EM.tipo_equipo
                  FROM equipos_main AS EM
                  WHERE EM.serie = '$equipo' ";
          $query = $this->db->query($sql);
          return $query->row();
      }



      function mail_config($id_tipo)
      {
        $this->db->select('MC.subject, MC.body, MC.alt_body');
        $this->db->from('mail_config AS MC');
        $this->db->where("MC.id_tipo", $id_tipo);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
      }


      function mail_socios($id_tipo, $id_socio, $id_tipo_envio)
      {
        $this->db->select('U.name, U.email');
        $this->db->from('mail_socios AS MS');
        $this->db->join('tbl_users as U', 'U.userId = MS.id_usuario','left');
        $this->db->where("MS.mail_tipo", $id_tipo);
        $this->db->where("MS.id_socio", $id_socio);
        $this->db->where("MS.id_tipo_envio", $id_tipo_envio);
        $this->db->where("MS.habilitado", 1);

        $query = $this->db->get();
        $result = $query->result();

        $correos = array();
        foreach ($result as $valor) {
          $correos[$valor->email] = $valor->name;
        }

        return $correos;
      }

      function mail_gestores($id_tipo, $id_proyecto, $id_tipo_envio)
      {
        $this->db->select('U.name, U.email');
        $this->db->from('mail_gestores AS MG');
        $this->db->join('tbl_users as U', 'U.userId = MG.id_usuario','left');
        $this->db->where("MG.mail_tipo", $id_tipo);
        $this->db->where("MG.id_proyecto", $id_proyecto);
        $this->db->where("MG.id_tipo_envio", $id_tipo_envio);
        $this->db->where("MG.habilitado", 1);

        $query = $this->db->get();
        $result = $query->result();

        $correos = array();
        foreach ($result as $valor) {
          $correos[$valor->email] = $valor->name;
        }

        return $correos;
      }

      function mail_gral($id_tipo, $id_tipo_envio)
      {
        $this->db->select('U.name, U.email');
        $this->db->from('mail_gral AS MGR');
        $this->db->join('tbl_users as U', 'U.userId = MGR.id_usuario','left');
        $this->db->where("MGR.mail_tipo", $id_tipo);
        $this->db->where("MGR.id_tipo_envio", $id_tipo_envio);
        $this->db->where("MGR.habilitado", 1);

        $query = $this->db->get();
        $result = $query->result();

        $correos = array();
        foreach ($result as $valor) {
          $correos[$valor->email] = $valor->name;
        }

        return $correos;
      }

       function mail_enviado($datos_mail = NULL,$mails_to = NULL,$mails_cc = NULL,$mails_cco = NULL,$equipo = NULL,$proyecto = NULL,$observacion_extra = NULL, $fecha = NULL, $num_orden = NULL)
      {
        $mail = new PHPMailer();
        $mail->SetLanguage('es');
        $mail->IsSMTP(); //Establecemos que utilizaremos SMTP
        $mail->SMTPAuth   = TRUE; //Habilitamos la autenticación SMTP
        $mail->SMTPSecure = "tls";  //Establecemos el prefijo del protocolo seguro de comunicación con el servidor
        $mail->Host       = "smtp.office365.com"; //Establecemos nuestro servidor SMTP
        $mail->Port       = 587; //Establecemos el puerto SMTP en el servidor
        $mail->Username   = "sistemas@cecaitra.org.ar"; //La cuenta de correo
        $mail->Password   = "SisCec16"; //Password de la cuenta
        $mail->SetFrom('sistemas@cecaitra.org.ar', 'Sistemas CECAITRA'); //Quien envía el correo

        foreach ($mails_to as $email => $name) {
          $mail->AddAddress($email, $name);
        }

        foreach ($mails_cc as $email => $name) {
          $mail->AddCC($email, $name);
        }

        foreach ($mails_cco as $email => $name) {
          $mail->AddBCC($email, $name);
        }

        eval("\$datos_mail->subject = \"$datos_mail->subject\";");
        eval("\$datos_mail->body = \"$datos_mail->body\";");
        eval("\$datos_mail->alt_body = \"$datos_mail->alt_body\";");

        $mail->Subject = $datos_mail->subject;
        $mail->Body = $datos_mail->body;
        $mail->Body .= "<p><em><strong> No respondas este email, ya que el remitente es una casilla automática.</strong></em></p>";
        $mail->AltBody = $datos_mail->alt_body;

        //$mail->Send();

        if($_SERVER['HTTP_HOST'] === "localhost"){
          //Localhost
          // $mail->Send();
        }else{
          //SC - SCDEV
          $mail->Send();
        }
      }


}
?>
