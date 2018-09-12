$(document).ready(function(){
	$("#num-paciente").val(Numero_Paciente());
	resetFormMedico();
	resetPracticas();
	actualizarNomencladores();		
});

$("#num-paciente").css("color", "red");
$("#num-paciente").css("font-weight", "bold");

$("#num-paciente").on("input", function(){
	var longitud = $("#num-paciente").val().length;
	var numero = $("#num-paciente").val();

	switch (longitud)
	{
		case 3: var ano = numero.substr(0, 1);
				var mes = numero.substr(1, 2);
				if (mes > 12 || mes <= 0)
				{
					$.bigBox({
						title : "Error",
						content : "El número de mes no puede ser mayor a 12.",
						color : "#C46A69",
						timeout: 3000,
						icon : "fa fa-warning shake animated"
					});
					$("#num-paciente").val(ano+"01");
				}
			break;
		case 5: var ano = numero.substr(0, 1);
				var mes = numero.substr(1, 2);
				var dia = numero.substr(3, 2);
				console.log(ano+' '+mes+' '+dia);
				if (mes > 12 || mes <= 0)
				{
					$.bigBox({
						title : "Error",
						content : "El número de mes no puede ser mayor a 12.",
						color : "#C46A69",
						timeout: 3000,
						icon : "fa fa-warning shake animated"
					});
					$("#num-paciente").val(ano+"01");
					return;
				}
				if (dia <= 0 || dia > 31)
				{
					$.bigBox({
						title : "Error",
						content : "El día de mes no puede ser mayor a 31.",
						color : "#C46A69",
						timeout: 3000,
						icon : "fa fa-warning shake animated"
					});
					$("#num-paciente").val(ano+mes+"01");
				}
			break;
		case 8: var ano = numero.substr(0, 1);
				var mes = numero.substr(1, 2);
				var dia = numero.substr(3, 2);
				var num = numero.substr(-3);
				console.log(ano+' '+mes+' '+dia+' '+num);
				if (mes > 12 || mes <= 0)
				{
					$.bigBox({
						title : "Error",
						content : "El número de mes no puede ser mayor a 12.",
						color : "#C46A69",
						timeout: 3000,
						icon : "fa fa-warning shake animated"
					});
					$("#num-paciente").val(ano+"01");
					return;
				}
				if (dia <= 0 || dia > 31)
				{
					$.bigBox({
						title : "Error",
						content : "El día de mes no puede ser mayor a 31.",
						color : "#C46A69",
						timeout: 3000,
						icon : "fa fa-warning shake animated"
					});
					$("#num-paciente").val(ano+mes+"01");
				}
			break;
	}
});

$(document).unbind("keydown").keydown(function(key){
	if (key.which === 112)
	{
		key.preventDefault();				
		actualizarPacientes("key down");
		$("#modal-pacientes").modal("show");			
	}			
});

$("#seleccionar-paciente").click(function(e){
	if ($(".modal-body #buscar-paciente").val() !== "" && $("#modal_pacientes_list [value="+$(".modal-body #buscar-paciente").val()+"]").data("value") !== undefined) 
	{
		seleccionarPaciente($("#modal_pacientes_list [value="+$(".modal-body #buscar-paciente").val()+"]").data("value"));
	}		
	e.preventDefault();
});

$(".modal-body #buscar-paciente").keypress(function(key){
	if (key.which === 13) 
	{
		if ($(".modal-body #buscar-paciente").val() !== "" && $("#modal_pacientes_list [value="+$(".modal-body #buscar-paciente").val()+"]").data("value") !== undefined) 
		{
			seleccionarPaciente($("#modal_pacientes_list [value="+$(".modal-body #buscar-paciente").val()+"]").data("value"));
		}
		key.preventDefault();			
	}
});

$("#nombre").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#nombre").val() !== "")
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/pacientes/pornombre",
				dataType: "json",
				data: JSON.stringify({"ApellidoNombre": $("#nombre").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true) 
					{
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron pacientes para los datos ingresados.",
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
							$("#nombre").attr("data-value", response.data[0].Id);
							$("#nombre").val(response.data[0].ApellidoNombre);
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
							$("#matricula").val("");
							$("#matricula").blur();
							$("#obra1").val(response.data[0].NombreMutual1+" - COD: "+response.data[0].CodMutual1);
							if (response.data[0].NombreMutual1 !== null)
							{
								$("#obra1").attr("data-value", response.data[0].Mutual1Id)
								$("#form-mutual1").prop("hidden", false);
								$("#debe-orden1").val(response.data[0].DebeOrden1);
								$("#num-afiliado1").val(response.data[0].NumAfiliado1);
								$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
								$("#porc-cobertura1").val(response.data[0].PorcCobertura1);
							}
							else
							{
								$("#obra1").val("");
								resetFormObra1();
							}
							$("#obra2").val(response.data[0].NombreMutual2+" - COD: "+response.data[0].CodMutual2);
							if (response.data[0].NombreMutual2 !== null)
							{
								$("#form-mutual2").prop("hidden", false);
								$("#debe-orden2").val(response.data[0].DebeOrden2);
								$("#num-afiliado2").val(response.data[0].NumAfiliado2);
								$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
								$("#porc-cobertura2").val(response.data[0].PorcCobertura2);
							}
							else
							{
								$("#obra2").val("");
								resetFormObra2();
							}
							$("#factor").val(response.data[0].Factor);
							$("#acto-prof").val(response.data[0].ActoProf);
						}
						else
						{								
							$("#body-pacientes").empty();
							$.each(response.data, function(index, item){
								item.NumDocumento == null ? doc = "No especifica" : doc = item.NumDocumento
								$("#body-pacientes").append("<tr id="+item.Id+">"+
																"<td class=\"col-md-3\">"+item.ApellidoNombre+"</td>"+
																"<td class=\"col-md-2\">"+doc+"</td>"+
															"</tr>");
							});								
							$("#modal-pacientes-por-apellido").modal("show");
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
							content : "No se puede obtener el paciente especificado.",
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

$("#body-pacientes").unbind("click").click(function(e){
	$("#nombre").attr("data-value", e.target.parentElement.id);
	seleccionarPaciente(e.target.parentElement.id);	
});

$("#body-pacientes-dni").unbind("click").on("click", function(e){	
	$("#nombre").attr("data-value", e.target.parentElement.id);
	seleccionarPaciente(e.target.parentElement.id);
});

$("#body-medicos").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	$("#matricula").attr("data-value", fila.id);
	$("#matricula").val(fila.cells[0].innerText+" - MAT: "+fila.cells[1].innerText);
	$("#modal-medicos").modal("hide");
	$("#matricula").focus();
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
})

$("#seleccionar-paciente-apellido").click(function(e){
	if ($("#buscar-paciente-apellido").val() !== "" && $("#modal_pacientes_list_apellido [value="+$("#buscar-paciente-apellido").val()+"]").data("value") !== undefined)
	{
		seleccionarPaciente($("#modal_pacientes_list_apellido [value="+$("#buscar-paciente-apellido").val()+"]").data("value"));
	}		
	e.preventDefault();
});

$("#buscar-paciente-apellido").keypress(function(key){
	if (key.which === 13) 
	{
		if ($("#buscar-paciente-apellido").val() !== "" && $("#modal_pacientes_list_apellido [value="+$("#buscar-paciente-apellido").val()+"]").data("value") !== undefined) 
		{
			seleccionarPaciente($("#modal_pacientes_list_apellido [value="+$("#buscar-paciente-apellido").val()+"]").data("value"));
		}
		key.preventDefault();			
	}
});

function seleccionarPaciente(id){		
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/pacientes/"+id,
		dataType: "json",
		headers: {"Authorization": $.cookie("ApiKey")},				
		success: function(response){
			if (response.error === true) 
			{
				if (response.data === "No se han encontrado datos para un paciente en particular") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente elegido, ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
				actualizarPacientes("seleccionar paciente");
			}
			else
			{						
				$("#nombre").val(response.data[0].ApellidoNombre);
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
				$("#matricula").val("");
				$("#matricula").blur();
				$("#obra1").val(response.data[0].NombreMutual1+" - COD: "+response.data[0].CodMutual1);
				if (response.data[0].NombreMutual1 !== null)
				{
					$("#obra1").attr("data-value", response.data[0].Mutual1Id);
					$("#form-mutual1").prop("hidden", false);
					$("#debe-orden1").val(response.data[0].DebeOrden1);
					$("#num-afiliado1").val(response.data[0].NumAfiliado1);
					$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
					$("#porc-cobertura1").val(response.data[0].PorcCobertura1);
				}
				else
				{
					$("#obra1").val("");
					resetFormObra1();
				}
				$("#obra2").val(response.data[0].NombreMutual2+" - COD: "+response.data[0].CodMutual2);
				if (response.data[0].NombreMutual2 !== null)
				{
					$("#form-mutual2").prop("hidden", false);
					$("#debe-orden2").val(response.data[0].DebeOrden2);
					$("#num-afiliado2").val(response.data[0].NumAfiliado2);
					$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
					$("#porc-cobertura2").val(response.data[0].PorcCobertura2);
				}
				else
				{
					$("#obra2").val("");
					resetFormObra2();
				}
				$("#factor").val(response.data[0].Factor);
				$("#acto-prof").val(response.data[0].ActoProf);
				$("#modal-pacientes").modal("hide");
				$("#modal-pacientes-por-apellido").modal("hide");
				$("#modal-pacientes-por-dni").modal("hide");
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
					content : "No se puede obtener el paciente especificado.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}	

$("#numero-doc").on("keypress", function(key){
	if (key.which === 13)
	{
		key.preventDefault();
		if ($("#numero-doc").val() !== "")
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/pacientes/pordocumento",
				dataType: "json",
				data: JSON.stringify({"NumDocumento": $("#numero-doc").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true) 
					{
						if (response.data === "No se encontraron datos") 
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron pacientes para los datos ingresados.",
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
							$("#nombre").val(response.data[0].ApellidoNombre);
							$("#nombre").data("value") = response.data[0].Id;
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
							$("#matricula").val("");
							$("#matricula").blur();
							$("#obra1").val(response.data[0].NombreMutual1+" - COD: "+response.data[0].CodMutual1);
							if (response.data[0].NombreMutual1 !== null)
							{
								$("#obra1").attr("data-value", response.data[0].Mutual1Id);
								$("#form-mutual1").prop("hidden", false);
								$("#debe-orden1").val(response.data[0].DebeOrden1);
								$("#num-afiliado1").val(response.data[0].NumAfiliado1);
								$("#tipo-afiliado1").val(response.data[0].TipoAfiliado1);
								$("#porc-cobertura1").val(response.data[0].PorcCobertura1);
							}
							else
							{
								$("#obra1").val("");
								resetFormObra1();
							}
							$("#obra2").val(response.data[0].NombreMutual2+" - COD: "+response.data[0].CodMutual2);
							if (response.data[0].NombreMutual2 !== null)
							{
								$("#obra2").attr("data-value", response.data[0].Mutual2Id);
								$("#form-mutual2").prop("hidden", false);
								$("#debe-orden2").val(response.data[0].DebeOrden2);
								$("#num-afiliado2").val(response.data[0].NumAfiliado2);
								$("#tipo-afiliado2").val(response.data[0].TipoAfiliado2);
								$("#porc-cobertura2").val(response.data[0].PorcCobertura2);
							}
							else
							{
								$("#obra2").val("");
								resetFormObra2();
							}
							$("#factor").val(response.data[0].Factor);
							$("#acto-prof").val(response.data[0].ActoProf);
							$("#modal-pacientes").modal("hide");
							$("#modal-pacientes-por-apellido").modal("hide");
						}
						else
						{
							$("#body-pacientes-dni").empty();
							$.each(response.data, function(index, item){
								$("#body-pacientes-dni").append("<tr id="+item.Id+">"+
																	"<td>"+item.ApellidoNombre+"</td>"+
																	"<td>"+item.NumDocumento+"</td>"+
																"</tr>");
							});

							$("#modal-pacientes-por-dni").modal("show");
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
							content : "No se puede obtener el paciente especificado.",
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

$("#confirmar-agregar-medico").click(function(e){
	$("#confirmar-agregar-medico").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/medicos/crear",
		dataType: "json",
		data: FormToJSON_Medico(),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "Matrícula repetida")
				{
					$.bigBox({
						title : "Error",
						content : "La matrícula ingresada ya existe.<br>Por favor, ingrese otra.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					$(".modal-body #matricula").val("");
					$(".modal-body #Matricula").focus();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El médico se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				resetFormMedico();
				$("#modal-alta-medico").modal("hide");
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
				arr = ["Matricula", "TipoMatricula", "AbonoDomicilio", "Nombre", "Apellido"];
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
	$("#confirmar-agregar-medico").prop("disabled", false);
	e.preventDefault()		
});

function FormToJSON_Medico(){
	return JSON.stringify({
		"Matricula": $(".modal-body #matricula").val(),
	  	"TipoMatricula": $(".modal-body #tipo-matricula").val(),
	  	"Nombre": $(".modal-body #nombre-med").val(),
	  	"Apellido": $(".modal-body #apellido-med").val(),
	  	"CreadoPor": $.cookie("NombreUsuario")
	});
}

function resetFormMedico(){
	$(".modal-body #matricula").val("");
	$(".modal-body #tipo-matricula").prop("selectedIndex", "");
	$(".modal-body #apellido-med").val("");
	$(".modal-body #nombre-med").val("");
}

$("#matricula").keypress(function(k){
	if (k.which === 13) 
	{
		if ($("#matricula").val() !== "") 
		{
			if (isNaN($("#matricula").val())) 
			{				
				$.ajax({
					type: "POST",
					contentType: "application/json",
					url: "api/medicos/porapellido",
					dataType: "json",
					data: JSON.stringify({"Apellido": $("#matricula").val()}),
					headers: {"Authorization": $.cookie("ApiKey")},
					success: function(response){
						if (response.error === true)
						{
							if (response.data === "No se encontraron datos") 
							{
								$.bigBox({
									title : "Error",
									content : "No se encontraron médicos que coincidan con los datos ingresados.",
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
								$("#matricula").val(response.data[0].Apellido+" "+response.data[0].Nombre+" - MAT: "+response.data[0].Matricula);
								$("#matricula").attr("data-value", response.data[0].Id);
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
					data: JSON.stringify({"Matricula": $("#matricula").val()}),
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
								$("#matricula").val(response.data[0].Apellido+" "+response.data[0].Nombre+" - MAT: "+response.data[0].Matricula);
								$("#matricula").attr("data-value", response.data[0].Id);
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
		k.preventDefault();
	}
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
						
						var td = "<td id=\""+$("#practica").attr("data-id")+"\">"+codigo[1]+"</td>";

						$("#practica").attr("data-id", "");
						$("#practica").attr("data-tipo", "");
						$("#row-practicas").append(td);
						$("#practica").val("");
						$("#practica").focus();

						habilitarGrabar();
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

function actualizarPacientes(origin){	
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/pacientes",
		dataType: "json",
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if(response.error == true)
			{
				$.bigBox({
					title : "Error",
					content : "No se pueden obtener los pacientes.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{					
				$("#modal_pacientes_list").empty();				
				$.each(response.data, function(index, item){
					$("#modal_pacientes_list").append("<option data-value=\""+item.Id+"\" value=\""+item.ApellidoNombre+"\"></option>");					
				});					
			}
		},
		error: function(error){
			$.bigBox({
				title : "Error",
				content : "No se pueden obtener los pacientes.",
				color : "#C46A69",
				timeout: 5000,
				icon : "fa fa-warning shake animated"
			});
		}
	});
}

$("#agregar-medico").click(function(e){
	$("#modal-alta-medico").modal("show");
	e.preventDefault();
});

function actualizarNomencladores(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladores",
		dataType: "json",
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if(response.error == true)
			{
				$.bigBox({
					title : "Error",
					content : "No se pueden obtener las prácticas.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{
				$("#practicas").empty();					
				$.each(response.data, function(index, item){						
					$("#practicas").append("<option data-index='0' data-ugasto=\""+item.UGastos+"\" data-uhono=\""+item.UHonorarios+"\" data-valor-gastos=\""+response.valores[0].UGastos+"\" data-valor-hono=\""+response.valores[0].UHonorarios+"\" data-value=\""+item.Id+"\" value=\""+item.Codigo+" - "+item.Nombre+"\"></option>");
				});						
			}
		},

		error: function(error){
			$.bigBox({
				title : "Error",
				content : "No se pueden obtener las prácticas.",
				color : "#C46A69",
				timeout: 5000,
				icon : "fa fa-warning shake animated"
			});
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
	$("#div-final").hide();
	$("#ingresar").prop("disabled", true);
}

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
								resetPracticas();
							}
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
							}
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

				}
			});
		}
		key.preventDefault();
	}
});

$("#obra2").change(function(){
	if ($("#obra2").val() === "")
	{
		resetFormObra2();		
	}
});

$("#obra2").blur(function(){
	if ($("#obra2").val() === "")
	{
		resetFormObra2();
	}
});	

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/pacientes/crear",
		dataType: "json",
		data: FormToJSON(),
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error == true) 
			{					
				if (response.data == "Email incorrecto") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. Verifique que el Email esté bien escrito.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
				if (response.data == "Email repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El email está repetido, por favor ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
				if (response.data == "Número de documento repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El número de documento que ha ingresado está repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
				if (response.data == "El médico no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El médico elegido ya no existe.<br> Por favor, elija otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#matricula").val("");					
				}
				if (response.data == "La mutual 1 no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. La mutual N° 1 elegida ya no existe.<br> Por favor, elija otra.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#mutual1").val("");
				}
				if (response.data == "La mutual 2 no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. La mutual N° 2 elegida ya no existe.<br> Por favor, elija otra.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#mutual2").val("");
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El paciente se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-pacientes").get(0).reset();
				$("#num-paciente").val(Numero_Paciente());
				actualizarPacientes("ingresar");				
				actualizarNomencladores();
				resetPracticas();
				resetFormObra1();
				resetFormObra2();
				$("#finalizar").prop("disabled", false);
				$("#nombre").prop("data-value", "");
				$("#matricula").prop("data-value", "");
				$("#div-final").hide();
				$("#nombre").focus();				
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
				arr = ["ApellidoNombre"];		
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
	$("#ingresar").prop("disabled", false);
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

function FormToJSON(){
	var id = $("#nombre").data("value");
	if (id === "" || id === null || id === undefined)
	{
		id = null;
	}
	var fechanac = $("#fecha-nac").val();
	if (fechanac === "")
	{					
		if ($("#edad").val() !== "")
		{
			var fecha = new Date();
			var ano = parseInt(fecha.getFullYear());			
			fechanac = ((ano - parseInt( $("#edad").val() )) + "-01-01");
		}
	}
	$("#telefono").val() === "" ? telefono = null : null;
	$("#telefono").val() === 0 ? telefono = null : null;

	var count_celda = $("#row-practicas td").length;
	var array_celdas = $("#row-practicas td");
	var practicas = [];
	for (var i = 0; i < count_celda; i++) 
	{						
		var celda = array_celdas[i];
		practicas.push(celda.id);
	}
	
	return JSON.stringify({
		"Id": id,
		"NumPaciente": $("#num-paciente").val(),
		"ApellidoNombre": $("#nombre").val(),			
		"FechaNacimiento": fechanac,
		"Sexo": $("#sexo").val(),
		"Origen": $("#origen").val().substr(0, 50),
		"Cuenta": $("#cuenta").val().substr(0, 4),
		"Cama": $("#cama").val(),
		"Direccion": $("#direccion").val().substr(0, 50),
		"NumDocumento": $("#numero-doc").val(),
		"Telefono": telefono,
		"Celular": $("#celular").val().substr(0, 50),
		"Lugar": $("#lugar").val().substr(0, 50),
		"Mail": $("#email").val().substr(0, 100),
		"MatriculaMedico": $("#matricula").data("value"),
		"Mutual1": $("#obra1").data("value"),
		"DebeOrden1": $("#debe-orden1").val(),
		"NumAfiliado1": $("#num-afiliado1").val().substr(0, 20),
		"TipoAfiliado1": $("#tipo-afiliado1").val(),
		"Mutual2": $("#obra2").data("value"),
		"DebeOrden2": $("#debe-orden2").val(),
		"NumAfiliado2": $("#num-afiliado2").val().substr(0, 20),
		"TipoAfiliado2": $("#tipo-afiliado2").val(),
		"Factor": $("#factor").val().substr(0, 3),
		"ActoProf": $("#acto-prof").val(),
		"Practicas": practicas,
		"CreadoEn": "0",
		"SinCargo": $("#sin-cargo").val(),			
		"RealizaDescuentos": $("#realiza-descuentos").val(),
		"ReajustaImporte": $("#reajuste-importe").val(),
		"AbonoSena": $("#abono-sena").val(),
		"Comentarios": $("#comentarios").val(),
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

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

$("#cama").keypress(function(key){
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

$("#factor").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nombre").on("input", function(){
	habilitarGrabar();
});

$("#numero-doc").on("input", function(){
	habilitarGrabar();
});

function habilitarGrabar(){
	if ($("#nombre").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#numero-doc").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#row-practicas td").length === 0)
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}

function Numero_Paciente(){
	var hoy = new Date(); 
	var ano = hoy.getFullYear().toString().substr(3);
	var mes = hoy.getMonth();
	mes = parseInt(mes) + 1;
	mes = ("0" + (mes).toString()).substr(-2);
	var dia = ("0" + hoy.getDate()).substr(-2);
	prefijoNumPaciente = (ano + mes + dia);
	return prefijoNumPaciente;
}

$("#num-paciente").blur(function(){				
	if ($("#num-paciente").val().length == 8) 
	{
		$.ajax({
			type: "GET",
			contentType: "application/json",
			url: "api/pacientes/numpaciente/"+$("#num-paciente").val(),
			dataType: "json",
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error == true)
				{
					if (response.data == "Número de paciente incorrecto.")
					{
						$.bigBox({
							title : "Error",
							content : "El número de paciente es incorrecto.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
						$("#form-pacientes :input").prop("disabled", true);
						$("#num-paciente").prop("disabled", false);
						$("#num-paciente").val(Numero_Paciente());							
					}
					if (response.data == "Número de paciente ocupado.")
					{
						$.bigBox({
							title : "Error",
							content : "El número de paciente está ocupado.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
						$("#form-pacientes :input").prop("disabled", true);
						$("#num-paciente").prop("disabled", false);
						$("#num-paciente").val(Numero_Paciente());							
					}
				}
				else
				{
					$("#form-pacientes :input").prop("disabled", false);	
					$("#nombre-doctor").prop("disabled", true);
					$("#nombre").focus();
				}
			},
			error: function(error){
				$.bigBox({
					title : "Error",
					content : "El número de paciente es incorrecto.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
				$("#form-pacientes :input").prop("disabled", true);
				$("#num-paciente").prop("disabled", false);
				$("#num-paciente").val(Numero_Paciente());										
			}
		});
	}
	else
	{
		$.bigBox({
			title : "Error",
			content : "El número de paciente es incorrecto.",
			color : "#C46A69",
			timeout: 5000,
			icon : "fa fa-warning shake animated"
		});
		$("#form-pacientes :input").prop("disabled", true);
		$("#num-paciente").prop("disabled", false);
		$("#num-paciente").val(Numero_Paciente());		
	}
});

/*

$("#ingresar").click(function(e){
	var count_practicas = $("#row-practicas section").length;
	if (count_practicas !== 1)
	{
		for (var i =  1; i <= count_practicas; i++)
		{			
			if ($("#practicas"+i+" [value="+$("#practica"+i).val()+"]").data("value") === undefined || $("#practica"+i).val() === "") 
			{
				$.bigBox({
					title : "Error",
					content : "Uno o mas campos de práctica están vacíos o con contenido inválido.<br>Asegúrese que contengan datos reales.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
				return;
			}
		}
	}		

	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/pacientes/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error == true) 
			{		
				if (response.data == "Número de paciente incorrecto.")
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El número de paciente que ha ingresado es incorrecto.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});						
					$("#num-paciente").val(Numero_Paciente());
				}
				if (response.data == "Número de paciente repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El número de paciente que ha ingresado está repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});						
					$("#num-paciente").val(Numero_Paciente());
				}			
				if (response.data == "Email incorrecto") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. Verifique que el Email esté bien escrito.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});						
				}
				if (response.data == "Email repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El email está repetido, por favor ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});						
				}					
				if (response.data == "Número de documento repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El número de documento que ha ingresado está repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});						
				}
				if (response.data == "El médico no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. El médico elegido ya no existe.<br> Por favor, elija otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#matricula-medico").val("");
					actualizarMedicos();
					$("#nombre-doctor").val("");
				}
				if (response.data == "La mutual 1 no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. La mutual N° 1 elegida ya no existe.<br> Por favor, elija otra.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#obra1").val("");
					actualizarMutuales();
				}
				if (response.data == "La mutual 2 no existe") 
				{
					$.bigBox({
						title : "Error",
						content : "El paciente no se ha podido crear. La mutual N° 2 elegida ya no existe.<br> Por favor, elija otra.",
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
					content : "El paciente se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-pacientes").get(0).reset();
				$("#num-paciente").val(Numero_Paciente());
				actualizarPacientes("ingresar");
				actualizarMutuales();
				actualizarMedicos();
				resetPracticas();
				actualizarNomencladores(1);					
				resetFormObra1();
				resetFormObra2();	
				$("#paciente-existente").hide()
				$("#paciente-nuevo").hide();
				$("#paciente-nuevo").prop("checked", false);
				$("#paciente-nuevo-label").hide();					
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
				arr = ["ApellidoNombre"];		
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

*/