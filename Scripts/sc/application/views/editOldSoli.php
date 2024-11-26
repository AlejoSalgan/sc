<?php

$repaId = '';
$municipioId     = '';
$idequipo       = '';
$fecha_alta     = '';
$equipoSerie    = '';
$activo         = '';
$diagnostico_previo        = '';
$descripProyecto    = '';

if(!empty($repaInfo))
{
    foreach ($repaInfo as $ef)
    {
        $repaId                     = $ef->id;
        $municipioId                = $ef->idproyecto;        
        $idequipo                   = $ef->idequipo;
        $fecha_alta                 = $ef->fecha_alta;
        $equipoSerie                = $ef->equipoSerie;
        $activo                     = $ef->activo;
        $diagnostico_previo         = $ef->diagnostico_previo;
        $descripProyecto            = $ef->descripProyecto;

    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Solicitud de Revision Tecnica 
        <small>Modificar Solicitud de Revision Tecnica</small>
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
                        <h3 class="box-title">Detalles Orden Reparación</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editSoli" method="post" id="editSoli" role="form">

                        <div class="box-body">
                            <div class="row">                       
                            <!-- Select Proyecto -->
                            
                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha de Alta</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="fecha_alta"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                        <input id="fecha_alta" name="fecha_alta" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_alta; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id">Nº Orden de Servicio</label>
                                        <input type="text" class="form-control" id="repaId" name="repaId" value="<?php echo $repaId ?>" size="10" readonly>
                                    </div>
                                </div>
                        </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idproyecto">Proyecto</label>
                                        <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $descripProyecto?>"  readonly>
                                        <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto"/>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="equipoSerie"><i class="fa fa-video-camera" aria-hidden="true"></i> Equipo serie</label>
                                                                              
                                        <input type="text" class="form-control" id="equipoSerie" name="equipoSerie" value="<?php echo $equipoSerie ?>"  readonly>
                                        <input type="hidden" value="<?php echo $idequipo; ?>" name="idequipo" id="idequipo"/>  
                                           
                              
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">                                
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="diagnostico_previo">Diagnostico Previo</label>
                                        <textarea name="diagnostico_previo" id="diagnostico_previo" class="form-control" rows="5" cols="50"style="resize:none"><?php echo $diagnostico_previo; ?> </textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                      
                        <div class="box-body">
                            <div class="row">                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="activo">Activo&nbsp;&nbsp;</label>
                                        <input type="checkbox" id="activo" name="activo" value="1" <?php if($activo == 1) {echo 'checked="checked"';} ?>> <p style="text-align: center;">
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

<script>
    $(function() {
$("#tecnico option:selected").each(function () {
                mobile = $(this).data('mobile');
                imei = $(this).data('imei');
                $("#celular").val(mobile);
                $("#imei").val(imei);
            });
        $('#fecha_visita').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $("#tecnico").change(function () {
           $("#tecnico option:selected").each(function () {
                mobile = $(this).data('mobile');
                imei = $(this).data('imei');
                $("#celular").val(mobile);
                $("#imei").val(imei);
            });
        });
       
    });

$("#idproyecto").change(function () {
        valor = $(this).val();
        $.post("<?=base_url('ordenesb/equiposajax')?>", {proyecto: valor})
        .done(function(data) {
            var result = JSON.parse(data);
            var option = '';
            $("#idequipo").html("");
            var previo = ""; var i = 0;
            result.forEach(function(equipo) {
                if (previo != equipo['descrip']) {
                    previo = equipo['descrip'];
                    option = option + '<optgroup label="'+equipo['descrip']+'">';
                }
                option = option + "<option ";
                if ((equipo['evento_actual'] == 60 && equipo['estado'] == 2) || (equipo['evento_actual'] == 110 && equipo['estado'] == 5 ) ) {
                    option = option + 'style="color:DodgerBlue;" ';
                } else {
                    option = option + 'disabled style="color:red;" ';

                }
                option = option + 'value="'+equipo['id']+'">'+equipo['serie']+'</option>';
                if (i+1 >= result.length) {
                    option = option + "</optgroup>";
                } else {
                    if (result[i+1]['descrip'] != equipo['descrip']) {
                        option = option + "</optgroup>";
                    }
                }
                i++;
            });
            $("#idequipo").append(option);
            $('.selectpicker').selectpicker('refresh');
        });
    });

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