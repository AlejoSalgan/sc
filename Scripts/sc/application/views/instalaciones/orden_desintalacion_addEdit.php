<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - <?=$tipoItem?> Desintalacion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('ordenes_desintalacion'); ?>"> Desintalacion listado</a> /
        <span class="text-muted"><?=$tipoItem?> Desintalacion
    </div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    if ($this->session->flashdata('error')): ?>
                      <div class="alert alert-danger alert-dismissable" style="position: relative; bottom: 5px;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                <?php
                if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable" style="position: relative; bottom: 5px; ">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalles</h3>
                </div>

                <form role="form" action="<?= base_url('agregar_editar_orden_desintalacion') ?>" method="post">
                  <input type="hidden" name="tipoItem" value="<?=$tipoItem?>">
                  <input type="hidden" name="id_orden" value="<?=$orden->id?>">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Proyecto</label>
                              <?php if ($tipoItem == 'Agregar'): ?>
                                <select class="form-control" id="idproyecto" name="idproyecto" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($proyectos as $proyecto): ?>
                                       <option value="<?= $proyecto->id; ?>" <?php if($proyecto->id == $solicitud->id_proyecto) {echo "selected=selected";} ?>><?= $proyecto->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                              <?php else: ?>
                                <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?=$orden->proyecto?>" readonly>
                                <input type="hidden" name="idproyecto" id="idproyecto" value="<?= $orden->id_proyecto; ?>"/>
                              <?php endif; ?>

                          </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="idequipo"></i> Equipo</label>
                                <?php if ($tipoItem == 'Agregar'): ?>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="<?= ($tipoItem == "Agregar") ? 'Seleccionar Equipo' : $periferico->EM_serie;?>" data-size="6">
                                  </select>
                                <?php else: ?>
                                  <input type="text" class="form-control" id="equipo" name="equipo" value="<?=$orden->equipoSerie?>" readonly>
                                  <input type="hidden" name="idEquipo" id="idEquipo" value="<?= $orden->id_equipo; ?>"/>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Prioridad</label>
                              <select class="form-control" id="prioridad" name="prioridad" required>
                                  <option value="">Seleccionar</option>
                                  <?php foreach ($prioridades as $prioridad): ?>
                                     <option value="<?= $prioridad->id; ?>" <?php if($prioridad->id == $orden->id_prioridad) {echo "selected=selected";} ?>><?= $prioridad->tipo_prioridad ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                    </div>

                    <div class ="row">
                        <div class="col-md-6">
                            <div class="form-group">
                             <label for="descrip">Observacion</label>
                             <textarea name="observaciones" id="observaciones" class="form-control" rows="3" cols="50" style="resize:none"><?= $orden->observaciones; ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="descrip">Motivo</label>
                             <textarea name="motivo" id="motivo" class="form-control" rows="3" cols="50" style="resize:none" required><?= $orden->motivo; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4 class="box-title">Elementos</h4>

                    <div class="row">
                      <?php foreach ($elementos as $elemento): ?>
                        <div class="col-lg-4">
                          <div class="input-group">
                            <span class="input-group-addon">
                              <input type="checkbox" name="<?=$elemento->id?>" value="<?=$elemento->id?>" <?php if(in_array($elemento->id, $elementos_asignados)) {echo 'checked';} ?>>
                            </span>
                            <input type="text" class="form-control" value="<?=$elemento->elemento?>" readonly>
                          </div>
                          <!-- /input-group -->
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                             <label for="descrip">Detalles</label>
                           <textarea name="elementos_detalles" id="elementos_detalles" class="form-control" rows="3" cols="50" style="resize:none"><?= $orden->elementos_detalles; ?></textarea>
                          </div>
                      </div>
                    </div>

                    <hr>
                    <h4 class="box-title">Destino de los Elementos</h4>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="radio">
                            <label>
                              <input type="radio" name="destino" id="destino" value="0" <?php if($orden->destino == 0) {echo 'checked';} ?>>
                              Custodia
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="destino" id="destino" value="1" <?php if($orden->destino == 1) {echo 'checked';} ?>>
                              A disposicion
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                             <label for="descrip">Detalles</label>
                           <textarea name="destino_detalle" id="destino_detalle" class="form-control" rows="3" cols="50" style="resize:none"><?= $orden->destino_detalle; ?></textarea>
                          </div>
                      </div>
                    </div>

                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Guardar" />
                  </div>

                </form>
            </div>
          </div>
        </div>
    </section>
</div>



<script>
$( document ).ready(function() {

	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('desintalacion_equipos')?>", {proyecto: valor})
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
