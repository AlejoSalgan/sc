<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - Instalacion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('instalaciones_solicitudes'); ?>"> Solicitudes listado</a> /
        <span class="text-muted">Instalacion
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

        <form class="" action="<?= base_url('add_solicitud_instalacion') ?>" method="post">

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Datos identificatorios</h3>
                  </div>
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
                    </div><!-- /.box-body -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Detalles 1</h3>
                  </div>

                  <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Tipo de Equipo</label>
                              <select class="form-control" id="tipo_equipo" name="tipo_equipo_1" required>
                                <option value="">Seleccionar Tipo</option>
                                <?php foreach ($tipos_equipo as $tp): ?>
                                    <option value="<?= $tp->id; ?>"><?= $tp->descrip ?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Equipo</label>
                              <select id="idequipo" name="idequipo_1[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Equipo" data-size="6">
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Fecha Limite</label>
                              <input id="fecha_limite" name="fecha_limite_1" type="text" class="form-control fecha" autocomplete="off" aria-describedby="fecha" placeholder="Seleccionar fecha">
                          </div>
                        </div>


                      </div>


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Direccion</label>
                              <input type="text" class="form-control" id="direccion" name="direccion_1" value="" autocomplete="off" placeholder="Escribir Direccion" required>
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="descrip">Observacion</label>
                             <textarea name="observacion_1" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"></textarea>
                            </div>
                        </div>
                      </div>

                  </div><!-- /.box-body -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Detalles 2</h3>
                  </div>

                  <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Tipo de Equipo</label>
                              <select class="form-control" id="tipo_equipo" name="tipo_equipo_2">
                                <option value="">Seleccionar Tipo</option>
                                <?php foreach ($tipos_equipo as $tp): ?>
                                    <option value="<?= $tp->id; ?>"><?= $tp->descrip ?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Equipo</label>
                              <select id="idequipo" name="idequipo_2[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Equipo" data-size="6">
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Fecha Limite</label>
                              <input id="fecha_limite" name="fecha_limite_2" type="text" class="form-control fecha" autocomplete="off" aria-describedby="fecha" placeholder="Seleccionar fecha">
                          </div>
                        </div>


                      </div>


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Direccion</label>
                              <input type="text" class="form-control" id="direccion" name="direccion_2" value="" autocomplete="off" placeholder="Escribir Direccion">
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="descrip">Observacion</label>
                             <textarea name="observacion_2" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"></textarea>
                            </div>
                        </div>
                      </div>

                  </div><!-- /.box-body -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Detalles 3</h3>
                  </div>

                  <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Tipo de Equipo</label>
                              <select class="form-control" id="tipo_equipo" name="tipo_equipo_3">
                                <option value="">Seleccionar Tipo</option>
                                <?php foreach ($tipos_equipo as $tp): ?>
                                    <option value="<?= $tp->id; ?>"><?= $tp->descrip ?></option>
                                <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Equipo</label>
                              <select id="idequipo" name="idequipo_3[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Equipo" data-size="6">
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Fecha Limite</label>
                              <input id="fecha_limite" name="fecha_limite_3" type="text" class="form-control fecha" autocomplete="off" aria-describedby="fecha" placeholder="Seleccionar fecha">
                          </div>
                        </div>


                      </div>


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="idproyecto">Direccion</label>
                              <input type="text" class="form-control" id="direccion" name="direccion_3" value="" autocomplete="off" placeholder="Escribir Direccion">
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="descrip">Observacion</label>
                             <textarea name="observacion_3" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"></textarea>
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

	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('desintalacion_equipos')?>", {proyecto: valor})
		.done(function(data) {
			var result = JSON.parse(data);
			var option = '';
	 		$("#idequipo").html("");
	 		var previo = ""; var i = 0;
			result.forEach(function(equipo) {
				option = option + "<option ";
        option = option + 'style="color:DodgerBlue;" ';
				option = option + 'value="'+equipo['id']+'">'+equipo['serie']+'</option>';

				if (i+1 >= result.length) {
					option = option + "</optgroup>";
				} else {
					if (result[i+1]['descrip'] != equipo['descrip']) {
						option = option + "</optgroup>";
					}
				}
				i++;
			});
			$(".selectpicker").append(option);
			$('.selectpicker').selectpicker('refresh');
		});
	});
});

</script>
