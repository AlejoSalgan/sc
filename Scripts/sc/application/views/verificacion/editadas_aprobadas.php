<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$total_imagenes = sizeof($fotos);
$image_a_mostrar = ($total_imagenes < 15) ? $total_imagenes : 15;

 // Estos valores los recibo por GET
if(isset($_GET['pag'])){
	if ($image_a_mostrar > 14) {
		$imagen_a_empezar = ($_GET['pag']-1) * $image_a_mostrar;
	} else {
		$imagen_a_empezar = 0;
	}
	
	$imagen_a_terminar = $imagen_a_empezar + $image_a_mostrar;
	$pag_act = $_GET['pag'];
}else{
	$imagen_a_empezar = 0;
	$imagen_a_terminar = $imagen_a_empezar + $image_a_mostrar;
	$pag_act = 1;
}

 //Determino el numero de paginas
$pag_ant = $pag_act - 1;
$pag_sig = $pag_act + 1;
$pag_ult = $total_imagenes / $image_a_mostrar;
$residuo = $total_imagenes % $image_a_mostrar;
if($residuo>0) $pag_ult = floor($pag_ult) + 1;

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
.border {
	border: 4px solid;
}

.full {
	border-image: linear-gradient(45deg, #c0c5ce, #a7adba) 1;
}

.hoverEffect img {
	opacity: 1;
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}

.hoverEffect figure:hover img {
	opacity: .5;
}

:checked + img[class="full border"] {
	border-image: linear-gradient(45deg, lightgreen, green) 1;
}

:not(:checked) + img[class="full border"] {
	border-image: linear-gradient(45deg, #c0c5ce, #a7adba) 1;
}

input[type="checkbox"] {
	display: none;
}

#s{
	display: none;
}
</style>

<div class="content-wrapper">
	<div id="cabecera">
	Verificacion - Ver editadas
	<span class="pull-right">
		<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
		<a href="<?=base_url("protocolos_asignados")?>"> Protocolos Asignados</a> /
		<span class="text-muted"><?="$titulo - Protocolo Nº $protocolo->id"?></span>
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
				<?php echo "Pagina<strong><span class='text-primary'> ".$pag_act."</span></strong> de <strong>".$pag_ult ."</strong>";?>
            </h1>
          </div><!-- /.box -->
        </div>
    	</div>


			<div class="col-xs-4 text-right">
				<div class="form-group">
					<?= " <a class='btn btn-primary guardar' id='s' href=\"?pag=".$pag_sig."\" onclick=\"$pag_sig\">Siguiente</a>"?>
					
					<?php if ($_GET['pag'] != 1) {
						echo "<a class='btn btn-primary' href=\"./$id_protocolo\" onclick=\"1\">Primero</a> ";
					}
					
					if($pag_act>1) echo "<a class='btn btn-primary' href=\"?pag=".$pag_ant."\" onclick=\"$pag_ant\">Anterior</a> ";

					if($pag_act<$pag_ult) echo " ";?>

					<?php if ($pag_act<$pag_ult): ?>
						<button class="btn btn-success siguiente">Siguiente y confirmar</button>
					<?php elseif ($pag_act == $pag_ult): ?>
						<button class="btn btn-success siguiente">Confirmar y finalizar</button>
					<?php endif; ?>

					<?php if ($_GET['pag'] != $pag_ult) {
						echo "<a class='btn btn-primary' href=\"?pag=". $pag_ult."\" onclick=\"$pag_ult\">Ultimo</a>";
					}?>
				</div>


          </div><!-- /.box -->
		</div>

		<div class="row">
 		 <div class="col-lg-12">
 			 <div class="box box-primary">

				 <input type="hidden" name="pag_act" id="pag_act" value="<?=$pag_act?>">
				 <input type="hidden" name="pag_ult" id="pag_ult" value="<?=$pag_ult?>">

				 <div class="box-body">
					 <div class="row" style="margin-left:30px;">
	 				 <?php for ($imagen_a_empezar; $imagen_a_empezar < $imagen_a_terminar; $imagen_a_empezar++): ?>
						 <?php if ($fotos[$imagen_a_empezar]->imagen1): ?>
							 <div class="col-lg-2 hoverEffect" style="margin-bottom:10px; margin-left:-20px; margin-right: 50px">
 								 <figure>
 		    				 	 <label>
 										 <input type="checkbox" id="identrada" name="identrada[]" value="<?=$fotos[$imagen_a_empezar]->identrada?>">
 										 <img class="full border" src="<?=base_url("ver_fotos_ssti")."/?p=".$id_protocolo.'&f='.$fotos[$imagen_a_empezar]->imagen1.'&c=50&t=1&w=192&h=108'?>" width="235px" height="154px">
 									 </label>
 									
 									
									<button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal" data-target="#imagemodal" id="ampliar1" value="<?=$fotos[$imagen_a_empezar]->imagen1?>">1</button>
							
									<?php if ($fotos[$imagen_a_empezar]->imagen2): ?>
										<button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal" data-target="#imagemodal" id="ampliar2" value="<?=$fotos[$imagen_a_empezar]->imagen2?>">2</button>
									<?php endif; ?>
							
									<?php if ($fotos[$imagen_a_empezar]->imagen3): ?>
										<button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal" data-target="#imagemodal" id="ampliar3" value="<?=$fotos[$imagen_a_empezar]->imagen3?>">3</button>
									<?php endif; ?>

									<?php if ($fotos[$imagen_a_empezar]->imagen4): ?>
										<button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal" data-target="#imagemodal" id="ampliar4" value="<?=$fotos[$imagen_a_empezar]->imagen4?>">4</button>
									<?php endif; ?>
								
								</figure>
 			 	 			</div>
						 <?php endif; ?>
	 				 <?php endfor; ?>
					 </div>

	 			 </div>
 			 </div>
 		 </div>
 	 </div>


	<div id="imagemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Imagen ampliada</h4>
				</div>
			
				<div class="modal-body">
					<img class="imagepreview" style="width: 100%; height:400px" >
				</div>
			
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Cerrar</button>
				</div>
					</form>
			</div>
		</div>
	</div>

	</section>
</div>

<script>
$(document).ready(function() {
	$(".ampliar").on("click", function(e) {
			 e.preventDefault();
			 var imgSRC = $(this).val();
			 $(".imagepreview").attr("src", "<?= base_url('ver_fotos_ssti'); ?>/?p=<?=$id_protocolo?>&c=50&t=1&w=192&h=108&f="+imgSRC);
	});

	$(".siguiente").on("click", function() {
			 //e.preventDefault();
			 var checkboxes = new Array();
			 var pag_act = $("#pag_act").val();
			 var pag_ult = $("#pag_ult").val();

			 $("input:checkbox:checked").each(function() {
					checkboxes.push($(this).val());
       });

			 if (checkboxes.length > 0){
				 $.ajax({
 					url: "<?= base_url('estado_entrada');?>",
 					method: "POST",
 					dataType: 'json',
 					data: { checkbox_names: checkboxes, id_protocolo: <?=$protocolo->id?> },
 					success : function(data) {
 						 //alert(data.mensaje_subliminal);
						 if (pag_act == pag_ult) {
						 	window.location.href = '<?= base_url('protocolos_asignados');?>';
						 } else {
							 $("#s").get(0).click();
						 }
 					}
     	 });

			 }else{
				 if (pag_act == pag_ult) {
				 window.location.href = '<?= base_url('protocolos_asignados');?>';
					} else {
 						$("#s").get(0).click();
 				 }
			 }
	});
});
</script>
