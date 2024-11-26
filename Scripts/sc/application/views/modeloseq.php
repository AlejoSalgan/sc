<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';
$EQmodelos = explode(',', $equipos_modelos); //Los permisos para cada boton de Acciones.

if(empty($criterio)){
  $criterio = 0;
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Modelos</h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active">Modelos de equipos</li>
              </ol>
          </div>
      </div>
    </section>

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
                      <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                  </div>
              </div>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if ($EQmodelos[0] == 1) { ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewModeloequipo">Agregar Modelo</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Modelos de Equipos (Listado)</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>modeloseqListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 101px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>Nombre</option>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Sigla</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Asociado</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Nombre</th>
                      <th>Sigla</th>
                      <th>Asociado</th>
                      <th>Observaciones</th>
                      <?php if($EQmodelos[1] == 1 || $EQmodelos[2] == 1) { ?>
                          <th>Acciones</th>
                      <?php } ?>
                    </tr>
                    <?php
                    if(!empty($modeloseqRecords))
                    {
                        foreach($modeloseqRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                    ?>
                    <tr>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->descrip ?></p>
                      </td>
                      <td><?php echo($record->sigla == '')?"<spam class=\"text-info\">A designar</spam></small>": $record->sigla?></td>

                      <td><?php echo($record->asoc == '')?"<spam class=\"text-info\">A designar</spam></small>": $record->asoc?></td>

                      <?php if ($record->sistemas_aprob == 0) { ?>
                      <td> <p class="text-danger">EL MODELO NO HA SIDO ACTIVADO POR SISTEMAS</p> </td>
                      <?php } else { ?>
                      <td> <?php echo($record->observaciones == '')?"<spam class=\"text-info\">Sin observaciones</spam></small>":
                            $record->observaciones?> </td>
                      <?php } ?>
                      <td>
                          <?php if ($EQmodelos[1] == 1) { ?>
                              <a href="<?php echo base_url().'editOldModeloeq/'.$record->id; ?>" title="Editar" ><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php } ?>
                          <?php if ($EQmodelos[2] == 1) { ?>
                              <a href="#" title="Desactivar" data-modeloeqid="<?php echo $record->id; ?>" class="deleteModeloeq"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php } ?>
                          <?php if(in_array($userId, array(27,103,105,140,219)) && ($record->sistemas_aprob == 0)) { ?>
                                <a data-toggle="modal" data-tooltip="tooltip" title="Aprobar modelo" data-target="#modalAprobar<?php echo $record->id;$record->sistemas_aprob ?>" >
                                <i class="fa fa-check" style="color:#268C21"> </i> &nbsp;&nbsp;&nbsp;</a>
                                    <!-- sample modal content -->
                                    <div id="modalAprobar<?php echo $record->id;$record->sistemas_aprob ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel"> ¿Aprobar modelo? </h4>
                                                </div>
                                                <form  method="post" action="<?php echo base_url(); ?>aprobar_equipo" data-toggle="validator">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="equipoid" name="equipoid" value="<?php echo $record->id ?>" >
                                                        <input type="hidden" class="form-control" id="aprobado" name="aprobado" value="<?php echo $record->sistemas_aprob ?>" >
                                                        <p>¿Desea aprobar el modelo?</p>
                                                        <p><i class="fa fa-exclamation-triangle" style="color:#f39c12;"></i> Recuerde que al aprobar el modelo,
                                                         este se habilitará en la sección de equipos nuevos.</p>
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
                    <?php
                        }
                    }
                    ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "modeloseqListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
