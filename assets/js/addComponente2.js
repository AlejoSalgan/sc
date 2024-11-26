/**
 * File : addComponente.js
 * 
 * This file contain the validation 
 * 
 * Using validation plugin : jquery.validate.js
 * 
 */

$(document).ready(function(){
	
	var addComponenteForm = $("#addComponente");
	
	var validator = addComponenteForm.validate({
		
		rules:{
			//serie :{ required : true },
			//equipo :{ required : true },
			tipo : { required : true, selected : true},
			eventoView : { required : true, selected : true}, 
			//marca : { required : true, selected : true}, 
			//estado : { required : true, selected : true} 
		},
		messages:{
			//serie :{ required : "Campo obligatorio" },
			//equipo :{ required : "Campo obligatorio" },
			tipo : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			eventoView : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			//marca : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" },
			//estado : { required : "Campo obligatorio", selected : "Seleccione al menos una opción" } 			
		}
	});
});
