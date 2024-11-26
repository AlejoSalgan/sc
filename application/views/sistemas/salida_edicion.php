<?php 



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
        </div>                
    </section>
</div>
<script>


       
    $(document).ready(function() {

    

    });


</script>