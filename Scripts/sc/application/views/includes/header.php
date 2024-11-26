<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?= $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?= base_url('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link href="<?= base_url('assets/dist/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.1 -->
    <link href="<?= base_url('assets/plugins/ionicons_201-css/ionicons.min.css'); ?> " rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/datepicker/datepicker3.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" type="text/css" />
	  <link href="<?= base_url('assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/fullcalendar_340-css/fullcalendar.min.css'); ?>" rel="stylesheet" type="text/css">
    
    <link href="<?= base_url('assets/js/select2/dist/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="print.css" rel="stylesheet" type="text/css" media="print" />

    <script src="<?= base_url('assets/jQueryUI/Jquery_321.min.js');?>" type="text/javascript"></script>
    <script type="text/javascript">
        var baseURL = "<?= base_url(); ?>";
    </script>

    <link href="<?= base_url('assets/css/calendar.css'); ?>" type="text/css" rel="stylesheet" />   
    <link href="<?= base_url('assets/css/avatar_user.css'); ?>" rel="stylesheet" type="text/css" >

    <?php require APPPATH . '/libraries/listpermisos.php'; ?>
  </head>
  
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="<?= base_url(); ?>" class="logo">
          <span class="logo-mini"><b>S</b>C</span>
          <span class="logo-lg"><b>Sistema</b> CECAITRA</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu"><!-- User Account: style can be found in dropdown.less -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <table>
                  <tr>
                    <td>
                      <div class="circle">
                        <span class="initials"><?=substr($nombre, 0, 1).substr($apellido, 0, 1)?></span>
                      </div>
                    </td>
                    <td><span class="hidden-xs">&nbsp;&nbsp;&nbsp;</span></td>
                    <td><span class="hidden-xs"><?= $name; ?></span></td>
                  </tr>
                </table>
                </a>

                <ul class="dropdown-menu ">
                    <li >
                      <div class="inner" style="background-color: #048cbc">
                        	<div class="row">
                            <div class="col-sm-4 ">
                              <div class="circle2">
                                <span class="initials2"><?=substr($nombre, 0, 1).substr($apellido, 0, 1)?></span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-8 ">
                                <h4 class="description-header" style="color:white"><a class="perfil" href="<?= base_url().'verPersonal/'.$vendorId; ?>"><?=$name?></a></h4>
                                <p style="color:white"><?= $puesto_descrip; ?></p>
                            </div>
                          </div>
                      </div>
                    </li>
                    <ul class="nav nav-stacked">
                      <li><a href="<?= base_url('loadChangePass'); ?>" style="color:grey"><i class="fa fa-lock"></i> Cambiar contraseña</a></li>
                      <li><a href="<?= base_url('logout'); ?>" style="color:grey"><i class="fa fa-power-off"></i> Cerrar sesión</a></li>
  		              </ul>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
