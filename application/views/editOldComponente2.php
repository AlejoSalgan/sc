<?php

    $modelo                 = '';
    $cantidad               = '';
    $descrip                = '';
    $marcaId                = '';
    $tipoId                 = '';
    $evento_actual          = '';
    $activo                 = '';

if(!empty($componenteInfo))
{
    foreach ($componenteInfo as $ef)
    {
        $modelo             = $ef->modelo;
        $cantidad           = $ef->cantidad;
        $descrip            = $ef->descrip;
        $marcaId            = $ef->idmarca;
        $tipoId             = $ef->idtipo;
        $evento_actual      = $ef->evento_actual;
        $activo             = $ef->activo;
    }
}    

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        COMPONENTES 
        <small>Modificar componente</small>
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
                                <li><a href="<?=base_url('componentesListing')?>">Componentes listado</a></li> 
                                <li class="active">Modificar Componente	 </li>
                              </ol>          
                         </div>
                     </div>
                </div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles del Componente <strong>sin Serie</strong></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editComponente2" method="post" id="editComponente2" role="form">
                        <input type="hidden" value="<?php echo $tipoId; ?>" name="tipoIdOld" />
                        <input type="hidden" value="<?php echo $marcaId; ?>" name="marcaIdOld" />
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="cantidad">Modelo</label>
                                        <input type="text" class="form-control required" id="modelo" name="modelo" maxlength="150" value="<?php echo $modelo; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number" class="form-control required digits" id="cantidad"  name="cantidad" maxlength="3" value="<?php echo $cantidad; ?>" min="0" max="999" >
                                    </div>                                    
                                </div>
                            </div>                          

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="marca">Marcas</label>
                                        <select class="form-control required" id="marca" name="marca">
                                            <option value="0">Seleccionar Marca</option>
                                            <?php
                                            if(!empty($marcas))
                                            {
                                                foreach ($marcas as $marca)
                                                {
                                                    ?>
                                                    <option value="<?php echo $marca->id ?>"<?php if($marca->id == $marcaId) {echo "selected=selected";} ?>><?php echo $marca->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">Tipo</label>
                                        <select class="form-control" id="tipo" name="tipo">
                                            <option value="0">Seleccionar Tipo</option>
                                            <?php
                                            if(!empty($tipos))
                                            {
                                                foreach ($tipos as $tp)
                                                {
                                                    ?>
                                                    <option value="<?php echo $tp->id; ?>" <?php if($tp->id == $tipoId) {echo "selected=selected";} ?>><?php echo $tp->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>   
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="evento">Evento</label>
                                        <select class="form-control required" id="evento" name="evento">
                                            <option value="0">Seleccionar Evento</option>
                                            <?php
                                            if(!empty($eventos))
                                            {
                                                foreach ($eventos as $evento)
                                                {
                                                    ?>
                                                    <option value="<?php echo $evento->id; ?>" <?php if($evento->id == $evento_actual) {echo "selected=selected";} ?>><?php echo $evento->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="activo"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="activo">Activo&nbsp;&nbsp;</label>
                                        <input type="checkbox" id="activo" name="activo" value="1" <?php if($activo == 1) {echo 'checked="checked"';} ?>> <p style="text-align: center;">
                                    </div>
                                </div>      
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descrip">Descripción</label>
                                        <textarea name="descrip" id="descrip" class="form-control" rows="5" cols="50" style="resize:none"><?php echo $descrip; ?>
                                        </textarea>
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

<script src="<?php echo base_url(); ?>assets/js/editOldComponente2.js" type="text/javascript"></script>

