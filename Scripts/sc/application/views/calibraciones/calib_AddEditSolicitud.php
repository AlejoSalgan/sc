<?php
$calibId              = '';
$fecha_alta           = '';
$municipioId          = '';
$descripProyecto      = '';
$idequipo             = '';
$equipoSerie          = '';
$direccion            = '';
$tipo_equipo          = '';
$tipoEquipo           = '';
$Velocidad            = '';
$multicarril          = '';
$tipo_servicio        = '';
$tipo_ver             = '';
$prioridad            = '';
$descripPrioridad     = '';
$fecha_desde          = '';
$fecha_hasta          = '';
$observaciones_gestor = '';
$activo               = '';

foreach ( $calibInfo as $ef ) {
    $calibId              = $ef->id;
    $fecha_alta           = $ef->fecha_alta;
    $municipioId          = $ef->idproyecto;
    $descripProyecto      = $ef->descripProyecto;
    $idequipo             = $ef->idequipo;
    $equipoSerie          = $ef->equipoSerie;
    $direccion            = $ef->direccion;
    $tipo_equipo          = $ef->tipo_equipo;
    $tipoEquipo           = $ef->tipoEquipo;
    $velocidad            = $ef->velocidad;
    $multicarril          = $ef->multicarril;
    $tipo_servicio        = $ef->tipo_servicio;
    $tipo_ver             = $ef->tipo_ver;
    $prioridad            = $ef->prioridad;
    $descripPrioridad     = $ef->descripPrioridad;
    $fecha_desde          = $ef->fecha_desde;
    $fecha_hasta          = $ef->fecha_hasta;
    $observaciones_gestor = $ef->observaciones_gestor;
    $activo               = $ef->activo;
}

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		<?=$tipoItem?> Solicitud
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('calibraciones_solicitudes')?>">Solicitud de Calibraciones</a> /
  		  <span class="text-muted"><?=$tipoItem?> Solicitud </span>
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
        <div class="col-xs-8">
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Detalles</h3>
              </div>

              <form role="form" id="addSoli" action="<?php echo base_url() ?>agregar_editar_SG" method="post" role="form">
                  <input type="hidden" class="form-control" id="calibId" name="calibId" value="<?= $calibId ?>" >
                  <input type="hidden" class="form-control" id="tipoItem" name="tipoItem" value="<?= $tipoItem ?>" >
                  <?php if ($tipoItem == "Editar"): ?>
                    <input type="hidden" value="<?= $municipioId; ?>" name="idproyecto" id="idproyecto" />
                    <input type="hidden" value="<?= $idequipo; ?>" name="idequipo" id="idequipo" />
                  <?php endif; ?>

                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="idproyecto">Proyecto</label>
                                  <?php if ($tipoItem == "Agregar"): ?>
                                    <select class="form-control" id="idproyecto" name="idproyecto" autofocus="">
                                        <option value="0">Seleccionar</option>
                                        <?php foreach ($municipios as $municipio): ?>
                                          <option value="<?= $municipio->id ?>"><?= $municipio->descrip ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                  <?php else: ?>
                                    <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $descripProyecto?>" readonly>
                                    <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto" />
                                  <?php endif; ?>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <?php if ($tipoItem == "Agregar"): ?>
                                    <label for="idequipo">Equipo serie</label>
                                    <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccione los equipos..." data-size="6" required>
                                    </select>
                                  <?php else: ?>
                                    <label for="equipoSerie">Equipo serie</label>
                                    <input type="text" class="form-control" id="equipoSerie" name="equipoSerie" value="<?= $equipoSerie ?>" readonly>
                                    <input type="hidden" value="<?= $idequipo; ?>" name="idequipo" id="idequipo" />
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                  </div><!-- /.box-body -->

                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="tipo_servicio">Tipo de Servicio</label>
                                  <select class="form-control" id="tipo_servicio" name="tipo_servicio" required>
                                    <option value="">Seleccionar Servicio</option>
                                    <?php foreach ($servicios as $servicio): ?>
                                      <option value="<?= $servicio->id ?>" <?php if($servicio->verificacion == $tipo_ver) {echo "selected=selected";} ?>><?= $servicio->verificacion ?></option>
                                    <?php endforeach; ?>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="prioridad">Prioridad</label>
                                  <select class="form-control" id="prioridad" name="prioridad" required>
                                    <option value="">Seleccionar Prioridad</option>
                                    <?php foreach ($prioridades as $prioridad): ?>
                                      <option value="<?= $prioridad->id ?>" <?php if($prioridad->descrip == $descripPrioridad) {echo "selected=selected";} ?>><?= $prioridad->descrip ?></option>
                                    <?php endforeach; ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div><!-- /.box-body -->

                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="fecha_desde">Fecha Desde</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                      <input id="fecha_desde" name="fecha_desde" type="text" class="form-control" autocomplete="off" aria-describedby="fecha"
                                      <?php if ($tipoItem == "Agregar"): ?>
                                        placeholder="Seleccionar fecha" required
                                      <?php else: ?>
                                        value="<?= $fecha_desde; ?>"
                                      <?php endif; ?>
                                      >
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="fecha_hasta">Fecha Hasta</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                      <input id="fecha_hasta" name="fecha_hasta" type="text" class="form-control" autocomplete="off" aria-describedby="fecha"
                                      <?php if ($tipoItem == "Agregar"): ?>
                                        placeholder="Seleccionar fecha" required
                                      <?php else: ?>
                                        value="<?= $fecha_hasta; ?>"
                                      <?php endif; ?>
                                       >
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div><!-- /.box-body -->

                  <div class="box-body">
                      <div class ="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="observaciones_gestor">Observaciones</label>
                                  <textarea name="observaciones_gestor" id="observaciones_gestor" class="form-control" rows="5" cols="50" style="resize:none"><?= $observaciones_gestor; ?> </textarea>
                              </div>
                          </div>
                      </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Guardar" />
                  </div>
          </div>
        </div>

        <div class="col-xs-4">
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Informacion del equipo</h3>
              </div><!-- /.box-header -->

              <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                            <?php if ($tipoItem == "Agregar"): ?>
                              placeholder="Direccion del equipo"
                            <?php else: ?>
                              value="<?= $direccion ?>"
                            <?php endif; ?>
                            readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="tipo_equipo">Tipo</label>
                          <input type="hidden" id="idtipo_equipo" name="tipo_equipo" value="">
                          <input type="text" class="form-control" id="tipo_equipo"
                          <?php if ($tipoItem == "Agregar"): ?>
                            placeholder="Tipo del equipo" required
                          <?php else: ?>
                            value="<?= $tipoEquipo ?>"
                          <?php endif; ?>
                            readonly>
                      </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="velper">Velocidad permitida</label>
                            <input type="text" class="form-control" id="velper" name="velper"
                            <?php if ($tipoItem == "Agregar"): ?>
                              placeholder="Velocidad permitida del equipo"
                            <?php else: ?>
                              value="<?= $velocidad ?>"
                            <?php endif; ?>
                            readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="multicarril">Carriles</label>
                          <input type="text" class="form-control" id="multicarril" name="multicarril"
                          <?php if ($tipoItem == "Agregar"): ?>
                            placeholder="Carriles" required
                          <?php else: ?>
                            value="<?= $multicarril ?>"
                          <?php endif; ?>
                          readonly>
                      </div>
                  </div>
                </div>

              </div>
            </div>
        </div>
      </form>

      </div>
    </section>

</div>

<script>
    $(function() {
        $('#fecha_desde').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '0',
            language: 'es'
        });

        $('#fecha_hasta').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '0',
            language: 'es'
        });
    });

    $("#idproyecto").change(function () {
        valor = $(this).val();
        $.post("<?=base_url('equipos_calibrar')?>", {proyecto: valor})
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

    $('#idequipo').on('change', function() {
		var valor = $(this).val();
		$.post("<?=base_url('equipos/getequipo')?>", {idequipo: valor[0]})
		.done(function(data) {
			var result = JSON.parse(data);
			direccion = result["ubicacion_calle"]+" "+result["ubicacion_altura"]+" "+result["ubicacion_localidad"];
			$("#direccion").val(direccion);
			$("#tipo_equipo").val(result["descrip"]);
			$("#idtipo_equipo").val(result["et_id"]);
			$("#velper").val(result["ubicacion_velper"]);
			if (result["multicarril"]==0) {
				$("#multicarril").val('0');
			} else {
				$("#multicarril").val(result["multicarril"]);
			}
		});
	});
</script>
