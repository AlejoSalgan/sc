<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
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
  		Protocolos - Protocolos sin Ordenes
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
  		  <span class="text-muted">Protocolos sin Ordenes</span>
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
                    <h3 class="box-title">
                    </h3>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="info">
                        <th class="text-center">Protocolo</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Fecha Protocolo</th>
                        <th class="text-center">Fecha Desde</th>
                        <th class="text-center">Fecha Hasta</th>
                        <th class="text-center">Archivos</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                    </thead>

                    <?php foreach ($protocolos as $protocolo): ?>
                      <tr>
                        <!-- Protocolo -->
                        <td class="text-center"><span class="label label-primary etiqueta14 text-center"><?=$protocolo->id ?></span></td>

                        <!-- Equipo y Proyecto -->
                        <td><?= "<a href=".base_url("verEquipo/{$protocolo->idequipo}").">" . $protocolo->equipo_serie . "</a>";?><br/><small class="text-muted"><?=$protocolo->descripProyecto ?></small></td>

                        <!-- Fecha del Protocolo -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($protocolo->fecha_protocolo));?>
                        </td>

                        <!-- Fecha desde -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($protocolo->fecha_inicial_remoto));?>
                        </td>

                        <!-- Fecha hasta -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($protocolo->fecha_final_remoto));?>
                        </td>

                        <!-- Cantidad Archivos -->
                        <td class="text-center"><span class="label label-primary etiqueta13"><?=$protocolo->cantidad ?>
                        </td>

                        <td>
                          <form class="form" action="<?= base_url('orden_remota'); ?>" method="post">
                            <input type="hidden" name="protocolo" value="<?=$protocolo->id?>">
                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i></button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>

                  </table>
                </div><!-- /.box-body -->

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
        jQuery("#searchList").attr("action", baseURL + "protocolos_aprobados/" + value);
        jQuery("#searchList").submit();
    });
});
</script>
