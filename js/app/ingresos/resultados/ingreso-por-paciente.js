// Inicio variables globales

	var practicas;
	var practicasIncompletas = [];
	var count = 0;
	var ingresosExitosos = 0;
	var antecedentes =  [];

// Fin variables globales

$(document).ready(function(){
	$("#buscar-paciente").focus();
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
					url: "api/resultados/ingresos/pornombre",
					dataType: "json",
					data: JSON.stringify({"ApellidoNombre": $("#buscar-paciente").val(), "DesdeProtocolo": 0}),
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
					data: JSON.stringify({"NumPaciente": $("#buscar-paciente").val(), "DesdeProtocolo": 0}),
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
					data: JSON.stringify({"DNI": $("#buscar-paciente").val(), "DesdeProtocolo": 0}),
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

$("#body-ingresos").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	$("#buscar-paciente").attr("data-value", fila.id);
	seleccionarIngreso(fila.id);
	$("#modal-ingresos").modal("hide");	
});

// Inicio seleccionar un ingreso desde el modal

function seleccionarIngreso(id){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/resultados/ingresos/"+id,
		dataType: "json",
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos")
				{
					$.bigBox({
						title : "Error",
						content : "El ingreso seleccionado ya no existe.<br>Por favor, elija otro.",
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
				MostrarDatos(response);
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

// Fin seleccionar un ingreso desde el modal

$("#por-apellido-nombre").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#por-num-paciente").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#por-dni").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#form-resultados").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

// Inicio Paginado
$('#anterior').click(function(){
	
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		count--;
		var practicaAcutal = practicasIncompletas[count];

		$("#determinacion").text(practicaAcutal.CodTitulo);
		$("#descripcion").text(practicaAcutal.TitDescrip);
		$("#unidades").text(practicaAcutal.TitUnidades);
		$("#valores-referencias").text(practicaAcutal.ValoresReferenciaAmpliados);
		$("#seccion").text(practicaAcutal.NombreSeccion);

		if(count === 0)
			{
				$('#li-siguiente').removeClass("disabled");
				$('#siguiente').removeClass("disabled");

				$('#li-anterior').addClass("disabled");
				$('#anterior').addClass("disabled");
			}	
	}
});

$('#siguiente').click(function(){
		MostrarSiguientePractica();
});

// Fin Paginado

// Inicio Tomo el valor del resultado de la práctica

$("#resultado-practica").keypress(function(e) {
    if(e.which == 13)
	{
		// Seteo la visualización de las ultimas 5 prácticas en el sector de antecedentes
		antecedentes.push($("#resultado-practica").val());
	
		if(antecedentes.length === 6)
		{
			antecedentes.shift();
		}
	
		$("#antecedentes").empty();
		$.each(antecedentes, function(i, val){
			$("#antecedentes").prepend("<div class=\"form-group\">" +
											"<label>" + val + "</label>" +
									   "</div>");
		});

		// Guardo el resultado

		$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/resultados/crearlo",
		dataType: "json",
		data: FormToJSON(ingresosExitosos),
		headers: {"Authorization": $.cookie("ApiKey")},
			success: function(response){
				if (response.error === false)
				{					
					ingresosExitosos++;
					
					if(ingresosExitosos === practicasIncompletas.length)
						{
							$("#form-campos").hide();
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
					arr = ["IngresoId, NomencladorId, Resultado, CreadoPor"];
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
					}	
					Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
					$.bigBox({
						title : "Error",
						content : "Asegúrese que completó todos los campos requeridos. <br>"+Errores,
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});

		MostrarSiguientePractica();			
    }
});

// Fin Tomo el valor del resultado de la práctica

// Inicio Funciones Comunes

function MostrarSiguientePractica()
{
	if ($("#li-siguiente").prop("class") !== "disabled")
	{	
		$("#resultado-practica").val("");

		count++;
		var practicaAcutal = practicasIncompletas[count];

		$("#determinacion").text(practicaAcutal.PracticaCodigo);
		$("#determinacion").attr("data-id", practicaAcutal.NomencladorId);
		$("#descripcion").text(practicaAcutal.PracticaNombre);
		$("#unidades").text(practicaAcutal.TitUnidades);
		$("#valores-referencias").text(practicaAcutal.ValoresReferenciaAmpliados);
		$("#seccion").text(practicaAcutal.NombreSeccion);
		
		console.log('count: ' + count);
		console.log('deteminacion id: ' + $("#determinacion").attr('data-id'));

		if(count === practicasIncompletas.length - 1)
			{
				$('#li-anterior').removeClass("disabled");
				$('#anterior').removeClass("disabled");

				$('#li-siguiente').addClass("disabled");
				$('#siguiente').addClass("disabled");
			}
	}
}

function FormToJSON(ingresosExitosos)
{
	var esUltimoResultado = ingresosExitosos + 1 === practicasIncompletas.length;

	return JSON.stringify({
		"IngresoId": $("#protocolo").data("id"),
		"NomencladorId": $("#determinacion").attr('data-id'),
		"Resultado": $("#resultado-practica").val(),		
		"CreadoPor": $.cookie("NombreUsuario"),
		"EsUltimoResultado" : esUltimoResultado === false ? 0 : 1,
		"DesdeProtocolo": 0
	});
}

function MostrarDatos(response)
{
	var observaciones = response.data[0].Comentarios !== null ? response.data[0].Comentarios : 'Sin observaciones';
	$("#form-campos").show();
	$("#protocolo").attr("data-id", response.data[0].IngresoId);
	$("#apellido-nombre").text(response.data[0].ApellidoNombre);
	$("#numero-doc").text(response.data[0].NumDocumento);
	$("#protocolo").text(response.data[0].NumPaciente);
	$("#observaciones").text(observaciones);
	$("#seccion").text('Sección');
	
	var fecha_nac = new Date(response.data[0].FechaNacimiento);							

	var hoy = new Date();													
	
	var total = Math.floor((hoy - fecha_nac) / (1000 * 60 * 60 * 24 * 365));

	!isNaN(total) !== false ? $("#edad").text(total) : null;

	switch (response.data[0].Sexo)
	{
		case 0: sexo = "Masculino";
			break;
		case 1: sexo = "Femenino";
			break;
		default: sexo = "NE";
			break;
	}
	$("#sexo").text(sexo);
	$("#origen").text(response.data[0].Origen);

	if (response.data[0].MedicoId !== null)
	{
		$("#doctor").text(response.data[0].ApellidoMed+" "+response.data[0].NombreMed);
	}
	else
	{
		$('#doctor').text('No especifica');
	}

	// Carga de prácticas
	practicas = response.data[0].IngresosPractica;
	
	$.each(practicas, function(index, item){
			if(item.Resultado === null){
				practicasIncompletas.push(item)
			}
	});
	
	//var primerPractica = response.data[0].IngresosPractica[0];
	var primerPracticaIncompleta = practicasIncompletas[0];
	$("#determinacion").text(primerPracticaIncompleta.PracticaCodigo);
	$("#determinacion").attr("data-id", primerPracticaIncompleta.NomencladorId);
	$("#descripcion").text(primerPracticaIncompleta.PracticaNombre);
	$("#unidades").text(primerPracticaIncompleta.TitUnidades);
	$("#valores-referencias").text(primerPracticaIncompleta.ValoresReferenciaAmpliados);
	$("#seccion").text(primerPracticaIncompleta.NombreSeccion);
	
	$("#resultado-practica").focus();
}

// Fin Funciones Comunes