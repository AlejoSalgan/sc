<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="row bg-title" style="position: relative; bottom: 15px; ">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Solicitudes APP</h4>
          </div>
          <div class="text-right">
              <ol class="breadcrumb" style="background-color: white">
                  <li><a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                  <li><a href="<?= base_url('userListing/0/2'); ?>">Empleados Listado</a></li>
                  <li class="active"><?= $userInfo[0]->name?></li>
              </ol>
          </div>
      </div>
     </section>

     <section class="content">
       <div class="box box-primary">
         <div class="box-header with-border">
             <h3 class="box-title">Listado de Solicitudes</h3>
        </div>
         &nbsp;

     	      <div class="row">
              <div class="col-xs-6">
                  <div class="col-xs-12">
                      <div class="panel panel-primary" >
                          <div class="panel-heading">
                            Ubicacion
                          </div>
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                  <div class="row">
                                      <div class="col-xs-6">
                                        <form id="frmajax" method="post">
                                            <input type="hidden" class="form-control" name="codigo_msj" value="3000" >
                                            <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                            <input type="button" class="btn btn-primary btn-block guardar" value="Coordenadas" />
                                        </form>
                                      </div>

                                      <div class="col-xs-6">
                                        <form id="frmajax2" method="post">
                                            <input type="hidden" class="form-control" name="codigo_msj" value="3008" >
                                            <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                            <input type="button" class="btn btn-primary btn-block guardar" value="Ubicar telefono" />
                                        </form>
                                      </div>
                                   </div>

                                </div>
                            </div>
                          </div>
                      </div>
                   </div>
              </div>

              <div class="col-xs-6">
                  <div class="col-xs-12">
                      <div class="panel panel-primary" >
                          <div class="panel-heading">
                            Informacion del telefono
                          </div>
                          <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                  <div class="row">
                                      <div class="col-xs-6">
                                        <form id="frmajax3" method="post">
                                            <input type="hidden" class="form-control" name="codigo_msj" value="3004">
                                            <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                            <input type="button" class="btn btn-primary btn-block guardar" value="Marca y modelo" />
                                        </form>
                                      </div>

                                      <div class="col-xs-6">
                                        <form id="frmajax4" method="post">
                                            <input type="hidden" class="form-control" name="codigo_msj" value="3011">
                                            <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                            <input type="button" class="btn btn-primary btn-block guardar" value="Aplicaciones instaladas" />
                                        </form>
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
     	          <div class="col-xs-6">
     		            <div class="col-xs-12">
     			              <div class="panel panel-primary" >
     			                  <div class="panel-heading">
                              Red
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                  <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-4">
                                          <form id="frmajax5" method="post">
                                              <input type="hidden" class="form-control" name="codigo_msj" value="3001">
                                              <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                              <input type="button" class="btn btn-primary btn-block guardar" value="Operador de red" />
                                          </form>
                                        </div>

                                        <div class="col-xs-4">
                                          <form id="frmajax6" method="post">
                                              <input type="hidden" class="form-control" name="codigo_msj" value="3002">
                                              <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                              <input type="button" class="btn btn-primary btn-block guardar" value="Tipo de red" />
                                          </form>
                                        </div>

                                        <div class="col-xs-4">
                                          <form id="frmajax7" method="post">
                                              <input type="hidden" class="form-control" name="codigo_msj" value="3003">
                                              <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                              <input type="button" class="btn btn-primary btn-block guardar" value="Sim operador" />
                                          </form>
                                        </div>
                                     </div>
                                  </div>

           			              </div>
     			                  </div>
     			              </div>
     			           </div>
     	          </div>

                <div class="col-xs-6">
     		            <div class="col-xs-12">
     			              <div class="panel panel-primary" >
     			                  <div class="panel-heading">
                              Bateria
                            </div>
     			                  <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                      <div class="row">
                                          <div class="col-xs-4">
                                            <form id="frmajax8" method="post">
                                                <input type="hidden" class="form-control" name="codigo_msj" value="3005">
                                                <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                                <input type="button" class="btn btn-primary btn-block guardar" value="Porcentaje" />
                                            </form>
                                          </div>

                                          <div class="col-xs-4">
                                            <form id="frmajax9" method="post">
                                                <input type="hidden" class="form-control" name="codigo_msj" value="3006">
                                                <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                                <input type="button" class="btn btn-primary btn-block guardar" value="Temperatura" />
                                            </form>
                                          </div>

                                          <div class="col-xs-4">
                                            <form id="frmajax9" method="post">
                                                <input type="hidden" class="form-control" name="codigo_msj" value="3007">
                                                <input type="hidden" class="form-control" name="userId" value="<?= $userInfo[0]->userId ?>">
                                                <input type="button" class="btn btn-primary btn-block guardar" value="Voltaje" />
                                            </form>
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
                 <div class="col-xs-12">
                     <div class="col-xs-12">
                         <div class="panel panel-primary">
                             <div class="panel-heading">
                               Resultado
                             </div>
                             <div class="panel-body">
                                <blockquote>
                                    <span id="content">Seleccione una solicitud.</span>
                                </blockquote>
                             </div>
                         </div>
                      </div>
                 </div>
            </div>
     </section>
</div>

<script>
    $(document).ready(function(){
      $('.guardar').click(function(){
        var valor = $(this).closest("form").serialize();
        $('#content').html('<div class="overlay"><br><i class="fa fa-refresh fa-spin"></i></div>');
        $.post( "<?=base_url('mensajes_app')?>", valor)
        .fail(function() {
            $("#content").html('');
            alert('Ha surgido un error.');
          })
        .done(function(respuesta) {
          $("#content").html(respuesta);
        });
      });
    });
</script>
