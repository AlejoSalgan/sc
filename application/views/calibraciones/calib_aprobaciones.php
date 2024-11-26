<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$CALIBaprobacion = explode(',', $calibracion_aprobacion); //Los permisos para cada boton de Acciones.
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
    Aprobaciones de Equipos
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <span class="text-muted">Aprobaciones </span>
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
          <div class="col-md-3">
            <div class="tabbable" >
              <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
                <?php $cont = 0;?>
                <?php foreach ($tipos as $tipo): ?>
                  <li <?= ($cont == 0) ? 'class="active"' : "" ;?>><a href="#<?=$tipo->id?>" data-toggle="tab"><?=$tipo->descrip?></a></li>
                  <?php $cont = 1;?>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

            <div class="col-md-9">
              <div class="tab-content">
                <?php $cont1 = 0;?>
                <?php foreach ($tipos as $tipo): ?>
                <div class="tab-pane <?= ($cont1 == 0) ? 'active' : "" ;?>" id="<?=$tipo->id?>">
                  <?php $cont1 = 1;?>
                  <div class="box box-primary">
                    <div class="box-header">
                      <h3 class="box-title"><?=$tipo->descrip?></h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover">
                            <?php if (empty($pedidos[$tipo->id])): ?>
                              <tr>
                                  <th>No hay equipos para aprobar.</th>
                              </tr>
                            <?php else: ?>
                              <tr class="info">
                                  <th class="text-center">Cantidad</th>
                                  <?php if ($tipo->id != 1 && $tipo->id != 2402): ?>
                                    <th class="text-center">Nº Carriles</th>
                                  <?php endif; ?>
                                  <th class="text-center">Tipo de Servicio</th>

                                  <?php if ($tipo->id != 1): ?>
                                    <th class="text-center">Horario</th>
                                    <th class="text-center">Distancia INTI</th>
                                  <?php endif; ?>

                                  <th class="text-center">Nº Orden Compra</th>
                                  <th class="text-center">Fecha Solicitud OT</th>
                                  <th class="text-center">Acciones</th>
                              </tr>
                              <?php foreach ($pedidos[$tipo->id] as $record): ?>
                                <tr>
                                  <td class="text-center"><b>
                                    <?php switch ($restantes[$record->id]) {
                                      case 10:
                                        $text = "text-success";
                                        break;
                                      case 5:
                                        $text = "text-warning";
                                        break;
                                      case 0:
                                      case 1:
                                      case 2:
                                      case 3:
                                        $text = "text-danger";
                                        break;
                                      default:
                                        $text = "";
                                        break;
                                    } ?>
                                    <span class="<?=$text?>"><?=$restantes[$record->id]?></span>/<span class="text-info"><?=$record->cantidad?></span>
                                    </b></td>
                                  <?php if ($tipo->id != 1 && $tipo->id != 2402): ?>
                                    <td class="text-center"><?= $record->carriles;?></td>
                                  <?php endif; ?>
                                  <td class="text-center" style="color:<?=$record->color_servicio?>"><?= $record->tipo_servicio; ?></td>
                                  <?php if ($tipo->id != 1): ?>
                                    <td class="text-center">
                                      <?php switch ($record->horario):
                                        case 'D':?>
                                          <p>Diurno</p>
                                      <?php break;
                                        case 'N':?>
                                          <p>Nocturno</p>
                                      <?php break;
                                        endswitch;?>
                                    </td>
                                    <td class="text-center"><?= $record->distancia;?></td>
                                  <?php endif; ?>
                                  <td class="text-center"><?= ($record->num_compra == NULL) ? 'A designar' : $record->num_compra;?></td>
                                  <td class="text-center"><?= ($record->fecha_ot == NULL) ? 'A designar' : date('d/m/Y',strtotime($record->fecha_ot));?></td>
                                  <td>
                                    <?php if ($CALIBaprobacion[0] == 1): ?>
                                      <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'ver_pedido/'.$record->id ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                                    <?php endif; ?>
                                    <?php if (($CALIBaprobacion[1] == 1) && ($record->estado == 0)): ?>
                                      <a data-toggle="tooltip" title="Agregar datos compra" href="<?php echo base_url().'pedido_compra/'.$record->id ?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;</a>
                                    <?php endif; ?>
                                    <?php if (($CALIBaprobacion[2] == 1) && ($record->num_compra != NULL && $record->fecha_ot != NULL && $record->estado == 0)): ?>
                                      <a data-toggle="tooltip" title="Aprobar compra" href="<?= base_url().'aprobacion_compra/'.$record->id ?>"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                        </table>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
    </section>
</div>
