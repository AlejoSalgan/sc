<?php

$componenteId = '';
$serie = '';
$serieEq = '';
$idequipo = '';
$descrip = '';
$idmarca = '';
$idtipo = '';
$evento_actual = '';
$modelo = '';
$activo = '';

if(!empty($componenteInfo))
{
    foreach ($componenteInfo as $ef)
    {
        $componenteId = $ef->id;
        $serie = $ef->serie;
        $serieEq = $ef->serieEq;
        $idequipo = $ef->idequipo;
        $descrip = $ef->descrip;
        $idmarca = $ef->idmarca;
        $idtipo = $ef->idtipo;
        $evento_actual = $ef->evento_actual;
        $modelo = $ef->modelo;
        $activo = $ef->activo;
    }
}    

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        COMPONENTES 
        <small>Modificar Componente</small>
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
                        <h3 class="box-title">Detalles del Componente</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editComponente" method="post" id="editComponente" role="form">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="serieView">Serie</label>
                                        <input type="text" class="form-control" id="serieView" name="serieView" value="<?php echo $serie; ?>" disabled="disabled">
                                        <input type="hidden" value="<?php echo $componenteId; ?>" name="componenteId" />
                                        <input type="hidden" value="<?php echo $serie; ?>" name="serie" id="serie" />  
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="equipo">Equipo</label>
                                    <input type="text" id="search_data" class="form-control search-input" name="search-term" value="<?php echo $serieEq; ?>" onkeyup="liveSearch()" autocomplete="off">
                                    <div id="suggestions">
                                        <div id="autoSuggestionsList">
                                        </div>
                                    </div>
                                    <input type="hidden" name="idequipo" id="idequipo" value="<?php echo $idequipo; ?>" /> 
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="cantidad">Modelo</label>
                                        <input type="text" class="form-control required" id="modelo" name="modelo" maxlength="150" value="<?php echo $modelo; ?>">
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
                                                    <option value="<?php echo $marca->id ?>"<?php if($marca->id == $idmarca) {echo "selected=selected";} ?>><?php echo $marca->descrip ?></option>
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
                                                    <option value="<?php echo $tp->id; ?>" <?php if($tp->id == $idtipo) {echo "selected=selected";} ?>><?php echo $tp->descrip ?></option>
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
                                        <label for="evento">Lugar</label>
                                        <select class="form-control required" id="evento" name="evento">
                                            <option value="0">Seleccionar Lugar</option>
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
                            </div><!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descrip">Descripción</label>
                                        <textarea name="descrip" id="descrip" class="form-control" rows="5" cols="50" style="resize:none"><?php echo $descrip; ?></textarea>
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

<script>
            function liveSearch() {

                var input_data = $('#search_data').val();
                if (input_data.length === 0) {
                    $('#suggestions').hide();
                } else {


                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/livesearch/search",
                        data: {search_data: input_data},
                        success: function (data) {
                            // return success
                            if (data.length > 0) {
                                $('#suggestions').show();
                                $('#autoSuggestionsList').addClass('auto_list');
                                $('#autoSuggestionsList').html(data);
                            }
                        }
                    });
                }
            }

            function cargar(param1, param2) {  
                //$('#div_dinamico_anim').html("Hola " + param1); 
                $("#idequipo").val(param1);
                $("#search_data").val(param2);
            }
            
            $('body').on('click', '.solTitle', function() {
                cargar( $(this).attr('rel'), $(this).text() );
                $('#suggestions').hide();

            });

        </script>