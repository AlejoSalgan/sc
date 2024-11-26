<?php
  if(isset($_POST['btn-submit'])) {

    $email = $_POST['txtemail']; // email

    $usuario = $this->recuperar_model->recuperar_usuario($email);

    $code = md5(uniqid(rand())); // toKen

    foreach ($usuario as $us){
      $id = base64_encode($us->userId); // id codificado
    }

    $date = date_create();

    $fecha_actual = date_format($date, 'Y-m-d H:i:s');
    
    $this->recuperar_model->actualizar_token($code, $email); // actualiza token
    
    $this->recuperar_model->actualizar_tokenDate($email, $fecha_actual); // actualiza fecha de creación del token

    if (!empty($usuario)){ //si existe el email
      $message= "
        Hola, $email
        <br /><br />
        Nos han solicitado reestablecer su contraseña, si ha hecho esto simplemente siga
                  el siguiente enlace, caso contrario ignore este mensaje.  <br /><br />
        Haga click en el siguiente enlace para restablecer su contraseña
        <br /><br />
        <a href=\"" .base_url() . "reset?id=$id&code=$code\">Click aquí para reiniciar su contraseña</a>
        <br /><br />
        Gracias :)
      ";
      $subject = "[SC]Reiniciar contraseña";
      
      $this->recuperar_model->send_mail($email,$message,$subject);
      
      $msg = "
        <div class='alert alert-success'>
          <button class='close' data-dismiss='alert'>&times;</button>
          Hemos enviado un correo electronico a $email. Haga click en el enlace de restablecimiento de contraseña en el email para generar una nueva contraseña.
        </div>
      ";
    } else { //si el email no está en la base de datos
      $msg = "
        <div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <center><strong>Lo sentimos!</strong>  El email no fue encontrado.<center><br>
          <center>Intentelo nuevamente.</center>
        </div>
      ";
    }
  }
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="login-page">
    <div class="login-box">

      <div class="login-logo">
        <a href="#"><b>CECAITRA</b>
        	<br>Sistema de Recuperación
        </a>
      </div><!-- /.login-logo -->
      
      <div class="login-box-body">

        <p class="login-box-msg">Ingrese su e-mail</p>
        
        <?php $this->load->helper('form'); ?>
        
        <div class="row">
          <div class="col-md-12">
            <?php 
              echo validation_errors(
                '<div class="alert alert-danger alert-dismissable">', 
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
              ); 
            ?>
          </div>
        </div>

        <?php
          if(isset($msg)) {
            echo $msg;
          }
          else {
        ?>
            <div class='alert alert-info' role="alert" >
              Por favor, introduzca su dirección de correo electrónico. Recibirá un enlace para crear una nueva contraseña por correo electrónico.
            </div>  
        <?php
          }
        ?>
			
      	<form class="form-signin" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Correo electrónico" name="txtemail" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="pull-center">
              <div class="col-xs-12">
                <input type="submit" class="btn btn-primary btn-block btn-flat" name="btn-submit" value="Generar nueva contraseña" />
              </div>
            </div><!-- /.col -->
          </div>
        </form>
    
      </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    <script src="/assets/js/jQuery-2.1.4.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

  </body>

</html>