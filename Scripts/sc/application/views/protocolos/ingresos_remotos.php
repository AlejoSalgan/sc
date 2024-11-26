<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$INGremotos = explode(',', $ingreso_remotos);
$INGpendientes = explode(',', $ingreso_pendientes);

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
  		Protocolos - Protocolos Remotos
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
  		  <span class="text-muted">Protocolos Remotos</span>
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
                        <form action="<?= base_url('protocolos_remotos') ?>" method="post" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 135px; height: 30px;">
                                  <?php foreach ($opciones as $key => $opcion): ?>
                                    <option value="<?=$key?>" <?php if($criterio === $key) {echo "selected=selected";} ?>><?=$opcion?></option>
                                  <?php endforeach; ?>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-primary searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr class="info">
                      <?php foreach ($opciones as $key => $opcion): ?>
                        <?php if ($key !== 0 && $key !== 'MUN.descrip'): ?>
                          <th class="text-center"><?=$opcion?></th>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <th class="text-center">Acciones</th>
                    </tr>
                    </thead>

                    <?php foreach ($protocolos as $protocolo): ?>
                      <tr>
                      <!-- Protocolo -->
                      <td class="text-center"><span class="label label-primary etiqueta14 text-center"><?=$protocolo->id ?></span></td>

                      <!-- Equipo y Proyecto -->
                      <td><?= "<a href=".base_url("verEquipo/{$protocolo->idequipo}").">" . $protocolo->equipo_serie . "</a>";?><br/><small class="text-muted"><?=$protocolo->descripProyecto ?></small></td>

                      <!-- Fecha del Protocolo -->
                      <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($protocolo->fecha_protocolo));?>
                      </td>

                      <!-- Fecha desde -->
                      <td class="text-center"><?= date('d/m/Y - H:i:s',strtotime($protocolo->fecha_inicial_remoto));?>
                      </td>

                      <!-- Fecha hasta -->
                      <td class="text-center"><?= $protocolo->fecha_final_remoto;?></td>

                      <!-- Cantidad Archivos -->
                      <td class="text-center"><span class="label label-primary etiqueta13"><?=$protocolo->cantidad ?>
                      </td>

                      <td>
                            <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Ver Detalle" href="<?=base_url("verProtocolos/{$protocolo->id_orden}?searchText={$searchText}&criterio={$criterio}")?>">&nbsp;<i class="fa fa-info"></i>&nbsp;</a>


                            <?php if($INGpendientes[2] == 1 ) { ?>
                              <a class="btn btn-danger btn-xs" data-toggle="modal" data-tooltip="tooltip" title="Anular Protocolo" data-target="#modalDeshabilitar<?php echo $protocolo->id ?>"><i class="fa fa-times"></i></a>
                                    <!-- sample modal content -->
                                    <div id="modalDeshabilitar<?php echo $protocolo->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Anular el Protocolo Nº <?php echo $protocolo->id ?></h4>
                                                </div>
                                                <form  method="post" action="<?=base_url('anular_remoto')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="protocolo" name="protocolo" value="<?php echo $protocolo->id ?>" >

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
        jQuery("#searchList").attr("action", baseURL + "protocolos_remotos/" + value);
        jQuery("#searchList").submit();
    });
});
</script>
