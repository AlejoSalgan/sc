<script>
	$(document).ready(function(){
		$("button.rechazar").click(function(){
		    $("#evento").val($(this).prev('input').val());
		});
	});
</script>
<div id="rechazar" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="post" action="<?=base_url('agenda-invitaciones')?>">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">¿Confirma su no asistencia?</h4>
			</div>
			<div class="modal-body">

				<label for="razon">Ingrese el motivo por el que no asistirá:</label>
				<textarea name="razon" class="form-control" rows="3" style="resize: none;" required></textarea>
			</div>
			<div class="modal-footer">
				<input id="evento" type="hidden" name="evento" value="<?=$invitacion->evento?>">
				<input type="hidden" name="confirmo" value="2">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="confirmar" type="submit" class="btn btn-danger">Confirmar no asistencia</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>Eventos de agenda<small>Invitaciones a reuniones</small></h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<?php if (!$invitaciones):?>
				<div class="alert alert-info" role="alert">No tiene invitaciones a ninguna reunión</div>
				<?php else:?>
				<ul class="list-group">
					<?php foreach ($invitaciones as $invitacion):?>
						<?php if ($invitacion->confirmo == 0):?>
							<div class="list-group-item list-group-item-warning">
								<h4 class="list-group-item-heading"><?=$invitacion->nombre?><?=$invitacion->ubicacion?' en '.$invitacion->ubicacion:''?> - creado por <?=$invitacion->name?></h4>
								<h5 class="list-group-item-heading">Desde <?=date('d/m/Y H:i:s',strtotime($invitacion->fecha_inicio))?><?=$invitacion->fecha_fin?' hasta '.date('d/m/Y H:i:s',strtotime($invitacion->fecha_fin)):''?></h5>
								<span class="list-group-item-text"><?=$invitacion->descripcion?></span>
								<span class="pull-right">
									<div class="btn-group" role="group">
										<form class="form-inline pull-left" method="post" action="<?=base_url('agenda-invitaciones')?>">
											<input type="hidden" name="evento" value="<?=$invitacion->evento?>">
											<input type="hidden" name="confirmo" value="1">
											<button type="submit" class="btn btn-sm btn-success">
												<i class="fa fa-calendar-check-o"> Asistiré</i>
											</button>
										</form>
										<input type="hidden" name="evento" value="<?=$invitacion->evento?>">
										<button type="submit" class="btn btn-sm btn-danger rechazar" data-toggle="modal" data-target="#rechazar">
											<i class="fa fa-calendar-times-o"> No asistiré</i>
										</button>
									</div>
								</span>
								<p></p>
							</div>
						<?php elseif ($invitacion->confirmo == 1):?>
							<div class="list-group-item list-group-item-success clearfix">
								<h4 class="list-group-item-heading"><?=$invitacion->nombre?><?=$invitacion->ubicacion?' en '.$invitacion->ubicacion:''?> - creado por <?=$invitacion->name?></h4>
								<h5 class="list-group-item-heading">Desde <?=date('d/m/Y H:i:s',strtotime($invitacion->fecha_inicio))?><?=$invitacion->fecha_fin?' hasta '.date('d/m/Y H:i:s',strtotime($invitacion->fecha_fin)):''?></h5>
								<span class="list-group-item-text"><?=$invitacion->descripcion?></span>
								<span class="pull-right">
									<input type="hidden" name="evento" value="<?=$invitacion->evento?>">
									<button type="submit" class="btn btn-sm btn-danger rechazar" data-toggle="modal" data-target="#rechazar">
										<i class="fa fa-calendar-times-o"> No asistiré</i>
									</button>
								</span>
								<p></p>
							</div>
						<?php elseif ($invitacion->confirmo == 2):?>
							<div class="list-group-item list-group-item-danger clearfix">
								<h4 class="list-group-item-heading"><?=$invitacion->nombre?><?=$invitacion->ubicacion?' en '.$invitacion->ubicacion:''?> - creado por <?=$invitacion->name?></h4>
								<h5 class="list-group-item-heading">Desde <?=date('d/m/Y H:i:s',strtotime($invitacion->fecha_inicio))?><?=$invitacion->fecha_fin?' hasta '.date('d/m/Y H:i:s',strtotime($invitacion->fecha_fin)):''?></h5>
								<div class="list-group-item-text"><?=$invitacion->descripcion?></div>
								<span class="list-group-item-text">Ud. no asistirá por el motivo: <em><?=$invitacion->razon?></em></span>
								<span class="pull-right">
									<form class="form-inline pull-left" method="post" action="<?=base_url('agenda-invitaciones')?>">
										<input type="hidden" name="evento" value="<?=$invitacion->evento?>">
										<input type="hidden" name="confirmo" value="1">
										<button type="submit" class="btn btn-sm btn-success">
											<i class="fa fa-calendar-check-o"> Asistiré</i>
										</button>
									</form>
								</span>
								<p></p>
							</div>
						<?php endif;?>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
			</div>
		</div>
	</section>
</div>