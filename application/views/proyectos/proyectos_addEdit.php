<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Proyectos - <?=$tipoItem?> proyecto
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('municipiosListing'); ?>"> Proyectos listado</a> /
        <span class="text-muted"><?=$tipoItem?> proyecto</span>
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
          <div class="col-xs-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalles</h3>
                </div>

                <form role="form" action="<?= base_url('agregar_editar_proyecto') ?>" method="post">
                  <input type="hidden" name="tipoItem" value="<?=$tipoItem?>">
                  <input type="hidden" name="id_proyecto" value="<?=$proyecto->id?>">


                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label id="label_nombre" for="label_nombre">Nombre</label>
                                <input id="nombre" name="nombre" type="text" class="form-control" autocomplete="off" value="<?=$proyecto->descrip?>">
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                <label id="label_iniclaes" for="label_iniclaes">Iniciales</label>
                                <input id="iniciales" name="iniciales" type="text" class="form-control" autocomplete="off" value="<?=$proyecto->iniciales?>">
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label id="label_codigo" for="label_codigo">Codigo de Municipio</label>
                                <input id="codigo" name="codigo" type="number" min="1" class="form-control" autocomplete="off" value="<?=$proyecto->codigo_municipio?>">
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                <label id="label_administracion" for="label_administracion">Adminstracion</label>
                                <input id="administracion" name="administracion" type="number" min="1"  class="form-control" autocomplete="off" value="<?=$proyecto->adminstracion?>">
                              </div>
                          </div>
                      </div>

                      <div class ="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="observaciones_gestor">Observaciones</label>
                                  <textarea name="observaciones" id="observaciones" class="form-control" rows="5" cols="50" style="resize:none"><?=$proyecto->observaciones?></textarea>
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
