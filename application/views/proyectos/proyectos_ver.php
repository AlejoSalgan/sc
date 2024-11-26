<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  #piechart{ position: relative; right: 10px; }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
     <div id="cabecera">
      Proyectos - <?= $municipioInfo->descrip?>
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('municipiosListing'); ?>">Proyectos</a> /
        <span class="text-muted"><?= $municipioInfo->descrip?></span>
      </span>
    </div>

     <section class="content">
       <div class="box box-primary">
         <div class="box-header with-border">
             <h3 class="box-title">
               <?php if ($municipioInfo->activo): ?>
                <span class="label label-success"><?= $municipioInfo->descrip?></span>
              <?php else: ?>
                  <span class="label label-danger"><?= $municipioInfo->descrip?></span>
              <?php endif; ?>
             </h3>
        </div>
       </div>

       <div class="row">
         <div class="col-md-6">
           <div class="box box-primary">
             <div class="box-header with-border">
               <h3 class="box-title">Gestion de Proyecto</h3>
             </div>
             <!-- /.box-header -->
             <div class="box-body no-padding">
               <table class="table table-striped table-bordered">
                 <tr class="info">
                   <th class="text-center">Nombre</th>
                   <th class="text-center">Rol</th>
                   <th class="text-center">A cargo</th>
                 </tr>
                 <?php foreach ($gestiones as $gestion): ?>
                   <tr>
                     <td class="text-center"><?= "<a href=".base_url("verPersonal/{$gestion->usuario}").">" .$gestion->name. "</a>"; ?></td>
                     <td class="text-center"><?= $gestion->role?></td>
                     <td class="text-center"><?= ($gestion->prioridad == 1) ? 'SI' : 'NO' ; ?></td>
                   </tr>
                 <?php endforeach; ?>
               </table>
             </div>
           </div>
         </div>
         <!-- ./col -->
         <div class="col-md-6">
           <div class="box box-primary">
             <div class="box-header with-border">
               <h3 class="box-title">Estados</h3>
             </div>
             <div class="box-body">
                 <div id="piechart"></div>
             </div>
           </div>
         </div>
       </div>

       <div class="row">
         <div class="col-md-6">
           <div class="box box-primary">
             <div class="box-header with-border">
               <h3 class="box-title">Tipos de equipos</h3>
             </div>
             <!-- /.box-header -->
             <div class="box-body no-padding">
               <table class="table table-striped table-bordered">
                 <tr>
                   <th style="width: 10px">Cantidad</th>
                   <th>Tipo</th>
                   <th>Progreso</th>
                   <th style="width: 40px">Porcentaje</th>
                 </tr>
                 <?php foreach ($tipos as $tipo):
                   $porcentaje = number_format(($tipo->cantidad/$total->cantidad)*100,2);
                   $color = $color = sprintf("#%06x",rand(0,16777215));
                   ?>
                   <tr>
                     <td class="text-center"><?= $tipo->cantidad?></td>
                     <td><?= $tipo->descrip?></td>
                     <td>
                       <div class="progress progress-xs">
                         <div class="progress-bar progress-bar-default" style="width: <?=$porcentaje?>%; background-color:<?=$color?>"></div>
                       </div>
                     </td>
                     <td><span class="badge bg-default" style="background-color:<?=$color?>"><?=$porcentaje?>%</span></td>
                   </tr>
                 <?php endforeach; ?>
               </table>
             </div>
           </div>
         </div>
       </div>
     </section>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
      ['Estado', 'Cantidad de equipos'],
      <?php foreach ($estados as $estado):
        echo "['".$estado->descrip."',".$estado->cantidad."],";
      endforeach; ?>
    ]);

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Cantidad de equipos segun su estado', 'width':487, 'height':400};

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
</script>
