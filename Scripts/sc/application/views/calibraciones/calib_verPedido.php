<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">


<div class="content-wrapper">
	 <div id="cabecera">
 		Calibraciones - Pedido Nº <?=$pedido->id?>
 		<span class="pull-right">
 			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
 			<a href="<?=base_url('calibraciones_parciales')?>">Calibraciones Parciales</a> /
 		  <span class="text-muted">Ver Pedido</span>
 		</span>
 	</div>

   <section class="content">
     <div class="row">
				 <div class="col-xs-6">
					 <div class="box box-primary">
             <div class="box-header with-border">
               <h3 class="box-title">Información</h3>
             </div>
						 <div class="box-header">
								 <h4><b>Solicitado por:</b> <?="<a href=".base_url("verPersonal/{$pedido->usuario_pedido}").">" . $pedido->namePedido . "</a>"; ?> <span class='pull-right'><b>Fecha:</b> <?=date('d/m/Y - H:i',strtotime($pedido->ts_pedido))?></span></h4>
						 </div>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Cantidad</b> <a class="pull-right"><?=$pedido->cantidad?></a>
									</li>
									<li class="list-group-item">
										<b>Tipo Equipo</b> <span class="pull-right"><?=$pedido->tipoEquipo?></span>
									</li>
									<li class="list-group-item">
										<b>Tipo de Servicio</b> <span class="pull-right"><?=$pedido->tipo_servicio?></span>
									</li>
									<?php if ($pedido->tipo_equipo == 1 || $pedido->tipo_equipo == 2): ?>
										<li class="list-group-item">
											<b>Horario</b> <span class="pull-right">
												<?php switch ($pedido->horario):
												case 'D':?>
													<p>Diurno</p>
												<?php break;
												case 'N':?>
													<p>Nocturno</p>
												<?php break;
													endswitch;?></span>
										</li>
										<li class="list-group-item">
											<b>Distancia</b> <span class="pull-right"><?=$pedido->distancia?></span>
										</li>
									<?php endif; ?>

									<?php if ($pedido->tipo_equipo == 2): ?>
										<li class="list-group-item">
											<b>Nº Carriles</b> <span class="pull-right"><?=$pedido->carriles?></span>
										</li>
									<?php endif; ?>
									<li class="list-group-item">
										<b>Observacion</b><br>
										<?= ($pedido->observacion == NULL) ? 'Sin observaciones.' : $pedido->observacion;?>
									</li>
								</ul>
           </div>
         </div>

				 <div class="col-xs-6">
					 <div class="box box-primary">
             <div class="box-header with-border">
               <h3 class="box-title">Detalle Pedido Compra</h3>
             </div>
						 <div class="box-header">
								 <h4><b>Cargado por:</b> <?="<a href=".base_url("verPersonal/{$pedido->usuario_compra}").">" . $pedido->nameCompra . "</a>"; ?> <span class='pull-right'><b>Fecha:</b> <?=date('d/m/Y - H:i',strtotime($pedido->ts_compra))?></span></h4>
						 </div>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Nº compra</b> <a class="pull-right"><?=$pedido->num_compra?></a>
									</li>
									<li class="list-group-item">
										<b>Presupuesto</b> <span class="pull-right"><?=$pedido->presupuesto?></span>
									</li>
									<li class="list-group-item">
										<b>Nº OT</b> <span class="pull-right"><?=$pedido->num_ot?></span>
									</li>
									<li class="list-group-item">
										<b>Fecha Solicitud OT</b> <span class="pull-right"><?=date('d/m/Y',strtotime($pedido->fecha_ot))?></span>
									</li>
									<li class="list-group-item">
										<b>Observacion</b><br>
										<?= ($pedido->observacion_compra == NULL) ? 'Sin observaciones.' : $pedido->observacion_compra;?>
									</li>
								</ul>
           </div>
         </div>
     </div>

		 <div class="row">
			 <div class="col-md-12">
				 <div class="box box-primary">
					 <div class="box-header with-border">
						 <h3 class="box-title">Parciales asignados</h3>
					 </div>
					 <div class="box-body table-responsive no-padding">
						 <table class="table table-bordered table-hover">
							 <tr class="info">
							 	<th class="text-center">Nº Parcial</th>
								<th class="text-center">Nº Orden</th>
								<th class="text-center">Equipo</th>
								<th class="text-center">Proyecto</th>
							 </tr>
							 <?php foreach ($parciales as $parcial): ?>
							 	<tr>
							 		<td class="text-center"><?=$parcial->num_parcial?></td>
									<td class="text-center"><?="<a href=".base_url("verCalib/{$parcial->num_orden}").">" . $parcial->num_orden . "</a>"; ?> </td>
									<td class="text-center"><?="<a href=".base_url("verEquipo/{$parcial->idequipo}").">" . $parcial->serie . "</a>"; ?> </td>
									<td class="text-center"><?=$parcial->descrip?></td>
							 	</tr>
							 <?php endforeach; ?>
						 </table>
					 </div>
				 </div>
			 </div>
		 </div>
   </section>
 </div>
