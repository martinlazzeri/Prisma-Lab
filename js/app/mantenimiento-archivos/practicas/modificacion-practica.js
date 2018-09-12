$(document).ready(function(){
	actualizarPracticas();
	actualizarMutuales();
	$("#buscar_practica").focus();
});

function actualizarPracticas(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladoresespeciales/",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos de prácticas") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron nomencladores especiales registradoss.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#list_practicas").empty();
				$.each(response.data, function(index, item){
					$("#list_practicas").append("<option data-value=\""+item.Id+"\" value=\""+item.Nombre+" - "+item.NombreMutual+"\"></option>");
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
					content : "No se pudieron obtener los nomencladores especiales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

function actualizarMutuales(){		
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/mutuales/",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se han encontrado datos") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron obras sociales.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#list_mutuales").empty();
				$.each(response.data, function(index, item){
					$("#list_mutuales").append("<option data-value=\""+item.Id+"\" value=\""+item.Codigo+" - "+item.Nombre+"\"></option>");
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
					content : "No se pudieron obtener las obras sociales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar_practica").on("input", function(){
	var val = this.value;
	if ($("#list_practicas option").filter(function(){
		return this.value === val;
	}).length)
	{
		$.ajax({
			type: "GET",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/"+$("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value"),
			dataType: "json",
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "No se han encontrado datos")
					{
						$.bigBox({
							title : "Error",
							content : "No se encontraron datos del nomenclador especial elegido.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_practica").val("");
						actualizarPracticas();
					}
				}
				else
				{											
					$("#form-practicas :input").prop("disabled", false);
					$("#modificar").prop("disabled", true);
					$("#buscar_mutual").val(response.data[0].CodMutual+" - "+response.data[0].NombreMutual);
					$("#nombre").val(response.data[0].Nombre);
					$("#a").val(response.data[0].A);
					$("#codigo").val(response.data[0].Codigo);
					$("#unidad-gasto").val(response.data[0].UnidadGasto);
					$("#unidad-honorario").val(response.data[0].UnidadHonorario);
					$("#nivel").val(response.data[0].Nivel);

					habilitarModificar();
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
						content : "No se pudo obtener el nomenclador especial.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
});

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);
	if ($("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value") !== undefined && $("#buscar_practica").val() !== "") 
	{
		$.ajax({
			type: "PUT",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/modificar",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "La práctica no existe")
					{
						$.bigBox({
							title : "Error",
							content : "El nomenclador especial elegido ya no existe.<br>Por favor, seleccione otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_practica").val("");
						$("#buscar_practica").focus();
						actualizarPracticas();
					}
					if (response.data === "La mutual no existe")
					{
						$.bigBox({
							title : "Error",
							content : "La mutual elegida ya no existe.<br>Por favor, seleccione otra.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_mutual").val("");
						$("#buscar_mutual").focus();
						actualizarMutuales();
						$("#modificar").prop("disabled", false);
					}
					if (response.data === "El nombre de práctica está repetido")
					{
						$.bigBox({
							title : "Error",
							content : "El nombre ingresado ya existe.<br>Pro favor, ingrese otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#nombre").val("");
						$("#nombre").focus();
						$("#modificar").prop("disabled", false);
					}
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "El nomenclador especial se ha modificado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});	
					$("#form-practicas :input").prop("disabled", true);
					$("#buscar_practica").prop("disabled", false);
					$("#form-practicas").get(0).reset();
					actualizarPracticas();
					actualizarMutuales();
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
					arr = ["Id", "MutualId", "Nombre", "A", "Codigo", "UnidadGasto", "UnidadHonorario", "Nivel"];
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
					Errores = Errores.replace("MutualId", "id de mutual");
					Errores = Errores.replace("UnidadGasto", "unidad de gasto");
					Errores = Errores.replace("UnidadHonorario", "unidad de honorario");
					Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
					$.bigBox({
						title : "Error",
						content : "Asegúrese que completó todos los campo requeridos. <br>"+Errores+"<br><br>",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value"),
		"MutualId": $("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value"),
		"Nombre": $("#nombre").val(),
		"A": $("#a").val(),
		"Codigo": $("#codigo").val(),
		"UnidadGasto": $("#unidad-gasto").val(),
		"UnidadHonorario": $("#unidad-honorario").val(),
		"Nivel": $("#nivel").val(),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar_practica").focus();
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

$("#a").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#codigo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#unidad-gasto").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#unidad-honorario").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nivel").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#buscar_practica").on("input", function(){
	habilitarModificar();
});

$("#buscar_mutual").on("input", function(){
	habilitarModificar();
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

$("#a").on("input", function(){
	habilitarModificar();
});

$("#codigo").on("input", function(){
	habilitarModificar();
});

$("#unidad-gasto").on("input", function(){
	habilitarModificar();
});

$("#unidad-honorario").on("input", function(){
	habilitarModificar();
});

$("#nivel").on("input", function(){
	habilitarModificar();
});

function habilitarModificar(){
	if ($("#buscar_practica").val())
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#buscar_mutual").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#a").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#codigo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#unidad-gasto").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#unidad-honorario").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nivel").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}