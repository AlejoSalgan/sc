<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(empty($criterio)){
  $criterio = 0;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Usuarios - Accesos Listados
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <span class="text-muted">Acceso Listado</span>
    </span>
  </div>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <?php
          $this->load->helper('form');
          $error = $this->session->flashdata('error');
          if ($error): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>
        <?php
        $success = $this->session->flashdata('success');
        if ($success): ?>
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?= $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <div class="form-group">
                  <a class="btn btn-primary" href="<?=base_url('agregar_acceso'); ?>">Agregar Accesos</a>
            </div>
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
                      <form action="<?= base_url('acceso_listado') ?>" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                            <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>ID</option>
                                <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Nombre</option>
                                <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Link</option>
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
                        <th class="text-center">ID</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Orden</th>
                        <th class="text-center">Padre</th>
                        <th class="text-center">Tipo</th>
                        <th>Acciones</th>
                      </tr>

                      <?php foreach ($accesos as $acceso): ?>
                        <tr>
                          <td class="text-center"><?=$acceso->id?></td>
                          <td><?=$acceso->nombre?></td>
                          <td><?=$acceso->link?></td>
                          <td class="text-center"><?=$acceso->orden?></td>
                          <td class="text-center"><?=$acceso->padre?></td>
                          <td class="text-center"><?=$acceso->tipo?></td>
                          <td>
                            <a data-toggle="tooltip" title="Ver Acceso" href="<?= base_url('ver_acceso/'.$acceso->id) ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </table>

                  </div><!-- /.box-body -->
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
            jQuery("#searchList").attr("action", baseURL + "acceso_listado/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
