/**
 * @author Francisco Araujo / Cristian Rudzki
 */

 function getParam(pos){
	var path = window.location.pathname;
	path = path.split('/');
	return path[pos];
}

jQuery(document).ready(function(){
	

	jQuery(document).on("click", ".deleteCalib", function(){
		var calibId = $(this).data("calibid"),
			hitURL = baseURL + "deleteCalib",
			currentRow = $(this);

		var confirmation = confirm("Seguro de desactivar esta Solicitud?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Solicitud desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la Solicitud"); }
				else { alert("Access denied..!"); }
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".aprobarSoliG", function(){  
		var calibId = $(this).data("calibid");
		var tipoequipo = $(this).data("tipoequipo"),
		hitURL = baseURL + "aprobarSoliG",
		currentRow = $(this);

		var confirmation = confirm("Solicitar la Calibración de este Equipo?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId, tipoequipo : tipoequipo } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Solicitud Calibración Aprobada!"); }
				else if(data.status = false) { alert("Falló Aprobar Solicitud Calibración"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".solicitarSG", function(){
		var calibId = $(this).data("calibid"),
		hitURL = baseURL + "solicitarSG",
		currentRow = $(this);

		var confirmation = confirm("Solicitar a Servicios Generales?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Solicitud Calibración solicitada!"); }
				else if(data.status = false) { alert("Falló solicitada Solicitud Calibración"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".aprobarSoliSG", function(){
		var calibId = $(this).data("calibid"),
		hitURL = baseURL + "aprobarSoliSG",
		currentRow = $(this);

		//var confirmation = confirm("Aprobar Solicitud Calibracion ?");
		
		/*if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Solicitud Calibracion Aprobada!"); }
				else if(data.status = false) { alert("Falló Aprobar Solicitud Calibracion"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}*/
	});

	jQuery(document).on("click", ".espera", function(){
		var calibId = $(this).data("calibid"),
		hitURL = baseURL + "espera",
		currentRow = $(this);

		var confirmation = confirm("Convertir una Orden a Orden Pendiente?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Calibración en espera!"); }
				else if(data.status = false) { alert("Falló Orden Calibración"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".finalizar", function(){
		var calibId = $(this).data("calibid"),
		hitURL = baseURL + "finalizar",
		currentRow = $(this);

		var confirmation = confirm("Cerar la orden de Calibración?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { calibId : calibId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Calibración cerrada"); }
				else if(data.status = false) { alert("Falló Orden Calibración"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
