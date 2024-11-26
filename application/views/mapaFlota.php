<style>
#map {
	height: 500px;
	width: 665px;
}

/* Configurar y centrar animación CARGADOR */
#loader {
  position: absolute;
  left: 50%;
  top: 40%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 2s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 }
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom {
  from{ bottom:-100px; opacity:0 }
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>

<script>
/* Recarga la página */
function recarga(){
	location.href=location.href
}
setInterval('recarga()',420000)

var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}

// Creo array de marcadores vacío
var map;
var markers = [];

function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 2,
		mapTypeControl: false,
		draggable: true,
		streetViewControl: false
	});

	var icon = {
			url: '<?=base_url()?>/assets/images/New-Cecaitra-car.png',
			scaledSize: new google.maps.Size(80, 120)
	};

	// Obtengo localización de vehículos
	$.post("<?=base_url('mapa/localizacionvehiculos')?>")
	.done(function(data) {
		vehiculos = JSON.parse(data);

		var bounds = new google.maps.LatLngBounds();
		var contentString = '';
// 	    // Display multiple markers on a map
	    var infoWindow = new google.maps.InfoWindow(), marker, i;
		for (i = 0; i < vehiculos.length; i++) {
			var point = new google.maps.LatLng(
					parseFloat(vehiculos[i].latitud),
					parseFloat(vehiculos[i].longitud));

			contentString = '<h4><center><strong><font color="blue">'+vehiculos[i].alias+'</h4></center></strong></font><h4><center><strong>'+vehiculos[i].patente+'</h4></center></strong><i><h5><center>'+vehiculos[i].fecha+'</h5></center></i>';

			bounds.extend(point);
			marker = new google.maps.Marker({
				title: vehiculos[i].patente,
				map: map,
				icon: icon,
				animation: google.maps.Animation.DROP,
				position: point,
				html: contentString,
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
	$("#vehiculos").change(function() {
		showVehiculo(this.value);
	});
});

//This function will loop through the listings and hide them all.
function showVehiculo(vehiculo) {
	if (vehiculo == 'TODOS') {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setVisible(true);
		}
	} else {
		for (var i = 0; i < markers.length; i++) {
			if (markers[i].title == vehiculo) {
				markers[i].setVisible(true);
			} else {
				markers[i].setVisible(false);
			}
		}
	}
}
</script>

</head>
		<body onload="myFunction()" style="margin:0;">
			<div id="loader"></div>
		</body>

<div class="content-wrapper">
    <section class="content-header">
				<div class="row bg-title" style="position: relative; bottom: 15px; ">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
								<h4 class="page-title">Flota Vehiculos</h4>
						</div>
						<div class="text-right">
								<ol class="breadcrumb" style="background-color: white">
										<li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
										<li class="active">Flota Vehiculos</li>
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
			              <h3 class="box-title">Lista de <b>Vehiculos</b></h3>
			            </div>
		            <!-- /.box-header -->
		            	<div class="box-body no-padding">
										<div class="col-md-12">
											<div class="form-group">
													<h4><label for="vehiculos">Dominio</label></h4>
													<select id="vehiculos" name="vehiculos" class="form-control selectpicker" multiple data-live-search="true" title="Seleccione dominio ..." data-size="10" data-max-options="1" required>
													<option value="" selected>TODOS</option>
													<?php foreach ($vehiculos as $vehiculo):?>
														<option value="<?=$vehiculo->dominio?>"><?=$vehiculo->dominio?></option>
													<?php endforeach; ?>
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
