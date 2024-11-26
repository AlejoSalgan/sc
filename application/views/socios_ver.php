<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
		 <div id="cabecera">
       Socios - Remito Nº <?= $remitoInfo->num_remito?>
       <span class="pull-right">
         <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
         <a href="<?= base_url('remitos_listado'); ?>"> Remitos listado</a> /
         <span class="text-muted">Ver Remito</span>
       </span>
     </div>

     <section class="content">
			 <div class="row">
				 <div class="col-md-12">
					 <div class="box box-primary">
						 <div class="box-header with-border">
							 <h3 class="box-title">
								 Estado: <?= $remitoInfo->tipo_estado ?>
							 </h3>
						</div>
					 </div>
				 </div>
			 </div>

         <div class="row">
						 <div class="col-xs-6">
							 <div class="box box-primary">
		             <div class="box-header with-border">
		               <h3 class="box-title">Información</h3>
		             </div>
										<ul class="list-group list-group-unbordered">
											<li class="list-group-item">
												<b>Equipo</b> <a class="pull-right"><?=$remitoInfo->serie?></a>
											</li>
											<li class="list-group-item">
												<b>Proyecto</b> <span class="pull-right"><?=$remitoInfo->descrip?></span>
											</li>
											<?php if ($remitoInfo->fecha_ingreso): ?>
												<li class="list-group-item">
													<b>Fecha Ingreso</b> <span class="pull-right"><?=date('d/m/Y',strtotime($remitoInfo->fecha_ingreso))?></span>
												</li>
											<?php endif; ?>
											<?php if ($remitoInfo->nameCreadoPor): ?>
												<li class="list-group-item">
													<b>Aceptado por</b> <span class="pull-right"><?=$remitoInfo->nameCreadoPor?></span>
												</li>
											<?php endif; ?>


										</ul>
		           </div>
	           </div>
         </div>

				 <?php if ($observaciones): ?>
					 <div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title">Eventos</h3>
							 </div>
								 <div class="box-body table-responsive no-padding">
								 <table class="table table-bordered table-hover">
									 <tr class="info">
										 <th class="text-center">Usuario</th>
										 <th class="text-center">Observaciones</th>
										 <th class="text-center">Fecha</th>
									 </tr>
									 <?php foreach ($observaciones as $observacion): ?>
										 <tr>
											 <td class="text-center text-primary"><?=$observacion->name?></td>
											 <td><span class='text-muted'><?=trim(ucfirst(strtolower($observacion->observacion)));?></span></td>
											 <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($observacion->fecha))?></td>
										 </tr>
									 <?php endforeach; ?>
								 </table>
							 </div>
							 </div>
						 </div>
					 </div>
				 <?php endif; ?>


				 <?php if ($reparaciones): ?>
					 <div class="row">
  	         <div class="col-md-12">
  	           <div class="box box-primary">
  	             <div class="box-header with-border">
  	               <h3 class="box-title">Eventos Reparaciones</h3>
  	            </div>
  	            	<div class="box-body table-responsive no-padding">
  	              <table class="table table-bordered table-hover">
  	                <tr class="info">
  	                  <th class="text-center">Usuario</th>
  	                  <th class="text-center">Observaciones</th>
  	                  <th class="text-center">Fecha</th>
  	                </tr>
  	                <?php foreach ($reparaciones as $reparacion): ?>
  	                  <tr>
  	                    <td class="text-center text-primary"><?=$reparacion->u_name?></td>
  	                    <td><span class='text-muted'><?=trim(ucfirst(strtolower($reparacion->re_observ)));?></span></td>
  	                    <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($reparacion->re_fecha))?></td>
  	                  </tr>
  	                <?php endforeach; ?>
  	              </table>
  	            </div>
  	         		</div>
  	       		</div>
  					</div>
				 <?php endif; ?>
     </section>
 </div>
