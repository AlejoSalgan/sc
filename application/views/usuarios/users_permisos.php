<?php

$userId       = '';
$name         = '';

foreach ($userInfo as $uf)
{
    $userId = $uf->userId;
    $name   = $uf->name;
    $role   = $uf->role;
}

foreach ($permisosInfo as $uf)
{
    $equipos_marcas            = $uf->equipos_marcas;
    $equipos_equipos           = $uf->equipos_equipos;
    $equipos_tipos             = $uf->equipos_tipos;
    $equipos_modelos           = $uf->equipos_modelos;
    $equipos_propietarios      = $uf->equipos_propietarios;

    $componentes_componentes   = $uf->componentes_componentes;
    $componentes_sinAsignar    = $uf->componentes_sinAsignar;
    $componentes_marcas        = $uf->componentes_marcas;
    $componentes_tipos         = $uf->componentes_tipos;

    $bajada_ordServ            = $uf->bajada_ordServ;

    $bajada_ordSR              = $uf->bajada_ordSR;
    $bajada_ordSP              = $uf->bajada_ordSP;
    $bajada_ordProc            = $uf->bajada_ordProc;
    $bajada_ordAnul            = $uf->bajada_ordAnul;
    $bajada_ordCero            = $uf->bajada_ordCero;


    $bajada_grupoSE            = $uf->bajada_grupoSE;
    $bajada_grupoSR            = $uf->bajada_grupoSR;
    $bajada_grupoSP            = $uf->bajada_grupoSP;
    $bajada_grupoC             = $uf->bajada_grupoC;

    $ingreso_pendientes        = $uf->ingreso_pendientes;
    $ingreso_ingresados        = $uf->ingreso_ingresados;
    $ingreso_anulados          = $uf->ingreso_anulados;
    $ingreso_cero              = $uf->ingreso_cero;
    $ingreso_remotos              = $uf->ingreso_remotos;


    $novedades_novedades       = $uf->novedades_novedades;

    $mantenimiento_solicitudes = $uf->mantenimiento_solicitudes;
    $mantenimiento_ordenes     = $uf->mantenimiento_ordenes;

    $reparacion_solicitudes    = $uf->reparacion_solicitudes;
    $reparacion_ordenes        = $uf->reparacion_ordenes;

    $instalacion_solicitudes   = $uf->instalacion_solicitudes;
    $instalacion_ordenes       = $uf->instalacion_ordenes;

    $calibracion_solicitudes   = $uf->calibracion_solicitudes;
    $calibracion_ordenes       = $uf->calibracion_ordenes;
    $calibracion_ordenesP      = $uf->calibracion_ordenesP;

    $calibracion_rechazadas    = $uf->calibracion_rechazadas;
    $calibracion_finalizadas   = $uf->calibracion_finalizadas;
    $calibracion_aprobacion    = $uf->calibracion_aprobacion;

    $flota_flota               = $uf->flota_flota;

    $socios_solicitudes        = $uf->socios_solicitudes;
    $socios_remitos            = $uf->socios_remitos;
    $socios_finalizados        = $uf->socios_finalizados;
    $socios_rechazados         = $uf->socios_rechazados;

    $deposito_ingresos          = $uf->deposito_ingresos;
    $deposito_custodia         = $uf->deposito_custodia;
    $deposito_egreso          = $uf->deposito_egreso;
    $deposito_finalizadas      = $uf->deposito_finalizadas;

    $fotos_desencriptadas      = $uf->fotos_desencriptadas;

    $exportaciones_exportaciones      = $uf->exportaciones_exportaciones;
    $exportaciones_detalles      = $uf->exportaciones_detalles;

    $proyectos_proyectos      = $uf->proyectos_proyectos;
    $proyectos_asignaciones      = $uf->proyectos_asignaciones;



}

$EQequipos        = explode(',', $equipos_equipos);
$EQmarcas         = explode(',', $equipos_marcas);
$EQtipos          = explode(',', $equipos_tipos);
$EQmodelos        = explode(',', $equipos_modelos);
$EQpropietarios   = explode(',', $equipos_propietarios);

$COMcomponentes   = explode(',', $componentes_componentes);
$COMsinasignar    = explode(',', $componentes_sinAsignar);
$COMmarcas        = explode(',', $componentes_marcas);
$COMtipos         = explode(',', $componentes_tipos);

$BMordServ        = explode(',', $bajada_ordServ);
$BMordSR          = explode(',', $bajada_ordSR);
$BMordSP          = explode(',', $bajada_ordSP);
$BMordProc        = explode(',', $bajada_ordProc);
$BMordAnul        = explode(',', $bajada_ordAnul);
$BMordCero        = explode(',', $bajada_ordCero);

$BMgrupoSE        = explode(',', $bajada_grupoSE);
$BMgrupoSR        = explode(',', $bajada_grupoSR);
$BMgrupoSP        = explode(',', $bajada_grupoSP);
$BMgrupoC         = explode(',', $bajada_grupoC);

$INGpendientes    = explode(',', $ingreso_pendientes);
$INGingresados    = explode(',', $ingreso_ingresados);
$INGanulados      = explode(',', $ingreso_anulados);
$INGcero          = explode(',', $ingreso_cero);
$INGremotos          = explode(',', $ingreso_remotos);

$NOVnovedades     = explode(',', $novedades_novedades);

$MANTsolicitudes  = explode(',', $mantenimiento_solicitudes);
$MANTordenes      = explode(',', $mantenimiento_ordenes);

$REPAsolicitudes  = explode(',', $reparacion_solicitudes);
$REPAordenes      = explode(',', $reparacion_ordenes);

$INSTAsolicitudes = explode(',', $instalacion_solicitudes);
$INSTAordenes     = explode(',', $instalacion_ordenes);

$CALIBsolicitudes = explode(',', $calibracion_solicitudes);
$CALIBordenes     = explode(',', $calibracion_ordenes);
$CALIBordenesp    = explode(',', $calibracion_ordenesP);
$CALIBrechazadas  = explode(',', $calibracion_rechazadas);
$CALIBfinalizadas = explode(',', $calibracion_finalizadas);
$CALIBaprobacion  = explode(',', $calibracion_aprobacion);

$FLflota          = explode(',', $flota_flota);

$SOsolicitudes    = explode(',', $socios_solicitudes);
$SOremitos        = explode(',', $socios_remitos);
$SOfinalizados    = explode(',', $socios_finalizados);
$SOrechazados     = explode(',', $socios_rechazados);

$DEPingresos     = explode(',', $deposito_ingresos);
$DEPcustodia     = explode(',', $deposito_custodia);
$DEPegreso       = explode(',', $deposito_egreso);
$DEPfinalizadas  = explode(',', $deposito_finalizadas);

$FOTdesencriptadas   = explode(',', $fotos_desencriptadas);

$EXPexportaciones   = explode(',', $exportaciones_exportaciones);
$EXPdetalles   = explode(',', $exportaciones_detalles);

$PROproyectos   = explode(',', $proyectos_proyectos);
$PROasignaciones   = explode(',', $proyectos_asignaciones);

?>

<style media="screen">
  :checked + span[class="estado"] {
  color: #4281d8;
  }

  :not(:checked) + span[class="estado"] {
  color: #7e7e7e;
  }

  input[type="checkbox"] {
  display: none;
  }

  #icono {
  display: inline-block;
  border-radius: 60px;
  box-shadow: 0px 0px 2px #888;
  padding: 0.5em 0.6em;
  margin-left: 10px;
  margin-right: 8px;
  }

  #titulo {
    margin-left: 5px;
  }
</style>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Usuarios - Agregar Permisos
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?=base_url('userListing/0/1')?>">Usuarios</a> /
  		  <span class="text-muted">Agregar Permisos</span>
  		</span>
  	</div>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> <?=$name?> - <?=$role?></h3>
             </div>
            </div>
          </div>
         </div>

         <div class="row">
             <div class="col-md-2">
               <div class="form-group">
                 <form action="<?= base_url('agregar_permisos') ?>" method="POST">
                 <input type="hidden" value="<?= $userId; ?>" name="userId" />
                 <input type="submit" class="btn btn-primary btn-block margin-bottom" accesskey="s" value="Guardar" />
              </div>

               <div class="tabbable">
                 <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
                   <li class="active"><a href="#Equipos" data-toggle="tab">Equipos</a></li>
                   <li><a href="#Componentes" data-toggle="tab">Componentes</a></li>
                   <li><a href="#Bajada" data-toggle="tab">Bajada de Memoria</a></li>
                   <li><a href="#Ingreso" data-toggle="tab">Ingreso de Datos</a></li>
                   <li><a href="#Novedades" data-toggle="tab">Novedades</a></li>
                   <li><a href="#Mantenimiento" data-toggle="tab">Mantenimiento</a></li>
                   <li><a href="#Reparaciones" data-toggle="tab">Reparaciones</a></li>
                   <li><a href="#Instalaciones" data-toggle="tab">Instalaciones</a></li>
                   <li><a href="#Calibraciones" data-toggle="tab">Calibraciones</a></li>
                   <li><a href="#Flota" data-toggle="tab">Flota</a></li>
                   <li><a href="#Socios" data-toggle="tab">Socios</a></li>
                   <li><a href="#Deposito" data-toggle="tab">Deposito</a></li>
                   <li><a href="#Fotos" data-toggle="tab">Fotos Desencriptadas</a></li>
                   <li><a href="#Exportaciones" data-toggle="tab">Exportaciones</a></li>
                   <li><a href="#Proyectos" data-toggle="tab">Proyectos</a></li>



                 </ul>
               </div>
             </div>

             <div class="col-md-10">
               <div class="tab-content">

                 <div class="tab-pane active" id="Equipos">
                   <div class="box">
                     <div class="box-body table-responsive no-padding">
                           <h4 id="titulo"> Equipos</h4>
                           <ul class="products-list product-list-in-box">
                               <?php
                                 $equipos = array('equipos_agregar' => 'Agregar Equipos',
                                  'equipos_evento' => 'Nuevo Evento',
                                  'equipos_editar' => 'Editar Equipo',
                                  'equipos_historial' => 'Historial',
                                  'equipos_componentes' => 'Asignar Componentes',
                                  'equipos_actDesact' => 'Desactivar / Activar',
                                  'equipos_ver' => 'Ver Detalle',
                                  'equipos_solicitud' => 'Activar / Desactivar Solicitud Bajada'); ?>
                                 <?php $icono = array('fa fa-plus', 'fa fa-plus-square-o', 'fa fa-pencil', 'fa fa-history', 'fa fa-plus', 'fa fa-power-off', 'fa fa-info-circle', 'fa fa-play-circle');
                                 $count = 0;
                                 foreach ($equipos as $equipo => $nombre): ?>
                                 <li class="item">
                                      <label><input type="checkbox" id="<?=$equipo?>" name="<?=$equipo?>" value="1" <?php if($EQequipos[$count] == 1) {echo 'checked="checked"';} ?>>
                                         <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                      </label>
                                </li>
                                 <?php
                                 $count = $count +1;
                                 endforeach; ?>
        		                </ul>
                       </div>
                     </div>

                     <div class="box">
                       <div class="box-body table-responsive no-padding">
                             <h4 id="titulo"> Marcas</h4>
                             <ul class="products-list product-list-in-box">
                                 <?php
                                   $marcas = array('marcas_agregar' => 'Agregar' , 'marcas_editar' => 'Editar', 'marcas_cancelar' => 'Cancelar');
                                   $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                   $count = 0;
                                   foreach ($marcas as $marca => $nombre): ?>
                                   <li class="item">
                                        <label><input type="checkbox" id="<?=$marca?>" name="<?=$marca?>" value="1" <?php if($EQmarcas[$count] == 1) {echo 'checked="checked"';} ?>>
                                           <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                        </label>
                                  </li>
                                   <?php
                                   $count = $count +1;
                                   endforeach; ?>
          		                </ul>
                         </div>
                       </div>


                       <div class="box">
                         <div class="box-body table-responsive no-padding">
                               <h4 id="titulo"> Tipos</h4>
                               <ul class="products-list product-list-in-box">
                                   <?php
                                     $tipos = array('tipos_agregar' => 'Agregar' , 'tipos_editar' => 'Editar', 'tipos_cancelar' => 'Cancelar');
                                     $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                     $count = 0;
                                     foreach ($tipos as $tipo => $nombre): ?>
                                     <li class="item">
                                          <label><input type="checkbox" id="<?=$tipo?>" name="<?=$tipo?>" value="1" <?php if($EQtipos[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                    </li>
                                     <?php
                                     $count = $count +1;
                                     endforeach; ?>
            		                </ul>
                           </div>
                         </div>

                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Modelos</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $modelos = array('modelos_agregar' => 'Agregar' , 'modelos_editar' => 'Editar', 'modelos_cancelar' => 'Cancelar');
                                       $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                       $count = 0;
                                       foreach ($modelos as $modelo => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$modelo?>" name="<?=$modelo?>" value="1" <?php if($EQmodelos[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Propietarios</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $propietarios = array('propietarios_agregar' => 'Agregar' , 'propietarios_editar' => 'Editar', 'propietarios_cancelar' => 'Cancelar');
                                         $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                         $count = 0;
                                         foreach ($propietarios as $propietario => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$propietario?>" name="<?=$propietario?>" value="1" <?php if($EQpropietarios[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>
                   </div>


                   <div class="tab-pane" id="Componentes">
                     <div class="box">
                       <div class="box-body table-responsive no-padding">
                             <h4 id="titulo"> Componentes</h4>
                             <ul class="products-list product-list-in-box">
                                 <?php
                                   $componentes = array('componentes_agregar' => 'Agregar Componente',
                                   'componentes_agregarS' => 'Agregar Componente Serie',
                                    'componentes_editar' => 'Editar',
                                     'componentes_cancelar' => 'Cancelar',
                                      'componentes_historial' => 'Historial');
                                   $icono = array('fa fa-plus', 'fa fa-plus', 'fa fa-edit', 'fa fa-trash', 'fa fa-history');
                                   $count = 0;
                                   foreach ($componentes as $componente => $nombre): ?>
                                   <li class="item">
                                        <label><input type="checkbox" id="<?=$componente?>" name="<?=$componente?>" value="1" <?php if($COMcomponentes[$count] == 1) {echo 'checked="checked"';} ?>>
                                           <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                        </label>
                                  </li>
                                   <?php
                                   $count = $count +1;
                                   endforeach; ?>
          		                </ul>
                         </div>
                       </div>

                       <div class="box">
                         <div class="box-body table-responsive no-padding">
                               <h4 id="titulo"> Sin Asignar</h4>
                               <ul class="products-list product-list-in-box">
                                   <?php
                                     $componentesSA = array('sinAsginar_agregar' => 'Agregar Componente',
                                     'sinAsginar_agregarS' => 'Agregar Componente Serie',
                                      'sinAsginar_editar' => 'Editar',
                                       'sinAsginar_cancelar' => 'Cancelar',
                                        'sinAsginar_historial' => 'Historial');
                                     $icono = array('fa fa-plus', 'fa fa-plus', 'fa fa-edit', 'fa fa-trash', 'fa fa-history');
                                     $count = 0;
                                     foreach ($componentesSA as $componenteSA => $nombre): ?>
                                     <li class="item">
                                          <label><input type="checkbox" id="<?=$componenteSA?>" name="<?=$componenteSA?>" value="1" <?php if($COMsinasignar[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                    </li>
                                     <?php
                                     $count = $count +1;
                                     endforeach; ?>
            		                </ul>
                           </div>
                         </div>

                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Marcas</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $marcasC = array('marcasC_agregar' => 'Agregar' , 'marcasC_editar' => 'Editar', 'marcasC_cancelar' => 'Cancelar');
                                       $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                       $count = 0;
                                       foreach ($marcasC as $marcaC => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$marcaC?>" name="<?=$marcaC?>" value="1" <?php if($COMmarcas[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Tipos</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $tiposC = array('tiposC_agregar' => 'Agregar' , 'tiposC_editar' => 'Editar', 'tiposC_cancelar' => 'Cancelar');
                                       $icono = array('fa fa-plus', 'fa fa-edit' , 'fa fa-trash');
                                       $count = 0;
                                       foreach ($tiposC as $tipoC => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$tipoC?>" name="<?=$tipoC?>" value="1" <?php if($COMtipos[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
              		                </ul>
                             </div>
                           </div>
                     </div>


                     <div class="tab-pane" id="Bajada">
                       <div class="box">
                         <div class="box-body table-responsive no-padding">
                               <h4 id="titulo"> Ordenes de Servicio</h4>
                               <ul class="products-list product-list-in-box">
                                   <?php
                                     $ordenes_baj = array('OS_agregar' => 'Agregar Orden de Servicio',
                                     'OS_ver' => 'Ver Detalle',
                                      'OS_editar' => 'Editar',
                                       'OS_cancelar' => 'Cancelar',
                                        'OS_enviar' => 'Enviar');
                                     $icono = array('fa fa-plus', 'fa fa-info-circle', 'fa fa-edit', 'fa fa-trash', 'fa fa-share-square-o');
                                     $count = 0;
                                     foreach ($ordenes_baj as $orden_baj => $nombre): ?>
                                     <li class="item">
                                          <label><input type="checkbox" id="<?=$orden_baj?>" name="<?=$orden_baj?>" value="1" <?php if($BMordServ[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                    </li>
                                     <?php
                                     $count = $count +1;
                                     endforeach; ?>
            		                </ul>
                           </div>
                         </div>

                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Ordenes Sin Recibir</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $ordenes_sr = array('OSR_ver' => 'Ver Detalle',
                                       'OSR_cancelarEnvio' => 'Cancelar Envio');
                                       $icono = array('fa fa-info-circle', 'fa fa-times');
                                       $count = 0;
                                       foreach ($ordenes_sr as $orden_sr => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$orden_sr?>" name="<?=$orden_sr?>" value="1" <?php if($BMordSR[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
              		                </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ordenes Sin Procesar</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $ordenes_sp = array('OSP_ver' => 'Ver Detalle',
                                         'OSP_cancelarEnvio' => 'Cancelar Envio');
                                         $icono = array('fa fa-info-circle', 'fa fa-times');
                                         $count = 0;
                                         foreach ($ordenes_sp as $orden_sp => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$orden_sp?>" name="<?=$orden_sp?>" value="1" <?php if($BMordSP[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                		                </ul>
                               </div>
                             </div>

                             <div class="box">
                               <div class="box-body table-responsive no-padding">
                                     <h4 id="titulo"> Ordenes Procesadas</h4>
                                     <ul class="products-list product-list-in-box">
                                         <?php
                                           $ordenes_pro = array('OP_ver' => 'Ver Detalle',
                                           'OP_cancelarEnvio' => 'Cancelar Envio');
                                           $icono = array('fa fa-info-circle', 'fa fa-times');
                                           $count = 0;
                                           foreach ($ordenes_pro as $orden_pro => $nombre): ?>
                                           <li class="item">
                                                <label><input type="checkbox" id="<?=$orden_pro?>" name="<?=$orden_pro?>" value="1" <?php if($BMordProc[$count] == 1) {echo 'checked="checked"';} ?>>
                                                   <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                </label>
                                          </li>
                                           <?php
                                           $count = $count +1;
                                           endforeach; ?>
                  		                </ul>
                                 </div>
                               </div>








                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Ordenes Anuladas</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $ordenes_anuladas = array('OA_ver' => 'Ver Detalle');
                                             $icono = array('fa fa-info-circle');
                                             $count = 0;
                                             foreach ($ordenes_anuladas as $orden_anulada => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$orden_anulada?>" name="<?=$orden_anulada?>" value="1" <?php if($BMordAnul[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                    		                </ul>
                                   </div>
                                 </div>



                                 <div class="box">
                                   <div class="box-body table-responsive no-padding">
                                         <h4 id="titulo"> Ordenes Cero</h4>
                                         <ul class="products-list product-list-in-box">
                                             <?php
                                               $ordenes_ceros = array('OCE_ver' => 'Ver Detalle');
                                               $icono = array('fa fa-info-circle');
                                               $count = 0;
                                               foreach ($ordenes_ceros as $orden_cero => $nombre): ?>
                                               <li class="item">
                                                    <label><input type="checkbox" id="<?=$orden_cero?>" name="<?=$orden_cero?>" value="1" <?php if($BMordCero[$count] == 1) {echo 'checked="checked"';} ?>>
                                                       <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                    </label>
                                              </li>
                                               <?php
                                               $count = $count +1;
                                               endforeach; ?>
                      		                </ul>
                                     </div>
                                   </div>









                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Grupos - Sin Enviar</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $grupos_se = array('GSE_ver' => 'Ver Detalle',
                                             'GSE_editar' => 'Editar',
                                             'GSE_enviarOrd' => 'Enviar Ordenes',
                                             'GSE_verCerco' => 'Ver Detalle (Cerco)',
                                             'GSE_editarCerco' => 'Editar (Cerco)',
                                             'GSE_enviarCerco' => 'Enviar Ordenes (Cerco)');
                                             $icono = array('fa fa-info-circle', 'fa fa-edit', 'fa fa-share-square-o', 'fa fa-info-circle', 'fa fa-edit', 'fa fa-share-square-o');
                                             $count = 0;
                                             foreach ($grupos_se as $grupo_se => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$grupo_se?>" name="<?=$grupo_se?>" value="1" <?php if($BMgrupoSE[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                    		                </ul>
                                   </div>
                                 </div>

                                 <div class="box">
                                   <div class="box-body table-responsive no-padding">
                                         <h4 id="titulo"> Grupos - Sin Recibir</h4>
                                         <ul class="products-list product-list-in-box">
                                             <?php
                                               $grupos_sr = array('GSR_ver' => 'Ver Detalle',
                                               'GSR_cancelarEnvio' => 'Cancelar Envio');
                                               $icono = array('fa fa-info-circle', 'fa fa-times');
                                               $count = 0;
                                               foreach ($grupos_sr as $grupo_sr => $nombre): ?>
                                               <li class="item">
                                                    <label><input type="checkbox" id="<?=$grupo_sr?>" name="<?=$grupo_sr?>" value="1" <?php if($BMgrupoSR[$count] == 1) {echo 'checked="checked"';} ?>>
                                                       <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                    </label>
                                              </li>
                                               <?php
                                               $count = $count +1;
                                               endforeach; ?>
                      		                </ul>
                                     </div>
                                   </div>

                                   <div class="box">
                                     <div class="box-body table-responsive no-padding">
                                           <h4 id="titulo"> Grupos - Sin Procesar</h4>
                                           <ul class="products-list product-list-in-box">
                                               <?php
                                                 $grupos_sp = array('GSP_ver' => 'Ver Detalle',
                                                 'GSP_cancelarEnvio' => 'Cancelar Envio');
                                                 $icono = array('fa fa-info-circle', 'fa fa-times');
                                                 $count = 0;
                                                 foreach ($grupos_sp as $grupo_sp => $nombre): ?>
                                                 <li class="item">
                                                      <label><input type="checkbox" id="<?=$grupo_sp?>" name="<?=$grupo_sp?>" value="1" <?php if($BMgrupoSP[$count] == 1) {echo 'checked="checked"';} ?>>
                                                         <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                      </label>
                                                </li>
                                                 <?php
                                                 $count = $count +1;
                                                 endforeach; ?>
                        		                </ul>
                                       </div>
                                     </div>

                                     <div class="box">
                                       <div class="box-body table-responsive no-padding">
                                             <h4 id="titulo"> Grupos - Cerco</h4>
                                             <ul class="products-list product-list-in-box">
                                                 <?php
                                                   $grupos_cerco = array('GC_ver' => 'Ver Detalle',
                                                   'GC_cancelarEnvio' => 'Cancelar Envio');
                                                   $icono = array('fa fa-info-circle', 'fa fa-times');
                                                   $count = 0;
                                                   foreach ($grupos_cerco as $grupo_cerco => $nombre): ?>
                                                   <li class="item">
                                                        <label><input type="checkbox" id="<?=$grupo_cerco?>" name="<?=$grupo_cerco?>" value="1" <?php if($BMgrupoC[$count] == 1) {echo 'checked="checked"';} ?>>
                                                           <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                        </label>
                                                  </li>
                                                   <?php
                                                   $count = $count +1;
                                                   endforeach; ?>
                          		                </ul>
                                         </div>
                                       </div>
                       </div>



                       <div class="tab-pane" id="Ingreso">

                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Protocolos Pendientes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $protocolos_pen = array('pendientes_ver' => 'Ver Detalle',
                                       'pendientes_editar' => 'Editar',
                                       'pendientes_cancelar' => 'Cancelar',
                                       'pendientes_finalizar' => 'Finalizar',
                                       'pendientes_dividir' => 'Dividir Protocolo',
                                       'pendientes_enlazar' => 'Enlazar Protocolo');
                                       $icono = array('fa fa-info-circle', 'fa fa-edit', 'fa fa-trash', 'fa fa-check','fa fa-cut','fa fa-random');
                                       $count = 0;
                                       foreach ($protocolos_pen as $protocolo_pen => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$protocolo_pen?>" name="<?=$protocolo_pen?>" value="1" <?php if($INGpendientes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Protocolos Ingresados</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $protocolos_ing = array('ingresados_ver' => 'Ver Detalle', 'ingresados_estado' => 'Cambiar estado'
                                         );
                                         $icono = array('fa fa-info-circle', 'fa fa-undo');
                                         $count = 0;
                                         foreach ($protocolos_ing as $protocolo_ing => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$protocolo_ing?>" name="<?=$protocolo_ing?>" value="1" <?php if($INGingresados[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>

                             <div class="box">
                               <div class="box-body table-responsive no-padding">
                                     <h4 id="titulo"> Protocolos Anulados</h4>
                                     <ul class="products-list product-list-in-box">
                                         <?php
                                           $protocolos_anu = array('anulados_ver' => 'Ver Detalle'
                                           );
                                           $icono = array('fa fa-info-circle');
                                           $count = 0;
                                           foreach ($protocolos_anu as $protocolo_anu => $nombre): ?>
                                           <li class="item">
                                                <label><input type="checkbox" id="<?=$protocolo_anu?>" name="<?=$protocolo_anu?>" value="1" <?php if($INGanulados[$count] == 1) {echo 'checked="checked"';} ?>>
                                                   <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                </label>
                                          </li>
                                           <?php
                                           $count = $count +1;
                                           endforeach; ?>
                                      </ul>
                                 </div>
                               </div>

                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Protocolos Ceros</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $protocolos_ceros = array('ceros_ver' => 'Ver Detalle'
                                             );
                                             $icono = array('fa fa-info-circle');
                                             $count = 0;
                                             foreach ($protocolos_ceros as $protocolo_cero => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$protocolo_cero?>" name="<?=$protocolo_cero?>" value="1" <?php if($INGcero[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                                        </ul>
                                   </div>
                                 </div>





                                 <div class="box">
                                   <div class="box-body table-responsive no-padding">
                                         <h4 id="titulo"> Protocolos Remotos</h4>
                                         <ul class="products-list product-list-in-box">
                                             <?php
                                               $protocolos_remotos = array('remotos_agregar' => 'Nuevo Protocolo', 'remotos_anular' => 'Anular Protocolo', 'remotos_decripto' => 'Decripto 1'
                                               );
                                               $icono = array('fa fa-plus', 'fa fa-trash', 'fa fa-check');
                                               $count = 0;
                                               foreach ($protocolos_remotos as $protocolo_remoto => $nombre): ?>
                                               <li class="item">
                                                    <label><input type="checkbox" id="<?=$protocolo_remoto?>" name="<?=$protocolo_remoto?>" value="1" <?php if($INGremotos[$count] == 1) {echo 'checked="checked"';} ?>>
                                                       <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                    </label>
                                              </li>
                                               <?php
                                               $count = $count +1;
                                               endforeach; ?>
                                          </ul>
                                     </div>
                                   </div>





                       </div>




                       <div class="tab-pane" id="Novedades">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Novedades</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $novedades = array('nov_envRepa' => 'Enviar Reparaciones',
                                       'nov_envMante' => 'Enviar Mantanimiento',
                                       'nov_selec' => 'Seleccionar',
                                       'nov_ver' => 'Ver Detalle',
                                       'nov_crear' => 'Crear novedad',
                                       'nov_desestimar' => 'Desestimar');
                                       $icono = array('fa fa-gear', 'fa fa-wrench', 'fa fa-check-square', 'fa fa-info-circle','fa fa-plus','fa fa-times');
                                       $count = 0;
                                       foreach ($novedades as $novedad => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$novedad?>" name="<?=$novedad?>" value="1" <?php if($NOVnovedades[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>
                       </div>


                       <div class="tab-pane" id="Mantenimiento">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Solicitudes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $man_solicitudes = array('mantS_crearOrdSelec' => 'Crear Ordenes Seleccionadas',
                                       'mantS_rechazarSoli' => 'Rechazar Solicitudes Seleccionadas',
                                       'mantS_crearSoli' => 'Crear solicitud nueva',
                                       'mantS_seleccionar' => 'Selecionar',
                                       'mantS_ver' => 'Ver Detalle');
                                       $icono = array('fa fa-check', 'fa fa-times', 'fa fa-plus', 'fa fa-check-square','fa fa-info-circle');
                                       $count = 0;
                                       foreach ($man_solicitudes as $man_solicitud => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$man_solicitud?>" name="<?=$man_solicitud?>" value="1" <?php if($MANTsolicitudes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ordenes</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $man_ordenes = array('mantO_ordenNueva' => 'Crear Orden Nueva',
                                         'mantO_verEditar' => 'Ver / Editar',
                                         'mantO_enviar' => 'Enviar celular',
                                         'mantO_finalizar' => 'Finalizar',
                                         'mantO_agregarVisitas' => 'Agregar nueva visitas',
                                         'mantO_adjArchivo' => 'Adjuntar Archivo',
                                         'mantO_cancelarOrden' => 'Cancelar Orden'
                                        );
                                         $icono = array('fa fa-plus', 'fa fa-info-circle', 'fa fa-arrow-right', 'fa fa-check','fa fa-plus','fa fa-file','fa fa-times');
                                         $count = 0;
                                         foreach ($man_ordenes as $man_orden => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$man_orden?>" name="<?=$man_orden?>" value="1" <?php if($MANTordenes[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>
                       </div>


                       <div class="tab-pane" id="Reparaciones">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Solicitudes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $repa_solicitudes = array('repaS_crearOrdSelec' => 'Crear Ordenes Seleccionadas',
                                       'repaS_rechazarSoli' => 'Rechazar Solicitudes Seleccionadas',
                                       'repaS_crearSoli' => 'Crear solicitud nueva',
                                       'repaS_seleccionar' => 'Selecionar',
                                       'repaS_ver' => 'Ver Detalle');
                                       $icono = array('fa fa-check', 'fa fa-times', 'fa fa-plus', 'fa fa-check-square','fa fa-info-circle');
                                       $count = 0;
                                       foreach ($repa_solicitudes as $repa_solicitud => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$repa_solicitud?>" name="<?=$repa_solicitud?>" value="1" <?php if($REPAsolicitudes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ordenes</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $repa_ordenes = array('repaO_ordenNueva' => 'Crear Orden Nueva',
                                         'repaO_verEditar' => 'Ver / Editar',
                                         'repaO_reasignar' => 'Reasignar',
                                         'repaO_enviar' => 'Enviar celular',
                                         'repaO_finalizar' => 'Finalizar',
                                         'repaO_agregarVisitas' => 'Agregar nueva visitas',
                                         'repaO_enviarSocio' => 'Enviar Socio',
                                         'repaO_recibirEquipo' => 'Recibir equipo',
                                         'repaO_adjArchivo' => 'Adjuntar Archivo',
                                         'repaO_cancelarOrden' => 'Cancelar Orden'
                                        );
                                         $icono = array('fa fa-plus', 'fa fa-info-circle', 'fa fa-share', 'fa fa-arrow-right', 'fa fa-check','fa fa-plus', 'fa fa-arrow-up', 'fa fa-arrow-down', 'fa fa-file','fa fa-times');
                                         $count = 0;
                                         foreach ($repa_ordenes as $repa_orden => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$repa_orden?>" name="<?=$repa_orden?>" value="1" <?php if($REPAordenes[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>
                       </div>


                       <div class="tab-pane" id="Instalaciones">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Solicitudes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $insta_solicitudes = array('instaS_crearOrdSelec' => 'Crear Ordenes Seleccionadas',
                                       'instaS_rechazarSoli' => 'Rechazar Solicitudes Seleccionadas',
                                       'instaS_crearSoli' => 'Crear solicitud nueva',
                                       'instaS_seleccionar' => 'Selecionar',
                                       'instaS_ver' => 'Ver Detalle');
                                       $icono = array('fa fa-check', 'fa fa-times', 'fa fa-plus', 'fa fa-check-square','fa fa-info-circle');
                                       $count = 0;
                                       foreach ($insta_solicitudes as $insta_solicitud => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$insta_solicitud?>" name="<?=$insta_solicitud?>" value="1" <?php if($INSTAsolicitudes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ordenes</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $insta_ordenes = array('instaO_ordenNueva' => 'Crear Orden Nueva',
                                         'instaO_verEditar' => 'Ver / Editar',
                                         'instaO_reasignar' => 'Reasignar',
                                         'instaO_enviar' => 'Enviar celular',
                                         'instaO_finalizar' => 'Finalizar',
                                         'instaO_agregarVisitas' => 'Agregar nueva visitas',
                                         'instaO_agregarCortes' => 'Agregar nueva fecha corte',
                                         'instaO_adjArchivo' => 'Adjuntar Archivo',
                                         'instaO_cancelarOrden' => 'Cancelar Orden'
                                        );
                                         $icono = array('fa fa-plus', 'fa fa-info-circle', 'fa fa-share', 'fa fa-arrow-right', 'fa fa-check','fa fa-plus', 'fa fa-calendar',  'fa fa-file', 'fa fa-times');
                                         $count = 0;
                                         foreach ($insta_ordenes as $insta_orden => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$insta_orden?>" name="<?=$insta_orden?>" value="1" <?php if($INSTAordenes[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>
                       </div>


                       <div class="tab-pane" id="Calibraciones">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Solicitudes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $cali_solicitudes = array(
                                       'CS_SolicitarParciales' => 'Solicitiar Parciales',
                                       'CS_agregarSolicitud' => 'Agregar Solicitud Calibración',
                                       'CS_ver' => 'Ver Detalle',

                                       'CS_editarG' => 'Editar Solicitud',
                                       'CS_editarC' => 'Editar Pedido',
                                       'CS_cancelarG' => 'Cancelar',

                                       'CS_aprobarG' => 'Solicitar Calibracion',
                                       'CS_aprobarC' => 'Solicitar Aprobacion');
                                       $icono = array(
                                       'fa fa-plus',
                                       'fa fa-plus',
                                       'fa fa-info-circle',

                                       'fa fa-edit',
                                       'fa fa-edit',
                                       'fa fa-trash',

                                       'fa fa-check',
                                       'fa fa-check');
                                       $count = 0;
                                       foreach ($cali_solicitudes as $cali_solicitud => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$cali_solicitud?>" name="<?=$cali_solicitud?>" value="1" <?php if($CALIBsolicitudes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ordenes</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $cali_ordenes = array(
                                         'CO_ver' => 'Ver Detalle',
                                         'CO_editar' => 'Editar',
                                         'CO_cancelar' => 'Cancelar',
                                         'CO_ordPendiente' => 'Orden Pendiente',
                                         'CO_finalizar' => 'Finalizar Orden'
                                        );
                                         $icono = array(
                                           'fa fa-info-circle',
                                           'fa fa-edit',
                                           'fa fa-trash',
                                           'fa fa-arrow-circle-right',
                                           'fa fa-check');
                                         $count = 0;
                                         foreach ($cali_ordenes as $cali_orden => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$cali_orden?>" name="<?=$cali_orden?>" value="1" <?php if($CALIBordenes[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>

                             <div class="box">
                               <div class="box-body table-responsive no-padding">
                                     <h4 id="titulo"> Ordenes - Pendientes</h4>
                                     <ul class="products-list product-list-in-box">
                                         <?php
                                           $cali_ordenesP = array(
                                           'COP_ver' => 'Ver Detalle',
                                           'COP_editar' => 'Editar',
                                           'COP_cancelar' => 'Cancelar',
                                           'COP_finalizar' => 'Finalizar'
                                          );
                                           $icono = array(
                                             'fa fa-info-circle',
                                           'fa fa-edit',
                                           'fa fa-trash',
                                           'fa fa-check');
                                           $count = 0;
                                           foreach ($cali_ordenesP as $cali_ordenP => $nombre): ?>
                                           <li class="item">
                                                <label><input type="checkbox" id="<?=$cali_ordenP?>" name="<?=$cali_ordenP?>" value="1" <?php if($CALIBordenesp[$count] == 1) {echo 'checked="checked"';} ?>>
                                                   <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                </label>
                                          </li>
                                           <?php
                                           $count = $count +1;
                                           endforeach; ?>
                                      </ul>
                                 </div>
                               </div>

                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Ordenes - Rechazadas</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $cali_rechazadas = array(
                                             'COR_ver' => 'Ver Detalle'

                                            );
                                             $icono = array(
                                               'fa fa-info-circle');
                                             $count = 0;
                                             foreach ($cali_rechazadas as $cali_rechazada => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$cali_rechazada?>" name="<?=$cali_rechazada?>" value="1" <?php if($CALIBrechazadas[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                                        </ul>
                                   </div>
                                 </div>

                                 <div class="box">
                                   <div class="box-body table-responsive no-padding">
                                         <h4 id="titulo"> Ordenes - Finalizadas</h4>
                                         <ul class="products-list product-list-in-box">
                                             <?php
                                               $cali_finalizadas = array(
                                               'COF_ver' => 'Ver Detalle'

                                              );
                                               $icono = array(
                                                 'fa fa-info-circle');
                                               $count = 0;
                                               foreach ($cali_finalizadas as $cali_finalizada=> $nombre): ?>
                                               <li class="item">
                                                    <label><input type="checkbox" id="<?=$cali_finalizada?>" name="<?=$cali_finalizada?>" value="1" <?php if($CALIBfinalizadas[$count] == 1) {echo 'checked="checked"';} ?>>
                                                       <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                    </label>
                                              </li>
                                               <?php
                                               $count = $count +1;
                                               endforeach; ?>
                                          </ul>
                                     </div>
                                   </div>

                                   <div class="box">
                                     <div class="box-body table-responsive no-padding">
                                           <h4 id="titulo"> Aprobacion</h4>
                                           <ul class="products-list product-list-in-box">
                                               <?php
                                                 $cali_aprobaciones = array(
                                                 'AP_ver' => 'Ver Detalle',
                                                 'AP_agregar' => 'Agregar datos',
                                                 'AP_aprobar' => 'Aprobar compra'
                                                );
                                                 $icono = array(
                                                   'fa fa-info-circle', 'fa fa-plus', 'fa fa-check');
                                                 $count = 0;
                                                 foreach ($cali_aprobaciones as $cali_aprobacion=> $nombre): ?>
                                                 <li class="item">
                                                      <label><input type="checkbox" id="<?=$cali_aprobacion?>" name="<?=$cali_aprobacion?>" value="1" <?php if($CALIBaprobacion[$count] == 1) {echo 'checked="checked"';} ?>>
                                                         <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                      </label>
                                                </li>
                                                 <?php
                                                 $count = $count +1;
                                                 endforeach; ?>
                                            </ul>
                                       </div>
                                     </div>
                       </div>


                       <div class="tab-pane" id="Flota">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Flota</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $flotas = array('flota_agregar' => 'Agregar Vehiculos',
                                       'flota_editar' => 'Editar',
                                       'flota_cancelar' => 'Cancelar');
                                       $icono = array('fa fa-plus', 'fa fa-edit', 'fa fa-trash');
                                       $count = 0;
                                       foreach ($flotas as $flota => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$flota?>" name="<?=$flota?>" value="1" <?php if($FLflota[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>
                       </div>


                       <div class="tab-pane" id="Socios">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Solicitudes</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $solicitudes_so = array('SOSoli_recibir' => 'Recibir equipo',
                                       'SOSoli_cancelar' => 'Cancelar remito');
                                       $icono = array('fa fa-check', 'fa fa-times');
                                       $count = 0;
                                       foreach ($solicitudes_so as $solicitud_so => $nombre): ?>
                                       <li class="item">
                                            <label><input type="checkbox" id="<?=$solicitud_so?>" name="<?=$solicitud_so?>" value="1" <?php if($SOsolicitudes[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Remitos</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $remitos_so = array('SORemitos_ver' => 'Ver detalle',
                                         'SORemitos_agregar' => 'Agregar eventos',
                                         'SORemitos_solicitar' => 'Solicitar presupuesto',
                                         'SORemitos_verPresupuesto' => 'Ver presupuesto',
                                         'SORemitos_finalizar' => 'Finalizar');
                                         $icono = array('fa fa-info-circle', 'fa fa-plus', 'fa fa-arrow-circle-right', 'fa fa-file' ,'fa fa-check');
                                         $count = 0;
                                         foreach ($remitos_so as $remito_so => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$remito_so?>" name="<?=$remito_so?>" value="1" <?php if($SOremitos[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>

                             <div class="box">
                               <div class="box-body table-responsive no-padding">
                                     <h4 id="titulo"> Finalizados</h4>
                                     <ul class="products-list product-list-in-box">
                                         <?php
                                           $finalizados_so = array('SOFin_ver' => 'Ver detalle'
                                           );
                                           $icono = array('fa fa-info-circle');
                                           $count = 0;
                                           foreach ($finalizados_so as $finalizado_so => $nombre): ?>
                                           <li class="item">
                                                <label><input type="checkbox" id="<?=$finalizado_so?>" name="<?=$finalizado_so?>" value="1" <?php if($SOfinalizados[$count] == 1) {echo 'checked="checked"';} ?>>
                                                   <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                </label>
                                          </li>
                                           <?php
                                           $count = $count +1;
                                           endforeach; ?>
                                      </ul>
                                 </div>
                               </div>

                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Rechazadas</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $rechazados_so = array('SORec_ver' => 'Ver detalle'
                                             );
                                             $icono = array('fa fa-info-circle');
                                             $count = 0;
                                             foreach ($rechazados_so as $rechazado_so => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$rechazado_so?>" name="<?=$rechazado_so?>" value="1" <?php if($SOrechazados[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                                        </ul>
                                   </div>
                                 </div>
                       </div>
















                      <div class="tab-pane" id="Deposito">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Ingresos</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $ingresos_dep = array(
                                         'DEPIngresos_ver' => 'Ver detalle',
                                         'DEPIngresos_recibir' => 'Recibir equipo',
                                         'DEPIngresos_nuevo' => 'Nuevo Ingreso'
                                       );
                                       $icono = array('fa fa-info-circle', 'fa fa-check','fa fa-plus');
                                       $count = 0;
                                       foreach ($ingresos_dep as $ingreso_dep => $nombre): ?>
                                       <li class="item">
                                          <label><input type="checkbox" id="<?=$ingreso_dep?>" name="<?=$ingreso_dep?>" value="1" <?php if($DEPingresos[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>

                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Custodia</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $custodias_dep = array(
                                           'DEPCustodia_ver' => 'Ver detalle',
                                           'DEPCustodia_eventos' => 'Agregar eventos',
                                           'DEPCustodia_archivos' => 'Adjuntar archivos',
                                           'DEPCustodia_enviar' => 'Enviar equipo'
                                         );

                                         $icono = array('fa fa-info-circle', 'fa fa-plus', 'fa fa-file' ,'fa fa-arrow-up');
                                         $count = 0;
                                         foreach ($custodias_dep as $custodia_dep => $nombre): ?>
                                         <li class="item">
                                              <label><input type="checkbox" id="<?=$custodia_dep?>" name="<?=$custodia_dep?>" value="1" <?php if($DEPcustodia[$count] == 1) {echo 'checked="checked"';} ?>>
                                                 <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                              </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>

                             <div class="box">
                               <div class="box-body table-responsive no-padding">
                                     <h4 id="titulo"> Egreso</h4>
                                     <ul class="products-list product-list-in-box">
                                         <?php
                                           $egresos_dep = array('DEPEgreso_ver' => 'Ver detalle',
                                           'DEPEgreso_eventos' => 'Agregar eventos'
                                           );
                                           $icono = array('fa fa-info-circle','fa fa-plus');
                                           $count = 0;
                                           foreach ($egresos_dep as $egreso_dep => $nombre): ?>
                                           <li class="item">
                                                <label><input type="checkbox" id="<?=$egreso_dep?>" name="<?=$egreso_dep?>" value="1" <?php if($DEPegreso[$count] == 1) {echo 'checked="checked"';} ?>>
                                                   <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                </label>
                                          </li>
                                           <?php
                                           $count = $count +1;
                                           endforeach; ?>
                                      </ul>
                                 </div>
                               </div>

                               <div class="box">
                                 <div class="box-body table-responsive no-padding">
                                       <h4 id="titulo"> Finalizadas</h4>
                                       <ul class="products-list product-list-in-box">
                                           <?php
                                             $finalizadas_dep = array('DEPFinalizadas_ver' => 'Ver detalle'
                                             );
                                             $icono = array('fa fa-info-circle');
                                             $count = 0;
                                             foreach ($finalizadas_dep as $finalizada_dep => $nombre): ?>
                                             <li class="item">
                                                  <label><input type="checkbox" id="<?=$finalizada_dep?>" name="<?=$finalizada_dep?>" value="1" <?php if($DEPfinalizadas[$count] == 1) {echo 'checked="checked"';} ?>>
                                                     <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                                  </label>
                                            </li>
                                             <?php
                                             $count = $count +1;
                                             endforeach; ?>
                                        </ul>
                                   </div>
                                 </div>
                       </div>







                       <div class="tab-pane" id="Fotos">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Fotos Desencriptadas</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $fotos = array('fotosD_ver' => 'Ver Fotos');
                                       $icono = array('fa fa-image');
                                       $count = 0;
                                       foreach ($fotos as $foto => $nombre): ?>
                                       <li class="item">
                                          <label><input type="checkbox" id="<?=$foto?>" name="<?=$foto?>" value="1" <?php if($FOTdesencriptadas[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>
                       </div>









                       <div class="tab-pane" id="Exportaciones">
                         <div class="box">
                           <div class="box-body table-responsive no-padding">
                                 <h4 id="titulo"> Exportaciones</h4>
                                 <ul class="products-list product-list-in-box">
                                     <?php
                                       $expos = array('expo_ver' => 'Ver Detalles');
                                       $icono = array('fa fa-info');
                                       $count = 0;
                                       foreach ($expos as $expo => $nombre): ?>
                                       <li class="item">
                                          <label><input type="checkbox" id="<?=$expo?>" name="<?=$expo?>" value="1" <?php if($EXPexportaciones[$count] == 1) {echo 'checked="checked"';} ?>>
                                             <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                          </label>
                                      </li>
                                       <?php
                                       $count = $count +1;
                                       endforeach; ?>
                                  </ul>
                             </div>
                           </div>



                           <div class="box">
                             <div class="box-body table-responsive no-padding">
                                   <h4 id="titulo"> Ver Detalles</h4>
                                   <ul class="products-list product-list-in-box">
                                       <?php
                                         $expo_detalles = array('detalle_aprobadas' => 'Ver Aprobadas','detalle_desaprobadas' => 'Ver Desaprobadas');
                                         $icono = array('fa fa-check', 'fa fa-times');
                                         $count = 0;
                                         foreach ($expo_detalles as $expo_detalle => $nombre): ?>
                                         <li class="item">
                                            <label><input type="checkbox" id="<?=$expo_detalle?>" name="<?=$expo_detalle?>" value="1" <?php if($EXPdetalles[$count] == 1) {echo 'checked="checked"';} ?>>
                                               <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                            </label>
                                        </li>
                                         <?php
                                         $count = $count +1;
                                         endforeach; ?>
                                    </ul>
                               </div>
                             </div>
                       </div>
































                       <div class="tab-pane" id="Proyectos">
                          <div class="box">
                            <div class="box-body table-responsive no-padding">
                                  <h4 id="titulo"> Proyectos</h4>
                                  <ul class="products-list product-list-in-box">
                                      <?php
                                        $proyectos_pro = array(
                                          'PROproyectos_agregar' => 'Agregar Proyecto',
                                          'PROproyectos_ver' => 'Ver detalle',
                                          'PROproyectos_editar' => 'Editar Proyecto',
                                          'PROproyectos_asignar' => 'Asignar Gestor',
                                          'PROproyectos_remoto' => 'Activar/Desactivar Remoto',
                                          'PROproyectos_estado' => 'Activar/Desactivar Proyecto'
                                        );
                                        $icono = array('fa fa-plus','fa fa-info','fa fa-edit','fa fa-user','fa fa-wifi','fa fa-power-off');
                                        $count = 0;
                                        foreach ($proyectos_pro as $proyecto_pro => $nombre): ?>
                                        <li class="item">
                                           <label><input type="checkbox" id="<?=$proyecto_pro?>" name="<?=$proyecto_pro?>" value="1" <?php if($PROproyectos[$count] == 1) {echo 'checked="checked"';} ?>>
                                              <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                           </label>
                                       </li>
                                        <?php
                                        $count = $count +1;
                                        endforeach; ?>
                                   </ul>
                              </div>
                            </div>

                            <div class="box">
                              <div class="box-body table-responsive no-padding">
                                    <h4 id="titulo"> Asignaciones</h4>
                                    <ul class="products-list product-list-in-box">
                                        <?php
                                          $proyectos_asig = array(
                                            'PROasig_eliminar' => 'Eliminar asignacion',
                                            'PROasig_prioridad' => 'Dar prioridad',
                                            'PROasig_guardad' => 'Guardad'
                                          );

                                          $icono = array('fa fa-times', 'fa fa-retweet', 'fa fa-save');
                                          $count = 0;
                                          foreach ($proyectos_asig as $proyecto_asig => $nombre): ?>
                                          <li class="item">
                                               <label><input type="checkbox" id="<?=$proyecto_asig?>" name="<?=$proyecto_asig?>" value="1" <?php if($PROasignaciones[$count] == 1) {echo 'checked="checked"';} ?>>
                                                  <span class="estado"><i id="icono" class="<?=$icono[$count]?>"> </i> <?=' '.$nombre?></span>
                                               </label>
                                         </li>
                                          <?php
                                          $count = $count +1;
                                          endforeach; ?>
                                     </ul>
                                </div>
                              </div>


                        </div>


























                 </div>
              </div>
          </div>
          </form>
    </section>
</div>
