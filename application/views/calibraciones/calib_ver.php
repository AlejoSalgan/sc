<?php

if(!empty($calibInfo))
{
    foreach ($calibInfo as $ef)
    {
        $calibId                        = $ef->id;
        $fecha_visita                   = $ef->fecha_visita;
        $fecha_alta                     = $ef->fecha_alta;

        $municipioId                    = $ef->idproyecto;
        $descripProyecto                = $ef->descripProyecto;
        $idequipo                       = $ef->idequipo;
        $equipoSerie                    = $ef->equipoSerie;

        $direccion                      = $ef->direccion;
        $tipo_equipo                    = $ef->tipo_equipo;
        $tipoEquipo                     = $ef->tipoEquipo;

        $velocidad                      = $ef->velocidad;
        $multicarril                    = $ef->multicarril;

        $tipo_servicio                  = $ef->tipo_servicio;
        $tipo_ver                       = $ef->tipo_ver;
        $prioridad                      = $ef->prioridad;
        $descripPrioridad               = $ef->descripPrioridad;

        $fecha_desde                    = $ef->fecha_desde;
        $fecha_hasta                    = $ef->fecha_hasta;
        $creadopor                      = $ef->creadopor;

        $observaciones_gestor           = $ef->observaciones_gestor;

        $nro_oc                         = $ef->nro_oc;
        $fecha_oc                       = $ef->fecha_oc;
        $observaciones_serv             = $ef->observaciones_serv;

        $fecha_vto                      = $ef->fecha_vto ;

        $idsupervisor                   = $ef->idsupervisor;
        $nameSupervisor                 = $ef->nameSupervisor;
        $dominio                        = $ef->dominio;
        $nameConductor                  = $ef->nameConductor;
        $nameTecnico                    = $ef->nameTecnico;
        $observaciones_calib            = $ef->observaciones_calib;
        $mobile                         = $ef->mobile;

        $nro_ot                         = $ef->nro_ot;
        $fecha_pasadas                  = $ef->fecha_pasadas;
        $pasadas_aprob                  = $ef->pasadas_aprob;
        $fecha_simulacion               = $ef->fecha_simulacion;
        $simulacion_aprob               = $ef->simulacion_aprob;
        $fecha_informe                  = $ef->fecha_informe;
        $fecha_certificado              = $ef->fecha_certificado;

        $estado_descrip                 = $ef->estado_descrip;
        $solicitud_creado               = $ef->solicitud_creado;
        $tipo                           = $ef->tipo;
        $ord_tipo                       = $ef->ord_tipo;
        $tipo_orden                       = $ef->tipo_orden;

    }
}

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<style media="screen">
  #phone {display: inline-block;}
  #tiempo-content {
    border-top: 1px solid #cccccc;
    border-bottom: 1px solid #cccccc;
  }
  #tiempo {
    margin-right: 6px;
  }

  #numeros {
    color: #3c8dbc;
  }

  @media screen and (min-width:1024px) {
    #phone {display: none;}
    }
</style>

<div class="content-wrapper">
  <div id="cabecera">
    Ver Orden
    <span class="pull-right">
      <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
      <?php switch ($tipo_orden) {
        case 10:
        case 20:
        case 30: ?>
          <a href="<?= base_url('calibraciones_solicitudes')?>">Solicitudes de Calibraciones</a> /
      <?php break;
        case 40:
        case 51:
        case 60:
        case 61: ?>
          <a href="<?= base_url('calibraciones_ordenes')?>">Ordenes de Calibracion</a> /
      <?php break;
        case 80:
        case 81: ?>
          <a href="<?= base_url('calibraciones_pendientes')?>">Ordenes Pendientes</a> /
      <?php break;
        case 70:
        case 71: ?>
          <a href="<?= base_url('calibraciones_finalizadas')?>">Ordenes Finalizadas</a> /
      <?php break;
      } ?>
      <span class="text-muted">Ver Orden</span>
    </span>
  </div>

  <section class="content">
    <?php if ($ordenes[0]->id): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">
                Esta equipo tiene una Orden de Reparacion abierta. Orden Nº <?= "<a href=".base_url("ver-orden/{$ordenes[0]->id}").">" . $ordenes[0]->id . "</a>"; ?> </a>
              </h3>
           </div>
          </div>
        </div>
      </div>
    <?php endif; ?>


    <div class="row">
      <div class="col-md-2">
        <div class="tabbable" >
          <ul class="nav tab-group-vertical nav-stacked" style="background-color: white">
            <li class="active"><a href="#principal" data-toggle="tab">Principal </a></li>
            <li><a href="#eventos" data-toggle="tab">Eventos</a></li>
            <li><a href="#documentacion" data-toggle="tab">Documentacion</a></li>
          </ul>
        </div>
      </div>
      <br id="phone">

      <div class="col-md-10">
        <div class="tab-content">
          <div class="tab-pane active" id="principal">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Principal</h3>
              </div>

              <div class="box-body no-padding">
                <table class="table table-bordered ">
                    <tr class="info"><th>SOLICITUD</th></tr>
                    <tr><td>Gestionado por: <?="<a href=".base_url("verPersonal/{$creadopor}").">" . $solicitud_creado . "</a>"; ?></td></tr>
                </table>

                <div class="box-footer">
                <div class="row">
                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Fecha Alta</h5>
                      <span><?=date('d/m/Y',strtotime($fecha_alta))?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Nº Orden</h5>
                      <span><?= $calibId?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Tipo de Servicio</h5>
                      <span><?= $tipo_ver?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Prioridad</h5>
                      <span><?= $descripPrioridad?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Fecha Desde</h5>
                      <span><?=date('d/m/Y',strtotime($fecha_desde))?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Fecha Hasta</h5>
                      <span><?=date('d/m/Y',strtotime($fecha_hasta))?></span>
                    </div>
                  </div>

                </div>
              </div>
              </div>
            </div>


            <div class="box">
              <div class="box-body no-padding">
                <table class="table table-bordered ">
                    <tr class="info"><th>EQUIPO</th></tr>
                    <tr><td><?= "<a href=".base_url("verEquipo/{$idequipo}").">" . $equipoSerie . "</a>"; ?> - <span class="text-muted"><?= $descripProyecto?></span></td></tr>
                </table>

                <div class="box-footer">
                <div class="row">
                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h4 class="description-header">Fecha Vto</h4>
                      <span><?= ($fecha_vto == 01/01/1970) ? "Sin fecha": date('d/m/Y',strtotime($fecha_vto));?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Direccion</h5>
                      <span><?=($direccion == "" || $direccion == NULL || $direccion == "  ") ? "Sin direccion": $direccion;?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Tipo de Equipo</h5>
                      <span><?= $tipoEquipo; ?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Velocidad Permitida</h5>
                      <span><?= $velocidad." KM/H"; ?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Nº Carriles</h5>
                      <span><?= $multicarril; ?></span>
                    </div>
                  </div>

                  <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                      <h5 class="description-header">Nº Orden Compra</h5>
                      <span><?=($nro_oc == NULL) ? "A designar": $nro_oc;?></span>
                    </div>
                  </div>

                </div>
              </div>
              </div>

            </div>

            <?php if ($tipo_orden > 30): ?>
              <div class="box">
                <div class="box-body no-padding">
                  <table class="table table-bordered ">
                      <tr class="info"><th>ORDEN</th></tr>
                      <tr><td>Fecha visita: <?=($fecha_visita == "01/01/1970" || $fecha_visita == NULL) ? "A designar": date('d/m/Y',strtotime($fecha_visita));?></td></tr>
                  </table>

                  <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h4 class="description-header">Nº Ord Trabajo</h4>
                        <span>0</span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Supervisor</h5>
                        <span><?=($nameSupervisor == NULL) ? "A designar": $nameSupervisor;?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Conductor</h5>
                        <span><?=($nameConductor == NULL) ? "A designar": $nameConductor;?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Tecnico</h5>
                        <span><?=($nameTecnico == NULL) ? "A designar": $nameTecnico;?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Celular</h5>
                        <span><?=($mobile == NULL) ? "A designar": $mobile;?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Dominio</h5>
                        <span><?=($dominio == NULL) ? "A designar": $dominio;?></span>
                      </div>
                    </div>

                  </div>
                </div>
                </div>
              </div>

              <div class="box">
                <div class="box-body no-padding">
                  <table class="table table-bordered ">
                      <tr class="info"><th>ORDEN TECNICA</th></tr>
                      <tr><td>Orden Tecnica Nº <?=($nro_ot == NULL) ? "A designar": $nro_ot;?> </td></tr>
                  </table>

                  <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h4 class="description-header">Fecha Pasadas</h4>
                        <span><?=($fecha_pasadas == NULL) ? "Sin fecha": date('d/m/Y',strtotime($fecha_pasadas));?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Estado Pasadas</h5>
                        <span><?php switch ($pasadas_aprob):
                            case 0:?>
                                Sin estado
                            <?php break;
                            case 1:?>
                                Aprobada
                            <?php break;
                            case 2:?>
                               No aprobada
                            <?php break;
                            endswitch;?>
                        </span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Fecha Simulacion</h5>
                        <span><?=($fecha_simulacion == NULL) ? "Sin fecha": date('d/m/Y',strtotime($fecha_simulacion));?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Estado Simulacion</h5>
                        <span><?php switch ($simulacion_aprob):
                            case 0:?>
                                Sin estado
                            <?php break;
                            case 1:?>
                                Aprobada
                            <?php break;
                            case 2:?>
                               No aprobada
                            <?php break;
                            endswitch;?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Fecha Informe</h5>
                        <span><?=($fecha_informe == NULL) ? "Sin fecha": date('d/m/Y',strtotime($fecha_informe));?></span>
                      </div>
                    </div>

                    <div class="col-sm-2 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">Fecha Certificacion</h5>
                        <span><?=($fecha_certificado == NULL) ? "Sin fecha": date('d/m/Y',strtotime($fecha_certificado));?></span>
                      </div>
                    </div>

                  </div>
                </div>
                </div>
              </div>
            <?php endif; ?>


          </div>


          <div class="tab-pane" id="eventos">
            <div class="box box-primary">
              <div class="box-header" >
                <h3 class="box-title">Eventos</h3>
              </div>

              <div class="box-body" style="border-top: 1px solid #cccccc;">
                <div class="col-md-12">
                  <?php for ($i=0; $i < $cantidad; $i++) {
                    $datetime1 = date_create($eventos[$i]->fecha);
                    if ($eventos[$i+1]->fecha == NULL) {
                      $fecha_siguiente = date("Y-m-d H:i:s");
                    } else {
                      $fecha_siguiente = $eventos[$i+1]->fecha ;
                    }

                    $datetime2 = date_create($fecha_siguiente);
                    $interval = date_diff($datetime1, $datetime2);
                    $dias = $interval->format('%a');
                    $horas = $interval->format('%h');
                    $minutos = $interval->format('%i');

                    $sumaD += $dias;
                    $sumaH += $horas;
                    $sumaM += $minutos;

                    $segundosD = $sumaD *86400;
                    $segundosH = $sumaH *3600;
                    $segundosM = $sumaM *60;
                    $segundosT = $segundosD + $segundosH + $segundosM;

                    $dt1 = new DateTime("@0");
                    $dt2 = new DateTime("@$segundosT");
                    $totalD = $dt1->diff($dt2)->format('%a');
                    $totalH = $dt1->diff($dt2)->format('%h');
                    $totalM = $dt1->diff($dt2)->format('%i');

                     } ?>
                  <h2>
                    <span id="numeros"><?= $totalD?></span> <?= ($totalD > 1) ? 'dias' : 'dia' ;?>
                    <span id="numeros"><?= $totalH?></span> <?= ($totalH > 1) ? 'horas' : 'hora' ;?>
                    <span id="numeros"><?= $totalM?></span> <?= ($totalM > 1) ? 'minutos' : 'minuto' ;?>
                  </h2>
                  <div class = "progress">
                    <?php foreach ($sectores as $color => $porcentaje): ?>
                      <div class = "progress-bar progress-bar-success" role = "progressbar"
                         aria-valuenow = "60" aria-valuemin = "0" aria-valuemax = "100" style = "width: <?=$porcentaje?>%; background-color: <?=$color?>;">
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <?php foreach ($grupos_eventos as $grupo): ?>
                    <span class="label label-default" style="background-color: <?= $grupo->color?>"><span style="color: white; font-size:11px;"><?= $grupo->sector?></span></span>&nbsp;&nbsp;&nbsp;
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="box-body ">
                <ul class="products-list product-list-in-box">
                  <?php foreach ($eventos as $evento): ?>
                    <li class="item" style="border-top: 1px solid #cccccc;">
                        <a href="javascript:void(0)" class="product-title"><?= $evento->estado?></a>
                        <span class="pull-right">
                          <i class="fa fa-clock-o"></i><?= " ".date('d/m/Y - H:i:s',strtotime($evento->fecha))?>
                        </span>
                        <span class="product-description" style="color: #333333"><?= $evento->observacion?></span>
                        <div class="timeline-footer">
                           <span class="label label-default" style="background-color: <?= $evento->color?>"><span style="color: white;"><?= $evento->sector?></span></span> - <?="<a href=".base_url("verPersonal/{$evento->usuario}").">" . $evento->name . "</a>"; ?>
                       </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>









          <div class="tab-pane" id="documentacion">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Documentacion</h3>
              </div>

            </div>
          </div>


        </div>
      </div>











    </div>
  </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/imprime.js" type="text/javascript"></script>
