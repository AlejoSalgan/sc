<?php if ($titulo != 'Reparaciones'){ ?>
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
<?php } ?>

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
		        <form action="<?php echo base_url($this->uri->segment (1)."/".$this->uri->segment (2)) ?>" method="POST" id="searchList">
	                <div class="input-group">
	                  <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Buscar ..."/>
	                  <div class="input-group-btn">
	                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
	                  </div>
	                </div>
	            </form>

	  			<table class="table table-striped" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Proyecto</th>
							<th>Fecha</th>
							<th>Tipo de falla</th>
							<?=$titulo=='Reparaciones'?'<th>Diagnóstico</th>':''?>
							<th>Tiempos</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($ordenes as $orden):?>
						<tr>
							<td><?php echo "<a href=".base_url("verEquipo/{$orden->em_id}").">" . $orden->rm_serie . "</a>"; ?></td>
							<td><?=$orden->mu_descrip?></td>
							<td><?=date('d/m/Y',strtotime($orden->re_fecha))?></td>
							<td><?=$orden->fm_descrip?></td>
							<?php if ($titulo=='Reparaciones'):?>
								<td><?=$orden->dm_descrip?></td>
							<?php endif;?>
							<td><span data-toggle="tooltip" data-placement="top" title="Tiempo transcurrido total" class="label <?=$orden->total<=7?'label-success':($orden->total<=14?'label-warning':'label-danger')?>"><?=$orden->total?></span></td><td><a data-toggle="tooltip" title="Ver" href="<?=base_url("ver-orden/{$orden->rm_id}?ref={$this->uri->uri_string()}")?>"><i class="fa fa-info-circle"></i></a></td>
						</tr>
					<?php endforeach;?>
					</tbody>
	  			</table>
			</div>
		</div>
    	    <div class="box-footer clearfix">
        	<?php echo $this->pagination->create_links(); ?>
        	</div>
	</div>
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            <?php if ($titulo == 'Reparaciones'): ?>
            jQuery("#searchList").attr("action", baseURL + "reparaciones/finalizadas/" + value);
            <?php else: ?>
            jQuery("#searchList").attr("action", baseURL + "mantenimiento/finalizadas/" + value);
            <?php endif; ?>
            jQuery("#searchList").submit();
        });
    });
</script>
