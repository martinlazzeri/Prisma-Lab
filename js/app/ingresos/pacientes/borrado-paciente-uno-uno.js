$(document).ready(function(){
	$("#buscar-pacientes").focus();
});

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

function resetPracticas(){
	$("#row-practicas").empty();		
	$("#label-total").text("0.00");
	$("#label-cuenta-sena").text("");
	$("#label-saldo-pendiente").text("");
	$("#div-final").hide();
	$("#sin-cargo").prop("selectedIndex", "");
	$("#abono-sena").val("");
	$("#realiza-descuentos").prop("selectedIndex", "");
	$("#reajuste-importe").prop("selectedIndex", "");
	$("#label-cuenta-sena").text("");
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
								$("#eliminar").prop("disabled", false);

								if (response.data[0].IngresosPractica) 
								{
									$.each(response.data[0].IngresosPractica, function(index, item){
										item.EsNomencladorTrabajo == 1 ? nomentrabajo = 0 : nomentrabajo = 1;
										$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+nomentrabajo+"\">"+item.PracticaCodigo+"</td>");
										$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
										calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo);
									});
								}
								$("#div-final").show();
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
								$("#eliminar").prop("disabled", false);

								if (response.data[0].IngresosPractica) 
								{
									$.each(response.data[0].IngresosPractica, function(index, item){
										item.EsNomencladorTrabajo == 1 ? nomentrabajo = 0 : nomentrabajo = 1;
										$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+nomentrabajo+"\">"+item.PracticaCodigo+"</td>");
										$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
										calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo);
									});	
								}		
								$("#div-final").show();
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
				$("#eliminar").prop("disabled", false);				

				if (response.data[0].IngresosPractica) 
				{
					$.each(response.data[0].IngresosPractica, function(index, item){
						item.EsNomencladorTrabajo == 1 ? nomentrabajo = 0 : nomentrabajo = 1;
						$("#row-practicas").append("<td data-ingresop=\""+item.IngresoPracticaId+"\" data-nomencladorid=\""+item.NomencladorId+"\" data-tipo=\""+nomentrabajo+"\">"+item.PracticaCodigo+"</td>");
						$("#row-borrado").append("<td><button type=\"button\" class=\"fa fa-times\" onclick=\"borrarPractica("+ index +");\"></button></td>");
						calcularCostoPractica(item.NomencladorId, item.EsNomencladorTrabajo);
					});	
				}
				$("#div-final").show();
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

function calcularCostoPractica(id, tipoNomenclador){
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
				var costo_parcial = 0.00;
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
						costo_parcial = (valorugasto * coefugasto * categoria) + (valoruhono * coefuhono * categoria);						
					}
					if (valora !== null && valorb !== null && valorc !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial FABA					
						switch (codigo)
						{
							case "A": costo_parcial = parseFloat(valora * nivel);
									break;
							case "B": costo_parcial = parseFloat(valorb * nivel);
									break;
							case "C":costo_parcial = parseFloat(valorc * nivel);
									break;
						}
					}
					if (valornbu !== null && codigo !== null && nivel !== null) 
					{
						//calculo costo para nomenclador especial NBU
						costo_parcial = parseFloat(valornbu * nivel);
					}
				}

				if (response.tipoNomen == 1) //nomenclador de trabajo
				{
					response.nomencladores[0].UGastos == null ? ugasto = null : ugasto = response.nomencladores[0].UGastos;
					response.nomencladores[0].UHonorarios == null ? uhono = null : uhono = response.nomencladores[0].UHonorarios;

					costo_parcial = parseFloat((ugasto * valorugasto) + (uhono * valoruhono));
				}				

				var total = parseFloat($("#label-total").text());

				total += costo_parcial;

				$("#label-total").text(parseFloat(total).toFixed(2));
				
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

$("#fecha-nac").blur(function(){
	var date_end = new Date();
    var date_start = new Date($("#fecha-nac").val());                
	var total_años = Math.floor((date_end - date_start) / (1000 * 60 * 60 * 24 * 365));			
	if (!isNaN(total_años))
	{
		if (total_años < 0) 
		{
			$("#edad").text("Edad:");
			$("#fecha-nac").val("");
		}
		else
		{
			$("#edad").text("Edad: "+ total_años + " años");
		}			
	}
	else
	{
		$("#edad").text("Edad:");
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	$.ajax({
		type: "DELETE",
		contentType: "application/json",
		url: "api/pacientes/eliminar",
		dataType: "json",
		data: FormToJSON(),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true) 
			{
				$("#eliminar").prop("disabled", false);
				if (response.data === "El paciente no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente elegido ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El paciente se ha eliminado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-borrado").get(0).reset();				
				$("#acto-prof").prop("selectedIndex", "");
				resetFormObra1();
				resetFormObra2();
				resetPracticas();
				$("#form-campos").hide();
				$("#edad").text("Edad:");
				$("#eliminar").prop("disabled", true);
				$("#fecha-nac").blur();
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
					content : "No se pudo eliminar el paciente.",
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
		"IngresoId": $("#buscar-pacientes").data("value"),
		"PacienteId": $("#nombre").data("value"),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}