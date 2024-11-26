<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/progressBar.css">


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row bg-title" style="position: relative; bottom: 15px; ">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?=$titulo?></h4> 
            </div>
            <div class="text-right">
                <ol class="breadcrumb" style="background-color: white">
                    <li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
                    <li class="active"><?=$titulo?></li>
                </ol>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">                              
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?=$nombre1?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Estadisticas</strong>
                                </p>

                                <div class="progress" id="prog">
                                    <div class="progress-bar" id="prog-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" <?="style='width:" .$formula1. "%;' "?> >
                                        <span class="sr-only"><?=$formula1?>% Complete</span>
                                    </div>
                                    <span class="progress-type" id="prog-type" ><?=$nombreBarra1?></span>
                                    <span class="progress-completed" id="prog-com"><?=$formula1?>%</span>
                                </div>                          
                              <!-- /.progress-group -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"></i> <?=$cantidad1?></span> de <span class="description-percentage text-green"></i> <?=$valorTotal1?></span>
                                            <br>
                                            <span class="description-text">Cantidad</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=$valorMinimo1?>%</span>
                                            <br>
                                            <span class="description-text">Valor Mínimo</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=$valorMaximo1?>%</span>
                                            <br>
                                            <span class="description-text">Valor Máximo</span>
                                        </div>
                                    </div>
                                </div>                  
                            </div>

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Detalles</strong>
                                </p>

                                <div class="col-xs-12">
                                    <p><strong>Puesto Responsable:</strong> <?=$puesto?></p>
                                    <p><strong>Periodicidad:</strong> <?=$periodicidad?></p>
                                    <p><strong>Descripción:</strong> <?=$descripcion1?></p>
                                </div>
                            </div>                      

                        </div>
                      <!-- /.row -->
                    </div>
                    
                </div>                 
            </div>
            
        </div>


        <div class="row">
            <div class="col-md-12">                              
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?=$nombre2?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Estadisticas</strong>
                                </p>

                                <div class="progress" id="prog">
                                    <div class="progress-bar" id="prog-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" <?="style='width:" .$formula2. "%;' "?> >
                                        <span class="sr-only"><?=$formula2?>% Complete</span>
                                    </div>
                                    <span class="progress-type" id="prog-type" ><?=$nombreBarra2?></span>
                                    <span class="progress-completed" id="prog-com"><?=$formula2?>%</span>
                                </div>                          
                              <!-- /.progress-group -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"></i> <?=$cantidad2?></span> de <span class="description-percentage text-green"></i> <?=$valorTotal2?></span>
                                            <br>
                                            <span class="description-text">Cantidad</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=$valorMinimo2?>%</span>
                                            <br>
                                            <span class="description-text">Valor Mínimo</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=$valorMaximo2?>%</span>
                                            <br>
                                            <span class="description-text">Valor Máximo</span>
                                        </div>
                                    </div>
                                </div>                  
                            </div>

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Detalles</strong>
                                </p>

                                <div class="col-xs-12">
                                    <p><strong>Puesto Responsable:</strong> <?=$puesto?></p>
                                    <p><strong>Periodicidad:</strong> <?=$periodicidad?></p>
                                    <p><strong>Descripción:</strong> <?=$descripcion2?></p>
                                </div>
                            </div>                      

                        </div>
                      <!-- /.row -->
                    </div>
                    
                </div>                 
            </div>
            
        </div>


        <div class="row">
            <div class="col-md-12">                              
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?=$nombre3?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Estadisticas</strong>
                                </p>

                                <div class="progress" id="prog">
                                    <div class="progress-bar" id="prog-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" <?="style='width:" .$formula3. "%;' "?> >
                                        <span class="sr-only"><?=$formula3?>% Complete</span>
                                    </div>
                                    <span class="progress-type" id="prog-type" ><?=$nombreBarra3?></span>
                                    <span class="progress-completed" id="prog-com"><?=$formula3?>%</span>
                                </div>                          
                              <!-- /.progress-group -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"></i> <?=$cantidad3?></span> de <span class="description-percentage text-green"></i> <?=$valorTotal3?></span>
                                            <br>
                                            <span class="description-text">Cantidad</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=$valorMinimo3?>%</span>
                                            <br>
                                            <span class="description-text">Valor Mínimo</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=$valorMaximo3?>%</span>
                                            <br>
                                            <span class="description-text">Valor Máximo</span>
                                        </div>
                                    </div>
                                </div>                  
                            </div>

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Detalles</strong>
                                </p>

                                <div class="col-xs-12">
                                    <p><strong>Puesto Responsable:</strong> <?=$puesto?></p>
                                    <p><strong>Periodicidad:</strong> <?=$periodicidad?></p>
                                    <p><strong>Descripción:</strong> <?=$descripcion3?></p>
                                </div>
                            </div>                      

                        </div>
                      <!-- /.row -->
                    </div>
                    
                </div>                 
            </div>
            
        </div>


        <div class="row">
            <div class="col-md-12">                              
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?=$nombre4?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Estadisticas</strong>
                                </p>

                                <div class="progress" id="prog">
                                    <div class="progress-bar" id="prog-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" <?="style='width:" .$formula4. "%;' "?> >
                                        <span class="sr-only"><?=$formula4?>% Complete</span>
                                    </div>
                                    <span class="progress-type" id="prog-type" ><?=$nombreBarra4?></span>
                                    <span class="progress-completed" id="prog-com"><?=$formula4?>%</span>
                                </div>                          
                              <!-- /.progress-group -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"></i> <?=$cantidad4?></span> de <span class="description-percentage text-green"></i> <?=$valorTotal4?></span>
                                            <br>
                                            <span class="description-text">Cantidad</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=$valorMinimo4?>%</span>
                                            <br>
                                            <span class="description-text">Valor Mínimo</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=$valorMaximo4?>%</span>
                                            <br>
                                            <span class="description-text">Valor Máximo</span>
                                        </div>
                                    </div>
                                </div>                  
                            </div>

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Detalles</strong>
                                </p>

                                <div class="col-xs-12">
                                    <p><strong>Puesto Responsable:</strong> <?=$puesto?></p>
                                    <p><strong>Periodicidad:</strong> <?=$periodicidad?></p>
                                    <p><strong>Descripción:</strong> <?=$descripcion4?></p>
                                </div>
                            </div>                      

                        </div>
                      <!-- /.row -->
                    </div>
                    
                </div>                 
            </div>
            
        </div>   


        <div class="row">
            <div class="col-md-12">                              
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?=$nombre5?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Estadisticas</strong>
                                </p>

                                <div class="progress" id="prog">
                                    <div class="progress-bar" id="prog-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" <?="style='width:" .$formula5. "%;' "?> >
                                        <span class="sr-only"><?=$formula5?>% Complete</span>
                                    </div>
                                    <span class="progress-type" id="prog-type" ><?=$nombreBarra4?></span>
                                    <span class="progress-completed" id="prog-com"><?=$formula4?>%</span>
                                </div>                          
                              <!-- /.progress-group -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"></i> <?=$cantidad5?></span> de <span class="description-percentage text-green"></i> <?=$valorTotal5?></span>
                                            <br>
                                            <span class="description-text">Cantidad</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?=$valorMinimo5?>%</span>
                                            <br>
                                            <span class="description-text">Valor Mínimo</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?=$valorMaximo5?>%</span>
                                            <br>
                                            <span class="description-text">Valor Máximo</span>
                                        </div>
                                    </div>
                                </div>                  
                            </div>

                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Detalles</strong>
                                </p>

                                <div class="col-xs-12">
                                    <p><strong>Puesto Responsable:</strong> <?=$puesto?></p>
                                    <p><strong>Periodicidad:</strong> <?=$periodicidad?></p>
                                    <p><strong>Descripción:</strong> <?=$descripcion5?></p>
                                </div>
                            </div>                      

                        </div>
                      <!-- /.row -->
                    </div>
                    
                </div>                 
            </div>
            
        </div>   


    </section>
</div>



