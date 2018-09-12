$(document).ready(function(){
	actualizarMedicos();
	$("#buscar_medico").focus();
});

function actualizarMedicos(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/medicos/",
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
						content : "No se encontraron médicos.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#list_medicos").empty();
				$.each(response.data, function(index, item){
					$("#list_medicos").append("<option data-value=\""+item.Id+"\" value=\""+item.Matricula+" - "+item.Nombre+" "+item.Apellido+"\"></option>");
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
					content : "No se pudo obtener los médicos.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar_medico").on("input", function(){
	var val = this.value;
	if ($("#list_medicos option").filter(function(){
		return this.value === val;
	}).length)
	{
		if ($("#buscar_medico").val === "")
		{
			$("#form-borrado").get(0).reset();
		}
		else
		{
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/medicos/"+$("#list_medicos [value='"+$("#buscar_medico").val()+"']").data("value"),
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
								content : "No se encontraron datos para el médico elegido.",
								color : "#C46A69",
								timeout : 8000,
								icon : "fa fa-warning shake animated"
							});
							$("#buscar_medico").val("");
							actualizarMedicos();
						}
					}
					else
					{
						$("#matricula").val(response.data[0].Matricula);
						$("#tipo-matricula").val(response.data[0].TipoMatricula);
						$("#nombre").val(response.data[0].Nombre);
						$("#apellido").val(response.data[0].Apellido);
						$("#domicilio1").val(response.data[0].Domicilio1);
						$("#telefono1").val(response.data[0].Telefono1);
						$("#domicilio2").val(response.data[0].Domicilio2);
						$("#telefono2").val(response.data[0].Telefono2);

						$("#eliminar").prop("disabled", false);
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
							content : "No se pudo obtener el médico.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
	}	
});

$("#buscar_medico").change(function(){
	if ($("#buscar_medico").val() === "")
	{
		$("#form-borrado").get(0).reset();
		$("#eliminar").prop("disabled", true);
	}
});

$("#buscar_medico").blur(function(){
	if ($("#buscar_medico").val() === "")
	{
		$("#form-borrado").get(0).reset();
		$("#eliminar").prop("disabled", true);
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	if ($("#medicos").val() !== "")
	{
		$.ajax({
			type: "DELETE",
			contentType: "application/json",
			url: "api/medicos/eliminar",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if(response.error === true)
				{
					if (response.data === "El médico no existe")
					{
						$.bigBox({
							title : "Error",
							content : "El médico que intenta eliminar, ya no existe. Por favor seleccione otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_medico").val("");
						actualizarMedicos();
					}
					if (response.data === "El médico no se puede eliminar porque tiene pacientes asociados.")
					{
						$.bigBox({
							title : "Error",
							content : "No se pudo eliminar el médico.<br> Existen pacientes asociados al médico "+ 
										"que se quiere eliminar, y mientras existan no lo podrá eliminar.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#eliminar").prop("disabled", false);
					}
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "El médico se ha eliminado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});
					$("#form-borrado").get(0).reset();
					actualizarMedicos();
					$("#eliminar").prop("disabled", true);
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
						content : "No se pudo eliminar el médico.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}		
});

function FormToJSON(){
	var medico = $("#buscar_medico").val();
	return JSON.stringify({
		"Id": $("#list_medicos [value='"+ medico +"']").data("value"),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar_medico").focus();
			key.preventDefault();
		}
	}
});