$(document).ready(function(){
	$("#buscar-paciente").focus();
});

$("#body-ingresos").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	seleccionarIngreso(fila.id);
	$("#modal-ingresos").modal("hide");
});

$("#buscar-paciente").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#buscar-paciente").val() !== "")
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
									content : "No se han encontrado ingresos que coincidan con los datos ingresados.",
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
								seleccionarIngreso(response.data[0].IngresoId);
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									item.NumDocumento == null ? dni = "No especifica" : dni = item.NumDocumento;
									item.MedicoId == null ? medico = "No especifica" : medico = item.ApellidoMed+" "+item.NombreMed;
									$("#body-ingresos").append("<tr id="+item.IngresoId+">"+
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
								content : "No se pudo obtener el ingreso.",
								color : "#C46A69",
								timeout: 5000,
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
									content : "No se encontraron ingresos que coincidan con los datos.",
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
								seleccionarIngreso(response.data[0].IngresoId);
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									item.NumDocumento == null ? dni = "No especifica" : dni = item.NumDocumento;
									item.MedicoId == null ? medico = "No especifica" : medico = item.ApellidoMed+" "+item.NombreMed;
									$("#body-ingresos").append("<tr id="+item.IngresoId+">"+
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
								content : "No se pueden obtener los ingresos.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}
		}
		else
		{
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/resultados/",
				dataType: "json",
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true)
					{
						$.bigBox({
							title : "Error",
							content : "No se encontraron resultados ingresados.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
					}
					else
					{
						$("#body-ingresos").empty();
						$.each(response.data, function(index, item){
							item.NumDocumento == null ? dni = "No especifica" : dni = item.NumDocumento;
							item.MedicoId == null ? medico = "No especifica" : medico = item.ApellidoMed+" "+item.NombreMed;
							$("#body-ingresos").append("<tr id="+item.IngresoId+">"+
															"<td>"+item.NumPaciente+"</td>"+
															"<td>"+item.ApellidoNombre+"</td>"+
															"<td>"+dni+"</td>"+
															"<td>"+medico+"</td>"+
													   "</tr>");
						});
						$("#modal-ingresos").modal("show");
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
							content : "No se pudo obtener el paciente.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			})
		}
		key.preventDefault();
	}
});

function seleccionarIngreso(id){
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
			}
			else
			{
				$("#buscar-paciente").val("");
				$("#protocolo").text(response.data[0].NumPaciente);
				$("#apellido-nombre").text(response.data[0].ApellidoNombre);
				if (response.data[0].ApellidoMed !== null) 
				{
					$("#medico").text(response.data[0].ApellidoMed+" "+response.data[0].NombreMed);
				}
				else
				{
					$("#medico").text("No especifica");
				}
				calcularEdad(response.data[0].FechaNacimiento);
				response.data[0].Sexo == 0 ? $("#sexo").text("Masculino") : $("#sexo").text("Femenino");
				response.data[0].Sexo == null ? $("#sexo").text("No especifica") : "";
				response.data[0].Origen == null ? $("#origen").text("No especifica") : $("#origen").text(response.data[0].Origen);

				$("#practicas").empty();
				$.each(response.data, function(index, item){
					$("#practicas").append("<div class=\"form-group\">"+
												"<label class=\"col-md-2 control-label\">Práctica</label>"+
												"<div class=\"col-md-1\">"+
													"<label class=\"control-label\">"+item.Codigo+"</label>"+
												"</div>"+
												"<div class=\"col-md-2\">"+
													"<label class=\"control-label\">"+item.Resultado+" "+item.Unidades+"</label>"+
												"</div>"+
												"<div class=\"col-md-3\">"+
													"<label class=\"control-label\">Rango: "+item.Rango+"</label>"+
												"</div>"+
											"</div>");
				});
				$("#div-campos").show();
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