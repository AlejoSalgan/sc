	<script>
$(document).ready(function(){
	$("#fecha_inicio").datepicker({
	    format: "yyyy-mm-dd",
	    language: "es",
	    startDate: "today",
	}).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#fecha_fin').datepicker('setStartDate', minDate);
    });
	$("#fecha_fin").datepicker({
	    format: "yyyy-mm-dd",
	    language: "es",
	    startDate: "today",
	}).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#fecha_inicio').datepicker('setEndDate', maxDate);
    });
	$("#hora_inicio").timepicker({
        template: false,
        showInputs: false,
        minuteStep: 1,
        showMeridian: false
    });
	$("#hora_fin").timepicker({
		template: false,
        showInputs: false,
        minuteStep: 1,
        showMeridian: false
    });
    $("#diacompleto").click(function(){
        if ($(this).is(":checked")) {
			$("#hora_inicio").prop("disabled",true);
			$("#hora_inicio").prop("required",false);
	        $("#fecha_fin").prop("disabled",true);
			$("#hora_fin").prop("disabled",true);
			$("#fecha_fin").prop("required",false);
			$("#hora_fin").prop("required",false);
			$("#hora_inicio").val("");
			$("#fecha_fin").val("");
			$("#hora_fin").val("");
        } else {
        	$("#hora_inicio").prop("disabled",false);
			$("#hora_inicio").prop("required",true);
			$("#fecha_fin").prop("disabled",false);
        	$("#hora_fin").prop("disabled",false);
        	$("#fecha_fin").prop("required",true);
			$("#hora_fin").prop("required",true);
			var today = new Date();
			$("#hora_inicio").val(today.format("H:i"));
			$("#fecha_fin").val(today.format("Y-m-d"));
			$("#hora_fin").val(today.format("H:i"));
        }
    });
    $('#tipo').change(function(){
    	if ($(this).val() == 1) {
        	$("#invitados").show();
        	$("#asistentes").prop("required",true);
    		$("#hora_inicio").prop("required",true);
    		$("#hora_fin").prop("required",true);
    		$("#hora_inicio").prop("disabled",false);
    		$("#hora_fin").prop("disabled",false);
			var today = new Date();
    		$("#hora_inicio").val(today.format("H:i"));
    		$("#hora_fin").val(today.format("H:i"));
    	} else if ($(this).val() == 2) {
    		$("#invitados").hide();
    		$("#asistentes").prop("required",false);
    		$("#asistentes").val("");
    		$("#hora_inicio").prop("required",false);
    		$("#hora_fin").prop("required",false);
    		$("#hora_inicio").prop("disabled",true);
    		$("#hora_fin").prop("disabled",true);
    		$("#hora_inicio").val("");
    		$("#hora_fin").val("");
    	} else {
    		$("#invitados").hide();
    		$("#asistentes").prop("required",false);
    		$("#asistentes").val("");
    		$("#hora_inicio").prop("required",true);
    		$("#hora_fin").prop("required",true);
    		$("#hora_inicio").prop("disabled",false);
    		$("#hora_fin").prop("disabled",false);
			var today = new Date();
    		$("#hora_inicio").val(today.format("H:i"));
    		$("#hora_fin").val(today.format("H:i"));
    	}
   	});
    $('#calendar').fullCalendar({
		editable: false,
		defaultView: 'agendaWeek',
		allDaySlot: false,
		businessHours: {
		    // days of week. an array of zero-based day of week integers (0=Sunday)
		    dow: [ 1, 2, 3, 4, 5 ], // Monday - Friday
		    start: '9:00', // a start time (9am in this example)
		    end: '18:00', // an end time (6pm in this example)
		},
		events: <?=json_encode($eventos)?>
    });
})
</script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
          <div class="row bg-title" style="position: relative; bottom: 15px; ">
              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                  <h4 class="page-title">Eventos de agenda</h4> 
              </div>
              <div class="text-right">
                  <ol class="breadcrumb" style="background-color: white">
                      <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                      <li class="active">Añadir evento</li>
                  </ol>
              </div>
          </div>
     	</section>

    <section class="content">
	<div class="row">
		<!-- left column -->
		<?php if ($ocupados):?>
		<div class="col-md-4">
		<?php else:?>
		<div class="col-md-12">		
		<?php endif;?>
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Añadir evento</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
				<!-- form start -->
				<form role="form" id="form" action="<?=base_url()?>agenda-add" method="post">
				<input type="hidden" name="creadopor" value="<?=$userId?>">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">	
							<div class="form-group">
								<label for="nombre">* Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de evento" maxlength="150" value="<?=$post['nombre']?>" required  autofocus>
							</div>
						</div>
					</div> 
					<div class="row">
						<div class="col-md-5 col-md-offset-1">	
							<div class="form-group">
								<label for="tipo">* Motivo	</label>
								<select id="tipo" name="tipo" class="form-control">
								<?php foreach ($tipos as $row):?>
								  <option value="<?=$row->id?>" <?=$row->id==$post['tipo']?'selected':''?>><?=$row->descrip?></option>
								<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col-md-5">	
							<div class="form-group">
								<label for="ubicacion">Ubicación</label>
								<input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación" maxlength="150"  value="<?=$post['ubicacion']?>">
							</div>
						</div>
					</div>
					<!-- Invitados a reunión -->
					<div id="invitados" class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<label for="asistentes">* Asistentes</label>
								<select id="asistentes" name="asistentes[]" class="form-control selectpicker" multiple data-live-search="true" title="Seleccione los asistentes..." data-size="5" required>
								<?php foreach ($puestos as $key => $puesto):?>
									<optgroup label="<?=$key?>">
									<?php foreach ($puesto as $id => $asistente): ?>
										<option value="<?=$id?>" <?=in_array($id,$asistentes)?'selected':''?>><?=$asistente?></option>
									<?php endforeach;?>
									</optgroup>
								<?php endforeach;?>
								</select>
							</div>
						</div>
					</div>
					<!-- / Invitados a reunión -->
					<div class="row"> 		   		   		
						<div class="col-md-3 col-md-offset-1">
							<div class="form-group">
								<label for="fecha_inicio">* Inicio: </label>
								<input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?=date('Y-m-d')?>" required autocomplete="off">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="hora_inicio">* Hora:</label>
								<input type="text" class="form-control" id="hora_inicio" name="hora_inicio" required autocomplete="off">
							</div>
						</div>	 					
						<div class="col-md-5">
							<div class="checkbox">
								<label>
									<input id="diacompleto" type="checkbox">Todo el día
								</label>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class="col-md-3 col-md-offset-1">
							<div class="form-group">
								<label for="fecha_fin">Fin: </label>
								<input type="text" class="form-control" id="fecha_fin" name="fecha_fin" value="<?=date('Y-m-d')?>" required autocomplete="off">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="hora_fin">Hora:</label>
								<input type="text" class="form-control" id="hora_fin" name="hora_fin" required autocomplete="off">
							</div>
						</div>	
					</div>
					<!-- ---------------------------------------------------------------------- -->
					<div class="row"> 
						<div class="col-md-10 col-md-offset-1">	
							<div class="form-group">
								<label for="descripcion">* Descripción</label>
								<textarea style="overflow:auto;resize:none" class="form-control" rows="4" id="descripcion" name="descripcion" placeholder="Descripción del evento"><?=$post['descripcion']?></textarea>
							</div>
						</div>
					</div>
					<!-- ---------------------------------------------------------------------- -->
					<div class="row">
						<div class="col-md-10 col-md-offset-1">		
							<div class="form-group">
								<button type="reset" class="btn btn-default" value="Reset"><i class="fa fa-times" aria-hidden="true"></i> Restablecer</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<?php if ($ocupados):?>
		<div class="col-md-8">
				<div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
				<?php $cant = count($ocupados); $i = 1?>
				<?php foreach ($ocupados as $ocupado):?>
				 <?="<strong>{$ocupado->name}</strong>"?><?=$i<$cant?($i==$cant-1)?' y ':',':''?>
				<?php $i++;?>
				<?php endforeach;?>
				está/n ocupado/s en la fecha elegida, por favor seleccione otra fecha.</div>
				<div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> 
				En el calendario a continuación se muestran en rojo las fechas ocupadas para los asistentes seleccionados previamente.
				</div>
				<div class="box box-primary">
					<div id="calendar"></div>
				</div>
		</div>
		<?php endif;?>
	</div>
</div>