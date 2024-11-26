<style media="screen">
#formContent {
  background: #fff;
  width: 100%;
  max-width: 450px;
  position: relative;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
}

img {
  border-radius: 50%;
  border-color: red;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  box-shadow: 0 7px 15px 0 rgba(0,0,0,0.3);
  display: none;
}

#subtitulo {
text-shadow: 2px 2px 6px #000000;
font-size: 24px;
}

html {
    overflow-y:hidden;
}

@media screen and (min-width:1024px) {
  html {
      overflow-y:hidden;
  }

  .login-box{
      position: relative;
      bottom: 50px;
  }

  img {
      display: inline-block;
  }

  #titulo {
      display: none;
  }
}
</style>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>CECAITRA | Sistema de Administración </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="login-page">
    <div class="login-box" >
      <div class="login-logo">
        <img src="<?= base_url(); ?>assets/images/logo_blanco.png" alt="Avatar" />
        <p id="titulo">CECAITRA</p>
        <h4><p class="lead" id="subtitulo">Sistema de Administración1111</p></h4>
      </div><!-- /.login-logo -->
      <div class="login-box-body" id="formContent">
        <h4><p class="login-box-msg">Bienvenido</p></h4>
        <?php $this->load->helper('form'); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php $this->load->helper('form'); ?>
        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('loginMe'); ?>" method="post">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input type="email" class="form-control" placeholder="Correo electrónico" name="email" required />
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" placeholder="Contraseña" name="password" required />
          </div>
          <br>
          <br>
          <div class="row">
            <div>
                <div class="pull-left">
                  <div class="col-lg-12">
                    <a href="<?= base_url('recuperar'); ?>" class="btn btn-block btn-primary">Recuperar clave</a>
                  </div>
                </div>
                <div class="pull-right">
                  <div class="col-lg-12">
                    <input type="submit" class="btn btn-block btn-success" value="Iniciar sesión" />
                  </div>
                </div>
            </div><!-- /.col -->
          </div>

        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?= base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>
