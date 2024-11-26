<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$EQequipos = explode(',', $equipos_equipos); //Los permisos para cada boton de Acciones.
if(empty($criterio)){
  $criterio = 0;
}
echo "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX3EQUIPOS:PHP<br>";

?>

<style type="text/css">
  @media print {
    a[href]:after {content: none !important;}
    #botonImprimir {display: none;}
  }
  .letterC {
background-color: #B22222;
color:white;
position: relative;
margin-top: 10px;
font-family: Arial;
  }

  .letterI {
background-color: #1E90FF;
color:white;
position: relative;
margin-top: 10px;
font-family: Arial;
  }
</style>

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
</style>

<script>
function Imprimir() {
  window.print();
}
</script>

<div class="content-wrapper">
    <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
      Equipos
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Equipos listado</span>
      </span>
    </div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if ($error): ?>
                      <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                <?php
                $success = $this->session->flashdata('success');
                if ($success): ?>
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>

              <div class="row">
                  <div class="col-md-12">
                      <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                  </div>
              </div>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-10 text-left">
                <div class="form-group">
               	    <a><button id="botonImprimir" class="btn btn-primary" onclick="Imprimir()">Imprimir</button></a>
                </div>
            </div>
            <div class="col-xs-2 text-right btn-toolbar">
                <div class="form-group">
                    <?php if ($EQequipos[0] == 1): ?>
                      <a id="botonImprimir" class ="btn btn-labeled btn-primary" href="<?=base_url('agregar_equipo'); ?> " role="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Agregar Equipo</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div id="botonImprimir" class="box-header">
                    <h1 class="box-title">
                      <?php if ($total > 0): ?>
                        Total: <span class="text-primary"><b><?= $total?></b></span>
                      <?php else: ?>
                        No hay datos para mostrar.
                      <?php endif; ?>
                    </h1>
                    <div class="box-tools">
                        <form action="<?=base_url('equiposListing') ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input id="botonImprimir" type="text" name="searchText" value="<?=$searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                              <select id="botonImprimir" class="form-control pull-right" id="criterio" name="criterio" style="width: 101px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Serie</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Modelo</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Marca</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Asociado</option>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Lugar</option>
                                  <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Evento</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Propietario</option>
                                  <option value="10" <?php if($criterio == 10) {echo "selected=selected";} ?>>Dirección</option>
                              </select>
                              <div class="input-group-btn">
                                <button id="botonImprimir" class="btn btn-sm btn-default searchList"><i id="botonImprimir" class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->

                <?php if ($total > 0): ?>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover">
                    <tr class="info">
                      <th>Serie</th>
                      <th width="50px">Lugar</th>
                      <th>Evento</th>
                      <th>Calib Vto</th>
                      <th width="110px">Gestor</th>
                      <th>Modelo-Marca</th>
                      <th>Asociado</th>
                      <th>Propietario</th>
                      <th id="botonImprimir">Acciones</th>
                    </tr>

                    <?php foreach ($equiposRecords as $record):
                        $etiqueta = ($record->activo == 1) ? "primary" : "danger";
                        $lt = array(1,2,400,2402,2407,2412);
                        $fecha_hoy = new DateTime(date());
                        $fecha_vto = new DateTime($record->doc_fechavto);
                        //Solo por la prorroga de los dias
                        if ($record->prorroga_bajada && $record->tipo_equipo == 0 && $record->doc_fechavto > '2020-03-18') {
                          $fecha_vto->add(new DateInterval("P".$record->prorroga_bajada."D"));
                        }
                    ?>
                    <tr>
                      <td>
                        <span> <!-- //Continuar bajada -->
                          <?php if ($record->bajada == 1 ): ?>
                            <?php if ($record->operativo == 1 && $record->solicitud_bajada == 1 && $record->estado == 2): ?>
                              <?php if (in_array($record->tipo, $lt)): ?>
                                <?php if (($record->doc_fechavto != '0000-00-00' || $record->doc_fechavto != '' || $record->doc_fechavto != NULL) && ($fecha_vto > $fecha_hoy) && $record->estado == 2): ?>
                                  <i class="fa fa-check-square fa-lg" style="color:#009900; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="Continuar bajada: SI"></i>
                                <?php else: ?>
                                  <i class="fa fa-window-close fa-lg" style="color:#d9534f; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="Continuar bajada: NO"></i>
                                <?php endif; ?>
                              <?php else: ?>
                                <i class="fa fa-check-square fa-lg" style="color:#009900; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="Continuar bajada: SI"></i>
                              <?php endif; ?>
                            <?php else: ?>
                                <i class="fa fa-window-close fa-lg" style="color:#d9534f; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="Continuar bajada: NO"></i>
                            <?php endif; ?>
                          <?php else: ?>
                            <i class="fa fa-square-o fa-lg" style="color:#041725; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="No es un tipo de equipo para bajar memoria."></i>
                          <?php endif; ?>
                        </span>

                        <!-- Equipo, proyecto y direccion -->
                        <span data-toggle="tooltip" data-placement="top" title="<?=($record->ubicacion_calle == NULL || $record->ubicacion_calle == "") ? "A designar" : $record->ubicacion_calle." ".$record->ubicacion_altura?>" class="label label-<?=$etiqueta ?>"><?=$record->serie?></span>
                        <?php if ($record->comunicador): ?>
                          <span class="letterC"><b>&nbsp;C&nbsp;</b></span>
                        <?php endif; ?>
                        <?php if ($record->iluminador): ?>
                          <span class="letterI"><b>&nbsp;I&nbsp;</b></span>
                        <?php endif; ?>
                        <br/>
                        <?php if ($record->lugarID == 6 OR $record->lugarID == 7): ?>
                            <span class="text-muted"><small><?= ($record->descrip == "") ? "<spam class=\"text-danger\">---------</spam>" : $record->descrip ?></small></span></td>
                        <?php else: ?>
                            <span class="text-muted"><small><?= ($record->descrip == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descrip ?></small></span></td>
                        <?php endif; ?>
                      </td>

                      <!-- Lugar -->
                      <td><?=$record->descripEstado ?></td>

                      <!-- Evento -->
                      <td><?= ($record->descripEvento == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descripEvento ?></td>

                      <!-- Fecha vencimiento -->
                      <td><small>
                      <?php $lt = array(1,2,400,2402,2407,2412);
                      if (in_array($record->tipo, $lt) and $record->doc_fechavto != '0000-00-00'): ?>
                        <?=date('d/m/Y',strtotime($record->doc_fechavto));?><br>
                        <?php
                        $fecha_vto2 = new DateTime($record->doc_fechavto);
                        $fecha_vto2->add(new DateInterval('P1D'));
                        $fecha_hoy = new DateTime(date());
                        $interval2 = $fecha_vto2->diff($fecha_hoy);
                        $dias =  $interval2->format('%a%');

                        ($dias >= 2)?$palabra = "días": $palabra = "día";

                        if ($dias >= 60) {
                          $color = "info";
                        } elseif($dias >= 30) {
                          $color = "warning";
                        } else {
                          $color = "danger";
                        }
                        if ($fecha_vto2 > $fecha_hoy) {
                          echo "<span class='text-$color'>$dias $palabra se vence.</span>";
                        } else {
                          echo "<span class='text-danger'>$dias $palabra vencido.</span>";
                        }
                        ?>
                      <?php elseif (in_array($record->tipo, $lt) and $record->doc_fechavto == '0000-00-00'): ?>
                        <spam class="text-danger">Falta cargar la fecha.</spam>
                      <?php else: ?>
                        <spam class="text-success">No requiere.</spam>
                      <?php endif; ?>
                      </small></td> <!-- //Fecha de calibración -->

                      <td><small>
                          <?php if ($record->gestor_name != ''): ?>
                            <?php echo "<a href=".base_url("verPersonal/{$usuario->userId}").">" . $record->gestor_name . "</a>"; ?>
                          <?php else: ?>
                            <spam class="text-danger">A designar</spam>
                          <?php endif; ?>





                        </small></td><!-- //Gestor -->

                      <td><!-- //Modelo -->
                        <small><?=($record->modelo == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->modelo ?></small><br>
                        <small><?=($record->marca == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->marca ?></small>
                      </td>

                      <td><!-- //Asociado -->
                        <small><?= ($record->descripAsociado == "") ? "-" : $record->descripAsociado ?></small>
                      </td>

                      <td><!-- //Propietario -->
                        <small><?= ($record->descripProp == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descripProp ?></small>
                      </td>

                      <td>
                      	  <form id ="myform<?=$record->id?>" method="post" action="<?=base_url('asigComponente/')?>">
                              <input type="hidden" name="idmodelo" value="<?=$record->idmodelo2?>">
                              <input type="hidden" name="idequipo" value="<?=$record->id?>">
                          </form>

                          <?php if (((!in_array($roleUser, $isCalibracion)) && ($EQequipos[1] == 1)) || ((in_array($roleUser, $isCalibracion) && ($record->requiere_calib == 1) && ($EQequipos[1] == 1)))): ?>
                              <a id="botonImprimir" data-toggle="modal" data-tooltip="tooltip" title="Nuevo evento" data-target="#modalEventos<?php echo $record->id;$record->serie;$record->requiere_calib?>" >
                              <i class="fa fa-plus-square-o"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <!-- sample modal content -->
                                  <div id="modalEventos<?php echo $record->id;$record->serie;$record->requiere_calib?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">
                                                    Nuevo evento para <?php echo $record->serie ?></h4>
                                              </div>
                                              <form  method="post" action="<?php echo base_url(); ?>editEvento" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="equipoid" name="equipoid" value="<?php echo $record->id ?>">
                                                      <input type="hidden" class="form-control" id="serie" name="serie" value="<?php echo $record->serie ?>" >
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cambiar el lugar y el evento puede afectar las funcionalidades de otros sectores.</p>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="estado">Lugar</label>
                                                                <select class="form-control required" id="estado" name="estado" required data-error="Seleccionar al menos una opción.">
                                                                    <option value="">Seleccionar Lugar</option>
                                                                    <?php
                                                                    if((!empty($estados)) AND (!in_array($roleUser, $isCalibracion))):
                                                                        foreach ($estados as $estado):
                                                                            ?>
                                                                            <option value="<?php echo $estado->id ?>"
                                                                             <?=($estado->id == 4 && !$record->requiere_calib)?'disabled':''?>>
                                                                            <?php echo $estado->descrip ?>
                                                                            </option>
                                                                    <?php
                                                                        endforeach;
                                                                    elseif (in_array($roleUser, $isCalibracion)): ?>
                                                                        <option value="4">INTI</option>

                                                                    <?php endif;?>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="evento">Evento</label>
                                                                <select class="form-control required" id="evento" name="evento" required data-error="Seleccionar al menos una opción.">
                                                                    <option value="">Seleccionar Evento</option>
                                                                    <?php
                                                                    if((!empty($eventos)) AND (!in_array($roleUser, $isCalibracion))):
                                                                        foreach ($eventos as $evento): ?>
                                                                            <option value="<?=$evento->id?>"  <?=($evento->id == 30 && !$record->requiere_calib)?'disabled { color: red }':''?>>
                                                                            <?=$evento->descrip?>
                                                                            </option>
                                                                        <?php
                                                                        endforeach;
                                                                    elseif (in_array($roleUser, $isCalibracion)): ?>
                                                                        <option value="30">Calibración</option>
                                                                    <?php endif; ?>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                      <div class="form-group">
                                                        <label for="subida_observ">Observaciones</label>
                                                        <textarea name="observ" id="observ" class="form-control" rows="3" cols="20"  style="resize: none"></textarea>
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
                          <?php endif; ?>

                          <?php if (((!in_array($roleUser, $isCalibracion)) && ($EQequipos[2] == 1)) || ((in_array($roleUser, $isCalibracion) && ($record->requiere_calib == 1) && ($EQequipos[2] == 1)))): ?>
                              <a id="botonImprimir" data-toggle="tooltip" title="Editar" href="<?= base_url().'editar_equipo/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                          <?php if ($EQequipos[3] == 1): ?>
                              <a id="botonImprimir" data-toggle="tooltip" title="Ver historial" href="<?php echo base_url().'historial/historialEqListing/'.$record->id; ?>"><i class="fa fa-history"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                          <?php if ($EQequipos[4] == 1): ?>
                              <a id="botonImprimir" href="#" data-toggle="tooltip" title="Asignar componentes" onclick="document.getElementById('myform<?=$record->id?>').submit()">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                          <?php if ($EQequipos[5] == 1): ?>
                              <a id="botonImprimir" data-toggle="modal" data-tooltip="tooltip" title="<?=($record->activo == 1) ? 'Desactivar': 'Activar';?>" data-target="#modalDeshabilitar<?= $record->id;$record->serie;$record->activo ?>" >
                              <i class="fa fa-power-off" <?=($record->activo == 1) ? 'style="color:#d9534f"': '';?>></i> &nbsp;&nbsp;&nbsp;</a>
                                  <div id="modalDeshabilitar<?= $record->id;$record->serie;$record->activo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">
                                                    <?=($record->activo == 1) ? "Desactivar": "Activar";?> el equipo <?= $record->serie ?></h4>
                                              </div>
                                              <form  method="post" action="<?= base_url('desactivar_equipo'); ?>" data-toggle="validator">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="equipoid" name="equipoid" value="<?= $record->id ?>" >
                                                      <input type="hidden" class="form-control" id="activo" name="activo" value="<?= $record->activo ?>" >

                                                      <p>¿Desea <?=($record->activo == 1) ? "desactivar": "activar";?> el equipo?</p>
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al <?=($record->activo == 1) ? "desactivarlo no": "activarlo";?> podrá realizar algunas funciones para otros sectores.</p>
                                                      <div class="form-group">
                                                        <label for="subida_observ">Observaciones</label>
                                                        <textarea name="observ" id="observ" class="form-control" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
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
                                      </div>
                                  </div><!-- /.modal -->
                          <?php endif; ?>

                          <?php if ($EQequipos[6] == 1): ?>
                              <a id="botonImprimir" data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verEquipo/'.$record->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                          <?php if ($EQequipos[7] == 1 && $record->bajada == 1): ?>
                            <a id="botonImprimir" data-toggle="modal" data-tooltip="tooltip" title="<?=($record->solicitud_bajada == 1) ? 'Desactivar Solicitud de Bajada': 'Activar Solicitud de Bajada';?>" data-target="#modalSolicitud<?=$record->id?>">
                            <i class="fa fa-<?=($record->solicitud_bajada == 1) ? 'stop-circle text-danger': 'play-circle text-success';?>             "></i>&nbsp;&nbsp;&nbsp;</a>

                            <div id="modalSolicitud<?=$record->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="myModalLabel">
                                              <?=($record->solicitud_bajada == 1) ? 'Desactivar Solicitud de Bajada': 'Activar Solicitud de Bajada';?> -  <?= $record->serie ?></h4>
                                        </div>
                                        <form  method="post" action="<?= base_url('solicitud_bajada'); ?>" data-toggle="validator">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="equipoid" name="equipoid" value="<?= $record->id ?>">
                                                <input type="hidden" class="form-control" id="estado_solicitud" name="estado_solicitud" value="<?= $record->solicitud_bajada ?>">
                                                <?php if ($record->solicitud_bajada == 1): ?>
                                                  <p><i class="fa fa-exclamation-triangle" style="color:#dc4c3c;"></i> Al desactivar la Solicitud de Bajada no se podra realizar una Bajada de Memoria.</p>
                                                  <p>Ningun proceso del SC activara esta Solicitud, queda bajo tu responsabilidad vovler activarlo.</p>
                                                <?php else: ?>
                                                  <p>Equipo con Solicitud de Bajada en estado Desactivado.</p>
                                                  <p>Al activarlo volverá a estar en el estado de poder realizarse una Bajada de Memoria. Queda bajo su responsabilidad la activación del mismo.</p>
                                                <?php endif; ?>

                                                <div class="form-group">
                                                  <label for="solicitud_observ">Observaciones</label>
                                                  <textarea name="solicitud_observ" id="solicitud_observ" data-error="Completar este campo." required class="form-control" rows="3" cols="20"  style="resize: none"></textarea>
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
                          <?php endif; ?>

                          <br>

                          <?php if (in_array($roleUser, $isCalibracion) || in_array($roleUser, $isAdmin)): ?>
                            <a data-toggle="tooltip" title="Adjuntar archivo" href="<?=base_url("equipos_archivos/{$record->id}")?>"><i class="fa fa-file"></i></a>
                          <?php endif; ?>

                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </table>

                </div><!-- /.box-body -->
                <div id="botonImprimir" class="box-footer clearfix">
                    <?= $this->pagination->create_links(); ?>
                </div>
                <?php endif; ?>

              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "equiposListing/" + value);
            jQuery("#searchList").submit();
        });
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function(){
        $('[data-tooltip="tooltip"]').tooltip();
    });
</script>
