<?php

    $recibido         = $this->uri->segment(2);
    $tecnico_Old      = $this->uri->segment(3);
    $idproyecto       = $this->uri->segment(4);
    $fecha_visita_Old = $this->uri->segment(5);

    if(!empty($grupos_equiposRecords)) {
        foreach($grupos_equiposRecords as $record){
            $tecnico       = $record->tecnico;
            $nameTecnico   = $record->nameTecnico;
            $conductor     = $record->conductor;
            $nameConductor = $record->nameConductor;
            $iddominio     = $record->iddominio;
            $dominio       = $record->dominio;
            $fecha_visita  = $record->fecha_visita;
        }
    }

    $fecha_visita = $this->fechas->cambiaf_a_normal($fecha_visita);
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Editar grupo</h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li><a href="<?= base_url('gruposSE'); ?>" >Grupos</a></li>
                  <li class="active">Editar grupo</li>
              </ol>
          </div>
      </div>
     </section>

    <section class="content">
        <div class="box box-primary"> <!-- /.box-print -->
            &nbsp;
            <div class="row">
                <div class="col-xs-12">
                    <form role="form" action="<?php echo base_url() ?>gruposEditAprob" method="post" id="gruposEditAprob" role="form">
                        <input type="hidden" class="form-control" id="recibido" name="recibido" value="<?php echo $recibido ?>" >
                        <input type="hidden" class="form-control" id="tecnico_Old" name="tecnico_Old" value="<?php echo $tecnico_Old ?>">
                        <input type="hidden" class="form-control" id="idproyecto" name="idproyecto" value="<?php echo $idproyecto ?>">
                        <input type="hidden" class="form-control" id="fecha_visita_Old" name="fecha_visita_Old" value="<?php echo $fecha_visita_Old?>">

                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_visita">Fecha Visita</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            <input id="fecha_visita" name="fecha_visita" type="text" class="form-control" aria-describedby="fecha" value="<?php echo $fecha_visita ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="iddominio"><i class="fa fa-car" aria-hidden="true"></i> Dominio</label>
                                        <select class="form-control" id="iddominio" name="iddominio">
                                                <option value="0">Seleccionar</option>
                                                <?php
                                                if(!empty($vehiculos))
                                                {
                                                    foreach ($vehiculos as $vehiculo)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $vehiculo->id ?>" <?php if($vehiculo->id == $iddominio) {echo "selected=selected";} ?>><?php echo $vehiculo->dominio . " - " .  $vehiculo->marca. ", " .  $vehiculo->modelo ?></option>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="conductor"><i class="fa fa-users" aria-hidden="true"></i> Conductor</label>
                                        <select class="form-control" id="conductor" name="conductor">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($empleados))
                                            {
                                                foreach ($empleados as $empleado)
                                                {
                                                    ?>
                                                    <option value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $conductor) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fa fa-male" aria-hidden="true"></i> Técnico</label>
                                        <select class="form-control" id="tecnico" name="tecnico">
                                            <option value="0">Seleccionar</option>
                                            <?php
                                            if(!empty($empleados))
                                            {
                                                foreach ($empleados as $empleado)
                                                {
                                                    ?>
                                                    <option data-mobile="<?php echo $empleado->mobile ?>" data-imei="<?php echo $empleado->imei ?>" value="<?php echo $empleado->userId ?>" <?php if($empleado->userId == $tecnico) {echo "selected=selected";} ?>><?php echo $empleado->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="celular"><i class="fa fa-phone-square" aria-hidden="true"></i> Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" placeholder="000-0000000" readonly>
                                        <input type="hidden" name="imei" id="imei" value="" />
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Guardar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/imprime.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script>
    $(function() {
$("#tecnico option:selected").each(function () {
                mobile = $(this).data('mobile');
                imei = $(this).data('imei');
                $("#celular").val(mobile);
                $("#imei").val(imei);
            });
        $('#fecha_visita').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_oc').datepicker({
            format: 'dd-mm-yyyy',
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

</script>
