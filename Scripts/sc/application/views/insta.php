<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Ordenes de Instalación</h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active">Ordenes de Instalación</li>
              </ol>
          </div>
      </div>
     </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary enviarTodo" href="#">Enviar Todo</a>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewInstalacion">Agregar Orden Instalación</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Ordenes Instalación listado</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>instaListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Nro. de Orden"/>
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
                      <th>Proyecto</th>
                      <th>Equipo</th>
                      <th>Vehículo</th>
                      <th>Técnico</th>
                      <th>Fecha Visita</th>
                      <th class="text-center">Enviado</th>
                      <th class="text-center">Recibido</th>
                      <th class="text-center">Procesado</th>
                      <th>Acciones</th>
                    </tr>
                    <?php
                    if(!empty($instaRecords))
                    {
                        foreach($instaRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "muted" : "danger";
                    ?>
                    <tr>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->id ?></p>
                      </td>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->descripProyecto ?></p>
                      </td>
                      <td><?php echo $record->equipoSerie; ?></td>
                      <td><?php echo $record->dominio; ?></td>
                      <td><?php echo $record->nameTecnico; ?></td>
                      <td>
                        <p class="text-<?=$etiqueta ?>"><?=$record->fecha_visita ?></p>
                      </td>
                      <td class="text-center">
                        <?php echo($record->enviado == 0) ? "<p class=\"text-danger\">NO</p>": "SI";?>
                      </td>
                      <td class="text-center">
                        <?php echo($record->recibido == 0) ? "<p class=\"text-danger\">NO</p>": "SI";?>
                      </td>
                      <td class="text-center">
                        <?php echo($record->ord_procesado == 0) ? "<p class=\"text-danger\">NO</p>": "SI";?>
                      </td>
                      <td>
                          <a data-toggle="tooltip" title="Ver Detalle" href="<?php echo base_url().'verInsta/'.$record->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</a>

<?php if(($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) || ($record->activo == 0 && $record->enviado == 0 && $record->recibido == 0)) { ?>    
                          <a data-toggle="tooltip" title="Editar" href="<?php echo base_url().'editOldInsta/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
<?php } ?>   

<?php if( ($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) ) { ?>                        
                          <a data-toggle="tooltip" title="Cancelar" href="#" data-instaid="<?php echo $record->id; ?>" class="deleteInsta"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
<?php } ?>

<?php if(($record->activo == 1 && $record->enviado == 0 && $record->recibido == 0) ) { ?>                          
                          <a data-toggle="tooltip" title="Enviar" href="#" data-instaid="<?php echo $record->id; ?>" class="enviarInsta"><i class="fa fa-share-square-o"></i>&nbsp;&nbsp;&nbsp;</a>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/insta.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "instaListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
