<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?=$titulo?></i></h4> 
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio <i class="fa fa-file-excel"></i></a></li>
                    <li class="active"><?=$titulo?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?= $title ?>
                         
                    <!-- Botón volver atrás -->   
                   	<span class="pull-right">
                   	<button onclick="goBack()" type="button" class="btn btn-primary"><b>Volver atrás</b></button>
               		<script>
                   		function goBack() {
                       		window.history.back();
                       		}
                    </script>
                    </span>
                  </h2>
             </div>
            <!-- /.col-lg-12 -->
         </div>
    </section>
    
    <section class="content">
    	<div class="row">
              <!-- col-md-12 -->
                  <div class="col-md-12">
                   <?php if ($error_no_existe):?>
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p><b>Los siguientes precintos no se encuentran en el sistema:</b> </p>
                          <?php foreach ($error_no_existe as $value) {
                              echo $value."<br>";
                              }?>
                       </div>
                   <?php endif;?>
                    <?php if ($error_estado):?>
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <p>Los siguientes precintos no se encuentran cargados: </p>
                          <?php foreach ($no_existe as $value) {
                              echo $value."<br>";
                              }?>
                       </div>
                   <?php endif;?>
                    <?php if ($error_precinto_usado ):?>
                    
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p><b>Los siguientes precintos ya fueron utilizados:</b> </p>
                          <?php foreach ($error_precinto_usado as $value) {
                              echo $value."<br>";
                              }?>
                       </div>
                   <?php endif;?>
                    <?php if ($error_precinto_acta ):?>
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p><b>Los siguientes precintos estan en las actas:</b> </p>
                          <?php foreach ($error_precinto_acta as $value) {
                              echo $value."<br>";
                              }?>
                       </div>
                   <?php endif;?>
                     <?php if ($success): ?>
                     <?php echo "carlos"; ?>
                     <div class="alert alert-success alert-dismissable">Archivo: <?= $file ?> cargado correctamente
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
                   <?php endif; ?>
                       <!-- row -->
                         <div class="row">
                           <div class="col-md-12">
                             <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');?>
                            </div>
                          </div>
                       <!-- /row -->
                   </div>
               <!-- /col-md-12 --> 
            </div>
    </section>
</div>

