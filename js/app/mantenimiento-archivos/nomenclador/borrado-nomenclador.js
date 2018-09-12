$(document).ready(function(){
	actualizarNomencladores();
	$("#buscar-nomenclador").focus();
});

function actualizarNomencladores(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladores",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos.")
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron nomencladores registrados.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#nomencladores_list").empty();
				$.each(response.data, function(index, item){
					$("#nomencladores_list").append("<option data-value=\""+item.Id+"\" value=\""+item.Codigo+" - Nombre: "+item.Nombre+"\"></option>");
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
					content : "No se pueden obtener los nomencladores.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar-nomenclador").on("input", function(){
	var val = this.value;
	if ($("#nomencladores_list option").filter(function(){
		return this.value === val;
	}).length)
	{
		if ($("#buscar-nomenclador").val() !== "")
		{
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/nomencladores/"+$("#nomencladores_list [value='" + $("#buscar-nomenclador").val() + "']").data("value"),
				dataType: "json",
				beforeSend: function(xhr){
					xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
				},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos.")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron datos.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
							actualizarNomencladores();
							$("#form-nomencladores").get(0).reset();
							$("#eliminar").prop("disabled", true);
							$("#buscar-nomenclador").prop("disabled", false);
						}
					}
					else
					{
						$("#eliminar").prop("disabled", false);						

						$("#codigo").val(response.data[0].Codigo);
						$("#nombre").val(response.data[0].Nombre);
						$("#inos").val(response.data[0].INOS);
						$("#_677").val(response.data[0]._677);
						$("#u-gastos").val(response.data[0].UGastos);
						$("#u-honorarios").val(response.data[0].UHonorarios);
						$("#area").val(response.data[0].Area);
						$("#complejidad").val(response.data[0].Complejidad);
						$("#inos-reducido").val(response.data[0].INOSReducido);
						$("#no-nomenclada").val(response.data[0].NoNomenclada);
						$("#tiempo-realizacion").val(response.data[0].TiempoRealizacion);
						$("#id-muestra").val(response.data[0].IdMuestra);
						$("#proceso").val(response.data[0].Proceso);
						$("#lista").val(response.data[0].Lista);
						$("#codigo-nomen-faba").val(response.data[0].CodigoFABA);
						$("#nivel").val(response.data[0].Nivel);
						$("#ria").val(response.data[0].RIA);
						$("#nbu-frecuencia").val(response.data[0].NBUFrecuencia);
						$("#nbu-codigo").val(response.data[0].NBUCodigo);
						$("#cantidad").val(response.data[0].Cantidad);	

						$.each(response.determinaciones, function(index, item){
							$("#det"+index).val(item.Codigo);
							$("#seccion"+index).val(item.Seccion);
							$("#orden"+index).val(item.Orden);
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
							content : "No se pudo obtener el nomenclador.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
		else
		{
			$("#form-nomencladores").get(0).reset();
			$("#eliminar").prop("disabled", true);			
			$("#buscar-nomenclador").focus();
		}
	}
	else
	{

	}		
});

$("#buscar-nomenclador").change(function(){
	if ($("#buscar-nomenclador").val() === "")
	{
		$("#form-nomencladores").get(0).reset();
		$("#eliminar").prop("disabled", true);
	}
});

$("#buscar-nomenclador").blur(function(){
	if ($("#buscar-nomenclador").val() === "")
	{
		$("#form-nomencladores").get(0).reset();
		$("#eliminar").prop("disabled", true);
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	$.ajax({
		type: "DELETE",
		contentType: "application/json",
		url: "api/nomencladores/eliminar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{					
				if (response.data === "No existe el nomenclador.")
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador que trata de eliminar ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					actualizarNomencladores();
					$("#form-nomencladores").get(0).reset();
					$("#eliminar").prop("disabled", true);						
					$("#buscar-nomenclador").focus();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El nomenclador se ha eliminado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				actualizarNomencladores();
				$("#form-nomencladores").get(0).reset();
				$("#eliminar").prop("disabled", true);					
				$("#buscar-nomenclador").focus();
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
					content : "No se pudo eliminar el nomenclador.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#nomencladores_list [value='" + $("#buscar-nomenclador").val() + "']").data("value"),			
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if (key.which === 9) 
	{
		if ($("#eliminar").prop("disabled") == false)
		{
			$("#buscar-nomenclador").focus();
		}
		key.preventDefault();
	}
});