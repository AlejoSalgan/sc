<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

if(empty($criterio)){
  $criterio = '0';
}

?>

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
   Perifericos - <?=$titulo?>
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
          <div class="col-md-12 text-right btn-toolbar">
            <a class="btn btn-labeled btn-primary" href="<?=base_url('agregar_periferico')?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Agregar periferico</a>
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
                        <form action="<?= base_url(strtolower($titulo).'_listado') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                  <?php foreach ($opciones as $key => $opcion): ?>
                                    <?php if ($key !=='PE.fecha_alta'): ?>
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
                            <?php if ($key !== 0 && $key !=='PT.nombre_tipo' && $key !=='MUN.descrip'): ?>
                              <th class="text-center"><?=$opcion?></th>
                            <?php endif; ?>
                          <?php endforeach; ?>
                            <th class="text-center">Acciones</th>
                        </tr>

                        <?php foreach ($perifericos as $periferico): ?>
                          <tr>
                            <td class="text-center"><?=$periferico->id?></td>

                            <td><span class="text-primary"><?=$periferico->serie ?></span><br/><span class="text-muted"><small><?=$periferico->nombre_tipo ?></small></span></td>

                            <td><?= (!$periferico->id_equipo) ? "A designar" : "<a href=".base_url("verEquipo/{$periferico->id_equipo}").">" . $periferico->EM_serie . "</a>";?><br/><span class="text-muted"><small><?=$periferico->proyecto ?></small></span></td>

                            <td><?=$periferico->socio?></td>

                            <?php if ($periferico->id_tipo == 2): ?>
                              <td class="text-center <?= ($periferico->comunicacion == 1) ? "text-success" : "text-danger" ;?>"><?= ($periferico->comunicacion == 1) ? "SI" : "NO" ;?></td>
                            <?php else: ?>
                              <td class="text-center"> - </td>
                            <?php endif; ?>

                            <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($periferico->fecha_alta));?></td>

                            <td class="text-center"><span class="label label-<?= $periferico->label;?>"><?= $periferico->nombre_estado;?></span></td>

                            <td>
                                <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url("ver_periferico/$periferico->id") ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>

                                <a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Editar periferico" href="<?=base_url("editar_periferico/{$periferico->id}")?>"><i class="fa fa-edit"></i></a>

                                <a class="btn btn-<?= ($periferico->estado == 1) ? "danger" : "success";?> btn-xs" data-toggle="modal" title="<?= ($periferico->estado == 1) ? "Desactivar" : "Activar";?> periferico" data-target="#modalEstado<?= $periferico->id; $periferico->estado; $periferico->serie ?>" ><i class="fa fa-power-off"></i></a>
                                    <!-- sample modal content -->
                                    <div id="modalEstado<?= $periferico->id; $periferico->estado; $periferico->serie ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel"><?= ($periferico->estado == 1) ? "Desactivar" : "Activar";?> el periferico <?= $periferico->serie ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('estado_periferico')?>" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="id_periferico" name="id_periferico" value="<?= $periferico->id ?>" >
                                                        <input type="hidden" class="form-control" id="estado" name="estado" value="<?= $periferico->estado ?>" >

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


                                <?php if ($periferico->id_tipo == 2): ?>
                                  <a class="btn btn-<?= ($periferico->comunicacion == 1) ? "danger" : "success";?> btn-xs" data-toggle="modal" title="<?= ($periferico->comunicacion == 1) ? "Desactivar" : "Activar";?> Transmision" data-target="#modalComunicacion<?= $periferico->id; $periferico->comunicacion; $periferico->serie ?>" ><i class="fa fa-wifi"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalComunicacion<?= $periferico->id; $periferico->comunicacion; $periferico->serie ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel"><?= ($periferico->comunicacion == 1) ? "Desactivar" : "Activar";?> la transmision de <?= $periferico->serie ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?=base_url('estado_comunicacion')?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_periferico" name="id_periferico" value="<?= $periferico->id ?>" >
                                                          <input type="hidden" class="form-control" id="comunicacion" name="comunicacion" value="<?= $periferico->comunicacion ?>" >

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
            jQuery("#searchList").attr("action", baseURL + "perifericos_listado/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
