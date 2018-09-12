$(document).ready(function(){
	actualizarUsuarios();
	actualizarRoles();
	$("#buscar-usuario").focus();
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
							$("#form-borrado :input").prop("disabled", true);
							$("#form-borrado").get(0).reset();
							$("#buscar-usuario").prop("disabled", false);
							$("#buscar-usuario").focus();
							$("#ShowImage").prop("src", "");
						}
					}
					else
					{
						$("#eliminar").prop("disabled", false);						

						$("#nombre").val(response.data[0].Nombre);
						$("#apellido").val(response.data[0].Apellido);
						$("#nombre-usuario").val(response.data[0].NombreUsuario);						
						$("#email").val(response.data[0].Email);
						$("#fecha-nac").val(response.data[0].FechaNacimiento);
						$("#rol").val(response.data[0].RoleId);				
						$("#ShowImage").prop("src", response.data[0].Imagen);
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
			$("#form-borrado :input").prop("disabled", true);
			$("#form-borrado").get(0).reset();
			$("#buscar-usuario").prop("disabled", false);
			$("#ShowImage").prop("src", "");
		}
	}
	else
	{

	}		
});

$("#buscar-usuario").change(function(){
	if($("#buscar-usuario").val() === "")
	{
		$("#form-borrado :input").prop("disabled", true);
		$("#form-borrado").get(0).reset();
		$("#buscar-usuario").prop("disabled", false);
		$("#ShowImage").prop("src", "");
	}
});

$("#buscar-usuario").blur(function(){
	if($("#buscar-usuario").val() === "")
	{
		$("#form-borrado :input").prop("disabled", true);
		$("#form-borrado").get(0).reset();
		$("#buscar-usuario").prop("disabled", false);
		$("#ShowImage").prop("src", "");
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	$.ajax({
		type: "DELETE",
		contentType: "application/json",
		url: "api/usuarios/eliminar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
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
					$("#form-borrado :input").prop("disabled", true);
					$("#form-borrado").get(0).reset();
					$("#buscar-usuario").prop("disabled", false);
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El usuario se ha eliminado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				actualizarUsuarios();
				actualizarRoles();
				$("#form-borrado :input").prop("disabled", true);
				$("#form-borrado").get(0).reset();
				$("#buscar-usuario").prop("disabled", false);
				$("#buscar-usuario").focus();
				$("#ShowImage").prop("src", "");
			}
		},
		error: function(error){
			$("#eliminar").prop("disabled", false);
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
				arr = ["Id", "Nombre", "Apellido", "FechaNacimiento", "RoleId", "CreadoPor"];		
				Errores = "";
				j = 0;
				for (var i = 0; i < arr.length; i++) {
					if(j < 3){
						if (error.data.indexOf(arr[i]) > 0) 
						{
							Errores += arr[i].toString()+", ";
							j++;
						}
					}										
				};			
				Errores = Errores.replace("FechaNacimiento", "Fecha de Nacimiento");
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
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#usuarios [value='" + $("#buscar-usuario").val() + "']").data("value"),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false)
	{
		if (key.which === 9) 
		{
			$("#buscar-usuario").focus();
			key.preventDefault();
		}
	}
});