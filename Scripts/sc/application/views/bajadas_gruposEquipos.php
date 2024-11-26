<?php
    $recibido     = $this->uri->segment(2);
    $tecnico      = $this->uri->segment(3);
    $idproyecto   = $this->uri->segment(4);
    $fecha_visita = $this->uri->segment(5);
?>

<link href="<?= base_url(); ?>assets/css/orden_bajadaMemoria.css" type="text/css" rel="stylesheet" media="print" />

<link href="<?= base_url(); ?>assets/css/orden_bajadaMemoria.css" type="text/css" rel="stylesheet" media="screen" />

<div class="content-wrapper">
    <div style="padding: 10px 15px; background-color: white; z-index: 999999; font-size: 16px; font-weight: 500;">
      Detalle del grupo
      <span class="pull-right">
        <a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?= base_url('gruposSE'); ?>" >Grupos</a> /
        <span class="text-muted">Detalle del grupo</span>
      </span>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-xs-4 text-left">
                <div class="form-group">
                    <a class="btn btn-primary" href="javascript:void(0);" id="imprime"  >Imprimir</a>
                </div>
            </div>
        </div>

        <span id="boxprint">
            <div class="row">
              <div class="col-xs-12">
                  <table class="table">
                    <tr>
                  		<th id="titulo" style="-webkit-print-color-adjust: exact;" colspan="4">Datos identificatorios - Emision</th>
                  	</tr>
                    <tr>
                  		<td id="col-tbl1">Nombre del proyecto:</td>
                  		<td id="dato-tbl1"><?= $grupo_datos->descripProyecto?></td>
                      <td id="col-tbl1">Fecha:</td>
                  		<td id="dato-tbl1"><?= date("d/m/Y")?></td>
                  	</tr>
                  </table>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                  <table id="tabla-2" class="table">
                    <tr>
                     <th id="titulo" style="-webkit-print-color-adjust: exact;" colspan="6">Orden de servicio de retiro de memorias</th>
                   </tr>
                    <tr id="col">
                     <td id="col-tbl2">Supervisor a <br>cargo</td>
                     <td id="just2">Personal operativo</td>
                     <td id="col-tbl2">Nro del <br>recorrido</td>
                     <td id="col-tbl2">Nro dominio <br>del vehiculo</td>
                     <td id="col-tbl2">Fecha de la <br>orden de servicio</td>
                     <td id="col-tbl2">Nro orden <br>de servicio</td>
                   </tr>
                   <tr>
                     <td id="dato-tbl2"rowspan="2">Cesar Melgarejo</td>
                     <td id="dato-tbl2"><?= $grupo_datos->nameTecnico?></td>
                     <td id="dato-tbl2" rowspan="2"> - </td>
                     <td id="dato-tbl2" rowspan="2"><?= $grupo_datos->dominio?></td>
                     <td id="dato-tbl2" rowspan="2"><?= date('d/m/Y',strtotime($grupo_datos->fecha_alta))?></td>
                     <td id="dato-tbl2" rowspan="2"><?= $nro_orden ?></td>
                   </tr>
                   <tr>
                     <td id="dato-tbl2"><?= $grupo_datos->nameConductor?></td>
                   </tr>
                   <tr>
                     <td id="linea-blanca" colspan="6">&nbsp;</td>
                   </tr>
                   <tr>
                     <td id="col2-tbl2" colspan="3">Responsable de la asignacion de la Tarea</td>
                     <td id="col2-tbl2" colspan="3">Funcionario Responsable del Gobierno/Organismo Contrante</td>
                   </tr>
                   <tr>
                     <td id="dato-tbl2" colspan="3">Alberto Martinez</td>
                     <td id="dato-tbl2" colspan="3">&nbsp;</td>
                   </tr>
                  </table>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                  <table id="tabla-3"class="table">
                    <tr>
                      <th id="titulo" style="-webkit-print-color-adjust: exact;" colspan="4">Protocolo de retiro - Resumen (Ingreso de memorias - Generacion del protocolo)</th>
                    </tr>
                    <tr>
                      <td id="col-tbl3" colspan="2">Total de equipos <br>visitados/involucrados</td>
                      <td id="just3">Fecha visita</td>
                      <td id="just3">Cantidad de paginas</td>
                    </tr>

                    <tr>
                     <td id="dato-tbl3" colspan="2"><?= $total_equipos?></td>
                     <td id="dato-tbl3"><?= date('d/m/Y',strtotime($grupo_datos->fecha_visita))?></td>
                     <td id="dato-tbl3"><?= $cant_pag?></td>
                    </tr>

                    <tr>
                      <th id="titulo" style="-webkit-print-color-adjust: exact;" colspan="4">Intervención (Aclaracion, Fecha y Firma)</th>
                    </tr>
                    <tr>
                      <td id="col2-tbl3" colspan="2"><b>Responsables de la Ejecución de la Tarea</b></td>
                      <td id="col2-tbl3" colspan="2"><b>Responsable Area Tratamiento (Desencrip./Procesamiento)</b></td>
                    </tr>

                    <tr>
                     <td id="dato-tbl3">&nbsp;</td>
                     <td id="dato-tbl3">&nbsp;</td>
                     <td id="dato-tbl3">&nbsp;</td>
                     <td id="dato-tbl3">&nbsp;</td>
                    </tr>
                  </table>
              </div>
            </div>

            <?php foreach ($grupos_equipos as $record): ?>
              <div class="row" >
                <div class="col-xs-12">
                  <table id="tabla-4A" class="table">
                    <tr>
                     <th id="titulo2" style="-webkit-print-color-adjust: exact;" colspan="6">Detalles por equipo</th>
                   </tr>
                    <tr>
                     <td id="col-tbl4A">Equipo Nº</td>
                     <td id="dato-tbl4A"><?= $record->equipoSerie;?></td>
                     <td id="col2-tbl4A" rowspan="2">Archivos <br>retirados</td>
                     <td id="col3-tbl4A">Desde</td>
                     <td id="dato2-tbl4A">&nbsp;</td>
                     <td id="col4-tbl4A" rowspan="2">Nro del <br>protocolo</td>
                   </tr>

                   <tr>
                     <td id="col-tbl4A">Ubicacion</td>
                     <td id="dato2-tbl4A"><?=
                      ($record->ubicacion_calle == NULL || $record->ubicacion_calle == "") ? "A designar" : substr($record->ubicacion_calle." ".$record->ubicacion_altura, 0,36) ;

                     ?></td>
                     <td id="col3-tbl4A">Hasta</td>
                     <td id="dato2-tbl4A">&nbsp;</td>
                   </tr>
                  </table>

                  <table id="tabla-4B" class="table">
                    <tr>
                     <td id="col-tbl4B" rowspan="2">Retiro de <br>memorias</td>
                     <td id="col2-tbl4B">Hora inicio</td>
                     <td id="dato-tbl4B">&nbsp;</td>
                     <td id="col3-tbl4B">Total de presunciones</td>
                     <td id="dato2-tbl4B">&nbsp;</td>
                     <td id="dato3-tbl4B"rowspan="2">&nbsp;</td>
                   </tr>

                   <tr>
                     <td id="col2-tbl4B">Hora fin</td>
                     <td id="dato-tbl4B">&nbsp;</td>
                     <td id="col3-tbl4B">Total de archivos</td>
                     <td id="dato2-tbl4B">&nbsp;</td>
                   </tr>
                  </table>

                  <table id="tabla-4C" class="table">
                    <tr>
                     <td id="col-tbl4C">Estado normal y funcionamiento:</td>
                     <td id="dato-tbl4C">&nbsp;</td>
                     <td id="col2-tbl4C">Equipo apagado:</td>
                     <td id="dato-tbl4C">&nbsp;</td>
                     <td id="col3-tbl4C">Inst./Equipo con signos de vandalimo:</td>
                     <td id="dato2-tbl4C">&nbsp;</td>
                   </tr>
                   <tr>
                     <td id="col-tbl4C">Observaciones:</td>
                     <td id="dato2-tbl4C" colspan="5"></td>
                   </tr>
                  </table>
                </div>
              </div>
            <?php endforeach; ?>
          </span>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/imprime.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
