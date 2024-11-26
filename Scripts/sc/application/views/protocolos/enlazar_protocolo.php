<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }
</style>


<div class="content-wrapper">
    <div id="cabecera">
      Bajada de memoria - Enlazar Protocolo
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

                <form role="form" action="<?= base_url('protocolos_cruzados') ?>" method="post">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Id equipo</label>
                              <input type="number" class="form-control" id="idequipo"  name="idequipo" maxlength="6" min="1" value="" required>
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



      <?php  if ($idequipo > 0):  ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Bajadas</h3>
           </div>

           <div class="box-body table-responsive no-padding">
           <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Datos Completos ORDENESB_MAIN <span class="text-primary"><!-- <?=$protocolosM->idequipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Nº Orden</th>
                 <th class="text-center">Equipo Serie</th>
                 <th class="text-center">Fecha</th>
                 <th class="text-center">Protocolos</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

                 <tr>
                   <?php foreach ($idequipo as $protocolo): ?>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->id?></span></td>
                   <td class="text-center"><?=$protocolo->serie?></td>
                   <td class="text-center"><?=$protocolo->fecha_visita?></td>
                   <td class="text-center"><?=$protocolo->protocolo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->bajada_desde))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->bajada_hasta))?></td>
                   <td class="text-center"><?=$protocolo->bajada_archivos?></td>
                 </tr>
                  <?php endforeach; ?>
             </table>
             <br><br>
             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Diferencias PROTOCOLOS_MAIN <span class="text-primary"><!-- <?=$protocolosM->idequipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

                 <tr>
                   <?php foreach ($protocolosM as $protocolo): ?>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
                  <?php endforeach; ?>
             </table>
             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Diferencias ORDENES_MAIN <span class="text-primary"><!-- <?=$protocolosM->idequipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

                 <tr>
                   <?php foreach ($Ordenesb as $protocolo): ?>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
                  <?php endforeach; ?>
             </table>

             <br><br>

             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Bajadas no correlativas PROTOCOLOS_MAIN <span class="text-primary"><!-- <?=$equipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

               <?php foreach ($noconsecutivosPro as $protocolo): ?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
               <?php endforeach; ?>
             </table>

             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Bajadas no correlativas ORDENES_MAIN <span class="text-primary"><!-- <?=$equipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

               <?php foreach ($noconsecutivosOrd as $protocolo): ?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
               <?php endforeach; ?>
             </table>

             <br><br>

             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Bajadas con fehas Pisadas PROTOCOLOS_MAIN <span class="text-primary"><!-- <?=$equipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

               <?php foreach ($nocorrelaticoPro as $protocolo): ?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
                   <td class="text-center"><span class="text-success"><b><?=$protocolo->nro_msj?></b></span></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_inicial))?></td>
                   <td class="text-center"><?=date('d/m/Y',strtotime($protocolo->fecha_final))?></td>
                   <td class="text-center"><?=$protocolo->cantidad?></td>
                 </tr>
               <?php endforeach; ?>
             </table>

             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Bajadas con fehas Pisadas ORDENES_MAIN <span class="text-primary"><!-- <?=$equipo?> --></span></th>
               </tr>

               <tr class="info">
                 <th class="text-center">Protocolo</th>
                 <th class="text-center">Id Equipo</th>
                 <th class="text-center">Nro msj</th>
                 <th class="text-center">Fecha desde</th>
                 <th class="text-center">Fecha hasta</th>
                 <th class="text-center">Cantidad</th>
               </tr>

               <?php foreach ($nocorrelaticoOrd as $protocolo): ?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$protocolo->protocolo?></span></td>
                   <td class="text-center"><?=$protocolo->idequipo?></td>
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
      <?php if ($idequipo): ?>
      <div class="row">
        <div class="col-xs-12">
          <form role="form" action="<?= base_url('acomodar_protocolo') ?>" method="post">

          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Enlazar Protocolo Cruzados</h3>
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

