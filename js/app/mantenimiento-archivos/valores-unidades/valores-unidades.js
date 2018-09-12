$(document).ready(function(){
	actualizarValores();
	actualizarSecciones();
	$("#numero-uso-arranque").focus();
});

function actualizarValores(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/valoresunidades/",
		dataType: "json",			
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron valores registrados.<br>Por favor, inserte valores.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#numero-uso-arranque").val(response.data[0].NumeroUsoArranque);
				$("#valor-faba-a").val(response.data[0].ValorFABAA);
				$("#valor-faba-b").val(response.data[0].ValorFABAB);
				$("#valor-faba-c").val(response.data[0].ValorFABAC);
				$("#valor-nbu-af").val(response.data[0].ValorNBUAltaFrec);
				$("#valor-nbu-bf").val(response.data[0].ValorNBUBajaFrec);
				$("#pmo").val(response.data[0].PMO);
				$("#u-gastos").val(response.data[0].UGastos);
				$("#u-honorarios").val(response.data[0].UHonorarios);
				$("#recibos").val(response.data[0].Recibos);
				$("#etiquetas").val(response.data[0].Etiquetas);
				$("#tarjetas").val(response.data[0].Tarjetas);
				$("#valor-practica-minima").val(response.data[0].ValorPracticaMinima);
				$("#extraccion-domicilio").val(response.data[0].ExtraccionDomicilio);
				$("#acto-profesional-bioquimico").val(response.data[0].ActoProfesionalBioquimico);
				$("#valor-monto-maximo").val(response.data[0].ValorMontoMaximo);
				$("#numerador-derivaciones").val(response.data[0].NumeradorDerivaciones);
				$("#buscar_seccion").val(response.data[0].CodSeccion+" - "+response.data[0].NombreSeccion);
				$("#posicion-seccion").val(response.data[0].PosicionSeccion);
				$("#decodificar-nemotecnicos").val(response.data[0].DecodificarNemotecnicos);
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
					content : "No se pudieron obtener los valores de unidades en uso.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

function actualizarSecciones(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/secciones/",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos para secciones en general.") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron secciones registradas.<br>Por favor, ingréselas.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#list_secciones").empty();
				$.each(response.data, function(index, item){
					$("#list_secciones").append("<option data-value=\""+item.Id+"\" value=\""+item.Codigo+" - "+item.Nombre+"\"></option>")
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
					content : "No se pudieron obtener las secciones.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/valoresunidades/actualizar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "La sección no existe")
				{
					$.bigBox({
						title : "Error",
						content : "La sección elegida para el hemograma no existe.<br>Por favor, seleccione otra.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
					$("#buscar_seccion").val("");
					$("#buscar_seccion").focus();
					actualizarSecciones();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "Valores actualizados correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
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
				arr = ["NumeroUsoArranque", "UGastos", "UHonorarios", "Recibos", "Etiquetas", "Tarjetas", "ValorPracticaMinima", "ExtraccionDomicilio", "ActoProfesionalBioquimico", "ValorMontoMaximo", "NumeradorDerivaciones", "SeccionFormulaHemograma", "PosicionSeccion", /*"PracticasComponentes",*/"DecodificarNemotecnicos"];		
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
				Errores = Errores.replace("NumeroUsoArranque", "número de uso de arranque");
				Errores = Errores.replace("ValorFABAA", "valor FABA A");
				Errores = Errores.replace("ValorFABAB", "valor FABA B");
				Errores = Errores.replace("ValorFABAC", "valor FABA C");
				Errores = Errores.replace("ValorNBUAltaFrec", "valor NBU para alta frecuencia");
				Errores = Errores.replace("ValorNBUBajaFrec", "valor NBU para baja frecuencia");					
				Errores = Errores.replace("UGastos", "unidad de gastos");
				Errores = Errores.replace("UHonorarios", "unidad de honorarios");
				Errores = Errores.replace("ValorPracticaMinima", "valor de práctica mínima");
				Errores = Errores.replace("ExtraccionDomicilio", "extracción a domicilio");
				Errores = Errores.replace("ActoProfesionalBioquimico", "acto profesional bioquímico");
				Errores = Errores.replace("ValorMontoMaximo", "valor del monto máximo");
				Errores = Errores.replace("NumeradorDerivaciones", "numerador de derivaciones");
				Errores = Errores.replace("SeccionFormulaHemograma", "sección de la fórmula del hemograma");
				Errores = Errores.replace("PosicionSeccion", "posición en la sección");
				Errores = Errores.replace("DecodificarNemotecnicos", "decodificación de nemotécnicos");
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

function FormToJSON(){
	return JSON.stringify({
		"NumeroUsoArranque": $("#numero-uso-arranque").val(),
		"ValorFABAA": $("#valor-faba-a").val().substr(0, 7),
		"ValorFABAB": $("#valor-faba-b").val().substr(0, 7),
		"ValorFABAC": $("#valor-faba-c").val().substr(0, 7),
		"ValorNBUAltaFrec": $("#valor-nbu-af").val().substr(0, 7),
		"ValorNBUBajaFrec": $("#valor-nbu-bf").val().substr(0, 7),
		"PMO": $("#pmo").val().substr(0, 7),
		"UGastos": $("#u-gastos").val(),
		"UHonorarios": $("#u-honorarios").val(),
		"Recibos": $("#recibos").val(),
		"Etiquetas": $("#etiquetas").val(),
		"Tarjetas": $("#tarjetas").val(),
		"ValorPracticaMinima": $("#valor-practica-minima").val(),
		"ExtraccionDomicilio": $("#extraccion-domicilio").val(),
		"ActoProfesionalBioquimico": $("#acto-profesional-bioquimico").val(),
		"ValorMontoMaximo": $("#valor-monto-maximo").val(),
		"NumeradorDerivaciones": $("#numerador-derivaciones").val(),
		"SeccionFormulaHemograma": $("#list_secciones [value='"+$("#buscar_seccion").val()+"']").data("value"),
		"PosicionSeccion": $("#posicion-seccion").val(),
		//"PracticasComponentes": $("#practicas-componentes").val(),
		"DecodificarNemotecnicos": $("#decodificar-nemotecnicos").val(),
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#numero-uso-arranque").focus();
		key.preventDefault();
	}
});

$("#numero-uso-arranque").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-faba-a").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-faba-b").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-faba-c").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-nbu-af").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-nbu-bf").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#pmo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#u-gastos").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#u-honorarios").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#recibos").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#etiquetas").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#tarjetas").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-practica-minima").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#extraccion-domicilio").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-monto-maximo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#numero-uso-arranque").on("input", function(){
	habilitarIngresar();
});

$("#valor-faba-a").on("input", function(){
	habilitarIngresar();
});

$("#valor-faba-b").on("input", function(){
	habilitarIngresar();
});

$("#valor-faba-c").on("input", function(){
	habilitarIngresar();
});

$("#valor-nbu-af").on("input", function(){
	habilitarIngresar();
});

$("#valor-nbu-bf").on("input", function(){
	habilitarIngresar();
});

$("#pmo").on("input", function(){
	habilitarIngresar();
});

$("#u-gastos").on("input", function(){
	habilitarIngresar();
});

$("#u-honorarios").on("input", function(){
	habilitarIngresar();
});

$("#recibos").on("input", function(){
	habilitarIngresar();
});

$("#etiquetas").on("input", function(){
	habilitarIngresar();
});

$("#tarjetas").on("input", function(){
	habilitarIngresar();
});

$("#valor-practica-minima").on("input", function(){
	habilitarIngresar();
});

$("#extraccion-domicilio").on("input", function(){
	habilitarIngresar();
});

$("#valor-monto-maximo").on("input", function(){
	habilitarIngresar();
});

$("#numerador-derivaciones").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#numero-uso-arranque").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-faba-a").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-faba-b").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-faba-c").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-nbu-af").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-nbu-bf").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#pmo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#u-gastos").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#u-honorarios").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#recibos").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#etiquetas").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#tarjetas").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-practica-minima").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#extraccion-domicilio").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-monto-maximo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#numerador-derivaciones").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}