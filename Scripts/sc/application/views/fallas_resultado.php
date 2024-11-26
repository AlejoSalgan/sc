<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

$NOVnovedades = explode(',', $novedades_novedades); //Los permisos para cada boton.

?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"><?=$titulo?></h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?=base_url()?>" class="fa fa-home"> Inicio</a></li>
                  <li><a href="<?=base_url('fallas')?>">Novedades</a></li>
                  <li class="active">Resultado</li>
              </ol>
          </div>
      </div>
    </section>
    <section class="content">
	<div class="box">
		<div class="box-body">
			<?=$mensaje_orden?>
			<?php foreach ($mensajes as $mensaje):?>
				<?=$mensaje?>
			<?php endforeach;?>
		</div>
	</div>
	</section>
</div>