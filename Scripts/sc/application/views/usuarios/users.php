<?php
  //1. User 2.Empleado
  $tipoUser = $this->uri->segment(4);//segundo param

  if(empty($criterio)){
  $criterio = 0;
}

?>

<style>
  #example2_info {
    position: relative; top: 5px; left: 680px;
  }

  #example2_paginate {
    position: relative; bottom: 20px; right: 440px;
  }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <?php switch ($filtro):
                    case 1:?>
                		<h4 class="page-title">Usuarios</h4>
              <?php break;
                    case 2:?>
                    	<h4 class="page-title">Empleados</h4>
              <?php break;
                    default:?>
                        echo
              <?php break;
                    endswitch;?>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <?php switch ($filtro):
                    case 1:?>
                		 <li class="active">Usuarios</li>
                  <?php break;
                        case 2:?>
                         <li class="active">Empleados</li>
                  <?php break;
                        default:?>
                            echo
                  <?php break;
                        endswitch;?>
              </ol>
          </div>
      </div>
    </section>
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
        <?php
        if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?= $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                
                <?php if ($roleUser == ROLE_SUPERADMIN): ?>
    					      <?php switch ($filtro):
    					            case 1:?>
    					                <a class="btn btn-primary" href="<?= base_url(); ?>agregar_usuario">Agregar Usuario</a>
    					      <?php break;
    					            case 2:?>
    					                <a class="btn btn-primary" href="<?= base_url(); ?>agregar_empleado">Agregar Empleado</a>
    					      <?php break;
    					            default:?>
    					                <a class="btn btn-primary" href="<?= base_url(); ?>agregar_usuario">Agregar Empleado</a>
                              <a class="btn btn-primary" href="<?= base_url(); ?>agregar_empleado">Agregar Usuario</a>
    					      <?php break;
    					            endswitch;?>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <?php switch ($filtro):
                          case 1:?>
                              <h3 class="box-title">Listado</h3>
                    <?php break;
					                case 2:?>
					          		      <h3 class="box-title">Listado</h3>
			              <?php break;
					                default:?>
					          		     <h3 class="box-title">Empleados/Usuarios listado</h3>
				            <?php break;
					                endswitch;?>

                    <div class="box-tools">
                        <form action="<?= base_url() ?>userListing/0/<?= $filtro;//segundo param ?>" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?= $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar"/>
                              <select class="form-control pull-right" id="criterio" name="criterio" style="width: 100px; height: 30px;">
                                  <option value="0" <?php if($criterio == 0) {echo "selected=selected";} ?>>Todos</option>
                                  <?php if ($roleUser == ROLE_SUPERADMIN): ?>
                                      <option value="1" <?php if($criterio == 1) {echo "selected=selected";} ?>>ID</option>
                                    
                                  <?php endif; ?>
                                  <option value="2" <?php if($criterio == 2) {echo "selected=selected";} ?>>Nombre</option>
                                  <option value="3" <?php if($criterio == 3) {echo "selected=selected";} ?>>Apellido</option>
                                  <?php if ($filtro == 1): ?>
                                      <option value="4" <?php if($criterio == 4) {echo "selected=selected";} ?>>Correo</option>
                                      <option value="5" <?php if($criterio == 5) {echo "selected=selected";} ?>>Sede</option>
                                      <option value="6" <?php if($criterio == 6) {echo "selected=selected";} ?>>Interno</option>
                                  <?php endif; ?>
                                  <option value="7" <?php if($criterio == 7) {echo "selected=selected";} ?>>Celular</option>
                                  <option value="8" <?php if($criterio == 8) {echo "selected=selected";} ?>>Rol</option>
                              </select>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <?php if ($roleUser == ROLE_SUPERADMIN): ?>
                          <th>ID</th>
                      <?php endif; ?>
                      <th>Apellido y Nombre</th>
                      <?php if ($filtro == 1): ?>
                        <th>Correo Electrónico</th>
                        <th>Nº Interno</th>
                      <?php endif; ?>
                      <?php if($filtro == 2 && $roleUser == ROLE_SUPERADMIN){ //1. Usuario ?>
                        <th>Supervisor Responsable</th>
                      <?php } ?>
                      <th>Celular</th>
                      <?php if ($roleUser == ROLE_SUPERADMIN): ?>
                          <th>Acciones</th>
                      <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($userRecords as $record): ?>
                          <tr>
                        
                            
                            <?php if ($roleUser == ROLE_SUPERADMIN): ?>
                              <td method="post"  class="form-group" name='userId'><?= $record->userId ?></td>
                            <?php endif; ?>
                        <td><?= "<a href=".base_url("verPersonal/{$record->userId}").">" . $record->apellido." ".$record->nombre . "</a>"; ?>
                            <br/><span class="text-muted"><small><?= $record->role ?></small></span>
                        </td>
                        <?php if ($filtro == 1): ?>
                          <td><?= $record->email ?></td>
                          <td><span class="text-center"> <?= ($record->interno != 0) ? $record->interno : "A designar" ?> </span>
                              <br/><span class="text-muted"><small> <?= ($record->sede_descrip != NULL) ? $record->sede_descrip : "A designar" ?>
                              </small></span></td>
                          </td>
                        <?php endif; ?>

                        <?php if ($filtro == 2 && $roleUser == ROLE_SUPERADMIN): ?>
                          <td><?= $record->email ?></td>
                        <?php endif; ?>
                        <td><?= $record->mobile ?></td>

                        <?php if ($roleUser == ROLE_SUPERADMIN): //2. Empleado  ?>
                        <td>
                          <?php if ($filtro == 1): //1. Usuario ?>
                              <a data-toggle="tooltip" title="Editar Usuario" href="<?= base_url().'editar_usuario/'.$record->userId; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                          <?php endif; ?>

                        <?php if ($filtro == 2): //2. Empleado  ?>
                            <a data-toggle="tooltip" title="Editar Empleado" href="<?= base_url().'editar_empleado/'.$record->userId; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php endif; ?>

                        <?php if ($filtro == 2): //2. Empleado  ?>
                          <a data-toggle="tooltip" title="Eliminar" href="#" data-userid="<?= $record->userId; ?>" class="deleteUser"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php endif; ?>

                        <?php if ($filtro == 2): //2. Empleado  ?>
                          <a data-toggle="tooltip" title="Solicitudes APP" href="<?= base_url().'solicitudes_app/'.$record->userId; ?>"><i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;</a>
                        <?php endif; ?>
                        

                          <?php if (($name == "Francisco Araujo" || $name == "Ignacio Gutt" || $name == "Cristian Rudzki" || $name == "Leonel Gutt" || $name == "Carlos Javier Hazañas" || $name == "Emmanuel Lencina") && $filtro == 1): //2. Empleado  ?>
                          
                            <a data-toggle="tooltip" title="Permisos" href="<?= base_url().'ver_permisos/'.$record->userId; ?>"><i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;</a>
                             
                              <!-- aca va un if que solo podemos usar nosotros 4 y francisco-->
                              
                            <?php endif; ?>

                              
                              <?php if (in_array($vendorId, array(275,276,105,68,27))): ?>  
                              <form action="<?=base_url('password_random') ?>" method="POST">
                                  <input type="hidden" name="usuarioId" value="<?= $record->userId ?>">
                                  <button type="submit" class="fa fa-lock "></button>
                              </form> 
                              <?php endif; ?>
                          </td>
                        
                      <?php endif; ?>

                      </tr>
                      <?php endforeach; ?>
                      
                    </tbody>
                  </table>
                </div>

            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
