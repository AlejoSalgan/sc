<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Componentes</h4> 
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li><a href="<?=base_url('componentesListing')?>">Componentes listado</a></li> 
                    <li class="active">Agregar nuevo componente</li>
                </ol>
            </div>
        </div>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles del Componente <strong>sin SERIE</strong></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addComponente" action="<?php echo base_url() ?>addNewComponente2" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="cantidad">Modelo</label>
                                        <input type="text" class="form-control required" id="modelo" name="modelo" maxlength="150" autofocus="">
                                    </div>
                                </div>

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label>                                        
                                        <input type="number" class="form-control required digits" id="cantidad"  name="cantidad" maxlength="3" value="1" min="0" max="999" >
                                    </div>                                    
                                </div>
                            </div>                           

                            <div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="marca">Marcas</label>
                                        <select class="form-control" id="marca" name="marca">
                                            <option value="0">Seleccionar Marca</option>
                                            <?php
                                            if(!empty($marcas))
                                            {
                                                foreach ($marcas as $marca)
                                                {
                                                    ?>
                                                    <option value="<?php echo $marca->id ?>"><?php echo $marca->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">Tipos</label>
                                        <select class="form-control required" id="tipo" name="tipo">
                                            <option value="0">Seleccionar Tipo</option>
                                            <?php
                                            if(!empty($tipos))
                                            {
                                                foreach ($tipos as $tipo)
                                                {
                                                    ?>
                                                    <option value="<?php echo $tipo->id ?>"><?php echo $tipo->descrip ?></option>
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
                                        <label for="eventoView">Eventos</label>
                                        <select class="form-control required" id="eventoView" name="eventoView">
                                            <option value="0">Seleccionar Eventos</option>
                                            <?php
                                            if(!empty($eventos))
                                            {
                                                foreach ($eventos as $evento)
                                                {
                                                    ?>
                                                    <option value="<?php echo $tipo->id ?>"><?php echo $evento->descrip ?></option>
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
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descrip">Descripción</label>
                                        <textarea name="descrip" id="descrip" class="form-control" rows="5" cols="50" style="resize:none"></textarea>
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

<script src="<?php echo base_url(); ?>assets/js/addComponente2.js" type="text/javascript"></script>


       