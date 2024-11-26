<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

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
      
      <div class="row">
        <div class="col-md-12 text-right btn-toolbar">
          <a class="btn btn-labeled btn-primary" href="<?=base_url('agregar_proyecto')?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Agregar Proyecto</a>
        </div>
      </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Proyectos listado</h3>
                    <div class="box-tools">
                        <form action="<?= base_url('municipiosListing') ?>" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                            <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Proyecto</option>
                                <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Gestor</option>
                                <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Ayudantes</option>
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
                      <th class="text-center">Proyecto</th>
                      <th class="text-center">Gestor</th>
                      <th class="text-center">Total de Equipos</th>
                      <th class="text-center">Activos</th>
                      <th class="text-center">Inactivos</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                    <?php foreach ($proyectos as $proyecto): ?>
                      <tr>
                        <td><span class="text-info"><?=$proyecto->nombre_proyecto?></span></td>
                        <td class="text-center"><?= ($proyecto->gestor) ? "<a class='gestor' href=".base_url("verPersonal/{$proyecto->id_gestor}").">" . $proyecto->gestor . "</a>" : 'A designar' ;?></td>
                        <td class="text-center"><span class="label label-info" style="color:white; font-size:14px;"><?=$proyecto->activos+$proyecto->inactivos?></span></td>
                        <td class="text-center"><span class="label label-success" style="color:white; font-size:14px;"><?=$proyecto->activos?></span></td>
                        <td class="text-center"><span class="label label-danger" style="color:white; font-size:14px;"><?=$proyecto->inactivos?></span></td>

                        <td>
                          <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url("ver_proyecto/$proyecto->id") ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>

                          <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Editar Proyecto" href="<?= base_url("editar_proyecto/$proyecto->id") ?>">&nbsp;<i class="fa fa-edit"></i></a>

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
