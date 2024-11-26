/**
 * @author Francisco Araujo
 */

jQuery(document).ready(function(){
	

	jQuery(document).on("click", ".deleteOrdenesb", function(){
		var ordenesbId = $(this).data("ordenesbid"),
			hitURL = baseURL + "deleteOrdenesb",
			currentRow = $(this);

		var confirmation = confirm("Seguro de desactivar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ordenesbId : ordenesbId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la Orden"); }
				else { alert("Access denied..!"); }
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".enviarOrdenesb", function(){
		var ordenesbId = $(this).data("ordenesbid"),
			hitURL = baseURL + "enviarOrdenesb",
			currentRow = $(this);

		var confirmation = confirm("Seguro de Enviar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ordenesbId : ordenesbId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Enviada!"); }
				else if(data.status = false) { alert("Falló el envío de la Orden"); }
				else { alert("Access denied..!"); }
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".enviarTodo", function(){
		var ordenesbid = $(this).data("ordenesbid"),
		hitURL = baseURL + "enviarTodo",
		currentRow = $(this);

		//var confirmation = confirm("Seguro de Enviar esta Orden ?");
		
		/*if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL, 
			data : {  } 
			}).done(function(data){
				if(data.status = true) { alert("Orden Enviada!"); }
				else if(data.status = false) { alert("Falló el envío de la Orden"); }
				else { alert("Access denied..!"); }
			});
		}*/

		//location.reload();
	});

	jQuery(document).on("click", ".cancelarEnvOrdenesb", function(){
		var ordenesbId = $(this).data("ordenesbid"),
		hitURL = baseURL + "cancelarEnvOrdenesb",
		currentRow = $(this);

		var confirmation = confirm("Cancelar el envio de esta orden?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ordenesbId : ordenesbId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("Envio Cancelado"); }
				else if(data.status = false) { alert("Falló la cancelación de esta orden"); }
				else { alert("Access denied..!"); }				
				location.reload();
			});
		}
	});

	jQuery(document).on("click", ".cancelarEnvOrdenesG", function(){
		var ordenesbid = $(this).data("ordenesbid"),
		hitURL = baseURL + "cancelarEnvOrdenesG",
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

	jQuery(document).on("click", ".limpiarCelular", function(){
		var celularid = $(this).data("celularid"),
			hitURL = baseURL + "limpiarCelular",
			currentRow = $(this);
		
		var confirmation = confirm("¿Desea limpiar este celular?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { celularid : celularid } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Equipo dado de baja!"); }
				else if(data.status = false) { alert("Falló la baja del equipo"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
