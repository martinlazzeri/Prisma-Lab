$(document).ready(function(){
	actualizarTitulos();
	$("#buscar-titulos").focus();
});

function actualizarTitulos(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/titulos",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos")
				{
					$.bigBox({
						title : "Error",
						content : "No hay títulos registrados.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#titulos").empty();
				$.each(response.data, function(index, item){
					$("#titulos").append("<option data-value=\""+item.Id+"\" value=\""+item.Codigo+" - "+item.Descripcion+"\"></option>");
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
					content : "No se pueden obtener los títulos.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar-titulos").on("input", function(){
	var val = this.value;
	if ($("#titulos option").filter(function(){
		return this.value === val;
	}).length)
	{
		if ($("#buscar-titulos").val() !== "")
		{
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/titulos/"+$("#titulos [value='" + $("#buscar-titulos").val() + "']").data("value"),
				dataType: "json",
				beforeSend: function(xhr){
					xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
				},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No hay títulos registrados.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
					else
					{
						$("#form-titulo :input").prop("disabled", false);

						$("#codigo").val(response.data[0].Codigo);
						$("#descripcion").val(response.data[0].Descripcion);
						$("#tipo-titulo").val(response.data[0].Tipo);
						$("#unidades").val(response.data[0].Unidades);
						$("#rango").val(response.data[0].Rango);
						$("#linea1").val(response.data[0].LineaTexto1);
						$("#linea2").val(response.data[0].LineaTexto2);
						$("#linea3").val(response.data[0].LineaTexto3);
						$("#resultado").val(response.data[0].LineaTexto4);
						$("#valores-referencia").val(response.data[0].ValoresReferenciaAmpliados);
						$("#valor-minimo").val(response.data[0].ValorMinimo);
						$("#valor-maximo").val(response.data[0].ValorMaximo);		

						$("#modificar").prop("disabled", true);
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
							content : "No se puede obtener el título.",
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
			$("#form-titulo").get(0).reset();
			$("#form-titulo :input").prop("disabled", true);
			$("#buscar-titulos").prop("disabled", false);
		}
	}
	else
	{

	}				
});

$("#buscar-titulos").change(function(){
	if ($("#buscar-titulos").val() === "")
	{
		$("#form-titulo").get(0).reset();
		$("#form-titulo :input").prop("disabled", true);
		$("#buscar-titulos").prop("disabled", false);
	}
});

$("#buscar-titulos").blur(function(){
	if ($("#buscar-titulos").val() === "")
	{
		$("#form-titulo").get(0).reset();
		$("#form-titulo :input").prop("disabled", true);
		$("#buscar-titulos").prop("disabled", false);
	}
});

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);
	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/titulos/modificar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "El título no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El título que intenta modificar ya no existe.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					actualizarTitulos();
					$("#form-titulo").get(0).reset();
					$("#form-titulo :input").prop("disabled", true);
					$("#buscar-titulos").prop("disabled", false);
					$("#buscar-titulos").focus();
				}
				if (response.data === "Código del título repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El código de título ingresado está repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					$("#codigo").val("");
					$("#codigo").focus();
					$("#modificar").prop("disabled", false);
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El título se ha modificado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				actualizarTitulos();
				$("#form-titulo").get(0).reset();
				$("#form-titulo :input").prop("disabled", true);
				$("#buscar-titulos").prop("disabled", false);
				$("#buscar-titulos").focus();
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
				arr = ["Codigo", "CreadoPor"];
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
				Errores = Errores.replace("Codigo", "código de título");
				Errores = Errores.replace("CreadoPor", "usuario que lo creó");
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
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#titulos [value='" + $("#buscar-titulos").val() + "']").data("value"),
		"Codigo": $("#codigo").val(),
		"Descripcion": $("#descripcion").val(),
		"Tipo": $("#tipo-titulo").val(),
		"Unidades": $("#unidades").val(),
		"Rango": $("#rango").val(),
		"LineaTexto1": $("#linea1").val(),
		"LineaTexto2": $("#linea2").val(),
		"LineaTexto3": $("#linea3").val(),
		"LineaTexto4": $("#resultado").val(),
		"ValoresReferenciaAmpliados": $("#valores-referencia").val(),
		"ValorMinimo": $("#valor-minimo").val(),
		"ValorMaximo": $("#valor-maximo").val(),			
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar-titulos").focus();
			key.preventDefault();
		}
	}
});

$("#codigo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#descripcion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#unidades").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#rango").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea3").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#resultado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-minimo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-maximo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#buscar-titulos").on("input", function(){
	habilitarModificar();
});

$("#codigo").on("input", function(){
	habilitarModificar();
});

$("#descripcion").on("input", function(){
	habilitarModificar();
});

$("#tipo-titulo").on("input", function(){
	habilitarModificar();
});

$("#unidades").on("input", function(){
	habilitarModificar();
});

$("#rango").on("input", function(){
	habilitarModificar();
});

$("#linea1").on("input", function(){
	habilitarModificar();
});

$("#linea2").on("input", function(){
	habilitarModificar();
});

$("#linea3").on("input", function(){
	habilitarModificar();
});

$("#resultado").on("input", function(){
	habilitarModificar();
});

$("#valores-referencia").on("input", function(){
	habilitarModificar();
});

$("#valor-minimo").on("input", function(){
	habilitarModificar();
});

$("#valor-maximo").on("input", function(){
	habilitarModificar();
});

function habilitarModificar(){
	if ($("#codigo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#descripcion").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#tipo-titulo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#unidades").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#rango").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#linea1").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#linea2").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#linea3").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#resultado").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#valores-referencia").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#valor-minimo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#valor-maximo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}