<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/estilo_tablas.css'); ?>">

<div class="content-wrapper">
     <div id="cabecera">
      Bajada de memoria - Tecnicos
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Tecnicos</span>
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
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detalles</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <thead>
                 <tr class="info">
                   <th class="text-center">ID</th>
                   <th class="text-center">Nombre y apellido</th>
                   <th class="text-center">Telefono</th>
                   <th class="text-center">IMEI</th>
                   <?php if (in_array($userId, array(27,103,105,140,219))):?>
                     <th class="text-center">Liberado</th>
                   <?php endif; ?>
                   <th class="text-center">Acciones</th>
                 </tr>
               </thead>

               <?php foreach ($userRecords as $tecnico):?>
                 <tr>
                   <td class="text-center"><?=$tecnico->userId?></td>
                   <td><?= "<a href=".base_url("verPersonal/{$tecnico->userId}").">" .$tecnico->name. "</a>"; ?></td>
                   <td class="text-center"><?= ($tecnico->mobile == NULL) ? "<span class='text-danger'> A designar </span>" : $tecnico->mobile ;  ?></td>
                   <td class="text-center"><?= ($tecnico->imei == NULL) ? "<span class='text-danger'> A designar </span>" : $tecnico->imei ;  ?></td>
                   <?php if (in_array($userId, array(27,103,105,140,219))):?>
                     <td class="text-center <?= ($tecnico->liberado == 1) ? 'text-success' : 'text-danger' ; ?>"><?= ($tecnico->liberado == 1) ? 'SI' : 'NO' ; ?></td>
                   <?php endif; ?>
                   <td>
                     <?php if ($tecnico->imei != NULL): ?>
                       <a class="btn btn-danger btn-xs" data-toggle="tooltip" title="Limpiar Celular" href="#" data-celularid="<?php echo $tecnico->imei; ?>" class="limpiarCelular"><i class="fa fa-trash"></i></a>
                     <?php endif; ?>

                     <?php if (in_array($userId, array(27,103,105,140,219)) && $tecnico->imei != NULL):?>
                       <a class="btn btn-<?= ($tecnico->liberado == 1) ? 'danger' : 'success' ; ?> btn-xs" data-toggle="tooltip" title="<?= ($tecnico->liberado == 1) ? 'Bloquear telefono' : 'Liberar telefono' ; ?>" href="<?= base_url("liberar_bajada/$tecnico->userId/$tecnico->liberado") ?>">&nbsp;<i class="fa fa-lock"></i>&nbsp;</a>
                     <?php endif?>
                   </td>
                 </tr>
               <?php endforeach; ?>
             </table>
           </div>
        </div>
      </div>

    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/ordenesb.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>
