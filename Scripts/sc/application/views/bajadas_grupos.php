<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$BMgrupoSE = explode(',', $bajada_grupoSE);
$BMgrupoSR = explode(',', $bajada_grupoSR);
$BMgrupoSP = explode(',', $bajada_grupoSP);

?>

<style>
iframe {
  display: none;
}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Bajada de Memorias - Grupos
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Grupos</span>
      </span>
    </div>


    <section class="content">
      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><span class="label label-primary" style=" font-size:14px;"><?= $cantidad_sinEnviar;?></span>&nbsp;&nbsp;&nbsp;Proyectos sin enviar</a></li>
            <li><a href="#tab_2" data-toggle="tab"><span class="label label-primary" style=" font-size:14px;"><?= $cantidad_sinRecibir;?></span>&nbsp;&nbsp;&nbsp;Proyectos sin recibir</a></li>
            <li><a href="#tab_3" data-toggle="tab"><span class="label label-primary" style=" font-size:14px;"><?= $cantidad_sinProcesar;?></span>&nbsp;&nbsp;&nbsp;Proyectos sin procesar</a></li>
          </ul>

          <div class="tab-content no-padding">
            <div class="tab-pane active" id="tab_1">
              <div class="row barra" style="display:none;">
                <div class="col-md-12">
                  <strong style="color: red;">Procesando... por favor espere.</strong>
                  <div class="progress">
                    <div id="barraprogreso" class="progress-bar progress-bar-striped active" role="progressbar" style="width:0%">0%</div>
                  </div>
                </div>
              </div>
              <div class="table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <tr class="info">
                    <th class="text-center">Equipos</th>
                    <th class="text-center">Proyecto</th>
                    <th class="text-center">Nro Ordenes</th>
                    <th class="text-center">Conductor</th>
                    <th class="text-center">Técnico</th>
                    <th class="text-center">Vehículo</th>
                    <th class="text-center">Fecha de Visita</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  <?php foreach ($gruposRecords as $record):
                      $fecha_visita = new DateTime($record->fecha_visita);
                      if ($record->tecnico == 51 || $record->tecnico == 59 || $record->tecnico == 80 || $record->tecnico == 117) {
                        $fecha_visita->add(new DateInterval('P8D'));
                      } else {
                        $fecha_visita->add(new DateInterval('P4D'));
                      }
                      $fecha_hoy = new DateTime(date());
                      if ($fecha_visita > $fecha_hoy){
                          $tr = "<tr>";
                      }else{
                          $tr = "<tr>";
                      }

                      echo $tr;
                      $recibidoGSE = 0;
                      ?>

                      <td class="text-center"><span class="label label-primary" style=" font-size:14px;"><?= $record->cantidad;?></span></td>
                      <td class="text-center"><?= $record->descripProyecto;?></td>
                      <td class="text-center"><?= ($record->orden_min == $record->orden_max) ? $record->orden_max : "$record->orden_min - $record->orden_max" ;?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->conductor}").">" . $record->nameConductor . "</a>"; ?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->tecnico}").">" . $record->nameTecnico . "</a>"; ?></td>
                      <td class="text-center"><?= $record->dominio;?></td>
                      <td class="text-center"><?= $this->fechas->cambiaf_a_arg($record->fecha_visita);?></td>
                      <td>
                        <?php if($BMgrupoSE[0] == 1) { ?>
                            <a data-toggle="tooltip" title="Ver detalle" href="<?php echo base_url().'grupos_equipos/'.$recibidoGSE.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php } ?>

                        <?php if($BMgrupoSE[1] == 1) { ?>
                            <a data-toggle="tooltip" title="Editar" href="<?php echo base_url().'grupos_edit/'.$recibidoGSE.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php } ?>

                        <?php if($BMgrupoSE[2] == 1) { ?>
                            <button class="btn btn-link btn-xs enviarTodo" type="button" data-toggle="tooltip" data-cantidad="<?=$record->cantidad?>" data-tecnico="<?=$record->tecnico?>" data-idproyecto="<?=$record->idproyecto?>" data-fecha_visita="<?=$record->fecha_visita?>" title="Enviar Ordenes"><i class="fa fa-share-square-o"></i></button>
                        <?php } ?>
                       		<?php /* <a data-toggle="tooltip" class="fa fa-print" title="Imprimir" type="button" onclick="frames['frame'].print()" class="btn btn-primary btn-sm"></a> */?>

                      <?php

                        /* Boton para imprimir a futuro la Orden de servicio retiro de memoria
                        <iframe src="<?php echo base_url().'grupos_equipos/'.$recibidoGSE.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>" name="frame"></iframe> */
                        ?>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>

            <div class="tab-pane" id="tab_2">
              <div class="table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <tr class="info">
                    <th class="text-center">Equipos</th>
                    <th class="text-center">Proyecto</th>
                    <th class="text-center">Nro Ordenes</th>
                    <th class="text-center">Conductor</th>
                    <th class="text-center">Técnico</th>
                    <th class="text-center">Vehículo</th>
                    <th class="text-center">Fecha de Visita</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  <?php foreach ($gruposSR as $record):
                      $fecha_visita = new DateTime($record->fecha_visita);
                      if ($record->tecnico == 51 || $record->tecnico == 59 || $record->tecnico == 80 || $record->tecnico == 117) {
                        $fecha_visita->add(new DateInterval('P8D'));
                      } else {
                        $fecha_visita->add(new DateInterval('P4D'));
                      }
                      $fecha_hoy = new DateTime(date());
                      if ($fecha_visita > $fecha_hoy){
                          $tr = "<tr>";
                      }else{
                          $tr = "<tr class='danger'>";
                      }

                      echo $tr;
                      $recibidoGSR = 2;
                      ?>

                      <td class="text-center"><span class="label label-primary" style=" font-size:14px;"><?= $record->cantidad;?></span></td>
                      <td class="text-center"><?= $record->descripProyecto;?></td>
                      <td class="text-center"><?= ($record->orden_min == $record->orden_max) ? $record->orden_max : "$record->orden_min - $record->orden_max" ;?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->conductor}").">" . $record->nameConductor . "</a>"; ?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->tecnico}").">" . $record->nameTecnico . "</a>"; ?></td>
                      <td class="text-center"><?= $record->dominio;?></td>
                      <td class="text-center"><?= $this->fechas->cambiaf_a_arg($record->fecha_visita);?></td>
                      <td>
                        <?php if($BMgrupoSR[0] == 1) { ?>
                            <a data-toggle="tooltip" title="Ver detalle" href="<?php echo base_url().'grupos_equipos/'.$recibidoGSE.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php } ?>

                        <?php if($BMgrupoSR[1] == 1) { ?>
                            <a data-toggle="tooltip" title="Cancelar Envio" href="<?php echo base_url().'cancelarEnvOrdenesG/'.$recibidoGSR.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>" data-ordenesbid="<?php echo $record->id; ?>" class="cancelarEnvOrdenesG"><i class="fa fa-times text-danger"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>

            </div>

            <div class="tab-pane" id="tab_3">
              <div class="table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <tr class="info">
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Proyecto</th>
                    <th class="text-center">Nro Ordenes</th>
                    <th class="text-center">Conductor</th>
                    <th class="text-center">Técnico</th>
                    <th class="text-center">Vehículo</th>
                    <th class="text-center">Fecha de Visita</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  <?php foreach ($gruposSP as $record):
                      $fecha_visita = new DateTime($record->fecha_visita);
                      if ($record->tecnico == 51 || $record->tecnico == 59 || $record->tecnico == 80 || $record->tecnico == 117) {
                        $fecha_visita->add(new DateInterval('P8D'));
                      } else {
                        $fecha_visita->add(new DateInterval('P4D'));
                      }
                      $fecha_hoy = new DateTime(date());
                      if ($fecha_visita > $fecha_hoy){
                          $tr = "<tr>";
                      }else{
                          $tr = "<tr class='danger'>";
                      }

                      echo $tr;
                      $recibidoGSP = 1;
                      ?>

                      <td class="text-center"><span class="label label-primary" style=" font-size:14px;"><?= $record->cantidad;?></span></td>
                      <td class="text-center"><?= $record->descripProyecto;?></td>
                      <td class="text-center"><?= ($record->orden_min == $record->orden_max) ? $record->orden_max : "$record->orden_min - $record->orden_max" ;?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->conductor}").">" . $record->nameConductor . "</a>"; ?></td>
                      <td class="text-center"><?="<a href=".base_url("verPersonal/{$record->tecnico}").">" . $record->nameTecnico . "</a>"; ?></td>
                      <td class="text-center"><?= $record->dominio;?></td>
                      <td class="text-center"><?= $this->fechas->cambiaf_a_arg($record->fecha_visita);?></td>
                      <td>
                        <?php if($BMgrupoSP[0] == 1) { ?>
                            <a data-toggle="tooltip" title="Ver detalle" href="<?php echo base_url().'grupos_equipos/'.$recibidoGSE.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>	
                        <?php } ?>

                        <?php if($BMgrupoSP[1] == 1) { ?>
                            <a data-toggle="tooltip" title="Cancelar Envio" href="<?php echo base_url().'cancelarEnvOrdenesG/'.$recibidoGSP.'/'.$record->tecnico.'/'.$record->idproyecto.'/'.$record->fecha_visita; ?>" data-ordenesbid="<?php echo $record->id; ?>" class="cancelarEnvOrdenesG"><i class="fa fa-times text-danger"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
         </div>
    </section>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('ul.pagination li a').click(function (e) {
			e.preventDefault();
			var link = jQuery(this).get(0).href;
			var value = link.substring(link.lastIndexOf('/') + 1);
			$("#searchList").attr("action", baseURL + "gruposBajada/" + value);
            $("#searchList").submit();
		});

		function animarBarra(cantidad) {
			avance = Math.round(parseInt(100/cantidad));
			var contador = 0;
			$(".barra").show();
			setInterval(function(){
				$("#barraprogreso").html(contador+"%");
				$("#barraprogreso").css("width",contador+"%");
				contador = contador + avance;
			}, 2000);
		}

		$("button.enviarTodo").click(function() {
			$("button.enviarTodo").attr("disabled",true);
			$("button.enviarTodo").css("color", "grey");
			animarBarra($(this).data("cantidad"));
			ruta = "<?=base_url("enviarTodo")?>/"+$(this).data("tecnico")+"/"+$(this).data("idproyecto")+"/"+$(this).data("fecha_visita")
			$.post(ruta)
			.done(function( data ) {
				dataobj = JSON.parse(data);
				if (dataobj['status'] == false) {
					alert("Error 411: error en la transacción al enviar las órdenes. No siga procesando órdenes. Consulte al administrador del sistema. ");
				}
				window.location.replace("<?=base_url("gruposSE")?>");
			});
		});

	});
</script>
