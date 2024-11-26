<?php

$userId       = '';
$name         = '';
$nombre       = '';
$apellido     = '';
$email        = '';
$mobile       = '';
$roleId       = '';
$asociado     = '';
$puesto       = '';
$imei         = '';
$modelomov    = '';
$role         = '';
$u_tipo       = '';
$u_puesto     = '';
$u_equipo     = '';
$u_propiet    = '';
$id_sede      = '';
$sede_descrip = '';
$telefono     = '';
$direccion    = '';
$interno      = '';


if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId       = $uf->userId;
        $name         = $uf->name;
        $nombre       = $uf->nombre;
        $apellido     = $uf->apellido;
        $email        = $uf->email;
        $mobile       = $uf->mobile;
        $roleId       = $uf->roleId;
        $asociado     = $uf->asociado;
        $puesto       = $uf->puesto;
        $imei         = $uf->imei;
        $modelomov    = $uf->modelomov;
        $role         = $uf->role;
        $u_tipo       = $uf->u_tipo;
        $u_puesto     = $uf->u_puesto;
        $u_equipo     = $uf->u_equipo;
        $u_propiet    = $uf->u_propiet;
        $id_sede      = $uf->id_sede;
        $sede_descrip = $uf->sede_descrip;
        $telefono     = $uf->telefono;
        $direccion    = $uf->direccion;
        $interno      = $uf->interno;

    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Detalles del contacto</h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <?php switch ($u_tipo):
                          case 1:?>
                            <li><a href="javascript:history.go(-1)">Listado de Usuarios</a></li>
                            <li class="active">Detalles  <?= $nombre. " " .$apellido; ?></li>
                    <?php break;
                          case 2:?>
                            <li><a href="javascript:history.go(-1)">Listado de Empleados</a></li>
                            <li class="active">Detalles  <?= $nombre. " " .$apellido; ?></li>
                    <?php break;
                  endswitch;?>
              </ol>
          </div>
      </div>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 align="left">
                          <?php $av = base_url()."/assets/dist/img/avatar".strval($this->session->userdata ( 'userId' )).".png"; ?>

                          <?php if (@getimagesize($av)): ?>
                              <img src="<?= $av?>" class="user-image img-circle" alt="User Image" height="50" width="50"/>
                          <?php else: ?>
                              <img src="<?= base_url(); ?>assets/dist/img/avatar.png" class="user-image" height="50" width="50" alt="User Image" />
                          <?php endif; ?>

                          <?= $nombre. " " .$apellido; ?>
                        </h3>
                    </div><!-- /.box-header -->

                    <input type="hidden" value="<?= $userId; ?>" name="userId" />
                        <div class="box-body">
                          <table class="table table-hover">
                              <tr>
                                <td><strong>Correo:</strong></td>
                                <td><?= ($email == NULL) ? "Sin e-mail": $email;?></td>
                              </tr>
                              <tr>
                                <td><strong>Sede:</strong></td>
                                <td><?= ($id_sede == 0) ? "Sin sede": $sede_descrip;?></td>
                              </tr>
                              <tr>
                                <td><strong>Direccion:</strong></td>
                                <td><?= ($direccion == NULL) ? "Sin direccion": $direccion;?></td>
                              </tr>
                              <tr>
                                <td><strong>Telefonos:</strong></td>
                                <td><?= ($telefono == NULL) ? "Sin telefono": $telefono;?></td>
                              </tr>
                              <tr>
                                <td><strong>Interno:</strong></td>
                                <td><?= ($interno == NULL) ? "Sin interno": $interno;?></td>
                              </tr>
                              <tr>
                                <td><strong>Celular:</strong></td>
                                <td><?= $mobile; ?></td>
                              </tr>
                              <tr>
                                <td><strong>IMEI:</strong></td>
                                <td><?= $imei; ?></td>
                              </tr>
                              <tr>
                                <td><strong>Modelo:</strong></td>
                                <td><?= $modelomov; ?></td>
                              </tr>
                              <tr>
                                <td><strong>Rol:</strong></td>
                                <td><?=$role; ?></td>
                              </tr>
                              <tr>
                                <td><strong>Puesto:</strong></td>
                                <td><?=$u_puesto; ?></td>
                              </tr>
                              <tr>
                                <td><strong>Asociado:</strong></td>
                                <td><?=$u_propiet; ?></td>
                              </tr>
                          </table>
                          <hr style="height:1px;border:solid 0.6px;color:#ABB2B9;background-color:#333;" />
                          <div class="row">
                              <div class="col-md-12">
                              		<a class="btn btn-primary" href="javascript:history.go(-1);">Volver</a>
    							            </div>
                          </div>
                        </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
