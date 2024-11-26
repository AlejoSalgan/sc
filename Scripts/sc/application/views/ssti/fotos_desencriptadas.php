<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$FOTdesencriptadas = explode(',', $fotos_desencriptadas);
?>

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
   SSTI - <?=$titulo?>
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
                        <form action="<?= base_url('fotosDesencriptadas_listado') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
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

                        <?php foreach ($protocolos as $protocolo):
													$fecha_evento = new DateTime($protocolo->ts);
													$interval = $fecha_evento->diff(new DateTime(date()));
													$dias =  $interval->format('%a%');
													if ($dias >= 4) {
														$color = "danger";
														$texto = "+4 Dias";
													} elseif($dias >= 1) {
														$color = "warning";
														$texto = "+1 Dia";
													} else{
														$color = "primary";
														$texto = "Horas";
													}
													?>
                          <tr>
                            <td class="text-center"><p class="label label-<?=$color?>" style="color:white; font-size:16px;"><?=$protocolo->id_protocolo ?></p></td>
                            <td class="text-center"><?= "<a href=".base_url("verEquipo/{$protocolo->id_equipo}").">" . $protocolo->equipo_serie . "</a>"; ?></td>
                            <td class="text-center"><?= ($protocolo->proyecto == NULL) ? "<span class='text-danger'> A designar </span>" : $protocolo->proyecto ;  ?></td>
                            <td class="text-center"><?=$protocolo->cantidad?></td>
														<td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($protocolo->ts));?><br><strong class='text-<?=$color?>'><?=$texto?></strong>
														</td>

                            <td>
															<?php if ($FOTdesencriptadas[0] == 1): ?>
                              	<a class="btn btn-primary btn-xs" target="_blank" data-toggle="tooltip" title="Ver Fotos" href="<?= base_url("ver_fotos/$protocolo->id_protocolo") ?>"><i class="fa fa-image"></i></a>
															<?php endif; ?>
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

</script>
