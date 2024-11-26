<script>
$(document).ready(function(){
	$('#solicitud').tab('show');
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Equipo <?=$orden->rm_serie?></h4>
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?=base_url()?>"><i class="fa fa-home"></i> Inicio </a></li>
                  <li><a href="<?=base_url(strtolower($titulo).'/solicitudes')?>"><?=$titulo?> Solicitudes</a></li>
                  <li class="active">Solicitud Nº <?=$orden->rm_id?></li>
                </ol>
            </div>
        </div>
       </section>
    <section class="content">
	<div class="box">
		<div class="box-body">
			<div>
				<!-- Nav tabs -->
  				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#solicitud" aria-controls="solicitud" role="tab" data-toggle="tab">Solicitud</a></li>
					<li role="presentation"><a href="#eventos" aria-controls="eventos" role="tab" data-toggle="tab">Eventos</a></li>
					<?php if ($imagenes):?>
					<li role="presentation"><a href="#imagenes" aria-controls="imagenes" role="tab" data-toggle="tab">Imágenes</a></li>
					<?php endif;?>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="solicitud">
						<div class="panel panel-default">
							<div class="panel-body">
    							<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="rm_id">Solicitud Nº</label>
											<input id="rm_id" type="text" class="form-control" value="<?=$orden->rm_id?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="ote_descrip">Estado</label>
											<input id="ote_descrip" type="text" class="form-control" value="<?=$orden->ote_descrip?>" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">Equipo</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="rm_serie">Código de equipo</label>
											<input id="rm_serie" type="text" class="form-control" value="<?=$orden->rm_serie?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="ema_descrip">Fabricante</label>
											<input id="ema_descrip" type="text" class="form-control" value="<?=$orden->ema_descrip?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="emo_descrip">Modelo</label>
											<input id="emo_descrip" type="text" class="form-control" value="<?=$orden->emo_descrip?>" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="em_ubicacion_calle">Ubicación</label>
											<input id="em_ubicacion_calle" type="text" class="form-control" value="<?=$orden->em_ubicacion_calle?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="fm_descrip">Tipo de problema</label>
											<input id="fm_descrip" type="text" class="form-control" value="<?=$orden->fm_descrip?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="mo_descrip">Motivo del problema</label>
											<input id="mo_descrip" type="text" class="form-control" value="<?=$orden->mo_descrip?>" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">Solicitado por</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="u_name">Solicitado por</label>
											<input id="u_name" type="text" class="form-control" value="<?=$orden->u_name?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="r_role">Sector</label>
											<input id="r_role" type="text" class="form-control" value="<?=$orden->r_role?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="p_descrip">Puesto</label>
											<input id="p_descrip" type="text" class="form-control" value="<?=$orden->p_descrip?>" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="u_mobile">Teléfono</label>
											<input id="u_mobile" type="text" class="form-control" value="<?=$orden->u_mobile?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="u_email">E-mail</label>
											<input id="u_email" type="text" class="form-control" value="<?=$orden->u_email?>" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">Proyecto</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="mu_descrip">Proyecto</label>
											<input id="mu_descrip" type="text" class="form-control" value="<?=$orden->mu_descrip?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="ue_name">Gestionado por</label>
											<input id="ue_name" type="text" class="form-control" value="<?=$orden->ue_name?>" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="eventos">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Evento</th>
										<th>Fecha</th>
										<th>Realizado por</th>
										<th>Observación</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($estados as $estado):?>
									<tr>
										<td><?=$estado->ote_descrip?></td>
										<td><?=date('d/m/Y H:i:s',strtotime($estado->re_fecha))?></td>
										<td><?=$estado->u_name?></td>
										<td><?=$estado->re_observ?></td>
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
					<?php if ($imagenes):?>
					<div role="tabpanel" class="tab-pane fade" id="imagenes">
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								  <!-- Indicators -->
								  <ol class="carousel-indicators">
		  							<?php $cant = count($imagenes);
		  							for ($i = 0; $i < $cant; $i++):?>
								    <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" <?=($i == 0)?'class="active"':''?>></li>
								    <?php endfor;?>
								  </ol>

								  <!-- Wrapper for slides -->
								  <div class="carousel-inner" role="listbox">
									<?php $i = 1; foreach ($imagenes as $imagen):?>
								    <div class="item <?=($i == 1)?'active':''?>">
								      <img class="img-responsive center-block" src="<?=base_url()."img_reportes/{$imagen->nombre_archivo}"?>" alt="imagen<?=$i?>">
								      <div class="carousel-caption">
								        Imagen <?=$i?>
								      </div>
								    </div>
									<?php $i++; endforeach;?>
								  </div>

								  <!-- Controls -->
								  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
								    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								    <span class="sr-only">Previa</span>
								  </a>
								  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
								    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								    <span class="sr-only">Siguiente</span>
								  </a>
								</div>
							</div>
						</div>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
    </section>
</div>
