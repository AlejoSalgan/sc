<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }
</style>


<div class="content-wrapper">
    <div id="cabecera">
      Bajada de memoria - Enlazar Orden
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Enlazar Orden
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

                <form role="form" action="<?= base_url('bajada_enlazar_orden') ?>" method="post">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Protocolo</label>
                              <input type="number" class="form-control" id="protocolo"  name="protocolo" maxlength="6" min="1" value="" required>
                          </div>
                        </div>


                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Proyecto</label>
                                <select class="form-control" id="idproyecto" name="idproyecto" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($proyectos as $proyecto): ?>
                                       <option value="<?= $proyecto->id; ?>" <?php if($proyecto->id == $solicitud->id_proyecto) {echo "selected=selected";} ?>><?= $proyecto->descrip ?></option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="idequipo"></i> Equipo</label>
                                  <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="<?= ($tipoItem == "Agregar") ? 'Seleccionar Equipo' : $periferico->EM_serie;?>" data-size="6">
                                  </select>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Buscar" />
                  </div>
                </form>

          </div>
        </div>
      </div>



      <?php if ($protocolo_unico > 0): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Protocolos</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">PROTOCOLO UNICO: <span class="text-primary"><?=$protocolo_unico->id?></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Equipo</th>
                 <th class="text-center">Fecha</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo_unico->id?></span></td>
                   <td class="text-center"><?=$protocolo_unico->equipo_serie?></td>
                   <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($protocolo_unico->fecha))?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo_unico->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo_unico->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo_unico->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo_unico->cantidad?></td>
                 </tr>
             </table>

             <br><br>

             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">PROTOCOLO DEL EQUIPO: <span class="text-primary"><?=$equipo?></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Equipo</th>
                 <th class="text-center">Fecha</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

               <?php foreach ($protocolos as $protocolo): ?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->id?></span></td>
                   <td class="text-center"><?=$protocolo->equipo_serie?></td>
                   <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($protocolo->fecha))?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
               <?php endforeach; ?>
             </table>
           </div>
        </div>


        </div>
      </div>
      <?php endif; ?>

      <?php if ($ordenes): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ordenes de bajada</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <tr class="info">
                 <th class="text-center">ID</th>
                 <th class="text-center">Equipo</th>
                 <th class="text-center">Fecha Visita</th>
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha Hasta</th>
                 <th class="text-center">Cantidad</th>
                 <th class="text-center">Procesado</th>
               </tr>

               <?php foreach ($ordenes as $orden): ?>
                 <tr>

                   <td class="text-center"><span class="label label-<?=($orden->ord_procesado == 0) ? "warning" : "primary" ;?> etiqueta14"><?=$orden->id?></span></td>
                   <td class="text-center"><?=$orden->serie?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($orden->fecha_visita))?></td>
                   <td class="text-center">
                     <?php if ($orden->protocolo): ?>
                       <span class="text-primary"><b><?=$orden->protocolo?></b></span>
                     <?php else: ?>
                       <span class="text-danger"><b>-</b></span>
                     <?php endif; ?>
                   </td>

                   <td class="text-center"><span class="text-success"><b><?=$orden->nro_msj?></b></span></td>

                   <td class="text-center">
                     <?php if ($orden->bajada_desde): ?>
                       <?=date('d/m/Y - H:i',strtotime($orden->bajada_desde))?>
                     <?php else: ?>
                       <span class="text-danger"><b>-</b></span>
                     <?php endif; ?>
                   </td>

                   <td class="text-center">
                     <?php if ($orden->bajada_hasta): ?>
                       <?=date('d/m/Y - H:i',strtotime($orden->bajada_hasta))?>
                     <?php else: ?>
                       <span class="text-danger"><b>-</b></span>
                     <?php endif; ?>
                   </td>

                   <td class="text-center">
                     <?php if ($orden->bajada_archivos): ?>
                       <?=$orden->bajada_archivos?>
                     <?php else: ?>
                       <span class="text-danger"><b>-</b></span>
                     <?php endif; ?>
                   </td>

                   <td class="text-center text-<?= ($orden->ord_procesado == 0) ? "danger" : "primary" ;?>"> <?=$orden->ord_procesado?></td>
                 </tr>
               <?php endforeach; ?>


             </table>
           </div>
        </div>
      </div>
      </div>
      <?php endif; ?>




      <?php if ($protocolo_unico): ?>
      <div class="row">
        <div class="col-xs-12">
          <form role="form" action="<?= base_url('actualizar_orden') ?>" method="post">

          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Actualizar</h3>
              </div>

                <div class="box-body">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Protocolo</label>
                            <input type="number" class="form-control" id="protocolo2"  name="protocolo2" maxlength="6" min="1" value="" required>
                        </div>
                      </div>


                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="idproyecto">Nº Orden</label>
                            <input type="number" class="form-control" id="id_orden"  name="id_orden" maxlength="6" min="1" value="" required>
                        </div>
                      </div>
                </div>

        </div>

        <div class="box-footer">
            <input type="submit" class="btn btn-primary" value="Actualizar" />
        </div>

        </form>

      </div>
      </div>
      <?php endif; ?>


    </section>
</div>



<script>
$( document ).ready(function() {
	$("#idproyecto").change(function () {
		valor = $(this).val();
		$.post("<?=base_url('equipos_enlace')?>", {proyecto: valor})
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
