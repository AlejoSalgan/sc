<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<div class="content-wrapper">
    <div id="cabecera">
      Protocolos - Agregar remotos
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('protocolos_remotos'); ?>"> Protocolos Remotos</a> /
        <span class="text-muted">Protocolos Agregar remotos</span>
      </span>
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

                <form role="form" action="<?= base_url('addRemoto') ?>" method="post">

                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="idproyecto">Proyecto</label>
                                <select class="form-control" id="idproyecto" name="idproyecto" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($municipios as $municipio): ?>
                                       <option value="<?php echo $municipio->id; ?>" <?php if($municipio->id == $ordenesbInfo->idproyecto) {echo "selected=selected";} ?>><?php echo $municipio->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="idequipo"></i> Equipo serie</label>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccione el equipo" data-size="6" required>
                                  </select>
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                <label id="label_icono" for="label_icono">Fecha Desde</label>
                                <input type='text' class="form-control" id='datetimepicker1' name="fecha_desde" required />
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                <label id="label_icono" for="label_icono">Fecha Hasta</label>
                                <input type='text' class="form-control" id='datetimepicker2' name="fecha_hasta" required />
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                <label id="label_icono" for="label_icono">Cantidad</label>
                                <input type='number' class="form-control" min="0" name="cantidad" required />
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

<script type="text/javascript">
    $(function () {
      $('#datetimepicker1').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
      });
    });

    $(function () {
      $('#datetimepicker2').datetimepicker({
        format: 'DD/MM/YYYY HH:mm'
      });
    });
</script>

<script>
$( document ).ready(function() {
	$('#fecha_visita').datepicker({
		format: 'dd-mm-yyyy',
		language: 'es'
	});

	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('equipos_remotos')?>", {proyecto: valor})
		.done(function(data) {
			var result = JSON.parse(data);
			var option = '';
	 		$("#idequipo").html("");
	 		var previo = ""; var i = 0;
			result.forEach(function(equipo) {
				option = option + "<option ";
        option = option + 'style="color:DodgerBlue;" ';
				option = option + 'value="'+equipo['id_equipo']+'">'+equipo['serie']+'</option>';

				if (i+1 >= result.length) {
					option = option + "</optgroup>";
				} else {
					if (result[i+1]['descrip'] != equipo['descrip']) {
						option = option + "</optgroup>";
					}
				}
				i++;
			});
			$("#idequipo").append(option);
			$('.selectpicker').selectpicker('refresh');
		});
	});
});

</script>
