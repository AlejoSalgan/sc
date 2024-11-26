<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
	.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
	.btn-labeled {padding-top: 0;padding-bottom: 0; argin-bottom:10px;}
  .btn-toolbar { margin-bottom:10px; }
</style>

<div class="content-wrapper">
    <div id="cabecera">
      Instalaciones - Ver Grupo
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('solicitudes_instalacion'); ?>"> Solicitudes Instalacion</a> /
        <span class="text-muted">Ver Grupo</span>
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
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detalles</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>ID</td>
                      <td><span class="text-primary"><?=$grupo->id?></span></td>
                    </tr>
                    <tr>
                      <td>Solicitado por</td>
                      <td><?= "<a href=".base_url("verPersonal/{$grupo->solicitado_por}").">" .$grupo->solicitado_name. "</a>"; ?></td>
                    </tr>
                    <tr>
                      <td>Fecha Solicitacion</td>
                      <td><?=date('d/m/Y - H:i:s',strtotime($grupo->fecha_solicitacion))?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informacion</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Proyecto</td>
                      <td><span class="text-primary"><?=$grupo->proyecto ?></span></td>
                    </tr>

                    <tr>
                      <td>Prioridad</td>
                      <td><span class="label label-<?= $grupo->prioridad_label;?>"><?= $grupo->tipo_prioridad;?></span></td>
                    </tr>
                    <tr>
                      <td>Aprobado</td>
                      <td><?= ($grupo->aprobado == 0) ? "NO" : "SI" ;?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
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
               <tr class="info">
								 <th class="text-center">ID</th>
                 <th class="text-center">Tipo de Equipo</th>
                 <th class="text-center">Equipo</th>
                 <th class="text-center">Fecha Limite</th>
                 <th class="text-center">Direccion</th>
                 <th class="text-center">Observacion</th>
								 <th class="text-center">Acciones</th>

               </tr>
               <?php foreach ($ordenes as $orden): ?>
                 <tr>
									 <td class="text-center"><?=$orden->id?></td>
                   <td><?=$orden->tipo_equipo_descrip?></td>
                   <td class="text-center"><?= ($orden->equipo_serie) ? $orden->equipo_serie : "A designar" ;?></td>
                   <td class="text-center"><?= ($orden->fecha_limite) ? date('d/m/Y',strtotime($orden->fecha_limite)) : "A designar" ;?></td>
                   <td><?= ($orden->direccion) ? $orden->direccion : "A designar" ;?></td>
                   <td><?= ($orden->observaciones) ? $orden->observaciones : "Sin observaciones." ;?></td>
									 <td>
											 <a data-toggle="tooltip" title="Eliminar Solicitud" href="<?= base_url('eliminar_solicitud_instalacion/'.$orden->id) ?>"><i class="fa fa-times text-danger"></i>&nbsp;&nbsp;&nbsp;</a>
									 </td>


                 </tr>
               <?php endforeach; ?>
             </table>
           </div>
        </div>
      </div>

    </section>
</div>
