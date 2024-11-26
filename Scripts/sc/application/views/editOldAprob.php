<?php

$calibId                        = '';
$fecha_alta                     = '';
$municipioId                    = '';
$descripProyecto                = '';
$idequipo                       = '';
$equipoSerie                    = '';
$tipo_servicio                  = '';
$tipo_ver                       = '';
$prioridad                      = '';
$descripPrioridad               = '';
//$nro_oc                         = '';
//$fecha_oc                       = '';
//$observaciones_serv             = '';
$distancia_inti                 = '';
$horario_calib                  = '';
$observacion_solicalib          = '';
$movil                          = '';

$ord_tipo                       = '';

if(!empty($calibInfo))
{
    foreach ($calibInfo as $ef)
    {
        $calibId                                = $ef->id;
        $fecha_alta                             = $ef->fecha_alta;
        $municipioId                            = $ef->idproyecto;
        $descripProyecto                        = $ef->descripProyecto;
        $idequipo                               = $ef->idequipo;
        $equipoSerie                            = $ef->equipoSerie;
        $tipo_servicio                          = $ef->tipo_servicio;
        $tipo_ver                               = $ef->tipo_ver;
        $prioridad                              = $ef->prioridad;
        $descripPrioridad                       = $ef->descripPrioridad;
        //$nro_oc                                 = $ef->nro_oc;
        //$fecha_oc                               = $ef->fecha_oc;
        //$observaciones_serv                     = $ef->observaciones_serv;
        $distancia_inti                         = $ef->distancia_inti;
        $horario_calib                          = $ef->horario_calib;
        $observacion_solicalib                  = $ef->observacion_solicalib;
        $movil                                  = $ef->movil;
        $ord_tipo                               = $ef->ord_tipo;
        
    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detalle Orden de Solicitud
        <small>Modificar Solicitud de Calibración</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-xs-8">
              <!-- general form elements -->
              
                 <div class="text-right"  >
                      <ol class="breadcrumb" style="background-color: transparent">
                        <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                        <li><a href="javascript:history.go(-1)">Calibraciones</a></li>
                        <li class="active">Editar orden de Calibración</li>
                      </ol>          
                 </div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles Orden Calibración</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->   
                    <form role="form" action="<?php echo base_url() ?>editAprob" method="post" id="editAprob" role="form">
                    <input type="hidden" class="form-control" id="tipo" name="ord_tipo" value="<?php echo $ord_tipo ?>" >

                        <div class="box-body">
                            <div class="row">                       
                            <!-- Fecha Visita -->
                            
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
                                        <input type="text" class="form-control" id="calibId" name="calibId" value="<?php echo $calibId ?>" size="10" readonly>
                                    </div>
                                </div>
                        </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idproyecto">Proyecto</label>
                                        <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $descripProyecto?>"  readonly>
                                        <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_servicio">Tipo de Servicio</label>
                                        <input type="text" class="form-control" id="tipo_servicio" name="tipo_servicio" value="<?php echo $tipo_ver?>"  readonly>                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prioridad">Prioridad</label>
                                        <input type="text" class="form-control" id="prioridad" name="prioridad" value="<?php echo $descripPrioridad?>"  readonly>
                                    </div>
                                </div>
                          </div> 
                       </div><!-- /.box-body -->         
                       
                       <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="distancia_inti">Distancia INTI</label>
                                        <select class="form-control required" id="distancia_inti" name="distancia_inti">
                                            <option value="0" <?php if($distancia_inti == 0) {echo "selected=selected";} ?>>Seleccionar Distancia</option>
                                            <option value="1" <?php if($distancia_inti == 1) {echo "selected=selected";} ?>>+100 KM</option>
                                            <option value="2" <?php if($distancia_inti == 2) {echo "selected=selected";} ?>>-100 KM</option>
                                        </select>
                                    </div>
                                </div>

	                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="horario_calib">Tipo de Horario</label>
                                        <select class="form-control required" id="horario_calib" name="horario_calib">
                                            <option value="0" <?php if($horario_calib == 0) {echo "selected=selected";} ?>>Seleccionar Horario</option>
                                            <option value="1" <?php if($horario_calib == 1) {echo "selected=selected";} ?>>Diurno</option>
                                            <option value="2" <?php if($horario_calib == 2) {echo "selected=selected";} ?>>Nocturno</option>
                                        </select>
                                    </div>
                                </div>   
                            </div>
                        </div><!-- /.box-body -->
                        
                    	<div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="observacion_solicalib">Observación Solicitud Calibraciones</label>
                                        <textarea name="observacion_solicalib" id="observacion_solicalib" class="form-control" rows="5" cols="50" style="resize:none"><?php echo $observacion_solicalib; ?></textarea>
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
        
        $('#fecha_oc').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '0',
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