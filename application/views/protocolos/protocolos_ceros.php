<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$INGcero = explode(',', $ingreso_cero);

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
  		Protocolos - Protocolos Ceros
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
  		  <span class="text-muted">Protocolos Ceros</span>
  		</span>
  	</div>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
                    <?php if ($total > 0): ?>
                    Total:<b><a href="javascript:void(0)"> <?= $total?></a></b>
                  <?php else: ?>
                    No hay datos para mostrar.
                  <?php endif; ?>
                  </h3>

                    <div class="box-tools">
                        <form action="<?= base_url("protocolosceroListing") ?>" method="GET" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Protocolo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Fecha Protocolo</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Cantidad</option>
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
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr class="info">
                          <th class="text-center">Protocolo</th>
                          <th class="text-center">Equipo</th>
                          <th class="text-center">Fecha Protocolo</th>
                          <th class="text-center">Tecnico</th>
                          <th class="text-center" width="200px">Motivo</th>
                          <!-- <th class="text-center">Orden Reparacion</th> -->
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>

                      <?php foreach ($protocolosRecords as $key => $record): ?>
                        <tr>
                        <!-- Protocolo -->
                        <td class="text-center"><span class="label label-primary etiqueta14 text-center"><?=$record->protocolo ?></span><br>
                          <small class="text-muted">Ord. <?=$record->id?></small></td>

                        <!-- Equipo y Proyecto -->
                        <td><?= "<a href=".base_url("verEquipo/{$record->idequipo}").">" . $record->equipoSerie . "</a>";?><br/><small class="text-muted"><?=$record->descripProyecto ?></small></td>

                        <!-- Fecha del Protocolo -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($record->fecha_procesado));?>
                        </td>

                        <!-- Subida por -->
                        <td class="text-center"><?= $record->tecnico;?></td>

                        <!-- Motivo -->
                        <td>
      										<span class=text-muted><?= ucfirst(strtolower($record->bajada_observ))?></span>
      									</td>

                        <!-- N° de Reparacion -->
                        <!--<td class="text-center"><?//"<a href=".base_url("ver-orden/{$record->id_ord_repa}").">" . $record->id_ord_repa . "</a>"; ?> </td>-->

                        <td>
                          <?php if($INGcero[0] == 1) { ?>
                              <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("verProtocolos/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                          <?php } ?>

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
            jQuery("#searchList").attr("action", baseURL + "protocolosceroListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
