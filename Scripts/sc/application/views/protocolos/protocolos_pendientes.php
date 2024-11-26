<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$INGpendientes = explode(',', $ingreso_pendientes);

if(empty($criterio)){
  $criterio = 0;
}
?>

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }

  .etiqueta13{
    font-size: 13px;
  }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/estilo_tablas_2.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Protocolos - Protocolos Pendientes
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <?php if ($INGpendientes[1] == 1): ?>
          <a href="<?= base_url('grupos_estados'); ?>"> Proyectos Pendientes</a> /
        <?php endif; ?>
  		  <span class="text-muted">Protocolos Pendientes</span>
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
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                      <?php if ($total > 0): ?>
                      Total:<b><a href="javascript:void(0)"> <?= $total?></a></b>
                    <?php else: ?>
                      No hay datos para mostrar.
                    <?php endif; ?>
                    </h3>
                    <div class="box-tools">
                        <form action="<?= base_url('protocolosListing') ?>" method="GET" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Protocolo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Fecha Protocolo</option>
                                  <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Fecha Desde</option>
                                  <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Fecha Hasta</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Cantidad</option>
                                  <option value="9" <?php if($criterio == 9) {echo "selected=selected";} ?>>Transferencia</option>
                                  <option value="10" <?php if($criterio == 10) {echo "selected=selected";} ?>>Modelo Equipo</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->

                <?php if ($total > 0): ?>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr class="info">
                        <th class="text-center">Protocolo</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Fecha Protocolo</th>
                        <th class="text-center">Fecha Desde</th>
                        <th class="text-center">Fecha Hasta</th>
                        <th class="text-center">Archivos</th>
                        <th class="text-center">Transferencia</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                    </thead>

                    <?php foreach ($protocolosRecords as $key => $record):
                      $fila ="";
                      if ($record->bajada_archivos > 0 && $record->subida_estado == 0) {
                        $fecha_evento = new DateTime($record->fecha_procesado);
                        $interval = $fecha_evento->diff(new DateTime($record->bajada_desde));
                        $dias =  $interval->format('%a%');
                        if ($dias >= 30) {
                          $label = "danger";
                        } else {
                          $label = "primary";
                        }
                      } else {
                        $label = "primary";
                      }

                      if ($record->requiere_calibracion == 1 && $record->subida_estado == 0) {
                      $fecha_vto= new DateTime($record->doc_fechavto);
                      $fecha_hoy = new DateTime(date());
                      $dias2 = $fecha_vto->diff($fecha_hoy);
                        if ($dias2->days >=8 && $dias2->days <= 14 && $dias2->invert == 1){
                          $fila = "warning";
                        }elseif ($dias2->invert == 0 || ($dias2->days <= 7 && $dias2->invert == 1)){
                          $fila = "danger";
                        }else {
                          $fila ="";
                        }
                      }
                      ?>

                      <tr class="<?=$fila?>">
                        <!-- Protocolo -->
                        <td class="text-center"><span class="label label-<?=$label?> etiqueta14 text-center"><?=$record->protocolo ?></span><br>
                          <small class="text-muted">Ord. <?=$record->id?></small></td>

                        <!-- Equipo y Proyecto -->
                        <td><?= "<a href=".base_url("verEquipo/{$record->idequipo}").">" . $record->equipoSerie . "</a>";?><br/><small class="text-muted"><?=$record->descripProyecto ?></small></td>

                        <!-- Fecha del Protocolo y Fecha de Vencimiento -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($record->fecha_procesado));?>
                        <?php if ($record->requiere_calibracion == 1): ?>
                          <br><span class="text-warning">Vto: <?= date('d/m/Y',strtotime($record->doc_fechavto));?></span>
                        <?php endif; ?>
                        </td>

                        <!-- Fecha desde -->
                        <td class="text-center">
                          <?php if ($record->bajada_archivos > 0 && $record->subida_FD == NULL): ?>
                            <?= date('d/m/Y - H:i',strtotime($record->bajada_desde));?>
                          <?php elseif ($record->bajada_archivos == 0 && $record->subida_FD == NULL): ?>
                            <strong class="text-danger">SIN FECHA</strong>
                          <?php elseif ($record->subida_FD != NULL): ?>
                            <?= date('d/m/Y - H:i',strtotime($record->subida_FD));?>
                          <?php endif; ?>
                        </td>

                        <!-- Fecha hasta -->
                        <td class="text-center">
                          <?php if ($record->bajada_archivos > 0 && $record->subida_FH == NULL): ?>
                            <?= date('d/m/Y - H:i',strtotime($record->bajada_hasta));?>
                          <?php elseif ($record->bajada_archivos == 0 && $record->subida_FH == NULL): ?>
                            <strong class="text-danger">SIN FECHA</strong>
                          <?php elseif ($record->subida_FH != NULL): ?>
                            <?= date('d/m/Y - H:i',strtotime($record->subida_FH));?>
                          <?php endif; ?>
                        </td>

                        <!-- Cantidad Archivos  y el Metodo de envio -->
                        <td class="text-center">
                          <?php if ($record->subida_cant == NULL || $record->subida_cant == 0): ?>
                            <span class="label label-<?= ($record->bajada_archivos == 0) ? "danger" : "primary" ;?> etiqueta13"><?=$record->bajada_archivos ?></span>
                          <?php elseif ($record->bajada_archivos >= 0 && ($record->subida_cant != NULL || $record->subida_cant != 0)): ?>
                            <span class="label label-primary etiqueta13"><?=$record->subida_cant ?></span>
                          <?php endif; ?>

                          <br>
                          <?php if ($record->transferidos_estado == 10 || $record->transferidos_estado == 20): ?>
                            <?php if ($record->bajada_archivos > 0): ?>
                              <?php if ($record->transferido_tipo == 0): ?>
                                <span class="text-primary">Enviado Online</span>
                              <?php else: ?>
                                <span class="text-muted"> Enviado Disco</span>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        </td>

                        <!-- Estado de la Transferencia -->
                        <td class="text-center"><span class="label label-<?= $record->transferido_label;?>"><?= $record->estado_transferencia;?></span>
                        <br>
                        <?php if ($record->id_estado >= 10): ?>
                          <?= substr(ucfirst($record->ubicacion),0,5)." ".substr($record->ubicacion,-1)?>
                        <?php endif; ?>
                        </td>

                        <!-- Acciones -->
                        <td>
                            <?php if($INGpendientes[0] == 1) { ?>
                                <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("verProtocolos/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                            <?php } ?>

                            <?php if($INGpendientes[1] == 1 && $record->transferidos_estado == 20) { ?>
                                <a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Editar" href="<?=base_url("protocolos_editar/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-pencil"></i></a>
                            <?php } ?>

                            <?php if($INGpendientes[2] == 1 && ($record->transferidos_estado == 20 || $record->protocolo == 0)) { ?>
                              <a class="btn btn-danger btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Anular Protocolo" data-target="#modalDeshabilitar<?php echo $record->protocolo ?>"><i class="fa fa-times"></i></a>
                                    <!-- sample modal content -->
                                    <div id="modalDeshabilitar<?php echo $record->protocolo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Anular el Protocolo Nº <?php echo $record->protocolo ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('anular_protocolo')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?php echo $record->protocolo ?>" >

                                                        <p>¿Desea anular el protocolo?</p>
                                                        <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al deshabilitarlo no se podrá ingresar la información del equipo</p>
                                                        <div class="form-group">
                                                          <label for="subida_observ">Observaciones</label>
                                                          <textarea name="subida_observ" id="subida_observ" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                          <div class="help-block with-errors"></div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                            <?php } ?>

                            <?php if($INGpendientes[3] == 1 && $record->transferidos_estado == 20) { ?>
                                <?php if (($record->bajada_archivos == 0 && $record->subida_cant == NULL) || (($record->subida_ingresados > 0) || ($record->subida_cant > 0)) || ($record->subida_errores == 0 && $record->subida_vencidos > 0) ) { ?>
                                    <a class="btn btn-success btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Finalizar Protocolo" data-target="#modalFinalizar<?php echo $record->protocolo; $record->bajada_archivos; $record->subida_cant; $record->subida_ingresados; $record->subida_FD; $record->subida_FH; $record->subida_vencidos; $record->subida_errores; $record->idmodelo ?>"><i class="fa fa-check"></i></a>

                                    <!-- sample modal content -->
                                    <div id="modalFinalizar<?php echo $record->protocolo; $record->bajada_archivos; $record->subida_cant; $record->subida_ingresados; $record->subida_FD; $record->subida_FH; $record->subida_vencidos; $record->subida_errores; $record->idmodelo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Finalizar el Protocolo Nº <?php echo $record->protocolo ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('finalizar_protocolo')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?php echo $record->protocolo ?>" >
                                                        <input type="hidden" class="form-control" id="idmodelo" name="idmodelo" value="<?php echo $record->idmodelo ?>" >
                                                        <?php if (($record->subida_ingresados > 0 && $record->subida_cant == 0 && $record->subida_FD != NULL && $record->subida_FH != NULL) ) { ?>
                                                          <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="1" >
                                                        <?php } else { ?>
                                                          <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="4" >
                                                        <?php } ?>


                                                        <?php if (($record->subida_ingresados > 0) || ($record->subida_cant > 0)): ?>
                                                        <p>¿Desea ingresar el protocolo?</p>
                                                          <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al ingresarlo no se podrá modificar la información del equipo</p>

                                                        <?php elseif (($record->bajada_archivos == 0 && $record->subida_cant == NULL) || ($record->subida_errores == 0 && $record->subida_vencidos > 0)): ?>
                                                          <p>¿Desea finalizar el protocolo en cero?</p>
                                                          <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cerrarlo no se podrá modificar la información del equipo</p>
                                                          <div class="form-group">
                                                              <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="2" >
                                                              <label for="subida_observ">Observaciones</label>
                                                              <textarea name="subida_observ" id="subida_observ" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                              <div class="help-block with-errors"></div>
                                                          </div>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                <?php } ?>
                            <?php } ?>

                            <?php if($INGpendientes[4] && $record->bajada_archivos >= 10001 && $record->transferidos_estado == 20) { ?>
                              <a class="btn btn-info btn-xs" data-toggle="tooltip" title="Dividir Protocolo" href="<?=base_url("dividir_protocolo/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-cut"></i></a>
                            <?php } ?>

                            <?php if($INGpendientes[5] && $record->protocolo == 999) { ?>
                              <a class="btn btn-default btn-xs" data-toggle="tooltip" title="Enlazar Protocolo" href="<?=base_url("enlazar_protocolo/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-random"></i></a>
                            <?php } ?>
                            <br>
                            <?php if ($INGpendientes[1]): ?>
                              <?php if ($record->protocolo != $record->pm_protocolo && $record->protocolo != 999 && $record->protocolo != 0): ?>
                                <span class="text-danger"><b>PROTOCOLO CRUZADO</b></span>
                              <?php endif; ?>
                            <?php endif; ?>

                        </td>

                      </tr>
                    <?php endforeach; ?>

                  </table>
                </div><!-- /.box-body -->
                <?php endif; ?>

                <?php if ($total > 15): ?>
                  <div class="box-footer clearfix">
                      <?= $this->pagination->create_links(); ?>
                  </div>
                <?php endif; ?>


              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "protocolosListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
