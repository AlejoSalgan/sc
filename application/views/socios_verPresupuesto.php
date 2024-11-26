<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

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

<div class="content-wrapper">
		 <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
       Remito Nº <?= $remitoInfo->num_remito?>
       <span class="pull-right">
         <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
         <a href="<?=base_url('remitos_listado')?>">Remitos listado</a> /
         <span class="text-muted">Ver Presupuesto</span>
       </span>
     </div>

		 <section class="content">
				 <div class="row">
					 <div class="col-md-12">
								 <?php
										 $this->load->helper('form');
										 $error = $this->session->flashdata('error');
										 if ($error): ?>
											 <div class="alert alert-danger alert-dismissable">
													 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													 <?= $this->session->flashdata('error'); ?>
											 </div>
										 <?php endif; ?>
								 <?php
								 $success = $this->session->flashdata('success');
								 if ($success): ?>
									 <div class="alert alert-success alert-dismissable">
											 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											 <?= $this->session->flashdata('success'); ?>
									 </div>
								 <?php endif; ?>
							 <div class="row">
									 <div class="col-md-12">
											 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
									 </div>
							 </div>
					 </div>
				 </div>

         <div class="row">
             <div class="col-xs-6">
               <div class="box box-primary">
                 <div class="box-header with-border">
                     <h3 class="box-title">Agregar observacion</h3>
                 </div><!-- /.box-header -->
								 <form class="form" action="<?= base_url('aprobar_presupuesto'); ?>" method="post">
									 <div class="box-body">
											 <input type="hidden" name="id_remito" value="<?= $id_remito?>">
												 <div class="row">
														 <div class="col-md-12">
																 <div class="form-group">
																		 <label for="observ">Observaciones</label>
																		 <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20" autofocus tyle="resize:none"></textarea>
																 </div>
														 </div>
												 </div><!-- /.row -->
									 </div><!-- /.box-header -->
									 <div class="box-footer">
											 <input type="submit" class="btn btn-success" name="aprobar" value="Aprobar presupuesto" />
											 <input type="submit" class="btn btn-danger" name="aprobar" value="Desaprobar presupuesto" />
									 </div>
								 </form>
               </div><!-- /.box -->
             </div>

						 <div class="col-xs-6">
							 <div class="box box-primary">
								 <div class="box-header with-border">
									 <h3 class="box-title">Datos del presupuesto</h3>
								 </div>
								 <!-- /.box-header -->
								 <div class="box-body">
									 <ul class="products-list product-list-in-box">
										 <?php foreach ($presupuestos as $presupuesto): ?>
											 <li class="item">
												 <div class="">
													<strong>Nº Presupuesto: </strong><a href="javascript:void(0)" class="product-title"> <?=$presupuesto->num_presupuesto?></a> <span class="pull-right"><?=date('d/m/Y',strtotime($presupuesto->fecha_presupuesto))?></span>
													 <br>
													 <td><?=$presupuesto->observacion?></td>
													 <br>
													 <td>
														 <form action="<?=base_url('descargar_presupuesto')?>" method="post">
														 <?php switch ($presupuesto->tipo) {
															 case '.pdf': ?>
															 		 <span class="label label-danger">PDF</span>
															     <?php
																	 $tipo = "application/pdf";
																	 break;
															 case '.doc':
															 case '.docx': ?>
																	<span class="label label-primary">WORD</span>
															    <?php
																	$tipo = "application/msword";
																	break;
															 case '.xls':
															 case '.xlsx': ?>
																	<span class="label label-success">EXCEL</span>
															    <?php
																	$tipo = "application/vnd.ms-excel";
																	break;
															 default: ?>
															 		ERROR
															    <?php break;
															 } ?>
														  -	<button type="submit" class="link"><span>Descargar archivo</span></button>
															<input type="hidden" name="name" value="<?=$presupuesto->archivo?>">
															<input type="hidden" name="tipo" value="<?=$presupuesto->tipo?>">
															<input type="hidden" name="id" value="<?=$this->uri->segment(2);?>">
															</form>
														</td>
												 </div>
											 </li>
										 <?php endforeach; ?>
									 </ul>
								 </div>
								 <!-- /.box-body -->
							 </div>
						 </div>
         </div>
     </section>
 </div>
