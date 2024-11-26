<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$total_imagenes=sizeof($fotos);

if ($total_imagenes < 25) {
	$image_a_mostrar=$total_imagenes;
} else {
	$image_a_mostrar=25;
}

 //estos valores los recibo por GET
 if(isset($_GET['pag'])){
 	$imagen_a_empezar=($_GET['pag']-1)*$image_a_mostrar;
	$imagen_a_empezar1=($_GET['pag']-1)*$image_a_mostrar;
	$imagen_a_empezar2=($_GET['pag']-1)*$image_a_mostrar;
	$imagen_a_empezar3=($_GET['pag']-1)*$image_a_mostrar;

	$imagen_a_terminar=$imagen_a_empezar+$image_a_mostrar;
 	$pag_act=$_GET['pag'];
 }else{
 	$imagen_a_empezar=0;
	$imagen_a_empezar1=0;
	$imagen_a_empezar2=0;
	$imagen_a_empezar3=0;

 	$imagen_a_terminar=$imagen_a_empezar+$image_a_mostrar;
 	$pag_act=1;
 }

 //parte 2: determinar numero de paginas
 $pag_ant=$pag_act-1;
 $pag_sig=$pag_act+1;
 $pag_ult=$total_imagenes/$image_a_mostrar;
 $residuo=$total_imagenes%$image_a_mostrar;
 if($residuo>0) $pag_ult=floor($pag_ult)+1;
 ?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">

<style>
  .mb60{
      margin-bottom: 60px;
  }
  .container {
    position: relative;
    margin:0 auto;
    max-width: 950px;
  }
  .swiper-container{
      text-align: center;
  }
  .swiper-container .swiper-slide img {
      max-width: 100%;
      width: 100%;
      height: auto;
  }
  .prettyprint{
      border: none;
      background: #fafafa;
      color: #697d86;
  }
  #thumbs {
      height: 10%;
      box-sizing: border-box;
      padding: 10px 0;
  }
  #thumbs .swiper-slide {
      width: 16%;
      height: auto;
      opacity: 0.2;
      cursor: pointer;
  }
  #thumbs .swiper-slide-active {
      opacity: 1;
  }


	@font-face {
    font-family: 'License-Plate';
    src: url("<?=base_url('assets/fuentes/LicensePlate.ttf')?>");
    font-weight: normal;
    font-style: normal;
	}

	@font-face {
		font-family: 'FE-FONT';
		src: url("<?=base_url('assets/fuentes/FE-FONT.TTF')?>");
		font-weight: normal;
		font-style: normal;
	}

/* AUTOS*/
#auto_viejo {
    position: absolute;
    color: white;
    font-size: 60px;
		font-family: "License-Plate";
    left: 130px;
		margin-top: 15px;
}

#auto_nuevo {
    position: absolute;
    color: black;
    font-size: 50px;
		font-family: "FE-FONT";
    left: 94px;
		margin-top: 15px;
		word-spacing: -10px;
}

/* MOTOS */
#moto_vieja_letras {
    position: absolute;
    color: white;
    font-size: 40px;
		font-family: "License-Plate";
    left: 197px;
		margin-top: 15px;
		margin-bottom: 1px;

}

#moto_vieja_numeros {
    position: absolute;
    color: white;
    font-size: 40px;
		font-family: "License-Plate";
    left: 197px;
		margin-top: 50px;
}

#moto_nueva_p1 {
    position: absolute;
    color: black;
    font-size: 35px;
		font-family: "FE-FONT";
    left: 187px;
		margin-top: 5px;
}

#moto_nueva_p2 {
    position: absolute;
    color: black;
    font-size: 35px;
		font-family: "FE-FONT";
    left: 177px;
		margin-top: 40px;
}

</style>

<div class="content-wrapper">
  <div id="cabecera">
   SSTI - <?=$titulo?>
   <span class="pull-right">
     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
		 <a href="<?=base_url("verExportacion/$protocolo->idexportacion")?>"> Exportacion Nº <?=$protocolo->idexportacion?> </a> /
     <span class="text-muted"><?=$titulo?></span>
   </span>
 </div>

  <section class="content">
    <div class="row">
      <div class="col-xs-4">
        <div class="box box-primary">
          <div class="box-header">
            <h1 class="box-title">
							<?= "Equipo: <a href=".base_url("verEquipo/{$protocolo->id_equipo}").">" . $protocolo->equipo_serie . "</a> - ".$protocolo->proyecto ?>
            </h1>
          </div><!-- /.box -->
        </div>
    	</div>

			<div class="col-xs-4">
        <div class="box box-primary">
          <div class="box-header">
            <h1 class="box-title">
							<?= "Protocolo: <span class='text-primary'>$id_protocolo</span>"?>
            </h1>
          </div><!-- /.box -->
        </div>
    	</div>

			<div class="col-xs-4">
        <div class="box box-primary">
          <div class="box-header">
            <h1 class="box-title">
							<?= "Total de recortes: <span class='text-primary'>$total_imagenes</span>"?>
            </h1>
          </div><!-- /.box -->
        </div>
    	</div>
		</div>

		<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary">
						<div class="box-header with-border">
	            <h1 class="box-title">Fotos del equipo</h1>
							<span class="pull-right">

							 <a data-toggle="modal" title="Ayuda" data-target="#modalAyuda_instaOrdenes" ><i class="fa fa-question-circle text-info fa-lg"></i></a>
									 <!-- sample modal content -->
									 <div id="modalAyuda_instaOrdenes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											 <div class="modal-dialog">
													 <div class="modal-content">
															 <div class="modal-header">
																	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	 <h4 class="modal-title" id="myModalLabel">Ayuda de la galería</h4>
															 </div>
															 <div class="modal-body">
																 <p><strong>Equipo:</strong> Nombre de serie del equipo seguido por su proyecto.</p>
																 <p><strong>Protocolo:</strong> Protocolo del equipo.</p>
																 <p><strong>Total de recortes:</strong> Cantidad de recortes del equipo. No confundir con el total de imágenes del protocolo.</p>
																 <p><strong>Controles</strong></p>
																 <p><strong>Deslizar:</strong> Se puede hacer el cambio de imagen haciendo click sobre la foto y deslizando para la derecha o izquierda.<br>
																 <p><strong>Detalles:</strong> La galería mostrara de a 25 imágenes por pagina. Debajo de las miniaturas esta el paginado para ir a las siguientes paginas.</p>
															 </div>
															 <div class="modal-footer">
																	 <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
															 </div>
													 </div>
											 </div>
									 </div>
						 </span>
	          </div><!-- /.box -->

					<div class="box-body">

						<div class="container">
                <div id="slider" class="swiper-container">
                    <div class="swiper-wrapper">
											<?php for ($imagen_a_empezar; $imagen_a_empezar < $imagen_a_terminar; $imagen_a_empezar++): ?>
														<div class="swiper-slide">
															<div class="row">
																<div class="col-lg-6">
																	<img src="<?=base_url("ver_fotos_ssti")."/?p=".$id_protocolo.'&f='.$fotos[$imagen_a_empezar]['imagen1'].'&c=50'?>" width="50%" height="50%">
																</div>

																<div class="col-lg-6">
																	<div class="box box-primary">
												            <div class="box-header with-border">
												              <h3 class="box-title">Datos de la Infraccion</h3>
												           </div>
												           <div class="box-body table-responsive no-padding">
															<table class="table table-bordered">
																<tbody>
                                                            		<tr>
                                                            			<td colspan="4">
                                                            				<div>
                                                                    			<?php $dominio = $fotos[$imagen_a_empezar]['dominio']; ?>
                                                                    			<?php if (strlen($dominio) == 6): ?>
                                                                    				<?php
                                                                    				$primera_parte = substr($dominio, 0, 3);
                                                                    				$segunda_parte = substr($dominio, 3, 3);
                                                                    				?>
                                                                    				<?php if (!is_numeric($primera_parte)): ?>
                                                                    					<img id="image" src="<?php echo base_url(); ?>assets/images/auto_viejo.jpg" style="width:200px; height:103px;">
                                                                    					<span id="auto_viejo"><?=$primera_parte." ".$segunda_parte?></span>
                                                                    				<?php else: ?>
                                                                    					<img id="image" src="<?php echo base_url(); ?>assets/images/moto_vieja.jpg" style="width:20px; height:103px;">
                                                                    					<span id="moto_vieja_letras"><?=$primera_parte?></span>
                                                                    					<span id="moto_vieja_numeros"><?=$segunda_parte?></span>
                                                                    				<?php endif; ?>
                                                                    
                                                                    			<?php else: ?>
                                                                    				<?php if (!is_numeric(substr($dominio, 1, 1))): ?>
                                                                    					<img id="image" src="<?php echo base_url(); ?>assets/images/auto_nuevo.jpg" style="width:290px; height:100px;">
                                                                    					<?php
                                                                    					$letras1 = substr($dominio, 0, 2);
                                                                    					$numeros = substr($dominio, 2, 3);
                                                                    					$letras2 = substr($dominio, 5, 2);
                                                                    					?>
                                                                    					<span id="auto_nuevo" ><?=$letras1." ".$numeros." ".$letras2?></span>
                                                                    				<?php else: ?>
                                                                    					<img id="image" src="<?php echo base_url(); ?>assets/images/moto_nueva.jpg" style="width:120px; height:100px;">
                                                                    					<?php
                                                                    					$primera_parte = substr($dominio, 0, 3);
                                                                    					$segunda_parte = substr($dominio, 3, 4);
                                                                    					?>
                                                                    					<span id="moto_nueva_p1"><?=$primera_parte?></span>
                                                                    					<span id="moto_nueva_p2"><?=$segunda_parte?></span>
                                                                    				<?php endif; ?>
                                                                    			<?php endif; ?>
                                                                    		</div>
                                                                    	</td>
                                                                    </tr>
																	<tr>
										                      			<th>Identificacion interna</th>
																		<td colspan="3"><span class="text-primary"><?=$fotos[$imagen_a_empezar]['identrada']?></span></td>
												                    </tr>

																	<tr>
											                        	<th>Fecha de toma</th>
																	    <td colspan="3"><?=date('d/m/Y',strtotime($fotos[$imagen_a_empezar]['fecha_toma']))." - ".$fotos[$imagen_a_empezar]['hora_toma']?></td>
												                    </tr>

																	<tr>
												                        <th>Editado por</th>
																		<td colspan="3"><?=$fotos[$imagen_a_empezar]['editado_por']?></td>
												                    </tr>

																	<tr>
												                        <th>ID Edicion</th>
																		<td colspan="3"><span class="text-primary"><?=$fotos[$imagen_a_empezar]['idedicion']?></span></td>
												                    </tr>

																	<tr>
											                        	<th>Fecha de Edicion</th>
																		<td colspan="3"><?=date('d/m/Y - H:i:s',strtotime($fotos[$imagen_a_empezar]['frequest']))?></td>
												                    </tr>

																	<tr>
											                    		<th>Archivo 1</th>
																		<td colspan="3">
																			<a href="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar]['imagen1']?>&c=50" title="Ver imagen 1" target="_blank"><?=$fotos[$imagen_a_empezar]['imagen1']?>&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>
																		</td>
												                    </tr>
																	<?php if ($fotos[$imagen_a_empezar]['imagen2']): ?>
																	<tr>
													                	<th>Archivo 2</th>
																		<td colspan="3">
																			<a href="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar]['imagen2']?>&c=50" title="Ver imagen 2" target="_blank"><?=$fotos[$imagen_a_empezar]['imagen2']?>&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>
																		</td>
												                    </tr>
																	<?php endif; ?>

																	<?php if ($fotos[$imagen_a_empezar]['imagen3']): ?>
																	<tr>
													                	<th>Archivo 3</th>
																		<td colspan="3">
																		
																			<a href="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar]['imagen3']?>&c=50" title="Ver imagen 3" target="_blank"><?=$fotos[$imagen_a_empezar]['imagen3']?>&nbsp;&nbsp;<i class="fa fa-external-link"></i></a>
																		</td>
													                </tr>
																	<?php endif; ?>
																</tbody>
															</table>
										           		</div>
									          		</div>
																</div>
															</div>
														</div>
											<?php endfor; ?>

                    </div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                    <div class="swiper-button-next swiper-button-white"></div>
                </div>

                <div id="thumbs" class="swiper-container mb60">
                    <div class="swiper-wrapper">
						<?php for ($imagen_a_empezar1; $imagen_a_empezar1 < $imagen_a_terminar; $imagen_a_empezar1++): ?>
							<div class="swiper-slide">
								<img src="<?=base_url("ver_fotos_ssti").'/?idedicion='.$fotos[$imagen_a_empezar1]['idedicion']?>">
								<!-- <img src="http://ssti.cecaitra.com/modulos/ver-imagen-zoom.php?idedicion=<?=$fotos[$imagen_a_empezar1]['idedicion']?>"> -->
							</div>
						<?php endfor; ?>
                    </div>
                </div>
        </div><!-- / #contents -->

					</div>
				</div>
			</div>
  	</div>

		<div class="box-footer clearfix">
			<?php
				echo "<h4>Pagina<strong><span class='text-primary'> ".$pag_act."</span></strong> de <strong>".$pag_ult ."</strong></h4>";
			if ($_GET['pag'] != 1) {
				echo "<a class='btn btn-primary' href=\"./$id_protocolo\" onclick=\"Pagina('1')\">Primero</a> ";
			}
			if($pag_act>1) echo "<a class='btn btn-primary' href=\"?pag=".$pag_ant."\" onclick=\"Pagina('$pag_ant')\">Anterior</a> ";

			if($pag_act<$pag_ult) echo " <a class='btn btn-primary' href=\"?pag=".$pag_sig."\" onclick=\"Pagina('$pag_sig')\">Siguiente</a> ";

			if ($_GET['pag'] != $pag_ult) {
				echo "<a class='btn btn-primary' href=\"?pag=". $pag_ult."\" onclick=\"Pagina('$pag_ult')\">Ultimo</a>";
			}
			?>
		</div>
  </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>

<script type="text/javascript">
var slider = new Swiper ('#slider', {
  slidesPerView: 1,
  loop: false,
  loopedSlides: 6,
  centeredSlides : true,
　disableOnInteraction: true,
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
  })
  var thumbs = new Swiper('#thumbs', {
      centeredSlides: true,
      spaceBetween: 10,
loop: false,
      slidesPerView: "auto",
      touchRatio: 0.2,
      slideToClickedSlide: true
  });
  slider.params.control = thumbs;
  thumbs.params.control = slider;
</script>
