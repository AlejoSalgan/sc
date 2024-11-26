<?php 

   $eliminadas = []; // Definir $eliminadas como un array vacío por defecto


   if (!defined('BASEPATH')) {
       exit('No direct script access allowed');
   }

   if (!$fotos) {
       exit('No direct script access allowed');
   }

   $total_imagenes = sizeof($fotos);
   $image_a_mostrar = ($total_imagenes < 15) ? $total_imagenes : 15;

   $pag_recibida =$_GET['pag'];
   if($pag_recibida*1 <= 0){
       header("Location: ?pag=1");
   }


   if (isset($pag_recibida)) {
       if ($image_a_mostrar > 14) {
           $imagen_a_empezar = ($pag_recibida - 1) * $image_a_mostrar;

       } else {   
           $pag_act = 1;
           $imagen_a_empezar = 0;
       }

       $imagen_a_terminar = $imagen_a_empezar + $image_a_mostrar;
       $pag_act = $pag_recibida;
       
   } else {

        $ultimo_registro = $ultimo->ultimo;

        if($ultimo_registro){

            function buscarPosicionPorIdentEntrada($array, $identrada) {
                foreach ($array as $posicion => $objeto) {
                    if ($objeto->identrada == $identrada) {
                        return $posicion;
                        
                    }
                }
                pre("NO SE ENCUENTRA ULIMO VISTO EN PROTOCOLO");
                die;
            }

            $resultado = buscarPosicionPorIdentEntrada($fotos, $ultimo_registro);        
            $pag_act = floor($resultado/15);
            header("Location: ?pag=$pag_act");

        }else{
            $imagen_a_empezar = 0;
            $imagen_a_terminar = $imagen_a_empezar + $image_a_mostrar;
            $pag_act = 1;
        }           
   }

   //Determino el numero de paginas
   $pag_ant = $pag_act - 1;
   $pag_sig = $pag_act + 1;
   $pag_ult = $total_imagenes / $image_a_mostrar;
   $residuo = $total_imagenes % $image_a_mostrar;
   
   if ($residuo > 0) {

       $pag_ult = floor($pag_ult) + 1;

       if($pag_act == $pag_ult){
           $imagen_a_terminar = $total_imagenes;        
       }
   }



   // Obtener imágenes de la sesión si están disponibles
   $guardados_aprobados = isset($_SESSION['aprobados']) ? $_SESSION['aprobados'] : null;
   $guardados_eliminados = isset($_SESSION['eliminados']) ? $_SESSION['eliminados'] : null;

   // Si no hay imágenes guardadas en la sesión, inicializar los arrays
   if (!$guardados_aprobados && !$guardados_eliminados) {
       $aprobados = [];
       $eliminadas = [];

       // Obtener datos del servidor PHP
       $eliminadas_ant = json_encode($eliminados);
       $imagenes = json_encode($fotos);

       // Crear un array para almacenar los valores de identrada
       foreach ($fotos as $foto) {
           $aprobados[] = $foto->identrada;
       }
   } else {
       // Si hay imágenes guardadas en la sesión, recuperarlas
       $aprobados = json_decode($guardados_aprobados);
       $eliminadas = json_decode($guardados_eliminados);
   }


    

?>

<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/breadcrumbs.css');?>">

<style media="screen">
    .border {
        border: 4px solid;
    }

    .full {
        /* border-image: linear-gradient(45deg, #c0c5ce, #a7adba) 1; */
    }

    .hoverEffect img {
        opacity: 1;
        -webkit-transition: .3s ease-in-out;
        transition: .3s ease-in-out;
    }

    .hoverEffect img:hover {
        opacity: .5;
    }

    :checked+img[class="full border"] {
        /* border-image: linear-gradient(45deg, lightcoral, red) 1; */ 
        filter: saturate(55%) hue-rotate(120deg);
        border: 8px solid blue;



    }

    :not(:checked)+img[class="full border"] {
        border-image: linear-gradient(45deg, #c0c5ce, #a7adba) 1;

    }

    input[type="checkbox"] {
        display: none;
    }

    #s {
        display: none;
    }
    #loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    }

    .loading-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    text-align: center;
    z-index: 10000;
    }

    .spinner-border {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: text-bottom;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
    }

    @keyframes spinner-border {
    to {
        transform: rotate(360deg);
    }
    }

    .tooltip {
        visibility: hidden;
        width: 560px;
        background-color: #19190A;
        color: #ECF5EA;
        text-align: left;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        font-size:1em;
        left: 50%;
        margin-left: -20px;
        opacity: 0;
        transition: opacity 0.8s;
        font-family: Arial;
    }

    .ayuda:hover .tooltip {
        visibility: visible;
        opacity: 0.85;
    }

    /* Agrega los estilos oscuros para los elementos que desees */
</style>

<div class="content-wrapper">
   
    <div id="cabecera">
        Verificacion - Ver editadas
                <!-- Icono con efecto hover -->
            <span class="ayuda" style="margin-left: 20px; margin-bottom: 0px; position: relative;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16" style="vertical-align: middle;">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
            </svg>
            <!-- Cuadro flotante -->
            <div class="tooltip">

                <b style="margin-left: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-keyboard" viewBox="0 0 16 16">
                    <path d="M14 5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zM2 4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/>
                    <path d="M13 10.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm0-2a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm-5 0A.25.25 0 0 1 8.25 8h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 8 8.75zm2 0a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-1.5a.25.25 0 0 1-.25-.25zm1 2a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm-5-2A.25.25 0 0 1 6.25 8h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 6 8.75zm-2 0A.25.25 0 0 1 4.25 8h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 4 8.75zm-2 0A.25.25 0 0 1 2.25 8h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 2 8.75zm11-2a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm-2 0a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm-2 0A.25.25 0 0 1 9.25 6h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 9 6.75zm-2 0A.25.25 0 0 1 7.25 6h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 7 6.75zm-2 0A.25.25 0 0 1 5.25 6h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5A.25.25 0 0 1 5 6.75zm-3 0A.25.25 0 0 1 2.25 6h1.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-1.5A.25.25 0 0 1 2 6.75zm0 4a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm2 0a.25.25 0 0 1 .25-.25h5.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-5.5a.25.25 0 0 1-.25-.25z"/>
                    </svg> Atajos de Teclado
                </b>
            <ul>
                <il class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                    </svg>
                    : Página Siguiente
                </il>
                <il class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                        : Página Anterior
                </il>
                <il class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-usb" viewBox="0 0 16 16">
                        <path d="M2.25 7a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25h11.5a.25.25 0 0 0 .25-.25v-1a.25.25 0 0 0-.25-.25z"/>
                        <path d="M0 5.5A.5.5 0 0 1 .5 5h15a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5zM1 10h14V6H1z"/>
                    </svg> Space : Marcar todos
                </il>
               
            </ul>
                
                


            </div>
        </span>

        <span class="pull-right">
            <a href="<?=base_url();?>" class="fa fa-home"> Inicio</a> /
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
                            <?="Equipos: <a href=" . base_url("verEquipo/{$protocolo->id_equipo}") . ">" . $protocolo->equipo_serie . "</a> - " . $protocolo->proyecto?>
                        </h1>
                    </div><!-- /.box -->
                </div>
            </div>

            <div class="col-xs-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h1 class="box-title">
                            <?php echo "Pagina<strong><span class='text-primary'> " . $pag_act . "</span></strong> de <strong>" . $pag_ult . "</strong>"; ?>

                        </h1>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 text-right">
                <div class="form-group">
                    <?php
                        $pag_inicio = max(1, $pag_act - 1);
                        $pag_fin = min($pag_inicio + 2, $pag_ult);
                        $pag_inicio = max(1, $pag_fin - 2);
                    ?>  
                    <?php if ($total_imagenes >= 15): ?>

                        <?php if ($pag_act != 1): ?>
                            <a class="btn btn-primary" href="?pag=<?=1?>" onclick="1">Primero</a>
                            <a class="btn btn-primary ml-1" href="?pag=<?=$pag_ant?>" onclick="<?=$pag_ant?>"><</a>
                        <?php endif;?>


                        <?php if ($pag_act != $pag_ult): ?>
                                <?php for ($i = $pag_inicio; $i <= $pag_fin; $i++): ?>
                                    <a id="paginas" class="btn btn-primary<?=($i == $pag_act) ? ' active' : '';?>" href="?pag=<?=$i;?>" onclick="<?=$pag_ult?>"><?=$i;?></a>
                                <?php endfor;?>
                        <?php endif;?>
                        
                        <?php if ($pag_act < $pag_ult): ?>
                                <a id="adelante" class="btn btn-primary " href="?pag=<?=$pag_sig?>" onclick="<?=$pag_sig?>">></a>
                                <a class="btn btn-primary" href="?pag=<?=$pag_ult?>" onclick="<?=$pag_ult?>">Último</a>
                        

                        <?php endif;?>
                    <?php endif;?>

                    <button class="btn btn-success confirmar">Confirmar Fotos</button>
                </div>
            </div>
            

        </div>

         <!-- Formulario oculto -->
         <form id="formulario-protocolos" action="<?= base_url('procesar_protocolos') ?>" method="post" style="display: none;">
            <input type="hidden" name="protocolos_eliminados" id="protocolos_eliminados">
            <input type="hidden" name="protocolos_aprobados" id="protocolos_aprobados">
            <input type="hidden" name="protocolo_enviar" id="protocolo_enviar" value=" <?="$protocolo->id"?>">
            <input type="hidden" name="eliminados_anteriores" id="eliminados_anteriores" >
            <input type="hidden" name="ultimo" id="ultimo"   >
            <button type="submit">Enviar Protocolos</button>
         </form>

        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <input type="hidden" name="pag_act" id="pag_act" value="<?=$pag_act?>">
                    <input type="hidden" name="pag_ult" id="pag_ult" value="<?=$pag_ult?>">
                    <div class="box-body">
                        <div class="row" style="margin-left:30px;">
                            <?php for ($imagen_a_empezar; $imagen_a_empezar < $imagen_a_terminar; $imagen_a_empezar++): ?>
                            <?php if ($fotos[$imagen_a_empezar]->imagen1): ?>
                            <div class="col-lg-2 hoverEffect"
                                style="margin-bottom:10px; margin-left:-20px; margin-right: 50px">
                                <figure>
                                    <label>
                                        <input type="checkbox" id="identrada" name="identrada[]"
                                            value="<?=$fotos[$imagen_a_empezar]->identrada?>">
                                        <img class="full border"
                                            src="<?=base_url("ver_fotos_ssti") . "/?p=" . $id_protocolo . '&f=' . $fotos[$imagen_a_empezar]->imagen1 . '&c=50&t=1&w=192&h=108'?>"
                                            width="235px" height="154px">
                                    </label>


                                    <button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal"
                                        data-target="#imagemodal" id="ampliar1"
                                        value="<?=$fotos[$imagen_a_empezar]->imagen1?>">1</button>

                                    <?php if ($fotos[$imagen_a_empezar]->imagen2): ?>
                                    <button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal"
                                        data-target="#imagemodal" id="ampliar2"
                                        value="<?=$fotos[$imagen_a_empezar]->imagen2?>">2</button>
                                    <?php endif;?>

                                    <?php if ($fotos[$imagen_a_empezar]->imagen3): ?>
                                    <button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal"
                                        data-target="#imagemodal" id="ampliar3"
                                        value="<?=$fotos[$imagen_a_empezar]->imagen3?>">3</button>
                                    <?php endif;?>

                                    <?php if ($fotos[$imagen_a_empezar]->imagen4): ?>
                                    <button type="button" class="btn btn-primary btn-sm ampliar" data-toggle="modal"
                                        data-target="#imagemodal" id="ampliar4"
                                        value="<?=$fotos[$imagen_a_empezar]->imagen4?>">4</button>
                                    <?php endif;?>

                                </figure>
                            </div>
                            <?php endif;?>
                            <?php endfor;?>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div id="imagemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Imagen ampliada</h4>
                    </div>

                    <div class="modal-body">
                        <img class="imagepreview" style="width: 100%; height:400px">
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

    var eliminados = [];
    var aprobados = [];

    var guardados_aprobados = sessionStorage.getItem('aprobados');
    var guardados_eliminados = sessionStorage.getItem('eliminados');

    if (!guardados_aprobados && !guardados_eliminados) {

        const eliminadas_ant = <?= json_encode($eliminadas) ?> ;
        const imagenes = <?= json_encode($fotos) ?>;

        imagenes.forEach(objeto => {
            aprobados.push(objeto.identrada);
        });

    }

    if (guardados_eliminados && guardados_aprobados) {
        eliminados = JSON.parse(guardados_eliminados);
        aprobados = JSON.parse(guardados_aprobados);

    }

    // Iterar sobre los checkboxes y marcar los seleccionados
    $('input[type="checkbox"]').each(function() {
        var valorCheckbox = $(this).val();
        if (eliminados.includes(valorCheckbox)) {
            $(this).prop('checked', true);
        }
    });

    // Manejar el evento de cambio de los checkboxes
    $('input[type="checkbox"]').on('change', function() {
        var valorCheckbox = $(this).val();
        var index_eliminado = eliminados.indexOf(valorCheckbox);
        var index_aprobado = aprobados.indexOf(valorCheckbox);

        if ($(this).is(':checked')) {
            eliminados.push(valorCheckbox);
            aprobados.splice(index_aprobado, 1);
        } else {
            eliminados.splice(index_eliminado, 1);
            aprobados.push(valorCheckbox);
        }

        // Guardar los valores actualizados en el sessionStorage
        sessionStorage.setItem('eliminados', JSON.stringify(eliminados));
        sessionStorage.setItem('aprobados', JSON.stringify(aprobados));
    });

    $('.confirmar').click(function(e) { 
        e.preventDefault();
        eliminadas_ant = <?= json_encode($eliminados) ?> ;
        let cantidadDescartadas = eliminados.length;


        const ultimo = <?= $imagen_a_empezar ?>;
        let identrada_ultimo = aprobados[ultimo];

        const formulario = document.getElementById('formulario-protocolos');
        var confirmacion = confirm("¿Seguro que desea descartar " + cantidadDescartadas + " de " + <?=$total_imagenes?> + " fotos?");
        if (confirmacion) {
            $('#protocolos_eliminados').val(JSON.stringify(eliminados));
            $('#protocolos_aprobados').val(JSON.stringify(aprobados));
            $('#eliminados_anteriores').val(JSON.stringify(eliminadas_ant));
            $('#ultimo').val(identrada_ultimo);
            // value="<?=$imagen_a_empezar?>"
            formulario.submit();
            sessionStorage.setItem('eliminados', '');
            sessionStorage.setItem('aprobados', '');
        }
    });

    $(".ampliar").on("click", function(e) {
        e.preventDefault();
        var imgSRC = $(this).val();
        $(".imagepreview").attr("src", "<?=base_url('ver_fotos_ssti');?>/?p=<?=$id_protocolo?>&c=50&t=1&w=192&h=108&f=" + imgSRC);
    });

        
    // Manejar el evento de presionar la tecla de flecha izquierda
    $(document).keydown(function(e) {
        if (e.keyCode === 37) { // Flecha izquierda
            e.preventDefault(); // Evitar el comportamiento predeterminado del navegador
            if (<?=$pag_act?> > 1) {
                window.location.href = "?pag=<?=$pag_act - 1?>";
            }
        } else if (e.keyCode === 39) { // Flecha derecha
            e.preventDefault(); // Evitar el comportamiento predeterminado del navegador
            if (<?=$pag_act?> < <?=$pag_ult?>) {
                window.location.href = "?pag=<?=$pag_act + 1?>";
            }
        } else if (e.keyCode === 32) { // Espacio
            e.preventDefault(); // Evitar el comportamiento predeterminado del navegador
            $('input[type="checkbox"]').click(); // Marcar todas las casillas de verificación
        }
    });

    });


</script>