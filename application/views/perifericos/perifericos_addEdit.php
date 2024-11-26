<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Perifericos - <?=$tipoItem?> periferico
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('perifericos_listado'); ?>"> Perifericos listado</a> /
        <span class="text-muted"><?=$tipoItem?> periferico</span>
      </span>
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

                <form role="form" action="<?= base_url('agregar_editar_perifericos') ?>" method="post">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label id="label_icono" for="label_icono">Serie</label>
                              <input type='text' class="form-control" id="serie" name="serie" <?= ($tipoItem == "Agregar") ? "required" : "readonly" ;?> value="<?=$periferico->serie?>"/>
                              <input type="hidden" name="tipoItem" value="<?= $tipoItem; ?>"/>
                              

                              <?php if ($tipoItem == "Editar"): ?>
                                <input type="hidden" name="id_periferico" value="<?= $periferico->id; ?>"/>
                                <input type="hidden" name="idEquipo" value="<?= $periferico->id_equipo; ?>"/>
                              <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Tipo</label>
                              <select class="form-control" id="id_tipo" name="id_tipo" required>
                                  <option value="">Seleccionar</option>
                                  <?php foreach ($tipos_periferico as $tipo_periferico): ?>
                                     <option value="<?php echo $tipo_periferico->id; ?>" <?php if($tipo_periferico->id == $periferico->id_tipo) {echo "selected=selected";} ?>><?php echo $tipo_periferico->nombre_tipo ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Socio</label>
                              <select class="form-control" id="socio" name="socio" required>
                                  <option value="">Seleccionar</option>
                                  <?php foreach ($asociados as $asociado): ?>
                                     <option value="<?php echo $asociado->id; ?>" <?php if($asociado->id == $periferico->socio) {echo "selected=selected";} ?>><?php echo $asociado->descrip ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                        </div>
                    </div>



                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="idproyecto">Proyecto</label>
                                <select class="form-control" id="idproyecto" name="idproyecto">
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($proyectos as $proyecto): ?>
                                       <option value="<?php echo $proyecto->id; ?>" <?php if($proyecto->id == $periferico->municipio) {echo "selected=selected";} ?>><?php echo $proyecto->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="idequipo"></i> Equipo</label>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="<?= ($tipoItem == "Agregar") ? 'Seleccionar Equipo' : $periferico->EM_serie;?>" data-size="6">
                                  </select>
                              </div>
                          </div>
                      </div>

                      <div class ="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                 <label for="descrip">Observacion</label>
                               <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"><?= $periferico->observacion; ?></textarea>
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
		$.post("<?=base_url('perifericos_equipos')?>", {proyecto: valor})
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
