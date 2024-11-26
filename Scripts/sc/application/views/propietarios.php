<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

$EQpropietarios = explode(',', $equipos_propietarios); //Los permisos para cada boton de Acciones.

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Propietarios</h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active">Propietarios</li>
              </ol>
          </div>
      </div>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if ($EQpropietarios[0] == 1) { ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewPropietario2">Agregar Propietario</a>
                    <?php } else { ?>
                        <a class="btn btn-primary" disabled href="<?php echo base_url(); ?>addNewPropietario2">Agregar Propietario</a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Propietarios listado</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>propietariosListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Nombre"/>
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
                      <th>Observaciones</th>
                      <?php if($EQpropietarios[1] == 1 || $EQpropietarios[2] == 1) { ?>
                          <th>Acciones</th>
                      <?php } ?>
                    </tr>
                    <?php
                    if(!empty($propietariosRecords))
                    {
                        foreach($propietariosRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                    ?>
                    <tr>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->descrip ?></p>
                      </td>
                      <td><?php echo($record->observaciones == '')?"<spam class=\"text-info\">Sin observaciones</spam></small>": $record->observaciones?></td>
                      <td>
                          <?php if ($EQpropietarios[1] == 1) { ?>
                              <a href="<?php echo base_url().'editOldPropietario/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php }?>

                          <?php if ($EQpropietarios[2] == 1) { ?>
                              <a href="#" data-propietarioid="<?php echo $record->id; ?>" class="deletePropietario"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php }?>
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
            jQuery("#searchList").attr("action", baseURL + "propietariosListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
