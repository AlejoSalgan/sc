<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Usuarios - Agregar acceso
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <a href="<?= base_url('acceso_listado'); ?>"> Acceso Listado</a> /
      <span class="text-muted">Agregar acceso</span>
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
      <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detalles</h3>

                <span class="pull-right">

                  <a data-toggle="modal" title="Ayuda" data-target="#modalAccesos" ><i class="fa fa-question-circle text-info fa-lg"></i></a>
                      <!-- sample modal content -->
                      <div id="modalAccesos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                      <h4 class="modal-title" id="myModalLabel">Ayuda de Agregar Accesos</h4>
                                  </div>
                                  <div class="modal-body">
                                    <p><strong>Icono:</strong> Solo para las Categorias. <br>
                                      Ejemplo: fa fa-dashboard
                                    </p>

                                    <p><strong>Nombre:</strong> El nombre que escribas es el que aparecera para las Categorias, Menu y Submenu. Para el resto es solo para identificarlo. <br>
                                      Ejemplo: Equipos o Funcion Cargar Equipos.
                                    </p>

                                    <p><strong>Link:</strong> Es la funcion que esta en routes.<br>
                                      Ejemplo: agregar_acceso
                                    </p>

                                    <p><strong>Orden:</strong> Es el orden para los Submenus.<br>
                                      Ejemplo: 10/20/30/40/Etc.
                                    </p>

                                    <p><strong>Padre:</strong> Es el ID de un acceso que contiene a otro.<br>
                                      Ejemplo: El Menu Personal es el ID 26 si queremos agregar un nuevo Submenu para Personal este campo llevaria el numero <strong>26</strong>.<br>
                                      Lo mismos se aplicaria entre Categorias con Menus, Submenus con Vistas y Vistas con Funciones y Acciones.
                                    </p>


                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-success btn-rounded" data-dismiss="modal">Aceptar</button>
                                  </div>
                              </div>
                          </div>
                      </div>

                </span>
            </div>

            <form role="form" action="<?= base_url('agregar_editar_accesos') ?>" method="post">

              <div class="box-body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_icono" for="label_icono">Icono</label>
                            <input id="icono" name="icono" type="text" class="form-control" autocomplete="off">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_nombre" for="label_nombre">Nombre</label>
                            <input id="nombre" name="nombre" type="text" class="form-control" autocomplete="off">
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_link" for="label_link">Link</label>
                            <input id="link" name="link" type="text" class="form-control" autocomplete="off">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_orden" for="label_orden">Orden</label>
                            <input id="orden" name="orden" type="text" class="form-control" autocomplete="off">
                          </div>
                      </div>
                  </div>


                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_padre" for="label_padre">Padre</label>
                            <input id="padre" name="padre" type="text" class="form-control" autocomplete="off">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                            <label id="label_tipo" for="label_tipo">Tipo</label>
                            <select class="form-control" name="tipo" id="tipo" required>
															<option value="">Seleccionar tipo</option>
                              <option value="0">Categoria</option>
															<option value="1">Menu</option>
															<option value="2">Submenu</option>
															<option value="3">Vista</option>
															<option value="4">Funcion</option>
														</select>
                          </div>
                      </div>
                  </div>


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


                  <div class ="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="observaciones_gestor">Observaciones</label>
                              <textarea name="observaciones_gestor" id="observaciones_gestor" class="form-control" rows="5" cols="50" style="resize:none"><?= $observaciones_gestor; ?> </textarea>
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
