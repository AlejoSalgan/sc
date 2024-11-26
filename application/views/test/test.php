<?php 
    // if(!ambient()){
    //   $var1 = "ENTRA EN METODO DESARROLLO";
    // }else{
    //   $var1 = "NO ENTRA";
    // }
      
    $var1 = phpinfo(); exit;
?>


<style type="text/css">
  #columna{
    overflow: auto;
    height: 320px; /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
  }

  #infor{
    color: black;
  }

  #chartdiv {
    width: 100%;
    height: 250px;
  }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">Ambiente test <b> Para Desarrollo</b></div>
  
  <section class="content">
  <?php var_dump($var1); ?>

  </section>

</div>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


