<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

<?php

require APPPATH . '/libraries/listpermisos.php';

$equipoId            = '';
$serie               = '';
$tipoId              = '';
$municipioId         = '';
$decriptador         = '';
$exportable          = '';
$activo              = '';
$marcaId             = '';
$estadoId            = '';
$modeloId            = '';
$serie_int           = '';
$requiere_calib      = '';
$ejido_urbano        = '';
$observ              = '';
$propietarioId       = '';
$vehiculoasig        = '';
$remito              = '';
$pedido              = '';
$ordencompra         = '';
$multicarril         = '';

$ubicacion_calle     = '';
$ubicacion_altura    = '';
$ubicacion_mano      = '';
$ubicacion_sentido   = '';
$ubicacion_localidad = '';
$ubicacion_cp        = '';
$ubicacion_velper    = '';
$velocidad_min    = '';
$geo_lat             = '';
$geo_lon             = '';
$doc_certif          = '';
$doc_aprob           = '';
$doc_normasic        = '';
$doc_distancia       = '';
$ftp_host            = '';
$ftp_user            = '';

$doc_fechacal        = '';
$doc_fechavto        = '';

$doc_informe         = '';
$nro_ot              = '';

if(!empty($equipoInfo))
{
    foreach ($equipoInfo as $ef)
    {
        $equipoId            = $ef->id;
        $serie               = $ef->serie;
        $municipioId         = $ef->municipio;
        $tipoId              = $ef->tipo;
        $decriptador         = $ef->decriptador;
        $exportable          = $ef->exportable;
        $marcaId             = $ef->marca;
        $estadoId            = $ef->estado;
        $propietarioId       = $ef->idpropietario;
        $modeloId            = $ef->idmodelo;
        $serie_int           = $ef->serie_int;
        $requiere_calib      = $ef->requiere_calib;
        $vehiculoasig        = $ef->vehiculoasig;
        $remito              = $ef->remito;
        $pedido              = $ef->pedido;
        $ordencompra         = $ef->ordencompra;
        $multicarril         = $ef->multicarril;
        $carril_sentido      = $ef->carril_sentido;

        $ejido_urbano        = $ef->ejido_urbano;
        $observ              = $ef->observ;
        $activo              = $ef->activo;
        $ubicacion_calle     = $ef->ubicacion_calle;
        $ubicacion_altura    = $ef->ubicacion_altura;
        $ubicacion_mano      = $ef->ubicacion_mano;
        $ubicacion_sentido   = $ef->ubicacion_sentido;
        $ubicacion_localidad = $ef->ubicacion_localidad;
        $ubicacion_cp        = $ef->ubicacion_cp;
        $ubicacion_velper    = $ef->ubicacion_velper;

        $velocidad_min    = $ef->velocidad_min;
        $geo_lat             = $ef->geo_lat;
        $geo_lon             = $ef->geo_lon;
        $doc_certif          = $ef->doc_certif;
        $doc_aprob           = $ef->doc_aprob;
        $doc_normasic        = $ef->doc_normasic;
        $doc_distancia       = $ef->doc_distancia;
        $ftp_host            = $ef->ftp_host;
        $ftp_user            = $ef->ftp_user;
        $ftp_pass            = $ef->ftp_pass;

        $doc_fechacal        = $ef->doc_fechacal;
        $doc_fechavto        = $ef->doc_fechavto;
        $doc_informe         = $ef->doc_informe;
        $nro_ot              = $ef->nro_ot;

    }
}


$CS = explode(',', $carril_sentido);

if ($role == ROLE_SUPERADMIN || in_array($role, $isSSGG) || in_array($role, $isDeposito)):
    $activo1 = "active";
elseif (in_array($role, $isGestion)):
    $activo3 = "active";
elseif (in_array($role, $isCalibracion)):
    $activo4 = "active";
endif;

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">


<div class="content-wrapper">
    <div id="cabecera">
     Equipos - <?=$tipoItem?> Equipo
     <span class="pull-right">
       <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
       <a href="<?=base_url('equiposListing')?>">Equipos listado</a> /
       <span class="text-muted"><?=$tipoItem?> Equipo</span>
     </span>
   </div>

    <section class="content">

        <div class="row">

            <div class="col-md-12">
                  <?php
                      $this->load->helper('form');
                      $error = $this->session->flashdata('error');
                      if ($error): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                      <?php endif; ?>
                  <?php
                  $success = $this->session->flashdata('success');
                  if ($success): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                  <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo ($tipoItem == "Agregar") ? "Nuevo Equipo" : $serie ?> </b></h3>
                    </div>

                    <?php if ($tipoItem == "Agregar"): ?> <!-- form start -->
                        <form role="form" id="addEquipo" action="<?php echo base_url() ?>addNewEquipo" method="post" role="form">
                    <?php else: ?>
                        <form role="form" action="<?php echo base_url() ?>editEquipo" method="post" id="editEquipo" role="form">
                    <?php endif; ?>

                        <input type="hidden" value="<?php echo $equipoId; ?>" name="equipoId" />
                        <input type="hidden" value="<?php echo $serie; ?>" name="serie" />
                        <input type="hidden" value="0" name="componenteId" />
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="white-box">
                                        <!-- .tabs -->
                                        <ul class="nav nav-tabs tabs customtab">
                                            <?php if ($role == ROLE_SUPERADMIN || in_array($role, $isSSGG) || in_array($role, $isDeposito)) {?>
                                                <li class="<?= $activo1?> tab">
                                                    <a href="#detalles" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Detalles </span> </a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($role == ROLE_SUPERADMIN || in_array($role, $isSSGG) || in_array($role, $isDeposito)): ?>
                                                <li class="tab">
                                                    <a href="#SSGG" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">SSGG</span> </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($role == ROLE_SUPERADMIN || in_array($role, $isSSGG) || in_array($role, $isGestion) || in_array($role, $isDeposito)) {?>
                                                <li class="<?= $activo3?> tab">
                                                    <a href="#ubicacion" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Ubicación</span> </a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($role == ROLE_SUPERADMIN || in_array($role, $isCalibracion) || in_array($role, $isGestion) || in_array($role, $isSSGG) || in_array($role, $isGestion) || in_array($role, $isDeposito)) {?>
                                                <li class="<?= $activo4?> tab">
                                                    <a href="#calibracion" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Calibración</span> </a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($name == "Francisco Araujo" || $name == "Cristian Rudzki" || $name == "Carlos Javier Hazañas" || $name == "Pedro Moyano" || $name == "Leonardo Mila" || $name == "Fernando Diaz") {?>
                                                <li class="tab">
                                                    <a href="#desencriptacion" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Desencriptación</span> </a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($name == "Francisco Araujo" || $name == "Ignacio Gutt" || $name == "Cristian Rudzki" || $name == "Leonel Gutt" || $name == "Carlos Javier Hazañas" || $name == "Emmanuel Lencina" || $name == "Gabriel Sciancalepore") {?>
                                                <li class="tab">
                                                    <a href="#datos_ftp" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Datos FTP</span> </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <!-- /.tabs -->
                                        <div class="tab-content">
                                            <!-- .tabs 1 -->
                                            <div class="tab-pane <?= $activo1?>" id="detalles">
                                                <br>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="modelo">Modelos</label>
                                                                <select class="form-control required" id="modelo" name="modelo">
                                                                    <option value="0">Seleccionar Modelo</option>
                                                                    <?php foreach ($modelos as $modelo): ?>
                                                                        <option value="<?php echo $modelo->id ?>" data-sigla="<?php echo $modelo->sigla ?>"
                                                                        <?php if ($tipoItem == "Agregar") { ?>
                                                                            <?php if($modelo->sistemas_aprob == 0){echo "disabled";} ?>>
                                                                        <?php } else { ?>
                                                                            <?php if ($modelo->sistemas_aprob == 0) { ?>
                                                                                <?php echo "disabled"; ?>
                                                                            <?php } else { ?>
                                                                                <?php if($modelo->id == $modeloId && $modelo->sistemas_aprob == 1){echo "selected=selected";} ?>>
                                                                            <?php } ?>
                                                                                <?php echo $modelo->descrip ?> </option> <!-- option de la vista editar-->
                                                                        <?php } ?>
                                                                             <?php echo $modelo->descrip ?></option> <!-- option de la vista agregar-->
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php if ($tipoItem == "Agregar") { ?>
                                                                    <label for="serieNro">Serie</label>
                                                                    <input type="text" class="form-control" id="serieNro" name="serieNro" maxlength="20" autofocus="">
                                                                    <input type="hidden" name="serie" id="serie"/>
                                                                <?php } else { ?>
                                                                    <label for="serieNro">Serie</label>
                                                                	<input type="text" class="form-control" id="nombreSerie" name="nombreSerie" disabled value=<?php echo $serie ?>>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="marca">Marcas</label>
                                                                <select class="form-control required" id="marca" name="marca">
                                                                    <option value="0">Seleccionar Marca</option>
                                                                    <?php foreach ($marcas as $marca): ?>
                                                                        <option value="<?php echo $marca->id ?>" <?php if($marca->id == $marcaId) {echo "selected=selected";} ?>><?php echo $marca->descrip ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="tipo">Tipo</label>
                                                                <select class="form-control" id="tipo" name="tipo">
                                                                    <option value="0">Seleccionar Tipo</option>
                                                                    <?php foreach ($tipos as $tp): ?>
                                                                        <option value="<?php echo $tp->id; ?>" <?php if($tp->id == $tipoId) {echo "selected=selected";} ?>><?php echo $tp->descrip ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="municipio">Proyecto</label>
                                                                <select class="form-control" id="municipio" name="municipio">
                                                                    <option value="0" <?php echo ($municipioId == 0) ? "selected=selected" : "" ;?>>A designar</option>
                                                                    <?php foreach ($municipios as $municipio): ?>
                                                                        <option value="<?php echo $municipio->id; ?>" <?php if($municipio->id == $municipioId) {echo "selected=selected";} ?>><?php echo $municipio->descrip ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="propietario">Propietario</label>
                                                                <select class="form-control required" id="propietario" name="propietario">
                                                                    <option value="0">Seleccionar Propietario</option>
                                                                    <?php foreach ($propietarios as $propietario): ?>
                                                                        <option value="<?php echo $propietario->id ?>" <?php if($propietario->id == $propietarioId) {echo "selected=selected";} ?>><?php echo $propietario->descrip ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="estado">Lugar</label>
                                                                <select class="form-control required" id="estado" name="estado">
                                                                  <?php if ($estadoId == 1): ?>
                                                                    <option value="<?=$estadoId?>">Deposito</option>
                                                                  <?php elseif ($estadoId == 3):?>
                                                                    <option value="<?=$estadoId?>">Socio</option>
                                                                  <?php else: ?>
                                                                    <option value="0">Seleccionar Lugar</option>
                                                                    <?php foreach ($estados as $estado): ?>
                                                                      <option value="<?= $estado->id ?>" <?php if($estado->id == $estadoId) {echo "selected=selected";} ?>><?php echo $estado->descrip ?></option>
                                                                    <?php endforeach; ?>
                                                                  <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="vehiculoasig">Vehículo Asignado</label>
                                                                <select class="form-control required" id="vehiculoasig" name="vehiculoasig">
                                                                    <option value="0">Seleccionar Vehículo</option>
                                                                    <?php if (!empty($vehiculos)): ?>
                                                                      <?php foreach ($vehiculos as $vehiculo): ?>
                                                                            <option value="<?php echo $vehiculo->id ?>" <?php if($vehiculo->id == $vehiculoasig) {echo "selected=selected";} ?>><?php echo $vehiculo->dominio ?></option>
                                                                      <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.tabs1 -->

                                            <div class="tab-pane" id="SSGG">
                                                <br>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="remito">Remito</label>
                                                                <input type="text" class="form-control required" id="remito" name="remito" maxlength="50" value="<?php echo $remito; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pedido">Nro. Pedido</label>
                                                                <input type="text" class="form-control" id="pedido"  name="pedido" maxlength="50" value="<?php echo $pedido; ?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ordencompra">Nro. Orden de Compra</label>
                                                                <input type="text" class="form-control" id="ordencompra"  name="ordencompra" maxlength="50" value="<?php echo $ordencompra; ?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="observ">Observaciones</label>
                                                                <textarea name="observ" id="observ" class="form-control" rows="3" cols="20" style="resize:none"><?php echo $observ ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->
                                                </div><!-- /.row -->
                                            </div><!-- /.tabs5 -->

                                            <!-- .tabs2 -->
                                            <div class="tab-pane <?= $activo3?>" id="ubicacion">
                                                <br>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ubicacion_calle">Calle - Avenida - Ruta</label>
                                                                <input type="text" class="form-control" id="ubicacion_calle" name="ubicacion_calle" maxlength="255" value="<?php echo $ubicacion_calle; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ubicacion_altura">Altura - Km</label>
                                                                <input type="text" class="form-control" id="ubicacion_altura" name="ubicacion_altura" maxlength="50" value="<?php echo $ubicacion_altura; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ubicacion_sentido">Sentido</label>
                                                                <select class="form-control required" id="ubicacion_sentido" name="ubicacion_sentido">
                                                                    <option value="0" <?php if($ubicacion_sentido == 0) {echo "selected=selected";} ?>>Seleccionar sentido</option>
                                                                    <option value="5" <?php if($ubicacion_sentido == 5) {echo "selected=selected";} ?>>Ascendente</option>
                                                                    <option value="6" <?php if($ubicacion_sentido == 6) {echo "selected=selected";} ?>>Descendente</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ejido_urbano">Ejido Urbano</label>
                                                                <select class="form-control required" id="ejido_urbano" name="ejido_urbano">
                                                                    <option value="0" <?php if($ejido_urbano == 0) {echo "selected=selected";} ?>>Seleccionar Ejido</option>
                                                                    <option value="1" <?php if($ejido_urbano == 1) {echo "selected=selected";} ?>>Dentro</option>
                                                                    <option value="2" <?php if($ejido_urbano == 2) {echo "selected=selected";} ?>>Fuera</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ubicacion_localidad">Localidad</label>
                                                                <input type="text" class="form-control" id="ubicacion_localidad"  name="ubicacion_localidad" maxlength="50" value="<?php echo $ubicacion_localidad; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ubicacion_cp">Código postal</label>
                                                                <input type="text" class="form-control" id="ubicacion_cp"  name="ubicacion_cp" maxlength="6" value="<?php echo $ubicacion_cp; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="geo_lat">Geo Latitud</label>
                                                                <input type="text" class="form-control" id="geo_lat"  name="geo_lat" maxlength="10" value="<?php echo $geo_lat; ?>" placeholder="Ejemplo: -21.445566">
                                                            </div>
                                                            <p class="help-block">La Latitud tiene que estar entre -21.350556 y --55.165957.</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="geo_lon">Geo Longitud</label>
                                                                <input type="text" class="form-control" id="geo_lon"  name="geo_lon" maxlength="10" value="<?php echo $geo_lon; ?>" placeholder="Ejemplo: -53.778899">
                                                            </div>
                                                            <p class="help-block">La Longitud tiene que estar entre -53.232825 y -72.623017.</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.tabs2 -->
                                            <!-- .tabs3 -->
                                            <div class="tab-pane <?= $activo4?>" id="calibracion">
                                                <br>
                                                <div class="col-md-12 col-xs-12">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="multicarril">Nº Carriles</label>
                                                                <select class="form-control required" id="multicarril" name="multicarril">
                                                                    <option value="0" <?php if($multicarril == 0) {echo "selected=selected";} ?>>Sin Carriles</option>
                                                                    <option value="1" <?php if($multicarril == 1) {echo "selected=selected";} ?>>1</option>
                                                                    <option value="2" <?php if($multicarril == 2) {echo "selected=selected";} ?>>2</option>
                                                                    <option value="3" <?php if($multicarril == 3) {echo "selected=selected";} ?>>3</option>
                                                                    <option value="4" <?php if($multicarril == 4) {echo "selected=selected";} ?>>4</option>
                                                                    <option value="5" <?php if($multicarril == 5) {echo "selected=selected";} ?>>5</option>
                                                                    <option value="6" <?php if($multicarril == 6) {echo "selected=selected";} ?>>6</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 1</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio"  name="carril_1" value="1A" <?php if($CS[0] == "1A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio"  name="carril_1" value="1D" <?php if($CS[0] == "1D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 2</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio" name="carril_2" value="2A" <?php if($CS[1] == "2A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio" name="carril_2" value="2D" <?php if($CS[1] == "2D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 3</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio" name="carril_3" value="3A" <?php if($CS[2] == "3A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio" name="carril_3" value="3D" <?php if($CS[2] == "3D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    </div>

                                                    <div class="row">
                                                      <div class="col-md-3">
                                                          <div class="form-group">
                                                              <label for="velocidad_min">Velocidad minima</label>
                                                              <input type="text" class="form-control" id="velocidad_min"  name="velocidad_min" maxlength="3" value="<?php echo $velocidad_min; ?>">
                                                          </div>
                                                      </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="ubicacion_velper">Velocidad máxima</label>
                                                                <input type="text" class="form-control" id="ubicacion_velper"  name="ubicacion_velper" maxlength="3" value="<?php echo $ubicacion_velper; ?>">
                                                            </div>
                                                        </div>



                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 4</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio"  name="carril_4" value="4A" <?php if($CS[3] == "4A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio"  name="carril_4" value="4D" <?php if($CS[3] == "4D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 5</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio" name="carril_5" value="5A" <?php if($CS[4] == "5A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio" name="carril_5" value="5D" <?php if($CS[4] == "5D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="doc_informe">Carril 6</label>
                                                                        <div class="input-group">
                                                                            <label><input type="radio" name="carril_6" value="6A" <?php if($CS[5] == "6A") {echo 'checked';} ?>> Ascendente</label><br>
                                                                            <label><input type="radio" name="carril_6" value="6D" <?php if($CS[5] == "6D") {echo 'checked';} ?>> Descendente</label><br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    </div>

                                                    <?php if (!in_array($role, $isGestion) && !in_array($role, $isDeposito) && !in_array($role, $isSSGG)): ?>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_fechacal">Fecha Calibración</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                                    <?php if ($doc_fechacal == '0000-00-00'): ?>
                                                                      <input id="doc_fechacal" name="doc_fechacal" type="text" class="form-control" aria-describedby="fecha" placeholder="Seleccione una fecha">
                                                                    <?php else: ?>
                                                                      <input id="doc_fechacal" name="doc_fechacal" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $doc_fechacal ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_fechavto">Fecha Vencimiento</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                                    <?php if ($doc_fechavto == '0000-00-00'): ?>
                                                                      <input id="doc_fechavto" name="doc_fechavto" type="text" class="form-control" aria-describedby="fecha" placeholder="Seleccione una fecha">
                                                                    <?php else: ?>
                                                                      <input id="doc_fechavto" name="doc_fechavto" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $doc_fechavto ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_certif">Tipo de calibración</label>
                                                                <div class="input-group">
                                                                    <label><input type="radio" name="doc_certif" value="Primitiva" <?php if($doc_certif == "Primitiva") {echo 'checked';} ?>> Primitiva</label><br>
                                                                    <label><input type="radio" name="doc_certif" value="Periodica" <?php if($doc_certif == "Periodica") {echo 'checked';} ?>> Periodica</label><br>
                                                                    <label><input type="radio" name="doc_certif" value="No requiere" <?php if($doc_certif == "No requiere") {echo 'checked';} ?>> No Requiere</label><br>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_informe">Informe</label>
                                                                <div class="input-group">
                                                                    <label><input type="radio" name="doc_informe" value="1" <?php if($doc_informe == 1) {echo 'checked';} ?>> Si</label><br>
                                                                    <label><input type="radio" name="doc_informe" value="0" <?php if($doc_informe == 0) {echo 'checked';} ?>> No</label><br>
                                                                </div>
                                                            </div>
                                                         </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nro_ot">Nro OT</label>
                                                                <input type="text" class="form-control" id="nro_ot" name="nro_ot" maxlength="50" value="<?php echo $nro_ot; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_aprob">Código de aprobación</label>
                                                                <input type="text" class="form-control" id="doc_aprob"  name="doc_aprob" maxlength="100" value="<?php echo $doc_aprob; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_normasic">Norma SIC</label>
                                                                <input type="text" class="form-control" id="doc_normasic"  name="doc_normasic" maxlength="100" value="<?php echo $doc_normasic; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="doc_distancia">Distancia entre espiras</label>
                                                                <input type="text" class="form-control" id="doc_distancia"  name="doc_distancia" maxlength="20" value="<?php echo $doc_distancia; ?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->

                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- /.tabs3 -->

                                            <div class="tab-pane" id="desencriptacion">
                                                <br>

                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="serie_int">Serie Int</label>
                                                                <input type="text" class="form-control" id="serie_int"  name="serie_int" maxlength="20" value="<?php echo $serie_int; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="decriptador">Decriptador</label>
                                                                <input type="text" class="form-control" id="decriptador"  name="decriptador" value="<?php echo $decriptador; ?>" maxlength="11">
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exportable">Exportable</label>
                                                                <p style="text-align: center;"><input type="checkbox" id="exportable" name="exportable" value="1" <?php if($exportable == 1) {echo 'checked="checked"';} ?>>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->
                                                </div>
                                            </div><!-- /.tabs4 -->

                                            <div class="tab-pane" id="datos_ftp">
                                                <br>

                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ftp_host">Host</label>
                                                                <input type="text" class="form-control" id="ftp_host"  name="ftp_host" maxlength="50" value="<?php echo $ftp_host; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ftp_user">User</label>
                                                                <input type="text" class="form-control" id="ftp_user"  name="ftp_user" maxlength="30" value="<?php echo $ftp_user; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="ftp_pass">Password</label>
                                                                <input type="text" class="form-control" id="ftp_pass"  name="ftp_pass" maxlength="20" value="<?php echo $ftp_pass; ?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- /.row -->
                                                </div>
                                            </div><!-- /.tabs5 -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                            <a class="btn btn-primary" href="javascript:history.go(-1);">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if ($tipoItem == "Agregar"): ?>
    <script src="<?php echo base_url(); ?>assets/js/addEquipo.js" type="text/javascript"></script>
<?php else: ?>
    <script src="<?php echo base_url(); ?>assets/js/editEquipo.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<?php endif; ?>

<script>
    $(function() {
        $('#doc_fechacal').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es'
        });

        $('#doc_fechavto').datepicker({
            format: 'yyyy-mm-dd',
            language: 'es'
        });
    });

    $(function() {
        $("#modelo").change(function () {
           $("#modelo option:selected").each(function () {
                sigla = $(this).data("sigla");
                serie = $("#serieNro").val();
                $("#serie").val(sigla + serie);
            });
        })
        $("#serieNro").change(function () {
                serie = $(this).val();
                sigla = $("#modelo").find(':selected').data('sigla');
                $("#serie").val(sigla + serie);

        })

        $("#tipo").change(function () {
           $("#tipo option:selected").each(function () {
                tipo = $(this).val();
                if(tipo == 1 || tipo == 2403 || tipo == 2406)
                {
                    $("#vehiculoasig").removeAttr('disabled');
                } else {
                    $("#vehiculoasig").attr('disabled', 'disabled');
                }
            });
        });

        $("#multicarril").change(function () {
                multicarril = $(this).val();
                switch(multicarril) {
                    case "0":
                        $("input[name=carril_1]").attr('disabled', true);
                        $("input[name=carril_2]").attr('disabled', true);
                        $("input[name=carril_3]").attr('disabled', true);
                        $("input[name=carril_4]").attr('disabled', true);
                        $("input[name=carril_5]").attr('disabled', true);
                        $("input[name=carril_6]").attr('disabled', true);
                        break;
                    /*case "1":
                        $("input[name=carril_1]").attr('disabled', false);
                        $("input[name=carril_2]").attr('disabled', true);
                        $("input[name=carril_3]").attr('disabled', true);
                        break;
                    case "2":
                        $("input[name=carril_1]").attr('disabled', false);
                        $("input[name=carril_2]").attr('disabled', false);
                        $("input[name=carril_3]").attr('disabled', true);
                        break;
                    case "3":
                        $("input[name=carril_1]").attr('disabled', false);
                        $("input[name=carril_2]").attr('disabled', false);
                        $("input[name=carril_3]").attr('disabled', false);
                        break;
                  */

                }
        });
    });
</script>
