<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/adjuntar_archivo.css'); ?>">

<div class="content-wrapper">
	<div id="cabecera">
		Equipo <?=$serie?>
		<span class="pull-right">
			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
			<a href="<?=base_url($this->input->get('ref'))."?searchText=".$this->input->get('searchText')?>">Órdenes de trabajo </a> /
		  <span class="text-muted">Adjuntar Archivo</span>
		</span>
	</div>

	 <section class="content">
		 <div class="row">
			 <div class="col-md-12">
				 <div class="callout callout-info">
					 <h4>Guardar: Permite guardar los archivos para continuar mas tarde o seguir agregando antes de ser subido al sistema.</h4>
				 </div>
			 </div>
			 <div class="col-md-12">
				 <div class="callout callout-success">
					 <h4>Cargar Archivos: Permite confirmar que los archivos precargados esten listos para que sean visibles en Ver Orden.</h4>
				 </div>
			 </div>
		 </div>

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

			 <div class="row">
           <div class="col-xs-6">
             <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title">Datos del archivo</h3>
               </div><!-- /.box-header -->
							 <form action="<?= base_url('guardar_archivo')?>" method="POST" enctype="multipart/form-data" name="myForm" data-toggle="validator">
								 	<input type="hidden" name="id_orden" value="<?= $id_orden?>">
									<input type="hidden" name="ref" value="<?= $this->input->get('ref')?>">
									<input type="hidden" name="searchText" value="<?= $this->input->get('searchText')?>">
								 	<div class="box-body">
											<div class="row">
													<div class="col-md-12">
															<div class="form-group">
																	<label for="ordencompra">Archivo adjunto</label>
																	<input type="file" class="form-control-file" id="archivo" aria-describedby="fileHelp" name="archivo">
																	<p class="help-block">Solo archivos PDF, WORD o EXCEL.</p>
																	<p class="help-block">Solo archivos menor o igual a 1MB.</p>
															</div>
													</div>
											</div><!-- /.row -->
											<div class="row">
													<div class="col-md-12">
															<div class="form-group">
																	<label for="observ">Observaciones</label>
																	<textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20" style="resize:none"><?=$this->session->flashdata('info')?></textarea>
															</div>
													</div>
											</div><!-- /.row -->
								 </div>
								 	<div class="box-footer">
										 <input type="submit" class="btn btn-primary" value="Guardar" />
										 <a href="<?=base_url("cargar_archivo/{$id_orden}?ref={$this->input->get('ref')}&searchText={$this->input->get('searchText')}")?>" class="btn btn-success btn-flat" <?= ($cant_archivos > 0) ? "" : "disabled" ?>>Cargar Archivos</a>
								 	</div>
						 		</form>
             </div><!-- /.box -->
           </div>

					 <div class="col-xs-6">
             <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title">Archivos cargados </h3>
               </div><!-- /.box-header -->
							 <div class="box-body">
								 <ul class="products-list product-list-in-box">
									 <?php if ($cant_archivos > 0): ?>
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
 															<input type="hidden" name="id_orden" value="<?= $id_orden?>">
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
															<button type="submit" id="descargar" class="link"><span>Descargar archivo</span></button> -
															<a id="eliminar_archivo" href="<?=base_url("eliminar_archivo/{$archivo->id}?ref={$this->input->get('ref')}&searchText={$this->input->get('searchText')}&orden={$id_orden}")?>">Eliminar archivo</a>
														 </form>
													 </td>
												 </div>
											 </li>
										 <?php endforeach; ?>
									 <?php else: ?>
										 <p>No hay archivos para esta orden.</p>
									 <?php endif; ?>
								 </ul>
							 </div>
             </div><!-- /.box -->
           </div>
       </div>
   </section>
 </div>
