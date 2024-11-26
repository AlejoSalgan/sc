<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$PROasignaciones   = explode(',', $proyectos_asignaciones);

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Proyectos - Asignaciones
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <a href="<?= base_url('municipiosListing'); ?>"> Proyecto Listado</a> /
      <span class="text-muted">Asignaciones</span>
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
        <?php
        if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?= $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$proyecto->descrip?> - Asignados</h3>
            </div>

            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-hover">
                <tr class="info">
                  <th class="text-center">ID</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Rol</th>
                  <th class="text-center">A cargo</th>
                  <th class="text-center">Acciones</th>

                </tr>

                <?php foreach ($gestiones as $gestion): ?>
                  <tr>
                    <td class="text-center"><?= $gestion->id?></td>
                    <td><?= "<a href=".base_url("verPersonal/{$gestion->usuario}").">" .$gestion->name. "</a>"; ?></td>
                    <td><?= $gestion->role?></td>
                    <td class="text-center"><?= ($gestion->prioridad == 1) ? 'SI' : 'NO' ; ?></td>
                    <td>
                      <?php if ($PROasignaciones[0] == 1): ?>
                        <a data-toggle="tooltip" title="Eliminar Asignacion" href="<?= base_url('eliminar_asignacion/'.$gestion->id) ?>"><i class="fa fa-times text-danger"></i>&nbsp;&nbsp;&nbsp;</a>
                      <?php endif; ?>

                      <?php if ($PROasignaciones[1] == 1): ?>
                        <a data-toggle="tooltip" title="Dar prioridad" href="<?= base_url('estado_prioridad/'.$gestion->id) ?>"><i class="fa fa-retweet text-success"></i>&nbsp;&nbsp;&nbsp;</a>
                      <?php endif; ?>


                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>

            </div><!-- /.box-body -->


        </div>
      </div>

      <?php if ($PROasignaciones[2] == 1): ?>

        <div class="col-xs-5">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Usuario</h3>
            </div>

            <form role="form" action="<?= base_url('agregar_asignacion') ?>" method="post">
              <input type="hidden" value="<?=$this->uri->segment(2);?>" name="id_proyecto" id="id_proyecto">

              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label id="label_tipo" for="label_tipo">Nombre</label>
                            <select class="form-control select2" multiple="multiple" data-placeholder=" Seleccionar usuario"  name="usuarios[]" id="usuarios">
                              <?php foreach ($gestores as $gestor): ?>
                                <option value="<?=$gestor->userId?>"><?=$gestor->name?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                      </div>
                  </div>
              </div><!-- /.box-body -->

                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar" />
                </div>
            </form>

        </div>
      </div>

      <?php endif; ?>


    </div>
  </section>
</div>

<script>

$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()

})
</script>
