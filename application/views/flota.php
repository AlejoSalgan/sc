<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

$FLflota = explode(',', $flota_flota); //Los permisos para cada boton de Acciones.

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Flota</h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active">Flota</li>
              </ol>
          </div>
      </div>
    </section>  

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if ($FLflota[0] == 1) { ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewFlotaVeh">Agregar vehículo</a> 
                    <?php }?>                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Flota listado</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>flotaListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Dominio o Destino"/>
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
                      <th>#</th>
                      <th>Dominio</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Destino</th>
                      <th>Asignado</th>
                      <th>Propietario</th>
                      <th>Proyecto</th>
                      <th>Equipo</th>                      
                      <th>Acciones</th>
                    </tr>
                    <?php
                    if(!empty($flotaRecords))
                    {
                        foreach($flotaRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                    ?>
                    <tr>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->movilnro ?></p>
                      </td>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->dominio ?></p>
                      </td>
                      <td><?=$record->marca ?></td>
                      <td><small><?=$record->modelo ?></small></td>
                      <td><?php echo ($record->descripDestino == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descripDestino ?></td>
                      <td><?php echo ($record->chofer1 == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->chofer1 ?></td>
                      <td><?php echo ($record->descrip_propietario == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descrip_propietario ?></td>
                      <td><?php echo ($record->descripProyecto == "") ? "<spam class=\"text-info\">A designar</spam>" : $record->descripProyecto ?></td>
                      <td><?php echo ($record->serie  == "") ? "<spam class=\"text-info\">Sin Equipo</spam>" : $record->serie ?></td>          
                      <td>
                          <?php if ($FLflota[1] == 1) { ?>
                              <a href="<?php echo base_url().'editOldFlota/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php }?>  
                              
                          <?php if ($FLflota[2] == 1) { ?>
                              <a href="#" data-flotaid="<?php echo $record->id; ?>" class="deleteFlota"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
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
            jQuery("#searchList").attr("action", baseURL + "flotaListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
