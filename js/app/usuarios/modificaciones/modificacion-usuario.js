$(document).ready(function(){
	actualizarUsuarios();
	actualizarRoles();
	$("#buscar-usuario").focus();
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

function actualizarUsuarios(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/usuarios",
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
						content : "No existen usuarios creados.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#usuarios").empty();
				$.each(response.data, function(index, item){
					$("#usuarios").append("<option data-value=\""+item.Id+"\" value=\""+item.NombreUsuario+" - "+item.Nombre+" "+item.Apellido+"\"></option>");
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
			}
			else
			{
				$.bigBox({
					title : "Error",
					content : "No se pudieron obtener los usuarios.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

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
			}
		}
	});
}

$("#buscar-usuario").on("input", function(){
	var val = this.value;
	if ($("#usuarios option").filter(function(){
		return this.value === val;
	}).length)
	{
		if($("#buscar-usuario").val() !== "")
		{
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/usuarios/"+$("#usuarios [value='" + $("#buscar-usuario").val() + "']").data("value"),
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
								content : "El usuario no existe.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
							actualizarUsuarios();
							$("#form-modificar :input").prop("disabled", true);
							$("#form-modificar").get(0).reset();
							$("#buscar-usuario").prop("disabled", false);
							$("#buscar-usuario").focus();
						}
					}
					else
					{
						$("#form-modificar :input").prop("disabled", false);												

						$("#nombre").val(response.data[0].Nombre);
						$("#apellido").val(response.data[0].Apellido);
						$("#nombre-usuario").val(response.data[0].NombreUsuario);						
						$("#email").val(response.data[0].Email);
						$("#fecha-nac").val(response.data[0].FechaNacimiento);
						$("#rol").val(response.data[0].RoleId);
						$("#ShowImage").prop("src", response.data[0].Imagen);
						$("#nombre").focus();
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
					}
					else
					{
						$.bigBox({
							title : "Error",
							content : "No se pudo obtener el usuario.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
		else
		{
			$("#form-modificar :input").prop("disabled", true);
			$("#form-modificar").get(0).reset();
			$("#buscar-usuario").prop("disabled", false);
		}
	}
	else
	{

	}		
});

$("#buscar-usuario").change(function(){
	if($("#buscar-usuario").val() === "")
	{
		$("#form-modificar :input").prop("disabled", true);
		$("#form-modificar").get(0).reset();
		$("#buscar-usuario").prop("disabled", false);
	}
});

$("#buscar-usuario").blur(function(){
	if($("#buscar-usuario").val() === "")
	{
		$("#form-modificar :input").prop("disabled", true);
		$("#form-modificar").get(0).reset();
		$("#buscar-usuario").prop("disabled", false);
	}
});

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);
	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/usuarios/modificar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "Nombre de usuario repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El nombre de usuario elegido está ocupado.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					$("#nombre-usuario").val("");
					$("#nombre-usuario").focus();
					$("#modificar").prop("disabled", false);
				}
				if (response.data === "Email de usuario repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El email de usuario elegido está ocupado.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					$("#email").val("");
					$("#email").focus();
					$("#modificar").prop("disabled", false);
				}
				if (response.data === "El usuario no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El usuario que quiere modificar ya no existe.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					actualizarUsuarios();
					$("#form-modificar :input").prop("disabled", true);
					$("#form-modificar").get(0).reset();
					$("#buscar-usuario").prop("disabled", false);
				}
				if (response.data === "El rol no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El rol que eligió ya no existe.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					actualizarRoles();	
					$("#modificar").prop("disabled", false);					
				}
			}
			else
			{
				var data1 = new FormData($("input[name^='subida']"));
                $.each($("input[name^='subida']")[0].files, function(index, item) {
                	data1.append(index, item);
                });

			    $.ajax({
			      	url: "subir_img.php",
			      	type: "POST",
			      	data: data1,
			      	enctype: "multipart/form-data",
			      	processData: false,
			      	contentType: false					    
			    });	

				$.bigBox({
					title : "Éxito",
					content : "El usuario se ha modificado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				actualizarUsuarios();
				actualizarRoles();
				$("#form-modificar :input").prop("disabled", true);
				$("#form-modificar").get(0).reset();
				$("#buscar-usuario").prop("disabled", false);
				$("#buscar-usuario").focus();
				$("#ShowImage").prop("src", "");
			}
		},
		error: function(error){
			$("#modificar").prop("disabled", false);
			if (error.status === 500)
			{
				$.bigBox({
					title : "Error",
					content : "Ha ocurrido un error crítico y su solicitud no pudo ser procesada.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{					
				//arreglo con todos los posibles campos con error
				arr = ["Id", "NombreUsuario", "Nombre", "Apellido", "Email", "FechaNacimiento", "RoleId", "CreadoPor"];
				//arreglo con los errores actuales
				var Errores = error.responseJSON.message.split(", ");
				//saco principio del mensaje de error asi obtengo solo el nombre del primer campo con error
				Errores[0] = Errores[0].substr(22);
				//saco final del mensaje de error asi obtengo solo el nombre del ultimo campo con error
				Errores[Errores.length-1] = Errores[Errores.length-1].substr(0, Errores[Errores.length-1].indexOf(" "));
				//contador de errores a 0
				var j = 0;
				//mensaje a mostrar vacío
				mensaje = "";
				$.each(Errores, function(index, itemErr)
				{
					if(j < 3)
					{
						$.each(arr, function(index, itemArr){
							if(itemErr === itemArr)
							{
								mensaje += itemArr+", ";
								j++;
							}
						});
					}
				});			
				mensaje = mensaje.replace("NombreUsuario", "Nombre de usuario");
				mensaje = mensaje.replace("FechaNacimiento", "Fecha de Nacimiento");
				mensaje = mensaje.replace("RoleId", "rol de usuario");					
				mensaje = "Campo(s) requerido(s) " + mensaje + " vacío(s) o nulo(s).";
				$.bigBox({
					title : "Error",
					content : "Asegúrese que completó todos los campos requeridos. <br>" + mensaje,
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
	e.preventDefault();
});

function FormToJSON(){
	var rutaimg = "";

	if ($("input[type=file]")[0].files[0] !== undefined)
	{
		rutaimg = $("input[type=file]")[0].files[0].name;
	}		
	
	return JSON.stringify({
		"Id": $("#usuarios [value='" + $("#buscar-usuario").val() + "']").data("value"),
		"NombreUsuario": $("#nombre-usuario").val(),
		"Nombre": $("#nombre").val(),
		"Apellido": $("#apellido").val(),
		"Email": $("#email").val(),
		"FechaNacimiento": $("#fecha-nac").val(),
		"RoleId": $("#rol").val(),
		"Imagen": rutaimg,
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false)
	{
		if (key.which === 9) 
		{
			$("#buscar-usuario").focus();
			key.preventDefault();
		}
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