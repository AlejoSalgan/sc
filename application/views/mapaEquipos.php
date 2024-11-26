<style>
#map {
	height: 500px;
	width: 665px;
}
</style>

<script>
// Creo array de marcadores vacío
var map;
var markers = [];

//This function will loop through the listings and hide them all.
function showUsuario(usuario) {
	if (usuario == 'TODOS') {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setVisible(true);
		}
	} else {
		for (var i = 0; i < markers.length; i++) {
			if (markers[i].title == usuario) {
				markers[i].setVisible(true);
			} else {
				markers[i].setVisible(false);
			}
		}
	}
}

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 2,
		mapTypeControl: false,
		draggable: true,
		streetViewControl: false
		});

	var icon = {
			url: '<?=base_url()?>/assets/images/MarcadorEquipoFijo.png',
			scaledSize: new google.maps.Size(40, 60)

			};

	$.post( "<?=base_url('equipos/localizacionfijos')?>")
	.done(function( data ) {
		equipos = JSON.parse(data);
		var bounds = new google.maps.LatLngBounds();
		var contentString = '';
	    // Display multiple markers on a map
	    var infoWindow = new google.maps.InfoWindow(), marker, i;
		for (i = 0; i < equipos.length; i++) {
			var point = new google.maps.LatLng(
					parseFloat(equipos[i].geo_lat),
					parseFloat(equipos[i].geo_lon));

			contentString = '<div id="content"><h3><center><b><a href="<?=base_url('verEquipo')?>/'+equipos[i].id+'">' + equipos[i].serie + '</a></b></center></h3><h4><center><font color="green">'+equipos[i].ubicacion_calle+' '+equipos[i].ubicacion_altura+'</center></font></h4></div></b></center></h3><h4><center><b>Lugar:</b> '+equipos[i].descripEstado+'</center></h4></div>';

			bounds.extend(point);
			marker = new google.maps.Marker({
				title: equipos[i].serie,
				map: map,
				icon: icon,
				animation: google.maps.Animation.DROP,
				position: point,
				html: contentString,
				dato: equipos[i].m_id
			});
			// Push the marker to our array of markers.
	        markers.push(marker);

	        google.maps.event.addListener(marker, 'click', (function(marker, i) {
	            return function() {
	                infoWindow.setContent(this.html);
	                infoWindow.open(map, marker);
	            }
	        })(marker, i));
		}
		map.fitBounds(bounds);
	});
}

$( document ).ready(function() {
	$("#municipio").change(function() {
		showEquipo(this.value);
	});
});

function showEquipo(municipio) {
	var bounds = new google.maps.LatLngBounds();
	if (municipio == 0) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setVisible(true);
			bounds.extend(markers[i].position);
		}
	} else {
		for (var i = 0; i < markers.length; i++) {
			if (markers[i].dato == municipio) {
				markers[i].setVisible(true);
				bounds.extend(markers[i].position);
			} else {
				markers[i].setVisible(false);
			}
		}
	}
	map.fitBounds(bounds);
}
</script>


<div class="content-wrapper">
	<section class="content-header">
		<div class="row bg-title" style="position: relative; bottom: 15px; ">
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h4 class="page-title">Equipos fijos</h4>
				</div>
				<div class="text-right">
						<ol class="breadcrumb" style="background-color: white">
								<li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
								<li class="active">Equipos fijos</li>
						</ol>
				</div>
		</div>
	</section>

	<section class="content">
		<div class="row">
				<div class="col-md-8 col-sm-8">
						<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title">Ubicación</b></h3>
								</div>
							<!-- /.box-header -->
								<div class="box-body no-padding">
										<div class="row">
												<div class="col-md-8 col-sm-8">
													<div class="pad">
														<div id="map"></div>
																<div id="world-map-markers"></div>
													 </div>
												</div>
										</div>
								</div>
						</div>
				</div>

				<div class="col-md-4 col-sm-4">
						<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title">Lista de <b>Municipios</b></h3>
								</div>
							<!-- /.box-header -->
								<div class="box-body no-padding">
									<div class="col-md-12">
										<div class="form-group">
												<h4><label for="municipio">Proyectos</label></h4>
												<select class="form-control" id="municipio" name="municipio">
														<option value="0">TODOS</option>
														<?php foreach ($municipios as $municipio) : ?>
																<option value="<?php echo $municipio->id; ?>"><?php echo $municipio->descrip ?></option>
														<?php endforeach;	?>
												</select>
										</div>
									</div>
								</div>
						</div>
				</div>
		</div>
	</section>
</div>

<?php require APPPATH . '/libraries/mapas_llaveGoogle.php'; ?>
