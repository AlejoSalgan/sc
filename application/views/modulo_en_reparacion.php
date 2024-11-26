<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

$INGcero = explode(',', $ingreso_cero);

if(empty($criterio)){
  $criterio = 0;
}
?>

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }

  .etiqueta13{
    font-size: 13px;
  }

  /* Estilos adicionales para mejorar la azpariencia */
  .content-wrapper {
    padding: 20px;
  }

  #cabecera {
    background-color: #f5f5f5;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
  }

  .fa-home {
    text-decoration: none;
    color: #337ab7;
  }

  .fa-home:hover {
    color: #23527c;
  }

  .text-muted {
    color: #777;
  }

  .content {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
  }

  .col-xs-12 {
    padding: 20px;
    text-align: center;
    font-size: 24px;
  }

  .fa-wrench {
    font-size: 36px;
    margin-left: 10px;
  }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Modulo en Reparacion ...
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
  		  <span class="text-muted">titulo</span>
  		</span>
  	</div>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
            Programadores Trabajando <i class="fa fa-wrench"></i>
            </div>
        </div>
    </section>
</div>
