/**
 * @author Francisco Araujo
 */

jQuery(document).ready(function(){
	

	jQuery(document).on("click", ".deleteInsta", function(){
		var instaId = $(this).data("instaid"),
			hitURL = baseURL + "deleteInsta",
			currentRow = $(this);

		var confirmation = confirm("Seguro de desactivar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { instaId : instaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la Orden"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".enviarInsta", function(){
		var instaId = $(this).data("instaid"),
			hitURL = baseURL + "enviarInsta",
			currentRow = $(this);

		var confirmation = confirm("Seguro de Enviar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { instaId : instaId } 
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
		var hitURL = baseURL + "insta/enviarTodo";

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

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
