<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Usuarios - <?=$nombre_acceso?>
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <a href="<?= base_url('acceso_listado'); ?>"> Acceso Listado</a> /
      <span class="text-muted">Ver acceso</span>
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
      <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Listado de Accesos</h3>
            </div>


            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-hover">
                <tr class="info">
                  <th class="text-center">ID Permiso</th>
                  <th class="text-center">Rol</th>
                  <th class="text-center">Acciones</th>
                </tr>

                <?php foreach ($accesoInfo as $info): ?>
                  <tr>
                    <td class="text-center"><?=$info->id?></td>
                    <td ><?=$info->role?></td>

                    <td class="text-center">
                      <?php if ($info->rol != 99): ?>
                        <a data-toggle="tooltip" title="Eliminar Permiso" href="<?= base_url('eliminar_permiso/'.$info->id) ?>"><i class="fa fa-times text-danger"></i>&nbsp;&nbsp;&nbsp;</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>

            </div><!-- /.box-body -->


        </div>
      </div>


      <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Permiso</h3>
            </div>

            <form role="form" action="<?= base_url('agregar_permiso') ?>" method="post">
              <input type="hidden" value="<?=$this->uri->segment(2);?>" name="id_menu" id="id_menu">

              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label id="label_tipo" for="label_tipo">Rol</label>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Sekeccionar Rol"  name="rol[]" id="rol">
                              <?php foreach ($roles as $rol): ?>
                                <option value="<?=$rol->roleId?>"><?=$rol->role?></option>
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
    </div>
  </section>
</div>

<script>

$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()

})
</script>
