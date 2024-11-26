<div class="content-wrapper">
    <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
      <?= $tipoItem?> Orden de Bajada
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('ordenesbListing')?>">Ordenes de Servicio</a> /
        <span class="text-muted"><?= $tipoItem?> Orden de Bajada</span>
      </span>
    </div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if ($error): ?>
                      <div class="alert alert-danger alert-dismissable" style="position: relative; bottom: 5px;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                <?php
                $success = $this->session->flashdata('success');
                if ($success): ?>
                  <div class="alert alert-success alert-dismissable" style="position: relative; bottom: 5px; ">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('info')): ?>
                  <div class="alert alert-warning alert-dismissable" style="position: relative; bottom: 5px; ">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('info'); ?>
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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Detalles de la Orden</h3>
                      <span class="pull-right">

   										 <a data-toggle="modal" title="Ayuda" data-target="#modalAyuda_instaOrdenes" ><i class="fa fa-question-circle text-info fa-lg"></i></a>
   												 <!-- sample modal content -->
   												 <div id="modalAyuda_instaOrdenes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   														 <div class="modal-dialog">
   																 <div class="modal-content">
   																		 <div class="modal-header">
   																				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
   																				 <h4 class="modal-title" id="myModalLabel">Ayuda de Ordenes de Bajada de Memoria</h4>
   																		 </div>
   																		 <div class="modal-body">
                                        <p>Solo se podrá Bajar Memorias de Equipos que tengan las siguientes condiciones: </p>
                                        <p><strong>- Condición de Bajada:</strong> <span class="text-success">SI</span></p>
                                        <p><strong>- Solicitud de Bajada:</strong> <span class="text-success">SI</span></p>
                                        <p><strong>- Lugar:</strong> <span class="text-success">Proyecto</span></p>
                                        <p><strong>- Fecha de Calibracion:</strong> *Solo para los equipos que son tipo velocidad. La fecha de Calibracion no tiene que estar vencida.*</p>
                                        <p>El listado de Equipos solo mostraran los que cumplan estas condiciones. Ante cualquier duda se puede consultar el estado de cada uno en Ver Detalle.</p>
   																		 </div>
   																		 <div class="modal-footer">
   																				 <button type="button" class="btn btn-success btn-rounded" data-dismiss="modal">Aceptar</button>
   																		 </div>
   																 </div>
   														 </div>
   												 </div>

   									 </span>
                    </div>

                    <form role="form" id="addOrdenesb" action="<?= base_url('agregar_editar_ordenes')?>" method="post" role="form">
                        <input type="hidden" class="form-control" id="ordenesbId" name="ordenesbId" value="<?= $ordenesbInfo->id ?>" >
                        <input type="hidden" class="form-control" id="tipoItem" name="tipoItem" value="<?= $tipoItem ?>" >

                        <div class="box-body">
                          <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                     <label for="fecha_visita">Fecha de Visita</label>
                                       <div class="input-group">
                                         <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                         <input id="fecha_visita" name="fecha_visita" type="text" class="form-control" aria-describedby="fecha" autocomplete="off"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask value="<?= $ordenesbInfo->fecha_visita ?>" required>
                                     </div>
                                </div>
                             </div>

                             <div class="col-md-3">
                               <div class="form-group">
                                   <label for="idproyecto">Proyecto</label>
                                   <?php if ($tipoItem == "Agregar"): ?>
                                     <select class="form-control" id="idproyecto" name="idproyecto" required>
                                         <option value="">Seleccionar</option>
                                         <?php foreach ($municipios as $municipio): ?>
                                            <option value="<?php echo $municipio->id; ?>" <?php if($municipio->id == $ordenesbInfo->idproyecto) {echo "selected=selected";} ?>><?php echo $municipio->descrip ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                   <?php else: ?>
                                     <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?= $ordenesbInfo->descripProyecto ?>" readonly>
                                     <input type="hidden" value="<?= $ordenesbInfo->idproyecto ?>" name="idproyecto" id="idproyecto" />
                                   <?php endif; ?>
                               </div>
                             </div>

                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="idequipo"></i> Equipo serie</label>
                                     <?php if ($tipoItem == "Agregar"): ?>
                                       <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" title="Seleccione los equipos..." data-size="6" required>
                                       </select>
                                     <?php else: ?>
                                       <input type="text" id="search_data" class="form-control search-input" name="search-term" value="<?= $ordenesbInfo->equipoSerie ?>" onkeyup="liveSearch()" autocomplete="off" readonly>
                                       <div id="suggestions">
                                           <div id="autoSuggestionsList">
                                           </div>
                                       </div>
                                       <input type="hidden" name="idequipo" id="idequipo" value="<?= $idequipo ?>" />
                                     <?php endif; ?>
                                 </div>
                             </div>
                          </div>
                          <br>

                          <div class="row">
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="conductor"> Conductor</label>
                                      <select class="form-control" id="conductor" name="conductor" required>
                                          <option value="">Seleccionar conductor</option>
                                          <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $ordenesbInfo->conductor) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                          <?php endforeach; ?>

                                          <?php if ($role == 99): ?>
                                            <option value="">---------------------------</option>
                                            <?php foreach ($superadmins as $superadmin): ?>
                                              <option value="<?php echo $superadmin->userId ?>" <?php if($superadmin->userId == $ordenesbInfo->conductor) {echo "selected=selected";} ?>><?php echo $superadmin->name ?></option>
                                            <?php endforeach; ?>
                                          <?php endif; ?>
                                      </select>
                                  </div>
                              </div>

                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label> Técnico</label>
                                      <select class="form-control" id="tecnico" name="tecnico" required>
                                          <option value="">Seleccionar tecnico</option>
                                          <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $ordenesbInfo->tecnico) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                          <?php endforeach; ?>

                                          <?php if ($role == 99): ?>
                                            <option value="">---------------------------</option>
                                            <?php foreach ($superadmins as $superadmin): ?>
                                              <option value="<?php echo $superadmin->userId ?>" <?php if($superadmin->userId == $ordenesbInfo->tecnico) {echo "selected=selected";} ?>><?php echo $superadmin->name ?></option>
                                            <?php endforeach; ?>
                                          <?php endif; ?>
                                      </select>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="iddominio">Dominio del vehículo</label>
                                      <select class="form-control" id="iddominio" name="iddominio" required>
                                          <option value="">Seleccionar</option>
                                          <?php foreach ($vehiculos as $vehiculo): ?>
                                              <option value="<?php echo $vehiculo->id ?>" <?php if($vehiculo->id == $ordenesbInfo->iddominio) {echo "selected=selected";} ?>><?php echo $vehiculo->dominio . " - " .  $vehiculo->marca. ", " .  $vehiculo->modelo ?></option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div><!-- /.row -->
                          <br>

                          <div class ="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                     <label for="descrip">Descripción</label>
                             		   <textarea name="descrip" id="descrip" class="form-control" rows="3" cols="50" style="resize:none"><?= $ordenesbInfo->descrip; ?></textarea>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                        </div>
                    </form>
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
</script>

<script>
$( document ).ready(function() {
	$('#fecha_visita').datepicker({
		format: 'dd-mm-yyyy',
		language: 'es'
	});

	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('ordenesb/equiposajax')?>", {proyecto: valor})
		.done(function(data) {
			var result = JSON.parse(data);
			var option = '';
	 		$("#idequipo").html("");
	 		var previo = ""; var i = 0;
			result.forEach(function(equipo) {
				option = option + "<option ";
        option = option + 'style="color:DodgerBlue;" ';
				option = option + 'value="'+equipo['id']+'">'+equipo['serie']+'</option>';

				if (i+1 >= result.length) {
					option = option + "</optgroup>";
				} else {
					if (result[i+1]['descrip'] != equipo['descrip']) {
						option = option + "</optgroup>";
					}
				}
				i++;
			});
			$("#idequipo").append(option);
			$('.selectpicker').selectpicker('refresh');
		});
	});
});

</script>
