<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

if ($link == "componentesListing") {
  $COMcomponentes = explode(',', $componentes_componentes); //Los permisos para cada boton de Acciones.
} elseif($link == "compNoAsigListing") {
  $COMsinasignar  = explode(',', $componentes_sinAsignar);
}

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Componentes</h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active">Componentes</li>
              </ol>
          </div>
      </div>
    </section>
       
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if($COMcomponentes[0] == 1 || $COMsinasignar[0] == 1) { ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewComponente2">Agregar Componente</a>
                    <?php } ?>

                    <?php if($COMcomponentes[1] == 1 || $COMsinasignar[1] == 1) { ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewComponente">Agregar Componente SERIE</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Componentes listado</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() . $link ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Marca Tipo Equipo"/>
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
                      <th>Cantidad</th>
                      <th>Tipo</th>
                      <th>Modelo</th>
                      <th>Marca</th>
                      <th>Serie</th>
                      <th>Equipo</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                    <?php
                    if(!empty($componentesRecords))
                    {
                        foreach($componentesRecords as $record)
                        {
                          $etiqueta = ($record->activo == 1) ? "success" : "danger";
                    ?>
                    <tr>

                      <td class="text-center"><span class="label label-<?=$etiqueta ?>"><?=$record->cantidad ?></span></td>
                      <td><?=$record->descrip_tipo ?></td>
                      <td><?php echo($record->modelo == '')?"<spam class=\"text-info\">A designar</spam></small>": $record->modelo?></td>
                      <td><?php echo($record->descrip_marca == '')?"<spam class=\"text-info\">A designar</spam></small>": $record->descrip_marca?></td>
                      <td><?php echo($record->serie == '')?"<spam class=\"text-info\">A designar</spam></small>": $record->serie?></td>
                      <td>
                      <?php //los grupos no pueden ser sin asignar, sólo en forma individual se asigna.
                      echo ($record->serieEquipo == "") ? "<spam class=\"text-primary\">Depósito</spam>" : "<spam class=\"text-success\">" . $record->serieEquipo . "</spam>";

                       /* if(($record->cantidad == 1)){
                          echo ($record->serieEquipo == "") ? "<spam class=\"text-primary\">Depósito</spam>" : "<spam class=\"text-success\">" . $record->serieEquipo . "</spam>";
                        } else {
                          echo "<spam class=\"text-primary\">Depósito</spam>";
                        }*/
                      ?>
                            
                      </td>
                      <td><?php echo($record->descrip == '')?"<spam class=\"text-info\">Sin descripción</spam></small>": $record->descrip?></td>
                      <td>
                          <?php if(($record->cantidad == 1)){ ?>  <!--los grupos no pueden ser sin asignar, sólo en forma individual se asigna.-->

                              <?php if($COMcomponentes[2] == 1 || $COMsinasignar[2] == 1) { ?>
                                  <a href="<?php echo base_url().'editOldComponente/'.$record->id; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php } ?>

                              <?php if($COMcomponentes[3] == 1 || $COMsinasignar[3] == 1) { ?>
                                  <a href="#" data-componenteid="<?php echo $record->id; ?>" class="deleteComponente"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php } ?>

                          <?php } else {  ?>

                              <?php if($COMcomponentes[2] == 1 || $COMsinasignar[2] == 1) { ?>
                                  <a href="<?php echo base_url().'editOldComponente2/'.$record->idtipo . '/' . $record->idmarca; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php } ?>

                              <?php if($COMcomponentes[3] == 1 || $COMsinasignar[3] == 1) { ?>
                                  <a href="#" data-componenteid="<?php echo $record->idtipo . '|' . $record->idmarca; ?>" class="deleteComponente"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                              <?php } ?>
                          <?php } ?>

                          <?php if($COMcomponentes[4] == 1 || $COMsinasignar[4] == 1) { ?>                          
                              <a href="<?php echo base_url().'historial//historialCompListing/'.$record->id; ?>"><i class="fa fa-history"></i>&nbsp;&nbsp;&nbsp;</a>
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
console.log($(location).attr('href'));
console.log($(location).attr('pathname'));    

    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);

            pat = /componentesListing/;
            if(pat.test($(location).attr('pathname')))
              {
                jQuery("#searchList").attr("action", baseURL + "componentesListing/" + value);
              } else {
                jQuery("#searchList").attr("action", baseURL + "compNoAsigListing/" + value);
              }

            //jQuery("#searchList").attr("action", baseURL + "componentesListing/" + value);
            //jQuery("#searchList").attr("action", baseURL + "compNoAsigListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
