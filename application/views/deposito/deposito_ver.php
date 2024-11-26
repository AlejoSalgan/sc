<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/adjuntar_archivo.css'); ?>">

<style media="screen">
  #columna{
    overflow: auto;
    height: 350px; /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
  }

  #principal {
      margin-left: 0px;
  }

  @media screen and (min-width:1024px) {
    #principal {
      margin-left: -100px;
    }
  }

</style>

<div class="content-wrapper">
     <div id="cabecera">
   		Deposito - Detalles del Remito
   		<span class="pull-right">
   			<a href="<?=base_url(); ?>" class="fa fa-home"> Inicio</a> /
            <a href="<?=base_url(strtolower($remito->tipo)."_listado")?>">Listado <?=strtolower($remito->tipo)?></a> /
            <span class="text-muted">Ver Remito</span>
   		</span>
   	</div>

    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Principal</h3>
           </div>
           <div class="box-body">
             <div class="row">
               <div class="col-md-6">
                 <dl class="dl-horizontal" id="principal">
                    <dt>Equipo</dt> <dd><?= "<a href=".base_url("verEquipo/{$remito->id_equipo}").">" . $remito->serie . "</a>"; ?></dd>
                    <dt>Proyecto</dt> <dd><?= ($remito->municipio_descrip == NULL) ? "<span class='text-danger'> A designar </span>" : $remito->municipio_descrip;?></dd>
                    <dt>Categoria</dt> <dd><?=$remito->categoria_descrip?></dd>
                    <dt>Nº Remito</dt> <dd><?= ($remito->num_remito == NULL) ? "<span class='text-danger'> A designar </span>" : $remito->num_remito ; ?></dd>
                 </dl>
               </div>

               <div class="col-md-6">
                 <dl class="dl-horizontal" id="principal">
                  <dt>Recibido Por</dt><dd><?= ($remito->usuario_recibido == NULL) ? "<span class='text-danger'> A designar </span>" : "<a href=".base_url("verPersonal/{$remito->usuario_recibido}").">" . $remito->name . "</a>" ?></dd>
                  <dt>Fecha Recibido</dt> <dd><?= ($remito->fecha_recibido == NULL) ? "<span class='text-danger'> A designar </span>" : date('d/m/Y - H:i:s',strtotime($remito->fecha_recibido)) ?></dd>
                  <dt>Orden Trabajo</dt> <dd><?= ($remito->id_orden == NULL) ? "<span class='text-danger'> A designar </span>" : "<a href=".base_url("ver-orden/{$remito->id_orden}").">" . $remito->id_orden . "</a>"; ?></dd>
                </dl>
               </div>
             </div>
           </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-<?=$remito->label?>">
            <div class="box-header with-border">
              <h3 class="box-title">Estado</h3>
           </div>
           <div class="box-body">
            <p><?=$remito->nombre_estado?></p>
           </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary" <?= ($total_eventos > 0) ? "id='columna'": "";?>>
            <div class="box-header with-border">
              <h3 class="box-title">Eventos</h3>
           </div>
            <?php if($total_eventos > 0): ?>
              <?php $i = $total_eventos ?>
              <?php foreach ($eventos as $evento): ?>
                <div class="panel panel-primary mb-0" >
                  <div class="panel-heading">
                     <?=$i.") ".$evento->nombre_estado?>
                    <span class="pull-right"><?=date('d/m/Y - H:i:s',strtotime($evento->fecha))?></span>
                  </div>
                  <div class="panel-body"><?=$evento->observacion?></div>
                  <div class="panel-footer">
                    Realizado por: <strong><?="<a href=".base_url("verPersonal/{$evento->usuario}").">" . $evento->name . "</a>"; ?></strong>
                  </div>
                </div>
                <?php $i-- ?>
              <?php endforeach; ?>
            <?php else:?>
              <div class="box-body">
                <p>No hay eventos para este remito.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Archivos cargados </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php if ($cant_archivos > 0): ?>
              <?php foreach ($archivos as $archivo): ?>
              <li class="item">
                <div class="">
                  <strong> <?="<a href=".base_url("verPersonal/{$archivo->creado_por}").">" . $archivo->name . "</a>"; ?> </strong> <span class="pull-right"><?=date('d/m/Y - H:i:s',strtotime($archivo->fecha_ts))?></span>
                  <br>
                  <td><strong><?= ($archivo->nombre_archivo == NULL)? 'Sin titulo' : $archivo->nombre_archivo; ?></strong></td>
                  <br>
                  <td><?=$archivo->observacion?></td>
                  <br>
                  <td>
                    <form action="<?=base_url($descargar)?>" method="post">
                      <input type="hidden" name="name" value="<?=$archivo->archivo?>">
                      <input type="hidden" name="tipo" value="<?=$archivo->tipo?>">
                      <input type="hidden" name="id_orden" value="<?= $id_orden?>">
                      <input type="hidden" name="direccion" value="<?=uri_string()?>">
                      <input type="hidden" name="ref" value="<?= $this->input->get('ref')?>">
                      <input type="hidden" name="searchText" value="<?= $this->input->get('searchText')?>">
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
              <?php else: ?>
              <p>No hay archivos para esta orden.</p>
              <?php endif; ?>
            </ul>
          </div>
        </div><!-- /.box -->
      </div>

      </div>

    </section>
 </div>
