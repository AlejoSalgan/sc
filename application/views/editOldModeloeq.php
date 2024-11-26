<?php

$modeloeqId                 = '';
$descrip                    = '';
$activo                     = '';
$descrip_alt                = '';
$sigla                      = '';
$asociado                   = '';
$observaciones              = '';

if(!empty($modeloeqInfo))
{
    foreach ($modeloeqInfo as $ef)
    {
        $modeloeqId                 = $ef->id;
        $descrip                    = $ef->descrip;
        $activo                     = $ef->activo;
        $descrip_alt                = $ef->descrip_alt;
        $sigla                      = $ef->sigla;
        $asociado                   = $ef->asociado;
        $observaciones              = $ef->observaciones;        
    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Modelo de Equipo
        <small>Modificar Modelo de Equipo</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="row">
                 	<div class="col-xs-12">
                         <div class="text-right"  >
                              <ol class="breadcrumb" style="background-color: transparent">
                                <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                                <li><a href="<?=base_url('modeloseqListing')?>">Modelos equipos</a></li>
                                <li class="active">Modificar modelo</li>
                              </ol>          
                         </div>
                    </div>
                </div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles Modelo de Equipo</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editModeloeq" method="post" id="editModeloeq" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label for="descrip">Nombre</label>
                                        <input type="text" class="form-control required" id="descrip" name="descrip" value="<?php echo $descrip; ?>" maxlength="100" autofocus="">
                                        <input type="hidden" value="<?php echo $modeloeqId; ?>" name="modeloeqId" />
                                    </div>                               
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sigla">Sigla</label>
                                        <input type="text" class="form-control required" id="sigla" name="sigla" value="<?php echo $sigla; ?>" maxlength="100">
                                    </div>
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="descrip_alt">Descripción Alternativa</label>
                                        <input type="text" class="form-control required" id="descrip_alt" name="descrip_alt" value="<?php echo $descrip_alt; ?>" maxlength="100">
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
                                                    <option value="<?php echo $rl->descrip ?>" <?php if($rl->descrip == $asociado) {echo "selected=selected";} ?>><?php echo $rl->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="activo">Activo</label>
                                        <p style="text-align: left;"> <input type="checkbox" id="activo" name="activo" value="1" <?php if($activo == 1) {echo 'checked="checked"';} ?>>
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