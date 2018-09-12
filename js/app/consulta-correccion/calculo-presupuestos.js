$(document).ready(function(){
	$("#nombre").focus();
});

$("#nombre").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$(document).unbind("keypress").keypress(function(key){
	if (key.which === 43 || key.which === 45) 
	{
		switch (key.which)
		{
			case 43: var suma = parseFloat(5);
				     var importe_boleta = parseFloat($("#importe-boleta").text());
					 $("#importe-boleta").text(parseFloat(parseFloat(importe_boleta) + parseFloat(suma)).toFixed(2));
					 					 
					 var importe_paciente = parseFloat($("#importe-paciente").text());					 
					 $("#importe-paciente").text(parseFloat(parseFloat(importe_paciente) + parseFloat(suma)).toFixed(2));
				break;
			case 45: var resta = parseFloat(5);
					 var importe_boleta = parseFloat($("#importe-boleta").text());
					 if ((parseFloat(importe_boleta) - parseFloat(resta)) < 0)
					 {
					 	$("#importe-paciente").text("0.00");
					 }
					 else
					 {
					 	$("#importe-boleta").text(parseFloat(parseFloat(importe_boleta) - parseFloat(resta)).toFixed(2));
					 }

					 var importe_paciente = parseFloat($("#importe-paciente").text());					 
					 if ((parseFloat(importe_paciente) - parseFloat(resta)) < 0)
					 {
					 	$("#importe-paciente").text("0.00");
					 }
					 else
					 {
					 	$("#importe-paciente").text(parseFloat(parseFloat(importe_paciente) - parseFloat(resta)).toFixed(2));
					 }
				break;
		}
		key.preventDefault();
	}
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
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron mutuales que coincidan con los datos ingresados.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
							resetFormObra1();
						}
					}
					else
					{
						if (response.cantidad === 1) 
						{
							if ($("#obra2").val() === response.data[0].Nombre+" - COD: "+response.data[0].Codigo)
							{
								$.bigBox({
									title : "Error",
									content : "La mutual elegida ya está asignada.<br>Por favor, elija otra.",
									color : "#C46A69",
									timeout: 5000,
									icon : "fa fa-warning shake animated"
								});
								resetFormObra1();
							}
							else
							{
								$("#obra1").attr("data-value", response.data[0].Id);
								$("#obra1").val(response.data[0].Nombre+" - COD: "+response.data[0].Codigo);
								$("#porc-cobertura1").val(response.data[0].PorcCobertura);
								$("#form-mutual1").prop("hidden", false);
								$("#debe-orden1").focus();
								$("#abona-apb1").val(response.data[0].AbonoAPB);
								resetPracticas();
							}
						}
						else
						{							
							$("#body-mutuales").empty();
							$.each(response.data, function(index, item){
								item.AbonoAPB == 0 ? abonoapb = "No" : abonoapb = "Sí";
								$("#body-mutuales").append("<tr id="+item.Id+">"+
																"<td>"+item.Nombre+"</td>"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.PorcCobertura+"</td>"+
																"<td>"+abonoapb+"</td>"+
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
							content : "No se puede obtener la mutual.",
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

$("#obra1").on("input", function(){
	if ($("#obra1").val() === "")
	{
		$("#obra1").attr("data-value", "");
		resetFormObra1();
		resetPracticas();
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
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron mutuales que coincidan con los datos ingresados.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
							resetFormObra2();
						}
					}
					else
					{
						if (response.cantidad === 1) 
						{
							if ($("#obra1").val() === response.data[0].Nombre+" - COD: "+response.data[0].Codigo)
							{
								$.bigBox({
									title : "Error",
									content : "La mutual elegida ya está asignada.<br>Por favor, elija otra.",
									color : "#C46A69",
									timeout: 5000,
									icon : "fa fa-warning shake animated"
								});
								resetFormObra2();
							}
							else
							{
								$("#obra2").attr("data-value", response.data[0].Id);
								$("#obra2").val(response.data[0].Nombre+" - COD: "+response.data[0].Codigo);
								$("#porc-cobertura2").val(response.data[0].PorcCobertura);
								$("#form-mutual2").prop("hidden", false);
								$("#debe-orden2").focus();
								$("#abona-apb2").val(response.data[0].AbonoAPB);
							}
						}
						else
						{							
							$("#body-mutuales2").empty();
							$.each(response.data, function(index, item){
								item.AbonoAPB == 0 ? abonoapb = "No" : abonoabp = "Sí";
								$("#body-mutuales2").append("<tr id="+item.Id+">"+
																"<td>"+item.Nombre+"</td>"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.PorcCobertura+"</td>"+
																"<td>"+abonoapb+"</td>"+
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
							content : "No se puede obtener la mutual.",
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

$("#obra2").on("input", function(){
	if ($("#obra2").val() === "")
	{
		$("#obra2").attr("data-value", "");
		resetFormObra2();
	}
});

function resetPracticas(){
	$("#row-practicas").empty();
	$("#practica").val("");
	$("#practica").prop("disabled", false);
	$("#practica").attr("data-id", "");
	$("#practica").attr("data-tipo", "");
	$("#span-nomen-trabajo").hide();
	$("#span-nomen-especial").hide();
	$("#costo-parcial").hide();
	$("#costo-parcial").text("");
	$("#span-costo").hide();
	$("#span-codigo-nomen").hide();	
	$("#importe-boleta").text("0.00");
	$("#importe-mutual1").text("0.00");
	$("#importe-mutual2").text("0.00");
	$("#importe-paciente").text("0.00");
	$("#importe-apb").text("0.00");
	$("#total").text("0.00");
}

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
		fila.cells[3].innerText == "No" ? abonoapb = 0 : abonoapb = 1;
		$("#abona-apb1").val(abonoapb);
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
		fila.cells[3].innerText == "No" ? abonoapb = 0 : abonoapb = 1;
		$("#abona-apb1").val(abonoapb);

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

						if(count_celda == 0)
						{
							$("#abona-apb1").val() == 0 ? $("#importe-apb").text(parseFloat(response.valores[0].ActoProfesionalBioquimico).toFixed(2)) : "";
						}

						var parcial = parseFloat($("#costo-parcial").text());
						var boleta = parseFloat($("#importe-boleta").text());
						var paciente = parseFloat($("#importe-paciente").text());
						var mutual1 = parseFloat($("#importe-mutual1").text());
						var mutual2 = parseFloat($("#importe-mutual2").text());
						var apb = parseFloat($("#importe-apb").text());
						var total = parseFloat($("#total").text());

						$("#importe-boleta").text(parseFloat(parcial+boleta).toFixed(2));

						if ($("#obra1").data("value"))
						{							
							$("#importe-mutual1").text(parseFloat(parseFloat(mutual1) + (parseFloat((parcial * parseInt($("#porc-cobertura1").val())) / 100))).toFixed(2));
						}

						$("#importe-paciente").text(parseFloat(parseFloat($("#importe-boleta").text()) - parseFloat($("#importe-mutual1").text())).toFixed(2));

						$("#total").text(parseFloat(parseFloat($("#importe-paciente").text()) + parseFloat($("#importe-apb").text())).toFixed(2));

						$("#span-nomen-trabajo").hide();
						$("#span-nomen-especial").hide();
						$("#costo-parcial").hide();
						$("#span-costo").hide();
						$("#span-costo").text("");
						$("#span-codigo-nomen").hide();
						
						var td = "<td id=\""+$("#practica").attr("data-id")+"\">"+codigo[1]+"</td>";

						$("#practica").attr("data-id", "");
						$("#practica").attr("data-tipo", "");
						$("#row-practicas").append(td);
						$("#practica").val("");
						$("#practica").focus();

						habilitarImprimir();
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

$("#finalizar").click(function(e){
	$("#practica").prop("disabled", true);
	$("#finalizar").prop("disabled", true);
	$("#span-nomen-trabajo").hide();
	$("#span-nomen-especial").hide();
	$("#costo-parcial").hide();
	$("#span-costo").hide();
	$("#span-codigo-nomen").hide();
	$("#practica").val("");
	$("#div-final").show();
	e.preventDefault();
});

function resetFormObra1(){
	$("#obra1").val("");
	$("#form-mutual1").prop("hidden", true);
	$("#debe-orden1").prop("selectedIndex", "");
	$("#num-afiliado1").val("");
	$("#tipo-afiliado1").prop("selectedIndex", "");
	$("#porc-cobertura1").val("");
	$("#obra1").prop("data-value", "");
}

function resetFormObra2(){
	$("#obra2").val("");
	$("#form-mutual2").prop("hidden", true);
	$("#debe-orden2").prop("selectedIndex", "");
	$("#num-afiliado2").val("");
	$("#tipo-afiliado2").prop("selectedIndex", "");
	$("#porc-cobertura2").val("");
	$("#obra2").prop("data-value", "");
}

$("#imprimir").click(function(e){
	var practicas = $("#row-practicas td").length;

	if (practicas > 0)
	{
		$("#input-importe-boleta").val($("#importe-boleta").text());
		$("#input-importe-mutual1").val($("#importe-mutual1").text());
		$("#input-importe-mutual2").val($("#importe-mutual2").text());
		$("#input-importe-paciente").val($("#importe-paciente").text());
		$("#input-importe-apb").val($("#importe-apb").text());
		$("#input-total").val($("#total").text());
		$("#row-practicas td")[0] ? $("#input-p1").val($("#row-practicas td")[0].innerText) : "";
		$("#row-practicas td")[1] ? $("#input-p2").val($("#row-practicas td")[1].innerText) : "";
		$("#row-practicas td")[2] ? $("#input-p3").val($("#row-practicas td")[2].innerText) : "";
		$("#row-practicas td")[3] ? $("#input-p4").val($("#row-practicas td")[3].innerText) : "";
		$("#row-practicas td")[4] ? $("#input-p5").val($("#row-practicas td")[4].innerText) : "";
		$("#row-practicas td")[5] ? $("#input-p6").val($("#row-practicas td")[5].innerText) : "";
		$("#row-practicas td")[6] ? $("#input-p7").val($("#row-practicas td")[6].innerText) : "";
		$("#row-practicas td")[7] ? $("#input-p8").val($("#row-practicas td")[7].innerText) : "";
		$("#row-practicas td")[8] ? $("#input-p9").val($("#row-practicas td")[8].innerText) : "";
		$("#row-practicas td")[9] ? $("#input-p10").val($("#row-practicas td")[9].innerText) : "";
		$("#row-practicas td")[10] ? $("#input-p11").val($("#row-practicas td")[10].innerText) : "";
		$("#row-practicas td")[11] ? $("#input-p12").val($("#row-practicas td")[11].innerText) : "";
		$("#row-practicas td")[12] ? $("#input-p13").val($("#row-practicas td")[12].innerText) : "";
		$("#row-practicas td")[13] ? $("#input-p14").val($("#row-practicas td")[13].innerText) : "";
		$("#row-practicas td")[14] ? $("#input-p15").val($("#row-practicas td")[14].innerText) : "";
		$("#row-practicas td")[15] ? $("#input-p16").val($("#row-practicas td")[15].innerText) : "";
		$("#row-practicas td")[16] ? $("#input-p17").val($("#row-practicas td")[16].innerText) : "";
		$("#row-practicas td")[17] ? $("#input-p18").val($("#row-practicas td")[17].innerText) : "";
		$("#row-practicas td")[18] ? $("#input-p19").val($("#row-practicas td")[18].innerText) : "";
		$("#row-practicas td")[19] ? $("#input-p20").val($("#row-practicas td")[19].innerText) : "";
		$("#porc-cobertura1").prop("disabled", false);
		$("#abona-apb1").prop("disabled", false);
		$("#porc-cobertura2").prop("disabled", false);
		$("#abona-apb2").prop("disabled", false);
		$("#form-calculo-presupuesto").submit();
		resetPracticas();
		resetFormObra1();
		resetFormObra2();
		$("#porc-cobertura1").prop("disabled", true);
		$("#abona-apb1").prop("disabled", true);
		$("#porc-cobertura2").prop("disabled", true);
		$("#abona-apb2").prop("disabled", true);
		$("#row-practicas").empty();
		$("#form-calculo-presupuesto").get(0).reset();
		$("#imprimir").prop("disabled", true);
	}
	else
	{
		$.bigBox({
			title : "Error",
			content : "No se puede generar un presupuesto sin prácticas a realizar. Por favor, ingrese al menos una.",
			color : "#C46A69",
			timeout: 8000,
			icon : "fa fa-warning shake animated"
		});
	}
	e.preventDefault();
});

$("#nombre").on("input", function(){
	habilitarImprimir();
});

$("#obra1").on("input", function(){
	habilitarImprimir();
});

$("#factor").on("input", function(){
	habilitarImprimir();
});

function habilitarImprimir(){
	if ($("#nombre").val() === "")
	{
		$("#imprimir").prop("disabled", true);
		return;
	}
	if ($("#obra1").val() === "")
	{
		$("#imprimir").prop("disabled", true);
		return;
	}
	if ($("#factor").val() === "")
	{
		$("#imprimir").prop("disabled", true);
		return;
	}
	if ($("#row-practicas td").length === 0)
	{
		$("#imprimir").prop("disabled", true);
		return;
	}
	$("#imprimir").prop("disabled", false);
}