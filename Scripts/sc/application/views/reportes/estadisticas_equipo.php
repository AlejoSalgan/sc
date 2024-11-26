<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /> 


<div class="content-wrapper">
    <div id="cabecera">
      SC - Informe de Estadísticas
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Informe de Estadísticas
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
                <form role="form" action="<?= base_url('estadisticas_excel') ?>" method="post">
                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
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

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="idmodelo"></i> Modelo</label>
                                  <select id="idmodelo" name="idmodelo" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Modelo" data-size="10" required>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="idequipo"></i> Equipo</label>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccionar Equipo" data-size="10" required>
                                  </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="fecha">Fecha Rango</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                              <input type='text' class="form-control" id='datetimepicker1' name="fecha" required />
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" id="descargar" value="Descargar" />
                  </div>
                  <div class="box-header with-border">
                      <h3 type="text" class="text-success" id="textdescaraga"> Preparando Excel...</h3>              
                  </div>
                  
                </form>                      
          </div>
        </div>
      </div>
    </section>
</div>



<script>
$( document ).ready(function() {

  $("#textdescaraga").hide();

  $("#descargar").click( function() {
    $("#textdescaraga").show("slow");
    $("#textdescaraga").delay(2000);
    $("#textdescaraga").hide("slow");
  });

	$("#idproyecto").change(function () {
		valor_proyecto = $(this).val();
		$.post("<?=base_url('equipos_modelos_ssti')?>", {proyecto: valor_proyecto})
		.done(function(data) {
      var result = JSON.parse(data);
      var option = '';
      $("#idmodelo").html("");
      result.forEach(function(modelo) {
        option = option + "<option ";
        option = option + 'style="color:DodgerBlue;" ';
        option = option + 'value="'+modelo['id']+'">'+modelo['descrip']+'</option>';		
      });
  
      $("#idmodelo").append(option);
      $('#idmodelo').selectpicker('refresh');
    });
  });

  $("#idmodelo").change(function () {
      val_idmodelo = $(this).val()[0];
      $.post("<?=base_url('equipos_by_modelo')?>", {
        proyecto: valor_proyecto, 
        modelo: val_idmodelo
      }).done(function(data2) {
      
        var result_equipos = JSON.parse(data2);
      
        var option_equipos = '';
        var i = 0;
      $("#idequipo").html("");
      result_equipos.forEach(function(equipo) {

        if (i == 0) {
          option_equipos = option_equipos + '<option style="color:DodgerBlue;"';
          //option_equipos = option_equipos + 'value="0">TODOS LOS EQUIPOS</option>';
          i++;
				} else {
          option_equipos = option_equipos + "<option ";
          option_equipos = option_equipos + 'style="color:DodgerBlue;" ';
          option_equipos = option_equipos + 'value="'+equipo['serie']+'">'+equipo['serie']+'</option>';
				}
		
      });
      ///alert(option_equipos);
      $("#idequipo").append(option_equipos);
      $('.selectpicker').selectpicker('refresh');
    });
  });
  $("#descargar").on("click", function() {
      valor_proyecto = $("#idproyecto").val();
      valor_modelo = $("#idmodelo").val();
      valor_equipo =$("#idequipo").val();
      valor_fecha = $("#datetimepicker1").val();

		$.post("<?=base_url('estadisticas_excel')?>", {
      proyecto: valor_proyecto,
      modelo: valor_modelo,
      equipo: valor_equipo,
      fecha: valor_fecha,      
    })
		.done(function(data) {    
    });
  });
   //antropometria-
});
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
</script>