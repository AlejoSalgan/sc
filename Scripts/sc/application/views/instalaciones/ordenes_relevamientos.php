<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

if(empty($criterio)){
  $criterio = '0';
}

?>


<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
   Instalaciones - <?=$titulo?>
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
                        <form action="<?= base_url('instalaciones_solicitudes') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                  <?php foreach ($opciones as $key => $opcion): ?>
                                    <?php if ($key !== "RE.fecha_ts"): ?>
                                        <option value="<?=$key?>" <?php if($criterio == $key) {echo "selected=selected";} ?>><?=$opcion?></option>
                                    <?php endif; ?>

                                  <?php endforeach; ?>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary searchList"><i class="fa fa-search"></i></button>
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
                          <?php foreach ($opciones as $key => $opcion): ?>
                            <?php if ($key !== 0): ?>
                              <th class="text-center"><?=$opcion?></th>
                            <?php endif; ?>
                          <?php endforeach; ?>
                            <th class="text-center">Acciones</th>
                        </tr>

                        <?php foreach ($ordenes as $orden): ?>
                          <tr>
                            <td class="text-center"><?=$orden->id?></td>
                            <td class="text-center"><span class="text-primary"><?=$orden->proyecto ?></span></td>
                            <td><?=$orden->direccion?></td>
                            <td><?=$orden->tipos_equipo?></td>
                            <td class="text-center"><span class="label label-<?= $orden->prioridad_label;?>"><?= $orden->tipo_prioridad;?></span></td>
                            <td class="text-center"><?="<a href=".base_url("verPersonal/{$orden->solicitado_por}").">" . $orden->solicitado_name . "</a>"; ?></td>
                            <td class="text-center"><?= date('d/m/Y',strtotime($orden->fecha_ts));?></td>


                            <td>
                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 || $role == 100 || $role == 101 || $role == 102 || $role == 103 || $role == 104): ?>
                                  <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url("ver_relevamiento/$orden->id") ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                                <?php endif; ?>

                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 || $role == 100 || $role == 101 || $role == 102 || $role == 103 || $role == 104): ?>
                                  <a class="btn btn-default btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Agregar observaciones" data-target="#modalObservaciones<?= $orden->id;?>"><i class="fa fa-plus"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalObservaciones<?= $orden->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Agregar nueva observación - Relevamiento Nº<?= $orden->id ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('insta_agregar_observacion'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->id ?>">

                                                          <input type="hidden" class="form-control" id="link" name="link" value="ordenes_relevamiento">

                                                          <input type="hidden" class="form-control" id="tabla" name="tabla" value="instalaciones_relevamiento_eventos">

                                                          <div class="form-group">
                                                            <label for="subida_observ">Observaciones</label>
                                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none" data-error="Completar este campo." required></textarea>
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
                                <?php endif; ?>

                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 ): ?>
                                  <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Adjuntar archivo" href="<?=base_url("relevamiento_archivos/{$orden->id}")?>"><i class="fa fa-file"></i></a>
                                <?php endif; ?>


                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 ): ?>
                                  <a class="btn btn-info btn-xs" data-toggle="tooltip" title="Agregar Visita" href="<?=base_url("agregar_visitas/{$orden->id}/R")?>"><i class="fa fa-user"></i></a>
                                <?php endif; ?>


                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 ): ?>
                                  <a class="btn btn-danger btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Cancelar Orden" data-target="#modalCancelar<?= $orden->id;?>"><i class="fa fa-times"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalCancelar<?= $orden->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Cancelar - Relevamiento Nº<?= $orden->id ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('cancelar_relevamiento'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->id ?>">

                                                          <input type="hidden" class="form-control" id="link" name="link" value="ordenes_relevamiento">

                                                          <div class="form-group">
                                                            <label for="subida_observ">Observaciones</label>
                                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none" data-error="Completar este campo." required></textarea>
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
                                <?php endif; ?>


                                <?php if ($role == 99 || $role == 500 || $role == 501 || $role == 502 || $role == 503 ): ?>
                                  <a class="btn btn-success btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Finalizar Orden" data-target="#modalFinalizar<?= $orden->id;?>"><i class="fa fa-check"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalFinalizar<?= $orden->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Finalizar - Relevamiento Nº<?= $orden->id ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('finalizar_relevamiento'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label id="label_estado" for="label_estado">Estado</label>
                                                            <select class="form-control" id="estado" name="estado" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="30">Aprobada</option>
                                                                <option value="40">Desaprobada</option>
                                                            </select>
                                                             <div class="help-block with-errors"></div>
                                                         </div>
                                                      </div>
                                                    </div>
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->id ?>">

                                                          <div class="form-group">
                                                            <label for="subida_observ">Observaciones</label>
                                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none" data-error="Completar este campo." required></textarea>
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

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "instalaciones_solicitudes/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
