<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$EXPdetalles = explode(',', $exportaciones_detalles);
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
   SSTI - Exportacion Nº <?= $numExpo?>
   <span class="pull-right">
     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
     <a href="<?= base_url('exportaciones_listado'); ?>"> Exportaciones</a> /
     <span class="text-muted">Ver Exportacion</span>
   </span>
 </div>

    <section class="content">
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">Detalles</h3>
              </div><!-- /.box-header -->

              <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <tr class="info">
                    <th class="text-center">Nº Protocolo</th>
                    <th class="text-center">Equipo</th>
                    <th class="text-center">Municipio</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  <?php foreach ($expo_protocolos as $protocolo): ?>
                  <tr>
                    <td class="text-center"><span class="label label-primary" style="color:white; font-size:14px;"><?=$protocolo->id?></span></td>
                    <td class="text-center"><?= "<a href=".base_url("verEquipo/{$protocolo->idequipo}").">" . $protocolo->equipo_serie . "</a>"; ?></td>
                    <td class="text-center"><?= $protocolo->descrip?></td>
                    <td>
                      <?php if ($EXPdetalles[0] == 1): ?>
                        <a class="btn btn-primary btn-xs btn-success" data-toggle="tooltip" title="Ver Aprobadas" href="<?= base_url("verAprobadas/$protocolo->id") ?>"><i class="fa fa-check"></i></a>
                      <?php endif; ?>

                      <?php if ($EXPdetalles[1] == 1): ?>
                        <a class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" title="Ver Desaprobadas" href="<?= base_url("verDesaprobadas/$protocolo->id") ?>"><i class="fa fa-times"></i></a>
                      <?php endif; ?>

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
