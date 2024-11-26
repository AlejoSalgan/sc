<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Perifericos - Ver periferico
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('perifericos_listado'); ?>"> Perifericos listado</a> /
        <span class="text-muted">Ver periferico</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
              <?="$periferico->serie - $periferico->nombre_tipo"?>
              </h3>
           </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-<?=$periferico->label?>">
            <div class="box-header with-border">
              <h3 class="box-title">
                Estado: <?=$periferico->nombre_estado?>
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
                      <td>ID</td>
                      <td><span class="text-primary"><?=$periferico->id?></span></td>
                    </tr>
                    <tr>
                      <td>Fecha de Alta</td>
                      <td><?=date('d/m/Y - H:i:s',strtotime($periferico->fecha_alta))?></td>
                    </tr>
                    <tr>
                      <td>Creado por</td>
                      <td><?= "<a href=".base_url("verPersonal/{$periferico->creado_por}").">" .$periferico->name. "</a>"; ?></td>
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
                      <td><?=(!$periferico->id_equipo)? "<span class='text-danger'>A designar</span>" : "<a href=".base_url("verEquipo/{$periferico->id_equipo}").">" . $periferico->EM_serie . "</a>" ;?></td>
                    </tr>
                    <tr>
                      <td>Proyecto</td>
                      <td><?=(!$periferico->proyecto)? "<span class='text-danger'>A designar</span>" : $periferico->proyecto ;?></td>
                    </tr>
                    <tr>
                      <td>Socio</td>
                      <td><?=(!$periferico->socio_descrip)? "<span class='text-danger'>A designar</span>" : $periferico->socio_descrip ;?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>
      </div>

      <?php if ($historiales): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Historial</h3>
             </div>

             <div class="box-body table-responsive no-padding">
               <table class="table table-bordered table-hover">
                 <tr class="info">
                   <th class="text-center">ID</th>
                   <th class="text-center">Evento</th>
                   <th class="text-center">Detalles</th>
                   <th class="text-center">Observaciones</th>
                   <th class="text-center">Usuario</th>
                   <th class="text-center">Fecha</th>
                 </tr>

                 <?php foreach ($historiales as $historial): ?>
                   <tr>
                     <td class="text-center"><?=$historial->id?></td>
                     <td class="text-center"><span class="label label-<?= $historial->label_evento;?>"><?=$historial->nombre_evento?></span></td>
                     <td><?=(!$historial->detalle)? "<span class='text-muted'>Sin detalles.</span>" : $historial->detalle ; ?></td>
                     <td><?=(!$historial->observacion)? "<span class='text-muted'>Sin observaciones.</span>" : $historial->observacion ; ?></td>
                     <td class="text-center"><?= "<a href=".base_url("verPersonal/{$historial->usuario}").">" .$historial->name. "</a>"; ?></td>
                     <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($historial->fecha))?></td>
                   </tr>
                 <?php endforeach; ?>
               </table>
             </div>
          </div>
        </div>
      <?php endif; ?>

    </section>
</div>
