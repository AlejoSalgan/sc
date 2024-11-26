/**
 * @author Francisco Araujo CECAITRA
 */

//obtener parametro segun la posición
function getParam(pos){
	var path = window.location.pathname;
	path = path.split('/');
	return path[pos];
}

jQuery(document).ready(function(){

	
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("¿Seguro de eliminar este item?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Usuario dado de baja"); }
				else if(data.status = false) { alert("Falló la baja del usuario"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".deleteEquipo", function(){
		var equipoid = $(this).data("equipoid"),
			hitURL = baseURL + "deleteEquipo",
			currentRow = $(this);
		
		var confirmation = confirm("¿Seguro de eliminar este Equipo?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { equipoid : equipoid } 
			}).done(function(data){
				alert(data);
				//currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Equipo dado de baja!"); }
				else if(data.status = false) { alert("Falló la baja del equipo"); }
				else { alert("Access denied..!"); }
				//location.reload();
			});
		} else {
			alert('no');
		}
	});

	jQuery(document).on("click", ".deleteComponente", function(){
		var componenteid = $(this).data("componenteid"),
			hitURL = baseURL + "deleteComponente",
			currentRow = $(this);
		
		var confirmation = confirm("¿Seguro de eliminar este Componente?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { componenteid :  componenteid} 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Componente dado de baja!"); }
				else if(data.status = false) { alert("Falló la baja del Componente"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".deleteCompRelacion", function(){
		var compid = $(this).data("compid"),
			hitURL = baseURL + "deleteCompRelacion",
			currentRow = $(this);
		
		var confirmation = confirm("¿Seguro de eliminar esta relación?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { compid : compid } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('p').remove();
				if(data.status = true) { alert("¡Componente desvinculado!"); }
				else if(data.status = false) { alert("Falló la baja del Componente"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteTipoeq", function(){
		var tipoeqId = $(this).data("tipoeqid"),
			hitURL = baseURL + "deleteTipoeq",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este tipo de equipo?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { tipoeqId : tipoeqId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Tipo de Equipo desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del tipo de equipo"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteMarcaeq", function(){
		var marcaeqId = $(this).data("marcaeqid"),
			hitURL = baseURL + "deleteMarcaeq",
			currentRow = $(this);

		var confirmation = confirm("Seguro de desactivar esta marca de equipo ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { marcaeqId : marcaeqId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Marca de Equipo desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la marca de equipo"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".deleteTipocomp", function(){
		var tipocompId = $(this).data("tipocompid"),
			hitURL = baseURL + "deleteTipocomp",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este Tipo de componente?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { tipocompId : tipocompId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Tipo de Componente desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del componente"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteMarcacomp", function(){
		var marcacompId = $(this).data("marcacompid"),
			hitURL = baseURL + "deleteMarcacomp",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar esta marca de componente ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { marcacompId : marcacompId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Marca de Componente desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la marca de componente"); }
				else { alert("Access denegado..!"); }
			});
		}
	});
	

	jQuery(document).on("click", ".deleteModeloeq", function(){
		var modeloeqId = $(this).data("modeloeqid"),
			hitURL = baseURL + "deleteModeloeq",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este modelo de equipo ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { modeloeqId : modeloeqId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Modelo Equipo desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del modelo de equipo"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".deleteMunicipio", function(){
		var municipioId = $(this).data("municipioid"),
			hitURL = baseURL + "deleteMunicipio",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este Municipio ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { municipioId : municipioId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Municipio desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del Municipio"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".deletePropietario", function(){
		var propietarioId = $(this).data("propietarioid"),
			hitURL = baseURL + "deletePropietario",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este Propietario ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { propietarioId : propietarioId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Propietario desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del Propietario"); }
				else { alert("Access denied..!"); }
			});
		}
	});


	jQuery(document).on("click", ".deleteOrdenesb", function(){
		var ordenesbId = $(this).data("ordenesbid"),
			hitURL = baseURL + "deleteOrdenesb",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar esta Orden ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ordenesbId : ordenesbId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Orden desactivada!"); }
				else if(data.status = false) { alert("Falló la baja de la Orden"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteFlota", function(){
		var flotaId = $(this).data("flotaid"),
			hitURL = baseURL + "deleteFlota",
			currentRow = $(this);

		var confirmation = confirm("¿Seguro de desactivar este Vehículo de equipo?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { flotaId : flotaId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("¡Vehículo desactivado!"); }
				else if(data.status = false) { alert("Falló la baja del Vehículo"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
