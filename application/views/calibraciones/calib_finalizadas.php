<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$CALIBfinalizadas = explode(',', $calibracion_finalizadas); //Los permisos para cada boton de Acciones.

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
                      <form action="<?= base_url('calibraciones_finalizadas') ?>" method="POST" id="searchList">
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
                        <th class="text-center">Fecha Informe</th>
                        <th class="text-center">Fecha Certificado</th>
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
                          <td class="text-center"><?= ($orden->fecha_informe == NULL) ? 'No aplicable' : date('d/m/Y',strtotime($orden->fecha_informe));?></td>
                          <td class="text-center"><?= ($orden->fecha_certificado == NULL) ? 'A designar' : date('d/m/Y',strtotime($orden->fecha_certificado));?></td>
                          <td class="text-center"><span class="label label-default" style="background-color:<?=$orden->color_tipo?>; color: white"><?= $orden->estado_descrip;?></span></td>
                          <td>
                            <?php if (($CALIBfinalizadas[0] == 1) && ($orden->tipo_orden == 70 || $orden->tipo_orden == 71)): ?>
                              <a data-toggle="tooltip" title="Ver Detalle" href="<?= base_url().'verCalib/'.$orden->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>
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
            jQuery("#searchList").attr("action", baseURL + "calibraciones_finalizadas/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
