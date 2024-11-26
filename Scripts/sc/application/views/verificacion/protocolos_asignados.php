<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Verificacion - <?=$titulo?>
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
                        <form action="<?= base_url('protocolos_asignados') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                  <?php foreach ($opciones as $key => $opcion): ?>
																		<?php if (!is_numeric($key)): ?>
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

                        <?php foreach ($protocolos as $protocolo): ?>
                          <tr>
                            <td class="text-center"><p class="label label-primary" style="color:white; font-size:16px;"><?=$protocolo->id_protocolo ?></p></td>
                            <td class="text-center"><?= "<a href=".base_url("verEquipo/{$protocolo->id_equipo}").">" . $protocolo->equipo_serie . "</a>"; ?></td>
                            <td class="text-center"><?= ($protocolo->proyecto == NULL) ? "<span class='text-danger'> A designar </span>" : $protocolo->proyecto ;  ?></td>
                            <td class="text-center"><?=$protocolo->cantidad?>
                            <br>
                              <span class="text-success">A:<?=$protocolo->aprobados?> - </span>
                              <span class="text-danger">D:<?=$protocolo->descartados?></span>
                            </td>
														<td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($protocolo->ts));?>
                            <td class="text-center"><?=$protocolo->name_verificador;?>
                            <td class="text-center"><?=$protocolo->verificacion_nombre;?>

														</td>

                            <td>
                              <?php if ($protocolo->est_verificacion == 30 && $role != 22) { ?>
                                <a class="btn btn-primary btn-xs" target="_blank" data-toggle="tooltip" title="Ver editadas" href="<?= base_url("ver_editadas/$protocolo->id_protocolo") ?>"><i class="fa fa-image"></i></a>
                              <?php } ?>

                              <?php if ($protocolo->est_verificacion == 30 && $role != 22) { ?>
                                <a class="btn btn-success btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Cerrar asignacion" data-target="#cerrarAsignacion<?= $protocolo->id_protocolo ?>">&nbsp;<i class="fa fa-check">&nbsp;</i></a>

                                  <!-- sample modal content -->
                                  <div id="cerrarAsignacion<?=$protocolo->id_protocolo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">Cerrar asignacion del Protocolo Nº <?=$protocolo->id_protocolo ?></h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('cerrar_asignacion')?>" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="id_protocolo" name="id_protocolo" value="<?=$protocolo->id_protocolo ?>">
                                                      
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Al cerrar una asignacion de un protocolo este desaparecera del listado, por favor corroborar que el protocolo haya sido verificado o si es necesario realizar una segunda pasada.</p>
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
                              

                                
                            </td>
                          </tr>
                        <?php endforeach; ?>

                      </table>

                    </div><!-- /.box-body -->

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
            jQuery("#searchList").attr("action", baseURL + "protocolos_asignados/" + value);
            jQuery("#searchList").submit();
        });
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
