<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/breadcrumbs.css'); ?>">

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
  #example2_info {
    position: relative; top: 5px; left: 680px;
  }

  #example2_paginate {
    position: relative; bottom: 20px; right: 440px;
  }
</style>

<div class="content-wrapper">
     <div id="cabecera">
  		Equipamiento
  		<span class="pull-right">
  		<a href="<?= base_url(); ?>" class="fa fa-home"> Inicio</a>
        <a href="<?=base_url(''.$accion.'')."?searchText=".$this->input->get('searchText')."&criterio=".$this->input->get('criterio')?>"> <?= $titulo ?></a>
  		  <span class="text-muted">Ver Precintos</span>
  		</span>
  	</div>
  	
    <section class="content">
    	 <div class="row">
              <!-- col-md-12 -->
                  <div class="col-md-12">
                        <?php
                         $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if ($error):?>
                        <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('error'); ?>
                       </div>
                       <?php endif;?>
                       <?php
                        $success = $this->session->flashdata('success');
                         if ($success): ?>
                         <div class="alert alert-success alert-dismissable">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                         
                         <?= $this->session->flashdata('success');?>
                         </div>
                         <?php endif; ?>
                       <!-- row -->
                         <div class="row">
                           <div class="col-md-12">
                             <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');?>
                            </div>
                          </div>
                       <!-- /row -->
                   </div>
               <!-- /col-md-12 --> 
            </div>
   
          
        
		<div class="row">
           
        	<div class="col-xs-12">
                  <div class="box box-primary">
                     <div class="box-header with-border">
                        <h3 class="box-title">Inventario </h3>
                      </div><!-- /.box-header -->
            		  <div class="box-body">
            		<table id="example2" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                             <th>#</th>
                             <th>Imagen</th>
                           	 <th>Codigo</th>
                             <th>Descripcion</th>
                             <th>stock</th>
                             <th>Acciones</th>
                           </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>                 
                            <td> <img src="<?php echo base_url("assets/images/equipamiento/cono.jpg");?>" class="img-thumbnail" width="40px"></td>
                            <td>00123</td>
                            <td>conos viales</td>       
                            <td>
                             <span class="label label-success">50</span>
                            </td>                 
                            <td>
                                <!-- <button type="button" class="btn btn-primary">Agregar</button> -->
                                <a data-toggle="tooltip" title="Editar Producto" href="<?= base_url().'editar_usuario/'.$record->userId; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            </td>
                           </tr>
                          <tr>
                            <td>2</td>                 
                            <td> <img src="<?php echo base_url("assets/images/equipamiento/gabinete.jpg");?>" class="img-thumbnail" width="40px"></td>
                            <td>00125</td>
                            <td>Gabinete</td>       
                            <td>
                            <span class="label label-danger">10</span>
                            </td>                 
                            <td>                 
                              <a data-toggle="tooltip" title="Editar Producto" href="<?= base_url().'editar_usuario/'.$record->userId; ?>"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;</a>
                            </td>
                           </tr>
                        </tbody>
                 	 </table> 
            		 </div>
            		 <div class="box-footer">
        		 		  <!-- FOOTER -->		 	
        			</div>
                 </div><!-- /.box -->
             </div>
        </div>


<!--  -->

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet prefetch" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

              <div class="container">
                <div class="row">
                  <div class="col-md-12" style="margin-top:20px;">
                      <table class="table table-bordered table-striped">
                        <tr>
                           <td>País</td>
                           <td>Acciones</td>
                        </tr>
                        <tr>
                          <td >US</td>
                          <td id="us">
                            <button type="button" class="add">Ver ciudad</button>                    </td>
                        </tr>
                        <tr>
                          <td>MX</td>
                          <td id="mx">
                            <button type="button" class="add">Ver ciudad</button>                    </td>
                        </tr>
                         <tr>
                          <td>AR</td>
                          <td id="ar">
                            <button type="button" class="add">Ver ciudad</button>                    </td>
                        </tr>       
                      </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered table-striped" id="details-country">
                      <tr>
                         <td>ID ciudad</td>
                         <td>Ciudad</td>
                         <td>País</td>
                         <td>Acción</td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
      </div>
        </div>
   </section>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

 Ejecutar
<!-- -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  
  
  $(document).ready(function(){
  $('.add').click(function(){
    
    /*
    ** Obtengo el ID del pais del elemento padre
    ** del boton al que le doy clic
    */
    let id_country = $(this).parent().attr('id');
    /*
    ** Creo una variable con la URL a la que
    ** mandaré la petición y le concateno la variable id_country
    */
    let url =`https://api.meetup.com/2/cities?&country=${id_country}&page=1`;
    /*//`https://api.meetup.com/2/cities?&country=${id_country}&page=1`;
    
    	/*
    ** Creo una funcion AJAX de tipo GET donde
    ** configuro sus valores.
    ** type = tipo de método. Ej: POST o GET
    ** url = url donde haré la petición
    ** success = Si la información es correcta, me la retorna de la url donde hice la petición
    ** dataType = El tipo de dato que esperamos del servidor.
    ** jsonp por que hacemos una petición a un dominio diferente
    */
    
    $.ajax({
      type: "GET",
      url: url,
    
      success: function(data)
      {
        //console.log(data);
        let ciudad = data['results'][0]['city'];
        let id_ciudad = data['results'][0]['id'];
        let pais = data['results'][0]['localized_country_name'];
        
        let html = `
          <tr>
            <td>${id_ciudad}</td>
            <td>${ciudad}</td>
            <td>${pais}</td>
            <td><button type="button" class="deleteCity">Eliminar</button></td>
          </tr>
        `;
        
        $('#details-country tbody').append(html); //Insertamos la fila al cuerpo de la segunda tabla.
      },
      dataType: 'jsonp',
    });
    
  });
  
  //Delegación de eventos.
  $('#details-country tbody' ).on( "click", ".deleteCity", function() {
    $(this).parent().parent().remove();
  });
  
  
});
</script>