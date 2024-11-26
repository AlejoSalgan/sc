<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/listpermisos.php';

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
  <div id="cabecera">
   Protocolos - Protocolos Desencriptando
   <span class="pull-right">
     <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
     <span class="text-muted">Protocolos Desencriptando</span>
   </span>
 </div>

    <section class="content">
      <div class="row">
          <div class="col-md-12">
              <?php
              $this->load->helper('form');
              if ($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('error'); ?>
                  </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
              <?php endif; ?>
          </div>
      </div>

      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h1 class="box-title">
                      Total:<b><a href="javascript:void(0)"> </a></b>
                  </h1>



              </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-bordered table-hover">
                        <tr class="info">
                          <th class="text-center">Protocolo</th>
                          <th class="text-center">Decripto</th>
                          <th class="text-center">Equipo</th>
                          <th class="text-center">Cantidad</th>
                          <th class="text-center">Error</th>
                          <th class="text-center">Fecha</th>
                        </tr>

                        <tbody id="DataResult"></tbody>

                      </table>

                    </div><!-- /.box-body -->

            </div><!-- /.box -->

            <p></p>
          </div>
      </div>
    </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
      setTimeout(fetchDecriptos, 1000)

      function fetchDecriptos() {
          $.ajax({
              url: "<?=base_url('protocolos_decripto')?>",
              success: function(data) {
                imagenes = JSON.parse(data);
                var html = '';
                var i;
                for (i = 0; i < imagenes.length; i++) {
                  html += '<tr>' +
                    '<td class="text-center"><p class="label label-primary" style="color:white; font-size:16px;">' + imagenes[i]['id_protocolo'] + '</p></td>' +
                    '<td class="text-center">' + imagenes[i]['decripto'] + '</td>' +
                    '<td><a href="' + baseURL + 'verEquipo/' + imagenes[i]['id'] + '">'+ imagenes[i]['equipo_serie'] +'</a><br/><span class="text-muted"><small>' +  imagenes[i]['descrip'] + '</small></span></td>' +
                    '<td>' + imagenes[i]['cantidad'] + '</td>';

                    if (imagenes[i]['error_descrip']) {
                      html += '<td><strong>' + imagenes[i]['error_descrip'] + '</strong><br> <strong><span class="text-danger">' +  imagenes[i]['error_cantidad'] + '</span></strong>';
                      if (imagenes[i]['error_cantidad'] == 1) {
                        html += ' Registro con error.</td>';
                      } else {
                        html += ' Registros con errores.</td>';
                      }
                    } else {
                      html += '<td>-</td>';
                    }

                    if (imagenes[i]['fecha']) {
                      html += '<td>' + imagenes[i]['fecha'] + '</td>';
                    } else {
                      html += '<td>-</td>';
                    }

                    html += '</tr>';
                }
                $('#DataResult').html(html);
                setTimeout(fetchDecriptos, 5000)

              }
          })
      }

    });



</script>
