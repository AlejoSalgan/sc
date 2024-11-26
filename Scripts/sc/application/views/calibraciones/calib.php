<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

switch ($filtro):  // Dependiendo del tipo se cargaran los permisos de las acciones.
    case 0:
        $CALIBsolicitudes = explode(',', $calibracion_solicitudes); //Los permisos para cada boton de Acciones.
    break;

    case 1:
        $CALIBordenes = explode(',', $calibracion_ordenes);
    break;

    case 2:
        $CALIBordenesp = explode(',', $calibracion_ordenesP);
endswitch;

$tipo = $this->uri->segment(3);//segundo param

if(empty($criterio)){
    $criterio = 0;
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php switch ($filtro): //0. Solicitud 1.Ordenes 2.Pendientes 3.Finalizadas
                        case 0:?>
                            <h4 class="page-title">Solicitud de Calibración</h4>
                  <?php break;
                        case 1:?>
                            <h4 class="page-title">Ordenes de Calibración</h4>
                  <?php break;
                        case 2:?>
                            <h4 class="page-title">Ordenes de Calibración - Pendientes</h4>
                  <?php break;
                        case 3:?>
                            <h4 class="page-title">Ordenes de Calibración - Finalizadas</h4>
                  <?php break;
                        endswitch;?>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <?php switch ($filtro): //0. Solicitud 1.Ordenes 2.Pendientes 3.Finalizadas
                        case 0:?>
                            <li class="active">Solicitud de Calibración</li>
                  <?php break;
                        case 1:?>
                            <li class="page-title">Ordenes de Calibración</li>
                  <?php break;
                        case 2:?>
                            <li class="page-title">Ordenes de Calibración - Pendientes</li>
                  <?php break;
                        case 3:?>
                            <li class="page-title">Ordenes de Calibración - Finalizadas</li>
                  <?php break;
                        endswitch;?>
              </ol>
          </div>
      </div>
     </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if ($CALIBsolicitudes[0] == 1): ?>
                        <a class="btn btn-primary" href="<?= base_url(); ?>agregar_SG">Agregar Solicitud de Calibración</a>
                    <?php else: ?>
                        <a class="btn btn-primary" disabled href="<?= base_url(); ?>agregar_SG">Agregar Solicitud de Calibración</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <?php switch ($filtro):
                      case 0:?>
                        <h3 class="box-title">Solicitud de Calibración listado</h3>
                    <?php break;
                      default:?>
                        <h3 class="box-title">Ordenes de Calibración listado</h3>
                    <?php break;
                      endswitch;?>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>calibListing/0/<?php echo $tipo;//segundo param ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 140px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Proyecto</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Equipo</option>
                                  <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Tipo de equipo</option>
                                  <?php if ($tipo == 0): ?>
                                      <option value="9" <?php if($criterio == 9) {echo "selected=selected";} ?>>Nº Carriles</option>
                                  <?php endif; ?>
                                  <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Tipo de servicio</option>
                                  <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Prioridad</option>
                                  <?php if ($tipo == 1 or $tipo == 2): ?>
                                      <option value="10" <?php if($criterio == 10) {echo "selected=selected";} ?>>Fecha Visita</option>
                                      <option value="11" <?php if($criterio == 11) {echo "selected=selected";} ?>>Técnico</option>
                                      <option value="12" <?php if($criterio == 12) {echo "selected=selected";} ?>>Dominio</option>
                                  <?php else: ?>
                                      <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Fecha Alta</option>
                                  <?php endif; ?>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Estado</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>#</th>
                      <th>Equipo</th>
                      <th>Tipo de Equipo</th>
                      <?php if ($tipo == 0): //0. Solicitudes?>
                          <th>Nº Carriles</th>
                      <?php endif; ?>
                      <th>Tipo de Servicio</th>
                      <th>Prioridad</th>
                      <?php if ($tipo == 1 or $tipo == 2): //1 o 2 - Ordenes?>
                          <th>Fecha Visita</th>
                          <th>Técnico</th>
                          <th>Dominio</th>
                      <?php else: ?>
                          <th>Fecha Alta</th>
                      <?php endif; ?>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                    <?php foreach ($calibRecords as $record): ?>

                        <tr>
                      <td><p class="text-muted ?>"><?=$record->id ?></p></td>
                      <td>
                        <span class="label label-primary ?>"><?=$record->equipoSerie ?></span>
                        <br/>
                        <span class="text-muted"><small><?=$record->descripProyecto ?></small></span>
                      </td>
                      <td><small><?= $record->tipoEquipo; ?></small></td>

                      <?php if ($tipo == 0): //1. Solicitudes?>
                          <td class="text-center"><?= $record->multicarril; ?></td>
                      <?php endif; ?>

                      <td><?= ($record->tipo_ver == '')?"<spam class=\"text-info\">A designar</spam>": $record->tipo_ver?></td>
                      <td><?= ($record->descripPrioridad == '')?"<spam class=\"text-info\">A designar</spam>": $record->descripPrioridad?></td>

                      <?php if ($tipo == 1 or $tipo == 2): //1 o 2 - Ordenes Calibraciones ?>
                          <td>
                            <p class="text-muted">
                            <?php $fecha_visita = $this->fechas->cambiaf_a_arg($record->fecha_visita);
                            echo($fecha_visita == NULL)?"<small><spam class=\"text-info\">A designar</spam></small>": $fecha_visita?>
                            </p>
                          </td>
                          <?php if ($record->tipoEquipo == "Cinemómetro Movil"): ?>
                              <td><?= "No asignado"?></td>
                              <td><?= "No asignado"?></td>
                          <?php else: ?>
                              <td><?= ($record->nameTecnico == '')?"<small><spam class=\"text-info\">A designar</spam></small>": $record->nameTecnico?></td>
                              <td><?= ($record->dominio == '')?"<small><spam class=\"text-info\">A designar</spam></small>": $record->dominio?></td>
                          <?php endif; ?>
                      <?php else: ?>
                          <td><?= $fecha_alta = $this->fechas->cambiaf_a_arg($record->fecha_alta); ?></td>
                      <?php endif; ?>

                      <td><?= $record->estado_descrip; ?></td>
                      <td>
                          <?php if ($CALIBsolicitudes[1] == 1 || $CALIBordenes[0] == 1 || $CALIBordenesp[0] == 1): ?>
                              <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verCalib/'.$record->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                          <?php switch ($filtro):
                                case 0: ?>
                              <?php if ($CALIBsolicitudes[2] == 1): ?>
                                  <?php if (($record->ord_tipo == 0 OR $record->ord_tipo == 10)): ?>
                                      <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editar_SG/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>

                              <?php if ($CALIBsolicitudes[3] == 1): ?>
                                  <?php if (($record->activo == 1 AND $record->ord_tipo == 0 OR $record->ord_tipo == 10)): ?>
                                      <a data-toggle="tooltip" title="Cancelar" href="#" data-calibid="<?= $record->id; ?>" class="deleteCalib"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>

                              <?php if ($CALIBsolicitudes[4] == 1): ?>
                                  <?php if (($record->activo == 1 AND $record->tipo_ver != '' AND $record->descripPrioridad != '' AND ($record->ord_tipo == 0 OR $record->ord_tipo == 10))): ?>
                                      <a data-toggle="tooltip" title="Aprobar" href="#" data-calibid="<?= $record->id; ?>" data-tipoequipo="<?= $record->tipoEquipo; ?>" class="aprobarSoliG"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>

                              <?php if ($CALIBsolicitudes[5] == 1): ?>
                                  <?php if (($record->ord_tipo == 1)): ?>
                                      <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editOldAprob/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>

                              <?php if ($CALIBsolicitudes[5] == 1): ?>
                                  <?php if (($record->distancia_inti != 0 AND $record->horario_calib != 0 AND $record->ord_tipo == 1)): ?>
                                      <a data-toggle="tooltip" title="Aprobar" href="#" data-calibid="<?= $record->id; ?>" class="solicitarSG"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>
                          <?php break;

                          case 1: ?>
                              <?php if ($CALIBordenes[1] == 1): ?>
                                  <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editOldCalib/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php endif; ?>

                              <?php if ($CALIBordenes[2] == 1): ?>
                                  <?php if (($record->ord_tipo == 31 OR $record->ord_tipo == 32)): ?>
                                      <a data-toggle="tooltip" title="Orden pendiente" href="#" data-calibid="<?= $record->id; ?>" class="espera"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>

                              <?php if ($CALIBordenes[3] == 1): ?>
                                  <?php if (($record->ord_tipo == 22 OR $record->ord_tipo == 23)): ?>
                                      <a data-toggle="tooltip" title="Finalizar Orden" href="#" data-calibid="<?= $record->id; ?>" class="finalizar"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>
                          <?php break;

                          case 2: ?>
                              <?php if ($CALIBordenesp[1] == 1): ?>
                                  <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editOldCalib/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php endif; ?>

                              <?php if ($CALIBordenesp[2] == 1): ?>
                                  <?php if (($record->ord_tipo == 22 OR $record->ord_tipo == 23)): ?>
                                      <a data-toggle="tooltip" title="Finalizar Orden" href="#" data-calibid="<?= $record->id; ?>" class="finalizar"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <?php endif; ?>
                              <?php endif; ?>
                          <?php break;
                          endswitch;
                          ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/calib.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            value = (value=="") ? 0 : value;
            jQuery("#searchList").attr("action", baseURL + "calibListing/" + value + "/" + getParam(3));
            jQuery("#searchList").submit();
        });
    });
</script>
