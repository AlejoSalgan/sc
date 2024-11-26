<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

switch ($titulo) { //Los permisos para cada boton.
    case 'Mantenimiento':
       $MANTsolicitudes = explode(',', $mantenimiento_solicitudes);
    break;

    case 'Reparaciones':
       $REPAsolicitudes = explode(',', $reparacion_solicitudes);
    break;

    case 'Instalaciones':
       $INSTAsolicitudes = explode(',', $instalacion_solicitudes);
    break;
}

?>

<script>
$(document).ready(function () {
	$("#selectall").change(function () {
	    $('input:checkbox').not(this).prop('checked', this.checked);
		if ($('#form input[type=checkbox]:checked').length) {
			$(".enviar").prop("disabled",false);
		} else {
			$(".enviar").prop("disabled",true);
		}
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

	$("#aprobar").click(function(){
		$("#estado").val("a");
		$("#modalbutton").removeClass("btn-danger");
		$("#modalbutton").addClass("btn-success");
		$("#myModalLabel").html('¿Desea convertir las solicitudes seleccionadas en órdenes?');
		$("#modalbutton").html('Confirmar envío órdenes de trabajo');
 	});

	$("#rechazar").click(function(){
		$("#estado").val("r");
		$("#modalbutton").removeClass("btn-success");
		$("#modalbutton").addClass("btn-danger");
		$("#myModalLabel").html('¿Desea rechazar las solicitudes seleccionadas?');
		$("#modalbutton").html('Confirmar rechazo de solicitudes');
 	});

	$("#modalbutton").click(function() {
		$("#form").find('[type="submit"]').trigger('click');
	});

	$('#fecha_visita').datepicker({language: 'es', format: 'dd/mm/yyyy'});

    $("#searchbutton").click(function() {
    	$("#form").attr("action","<?=base_url(uri_string())?>");
    	$("#form").attr("method","get");
    	$("#estado").remove();
    	$("input:checkbox").remove();
    	$("#observ").remove();
    	$("#form").submit();
    });

    $("#search").keypress(function(evento) {
    	if(evento.which == 13) {
    		$("#searchbutton").click();
    	}
    });

});

</script>

<script>  // En bootstrap.min.css se configuro overflow-X como unset. La variable original era AUTO.
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
		'paging'        : true,
		'lengthChange'  : false,
		'searching'     : false,
		'ordering'      : false,
		'info'          : true,
		'iDisplayLength': 30,
		'autoWidth'     : false
    })
  })
</script>

<style>
  #example2_info {
    position: relative; top: 5px; left: 680px;
  }

  #example2_paginate {
    position: relative; bottom: 20px; right: 440px;
  }
</style>

<form id="form" action="<?=base_url('ordenes/altaorden')?>?ref=<?=uri_string()?>" method="post">
<button type="submit" class="hide"></button>
<input id="estado" type="hidden" name="estado" value="">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<label for="observ">Si lo desea, ingrese una observación:</label>
        	<textarea style="resize: none;" id="observ" name="observ" class="form-control" rows="3" placeholder="Observación"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="modalbutton" type="button" class="btn"></button>
      </div>
    </div>
  </div>
</div>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	 <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"><?=$titulo?> <?=$subtitulo?></h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active"><?=$titulo?> <?=$subtitulo?></li>
              </ol>
          </div>
      </div>
     </section>

	<section class="content-header">

		<div class="row">
			<div class="col-md-12 text-right btn-toolbar">
				<?php if($MANTsolicitudes[0] == 1 || $REPAsolicitudes[0] == 1 || $INSTAsolicitudes[0] == 1) { ?>
					<button data-toggle="modal" data-target="#myModal" id="aprobar" type="button" class="btn inline btn-success enviar" disabled><i class="fa fa-check"></i> Crear órdenes de las solicitudes seleccionadas</button>
				<?php } ?>

				<?php if($MANTsolicitudes[1] == 1 || $REPAsolicitudes[1] == 1 || $INSTAsolicitudes[1] == 1) { ?>
					<button data-toggle="modal" data-target="#myModal" id="rechazar" type="button" class="btn inline btn-danger enviar" disabled><i class="fa fa-times"></i> Rechazar solicitudes seleccionadas</button>
				<?php } ?>

				<?php if($MANTsolicitudes[2] == 1 || $REPAsolicitudes[2] == 1 || $INSTAsolicitudes[2] == 1) { ?>
					<a class="btn btn-primary" href="<?=base_url('ordenes/alta_solicitud')?>?ref=<?=uri_string()?>" role="button"><i class="fa fa-plus"></i> Crear solicitud nueva</a>
				<?php } ?>
			</div>
		</div>
	</section>
    <section class="content">
	<div class="box">
		<div class="box-body">
			<div class="table-responsive">

            	<div class="box-tools">
                    <div class="input-group">
                      <input id="search" type="text" name="search" value="<?=$search?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar . . ."/>
                      <div class="input-group-btn">
                        <button id="searchbutton" type="button" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                </div>

	  			<table class="table table-hover table-striped" id="example2">
					<thead>
						<tr>
							<th>
								<?php if($MANTsolicitudes[3] == 1 || $REPAsolicitudes[3] == 1 || $INSTAsolicitudes[3] == 1) { ?>
									<input type="checkbox" id="selectall" name="selectall">
								<?php } ?>
							</th>

							<th>Equipo</th><th width="150px">Dirección</th><th>Fecha</th><th width="225px"> Tipo de falla</th><th>Observaciones</th><th>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($solicitudes as $solicitud):?>
						<tr <?=in_array($solicitud->rm_serie,$repetidas)?'class="danger"':''?>>
							<td>
								<?php if($MANTsolicitudes[3] == 1 || $REPAsolicitudes[3] == 1 || $INSTAsolicitudes[3] == 1) { ?>
									<input type="checkbox" name="id[]" value="<?=$solicitud->rm_id?>">
								<?php } ?>
							</td>

              <td><?php echo "<a href=".base_url("verEquipo/{$solicitud->em_id}").">" . $solicitud->rm_serie . "</a>"; ?>
                  <br/><span class="text-muted"><small><?=$solicitud->mu_descrip?></small></span>
              </td>
              <td><?=$solicitud->em_ubicacion_calle." ".$solicitud->em_ubicacion_altura?></td>
							<td><?=date('d/m/Y',strtotime($solicitud->re_fecha))?></td>
							<td><?=$solicitud->fm_descrip?></td>
							<td><?=$solicitud->re_observ?></td>

							<td>
								<?php if($MANTsolicitudes[4] == 1 || $REPAsolicitudes[4] == 1 || $INSTAsolicitudes[4] == 1) { ?>
									<a data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("ver-solicitud/{$solicitud->rm_id}")?>"><i class="fa fa-info-circle"></i></a>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
	  			</table>
			</div>
		</div>
	</div>
    </section>
</div>
</form>
