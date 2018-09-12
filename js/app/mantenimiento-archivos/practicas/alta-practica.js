$(document).ready(function(){
	actualizarMutuales();
	$("#buscar_mutual").focus();
});

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

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	if ($("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value") !== undefined && $("#buscar_mutual").val() !== "") 
	{
		$.ajax({
			type: "POST",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/crear",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "El nombre está repetido")
					{
						$.bigBox({
							title : "Error",
							content : "El nombre ingresado ya existe.<br>Por favor, ingrese otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#nombre").val("");
						$("#nombre").focus();
					}
					if (response.data === "La mutual no existe")
					{
						$.bigBox({
							title : "Error",
							content : "La mutual elegida, ya no existe.<br>Pro favor, seleccione otra mutual.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_mutual").val("");
						$("#buscar_mutual").focus();
						actualizarMutuales();
					}						
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "El nomenclador especial se ha creado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});
					$("#form-practicas").get(0).reset();
					actualizarMutuales();
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
					arr = ["MutualId", "A", "Nombre", "Codigo", "UnidadGasto", "UnidadHonorario", "Nivel"];
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
					Errores = Errores.replace("MutualId", "Id de mutual");
					Errores = Errores.replace("UnidadGasto", "unidad de gasto");
					Errores = Errores.replace("UnidadHonorario", "unidad de honorario");						
					Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
					$.bigBox({
						title : "Error",
						content : "Asegúrese que completó todos los campo requeridos. <br>"+Errores+"<br><br>",
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
		$.bigBox({
			title : "Error",
			content : "Asegúrese que el campo de mutual no está vacío y que tiene datos reales.",
			color : "#C46A69",
			timeout : 8000,
			icon : "fa fa-warning shake animated"
		});
	}
	$("#ingresar").prop("disabled", false);
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"MutualId": $("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value"),
		"A": $("#a").val(),
		"Nombre": $("#nombre").val(),
		"Codigo": $("#codigo").val(),
		"UnidadGasto": $("#unidad-gasto").val(),
		"UnidadHonorario": $("#unidad-honorario").val(),
		"Nivel": $("#nivel").val(),
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#buscar_mutual").focus();
		key.preventDefault();
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

$("#buscar_mutual").on("input", function(){
	habilitarIngresar();
});

$("#nombre").on("input", function(){
	habilitarIngresar();
});

$("#a").on("input", function(){
	habilitarIngresar();
});

$("#codigo").on("input", function(){
	habilitarIngresar();
});

$("#unidad-gasto").on("input", function(){
	habilitarIngresar();
});

$("#unidad-honorario").on("input", function(){
	habilitarIngresar();
});

$("#nivel").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#buscar_mutual").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#a").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#codigo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#unidad-gasto").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#unidad-honorario").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nivel").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}