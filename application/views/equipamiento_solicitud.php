<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="row bg-title" style="position: relative; bottom: 15px; ">
    		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    			<h4 class="page-title">Solicitud de provisión</h4> 
    		</div>
    		<div class="text-right">
    			<ol class="breadcrumb" style="background-color: white">
    				<li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
    				<li class="active">Solicitud de provisión de equipamiento</li>
    				
    			</ol>
            </div>
		</div>
	</section>
	<section class="content">
	  <div class="row">
		<!-- left column -->
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">

				<!-- form start -->
				 <form role="form" id="form" action="<?=base_url()?>" method="post">
    				<input type="hidden" name="creadopor" value="<?=$userId?>">
    				
    				<input id="es_equipo" type="hidden" name="es_equipo" value="1">
    				
    				<ul id="navegacion" class="nav nav-tabs">
        	  			<li role="presentation" class="active"><a id="equipo" href="#">Equipo</a></li>
        	  			<li role="presentation"><a id="equipamiento" href="#">Equipamiento</a></li>
    				</ul>
    					<!-- Tipo -->
        					<div class="row" id = "solicitud">
        						<div class="col-md-3 col-md-offset-1">
        							<div class="form-group">
        								<label for="tipo">* Tipo</label>
        								<select id="tipo0" name="tipo1" class="form-control" required>
            								<?php foreach ($equipos_tipos as $equipos_tipos):?>
            									<option value="<?=$equipos_tipos->id?>"><?=$equipos_tipos->descrip?></option>
            								<?php endforeach;?>
        								</select>
        							</div>
        						</div>
        						<div class="col-md-4">	
        							<div class="form-group">
        								<label for="proyecto">* Proyecto</label>
        								<select id="proyecto" name="proyecto" class="form-control" required>
        									<?php foreach ($municipios as $municipio):?>
        									<option value="<?=$municipio->id?>"><?=$municipio->descrip?></option>
        									<?php endforeach;?>
        								</select>
        							</div>
        						</div>
        						<div class="col-md-2">	
        							<div class="form-group">
        								<label for="cantidad">* Cantidad</label>
        								<input class="form-control" id="cantidad" name="cantidad"type="number" min="1" required></input>
        							</div>
        						</div>
        					</div>
        					
        					<div class="row">
            					<div class="col-md-2 col-md-offset-10">	
                            		<div class="form-group">
                            			<label for=""> </label>
                            			<button class="btn btn-default" id="addINPUT" type="button">+</button>
                            			<button class="btn btn-default" id="removeINPUT" type="button" >-</button>
                            		</div>
                            	</div>
        					</div>
        					
        				<div class="row">
        					<div class="col-md-10 col-md-offset-1">	
        						<div class="form-group">
        							<label for="descripcion"> Descripción</label>
        							<textarea style="overflow:auto;resize:none" class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Descripción del evento"></textarea>
        						</div>
        					</div>
        				</div>
    					<!-- ---------------------------------------------------------------------- -->
    					<div class="row">
    						<div class="col-md-10 col-md-offset-1">		
    							<div class="form-group">
    								<button type="reset" class="btn btn-default" value="Reset"><i class="fa fa-times" aria-hidden="true"></i> Restablecer</button>
    								<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
    							</div>
    						</div>
    					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script>
$(document).ready(function() {

	var cont = 0;
	var indName = 1;
	var idNew = 1;
	
	$(".nav a").on("click", function(){
	   $(".nav").find(".active").removeClass("active");
	   $(this).parent().addClass("active");
	});
	$('#navegacion a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		id = $(this).attr('id');
		switch(id) {
 			case "equipo":
 				$("#tipo0").html('');
 	 			if (idNew > 1){
 	 	 			for (i = 0; i < idNew; i++){
 	 	 				$("#"+i).html('');
 	 	 			}
 	 			}
				$("#es_equipo").val("1");
				break;
			case "equipamiento":
				$("#tipo0").html('');
				if (idNew > 1) {
 	 	 			for (i = 0; i < idNew; i++){
 	 	 				$("#"+i).html('');
 	 	 			}
 	 			}
				$("#es_equipo").val("0");
				break;
		}
		$.post("getTipos",{es_equipo: $("#es_equipo").val()}).done(function(data) {
			tipos = JSON.parse(data);// string a  ARRAY de javascript
     		var	cant = tipos.length;
     		for (i = 0; i < cant; i++) { 
     			if ( $("#es_equipo").val() == '1') {
         			descripcion = tipos[i].descrip;
         		} else {
         			descripcion = tipos[i].descripcion;
         		}
                $('#tipo0').append($('<option>',{value: tipos[i], text : descripcion}));
            }
		});
	});
   
 	$("#addINPUT").click(function(){
 		$("#solicitud").clone().attr('id',idNew).insertAfter("#solicitud");
 		$("#tipo"+idNew).attr('name','tipo' + indName);
 		$("#proyecto").attr('proyecto','proyecto' + indName);
 		$("#cantidad").attr('cantidad','cantidad' + indName);
 		idNew++;
 		indName++;
 		
 	 });
	 
	$("#removeINPUT").click(function(){
	    $("#"+idNew).html('');
	    idNew--;
	    indTipo--;
	    
	 });	
});
</script>