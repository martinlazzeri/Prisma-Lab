$(document).ready(function(){
	actualizarMedicos();
	$("#buscar_medico").focus();
});

function resetForm(){
	$("#form-modificar").get(0).reset();
	$("#form-modificar :input").prop("disabled", true);
	$("#buscar_medico").prop("disabled", false);
}

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
		if ($("#buscar_medico").val() === "")
		{
			resetForm();
		}
		else
		{
			var medico = $("#buscar_medico").val();
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/medicos/"+$("#list_medicos [value='"+medico+"']").data("value"),
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
							resetForm();
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
						$("#form-modificar :input").prop("disabled", false);
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
		resetForm();
	}
});

$("#buscar_medico").blur(function(){
	if ($("#buscar_medico").val() === "")
	{			
		resetForm();
	}
});

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);
	if ($("#buscar_medico").val() !== "")
	{
		$.ajax({
			type : "PUT",
			contentType: "application/json",
			url: "api/medicos/modificar",
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
							content : "El médico que intenta modificar, ya no existe. Por favor seleccione otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						resetForm();
						actualizarMedicos();
					}	
					if (response.data === "Matrícula repetida")
					{
						$.bigBox({
							title : "Error",
							content : "La matrícula ingresada está repetida. <br>Por favor ingrese otra.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#matricula").val("");
						$("#matricula").focus();
						$("#modificar").prop("disabled", false);
					}						
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "El médico se ha modificado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});
					resetForm();
					actualizarMedicos();
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
					arr = ["Matricula", "TipoMatricula", "AbonoDomicilio", "Nombre", "Apellido", "Domicilio1", "Telefono1"];
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
					Errores = Errores.replace("Matricula", "Matrícula");
					Errores = Errores.replace("TipoMatricula", "Tipo de Matrícula");
					Errores = Errores.replace("Domicilio1", "Domicilio N° 1");
					Errores = Errores.replace("Telefono1", "Teléfono N° 1");
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
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#list_medicos [value='" + $("#buscar_medico").val() + "']").data("value"),
		"Matricula": $("#matricula").val(),
		"TipoMatricula": $("#tipo-matricula").val(),
		"Nombre": $("#nombre").val(),
		"Apellido": $("#apellido").val(),
		"Domicilio1": $("#domicilio1").val(),
		"Telefono1": $("#telefono1").val(),
		"Domicilio2": $("#domicilio2").val(),
		"Telefono2": $("#telefono2").val(),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar_medico").focus();
			key.preventDefault();
		}
	}
});

$("#matricula").keypress(function(key){
	if (key.which === 13)
	{
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

$("#domicilio1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#telefono1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#domicilio2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#telefono2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

$("#apellido").on("input", function(){
	habilitarModificar();
});

$("#matricula").on("input", function(){
	habilitarModificar();
});

$("#tipo-matricula").on("input", function(){
	habilitarModificar();
});

$("#domicilio1").on("input", function(){
	habilitarModificar();
});

$("#telefono1").on("input", function(){
	habilitarModificar();
});

function habilitarModificar(){
	if ($("#nombre").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if($("#apellido").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	};
	if ($("#matricula").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#matricula").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#tipo-matricula").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#domicilio1").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#telefono1").val() === "") 
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}