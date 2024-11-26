<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


<div class="content-wrapper">
    <div id="cabecera">
      SSTI - Informe de Productividad
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Informe de Productividad
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
                <form role="form" action="<?= base_url('descargar_productividad') ?>" method="post">
                  <div class="box-body">
                    <div class="row">
                      <!-- Se dejan div comentados futura version [ :-) ]-->
                        <!-- <div class="col-md-3">
                          <label for="fecha_desde_label">Fecha Desde</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                              <input type='text' class="form-control" id='datetimepicker1' name="fecha_desde" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                          <label for="fecha_hasta_label">Fecha Hasta</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                              <input type='text' class="form-control" id='datetimepicker2' name="fecha_hasta" required />
                            </div>
                        </div> -->
                        <div class='col-md-4'>
                          <div class="form-group">
                              <label for="fecha">Fecha Rango</label>
                                <input type="text" class="form-control" name="fecha" required/>
                          </div>      
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto_label">Proyecto</label>
                                <select class="form-control" id="idproyecto" name="idproyecto" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($proyectos as $proyecto): ?>
                                      <option value="<?= $proyecto->id; ?>" <?php if($proyecto->id == $solicitud->id_proyecto) {echo "selected=selected";} ?>><?= $proyecto->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="idequipo"></i> Equipo</label>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Equipo" data-size="10">
                                  </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                            <input class="form-check-input" type="checkbox" value="1" id="foto_noche" name="foto_noche">
                              <label class="form-check-label" for="fotonoche_label">  
                              Solo Productividad Nocturna
                              </label>
                      </div>
                    </div> 
                  </div>
                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Descargar" />
                  </div>                
                </form>
          </div>
        </div>
      </div>
    </section>
</div>
<script>
$( document ).ready(function() {

	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('equipos_ssti')?>", {proyecto: valor})
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
			$("#idequipo").append(option);
			$('.selectpicker').selectpicker('refresh');
		});
	});
});

</script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /> 
<script>
$(document).ready(function() {
  $(function () {
    $('input[name="fecha"]').daterangepicker({
        "locale": {
          "format": "YYYY-MM-DD",
          "separator": "/",
          "applyLabel": "Aplicar",
          "cancelLabel": "Cancelar",
          "fromLabel": "From",
          "toLabel": "To",
          "customRangeLabel": "Custom",
          "minDate": new Date(),
          
          "daysOfWeek": [
              "Do",
              "Lu",
              "Ma",
              "Mi",
              "Ju",
              "Vi",
              "Sa"
          ],
          "monthNames": [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Deciembre"
          ],
          "firstDay": 1
        }
    });
  });
});
</script>

