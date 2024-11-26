/**
 * @author Francisco Araujo
 */

jQuery(document).ready(function(){
	

	jQuery(document).on("click", ".deleteMante", function(){
		var manteId = $(this).data("manteid"),
			hitURL = baseURL + "deleteMante",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar esta Orden?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { manteId : manteId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la orden"); }
				else { alert("¡Acceso denegado..!"); }
			});
		}
	});

	jQuery(document).on("click", ".enviarMante", function(){
		var manteId = $(this).data("manteid"),
			hitURL = baseURL + "enviarMante",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de enviar esta orden?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { manteId : manteId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Enviada!"); }
				else if(data.status = false) { alert("Falló el envío de la orden"); }
				else { alert("¡Acceso denegado!"); }
			});
		}
	});

	jQuery(document).on("click", ".enviarTodo", function(){
		var hitURL = baseURL + "mante/enviarTodo";

		var confirmation = confirm("¿Seguro de enviar esta orden?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL, 
			data : {  } 
			}).done(function(data){
				if(data.status = true) { alert("¡Orden enviada!"); }
				else if(data.status = false) { alert("Falló el envío de la orden"); }
				else { alert("¡Acceso denegado!"); }
			});
		}
	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
