<?php

$userId    = '';
$name      = '';
$nombre    = '';
$apellido  = '';
$email     = '';
$mobile    = '';
$roleId    = '';
$asociado  = '';
$puesto    = '';
$imei      = '';
$modelomov = '';
$sedeID    = '';
$id_sede   = '';
$interno   = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId    = $uf->userId;
        $name      = $uf->name;
        $nombre    = $uf->nombre;
        $apellido  = $uf->apellido;
        $email     = $uf->email;
        $mobile    = $uf->mobile;
        $roleId    = $uf->roleId;
        $asociado  = $uf->asociado;
        $puesto    = $uf->puesto;
        $imei      = $uf->imei;
        $modelomov = $uf->modelomov;
        $sedeID    = $uf->sedeID;
        $id_sede   = $uf->id_sede;
        $interno   = $uf->interno;
    }
}




?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"><?php echo $tipoUsuario ?></h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active"><?php echo $tipoItem." ".$tipoUsuario ?></li>
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
                        <h3 class="box-title">Información personal</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>agregar_editar_usuario" method="post" id="agregar_editar_usuario" role="form">
                    <input type="hidden" value="<?php echo $userId; ?>" name="userId" /> 
                    <input type="hidden" class="form-control" id="tipoItem" name="tipoItem" value="<?php echo $tipoItem ?>" >
                    <input type="hidden" class="form-control" id="tipoUsuario" name="tipoUsuario" value="<?php echo $tipoUsuario ?>" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre" value="<?php echo $nombre; ?>" maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese apellido" value="<?php echo $apellido; ?>" maxlength="100">
                                    </div>
                                </div>
                            </div>

                            <?php  if ($tipoUsuario == "Usuario") { ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" placeholder="Ingrese e-mail" name="email" value="<?php echo $email; ?>" maxlength="128">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <input type="password" class="form-control" id="password" placeholder="Contraseña" name="password" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cpassword">Confirmar contraseña</label>
                                            <input type="password" class="form-control" id="cpassword" placeholder="Confirme contraseña" name="cpassword" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sede">Sedes</label>
                                        <select class="form-control required" id="sede" name="sede">
                                            <option value="0">Seleccionar Sede</option>
                                            <?php
                                            if(!empty($sedes))
                                            {
                                                foreach ($sedes as $sd)
                                                {
                                                    ?>
                                                    <option value="<?php echo $sd->sedeID?>" <?php if($sd->sedeID == $id_sede) {echo "selected=selected";} ?>><?php echo $sd->sede ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="interno">Numero Interno</label>
                                        <input type="text" class="form-control digits" id="interno" placeholder="Ingrese numero" name="interno" value="<?php echo $interno; ?>" >
                                    </div>
                                </div>    
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Celular</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Ingrese numero" name="mobile" value="<?php echo $mobile; ?>" maxlength="10">
                                    </div>
                                </div>
                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="imei">Numero IMEI</label>
                                        <input type="text" class="form-control digits" id="imei" placeholder="Ingrese IMEI" name="imei" value="<?php echo $imei; ?>" >
                                    </div>
                                </div>    
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modelomov">Modelo de Celular</label>
                                        <input type="text" class="form-control" id="modelomov" placeholder="Ingrese modelo" name="modelomov" value="<?php echo $modelomov; ?>" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rol</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="0">Seleccionar Rol</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="puesto">Puesto</label>
                                        <select class="form-control required" id="puesto" name="puesto">
                                            <option value="0">Seleccionar Puesto</option>
                                            <?php
                                            if(!empty($puestos))
                                            {
                                                foreach ($puestos as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->id ?>" <?php if($rl->id == $puesto) {echo "selected=selected";} ?>><?php echo $rl->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="asociado">Asociado</label>
                                        <select class="form-control required" id="asociado" name="asociado">
                                            <option value="0">Seleccionar Asociado</option>
                                            <?php
                                            if(!empty($asociados))
                                            {
                                                foreach ($asociados as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->id ?>" <?php if($rl->id == $asociado) {echo "selected=selected";} ?>><?php echo $rl->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/user_AddEdit.js" type="text/javascript"></script>