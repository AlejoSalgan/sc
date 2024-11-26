/**
 * File : editEquipo.js 
 * 
 */
$(document).ready(function(){
	
	var editForm = $("#editEquipo");
	
	var validator = editForm.validate({
		
		rules:{
			//serie :{ required : true },
			//decriptador :{ required : true },
			//ftp_host : { required : true, digits : true },
			//municipio : { required : true, selected : true}, 
			tipo : { required : true, selected : true}, 
			marca : { required : true, selected : true}, 
			modelo : { required : true, selected : true} 
		},
		messages:{
			//serie :{ required : "Campo obligatorio" },
			//decriptador :{ required : "Campo obligatorio" },
			//ftp_host :{ required : "Campo obligatorio" },
			//municipio : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" }, 
			tipo : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			marca : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			modelo : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" } 			
		}
	});
});