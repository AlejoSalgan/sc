<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
// Envíe un encabezado Refresh al navegador actualizando 35 segundos.
header('Refresh: 35');
$aprobar =0;
?>

<style type="text/css">
	a:link,	a:visited {
		color: #4c8cc0;
	}

	a:hover, a:focus,	a:active {
		color: black;
	}

	button {
		overflow: visible;
		width: auto;
	}

	button.link {
		font-family: "Verdana" sans-serif;
		font-size: 1em;
		text-align: left;
		color: #4c8cc0;
		background: none;
		margin: 0;
		padding: 0;
		border: none;
		cursor: pointer;
		-moz-user-select: text;
	}

	button.link:hover span,	button.link:focus span {
		color: black;
	}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/estilo_tablas_2.css'); ?>">

<div class="content-wrapper">
		<div id="cabecera">
	   Ingreso de datos - Proyectos pendientes
	   <span class="pull-right">
	     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
	     <span class="text-muted">Proyectos pendientes</span>
	   </span>
	 </div>

		<section class="content">
			<div class="row">
				<div class="col-lg-6">
					<div class="box box-<?= ($aprobar == 0) ? "success" : "warning" ;?>">
            <div class="box-header with-border">
              <h3 class="box-title">
								<?php if ($aprobar >= 1): ?>
									<span class="text-info"><b><?=$aprobar?></b></span>
									<?php if ($aprobar == 1): ?>
										Orden pendiente para aprobar.
									<?php else: ?>
										Ordenes pendientes para aprobar.
									<?php endif; ?>
								<?php else: ?>
									No hay ordenes pendientes para aprobar.
								<?php endif; ?>
							</h3>
            </div>
          </div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Proyectos pendientes</h3>
						</div>
						<div class="box-body table-responsive no-padding">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr class="info">
										<th class="text-center">Equipos</th>
										<th class="text-center">Proyecto</th>
										<th class="text-center">Fecha de Visita</th>
										<th class="text-center">Cantidad</th>
									</tr>
								</thead>

								<?php foreach ($gruposRecords as $record): ?>
									<tr>
										<td class="text-center"><?= $record->cantidad;?></td>
										<td>
											<form action="<?= base_url('protocolosListing') ?>" method="get">
												<input type="hidden" value="<?= $record->descripProyecto;?>" name="searchText"/>
												<button type="submit" class="link"><span><?= $record->descripProyecto;?></span></button>
											</form>
										</td>
										<td class="text-center"><?= $this->fechas->cambiaf_a_arg($record->fecha_visita);?></td>
										<td class="text-center <?= ($record->cantidadArchivos == 0) ? "text-danger" : '' ;?>"><?= $record->cantidadArchivos;?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title">Modelos pendientes</h3>
						</div>
						<div class="box-body table-responsive no-padding">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr class="info">
										<th class="text-center">Modelo Equipos</th>
										<th class="text-center">Cantidad Equipos</th>
										<th class="text-center">Total de Archivos</th>
										<th class="text-center">Total de Registros</th>
									</tr>
								</thead>
								<!-- Por base de datos no salio el tema de sumar una division tomando su parte entera, SUM(ROUND((SUM(OM.bajada_archivos)/EMOD.divide_x))); en protocolos_model. Asi que hice un sumador, si encontras la solucion traelo por BBDD -->
								<?php $total_registros = 0; ?>
								<?php foreach ($modelos as $modelo): ?>
									<tr>
										<td>
											<form action="<?= base_url('protocolosListing') ?>" method="get">
												<input type="hidden" value="<?= $modelo->modelo_equipo;?>" name="searchText"/>
												<button type="submit" class="link"><span><?= $modelo->modelo_equipo;?></span></button>
											</form>
										</td>

										<td class="text-center"><?= $modelo->cantidad_equipos;?></td>
										<td class="text-center <?= ($modelo->total_archivos == 0) ? "text-danger" : '' ;?>"><?= $modelo->total_archivos;?></td>
										<td class="text-center"><?= ($modelo->registros != NULL) ? $modelo->registros : '<span class="text-danger"><b>-</b></span>' ;?></td>
										<?php $total_registros = $total_registros + $modelo->registros; ?>
									</tr>
								<?php endforeach; ?>
								<tr class="success">
									<td class="text-center"><strong>TOTAL</strong></td>
									<td class="text-center"><strong class="text-primary"><?= $total_modelos->equipos;?></strong></td>
									<td class="text-center"><strong class="text-primary"><?= $total_modelos->archivos;?></strong></td>
									<td class="text-center"><strong class="text-primary"><?= $total_registros;?></strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
</div>
