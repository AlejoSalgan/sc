<?php
if(empty($_GET['id']) && empty($_GET['code']))
{
    redirect('loginMe');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
    $id = base64_decode($_GET['id']); // id del usuario

    $usuario = $this->recuperar_model->get_usuarioById($id);

    foreach ($usuario as $us){        
        $name = $us->name;         // nombre del usuario
        $email = $us->email;
        $tokenDB = $us->tokenCode; // 
        $tokenDate = $us->tokenDate; // fecha en que se generó el token en la base de datos
    }

    $code = $_GET['code']; // toKen

    $date = date_create();
    $fecha_actual = date_format($date, 'Y-m-d H:i:s');

    $datetime1 = date_create($tokenDate);
    $datetime2 = date_create($fecha_actual);
    $intervalo = date_diff($datetime1, $datetime2);
    $intervalo->format('%R%a días');

    $año = $intervalo->y;
    $mes = $intervalo->m;
    $dia = $intervalo->d;
    $hora = $intervalo->h;
    $minutos = $intervalo->i;
    $segundos = $intervalo->s;

    if ($code == $tokenDB && $año == 0 && $mes == 0 && $dia == 0 && $hora == 0 && $minutos <= 15)
    {
        if(!empty($usuario) && !empty($code))
        {
            if(isset($_POST['btn-reset-pass']))
            {
                $pass = $_POST['pass'];
                $cpass = $_POST['confirm-pass'];

                if($cpass !== $pass)
                {
                    $msg = "<div class='alert alert-danger'>
    						<button class='close' data-dismiss='alert'>&times;</button>
    						<strong>Lo sentimos!</strong>  Las contraseñas no coinciden.
                            <center><strong>Intentelo nuevamente.</strong></center>
    						</div>";
                }
                else
                {
                    $password = md5($cpass);
                    
                    $this->recuperar_model->newPass($password, $id, $code);
                    
                    $msg = "<div class='alert alert-success'>
    						<button class='close' data-dismiss='alert'>&times;</button>
    						<center> <strong> Contraseña cambiada </strong> </center> </div>
                            <div class='alert alert-success'><center> ¡ ESPERE !<br> LO ESTAMOS REDIRECCIONANDO A LA PÁGINA PRINCIPAL </center></div>";
                    
                    $result = $this->login_model->loginMe($email, $password);
                    
                    if(count($result) > 0)
                    {
                        foreach ($result as $res)
                        {
                            $sessionArray = array('userId'=>$res->userId,
                                'role'=>$res->roleId,
                                'roleText'=>$res->role,
                                'name'=>$res->name,
                                'puesto'=>$res->puesto,
                                'puesto_descrip'=>$res->puesto_descrip,
                                'isLoggedIn' => TRUE
                            );
                            
                            $this->session->set_userdata($sessionArray);

                            header("refresh:4;\"" . base_url() . "dashboard");
                          
                        }
                    }
                }
            }
        }
    }
    else
    {
        if (!($code == $tokenDB)){
            $msg = "<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<center>Ha utilizado un link antiguo, por favor solicite restablecer nuevamente su contraseña:</center>
                <p><a href=\"" . base_url() . "recuperar\"><strong><center>Haga click aquí</center></strong></a></p>
				</div>";
        }
        if (!($año == 0 && $mes == 0 && $dia == 0 && $hora == 0 && $minutos <= 15)){
            $msg = "<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<center>Ha superado los 15 minutos de validez que poseía el link de recuperación, por favor
                solicite restablecer nuevamente su contraseña:</center>
                <p><a href=\"" . base_url() . "recuperar\"><strong><center>Haga click aquí</center></strong></a></p>
				</div>"; 
        }
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
        	<br>Restablecer contraseña</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php $this->load->helper('form'); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', 
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
                <?php
			if(isset($msg))
			{
				echo $msg;
			}
			else
			{
				?>
              	<div class='alert alert-success'>
				Hola <strong><?php echo $name ?></strong>, estás aquí para restablecer tu contraseña olvidada.
				</div>  
                <?php
			}
			?>
			
      	<form class="form-signin" method="post">
      	
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Contraseña nueva" name="pass" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Confirme contraseña" name="confirm-pass" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="pull-center">
            <div class="col-xs-12">
              <input type="submit" class="btn btn-primary btn-block btn-flat" name="btn-reset-pass" value="Reiniciar su contraseña" />
            </div>
            </div><!-- /.col -->
          </div>
          
        </form>
        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>