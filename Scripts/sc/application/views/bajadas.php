<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

switch ($tipoItem):  // Dependiendo del tipo se cargaran los permisos de las acciones.
    case "Ordenes":
        $BMordServ = explode(',', $bajada_ordServ);
        $titulo = "Ordenes de Servicio";
        $form_action = "<form action=\"" . base_url() . "ordenesbListing\" method=\"POST\" id=\"searchList\">";
    break;

    case "Recibir":
        $BMordSR = explode(',', $bajada_ordSR);
        $titulo = "Ordenes Sin Recibir";
        $form_action = "<form action=\"" .  base_url() . "ordenesbSRListing\" method=\"POST\" id=\"searchList\">";
    break;

    case "SP":
        $BMordSP = explode(',', $bajada_ordSP);
        $titulo = "Ordenes Sin Procesar";
        $form_action = "<form action=\"" . base_url() . "ordenesbSPListing\" method=\"POST\" id=\"searchList\">";
    break;

    case "Procesado":
        $BMordProc = explode(',', $bajada_ordProc);
        $titulo = "Ordenes Procesadas";
        $form_action = "<form action=\"" . base_url() . "ordenesbProcListing\" method=\"POST\" id=\"searchList\">";
    break;

    case "Anulado":
        $BMordAnul = explode(',', $bajada_ordAnul);
        $titulo = "Ordenes Anuladas";
        $form_action = "<form action=\"" . base_url() . "ordenesAnuladas\" method=\"POST\" id=\"searchList\">";
    break;

    case "Cero":
        $BMordCero = explode(',', $bajada_ordCero);
        $titulo = "Ordenes Protocolos 0";
        $form_action = "<form action=\"" . base_url() . "ordenesCero\" method=\"POST\" id=\"searchList\">";
    break;
endswitch;

if(empty($criterio)){
  $criterio = 0;
}

?>

<div class="content-wrapper">
    <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
      <?=$titulo?>
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted"><?=$titulo?></span>
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                  <?php if ($BMordServ[0] == 1): ?>
                    <a class="btn btn-primary" href="<?= base_url('agregar_orden'); ?>">Agregar Orden de Servicio</a>
                  <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h1 class="box-title">
                      <?php if ($total > 0): ?>
                        Total:<b><a href="javascript:void(0)"> <?= $total?></a></b>
                      <?php else: ?>
                        No hay datos para mostrar.
                      <?php endif; ?>
                    </h1>

                    <?php if ($total_tabla > 0): ?>
                      <div class="box-tools">
                          <?= $form_action; ?>
                              <div class="input-group">
                                <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                                <select class="form-control pull-right" id="criterio" name="criterio" style="width: 116px; height: 30px;">
                                    <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                    <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                    <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Proyecto</option>
                                    <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Equipo</option>
                                    <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Vehículo</option>
                                    <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Técnico</option>
                                    <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Fecha Visita</option>
                                </select>
                                <div class="input-group-btn">
                                  <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                </div>
                              </div>
                          </form>
                      </div>
                    <?php endif; ?>

                </div><!-- /.box-header -->

                <?php if ($total > 0): ?>
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                      <tr class="info">
                        <th class="text-center">Nº Orden</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Conductor</th>
                        <th class="text-center">Técnico</th>
                        <th class="text-center">Vehículo</th>
                        <th class="text-center">Fecha Visita</th>
                        <th class="text-center">Enviado</th>
                        <th class="text-center">Recibido</th>
                        <th class="text-center">Procesado</th>
                        <th>Acciones</th>
                      </tr>
                      <?php foreach ($ordenesbRecords as $record):
                          if ($record->activo == 1) {
                            if ($record->enviado == 0 || $record->ord_procesado == 1 || $record->ord_procesado == 2) {
                              $etiqueta = "primary";
                            } elseif ($record->enviado == 1 && $record->ord_procesado == 0 && ($record->recibido == 0 || $record->recibido == 1)) {
                              $etiqueta = "warning";
                            }
                          } else {
                            $etiqueta = "danger";
                          }
                      ?>
                        <tr>
                        <td class="text-center">
                          <p class="<?="label label-".$etiqueta?>" style="color:white; font-size:14px;"><?=$record->id ?></p>
                        </td>
                        <td><strong>
                          <?= "<a href=".base_url("verEquipo/{$record->idequipo}").">" . $record->equipoSerie . "</a>"; ?></strong>
                          <br/>
                          <span class="text-muted"><small><?=$record->descripProyecto ?></small></span>
                        </td>
                        <td>
                          <?="<a href=".base_url("verPersonal/{$record->conductor}").">" . $record->nameConductor . "</a>"; ?>
                        </td>
                        <td>
                          <?="<a href=".base_url("verPersonal/{$record->tecnico}").">" . $record->nameTecnico . "</a>"; ?>
                        </td>
                        <td class="text-center"><?= $record->dominio; ?></td>
                        <td class="text-center">
                          <p class="text-muted"><?=$this->fechas->cambiaf_a_arg($record->fecha_visita); ?></p>
                        </td>
                        <td class="text-center">
                          <?=($record->enviado == 0) ? "<i class='fa fa-close' style='color:red;'></i>": "<i class='fa fa-check'style='color:green;' ></i>";?>
                        </td>
                        <td class="text-center">
                          <?=($record->recibido == 0) ? "<i class='fa fa-close' style='color:red;'></i>": "<i class='fa fa-check'style='color:green;' ></i>";?>
                        </td>
                        <td class="text-center">
                          <?php
                              switch ($record->ord_procesado) {
                                case '0': ?>
                                  <i class='fa fa-close' style='color:red;'></i>
                                <?php  break;

                                case '1': ?>
                                  <i class='fa fa-check'style='color:green;' ></i>
                                <?php break;

                                case '2': ?>
                                  <a data-toggle="tooltip" title="Procesado fuera del Cerco"><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i></a>
                                <?php  break;
                              }
                          ?>
                        </td>

                        <td>
                            <?php if($BMordServ[1] == 1 || $BMordSR[0] == 1 || $BMordSP[0] == 1 || $BMordProc[0] == 1 || $BMordCero[0] == 1 || $BMordAnul[0] == 1) { ?>
                                <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verOrdenb/'.$record->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php } ?>

                            <?php if($BMordServ[2] == 1) { ?>
                                <?php if(($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) || ($record->activo == 0 && $record->enviado == 0 && $record->recibido == 0)) { ?>
                                    <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editar_orden/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                <?php } ?>
                            <?php } ?>

                            <?php if($BMordServ[3] == 1) { ?>
                                <?php if( ($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) ) { ?>
                                <a data-toggle="modal" title="Cancelar orden" data-target="#modalDeshabilitar<?= $record->id;$record->idequipo ?>" ><i class="fa fa-trash"></i> &nbsp;&nbsp;&nbsp;</a>
                                    <!-- sample modal content -->
                                    <div id="modalDeshabilitar<?= $record->id;$record->idequipo ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Anular la orden Nº <?= $record->id ?></h4>
                                                </div>
                                                <form  method="post" action="<?= base_url(); ?>anularOrden" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="idOrden" name="idOrden" value="<?= $record->id ?>" >
                                                        <input type="hidden" class="form-control" id="idEquipo" name="idEquipo" value="<?= $record->idequipo ?>" >

                                                        <p>¿Desea anular la Orden de bajada?</p>
                                                        <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al anular no se podrá deshacer este cambio</p>
                                                        <div class="form-group">
                                                          <label for="observ">Observaciones</label>
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
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                  <?php } ?>
                              <?php } ?>

                            <?php if($BMordServ[4] == 1) { ?>
                                <?php if(($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) ) { ?>
                                    <a data-toggle="tooltip" title="Enviar" href="#" data-ordenesbid="<?= $record->id; ?>" class="enviarOrdenesb"><i class="fa fa-share-square-o"></i>&nbsp;&nbsp;&nbsp;</a>
                                <?php } ?>
                            <?php } ?>

                            <?php if($BMordSR[1] == 1 || $BMordSP[1] == 1 || $BMordProc[1] == 1) { ?>
                                <?php if(($record->activo == 1 && $record->enviado == 1 && $record->recibido == 0) OR ($record->activo == 1 && $record->enviado == 1 && $record->recibido == 1 && $record->ord_procesado == 0) OR ($record->activo == 1 && $record->enviado == 1 && $record->recibido == 1 && $record->ord_procesado == 2 && ($role == ROLE_SUPERADMIN OR $role == ROLE_INGDATOS))) { ?>
                                    <a data-toggle="tooltip" title="Cancelar Envio" href="#" data-ordenesbid="<?= $record->id; ?>" class="cancelarEnvOrdenesb"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;</a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </table>

                  </div><!-- /.box-body -->
                  <?php if ($total > 15): ?>
                    <div class="box-footer clearfix">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<?php switch ($tipoItem) { // Dependiendo del tipo de sub-menu tendra efecto el paginado
  case 'Ordenes': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesbListing/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;

  case 'Recibir': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesbSRListing/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;

  case 'SP': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesbSPListing/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;

  case 'Procesado': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesbProcListing/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;

  case 'Anulado': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesAnuladas/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;

  case 'Cero': ?>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/ordenesb.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "ordenesCero/" + value);
                jQuery("#searchList").submit();
            });
        });
    </script>
  <?php  break;
}

?>
