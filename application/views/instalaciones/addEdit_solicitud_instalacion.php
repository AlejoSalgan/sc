<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - <?=$tipoItem?> nueva Solicitud
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('solicitudes_instalacion'); ?>"> Solicitudes listado</a> /
        <span class="text-muted"><?=$tipoItem?> nueva Solicitud
    </div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    if ($this->session->flashdata('error')): ?>
                      <div class="alert alert-danger alert-dismissable" style="position: relative; bottom: 5px;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                <?php
                if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable" style="position: relative; bottom: 5px; ">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>
          </div>
        </div>

        <form class="" action="<?= base_url('addEdit_nueva_solicitud_instalacion') ?>" method="post">
          <input type="hidden" name="id_grupo" value="<?=$id_grupo?>">
          <input type="hidden" name="tipoItem" value="<?=$tipoItem?>">

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Detalles</h3>
                  </div>

                  <div class="box-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Tipo de Equipo</label>
                              <select class="form-control" id="tipo_equipo" name="tipo_equipo">
                                <option value="">Seleccionar Tipo</option>
                                <?php foreach ($tipos_equipo as $tp): ?>
                                    <option value="<?= $tp->id; ?>"><?= $tp->descrip ?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                        </div><!-- /.col-md-6 -->

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Fecha Limite</label>
                              <input id="fecha_limite" name="fecha_limite" type="text" class="form-control fecha" autocomplete="off" aria-describedby="fecha" placeholder="Seleccionar fecha">
                          </div>
                        </div><!-- /.col-md-6 -->
                      </div><!-- /.row -->


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Direccion</label>
                              <input type="text" class="form-control" id="direccion" name="direccion" value="" autocomplete="off" placeholder="Escribir Direccion">
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="descrip">Observacion</label>
                             <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"></textarea>
                            </div>
                        </div>
                      </div>

                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Guardar" />
                  </div>
              </div>
            </div>
          </div>

        </form>
    </section>
</div>

<script>
$( document ).ready(function() {
  $(function() {
      $('.fecha').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '0',
          language: 'es',
          todayHighlight: true
      });
  });
});
</script>
