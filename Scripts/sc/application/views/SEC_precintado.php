<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<style>
  #example2_info {
    position: relative; top: 5px; left: 10px;
  }
  #example2_paginate {
    position: relative; bottom: 10px; left: 10px;
  }
ul.breadcrumb {
  margin: 1px;
  padding: 11px 15px;
  list-style: none;
  background-color: #eee;
}
ul.breadcrumb li {
  display: inline;
  font-size: 15px;
}
ul.breadcrumb li+li:before {
  padding: 8px;
  color: black;
  content: "/\00a0";
}
ul.breadcrumb li a {
  color: #0275d8;
  text-decoration: none;
}
ul.breadcrumb li a:hover {
  color: #01447e;
  text-decoration: underline;
}
  
</style>

<div class="content-wrapper">
  <div id="cabecera">
  		Precintos
  		<span class="pull-right">
  		  <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
          <a href="<?=base_url(''.$accion.'')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>"> <?= $titulo ?></a>
  		  <span class="text-muted">Ver Precintos</span>
  		</span>
  	</div>
    <section class="content">
    	 <div class="row">
              <!-- col-md-12 -->
                  <div class="col-md-12">
                        <?php
                         $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if ($error):?>
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('error'); ?>
                       </div>
                       <?php endif;?>
                       <?php
                        $success = $this->session->flashdata('success');
                         if ($success): ?>
                         <div class="alert alert-success alert-dismissable">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                         
                         <?= $this->session->flashdata('success');?>
                         </div>
                         <?php endif; ?>
                       <!-- row -->
                         <div class="row">
                           <div class="col-md-12">
                             <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');?>
                            </div>
                          </div>
                       <!-- /row -->
                   </div>
               <!-- /col-md-12 --> 
            </div>
   
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <form name="form_precintado" action="<?=base_url('reparaciones/precinto')?>" method="post">
                    <div class="modal-content">
                      <div class="modal-header bg-primary">
                        <h4 class="modal-title text-center"><b><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> Carga de precintado</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
    						 <div class="form-group">
    						 <label for="desde">Desde</label>
                              <input class="form-control" type="number" id="desde" name="desde" min="1" required/>
                             </div>
                             <div class="form-group">
                             <label for="hasta">Hasta</label>
                              <input class="form-control" type="number" id="hasta" name="hasta" />
                             </div>
                          <button type="reset" class="btn btn-danger btn-sm" >Limpiar</button><small class="text-muted">
                          <br>
                          Ingrese el rango de precintos a cargar	
                          </small>
                        </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>	
                      	 </div>
                   	 </div>
                    </form>
                  </div>
                </div>
        
		<div class="row">
           <div class="col-xs-6">
             <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title">Opciones</h3>
               </div><!-- /.box-header -->

				<div class="box-body">
    				<div class="row">
    					<div class="col-md-12">
    						<div class="form-group">
    							<label for="">Seleccione</label>
    							 <form action="<?= base_url('reparaciones/precinto-plantilla')?>">
                                   <button type="button"class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> Carga de precintos</button>
                                   <button class="btn btn-primary btn-lg btn-block" id="excel" type="submit"><i class="fa fa-download" aria-hidden="true"></i></i> Plantilla Excel</button>
                                 </form>				      	
    						</div>
    							<p class="help-block">No ingresar un rango mayor a 500.</p>
    							<p class="help-block">Utilizar el campo DESDE para insertar un solo número de precinto.</p>
    					</div>
    				</div><!-- /.row -->
    				<div class="row">
    					<div class="col-md-12">
    						<div class="form-group">	
    								<!--  -->
    						</div>
    					</div>							
    				</div><!-- /.row -->
				</div>
        		<div class="box-footer">
        		   <!-- FOOTER -->		 	
        		</div>
            </div><!-- /.box -->
           </div>
           
        	<div class="col-xs-6">
               <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Precintos cargados </h3>
                   </div><!-- /.box-header -->
            	  <div class="box-body">
                	<table id="example2" class="table table-bordered table-striped">
                    	<thead>
                        	 <tr>
                            	 <th>Precinto Nº</th>
                                 <th>Estado</th>
                                 <th>Fecha</th>
                                 <th>Acciones</th>
                             </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($precintos as $PR): ?>
                             <tr>
                                 <td><?= $PR->id ?></td>
                                 <td>
                                      <?php switch ($PR->estado) {
                                          case 0: 
                                          case 1: ?>
                                         	 <span class="label label-danger"><?php echo $PR->descripcion?></span>
          							  <?php break;
          							   	  case 2:
          								  case 3: ?>
          									 <span class="label label-primary"><?= $PR->descripcion ?></span>
          							  <?php break;
          								  case 4:
      								  case 5: ?>
          									<span class="label label-success"><?= $PR->descripcion ?></span>
          							  <?php break;
          								  default: ?>
          									<span class="label label-danger">ERROR</span>
          							  <?php break;
          								 } ?> 
                                  </td>
                                  <td><?= $PR->precinto_fecha ?></td>
                                  <td><form action="<?php base_url() ?>precintado" method="post">
                                      	<input type="hidden" name="precinto" value="<?= $PR->id ?>"/>
                                           <?php   if ($PR->estado != 5){ ?>
                                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar Precinto" disabled>
                                            	   <span class="glyphicon glyphicon-remove"></span> 
                                  		  		</button>
                                            <?php  } else { ?>
                                            	<button type="submit" class="btn btn-danger btn-xs" title="Eliminar Precinto" onclick="return deleletconfig()" >
                                              		<span class="glyphicon glyphicon-remove"></span> 
                                  		  		</button>
                                        	<?php  } ?>
                                       </form></td>
                            </tr>
                                <?php endforeach ?>
                         </tbody>
					</table> 
            		 </div>
            		 <div class="box-footer">
        		 		  <!-- FOOTER -->		 	
        			</div>
                 </div><!-- /.box -->
             </div>
        </div>
   </section>
</div>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
  
 
function deleletconfig(){

var del=confirm("¿Está seguro que desea eliminar este Nº de Precinto?");
// if (del==true){
//    alert ("Precinto Eliminado")
// }
return del;
}

  
  
</script>
