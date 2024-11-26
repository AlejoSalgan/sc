<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

switch ($titulo):  // Dependiendo del tipo se cargaran los permisos de las acciones y el titulo.
    case "Ingresos":
        $DEPingresos    = explode(',', $deposito_ingresos);
        break;
    case "Custodia":
        $DEPcustodia        = explode(',', $deposito_custodia);
        break;
    case "Egresos":
        $DEPegreso    = explode(',', $deposito_egreso);
        break;
    case "Finalizadas":
        $DEPfinalizadas     = explode(',', $deposito_finalizadas);
        break;
endswitch;

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
   Deposito - <?=$titulo?>
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

      <?php if($DEPingresos[2] == 1):?>
        <div class="row">
          <div class="col-md-12 text-right btn-toolbar">
            <a class="btn btn-labeled btn-primary" href="<?=base_url('nuevo_ingreso')?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Nuevo Ingreso</a>
          </div>
        </div>
      <?php endif ?>


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
                                    <option value="<?=$key?>" <?php if($criterio == $key) {echo "selected=selected";} ?>><?=$opcion?></option>
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

                        <?php foreach ($remitos as $remito): ?>
                          <tr>
                            <td class="text-center"><?=$remito->id?></td>
                            <td class="text-center"><?= "<a href=".base_url("verEquipo/{$remito->id_equipo}").">" . $remito->serie . "</a>"; ?></td>
                            <td class="text-center"><?= ($remito->descrip == NULL) ? "<span class='text-danger'> A designar </span>" : $remito->descrip ;  ?></td>
                            <td class="text-center"><?= ($remito->id_orden == NULL) ? "<span class='text-danger'> A designar </span>" : "<a href=".base_url("ver-orden/{$remito->id_orden}").">" . $remito->id_orden . "</a>"; ?> </td>

                            <?php if ($remito->estado > 10):?>
                              <td class="text-center"><?= ($remito->num_remito == NULL) ? "<span class='text-danger'> A designar </span>" : $remito->num_remito ;  ?></td>
                            <?php endif; ?>

                            <!-- Ingresos y Egresos -->
                            <?php if (in_array($remito->estado,array(10,30))):?>
                              <td class="text-center"><?=$remito->categoria_descrip?></td>
                            <?php endif; ?>


                            <!-- Ingresos -->
                            <?php if($remito->estado == 10):?>
                              <td class="text-center"><?=date('d/m/Y',strtotime($remito->ts_creado));?></td>
                            <?php endif; ?>

                            <!-- Custodia -->
                            <?php if($remito->estado == 20):?>
                              <td class="text-center"><?=date('d/m/Y',strtotime($remito->fecha_recibido));?></td>
                              <td class="text-center"><?=$remito->name?></td>
                            <?php endif; ?>

                            <!--Egresos -->
                            <?php if ($remito->estado == 30):?>
                              <td class="text-center"> <?=date('d/m/Y',strtotime($remito->fecha_evento));?><br>
                              <?php
                              $fecha_evento = new DateTime($remito->fecha_evento);
                              $interval = $fecha_evento->diff(new DateTime(date()));
                              $dias =  $interval->format('%a%');

                              if ($dias >= 14) {
                                echo "<strong class='text-danger'>+14 Dias</strong>";
                              } elseif($dias >= 7) {
                                echo "<strong class='text-warning'>+7 Dias</strong>";
                              }
                              ?>
                              </td>
                            <?php endif; ?>

                            <?php if(in_array($remito->estado,array(40,50))):?>
                              <td class="text-center"><?=$remito->nombre_estado?></td>
                            <?php endif;?>

                            <td>
                              <?php if($DEPingresos[0] == 1 || $DEPcustodia[0] == 1 || $DEPegreso[0] == 1 || $DEPfinalizadas[0] == 1):?>
                                <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url("remito_deposito/$remito->id") ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                              <?php endif?>


                              <?php if ($remito->estado == 10 && $DEPingresos[1] == 1): ?>
                                  <a class="btn btn-success btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Recibir Equipos" data-target="#modalRecibir<?= $remito->id; $remito->serie; $remito->id_orden; $remito->categoria; $remito->id_proyecto; $remito->num_remito?>"><i class="fa fa-check"></i></a>
                                  <!-- sample modal content -->
                                  <div id="modalRecibir<?= $remito->id; $remito->serie; $remito->id_orden; $remito->categoria; $remito->id_proyecto; $remito->num_remito?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">Recibir Equipo - <?= $remito->serie?></h4>
                                              </div>
                                              <form class="form" action="<?= base_url('recibir_deposito'); ?>" method="post" data-toggle="validator">
                                                <input type="hidden" class="form-control" name="id_remito" value="<?= $remito->id ?>" >
                                                <input type="hidden" class="form-control" name="id_orden" value="<?= $remito->id_orden ?>" >
                                                <input type="hidden" class="form-control" name="categoria" value="<?= $remito->categoria ?>" >
                                                <input type="hidden" class="form-control" name="id_proyecto" value="<?= $remito->id_proyecto ?>" >

                                                  <div class="box-body">
                                                      <?php if ($remito->num_remito == NULL): ?>
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label id="label_num_remito" for="label_num_remito">Nº Remito</label>
                                                                  <div class="input-group">
                                                                    <span class="input-group-addon"> <i class="fa fa-list-ol" aria-hidden="true"></i> </span>
                                                                    <input type="number" class="form-control" id="num_remito"  name="num_remito" min="1" max="999999" autocomplete="off" placeholder="Maximo hasta 6 digitos"  data-error="Agregar numero de Remito o supero los 6 digitos." value="">
                                                                  </div>
                                                                 <div class="help-block with-errors"></div>
                                                             </div>
                                                          </div>
                                                        </div>
                                                      <?php endif; ?>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="form-group">
                                                                  <label for="observ">Observaciones</label>
                                                                  <textarea name="observacion" id="observacion" class="form-control" data-error="Completar este campo." required rows="3" cols="20" autofocus tyle="resize:none"></textarea>
                                                                  <div class="help-block with-errors"></div>
                                                              </div>
                                                          </div>
                                                      </div><!-- /.row -->
                                                  </div><!-- /.box-header -->
                                                  <div class="box-footer">
                                                      <input type="submit" class="btn btn-success pull-right" id="recibir" name="aprobar" value="Recibir" style="margin-left: 5px" />
                                                      <input type="submit" class="btn btn-danger pull-right" id="rechazar" name="aprobar" value="Rechazar" />
                                                  </div>
                                              </form>
                                          </div>
                                          <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                              <?php endif; ?>


                              <?php if (($remito->estado == 20 && $DEPcustodia[1] == 1) || ($remito->estado == 30 && $DEPegreso[1] == 1)): ?>
                                <a class="btn btn-default btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Agregar Eventos" data-target="#modalEventos<?= $remito->id; $remito->serie; $remito->estado?>"><i class="fa fa-plus"></i></a>
                                    <!-- sample modal content -->
                                    <div id="modalEventos<?= $remito->id; $remito->serie; $remito->estado?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Agregar nueva observación - <?= $remito->serie ?></h4>
                                                </div>
                                                <form  method="post" action="<?= base_url('agregar_observacion'); ?>" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="id_remito" name="id_remito" value="<?= $remito->id ?>">
                                                        <input type="hidden" class="form-control" id="estado" name="estado" value="<?= $remito->estado ?>">
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

                              <?php if ($remito->estado == 20 && $DEPcustodia[2] == 1): ?>
                                <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Adjuntar archivo" href="<?=base_url("deposito_archivos/{$remito->id}")?>"><i class="fa fa-file"></i></a>
                              <?php endif; ?>

                              <?php if ($remito->estado == 20 && $DEPcustodia[3] == 1): ?>
                                <a class="btn btn-success btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Enviar Equipo" data-target="#modalDestino<?= $remito->id; $remito->serie; $remito->estado; $remito->id_orden?>"><i class="fa fa-arrow-up"></i></a>
                                <!-- sample modal content -->
                                <div id="modalDestino<?= $remito->id; $remito->serie; $remito->estado; $remito->id_orden; $remito->id_equipo?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-notify modal-primary" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Enviar Equipo - <?= $remito->serie?></h4>
                                            </div>
                                            <form class="form" action="<?= base_url('equipo_destino'); ?>" method="post" data-toggle="validator">
                                                <div class="box-body">
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <div class="form-group">
                                                          <input type="hidden" class="form-control" name="id_remito" value="<?= $remito->id ?>" >
                                                          <input type="hidden" class="form-control" name="serie" value="<?= $remito->serie ?>" >
                                                          <input type="hidden" class="form-control" name="id_orden" value="<?= $remito->id_orden ?>" >
                                                          <input type="hidden" class="form-control" name="id_equipo" value="<?= $remito->id_equipo ?>" >
                                                         <label for="label_tipo_documentacion">Destino</label>
                                                           <div class="input-group">
                                                             <span class="input-group-addon"><i class="fa fa-list" aria-hidden="true"></i></span>
                                                             <select class="form-control" name="destino" id="destino" required data-error="Seleccionar una opcion.">
                                                              <option value="">Seleccionar destino</option>
                                                              <option value="1">Reparaciones</option>
                                                              <!--<option value="3">Instalaciones</option>-->
                                                              <option value="5">Socio</option>
                                                              <option value="11">Proyecto</option>

                                                            </select>
                                                           </div>
                                                          <div class="help-block with-errors"></div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="observ">Observaciones</label>
                                                                <textarea name="observacion" id="observacion" class="form-control" data-error="Completar este campo." required rows="3" cols="20" autofocus tyle="resize:none"></textarea>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->
                                                </div><!-- /.box-header -->
                                                <div class="box-footer">

                                                  <button type="submit" class="btn btn-info btn-rounded pull-right" style="margin-left: 5px">Aceptar</button>
                                                  <button type="button" class="btn btn-danger btn-rounded pull-right" data-dismiss="modal" >Cancelar</button>
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
            jQuery("#searchList").attr("action", baseURL + <?=strtolower($titulo)?>"_listado/" + value);
            jQuery("#searchList").submit();
        });
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });

    $(document).ready(function(){
      $("#recibir").click(function(){
        $("#num_remito").attr('required', 'required');
      });
    });

    $(document).ready(function(){
      $("#rechazar").click(function(){
        $("#num_remito").removeAttr('required');
      });
    });

</script>
