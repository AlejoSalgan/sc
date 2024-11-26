<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<?php
  switch ($protocolo_info->decripto) {
    case 0:
      $info_estado = "Bajada";
      $color = "#66807c";
      $valor = 0;
      break;

    case 1:
      $info_estado = "Pendiente Desencriptacion";
      $color = "#e69d45";
      $valor = 0;
      break;

    case 2:               
      $info_estado = "Desencriptando";
      $color = "#6366f1";
      $valor = 0;
      break;

    case 3:
      $info_estado = "Incorporando";
      $color = "#209b60";
      $valor = 0;
      break;

    case 4:
      switch ($protocolo_info->pm_estado) {
        case 99:
          switch ($protocolo_info->incorporacion_estado) {
            case 52:
              $info_estado = "Exportado";
              $color = "#27a269";
              $valor = 4;
              break;
            
            case 55:
              $info_estado = "Salida de Edicion Observada";
              $color = "#af1a1d";
              $valor = 4;
              break;
              
            case 65:
              $info_estado = "Salida de Edicion Pendiente";
              $color = "#45818e";
              $valor = 4;
              break;
            
            default:
              $info_estado = "Sin estado";
              $color = "#af1a1d";
              $valor = 5;
              break;
          }
          break;

        case 0:
          switch ($protocolo_info->incorporacion_estado) {
            case 0:
              $info_estado = "Desencriptado";
              $color = "#5e62a8";
              $valor = 1;
              break;

            case 60:
              $info_estado = "Edicion";
              $color = "#1c8cfc";
              $valor = 2;
              break;
            
            case 63:
              $info_estado = "Error impacto";
              $color = "#db3a34";
              $valor = 2;
              break;

            case 65:
              $info_estado = "Edicion finalizada";
              $color = "#2f9839";
              $valor = 3;
              break;

            case 69:
              $info_estado = "Control de Calidad";
              $color = "#e69d45";
              $valor = 3;
              break;

            case 72:
              $info_estado = "Descartado en Edicion";
              $color = "#db3a34";
              $valor = 3;
              break;

            case 73:
              $info_estado = "Descartado en Verificacion";
              $color = "#db3a34";
              $valor = 3;
              break;

            case 74:
              $info_estado = "Descartado por el Gestor";
              $color = "#db3a34";
              $valor = 5;
              break;

            case 75:
              $info_estado = "Descartado por Error en el Equipo";
              $color = "#db3a34";
              $valor = 5;
              break;

            case 200:
              $info_estado = "Protocolo apto para subir a Cointra";
              $color = "#45818e";
              break;                                      

            case 201:
              $info_estado = "Protocolo en Cointra";
              $color = "#45818e";
              break;
            
            default:
              $info_estado = "Sin estado";
              $color = "#af1a1d";
              $valor = 5;
              break;
          }
          break;
        
        default:
          $info_estado = "Sin estado";
          $color = "#af1a1d";
          $valor = 5;
          break;
      }

      break;

    case 5:
      // Los nuevos estados
      switch ($protocolo_info->incorporacion_estado) {
        case 10:
          $info_estado = "Descartado por Error en el Equipo";
          $color = "#db3a34";
          $valor = 5;
          break;
        
        case 20:
          $info_estado = "Descartado por el Gestor";
          $color = "#db3a34";
          $valor = 5;
          break;

        case 30:
          $info_estado = "Descartado en Edicion";
          $color = "#db3a34";
          $valor = 3;
          break;
        
        case 40:
          $info_estado = "Descartado en Verificacion";
          $color = "#db3a34";
          $valor = 3;
          break;

        case 50:
          $info_estado = "Descartado por Filtros";
          $color = "#db3a34";
          $valor = 2;
          break;

        case 60:
          $info_estado = "Descartado por Archivos duplicados";
          $color = "#db3a34";
          $valor = 2;
          break;
        
        case 70:
          $info_estado = "Anulado";
          $color = "#db3a34";
          $valor = 5;
          break;
          

        default:
          $info_estado = "Sin estado";
          $color = "#af1a1d";
          $valor = 5;
          break;
      }
      break;

      //Fin de los nuevos estados

    case 6:
      $info_estado = "Protocolo en revision";
      $color = "#ff8654";
      $valor = 5;
      break;

    case 10:
      $info_estado = "Ingreso";
      $color = "#2f9839";
      $valor = 0;
      break;

    default:
      $info_estado = "Sin estado";
      $color = "#af1a1d";
      $valor = 5;
      break;
  }
?>

<div class="content-wrapper">
    <div id="cabecera">
      Protocolos - Detalle del Protocolo
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <span class="text-muted">Detalle del Protocolo</span>
      </span>
    </div>

    <section class="content">
    <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
              Protocolo Nº <span class="text-primary"> <?=$protocolo_info->id_protocolo?> - <?=$protocolo_info->equipo_serie?></span>
              </h3>
           </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box" style="border-color: <?=$color?>">
            <div class="box-header with-border" >
              <h3 class="box-title">
                Estado: <span class="label label-default" style="background-color: <?=$color?>; color: white"><?= $info_estado;?></span> 
              </h3>
           </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registros</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <?php if (!$protocolo_info->info_fecha_sincronizacion): ?>
                      <tr>
                        <td>Protocolo en espera de Desencriptacion</td>
                      </tr>
                    <?php else: ?>

                      <?php if ($valor > 0): ?>
                        <tr>
                        <td width="50%">Desencriptados</td>
                        <td><span class="text-<?=($protocolo_info->info_desencriptados > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_desencriptados?></span></td>
                      </tr>
                      <tr>
                        <td>Filtro Velocidad</td>
                        <td><span class="text-<?=($protocolo_info->info_filtro_velocidad > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_filtro_velocidad?></span></td>
                      </tr>
                      <tr>
                        <td>Filtro Velocidad 0</td>
                        <td><span class="text-<?=($protocolo_info->info_velocidad_0 > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_velocidad_0?></span></td>
                      </tr>

                      <tr>
                        <td>Filtro Velocidad 150</td>
                        <td><span class="text-<?=($protocolo_info->info_velocidad_150 > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_velocidad_150?></span></td>
                      </tr>

                      <tr>
                        <td>Archivos Dañados</td>
                        <td><span class="text-<?=($protocolo_info->info_danados > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_danados?></span></td>
                      </tr>

                      <tr>
                        <td>Registros Editables</td>
                        <td><span class="text-<?=($protocolo_info->info_editables > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_editables?></span></td>
                      </tr>

                      <?php endif; ?>

                      <?php if ($valor >= 2): ?>
                        <tr>
                        <td>En Edicion</td>
                        <td><span class="text-<?=($protocolo_info->info_edicion > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_edicion?></span></td>
                      </tr>
                      <?php endif; ?>
                      
                      <?php if ($valor >= 3): ?>
                        <tr>
                        <td>Aprobados</td>
                        <td><span class="text-<?=($protocolo_info->info_aprobados > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_aprobados?></span></td>
                      </tr>

                      <tr>
                        <td>Descartados</td>
                        <td><span class="text-<?=($protocolo_info->info_descartados > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_descartados?></span></td>
                      </tr>

                      <tr>
                        <td>Descartados en Verificacion</td>
                        <td><span class="text-<?=($protocolo_info->info_verificacion > 0) ? "primary" : "danger" ;?>"><?=$protocolo_info->info_verificacion?></span></td>
                      </tr>
                      <?php endif; ?>

                      
                    <?php endif; ?>

                  </tbody>
                </table>
           </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informacion del Protocolo</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                            
                  <tr>
                      <td>Fecha Alta</td>
                      <td><?= date('d/m/Y - H:i:s',strtotime($protocolo_info->fecha_alta));?></td>
                    </tr>

                    <tr>
                      <td>Nº Protocolo</td>
                      <td><?=$protocolo_info->id_protocolo?></td>
                    </tr>
                    
                    <tr>
                      <td>Equipo</td>
                      <td><span class="text-primary"><?=$protocolo_info->equipo_serie?></span></td>
                    </tr>

                    <tr>
                      <td>Proyecto</td>
                      <td><span class="text-primary"><?=$protocolo_info->proyecto_name?></span></td>
                    </tr>

                    <tr>
                      <td>Nº Exportacion</td>
                        <?php if ($protocolo_info->pm_estado == 99): ?>
                          <?php $expo_numero = ($protocolo_info->num_expo)? $protocolo_info->num_expo : $protocolo_info->id_expo;?>
                          <td><span class="text-primary"><?=$expo_numero?></span></td>
                        <?php else: ?>
                          <td><span class="text-danger">Pendiente</span></td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                      <td>Fecha Desde</td>
                      <td><?= date('d/m/Y',strtotime($protocolo_info->fecha_inicial));?></td>
                    </tr>

                    <tr>
                      <td>Fecha Hasta</td>
                      <td><?= date('d/m/Y',strtotime($protocolo_info->fecha_final));?></td>
                    </tr>

                    <tr>
                      <td>Cantidad</td>
                      <td><span class="text-primary"><?=$protocolo_info->cantidad?></span></td>
                    </tr>

                    <tr>
                      <td>Fecha Sincronizacion</td>
                      <td><span class="text-primary"><?= (!$protocolo_info->info_fecha_sincronizacion) ? "Pendiente" : date('d/m/Y - H:i:s',strtotime($protocolo_info->info_fecha_sincronizacion)); ?></span></td>
                    </tr>

                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>


      
        <div class="row">

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detalle de los Archivos</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                    <?php if (!$bajada_info->subida_ingresados): ?>
                      <tr>
                        <td>Pendiente de Ingreso de Datos.</td>
                      </tr>
                    <?php else: ?>
                  <tr>
                      <td>Imagenes</td>
                      <td><?=$bajada_info->subida_fotos?></td>
                    </tr>

                    <tr>
                      <td>Videos</td>
                      <td><?=$bajada_info->subida_videos?></td>
                    </tr>

                    <tr>
                      <td>Fabricantes</td>
                      <td><?=$bajada_info->subida_fabrica?></td>
                    </tr>

                    <tr>
                      <td>Documentos</td>
                      <td><?=$bajada_info->subida_documentos?></td>
                    </tr>

                    <tr>
                      <td>Vencidos</td>
                      <td><?=$bajada_info->subida_vencidos?></td>
                    </tr>

                    <tr>
                      <td>Sin archivos BD</td>
                      <td><?=$bajada_info->subida_sbd?></td>
                    </tr>

                    <tr>
                      <td>Repetidos</td>
                      <td><?=$bajada_info->subida_repetidos?></td>
                    </tr>

                    <tr>
                      <td>Para Ingresar</td>
                      <td><?=$bajada_info->subida_envios?></td>
                    </tr>

                    <tr>
                      <td>Errores</td>
                      <td><?=$bajada_info->subida_errores?></td>
                    </tr>

                    <tr>
                      <td>Ingresados</td>
                      <td><?=$bajada_info->subida_ingresados?></td>
                    </tr>

                    <?php endif; ?>

                    
                  </tbody>
                </table>
           </div>
          </div>
        </div>

        

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informacion de la Bajada</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                  <tr>
                      <td>Nº Orden</td>
                      <td><?=$bajada_info->id?></td>
                    </tr>

                    <tr>
                      <td>Tipo de bajada</td>
                      <td><span class="text-primary"><?= ($protocolo_info->remoto == 0) ? "Fisica" : "Remoto"; ?></span></td>
                    </tr>

                    <tr>
                      <td>Ubicacion</td>
                      <td><?= substr(ucfirst($protocolo_info->ubicacion),0,5)." ".substr($protocolo_info->ubicacion,-1)?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>
      
      
      
      </div>



       

      <?php if (in_array($vendorId, array(27,191,38,175,146,221,263,68,175,105,284))): ?>
        <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">**Protocolos Main (Sistemas)</h3>
           </div>
           <div class="box-body table-responsive no-padding">
               <table class="table table-bordered">
                  <tbody>
                  <tr>
                      <td>Decripto</td>
                      <td><?=$protocolo_info->decripto?></td>
                    </tr>

                    <tr>
                      <td>Incorporacion Estado</td>
                      <td><?=$protocolo_info->incorporacion_estado?></td>
                    </tr>

                    <tr>
                      <td>Estado</td>
                      <td><?=$protocolo_info->pm_estado?></td>
                    </tr>

                    <tr>
                      <td>Estado Verificacion</td>
                      <td><?=$protocolo_info->est_verificacion?></td>
                    </tr>

                    <tr>
                      <td>Numero de mensaje</td>
                      <td><?=$protocolo_info->nro_msj?></td>
                    </tr>
                  </tbody>
                </table>
           </div>
          </div>
        </div>
      
      
        </div>
        <?php endif; ?>
    </section>
</div>
