<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$CALIBsolicitudes = explode(',', $calibracion_solicitudes); //Los permisos para cada boton de Acciones.

if(empty($criterio)){
    $criterio = 0;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
		<?=$titulo?> de Calibracion
		<span class="pull-right">
			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
		  <span class="text-muted"><?=$titulo?></span>
		</span>
	</div>

  <section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            $this->load->helper('form');
            if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <?php if ($CALIBsolicitudes[0] == 1): ?>
                  <button id="boton_parciales" data-toggle="modal" data-target="#parciales" type="button" class="btn inline btn-success"> Solicitar Parciales</button>
                <?php endif; ?>
                <?php if ($CALIBsolicitudes[1] == 1): ?>
                  <a class="btn btn-primary" href="<?= base_url(); ?>agregar_SG">Agregar Solicitud</a>
                <?php endif; ?>
            </div>
        </div>

        <div id="parciales" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Solicitar Parciales</h4>
                    </div>
                    <form  method="post" action="<?=base_url('agregar_pedidos')?>" data-toggle="validator">
                    <div class="modal-body">
                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Los pedidos de parciales se asociaran al tipo de equipo de la orden que se esta calibrando.</p>
                      <p> Por ejemplo un parcial de Cinemometro Fijo Monocarril es distinto de un Cinemometro Fijo Monocarril Doppler, no confundir.</p>
                      <br>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="tipo_equipo">Tipo de Equipo</label>
                                  <select class="form-control required" id="tipo_equipo" name="tipo_equipo" required data-error="Seleccionar al menos una opción.">
                                      <option value="">Seleccionar tipo</option>
                                      <?php foreach ($equiposCalibrar as $equipoCalibrar): ?>
                                        <option value="<?= $equipoCalibrar->id?>"><?= $equipoCalibrar->descrip?></option>
                                      <?php endforeach; ?>
                                  </select>
                                  <div class="help-block with-errors"></div>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="cantidad">Cantidad</label>
                                  <input type="number" class="form-control required" id="cantidad" name="cantidad" min="1" max="100" autocomplete="off" required data-error="Ingresar la cantidad de parciales.">
                                  <div class="help-block with-errors"></div>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="tipo_servicio">Tipo de Servicios</label>
                                  <select class="form-control required" id="tipo_servicio" name="tipo_servicio" required data-error="Seleccionar al menos una opción.">
                                      <option value="">Seleccionar servicio</option>
                                      <option value="1">Primitivas</option>
                                      <option value="2">Periodicas</option>
                                      <option value="3">Adicionales</option>
                                  </select>
                                  <div class="help-block with-errors"></div>
                              </div>
                          </div>
                        </div>


                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label id="label_horario" for="horario">Tipo de Horario</label>
                                <select class="form-control required" id="horario" name="horario" required data-error="Seleccionar al menos una opción.">
                                    <option value="">Seleccionar horario</option>
                                    <option value="D">Diurno</option>
                                    <option value="N">Nocturno</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label id="label_distancia" for="distancia">Distancia INTI</label>
                              <select class="form-control required" id="distancia" name="distancia" required data-error="Seleccionar al menos una opción.">
                                  <option value="">Seleccionar distancia</option>
                                  <option value="+100">+100</option>
                                  <option value="-100">-100</option>
                              </select>
                              <div class="help-block with-errors"></div>
                          </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label id="label_carriles" for="carriles" visible="hide">Nº Carriles</label>
                                <select class="form-control required" id="carriles" name="carriles" required data-error="Seleccionar al menos una opción.">
                                    <option value="">Seleccionar Evento</option>
                                    <option value="2">2 carriles</option>
                                    <option value="3">3 carriles</option>
                                    <option value="4">4 carriles</option>
                                    <option value="5">5 carriles</option>
                                    <option value="6">6 carriles</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="observacion">Observaciones</label>
                          <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none"></textarea>
                        </div>
                      </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                    </div>
                </form>
                </div>
              </div>
          </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h1 class="box-title">
                  <?php if ($total > 0): ?>
                    Total:<b><a href="javascript:void(0)"> <?= $total?></a></b>
                  <?php else: ?>
                    No hay datos para mostrar.
                  <?php endif; ?>
                </h1>

                <?php if ($total_tabla > 0): ?>
                  <div class="box-tools">
                      <form action="<?= base_url('calibraciones_solicitudes') ?>" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                            <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                              <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                              <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                              <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Proyecto</option>
                              <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Equipo</option>
                              <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Tipo de equipo</option>
                              <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Tipo de servicio</option>
                              <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Prioridad</option>
                              <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Fecha Alta</option>
                              <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Estado</option>
                              <option value="9" <?php if($criterio == 9) {echo "selected=selected";} ?>>Nº Carriles</option>
                            </select>
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </form>
                  </div>
                <?php endif; ?>

            </div><!-- /.box-header -->
                <?php if ($total > 0): ?>
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                      <tr class="info">
                        <th class="text-center">Nº orden</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Tipo de Servicio</th>
                        <th class="text-center">Prioridad</th>
                        <th class="text-center">Fecha Creacion</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                      </tr>

                      <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                          <td class="text-center"><p class="label label-primary" style="color:white; font-size:14px;"><?=$solicitud->id?></p></td>
                          <td><?= "<a href=".base_url("verEquipo/{$solicitud->idequipo}").">" . $solicitud->equipoSerie . "</a>"; ?>
                            <br/><span class="text-muted"><small><?=$solicitud->descripProyecto?></small></span>
                          </td>
                          <td><?= $solicitud->tipoEquipo; ?>
                            <br/><span class="text-muted"><small>
                            <?php switch ($solicitud->multicarril) {
                                case 0:
                                  echo 'No necesita carriles';
                                  break;
                                case 1:
                                  echo $solicitud->multicarril. ' Carril';
                                  break;
                                case 2:
                                case 3:
                                case 4:
                                case 5:
                                  echo $solicitud->multicarril. ' Carriles';
                                  break;

                                default:
                                  echo 'A designar';
                                  break;
                              }
                            ?></small></span>
                          </td>
                          <td class="text-center" style="color:<?=$solicitud->color_servicio?>"><?= $solicitud->tipo_ver; ?></td>
                          <td class="text-center"><span class="<?= $solicitud->label;?>"><?= $solicitud->descripPrioridad;?></span></td>
                          <td class="text-center"><?=date('d/m/Y',strtotime($solicitud->fecha_alta))?></td>
                          <td class="text-center"><span class="label label-default" style="background-color:<?=$solicitud->color_tipo?>; color: white"><?= $solicitud->estado_descrip;?></span></td>
                          <td>
                            <?php if (($CALIBsolicitudes[2] == 1) && ($solicitud->tipo_orden == 10 || $solicitud->tipo_orden == 20 || $solicitud->tipo_orden == 30)): ?>
                              <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verCalib/'.$solicitud->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <?php if (($CALIBsolicitudes[3] == 1) && ($solicitud->tipo_orden == 10)): ?>
                              <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editar_SG/'.$solicitud->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <?php if (($CALIBsolicitudes[4] == 1) && ($solicitud->tipo_orden == 20)): ?>
                              <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editOldAprob/'.$solicitud->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <?php if (($CALIBsolicitudes[5] == 1) && ($solicitud->tipo_orden == 10 || $solicitud->tipo_orden == 20)): ?>
                              <a data-toggle="modal" title="Cancelar" data-target="#modalCancelar<?= $solicitud->id ?>" ><i class="fa fa-trash" style="color:#dc4c3c;"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <!-- sample modal content -->
                                  <div id="modalCancelar<?= $solicitud->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">Cancelar la orden Nº <?= $solicitud->id ?></h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('deleteCalib')?>" data-toggle="validator" id="validar_caracateres">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $solicitud->id ?>" >

                                                      <p>¿Desea anular la Orden?</p>
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cancelarla no se podrá trabajar sobre la misma.</p>
                                                      <div class="form-group">
                                                        <label for="label_observacion">Observaciones</label>
                                                        <textarea name="observacion" id="observacion" class="form-control caractares" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-info enableOnInput">Aceptar</button>
                                              </div>
                                          </form>
                                          </div>
                                          <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                            <?php endif; ?>

                            <?php if (($CALIBsolicitudes[6] == 1) && ($solicitud->tipo_orden == 10)): ?>
                              <a data-toggle="tooltip" title="Solicitar Calibracion" href="<?= base_url().'aprobarSoliG/'.$solicitud->id; ?>"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <?php if (($CALIBsolicitudes[7] == 1) && ($solicitud->tipo_orden == 20)): ?>
                              <a data-toggle="tooltip" title="Pedido de aprobacion" href="<?= base_url().'solicitarSG/'.$solicitud->id; ?>"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div><!-- /.box-body -->
                  <?php if ($total > 15): ?>
                    <div class="box-footer clearfix">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
          </div><!-- /.box -->
        </div>
    </div>

  </section>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/calib.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "calibraciones_solicitudes/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>

<script>
$("#validar_caracateres").submit(function () {
    if($(".caractares").val().length < 50) {
        var falta = 50 -$(".caractares").val().length;
        alert("La observacion tiene que tener como minimo 50 caractares.\nTe falta "+ falta + " caracteres");
        return false;
    } else {
      return true;
    }
});
</script>

<script>
  $(document).ready(function(){
    $("#boton_parciales").click(function() {
      $("#horario").hide();
      $("#label_horario").hide();
      $("#distancia").hide();
      $("#label_distancia").hide();
      $("#carriles").hide();
      $("#label_carriles").hide();
    });
      $('#tipo_equipo').on('change', function() {
        tipo_equipo = $(this).val();
        switch(tipo_equipo) {
            case "2402":
            case "2412":
                $("#horario").show();
                $("#label_horario").show();
                $("#distancia").show();
                $("#label_distancia").show();
                $("#carriles").hide();
                $("#label_carriles").hide();
                break;

            case "2":
            case "2407":
            case "400":
                $("#horario").show();
                $("#label_horario").show();
                $("#distancia").show();
                $("#label_distancia").show();
                $("#carriles").show();
                $("#label_carriles").show();
                break;

            case "1":
                $("#horario").hide();
                $("#label_horario").hide();
                $("#distancia").hide();
                $("#label_distancia").hide();
                $("#carriles").hide();
                $("#label_carriles").hide();
                break;
        }
      });
  });
</script>
