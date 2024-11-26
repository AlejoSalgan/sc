/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#agregar_editar_usuario");
	
	var validator = addUserForm.validate({
		
		rules:{
			nombre :{ required : true },
			apellido :{ required : true },
			email : { required : true, email : true },
			//password : { required : true },
			//cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			nombre :{ required : "Campo obligatorio." },
			apellido :{ required : "Campo obligatorio." },
			email : { required : "Campo obligatorio.", email : "Ingrese una direccion de correo." },
			//password : { required : "Campo obligatorio." },
			//cpassword : {required : "Campo obligatorio.", equalTo: "La contraseña no es igual." },
			mobile : { required : "Campo obligatorio.", digits : "Ingrese únicamente números." },
			role : { required : "Campo obligatorio.", selected : "Seleccione al menos una opción." }			
		}
	});
});
