<style media="screen">
.container {
margin-top: 15px;
}
.tab-group,
.tab-group-vertical {
 position: relative;
 display: inline-block;
 vertical-align: middle;
 zoom: 1; /* Fix for IE7 */
 *display: inline; /* Fix for IE7 */
}

.tab-group > li,
.tab-group-vertical > li {
  border: 1px solid #428bca;
  border-radius: 4px;
  position: relative;
  float: left;
}
.tab-group > li.active > a,
.tab-group > li.active > a:hover,
.tab-group > li.active > a:focus,
.tab-group-vertical > li.active > a,
.tab-group-vertical > li.active > a:hover,
.tab-group-vertical > li.active > a:focus {
  background-color: #428bca;
  color: #fff;
}
.tab-group > li > a,
.tab-group-vertical > li > a {
  border-radius: 0;
}
.tab-group > li > a:hover,
.tab-group-vertical > li > a:hover {
  border-radius: 4px;
}

.tab-group li + li {
  margin-left: -1px;
}

.tab-group > li:not(:first-child):not(:last-child),
.tab-group > li:not(:first-child):not(:last-child) > a:hover {
border-radius: 0;
}
.tab-group > li:first-child,
.tab-group > li:first-child > a:hover {
  margin-left: 0;
}
.tab-group > li:first-child:not(:last-child),
.tab-group > li:first-child:not(:last-child) > a:hover {
border-top-right-radius: 0;
border-bottom-right-radius: 0;
}
.tab-group > li:last-child:not(:first-child),
.tab-group > li:last-child:not(:first-child) > a:hover {
border-top-left-radius: 0;
border-bottom-left-radius: 0;
}

.tab-group-vertical > li {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%;
  text-align:center;
}
.tab-group-vertical > li + li {
  margin-top: -1px;
  margin-left: 0px;
}

.tab-group-vertical > li:not(:first-child):not(:last-child),
.tab-group-vertical > li:not(:first-child):not(:last-child) > a:hover {
border-radius: 0;
}
.tab-group-vertical > li:first-child:not(:last-child),
.tab-group-vertical > li:first-child:not(:last-child) > a:hover {
border-top-right-radius: 4px;
border-bottom-right-radius: 0;
border-bottom-left-radius: 0;
}
.tab-group-vertical > li:last-child:not(:first-child),
.tab-group-vertical > li:last-child:not(:first-child) > a:hover {
border-top-left-radius: 0;
border-top-right-radius: 0;
border-bottom-left-radius: 4px;
}

.tab-pane{
margin-left:10px;
margin-right:10px;
}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
     Equipos - <b><?= $serie ?></b>
     <span class="pull-right">
       <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
       <a href="<?=base_url('equiposListing')?>">Equipos</a> /
       <span class="text-muted">Historial</span>
     </span>
   </div>

    <section class="content">
        <div class="row">
          <?php if (!in_array($role, array(60,61,62,63))): ?>
              <div class="col-md-12">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-star" style="color:#f39c12;"></i> Ultimo Evento</h2>
                  </div>
                  <div class="box-body no-padding">
                    <table class="table table-bordered">
                      <thead>
                          <tr class="info">
                              <th class ="text-center">#</th>
                              <th class ="text-center">Fecha</th>
                              <th class ="text-center">Origen</th>
                              <th class ="text-center">Tipo</th>
                              <th class ="text-center">Realizado por</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td class ="text-center"><?=$ultimoEvento->id?></td>
                            <td class ="text-center"><?=$this->fechas->cambiaf_a_arg_hor($ultimoEvento->fecha) ?></td>
                            <td class ="text-center"><?=$ultimoEvento->origen?></td>
                            <td class ="text-center"><?=$ultimoEvento->tipo?></td>
                            <td class ="text-center"><?= "<a href=".base_url("verPersonal/{$ultimoEvento->creadopor}").">" . $ultimoEvento->nameHistorial . "</a>"?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          <?php endif; ?>

          <div class="col-md-2">
            <div class="tabbable" >
              <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
                <?php if (!in_array($role, array(60,61,62,63))): ?>
                  <li <?= (!in_array($role, array(60,61,62,63))) ? "class='active'" : "" ; ?> ><a href="#eventos" data-toggle="tab">Eventos</a></li>
                  <li><a href="#equipos" data-toggle="tab">Equipos</a></li>
                  <li><a href="#bajada" data-toggle="tab">Bajada de Memoria</a></li>
                  <li><a href="#protocolos" data-toggle="tab">Protocolos</a></li>
                <?php endif; ?>

                <li <?= (in_array($role, array(60,61,62,63))) ? "class='active'" : "" ; ?>><a href="#reparaciones" data-toggle="tab">Reparaciones</a></li>
                <?php if (!in_array($role, array(60,61,62,63))): ?>
                  <li><a href="#mantenimiento" data-toggle="tab">Mantenimiento</a></li>
                  <li><a href="#deposito" data-toggle="tab">Deposito</a></li>
                  <li><a href="#calibraciones" data-toggle="tab">Calibraciones</a></li>

                  <li><a href="#novedades" data-toggle="tab">Novedades</a></li>
                  <li><a href="#desestimados" data-toggle="tab">Desestimados</a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>

          <div class="col-md-10">
              <div class="box">
                <div class="box-body table-responsive no-padding">

                  <div class="tab-content">
                    <div class="tab-pane <?= (!in_array($role, array(60,61,62,63))) ? "active" : "" ; ?>" id="eventos">
                      <?php if ($countEventos == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Eventos</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialEventos as $record):
                           switch ($record->tipo) {
                             case 'ALTA':
                                 $color = "success";
                               break;
                             case 'MODIFICACIÓN':
                             case 'MODIFICACION':
                                 $color = "warning";
                               break;
                             case 'BAJA':
                                 $color = "danger";
                               break;
                             default:
                               $color = "info";
                               break;
                           }
                           ?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <span class="product-description" style="color: #333333"><?=($record->detalle == NULL) ? "Sin detalles.": $record->detalle ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>

                    </div>


                    <div class="tab-pane" id="equipos">
                      <?php if ($countEquipos == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Equipos</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialEquipos as $record):
                           switch ($record->tipo) {
                             case 'ALTA':
                                 $color = "success";
                               break;
                             case 'MODIFICACIÓN':
                             case 'MODIFICACION':
                                 $color = "warning";
                               break;
                             case 'BAJA':
                                 $color = "danger";
                               break;
                             default:
                               $color = "info";
                               break;
                           }
                           ?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <span class="product-description" style="color: #333333"><?=($record->detalle == NULL) ? "Sin detalles.": $record->detalle ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>


                    <div class="tab-pane" id="bajada">
                      <?php if ($countBajada == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Bajada de memoria</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialBajada as $record):
                           switch ($record->tipo) {
                             case 'ALTA':
                                 $color = "success";
                               break;
                             case 'MODIFICACIÓN':
                             case 'MODIFICACION':
                                 $color = "warning";
                               break;
                             case 'BAJA':
                                 $color = "danger";
                               break;
                             default:
                               $color = "info";
                               break;
                           }
                           ?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <span class="product-description" style="color: #333333"><?=($record->detalle == NULL) ? "Sin detalles.": $record->detalle ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>


                    <div class="tab-pane" id="protocolos">
                      <?php if ($countProtocolos == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Protocolos</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialProtocolos as $record):
                           switch ($record->tipo) {
                             case 'INGRESADO':
                             case 'ORDEN MODIFICADA':
                                 $color = "success";
                               break;
                             case 'ANULADO':
                                 $color = "danger";
                               break;
                             case 'CANTIDAD CERO':
                                 $color = "default";
                                 break;
                             default:
                               $color = "primary";
                               break;
                           }
                           ?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <?php $protocolo = explode("---", $record->detalle); ?>
                               <span class="product-description" style="color: #333333"><?= 'Protocolo Nº <a href="'.base_url("verProtocolos/{$protocolo[1]}").'">'.$protocolo[0].'</a>' ?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>


                    <div class="tab-pane <?= (in_array($role, array(60,61,62,63))) ? "active" : "" ; ?>" id="reparaciones">
                      <?php if ($countReparaciones == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Reparaciones</h4>
                        <ul class="products-list product-list-in-box" >
                         <?php foreach ($historialReparaciones as $record):
                           switch ($record->tipo) {
                             case 'ALTA':
                                 $color = "success";
                               break;
                             case 'MODIFICACIÓN':
                             case 'MODIFICACION':
                                 $color = "warning";
                               break;
                             case 'BAJA':
                             case 'RECHAZADA':
                                 $color = "danger";
                               break;

                             default:
                               $color = "primary";
                               break;
                           }
                           ?>
                           <li class="item" style="border-top: 1px solid #cccccc;">
                               <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
                               <span class="pull-right">
                                 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
                               </span>
                               <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <span class="product-description" style="color: #333333"><?=($record->detalle == NULL) ? "Sin detalles.": $record->detalle ;?></span>
                           </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </div>


                    <div class="tab-pane" id="mantenimiento">
                      <?php if ($countMantenimiento == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Mantenimiento</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialMantenimiento as $record):
                           switch ($record->tipo) {
                             case 'ALTA':
                                 $color = "success";
                               break;
                             case 'MODIFICACIÓN':
                             case 'MODIFICACION':
                                 $color = "warning";
                               break;
                             case 'BAJA':
                             case 'RECHAZADA':
                                 $color = "danger";
                               break;
                             default:
                               $color = "primary";
                               break;
                           }
                           ?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-<?=$color?>"><?=$record->tipo?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->creadopor}").">" . $record->nameHistorial . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observaciones == NULL) ? "Sin observaciones.": $record->observaciones ;?></span>
                               <span class="product-description" style="color: #333333"><?=($record->detalle == NULL) ? "Sin detalles.": $record->detalle ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane" id="deposito">
                      <?php if (!$depositos): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Deposito</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($depositos as $deposito):

                           ?>
     							 				 <li class="item" style="border-top: 1px solid #000000;">
                             <span class="label label-primary">Remito creado</span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$deposito->creado_por}").">" . $deposito->name_creado . "</a>"?>

                             <span class="pull-right">
                               <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($deposito->ts_creado))?>
                             </span>
                             <span class="product-description" style="color: #333333"><strong>Detalles:</strong>
                              Remito interno Nº <span class="text-primary"><?=$deposito->id?></span>
                              <br>
                              <?= "<a class='product-title' target='_blank' href=".base_url("remito_deposito/{$deposito->id}").">Ver todos los movimientos.</a>"?>
                             </span>

                               <hr style="margin-top: 10px; margin-bottom: 10px">
     	 		                     <span class="label label-<?=$deposito->label?>"><?=$deposito->nombre_estado?></span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$deposito->creado_por}").">" . $deposito->usuario_evento . "</a>"?>

     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($deposito->fecha_evento))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><strong>Ultimo Evento:</strong> <?=($deposito->observacion == NULL) ? "Sin observaciones.": $deposito->observacion ;?></span>

     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>




                    <div class="tab-pane" id="calibraciones">
                      <?php if (!$calibraciones): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Calibraciones</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($calibraciones as $calibracion):

                           ?>
     							 				 <li class="item" style="border-top: 1px solid #000000;">
                             <span class="label label-primary">Orden creado</span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$calibracion->creadopor}").">" . $calibracion->name_creado . "</a>"?>

                             <span class="pull-right">
                               <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($calibracion->fecha_alta))?>
                             </span>
                             <span class="product-description" style="color: #333333"><strong>Detalles:</strong>
                              Orden Nº <span class="text-primary"><?=$calibracion->id?></span>

                               <hr style="margin-top: 10px; margin-bottom: 10px">
                               Estado actual <br>
     	 		                     <span class="label label-default" style="background-color:<?=$calibracion->color_tipo?>; color: white"><?= $calibracion->estado_descrip;?> </span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$calibracion->id_usuario_evento}").">" . $calibracion->usuario_evento . "</a>"?>

     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($calibracion->fecha_evento))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><strong>Ultimo Evento:</strong> <?=($calibracion->observacion == NULL) ? "Sin observaciones.": $calibracion->observacion ;?></span>

                               <hr style="margin-top: 10px; margin-bottom: 10px">
                               <?= "<a class='product-title' target='_blank' href=".base_url("verCalib/{$calibracion->id}").">Ver todos los movimientos.</a>"?>
                              </span>

     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane" id="novedades">
                      <?php if ($countNovedades == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Novedades</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialNovedades as $record):?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-primary">ALTA</span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->tecnico}").">" . $record->nameTecnico . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
                               <span class="product-description" style="color: #333333"><b>Falla Principal:</b> <?=$record->falla;?></span>
     	 		                     <span class="product-description" style="color: #333333"><?=($record->observacion == NULL) ? "Sin observaciones.": $record->observacion ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>

                    <div class="tab-pane" id="desestimados">
                      <?php if ($countDesestimados == 0): ?>
                        <h4> No hay datos para mostrar.</h4>
                      <?php else: ?>
                        <h4> Desestimados</h4>
                        <ul class="products-list product-list-in-box" >
     										 <?php foreach ($historialDesestimados as $record):?>
     							 				 <li class="item" style="border-top: 1px solid #cccccc;">
     	 		                     <span class="label label-danger">RECHAZADA</span> - <?= "<a class='product-title' href=".base_url("verPersonal/{$record->usuario}").">" . $record->nameUsuario . "</a>"?>
     	 		                     <span class="pull-right">
     														 <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($record->fecha))?>
     													 </span>
     	 		                     <span class="product-description" style="color: #333333"><?='Reporte Nº <a href="'.base_url("ver-desestimado/{$record->orden}?").'">'.$record->orden.'</a> RECHAZADA'?></span>
                               <span class="product-description" style="color: #333333"><?=($record->observDesestimado == NULL) ? "Sin observaciones.": $record->observDesestimado ;?></span>
     	 		                 </li>
     	                    <?php endforeach; ?>
     		                </ul>
                      <?php endif; ?>
                    </div>

                  </div> <!-- Tab contenedor-->

                </div>
            </div>
          </div>
        </div>
    </section>
</div>
