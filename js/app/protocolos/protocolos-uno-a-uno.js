$(document).ready(function(){
	$("#buscar-paciente").focus();
});

$("#form-protocolos").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

// Inicio Búsqueda de pacientes por diferentes criterios

$("#buscar-paciente").keypress(function(key){
	if ($("#buscar-paciente").val() !== "")
	{
		if (key.which === 13)
		{
			var radios = $("input[name='radio-inline']");
			
			if ($("#por-apellido-nombre").is(":checked"))
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/protocolos/PorApellidoNombre",
					dataType: "json",
					data: JSON.stringify({"ApellidoNombre": $("#buscar-paciente").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "No se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No se han encontrado ingresos coincidentes.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
							if (response.data === "El ingreso ya tiene resultados")
							{
								$.bigBox({
									title : "Error",
									content : "El ingreso seleccionado ya tiene resultados ingresados.",
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
								MostrarDatos(response);
							}
							else
							{
								$("#body-ingresos").empty();

								$.each(response.data, function(index, item){
									if (item.IngresosPractica !== null)
									{
										$("#body-ingresos").append("<tr id=\""+item.IngresoId+"\">"+
																		"<td>"+item.NumPaciente+"</td>"+
																		"<td>"+item.ApellidoNombre+"</td>"+
																	"</tr>");
									}
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
								content : "No se puede obtener el ingreso de paciente especificado.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}

			if ($("#por-num-paciente").is(":checked"))
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/resultados/ingresos/pornumpaciente",
					dataType: "json",
					data: JSON.stringify({"NumPaciente": $("#buscar-paciente").val(), "DesdeProtocolo": 1}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "No se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No se han encontrado ingresos coincidentes.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
							if (response.data === "El ingreso ya tiene resultados")
							{
								$.bigBox({
									title : "Error",
									content : "El ingreso seleccionado ya tiene resultados ingresados.",
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
								$("#form-campos").show();
								$("#protocolo").attr("data-id", response.data[0].IngresoId);
								$("#apellido-nombre").text(response.data[0].ApellidoNombre);
								$("#numero-doc").text(response.data[0].NumDocumento);
								$("#protocolo").text(response.data[0].NumPaciente);
								
								var fecha_nac = new Date(response.data[0].FechaNacimiento);							

								var hoy = new Date();													
								
								var total = Math.floor((hoy - fecha_nac) / (1000 * 60 * 60 * 24 * 365));

								!isNaN(total) !== false ? $("#edad").val(total) : null;

								switch (response.data[0].Sexo)
								{
									case 0: sexo = "M";
										break;
									case 1: sexo = "F";
										break;
									default: sexo = "NE";
										break;
								}
								$("#sexo").val(sexo);
								$("#origen").val(response.data[0].Origen);
								if (response.data[0].MedicoId !== null)
								{
									$("#doctor").val(response.data[0].ApellidoMed+" "+response.data[0].NombreMed);
								}

								j = 1;
								var practica = "";
								
								$("#resultados").empty();
								$.each(response.data[0]["IngresosPractica"], function(index, item){		
									item.ValoresReferenciaAmpliados == null ? valoresReferencia = "" : valoresReferencia = item.ValoresReferenciaAmpliados;								
									practica += "<div class=\"row\">"+
													"<div class=\"row\">"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Determinación "+j+"</label>"+
															"<label class=\"input\">"+
																"<input type=\"text\" data-value=\""+item.NomencladorId+"\" id=\"determinacion"+j+"\" value=\""+item.PracticaCodigo+"\" disabled>"+																		
															"</label>"+
														"</section>"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Descripción</label>"+
															"<label class=\"input\">"+
																"<input id=\"descripcion"+j+"\" type=\"text\" value=\""+item.TitDescrip+"\" disabled>"+
															"</label>"+
														"</section>"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\" id=\"unidades\">Unidades</label>"+
															"<label class=\"input\">"+
																"<div class=\"input-group\">"+
																	"<input type=\"text\" id=\"unidades"+j+"\" oninput=\"habilitarIngresar();\">"+
																	"<span id=\"span-unidades"+j+"\" class=\"input-group-addon\">"+item.TitUnidades+"</span>"+
																"</div>"+
															"</label>"+
														"</section>"+
													"</div>"+
													"<div class=\"row\">"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Valores de Referencia</label>"+
															"<label class=\"label\" id=\"valores-referencia"+j+"\">"+valoresReferencia+"</label>"+
														"</section>"+
													"</div>"+
												"</div>";
									j += 1;
								});
								$("#resultados").append(practica);

								habilitarIngresar();
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									if (item.IngresosPractica !== null)
									{
										$("#body-ingresos").append("<tr id=\""+item.IngresoId+"\">"+
																		"<td>"+item.NumPaciente+"</td>"+
																		"<td>"+item.ApellidoNombre+"</td>"+
																	"</tr>");
									}
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
								content : "No se puede obtener el ingreso de paciente especificado.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}
			if ($("#por-dni").is(":checked"))
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/resultados/ingresos/pordni",
					dataType: "json",
					data: JSON.stringify({"DNI": $("#buscar-paciente").val(), "DesdeProtocolo": 1}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "No se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No se han encontrado ingresos coincidentes.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
							if (response.data === "El ingreso ya tiene resultados")
							{
								$.bigBox({
									title : "Error",
									content : "El ingreso seleccionado ya tiene resultados ingresados.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
						}
						else
						{
							// Cuando se ingresa un criterio y es único
							if (response.cantidad === 1)
							{
								$("#form-campos").show();
								$("#protocolo").attr("data-id", response.data[0].IngresoId);
								$("#apellido-nombre").text(response.data[0].ApellidoNombre);
								$("#numero-doc").text(response.data[0].NumDocumento);
								$("#protocolo").text(response.data[0].NumPaciente);
								
								var fecha_nac = new Date(response.data[0].FechaNacimiento);							

								var hoy = new Date();													
								
								var total = Math.floor((hoy - fecha_nac) / (1000 * 60 * 60 * 24 * 365));

								!isNaN(total) !== false ? $("#edad").val(total) : null;

								switch (response.data[0].Sexo)
								{
									case 0: sexo = "M";
										break;
									case 1: sexo = "F";
										break;
									default: sexo = "NE";
										break;
								}

								$("#sexo").val(sexo);
								$("#origen").val(response.data[0].Origen);

								if (response.data[0].MedicoId !== null)
								{
									$("#doctor").val(response.data[0].ApellidoMed+" "+response.data[0].NombreMed);
								}

								j = 1;
								var practica = "";
								
								$("#resultados").empty();
								$.each(response.data[0]["IngresosPractica"], function(index, item){		
									item.ValoresReferenciaAmpliados == null ? valoresReferencia = "" : valoresReferencia = item.ValoresReferenciaAmpliados;								
									practica += "<div class=\"row\">"+
													"<div class=\"row\">"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Determinación "+j+"</label>"+
															"<label class=\"input\">"+
																"<input type=\"text\" data-value=\""+item.NomencladorId+"\" id=\"determinacion"+j+"\" value=\""+item.PracticaCodigo+"\" disabled>"+																		
															"</label>"+
														"</section>"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Descripción</label>"+
															"<label class=\"input\">"+
																"<input id=\"descripcion"+j+"\" type=\"text\" value=\""+item.TitDescrip+"\" disabled>"+
															"</label>"+
														"</section>"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\" id=\"unidades\">Unidades</label>"+
															"<label class=\"input\">"+
																"<div class=\"input-group\">"+
																	"<input type=\"text\" id=\"unidades"+j+"\" oninput=\"habilitarIngresar();\">"+
																	"<span id=\"span-unidades"+j+"\" class=\"input-group-addon\">"+item.TitUnidades+"</span>"+
																"</div>"+
															"</label>"+
														"</section>"+
													"</div>"+
													"<div class=\"row\">"+
														"<section class=\"col col-4\">"+
															"<label class=\"label\">Valores de Referencia</label>"+
															"<label class=\"label\" id=\"valores-referencia"+j+"\">"+valoresReferencia+"</label>"+
														"</section>"+
													"</div>"+
												"</div>";
									j += 1;
								});
								$("#resultados").append(practica);

								habilitarIngresar();
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									if (item.IngresosPractica !== null)
									{
										$("#body-ingresos").append("<tr id=\""+item.IngresoId+"\">"+
																		"<td>"+item.NumPaciente+"</td>"+
																		"<td>"+item.ApellidoNombre+"</td>"+
																	"</tr>");
									}
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
								content : "No se puede obtener el ingreso de paciente especificado.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});
			}
		}
	}
});

// Fin Búsqueda de pacientes por diferentes criterios

// Inicio Búsqueda de controlador por código

$("#buscar-controlador").keypress(function(key){
	if ($("#buscar-controlador").val() !== "")
	{
		if (key.which === 13)
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/controlador/porCodigo",
				dataType: "json",
				data: JSON.stringify({"Codigo": $("#buscar-controlador").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se han encontrado ingresos coincidentes.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
						if (response.data === "El ingreso ya tiene resultados")
						{
							$.bigBox({
								title : "Error",
								content : "El ingreso seleccionado ya tiene resultados ingresados.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
					else
					{
						switch(response.cantidad)
						{
							case 0: $.bigBox({
										title : "Error",
										content : "No existen controladres con el criterio ingresado.",
										color : "#C46A69",
										timeout: 8000,
										icon : "fa fa-warning shake animated"
									});
									break;
							case 1: MostrarControlador(response);
									break;
							default: $("#body-controladores").empty();
									 $.each(response.data, function(index, item){
									    if (item.IngresosPractica !== null)
										  {
											$("#body-controladores").append("<tr id=\"" + item.Id + "\">"+
																			"<td>"      + item.Codigo + "</td>"+
																			"<td>"      + item.Nombre + "</td>"+
																			"<td>"      + item.Apellido + "</td>"+
																		"</tr>");
										  } 
									 });
									 $("#modal-controladores").modal("show");
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
							content : "No se puede obtener el ingreso de paciente especificado.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
	}
});

// Fin Búsqueda de controlador por código

// Inicio Selección de un controlador del modal

$("#body-controladores").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	$("#buscar-controlador").attr("data-value", fila.id);
	$("#buscar-controlador").val(fila.cells[0].innerText + " - MAT: " + fila.cells[1].innerText);
	$("#modal-controladores").modal("hide");
	$("#buscar-controlador").focus();
	$("#emitir-protocolo").removeAttr('disabled');
	
});

// Fin Selección de un controlador del modal

// Inicio Funciones Comunes

function MostrarDatos(response)
{		
	$("#datos-paciente").show();
	$('#cuerpo-protocolo').show();
	$('#datos-controlador').show();
	$("#practicas").empty();
	$('#footer').show();

	$("#ingresoId").val(response.data[0].IngresoId);
	$("#protocolo").attr("data-id", response.data[0].IngresoId);
	$("#protocolo").text(response.data[0].NumPaciente);
	$("#apellido-nombre").text(response.data[0].ApellidoNombre);

	// Cargo las practicas y sus estados
	var estadoPractica;
	var protocoloCompleto = true;
	var protocoloEmitido = true;

	var combo = "<select class=\"form-control input-sm\">" +
  					"<option>Pendiente P</option>" +
  					"<option>Completa C</option>" +
				"</select>";
	
	$.each(response.data[0].IngresosPractica, function(index, item){
		
		if(item.Resultado !== null)
		{
			estadoPractica = "<b>Completa C</b>";
		}
		else
		{
			estadoPractica = "<b>Pendiente P</b>";
		}

		$("#practicas").append("<section class=\"col col-3\"> " +
									"<label class=\"label\">"+ item.PracticaCodigo + " " + estadoPractica +"</label>" +
								"</section>");
	});

	// Calculo el estado del protocolo
	$.each(response.data[0].IngresosPractica, function(index, item){
		if(item.Resultado === null)
		{
			return protocoloCompleto = false
		}
	});

	$.each(response.data[0].IngresosPractica, function(index, item){
		if(item.EstaEmitido === 0)
		{
			return protocoloEmitido = false
		}
	});

	$("#estadoProtocolo").empty();

	if(protocoloCompleto)
	{
		$("#estadoProtocolo").append("<span><strong>Protocolo Completo</strong></span>");
	}
	else
	{
		$("#estadoProtocolo").append("<span><strong>Protocolo Incompleto</strong></span>");
	}
}

function MostrarControlador(response)
{
	$("#buscar-controlador").attr("data-value", response.data[0].Id);
	$("#buscar-controlador").val(response.data[0].Codigo + " - MAT: " + response.data[0].Nombre + " " + response.data[0].Apellido);
	$("#buscar-controlador").focus();
	$("#emitir-protocolo").removeAttr('disabled');
}

$("#emitir-protocolo").on("click", function(){
	$('#form-protocolos').submit();
	$('#datos-paciente').hide();
	$('#cuerpo-protocolo').hide();
	$('#datos-controlador').hide();
	$('#footer').hide();

	$('#buscar-paciente').val('');
	$('#protocolo').text('');
	$('#apellido-nombre').text('');
	$("#practicas").empty();
	$('#estadoProtocolo').text('');
	$('#buscar-controlador').val('');
	$("#emitir-protocolo").prop('disabled', true);
});

// Fin Funciones Comunes