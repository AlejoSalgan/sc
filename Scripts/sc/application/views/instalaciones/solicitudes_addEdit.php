<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - <?=$tipoItem?> Relevamiento
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('instalaciones_solicitudes'); ?>"> Solicitudes listado</a> /
        <span class="text-muted"><?=$tipoItem?> Relevamiento
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

        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalles</h3>
                </div>

                <form role="form" action="<?= base_url('agregar_editar_solicitudes') ?>" method="post">
                  <input type="hidden" name="tipoItem" value="<?=$tipoItem?>">
                  <input type="hidden" name="id_orden" value="<?=$solicitud->id?>">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Proyecto</label>
                              <select class="form-control" id="idproyecto" name="idproyecto" required>
                                  <option value="">Seleccionar</option>
                                  <?php foreach ($proyectos as $proyecto): ?>
                                     <option value="<?= $proyecto->id; ?>" <?php if($proyecto->id == $solicitud->id_proyecto) {echo "selected=selected";} ?>><?= $proyecto->descrip ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label id="label_icono" for="label_icono">Direccion</label>
                              <input type='text' class="form-control" id="direccion" name="direccion" value="<?=$solicitud->direccion?>" required autocomplete="off">
                            </div>
                        </div>

                    </div>



                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="idproyecto">Tipo de Equipo</label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($tipos_equipos as $tipo_equipo): ?>
                                       <option value="<?= $tipo_equipo->id; ?>" <?php if($tipo_equipo->id == $solicitud->id_tipo_equipo) {echo "selected=selected";} ?>><?= $tipo_equipo->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="idproyecto">Prioridad</label>
                                <select class="form-control" id="prioridad" name="prioridad" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($prioridades as $prioridad): ?>
                                       <option value="<?= $prioridad->id; ?>" <?php if($prioridad->id == $solicitud->id_prioridad) {echo "selected=selected";} ?>><?= $prioridad->tipo_prioridad ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                          </div>
                      </div>

                      <div class ="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                 <label for="descrip">Observacion</label>
                               <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"><?= $solicitud->observaciones; ?></textarea>
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
