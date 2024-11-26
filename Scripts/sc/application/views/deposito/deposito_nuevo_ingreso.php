<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
     <div id="cabecera">
   		Deposito - Nuevo Ingreso
   		<span class="pull-right">
   			<a href="<?=base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?=base_url("ingresos_listado")?>">Listado Ingresos</a> /
        <span class="text-muted">Nuevo Ingreso</span>
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
              <?php if ($this->session->flashdata('success')): ?>
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
                  <h3 class="box-title">Detalles</h3>
              </div>

              <form role="form" action="<?= base_url('nuevo_recibir') ?>" method="post">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label id="label_icono" for="label_icono">Proyecto</label>
                              <select class="form-control" id="idproyecto" name="idproyecto" required>
                                  <option value="">Seleccionar Proyecto</option>
                                  <option value="0" style="color:red;">Sin proyecto</option>
                                  <?php foreach ($municipios as $municipio): ?>
                                     <option value="<?= $municipio->id; ?>" <?php if($municipio->id == $ordenesbInfo->idproyecto) {echo "selected=selected";} ?>><?= $municipio->descrip ?></option>
                                  <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label id="label_tipo" for="label_tipo">Equipos</label>
                              <select class="form-control select2" multiple="multiple" data-placeholder="   Seleccionar Equipos" name="idequipo[]" id="idequipo">
                              </select>
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

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informacion</h3>
            </div>
            <div class="box-body">
              <p><strong>Proyecto:</strong> Listado de todos los Proyectos del SC. <br>
                <strong>*Sin Proyecto:</strong> En esta selección mostrara los Equipos que no tengan asignado un proyecto.
              </p>

              <p><strong>Equipos:</strong> Es el listado de los Equipos según el Proyecto seleccionado anteriormente. <br>
                Se pueden seleccionar varios Equipos. <br>
                Despues de la serie del Equipo aparece, separado por un guion (-) el lugar donde se encuentra el mismo.
              </p>

              <p><strong>Ingreso</strong>
                <br>En esta pagina se seleccionaron los Equipos que esten en condiciones de ingresar al area de Deposito. Las condiciones son la siguientes:
                <ul>
                  <li>Que el Equipo no tenga una orden de Reparación o del Socio.</li>
                  <li>Que el Remito del Equipo no exista en Ingreso, Custodia o Egreso.</li>
                  <li>Que el Equipo este como lugar Deposito o Proyecto y no tenga una orden abierta o Remito.</li>
                </ul>
              </p>

              <p><strong>Informacion</strong><br>
                Otra informacion para tener en cuenta:
                <ul>
                  <li>Si un Equipo esta fisicamente en el Proyecto, no tiene una orden de Reparacion ni esta en el Socio, y se hace el ingreso correspondiente esto ocasionara que no se pueda realizar una bajada de memoria en el futuro o se cancele la orden que esta en proceso, por favor verificar que el Equipo se encuentre en CECAITRA primero.</li>
                  <li>Debido a que el modulo de Deposito es uno de los ultimos de integrarse al Sistema del SC, puede ser que en el listado de Equipos figure lugar Deposito pero no existe un registro en este sector. Si este es el caso haga el ingreso correspondiente con sus detalles para seguir su trazabilidad.</li>
                  <li>Si no le deja hacer el ingreso de un Equipo es muy seguro que lo pueda tener otro sector. Si el Equipo lo tiene fisicamente para ingresar a Deposito pero no esta en el menu de Ingreso, es posible que el sector que lo tenia no haya hecho la accion de enviarlo, por favor solicitarlo para seguir su circuito.</li>
                </ul>
              </p>
            </div>
          </div>
        </div>
      </div>

    </section>
 </div>

 <script>
   $(function () {
     //Initialize Select2 Elements
     $('.select2').select2()
   })


   $("#idproyecto").change(function () {
 		valor = $(this).val();
 		$.post("<?=base_url('destinoDeposito')?>", {proyecto: valor})
 		.done(function(data) {
 			var result = JSON.parse(data);
 			var option = '';
 			result.forEach(function(equipo) {
 				option += '<option value="'+equipo['id']+'">'+equipo['serie']+' - '+equipo['estado_descrip']+'</option>';
         option += "</optgroup>";
 			});
 			$("#idequipo").append(option);
 			$('.selectpicker').selectpicker('refresh');
 		});
 	});
 </script>
