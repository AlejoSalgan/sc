<?php
$calibId              = '';
$fecha_alta           = '';
$municipioId          = '';
$descripProyecto      = '';
$idequipo             = '';
$equipoSerie          = '';
$direccion            = '';
$tipo_equipo          = '';
$tipoEquipo           = '';
$Velocidad            = '';
$multicarril          = '';
$tipo_servicio        = '';
$tipo_ver             = '';
$prioridad            = '';
$descripPrioridad     = '';
$fecha_desde          = '';
$fecha_hasta          = '';
$observaciones_gestor = '';
$activo               = '';

if (! empty ( $calibInfo )) {
    foreach ( $calibInfo as $ef ) {
        $calibId              = $ef->id;
        $fecha_alta           = $ef->fecha_alta;
        $municipioId          = $ef->idproyecto;
        $descripProyecto      = $ef->descripProyecto;
        $idequipo             = $ef->idequipo;
        $equipoSerie          = $ef->equipoSerie;
        $direccion            = $ef->direccion;
        $tipo_equipo          = $ef->tipo_equipo;
        $tipoEquipo           = $ef->tipoEquipo;
        $velocidad            = $ef->velocidad;
        $multicarril          = $ef->multicarril;
        $tipo_servicio        = $ef->tipo_servicio;
        $tipo_ver             = $ef->tipo_ver;
        $prioridad            = $ef->prioridad;
        $descripPrioridad     = $ef->descripPrioridad;
        $fecha_desde          = $ef->fecha_desde;
        $fecha_hasta          = $ef->fecha_hasta;
        $observaciones_gestor = $ef->observaciones_gestor;
        $activo               = $ef->activo;
        $observaciones_gestor = $ef->observaciones_gestor;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"><?php echo $tipoItem ?> Solicitud de Calibración</h4> 
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li class="active"><?php echo $tipoItem ?> Solicitud de Calibración</li>
              </ol>
          </div>
      </div>
     </section>

    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-xs-8">
              <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalle</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addSoli" action="<?php echo base_url() ?>agregar_editar_SG" method="post" role="form">
                        <input type="hidden" class="form-control" id="calibId" name="calibId" value="<?php echo $calibId ?>" >
                        <input type="hidden" class="form-control" id="tipoItem" name="tipoItem" value="<?php echo $tipoItem ?>" >
                        <?php if ($tipoItem == "Editar") { ?>
                            <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto" />
                            <input type="hidden" value="<?php echo $idequipo; ?>" name="idequipo" id="idequipo" />
                        <?php } ?>
                      
                        <div class="box-body">
                            <div class="row">                       
                            
                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha de Alta</label>
                                    <div class="input-group">
                                            <span class="input-group-addon" id="fecha_alta"><i class="fa fa-calendar" aria-hidden="true"></i></span> 
                                            <input id="fecha_alta" name="fecha_alta" type="text" class="form-control" aria-describedby="fecha" 
                                            <?php if ($tipoItem == "Agregar") {?>
                                                value="<?=date('d/m/Y')?>" 
                                            <?php } else { ?>
                                                value="<?php echo $fecha_alta?>" 
                                            <?php }
                                              ?>
                                            readonly> 
                                        </div>
                                </div>
                            </div>
                            	<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id">Nº Orden de Servicio</label> 
                                        <input type="text" class="form-control" id="calibId" name="calibId" size="10" 
                                        <?php if ($tipoItem == "Agregar") {?>
                                                value="<?php echo $ordenNro ?>" 
                                            <?php } else { ?>
                                                value="<?php echo $calibId ?>" 
                                            <?php }
                                              ?>
                                            readonly>
                                    </div>
                                </div>
                        </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idproyecto">Proyecto</label>
                                        <?php if ($tipoItem == "Agregar") { ?>
                                            <select class="form-control" id="idproyecto" name="idproyecto" autofocus="">
                                                <option value="0">Seleccionar</option>
                                                <?php
                                                if(!empty($municipios))
                                                {
                                                    foreach ($municipios as $municipio)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $municipio->id ?>"><?php echo $municipio->descrip ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        <?php } else { ?>
                                            <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo $descripProyecto?>" readonly> 
                                            <input type="hidden" value="<?php echo $municipioId; ?>" name="idproyecto" id="idproyecto" />
                                        <?php } ?>
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php if ($tipoItem == "Agregar") { ?>
                                            <label for="idequipo"><i class="fa fa-video-camera" aria-hidden="true"></i> * Equipo serie</label>
                                            <select id="idequipo" name="idequipo[]" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccione los equipos..." data-size="6" required>
                                            </select>
                                        <?php } else { ?>
                                            <label for="equipoSerie"><i class="fa fa-video-camera" aria-hidden="true"></i> Equipo serie</label> 
                                            <input type="text" class="form-control" id="equipoSerie" name="equipoSerie" value="<?php echo $equipoSerie ?>" readonly> 
                                            <input type="hidden" value="<?php echo $idequipo; ?>" name="idequipo" id="idequipo" />
                                        <?php } ?>                                        
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                        <?php if ($tipoItem == "Agregar") {?>
                                            placeholder="Direccion del equipo" 
                                        <?php } else { ?>
                                            value="<?php echo $direccion ?>"
                                        <?php } ?>
                                        readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_equipo">Tipo</label>
                                        <input type="hidden" id="idtipo_equipo" name="tipo_equipo" value="">
                                        <input type="text" class="form-control" id="tipo_equipo" 
                                        <?php if ($tipoItem == "Agregar") {?>
                                            placeholder="Tipo del equipo"  required
                                        <?php } else { ?>
                                            value="<?php echo $tipoEquipo ?>" 
                                        <?php } ?>
                                        readonly>                                        
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="velper">Velocidad permitida</label>
                                        <input type="text" class="form-control" id="velper" name="velper" 
                                        <?php if ($tipoItem == "Agregar") {?>
                                            placeholder="Velocidad permitida del equipo"
                                        <?php } else { ?>
                                            value="<?php echo $velocidad ?>" 
                                        <?php } ?>
                                        readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="multicarril">Carriles</label>
                                        <input type="text" class="form-control" id="multicarril" name="multicarril" 
                                        <?php if ($tipoItem == "Agregar") {?>
                                            placeholder="Carriles" required
                                        <?php } else { ?>
                                            value="<?php echo $multicarril ?>"
                                        <?php } ?>
                                        readonly> 
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_servicio">Tipo de Servicio</label>
                                        <select class="form-control" id="tipo_servicio" name="tipo_servicio">
                                                <option value="0">Seleccionar</option>
                                                <?php
                                                if(!empty($servicios))
                                                {
                                                    foreach ($servicios as $servicio)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $servicio->id ?>" <?php if($servicio->verificacion == $tipo_ver) {echo "selected=selected";} ?>><?php echo $servicio->verificacion ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prioridad">Prioridad</label>
                                        <select class="form-control" id="prioridad" name="prioridad">
                                                <option value="0">Seleccionar</option>
                                                <?php
                                                if(!empty($prioridades))
                                                {
                                                    foreach ($prioridades as $prioridad)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $prioridad->id ?>" <?php if($prioridad->descrip == $descripPrioridad) {echo "selected=selected";} ?>><?php echo $prioridad->descrip ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_desde">Fecha Desde</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            <input id="fecha_desde" name="fecha_desde" type="text" class="form-control" aria-describedby="fecha" 
                                            <?php if ($tipoItem == "Agregar") {?>
                                                placeholder="Elija fecha" required
                                            <?php } else { ?>
                                                value="<?php echo $fecha_desde; ?>"
                                            <?php } ?>
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_hasta">Fecha Hasta</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            <input id="fecha_hasta" name="fecha_hasta" type="text" class="form-control" aria-describedby="fecha" 
                                            <?php if ($tipoItem == "Agregar") {?>
                                                placeholder="Elija fecha" required
                                            <?php } else { ?>
                                                value="<?php echo $fecha_hasta; ?>"
                                            <?php } ?>
                                            >
                                        </div>
                                    </div>
                                </div>                              

                            </div>
                        </div><!-- /.box-body -->                        
                        
                        <div class="box-body">
                            <div class ="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="observaciones_gestor">Observaciones del gestor</label>
                                        <textarea name="observaciones_gestor" id="observaciones_gestor" class="form-control" rows="5" cols="50" style="resize:none"><?php echo $observaciones_gestor; ?> </textarea>
                                    </div>
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->

                        <?php  if ($tipoItem == "Editar") { ?>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="activo">Activo&nbsp;&nbsp;</label> 
                                            <input type="checkbox" id="activo" name="activo" value="1" <?php if($activo == 1) {echo 'checked="checked"';} ?>>
                                            <p style="text-align: center;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                       

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>    
</div>

<script>
    $(function() {

        $('#fecha_desde').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '0',
            language: 'es'
        });

        $('#fecha_hasta').datepicker({
            format: 'dd-mm-yyyy',
            startDate: '0',
            language: 'es'
        });

        $("#tecnico").change(function () {
           $("#tecnico option:selected").each(function () {
                mobile = $(this).data('mobile');
                imei = $(this).data('imei');
                $("#celular").val(mobile);
                $("#imei").val(imei);
            });
        });
       
    });

    $("#idproyecto").change(function () {
        valor = $(this).val();
        $.post("<?=base_url('ordenesb/equiposajax')?>", {proyecto: valor})
        .done(function(data) {
            var result = JSON.parse(data);
            var option = '';
            $("#idequipo").html("");
            var previo = ""; var i = 0;
            result.forEach(function(equipo) {
                if (previo != equipo['descrip']) {
                    previo = equipo['descrip'];
                    option = option + '<optgroup label="'+equipo['descrip']+'">';
                }
                option = option + "<option ";
                if (
                    (equipo['evento_actual'] == 60 && equipo['estado'] == 2 && (equipo['tipo'] == 1 || equipo['tipo'] == 2 || equipo['tipo'] == 400 || equipo['tipo'] == 2402)) || 
                    (equipo['evento_actual'] == 110 && equipo['estado'] == 5 && (equipo['tipo'] == 1 || equipo['tipo'] == 2 || equipo['tipo'] == 400 || equipo['tipo'] == 2402)) || 
                    (equipo['evento_actual'] == 30 && equipo['estado'] == 2 && (equipo['tipo'] == 1 || equipo['tipo'] == 2 || equipo['tipo'] == 400 || equipo['tipo'] == 2402)) || 
                    (equipo['evento_actual'] == 40 && equipo['estado'] == 2 && (equipo['tipo'] == 1 || equipo['tipo'] == 2 || equipo['tipo'] == 400 || equipo['tipo'] == 2402))
                    ) {
                    option = option + 'style="color:DodgerBlue;" ';
                } else {
                    option = option + 'disabled style="color:red;" ';

                }
                option = option + 'value="'+equipo['id']+'">'+equipo['serie']+'</option>';
                if (i+1 >= result.length) {
                    option = option + "</optgroup>";
                } else {
                    if (result[i+1]['descrip'] != equipo['descrip']) {
                        option = option + "</optgroup>";
                    }
                }
                i++;
            });
            $("#idequipo").append(option);
            $('.selectpicker').selectpicker('refresh');
        });
    });

    $('#idequipo').on('change', function() {
		var valor = $(this).val();
		$.post("<?=base_url('equipos/getequipo')?>", {idequipo: valor[0]})
		.done(function(data) {
			var result = JSON.parse(data);
			direccion = result["ubicacion_calle"]+" "+result["ubicacion_altura"]+" "+result["ubicacion_localidad"];
			$("#direccion").val(direccion);
			$("#tipo_equipo").val(result["descrip"]);
			$("#idtipo_equipo").val(result["et_id"]);
			$("#velper").val(result["ubicacion_velper"]);
			if (result["multicarril"]==0) {
				$("#multicarril").val('-');
			} else {
				$("#multicarril").val(result["multicarril"]);
			}
			
		});
	});

    function liveSearch() {

                var input_data = $('#search_data').val();
                if (input_data.length === 0) {
                    $('#suggestions').hide();
                } else {


                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/livesearch/search",
                        data: {search_data: input_data},
                        success: function (data) {
                            // return success
                            if (data.length > 0) {
                                $('#suggestions').show();
                                $('#autoSuggestionsList').addClass('auto_list');
                                $('#autoSuggestionsList').html(data);
                            }
                        }
                    });
                }
            }

            function cargar(param1, param2) {  
                //$('#div_dinamico_anim').html("Hola " + param1); 
                $("#idequipo").val(param1);
                $("#search_data").val(param2);
            }
            
            $('body').on('click', '.solTitle', function() {
                cargar( $(this).attr('rel'), $(this).text() );
                $('#suggestions').hide();

            });
   
</script>