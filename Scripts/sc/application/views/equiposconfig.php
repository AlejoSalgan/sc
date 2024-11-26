<script>
$( document ).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();

	$('input:checkbox').click(function(event) {
		if ($("label[for='"+$(this).attr("id")+"']").css("color") == "rgb(218, 165, 32)") {
			if ($(this).is(":checked")) {
				event.preventDefault();
			}
		}
	});
});
</script>
<?php $cant = count($config); $newline = TRUE; $ulttipo = 0;?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>COMPONENTES EQUIPO <strong><?=$serie?></strong>
        <small>Asignación</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
         	<div class="col-xs-12">
                 <div class="text-right"  >
                      <ol class="breadcrumb" style="background-color: transparent">
                        <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                        <li><a href="<?=base_url('equiposListing')?>">Equipos listado</a></li> 
                        <li class="active">Asignar componente</li>
                      </ol>          
                 </div>
             </div>
        </div>
    <?php if ($mensaje):?>
    <?=$mensaje?>
    <?php else:?>
    <form role="form" action="<?php echo base_url();?>guardarAsigComp" method="post">
			<?php for ($i=1; $i<=$cant; $i++):
			$cont = $i-1; if ($ulttipo != $config[$cont]->id_comp_tipo) {$j=1; $ulttipo = $config[$cont]->id_comp_tipo;} else {$j++;}?>
				<?php if ($newline):?>
				<div class="row">
				<?php $newline = FALSE;?>
				<?php endif;?>
					<div class="col-md-3">
						<div class="form-group">
						<?php if ($config[$cont]->seriado):?>
								<label <?=$config[$cont]->existe?$config[$cont]->disponibles?'':'style="color: GoldenRod;"':'style="color: #d9534f;"'?> for="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" data-toggle="tooltip" data-placement="top" <?=$config[$cont]->existe?$config[$cont]->disponibles?'':'title="Hay camponentes de este tipo, pero están asignados a otros equipos"':'title="No hay camponentes de este tipo cargados en el sistema"'?>><?=$config[$cont]->ct_descrip?></label>
								<select name="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" type="text" class="form-control" id="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" <?=$config[$cont]->existe?'':'disabled'?>>
									<option value="0"></option>
									<?php foreach ($config[$cont]->comps as $row):?>
									<option value="<?=$row->idcomponente?>" <?=$row->serie==$config[$cont]->comps_asig[$j-1]->serie?'selected':''?>><?=$row->serie?></option>
									<?php endforeach;?>
								</select>
		  				<?php else:?>
								<label <?=$config[$cont]->existe?$config[$cont]->disponibles?'':'style="color: GoldenRod;"':'style="color: #d9534f;"'?> for="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" data-toggle="tooltip" data-placement="top" <?=$config[$cont]->existe?$config[$cont]->disponibles?'':'title="Hay camponentes de este tipo, pero están asignados a otros equipos"':'title="No hay camponentes de este tipo cargados en el sistema"'?>><?=$config[$cont]->ct_descrip?></label>
								<input id="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" name="c_<?=$config[$cont]->id_comp_tipo?>_<?=$cont?>" type="checkbox" value="noserie" <?=$config[$cont]->existe?'':'disabled'?> <?=($j<=$config[$cont]->cant)?'checked':''?>>
						<?php endif;?>
						</div>
					</div>
					<?php if ($i%4==0):
					$newline = TRUE;?>
				</div>
				<?php endif;?>
			<?php endfor;?>
			<input name="idequipo" type="hidden" value="<?=$idequipo?>">
			<input name="idmodelo" type="hidden" value="<?=$idmodelo?>">
			
			<div class="col-md-12">
    				<button type="reset" class="btn btn-danger">Restablecer</button>
    				<button type="submit" class="btn btn-primary">Guardar</button>
			</div>
	</form>
	<?php endif;?>
	</section>
</div>