<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

switch ($tipoItem):  // Dependiendo del tipo se cargaran los permisos de las acciones y el titulo.
    case "Pendientes":
        $INGpendientes = explode(',', $ingreso_pendientes);
        $accion ="protocolosListing";
        break;
    case "Ingresados":
        $INGingresados = explode(',', $ingreso_ingresados);
        $accion ="protocolosingListing";
        break;
    case "Anulados":
        $INGanulados = explode(',', $ingreso_anulados);
        $accion ="protocolosanuladoListing";
        break;
    case "Ceros":
        $INGcero = explode(',', $ingreso_cero);
        $accion ="protocolosceroListing";
        break;
endswitch;

if(empty($criterio)){
  $criterio = 0;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Protocolos <?= $tipoItem; ?>
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <?php if ($tipoItem == "Pendientes" && $INGpendientes[1] == 1): ?>
          <a href="<?= base_url('grupos_estados'); ?>"> Proyectos Pendientes</a> /
        <?php endif; ?>
  		  <span class="text-muted">Protocolos <?=$tipoItem; ?></span>
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
                    <h3 class="box-title">Protocolos listado</h3>
                    <div class="box-tools">
                        <form action="<?= base_url(''.$accion.'') ?>" method="GET" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 145px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Protocolo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Fecha Protocolo</option>
                                  <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Fecha Desde</option>
                                  <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Fecha Hasta</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Cantidad</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover">
                    <tr class="info">
                      <th class="text-center">Protocolo</th>
                      <th class="text-center">Equipo</th>
                      <th class="text-center">Fecha Protocolo</th>
                      <th class="text-center">Fecha Desde</th>
                      <th class="text-center">Fecha Hasta</th>
                      <th class="text-center">Cant. Archivos</th>
                      <th class="text-center">Estado</th>
                      <?php if ($tipoItem == "Ingresados"): ?>
                        <th class="text-center">Exportacion</th>
                      <?php endif; ?>
                      <th>Acciones</th>
                    </tr>

                    <?php foreach ($protocolosRecords as $key => $record):
                      $fila ="";
                      if ($record->bajada_archivos > 0 && $record->subida_estado == 0) {
                        $fecha_evento = new DateTime($record->fecha_procesado);
                        $interval = $fecha_evento->diff(new DateTime($record->bajada_desde));
                        $dias =  $interval->format('%a%');
                        if ($dias >= 30) {
                          $label = "danger";
                        } else {
                          $label = "primary";
                        }
                      } else {
                        $label = "primary";
                      }

                      if ($record->requiere_calibracion == 1 && $record->subida_estado == 0) {
                      $fecha_vto= new DateTime($record->doc_fechavto);
                      $fecha_hoy = new DateTime(date());
                      $dias2 = $fecha_vto->diff($fecha_hoy);
                        if ($dias2->days >=8 && $dias2->days <= 14 && $dias2->invert == 1){
                          $fila = "warning";
                        }elseif ($dias2->invert == 0 || ($dias2->days <= 7 && $dias2->invert == 1)){
                          $fila = "danger";
                        }else {
                          $fila ="";
                        }
                      }

                      ?>
                      <tr class="<?=$fila?>">
                        <td class="text-center"><p class="label label-<?=$label?>" style="color:white; font-size:16px;"><?=$record->protocolo ?></p></td>

                        <td><?= "<a href=".base_url("verEquipo/{$record->idequipo}").">" . $record->equipoSerie . "</a>";?><br/><span class="text-muted"><small><?=$record->descripProyecto ?></small></span></td>

                        <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($record->fecha_procesado));?>
                        <?php if ($record->requiere_calibracion == 1 && $record->subida_estado == 0): ?>
                          <br><span class="text-warning">Vto: <?= date('d/m/Y',strtotime($record->doc_fechavto));?></span>
                        <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($record->bajada_archivos > 0) {
                                echo date('d/m/Y - H:i',strtotime($record->bajada_desde));
                            } elseif ($record->bajada_archivos == 0 AND ($record->subida_FD == NULL || $this->fechas->cambiaf_a_arg_hor($record->subida_FD) == '01/01/1970 - 01:00:00')){
                                echo '<strong><span class="text-danger">SIN FECHA</span></strong>';
                            } elseif ($record->bajada_archivos == 0 AND $record->subida_FD != NULL){
                                echo date('d/m/Y - H:i',strtotime($record->subida_FD));
                            } ?>
                        </td>
                        <td class="text-center">
                            <?php if ($record->bajada_archivos > 0) {
                                echo date('d/m/Y - H:i',strtotime($record->bajada_hasta));
                            } elseif ($record->bajada_archivos == 0 AND ($record->subida_FH == NULL || $this->fechas->cambiaf_a_arg_hor($record->subida_FH) == '01/01/1970 - 01:00:00')){
                                echo '<strong><span class="text-danger">SIN FECHA</span></strong>';
                            } elseif ($record->bajada_archivos == 0 AND $record->subida_FH != NULL){
                                echo date('d/m/Y - H:i',strtotime($record->subida_FH));
                            } ?>
                        </td>
                        <td class="text-center">
                          <?php if ($record->subida_cant == NULL || $record->subida_cant == 0) { ?>
                            <?php if ($record->bajada_archivos == 0): ?>
                              <?php $color = 'danger'; ?>
                            <?php else: ?>
                              <?php $color = 'primary'; ?>
                            <?php endif; ?>
                            <span class="text-center"><span class="label label-<?=$color?>" style="color:white; font-size:13px;"><?=$record->bajada_archivos ?></span></span>
                          <?php } elseif ($record->bajada_archivos == 0 && ($record->subida_cant != NULL || $record->subida_cant != 0)) { ?>
                            <span class="text-center"><span class="label label-primary" style="color:white; font-size:13px;"><?=$record->subida_cant ?></span>
                            </span>
                          <?php } elseif ($record->bajada_archivos >= 0 && ($record->subida_cant != NULL || $record->subida_cant != 0)) { ?>
                            <span class="text-center"><span class="label label-primary" style="color:white; font-size:13px;"><?=$record->subida_cant ?></span>
                            </span>
                          <?php } ?>
                          <br>
                          <?php if ($record->bajada_archivos > 0): ?>
                            <?php if ($record->transferido_tipo == 0): ?>
                              <span class="text-primary">Enviado Online</span>
                            <?php else: ?>
                              <span class="text-muted"> Enviado Disco</span>
                            <?php endif; ?>
                          <?php endif; ?>
                        </td>

                        <td class="text-center"><span class="<?= $record->label;?>"><?= $record->estado;?></span></td>
                        <?php if ($tipoItem == "Ingresados"): ?>
                          <td class="text-center">
                            <?php
                              switch ($record->estado_expo) {
                                case 99:
                                    $color = "#3273cd";
                                    $info_estado = "Exportado";
                                  break;
                                case 70:
                                    if ($record->decripto == 5) {
                                      $color = "#db3a34";
                                      $info_estado = "Anulado";
                                    }
                                  break;
                                case 0:
                                      $color = "#ea9c0d";
                                      $info_estado = "Pendiente";
                                  break;
                              }
                            ?>
                            <span class="label label-default" style="background-color: <?= $color?>; color: #ffffff"><?= $info_estado?></span>
                            <?php if ($record->estado_expo == 99): ?>
                              <br/>
                              <?= "<a href=".base_url("verExportacion/{$record->idexportacion}").">" . "Nº ".$record->idexportacion . "</a>"; ?>
                            <?php endif; ?>
                          </td>
                        <?php endif; ?>

                        <td>
                            <?php if($INGpendientes[0] == 1 || $INGingresados[0] == 1 || $INGanulados[0] == 1 || $INGcero[0] == 1) { ?>
                                <a data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("verProtocolos/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php } ?>

                            <?php if($INGpendientes[1] == 1) { ?>
                                <a data-toggle="tooltip" title="Editar" href="<?=base_url("protocolos_editar/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php } ?>

                            <?php if($INGpendientes[2] == 1) { ?>
                                <a data-toggle="modal" title="Anular Protocolo" data-target="#modalDeshabilitar<?php echo $record->protocolo ?>" ><i class="fa fa-trash" style="color:#dc4c3c;"></i> &nbsp;&nbsp;&nbsp;</a>
                                    <!-- sample modal content -->
                                    <div id="modalDeshabilitar<?php echo $record->protocolo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Anular el Protocolo Nº <?php echo $record->protocolo ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('anular_protocolo')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?php echo $record->protocolo ?>" >

                                                        <p>¿Desea anular el protocolo?</p>
                                                        <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al deshabilitarlo no se podrá ingresar la información del equipo</p>
                                                        <div class="form-group">
                                                          <label for="subida_observ">Observaciones</label>
                                                          <textarea name="subida_observ" id="subida_observ" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                          <div class="help-block with-errors"></div>
                                                      </div>
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

                            <?php if($INGpendientes[3] == 1) { ?>
                                <?php if (($record->bajada_archivos == 0 && $record->subida_cant == NULL) || (($record->subida_ingresados > 0) || ($record->subida_cant > 0)) || ($record->subida_errores == 0 && $record->subida_vencidos > 0) ) { ?>
                                    <a data-toggle="modal" title="Finalizar Protocolo" data-target="#modalFinalizar<?php echo $record->protocolo; $record->bajada_archivos; $record->subida_cant; $record->subida_ingresados; $record->subida_FD; $record->subida_FH; $record->subida_vencidos; $record->subida_errores ?>" ><i class="fa fa-check" style="color:#1cc45c;"></i> &nbsp;&nbsp;&nbsp;</a>
                                    <!-- sample modal content -->
                                    <div id="modalFinalizar<?php echo $record->protocolo; $record->bajada_archivos; $record->subida_cant; $record->subida_ingresados; $record->subida_FD; $record->subida_FH; $record->subida_vencidos; $record->subida_errores ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Finalizar el Protocolo Nº <?php echo $record->protocolo ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('finalizar_protocolo')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">

                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?php echo $record->protocolo ?>" >
                                                        <?php if (($record->subida_ingresados > 0 && $record->subida_cant == 0 && $record->subida_FD != NULL && $record->subida_FH != NULL) ) { ?>
                                                          <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="1" >
                                                        <?php } else { ?>
                                                          <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="4" >
                                                        <?php } ?>


                                                        <?php if (($record->subida_ingresados > 0) || ($record->subida_cant > 0)): ?>
                                                        <p>¿Desea ingresar el protocolo?</p>
                                                          <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al ingresarlo no se podrá modificar la información del equipo</p>

                                                        <?php elseif (($record->bajada_archivos == 0 && $record->subida_cant == NULL) || ($record->subida_errores == 0 && $record->subida_vencidos > 0)): ?>
                                                          <p>¿Desea finalizar el protocolo en cero?</p>
                                                          <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cerrarlo no se podrá modificar la información del equipo</p>
                                                          <div class="form-group">
                                                              <input type="hidden" class="form-control" id="subida_estado" name="subida_estado" value="2" >
                                                              <label for="subida_observ">Observaciones</label>
                                                              <textarea name="subida_observ" id="subida_observ" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                              <div class="help-block with-errors"></div>
                                                          </div>
                                                        <?php endif ?>
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
                            <?php } ?>


                            <?php if($INGingresados[1] == 1) { ?>
                                <a data-toggle="modal" title="Cambiar estado" data-target="#modalCambio<?= $record->protocolo ?>" ><i class="fa fa-undo" style="color:#ff0000;"></i> &nbsp;&nbsp;&nbsp;</a>
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



                            <?php if($INGpendientes[4] && $record->bajada_archivos >=10001) { ?>
                                <a data-toggle="tooltip" title="Dividir Protocolo" href="<?=base_url("dividir_protocolo/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-cut"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php } ?>


                            <?php if($INGpendientes[5] && $record->protocolo == 999) { ?>
                                <a data-toggle="tooltip" title="Enlazar Protocolo" href="<?=base_url("enlazar_protocolo/{$record->id}?searchText={$searchText}&criterio={$criterio}")?>"><i class="fa fa-random"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php } ?>














                        </td>

                      </tr>
                    <?php endforeach; ?>

                  </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>

              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            <?php switch ($tipoItem) {
              case "Pendientes":?>
                jQuery("#searchList").attr("action", baseURL + "protocolosListing/" + value);
              <?php  break;
              case "Manuales":?>
                jQuery("#searchList").attr("action", baseURL + "protocolosListing/" + value);
              <?php  break;
              case "Ingresados":?>
                jQuery("#searchList").attr("action", baseURL + "protocolosingListing/" + value);
              <?php  break;
              case "Anulados":?>
                jQuery("#searchList").attr("action", baseURL + "protocolosanuladoListing/" + value);
              <?php  break;
              case "Ceros":?>
                jQuery("#searchList").attr("action", baseURL + "protocolosceroListing/" + value);
              <?php  break;
            }?>
            jQuery("#searchList").submit();
        });
    });
</script>
