/**
 * File : addEquipo.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addEquipoForm = $("#addEquipo");
	
	var validator = addEquipoForm.validate({
		
		rules:{
			serie :{ required : true },
			remito :{ required : true },
			//municipio : { required : true, selected : true}, 
			tipo : { required : true, selected : true}, 
			marca : { required : true, selected : true}, 
			modelo : { required : true, selected : true} 
		},
		messages:{
			serie :{ required : "Campo obligatorio" },
			remito :{ required : "Campo obligatorio" },
			//municipio : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" }, 
			tipo : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			marca : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			modelo : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" } 			
		}
	});
});
