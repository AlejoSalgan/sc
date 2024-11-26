<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
		<div id="cabecera">
	    <?=$titulo?> - <?=$subtitulo?>
	    <span class="pull-right">
	      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
	      <span class="text-muted"><?=$titulo." ".$subtitulo?></span>
	    </span>
	  </div>

		<section class="content">
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="box-header">
							<h1 class="box-title"></h1>
							<div class="box-tools">
									<form action="<?php echo base_url() ?>reportes-desestimados" method="get">
											<div class="input-group">
												<input type="text" name="search" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
												<div class="input-group-btn">
													<button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
												</div>
											</div>
									</form>
							</div>
						</div>

						<div class="box-body table-responsive no-padding">
							<table class="table table-bordered table-hover">
								<thead>
									<tr class="info">
										<th>Equipo</th><th>Proyecto</th><th>Fecha</th><th>Tipo de falla</th><th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($ordenes as $orden):?>
									<tr>
										<td><?php echo "<a href=".base_url("verEquipo/{$orden->em_id}").">" . $orden->rm_serie . "</a>"; ?></td><td><?=$orden->mu_descrip?></td><td><?=date('d/m/Y H:i:s',strtotime($orden->re_fecha))?></td><td><?=$orden->fm_descrip?></td><td><a data-toggle="tooltip" title="Ver" href="<?=base_url("ver-desestimado/{$orden->rm_id}")?>"><i class="fa fa-info-circle"></i></a></td>
									</tr>
								<?php endforeach;?>
								</tbody>
			  			</table>
						</div>

						<div class="box-footer clearfix">
								<?= $this->pagination->create_links(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>

</div>
