<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Numero de Parciales
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <span class="text-muted">Parciales</span>
    </span>
  </div>

    <section class="content">
      <div class="row">

          <div class="col-md-2">
            <div class="tabbable" >
              <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
                <li class="active"><a href="#monocarriles" data-toggle="tab">Monocarriles</a></li>
                <li><a href="#multicarril" data-toggle="tab">Multicarriles</a></li>
                <li><a href="#moviles" data-toggle="tab">Moviles</a></li>
              </ul>
            </div>
          </div>

          <div class="col-md-10">
            <div class="tab-content">
              <div class="tab-pane active" id="monocarriles">
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Cinemometros Monocarriles</h3>
                  </div>
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                      <?php if(empty($parciales_monoRecords)) { ?>
                          <tr>
                              <th>No hay números de parciales.</th>
                          </tr>
                      <?php } else {?>
                          <tr class="info">
                              <th class="text-center">Cantidad</th>
                              <th>Tipo de Servicio</th>
                              <th>Horario</th>
                              <th>Distancia INTI</th>
                              <th>Nº Orden Compra</th>
                          </tr>
                      <?php  }?>
                    <?php
                    if(!empty($parciales_monoRecords))
                    {
                        foreach($parciales_monoRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $record->cantidad;?></td>
                      <td> <?php echo $record->verificacion;?></td>
                      <td>
                        <?php switch ($record->horario_calib):
                          case '1':?>
                            <p>Diurno</p>
                        <?php break;
                          case '2':?>
                            <p>Nocturno</p>
                        <?php break;
                          endswitch;?>
                      </td>
                      <td>
                          <?php switch ($record->distancia_inti):
                          case '1':?>
                            <p>+100KM</p>
                        <?php break;
                          case '2':?>
                            <p>-100KM</p>
                        <?php break;
                          endswitch;?>
                      </td>
                      <td><?php echo($record->nro_oc == NULL) ? "A designar": $record->nro_oc;?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </table>

                  </div>
                </div>
              </div>

              <div class="tab-pane" id="multicarril">

                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Cinemometros Multicarriles</h3>
                  </div>
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                      <?php if(empty($parciales_multiRecords)) { ?>
                        <tr>
                            <th>No hay números de parciales.</th>
                        </tr>
                      <?php } else {?>
                        <tr class="info">
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Nº Carriles</th>
                          <th>Tipo de Servicio</th>
                          <th>Horario</th>
                          <th>Distancia INTI</th>
                          <th>Nº Orden Compra</th>
                        </tr>
                      <?php } ?>
                  <?php
                  if(!empty($parciales_multiRecords))
                  {
                      foreach($parciales_multiRecords as $record)
                      {
                        $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $record->cantidad;?></td>
                    <td class="text-center"><?php echo $record->multicarril;?></td>
                    <td> <?php echo $record->verificacion;?></td>
                    <td>
                      <?php switch ($record->horario_calib):
                        case '1':?>
                          <p>Diurno</p>
                      <?php break;
                        case '2':?>
                          <p>Nocturno</p>
                      <?php break;
                        endswitch;?>
                    </td>
                    <td>
                        <?php switch ($record->distancia_inti):
                        case '1':?>
                          <p>+100KM</p>
                      <?php break;
                        case '2':?>
                          <p>-100KM</p>
                      <?php break;
                        endswitch;?>
                    </td>
                    <td><?php echo($record->nro_oc == NULL) ? "A designar": $record->nro_oc;?></td>
                  </tr>
                  <?php
                      }
                  }
                  ?>
                  </table>
                  </div>
                </div>

              </div>

              <div class="tab-pane" id="moviles">

                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Cinemometros Moviles</h3>
                  </div>
                  <div class="box-body table-responsive no-padding">

                    <table class="table table-bordered table-hover">
                      <?php if(empty($parciales_movilRecords)) { ?>
                        <tr>
                            <th>No hay números de parciales.</th>
                        </tr>
                      <?php } else {?>
                        <tr class="info">
                          <th class="text-center">Cantidad</th>
                          <th>Tipo de Servicio</th>
                          <th>Nº Orden Compra</th>
                        </tr>
                      <?php } ?>
                  <?php
                  if(!empty($parciales_movilRecords))
                  {
                      foreach($parciales_movilRecords as $record)
                      {
                        $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $record->cantidad;?></td>
                    <td><?php echo $record->verificacion;?></td>
                    <td><?php echo($record->nro_oc == NULL) ? "A designar": $record->nro_oc;?></td>
                  </tr>
                  <?php
                      }
                  }
                  ?>
                  </table>

                  </div>
                </div>

              </div>

            </div>
          </div>


    </section>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/calib.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "parcialesListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
