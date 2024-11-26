<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/adjuntar_archivo.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - Ver Desintalacion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url($link); ?>"> <?=$titulo?></a> /
        <span class="text-muted">Ver Relevamiento</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-<?=$orden->estado_label?>">
            <div class="box-header with-border">
              <h3 class="box-title">
                Estado: <?=$orden->tipo_estado?>
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
                      <td><span class="text-primary"><?=$orden->id?></span></td>
                    </tr>
                    <tr>
                      <td>Tipo</td>
                      <td><span class="text-primary"><?= $orden->tipoOrden;?></span></td>
                    </tr>

                    <tr>
                      <td>Solicitado por</td>
                      <td><?= "<a href=".base_url("verPersonal/{$orden->solicitado_por}").">" .$orden->solicitado_name. "</a>"; ?></td>
                    </tr>

                    <tr>
                      <td>Fecha Solicitacion</td>
                      <td><?=date('d/m/Y',strtotime($orden->fecha_solicitacion))?></td>
                    </tr>

                    <tr>
                      <td>Ultima modificacion</td>
                      <td><?=date('d/m/Y - H:i:s',strtotime($orden->fecha_ts))?></td>
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
                      <td>Proyecto</td>
                      <td><?=$orden->proyecto?></td>
                    </tr>

                    <tr>
                      <td>Equipo</td>
                      <td><span class="text-primary"><?=$orden->equipoSerie ?></span></td>
                    </tr>

                    <tr>
                      <td>Tipo Equipo</td>
                      <td><?=$orden->tipo_equipo_descrip?></td>
                    </tr>

                    <tr>
                      <td>Direccion</td>
                      <td><?= ($orden->direccion) ? $orden->direccion : "A designar" ;?></td>
                    </tr>

                    <tr>
                      <td>Fecha Limite</td>
                      <td><?=date('d/m/Y',strtotime($orden->fecha_limite))?></td>
                    </tr>

                  </tbody>
                </table>
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
                         <form action="<?=base_url('archivo_descargar')?>" method="post">
                           <input type="hidden" name="name" value="<?=$archivo->archivo?>">
                           <input type="hidden" name="tipo" value="<?=$archivo->tipo?>">
                           <input type="hidden" name="parametro" value="<?= $parametro?>">
                           <input type="hidden" name="pagina_actual" value="<?= $pagina_actual?>">
                           <input type="hidden" name="sector" value="<?= $sector?>">
                           <input type="hidden" name="nombre_archivo" value="<?= $archivo->nombre_archivo?>">

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


      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Eventos</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <tr class="info">
                 <th class="text-center">ID</th>
                 <th class="text-center">Evento</th>
                 <th class="text-center">Observaciones</th>
                 <th class="text-center">Usuario</th>
                 <th class="text-center">Fecha</th>
               </tr>

               <?php foreach ($eventos as $evento): ?>
                 <tr>
                   <td class="text-center"><?=$evento->id?></td>
                   <td class="text-center"><span class="label label-<?= $evento->estado_label;?>"><?=$evento->tipo_estado?></span></td>
                   <td><span class='text-muted'><?=$evento->observacion?></span></td>
                   <td class="text-center"><?= "<a href=".base_url("verPersonal/{$evento->usuario}").">" .$evento->name. "</a>"; ?></td>
                   <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($evento->fecha))?></td>
                 </tr>
               <?php endforeach; ?>


             </table>
           </div>
        </div>
      </div>

    </section>
</div>
