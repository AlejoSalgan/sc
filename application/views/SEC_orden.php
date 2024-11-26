<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
//Descomentar en todos los IF para quitarles los permisos a Bajada de memoria cuando Mantenimiento vuelva a su curso//
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/adjuntar_archivo.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<script>
$(document).ready(function(){
	var data;
	$('#solicitud').tab('show');
	<?php if (($orden->rm_ultimo_estado==3) AND ((!in_array($roleUser, $isGestion)) AND (!in_array($roleUser, $isCECASIT)))):?>
		$('#fecha_visita').datepicker({language: 'es', format: 'dd/mm/yyyy'});
	<?php endif;?>
	$.post("<?=base_url()?>ordenes/getStatsOrden", {idorden: <?=$orden->rm_id?>})
	.done(function( data ) {
		var ctx = $("#myChart");
		var myChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: JSON.parse(data)
		});
	});
});
</script>

<div class="content-wrapper">
	 <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
     Equipo <?=$orden->rm_serie?>
     <span class="pull-right">
       <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
       <a href="<?=base_url($this->input->get('ref'))."?searchText=".$this->input->get('searchText')?>">Órdenes de trabajo </a> /
			 <span class="text-muted">Orden Nº <?=$orden->rm_id?></span>
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
	 			 <?php
	 			 if ($this->session->flashdata('success')): ?>
	 				 <div class="alert alert-success alert-dismissable">
	 						 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	 						 <?= $this->session->flashdata('success'); ?>
	 				 </div>
	 			 <?php endif; ?>
	 		 </div>
	 	 </div>

	<div class="box">
		<div class="box-body">
			<div>
				<!-- Nav tabs -->
  				<ul class="nav nav-tabs" role="tablist">
					<?php if (!in_array($role, array(60,61,62,63))): ?>
						<li role="presentation" <?= (!in_array($role, array(60,61,62,63))) ? "class='active'" : "" ; ?>><a href="#solicitud" aria-controls="solicitud" role="tab" data-toggle="tab">Orden</a></li>
	          <li role="presentation"><a href="#visitas" aria-controls="visitas" role="tab" data-toggle="tab">Visitas</a></li>
					<?php endif; ?>

					<?php if ($cant_cortes > 0): ?>
						<li role="presentation"><a href="#cortes" aria-controls="visitas" role="tab" data-toggle="tab">Cortes</a></li>
					<?php endif; ?>

					<li <?= (in_array($role, array(60,61,62,63))) ? "class='active'" : "" ; ?> role="presentation"><a href="#eventos" aria-controls="eventos" role="tab" data-toggle="tab">Eventos</a></li>

					<?php if (!in_array($role, array(60,61,62,63))): ?>
							<?php if ($cant_archivos > 0): ?>
								<li role="presentation"><a href="#documentacion" aria-controls="documentacion" role="tab" data-toggle="tab">Documentacion</a></li>
							<?php endif;?>
		          <li role="presentation"><a href="#graficos" aria-controls="graficos" role="tab" data-toggle="tab">Gráficos</a></li>
							<?php if ($imagenes):?>
									<li role="presentation"><a href="#imagenes" aria-controls="imagenes" role="tab" data-toggle="tab">Imágenes</a></li>
							<?php endif;?>
							<?php if ($orden->lat or $orden->ordlong):?>
									<li role="presentation"><a href="#mapa" aria-controls="mapa" role="tab" data-toggle="tab">Mapa</a></li>
							<?php endif;?>
					<?php endif; ?>

				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane <?= (!in_array($role, array(60,61,62,63))) ? "active" : "" ; ?>" id="solicitud">
						<div class="panel panel-primary">
							<div class="panel-heading">Detalle</div>
							<div class="panel-body">
    							<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="rm_id">Orden Nº</label>
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
						<div class="panel panel-primary">
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
						<div class="panel panel-primary">
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
						<div class="panel panel-primary">
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

						<?php if ($orden->rm_ultimo_estado != 8 && $ultima_visita->fecha_visita != NULL):?>
						<form method="post" action="<?=base_url('ordenes/actualizarVisita')?>?ref=<?=$this->input->get('ref')?>&ref2=<?=uri_string()?>&searchText=<?=$this->input->get('searchText')?>">
						<input type="hidden" name="id" value="<?=$orden->rm_id?>">
            <input type="hidden" name="serie" value="<?=$orden->rm_serie?>">
            <input type="hidden" name="id_visita" value="<?= $ultima_visita->id?>">
						<div class="panel panel-primary">
							<div class="panel-heading">Modificar ultima visita</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="fecha_visita">Fecha visita</label>
											<input id="fecha_visita" name="fecha_visita" type="text" class="form-control" value="<?=$ultima_visita->fecha_visita!=''?$this->fechas->cambiaf_a_arg($ultima_visita->fecha_visita):''?>" <?=(($orden->rm_ultimo_estado==3) AND ((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento)) OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))) )?'required':'readonly'?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="conductor">Conductor</label>
											<?php if (($orden->rm_ultimo_estado==3) AND (((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento)) OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
											<select id="conductor" name="conductor" class="form-control" required>
											<option value="" >Seleccione un usuario...</option>
											<?php foreach ($usuarios as $usuario):?>
												<option value="<?=$usuario->userId?>" <?=$usuario->userId==$ultima_visita->conductor?'selected':''?>><?=$usuario->name?></option>
											<?php endforeach;?>
											</select>
											<?php else:?>
											<input id="conductor" name="conductor" type="text" class="form-control" readonly value="<?=$ultima_visita->uv_conductor?>">
											<?php endif;?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="tecnico">Técnico</label>
											<?php if (($orden->rm_ultimo_estado==3) AND (((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento))  OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
											<select id="tecnico" name="tecnico" class="form-control" required>
											<option value="">Seleccione un usuario...</option>
											<?php foreach ($usuarios as $usuario):?>
												<option value="<?=$usuario->userId?>" <?=$usuario->userId==$ultima_visita->tecnico?'selected':''?>><?=$usuario->name?></option>
											<?php endforeach;?>
											</select>
											<?php else:?>
											<input id="tecnico" name="tecnico" type="text" class="form-control" readonly value="<?=$ultima_visita->uv_tecnico?>">
											<?php endif;?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="idflota">Vehículo</label>
											<?php if (($orden->rm_ultimo_estado==3) AND (((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento))  OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
											<select id="idflota" name="idflota" class="form-control" required>
											<option value="">Seleccione un vehículo...</option>
											<?php foreach ($vehiculos as $vehiculo): ?>
												<option value="<?=$vehiculo->id?>" <?=$vehiculo->id==$ultima_visita->idflota?'selected':''?>><?=$vehiculo->dominio?> (<?=$vehiculo->marca?> <?=$vehiculo->modelo?>)</option>
											<?php endforeach;?>
											</select>
											<?php else:?>
											<input id="idflota" name="idflota" type="text" class="form-control" readonly value="<?=$ultima_visita->uv_dominio." ".$ultima_visita->uv_marca." ".$ultima_visita->uv_modelo?>">
											<?php endif;?>
										</div>
									</div>
								</div>

                <div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="observ">Observación</label>
											<?php if (($orden->rm_ultimo_estado==3) AND (((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento))  OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
												<textarea id="ult_observ" name="ult_observ" class="form-control" rows="3" style="resize: none;"><?=$ultima_visita->observacion?></textarea>
											<?php else: ?>
												<textarea id="ult_observ" name="ult_observ" class="form-control" readonly rows="3" style="resize: none;"><?=$ultima_visita->observacion?></textarea>
											<?php endif; ?>

										</div>
									</div>
								</div>


								<?php if (($orden->rm_ultimo_estado==3) AND (((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento)) OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-primary" type="submit">Actualizar visita</button>
									</div>
								</div>
								<?php endif;?>
							</div>
						</div>
						</form>
          <?php endif; ?>


						<?php if (($orden->rm_ultimo_estado == 3 || $orden->rm_ultimo_estado == 11) && (
                ((in_array($roleUser, $isReparacion)) OR (in_array($roleUser, $isAdmin)) OR (in_array($roleUser, $isMantenimiento)) OR (in_array($roleUser, $isBajada)) OR (in_array($roleUser, $isInstalacion))))):?>
						<form method="post" action="<?=base_url('ordenes/agregarObservacion')?>?ref=<?=$this->input->get('ref')?>&searchText=<?=$this->input->get('searchText')?>">
						<input type="hidden" name="rm_id" value="<?=$orden->rm_id?>">
						<input type="hidden" name="rm_ultimo_estado" value="<?=$orden->rm_ultimo_estado?>">
							<div class="panel panel-primary">
							<div class="panel-heading">Observación</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="observ">Añadir Nueva Observación</label>
											<textarea id="observ" name="observ" class="form-control" rows="3" style="resize: none;"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-primary" type="submit">Guardar</button>
									</div>
								</div>
							</div>
						</div>
						</form>
						<?php endif;?>
					</div>

          <div role="tabpanel" class="tab-pane fade" id="visitas">
            <?php if ($ultima_visita->fecha_visita != NULL): ?>
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Conductor</th>
                      <th>Tecnico</th>
                      <th>Vehiculo</th>
                      <th>Observación</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($visitas as $ov_visita): ?>
                    <tr>
                      <td><?=date('d/m/Y',strtotime($ov_visita->fecha_visita))?></td>
                      <td><?= $ov_visita->nameConductor?></td>
                      <td><?= $ov_visita->nameTecnico  ?></td>
                      <td><?= $ov_visita->dominio  ?></td>
                      <td><?= $ov_visita->observacion  ?></td>
                    <?php endforeach; ?>
                      </tr>
                  </tbody>
                </table>
              </div>
            <?php else: ?>

              <table class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <td>No hay visitas programadas para esta orden.</td>
                    </tr>
                </tbody>
              </table>
            <?php endif; ?>

					</div>

					<div role="tabpanel" class="tab-pane fade" id="cortes">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Fecha Desde</th>
                      <th>Fecha Hasta</th>
                      <th>Observación</th>
											<th>Creado por</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($cortes as $corte): ?>
                    <tr>
                      <td><?=date('d/m/Y - H:i:s',strtotime($corte->fecha_desde))?></td>
                      <td><?=date('d/m/Y - H:i:s',strtotime($corte->fecha_hasta))?></td>
                      <td><?= $corte->observacion  ?></td>
                      <td><?= $corte->nameCreador  ?></td>
                    <?php endforeach; ?>
                      </tr>
                  </tbody>
                </table>
              </div>
					</div>

          <div role="tabpanel" class="tab-pane <?= (in_array($role, array(60,61,62,63))) ? "active" : "fade" ; ?>" id="eventos">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr class="info">
										<th>Evento</th>
										<th>Fecha</th>
										<th>Realizado por</th>
										<th>Categoría</th>
										<th>Tiempo transcurrido</th>
										<th>Observación</th>
									</tr>
								</thead>
								<tbody>
								<?php $i = 0; $total = 0;
								foreach ($estados as $estado):
								?>
									<tr>
										<td><?=$estado->ote_descrip?></td>
										<td><?=date('d/m/Y - H:i:s',strtotime($estado->re_fecha))?></td>
										<td><?=$estado->u_name?></td>
										<td><span class="label" style="color: white; background-color: #<?=$estado->rc_color?>;"><?=$estado->rc_descrip?></span></td>
										<td>
										<?php
                          if (isset($estados[$i+1]->re_fecha)) {
                              $fecha_siguiente = $estados[$i+1]->re_fecha;
                          } else {
                              $fecha_siguiente = date('Y-m-d H:i:s');
                          }

                          $diff = strtotime($fecha_siguiente) - strtotime($estado->re_fecha);

                          $dias = floor($diff / 86400);
                          $horas = floor(($diff - $dias * 86400) / 3600);
                          echo $estado->re_tipo != 7 && $estado->re_tipo != 8?"{$dias} días {$horas} horas":"-";
                      ?>
										</td>
										<td><?=trim(ucfirst(strtolower($estado->re_observ)));?></td>
									</tr>
								<?php
								    $i++;
								    if ($estado->re_tipo != 7 && $estado->re_tipo != 8) {
								        $total += $diff;
								    }
								endforeach;
								$dias = floor($total / 86400);
								$horas = floor(($total - $dias * 86400) / 3600);
								?>
								<tr><td></td><td></td><td></td><td></td><td><strong><?="{$dias} días {$horas} horas"?></strong></td><td></td></tr>
								</tbody>
							</table>
						</div>
					</div>


					<div role="tabpanel" class="tab-pane fade" id="documentacion">
							<ul class="products-list product-list-in-box">
									<?php foreach ($archivos as $archivo): ?>
										<li class="item">
											<div class="">
											 <strong> <?="<a href=".base_url("verPersonal/{$archivo->creado_por}").">" . $archivo->name . "</a>"; ?> </strong> <span class="pull-right"><?=date('d/m/Y - H:i:s',strtotime($archivo->fecha_ts))?></span>
												<br>
												<td><?=$archivo->observacion?></td>
												<br>
												<td>
													<form action="<?=base_url('descargar_archivo')?>" method="post">
													 <input type="hidden" name="name" value="<?=$archivo->archivo?>">
													 <input type="hidden" name="tipo" value="<?=$archivo->tipo?>">
													 <input type="hidden" name="direccion" value="<?=uri_string()?>">
													 <input type="hidden" name="ref" value="<?= $this->input->get('ref')?>">
													 <input type="hidden" name="searchText" value="<?= $this->input->get('searchText')?>">
														<?php switch ($archivo->tipo) {
															case '.pdf': ?>
																	<span class="label label-danger">PDF</span>
															<?php break;
															case '.doc':
															case '.docx': ?>
																 <span class="label label-primary">WORD</span>
															<?php break;
															case '.xls':
															case '.xlsx': ?>
																 <span class="label label-success">EXCEL</span>
															<?php break;
																 break;
															default: ?>
																 ERROR
																 <?php break;
															} ?> -
													 <button type="submit" id="descargar" class="link"><span>Descargar archivo</span></button>
													</form>
												</td>
											</div>
										</li>
									<?php endforeach; ?>
							</ul>

					</div>

					<div role="tabpanel" class="tab-pane fade" id="graficos">
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<canvas id="myChart" width="400" height="400"></canvas>
							</div>
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
									    <span class="sr-only">Siguiente  em_geo_lat, em.geo_lon as em_geo_lon</span>
									  </a>
									</div>
							</div>
						</div>
					</div>
					<?php endif;?>
					<div role="tabpanel" class="tab-pane fade" id="mapa">
						<div class="row">
							<div class="col-xs-12">
                                    <div class="box-header">
                                        <div id="map" style="height: 400px; width: 100%;"></div>
                           				<script>

                    					function initMap() {

                    					var finalizada = {lat: <?php echo $orden->lat;?>, lng: <?php echo $orden->ordlong; ?> };

                    					<?php if ($orden->em_geo_lat or $orden->em_geo_lon):?>
                    						var equipo = {lat: <?php echo $orden->em_geo_lat;?>, lng: <?php echo $orden->em_geo_lon;?> };
                    					<?php endif;?>

                    					var map = new google.maps.Map(document.getElementById('map'), {
                    					zoom: 14,
                    					mapTypeControl: false,
                    					draggable: true,
                    					streetViewControl: true,
                    					center: finalizada

                    					});

                    					var icon = {
                    					url: '<?=base_url()?>/assets/images/ordenMantenimiento.png',
                    					scaledSize: new google.maps.Size(36, 40)

                    					};

                     					var icon2 = {
                     					url: '<?=base_url()?>/assets/images/MarcadorEquipoFijo.png',
                            			scaledSize: new google.maps.Size(36, 40)

                            			};

                    					var contentString = '<div id="content">'+
                    					'<div id="infoOrden">'+
                    					'</div>'+
                    					'<div id="bodyContent">'+
                    					'<h3>Orden Nº <b><font color="green"><?=$orden->rm_id?></font></b> finalizada</h3>'
                    					'</div>'+
                    					'</div>';

                    					var contentString2 = '<div id="content2">'+
                    					'<div id="infoOrden2">'+
                    					'</div>'+
                    					'<div id="bodyContent">'+
                    					'<h3><center>Equipo <a href="<?=base_url('verEquipo')?>/<?php echo $orden->em_id?>"><?=$orden->rm_serie?></b></a></center></h3>'+
                    					'</div>'+
                    					'</div>';

                    					var infowindow = new google.maps.InfoWindow({
                    					content: contentString

                    					});

                    					var infowindow2 = new google.maps.InfoWindow({
                        					content: contentString2
                        					});

                    					var marker = new google.maps.Marker({
                    					position: finalizada,
                    					map: map,
                    					icon: icon,
                    					title: 'Orden finalizada'
                    					});

                    					<?php if ($orden->em_geo_lat or $orden->em_geo_lon):?>
                        					var marker2 = new google.maps.Marker({
                            					position: equipo,
                            					map: map,
                            					icon: icon2,
                            					title: '<?=$orden->rm_serie?>'
                            					});
                    					<?php endif;?>

                    					marker.addListener('click', function() {
                        					infowindow.open(map, marker);
                        					});

                    					marker2.addListener('click', function() {
                        					infowindow2.open(map, marker2);

                    					});

                    					}

                    					</script>
                                   </div>
                            </div>
						</div>
					</div>
			</div>
		</div>
    </section>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzSK3DOynZ32kCWi-xTzl2KwK1eksNEak&callback=initMap"></script>
