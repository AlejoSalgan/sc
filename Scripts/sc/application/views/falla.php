<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reporte Equipo <b><?=$falla->rm_serie?></b>
      </h1>
      
      <div class="row">		
        <div class="col-xs-12">
             <div class="text-right"  >
                  <ol class="breadcrumb" style="background-color: transparent">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li><a href="<?=base_url('fallas')?>">Reporte fallas</a></li> 
                    <li class="active">Ver reporte</li>
                  </ol>          
             </div>
         </div>   
      </div>           
      
    </section>
    <section class="content">
    
	<div class="box">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#reporte" aria-controls="reporte" role="tab" data-toggle="tab">Reporte</a></li>
	<?php if ($imagenes):?>
	<li role="presentation"><a href="#imagenes" aria-controls="imagenes" role="tab" data-toggle="tab">Imágenes</a></li>
	<?php endif;?>
	<?php if ($abiertas):?>
	<li role="presentation"><a href="#ordenes" aria-controls="ordenes" role="tab" data-toggle="tab">Órdenes abiertas del equipo</a></li>
	<?php endif;?>
	</ul>
	<div class="box-body">
	<!-- Tab panes -->
	
	
	<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="reporte">
			<div class="row">

            </div>     
                 
			<div class="row">			
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="rm_id">Reporte Nº</label>
						<input id="rm_id" type="text" class="form-control" value="<?=$falla->rm_id;?>" readonly>
					</div>
	        	</div>
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="rm_serie">Código de equipo</label>
						<input id="rm_serie" type="text" class="form-control" value="<?=$falla->rm_serie?>" readonly>
					</div>
	        	</div>
				<div class="col-md-4">
	        		<div class="form-group">
						<label for="mu_descrip">Proyecto</label>
						<input id="mu_descrip" type="text" class="form-control" value="<?=$falla->mu_descrip;?>" readonly>
					</div>
	        	</div>
	        </div>
			<div class="row">
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="u_name">Reportado por</label>
						<input id="u_name" type="text" class="form-control" value="<?=$falla->u_name;?>" readonly>
					</div>
	        	</div>
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="r_role">Sector</label>
						<input id="r_role" type="text" class="form-control" value="<?=$falla->r_role;?>" readonly>
					</div>
	        	</div>
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="p_descrip">Puesto</label>
						<input id="p_descrip" type="text" class="form-control" value="<?=$falla->p_descrip;?>" readonly>
					</div>
	        	</div>
	        </div>
   			<div class="row">
   				<div class="col-md-4">
	        		<div class="form-group">
						<label for="re_fecha">Fecha del reporte</label>
						<input id="re_fecha" type="text" class="form-control" value="<?=date('d/m/Y H:i:s',strtotime($falla->re_fecha));?>" readonly>
					</div>
	        	</div>
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="fm_descrip">Tipo de falla</label>
						<input id="fm_descrip" type="text" class="form-control" value="<?=$falla->fm_descrip;?>" readonly>
					</div>
	        	</div>
	        	<div class="col-md-4">
	        		<div class="form-group">
						<label for="mo_descrip">Motivo</label>
						<input id="mo_descrip" type="text" class="form-control" value="<?=$falla->mo_descrip;?>" readonly>
					</div>
	        	</div>
	        </div>
	       <div class="row">
   				<div class="col-md-12">
   					<div class="form-group">
						<label for="re_observ">Observaciones</label>
						<textarea style="resize: none;" id="re_observ" class="form-control" rows="3" readonly><?=$falla->re_observ;?></textarea>
					</div>
	        	</div>
	        </div>
		</div>
		<?php if ($imagenes):?>
		<div role="tabpanel" class="tab-pane fade" id="imagenes">
  	       <div class="row">
   				<div class="col-md-6 col-md-offset-3">
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
						  <ol class="carousel-indicators">
  							<?php $cant = count($imagenes);
  							for ($i = 0; $i < $cant; $i++):?>
						    <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" <?=($i == 0)?'class="active"':''?>></li>
						    <?php endfor;?>
						  </ol>
						
						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
							<?php $i = 1; foreach ($imagenes as $imagen):?>
						    <div class="item <?=($i == 1)?'active':''?>">
						      <img class="img-responsive center-block" src="<?=base_url()."img_reportes/{$imagen->nombre_archivo}"?>" alt="imagen<?=$i?>">
						      <div class="carousel-caption">
						        Imagen <?=$i?>
						      </div>
						    </div>
							<?php $i++; endforeach;?>
						  </div>
						
						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						    <span class="sr-only">Previa</span>
						  </a>
						  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						    <span class="sr-only">Siguiente</span>
						  </a>
						</div>
				</div>
			</div>
		</div>
		<?php endif;?>
		<?php if ($abiertas):?>
		<div role="tabpanel" class="tab-pane fade" id="ordenes">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
    					<tr><th>Órdenes abiertas de este equipo</th></tr>
        			</thead>
					<tbody style="font-size: 20px;">
        			<?php foreach ($abiertas as $abierta):
                    			switch ($abierta->tipo) {
                    			    case 'R':
                    			        $tipo = 'reparaciones';
                    			        break;
                    			    case 'M':
                    			        $tipo = 'mantenimiento';
                    			        break;
                    			    case 'I':
                    			        $tipo = 'instalaciones';
                    			        break;
                    			}
                    ?>
						<tr>
        					<td><strong></strong><a href="<?=base_url(($abierta->ultimo_estado==2?"ver-solicitud":"ver-orden")."/{$abierta->id}?ref={$tipo}/ordenes")?>"><?=$abierta->id?></a></strong></td>
      					</tr>
        			<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<?php endif;?>
		</div>
	</div>
    </section>
</div>