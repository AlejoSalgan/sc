<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
  .etiqueta14{
    font-size: 14px;
  }
</style>


<div class="content-wrapper">
    <div id="cabecera">
      Bajada de memoria - Bajadas realizadas
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">
    </div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    if ($this->session->flashdata('error')): ?>
                      <div class="alert alert-danger alert-dismissable" style="position: relative; bottom: 5px;">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?= $this->session->flashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                <?php
                if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success alert-dismissable" style="position: relative; bottom: 5px; ">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?= $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Fecha</h3>
                </div>

                <form role="form" action="<?= base_url('protocolos_generados') ?>" method="post">

                  <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="idproyecto">Fecha de Bajada</label>
                              <input type="date" class="form-control" id="fecha"  name="fecha" maxlength="6" min="1" value="" required>
                          </div>
                        </div>                       
                    </div>
                  </div>

                  <div class="box-footer">
                      <input type="submit" class="btn btn-primary" value="Buscar" />
                  </div>
                </form>

          </div>
        </div>
      </div>
      <?php if (isset($bajadas)):?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Protocolos</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <tr>
                 <th class="text-center" colspan="7">Bajadas Realizadas el Dia: <span class="text-primary"><?= $fecha?></span></th>
               </tr>
               <tr class="info">
                 <th class="text-center">Id equipo</th>
                 <th class="text-center">Id Municipio</th>
               </tr>
                 <?php foreach ($bajadas as $resultado):?>
                 <tr>
                   <td class="text-center"><span class="label label-primary etiqueta14"><?=$resultado->idequipo?></span></td>
                   <td class="text-center"><?=$resultado->idproyecto?></td>
                 </tr>
               <?php endforeach; ?>
             </table>             
           </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </section>
</div>
