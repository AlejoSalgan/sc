<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?=$titulo?></h4>
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li><a href="<?php echo base_url(); ?>fallas"><?=$titulo?></a></li>
                    <li class="active"><?=$subtitulo?></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
    	<div class="box">
    		<div class="box-body">
    			<form action="<?=base_url('ordenes/altaNuevaNovedad')?>" method="post" enctype="multipart/form-data">
    			<div class="row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="equipo">Código de equipo</label>
    							<select id="equipo" name="equipo[]" class="form-control selectpicker" multiple data-live-search="true" title="Seleccione un equipo..." data-size="10" data-max-options="1" required>
    								<?php foreach ($equipos as $equipo):?>
    									<option value="<?=$equipo->id?>"><?=$equipo->serie?></option>
    								<?php endforeach;?>
    							</select>
    					</div>
    				</div>
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="problema">Tipo de problema</label>
    							<select id="problema" name="problema[]" class="form-control selectpicker" multiple data-live-search="true" title="Seleccione un tipo de problema..." data-size="10" data-max-options="1" required>
    								<option value="0" default>Seleccione un tipo de problema...</option>
    								<?php foreach ($fallas as $falla):?>
    									<option value="<?=$falla->id?>"><?=$falla->descrip?></option>
    								<?php endforeach;?>
    							</select>
    					</div>
    				</div>
    			</div>
    			<div class="row">
    				<div class="col-md-12">
    					<div class="form-group">
    						<label for="observ">Observación</label>
    							<textarea id="observ" name="observ" rows="3" class="form-control" style="resize: none;" placeholder="Ingrese una observación..." required></textarea>
    					</div>
    				</div>
    			</div>
    			<div class="row">
    				<div class="col-md-12">
    					<div class="form-group">
    						<label for="observ">Archivos de imágenes:</label>
    						<input type="hidden" name="MAX_FILE_SIZE" value="1048576"> 
    						<input name="archivos[]" type="file" multiple/>
    						<p class="help-block">Puede subir archivos de <strong>imágenes JPG</strong> de hasta <strong>1024 KBs (1 MB)</strong>.</p>
    					</div>
    				</div>
    			</div>
    			
    			
    			
    			<div class="row">
    				<div class="col-md-12">
    					<button class="btn btn-success" type="submit">Guardar novedad</button> <button class="btn btn-danger" type="reset">Limpiar formulario</button>
    				</div>
    			</div>
    			</form>
    		</div>
    	</div>
    </section>
</div>
