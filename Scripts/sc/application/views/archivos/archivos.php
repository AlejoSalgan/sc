<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/adjuntar_archivo.css'); ?>">


<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0;}
	.btn { margin-bottom:10px; }
</style>


<div class="content-wrapper">
  <div id="cabecera">
    <?=$titulo?>
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
			<a href="<?= base_url($regreso)?>"><?=$pagina?></a> /
      <span class="text-muted">Adjuntar Archivo</span>
    </span>
  </div>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <?php
							 $this->load->helper('form');
							 if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        <?php
					 if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos del archivo</h3>
            <span class="pull-right">

              <a data-toggle="modal" title="Ayuda" data-target="#modalAyuda"><i class="fa fa-question-circle text-info fa-lg"></i></a>
              <!-- sample modal content -->
              <div id="modalAyuda" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h4 class="modal-title" id="myModalLabel">Ayuda de Archivos</h4>
                    </div>
                    <div class="modal-body">
                      <div class="alert alert-info">
                        <strong>Guardar:</strong> Permite guardar los archivos para continuar mas tarde o seguir agregando antes de ser subido al sistema.
                      </div>

                      <div class="alert alert-success">
                        <strong>Cargar Archivos:</strong> Permite confirmar que los archivos precargados esten listos para que sean visibles en Ver Orden.
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-rounded" data-dismiss="modal">Aceptar</button>
                    </div>
                  </div>
                </div>
              </div>

            </span>
          </div><!-- /.box-header -->
          <form action="<?= base_url($guardar)?>" method="POST" enctype="multipart/form-data" name="myForm" data-toggle="validator">
            <input type="hidden" name="parametro" value="<?= $parametro?>">
						<input type="hidden" name="pagina_actual" value="<?= $pagina_actual?>">
						<input type="hidden" name="sector" value="<?= $sector?>">
						<input type="hidden" name="tabla" value="<?= $tabla?>">

            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                   <div class="form-group">
                       <label for="label_tipo_documentacion">Tipo</label>
                         <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-list" aria-hidden="true"></i></span>
                           <select class="form-control" name="tipo_documentacion" id="tipo_documentacion" required data-error="Seleccionar una opcion.">
                            <option value="">Seleccionar tipo</option>
                            <option value="1">Documento</option>
                            <option value="2">Remito</option>
                            <option value="3">Presupuesto</option>
                            <option value="4">Factura</option>
                            <option value="5">Informe</option>
                            <option value="6">Certificado</option>
                            <option value="7">Acta</option>
                          </select>
                         </div>
                        <div class="help-block with-errors"></div>
                    </div>
                 </div>

                <div class="col-md-6">
                   <div class="form-group">
                       <label id="label_nombre_archivo" for="label_nombre_archivo">Nombre</label>
                         <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-font" aria-hidden="true"></i></span>
                           <input id="nombre_archivo" name="nombre_archivo" type="text" class="form-control" data-error="Completar este campo." required autocomplete="off">
                         </div>
                        <div class="help-block with-errors"></div>
                    </div>
                 </div>
               </div>

              <div class="row">
                <div class="col-md-12">
                  <label for="ordencompra">Archivo adjunto</label>
                  <div class="input-group">
                    <label class="input-group-btn">
                      <span class="btn btn-primary">
                          Seleccionar Archivo <input type="file" style="display: none;" name="archivo" id="archivo">
                      </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                  </div>
                  <p class="help-block">Solo archivos PDF, WORD o EXCEL.</p>
                  <p class="help-block">Solo archivos menor o igual a 1MB.</p>
                </div>
              </div><!-- /.row -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="observ">Observaciones</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="3" cols="20" style="resize:none"><?=$this->session->flashdata('info')?></textarea>
                  </div>
                </div>
              </div><!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-labeled btn-primary" value="Guardar" ><span class="btn-label"><i class="fa fa-save"></i></span>Guardar</button>
              <a href="<?=base_url("{$cargar}/{$parametro}?pagina_actual={$pagina_actual}&tabla={$tabla}")?>" class="btn btn-labeled btn-success" <?= ($cant_archivos > 0) ? "" : "disabled" ?>><span class="btn-label"><i class="fa fa-upload"></i></span>Cargar Archivos</a>
            </div>
          </form>
        </div><!-- /.box -->
      </div>

      <div class="col-xs-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Archivos cargados </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php if ($cant_archivos > 0): ?>
              <?php foreach ($archivos as $archivo): ?>
              <li class="item">
                <div class="">
                  <strong> <?="<a href=".base_url("verPersonal/{$archivo->creado_por}").">" . $archivo->name . "</a>"; ?> </strong> <span class="pull-right"><?=date('d/m/Y - H:i:s',strtotime($archivo->fecha_ts))?></span>
                  <br>
                  <td><strong>Nombre: </strong><span class"text-muted"><?= ($archivo->nombre_archivo == NULL)? 'Sin titulo' : $archivo->nombre_archivo; ?></span></td>
                  <br>
                  <td><strong>Observacion: </strong><?=$archivo->observacion?></td>
                  <br>
									<td><strong>Tipo:
											</strong><?php switch ($archivo->tipo) {
																 case '.pdf': ?>
											<span class="label label-danger">PDF</span>
											<?php break;
																 case '.doc':
																 case '.docx': ?>
											<span class="label label-primary">WORD</span>
											<?php break;
																 case '.xls':
																 case '.xlsx': ?>
											<span class="label label-success">EXCEL</span>
											<?php break;
																		break;
																 default: ?>
											ERROR
											<?php break;
																 } ?>
								  </td>
                  <br>
                  <td>
                    <form action="<?=base_url($descargar)?>" method="post">
                      <input type="hidden" name="name" value="<?=$archivo->archivo?>">
                      <input type="hidden" name="tipo" value="<?=$archivo->tipo?>">
											<input type="hidden" name="parametro" value="<?= $parametro?>">
											<input type="hidden" name="pagina_actual" value="<?= $pagina_actual?>">
											<input type="hidden" name="sector" value="<?= $sector?>">
											<input type="hidden" name="nombre_archivo" value="<?= $archivo->nombre_archivo?>">

                      <button type="submit" id="descargar" class="link"><span>Descargar archivo</span></button> -
                      <a id="archivo_eliminar" href="<?=base_url("{$eliminar}/{$archivo->id}?pagina_actual={$pagina_actual}&parametro={$parametro}&sector={$sector}&tabla={$tabla}")?>">Eliminar archivo</a>
                    </form>
                  </td>
                </div>
              </li>
              <?php endforeach; ?>
              <?php else: ?>
              <p>No hay archivos para esta orden.</p>
              <?php endif; ?>
            </ul>
          </div>
        </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>

<script>
  $(document).ready(function() {

    $('#tipo_documentacion').on('change', function() {
      tipo_documentacion = $(this).val();
      switch (tipo_documentacion) {
        case "7":
          $("#label_nombre_archivo").hide();
          $("#nombre_archivo").hide();
          break;

        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
        case "6":
          $("#label_nombre_archivo").show();
          $("#nombre_archivo").show();
          break;
      }
    });
  });


  $(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });

});

</script>
