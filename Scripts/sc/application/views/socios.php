<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

switch ($titulo):  // Dependiendo del tipo se cargaran los permisos de las acciones y el titulo.
    case "Solicitudes":
        $SOsolicitudes    = explode(',', $socios_solicitudes);
        break;
    case "Remitos":
        $SOremitos        = explode(',', $socios_remitos);
        break;
    case "Finalizados":
        $SOfinalizados    = explode(',', $socios_finalizados);
        break;
    case "Rechazados":
        $SOrechazados     = explode(',', $socios_rechazados);
        break;
endswitch;

if(empty($criterio)){
  $criterio = 0;
}
?>

<div class="content-wrapper">
     <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
       <?=$titulo?> Listado
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
              <?php if ($this->session->flashdata('info')): ?>
                  <div class="alert alert-warning alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('info'); ?>
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
                        <form action="<?= base_url(strtolower($titulo).'_listado') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Remito</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Proyecto</option>
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
                          <th>Nº Remito</th>
                          <th class="text-center">Equipo</th>
                          <th class="text-center">Periferico</th>
                          <th class="text-center">Propietario</th>
                          <th class="text-center">Estado</th>
                          <th>Acciones</th>
                        </tr>

                        <?php foreach ($remitos as $remito): ?>
                            <tr>
                              <td class="text-center"><?= ($remito->num_remito == NULL) ? "<a href='#'> A designar</a>" : '<p class="label label-primary" style="color:white; font-size:14px;">'.$remito->num_remito ;?></p></td>
                              <td><?= "<a href=".base_url("verEquipo/{$remito->idEquipo}").">" . $remito->serie . "</a>"; ?><br>
                                <span class="text-muted"><small><?=$remito->descrip ?></small></span>
                              </td>
                              <td><?= ($remito->serie_periferico) ? $remito->serie_periferico : '<span class="text-danger">A designar</span>';?><br>
                                <span class="text-muted"><small><?=$remito->tipo_periferico ?></small></span></td>
                              </td>

                              <td><?= ($remito->descripPropietario) ? $remito->descripPropietario : '<span class="text-danger">A designar</span>';?></td>
                              <td class="text-center"><span class="<?= $remito->label;?>"><?= $remito->tipo_estado;?></span></td>

                              <td>
                                <!-- En un futuro ver este permiso-->
                                <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url('verRemito/'.$remito->id) ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>


                                <?php if ($remito->id_estado == 0 && $SOsolicitudes[0] == 1): ?>
                                  <a class="btn btn-success btn-xs" data-toggle="modal" title="Recibir Equipo" data-target="#modalRecibir<?= $remito->id; $remito->serie; $remito->id_orden?>" ><i class="fa fa-check"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalRecibir<?= $remito->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Recibir el equipo - <?= $remito->serie ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('recibir_equipo'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_remito" name="id_remito" value="<?= $remito->id ?>" >
                                                          <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $remito->id_orden ?>" >
                                                          <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="estado">Fecha de recepcion</label>
                                                                      <input name="fecha_recibido" type="text" class="form-control fecha_recibido" aria-describedby="fecha" autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required data-error="Seleccionar una fecha de recepcion.">
                                                                    <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                              <div class="form-group">
                                                                <label for="estado">Nº Remito</label><br>
                                                                <input type="number" class="form-control" id="num_remito"  name="num_remito" min="1" max="999999" autocomplete="off" placeholder="Maximo hasta 6 digitos" required data-error="Agregar numero de Remito">
                                                                <div class="help-block with-errors"></div>
                                                              </div>
                                                            </div>
                                                          </div>

                                                          <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                  <label for="subida_observ">Observaciones</label>
                                                                  <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none"></textarea>
                                                                  <div class="help-block with-errors"></div>
                                                              </div>
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
                                              <!-- /.modal-content -->
                                          </div>
                                          <!-- /.modal-dialog -->
                                      </div>
                                      <!-- /.modal -->
                                <?php endif; ?>

                                <?php if ($remito->id_estado == 0 && $SOsolicitudes[1] == 1): ?>
                                  <a class="btn btn-danger btn-xs"data-toggle="modal" title="Cancelar remito" data-target="#modalCancelar<?= $remito->id; $remito->serie; $remito->id_orden?>" ><i class="fa fa-times"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalCancelar<?= $remito->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Cancelar el equipo - <?= $remito->serie ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('cancelar_remito'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_remito" name="id_remito" value="<?= $remito->id ?>" >
                                                          <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $remito->id_orden ?>" >
                                                          <div class="form-group">
                                                            <label for="subida_observ">Observaciones</label>
                                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none" required data-error="Agregar una breve descripcion."></textarea>
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





                                <?php if (($remito->id_estado == 1 || $remito->id_estado == 2) && ($SOremitos[1] == 1)): ?>
                                  <a class="btn btn-default btn-xs" data-toggle="modal" title="Agregar Eventos" data-target="#modalEventos<?= $remito->num_remito; $remito->serie?>"><i class="fa fa-plus"></i></a>
                                      <!-- sample modal content -->
                                      <div id="modalEventos<?= $remito->num_remito; $remito->serie?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Agregar nueva observación - <?= $remito->serie ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('nuevo_evento'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_remito" name="id_remito" value="<?= $remito->id ?>" >
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

                                <?php if (($remito->id_estado == 1 || $remito->id_estado == 2) && ($SOremitos[2] == 1)): ?>
                                  <a class="btn btn-info btn-xs" data-toggle="tooltip" title="Solicitar Presupuesto" href="<?= base_url('presupuesto/'.$remito->id) ?>"><i class="fa fa-arrow-right"></i></a>
                                <?php endif; ?>

                                <?php if ($remito->id_estado == 3 && $SOremitos[3] == 1): ?>
                                  <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Presupuesto" href="<?= base_url('ver_presupuesto/'.$remito->id) ?>"><i class="fa fa-file"></i></i>&nbsp;&nbsp;&nbsp;</a>
                                <?php endif; ?>

                                <?php if (($remito->id_estado == 1 || $remito->id_estado == 2) && ($SOremitos[4] == 1)): ?>
                                  <a class="btn btn-success btn-xs" data-toggle="modal" title="Finalizar" data-target="#modalFinalizar<?= $remito->id;$remito->num; $remito->serie?>"><i class="fa fa-check"></i></i> </a>
                                      <!-- sample modal content -->
                                      <div id="modalFinalizar<?= $remito->id;$remito->num_remito; $remito->serie?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title" id="myModalLabel">Finalizar trabajo - <?= $remito->serie ?></h4>
                                                  </div>
                                                  <form  method="post" action="<?= base_url('finalizarRemito'); ?>" data-toggle="validator">
                                                  <div class="modal-body">
                                                      <div class="form-group">
                                                          <input type="hidden" class="form-control" id="id_remito" name="id_remito" value="<?= $remito->id ?>" >
                                                          <input type="hidden" class="form-control" id="num_remito" name="num_remito" value="<?= $remito->num_remito ?>" >
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
            jQuery("#searchList").attr("action", baseURL + <?= strtolower($titulo).'_listado' ?>"/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>



<script>
    $(function() {
      $('.fecha_recibido').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
      });
    });

    $(function () {
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      $('[data-mask]').inputmask()
    })
</script>
