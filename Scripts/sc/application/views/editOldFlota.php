<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

<?php

$flotaId        = "";
$dominio        = "";
$movilnro       = "";
$marca          = "";
$motor          = "";
$chasis         = "";
$modelo         = "";
$anio           = "";
$propietarioId  = "";
$destinoId      = "";
$idchofer1      = "";
$idchofer2      = "";
$idproyecto     = "";
$segmento       = "";

$nro_poliza         = "";
$tipo_poliza        = "";
$fecha_autoparte    = "";
$venc_cedulaverde   = "";
$venc_seguro        = "";
$venc_vtv           = "";
$venc_matafuego     = "";
$venc_cert_hidro    = "";
$venc_ruta          = "";
$responsableId      = "";
$acc_kit            = "";
$acc_cargador       = "";
$acc_conos          = "";
$acc_chalecos       = "";

if(!empty($flotaInfo))
{
    foreach ($flotaInfo as $ef)
    {
        $flotaId        = $ef->id;
        $dominio        = $ef->dominio;
        $movilnro       = $ef->movilnro;
        $marca          = $ef->marca;
        $modelo         = $ef->modelo;
        $motor          = $ef->motor;
        $chasis         = $ef->chasis;
        $anio           = trim($ef->anio);
        $propietarioId  = $ef->propietario;
        $destinoId      = $ef->destino;
        $idchofer1      = $ef->idchofer1;
        $idchofer2      = $ef->idchofer2;
        $idproyecto     = $ef->idproyecto;
        $segmento       = trim($ef->segmento);

        $nro_poliza         = trim($ef->nro_poliza);
        $tipo_poliza        = trim($ef->tipo_poliza);
        $fecha_autoparte    = $ef->fecha_autoparte;
        $venc_cedulaverde   = $ef->venc_cedulaverde;
        $venc_seguro        = $ef->venc_seguro;
        $venc_vtv           = $ef->venc_vtv;
        $venc_matafuego     = $ef->venc_matafuego;
        $venc_cert_hidro    = $ef->venc_cert_hidro;
        $venc_ruta          = $ef->venc_ruta;
        $responsableId      = $ef->responsable;
        $acc_kit            = $ef->acc_kit;
        $acc_cargador       = $ef->acc_cargador;
        $acc_conos          = $ef->acc_conos;
        $acc_chalecos       = $ef->acc_chalecos;
    }
} 

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Flota
        <small>Modificar Vehículo</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="row">
                 	<div class="col-xs-12">
                         <div class="text-right"  >
                              <ol class="breadcrumb" style="background-color: transparent">
                                <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                                <li><a href="javascript:history.go(-1)">Flota listado</a></li>
                                <li class="active">Editar flota</li>
                              </ol>          
                         </div>
                     </div>
                </div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Detalles del Vehículo</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editFlota" method="post" id="editFlota" role="form">
                        <input type="hidden" value="<?php echo $flotaId; ?>" name="flotaId" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="dominio"><i class="fa fa-square" aria-hidden="true"></i> Dominio</label>
                                            <input type="text" class="form-control" id="dominio" name="dominio" value="<?php echo $dominio; ?>" maxlength="7">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="movilnro"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> Móvil nro</label>
                                            <input type="number" class="form-control" id="movilnro" name="movilnro" value="<?php echo $movilnro; ?>" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="marca">Marca</label>
                                            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $marca; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $modelo; ?>">
                                </div>
                            </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="motor">Numero de Motor</label>
                                            <input type="text" class="form-control" id="motor" name="motor" value="<?php echo $motor; ?>" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                <div class="form-group">
                                    <label for="chasis">Numero de Chasis</label>
                                    <input type="text" class="form-control" id="chasis" name="chasis" value="<?php echo $chasis; ?>" maxlength="50">
                                </div>
                            </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                     <select class="form-control" id="anio" name="anio">
                                        <option value="0">Seleccionar</option>
                                        <option value="2008" <?php if($anio == "2008") {echo "selected=selected";} ?>>2008</option>
                                        <option value="2009" <?php if($anio == "2009") {echo "selected=selected";} ?>>2009</option>
                                        <option value="2010" <?php if($anio == "2010") {echo "selected=selected";} ?>>2010</option>
                                        <option value="2011" <?php if($anio == "2011") {echo "selected=selected";} ?>>2011</option>
                                        <option value="2012" <?php if($anio == "2012") {echo "selected=selected";} ?>>2012</option>
                                        <option value="2013" <?php if($anio == "2013") {echo "selected=selected";} ?>>2013</option>
                                        <option value="2014" <?php if($anio == "2014") {echo "selected=selected";} ?>>2014</option>
                                        <option value="2015" <?php if($anio == "2015") {echo "selected=selected";} ?>>2015</option>
                                        <option value="2016" <?php if($anio == "2016") {echo "selected=selected";} ?>>2016</option>
                                        <option value="2017" <?php if($anio == "2017") {echo "selected=selected";} ?>>2017</option>
                                        <option value="2018" <?php if($anio == "2018") {echo "selected=selected";} ?>>2018</option>
                                        <option value="2019" <?php if($anio == "2019") {echo "selected=selected";} ?>>2019</option>
                                        <option value="2020" <?php if($anio == "2020") {echo "selected=selected";} ?>>2020</option>
                                        <option value="2021" <?php if($anio == "2021") {echo "selected=selected";} ?>>2021</option>
                                    </select>
                            </div> 
                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                <div class="form-group">
                                    <label for="segmento"><i class="fa fa-car" aria-hidden="true"></i> Segmento</label>
                                    <select class="form-control" id="segmento" name="segmento" >
                                        <option value="0">Seleccionar</option>
                                        <option value="Auto" <?php if($segmento == "Auto") {echo "selected=selected";} ?>>Auto</option>
                                        <option value="Grúa" <?php if($segmento == "Grúa") {echo "selected=selected";} ?>>Grúa</option>
                                        <option value="Pick Up" <?php if($segmento == "Pick Up") {echo "selected=selected";} ?>>Pick Up</option>
                                        <option value="Utilitario" <?php if($segmento == "Utilitario") {echo "selected=selected";} ?>>Utilitario</option>
                                    </select>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="propietario"><i class="fa fa-briefcase" aria-hidden="true"></i> Propietario</label>
                                            <select class="form-control required" id="propietario" name="propietario">
                                            <option value="0">Seleccionar Propietario</option>
                                            <?php
                                            if(!empty($propietarios))
                                            {
                                                foreach ($propietarios as $propietario)
                                                {
                                                    ?>
                                                    <option value="<?php echo $propietario->id ?>" <?php if($propietario->id == $propietarioId) {echo "selected=selected";} ?>><?php echo $propietario->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label for="destino"><i class="fa fa-list-ul" aria-hidden="true"></i> Destino</label>
                                            <select class="form-control" id="destino" name="destino">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($destinos))
                                            {
                                                foreach ($destinos as $destino)
                                                {
                                                    ?>
                                                    <option value="<?php echo $destino->id ?>" <?php if($destino->id == $destinoId) {echo "selected=selected";} ?>><?php echo $destino->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="text-center">
                                <div class="form-group">
                                <label for="chofer1"><i class="fa fa-male" aria-hidden="true"></i> Chofer 1</label>
                                    <select class="form-control" id="chofer1" name="chofer1">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($empleados))
                                            {
                                                foreach ($empleados as $empleado)
                                                {
                                                    ?>
                                                    <option value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $idchofer1) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                                </div>
                                <div class="col-md-6">                             
                                    <div class="text-center">
                                <div class="form-group">
                                <label for="chofer2"><i class="fa fa-male" aria-hidden="true"></i> Chofer 2</label>
                                    <select class="form-control" id="chofer2" name="chofer2">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($empleados))
                                            {
                                                foreach ($empleados as $empleado)
                                                {
                                                    ?>
                                                    <option data-mobile="<?php echo $empleado->mobile ?>" data-imei="<?php echo $empleado->imei ?>" value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $idchofer2) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                              
                                    <div class="text-center">
                                <div class="form-group">
                                <label for="proyecto"><i class="fa fa-map-marker" aria-hidden="true"></i> Proyecto</label>
                                    <select class="form-control required" id="proyecto" name="proyecto">
                                            <option value="0">Seleccionar Proyecto</option>
                                            <?php
                                            if(!empty($municipios))
                                            {
                                                foreach ($municipios as $proyecto)
                                                {
                                                    ?>
                                                    <option value="<?php echo $proyecto->id ?>" <?php if($proyecto->id == $idproyecto) {echo "selected=selected";} ?>><?php echo $proyecto->descrip ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>

                                </div>

                            </div>
                        </div><!-- /.box-body -->

					<hr style="height:1px;border:solid 1px;color:#3C8DBC;background-color:#333;" />		
							
                        <div class="box-body">
                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="responsable"><i class="fa fa-male" aria-hidden="true"></i> Responsable</label>
                                    <select class="form-control" id="responsable" name="responsable">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($responsables))
                                            {
                                                foreach ($responsables as $responsable)
                                                {
                                                    ?>
                                                    <option value="<?php echo $responsable->userId ?>" <?php if($responsable->userId == $responsableId) {echo "selected=selected";} ?>><?php echo $responsable->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_autoparte">Fecha verificación autoparte</label><br>
                                        <input type="text" id="fecha_autoparte"  name="fecha_autoparte" value="<?php echo $fecha_autoparte; ?>">
                                    </div>
                                </div>    
                            </div><!-- /.row -->

                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nro_poliza">Nº póliza de seguro</label>
                                        <input type="text" class="form-control" id="nro_poliza"  name="nro_poliza" maxlength="100" value="<?php echo $nro_poliza; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_poliza">Tipo de cobertura póliza</label>
                                        <input type="text" class="form-control" id="tipo_poliza"  name="tipo_poliza" maxlength="150" value="<?php echo $tipo_poliza; ?>">
                                    </div>
                                </div>    
                            </div><!-- /.row -->

                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_seguro">Venc. Seguro</label>
                                        <input type="text" class="form-control" id="venc_seguro"  name="venc_seguro" value="<?php echo $venc_seguro; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_cedulaverde">Venc. cédula verde</label>
                                        <input type="text" class="form-control" id="venc_cedulaverde"  name="venc_cedulaverde" value="<?php echo $venc_cedulaverde; ?>">
                                    </div>
                                </div>    
                            </div><!-- /.row -->

                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_vtv">Venc. VTV</label>
                                        <input type="text" class="form-control" id="venc_vtv"  name="venc_vtv" value="<?php echo $venc_vtv; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_matafuego">Venc. Matafuego</label>
                                        <input type="text" class="form-control" id="venc_matafuego"  name="venc_matafuego" value="<?php echo $venc_matafuego; ?>">
                                    </div>
                                </div>    
                            </div><!-- /.row -->

                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_ruta">Venc. Ruta</label>
                                        <input type="text" class="form-control" id="venc_ruta"  name="venc_ruta" value="<?php echo $venc_ruta; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venc_cert_hidro">Venc. certificación Hidro</label>
                                        <input type="text" class="form-control" id="venc_cert_hidro"  name="venc_cert_hidro" value="<?php echo $venc_cert_hidro; ?>">
                                    </div>
                                </div>    
                            </div><!-- /.row -->

					<hr style="height:1px;border:solid 1px;color:#3C8DBC;background-color:#333;" />
				
                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="acc_kit">Kit reglamentario</label>
                                        <input type="checkbox" class="form-control" id="acc_kit" name="acc_kit" value="1" <?php if($acc_kit == 1) {echo 'checked="checked"';} ?>>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="acc_cargador">Cargador de batería</label>
                                        <input type="checkbox" class="form-control" id="acc_cargador" name="acc_cargador" value="1" <?php if($acc_cargador == 1) {echo 'checked="checked"';} ?>>
                                    </div>
                                </div>    
                            </div><!-- /.row -->
                            <div class="row"><!--  -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="acc_conos">Conos con base (4)</label>
                                        <input type="checkbox" class="form-control" id="acc_conos" name="acc_conos" value="1" <?php if($acc_conos == 1) {echo 'checked="checked"';} ?>>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="acc_chalecos">Chalecos reflectivos (2)</label>
                                        <input type="checkbox" class="form-control" id="acc_chalecos" name="acc_chalecos" value="1" <?php if($acc_chalecos == 1) {echo 'checked="checked"';} ?>>
                                    </div>
                                </div>    
                            </div><!-- /.row -->

                        </div><!-- /.box-body -->

    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                            <input type="reset" class="btn btn-default" value="Limpiar" />
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

        $('#fecha_autoparte').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_cedulaverde').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_seguro').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_vtv').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_matafuego').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_ruta').datepicker({language: 'es', format: 'dd-mm-yyyy'});
        $('#venc_cert_hidro').datepicker({language: 'es', format: 'dd-mm-yyyy'});



    
    });
</script>
