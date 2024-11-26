<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$INGingresados = explode(',', $ingreso_ingresados);

if(empty($criterio)){
  $criterio = 0;
}
?>

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }

  .etiqueta13{
    font-size: 13px;
  }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/estilo_tablas_2.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
      Protocolos - Protocolos Ingresados
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Protocolos Ingresados</span>
      </span>
    </div>

    <section class="content">
      <div class="row">
          <div class="col-md-12">
              <?php
              $this->load->helper('form');
              if ($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('error'); ?>
                  </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
              <?php endif; ?>
          </div>
      </div>

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
                    <?php if ($total > 0): ?>
                    Total:<b><a href="javascript:void(0)"> <?= $total?></a></b>
                  <?php else: ?>
                    No hay datos para mostrar.
                  <?php endif; ?>
                  </h3>

                    <div class="box-tools">
                        <form action="<?= base_url("protocolosingListing") ?>" method="GET" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Protocolo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Fecha Protocolo</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Cantidad</option>
                                  <option value="10" <?php if($criterio == 10) {echo "selected=selected";} ?>>Modelo Equipo</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->

                <?php if ($total > 0): ?>
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr class="info">
                          <th class="text-center">Protocolo</th>
                          <th class="text-center">Equipo</th>
                          <th class="text-center">Fecha Protocolo</th>
                          <th class="text-center">Fecha Confirmado</th>
                          <th class="text-center">Archivos</th>
                          <th class="text-center">Estado</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>

                      <?php foreach ($protocolosRecords as $key => $record): ?>
                        <tr>
                        <!-- Protocolo -->
                        <td class="text-center"><span class="label label-primary etiqueta14 text-center"><?=$record->protocolo ?></span></td>

                        <!-- Equipo y Proyecto -->
                        <td><?= "<a href=".base_url("verEquipo/{$record->idequipo}").">" . $record->equipoSerie . "</a>";?><br/><small class="text-muted"><?=$record->descripProyecto?></small></td>

                        <!-- Fecha del Protocolo -->
                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($record->fecha_procesado));?>
                        </td>

                        <!-- Fecha de finalizacion -->
                        <td class="text-center"><?= date('d/m/Y - H:i',strtotime($record->subida_fecha));?>
                        </td>

                        <!-- Cantidad Archivos  y el Metodo de envio -->
                        <td class="text-center"><span class="label label-primary etiqueta13">
                          <?php if ($record->subida_cant == NULL || $record->subida_cant == 0): ?>
                            <?=$record->bajada_archivos ?>
                          <?php else: ?>
                            <?=$record->subida_cant ?>
                          <?php endif; ?>
                          </span>
                          <br>
                          <?php if ($record->transferidos_estado == 10 || $record->transferidos_estado == 20): ?>
                            <?php if ($record->bajada_archivos > 0): ?>
                              <?php if ($record->transferido_tipo == 0): ?>
                                <span class="text-primary">Enviado Online - <?= substr(ucfirst($record->ubicacion),0,5)." ".substr($record->ubicacion,-1)?></span>
                              <?php else: ?>
                                <span class="text-muted"> Enviado Disco - <?= substr(ucfirst($record->ubicacion),0,5)." ".substr($record->ubicacion,-1)?></span>
                              <?php endif; ?>

                            <?php endif; ?>
                          <?php endif; ?>
                        </td>

                        <!-- Estado -->
                        <td class="text-center">
                          <?php
                            switch ($record->decripto) {
                              case 0:
                                $info_estado = "Bajada";
                                $color = "#66807c";
                                break;

                              case 1:
                                $info_estado = "Pendiente Desencriptacion";
                                $color = "#e69d45";
                                break;

                              case 2:
                                $info_estado = "Desencriptando";
                                $color = "#6366f1";
                                break;

                              case 3:
                                $info_estado = "Incorporando";
                                $color = "#209b60";
                                break;

                              case 4://decripto 4
                                switch ($record->pm_estado) {

                                  case 99:
                                    switch ($record->incorporacion_estado) {
                                      case 52:
                                        $info_estado = "Salida de Edicion Aprobada";
                                        $color = "#27a269";
                                        break;
                                      
                                      case 55:
                                        $info_estado = "Salida de Edicion Observada";
                                        $color = "#af1a1d";
                                        break;
                                        
                                      case 65:
                                        $info_estado = "Salida de Edicion Pendiente";
                                        $color = "#45818e";
                                        break;                                                                          
                                      
                                      default:
                                        $info_estado = "Sin estado";
                                        $color = "#af1a1d";
                                        break;
                                    }
                                    break;

                                  case 0:
                                    switch ($record->incorporacion_estado) {
                                      case 0:
                                        $info_estado = "Desencriptado";
                                        $color = "#5e62a8";
                                        break;
    
                                      case 60:
                                        $info_estado = "Edicion";
                                        $color = "#1c8cfc";
                                        break;
                                      
                                      case 63:
                                        $info_estado = "Error impacto";
                                        $color = "#db3a34";
                                        break;
    
                                      case 65:
                                        $info_estado = "Edicion finalizada";
                                        $color = "#2f9839";
                                        break;
    
                                      case 69:
                                        $info_estado = "Verificacion";
                                        $color = "#e69d45";
                                        break;
    
                                      case 72:
                                        $info_estado = "Descartado en Edicion";
                                        $color = "#db3a34";
                                        break;

                                      case 200:
                                        $info_estado = "Protocolo apto para subir a Cointra";
                                        $color = "#45818e";
                                        break;                                      

                                      case 201:
                                        $info_estado = "Protocolo en Cointra";
                                        $color = "#45818e";
                                        break;
                                      
                                      default:
                                        $info_estado = "Sin estado";
                                        $color = "#af1a1d";
                                        break;
                                    }
                                    break;
                                  
                                  default:
                                    $info_estado = "Sin estado";
                                    $color = "#af1a1d";
                                    break;
                                }

                                break;

                              case 5:
                                $info_estado = "Anulado";
                                $color = "#db3a34";
                                break;

                              case 6:
                                $info_estado = "Protocolo en revision";
                                $color = "#ff8654";
                                break;

                              case 10:
                                $info_estado = "Ingreso";
                                $color = "#2f9839";
                                break;

                              default:
                                $info_estado = "Sin estado";
                                $color = "#af1a1d";
                                break;
                            }
                          ?>

                          
                          <span class="label label-default" style="background-color: <?= $color?>; color: #ffffff"><?= $info_estado?></span>
                          <?php if ($record->pm_estado == 99): ?>
                            <br/><b>
                            <?php $expo_numero = ($record->num_expo)? $record->num_expo : $record->id_expo;?>
                            <?= "<a href=".base_url("verExportacion/{$record->idexportacion}").">" . "Nº ".$expo_numero . "</a>"; ?>
                            </b>
                          <?php endif; ?>
                        </td>

                        <td>
                          <?php if($INGingresados[0] == 1) { ?>
                              <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("verProtocolos/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>
                          <?php } ?>

                          <?php if($INGingresados[1] == 1) { ?>
                              <a class="btn btn-danger btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Cambiar estado" data-target="#modalCambio<?= $record->protocolo ?>"><i class="fa fa-undo"></i></a>

                                  <!-- sample modal content -->
                                  <div id="modalCambio<?=$record->protocolo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">Cambiar de estado al Protocolo Nº <?=$record->protocolo ?></h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('estado_protocolo')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?=$record->protocolo ?>">
                                                      <input type="hidden" class="form-control" id="estado" name="estado" value="0">
                                                      <p>¿Desea cambiar el estado del protocolo?</p>
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Al aceptar el protocolo volvera a la pantalla de Protocolos Pendientes.</p>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-info btn-rounded">Aceptar</button>
                                              </div>
                                          </form>
                                          </div>
                                          <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                          <?php } ?>
                          <br>
                          <?php if ($record->protocolo != $record->pm_protocolo): ?>
                            <span class="text-danger"><b>PROTOCOLO CRUZADO</b></span>
                          <?php endif; ?>
                        </td>

                      </tr>
                      <?php endforeach; ?>
                    </table>
                  </div><!-- /.box-body -->
                <?php endif; ?>

                <?php if ($total > 15): ?>
                  <div class="box-footer clearfix">
                      <?= $this->pagination->create_links(); ?>
                  </div>
                <?php endif; ?>

              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "protocolosingListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
