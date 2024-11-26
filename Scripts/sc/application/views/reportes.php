<?php 

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
        Reportes Excel
        <span class="pull-right">
            <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
            <span class="text-muted">Reportes Excel</span>
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
                <?php if ($this->session->flashdata('info')): ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?= $this->session->flashdata('info'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">



            <div class="col-md-2">
                <div class="tabbable">
                    <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
                        <li class="active tab"><a href="#rapidos" data-toggle="tab">Rapidos </a></li>
                        <?php if (!in_array($role,  array(275,276,105,68,27,191,273,263,262,146,175,38,221))): ?>
                        <li class="tab">
                            <a href="#reparaciones2" data-toggle="tab"> Reparaciones </a>
                        </li>
                        <li class="tab">
                            <a href="#bajada2" data-toggle="tab" aria-expanded="false"> Bajada de memoria </a>
                        </li>
                        <li class="tab">
                            <a href="#calibraciones2" data-toggle="tab" aria-expanded="false"> Calibraciones </a>
                        </li>
                        <li class="tab">
                            <a href="#instalaciones" data-toggle="tab" aria-expanded="false"> Instalaciones </a>
                        </li>
                        <?php if (in_array($vendorId, array(275,276,105,68,27,191,273,263,262,146,175,38,221))): ?>
                        <li class="tab">
                            <a href="#sistemas" data-toggle="tab"> Sistemas </a>
                        </li>
                        <li class="tab" id="liSalidDeEdicion">
                            <a href="#salidaDeEdicion" data-toggle="tab" value = "salidaDeEdicion"> Salida De Edicion </a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="rapidos">
                        <?php $rapidos = array('1' => 'completo', '2' => 'activos', '3' => 'aVencer', '4' => 'enReparacion'); ?>
                        <?php foreach ($rapidos as $rapido => $tipo): ?>
                        <form role="form" id="<?=$tipo?>" action="<?=base_url('reportes/reportesRapidos')?>"
                            method="post">
                            <input type="hidden" name="reportes_rapidos" value="<?=$rapido?>">
                        </form>
                        <?php endforeach; ?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #3c8dbc;" class="box-header with-border">
                                        <h3 class="box-title">Reporte completo</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#" onclick="document.getElementById('completo').submit()"><i
                                                        class="fa fa-video-camera text-primary"></i> Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #00a65a;" class="box-header with-border">
                                        <h3 class="box-title">Equipos activos</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#" onclick="document.getElementById('activos').submit()"><i
                                                        class="fa fa-check text-success"></i> Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #f39c12;" class="box-header with-border">
                                        <h3 class="box-title">Calibraciones a vencer</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#" onclick="document.getElementById('aVencer').submit()"><i
                                                        class="fa fa-exclamation-triangle text-warning"></i>
                                                    Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #f56954;" class="box-header with-border">
                                        <h3 class="box-title">Equipos en Reparacion</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#"
                                                    onclick="document.getElementById('enReparacion').submit()"><i
                                                        class="fa fa-wrench text-danger"></i> Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <?php if (!in_array($role, array(60,61,62,63))): ?>
                        <form role="form" id="reportesEquipo" action="<?=base_url('reportes/reportesRapidos')?>"
                            method="post" role="form">
                            <input type="hidden" name="reportes_rapidos" value="0">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Personalizado</h3>
                                </div>
                                <div class="box-body ">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="municipio">Proyecto</label>
                                                <select class="form-control" id="municipio" name="municipio">
                                                    <option value="-1">Todos</option>
                                                    <?php foreach ($municipios as $municipio):?>
                                                    <option value="<?=$municipio->id?>"><?=$municipio->descrip?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="idequipo">Equipo serie</label>
                                                <select id="idequipo" name="idequipo[]"
                                                    class="form-control selectpicker" multiple data-live-search="true"
                                                    multiple data-max-options="1" title="Seleccione los equipos..."
                                                    data-size="6">
                                                </select>
                                                <input type="hidden" name="serie" id="serie" />
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipo">Tipos</label>
                                                <select class="form-control required" id="tipo" name="tipo">
                                                    <option value="0">Seleccionar Tipo</option>
                                                    <?php foreach ($tipos as $tipo):?>
                                                    <option value="<?=$tipo->id?>"><?=$tipo->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="marca">Marcas</label>
                                                <select class="form-control required" id="marca" name="marca">
                                                    <option value="0">Seleccionar Marca</option>
                                                    <?php foreach ($marcas as $marca): ?>
                                                    <option value="<?=$marca->id?>"><?=$marca->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="modelo">Modelos</label>
                                                <select class="form-control required" id="modelo" name="modelo">
                                                    <option value="0">Seleccionar Modelo</option>
                                                    <?php foreach ($modelos as $modelo):?>
                                                    <option value="<?=$modelo->id?>" data-sigla="<?=$modelo->sigla?>">
                                                        <?=$modelo->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Lugar</label>
                                                <select class="form-control required" id="estado" name="estado">
                                                    <option value="0">Seleccionar Lugar</option>
                                                    <?php foreach ($estados as $estado): ?>
                                                    <option value="<?=$estado->id?>"><?=$estado->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="modelo">Eventos</label>
                                                <select class="form-control required" id="evento" name="evento">
                                                    <option value="0">Seleccionar Evento</option>
                                                    <?php foreach ($eventos as $evento): ?>
                                                    <option value="<?=$evento->id?>" data-sigla="<?=$evento->id?>">
                                                        <?=$evento->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="modelo">Administración</label>
                                                <select class="form-control required" id="administracion"
                                                    name="administracion">
                                                    <option value="0">Seleccionar Administración</option>
                                                    <?php foreach ($administraciones as $administracion): ?>
                                                    <option value="<?=$administracion->id?>"
                                                        data-sigla="<?=$administracion->id?>">
                                                        <?=$administracion->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="calibra_vence">Calibración por vencer</label>
                                                <select class="form-control required" id="calibra_vence"
                                                    name="calibra_vence">
                                                    <option value="0">Seleccionar</option>
                                                    <option value="30">30 días</option>
                                                    <option value="60">60 días</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="propietarios">Propietarios</label>
                                                <select class="form-control required" id="propietarios"
                                                    name="propietarios">
                                                    <option value="0">Seleccionar</option>
                                                    <?php foreach ($propietarios as $propietario):?>
                                                    <option value="<?=$propietario->id?>"><?=$propietario->descrip?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->

                                    <div class="row">
                                        <!-- fechas desde hasta -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_desde">Fecha Desde</label><br>
                                                <input class="form-control" type="text" id="fecha_desde"
                                                    name="fecha_desde">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_hasta">Fecha Hasta</label><br>
                                                <input class="form-control" type="text" id="fecha_hasta"
                                                    name="fecha_hasta">
                                            </div>
                                        </div>
                                    </div><!-- FIN FECHAS -->

                                </div>
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" value="Descargar" />
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>

                    </div>


                    <div class="tab-pane" id="reparaciones2">
                        <form role="form" id="dppsvAbiertas" action="<?= base_url('reportes/reportesReparaciones')?>"
                            method="post">
                            <input type="hidden" name="reportes_reparaciones" value="100">
                        </form>

                        <form role="form" action="<?=base_url('reportes/reportesReparaciones')?>" method="post">
                            <input type="hidden" id="repaOrdAbiertas" name="reportes_reparaciones" value="102">
                        </form>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #f56954;" class="box-header with-border">
                                        <h3 class="box-title">Reporte DPPSV abiertas</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#"
                                                    onclick="document.getElementById('dppsvAbiertas').submit()"><i
                                                        class="fa fa-download"></i></i> Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-solid">
                                    <div style="border-left-style: solid;
                    border-left-color: #3c8dbc;" class="box-header with-border">
                                        <h3 class="box-title">Ordenes abiertas</h3>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#" onclick="document.getElementById('activos').submit()"><i
                                                        class="fa fa-download"></i> Descargar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Reporte DPPSV cerradas</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesReparaciones')?>"
                                        method="post">
                                        <input type="hidden" name="reportes_reparaciones" value="101">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde2">Fecha Desde</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_desde2"
                                                                name="fecha_desde2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_hasta2">Fecha Hasta</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_hasta2"
                                                                name="fecha_hasta2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- FIN FECHAS -->
                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ordenes cerradas</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesReparaciones')?>"
                                        method="post">
                                        <input type="hidden" name="reportes_reparaciones" value="103">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde2">Fecha Desde</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_desde4"
                                                                name="fecha_desde4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_hasta2">Fecha Hasta</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_hasta4"
                                                                name="fecha_hasta4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- FIN FECHAS -->
                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="panel panel-primary">
                            <div class="panel-heading">Equipos - días operativos</div>
                            <form role="form" action="<?=base_url('reportes/diasOperativos')?>" method="post">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="municipio3">Proyecto</label>
                                                <select class="form-control" id="municipio3" name="municipio3">
                                                    <option value="0">Todos</option>
                                                    <?php foreach ($municipios as $municipio):?>
                                                    <option value="<?=$municipio->id?>"><?=$municipio->descrip?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipo">Tipos</label>
                                                <select class="form-control required" id="tipo" name="tipo">
                                                    <option value="0">Seleccionar Tipo</option>
                                                    <?php foreach ($tipos as $tipo):?>
                                                    <option value="<?=$tipo->id?>"><?=$tipo->descrip?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="equipo">Código de equipo</label>
                                                <select id="equipo" name="equipo[]" class="form-control selectpicker"
                                                    multiple data-live-search="true" title="Seleccione un equipo..."
                                                    data-size="10" data-max-options="1">
                                                    <?php foreach ($equipos as $equipo):?>
                                                    <option value="<?=$equipo->id?>"><?=$equipo->serie?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proyecto">Fecha Desde</label><br>
                                                <input class="form-control" type="text" id="fecha_desde6"
                                                    name="fecha_desde6" autocomplete="off" required>
                                                <p class="help-block">No hay disponibles informes anteriores al
                                                    01/05/2018.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_hasta6">Fecha Hasta</label><br>
                                                <input class="form-control" type="text" id="fecha_hasta6"
                                                    name="fecha_hasta6" autocomplete="off" required>
                                            </div>
                                        </div><!-- FIN FECHAS -->
                                    </div>
                                    <!-- /.info-box -->

                                </div>
                                <!-- /.col -->

                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" value="Descargar" />
                                </div>
                            </form>
                        </div>

                    </div>




                    <div class="tab-pane" id="bajada2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Reporte Bajada de memoria</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesBajada')?>" method="post">
                                        <input type="hidden" name="reportes_bajada" value="200">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="municipio">Proyecto</label>
                                                        <select class="form-control" id="municipio2" name="municipio2"
                                                            required>
                                                            <option value="">Seleccionar un proyecto</option>
                                                            <?php foreach ($municipios as $municipio): ?>
                                                            <option value="<?=$municipio->id?>"><?=$municipio->descrip?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde3">Fecha Desde</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_desde3"
                                                                name="fecha_desde3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_hasta3">Fecha Hasta</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_hasta3"
                                                                name="fecha_hasta3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- FIN FECHAS -->


                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Total archivos ingresados</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesBajada')?>" method="post">
                                        <input type="hidden" name="reportes_bajada" value="201">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde5">Fecha Desde</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_desde5"
                                                                name="fecha_desde5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_hasta5">Fecha Hasta</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_hasta5"
                                                                name="fecha_hasta5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- FIN FECHAS -->
                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ultima Bajada</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/ultima_bajada')?>" method="post">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="municipio">Proyecto</label>
                                                        <select class="form-control" id="proyecto_ultimaBajada"
                                                            name="proyecto_ultimaBajada" required>
                                                            <option value="0">Todos</option>
                                                            <?php foreach ($municipios as $municipio): ?>
                                                            <option value="<?=$municipio->id?>"><?=$municipio->descrip?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde3">Fecha Maxima</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text"
                                                                id="fecha_ultimaBajada" name="fecha_ultimaBajada"
                                                                autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>

                    </div>





                    <div class="tab-pane" id="calibraciones2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Calibraciones a vencer</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesCalibraciones')?>"
                                        method="post">
                                        <input type="hidden" name="reportes_calibraciones" value="300">
                                        <div class="box-body">
                                            <div class="row">
                                                <!-- fechas desde hasta -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fecha_desde5">Fecha Proxima</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fecha_proxima"
                                                                name="fecha_proxima">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ordenes de Calibracion</h3>
                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesCalibraciones')?>"
                                        method="post">
                                        <input type="hidden" name="reportes_calibraciones" value="301">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="label_proyecto">Proyecto</label><br>
                                                        <div class="form-group">
                                                            <select class="form-control" id="proyecto" name="proyecto">
                                                                <option value="0">Todos</option>
                                                                <?php foreach ($proyectosCalibrar as $proyecto): ?>
                                                                <option value="<?=$proyecto->id?>">
                                                                    <?=$proyecto->descrip?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="label_ordenes" for="horario">Tipo de Orden</label>
                                                        <select class="form-control" id="tipo_orden" name="tipo_orden">
                                                            <option value="0">Todos</option>
                                                            <?php foreach ($tipo_ordenes as $tipo_orden): ?>
                                                            <option value="<?=$tipo_orden->id_tipoOrden?>">
                                                                <?=$tipo_orden->estado?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="label_proyecto">Tipo de Servicio</label><br>
                                                        <div class="form-group">
                                                            <select class="form-control" id="tipo_servicio"
                                                                name="tipo_servicio">
                                                                <option value="0">Todos</option>
                                                                <?php foreach ($servicios as $servicio): ?>
                                                                <option value="<?=$servicio->id?>">
                                                                    <?=$servicio->verificacion?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="label_ordenes" for="horario">Tipo de Equipo</label>
                                                        <select class="form-control" id="tipo_equipo"
                                                            name="tipo_equipo">
                                                            <option value="0">Todos</option>
                                                            <?php foreach ($equiposCalibrar as $equipo): ?>
                                                            <option value="<?= $equipo->id?>"><?= $equipo->descrip?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="tab-pane" id="instalaciones">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ordenes de Instalacion</h3>
                                        <span class="pull-right">

                                            <a data-toggle="modal" title="Ayuda"
                                                data-target="#modalAyuda_instaOrdenes"><i
                                                    class="fa fa-question-circle text-info fa-lg"></i></a>
                                            <!-- sample modal content -->
                                            <div id="modalAyuda_instaOrdenes" class="modal fade" tabindex="-1"
                                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×</button>
                                                            <h4 class="modal-title" id="myModalLabel">Ayuda de Ordenes
                                                                de Instalacion</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Proyecto:</strong> Selecciona el proyecto que
                                                                necesites descargar un informe del estado de las ordenes
                                                                de Instalación.</p>
                                                            <p><strong>Tipo de Orden:</strong> Selecciona el Tipo de
                                                                Orden que necesites para el informe.</p>
                                                            <p><strong>Rango de fechas:</strong> Selecciona el Rango de
                                                                Fechas que necesites para aplicar el informe. Hay tiempo
                                                                predeterminados que son:<br>
                                                            <ul>
                                                                <li><strong>Todas las fechas:</strong> Se aplica desde
                                                                    la primera Orden hasta la ultima creada actualmente.
                                                                </li>
                                                                <li><strong>1 Semana:</strong> El rango de fechas se
                                                                    aplica desde 7 días antes a la fecha actual hasta
                                                                    hoy.</li>
                                                                <li><strong>2 Semanas:</strong> El rango de fechas se
                                                                    aplica desde 14 días antes a la fecha actual hasta
                                                                    hoy.</li>
                                                                <li><strong>1 mes:</strong> El rango de fechas se aplica
                                                                    desde 30 días antes a la fecha actual hasta hoy.
                                                                </li>
                                                                <li><strong>Personalizado:</strong> El rango de fechas
                                                                    desde y hasta se puede elegir a gusto.</li>
                                                            </ul>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success btn-rounded"
                                                                data-dismiss="modal">Aceptar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </span>



                                    </div>
                                    <form role="form" action="<?=base_url('reportes/reportesInstalaciones')?>"
                                        method="post">
                                        <input type="hidden" name="reportes_instalaciones" value="400">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="label_proyecto">Proyecto</label><br>
                                                        <div class="form-group">
                                                            <select class="form-control" id="proyecto" name="proyecto">
                                                                <option value="0">Todos</option>
                                                                <?php foreach ($proyectosCalibrar as $proyecto): ?>
                                                                <option value="<?=$proyecto->id?>">
                                                                    <?=$proyecto->descrip?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="label_ordenes" for="horario">Tipo de Orden</label>
                                                        <select class="form-control" id="tipo_orden" name="tipo_orden">
                                                            <option value="0">Todas</option>
                                                            <option value="A">Abiertas</option>
                                                            <option value="F">Finalizadas</option>
                                                            <!--<option value="8">Rechazadas</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="label_ordenes" for="horario">Rango de fechas</label>
                                                        <select class="form-control" id="rango_fecha"
                                                            name="rango_fecha">
                                                            <option value="0">Todas las fechas</option>
                                                            <option value="7">1 Semana</option>
                                                            <option value="14">2 Semanas</option>
                                                            <option value="30">1 Mes</option>
                                                            <option value="1">Personalizado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="fechas_insta">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="label_fd_insta" id="label_fd_insta">Fecha
                                                            Desde</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="icono_fd_insta"><i
                                                                    class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fd_insta"
                                                                name="fd_insta" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="label_fh_insta" id="label_fh_insta">Fecha
                                                            Hasta</label><br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="icono_fh_insta"><i
                                                                    class="fa fa-calendar"
                                                                    aria-hidden="true"></i></span>
                                                            <input class="form-control" type="text" id="fh_insta"
                                                                name="fh_insta" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="Descargar" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if (in_array($vendorId, array(275,276,105,68,27,191,273,263,262,146,175,38,221))): ?>
                    <div class="tab-pane" id="sistemas">
                        <div class="col-md-6">
                            <div class="box box-light">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Sistemas</h3>
                                </div>

                                <form role="form" action="<?=base_url('reportes_sistemas')?>" method="post">
                                    <!--Ruta provisoria-->
                                    <div class="box-body">
                                        <div class="row">
                                            <!-- fechas desde hasta -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fecha_desde7">Fecha Desde</label><br>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"
                                                                aria-hidden="true"></i></span>
                                                        <input class="form-control" type="text" id="fecha_desde7"
                                                            name="fecha_desde7" require>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fecha_hasta5">Fecha Hasta</label><br>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"
                                                                aria-hidden="true"></i></span>
                                                        <input class="form-control" type="text" id="fecha_hasta7"
                                                            name="fecha_hasta7" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- FIN FECHAS -->
                                    </div>

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" value="Descargar Excel" />

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>

                    <?php if (in_array($vendorId, array(275,276,105,68,175,38,27))): ?>
                
                    <div id="salidaDeEdicion">
                        <form role="form" method="post" id="formData">
                            <!--este form va con lo de abajo-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h3 for="proyectoElegido">Proyectos : </h3>
                                    <select class="form-control required" required="required" name="proyectoElegido"
                                        id="proyectoElegido">
                                        <option value="0">Seleccionar proyecto</option>
                                        <?php foreach ($municipios as $municipio): ?>
                                        <option value="<?=$municipio->id?>" id="value">
                                            <?=$municipio->id . ' | ' . $municipio->descrip?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>

                            <div id="estado1">
                                <div class="col-md-12">
                                    <!--caja de botones y titulo-->
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><span>Ingreso de Datos</span></h3>
                                        </div>
                                        <div class="btn-toolbar justify-content-between">
                                            <button class="btn btn-primary salida_edicion_r" value="0,0,0" type="button"
                                                id="bajada_salida_edicion">Bajada</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="0,10,0" id="ingreso">Ingreso</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r" value="0,1,0"
                                                id="pendienteDeDesencriptacion">Pediente de
                                                Desencriptacion</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r" value="0,2,0"
                                                id="desencriptando">Desencriptando</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r" value="0,3,0"
                                                id="incorporando">Incorporando</button>
                                        </div>
                                    </div> <!-- fin de box-primary -->

                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><span>Edicion</span></h3>
                                        </div>
                                        <div class="btn-toolbar justify-content-between">
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="76,6,0" id="enRevision">En Revision</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="70,5,70" id="anulado">Anulado</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r" value="0,4,0"
                                                id="desencriptado">Desencriptado</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="60,4,0" id="edicion">Edicion </button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="63,4,0" id="errorImpacto">Error Impacto</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="69,4,0" id="verificacion">Verificacion</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="72,4,0" id="descartadoEnEdicion">Descartado en
                                                Edicion</button>
                                        </div>
                                    </div><!-- fin de box-primary -->

                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><span>Salida de Edicion</span></h3>
                                        </div>
                                        <div class="btn-toolbar justify-content-between">
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="65,4,0" id="editado">Editado</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="55,4,99" id="desencriptado">Salida de Edicion
                                                Observada</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="65,4,99">Salida de Edicion
                                                Pendiente</button>
                                            <button type="button" class="btn btn-primary salida_edicion_r"
                                                value="52,4,99" id="desencriptado">Salida de Edicion
                                                Aprobada</button>

                                        </div>
                                    </div><!-- fin de box-primary -->
                                    <button type="button" style="margin-top : 10px" type="submit"
                                        class="btn btn-success btn-xlg  mt-3 " id="btnExportacion">
                                        Listar Protocolos
                                    </button>

                                </div>
                        </form>

                    </div>
                </div>
                <br>
                <br>

                <div id="showData">

                    <br>
                    <h4 class="box-title md-inline-block" ">Protocolos:</h4>
                        <form role=" form" method='POST' action=<?=base_url('/reportes/exportaciones');?>>
                        <div id="todo-luces">
                            <div id="luces"></div>
                            <div id="allCheckLuces">
                                <input type="checkbox" id="check_general_luces" class="col-sm" name="check_proto"
                                    value="5">
                                <label for="check_general_luces">Marcar o Desmarcar Todos los check luces</label>
                            </div>

                            <div class=" col-lg-12" id="protocolos_a_listar">


                                <!-- /input-group -->
                            </div>
                        </div>
                        <div id="todo-no-luces">
                            <div id="noluces"></div>
                            <div id="allCheckNoLuces">
                                <input type="checkbox" id="check_general_no_luces" class="col-sm" name="check_proto"
                                    value="5">
                                <label for="check_general__no_luces">Marcar o Desmarcar Todos los check de NO
                                    luces</label>
                            </div>
                            <div class=" col-lg-12" id="protocolos_a_listar2">
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success btn-lg mt-3 " id="btnExportacion1" value="Exportar">


                        </form>

                </div>


            </div>
            <div class="col-md-12" id="protocolos-no-encontrados">
                <div class="alert alert-warning">
                    <p class="alert-link" style="margin-top: 10px;">NINGUN PROTOCOLO ENCONTRADO PARA LOS DATOS
                        INGRESADOS</p>
                </div>
            </div>
            <?php endif; ?>
            <!-- HASTA ACA  -->







        </div>

</div>



</section>

</div>
<!-- <script src="<?php //echo base_url(); ?>assets/js/reportesEquipo.js" type="text/javascript"></script> -->

<script>
$(function() {
    minDate = new Date(2018, 5 - 1, 1);
    fechaInicio = new Date

    $('#fecha_desde').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_hasta').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_desde2').datepicker({ // ----> REPORTES DPPDV <----
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_hasta2').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_desde3').datepicker({ // ----> REPORTES BAJADA DE MEMORIA <----
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_hasta3').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_desde4').datepicker({ // ----> REPORTES REPARACIONES <----
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_hasta4').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_desde5').datepicker({ // ----> REPORTES REPARACIONES <----
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_hasta5').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es'
    });

    $('#fecha_desde6').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        startDate: minDate,
        endDate: new Date()
    });

    $('#fecha_hasta6').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        startDate: minDate,
        endDate: new Date()
    });

    $('#fecha_desde7').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        startDate: minDate,
        endDate: new Date()

    });
    //alert($("#fecha_desde7").val());

    $('#fecha_hasta7').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        startDate: minDate,
        endDate: new Date()

    });



    $('#fecha_proxima').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',

    });

    $('#fd_insta').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        startDate: '01-05-2017',
    });

    $('#fh_insta').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        endDate: new Date(),
        todayHighlight: true
    });

    $('#fecha_ultimaBajada').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        endDate: new Date(),
        todayHighlight: true
    });
});

$("#municipio").change(function() {
    valor = $(this).val();
    $.post("<?=base_url('ordenesb/equiposajax')?>", {
            proyecto: valor
        })
        .done(function(data) {
            var result = JSON.parse(data);
            var option = '';
            $("#idequipo").html("");
            var previo = "";
            var i = 0;
            result.forEach(function(equipo) {
                option = option + "<option ";
                option = option + 'value="' + equipo['id'] + '">' + equipo['serie'] + '</option>';
            });
            $("#idequipo").append(option);
            $('.selectpicker').selectpicker('refresh');
        });
});

// aca estoy laburando -------------------------------------
function escondeYLimpiarItems() {
    $('.check-protocolo').css('display', 'block');
    $('#btnExportacion1').css('display', 'block');
    $('#allCheckLuces').css('display', 'block');
    $('#allCheckNoLuces').css('display', 'block');
    $('#showData').hide(); //escondo la lista de protocolos a mostrar;
    $('#protocolos-no-encontrados').hide();
    $('.conteiner-ajax').remove();
    $('.conteiner-ajax2').remove();
    $('.protocolos_listados').val('');
    $('.protocolos_listados2').val('');
}

$(document).ready(function() {

    $('#salidaDeEdicion').hide();

    $('li').click(function() {
        let value = $(this).attr('id');
        if(value == "liSalidDeEdicion"){
            $('#salidaDeEdicion').show();
        }else{
            $('#salidaDeEdicion').hide();
        }
    });

    $('#estado1').hide();
    $("#proyectoElegido").click(function() {
        let proyectoElegido = $('#proyectoElegido').val();
        if (proyectoElegido != 0) {
            $('#estado1').show();
        }
    });

    escondeYLimpiarItems();

    $('.salida_edicion_r').click(function() {
        boton = $(this).attr('id');
        var luces = [];
        var noLuces = [];
        cantLuces = 0;
        cantNoLuces = 0;
        total = 0;
        municipio = $('#proyectoElegido').val(); //me guardo los valores seleccionados por el usuario
        $("#btnExportacion").click(function() {

            escondeYLimpiarItems();

            //cada vez que se presiona el boton vuelvo a esconder los valores para poder volver a listarlos
            datos = $("#" + boton).val() + "," +
                municipio; //datos necesarios para la query de protocolos main
            $.ajax({
                url: "<?=base_url('reportes/salida_de_edicion');?>",
                type: "POST",
                ajax: true,
                data: {
                    datos
                }
            }).done(function(data) {

                if (data == "0") {
                    $('#protocolos-no-encontrados').show();
                } else {
                    data = JSON.parse(
                        data
                    );

                    $('#showData').show();
                    if (boton !== "editado") {

                        for (var j in
                                data) { //listo los datos que me llegaron en un input con su respectivo checkbox

                            $('#protocolos_a_listar').append(`<div class = "conteiner-ajax " style = "border: 1px  solid #c0c0c0; ">
                            <input type = "checkbox"
                            name = "protocolos_check[]"
                            value = "${data[j].id}"
                            class = "check-protocolo"
                            style = "display :block;"
                            >
                 <input type = "text"
                 class = 'form-control col-md-10 protocolos_listados'
                 value = "ID: ${data[j].id} - MUNICIPIO: ${data[j].municipio} - IDEXPORTACION: ${data[j].idexportacion} - SERIE: ${data[j].equipo_serie} - FECHA INICIAL: ${data[j].fecha_inicial} - FECHA FINAL: ${data[j].fecha_final} - APROBADOS: ${data[j].info_aprobados} - DESCARTADOS: ${data[j].info_descartados} - VERIFICACION: ${data[j].info_verificacion} - ARCHIVOS: ${data[j].archivos} - CANTIDAD: ${data[j].cantidad} - NRO EXPORTACION: ${data[j].numero_exportacion} "
                 readonly>
                 </div>
                 </div>
                `);
                            $('.check-protocolo').css('display', 'none');
                            $('#btnExportacion1').css('display', 'none');
                            $('#allCheckNoLuces').css('display', 'none');
                            $('#allCheckLuces').css('display', 'none');
                        }
                    } //ciere del if que me dice si apreto cualquier boton que no sea editado
                    else {
                        //lo primero que hago si el boton que apretan es editado es seprar los protocolos en luces y no luces

                        for (let i in data) {
                            if ((data[i].equipo_serie).includes('LUTEC') || (data[i]
                                    .equipo_serie).includes('DTV2')) {
                                luces.push(data[i]);
                                cantLuces++;
                            } else {
                                noLuces.push(data[i]);
                                cantNoLuces++;
                            }
                        }
                        //ciere del for de dividir arrays
                        $('#luces').html('<h3>Luces</h3>');
                        for (let j in
                                luces) { //listo los datos que me llegaron en un input con su respectivo checkbox

                            $('#protocolos_a_listar').append(`
                        <div class = "conteiner-ajax " style = "border: 1px  solid #c0c0c0; ">
                            <input type = "checkbox"
                                name = "protocolos_check[]"
                                value = "${luces[j].id}"
                                class = "check-protocolo-luces"
                                style = "display :block;"
                            >
                            <input type = "text"
                                class = 'form-control col-md-10 protocolos_listados'
                                value = "ID: ${luces[j].id} - MUNICIPIO: ${luces[j].municipio} - IDEXPORTACION: ${luces[j].idexportacion} - SERIE: ${luces[j].equipo_serie} - FECHA INICIAL: ${luces[j].fecha_inicial} - FECHA FINAL: ${luces[j].fecha_final} - APROBADOS: ${luces[j].info_aprobados} - DESCARTADOS: ${luces[j].info_descartados} - VERIFICACION: ${luces[j].info_verificacion} - ARCHIVOS: ${luces[j].archivos} - CANTIDAD: ${luces[j].cantidad} - NRO EXPORTACION: ${luces[j].numero_exportacion} "
                            readonly>
                        </div>
                 `);
                        }
                        $('#noluces').html('<h3>No Luces</h3>');
                        for (let j in
                                noLuces) { //listo los datos que me llegaron en un input con su respectivo checkbox

                            $('#protocolos_a_listar2').append(`<div class = "conteiner-ajax " style = "border: 1px  solid #c0c0c0; ">
                            <input type = "checkbox"
                            name = "protocolos_check[]"
                            value = "${noLuces[j].id}"
                            class = "check-protocolo-no-luces"
                            style = "display :block;"
                            >
                 <input type = "text"
                 class = 'form-control col-md-10 protocolos_listados'
                 value = "ID: ${noLuces[j].id} - MUNICIPIO: ${noLuces[j].municipio} - IDEXPORTACION: ${noLuces[j].idexportacion} - SERIE: ${noLuces[j].equipo_serie} - FECHA INICIAL: ${noLuces[j].fecha_inicial} - FECHA FINAL: ${noLuces[j].fecha_final} - APROBADOS: ${noLuces[j].info_aprobados} - DESCARTADOS: ${noLuces[j].info_descartados} - VERIFICACION: ${noLuces[j].info_verificacion} - ARCHIVOS: ${noLuces[j].archivos} - CANTIDAD: ${noLuces[j].cantidad} - NRO EXPORTACION: ${noLuces[j].numero_exportacion} "
                 readonly>
                 </div>
                 `);
                        }



                    } //llave del else que deberia encerrar todo el codigo que se ejecuta si apretaron editar

                }
                //SI CLCKEAN ALGUN PROTOCOLO QUE SEA DE LUCES LOS DE NO LUCES DESAPARECEN
                $('.check-protocolo-luces').on("click", function() {
                    if ($('.check-protocolo-luces').is(':checked')) {
                        $('#todo-no-luces').hide();
                    } else {
                        $('#todo-no-luces').show();
                    }
                });
                //SI CLICKEAN ALGUN PROTOCOLO QUE SEA DE NO LUCES ,LOS DE LUCES DESAPARECEN
                $('.check-protocolo-no-luces').on("click", function() {
                    if ($('.check-protocolo-no-luces').is(':checked')) {
                        $('#todo-luces').hide();
                    } else {
                        $('#todo-luces').show();
                    }
                });


                //SI SE LE DA CLICK AL CHECKBOX DE LUCES HACE QUE DESAPAREZCA TODO LO DE LUCES A PARTE DE TILDARSE TODO LO DE LUCES
                $("#check_general_luces").on("click", function() {
                    if ($('#check_general_luces').is(':checked')) {
                        $(".check-protocolo-luces").attr("checked", this
                            .checked);
                        $('#todo-no-luces').hide();
                    } else {
                        $(".check-protocolo-luces").attr("checked", this
                            .checked);
                        $('#todo-no-luces').show();
                    }
                });




                //SI SE LE DA CLICK AL CHECKBOX DE NO LUCES HACE QUE DESAPAREZCA TODO LO DE LUCES A PARTE DE TILDARSE TODO LO DE NO LUCES
                $("#check_general_no_luces").on("click", function() {
                    if ($('#check_general_no_luces').is(':checked')) {
                        $(".check-protocolo-no-luces").attr("checked", this
                            .checked);
                        $('#todo-luces').hide();
                    } else {
                        $(".check-protocolo-no-luces").attr("checked", this
                            .checked);
                        $('#todo-luces').show();


                    }
                });

                $('#btnExportacion1').on("click", function() {
                    setTimeout(function() {
                        location.href = "<?=base_url('reportes') ;?>"
                    }, 3000);
                });

            }); //llave cierre del done(lo que se ejecutta del conbtrolador en la vista)

        });

    });

})



//-----------HASTA ACA--------------------



$(document).ready(function() {
    $("#fechas_insta").hide();
    $("#label_fd_insta").hide();
    $("#label_fh_insta").hide();
    $("#icono_fd_insta").hide();
    $("#icono_fh_insta").hide();
    $("#fd_insta").hide();
    $("#fh_insta").hide();
    $('#rango_fecha').on('change', function() {
        rango_fecha = $(this).val();
        switch (rango_fecha) {
            case "0":
            case "7":
            case "14":
            case "30":
                $("#fechas_insta").hide();
                $("#label_fd_insta").hide();
                $("#label_fh_insta").hide();
                $("#icono_fd_insta").hide();
                $("#icono_fh_insta").hide();
                $("#fd_insta").hide();
                $("#fh_insta").hide();
                break;

            case "1":
                $("#fechas_insta").show();
                $("#label_fd_insta").show();
                $("#label_fh_insta").show();
                $("#icono_fd_insta").show();
                $("#icono_fh_insta").show();
                $("#fd_insta").show();
                $("#fh_insta").show();
                break;

        }
    });
});
</script>




<style>
.separador-tipo-protocolo {
    border: 0.5px solid #9c9c9c;
    color: #333;
    margin: 10px 0;
}

.conteiner-ingreso-de-datos {
    display: flex;
    justify-content: space-around;
    border: solid;

    /* align-items: center; */
}

.conteiner-ajax {

    align-items: center;
    justify-content: center;
}



/* .form-check{
display : flex;
}

.conteiner-ingreso-de-datos{




} */
</style>