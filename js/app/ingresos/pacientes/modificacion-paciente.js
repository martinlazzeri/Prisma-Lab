$(document).ready(function(){
	$("#buscar-pacientes").focus();
});

function borrarPractica(id_td){	
	var practicas = $("#row-practicas td");	
	var borrado = $("#row-borrado td");	
	calcularCostoPractica(practicas[id_td].attributes[1].value, practicas[id_td].attributes[2].value, "resta");
	$(practicas[id_td]).remove();
	$(borrado[id_td]).remove();

	reordenarIndices(id_td);
}

function reordenarIndices(id){
	var borrado = $("#row-borrado td button");	

	for (var i = id; i < borrado.length; i++) 
	{
		borrado[i].attributes[2].value = "borrarPractica("+(i)+");";
	}
}

function resetPracticas(){
	$("#row-practicas").empty();
	$("#row-borrado").empty();
	$("#practica").val("");
	$("#practica").prop("disabled", false);
	$("#span-nomen-trabajo").hide();
	$("#span-nomen-especial").hide();
	$("#costo-parcial").hide();
	$("#costo-parcial").text("");
	$("#label-total").text("0.00");
	$("#label-cuenta-sena").text("");
	$("#label-saldo-pendiente").text("");
	$("#span-costo").hide();
	$("#span-codigo-nomen").hide();
	$("#div-final").hide();
	$("#modificar").prop("disabled", true);
}

function resetFormObra1(){
	$("#obra1").val("");
	$("#form-mutual1").prop("hidden", true);
	$("#debe-orden1").prop("selectedIndex", "");
	$("#num-afiliado1").val("");
	$("#tipo-afiliado1").prop("selectedIndex", "");
	$("#porc-cobertura1").text("");
	$("#obra1").attr("data-value", "");
}

function resetFormObra2(){
	$("#obra2").val("");
	$("#form-mutual2").prop("hidden", true);
	$("#debe-orden2").prop("selectedIndex", "");
	$("#num-afiliado2").val("");
	$("#tipo-afiliado2").prop("selectedIndex", "");
	$("#porc-cobertura2").text("");
	$("#obra2").attr("data-value", "");
}

$("#buscar-pacientes").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#buscar-pacientes").val() !== "") 
		{
			if (isNaN($("#buscar-pacientes").val())) 
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/ingresos/pornombre",
					dataType: "json",
					data: JSON.stringify({"ApellidoNombre": $("#buscar-pacientes").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true) 
						{
							if (response.data === "No se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No se encontraron ingresos que coincidan con los datos ingresados.",
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
								resetPracticas();
								$("#buscar-pacientes").val(response.data[0].NumPaciente);
								$("#buscar-pacientes").attr("data-value", response.data[0].IngresoId);
								$("#nombre").val(response.data[0].ApellidoNombre);
								$("#nombre").attr("data-value", response.data[0].PacienteId);
								$("#fecha-nac").val(response.data[0].FechaNacimiento);
								$("#fecha-nac").blur();
								$("#sexo").val(response.data[0].Sexo);
								$("#origen").val(response.data[0].Origen);
								$("#cuenta").val(response.data[0].Cuenta);
								$("#cama").val(response.data[0].Cama);
								$("#direccion").val(response.data[0].Direccion);
								$("#numero-doc").val(response.data[0].NumDocumento);
								$("#telefono").val(response.data[0].Telefono);
								$("#celular").val(response.data[0].Celular);
								$("#lugar").val(response.data[0].Lugar);
								$("#email").val(response.data[0].Mail);				
								if (response.data[0].MedicoId !== null)
								{
									$("#matricula-medico").val(response.data[0].ApellidoMed+" "+response.data[0].NombreMed+" - MAT: "+response.data[0].Matricula);
									$("#matricula-medico").attr("data-value", response.data[0].MedicoId);									
								}
								else
								{
									$("#matricula-medico").val("");
									$("#matricula-medico").attr("data-value", "");
									$("#nombre-doctor").text("");
								}
								if (response.data[0].Mutual1Id !== null) 
								{
									$("#obra1").val(response.data[0].Mutual1Nombre+" - COD: "+response.data[0].Mutual1Cod);
									$("#obra1").attr("data-value", response.data[0].Mutual1Id);									
									$("#form-mutual1").prop("hidden", false);
									$("#debe-orden1").val(response.data[0].DebeOrden1);
									$("#num-afiliado1").val(response.data[0].NumAfiliado1);
									$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
									$("#porc-cobertura1").text(response.data[0].PorcCobertura1);
								}
								else
								{
									resetFormObra1();
									$("#obra1").val("");
								}				
								if (response.data[0].Mutual2Id !== null) 
								{
									$("#obra2").val(response.data[0].Mutual2Nombre+" - COD: "+response.data[0].Mutual2Cod);
									$("#obra2").attr("data-value", response.data[0].Mutual12d);
									$("#form-mutual2").prop("hidden", false);
									$("#debe-orden2").val(response.data[0].DebeOrden2);
									$("#num-afiliado2").val(response.data[0].NumAfiliado2);
									$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
									$("#porc-cobertura2").text(response.data[0].PorcCobertura2);
								}
								else
								{
									resetFormObra2();
									$("#obra2").val("");
								}					
								$("#factor").val(response.data[0].Factor);
								$("#acto-prof").val(response.data[0].ActoProf);
								$("#sin-cargo").val(response.data[0].SinCargo);
								$("#realiza-descuentos").val(response.data[0].RealizaDescuentos);
								$("#reajuste-importe").val(response.data[0].ReajustaImporte);
								$("#abono-sena").val(response.data[0].AbonoSena);
								$("#label-cuenta-sena").text(parseFloat(response.data[0].AbonoSena).toFixed(2));
								$("#comentarios").val(response.data[0].Comentarios);
								$("#form-modificar :input").prop("disabled", false);
								$("#nombre").focus();

								if (response.data[0].IngresosPractica) 
								{
									$.each(response.data[0].IngresosPractica, function(index, item){
										$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+item.EsNomencladorTrabajo+"\">"+item.PracticaCodigo+"</td>");
										$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
										if (index === 0)
										{											
											calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo, "apb");
										}
										else
										{
											calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo, "suma");
										}
									});
									$("#div-final").show();
								}
								habilitarModificar();
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									$("#body-ingresos").append("<tr id="+item.IngresoId+">"+
																	"<td>"+item.NumPaciente+"</td>"+
																	"<td>"+item.ApellidoNombre+"</td>"+
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
								content : "No se puede obtener el ingreso especificado.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});	
			}
			if (!isNaN($("#buscar-pacientes").val())) 
			{
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/ingresos/pornumpaciente",					
					dataType: "json",
					data: JSON.stringify({"NumPaciente": $("#buscar-pacientes").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true) 
						{
							if (response.data === "No se encontraron datos")
							{
								$.bigBox({
									title : "Error",
									content : "No se han encontrado ingresos para los datos ingresados.",
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
								resetPracticas();
								$("#buscar-pacientes").val(response.data[0].NumPaciente);
								$("#buscar-pacientes").attr("data-value", response.data[0].IngresoId);
								$("#nombre").val(response.data[0].ApellidoNombre);
								$("#nombre").attr("data-value", response.data[0].PacienteId);
								$("#fecha-nac").val(response.data[0].FechaNacimiento);
								$("#fecha-nac").blur();
								$("#sexo").val(response.data[0].Sexo);
								$("#origen").val(response.data[0].Origen);
								$("#cuenta").val(response.data[0].Cuenta);
								$("#cama").val(response.data[0].Cama);
								$("#direccion").val(response.data[0].Direccion);
								$("#numero-doc").val(response.data[0].NumDocumento);
								$("#telefono").val(response.data[0].Telefono);
								$("#celular").val(response.data[0].Celular);
								$("#lugar").val(response.data[0].Lugar);
								$("#email").val(response.data[0].Mail);				
								if (response.data[0].MedicoId !== null)
								{
									$("#matricula-medico").val(response.data[0].ApellidoMed+" "+response.data[0].NombreMed+" - MAT: "+response.data[0].Matricula);
									$("#matricula-medico").attr("data-value", response.data[0].MedicoId);									
								}
								else
								{
									$("#matricula-medico").val("");
									$("#matricula-medico").attr("data-value", "");
									$("#nombre-doctor").text("");
								}
								if (response.data[0].Mutual1Id !== null) 
								{
									$("#obra1").val(response.data[0].Mutual1Nombre+" - COD: "+response.data[0].Mutual1Cod);
									$("#obra1").attr("data-value", response.data[0].Mutual1Id);									
									$("#form-mutual1").prop("hidden", false);
									$("#debe-orden1").val(response.data[0].DebeOrden1);
									$("#num-afiliado1").val(response.data[0].NumAfiliado1);
									$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
									$("#porc-cobertura1").text(response.data[0].PorcCobertura1);
								}
								else
								{
									resetFormObra1();
									$("#obra1").val("");
								}				
								if (response.data[0].Mutual2Id !== null) 
								{
									$("#obra2").val(response.data[0].Mutual2Nombre+" - COD: "+response.data[0].Mutual2Cod);
									$("#obra2").attr("data-value", response.data[0].Mutual12d);
									$("#form-mutual2").prop("hidden", false);
									$("#debe-orden2").val(response.data[0].DebeOrden2);
									$("#num-afiliado2").val(response.data[0].NumAfiliado2);
									$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
									$("#porc-cobertura2").text(response.data[0].PorcCobertura2);
								}
								else
								{
									resetFormObra2();
									$("#obra2").val("");
								}					
								$("#factor").val(response.data[0].Factor);
								$("#acto-prof").val(response.data[0].ActoProf);
								$("#sin-cargo").val(response.data[0].SinCargo);
								$("#realiza-descuentos").val(response.data[0].RealizaDescuentos);
								$("#reajuste-importe").val(response.data[0].ReajustaImporte);
								$("#abono-sena").val(response.data[0].AbonoSena);
								$("#label-cuenta-sena").text(parseFloat(response.data[0].AbonoSena).toFixed(2));
								$("#comentarios").val(response.data[0].Comentarios);
								$("#form-modificar :input").prop("disabled", false);										
								$("#nombre").focus();

								if (response.data[0].IngresosPractica) 
								{
									$.each(response.data[0].IngresosPractica, function(index, item){
										$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+item.EsNomencladorTrabajo+"\">"+item.PracticaCodigo+"</td>");
										$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
										calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo, "suma");
									});	
									$("#div-final").show();
								}

								habilitarModificar();
							}
							else
							{
								$("#body-ingresos").empty();
								$.each(response.data, function(index, item){
									$("#body-ingresos").append("<tr id="+item.IngresoId+">"+
																	"<td>"+item.NumPaciente+"</td>"+
																	"<td>"+item.ApellidoNombre+"</td>"+
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
								content : "No se puede obtener el ingreso especificado.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
				});	
			}
		}
		key.preventDefault();
	}
});

$("#body-ingresos").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	$("#buscar-pacientes").attr("data-value", fila.id);
	seleccionarIngreso(fila.id);
	$("#modal-ingresos").modal("hide");
	$("#buscar-pacientes").focus();
});

$("#body-medicos").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	$("#matricula-medico").attr("data-value", fila.id);
	$("#matricula-medico").val(fila.cells[0].innerText+" - MAT: "+fila.cells[1].innerText);
	$("#modal-medicos").modal("hide");
	$("#matricula-medico").focus();
});

$("#body-mutuales").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	if ($("#obra2").val() === fila.cells[0].innerText+" - COD: "+fila.cells[1].innerText) 
	{
		$.bigBox({
			title : "Error",
			content : "La mutual elegida ya esta asignada.<br>Por favor elija otra.",
			color : "#C46A69",
			timeout: 8000,
			icon : "fa fa-warning shake animated"
		});
	}
	else
	{
		$("#obra1").attr("data-value", fila.id);
		$("#obra1").val(fila.cells[0].innerText+" - COD: "+fila.cells[1].innerText);
		$("#porc-cobertura1").val(fila.cells[2].innerText);
		$("#form-mutual1").prop("hidden", false);
		$("#debe-orden1").focus();		
		resetPracticas();	
		
		$("#modal-mutuales").modal("hide");
	}
});

$("#body-mutuales2").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	if ($("#obra1").val() === fila.cells[0].innerText+" - COD: "+fila.cells[1].innerText)
	{
		$.bigBox({
			title : "Error",
			content : "La mutual elegida ya esta asignada.<br>Por favor elija otra.",
			color : "#C46A69",
			timeout: 8000,
			icon : "fa fa-warning shake animated"
		});
	}
	else
	{
		$("#obra2").attr("data-value", fila.id);
		$("#obra2").val(fila.cells[0].innerText+" - COD: "+fila.cells[1].innerText);
		$("#porc-cobertura2").val(fila.cells[2].innerText);
		$("#form-mutual2").prop("hidden", false);
		$("#debe-orden2").focus();

		$("#modal-mutuales2").modal("hide");
	}
});

$("#body-practicas-modal").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	var esdetrabajo = fila.childNodes[2].innerText;
	esdetrabajo == "Especial" ? esdetrabajo = 0 : esdetrabajo = 1;
	seleccionarPractica(fila.id, esdetrabajo);

	$("#modal-practicas").modal("hide");
	$("#practica").focus();
});

function seleccionarIngreso(id){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/ingresos/"+id,
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
			}
			else
			{
				$("#form-campos").show();
				resetPracticas();
				$("#buscar-pacientes").val(response.data[0].NumPaciente);
				$("#buscar-pacientes").attr("data-value", response.data[0].IngresoId);
				$("#nombre").val(response.data[0].ApellidoNombre);
				$("#nombre").attr("data-value", response.data[0].PacienteId);
				$("#fecha-nac").val(response.data[0].FechaNacimiento);
				$("#fecha-nac").blur();
				$("#sexo").val(response.data[0].Sexo);
				$("#origen").val(response.data[0].Origen);
				$("#cuenta").val(response.data[0].Cuenta);
				$("#cama").val(response.data[0].Cama);
				$("#direccion").val(response.data[0].Direccion);
				$("#numero-doc").val(response.data[0].NumDocumento);
				$("#telefono").val(response.data[0].Telefono);
				$("#celular").val(response.data[0].Celular);
				$("#lugar").val(response.data[0].Lugar);
				$("#email").val(response.data[0].Mail);				
				if (response.data[0].MedicoId !== null)
				{
					$("#matricula-medico").val(response.data[0].ApellidoMed+" "+response.data[0].NombreMed+" - MAT: "+response.data[0].Matricula);
					$("#matricula-medico").attr("data-value", response.data[0].MedicoId);									
				}
				else
				{
					$("#matricula-medico").val("");
					$("#matricula-medico").attr("data-value", "");
					$("#nombre-doctor").text("");
				}
				if (response.data[0].Mutual1Id !== null) 
				{
					$("#obra1").val(response.data[0].Mutual1Nombre+" - COD: "+response.data[0].Mutual1Cod);
					$("#obra1").attr("data-value", response.data[0].Mutual1Id);									
					$("#form-mutual1").prop("hidden", false);
					$("#debe-orden1").val(response.data[0].DebeOrden1);
					$("#num-afiliado1").val(response.data[0].NumAfiliado1);
					$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
					$("#porc-cobertura1").text(response.data[0].PorcCobertura1);
				}
				else
				{
					resetFormObra1();
					$("#obra1").val("");
				}				
				if (response.data[0].Mutual2Id !== null) 
				{
					$("#obra2").val(response.data[0].Mutual2Nombre+" - COD: "+response.data[0].Mutual2Cod);
					$("#obra2").attr("data-value", response.data[0].Mutual12d);
					$("#form-mutual2").prop("hidden", false);
					$("#debe-orden2").val(response.data[0].DebeOrden2);
					$("#num-afiliado2").val(response.data[0].NumAfiliado2);
					$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
					$("#porc-cobertura2").text(response.data[0].PorcCobertura2);
				}
				else
				{
					resetFormObra2();
					$("#obra2").val("");
				}					
				$("#factor").val(response.data[0].Factor);
				$("#acto-prof").val(response.data[0].ActoProf);
				$("#sin-cargo").val(response.data[0].SinCargo);
				$("#realiza-descuentos").val(response.data[0].RealizaDescuentos);
				$("#reajuste-importe").val(response.data[0].ReajustaImporte);
				$("#abono-sena").val(response.data[0].AbonoSena);
				$("#label-cuenta-sena").text(parseFloat(response.data[0].AbonoSena).toFixed(2));
				$("#comentarios").val(response.data[0].Comentarios);
				$("#form-modificar :input").prop("disabled", false);										
				$("#nombre").focus();

				if (response.data[0].IngresosPractica) 
				{
					$.each(response.data[0].IngresosPractica, function(index, item){
						$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+item.EsNomencladorTrabajo+"\">"+item.PracticaCodigo+"</td>");
						$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
						calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo, "suma");
					});	
					$("#div-final").show();
				}

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
					content : "No se puede obtener el ingreso de paciente especificado.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	})
}

$("#practica").keypress(function(key){
	if (key.which === 13)
	{
		if ($("#practica").attr("data-id") !== "" && $("#practica").attr("data-tipo") !== "")
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/nomencladoresespeciales/porid",
				dataType: "json",
				data: JSON.stringify({"Id": $("#practica").data("id"),
									  "EsNomencladorTrabajo": $("#practica").data("tipo")}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true) 
					{
						if (response.data === "No se encontraron datos") 
						{
							$.bigBox({
								title : "Error",
								content : "El nomenclador elegido ya no existe.<br>Por favor, seleccione otro.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
					else
					{
						var count_celda = $("#row-practicas td").length;

						if (count_celda == 20) 
						{
							$.bigBox({
								title : "Error",
								content : "Sólo se permiten hasta 20 prácticas por ingreso de paciente.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
							return;
						}

						var codigo = $("#span-codigo-nomen").text().split(" ");

						var celdas = $("#row-practicas td");						
						for (var i = 0; i < count_celda; i++) 
						{
							if(celdas[i].innerText === codigo[1])
							{
								$.bigBox({
									title : "Error",
									content : "La práctica que desea ingresar ya se encuentra.<br>Por favor, seleccione otra.",
									color : "#C46A69",
									timeout: 5000,
									icon : "fa fa-warning shake animated"
								});
								$("#practica").val("");
								$("#practica").attr("data-id", "");
								$("#practica").attr("data-tipo", "");
								$("#span-nomen-trabajo").hide();
								$("#span-nomen-especial").hide();
								$("#costo-parcial").hide();
								$("#span-costo").hide();
								$("#span-costo").text("");
								$("#span-codigo-nomen").hide();								
								$("#practica").focus();
								return;
							}							
						}

						count_celda == 0 ? $("#label-total").text(parseFloat(response.valores[0].ActoProfesionalBioquimico).toFixed(2)) : "";

						var parcial = parseFloat($("#costo-parcial").text());
						var total = parseFloat($("#label-total").text());

						$("#label-total").text(parseFloat(parcial+total).toFixed(2));

						$("#span-nomen-trabajo").hide();
						$("#span-nomen-especial").hide();
						$("#costo-parcial").hide();
						$("#span-costo").hide();
						$("#span-costo").text("");
						$("#span-codigo-nomen").hide();
						
						var td = "<td data-ingresop="+0+" data-nomencladorid=\""+$("#practica").attr("data-id")+"\" data-tipo=\""+$("#practica").data("tipo")+"\">"+codigo[1]+"</td>";						

						var borrado = "<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ count_celda +");\"></button></td>";

						$("#practica").attr("data-id", "");
						$("#practica").attr("data-tipo", "");
						$("#row-practicas").append(td);
						$("#row-borrado").append(borrado);
						$("#practica").val("");
						$("#practica").focus();

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
							content : "No se puede obtener la práctica.",
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
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/nomencladoresespeciales/pormutual",
				dataType: "json",
				data: JSON.stringify({"Nombre": $("#practica").val(),
									  "Mutual1": $("#obra1").attr("data-value")}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron prácticas.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
					else
					{	//la consulta devuelve 1 solo nomenclador de trabajo o especial
						if (response.cantidad === 1)
						{	
							$("#costo-parcial").text("");
							//rescato valores de unidades
							response.valores[0].UGastos == null ? valorugasto = null : valorugasto = response.valores[0].UGastos;
							response.valores[0].UHonorarios == null ? valoruhono = null : valoruhono = response.valores[0].UHonorarios;
							response.valores[0].ActoProfesionalBioquimico == null ? apb = null : apb = response.valores[0].ActoProfesionalBioquimico;

							if (response.tipoNomenc == 0) //nomenclador especial
							{								
								$("#practica").attr("data-id", response.nomencladoresespeciales[0].PracticaId);
								$("#practica").attr("data-tipo", response.tipoNomenc);
								$("#practica").val(response.nomencladoresespeciales[0].NomEspCodigo+" "+response.nomencladoresespeciales[0].NomEspNombre);					
								$("#span-nomen-trabajo").hide();					
								$("#span-codigo-nomen").text("Código: "+response.nomencladoresespeciales[0].NomEspCodigo);

								//rescato datos de nomencladores especiales
								var codigo = response.nomencladoresespeciales[0].NomEspNombre.substr(0, 1);
								response.nomencladoresespeciales[0].INOSReducido == null ? inosreducido = null : inosreducido = response.nomencladoresespeciales[0].INOSReducido;
								response.nomencladoresespeciales[0].CoeficienteUGastos == null ? coefugasto = null : coefugasto = response.nomencladoresespeciales[0].CoeficienteUGastos;
								response.nomencladoresespeciales[0].CoeficienteUHono == null ? coefuhono = null : coefuhono = response.nomencladoresespeciales[0].CoeficienteUHono;
								var categoria = response.nomencladoresespeciales[0].Categoria;
								response.nomencladoresespeciales[0].ValorA == null ? valora = null : valora = response.nomencladoresespeciales[0].ValorA;
								response.nomencladoresespeciales[0].ValorB == null ? valorb = null : valorb = response.nomencladoresespeciales[0].ValorB;
								response.nomencladoresespeciales[0].ValorC == null ? valorc = null : valorc = response.nomencladoresespeciales[0].ValorC;
								response.nomencladoresespeciales[0].Nivel == null ? nivel = null : nivel = response.nomencladoresespeciales[0].Nivel;
								response.nomencladoresespeciales[0].ValorNBU == null ? valornbu = null : valornbu = response.nomencladoresespeciales[0].ValorNBU;
								
								if (coefugasto !== null && coefuhono !== null && categoria !== null && valorugasto !== null && valoruhono !== null) 
								{
									//calculo costo para nomenclador especial INOS
									$("#costo-parcial").text(parseFloat( ( parseFloat(valorugasto).toFixed(2) * parseFloat(coefugasto).toFixed(2) * parseFloat(categoria).toFixed(2) ) + 
					    					  ( parseFloat(valoruhono).toFixed(2) * parseFloat(coefuhono).toFixed(2) * parseFloat(categoria).toFixed(2) ) ).toFixed(2));
								}
								if (valora !== null && valorb !== null && valorc !== null && codigo !== null && nivel !== null) 
								{
									//calculo costo para nomenclador especial FABA					
									switch (codigo)
									{
										case "A":$("#costo-parcial").text(parseFloat(parseFloat(valora).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
												break;
										case "B":$("#costo-parcial").text(parseFloat(parseFloat(valorb).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
												break;
										case "C":$("#costo-parcial").text(parseFloat(parseFloat(valorc).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
												break;
									}
								}
								if (valornbu !== null && codigo !== null && nivel !== null) 
								{
									//calculo costo para nomenclador especial NBU
									$("#costo-parcial").text(parseFloat(parseFloat(valornbu).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
								}

								$("#span-nomen-especial").show();
								$("#span-costo").show();
								$("#costo-parcial").show();
								$("#span-codigo-nomen").show();
							}

							if (response.tipoNomenc == 1) //nomenclador de trabajo
							{								
								$("#practica").attr("data-id", response.nomencladores[0].PracticaId);
								$("#practica").attr("data-tipo", response.tipoNomenc);
								$("#practica").val(response.nomencladores[0].NomencladorCodigo+" "+response.nomencladores[0].NomencladorNombre);
								$("#span-nomen-especial").hide();					
								$("#span-codigo-nomen").text("Código: "+response.nomencladores[0].NomencladorCodigo);

								response.nomencladores[0].UGastos == null ? ugasto = null : ugasto = response.nomencladores[0].UGastos;
								response.nomencladores[0].UHonorarios == null ? uhono = null : uhono = response.nomencladores[0].UHonorarios;

								$("#costo-parcial").text(parseFloat((ugasto * valorugasto) + (uhono * valoruhono)).toFixed(2));

								$("#span-nomen-trabajo").show();
								$("#span-costo").show();
								$("#costo-parcial").show();
								$("#span-codigo-nomen").show();	
							}						
						}
						else
						{
							//mas de un nomenclador devuelto
							$("#body-practicas-modal").empty();
							//checkeo que existan nomencladores especiales
							if (response.nomencladoresespeciales)
							{
								$.each(response.nomencladoresespeciales, function(index, item){
									$("#body-practicas-modal").append("<tr id=\""+item.PracticaId+"\">"+
																		"<td>"+item.NomEspCodigo+"</td>"+
																		"<td>"+item.NomEspNombre+"</td>"+
																		"<td>Especial</td>"+
																	"</tr>");
								});
							}

							//checkeo que existan nomencladores de trabajo
							if (response.nomencladores)
							{
								$.each(response.nomencladores, function(index, item){
									$("#body-practicas-modal").append("<tr id=\""+item.PracticaId+"\">"+
																		"<td>"+item.NomencladorCodigo+"</td>"+
																		"<td>"+item.NomencladorNombre+"</td>"+
																		"<td>De Trabajo</td>"+
																	"</tr>");
								});
							}
							//muestro el modal siempre, dado que el resultado entre nomencladores de trabajo y especiales es mayor a 1
							$("#modal-practicas").modal("show");
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
							content : "No se pueden obtener las prácticas.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			})
		}
		key.preventDefault();
	}
});

function seleccionarPractica(id, tipoNomenclador){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/nomencladoresespeciales/porid",
		dataType: "json",
		data: JSON.stringify({"Id": id,
							  "EsNomencladorTrabajo": tipoNomenclador}),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true) 
			{
				if (response.data === "No se encontraron datos") 
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador elegido ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#practica").attr("data-id", id);
				$("#practica").attr("data-tipo", tipoNomenclador);
				$("#costo-parcial").text("");
				//rescato valores de unidades
				response.valores[0].UGastos == null ? valorugasto = null : valorugasto = response.valores[0].UGastos;
				response.valores[0].UHonorarios == null ? valoruhono = null : valoruhono = response.valores[0].UHonorarios;
				response.valores[0].ActoProfesionalBioquimico == null ? apb = null : apb = response.valores[0].ActoProfesionalBioquimico;

				if (response.tipoNomen == 0) //nomenclador especial
				{
					$("#practica").attr("data-id", response.nomencladoresespeciales[0].PracticaId);
					$("#practica").attr("data-tipo", response.tipoNomenc);
					$("#practica").val(response.nomencladoresespeciales[0].NomEspCodigo+" "+response.nomencladoresespeciales[0].NomEspNombre);					
					$("#span-nomen-trabajo").hide();					
					$("#span-codigo-nomen").text("Código: "+response.nomencladoresespeciales[0].NomEspCodigo);

					//rescato datos de nomencladores especiales
					var codigo = response.nomencladoresespeciales[0].NomEspNombre.substr(0, 1);
					response.nomencladoresespeciales[0].INOSReducido == null ? inosreducido = null : inosreducido = response.nomencladoresespeciales[0].INOSReducido;
					response.nomencladoresespeciales[0].CoeficienteUGastos == null ? coefugasto = null : coefugasto = response.nomencladoresespeciales[0].CoeficienteUGastos;
					response.nomencladoresespeciales[0].CoeficienteUHono == null ? coefuhono = null : coefuhono = response.nomencladoresespeciales[0].CoeficienteUHono;
					var categoria = response.nomencladoresespeciales[0].Categoria;
					response.nomencladoresespeciales[0].ValorA == null ? valora = null : valora = response.nomencladoresespeciales[0].ValorA;
					response.nomencladoresespeciales[0].ValorB == null ? valorb = null : valorb = response.nomencladoresespeciales[0].ValorB;
					response.nomencladoresespeciales[0].ValorC == null ? valorc = null : valorc = response.nomencladoresespeciales[0].ValorC;
					response.nomencladoresespeciales[0].Nivel == null ? nivel = null : nivel = response.nomencladoresespeciales[0].Nivel;
					response.nomencladoresespeciales[0].ValorNBU == null ? valornbu = null : valornbu = response.nomencladoresespeciales[0].ValorNBU;
					
					if (coefugasto !== null && coefuhono !== null && categoria !== null && valorugasto !== null && valoruhono !== null) 
					{					
						//calculo costo para nomenclador especial INOS
						$("#costo-parcial").text(parseFloat( ( parseFloat(valorugasto).toFixed(2) * parseFloat(coefugasto).toFixed(2) * parseFloat(categoria).toFixed(2) ) + 
		    					  ( parseFloat(valoruhono).toFixed(2) * parseFloat(coefuhono).toFixed(2) * parseFloat(categoria).toFixed(2) ) ).toFixed(2));
					}
					if (valora !== null && valorb !== null && valorc !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial FABA					
						switch (codigo)
						{
							case "A":$("#costo-parcial").text(parseFloat(parseFloat(valora).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
							case "B":$("#costo-parcial").text(parseFloat(parseFloat(valorb).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
							case "C":$("#costo-parcial").text(parseFloat(parseFloat(valorc).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
						}
					}
					if (valornbu !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial NBU
						$("#costo-parcial").text(parseFloat(parseFloat(valornbu).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
					}

					$("#span-nomen-especial").show();
					$("#span-costo").show();
					$("#costo-parcial").show();
					$("#span-codigo-nomen").show();					
				}

				if (response.tipoNomen == 1) //nomenclador de trabajo
				{
					$("#practica").attr("data-id", response.nomencladores[0].PracticaId);
					$("#practica").attr("data-tipo", response.tipoNomenc);
					$("#practica").val(response.nomencladores[0].NomencladorCodigo+" "+response.nomencladores[0].NomencladorNombre);
					$("#span-nomen-especial").hide();					
					$("#span-codigo-nomen").text("Código: "+response.nomencladores[0].NomencladorCodigo);

					response.nomencladores[0].UGastos == null ? ugasto = null : ugasto = response.nomencladores[0].UGastos;
					response.nomencladores[0].UHonorarios == null ? uhono = null : uhono = response.nomencladores[0].UHonorarios;

					$("#costo-parcial").text(parseFloat((ugasto * valorugasto) + (uhono * valoruhono)).toFixed(2));

					$("#span-nomen-trabajo").show();
					$("#span-costo").show();
					$("#costo-parcial").show();
					$("#span-codigo-nomen").show();	
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
					content : "No se puede obtener la práctica.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

function calcularCostoPractica(id, tipoNomenclador, operacion){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/nomencladoresespeciales/porid",
		dataType: "json",
		data: JSON.stringify({"Id": id,
							  "EsNomencladorTrabajo": tipoNomenclador}),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true) 
			{
				if (response.data === "No se encontraron datos") 
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador elegido ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{				
				$("#costo-parcial").text("");
				//rescato valores de unidades
				response.valores[0].UGastos == null ? valorugasto = null : valorugasto = response.valores[0].UGastos;
				response.valores[0].UHonorarios == null ? valoruhono = null : valoruhono = response.valores[0].UHonorarios;
				response.valores[0].ActoProfesionalBioquimico == null ? apb = null : apb = response.valores[0].ActoProfesionalBioquimico;

				if (response.tipoNomen == 0) //nomenclador especial
				{
					//rescato datos de nomencladores especiales
					var codigo = response.nomencladoresespeciales[0].NomEspNombre.substr(0, 1);
					response.nomencladoresespeciales[0].INOSReducido == null ? inosreducido = null : inosreducido = response.nomencladoresespeciales[0].INOSReducido;
					response.nomencladoresespeciales[0].CoeficienteUGastos == null ? coefugasto = null : coefugasto = response.nomencladoresespeciales[0].CoeficienteUGastos;
					response.nomencladoresespeciales[0].CoeficienteUHono == null ? coefuhono = null : coefuhono = response.nomencladoresespeciales[0].CoeficienteUHono;
					var categoria = response.nomencladoresespeciales[0].Categoria;
					response.nomencladoresespeciales[0].ValorA == null ? valora = null : valora = response.nomencladoresespeciales[0].ValorA;
					response.nomencladoresespeciales[0].ValorB == null ? valorb = null : valorb = response.nomencladoresespeciales[0].ValorB;
					response.nomencladoresespeciales[0].ValorC == null ? valorc = null : valorc = response.nomencladoresespeciales[0].ValorC;
					response.nomencladoresespeciales[0].Nivel == null ? nivel = null : nivel = response.nomencladoresespeciales[0].Nivel;
					response.nomencladoresespeciales[0].ValorNBU == null ? valornbu = null : valornbu = response.nomencladoresespeciales[0].ValorNBU;
					
					if (coefugasto !== null && coefuhono !== null && categoria !== null && valorugasto !== null && valoruhono !== null) 
					{					
						//calculo costo para nomenclador especial INOS
						$("#costo-parcial").text(parseFloat( ( parseFloat(valorugasto).toFixed(2) * parseFloat(coefugasto).toFixed(2) * parseFloat(categoria).toFixed(2) ) + 
		    					  ( parseFloat(valoruhono).toFixed(2) * parseFloat(coefuhono).toFixed(2) * parseFloat(categoria).toFixed(2) ) ).toFixed(2));
					}
					if (valora !== null && valorb !== null && valorc !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial FABA					
						switch (codigo)
						{
							case "A":$("#costo-parcial").text(parseFloat(parseFloat(valora).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
							case "B":$("#costo-parcial").text(parseFloat(parseFloat(valorb).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
							case "C":$("#costo-parcial").text(parseFloat(parseFloat(valorc).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
									break;
						}
					}
					if (valornbu !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial NBU
						$("#costo-parcial").text(parseFloat(parseFloat(valornbu).toFixed(2) * parseFloat(nivel).toFixed(2)).toFixed(2));
					}
				}

				if (response.tipoNomen == 1) //nomenclador de trabajo
				{
					response.nomencladores[0].UGastos == null ? ugasto = null : ugasto = response.nomencladores[0].UGastos;
					response.nomencladores[0].UHonorarios == null ? uhono = null : uhono = response.nomencladores[0].UHonorarios;

					$("#costo-parcial").text(parseFloat((ugasto * valorugasto) + (uhono * valoruhono)).toFixed(2));
				}

				var parcial = parseFloat($("#costo-parcial").text());
				var total = parseFloat($("#label-total").text());

				operacion === "suma" ? $("#label-total").text(parseFloat(total+parcial).toFixed(2)) : "";
				operacion === "resta" ? $("#label-total").text(parseFloat(total-parcial).toFixed(2)) : "";
				operacion === "apb" ? $("#label-total").text(parseFloat(total+parcial+apb).toFixed(2)) : "";
				$("#costo-parcial").hide();
				$("#label-saldo-pendiente").text("");
				$("#label-saldo-pendiente").text(parseFloat(parseFloat($("#label-total").text()).toFixed(2) - parseFloat($("#label-cuenta-sena").text()).toFixed(2)).toFixed(2));
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
					content : "No se puede obtener la práctica.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#practica").on("input", function(){
	if ($("#practica").val() === "") 
	{
		$("#practica").attr("data-id", "");
		$("#practica").attr("data-tipo", "");
		$("#span-nomen-especial").hide();
		$("#span-nomen-trabajo").hide();
		$("#span-costo").hide();
		$("#costo-parcial").hide();
		$("#span-codigo-nomen").hide();
	}
});

$("#finalizar-ingreso-practicas").click(function(e){
	$("#practica").prop("disabled", true);
	$("#finalizar-ingreso-practicas").prop("disabled", true);
	$("#span-nomen-trabajo").hide();
	$("#span-nomen-especial").hide();
	$("#costo-parcial").hide();
	$("#span-costo").hide();
	$("#span-codigo-nomen").hide();
	$("#practica").val("");
	$("#div-final").show();
	$("#row-borrado td button").prop("disabled", true);
	e.preventDefault();
});

$("#fecha-nac").blur(function(){
	var date_end = new Date();
    var date_start = new Date($("#fecha-nac").val());                
	var total_años = Math.floor((date_end - date_start) / (1000 * 60 * 60 * 24 * 365));			
	if (!isNaN(total_años))
	{
		if (total_años < 0) 
		{
			$("#edad").val("");
			$("#fecha-nac").val("");
		}
		else
		{
			$("#edad").val(total_años);
		}			
	}
	else
	{
		$("#edad").val("");
		$("#fecha-nac").val("");
	}
});
$("#edad").blur(function(){
	if ($("#edad").val() !== "")
	{
		if ($("#fecha-nac").val() === "")
		{
			var fecha = new Date();
			ano = parseInt(fecha.getFullYear());
			$("#fecha-nac").val((ano-$("#edad").val())+"-01-01");
		}
	}		
});

$("#matricula-medico").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#matricula-medico").val() !== "") 
		{
			if (isNaN($("#matricula-medico").val())) 
			{				
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/medicos/porapellido",
					dataType: "json",
					data: JSON.stringify({"Apellido": $("#matricula-medico").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{

						}
						else
						{
							if (response.cantidad === 1) 
							{
								$("#matricula-medico").val(response.data[0].Apellido+" "+response.data[0].Nombre+" - MAT: "+response.data[0].Matricula);
								$("#matricula-medico").attr("data-value", response.data[0].Id);
							}
							else
							{
								$("#body-medicos").empty();
								$.each(response.data, function(index, item){
									$("#body-medicos").append("<tr id="+item.Id+">"+
															  	"<td>"+item.Apellido+" "+item.Nombre+"</td>"+
															  	"<td>"+item.Matricula+"</td>"+
															  "</tr>");
								});
								$("#modal-medicos").modal("show");
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
								content : "No se puede obtener el médico especificado.",
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
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/medicos/pormatricula",
					dataType: "json",
					data: JSON.stringify({"Matricula": $("#matricula-medico").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "No se encontraron datos") 
							{
								$.bigBox({
									title : "Error",
									content : "No se encontraron médicos para los datos especificados.",
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
								$("#matricula-medico").val(response.data[0].Apellido+" "+response.data[0].Nombre+" - MAT: "+response.data[0].Matricula);
								$("#matricula-medico").attr("data-value", response.data[0].Id);
							}
							else
							{			
								$("#body-medicos").empty();			
								$.each(response.data, function(index, item){
									$("#body-medicos").append("<tr id="+item.Id+">"+
															  	"<td>"+item.Apellido+" "+item.Nombre+"</td>"+
															  	"<td>"+item.Matricula+"</td>"+
															  "</tr>");
								});
								$("#modal-medicos").modal("show");
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
								content : "No se puede obtener el médico especificado.",
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

$("#obra1").on("input", function(){
	resetFormObra1();
	resetPracticas();
});

$("#obra1").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#obra1").val() !== "")
		{
			$.ajax({
				type:"POST",
				contentType: "application/json",
				url: "api/mutuales/pornombre",
				dataType: "json",
				data: JSON.stringify({"Nombre": $("#obra1").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true) 
					{
						if (response.data === "No se han econtrado datos") 
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron mutuales coincidentes con los datos ingresados.",
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
							$("#obra1").val(response.data[0].Nombre+" - COD: "+response.data[0].Codigo);
							$("#porc-cobertura1").text(response.data[0].PorcCobertura);
							$("#form-mutual1").prop("hidden", false);
							$("#debe-orden1").focus();
							resetPracticas();
							actualizarPracticas(response.data[0].Id);
						}
						else
						{							
							$("#body-mutuales").empty();
							$.each(response.data, function(index, item){
								$("#body-mutuales").append("<tr id="+item.Id+">"+
																"<td>"+item.Nombre+"</td>"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.PorcCobertura+"</td>"+
														   "</tr>");
							});
							$("#modal-mutuales").modal("show");
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
							content : "No se puede obtener la mutual especificada.",
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
});
$("#obra2").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#obra2").val() !== "")
		{
			$.ajax({
				type:"POST",
				contentType: "application/json",
				url: "api/mutuales/pornombre",
				dataType: "json",
				data: JSON.stringify({"Nombre": $("#obra2").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true) 
					{
						//no se encuentran mutuales q coincidan
					}
					else
					{
						if (response.cantidad === 1) 
						{
							$("#porc-cobertura2").text(response.data[0].PorcCobertura);
							$("#form-mutual2").prop("hidden", false);
							$("#debe-orden2").focus();							
						}
						else
						{							
							$("#body-mutuales2").empty();
							$.each(response.data, function(index, item){
								$("#body-mutuales2").append("<tr id="+item.Id+">"+
																"<td>"+item.Nombre+"</td>"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.PorcCobertura+"</td>"+
														   "</tr>");
							});
							$("#modal-mutuales2").modal("show");
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
							content : "No se puede obtener la mutual especificada.",
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
});

$("#modificar").click(function(e){		
	$("#modificar").prop("disabled", true);
	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/pacientes/modificar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error == true)
			{
				$("#modificar").prop("disabled", false);
				if (response.data === "El paciente no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido modificar dado que ya no existe.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#form-modificar").get(0).reset();
					actualizarPacientes();
					$("#form-modificar :input").prop("disabled", true);
					$("#buscar-pacientes").prop("disabled", false);						
					actualizarMedicos();
					actualizarMutuales();
					resetFormObra1();
					resetFormObra2();
				}
				if (response.data === "Número de documento de paciente repetido")
				{
					$.bigBox({
						title : "Error",
						content : "Número de documento ingresado repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#numero-doc").val("");
					$("#numero-doc").focus();
				}
				if (response.data === "Mail de paciente incorrecto")
				{
					$.bigBox({
						title : "Error",
						content : "Email de paciente incorrecto.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#email").val("");
					$("#email").focus();
				}
				if (response.data === "Mail de paciente repetido")
				{
					$.bigBox({
						title : "Error",
						content : "Email de paciente repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#email").val("");
					$("#email").focus();
				}
				if (response.data === "El médico no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido modificar. El médico elegido ya no existe.<br> Por favor, elija otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#matricula-medico").val("");
					$("#nombre-doctor").text("");
					actualizarMedicos();
				}
				if (response.data === "La mutual 1 no existe")
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido modificar. La mutual N° 1 elegida ya no existe.<br> Por favor, elija otra.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#obra1").val("");						
					actualizarMutuales();
				}
				if (response.data === "La mutual 2 no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido modificar. La mutual N° 2 elegida ya no existe.<br> Por favor, elija otra.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#obra2").val("");						
					actualizarMutuales();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El paciente se ha modificado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-modificar").get(0).reset();				
				$("#form-modificar :input").prop("disabled", true);
				$("#buscar-pacientes").prop("disabled", false);	
				$("#nombre-doctor").text("");
				$("#edad").text("Edad:");
				$("#form-campos").hide();
				resetFormObra1();
				resetFormObra2();
				resetPracticas();
			}				
		},
		error: function(error){
			$("#modificar").prop("disabled", true);
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
				arr = ["ApellidoNombre"];		
				Errores = "";
				j = 0;
				for (var i = 0; i < arr.length; i++) {
					if(j < 3){
						if (error.data.indexOf(arr[i]) > 0) 
						{
							Errores += arr[i].toString()+", ";
							j++;
						}
					}										
				};			
				Errores = Errores.replace("ApellidoNombre", "nombre y apellido del paciente");
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
	e.preventDefault();
});

$("#sin-cargo").on("change", function(){
	if ($("#sin-cargo").val() == 0) 
	{
		$("#div-realiza-descuentos").show();			
		$("#div-abono-sena").show();
	}
	else
	{
		$("#div-realiza-descuentos").hide();
		$("#div-reajuste-importe").hide();
		$("#div-abono-sena").hide();
	}
});

$("#realiza-descuentos").on("change", function(){
	if ($("#realiza-descuentos").val() == 1) 
	{
		$("#div-reajuste-importe").show();
	}
	else
	{
		$("#div-reajuste-importe").hide();
	}
});

$("#abono-sena").on("input", function(){
	if(!isNaN($("#abono-sena").val()))
	{
		$("#label-cuenta-sena").text($("#abono-sena").val());
		$("#label-saldo-pendiente").text(parseFloat(parseFloat($("#label-total").text()).toFixed(2) - parseFloat($("#label-cuenta-sena").text()).toFixed(2)).toFixed(2));
	}
});

$("#label-total").on("change", function(){
	$("#label-saldo-pendiente").text(parseFloat(parseFloat($("#label-total").text()).toFixed(2) - $("#abono-sena").val()).toFixed(2));
})

function FormToJSON(){
	var fechanac = $("#fecha-nac").val();
	if (fechanac === "")
	{					
		if ($("#edad").val() !== "")
		{
			var fecha = new Date();
			var ano = parseInt(fecha.getFullYear());			
			fechanac = ((ano-parseInt($("#edad").val()))+"-01-01");
		}
	}

	var count_celda = $("#row-practicas td").length;
	var array_celdas = $("#row-practicas td");	
	var practicas = [];
	for (var i = 0; i < count_celda; i++) 
	{				
		var practica = [];		
		var celda = array_celdas[i];		

		practica.push(celda.attributes[0].value);
		practica.push(celda.attributes[1].value);		

		practicas.push(practica);
	}
		
	return JSON.stringify({
		"IngresoId": $("#buscar-pacientes").data("value"),
		"Id": $("#nombre").data("value"),		
		"ApellidoNombre": $("#nombre").val(),			
		"FechaNacimiento": fechanac,
		"Sexo": $("#sexo").val(),
		"Origen": $("#origen").val(),
		"Cuenta": $("#cuenta").val(),
		"Cama": $("#cama").val(),
		"Direccion": $("#direccion").val(),
		"NumDocumento": $("#numero-doc").val(),
		"Telefono": $("#telefono").val(),
		"Celular": $("#celular").val(),
		"Lugar": $("#lugar").val(),
		"Mail": $("#email").val(),
		"MatriculaMedico": $("#matricula-medico").data("value"),
		"Mutual1": $("#obra1").data("value"),
		"DebeOrden1": $("#debe-orden1").val(),
		"NumAfiliado1": $("#num-afiliado1").val(),
		"TipoAfiliado1": $("#tipo-afiliado1").val(),
		"Mutual2": $("#obra2").data("value"),
		"DebeOrden2": $("#debe-orden2").val(),
		"NumAfiliado2": $("#num-afiliado2").val(),
		"TipoAfiliado2": $("#tipo-afiliado2").val(),
		"Factor": $("#factor").val().substr(0,3),
		"ActoProf": $("#acto-prof").val(),
		"Practicas": practicas,		
		"SinCargo": $("#sin-cargo").val(),			
		"RealizaDescuentos": $("#realiza-descuentos").val(),
		"ReajustaImporte": $("#reajuste-importe").val(),
		"AbonoSena": $("#abono-sena").val(),
		"Comentarios": $("#comentarios").val(),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#nombre").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#fecha-nac").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#edad").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#origen").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#cuenta").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#direccion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#numero-doc").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#telefono").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#celular").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#lugar").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#email").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#abono-sena").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

$("#numero-doc").on("input", function(){
	habilitarModificar();
});

function habilitarModificar(){
	if ($("#nombre").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#numero-doc").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#row-practicas td").length === 0)
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}