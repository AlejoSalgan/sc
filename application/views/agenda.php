<script>
$( document ).ready(function() {
	$('#calendar').fullCalendar({
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		header    : {
			left  : 'prev,next today',
			center: 'title',
			right : 'month,agendaWeek,agendaDay'
		},
		businessHours: {
		    // days of week. an array of zero-based day of week integers (0=Sunday)
		    dow: [ 1, 2, 3, 4, 5 ], // Monday - Friday
		    start: '9:00', // a start time (9am in this example)
		    end: '18:00', // an end time (6pm in this example)
		},
		eventSources: [
			{
				url: "<?=base_url('agenda/eventos')?>",
				type: "POST",
				data: {
					userId: <?=$userId?>
				},
				error: function(data) {
	                alert('Hubo un error al obtener los eventos');
	            }
			}
		]
    });
});
</script>
<div class="content-wrapper">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<?php $success = $this->session->flashdata('success');
				if($success): ?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?=$success?>
					</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Referencia</h3>
				</div>
				<div class="panel-body">
					<span class="label" style="background-color: #00a65a;">Reunión confirmada</span>
					<span class="label" style="background-color: #f39c12;">Reunión a confirmar</span>
					<span class="label" style="background-color: #f56954;">Reunión cancelada</span>
					<?php for ($i = 1; $i < count($tiposeventos); $i++):?>
						<span class="label" style="background-color: #<?=$tiposeventos[$i]->color?>;"><?=$tiposeventos[$i]->descrip?></span>
					<?php endfor;?>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="box box-primary">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
</div>