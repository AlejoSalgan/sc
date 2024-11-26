<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

<?php
		$info              = explode(',', $this->session->flashdata('info'));
		$num_presupuesto   = $info[0];
		$fecha_presupuesto = $info[1];
		$observacion       = $info[2];
?>

<div class="content-wrapper">
	  <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Remito Nº <?= $remitoInfo->num_remito?></h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?=base_url() ?>" class="fa fa-home">Inicio</a></li>
                  <li><a href="<?=base_url('remitos_listado')?>">Remitos listado</a></li>
                  <li class="active">Solicitar Presupuesto</li>
              </ol>
          </div>
      </div>
     </section>

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
                     <h3 class="box-title">Datos del presupuesto</h3>
                 </div><!-- /.box-header -->
								 <div class="box-body">
									 <form action="<?= base_url('guardar_presupuesto')?>" method="POST" enctype="multipart/form-data" name="myForm" data-toggle="validator">
										 <input type="hidden" name="num_remito" value="<?= $remitoInfo->num_remito?>">
										 <input type="hidden" name="id_remito" value="<?= $id_remito?>">
											<div class="row">
													<div class="col-md-6">
                              <div class="form-group">
                              	<label for="remito">Nº Presupuesto</label>
                              	<input type="number" class="form-control required" id="num_presupuesto" name="num_presupuesto" min="1" max="999999" autocomplete="off" placeholder="Maximo hasta 6 digitos" required data-error="Ingresar un numero de presupuesto menor o igual a 6 digitos." value="<?= $num_presupuesto ?>">
                              	<div class="help-block with-errors"></div>
                              </div>
													</div>

													<div class="col-md-6">
															<div class="form-group">
																	<label for="pedido">Fecha presupuesto</label>
																	<input name="fecha_presupuesto" type="text" class="form-control fecha_presupuesto" aria-describedby="fecha" autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required data-error="Seleccionar una fecha de presupuesto." value="<?= $fecha_presupuesto?>">
																	<div class="help-block with-errors"></div>
															</div>
													</div>
											</div><!-- /.row -->

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
																	<textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20" style="resize:none"><?= $observacion ?></textarea>
															</div>
													</div>
											</div><!-- /.row -->

											<div class="box-footer">
													<input type="submit" class="btn btn-primary" value="Guardar" />
													<a href="<?= base_url().'solicitar_presupuesto/'.$id_remito; ?>" class="btn btn-success btn-flat" <?= ($cant_presupuestos > 0) ? "" : "disabled" ?>>Solicitar Presupuesto</a>
											</div>
									 </form>
								 </div>
               </div><!-- /.box -->
             </div>

						 <div class="col-xs-6">
               <div class="box box-primary">
                 <div class="box-header with-border">
                     <h3 class="box-title">Archivos cargados</h3>
                 </div><!-- /.box-header -->

								 <div class="box-body">
									 <div class="table-responsive">
										 <table class="table no-margin">
											 <?php if ($cant_presupuestos > 0): ?>
												 <thead>
												 <tr>
													 <th>Nº Presupuesto</th>
													 <th>Tipo</th>
													 <th>Archivo</th>
													 <th>Acciones</th>
												 </tr>
												 </thead>
												 <tbody>
													 <?php foreach ($presupuestos as $presupuesto): ?>
														 <td><?=$presupuesto->num_presupuesto?></td>
														 <td><?php
														 switch ($presupuesto->tipo) {
														 case '.pdf': ?>
														 		 <span class="text-danger">PDF</span>
														 <?php break;

														 case '.doc':
														 case '.docx': ?>
																<span class="text-primary">WORD</span>
														 <?php break;

														 case '.xls':
														 case '.xlsx': ?>
														 		<span class="text-success">EXCEL</span>
														 <?php break;

														 	default: ?>
														 		ERROR
														 <?php break;
														 } ?>

														 </td>
														 <td><?=$presupuesto->archivo?></td>
														 <td>
															 <a data-toggle="modal" title="Detalle del presupuesto" data-target="#modalInfo<?= $presupuesto->num_presupuesto; $presupuesto->fecha_presupuesto; $presupuesto->observacion ?>" ><i class="fa fa-info-circle"></i> &nbsp;&nbsp;&nbsp;</a>
                                   <!-- sample modal content -->
                                   <div id="modalInfo<?= $presupuesto->num_presupuesto; $presupuesto->fecha_presupuesto; $presupuesto->observacion ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                   <h4 class="modal-title" id="myModalLabel">Presupuesto Nº <?= $presupuesto->num_presupuesto ?></h4>
                                               </div>

                                               <div class="modal-body">
                                                   <div class="form-group">
																										 	<p><b>Fecha de Presupuesto:</b>
																												<?=date('d/m/Y',strtotime($presupuesto->fecha_presupuesto))?> </p>
																											<p><b>Observaciones:</b></p>
																											<p><?= $presupuesto->observacion ?></p>
                                                   </div>
                                               </div>
                                               <div class="modal-footer">
                                                   <button type="button" class="btn btn-info btn-rounded" data-dismiss="modal">Aceptar</button>
                                               </div>
                                           </div>
                                           <!-- /.modal-content -->
                                       </div>
                                       <!-- /.modal-dialog -->
                                   </div>
                                   <!-- /.modal -->

																<a data-toggle="tooltip" title="Borrar Archivo" href="<?= base_url().'eliminar_presupuesto/'.$presupuesto->id; ?>"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;</a>
															 </td>
														 </tr>
													 <?php endforeach; ?>
												 </tbody>
											 <?php else: ?>
												 <span>No hay presupuestos cargados.</span>
											 <?php endif; ?>
										 </table>
									 </div>
									 <!-- /.table-responsive -->
								 </div><!-- /.box-header -->
               </div><!-- /.box -->
             </div>
         </div>
     </section>
 </div>

 <script>
     $(function() {
       $('.fecha_presupuesto').datepicker({
         format: 'dd-mm-yyyy',
         language: 'es'
       });
     });

		 $(function () {
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      $('[data-mask]').inputmask()
    })

 </script>
