<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$CALIBordenesp = explode(',', $calibracion_ordenesP); //Los permisos para cada boton de Acciones.

if(empty($criterio)){
    $criterio = 0;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
		<?=$titulo?> de Calibracion
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
                      <form action="<?= base_url('calibraciones_pendientes') ?>" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
                            <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                              <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                              <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nº Orden</option>
                              <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Proyecto</option>
                              <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Equipo</option>
                              <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Tipo de equipo</option>
                              <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Tipo de servicio</option>
                              <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Prioridad</option>
                              <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Estado</option>
                              <option value="9" <?php if($criterio == 9) {echo "selected=selected";} ?>>Nº Carriles</option>
                              <option value="10" <?php if($criterio == 10) {echo "selected=selected";} ?>>Fecha Visita</option>
                              <option value="11" <?php if($criterio == 11) {echo "selected=selected";} ?>>Técnico</option>
                              <option value="12" <?php if($criterio == 12) {echo "selected=selected";} ?>>Dominio</option>
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
                        <th class="text-center">Nº orden</th>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Tipo de Servicio</th>
                        <th class="text-center">Técnico</th>
                        <th class="text-center">Fecha Visita</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                      </tr>

                      <?php foreach ($ordenes as $orden): ?>
                        <tr>
                          <td class="text-center"><p class="label label-primary" style="color:white; font-size:14px;"><?=$orden->id?></p></td>
                          <td><?= "<a href=".base_url("verEquipo/{$orden->idequipo}").">" . $orden->equipoSerie . "</a>"; ?>
                            <br/><span class="text-muted"><small><?=$orden->descripProyecto?></small></span>
                          </td>
                          <td><?= $orden->tipoEquipo; ?>
                            <br/><span class="text-muted"><small>
                            <?php switch ($orden->multicarril) {
                                case 0:
                                  echo 'No necesita carriles';
                                  break;
                                case 1:
                                  echo $orden->multicarril. ' Carril';
                                  break;
                                case 2:
                                case 3:
                                case 4:
                                case 5:
                                  echo $orden->multicarril. ' Carriles';
                                  break;

                                default:
                                  echo 'A designar';
                                  break;
                              }
                            ?></small></span>
                          </td>
                          <td class="text-center" style="color:<?=$orden->color_servicio?>"><?= $orden->tipo_ver; ?></td>
                          <td class="text-center"><?= ($orden->nameTecnico == NULL) ? 'A designar' : $orden->nameTecnico; ?></td>
                          <td class="text-center"><?= ($orden->fecha_visita == NULL) ? 'A designar' : date('d/m/Y',strtotime($orden->fecha_visita));?></td>
                          <td class="text-center"><span class="label label-default" style="background-color:<?=$orden->color_tipo?>; color: white"><?= $orden->estado_descrip;?></span></td>
                          <td>
                            <?php if (($CALIBordenesp[0] == 1) && ($orden->tipo_orden == 80 || $orden->tipo_orden == 81)): ?>
                              <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verCalib/'.$orden->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <?php if (($CALIBordenesp[1] == 1) && ($orden->tipo_orden == 80 || $orden->tipo_orden == 81)): ?>
                              <a data-toggle="tooltip" title="Editar" href="<?= base_url().'editOldCalib/'.$orden->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>

                            <a data-toggle="tooltip" title="Adjuntar archivo" href="<?= base_url().'calibraciones_adjuntar/'.$orden->id; ?>"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;</a>

                            <?php if (($CALIBordenesp[2] == 1) && ($orden->tipo_orden == 80 || $orden->tipo_orden == 81)): ?>
                              <a data-toggle="modal" title="Cancelar" data-target="#modalCancelar<?= $orden->id ?>" ><i class="fa fa-trash" style="color:#dc4c3c;"></i>&nbsp;&nbsp;&nbsp;</a>
                                  <!-- sample modal content -->
                                  <div id="modalCancelar<?= $orden->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                  <h4 class="modal-title" id="myModalLabel">Cancelar la orden Nº <?= $orden->id ?></h4>
                                              </div>
                                              <form  method="post" action="<?=base_url('deleteCalib')?>" data-toggle="validator" id="validar_caracateres">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <input type="hidden" class="form-control" id="id_orden" name="id_orden" value="<?= $orden->id ?>" >

                                                      <p>¿Desea anular la Orden?</p>
                                                      <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al cancelarla no se podrá trabajar sobre la misma.</p>
                                                      <div class="form-group">
                                                        <label for="label_observacion">Observaciones</label>
                                                        <textarea name="observacion" id="observacion" class="form-control caractares" data-error="Completar este campo." required rows="3" cols="20"  style="resize: none"></textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-info enableOnInput">Aceptar</button>
                                              </div>
                                          </form>
                                          </div>
                                          <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                            <?php endif; ?>

                            <?php if (($CALIBordenesp[3] == 1) && ($orden->tipo_orden == 80 || $orden->tipo_orden == 81)): ?>
                              <a data-toggle="tooltip" title="Finalizar Orden" href="<?= base_url().'finalizar/'.$orden->id; ?>"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;</a>
                            <?php endif; ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/calib.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "calibraciones_pendientes/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>

<script>
$("#validar_caracateres").submit(function () {
    if($(".caractares").val().length < 50) {
        var falta = 50 -$(".caractares").val().length;
        alert("La observacion tiene que tener como minimo 50 caractares.\nTe falta "+ falta + " caracteres");
        return false;
    } else {
      return true;
    }
});
</script>
