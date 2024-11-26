<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$PROproyectos   = explode(',', $proyectos_proyectos);

if(empty($criterio)){
  $criterio = 0;
}
?>

<style>
  .gestor { color: #363438; }

  .btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
  .btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
     Proyectos - Proyectos
     <span class="pull-right">
       <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
       <span class="text-muted">Proyectos</span>
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

      <?php if ($PROproyectos[0] == 1): ?>

        <div class="row">
          <div class="col-md-12 text-right btn-toolbar">
            <a class="btn btn-labeled btn-primary" href="<?=base_url('agregar_proyecto')?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Agregar Proyecto</a>
          </div>
        </div>
      <?php endif; ?>


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
                          <form action="<?= base_url('municipiosListing') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Proyecto</option>
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
                        <th class="text-center">Proyecto</th>
                        <th class="text-center">Gestor</th>
                        <th class="text-center">Activos</th>
                        <th class="text-center">Inactivos</th>
                        <th class="text-center">Total de Equipos</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Remoto</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                      <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                          <td><span class="text-<?= ($proyecto->activo == 1) ? 'info' : 'danger' ;?>"><?=$proyecto->nombre_proyecto?></span></td>
                          <td class="text-center"><?= ($proyecto->gestor) ? "<a class='gestor' href=".base_url("verPersonal/{$proyecto->id_gestor}").">" . $proyecto->gestor . "</a>" : 'A designar' ;?></td>
                          <td class="text-center"><span class="text-success"><b> <?=$proyecto->activos?></b></span></td>
                          <td class="text-center"><span class="text-danger"><b> <?=$proyecto->inactivos?></b></span></td>
                          <td class="text-center"><span class="label label-primary" style="color:white; font-size:14px;"><?=$proyecto->activos+$proyecto->inactivos?></span></td>
                          <td class="text-center"><span class="label label-<?= ($proyecto->activo == 1) ? 'success' : 'danger' ;?>"><?= ($proyecto->activo == 1) ? 'Activo' : 'Inactivo' ;?></span></td>
                          <td class="text-center"><span class="label label-<?= ($proyecto->remoto == 1) ? 'success' : 'danger' ;?>"><?= ($proyecto->remoto == 1) ? 'SI' : 'NO' ;?></span></td>

                          <td>
                            <?php if ($PROproyectos[1] == 1): ?>
                              <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url("ver_proyecto/$proyecto->id") ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                            <?php endif; ?>

                            <?php if ($PROproyectos[2] == 1): ?>
                              <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Editar Proyecto" href="<?= base_url("editar_proyecto/$proyecto->id") ?>">&nbsp;<i class="fa fa-edit"></i></a>
                            <?php endif; ?>

                            <?php if ($PROproyectos[3] == 1): ?>
                              <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Asignar Gestor" href="<?= base_url("proyecto_asignaciones/$proyecto->id") ?>">&nbsp;<i class="fa fa-user"></i>&nbsp;</a>
                            <?php endif; ?>


                            <?php if ($PROproyectos[4] == 1): ?>
                              <a class="btn btn-<?= ($proyecto->remoto == 1) ? "danger" : "success";?> btn-xs" data-toggle="modal" title="<?= ($proyecto->remoto == 1) ? "Desactivar" : "Activar";?> Remoto" data-target="#modalRemoto<?= $proyecto->id; $proyecto->remoto; $proyecto->nombre_proyecto ?>" ><i class="fa fa-wifi"></i></a>
                                  <!-- sample modal content -->
                                  <div id="modalRemoto<?= $proyecto->id; $proyecto->remoto; $proyecto->nombre_proyecto ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel"><?= ($proyecto->remoto == 1) ? "Desactivar" : "Activar";?> el Proyecto <b><?= $proyecto->nombre_proyecto ?></b> como Remoto</h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('estado_remoto')?>" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="id_proyecto" name="id_proyecto" value="<?= $proyecto->id ?>" >
                                                      <input type="hidden" class="form-control" id="remoto" name="remoto" value="<?= $proyecto->remoto ?>" >

                                                      <div class="form-group">
                                                        <label for="subida_observ">Observaciones</label>
                                                        <textarea name="observacion" id="observacion" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
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


                            <?php if ($PROproyectos[5] == 1): ?>
                              <a class="btn btn-<?= ($proyecto->activo == 1) ? "danger" : "success";?> btn-xs" data-toggle="modal" title="<?= ($proyecto->activo == 1) ? "Desactivar" : "Activar";?> Proyecto" data-target="#modalEstado<?= $proyecto->id; $proyecto->activo; $proyecto->nombre_proyecto ?>" ><i class="fa fa-power-off"></i></a>
                                  <!-- sample modal content -->
                                  <div id="modalEstado<?= $proyecto->id; $proyecto->activo; $proyecto->nombre_proyecto ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel"><?= ($proyecto->activo == 1) ? "Desactivar" : "Activar";?> el Proyecto <b><?= $proyecto->nombre_proyecto ?></b></h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('estado_proyecto')?>" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="id_proyecto" name="id_proyecto" value="<?= $proyecto->id ?>" >
                                                      <input type="hidden" class="form-control" id="estado" name="estado" value="<?= $proyecto->activo ?>" >

                                                      <div class="form-group">
                                                        <label for="subida_observ">Observaciones</label>
                                                        <textarea name="observacion" id="observacion" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "municipiosListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
