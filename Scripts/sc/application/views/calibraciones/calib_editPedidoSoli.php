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

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Pedido de Solicitud Calibracion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('calibraciones_solicitudes')?>">Solicitud de Calibraciones</a> /
        <span class="text-muted">Solicitud Calibracion</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-xs-8">

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Detalles</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo base_url() ?>editAprob" method="post" id="editAprob" role="form">
                <input type="hidden" class="form-control" id="calibId" name="calibId" value="<?= $calibId ?>" >

                   <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="distancia_inti">Distancia INTI</label>
                                    <select class="form-control required" id="distancia_inti" name="distancia_inti" required>
                                        <option value="" <?php if($distancia_inti == 0 || $distancia_inti == NULL) {echo "selected=selected";} ?>>Seleccionar Distancia</option>
                                        <option value="+100" <?php if($distancia_inti == '+100') {echo "selected=selected";} ?>>+100 KM</option>
                                        <option value="-100" <?php if($distancia_inti == '-100') {echo "selected=selected";} ?>>-100 KM</option>
                                    </select>
                                </div>
                            </div>

                          <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horario_calib">Tipo de Horario</label>
                                    <select class="form-control required" id="horario_calib" name="horario_calib" required>
                                        <option value="" <?php if($horario_calib == 0 || $horario_calib == NULL) {echo "selected=selected";} ?>>Seleccionar Horario</option>
                                        <option value="D" <?php if($horario_calib == 'D') {echo "selected=selected";} ?>>Diurno</option>
                                        <option value="N" <?php if($horario_calib == 'N') {echo "selected=selected";} ?>>Nocturno</option>
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
                    </div>
            </div>
        </div>

        <div class="col-xs-4">
          <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title">Informacion de la Solicitud</h3>
              </div><!-- /.box-header -->

              <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="idproyecto">Proyecto</label>
                          <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $descripProyecto?>"  readonly>
                          <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto"/>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="equipoSerie"> Equipo serie</label>
                        <input type="text" class="form-control" id="equipoSerie" name="equipoSerie" value="<?php echo $equipoSerie ?>"  readonly>
                        <input type="hidden" value="<?php echo $idequipo; ?>" name="idequipo" id="idequipo"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="tipo_servicio">Tipo de Servicio</label>
                          <input type="text" class="form-control" id="tipo_servicio" name="tipo_servicio" value="<?php echo $tipo_ver?>"  readonly>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="prioridad">Prioridad</label>
                        <input type="text" class="form-control" id="prioridad" name="prioridad" value="<?php echo $descripPrioridad?>"  readonly>
                    </div>
                  </div>
                </div>

              </div>
            </div>
        </div>

      </form>

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
