<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$EXPexportaciones = explode(',', $exportaciones_exportaciones);

if(empty($criterio)){
  $criterio = 0;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">


<div class="content-wrapper">
     <div id="cabecera">
      SSTI - Exportaciones Listado
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('exportaciones_listado'); ?>"> Exportaciones</a> /
        <span class="text-muted">Exportaciones</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title"></h3>
                  <div class="box-tools">
                      <form action="<?php echo base_url() ?>exportaciones_listado" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                            <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Exportacion</option>
                                <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Proyecto</option>
                            </select>
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </form>
                  </div>
              </div><!-- /.box-header -->

              <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <tr class="info">
                    <th>Nº Exportacion</th>
                    <th class="text-center">Proyecto</th>
                    <th class="text-center">Cantidad Protocolos</th>
                    <th>Acciones</th>
                  </tr>
                  <?php foreach ($exportaciones as $exportacion): ?>
                  <tr>
                    <td>
                      <p class="label label-primary" style="color:white; font-size:14px;"><?=$exportacion->numero_exportacion?></p>
                      </td>
                    <td class="text-center"><?=$exportacion->proyecto?></td>
                    <td class="text-center">
                      <p class="label label-primary" style="color:white; font-size:12px;"><?=$exportacion->cantidadProtocolos?></p>

                      </td>
                    <td>
                      <?php if ($EXPexportaciones[0] == 1): ?>
                        <a data-toggle="tooltip" title="Ver Detalle" href="<?php echo base_url().'verExportacion/'.$exportacion->numero_exportacion; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </table>

              </div><!-- /.box-body -->
              <div class="box-footer clearfix">
                  <?php echo $this->pagination->create_links(); ?>
              </div>
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
            jQuery("#searchList").attr("action", baseURL + "exportaciones_listado/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
