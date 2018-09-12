$(document).ready(function(){
	$("#buscar-paciente").focus();
});

$("#resultado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#buscar-paciente").keypress(function(key){
	if ($("#buscar-paciente").val() !== "")
	{
		if (key.which === 13)
		{
			if (isNaN($("#buscar-paciente").val()))
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/resultados/porapellidonombre",
					dataType: "json",
					data: JSON.stringify({"ApellidoNombre": $("#buscar-paciente").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "no se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No existen ingresos coincidentes con los datos ingresados.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
						}
						else
						{
							if (response.cantidad === 1)
							{
								seleccionarResultado(response.data[0].IngresoId);
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									item.NumDocumento !== null ? dni = item.NumDocumento : dni = "No especifica";
									item.Matricula !== null ? medico = item.ApellidoMed+" "+item.NombreMed : medico = "No posee";
									$("#body-ingresos").append("<tr id=\""+item.IngresoId+"\">"+
																	"<td>"+item.NumPaciente+"</td>"+
																	"<td>"+item.ApellidoNombre+"</td>"+
																	"<td>"+dni+"</td>"+
																	"<td>"+medico+"</td>"+
																"</tr>");
								});
								$("#modal-ingresos").modal("show");
							}
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
								content : "No se puede obtener el ingreso.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}
			if (!isNaN($("#buscar-paciente").val()))
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/resultados/pornumpaciente",
					dataType: "json",
					data: JSON.stringify({"NumPaciente": $("#buscar-paciente").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "no se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No existen ingresos coincidentes con los datos ingresados.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
						}
						else
						{
							if (response.cantidad === 1)
							{
								seleccionarResultado(response.data[0].IngresoId);
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									item.NumDocumento !== null ? dni = item.NumDocumento : dni = "No especifica";
									item.Matricula !== null ? medico = item.ApellidoMed+" "+item.NombreMed : medico = "No posee";
									$("#body-ingresos").append("<tr id=\""+item.IngresoId+"\">"+
																	"<td>"+item.NumPaciente+"</td>"+
																	"<td>"+item.ApellidoNombre+"</td>"+
																	"<td>"+dni+"</td>"+
																	"<td>"+medico+"</td>"+
																"</tr>");
								});
								$("#modal-ingresos").modal("show");
							}
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
								content : "No se puede obtener el ingreso.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}			
			key.preventDefault();
		}
	}
	else
	{
		if (key.which === 13)
		{
			key.preventDefault();
		}
	}
});

$("#body-ingresos").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	seleccionarResultado(fila.id);
	$("#modal-ingresos").modal("hide");
});

function seleccionarResultado(id){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/resultados/idingreso",
		dataType: "json",
		data: JSON.stringify({"IngresoId": id}),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true) 
			{
				if (response.data === "no se encontraron datos")
				{
					$.bigBox({
						title : "Error",
						content : "El ingreso seleccionado ya no existe.<br> Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
				$("#div-campos").hide();
				$("#practicas").empty();
				$("#form-resultados").get(0).reset();
				$("#protocolo").attr("data-id", "");
			}
			else
			{
				$("#div-campos").show();
				$("#protocolo").attr("data-id", response.data[0].IngresoId);
				$("#protocolo").text(response.data[0].NumPaciente);
				$("#apellido-nombre").text(response.data[0].ApellidoNombre);
				response.data[0].Matricula !== null ? $("#medico").text(response.data[0].ApellidoMed+" "+response.data[0].NombreMed) : $("#medico").text("No especifica");
				$("#edad").text(calcularEdad(response.data[0].FechaNacimiento));
				response.data[0].Sexo == 0 ? $("#sexo").text("Masculino") : $("#sexo").text("Femenino");
				response.data[0].Sexo == null ? $("#sexo").text("No especifica") : "";
				response.data[0].Origen == null ? $("#origen").text("No especifica") : $("#origen").text(response.data[0].Origen);

				$("#practicas").empty();
				$.each(response.data, function(index, item){
					$("#practicas").append("<div class=\"form-group\">"+
												"<label class=\"col-md-2 control-label\">Práctica</label>"+
												"<div class=\"col-md-1\">"+
													"<label id=\"practica\" data-id=\""+item.NomencladorId+"\" class=\"control-label\">"+item.Codigo+"</label>"+
												"</div>"+
												"<div class=\"col-md-2\">"+
													"<label class=\"input\">"+
														"<div class=\"input-group\">"+
															"<input type=\"text\" class=\"form-control\" id=\"resultado\" value=\""+item.Resultado+"\" oninput=\"habilitarModificar();\">"+
															"<span id=\"span-unidades\" class=\"input-group-addon\">"+item.Unidades+"</span>"+
														"</div>"+
													"</label>"+
												"</div>"+
												"<div class=\"col-md-3\">"+
													"<label class=\"control-label\">Rango: "+item.Rango+"</label>"+
												"</div>"+
											"</div>");
				});
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
					content : "No se pudo obtener el ingreso.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	})
}

function calcularEdad(edad){
	if (edad !== null && edad !== undefined && edad !== "") 
	{
		var date_end = new Date();
	    var date_start = new Date(edad);
		var total_años = Math.floor((date_end - date_start) / (1000 * 60 * 60 * 24 * 365));			
		$("#edad").text(total_años);
	}
	else
	{	
		$("#edad").text("");
	}	
}

$("#modificar").click(function(e){
	var practicas = $("#practicas #practica");
	var result = $("#practicas #resultado");	

	for (var i = 0; i < practicas.length; i++) 
	{
		if (practicas[i].attributes[1].value == "" || result[i].value == "")
		{
			$.bigBox({
				title : "Error",
				content : "Uno o mas resultados se encuentran vacíos. Por favor, ingrese todos los resultados para continuar.",
				color : "#C46A69",
				timeout: 8000,
				icon : "fa fa-warning shake animated"
			});
			return;
		}
	}

	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/resultados/modificar",
		dataType: "json",
		data: FormToJSON(),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true)
			{
				$.bigBox({
					title : "Error",
					content : "No se pudieron modificar los resultados.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El resultado se ha modificó correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"
				});
				$("#div-campos").hide();
				$("#practicas").empty();
				$("#form-resultados").get(0).reset();
				$("#protocolo").attr("data-id", "");
				$("#modificar").prop("disabled", true);
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
					content : "No se pudieron modificar los resultados.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	})
	e.preventDefault();
});

function FormToJSON(){
	var array_practicas = [];
	var practicas = $("#practicas #practica");
	var result = $("#practicas #resultado");	

	for (var i = 0; i < practicas.length; i++) 
	{
		var prac = []
		
		prac.push(practicas[i].attributes[1].value);
		prac.push(result[i].value);
		array_practicas.push(prac);
	}

	return JSON.stringify({
		"IngresoId": $("#protocolo").data("id"),
		"Practicas": array_practicas,
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

function habilitarModificar(){
	var resultados = $("#practicas #resultado");
	
	for (var i = 0; i < resultados.length; i++) {
		if (resultados[i].value === "")
		{
			$("#modificar").prop("disabled", true);
			return;
		}
	};

	$("#modificar").prop("disabled", false);
}