<style type="text/css">
#columna{
overflow: auto;
height: 320px; /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
}

#infor{
  color: black;
}

#chartdiv {
  width: 100%;
  height: 250px;
}
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">Panel de Informacion	</div>

  <section class="content">
    <div class="row">
      <div class="col-md-4">
        <div class="info-box bg-blue" style="margin-bottom:0px">
          <span class="info-box-icon"><i class="fa fa-video-camera"></i></span>
          <div class="info-box-content">
            <span class="info-box-number" style="font-size:24px">EQUIPOS</span>
            <span class="info-box-text"></span>
          </div>
        </div>

        <div class="box-footer no-padding">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"> <?= $count_equipos; ?></h5>
                <?php if ($count_equipos > 0): ?>
                      <span class="description-text"><a href="<?= base_url('equiposListing'); ?>">Total</a></span>
                <?php else: ?>
                    <span class="description-text text-primary">Total</span>
                <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?= $count_operativos; ?></h5>
                <form id ="operativo" action="<?= base_url('equiposListing'); ?>" method="post">
          				<input type="hidden" name="searchNum" name="searchNum" value="1">
          				<input type="hidden" name="columna" name="columna" value="operativo">
          			</form>
                <?php if ($count_operativos > 0): ?>
                  <span class="description-text"><a href="#" onclick="document.getElementById('operativo').submit()">Operativos</a></span>
                <?php else: ?>
                    <span class="description-text text-primary">Operativos</span>
                <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header"><?= $count_no_operativos; ?></h5>
                <form id ="no_operativo" action="<?= base_url('equiposListing'); ?>" method="post">
          				<input type="hidden" name="searchNum" name="searchNum" value="0">
          				<input type="hidden" name="columna" name="columna" value="operativo">
          			</form>

                <?php if ($count_no_operativos > 0): ?>
                  <span class="description-text"><a href="#" onclick="document.getElementById('no_operativo').submit()"><small>No Operativos</small></a></span>
                <?php else: ?>
                    <span class="description-text text-primary"><small>No Operativos</small></span>
                <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
			</div>

      <div class="col-md-4">
        <div class="info-box bg-yellow" style="margin-bottom:0px">
          <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
          <div class="info-box-content">
            <span class="info-box-number" style="font-size:24px">CALIBRACION</span>
            <span class="info-box-text"></span>
          </div>
        </div>

        <div class="box-footer no-padding">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?= $count_eqInti; ?></h5>
                <form id ="inti" action="<?= base_url('equiposListing'); ?>" method="post">
          				<input type="hidden" name="searchNum" name="searchNum" value="4">
          				<input type="hidden" name="columna" name="columna" value="estado">
          			</form>
                  <?php if ($count_eqInti > 0): ?>
                      <span class="description-text"> <a href="#" onclick="document.getElementById('inti').submit()">Equipos INTI</a></span>
                  <?php else: ?>
                      <span class="description-text text-primary">Equipos INTI</span>
                  <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header"><?= $requierenCalib; ?></h5>
                <form id ="requieren" action="<?= base_url('equiposListing'); ?>" method="post">
          				<input type="hidden" name="searchNum" name="searchNum" value="1">
          				<input type="hidden" name="columna" name="columna" value="requiere_calib">
          				<input type="hidden" name="calib" name="calib" value="1">
          			</form>
                <?php if ($requierenCalib > 0): ?>
                    <span class="description-text"><a href="#" onclick="document.getElementById('requieren').submit()">Requieren calibracion</a></span>
                <?php else: ?>
                    <span class="description-text text-primary">Requieren calibracion</span>
                <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header"><?=$documentacion?></h5>
                <form id ="documentacion" action="<?= base_url('calibraciones_pendientes'); ?>" method="post">
          			</form>
                <?php if ($documentacion > 0): ?>
                    <span class="description-text"><a href="#" onclick="document.getElementById('documentacion').submit()">Docs Pendiente</a></span>
                <?php else: ?>
                    <span class="description-text text-primary">Docs Pendiente</span>
                <?php endif; ?>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>

      <div class="col-md-4">
        <div class="info-box bg-red" style="margin-bottom:0px">
          <span class="info-box-icon"><i class="fa fa-wrench"></i></span>
          <div class="info-box-content">
            <span class="info-box-number" style="font-size:24px">REPARACION</span>
            <span class="info-box-number"><?=$count_socio2+$count_oficina_tecnica2+$count_proyecto_repa2+$count_solicitudes_repa?> Equipos</span>
          </div>
        </div>

        <div class="box-footer no-padding">
          <div class="row">
            <div class="col-sm-6">
              <div class="description-block">
                <h5 class="description-header"><?= $count_socio2+$count_oficina_tecnica2+$count_proyecto_repa2; ?></h5>
                <span class="text-primary">ORDENES ABIERTAS</span>
              </div>
              <!-- /.description-block -->
            </div>

            <div class="col-sm-6">
              <div class="description-block">
                <h5 class="description-header"><?= $count_solicitudes_repa; ?></h5>
                <span class="text-primary">ORDENES SIN ATENDER</span>
              </div>
              <!-- /.description-block -->
            </div>











          </div>
          <!-- /.row -->
        </div>
      </div>
    </div>
    <br>

    <?php if (in_array($role, array(60,61,62,63))):
      if ($remitos_pendientes > 1) {
        $mensaje = "Nuevas solicitudes de remitos.";
      } else {
        $mensaje = "Nueva solicitud de remito.";
      }
      ?>

      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
              <?php if ($remitos_pendientes == 0): ?>
                <i class="fa fa-bell-slash text-danger"></i> <b><span class="text-danger">0</span></b> No hay solicitudes nuevas.
              <?php else: ?>
                <i class="fa fa-bell text-primary"></i> <b><span class="text-success"><?=$remitos_pendientes?></span></b> <?=$mensaje?>
              <?php endif; ?>

            </h3>
        </div>
      </div>
    <?php endif; ?>


    <?php if (!in_array($role, array(60,61,62,63))): ?>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ordenes Abiertas</h3>
            </div>
            <div class="box-body">
              <?php if ($mantenimiento == 0 && $reparacion == 0 && $instalacion == 0 && $calibracion == 0 && $bajada == 0): ?>
                <span>No hay ordenes abiertas.</span>
              <?php else: ?>
                <div id="chartdiv"></div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Alertas</h3>
            </div>
            <div class="box-body">
              <ul>

                <?php if ($total_novedades > 0): ?>
                  <li> <strong> <a href="#"><?= $total_novedades?></a></strong> <strong>
                    <?php if ($total_novedades > 1): ?>
                      Novedades
                    <?php else: ?>
                      Novedad
                    <?php endif; ?>
                  </strong> sin atender.</li>
                <?php endif; ?>

                <?php if ($direccion > 0): ?>
                  <li> <strong> <a href="#"><?=$direccion?></a></strong>
                    <?php if ($direccion > 1): ?>
                      Equipos no tienen la
                    <?php else: ?>
                      Equipo no tiene la
                    <?php endif; ?>
                  <strong>direccion</strong> cargada.</li>
                <?php endif; ?>

                <?php if ($altura > 0): ?>
                  <li> <strong> <a href="#"><?=$altura?></a></strong>
                    <?php if ($altura > 1): ?>
                      Equipos no tienen la
                    <?php else: ?>
                      Equipo no tiene la
                    <?php endif; ?>
                  <strong>altura</strong> cargada.</li>
                <?php endif; ?>

                <?php if ($tipo > 0): ?>
                  <li> <strong> <a href="#"><?=$tipo?></a></strong>
                    <?php if ($tipo > 1): ?>
                      Equipos no tienen el
                    <?php else: ?>
                      Equipo no tiene el
                    <?php endif; ?>
                  <strong>tipo de equipo</strong> seleccionado.</li>
                <?php endif; ?>

                <?php if ($vencimiento > 0): ?>
                  <li> <strong> <a href="#"><?=$vencimiento?></a></strong>
                    <?php if ($vencimiento > 1): ?>
                      Equipos no tienen cargada la
                    <?php else: ?>
                      Equipo no tiene cargada la
                    <?php endif; ?>
                  <strong>fecha de vencimiento</strong>.</li>
                <?php endif; ?>

                <?php if ($calibracion > 0): ?>
                  <li> <strong> <a href="#"><?=$calibracion?></a></strong>
                    <?php if ($calibracion > 1): ?>
                      Equipos no tienen cargada la
                    <?php else: ?>
                      Equipo no tiene cargada la
                    <?php endif; ?>
                  <strong>fecha de calibracion</strong>.</li>
                <?php endif; ?>

                <?php if ($latitud > 0): ?>
                  <li> <strong> <a href="#"><?=$latitud?></a></strong>
                    <?php if ($latitud > 1): ?>
                      Equipos que la <strong>latitud</strong> no estan cargadas.</li>
                    <?php else: ?>
                      Equipo que la <strong>latitud</strong> no esta cargada.</li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($longitud > 0): ?>
                  <li> <strong> <a href="#"><?=$longitud?></a></strong>
                    <?php if ($longitud > 1): ?>
                      Equipos que la <strong>longitud</strong> no estan cargadas.</li>
                    <?php else: ?>
                      Equipo que la <strong>longitud</strong> no esta cargada.</li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($sentido > 0): ?>
                  <li> <strong> <a href="#"><?=$sentido?></a></strong>
                    <?php if ($sentido > 1): ?>
                      Equipos no tienen cargado el
                    <?php else: ?>
                      Equipo no tiene cargada el
                    <?php endif; ?>
                  <strong>sentido</strong>.</li>
                <?php endif; ?>

              </ul>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Proyectos</h3>
            </div>
            <div class="box-body">
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width:<?=$porcentaje_activo?>%">
                  <?=$porcentaje_activo?>%
                </div>
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?=$porcentaje_inactivo?>%">
                  <?=$porcentaje_inactivo?>%
                </div>
              </div>
            </div>

            <div class="box-footer no-padding">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?=$proyecto_activos?></h5>
                    <span class="description-text text-success"><strong>ACTIVOS</strong></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?=$proyecto_total?></h5>
                    <span class="description-text text-primary"> <strong> TOTAL</strong></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?=$proyecto_inactivos?></h5>
                    <span class="description-text text-danger"><strong>INACTIVOS</strong></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Estados de los Equipos</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_deposito?>%"><?=$porcentaje_deposito?>%
                      <span class="sr-only">40%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_proyecto?>%"><?=$porcentaje_proyecto?>%
                      <span class="sr-only">20%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_socio?>%; background-color: #605ca8;"><?=$porcentaje_socio?>%
                      <span class="sr-only">60%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_inti?>%"><?=$porcentaje_inti?>%
                      <span class="sr-only">80%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_oficina_tecnica?>%"><?=$porcentaje_oficina_tecnica?>%
                      <span class="sr-only">80%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_robados?>%; background-color: #D81B60;"><?=$porcentaje_robados?>%
                      <span class="sr-only">80%</span>
                    </div>
                  </div>
                  <div class="progress vertical">
                    <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="height: <?=$porcentaje_vandalizados?>%; background-color: #39CCCC;"><?=$porcentaje_vandalizados?>%
                      <span class="sr-only">80%</span>
                    </div>
                  </div>

                </div>

                <div class="col-md-4">
                  <table class="table table-bordered">
                     <tbody>
                       <tr>
                         <td><span class="label label-info" style="font-size:13px"><?=$count_deposito?></span></td>
                         <td>Deposito</td>
                       </tr>
                       <tr>
                         <td><span class="label label-success" style="font-size:13px"><?=$count_proyecto?></span></td>
                         <td>Proyecto</td>
                       </tr>
                       <tr>
                         <td><span class="label label-default" style="background-color: #605ca8; color:#ffffff; font-size:13px"><?=$count_socio?></span></td>
                         <td>Socio</td>
                       </tr>
                       <tr>
                         <td><span class="label label-warning" style="font-size:13px"><?=$count_inti?></span></td>
                         <td>INTI</td>
                       </tr>
                       <tr>
                         <td><span class="label label-danger" style="font-size:13px"><?=$count_oficina_tecnica?></span></td>
                         <td><small>Of. Tecnica Reparaciones</small></td>
                       </tr>
                       <tr>
                         <td><span class="label label-default" style="background-color: #D81B60; color:#ffffff; font-size:13px"><?=$count_robados?></span></td>
                         <td>Robados</td>
                       </tr>
                       <tr>
                         <td><span class="label label-default" style="background-color: #39CCCC; color:#ffffff; font-size:13px"><?=$count_vandalizados?></span></td>
                         <td>Vandalizado</td>
                       </tr>
                     </tbody>
                   </table>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <div class="row">
          <div class="col-md-6 col-xs-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Equipos Instalados en la ultima semana</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <?php if ($total_instalados > 0): ?>
                      <div class="row">
                          <div class="col-md-4 col-xs-4">
                            <div class="table-responsive">
                              <table class="table no-margin">
                                  <thead>
                                  <tr>
                                    <th>Totales</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td>
                                            <?php foreach ($afectados_tipos as $tipo): ?>
                                                <li>
                                                  <span class="text-muted"><small><?=($tipo->tipoEquipo == 1)? "Moviles:":"Fijos:" ?></small></span>
                                                  <span class="pull-right"><a href="javascript:void(0)"><?= $tipo->cantidad?></a></span>
                                                </li>
                                            <?php endforeach; ?>
                                            <br>
                                            <?php foreach ($afectados_municipios as $municipio): ?>
                                                <li>
                                                  <span class="text-muted"><small><?=$municipio->muni ?></small></span>
                                                  <span class="pull-right"><a href="javascript:void(0)"><?= $municipio->cantidad?></a></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </td>
                                      </tr>
                                  </tbody>
                              </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>

                          <div class="col-md-8 col-xs-8">
                            <div class="table-responsive">
                              <table class="table no-margin">
                                  <thead>
                                  <tr>
                                    <th>Equipo</th>
                                    <th>Gestor</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($list_eqAfect as $record): ?>
                                      <tr>
                                        <td><?= "<a href=".base_url("verEquipo/{$record->id}").">" . $record->serie . "</a>"; ?>
                                        <br/><span class="text-muted"><small><?=$record->muni ?></small></span></td>
                                        <td>
                                          <?= "<a href=".base_url("verPersonal/{$record->gestorId}").">" . $record->nombreGestor . "</a>"; ?>
                                        </td>
                                      </tr>
                                    <?php endforeach; ?>
                                  </tbody>
                              </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>
                      </div>
                    <?php else: ?>
                        <span>No hay equipos instalados en la ultima semana.</span>
                    <?php endif; ?>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer clearfix">
                    <span class="pull-left"><strong>&nbsp;TOTAL:<a href="javascript:void(0)"> <?= $total_instalados?></a></strong></span>
                    <form id ="afectados" action="<?php echo base_url(); ?>equiposListing" method="post">
              				<input type="hidden" name="searchNum" name="searchNum" value="40">
              				<input type="hidden" name="columna" name="columna" value="evento_actual">
                      <input type="hidden" name="fecha" name="fecha" value="7">
                      <input type="submit" class="btn btn-sm btn-primary btn-flat pull-right" <?= ($total_instalados == 0) ? "disabled" : "" ?> value="Ver más" />
              			</form>

                  </div>
                  <!-- /.box-footer -->
                </div>
          </div>

          <div class="col-md-6 col-xs-12">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Calibraciones a vencer</h3>
              </div>
              <!-- /.box-header -->
                <div class="box-body table-responsive no-padding" <?= ($total_avencer > 0) ? "id='columna'": "";?> >
                  <table class="table table-bordered table-hover">
                    <?php if ($total_avencer > 0): ?>
                      <thead>
                      <tr class="info">
                        <th>Equipo</th>
                        <th width="50px">Lugar</th>
                        <th>Gestor</th>
                        <th>Fecha de vto.</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($list_calibVence as $record):
                          $fecha_vto = new DateTime($record->doc_fechavto);
                          $fecha_hoy = new DateTime(date('Y-m-d H:i:s'));
                          $dias = $fecha_hoy->diff($fecha_vto);

                          if ($dias->days <= 7){
                              $tr = "<tr class='danger'>";
                          }elseif ($dias->days > 7 && $dias->days <= 14){
                            $tr = "<tr class='warning'>";
                          }else {
                            $tr = "<tr>";
                          } ?>
                          <?= $tr?>
                            <td><?= "<a href=".base_url("verEquipo/{$record->id}").">" . $record->serie . "</a>"; ?>
                            <br/><span class="text-muted"><small><?=$record->muni ?></small></span></td>
                            <td><?= $record->descripEstado ?></td>
                            <td>
                              <?= "<a href=".base_url("verPersonal/{$record->gestorId}").">" . $record->nombreGestor . "</a>"; ?>
                            </td>
                            <td><?=date('d/m/Y',strtotime($record->doc_fechavto))?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    <?php else: ?>
                      <span>No hay calibraciones que se van a vencer.</span>
                    <?php endif; ?>
                  </table>
                </div>
                <!-- /.table-responsive -->
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <span class="pull-left"><strong>&nbsp;TOTAL:<a href="javascript:void(0)"> <?= $total_avencer?></a></strong></span>
              </div>
              <!-- /.box-footer -->
            </div>

        </div>
      </div>

    <?php endif; ?>

  </section>

</div>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
chart.data = [ {
  "country": "Mantenimiento",
  "litres": <?=$mantenimiento?>
}, {
  "country": "Reparacion",
  "litres": <?=$reparacion?>
}, {
  "country": "Instalacion",
  "litres": <?=$instalacion?>
}, {
  "country": "Calibracion",
  "litres": <?=$calibraciones?>
}, {
  "country": "Bajada",
  "litres": <?=$bajada?>
} ];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()
</script>
