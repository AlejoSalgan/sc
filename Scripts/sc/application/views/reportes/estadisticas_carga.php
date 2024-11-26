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
        

        <div class="col-md-12">
          <div class="tab-content">
            <div class="tab-pane active" id="rapidos">
              <?php if (!in_array($role, array(60,61,62,63))): ?>
                <input type="hidden" name="reportes_rapidos" value="0">
                <div class="box box-primary" >
                  <div class="box-header with-border"><h3 class="box-title">Carga de Estadísticas</h3></div>
                  <div class="box-body ">
                    <form action="<?= base_url("reportes/cargar_estadisticas_archivo")?>" method="POST" enctype="multipart/form-data" name="myForm" data-toggle="validator">
                      <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="municipio">Proyecto</label>
                                <select class="form-control" id="municipio" name="municipio">
                                    <option value="">Seleccionar</option>
                                    <option value="7">CABA</option>
                                    <option value="">CABA-1</option>
                                    <option value="">CABA-3</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="idequipo">Modelo</label>
                            <select id="idequipo" name="idmodelo" class="form-control selectpicker" multiple data-live-search="true" multiple data-max-options="1" title="Seleccione los equipos..." data-size="6">
                            </select>
                            <input type="hidden" name="serie" id="serie" />
                          </div>
                          <div class="col-md-2">
                            <label>Protocolo</label>
                            <input class="form-control" type ="number" id="protocolo" name="protocolo">
                            <input type="hidden" name="serie" id="serie" />
                          </div>
                      </div><!-- /.row -->
                  
                      <div class="row">
                        <div class="col-md-6">
                          <label for="ordencompra">Archivo adjunto</label>
                          <div class="input-group">
                            <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Seleccionar Archivo <input type="file" style="display: none;" name="archivo" id="archivo">
                              </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                          </div>
                          <p class="help-block">Solo archivos .DAT.</p>
                          <p class="help-block">Solo archivos menor o igual a 1MB.</p>
                        </div>
                      </div><!-- /.row -->
                      <div class="box-footer ">
                        <input type="submit" class="btn btn-primary " value="Cargar" />
                       </div>
                    </form>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </div>
    </section>
</div>

<script>
    $(function() {
      $("#municipio").change(function () {
        valor = $(this).val();
        $.post("<?=base_url('ordenesb/equiposajax')?>", {proyecto: valor})
        .done(function(data) {
            var result = JSON.parse(data);
            var option = '';
            $("#idequipo").html("");
            var previo = ""; var i = 0;
            result.forEach(function(equipo) {
                option = option + '<option value="'+equipo['id']+'">'+equipo['serie']+'</option>';
            });
            $("#idequipo").append(option);
            $('.selectpicker').selectpicker('refresh');
        });
      });
    });
</script>