<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/listpermisos.php';

?>




<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Nueva fecha de corte</h4>
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li><a href="<?php echo base_url(); ?><?=strtolower($titulo)?>/ordenes"><?=$titulo?> Ordenes</a></li>
                    <li class="active">Orden Nº <?=$this->uri->segment(2);?></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
    	<div class="box">
    		<div class="box-body">
    			<form action="<?=base_url('ordenes/addfechaCorte')?>" method="post" >
          <input name="id_orden" type="hidden" value="<?=$this->uri->segment(2)?>">
    			<div class="row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="equipo">Fecha Desde</label>




                <div class="row">
                    <div class="col-md-6">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                          <input id="fecha_desde" name="fecha_desde" type="text" class="form-control" aria-describedby="fecha" autocomplete="off"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required>



                      </div>
                    </div>

                    <div class="col-md-6">
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
    				</div>
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="problema">Fecha Hasta</label>

                <div class="row">
                    <div class="col-md-6">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                          <input id="fecha_hasta" name="fecha_hasta" type="text" class="form-control" aria-describedby="fecha" autocomplete="off"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required>
                      </div>
                    </div>

                    <div class="col-md-6">
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
    				</div>
    			</div>



    			<div class="row">
    				<div class="col-md-12">
    					<div class="form-group">
    						<label for="observ">Observación</label>
    							<textarea id="observ" name="observ" rows="3" class="form-control" style="resize: none;" placeholder="Ingrese una observación..."></textarea>
    					</div>
    				</div>
    			</div>
    			<div class="row">
    				<div class="col-md-12">
    					<button class="btn btn-success" type="submit" accesskey="s">Guardar</button>
              <a class="btn btn-danger" href="<?php echo base_url(); ?><?=strtolower($titulo)?>/ordenes" accesskey="c">Cancelar</a>
    				</div>
    			</div>
    			</form>
    		</div>
    	</div>
    </section>
</div>

<script>
    $(function() {
        $('#fecha_desde').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('#fecha_hasta').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es'
        });

        $('.timepicker').timepicker({
          showInputs: false
        })
    });
</script>

<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
  })
</script>
