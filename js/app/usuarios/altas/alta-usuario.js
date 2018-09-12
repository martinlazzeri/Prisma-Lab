$(document).ready(function(){		
	//actualizarRoles();
	$("#firstname").focus();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#ShowImage").attr("src", e.target.result);
            $("#ShowImage").attr("width", 200);
            $("#ShowImage").attr("height", 200);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imagen").change(function(){
    readURL(this);
});

/*
function actualizarRoles(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/roles",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){	
			if (response.error === true)
			{
				if (response.data === "No se han econtrado datos")
				{
					$.bigBox({
						title : "Error",
						content : "No existen roles creados.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$.each(response.data, function(index, item){
					$("#rol").append("<option value=\""+item.Id+"\">"+item.Descripcion+"</option>");
				});
			}				
		},
		error: function(error){
			if (error.status === 500)
			{
				$.bigBox({
					title : "Error",
					content : "Ha ocurrido un error crítico y su solicitud no pudo ser procesada.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
				$("#ShowImage").prop("src", "app/usuarios/imagenes-perfil/avatar.gif");
			}
			else
			{
				$.bigBox({
					title : "Error",
					content : "No se pudieron obtener los roles de usuario.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
				$("#ShowImage").prop("src", "app/usuarios/imagenes-perfil/avatar.gif");
			}
		}
	});
}*/

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/usuarios/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "Error en el email")
				{
					$.bigBox({
						title : "Error",
						content : "El email es incorrecto. Verifique el formato de email que ingresó.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
				if (response.data === "Nombre de usuario repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El nombre de usuario que ingresó ya se encuentra registrado.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
				if (response.data === "Email de usuario repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El email que ingresó ya se encuentra registrado.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{	
				var inputImagen = new FormData($("input[name^='subida']"));
		        $.each($("input[name^='subida']")[0].files, function(index, item) {
		        	inputImagen.append(index, item);
		        });        
				$.ajax({
			      	url: "subir_img.php",
			      	type: "POST",
			      	data: inputImagen,
			      	enctype: "multipart/form-data",
			      	processData: false,
			      	contentType: false,
			      	success: function(respuesta){
			      	},
			      	error: function(err){
			      	}
			    });
				$.bigBox({
					title : "Éxito",
					content : "El usuario se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-usuarios").get(0).reset();
				$("#nombre").focus();
				$("#ShowImage").prop("src", "app/usuarios/imagenes-perfil/avatar.gif");
				$("#imagen").change();
			}
		},
		error: function(error){
			if (error.status === 500)
			{
				$.bigBox({
					title : "Error",
					content : "Ha ocurrido un error crítico y su solicitud no pudo ser procesada.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
				$("#ShowImage").prop("src", "app/usuarios/imagenes-perfil/avatar.gif");
			}
			else
			{
				arr = ["NombreUsuario", "Contrasena", "Nombre", "Apellido", "Email", "FechaNacimiento", "RoleId"];		
				Errores = "";
				j = 0;
				for (var i = 0; i < arr.length; i++) {
					if(j < 3){
						if (error.responseJSON.message.indexOf(arr[i]) > 0) 
						{
							Errores += arr[i].toString()+", ";
							j++;
						}
					}										
				};			
				Errores = Errores.replace("NombreUsuario", "nombre de usuario");
				Errores = Errores.replace("Contrasena", "contraseña");
				Errores = Errores.replace("FechaNacimiento", "fecha de nacimiento");					
				Errores = Errores.replace("RoleId", "rol de usuario");
				Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
				$.bigBox({
					title : "Error",
					content : "Asegúrese que completó todos los campos requeridos. <br>"+Errores,
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
	$("#ingresar").prop("disabled", false);
	e.preventDefault();
});

function FormToJSON(){
	var rutaimg = "";
	if ($("input[type=file]")[0].files[0] !== undefined)
	{
		rutaimg = $("input[type=file]")[0].files[0].name;
	}
	return JSON.stringify({
		"NombreUsuario": $("#nombre-usuario").val(),
		"Contrasena": $("#contrasena").val(),
		"Nombre": $("#nombre").val(),
		"Apellido": $("#apellido").val(),
		"Email": $("#email").val(),
		"FechaNacimiento": $("#fecha-nac").val(),
		"RoleId": $("#rol").find("option:selected").val(),
		"Imagen": rutaimg,
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#nombre").focus();
		key.preventDefault();
	}
});

$("#nombre").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#apellido").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nombre-usuario").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#contrasena").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#email").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#fecha-nac").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

