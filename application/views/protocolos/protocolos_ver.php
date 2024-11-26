<?php

foreach ($ordenesbInfo as $ef)
{
    $ordenesbId        = $ef->id;
    $equipoSerie       = $ef->equipoSerie;
    $protocolo         = $ef->protocolo;
    $bajada_desde      = $ef->bajada_desde;
    $bajada_hasta      = $ef->bajada_hasta;
    $bajada_archivos   = $ef->bajada_archivos;

    $subida_fotos      = $ef->subida_fotos;
    $subida_videos     = $ef->subida_videos;
    $subida_fabrica    = $ef->subida_fabrica;
    $subida_vencidos   = $ef->subida_vencidos;
    $subida_repetidos  = $ef->subida_repetidos;
    $subida_sbd        = $ef->subida_sbd;
    $subida_envios     = $ef->subida_envios;
    $subida_errores    = $ef->subida_errores;
    $subida_ingresados = $ef->subida_ingresados;
    $subida_observ     = $ef->subida_observ;
    $subida_documentos = $ef->subida_documentos;

    $subida_FD         = $ef->subida_FD;
    $subida_FH         = $ef->subida_FH;
    $subida_cant       = $ef->subida_cant;

    $subida_fecha      = $ef->subida_fecha;
    $subida_creadopor  = $ef->subida_creadopor;
    $nameSubida        = $ef->nameSubida;

    $label             = $ef->label;
    $estado            = $ef->estado;

    $subida_activo     = $ef->subida_activo;
    $estadoDecripto    = $ef->estadoDecripto;
    $ingresoEstado     = $ef->ingresoEstado;
    $subida_estado     = $ef->subida_estado;

    $bajada_observ     = $ef->bajada_observ;

    $bajada_observ     = $ef->bajada_observ;
    $idequipo          = $ef->idequipo;
    $idproyecto        = $ef->idproyecto;

    $descripProyecto     = $ef->descripProyecto;
    $decripto            = $ef->decripto;
    $incorporacion_estado    = $ef->incorporacion_estado;
    $color               = $ef->color;
    $idexportacion       = $ef->idexportacion;

}

switch ($estado) {
  case 0:
    $accion = "protocolosListing";
    $titulo = "Pendientes";
    break;
  case 1:
  case 4:
    $accion = "protocolosingListing";
    $titulo = "Ingresados";
    break;
  case 2:
    $accion = "protocolosanuladoListing";
    $titulo = "Anulados";
    break;
  case 3:
    $accion = "protocolosceroListing";
    $titulo = "Ceros";
    break;
}

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/efectos.css'); ?>">
<input type="hidden" id="protocolo" name="protocolo" value="<?=$protocolo?>">



<div class="content-wrapper">
    <div id="cabecera">
  		Detalle del Protocolo
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?=base_url(''.$accion.'')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>">Protocolos <?= $titulo?></a> /
  		  <span class="text-muted">Ver Protocolo</span>
  		</span>
  	</div>

    <section class="content">
      <?php if ($subida_estado == 1 || $subida_estado == 4): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-<?=$color?>">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <strong>Estado de la Desencriptacion:</strong> <?= $estadoDecripto?>
                </h3>
             </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detalle de los Archivos</h3>
            </div>

            <div class="box-footer">
              <strong>Protocolo:</strong> <a href="javascript:void(0);"><?php echo $protocolo; ?></a>
              <span class="pull-right"><span class="<?php echo $label;?>"><?php echo $estado;?></span></span></span>
            </div>

            <div class="box-footer">
              <strong>Ingresado por:</strong> <?php echo($nameSubida == NULL) ? "Pendiente": "<a href=".base_url("verPersonal/{$subida_creadopor}").">" . $nameSubida . "</a>" ;?>
              <span class="pull-right"><?php $subida_fecha = $this->fechas->cambiaf_a_arg_hor($subida_fecha);
              echo ($subida_fecha == "01/01/1970 - 01:00:00" OR $subida_fecha == NULL OR $subida_fecha == "30/11/-0001 - 00:00:00") ? "No se ingreso el protocolo": $subida_fecha
              ;?></span>
            </div>

            <div class="box-footer">
              <strong>Observaciones:</strong>
              <?php echo($subida_observ == NULL) ? "Sin observaciones": $subida_observ;?>
            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_fotos == NULL) ? "Pendiente": $subida_fotos;?></h5>
                    <span class="description-text text-info">Imagenes</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_videos == NULL) ? "Pendiente": $subida_videos;?></h5>
                    <span class="description-text text-info">Videos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_fabrica == NULL) ? "Pendiente": $subida_fabrica;?></h5>
                    <span class="description-text text-info">Fabricante</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->

                <div class="col-sm-3">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_documentos == NULL) ? "Pendiente": $subida_documentos;?></h5>
                    <span class="description-text text-info">Documentos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_vencidos == NULL) ? "Pendiente": $subida_vencidos;?></h5>
                    <span class="description-text text-danger">Vencidos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_sbd == NULL) ? "Pendiente": $subida_sbd;?></h5>
                    <span class="description-text text-danger">Sin BD</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_repetidos == NULL) ? "Pendiente": $subida_repetidos;?></h5>
                    <span class="description-text text-danger">Repetidos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_envios == NULL) ? "Pendiente": $subida_envios;?></h5>
                    <span class="description-text text-info">Ingresar</span>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_errores == NULL) ? "Pendiente": $subida_errores;?></h5>
                    <span class="description-text text-danger">Errores</span>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo($subida_ingresados == NULL) ? "Pendiente": $subida_ingresados;?></h5>
                    <span class="description-text text-success">Ingresados</span>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Orden de Bajada de Memoria</h3>
            </div>

            <div class="box-footer">
              <strong>Nº Orden: </strong><?php echo "<a href=".base_url("verOrdenb/{$ordenesbId}").">" . $ordenesbId . "</a>"; ?>
            </div>

            <div class="box-footer">
              <strong>Equipo: </strong><?= "<a href=".base_url("verEquipo/{$idequipo}").">" . $equipoSerie . "</a>"; ?>
              <span class="pull-right"><strong>Proyecto: </strong><?=$descripProyecto?></span>
            </div>

            <div class="box-footer">
              <strong>Observaciones:</strong>
              <?php echo($bajada_observ == NULL) ? "Sin observaciónes": $bajada_observ;?>
            </div>

            <?php if (($subida_FD == "0000-00-00 00:00:00" OR $subida_FD == NULL) AND ($subida_FH == "0000-00-00 00:00:00" OR $subida_FH == NULL) AND ($subida_cant == 0 OR $subida_cant == NULL)): ?>
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?=date('d/m/Y - H:i',strtotime($bajada_desde))?>
                        </h5>
                      <span class="description-text text-info">Fecha Desde</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?=date('d/m/Y - H:i',strtotime($bajada_hasta))?>
                      </h5>
                      <span class="description-text text-info">Fecha Hasta</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?php echo $bajada_archivos; ?></h5>
                      <span class="description-text text-info">Cantidad</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>

            <?php else: ?>



              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Orden Original</h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Titulos</h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">Orden Modificada</h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>

              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">
                      <?=date('d/m/Y',strtotime($bajada_desde))?> <br>
                      <?=date('H:i:s',strtotime($bajada_desde))?></h5>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <span class="description-text text-info">Fecha Desde</span>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?php if ($this->fechas->cambiaf_a_arg_hor($subida_FD) == "01/01/1970 - 01:00:00" OR $this->fechas->cambiaf_a_arg_hor($subida_FD) == NULL OR $this->fechas->cambiaf_a_arg_hor($subida_FD) == "30/11/-0001 - 00:00:00"): ?>
                          No se modifico la fecha
                        <?php else: ?>
                          <?=date('d/m/Y',strtotime($subida_FD))?> <br>
                          <?=date('H:i:s',strtotime($subida_FD))?></h5>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">
                      <?=date('d/m/Y',strtotime($bajada_hasta))?> <br>
                      <?=date('H:i:s',strtotime($bajada_hasta))?></h5>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <span class="description-text text-info">Fecha Hasta</span>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?php if ($this->fechas->cambiaf_a_arg_hor($subida_FH) == "01/01/1970 - 01:00:00" OR $this->fechas->cambiaf_a_arg_hor($subida_FH) == NULL OR $this->fechas->cambiaf_a_arg_hor($subida_FH) == "30/11/-0001 - 00:00:00"): ?>
                          No se modifico la fecha
                        <?php else: ?>
                          <?=date('d/m/Y',strtotime($subida_FH))?> <br>
                          <?=date('H:i:s',strtotime($subida_FH))?></h5>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>


              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">
                      <?php echo $bajada_archivos; ?></h5>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <span class="description-text text-info">Cantidad</span>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">
                        <?php echo($subida_cant == 0) ? "No se modifico la cantidad": $subida_cant;?>
                        </h5>

                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>


          </div>
        </div>

      </div>

      


      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registros</h3>
           </div>



           <div class="box-body table-responsive no-padding DetalleProtocolo">
               <table class="table table-bordered">
               <tbody>

                <?php if ($decripto == '4' && $protocolo_info->id_protocolo >= 241395): ?>

                  

                  <tr>
                      <td>Desencriptados</td>
                      <td><?=$protocolo_info->info_desencriptados?></td>
                      <td>Filtro Velocidad</td>
                      <td><?=$protocolo_info->info_filtro_velocidad?></td>
                    </tr>
                    <tr>
                      <td>Filtro Velocidad 0</td>
                      <td><?=$protocolo_info->info_velocidad_0?></td>
                      <td>Filtro Velocidad 150</td>
                      <td><?=$protocolo_info->info_velocidad_150?></td>
                    </tr>
                    <tr>
                      <td>Archivos Dañados</td>
                      <td><?=$protocolo_info->info_danados?></td>
                      <td>Registros Editables</td>
                      <td><?=$protocolo_info->info_editables?></td>
                    </tr>
                    <tr>
                      <td>En Edicion</td>
                      <td><?=$protocolo_info->info_edicion?></td>
                      <td>Aprobados</td>
                      <td><?=$protocolo_info->info_aprobados?></td>
                      
                    </tr>
                    <tr>
                      <td>Descartados</td>
                      <td><?=$protocolo_info->info_descartados?></td>
                      <td>Verificados</td>
                      <td><?=$protocolo_info->info_verificacion?></td>
                    </tr>

                <?php elseif ($decripto == '4' && $protocolo_info->id_protocolo < 241395): ?>
                  <tr>
                      <td>Primer Registro</td>
                      <td><div class="spinner" id="primer_registro"></div></td>
                      <td>Ultimo Registro</td>
                      <td><div class="spinner"id="ultimo_registro"></div></td>
                    </tr>
                    <tr>
                      <td>En Edicion</td>
                      <td><div class="spinner" id="edicion"></div><a id="en_edicion"></td>
                      <td>Archivos Dañados</td>
                      <td><div class="spinner" id="dañados"></div></td>
                    </tr>
                    <tr>
                      <td>Filtro de Velocidad</td>
                      <td><div class="spinner" id="velocidad"></div></td>
                      <td>Otros Filtros</td>
                      <td><div class="spinner" id="otros"></div></td>
                    </tr>
                    <tr>
                      <td>Aprobados</td>
                      <td><div class="spinner" id="aprobados"></div></td>
                      <td>Descartados</td>
                      <td><div class="spinner" id="descartados"></div></td>
                    </tr>
                <?php else: ?>
                  <tr>
                    <td>Protocolo en espera de Desencriptacion</td>
                  </tr>
                <?php endif; ?>
                </tbody>
                </table>
           </div>
          </div>
        </div>





        <?php if ($decripto == '4'):  ?>
        <div class="col-md-6">
          <div class="box box-<?=$color?>">
            <div class="box-header with-border">
              <h3 class="box-title">Desencriptacion</h3>
            </div>
            <div class="box-body table-responsive no-padding DetalleProtocolo" >
                <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th>Estado</th>
                        <td colspan="3"><?=$estadoDecripto?></td>
                      </tr>
                      <tr>
                        <th>Decripto</th>
                        <td><?=$decripto?></td>
                        <th>Nº Exportacion</th>
                        <td><?= "<a href=".base_url("verExpo/{$idexportacion}").">" . "Nº ".$idexportacion . "</a>"; ?></td>
                      </tr>
                      <tr>
                        <th colspan="4">Errores:</th>
                      </tr>
                      <tr>
                        <td colspan="4"><div class="spinner" id="errores"></div></td>
                      </tr>
                    </tbody>
                  </table>
            </div>
            <div class="box-footer DetalleProtocolo">
              Ultima actualizacion: <div class="spinner" id="actualizacion"></div>
            </div>
          </div>
        </div>
        <?php endif; ?>

      </div>









     

      <?php if (in_array($id_usuario, array(27,38,68,105,146,221,275,293,274,262,263,284))): ?>
      
      <div class="row">
        <?php if ($eventos): ?>
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Eventos</h3>
              </div>
              <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="info">
                        <th class="text-center">Observacion</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($eventos as $evento): ?>
                      <tr>
                        <td class="text-dark"><?=trim(ucfirst(strtolower($evento->observacion)));?></td>
                        <td class="text-center"><span class="badge badge-<?=$evento->label?>"><?=$evento->nombre_estado?></span></td>
                        <td class="text-center text-primary"><?=$evento->nameUsuario?></td>
                        <td class="text-center"><?=date('d/m/Y - H:i:s',strtotime($evento->fecha))?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($errores): ?>
        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Errores</h3>
           </div>

           <div class="box-body table-responsive no-padding">
             <table class="table table-bordered table-hover">
               <thead>
                   <tr class="info">
                       <th>Archivo</th>
                       <th>Detalle</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($errores as $key): ?>
                     <?php echo $key->errores; ?>
                   <?php endforeach; ?>
               </tbody>
             </table>
           </div>
        </div>
      <?php endif; ?>
    </div>

    </div>

      <?php endif; ?>
    </section>
</div>

  <script type="text/javascript">
      jQuery(document).ready(function(){

        var incorporacion_estado = <?= $incorporacion_estado ?> ;
        var decripto = <?= $decripto ?>;

        if (decripto == '4' && $protocolo_info->id_protocolo < 241395 ){

          setTimeout(fetchRegistros, 3000)
          function fetchRegistros() {
              var protocolo = $("#protocolo").val();
              var errores = '';
              console.log(protocolo);

                $.ajax({
                    url: "<?=base_url('protocolos_registros')?>",
                    method: "POST",
                    data: { protocolo: protocolo},
                    success: function(data) {
                      info = JSON.parse(data);
                      $("#primer_registro").attr('class','text-primary');
                      $("#edicion").attr('class','text-primary');
                      $("#velocidad").attr('class','text-secondary');
                      $("#aprobados").attr('class','text-success');
                      $("#ultimo_registro").attr('class','text-primary');
                      $("#dañados").attr('class','text-danger');
                      $("#otros").attr('class','text-warning');
                      $("#descartados").attr('class','text-danger');
                      $("#errores").attr('class','text-primary');
                      $("#actualizacion").attr('class','text-primary');
                      console.log(info);
                      $("#primer_registro").html(info[0]["Primer Registro"]);
                      $("#en_edicion").html(info[0]["En Edicion"]);
                      $("#velocidad").html(info[0]["Filtro de velocidad"]);
                      $("#aprobados").html(info[0]["Aprobados"]);
                      $("#ultimo_registro").html(info[0]["Ultimo Registro"]);
                      $("#dañados").html(info[0]["Archivos Da&ntilde;ados"]);
                      $("#otros").html(info[0]["Otros Filtros"]);
                      $("#descartados").html(info[0]["Descartados"]);
                      errores += '<strong><span class="text-danger">' + info[1]["error_cantidad"] + '</span></strong>';
                      if (info[1]["error_cantidad"] == 1) {
                        errores += ' Registro con error';
                      } else {
                        errores += ' Registros con errores';
                      }
                      errores += '<br>';
                      errores += '<strong>' + info[1]["error_descrip"] + '</strong>';

                      $("#errores").html(errores);
                      $("#actualizacion").html(info[1]["fecha"]);
                      setTimeout(fetchDecriptos, 5000)
                    }
                })
            }
        }
        
      });
  </script>
