/**
 * File : editEvento.js 
 * 
 */
$(document).ready(function(){
	
	var editForm = $("#editEvento");
	
	var validator = editForm.validate({
		
		rules:{
			evento : { required : true, selected : true}, 
			//municipio : { required : true, selected : true}, 
			estado : { required : true, selected : true} 
		},
		messages:{
			evento : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			//municipio : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			estado : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" } 
		}
	});
});