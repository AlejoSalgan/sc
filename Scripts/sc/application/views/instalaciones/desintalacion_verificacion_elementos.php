<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - Verificacion Elementos
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
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Detalles</h3>
             </div>
             <div class="box-body table-responsive no-padding">
                 <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>ID</td>
                        <td><span class="text-primary"><?=$orden->id?></span></td>
                      </tr>
                      <tr>
                        <td>Tipo</td>
                        <td><span class="text-primary"><?= $orden->tipoOrden;?></span></td>
                      </tr>
                      <tr>
                        <td>Solicitado por</td>
                        <td><?= "<a href=".base_url("verPersonal/{$orden->solicitado_por}").">" .$orden->solicitado_name. "</a>"; ?></td>
                      </tr>
                      <tr>
                        <td>Ultima modificacion</td>
                        <td><?=date('d/m/Y - H:i:s',strtotime($orden->fecha_ts))?></td>
                      </tr>

                    </tbody>
                  </table>
             </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Informacion</h3>
             </div>
             <div class="box-body table-responsive no-padding">
                 <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>Equipo</td>
                        <td><span class="text-primary"><?=$orden->equipoSerie ?></span></td>
                      </tr>

                      <tr>
                        <td>Proyecto</td>
                        <td><?=$orden->proyecto?></td>
                      </tr>

                      <tr>
                        <td>Proridad</td>
                        <td><span class="label label-<?= $orden->prioridad_label;?>"><?= $orden->tipo_prioridad;?></span></td>
                      </tr>

                    </tbody>
                  </table>
             </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Listado de Elementos</h3>
                </div>

                <form role="form" action="<?= base_url('reutilizacion_elementos') ?>" method="post">
                  <input type="hidden" name="id_orden" value="<?=$orden->id?>">
                  

                  <div class="box-body">
                    <p>Marcar los elementos que son reutilizables, los desmarcados quedaron marcados como descarte.</p>

                    <div class="row">
                      <?php foreach ($elementos as $elemento): ?>
                        <div class="col-lg-4">
                          <div class="input-group">
                            <span class="input-group-addon">
                              <input type="checkbox" name="<?=$elemento->id?>" value="<?=$elemento->id?>" <?php if(in_array($elemento->id, $elementos_verificados)) {echo 'checked';} ?>>
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
                             <label for="descrip">Observacion</label>
                           <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="50" style="resize:none"></textarea>
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
