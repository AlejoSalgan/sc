<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Instalacion - Agregar Visitas
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url($link); ?>"><?=$titulo?></a> /
  		  <span class="text-muted">Agregar Visitas</span>
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
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Detalles</h3>
              </div>

              <form action="<?= base_url('add_visita_instalacion') ?>" method="post">
                <input type="hidden" name="tabla_visitas" value="<?=$tabla_visitas?>">
                <input type="hidden" name="tabla_eventos" value="<?=$tabla_eventos?>">
                <input type="hidden" name="link" value="<?=$link?>">

                <input type="hidden" name="id_orden" value="<?=$id_orden?>">

                <div class="box-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Conductor</label>
                            <select class="form-control" id="conductor" name="conductor" required>
                              <option value="">Seleccionar Conductor</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                      <option value="<?= $usuario->userId ?>"><?= $usuario->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Tecnico</label>
                            <select class="form-control" id="tecnico" name="tecnico" required>
                              <option value="">Seleccionar Tecnico</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                      <option value="<?= $usuario->userId ?>"><?= $usuario->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                      </div>

                    </div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Fecha Visita</label>
                            <input id="fecha_visita" name="fecha_visita" type="text" class="form-control fecha" autocomplete="off" aria-describedby="fecha" placeholder="Seleccionar fecha">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Vehiculo</label>
                            <select class="form-control" id="vehiculo" name="vehiculo" required>
                              <option value="">Seleccionar vehículo.</option>
                                <?php foreach ($vehiculos as $vehiculo): ?>
                                      <option value="<?= $vehiculo->id ?>"><?= $vehiculo->dominio ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                      </div>


                    </div>

                    <div class="row">
                      <div class="col-md-12">
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
              </form>
          </div>
        </div>
      </div>



    </section>
</div>

<script>
    $(function() {
      $('.fecha').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '0',
          language: 'es',
          todayHighlight: true
      });
    });
</script>
