<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>">
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$MANTordenes= array(0,0,0,0,0,0,0,0,0,0,0);
$INSTAordenes = array(0,0,0,0,0,0,0,0,0,0,0);
$REPAordenes = array(0,0,0,0,0,0,0,0,0,0,0);

switch ($titulo) { //Los permisos para cada boton.
    case 'Mantenimiento':
       $MANTordenes = explode(',', $mantenimiento_ordenes);
       $tecnicos = array(400,401,402,403,600,601,602,603);
       break;
    case 'Reparaciones':
       $REPAordenes = explode(',', $reparacion_ordenes);
       $espacio = "&nbsp;&nbsp;&nbsp;";
       $tecnicos = array(200,201,202,203);
       break;
    case 'Instalaciones':
       $INSTAordenes = explode(',', $instalacion_ordenes);
       $espacio = "&nbsp;&nbsp;&nbsp;";
       $tecnicos = array(500,501,502,503);
       break;
}
?>

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0;}
</style>

<script>
$(document).ready(function () {
	$(".boton_envio").on('click',function() {
		$('#idorden').val($(this).data('id'));
		$("#myModalLabel").html('Al confirmar, se enviarÃ¡ la orden al celular del tÃ©cnico');
		$("#myForm").prop("action","<?=base_url('ordenes/enviarOrden')?>?ref=<?=uri_string()?>&searchText=<?=$this->input->get('searchText')?>");
		$('#campos_reasignada').hide();
		$('#campos_estado').hide();
		<?php if ($titulo == "Reparaciones"):?>
		$('#campos_finalizar').hide();
		<?php endif;?>
		$('.mensaje_finalizar').hide();
		$('#myModal').modal('show');
	});

	$(".boton_finalizar").on('click',function() {
	$('#observ').attr('minlength', 50);
	$('#observ').attr('placeholder', 'Explique brevemente el trabajo realizado.');
	$("#rchars").show();
	$("#lblRchars").show();
    $(".boton_finalizar").attr("disabled",true);
    $(".boton_finalizar").css("color", "grey");
		$('#idorden').val($(this).data('id'));
		$("#myModalLabel").html('Al confirmar, finalizarÃ¡ la orden');
		$("#myForm").prop("action","<?=base_url("finalizar-orden")?>?ref=<?=uri_string()?>&searchText=<?=$this->input->get('searchText')?>");
		<?php if ($titulo == "Reparaciones"):?>
		$.post("<?=base_url('ordenes/getFechaUltEvento')?>",{idorden: $('#idorden').val()})
		.done(function(response) {
			data = JSON.parse(response);
			var mindate = new Date(data.fecha);
			$('#fecha_finalizacion').datepicker("setStartDate",mindate);
		});
		$('#campos_reasignada').hide();
		$('#campos_estado').show();
		<?php endif;?>
		$('#campos_finalizar').show();
		$("#ultimo_estado").val($(this).data('ultimo_estado'));
		$("#estado").val($(this).data('estado'));
		$('.mensaje_finalizar').show();
		$('#myModal').modal('show');
	});

  // lio -> click en btn reasignar, renderiza el form modal para reasignar categorias de la OT y lugar del equipo
	$(".boton_reasignar").on('click',function() {
		$('#idorden').val($(this).data('id'));
		$("#myModalLabel").html('Al confirmar, reasignará¡ la orden');
		$("#myForm").prop("action","<?=base_url("reasignar-orden")?>?ref=<?=uri_string()?>&searchText=<?=$this->input->get('searchText')?>");
		$('#campos_reasignada').show(); // div con las categorias en checkboxes
		$('#campos_estado').show();
		<?php if ($titulo == "Reparaciones"):?>
		$('#campos_finalizar').hide();
		<?php endif;?>
		$("#ultimo_estado").val($(this).data('ultimo_estado'));

		$("#categoria").val($(this).data('categoria'));
		// bloque para poner en on los checkboxes de las categorias vigentes de la OT al momento de renderizar el form
    const categoriasVigentesOT = $(this).data('categorias-vigentes-ot') 
    const categoriasIds = categoriasVigentesOT.map( categoria => categoria.id) 
    const checkboxesCategoriasVigentes = document.querySelectorAll(".checkbox-categoria-vigente");
    checkboxesCategoriasVigentes.forEach(checkbox => {
      if (categoriasIds.includes(checkbox.value)) {
        checkbox.checked = true;
      }
    });
    // si el equipo esta en el socio, agrego la data en un input hidden para mandarla al servidor cuando se actualizan las categorias vigentes
    if (categoriasIds.includes("5")) {
      $("#checkbox-socio-hidden").val("5");
    }
    // fin bloque
    
    $("#estado").val($(this).data('estado'));
		$('.mensaje_finalizar').hide();
		$('#myModal').modal('show');
	});

	$("#modalbutton").click(function() {
		$("#form").find('[type="submit"]').trigger('click');
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	$('#fecha_finalizacion').datepicker({
		language: 'es',
		format: 'dd/mm/yyyy',
		daysOfWeekDisabled: '0,6'});

	$("#hora_finalizacion").timepicker({
        template: false,
        showInputs: false,
        minuteStep: 1,
        showMeridian: false
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
					$('#lblRchars').html(' Observación lista para enviar!');
					$('#rchars').html(' ');
				}
			});
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
  #example2_info { position: relative; top: 5px; left: 680px;}
  #example2_paginate { position: relative; bottom: 20px; right: 440px; }
</style>

<div class="content-wrapper">
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

        <!-- lio -> http://.../reasignar-orden?ref=instalaciones/ordenes&searchText= -->
				<form id="myForm" method="post" action="">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning mensaje_finalizar" role="alert" style="display: none;"><strong>La orden no se podrÃ¡ reasignar luego de finalizarla.</strong> AsegÃºrese de que la <strong>CATEGORÃ�A</strong> y <strong>ESTADO</strong> sea el actual antes de finalizar la orden.</div>
					<input name="idorden" id="idorden" type="hidden" value="">
					<input name="ultimo_estado" id="ultimo_estado" type="hidden" value="">

					<?php if ($titulo == "Reparaciones"):?>
    					<div id="campos_finalizar" class="form-group" style="display: none;">
    						<label for="diagnostico">DiagnÃ³stico</label>
    						<select id="diagnostico" name="diagnostico" class="form-control">
    							<?php foreach ($diagnosticos as $diagnostico): ?>
    									<option value="<?=$diagnostico->id?>"><?=$diagnostico->descrip?></option>
    							<?php endforeach; ?>
    						</select>
    						<div class="row">
                  <br>
        						<div class="col-md-6">
            						<label for="fecha_finalizacion">Fecha finalizaciÃ³n</label>
            						<input id="fecha_finalizacion" name="fecha_finalizacion" class="form-control" data-date-end-date="0d" value=<?=date('d/m/Y')?>>
        						</div>
        						<div class="col-md-6">
    								<label for="hora_finalizacion">Hora finalizaciÃ³n</label>
    								<input id="hora_finalizacion" name="hora_finalizacion" class="form-control" value=<?=date('H:i')?>>
        						</div>
    						</div>
    					</div>
					<?php endif;?>















					<div id="campos_reasignada" class="form-group" style="display: none;">

            
            <!-- lio form reasignar - categorias - -->
            <div style="display:nonex;">
              <label for="estado">Categorías</label>
              <div class="container" style="width: auto;">
                <div class="row">
                <?php foreach ($categorias as $categoria): ?>
                  <div class="col-md-3" style="padding: 0 1.5rem; margin:.5rem; border-radius:.5rem; background-color:#a5cee6;">
                    <div class="d-flex justify-content-between" style="align-items: center;">
                      <!-- <label for="checkbox-categoria-vigente-<?php //echo $categoria->id?>"><?php //echo $categoria->descrip?></label> -->
                      <label 
                        for="<?php echo $categoria->id != 5 ? "checkbox-categoria-vigente-$categoria->id" : "label-check-rc-socio-deshabilitado"; ?>"
                      >
                        <?php echo $categoria->descrip?>
                      </label>
                      <input 
                        title="<?php echo $categoria->id == 5 ? "No se puede actualizar esta categoría desde este panel" : ""; ?>"
                        class="checkbox-categoria-vigente" type="checkbox" 
                        value="<?php echo $categoria->id?>"  
                        name="nuevas_categorias_vigentes[]"
                        <?php echo $categoria->id == 5 ? "disabled": ""; ?>  
                        id="<?php echo $categoria->id != 5 ? "checkbox-categoria-vigente-$categoria->id" : "label-check-rc-socio-deshabilitado"; ?>"
                      >

                      <!-- lio -> como la categoria socio no se puede acceder desde el panel, mando el dato al server en un hidden para que el nuevo batch de categorias de la ot se cree correctamente -->
                      <?php if($categoria->id == 5): ?>
                        <input type="hidden" name="nuevas_categorias_vigentes[]" id="checkbox-socio-hidden">
                        <!-- value="<?php //echo $categoria->id?>" -->
                      <?php endif ?>


                      <!-- id="checkbox-categoria-vigente-<?php //echo $categoria->id?>" -->
                      <!-- name="<?php //echo $categoria->id != 5 ? "nuevas_categorias_vigentes[]": "check-rc-socio-deshabilitado"; ?>"  -->
                    </div>
                  </div>
                <?php endforeach; ?>
                  
                </div>
              </div>
            </div>
            
            <div style="display:none;">
              <label for="categoria">CategorÃ­a</label>
              <select id="categoria" name="categoria" class="form-control">
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria->id?>"><?php echo $categoria->descrip?></option>
                <?php endforeach; ?>
              </select> 
            </div>
           
          </div>














          <!-- lio -> form reasignar - select lugar - -->
					<div id="campos_estado" class="form-group" style="display: none;">
						<label for="estado">Lugar</label>
						<select id="estado" name="estado" class="form-control">
							<?php foreach ($estados as $estado): ?>
									<option value="<?=$estado->id?>"><?=$estado->descrip?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="observ">Observación</label>
						<textarea style="resize: none;" id="observ" name="observ" class="form-control" rows="3"></textarea>
						<div class="form-group">
  						<span id="rchars">50</span><span id="lblRchars"> Caracteres restantes</span>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="modalbutton" type="submit" class="btn btn-primary">Confirmar</button>
				</div>
				</form>
			</div>
		</div>
	</div>

     <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
      <b><?=$titulo?></b>
       <span class="pull-right">
         <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
         <span class="text-muted"><?=$titulo?> <?=$subtitulo?> Abiertas </span>
       </span>
     </div>

  	<section class="content-header">
      <div class="row">
          <div class="col-md-12">
              <?php
              $this->load->helper('form');
              if ($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                      <?= $this->session->flashdata('error'); ?>
                  </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ã—</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
              <?php endif; ?>
          </div>
      </div>

        <?php if ($MANTordenes[0] == 1 || $REPAordenes[0] == 1  || $INSTAordenes[0] == 1): ?>
  			  <div class="row">
  	    		<div class="col-md-12 text-right btn-toolbar">
  	    			<a class="btn btn-labeled btn-primary" href="<?=base_url('ordenes/alta')?>?ref=<?=uri_string()?>" role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Crear orden nueva</a>
  	    		</div>
  	    	</div>
     		<?php endif; ?>
  	</section>

    <section class="content">
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h1 class="box-title"> </h1>
                    <div class="box-tools">
                        <form action="<?= base_url($this->uri->segment (1)."/".$this->uri->segment (2)) ?>" method="get" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover">
                    <tr class="info">
                      <th>Equipo</th> <th>Direccion</th> <th>Fecha</th> <th>Tipo Falla</th>
        							<?php if ($role == 99 || $role == 200 || $role == 201 || $role == 202 || $role == 203):?>
                        <th>Categoria</th> <th>Lugar del Equipo</th>
        							<?php endif;?>
        							<th>Tiempos</th> <th>Acciones</th>
                    </tr>
                    <?php foreach ($ordenes as $orden):?>
          						<tr>
          							<td><?php echo "<a href=".base_url("verEquipo/{$orden->em_id}").">" . $orden->rm_serie . "</a>"; ?>
                            <br/><span class="text-muted"><small><?=$orden->mu_descrip?></small></span>
                        </td>
          							<td width="150px"><small><?= ($orden->em_ubicacion_calle == NULL) ? "A designar" : $orden->em_ubicacion_calle?></small></td>
          							<td><?=date('d/m/Y',strtotime($orden->re_fecha))?></td>
          							<td><span class="label label-default" data-toggle="tooltip" data-placement="top" title="<?=$this->ordenes_model->getPrimerEvento($orden->rm_id)->observ?>"><?=$orden->fm_descrip?></span></td>

                        <?php if ($role == 99 || $role == 200 || $role == 201 || $role == 202 || $role == 203):?>
                          <!-- 
                          <td>
                            <span 
                              class="label" style="color: white; background-color: #<?php //echo $orden->rc_color?>" 
                              data-toggle="tooltip" data-placement="top" 
                              title="<?php //echo $this->ordenes_model->getUltimoEvento($orden->rm_id)->observ?>"
                            ><?php //echo $orden->rc_descrip?></span> 
                          </td>
                          -->
                          <td style="display: grid;">
                            <?php foreach($orden->categorias_vigentes as $categoria_vigente): ?>
                              <p
                                class="label" style="width: min-content; color: white; background-color: #<?php echo $categoria_vigente->color?>" 
                                data-toggle="tooltip" data-placement="top" 
                                title="<?php echo $this->ordenes_model->getUltimoEvento($orden->rm_id)->observ?>"
                              ><?php echo $categoria_vigente->descrip; ?></p>
                            <?php endforeach ?>    
                          </td>

                          <td><small><?=$orden->es_descrip?></small></td>
          							<?php endif;?>

          							<td><span data-toggle="tooltip" data-placement="top" title="Tiempo transcurrido total" class="label <?=$orden->total<=7?'label-success':($orden->total<=14?'label-warning':'label-danger')?>"><?=$orden->total;?></span> <span data-toggle="tooltip" data-placement="top" title="Tiempo transcurrido de la categorÃ­a actual" class="label <?=$orden->cat_total<=7?'label-success':($orden->cat_total<=14?'label-warning':'label-danger')?>"><?=$orden->cat_total?></span> <span data-toggle="tooltip" data-placement="top" title="Tiempo transcurrido del evento actual" class="label <?=$orden->eve_total<=7?'label-success':($orden->eve_total<=14?'label-warning':'label-danger')?>"><?=$orden->eve_total?></span></td>
          							<td>
                          <?php if (in_array(1, array($MANTordenes[1],$REPAordenes[1],$INSTAordenes[1]))): ?>
          									<a data-toggle="tooltip" title="Ver/Editar" href="<?=base_url("ver-orden/{$orden->rm_id}?ref={$this->uri->uri_string()}&searchText={$searchText}")?>"><i class="fa fa-info-circle"></i></a>
          								<?php endif; ?>

                          <!-- lio -> btn.Reasignar -->
                          <?php if ($REPAordenes[2] == 1 || $INSTAordenes[2] == 1): ?>
                            <?php 
                              if (
                                !in_array($orden->rm_ultimo_estado, array(/* 14,15,16, */17,18,19)) && 
                                ( 
                                  ( $orden->rm_ultimo_categoria != 3 && (in_array($roleUser, $isReparacion)) ) 
                                  ||  
                                  ( $orden->rm_ultimo_categoria == 3 && (in_array($roleUser, $isInstalacion)) )  
                                  || 
                                  (in_array($roleUser, $isAdmin))
                                )
                              ): ?>
                                <button 
                                  data-toggle="tooltip" title="Reasignar" 
                                  data-id="<?=$orden->rm_id?>" data-ultimo_estado="<?=$orden->rm_ultimo_estado?>" 
                                  data-estado="<?=$orden->em_estado?>" 
                                  data-categoria="<?=$orden->rm_ultimo_categoria?>" 
                                  data-searchText="<?= $searchText?>" 
                                  data-categorias-vigentes-ot="<?php echo htmlspecialchars(json_encode($orden->categorias_vigentes), ENT_QUOTES, 'UTF-8'); ?>" 
                                  class="btn inline btn-link btn-sm boton_reasignar"><i class="fa fa-share"></i>
                                </button>
                            <?php endif; ?>
                          <?php endif; ?>

                          <?php if ($MANTordenes[2] == 1 || $REPAordenes[3] == 1 || $INSTAordenes[3] == 1): ?>
                                <?php $q = $this->load->model('ordenes_model');
                                $visita =$this->ordenes_model->ordenes_fechas($orden->rm_id); 
    
                                
                                ?>


                                <?php if ($visita && in_array($visita->roleTecnico,$tecnicos)): ?>
                                    <?php if (($orden->rm_ultimo_estado == 3 && $orden->rm_ultimo_estado != 16)  && (($orden->rm_ultimo_categoria != 3 && (in_array($roleUser, $isReparacion))) || ($orden->rm_ultimo_categoria == 3 && (in_array($roleUser, $isInstalacion)))  || (in_array($roleUser, $isAdmin)) || (in_array($roleUser, $isBajada)))): ?>
                                        <button data-toggle="tooltip" title="Enviar orden al celular" data-id="<?=$orden->rm_id?>" data-searchText="<?= $searchText?>" class="btn inline btn-link btn-sm boton_envio" type="button" style="color: DarkGoldenRod;"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                    <?php endif; ?>
                                <?php endif; ?>
          								<?php endif; ?>

                          <?php if ($MANTordenes[3] == 1 || $REPAordenes[4] == 1 || $INSTAordenes[4] == 1): ?>
          									<?php if (($orden->rm_ultimo_estado==9 || $orden->rm_ultimo_estado==11 && ($orden->rm_ultimo_categoria!=5 && $orden->rm_ultimo_categoria!=6) && $orden->rm_tipo != 'I'

                            )  && (($orden->rm_ultimo_categoria != 3 && (in_array($roleUser, $isReparacion))) ||  ($orden->rm_ultimo_categoria == 3 && (in_array($roleUser, $isInstalacion)))  || (in_array($roleUser, $isAdmin)) || (in_array($roleUser, $isBajada)))):?>
                              <?php if ($titulo = 'Mantenimiento'): ?>
                                &nbsp;&nbsp;&nbsp;
                              <?php endif; ?>
                              <button data-toggle="tooltip" title="Finalizar" data-id="<?=$orden->rm_id?>" data-ultimo_estado="<?=$orden->rm_ultimo_estado?>" data-searchText="<?= $searchText?>" data-estado="<?=$orden->em_estado?>" class="btn inline btn-link btn-sm boton_finalizar" style="color: MediumSeaGreen; margin-left:-12px"><i class="fa fa-check"></i></button>
          									<?php endif;?>
                          <?php endif; ?>

                          <!-- lio -> accion.Agregar fecha de corte -->
                          <?php //if ($orden->rm_ultimo_estado == 3 && $INSTAordenes[6] == 1): ?>
                          <?php if (in_array($orden->rm_ultimo_estado, array(3,14,15,16)) && $INSTAordenes[6] == 1): ?>
                            <a 
                              data-toggle="tooltip" title="Agregar fecha de corte" 
                              href="/fecha-corte/<?php echo $orden->rm_id; ?>"
                            >
                                <i class="fa fa-calendar"></i>
                            </a> <?= $espacio?>
                          <?php endif; ?>

                          <!-- lio -> accion.Enviar equipo -->
                          <?php 
                            if (
                              !$orden->equipo_enviado_al_socio_no_resuelto && (
                              !in_array($orden->rm_ultimo_estado, array(14,15,16,17,18,19)) && $orden->em_estado == 5 && $REPAordenes[6] == 1 
                                || 
                              ($orden->rm_falla == 108 && !in_array($orden->rm_ultimo_estado, array(14,15,16)) )
                              )
                            ): 
                          ?>

                            <a id="enviar_equipo" data-toggle="modal" data-tooltip="tooltip" title="Enviar Equipo" data-target="#modalEnviarSocio<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" ><i class="fa fa-arrow-circle-up"></i></a>
                              <div id="modalEnviarSocio<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                      <h4 class="modal-title" id="myModalLabel">Enviar equipo a otro sector - Equipo <?= $orden->rm_serie; ?></h4>
                                    </div>

                                    <div class="modal-body">
                                      <form  method="post" action="<?=base_url("enviar-socio/{$orden->rm_id}?ref={$this->uri->uri_string()}&searchText={$searchText}")?>" data-toggle="validator">

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al enviar un equipo no se podra deshacer este cambio.</p>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="label_destino">Destino</label>
                                                   <div class="input-group">
                                                     <span class="input-group-addon"><i class="fa fa-list" aria-hidden="true"></i></span>
                                                     <select class="form-control" name="destino" id="destino" required data-error="Seleccionar una opcion.">
                                                      <option value="">Seleccionar destino</option>
                                                      <option value="5">Socio</option>
                                                      <option value="10">Deposito</option>
                                                    </select>
                                                   </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                           </div>

                                           <div class="col-md-6">

                                              <div class="form-group">
                                                  <label id="label_asociado" for="label_asociado">Asociado</label>
                                                    <div class="input-group">
                                                      <span id="icono_asociado"class="input-group-addon"><i class="fa fa-list" aria-hidden="true"></i></span>
                                                      <select class="form-control" name="asociado" id="asociado" data-error="Seleccionar una opcion.">
                                                       <option value="">Seleccionar asociado</option>
                                                       <option value="<?= $orden->ep_id; ?>"><?= $orden->ep_descrip; ?></option>
                                                       <?php $this->load->model('perifericos_model');
                                                           $socios = $this->perifericos_model->SociosAsignados($orden->em_id);?>
                                                       <?php foreach ($socios as $socio): ?>
                                                         <option value="<?=$socio->socio?>"><?=$socio->descrip?></option>
                                                       <?php endforeach; ?>
                                                     </select>
                                                    </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="observacion">Observaciones</label>
                                              <textarea name="observacion_enviar" id="observacion_enviar" class="form-control" rows="3" cols="20"  style="resize: none" required data-error="Completar este campo."></textarea>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" class="btn btn-info ">Aceptar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                          <?php endif; ?>

                          <?php if (in_array($orden->rm_ultimo_estado, array(16,19)) && $REPAordenes[7] == 1): ?>
                            <?= $espacio ?><a data-toggle="tooltip" title="Recibir Equipo" href="<?=base_url("recibir-socio/{$orden->rm_id}?ref={$this->uri->uri_string()}&searchText={$searchText}")?>"><i class="fa fa-arrow-circle-down"></i></a>
                          <?php endif; ?>

                          <!-- lio -> btn.Agregar fecha de corte -->
                          <?php 
                            if (
                              (
                                ($MANTordenes[4] == 1 || $REPAordenes[5] == 1 || $INSTAordenes[5] == 1) && 
                                // $orden->rm_ultimo_estado == 3
                                in_array($orden->rm_ultimo_estado, array(3,14,15,16))
                              ) 
                              && 
                              (
                                ($orden->rm_ultimo_categoria != 3 && (in_array($roleUser, $isReparacion))) ||  
                                ($orden->rm_ultimo_categoria == 3 && (in_array($roleUser, $isInstalacion))) || 
                                (in_array($roleUser, $isAdmin)) || 
                                (in_array($roleUser, $isBajada))
                              )
                            ): 
                          ?>
                            <a data-toggle="modal" data-tooltip="tooltip" title="Agregar Nueva Visita" data-target="#modalVisitas<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" >
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;</a>
                                <!-- sample modal content -->
                                <div id="modalVisitas<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                                                <h4 class="modal-title" id="myModalLabel">Agregar nueva visita - Equipo <?= $orden->rm_serie; ?></h4>
                                            </div>
                                            <form  method="post"
                                              action="<?=base_url('agregarVisitas')?>?searchText=<?=$searchText?>"
                                              data-toggle="validator">
                                            <div class="modal-body">
                                              <div class="form-group">
                                                  <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->rm_id ?>">
                                                  <input type="hidden" class="form-control" id="dir_uri" name="dir_uri" value="<?= $this->uri->uri_string() ?>">
                                                  <input type="hidden" class="form-control" id="serie" name="serie" value="<?= $orden->rm_serie; ?>">

                                                  <div class="box box-primary collapsed-box" style="width:575px ">
                                                    <div class="box-header with-border">
                                                      <h3 class="box-title">Eventos</h3>

                                                      <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                      </div>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                      <ul class="products-list product-list-in-box">
                                                        <?= $this->load->model('ordenes_model');
                                                            $eventos   = $this->ordenes_model->getEstados($orden->rm_id);?>
                                                        <?php foreach ($eventos as $evento): ?>
                                                          <li class="item">
                                                              <div class="product-info" style="position: relative; right: 60px; ">
                                                              <span class="label" style="color: white; background-color: #<?=$evento->rc_color?>;"><?=$evento->rc_descrip?></span>
                                                              <span class="time pull-right" style="position: relative; left: 60px; "><i class="fa fa-clock-o"></i> <?=date('d/m/Y',strtotime($evento->re_fecha))?></span>
                                                              <span class="product-description">
                                                              <?= substr($evento->re_observ, 0, 100);?>
                                                              </span>
                                                          </div>
                                                        </li>
                                                        <?php endforeach; ?>
                                                      </ul>
                                                    </div>

                                                    <div class="box-footer text-center">
                                                      <a href="<?=base_url("ver-orden/{$orden->rm_id}?ref={$this->uri->uri_string()}")?>" class="uppercase">Ver mas detalles</a>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="estado">Conductor</label><br>
                                                            <select class="form-control required" id="conductor" name="conductor" required data-error="Seleccionar un conductor." style="width:270px">
                                                                <option value="">Seleccionar Conductor</option>
                                                                  <?php foreach ($usuarios as $usuario): ?>
                                                                        <option value="<?php echo $usuario->userId ?>"><?php echo $usuario->name ?></option>
                                                                  <?php endforeach; ?>
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="estado">Tecnico</label><br>
                                                          <select class="form-control required" id="tecnico" name="tecnico" required data-error="Seleccionar un tecnico." style="width:270px">
                                                              <option value="">Seleccionar Tecnico</option>
                                                                <?php foreach ($usuarios as $usuario): ?>
                                                                      <option value="<?php echo $usuario->userId ?>"><?php echo $usuario->name ?></option>
                                                                <?php endforeach; ?>
                                                          </select>
                                                          <div class="help-block with-errors"></div>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                          <label for="estado">Fecha de visita</label>
                                                            <input name="fecha_visita" type="text" class="form-control fecha_visita" aria-describedby="fecha" autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required data-error="Seleccionar una fecha de visita." style="width:270px">
                                                          <div class="help-block with-errors"></div>
                                                      </div>
                                                  </div>

                                                    <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="estado">Vehiculo</label><br>
                                                        <select class="form-control required" id="vehiculo" name="vehiculo" required data-error="Seleccionar al menos una opciÃ³n." style="width:270px">
                                                            <option value="">Seleccionar vehÃ­culo.</option>
                                                              <?php foreach ($vehiculos as $vehiculo): ?>
                                                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->dominio ?></option>
                                                              <?php endforeach; ?>
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                  </div>
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="subida_observ">Observaciones</label><br>
                                                    <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20"  style="resize: none; width:570px;"></textarea>
                                                  </div><br>
                                              </div>

                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                            </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                    </div>
                                </div>
                                <!-- /.modal -->
          								<?php endif; ?>

                          <br>
                          
                          <!-- lio -> btn.Adjuntar archivo -->
                          <?php if (
                            ($MANTordenes[5] == 1 || $REPAordenes[8] == 1 || $INSTAordenes[7] == 1) && 
                            // in_array($orden->rm_ultimo_estado, array(3,4,5,11,13))
                            in_array($orden->rm_ultimo_estado, array(3,4,5,11,13,14,15,16))
                          ): ?>
                            <a 
                              data-toggle="tooltip" title="Adjuntar archivo" 
                              href="<?=base_url("adjuntar_archivo/{$orden->rm_id}?ref={$this->uri->uri_string()}&searchText={$searchText}")?>"
                            >
                              <i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;
                            </a>
                          <?php endif; ?>

                          <!-- lio -> btn.Cancelar orden -->
                          <?php if (
                            ($MANTordenes[6] == 1 || $REPAordenes[9] == 1 || $INSTAordenes[8] == 1) && 
                            // in_array($orden->rm_ultimo_estado, array(3,4,5,11,13)))
                            in_array($orden->rm_ultimo_estado, array(3,4,5,11,13,14,15,16)))
                          : ?>
                            <a data-toggle="modal" data-tooltip="tooltip" title="Cancelar Orden" data-target="#modalCancelar<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" ><i class="fa fa-times text-danger"></i></a>
                              <div id="modalCancelar<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                                      <h4 class="modal-title" id="myModalLabel">Cancelar Orden - Equipo <?= $orden->rm_serie; ?></h4>
                                    </div>

                                    <div class="modal-body">
                                      <form  method="post" action="<?=base_url('cancelar_orden')?>" data-toggle="validator">
                                        <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->rm_id ?>">
                                        <input type="hidden" class="form-control" id="ref" name="ref" value="<?= $this->uri->uri_string() ?>">
                                        <input type="hidden" class="form-control" id="serie" name="serie" value="<?= $orden->rm_serie; ?>">
                                        <input type="hidden" class="form-control" id="searchText" name="searchText" value="<?= $this->input->get('searchText')?>">

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <p>Â¿Desea cancelar la Orden?</p>
                                              <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cancelar no se podrÃ¡ deshacer este cambio.</p>
                                              <label for="observacion">Observaciones</label>
                                              <textarea name="obseracion_cancelar" id="obseracion_cancelar" class="form-control" rows="3" cols="20"  style="resize: none" required data-error="Completar este campo."></textarea>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php endif; ?>







                          <?php if (in_array($orden->rm_ultimo_estado, array(11)) && $orden->rm_tipo == 'I'): ?>
                            <a data-toggle="modal" data-tooltip="tooltip" title="<?= ($orden->rm_falla == 90)? 'Entregar Equipo':'Solicitar Equipo'; ?>" data-target="#modalEquipo<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" ><i class="fa fa-video-camera <?= ($orden->rm_falla == 90)? 'text-warning':'text-success'; ?>"></i></a>
                              <div id="modalEquipo<?= $orden->rm_id; $orden->rm_serie; $this->uri->uri_string() ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                                      <h4 class="modal-title" id="myModalLabel"><?= ($orden->rm_falla == 90)? 'Entregar Equipo':'Solicitar Equipo'; ?> - Equipo <?= $orden->rm_serie; ?></h4>
                                    </div>

                                    <div class="modal-body">
                                      <form  method="post" action="<?=base_url('solicitud_deposito')?>" data-toggle="validator">
                                        <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->rm_id ?>">
                                        <input type="hidden" class="form-control" id="serie" name="serie" value="<?= $orden->rm_serie; ?>">
                                        <input type="hidden" class="form-control" id="id_falla" name="id_falla" value="<?= $orden->rm_falla?>">
                                        <input type="hidden" class="form-control" id="ref" name="ref" value="<?= $this->uri->uri_string() ?>">
                                        <input type="hidden" class="form-control" id="searchText" name="searchText" value="<?= $this->input->get('searchText')?>">

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="observacion">Observaciones</label>
                                              <textarea name="observacion_deposito" id="observacion_deposito" class="form-control" rows="3" cols="20"  style="resize: none" required data-error="Completar este campo."></textarea>
                                              <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php endif; ?>



          							</td>
          						</tr>
          					<?php endforeach;?>
                  </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <?= $this->pagination->create_links(); ?>
                </div>

              </div><!-- /.box -->
            </div>
        </div>
      </section>
    </div>

<script>
  $(function () {
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    $('[data-mask]').inputmask()
  })

  $(function() {
    $('.fecha_visita').datepicker({
      format: 'dd-mm-yyyy',
      language: 'es'
    });
  });
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "<?=  strtolower($titulo); ?>/ordenes/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>


<script>
  $(document).ready(function(){
    $("#asociado").hide();
    $("#label_asociado").hide();
    $("#icono_asociado").hide();
    $("#enviar_equipo").click(function() {
      $("#asociado").hide();
      $("#label_asociado").hide();
      $("#icono_asociado").hide();

    });
      $('#destino').on('change', function() {
        tipo_equipo = $(this).val();
        switch(tipo_equipo) {
            case "5":
                $("#asociado").show();
                $("#label_asociado").show();
                $("#icono_asociado").show();
                break;

            case "10":
            case "":
            case NULL:

                $("#asociado").hide();
                $("#label_asociado").hide();
                $("#icono_asociado").hide();
                break;
        }
      });
  });
</script>
