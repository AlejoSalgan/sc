<?php

$municipioId                = '';
$descrip                    = '';
$iniciales                  = '';
$codigo_municipio           = '';
$activo                     = '';
$observaciones              = '';
$gestorId                   = '';

if(!empty($municipioInfo))
{
    foreach ($municipioInfo as $ef)
    {
        $municipioId                = $ef->id;
        $descrip                    = $ef->descrip;
        $iniciales                  = $ef->iniciales;
        $codigo_municipio           = $ef->codigo_municipio;
        $activo                     = $ef->activo;
        $observaciones              = $ef->observaciones;
        $gestorId                   = $ef->gestor;
    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proyectos
        <small>Modificar Proyecto</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div class="form-group">
                            <a class="btn btn-default" href="javascript:history.go(-1);">Volver</a>
                        </div>
                    </div>
                </div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles del Proyecto</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editMunicipio" method="post" id="editMunicipio" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="descrip">Nombre</label>
                                        <input type="text" class="form-control required" id="descrip" name="descrip" value="<?php echo $descrip; ?>" maxlength="100" autofocus="">
                                        <input type="hidden" value="<?php echo $municipioId; ?>" name="municipioId" />
                                    </div>                               
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="iniciales">Iniciales</label>
                                        <input type="text" class="form-control" id="iniciales" name="iniciales" maxlength="10" value="<?php echo $iniciales; ?>">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gestor">Gestor</label>
                                        <select class="form-control required" id="gestor" name="gestor">
                                            <option value="0">Seleccionar Gestor</option>
                                            <?php
                                            if(!empty($gestores))
                                            {
                                                foreach ($gestores as $gestor)
                                                {
                                                    ?>
                                                    <option value="<?php echo $gestor->userId ?>" <?php if($gestor->userId == $gestorId) {echo "selected=selected";} ?>><?php echo $gestor->name ?></option>
                                                    
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo_municipio">Código</label>
                                        <input type="text" class="form-control" id="codigo_municipio" name="codigo_municipio" maxlength="10" value="<?php echo $codigo_municipio; ?>">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="activo">Activo</label>
                                            <p style="text-align: center;"> <input type="checkbox" id="activo" name="activo" value="1" <?php if($activo == 1) {echo 'checked="checked"';} ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3" cols="20" style="resize:none"><?php echo $observaciones; ?></textarea>
                                    </div> 
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                            <input type="reset" class="btn btn-default" value="Limpiar" />
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>