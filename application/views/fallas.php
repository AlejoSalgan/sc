<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$NOVnovedades = explode(',', $novedades_novedades); //Los permisos para cada boton.
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }

  .etiqueta13{
    font-size: 13px;
  }
</style>

<script>
$(document).ready(function () {
	$('input:checkbox').prop('checked',false);

	$("#selectall").change(function () {
	    $('input:checkbox').not(this).prop('checked', this.checked);
		if ($('#form input[type=checkbox]:checked').length) {
			$(".enviar").prop("disabled",false);
		} else {
			$(".enviar").prop("disabled",true);
		}
	});

	$("#repa").click(function(){
		$(".repa").show();
		$("#sector").val("R");
		$("#myModalLabel").html('¿Desea enviar a reparaciones?');
		$("#modalbutton").html('Confirmar envío a reparaciones');
		$("#form").attr("action","<?=base_url('ordenes/altasolicitud')?>");
 	});

	$("#mant").click(function(){
		$(".repa").hide();
		$("#sector").val("M");
		$("#myModalLabel").html('¿Desea enviar a mantenimiento?');
		$("#modalbutton").html('Confirmar envío a mantenimiento');
		$("#form").attr("action","<?=base_url('ordenes/altasolicitud')?>");
 	});

	$("#modalbutton").click(function() {
		    if($('#observ').val().length < 50){
		       e.preventdefault();
		    }
		$("#form").submit();
	});

	$('tr').click(function(event) {
		if ($('#form input[type=checkbox]:checked').length) {
			$(".enviar").prop("disabled",false);
		} else {
			$(".enviar").prop("disabled",true);
		}
	    if ((event.target.type !== 'checkbox') && (event.target.tagName.toLowerCase() !== 'i')) {
			$(':checkbox', this).trigger('click');
	    }
	});

	$(".desest").click(function() {
		$('#observ').attr('placeholder', 'Explique por que desestima la falla');
		$("#rchars").show();
		$("#lblRchars").show();

		$(".repa").hide();
		$("#myModalLabel").html('¿Desea desestimar el reporte?');
		$("#modalbutton").html('Confirmar desestimación del reporte');
		$("#form").attr("action","<?=base_url('ordenes/desestimarReporte')?>");
		$("#idreporte").val($(this).data("id"));
		$('#myModal').modal('show');
	});

	$("#searchbutton").click(function() {
		$("#form").attr("action","<?=base_url('fallas')?>");
		$("#form").attr("method","get");
		$("#sector").remove();
		$("#idreporte").remove();
		$("#observ").remove();
		$("#ref").remove();
		$("input:checkbox").remove();
		$("#form").submit();
	});

	$("#search").keypress(function(evento) {
		if(evento.which == 13) {
			evento.preventDefault();
			$("#searchbutton").click();
		}
	});

	var maxLength = 50;
	var textlen = 1;
		$('#observ').keypress(function(event) {
	        if (event.keyCode == 13) {
	            event.preventDefault();
	        }else{
	        	$('#observ').keyup(function() {
    	        	var textlen = maxLength - $(this).val().length;
    				if(textlen > 0){
    					$('#rchars').text(textlen);
    					$('#lblRchars').html(' Caracteres restantes');
    					$('#modalbutton').attr('disabled','disabled');
    				}else{
    					$('#modalbutton').removeAttr('disabled');
    					$('#rchars').text(0);
    					$('#lblRchars').html(' Observaci�n lista para enviar!');
    					$('#rchars').html(' ');
    				}
				});
	        }
	    });
});
</script>

<form id="form" action="" method="post">
<input id="sector" name="sector" type="hidden" value="">
<input id="idreporte" name="idreporte" type="hidden" value="">
<input id="ref" name="ref" type="hidden" value="<?=$search?>">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
		<div class="form-group repa">
      		<label for="operativo">¿Continuar bajadas durante la reparación?</label>
        	<input id="operativo" name="operativo" type="checkbox" class="form-control" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
		</div>
      	<div class="form-group">
      		<label for="observ">Ingrese una observaci�n:</label>
			<textarea style="resize: none;" id="observ" name="observ" class="form-control" rows="3"></textarea>
			<div class="form-group">
				<span id="rchars">50</span><span id="lblRchars"> Caracteres restantes</span>
			</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="modalbutton" type="button" class="btn btn-primary"></button>
      </div>
    </div>
  </div>
</div>


<div class="content-wrapper">
  <div id="cabecera">
   Novedades
   <span class="pull-right">
     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
     <span class="text-muted">Novedades</span>
   </span>
 </div>

    <section class="content">
			<div class="row">
		 	 <div class="col-md-12 text-right btn-toolbar">
		 		 <?php if ($NOVnovedades[0] == 1) { ?>
		 							 <button data-toggle="modal" data-target="#myModal" id="repa" type="button" class="btn inline btn-primary enviar btn-labeled" disabled><span class="btn-label"><i class="fa fa-wrench"></i></span>Enviar seleccionados a Reparaciones</button>
		 						 <?php }?>
		 						 <?php if ($NOVnovedades[1] == 1) { ?>
		 			 <button data-toggle="modal" data-target="#myModal" id="mant" type="button" class="btn inline btn-primary enviar btn-labeled" disabled><span class="btn-label"><i class="fa fa-check-square-o"></i></span>Enviar seleccionados a Mantenimiento</button>
		 		 <?php }?>
		 						 <?php if ($NOVnovedades[4] == 1) { ?>
									 <a class="btn btn-labeled btn-primary" href="<?=base_url('alta_novedad')?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Nuevo Reporte</a>
		 		 <?php }?>
		 	 </div>
		  </div>

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h1 class="box-title">
							</h1>

							<div class="box-tools">
										<div class="input-group">
											<input id="search" type="text" name="search" value="<?=$search?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar . . ."/>
											<div class="input-group-btn">
												<button id="searchbutton" type="button" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
											</div>
										</div>
								</div>
						</div>

						<div class="box-body table-responsive no-padding">
							<table class="table table-bordered table-striped table-hover">
		        				<thead>
		        					<tr class="info">
		        					<th class="text-center">
		        						<?php if ($NOVnovedades[2] == 1) { ?>
		        							<input type="checkbox" id="selectall" name="selectall">
		        						<?php }?>
		        					</th>
									<th class="text-center">N° Orden</th>
		        						<th>Equipo</th>
												<th>Gestor</th>
												<th width="225px">Tipo de falla y observación</th>
												<th>Motivo</th>
												<th>Reportado por</th>
												<th>Fecha</th>
												<th>Acciones</th>
		        					</tr>
		        				</thead>

							<tbody>
							<?php foreach ($fallas as $falla):?>
								<tr <?=in_array($falla->rm_serie,$repetidas)?'class="danger"':''?>>
									<td class="text-center">
										<?php if ($NOVnovedades[2] == 1) { ?>
										<input type="checkbox" name="id[]" value="<?=$falla->rm_id?>">
										<?php }?>
									</td>
									

									
									<td class="text-center"><span class="label label-primary etiqueta14"><?=$falla->rm_id ?></span></td>
								
									<td><?= "<a href=".base_url("verEquipo/{$falla->em_id}").">" . $falla->rm_serie . "</a>"; ?><br>
										<span class="text-muted"><small><?= ($falla->mu_descrip == "") ? "<spam class=\"text-info\">A designar</spam>" : $falla->mu_descrip ?></small></span></td>
									<td><?= ($falla->gestor_name) ? $falla->gestor_name : "Este proyecto no tiene asignado un gestor" ;?></td>
									<td><strong><?=$falla->fm_descrip?></strong><br>
										<span class=text-muted><?= ucfirst(strtolower($falla->obs_primeraFalla))?></span>

									</td>
									<td><?=$falla->mo_descrip?></td>
									<td><?="<a href=".base_url("verPersonal/{$falla->u_id}").">" . $falla->u_name . "</a>"; ?></td>
									<td><?=date('d/m/Y - H:i',strtotime($falla->re_fecha))?><br>
										<?php
										$date1 = new DateTime($falla->re_fecha);
										$date2 = new DateTime("now");
										$diff = $date1->diff($date2);
										echo "<strong class='text-danger'>$diff->days dia(s) sin atender.</strong>"  ;
										?>

									</td>
									<td>
										<?php if ($NOVnovedades[3] == 1) { ?>
											<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url()."ver-falla/{$falla->rm_id}"; ?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>



										<?php }?>

										<?php if ($NOVnovedades[4] == 1) { ?>
											<button type="button" class="btn btn-danger btn-xs btn-link desest" data-id="<?=$falla->rm_id?>" data-toggle="tooltip" title="Desestimar" style="color: white;"><i class="fa fa-times"></i></button>
										<?php }?>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
			  			</table>
						</div>
					</div>
				</div>
			</div>
    </section>
</div>
</form>
