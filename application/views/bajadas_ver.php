<style type="text/css">
@media print {
  a[href]:after {
    content: none !important;
  }
}
@media print {
  #botonImprimir {
    display: none;
  }
}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Bajada de memoria - Orden Nº <?= $bajada->idbajada?>
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <a href="javascript:history.go(-1)">Ordenes Listado</a> /
      <span class="text-muted">Ver Orden</span>
    </span>
  </div>

  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">
            <?="$bajada->equipoSerie - $bajada->descripProyecto"?>
            </h3>
         </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-<?=$color?>">
          <div class="box-header with-border">
            <h3 class="box-title">
              Estado: <?=$estado?>
            </h3>
         </div>
        </div>
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
                    <td>Nº Orden</td>
                    <td><span class="text-primary"><?=$bajada->idbajada?></span></td>
                  </tr>
                  <tr>
                    <td>Fecha de Creacion</td>
                    <td><?=date('d/m/Y - H:i:s',strtotime($bajada->fecha_alta))?></td>
                  </tr>
                  <tr>
                    <td>Creado por</td>
                    <td><?= "<a href=".base_url("verPersonal/{$bajada->creadopor}").">" .$bajada->nameCreadoPor. "</a>"; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Observacion</td>
                  </tr>
                  <tr>
                    <td colspan="2"><?=($ordenesbInfo->descrip == NULL) ? "Sin observaciones": $bajada->descrip;?></td>
                  </tr>
                </tbody>
              </table>
         </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Informacion de la Orden</h3>
         </div>
         <div class="box-body table-responsive no-padding">
             <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Fecha de Enviado</td>

                    <td><?=($bajada->enviado_fecha == "") ? "<span class='text-danger'>No se envío la orden de bajada</span>": date('d/m/Y - H:i:s',strtotime($bajada->enviado_fecha));?></td>
                  </tr>

                  <tr>
                    <td>Fecha de Recibido</td>
                    <td><?=($bajada->recibido_fecha == "") ? "<span class='text-danger'>No se recibió la orden de bajada</span>": date('d/m/Y - H:i:s',strtotime($bajada->recibido_fecha));?></td>
                  </tr>

                  <tr>
                    <td>Fecha de visita</td>
                    <td><?=date('d/m/Y',strtotime($bajada->fecha_visita));?></td>
                  </tr>

                  <tr>
                    <td>Conductor</td>
                    <td><?="<a href=".base_url("verPersonal/{$bajada->conductor}").">" . $bajada->nameConductor . "</a>"; ?></td>
                  </tr>

                  <tr>
                    <td>Tecnico</td>
                    <td><?="<a href=".base_url("verPersonal/{$bajada->tecnico}").">" . $bajada->nameTecnico . "</a>"; ?></td>
                  </tr>

                  <tr>
                    <td>Vehiculo</td>
                    <td><?= $bajada->dominio ?></td>
                  </tr>

                </tbody>
              </table>
         </div>
        </div>
      </div>

    </div>


    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos de la Bajada</h3>
          </div>
          <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                 <tbody>
                   <tr>
                     <td>Equipo</td>
                     <td><?= "<a href=".base_url("verEquipo/{$bajada->idequipo}").">" . $bajada->equipoSerie . "</a>"; ?></td>
                   </tr>
                   <tr>
                     <td>Proyecto</td>
                     <td><?=$bajada->descripProyecto?></td>
                   </tr>

                   <?php if ($orden_estado == 40 || $orden_estado == 45): ?>
                     <tr>
                       <td>Nº Protocolo</td>
                       <td colspan="2"><?= "<a href=".base_url("verProtocolos/{$bajada->idbajada}").">" . $bajada->protocolo . "</a>"; ?></td>
                     </tr>
                     <tr>
                       <td>Fecha Bajada</td>
                       <td><?=date('d/m/Y - H:i:s',strtotime($bajada->bajada_fecha))?></td>
                     </tr>
                     <tr>
                       <td>Procesado</td>
                       <td>
                         <?php if ($bajada->fecha_procesado): ?>
                           <?=date('d/m/Y - H:i:s',strtotime($bajada->fecha_procesado))?>
                         <?php else: ?>
                           <span class="text-danger">Sin fecha</span>
                         <?php endif; ?>
                         </td>
                     </tr>
                     <tr>
                       <td colspan="2">Observaciones</td>
                     </tr>
                     <tr>
                       <td colspan="2"><?=($bajada->bajada_observ == NULL) ? "Sin observaciones": $bajada->bajada_observ;?></td>
                     </tr>
                   <?php endif; ?>
                 </tbody>
               </table>
          </div>

          <?php if ($orden_estado == 40 || $orden_estado == 45): ?>
            <div class="box-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <span class="description-text text-info">Fecha Desde</span>
                  <h5 class="description-header">
                    <?php if ($bajada->bajada_desde != '0000-00-00 00:00:00' && $bajada->bajada_desde != NULL): ?>
                      <?=date('d/m/Y - H:i',strtotime($bajada->bajada_desde))?>
                    <?php else: ?>
                      Sin fecha
                    <?php endif; ?>
                    </h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <span class="description-text text-info">Fecha Hasta</span>
                  <h5 class="description-header">
                    <?php if ($bajada->bajada_hasta != '0000-00-00 00:00:00' && $bajada->bajada_hasta != NULL): ?>
                      <?=date('d/m/Y - H:i',strtotime($bajada->bajada_hasta))?>
                    <?php else: ?>
                      Sin fecha
                    <?php endif; ?>

                  </h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <span class="description-text text-info">Cantidad</span>
                  <h5 class="description-header">
                    <?php if ($bajada->bajada_archivos): ?>
                      <?= $bajada->bajada_archivos; ?>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                    </h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <?php endif; ?>
        </div>
      </div>

      <?php if ($orden_estado == 40 || $orden_estado == 45): ?>
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Mapa</h3>
         </div>
         <div class="box-body table-responsive no-padding">
             <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Coordendas del Equipo</td>
                    <td><?= ($bajada->geo_lat == "") ? "A designar" : $bajada->geo_lat ?></td>
                    <td><?= ($bajada->geo_lon == "") ? "A designar" : $bajada->geo_lon ?></td>
                  </tr>
                  <tr>
                    <td>Coordendas del Tecnico</td>
                    <td><?= ($bajada->bajada_lat == 0) ? "Sin coordenadas" : $bajada->bajada_lat ?></td>
                    <td><?= ($bajada->bajada_long == 0) ? "Sin coordenadas" : $bajada->bajada_long ?></td>
                  </tr>
                  <tr>
                    <?php if ($distancia && ($bajada->geo_lat && $bajada->geo_lon)): ?>
                      <?php if (intval($distancia) > 0): ?>
                        <td colspan="3">El tecnico está a <?=intval($distancia)?> KM del equipo</td>
                      <?php else: ?>
                        <td colspan="3">El tecnico está a <?=$distancia*1000?> M del equipo</td>
                      <?php endif; ?>
                    <?php else: ?>
                      <td class="text-danger" colspan="3">Faltan coordenadas para calcular la distancia.</td>
                    <?php endif; ?>
                  </tr>
                  <tr>
                    <?php if ($bajada->bajada_lat != 0 && $bajada->bajada_long != 0): ?>
                    <td colspan="3" style="padding:0px">
                      <div id="map" style="height: 290px; width: 100%; border-color: red;">
                         <script>
                            function initMap() {
                              var uluru = {lat: <?php echo $bajada->bajada_lat; ?>, lng: <?php echo $bajada->bajada_long; ?>};
                              <?php if ($bajada->geo_lat or $bajada->geo_lon):?>
                              var uluru2 = {lat: <?php echo $bajada->geo_lat; ?>, lng: <?php echo $bajada->geo_lon; ?>};
                              <?php endif;?>

                              var map = new google.maps.Map(document.getElementById('map'), {
                              zoom: 14,
                              mapTypeControl: false,
                              draggable: true,
                              streetViewControl: true,
                              center: uluru
                              });

                              var icon = {
                              url: '<?=base_url()?>/assets/images/MarcadorBajada.ico',
                              scaledSize: new google.maps.Size(36, 42)
                              };

                              var icon2 = {
                                  url: '<?=base_url()?>/assets/images/MarcadorEquipoFijo.png',
                                      scaledSize: new google.maps.Size(36, 42)
                                      };

                              var contentString = '<div id="content">'+
                              '<div id="infoOrden">'+
                              '</div>'+
                              '<h4 id="firstHeading" class="firstHeading"><center>Orden Retiro de Memorias: <font color="green"> <?php echo $bajada->idbajada; ?></font></center></h4>'+
                              '<h4 id="firstHeading" class="firstHeading"><center>Protocolo: <?php
                              echo "<a href=".base_url("verProtocolos/{$bajada->idbajada}").">" . $bajada->protocolo . "</a>"; ?>  </center></h4>'+
                              '<div id="bodyContent">'+
                              '</div>'+
                              '</div>';

                              var contentString2 = '<div id="content">'+
                              '<div id="infoEquipo">'+
                              '</div>'+
                              '<h3 id="firstHeading" class="firstHeading"><center>Equipo: <b><?php echo $bajada->equipoSerie; ?></b></center></h3>'+
                              '<h4 id="firstHeading" class="firstHeading"><center><?php echo $bajada->calle_equipo; ?></center></h4>'+
                              '<div id="bodyContent">'+
                              '</div>'+
                              '</div>';

                              var infowindow = new google.maps.InfoWindow({
                              content: contentString
                              });

                              var infowindow2 = new google.maps.InfoWindow({
                                  content: contentString2
                                  });

                              var marker = new google.maps.Marker({
                              position: uluru,
                              map: map,
                              icon: icon,
                              title: '<?php echo $bajada->serie; ?>'
                              });
                              <?php if ($bajada->geo_lat or $bajada->geo_lon):?>
                              var marker2 = new google.maps.Marker({
                                  position: uluru2,
                                  map: map,
                                  icon: icon2,
                                  title: '<?php echo $bajada->serie; ?>'
                                  });
                              <?php endif;?>

                              marker.addListener('click', function() {
                              infowindow.open(map, marker);
                              });

                              marker2.addListener('click', function() {
                              infowindow2.open(map, marker2);
                              });
                            }
                        </script>
                        </div>
                    </td>
                    <?php endif; ?>
                  </tr>
                </tbody>
              </table>
         </div>
        </div>
      </div>
      <?php endif; ?>
    </div>


    <div class="row">
      <?php if (($orden_estado == 40 || $orden_estado == 45) && $bajada->id_rm): ?>
      <div class="col-md-6">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Fallas</h3>
         </div>
         <div class="box-body table-responsive no-padding">
             <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Tipo de la falla</td>
                    <td><?=$bajada->falla_descrip?></td>
                  </tr>
                  <tr>
                    <td>Nº Orden</td>
                    <?php if ($bajada->ultimo_estado != 12): ?>
                      <td><span class="text-primary"><?=
                      "<a href=".base_url("ver-orden/$bajada->id_rm").">" . $bajada->id_rm . "</a>";?></span></td>
                    <?php else: ?>
                      <td><span class="text-primary"><?=
                      "<a href=".base_url("ver-desestimado/$bajada->id_rm").">" . $bajada->id_rm . "</a>";?></span></td>
                    <?php endif; ?>
                  </tr>
                  <tr>
                    <td>Estado</td>
                    <td><?=$bajada->orden_estado?></td>
                  </tr>
                </tbody>
              </table>
         </div>
        </div>
      </div>
      <?php endif; ?>


      <?php if ($roleId == 99 && $bajada->id_mensaje): ?>
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">**Mensaje (Superadmin)</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>ID</td>
                      <td><?=$bajada->id_mensaje?></td>
                    </tr>
                    <tr>
                      <td>Nro Msj</td>
                      <td><span class="text-primary"><?=$bajada->codigo_mensaje?></span></td>
                    </tr>
                    <tr>
                      <td>Tipo</td>
                      <td><?=$bajada->tipo_mensaje?></td>
                    </tr>
                    <tr>
                      <td colspan="2">Datos</td>
                    </tr>
                    <tr>
                      <td colspan="2"><?=$bajada->datos_mensaje?></td>
                    </tr>
                    <tr>
                      <td>Fecha ACK</td>
                      <td><?=$bajada->fecha_ack?></td>
                    </tr>
                    <tr>
                      <td>Intentos</td>
                      <td><?=$bajada->intentos?></td>
                    </tr>
                    <tr>
                      <td>Estado</td>
                      <td><?=$bajada->estado?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/imprime.js" type="text/javascript"></script>

<script>
function Imprimir() {
  window.print();
}
</script>

<?php require APPPATH . '/libraries/mapas_llaveGoogle.php'; ?>
