/**
 * @author Francisco Araujo
 */

jQuery(document).ready(function(){
	

	jQuery(document).on("click", ".deleteRepa", function(){
		var repaId = $(this).data("repaid"),
			hitURL = baseURL + "deleteRepa",
			currentRow = $(this);

		var confirmation = confirm("Seguro de desactivar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { repaId : repaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la Orden"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".enviarRepa", function(){
		var repaId = $(this).data("repaid"),
			hitURL = baseURL + "enviarRepa",
			currentRow = $(this);

		var confirmation = confirm("Seguro de Enviar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { repaId : repaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Enviada!"); }
				else if(data.status = false) { alert("Falló el envío de la Orden"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".enviarTodo", function(){
		var hitURL = baseURL + "repa/enviarTodo";

		var confirmation = confirm("Seguro de Enviar esta Orden ?");
		
		if(confirmation)
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
		}
	});

	jQuery(document).on("click", ".aprobarSoli", function(){
		var repaId = $(this).data("repaid"),
		hitURL = baseURL + "aprobarSoli",
		currentRow = $(this);

		var confirmation = confirm("Aprobar Orden Solicitud Tecnica ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { repaId : repaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden Solicitud Tecnica Aprobada!"); }
				else if(data.status = false) { alert("Falló Aprobar Orden Solicitud Tecnica"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
