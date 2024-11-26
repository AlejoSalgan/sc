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
	$imagen_a_terminar=$imagen_a_empezar+$image_a_mostrar;
 	$pag_act=$_GET['pag'];
 }else{
 	$imagen_a_empezar=0;
	$imagen_a_empezar1=0;
	$imagen_a_empezar2=0;
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
<link href="<?= base_url(); ?>assets/css/galeria_fotos.css" type="text/css" rel="stylesheet" media="screen" />

<div class="content-wrapper">
  <div id="cabecera">
   SSTI - <?=$titulo?>
   <span class="pull-right">
     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
		 <a href="<?=base_url("fotosDesencriptadas_listado")?>"> Fotos Desencriptadas </a> /
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
							<?= "Total de Imagen1: <span class='text-primary'>$total_imagenes</span>"?>
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
																 <p><strong>Total de Imagen1:</strong> Cantidad de la imagen1 del equipo. No confundir con el total de imágenes del protocolo.</p>
																 <p><strong>Controles</strong></p>
																 <p><strong>Flecha izquierda:</strong> Ir a la anterior imagen.<br>
																 <strong>Flecha derecha:</strong> Ir a la siguiente imagen.<br>
																 <strong>Enter:</strong> Imagen a pantalla completa.<br>
																 <strong>Esc o Escape:</strong> Salir de la imagen en pantalla completa.</p>
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
				    <div class="product-gallery">
				      <div class="product-photo-main" style=" margin-bottom:0px">
				        <div class="swiper-container">
				          <div class="swiper-wrapper">
										<?php for ($imagen_a_empezar; $imagen_a_empezar < $imagen_a_terminar; $imagen_a_empezar++): ?>
											<div class="swiper-slide">
					              <div class="swiper-zoom-container">
				              		<img src="<?=base_url("ver_fotos_ssti")."/?p=".$id_protocolo.'&f='.$fotos[$imagen_a_empezar].'&c=50'?>" width="100%" height="100%" style="position:relative; margin-bottom:75px">

					               <!--  <img src="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar]?>&c=50" width="100%" height="100%" style="position:relative; margin-bottom:75px"> -->
					              </div>
					            </div>
										<?php endfor; ?>
				          </div>
				          <div class="swiper-pagination"></div>
				        </div>
				      </div>
				      <div class="product-photos-side">
				        <div class="swiper-container">
				          <div class="swiper-wrapper">
										<?php for ($imagen_a_empezar1; $imagen_a_empezar1 < $imagen_a_terminar; $imagen_a_empezar1++): ?>
											<div class="swiper-slide">
					              <div class="swiper-zoom-container">
					              <img src="<?=base_url("ver_fotos_ssti")."/?p=".$id_protocolo.'&f='.$fotos[$imagen_a_empezar1].'&c=50'?>">
					           		<!--<img src="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar1]?>&c=50"> -->
					              </div>
					            </div>
										<?php endfor; ?>
				          </div>
				        </div>
				      </div>
				    </div>

						<div class="product-gallery-full-screen">
						  <div class="swiper-container gallery-top">
						    <div class="swiper-wrapper">
									<?php for ($imagen_a_empezar2; $imagen_a_empezar2 < $imagen_a_terminar; $imagen_a_empezar2++): ?>
										<div class="swiper-slide">
											<div class="swiper-zoom-container">
											 <img src="<?=base_url("ver_fotos_ssti")."/?p=".$id_protocolo.'&f='.$fotos[$imagen_a_empezar2].'&c=50'?>">
											<!-- 	<img src="http://edicion-metro.cecaitra.com/modulos/ver-foto-tam-araujo.php?p=<?=$id_protocolo?>&f=<?=$fotos[$imagen_a_empezar2]?>&c=50" draggable="false" ondragstart="return false;">-->
											</div>
										</div>
									<?php endfor; ?>
						    </div>
						    <div class="swiper-button-next swiper-button-white">
						      <svg fill="#FFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						        <path d="M0 0h24v24H0z" fill="none"/>
						        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
						      </svg>
						    </div>
						    <div class="swiper-button-prev swiper-button-white">
						      <svg fill="#FFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						        <path d="M0 0h24v24H0z" fill="none"/>
						        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
						      </svg>
						    </div>

						    <div class="gallery-nav">
						      <div class="swiper-pagination"></div>
						      <ul class="gallery-menu">
						        <li class="zoom">
						          <svg class="zoom-icon-zoom-in" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
						            <path d="M0 0h24v24H0V0z" fill="none"/>
						            <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
						          </svg>
						          <svg class="zoom-icon-zoom-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						            <path d="M0 0h24v24H0V0z" fill="none"/>
						            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/>
						          </svg>
						        </li>
						        <li class="fullscreen">
						          <svg class="fs-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						            <path d="M0 0h24v24H0z" fill="none"/>
						            <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
						          </svg>
						          <svg class="fs-icon-exit" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						            <path d="M0 0h24v24H0z" fill="none"/>
						            <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>
						          </svg>
						        </li>
						        <li class="close">
						          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
						            <path d="M0 0h24v24H0z" fill="none"/>
						          </svg>
						        </li>
						      </ul>
						    </div>
						  </div>
						</div>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/js/swiper.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/css/swiper.min.css" type="text/css" rel="stylesheet" />

<script type="text/javascript">

$(document).ready(function() {
  // --- VARIABLES ---
  var swiperSide = new Swiper('.product-photos-side .swiper-container', {
    direction: 'horizontal',
    centeredSlides: true,
    spaceBetween: 30,
    slidesPerView: 'auto',
    touchRatio: 0.2,
    slideToClickedSlide: true,
  })
  var swiperProduct = new Swiper('.product-photo-main .swiper-container', {
    direction: 'horizontal',
    pagination: '.swiper-pagination',
    paginationClickable: true,
    // keyboardControl: true,
  })
  var galleryTop = new Swiper('.product-gallery-full-screen .gallery-top', {
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    pagination: '.swiper-pagination',
    paginationType: 'fraction',
    spaceBetween: 10,
    keyboardControl: true,
    noSwiping: true,
    zoom: true,
  })
  swiperSide.params.control = swiperProduct || galleryTop;
  swiperProduct.params.control = swiperSide || galleryTop;
  galleryTop.params.control = swiperProduct || swiperSide;

  var galleryOpen = false,
      fullscreen = false,
      fsTrigger = $('.gallery-nav .fullscreen')[0],
      fsGallery = $('.product-gallery-full-screen')[0],
      fsFunction = fsGallery.requestFullscreen;
  // browser support check
  if (!fsFunction) {
    ['webkitRequestFullScreen',
      'mozRequestFullscreen',
      'msRequestFullScreen'
    ].forEach(function(req) {
      fsFunction = fsFunction || fsGallery[req];
    });
  }

  // --- FUNCTIONS ---
  function openImageGallery(slide) {
    galleryOpen = true;
    var galleryX = $('.product-photo-main').offset().left,
      galleryY = $('.product-photo-main').offset().top,
      galleryHeight = $('.product-photo-main').height(),
      galleryWidth = $('.product-photo-main').width(),
      activeIndex = slide.index(),
      indexes = $('.product-photo-main').find('.swiper-slide').length;
    $('body').css('overflow', 'hidden');
    $('.main, .product-gallery-full-screen').css('overflow-y', 'scroll');
    $('.product-gallery-full-screen').addClass('opened');
    galleryTop.activeIndex = activeIndex;
    galleryTop.onResize();
  }

  function goFs() {
    fullscreen = true;
    $('.product-gallery-full-screen').css('overflow-y', 'auto');
    $('.fullscreen').addClass('leavefs');
    fsFunction.call(fsGallery);
  }

  function leaveFs() {
    fullscreen = false;
    $('.product-gallery-full-screen').css('overflow-y', 'scroll');
    $('.fullscreen').removeClass('leavefs');
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }

  function closeImageGallery() {
    // if(zoomed) {
    //   zoom($('.product-gallery-full-screen .swiper-slide-active img'));
    // }
    $('body').css('overflow', 'auto');
    $('.main, .product-gallery-full-screen').css('overflow-y', 'auto');
    galleryOpen = false;
    leaveFs();
    $('.product-gallery-full-screen').removeClass('opened');
  }

  // --- EVENTS ---
  // open the large image gallery
  $('.product-photo-main .swiper-slide').on('click touch', function() {
    var slide = $(this);
    openImageGallery(slide);
  });
  // close the large image gallery
  $('.gallery-nav .close').on('click touch', function() {
    closeImageGallery();
  });
  // zoom in / out
  $('.zoom').on('click touch', function() {
    // zoom
  });
  // fullscreen toggle
  $(fsTrigger).on('click touch', function() {
    if (fullscreen) {
      leaveFs();
    } else {
      goFs();
    }
  });

  // keyboard controls
  $(document).on('keydown', function(e) {
    e.preventDefault();
    var code = e.keyCode || e.which;
    // open the large image gallery
    if (code == 13 && !galleryOpen) {
      var slide = $('.product-photo-main .swiper-slide.swiper-slide-active');
      openImageGallery(slide);
    }
    // close the large image gallery
    if (code == 27 && galleryOpen) {
      closeImageGallery();
    }
    if (code == 122) {
      if(galleryOpen) {
        if (fullscreen) {
          leaveFs();
        } else {
          goFs();
        }
      }
    }
  });

  $(window).on('resize', function() {
    galleryTop.onResize();
    swiperSide.onResize();
    swiperProduct.onResize();
  });
});

</script>
