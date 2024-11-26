<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; margin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<div class="content-wrapper">
    <div id="cabecera">
      Verificacion - Control de Verificacion
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Control de Verificacion</span>
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


      <!-- 
      <div class="row">
          <div class="col-md-12 text-right btn-toolbar">
            <a class="btn btn-labeled btn-primary" href="<?=base_url('habilitar_verificacion')?>" role="button"><span class="btn-label"><i class="fa fa-refresh"></i></span>Traer Protocolos</a>
          </div>
        </div>
      -->



      

      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Impactados</h3>
              <span class="pull-right">

              <a class="btn btn-primary btn-xs" href="<?=base_url('copiar_registros_proyecto')?>">Copiar Registros</a>
              </span>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <tr class="text-center info">
                      <td>Cantidad</td>
                      <td>Proyecto</td>
                      <td>Accion</td>
                    </tr>
                    <?php foreach($impactados as $impactado): ?>
                    <tr>
                      <td class="text-center text-primary"><?=$impactado->cantidad?></td>
                      <td><?=$impactado->proyecto?></td>
                      <td><a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Copiar Registros" href="<?= base_url("copiar_registros_proyecto/$impactado->id_municipio") ?>"><i class="fa fa-download"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
           </div>
          </div>
        </div>

        <!--
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informacion</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Equipo</td>
                      <td><?=(!$periferico->id_equipo)? "<span class='text-danger'>A designar</span>" : "<a href=".base_url("verEquipo/{$periferico->id_equipo}").">" . $periferico->EM_serie . "</a>" ;?></td>
                    </tr>
                    <tr>
                      <td>Proyecto</td>
                      <td><?=(!$periferico->proyecto)? "<span class='text-danger'>A designar</span>" : $periferico->proyecto ;?></td>
                    </tr>
                    <tr>
                      <td>Socio</td>
                      <td><?=(!$periferico->socio_descrip)? "<span class='text-danger'>A designar</span>" : $periferico->socio_descrip ;?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>
        -->
      </div>

      

    </section>
</div>
