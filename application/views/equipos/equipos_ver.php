<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style>
    @media print {
      a[href]:after {content: none !important;}
      #botonImprimir {display: none;}
    }
</style>

<?php
  $Equipo_velocidad = array(1,2,400,2402,2407,2412);
  $fecha_hoy = new DateTime(date('Y-m-d H:i:s'));
  $fecha_vto = new DateTime($equipo->doc_fechavto);

?>

<div class="content-wrapper">
     <div id="cabecera">
   		Equipos - Detalles del equipo
   		<span class="pull-right">
   			<a href="<?=base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?=base_url('equiposListing')?>">Equipos listado</a> /
   		  <span class="text-muted">Ver equipo</span>
   		</span>
   	</div>

    <section class="content">
      <div class="row">
          <div class="col-xs-12 ">
              <div class="form-group">
                  <a><button id="botonImprimir" class="btn btn-primary" onclick="Imprimir()">Imprimir</button></a>
              </div>
          </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Principal</h3>
           </div>
           <div class="box-body">
             <div class="row">
               <div class="col-md-6 mb">
                   <ul class="list-unstyled">
                     <li>Serie:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a><?=$equipo->serie?></a></li>
                     <li>Evento:&nbsp;&nbsp;<a><?= ($equipo->descripEvento == "") ? "A designar" : $equipo->descripEvento ?></a></li>
                     <li>Lugar:&nbsp;&nbsp;&nbsp;&nbsp;<a><?=$equipo->descripEstado?></a></li>
                   </ul>
               </div>

               <div class="col-md-6">
                   <ul class="list-unstyled">
                     <li>Proyecto:&nbsp;&nbsp;&nbsp;<a><?=($equipo->descripMunicipio == '') ? "A designar" : $equipo->descripMunicipio ?></a></li>
                     <li>Gestor:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a><?= ($equipo->nombreGestor == "") ? "<spam class=\"text-danger\"> A designar</spam>" :  $equipo->nombreGestor ?></a></li>
                     <li>Ayudante:&nbsp;&nbsp;A designar</li>
                   </ul>
               </div>
             </div>
           </div>

           <?php if ($role == 99): ?>
             <div class="box-footer">
               Ultima Modificacion: <a><?=date('d/m/Y - H:i:s',strtotime($equipo->fecha_ultmod));?></a>
             </div>
           <?php endif; ?>
          </div>
        </div>

        <div class="col-md-6">
          <?php if ($equipo->bajada == 1): ?>
              <?php if ($equipo->operativo == 1 && $equipo->solicitud_bajada == 1): ?>
                <?php if (in_array($equipo->tipo, $Equipo_velocidad)): ?>
                  <?php if (($equipo->doc_fechavto != '0000-00-00' || $equipo->doc_fechavto != '' || $equipo->doc_fechavto != NULL) && ($fecha_vto > $fecha_hoy)): ?>
                    <div class="box box-success">
                  <?php else: ?>
                    <div class="box box-danger">
                  <?php endif; ?>
                <?php else: ?>
                  <div class="box box-success">
                <?php endif; ?>
              <?php else: ?>
                  <div class="box box-danger">
              <?php endif; ?>
          <?php else: ?>
            <div class="box">
          <?php endif; ?>
            <div class="box-header with-border">
              <h3 class="box-title">
                Condicion de Bajada
              </h3>
           </div>

           <div class="box-body">
             <p>
             <?php if ($equipo->bajada == 1): ?>
               <?php if ($equipo->operativo == 1 && $equipo->solicitud_bajada == 1 && $equipo->estado == 2): ?>
                 <?php if (in_array($equipo->tipo, $Equipo_velocidad)): ?>
                   <?php if (($equipo->doc_fechavto != '0000-00-00' || $equipo->doc_fechavto != '' || $equipo->doc_fechavto != NULL) && ($fecha_vto > $fecha_hoy)): ?>
                     <i class="fa fa-check-square fa-lg" style="color:#009900; position: relative; top: 1px;"></i> <b>Continuar bajada:</b> SI
                   <?php else: ?>
                     <i class="fa fa-window-close fa-lg" style="color:#d9534f; position: relative; top: 1px;"></i> <b>Continuar bajada:</b> NO
                   <?php endif; ?>
                 <?php else: ?>
                   <i class="fa fa-check-square fa-lg" style="color:#009900; position: relative; top: 1px;"></i> <b>Continuar bajada:</b> SI
                 <?php endif; ?>
               <?php else: ?>
                   <i class="fa fa-window-close fa-lg" style="color:#d9534f; position: relative; top: 1px;"></i> <b>Continuar bajada:</b> NO
               <?php endif; ?>
             <?php else: ?>
               <i class="fa fa-square-o fa-lg" style="color:#041725; position: relative; top: 1px;"></i> No es un tipo de equipo para bajar memoria.
             <?php endif; ?>
             </p>

             <p><b>Activo:</b> <?=($equipo->activo == 1) ? 'SI' : 'NO' ;?></p>

             <?php if ($equipo->bajada == 1): ?>
               <p><b>Solicitud de Bajada:</b> <?=($equipo->solicitud_bajada == 1) ? 'SI' : 'NO' ;?></p>
             <?php endif; ?>

           </div>
          </div>
        </div>



      </div>

      <?php if ($equipo->bajada == 1): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Actividad</h3>
             </div>
             <div class="box-body">
               <?php if ($ultima_bajada->Ultima_bajada): ?>
                 <p><i class="fa fa-download text-primary"></i> Ultima bajada de memoria fue
                   <?php if ($ultima_bajada->Dias > 0): ?>
                      el <b><?=date('d/m/Y',strtotime($ultima_bajada->Ultima_bajada));?></b> (<a><?=$ultima_bajada->Dias?></a>
                      <?= ($ultima_bajada->Dias > 1) ? "dias)</p>" : "dia)</p>" ?>
                   <?php else: ?>
                     <a>hoy</a>.</p>
                   <?php endif; ?>
               <?php else: ?>
                 <p><i class="fa fa-exclamation-circle text-warning"></i> No hay datos sobre una bajada de memoria.</p>
               <?php endif; ?>

               <?php if (in_array($equipo->tipo, $Equipo_velocidad)): ?>
                 <?php if ($equipo->doc_fechavto == '0000-00-00' || $equipo->doc_fechavto == '' || $equipo->doc_fechavto == NULL): ?>
                   <p><i class="fa fa-times text-danger"></i> Falta la Fecha de Vencimiento. Condicion de Bajada NO</p>
                 <?php endif; ?>

                 <?php if ($fecha_vto < $fecha_hoy): ?>
                   <p><i class="fa fa-times text-danger"></i> Equipo con la Calibracion vencida. Condicion de Bajada NO</p>
                 <?php endif; ?>
               <?php endif; ?>

             </div>
            </div>
          </div>

        </div>
      <?php endif; ?>



      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informacion</h3>
           </div>
           <div class="box-body no-padding">
             <ul class="list-group list-group-unbordered">
               <li class="list-group-item">
                 <b>Modelo</b> <span class="pull-right"><?= ($equipo->descripModelo == "") ? "A designar" : $equipo->descripModelo ?></span>
               </li>
               <li class="list-group-item">
                 <b>Marca</b> <span class="pull-right"><?= ($equipo->descripMarca == "") ? "A designar" : $equipo->descripMarca ?></span>
               </li>
               <li class="list-group-item">
                 <b>Tipo</b> <span class="pull-right"><?= ($equipo->descrip_tipo == "") ? "A designar" : $equipo->descrip_tipo ?></span>
               </li>
               <li class="list-group-item">
                 <b>Propietario</b> <span class="pull-right"><?= ($equipo->descripPropietario == "") ? "A designar" : $equipo->descripPropietario ?></span>
               </li>
               <li class="list-group-item">
                 <b>Administración</b> <span class="pull-right"><?= ($equipo->prop_descrip == "") ? "Falta designar el proyecto." : $equipo->prop_descrip ?></span>
               </li>
               <li class="list-group-item">
                 <b>Vehículo Asignado</b> <span class="pull-right">
                   <?php switch ($equipo->tipo) {
                        case '1': ?>
                            <?= ($equipo->dominio == "") ? "A designar" : $equipo->dominio; ?>
                        <?php    break;
                        case '2403': ?>
                            <?= ($equipo->dominio == "") ? "A designar" : $equipo->dominio; ?>
                        <?php    break;
                        case '2406': ?>
                            <?= ($equipo->dominio == "") ? "A designar" : $equipo->dominio; ?>
                        <?php   break;
                        default: ?>
                            <?= "No requiere" ; ?>
                        <?php break;
                    } ?>
                 </span>
               </li>

               <li class="list-group-item">
                 <b>Observaciones</b> <br>
                  <?php if ($equipo->observ == NULL): ?>
                      Sin observaciones
                  <?php else: ?>
                      <?= $equipo->observ;?>
                  <?php endif; ?>
               </li>
           </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ubicacion</h3>
           </div>
           <div class="box-body no-padding">
             <ul class="list-group list-group-unbordered">
               <li class="list-group-item">
                 <b>Direccion</b> <span class="pull-right">
                 <?php if ($equipo->ubicacion_calle == ""): ?>
                   A designar
                 <?php else: ?>
                   <?=$equipo->ubicacion_calle." "?>
                   <?= ($equipo->ubicacion_altura == "") ? "(-Falta altura-)" : $equipo->ubicacion_altura ?>
                 <?php endif; ?>
                 </span>
               </li>

               <li class="list-group-item">
                 <b>Localidad</b> <span class="pull-right"><?= ($equipo->ubicacion_localidad == "") ? "A designar" : $equipo->ubicacion_localidad ?></span>
               </li>

               <li class="list-group-item">
                 <b>Código Postal</b> <span class="pull-right"><?= ($equipo->ubicacion_cp == "") ? "A designar" : $equipo->ubicacion_cp ?></span>
               </li>

               <li class="list-group-item">
                 <b>Ejido Urbano: </b>
                   <?php switch ($equipo->ejido_urbano) {
                         case '1': ?>
                             <?php echo "Dentro" ; ?>
                         <?php    break;
                         case '2': ?>
                             <?php echo "Fuera" ; ?>
                         <?php    break;
                         default: ?>
                             <?php echo "A designar" ; ?>
                         <?php    break;
                    } ?>
                <span class="pull-right">
                  <b>Sentido: </b>
                    <?php switch ($equipo->ubicacion_sentido) {
                        case '5': ?>
                            <?php echo "Ascendente"; ?>
                        <?php    break;
                        case '6': ?>
                            <?php echo "Descendente"; ?>
                        <?php    break;
                        default: ?>
                            <?php echo "A designar" ; ?>
                        <?php    break;
                     } ?>
                 </span>
               </li>

               <li class="list-group-item">
                 <b>Velocidad Maxima: </b>
                   <?php switch ($equipo->tipo) {
                         case '1': ?>
                             <?= ($equipo->ubicacion_velper == "" OR $equipo->ubicacion_velper == 0) ? "La velocidad depende de la ubicación." : $equipo->ubicacion_velper." KM/H"; ?>
                         <?php    break;
                         case '2': ?>
                             <?= ($equipo->ubicacion_velper == "" OR $equipo->ubicacion_velper == 0) ? "A designar" : $equipo->ubicacion_velper." KM/H"; ?>
                         <?php    break;
                         case '2402': ?>
                             <?= ($equipo->ubicacion_velper == "" OR $equipo->ubicacion_velper == 0) ? "A designar" : $equipo->ubicacion_velper." KM/H"; ?>
                         <?php    break;
                         case '400': ?>
                             <?= ($equipo->ubicacion_velper == "" OR $equipo->ubicacion_velper == 0) ? "A designar" : $equipo->ubicacion_velper." KM/H"; ?>
                         <?php   break;
                         default: ?>
                             <?= "No es un equipo de velocidad." ; ?>
                         <?php    break;
                    } ?>
                    <span class="pull-right">
                      <b>Nº Carriles: </b>
                        <?php switch ($equipo->tipo) {
                              case '2': ?>
                                  <?php echo $equipo->multicarril; ?>
                              <?php    break;
                              case '2402': ?>
                                  <?php echo $equipo->multicarril; ?>
                              <?php    break;
                              default: ?>
                                  <?php echo "No requiere" ; ?>
                              <?php    break;
                         } ?>
                 </span>
               </li>

               <li class="list-group-item">
                 <b>Carril Sentido:  </b>
                <span class="pull-right">
					<?php foreach ($equipo->carril_sentido as $sentido): ?>
         				<?=$sentido?>/
					<?php endforeach; ?>
                 </span>
               </li>

               <li class="list-group-item">
                 <b>Latitud: </b> <?= ($equipo->geo_lat == "") ? "A designar" : $equipo->geo_lat ?>
                  <span class="pull-right">
                    <b>Longitud: </b> <?= ($equipo->geo_lon == "") ? "A designar" : $equipo->geo_lon ?>
                   </span>
               </li>

                <?php if ((!empty($equipo->geo_lat) && !empty($equipo->geo_lon))): ?>
                  <li class="list-group-item">
                    <div id="map" style="height: 290px; width: 100%;"></div>
                       <script>
                           function initMap() {

                           var uluru = {lat: <?php echo $equipo->geo_lat; ?>, lng: <?php echo $equipo->geo_lon; ?>};

                           <?php if ($equipo->bajadaOrden_lat or $equipo->bajadaOrden_long):?>
                           var uluru2 = {lat: <?php echo $equipo->bajadaOrden_lat; ?>, lng: <?php echo $equipo->bajadaOrden_long; ?>};
                           <?php endif;?>

                           var map = new google.maps.Map(document.getElementById('map'), {
                           zoom: 14,
                           mapTypeControl: false,
                           draggable: true,
                           streetViewControl: true,
                           center: uluru

                           });

                           var icon = {
                           url: '<?=base_url()?>/assets/images/MarcadorEquipoFijo.png',
                           scaledSize: new google.maps.Size(36, 42)

                           };

                           var icon2 = {
                                   url: '<?=base_url()?>/assets/images/MarcadorBajada.ico',
                                   scaledSize: new google.maps.Size(36, 42)

                                   };

                           var contentString = '<div id="content">'+
                           '<div id="infoEquipo">'+
                           '</div>'+
                           '<h3 id="firstHeading" class="firstHeading"><center><b><?php echo $equipo->serie; ?></b></center></h3>'+
                           '<div id="bodyContent">'+
                           '<p><?php echo ($equipo->ubicacion_calle == "-" or "") ? "Sin calle asignada" : $equipo->ubicacion_calle ?></p>'+
                           '<p><?php echo ($equipo->ubicacion_altura == "" or "0") ? "Sin altura asignada" : $equipo->ubicacion_altura ?></p>'+
                           '</div>'+
                           '</div>';


                           var contentString2 = '<div id="content">'+
                           '<div id="infoOrden">'+
                           '</div>'+
                           '<h4 id="firstHeading" class="firstHeading"><center>Orden Retiro de Memorias: <font color="green"> <?php echo $equipo->idOrdenes; ?></font></center></h4>'+
                           '<h4 id="firstHeading" class="firstHeading"><center>Protocolo: <?php
                           echo "<a href=".base_url("verProtocolos/{$equipo->idOrdenes}").">" . $equipo->protocoloId . "</a>"; ?>  </center></h4>'+
                           '<div id="bodyContent">'+
                           '</div>'+
                           '</div>';

                           var infowindow = new google.maps.InfoWindow({
                           content: contentString

                           });

                           <?php if ($equipo->bajadaOrden_lat or $equipo->bajadaOrden_long):?>
                           var infowindow2 = new google.maps.InfoWindow({
                               content: contentString2
                               });
                           <?php endif;?>

                           var marker = new google.maps.Marker({
                           position: uluru,
                           map: map,
                           icon: icon,
                           title: '<?php echo $equipo->serie; ?>'
                           });

                           <?php if ($equipo->bajadaOrden_lat or $equipo->bajadaOrden_long):?>
                           var marker2 = new google.maps.Marker({
                               position: uluru2,
                               map: map,
                               icon: icon2,
                               title: '<?php echo $equipo->serie; ?>'
                               });
                           <?php endif;?>

                           marker.addListener('click', function() {
                           infowindow.open(map, marker);
                           });

                           <?php if ($equipo->bajadaOrden_lat or $equipo->bajadaOrden_long):?>
                           marker2.addListener('click', function() {
                               infowindow2.open(map, marker2);

                             });
                           <?php endif;?>
                           }
                      </script>
                  </li>
                <?php endif; ?>
             </ul>
           </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Calibracion</h3>
           </div>
           <div class="box-body no-padding">
             <?php if ((in_array($equipo->tipo, $tipos_calibrar)) AND ($equipo->doc_fechavto != "30/11/-0001" OR $equipo->doc_fechavto != "01/01/1970" OR $equipo->doc_fechavto != NULL)): ?>
               <div class="box-header">
                   <h4 align="left"> Fecha Vencimiento: <a><?=($equipo->doc_fechavto == "30/11/-0001" OR $equipo->doc_fechavto == "01/01/1970" OR $equipo->doc_fechavto == NULL) ? "Falta fecha": $equipo->doc_fechavto;?></a></h4>
               </div>

               <ul class="list-group list-group-unbordered">
                 <li class="list-group-item">
                   <b>Certificado de calibración</b> <span class="pull-right"><?= ($equipo->doc_certif == "") ? "A designar" : $equipo->doc_certif ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Código de aprobación</b> <span class="pull-right"><?= ($equipo->doc_aprob == "") ? "A designar" : $equipo->doc_aprob ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Norma SIC</b> <span class="pull-right"><?= ($equipo->doc_normasic == "") ? "A designar" : $equipo->doc_normasic ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Código Postal</b> <span class="pull-right"><?= ($equipo->ubicacion_cp == "") ? "A designar" : $equipo->ubicacion_cp ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Distancia entre espiras</b> <span class="pull-right"><?= ($equipo->doc_distancia == "") ? "A designar" : $equipo->doc_distancia ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Requiere Calibración</b> <span class="pull-right"><?= ($equipo->requiere_calib == "") ? "A designar" : $equipo->requiere_calib ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Fecha Calibración</b> <span class="pull-right"><?= ($equipo->doc_fechacal == "30/11/-0001" OR $equipo->doc_fechacal == "01/01/1970" OR $equipo->doc_fechacal == NULL) ? "Falta fecha": $equipo->doc_fechacal; ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Informe</b> <span class="pull-right"><?= ($equipo->doc_fechacal == "30/11/-0001" OR $equipo->doc_fechacal == "01/01/1970" OR $equipo->doc_fechacal == NULL) ? "Falta fecha": $equipo->doc_fechacal; ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Nro. Pedido</b> <span class="pull-right"><?= ($equipo->pedido == "") ? "S/N" : $equipo->pedido ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Nro. Orden de Compra</b> <span class="pull-right"><?= ($equipo->ordencompra == "") ? "S/N" : $equipo->ordencompra ?></span>
                 </li>
                 <li class="list-group-item">
                   <b>Nro. OT</b> <span class="pull-right"><?= ($equipo->nro_ot == "") ? "S/N" : $equipo->nro_ot ?></span>
                 </li>
               </ul>
             <?php else: ?>
               <div class="box-header">
                   <h4 align="left"> No es un equipo de velocidad.</h4>
               </div>
             <?php endif; ?>
           </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Componentes</h3>
           </div>
           <div class="box-body table-responsive no-padding">
             <?php if (!empty($componentesInfo)): ?>
               <table class="table table-hover">
                   <tr>
                      <th>Tipo</th> <th>Serie</th> <th>Marca</th> <th>Evento</th> <th>Descripción</th>
                    </tr>
                    <?php foreach ($componentesInfo as $record): ?>
                      <tr>
                          <td><small><?= ($record->descripTipo == '')? "<spam class=\"text-danger\">Sin Tipo</spam>": $record->descripTipo?></small>
                          </td>
                          <td><small><?= ($record->serie == '')? "<spam class=\"text-danger\">Sin Serie</spam>": $record->serie?></small>
                          </td>
                          <td><small><?= ($record->descripMarca == '')? "<spam class=\"text-danger\">Sin Marca</spam>": $record->descripMarca?></small>
                          </td>
                          <td><small><span class="text-success"><?=  $record->evento_actual ?></span></small></td>
                          <td><small><?= ($record->descrip == '')? "<spam class=\"text-danger\">Sin descripción</spam>": $record->descrip?></small>
                          </td>
                      </tr>
                    <?php endforeach; ?>
               </table>
             <?php else: ?>
               <div class="box-header">
                 <h4 align="left"> No hay componentes asignados para este equipo.</h4>
               </div>
             <?php endif; ?>

            </div>
          </div>
        </div>

      </div>

      <?php if ($archivos): ?>
        <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Archivos</h3>
               </div>
               <div class="box-body">
                 <ul class="products-list product-list-in-box">

   									<?php foreach ($archivos as $archivo): ?>
   										<li class="item">
   											<div class="">
   											 <strong><?= ($archivo->nombre_archivo == NULL)? 'Sin titulo' : $archivo->nombre_archivo; ?></strong> <span class="pull-right"><?=date('d/m/Y - H:i:s',strtotime($archivo->fecha_ts))?></span>
                          <br>
   												<td><?=$archivo->observacion?></td>
   												<br>
   												<td>
   													<form action="<?=base_url('archivo_descargar')?>" method="post">
   													 <input type="hidden" name="name" value="<?=$archivo->archivo?>">
   													 <input type="hidden" name="tipo" value="<?=$archivo->tipo?>">
   													 <input type="hidden" name="parametro" value="<?=$equipo->id?>">
   													 <input type="hidden" name="pagina_actual" value="verEquipo">
   													 <input type="hidden" name="sector" value="equipos">
                             <input type="hidden" name="nombre_archivo" value="<?=$archivo->nombre_archivo?>">

   														<?php switch ($archivo->tipo) {
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
   															} ?> -
   													 <button type="submit" id="descargar" class="link"><span>Descargar archivo</span></button>
   													</form>
   												</td>
   											</div>
   										</li>
   									<?php endforeach; ?>
   							</ul>

               </div>
              </div>
            </div>
        </div>
      <?php endif; ?>

    </section>
 </div>

<script>
  function Imprimir() {
    window.print();
  }
</script>

<?php require APPPATH . '/libraries/mapas_llaveGoogle.php'; ?>
