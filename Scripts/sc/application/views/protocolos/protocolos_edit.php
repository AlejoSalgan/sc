<?php

$ordenesbId        = '';
$tecnico           = '';
$nameTecnico       = '';
$bajada_desde      = '';
$bajada_hasta      = '';
$subida_cant       = '';

$equipoSerie       = '';
$protocolo         = '';
$bajada_archivos   = '';
$subida_fotos      = '';
$subida_videos     = '';
$subida_fabrica    = '';
$subida_envios     = '';
$subida_errores    = 0;
$subida_vencidos   = '';
$subida_sbd        = '';
$subida_repetidos  = '';
$subida_ingresados = '';
$subida_observ     = '';

foreach ($ordenesbInfo as $uf)
{
    $ordenesbId        = $uf->id;
    $tecnico           = $uf->tecnico;
    $nameTecnico       = $uf->nameTecnico;
    $bajada_desde      = $uf->bajada_desde;
    $bajada_hasta      = $uf->bajada_hasta;
    $subida_cant       = $uf->subida_cant;

    $equipoSerie       = $uf->equipoSerie;
    $protocolo         = $uf->protocolo;
    $bajada_archivos   = $uf->bajada_archivos;
    $subida_fotos      = $uf->subida_fotos;
    $subida_videos     = $uf->subida_videos;
    $subida_fabrica    = $uf->subida_fabrica;
    $subida_envios     = $uf->subida_envios;
    $subida_errores    = $uf->subida_errores;
    $subida_vencidos   = $uf->subida_vencidos;
    $subida_sbd        = $uf->subida_sbd;
    $subida_repetidos  = $uf->subida_repetidos;
    $subida_ingresados = $uf->subida_ingresados;
    $subida_observ     = $uf->subida_observ;
    $subida_documentos = $uf->subida_documentos;    
}

?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<div class="content-wrapper">
    <div id="cabecera">
  		Detalle del Protocolo
  		<span class="pull-right">
  			<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a> /
        <a href="<?=base_url('protocolosListing')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>">Protocolos Pendientes</a> /
  		  <span class="text-muted">Protocolo Nº <?= $protocolo; ?></span>
  		</span>
  	</div>

    <section class="content">

      <form role="form" id="editProtocolos" action="<?=base_url('editProtocolos')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>" method="post">
        <input type="hidden" value="<?php echo $protocolo; ?>" name="protocolo" id="protocolo" />

        <div class="row">

          <div class="col-md-6">
            <div class="row">

              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Archivos del Equipo</h3>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-3 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Imagenes</label>
                              <input type="number" class="form-control required digits" id="subida_fotos"  name="subida_fotos" maxlength="6" value="<?php echo $subida_fotos?>" min="0" autofocus>
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Videos</label>
                              <input type="number" class="form-control required digits" id="subida_videos"  name="subida_videos" value= "<?php echo $subida_videos ?>" min="0">
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Fabricante</label>
                          <input type="number" class="form-control required digits" id="subida_fabrica" name="subida_fabrica" value= "<?php echo $subida_fabrica ?>" min="0">
                            </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->

                      <div class="col-sm-3">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Documentos</label>
                          <input type="number" class="form-control required digits" id="subida_documentos" name="subida_documentos" value= "<?php echo $subida_documentos ?>" min="0">
                            </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </div>
                    <!-- /.row -->
                  </div>

                </div>
              </div>

              <div class="col-md-12">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Archivos errores del Equipo</h3>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Vencidos</label>
                              <input type="number" class="form-control required digits" id="subida_vencidos"  name="subida_vencidos" value= "<?php echo $subida_vencidos ?>" min="0">
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Repetidos</label>
                              <input type="number" class="form-control required digits" id="subida_repetidos" name="subida_repetidos" value= "<?php echo $subida_repetidos ?>" min="0">
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Sin BD</label>
                              <input type="number" class="form-control required digits" id="subida_sbd" name="subida_sbd" value= "<?php echo $subida_sbd ?>" min="0">
                            </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>

                </div>
              </div>

              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title">Archivos del Sistema</h3>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Ingresar</label>
                              <input type="text" class="form-control required digits" id="subida_envios" name="subida_envios" maxlength="6" value= "<?php echo $subida_envios ?>" readonly>
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Errores</label>
                            <input type="number" class="form-control required digits" id="subida_errores" name="subida_errores" value= "<?php echo $subida_errores ?>" min="0">
                          </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <div class="input-group">
                            <label for="">Total</label>
                            <input type="text" class="form-control required digits" id="subida_ingresados" name="subida_ingresados" value= "<?php echo $subida_ingresados ?>" readonly>
                            </div>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>

                </div>
              </div>

            </div>
          </div>


          <div class="col-md-6">
            <div class="row">

              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Orden de Bajada de Memoria</h3>
                  </div>

                  <div class="box-footer">
                    <strong>Nº Orden: </strong><?php echo "<a href=".base_url("verOrdenb/{$ordenesbId}").">" . $ordenesbId . "</a>"; ?>
                    <span class="pull-right"><strong>Protocolo:</strong> <a href="javascript:void(0);"><?php echo $protocolo; ?></a></span>

                  </div>

                  <div class="box-footer">
                    <strong>Equipo: </strong><?= "<a href=".base_url("verEquipo/{$idequipo}").">" . $equipoSerie . "</a>"; ?>
                    <span class="pull-right"><strong>Proyecto: </strong><?=$descripProyecto?></span>
                  </div>

                  <div class="box-footer">
                    <strong>Tecnico: </strong><?= "<a href=".base_url("verPersonal/{$tecnico}").">" . $nameTecnico . "</a>"; ?>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">

                          <strong><?=date('d/m/Y - H:i:s',strtotime($bajada_desde))?></strong>
                          <span class="description-text text-info">Fecha Desde</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <strong><?=date('d/m/Y - H:i:s',strtotime($bajada_hasta))?></strong>
                          <span class="description-text text-info">Fecha Hasta</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                            <strong><?=$bajada_archivos?></strong><br>
                          <span class="description-text text-info">Cantidad</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>


                </div>
              </div>

              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Modificar Orden</h3>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="text-center"for="hora_desde">Fecha Desde</label>
                      </div>

                      <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input id="subida_FD" name="subida_FD" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $subida_FD ?>">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control timepicker" id="hora_desde" name="hora_desde">
                                </div>
                            </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="text-center"for="hora_desde">Fecha Hasta</label>
                      </div>

                      <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <input id="subida_FH" name="subida_FH" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $subida_FH ?>">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control timepicker" id="hora_hasta" name="hora_hasta">
                                </div>
                            </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="box-footer">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="text-center"for="hora_desde">Cantidad</label>
                      </div>

                      <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                            <input type="number" class="form-control required digits" id="subida_cant" name="subida_cant" value= "<?php echo $subida_cant; ?>" min="0">
                        </div>
                      </div>

                    </div>
                  </div>











                </div>
              </div>

            </div>
          </div>

        </div>


        <div class="row">
          <div class="col-md-6">

            <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Observaciones</h3>
              </div><!-- /.box-header -->

                 <div class="box-body">

                     <div class="row">
                         <div class="col-md-12">
                             <div class="form-group">
                               <label for="subida_observ">Observaciones</label>
                               <textarea name="subida_observ" id="subida_observ" class="form-control" rows="3" cols="20"  style="resize: none"><?php echo $subida_observ;?></textarea>
                             </div>
                         </div>
                     </div><!-- /.row -->
                </div>
                 <div class="box-footer">
                    <button type="submit" value="Submit" class="btn btn-primary">Guardar</button>
                 </div>
            </div><!-- /.box -->

          </div>
        </div>

      </form>
    </section>












</div>

<script>
    $( document ).ready(function() {
        $("#subida_fotos").on('input',function(e){
            $("#subida_envios").val(parseFloat($(this).val()) - parseFloat($("#subida_vencidos").val()) - parseFloat($("#subida_repetidos").val()) - parseFloat($("#subida_sbd").val()) + parseFloat($("#subida_documentos").val()));
        });
        $("#subida_vencidos").on('input',function(e){
            $("#subida_envios").val(parseFloat($("#subida_fotos").val()) - parseFloat($(this).val())  - parseFloat($("#subida_sbd").val()) - parseFloat($("#subida_repetidos").val()) + parseFloat($("#subida_documentos").val()));
            $("#subida_ingresados").val($("#subida_fotos").val() - $(this).val() - $("#subida_errores").val()  - $("#subida_sbd").val() - $("#subida_repetidos").val() + parseFloat($("#subida_documentos").val()));
        });
        $("#subida_repetidos").on('input',function(e){
            $("#subida_envios").val(parseFloat($("#subida_fotos").val()) - parseFloat($(this).val())  - parseFloat($("#subida_sbd").val()) - parseFloat($("#subida_vencidos").val()) + parseFloat($("#subida_documentos").val()));
            $("#subida_ingresados").val($("#subida_fotos").val() - $(this).val() - $("#subida_errores").val() - $("#subida_sbd").val() + parseFloat($("#subida_documentos").val()));
        });
        $("#subida_sbd").on('input',function(e){
            $("#subida_envios").val(parseFloat($("#subida_fotos").val()) - parseFloat($(this).val()) - parseFloat($("#subida_vencidos").val())  - parseFloat($("#subida_repetidos").val()) + parseFloat($("#subida_documentos").val()));
            $("#subida_ingresados").val(parseFloat($("#subida_fotos").val()) - parseFloat($(this).val()) - parseFloat($("#subida_errores").val()) - parseFloat($("#subida_repetidos").val()) + parseFloat($("#subida_documentos").val()));
        });

        $("#subida_documentos").on('input',function(e){
            $("#subida_envios").val(
              parseFloat($("#subida_fotos").val() )
              +
              parseFloat(
              $(this).val())



            );
        });

        $("#subida_errores").on('input',function(e){
            if ($(this).val() == "") {
                $("#subida_ingresados").val("");
            } else {
                $("#subida_ingresados").val(
                  parseFloat($("#subida_envios").val())


                  -
                  parseFloat($(this).val())


                );
            }
        });
    });
</script>

<script>
    $(function() {
        $('#subida_FD').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#subida_FH').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('.timepicker').timepicker({
          showInputs: false
        })
    });
</script>
