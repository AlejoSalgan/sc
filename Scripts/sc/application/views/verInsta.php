<?php

if(!empty($instaInfo))
{
    foreach ($instaInfo as $ef)
    {
        $instaId            = $ef->id;
        $municipioId        = $ef->idproyecto;
        $idsupervisor       = $ef->idsupervisor;
        $dominio            = $ef->dominio;
        $conductor          = $ef->conductor;
        $tecnico            = $ef->tecnico;
        $idequipo           = $ef->idequipo;
        $fecha_visita       = $ef->fecha_visita;
        $fecha_alta         = $ef->fecha_alta;
        $equipoSerie        = $ef->equipoSerie;
        $activo             = $ef->activo;
        $descripProyecto    = $ef->descripProyecto;
        $nameSupervisor     = $ef->nameSupervisor;
        $nameConductor      = $ef->nameConductor;
        $nameTecnico        = $ef->nameTecnico;
        $diagnostico_previo            = $ef->diagnostico_previo;

    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ORDEN INSTALACION 
        <small>Detalles de la Orden Instalación</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-xs-8">
              <!-- general form elements -->
                
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <a class="btn btn-primary" href="javascript:void(0);" id="imprime">Imprimir</a>
                        </div>
                    </div>
                 	<div class="col-xs-6">
                         <div class="text-right"  >
                              <ol class="breadcrumb" style="background-color: transparent">
                                <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                                <li><a href="javascript:history.go(-1)">Ordenes de Instalacion</a></li>
                                <li class="active">Ver Detalles Orden Instalación </li>
                              </ol>          
                         </div>
                     </div>
                </div>
                
                <div class="box box-primary" id="boxprint"> <!-- /.box-print -->
                    <div class="box-header">
                        <h3 class="box-title">Detalle Orden Instalación: <?php echo $instaId; ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->

                        <div class="box-body">
                            <div class="row">                       
                            <!-- Select Proyecto -->
                            <div class="col-xs-4">
                                <strong>Proyecto:</strong> <?php echo $descripProyecto; ?>
                            </div>
                            <!-- Fecha -->
                            <div class="col-xs-4">
                                    <strong>Fecha alta:</strong> <?php echo $fecha_alta; ?>
                            </div>
                            <div class="col-xs-4">
                                    <strong>Nº Orden de Servicio:</strong> <?php echo $instaId; ?>
                                </div>
                        </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">  
                                    <strong>Diagnostico Previo:</strong> <?php echo $diagnostico_previo; ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <strong>Supervisor:</strong> <?php echo $nameSupervisor; ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <strong>Dominio del vehículo:</strong> <?php echo $dominio; ?>
                            </div>  
                        </div> 
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <strong>Conductor:</strong> <?php echo $nameConductor; ?>
                                </div>
                                <div class="col-xs-6">
                                    <strong>Técnico:</strong> <?php echo $nameTecnico; ?>
                                </div>                     
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class ="row">
                                <div class="col-xs-6">
                                    <strong>Fecha de solicitud de visita:</strong> <?php echo $fecha_visita; ?>
                                </div>
                                <div class="col-xs-6">
                                    <strong>Equipo serie:</strong> <?php echo $equipoSerie; ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                </div>
            </div>
            <div class="col-xs-4">
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
                    <div class="col-xs-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/imprime.js" type="text/javascript"></script>

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