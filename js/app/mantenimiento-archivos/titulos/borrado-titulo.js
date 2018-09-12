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
							actualizarTitulos();
							$("#form-titulo").get(0).reset();
							$("#form-titulo :input").prop("disabled", true);
							$("#buscar-titulos").prop("disabled", false);
						}
					}
					else
					{
						$("#eliminar").prop("disabled", false);

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
		$("#eliminar").prop("disabled", true);
	}
});

$("#buscar-titulos").blur(function(){
	if ($("#buscar-titulos").val() === "")
	{
		$("#form-titulo").get(0).reset();
		$("#eliminar").prop("disabled", true);
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	$.ajax({
		type: "DELETE",
		contentType: "application/json",
		url: "api/titulos/eliminar",
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
						content : "El título que intenta eliminar ya no existe.<br> Por favor, seleccione otro.",
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
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El título se ha eliminado correctamente.",
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
				$.bigBox({
					title : "Error",
					content : "No se pudo eliminar el título.",
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
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar-titulos").focus();
			key.preventDefault();
		}
	}
});