<style>
#map {
	height: 500px;
	width: 665px;
}
</style>

<script>
var map;
// Creo array de marcadores vacío
var markers = [];
var infowindow = null;

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

$( document ).ready(function() {
	$("#usuarios").change(function() {
		showUsuario(this.value);
	});
});

function timeSince(date) {

	  var seconds = Math.floor((new Date() - date) / 1000);

	  var interval = Math.floor(seconds / 31536000);

	  if (interval > 1) {
	    return "Hace " + interval + " años";
	  }
	  interval = Math.floor(seconds / 2592000);
	  if (interval > 1) {
	    return "Hace " + interval + " meses";
	  }
	  interval = Math.floor(seconds / 86400);
	  if (interval > 1) {
	    return "Hace " + interval + " días";
	  }
	  interval = Math.floor(seconds / 3600);
	  if (interval > 1) {
	    return "Hace " + interval + " horas";
	  }
	  interval = Math.floor(seconds / 60);
	  if (interval > 1) {
	    return "Hace " + interval + " minutos";
	  }
	  return "Hace " + Math.floor(seconds) + " segundos";
}

function downloadUrl(url,callback) {
	var request = window.ActiveXObject ?
		new ActiveXObject('Microsoft.XMLHTTP') :
		new XMLHttpRequest;

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			//request.onreadystatechange = doNothing;
			callback(request, request.status);
		}
	};
	request.open('GET', url, true);
	request.send(null);
}

function initMap() {
	// Creo nuevo mapa centrado en CABA
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.616949, lng: -58.445088},
		zoom: 9,
		mapTypeControl: false,
		styles: [
		      {
		        "featureType": "poi",
		        "stylers": [
		          { "visibility": "off" }
		        ]
		      }
		    ]
	});
	infowindow = new google.maps.InfoWindow({
		content: "holding..."
	});
	downloadUrl('<?="/locations/lugares.xml"?>', function(data) {
		var xml = data.responseXML;
		var xmlmarkers = xml.documentElement.getElementsByTagName('marker');
		var bounds = new google.maps.LatLngBounds();
		var infoWindow = new google.maps.InfoWindow();
		for (var i = 0; i < xmlmarkers.length; i++) {
			var nombre = xmlmarkers[i].getAttribute('nombre');
			var imei = xmlmarkers[i].getAttribute('imei');
			var fecha = xmlmarkers[i].getAttribute('fecha');
			var point = new google.maps.LatLng(
			parseFloat(xmlmarkers[i].getAttribute('lat')),
			parseFloat(xmlmarkers[i].getAttribute('lng')));

			var infowincontent = document.createElement('div');
			var strong = document.createElement('strong');
			strong.textContent = nombre;
			infowincontent.appendChild(strong);
			infowincontent.appendChild(document.createElement('br'));

			var timei = document.createElement('imei');
			timei.textContent = 'IMEI: '+imei;
			infowincontent.appendChild(timei);
			infowincontent.appendChild(document.createElement('br'));
			var tfecha = document.createElement('fecha');
			dfecha = new Date(fecha);
			tfecha.textContent = timeSince(dfecha);
			var em = document.createElement('em');
			em.textContent = tfecha.textContent;
			infowincontent.appendChild(em);

			marker = new google.maps.Marker({
				title: nombre,
				map: map,
				animation: google.maps.Animation.DROP,
				position: point,
				html: infowincontent
			});
			// Push the marker to our array of markers.
	        markers.push(marker);

			marker.addListener('click', function() {
				infowindow.setContent(this.html);
				infowindow.open(map, this);
			});
			bounds.extend(point);
		}
		map.fitBounds(bounds);
	});
}
</script>

<div class="content-wrapper">
		<section class="content-header">
			<div class="row bg-title" style="position: relative; bottom: 15px; ">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
							<h4 class="page-title">Localizaciones</h4>
					</div>
					<div class="text-right">
							<ol class="breadcrumb" style="background-color: white">
									<li><a href="<?php echo base_url(); ?>" class="fa fa-home"> Inicio</a></li>
									<li class="active">Localizaciones</li>
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
			              <h3 class="box-title">Lista de <b>Personal</b></h3>
			            </div>
		            <!-- /.box-header -->
		            	<div class="box-body no-padding">
										<div class="col-md-12">
											<div class="form-group">
												<h4><label for="usuarios" class="control-label">Usuarios</label></h4>
												<select id="usuarios" class="form-control">
														<option value="TODOS">TODOS</option>
															<?php foreach ($usuarios as $row):?>
																	<option value="<?=$row->name?>"><?=$row->name?></option>
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
