<?php

$calibId                        = '';
$fecha_alta                     = '';
$municipioId                    = '';
$descripProyecto                = '';
$idequipo                       = '';
$equipoSerie                    = '';
$direccion                      = '';
$tipo_equipo                    = '';
$tipoEquipo                     = '';
$tipo_servicio                  = '';
$tipo_ver                       = '';
$prioridad                      = '';
$descripPrioridad               = '';
$fecha_vto                      = '';
$nro_oc                         = '';
$movil                          = '';
$fecha_visita                   = '';
$idsupervisor                   = '';
$iddominio                      = '';
$conductor                      = '';
$tecnico                        = '';
$observaciones_calib            = '';
$nro_ot                         = '';
$fecha_pasadas                  = '';
$fecha_simulacion               = '';
$fecha_informe                  = '';
$fecha_certificado              = '';
$pasadas_aprob                  = '';
$simulacion_aprob               = '';
$fecha_certificado              = '';
$ord_tipo                       = '';
$tipo                           = '';

foreach ($calibInfo as $ef)
{
    $calibId                                = $ef->id;
    $fecha_alta                             = $ef->fecha_alta;
    $municipioId                            = $ef->idproyecto;
    $descripProyecto                        = $ef->descripProyecto;
    $idequipo                               = $ef->idequipo;
    $equipoSerie                            = $ef->equipoSerie;
    $direccion                              = $ef->direccion;
    $tipo_equipo                            = $ef->tipo_equipo;
    $tipoEquipo                             = $ef->tipoEquipo;
    $tipo_servicio                          = $ef->tipo_servicio;
    $tipo_ver                               = $ef->tipo_ver;
    $prioridad                              = $ef->prioridad;
    $descripPrioridad                       = $ef->descripPrioridad;
    $fecha_vto                              = $ef->fecha_vto;
    $nro_oc                                 = $ef->nro_oc;
    $movil                                  = $ef->movil;
    $fecha_visita                           = $ef->fecha_visita;
    $idsupervisor                           = $ef->idsupervisor;
    $iddominio                              = $ef->iddominio;
    $conductor                              = $ef->conductor;
    $tecnico                                = $ef->tecnico;
    $observaciones_calib                    = $ef->observaciones_calib;
    $nro_ot                                 = $ef->nro_ot;
    $fecha_pasadas                          = $ef->fecha_pasadas;
    $fecha_simulacion                       = $ef->fecha_simulacion;
    $fecha_informe                          = $ef->fecha_informe;
    $fecha_certificado                      = $ef->fecha_certificado;
    $pasadas_aprob                          = $ef->pasadas_aprob;
    $simulacion_aprob                       = $ef->simulacion_aprob;
    $ord_tipo                               = $ef->ord_tipo;
    $tipo                                   = $ef->tipo;
    $tipo_orden                                = $ef->tipo_orden;
}

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Orden de Calibracion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <?php if ($tipo_orden == 80 || $tipo_orden == 81): ?>
          <a href="<?= base_url('calibraciones_pendientes')?>">Ordenes Pendientes</a> /
        <?php else: ?>
          <a href="<?= base_url('calibraciones_ordenes')?>">Ordenes de Calibraciones</a> /
        <?php endif; ?>
        <span class="text-muted">Orden de Calibracion</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-md-8">

          <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title">Detalles</h3>
              </div><!-- /.box-header -->
              <!-- form start -->

              <form role="form" action="<?php echo base_url() ?>editCalib" method="post" id="editCalib" role="form">
              <input type="hidden" class="form-control" id="calibId" name="calibId" value="<?= $calibId ?>" >
              <input type="hidden" class="form-control" id="tipoequipo" name="tipoequipo" value="<?php echo $movil ?>" >
              <input type="hidden" class="form-control" id="ord_tipo" name="ord_tipo" value="<?php echo $ord_tipo ?>" >
              <input type="hidden" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo ?>" >
              <input type="hidden" class="form-control" id="tipo" name="tipo_ver" value="<?php echo $tipo_ver ?>" >
              <input type="hidden" class="form-control" id="celular" name="celular" placeholder="000-0000000" readonly>
              <input type="hidden" name="imei" id="imei" value="" />
              <input type="hidden" class="form-control" id="idsupervisor" name="idsupervisor" value="109" >

                  <div class="box-body">
                      <div class="row">
                      <!-- Fecha Visita -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_visita">Fecha de Visita</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    <?php if ($fecha_visita == '00-00-0000') { ?>
                                    <input id="fecha_visita" name="fecha_visita" type="text" class="form-control" aria-describedby="fecha" placeholder="Elija fecha para la visita">
                                    <?php } else { ?>
                                    <input id="fecha_visita" name="fecha_visita" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_visita ?>">
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num_ot">Nº OT</label>
                                <?php if (!$numeros_ot): ?>
                                  <select class="form-control" id="num_ot" name="num_ot" disabled>
                                      <option value="">No hay numeros de OT</option>
                                  </select>
                                <?php else: ?>
                                  <select class="form-control" id="num_ot" name="num_ot">
                                      <option value="">Seleccionar OT </option>
                                      <?php foreach ($numeros_ot as $numero_ot): ?>
                                         <option value="<?= $numero_ot->id; ?>" <?php if($numero_ot->id == $nro_ot) {echo "selected=selected";} ?>><?= $numero_ot->num_ot ?></option>
                                      <?php endforeach; ?>
                                  </select>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num_parcial_label">Nº Parcial</label>
                                <?php if (!$numeros_ot): ?>
                                  <select class="form-control" id="num_parcial" name="num_parcial" disabled>
                                    <option value="">No hay numeros de Parcial<ption>
                                  </select>
                                <?php else: ?>
                                  <select class="form-control" id="num_parcial" name="num_parcial">
                                    <option value="">Seleccionar Parcial</option>
                                  </select>
                                <?php endif; ?>
                            </div>
                        </div>

                        </div>
                  </div><!-- /.box-body -->

                  <?php if ($movil == 0): ?>
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="conductor">Conductor</label>
                                  <select class="form-control" id="conductor" name="conductor">
                                      <option value="0">Seleccionar</option>
                                      <?php
                                      if(!empty($empleados))
                                      {
                                          foreach ($empleados as $empleado)
                                          {
                                              ?>
                                              <option value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $conductor) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                              <?php
                                          }
                                      }
                                      ?>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Técnico</label>
                                  <select class="form-control" id="tecnico" name="tecnico">
                                      <option value="0">Seleccionar</option>
                                      <?php
                                      if(!empty($empleados))
                                      {
                                          foreach ($empleados as $empleado)
                                          {
                                              ?>
                                              <option data-mobile="<?php echo $empleado->mobile ?>" data-imei="<?php echo $empleado->imei ?>" value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $tecnico) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                              <?php
                                          }
                                      }
                                      ?>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="iddominio">Dominio</label>
                                  <select class="form-control" id="iddominio" name="iddominio">
                                      <option value="0">Seleccionar</option>
                                      <?php
                                      if(!empty($vehiculos))
                                          {
                                              foreach ($vehiculos as $vehiculo)
                                              {
                                                  ?>
                                                  <option value="<?php echo $vehiculo->id ?>" <?php if($vehiculo->id == $iddominio) {echo "selected=selected";} ?>><?php echo $vehiculo->dominio . " - " .  $vehiculo->marca. ", " .  $vehiculo->modelo ?></option>
                                                  <?php
                                              }
                                          }
                                          ?>
                                  </select>
                              </div>
                          </div>



                        </div>
                    </div><!-- /.box-body -->
                  <?php endif; ?>


                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="observaciones_calib">Observación</label>
                                  <textarea name="observaciones_calib" id="observaciones_calib" class="form-control" rows="5" cols="50" style="resize:none"><?php echo $observaciones_calib; ?></textarea>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="box-body">
                       <div class="row">
                       <!-- Fecha Pasadas -->
                         <div class="col-md-6">
                               <div class="form-group">
                                   <label for="fecha_pasadas">Fechas Pasadas</label>
                                   <div class="input-group">
                                       <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                       <?php if ($fecha_pasadas == '01-01-1970' or $fecha_pasadas == '00-00-0000') { ?>
                                       <input id="fecha_pasadas" name="fecha_pasadas" type="text" class="form-control" aria-describedby="fecha" placeholder="Elija fecha de pasadas">

                                       <?php } else { ?>
                                       <input id="fecha_pasadas" name="fecha_pasadas" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_pasadas?>">

                                       <?php }
                                       ?>
                                   </div>
                               </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="estado_aprob">Estado</label><br>
                                  <label><input type="radio" name="pasadas_aprob" value="1" <?php if($pasadas_aprob == 1) {echo 'checked';} ?>> Aprobado</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <label><input type="radio" name="pasadas_aprob" value="2" <?php if($pasadas_aprob == 2) {echo 'checked';} ?>> No aprobado</label>
                              </div>
                          </div>

                     </div>
                  </div>



                  <div class="box-body">
                       <div class="row">
                       <!-- Fecha simulación -->
                         <div class="col-md-6">
                               <div class="form-group">
                                   <label for="fecha_simulacion">Fechas Simulación</label>
                                   <div class="input-group">
                                       <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                       <?php if ($fecha_simulacion == '01-01-1970' or $fecha_simulacion == '00-00-0000') { ?>
                                       <input id="fecha_simulacion" name="fecha_simulacion" type="text" class="form-control" aria-describedby="fecha" placeholder="Elija fecha de simulacion">

                                       <?php } else { ?>
                                       <input id="fecha_simulacion" name="fecha_simulacion" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_simulacion?>">

                                       <?php }
                                       ?>
                                   </div>
                               </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="estado_simulacion">Estado</label><br>
                                  <label><input type="radio" name="simulacion_aprob" value="1" <?php if($simulacion_aprob == 1) {echo 'checked';} ?>> Aprobado</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <label><input type="radio" name="simulacion_aprob" value="2" <?php if($simulacion_aprob == 2) {echo 'checked';} ?>> No Aprobado</label>
                              </div>
                          </div>
                     </div>
                  </div>

                 <?php if (($tipo_ver == 'Primitivas' and $movil == 0 and ($tipo_orden == 80 || $tipo_orden == 81)) or ($tipo_ver == 'Primitivas' and $movil == 1 and ($tipo_orden == 80 || $tipo_orden == 81)) ) { ?>

                 <div class="box-body">
                      <div class="row">
                      <!-- Fecha primitiva -->
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="fecha_informe">Fecha Informe Primitiva</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                      <?php if ($fecha_informe == '01-01-1970' or $fecha_informe == '00-00-0000') { ?>
                                      <input id="fecha_informe" name="fecha_informe" type="text" class="form-control" aria-describedby="fecha" placeholder="Elija fecha de informe">

                                      <?php } else { ?>
                                      <input id="fecha_informe" name="fecha_informe" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_informe?>">

                                      <?php }
                                      ?>
                                  </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label for="f_informe">Adjuntar Informe</label>
                              <input type="file" id="f_informe">
                          </div>
                      </div>
                 </div>

                 <?php }
                  ?>

                  <?php if ($tipo_orden == 80 || $tipo_orden == 81) { ?>

                  <div class="box-body">
                      <div class="row">
                      <!-- Fecha certificado -->
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="fecha_certificado">Fecha Certificado</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                      <?php if ($fecha_certificado == '01-01-1970' or $fecha_certificado == '00-00-0000') { ?>
                                      <input id="fecha_certificado" name="fecha_certificado" type="text" class="form-control" aria-describedby="fecha" placeholder="Elija fecha de certificado">

                                      <?php } else { ?>
                                      <input id="fecha_certificado" name="fecha_certificado" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_certificado?>">

                                      <?php }
                                      ?>
                                  </div>
                              </div>
                           </div>

                          <div class="form-group">
                              <label for="f_certificado">Adjuntar Certificado</label>
                              <input type="file" id="f_certificado">
                          </div>
                      </div>
                 </div>

                  <?php }
                  ?>

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Guardar" />
                  </div>

          </div>

        </div>

        <div class="col-xs-4">
          <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title">Informacion de la Orden</h3>
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
                          <label for="equipoSerie">Equipo serie</label>
                          <input type="text" class="form-control" id="equipoSerie" name="equipoSerie" value="<?php echo $equipoSerie ?>"  readonly>
                          <input type="hidden" value="<?php echo $idequipo; ?>" name="idequipo" id="idequipo"/>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="direccion">Dirección</label>
                          <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion ?>"  readonly>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="tipoEquipo">Tipo Equipo</label>
                          <input type="text" class="form-control" id="tipoEquipo" name="tipo_equipo" value="<?php echo $tipoEquipo ?>"  readonly>
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

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="fecha_venc">Fecha de Vencimiento</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                              <input id="fecha_venc" name="fecha_venc" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_vto; ?>" disabled>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="nro_oc">Nº Orden compra</label>
                          <input type="text" class="form-control" id="nro_oc" name="nro_oc" value="<?php echo $nro_oc?>" disabled>
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

        $('#fecha_visita').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_pasadas').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_simulacion').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_informe').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_certificado').datepicker({
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

        $("#num_ot").change(function () {
      		valor = $(this).val();
      		$.post("<?=base_url('numeros_parciales')?>", {id_pedido: valor})
      		.done(function(data) {
      			var result = JSON.parse(data);
      			var option = '';
      	 		$("#num_parcial").html("");
      	 		var previo = ""; var i = 0;
      			result.forEach(function(parcial) {
      				option = option + "<option ";
              if (parcial['num_orden'] != null) {
                option = option + 'style="color:red;" ';
                option = option + 'value="'+parcial['id']+'">'+parcial['num_parcial']+" - Nº Orden: "+parcial['num_orden']+'</option>';
              } else {
                option = option + 'style="color:DodgerBlue;" ';
                option = option + 'value="'+parcial['id']+'">'+parcial['num_parcial']+" - A designar"+'</option>';
              }
      				if (i+1 >= result.length) {
      					option = option + "</optgroup>";
      				} else {
      					if (result[i+1]['id'] != parcial['id']) {
      						option = option + "</optgroup>";
      					}
      				}
      				i++;
      			});
      			$("#num_parcial").append(option);
      			$('.selectpicker').selectpicker('refresh');
      		});
      	});
    });
</script>
