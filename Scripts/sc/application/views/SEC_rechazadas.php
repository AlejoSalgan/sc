<script>  // En bootstrap.min.css se configuro overflow-X como unset. La variable original era AUTO.
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
		'paging'        : true,
		'lengthChange'  : false,
		'searching'     : false,
		'ordering'      : false,
		'info'          : true,
		'iDisplayLength': 30,
		'autoWidth'     : false
    })
  })
</script>

<style>
  #example2_info {
    position: relative; top: 5px; left: 680px;
  }

  #example2_paginate {
    position: relative; bottom: 20px; right: 440px;
  }
</style>

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
                  <li class="active"><?=$titulo?> <?=$subtitulo?> de trabajo</li>
              </ol>
          </div>
      </div>
     </section>

    <section class="content">
	<div class="box">
		<div class="box-body">
			<div class="table-responsive">
				<form method="get" action="<?=base_url(uri_string())?>">
					<div class="box-tools">
		                <div class="input-group">
		                <input id="search" type="text" name="search" value="<?=$search?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar . . ."/>
		                    <div class="input-group-btn">
		                        <button id="searchbutton" type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
		                    </div>
		                </div>
		            </div>
		        </form>

	  			<table class="table table-striped" id="example2">
					<thead>
						<tr>
							<th>Equipo</th><th>Proyecto</th><th>Fecha</th><th>Tipo de falla</th><th>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($ordenes as $orden):?>
						<tr>
							<td><strong><?=$orden->rm_serie?></strong></td><td><?=$orden->mu_descrip?></td><td><?=date('d/m/Y',strtotime($orden->re_fecha))?></td><td><?=$orden->fm_descrip?></td><td><a data-toggle="tooltip" title="Ver" href="<?=base_url("ver-orden/{$orden->rm_id}?ref={$this->uri->uri_string()}")?>"><i class="fa fa-info-circle"></i></a></td>
						</tr>
					<?php endforeach;?>
					</tbody>
	  			</table>
			</div>
		</div>
	</div>
    </section>
</div>
