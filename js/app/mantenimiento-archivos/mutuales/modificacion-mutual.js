$(document).ready(function(){
	actualizarMutuales();
	$("#buscar_mutual").focus();
});

function resetForm(){
	$("#form-modificar").get(0).reset();
	$("#form-modificar :input").prop("disabled", true);
	$("#buscar_mutual").prop("disabled", false);
}

function actualizarMutuales(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/mutuales/",
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
						content : "No se encontraron obras sociales.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$("#list_mutuales").empty();
				$.each(response.data, function(index, item){
					$("#list_mutuales").append("<option data-value=\""+item.Id+"\" value=\""+item.Codigo+" - "+item.Nombre+"\"></option>");
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
					content : "No se pudieron obtener las obras sociales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar_mutual").on("input", function(){
	var val = this.value;
	if ($("#list_mutuales option").filter(function(){
		return this.value === val;
	}).length)
	{
		if ($("#buscar_mutual").val() === "") 
		{
			resetForm();
		}
		else
		{
			var mutual = $("#buscar_mutual").val();
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/mutuales/"+$("#list_mutuales [value='"+mutual+"']").data("value"),
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
								content : "No se encontraron datos para la obra social elegida.",
								color : "#C46A69",
								timeout : 8000,
								icon : "fa fa-warning shake animated"
							});
							resetForm();
							actualizarMutuales();
						}
					}
					else
					{
						$("#codigo").val(response.data[0].Codigo);
						$("#nombre").val(response.data[0].Nombre);
						$("#abona-domicilio").val(response.data[0].AbonoDomicilio);
						$("#pmo").val(response.data[0].PMO);
						$("#cobra-coseguro").val(response.data[0].CobroCoseguro);
						$("#servicios-cortados").val(response.data[0].ServicioCortado);
						$("#inos-reducido").val(response.data[0].INOSReducido);
						$("#reconoce-677").val(response.data[0].Reconoce677);
						$("#nomen-completo").val(response.data[0].NomenCompleto);
						$("#valor-a").val(response.data[0].ValorA);
						$("#valor-b").val(response.data[0].ValorB);
						$("#valor-c").val(response.data[0].ValorC);
						$("#valor-nbu").val(response.data[0].ValorNBU);
						$("#coeficiente-gastos").val(response.data[0].CoeficienteUGastos);
						$("#coeficiente-honorarios").val(response.data[0].CoeficienteUHono);							
						$("#importe-boleta").val(response.data[0].ImporteBoletaMin);
						$("#abona-apb").val(response.data[0].AbonoAPB);							
						$("#porc-cobertura").val(response.data[0].PorcCobertura);
						$("#comentarios").val(response.data[0].Comentarios);
						$("#comentarios-int").val(response.data[0].ComentariosInternos);
						$("#porcentaje").val(response.data[0].Porcentaje);
						$("#condicion").val(response.data[0].Condicion);

						$("#form-modificar :input").prop("disabled", false);
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
							content : "No se pudo obtener la obra social.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
	}
	else
	{

	}		
});

$("#buscar_mutual").change(function(){
	if ($("#buscar_mutual").val() === "")
	{
		resetForm();
	}
});

$("#buscar_mutual").blur(function(){
	if ($("#buscar_mutual").val() === "")
	{
		resetForm();
	}
});

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);
	if($("#buscar_mutual").val() !== "")
	{
		$.ajax({
			type : "PUT",
			contentType: "application/json",
			url: "api/mutuales/modificar",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if(response.error === true)
				{
					if (response.data === "La mutual no existe.")
					{
						$.bigBox({
							title : "Error",
							content : "La la obra social elegida ya no existe. <br>Por favor seleccione otra.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
						resetForm();
						actualizarMutuales();
					}
					if (response.data === "Código de mutual repetido")
					{
						$.bigBox({
							title : "Error",
							content : "El código de mutual ingresado ya existe.<br>Por favor, ingrese otro.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#codigo").val("");
						$("#codigo").focus();
						$("#modificar").prop("disabled", false);
					}
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "La obra social se ha modificado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});
					resetForm();
					actualizarMutuales();
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
					arr = ["Codigo", "Nombre", "AbonoDomicilio", "PMO", "CobroCoseguro", "ServicioCortado", "INOSReducido", "Reconoce677", "NomenCompleto", "ValorA", "ValorB", "ValorC", "ValorNBU", "CoeficienteUGastos", "CoeficienteUHono", "PorcRecargo", "ImporteBoletaMin", "AbonoAPB", "PorcCobertura", "Porcentaje", "Condicion"];
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
					Errores = Errores.replace("Codigo", "Código de Obra Social");
					Errores = Errores.replace("AbonoDomicilio", "Abono Domicilio");
					Errores = Errores.replace("PMO", "P.M.O.");
					Errores = Errores.replace("CobroCoseguro", "Cobro Coseguro");
					Errores = Errores.replace("ServicioCortado", "Servicios Cortados");
					Errores = Errores.replace("INOSReducido", "INOS Reducido");
					Errores = Errores.replace("Reconoce677", "Reconoce 677");
					Errores = Errores.replace("NomenCompleto", "Nomen. Completo");
					Errores = Errores.replace("ValorA", "Valor Nivel A");
					Errores = Errores.replace("ValorB", "Valor Nivel B");
					Errores = Errores.replace("ValorC", "Valor Nivel C");
					Errores = Errores.replace("ValorNBU", "Valor N.B.U.");
					Errores = Errores.replace("CoeficienteUGastos", "Coef. Unitario Gastos");
					Errores = Errores.replace("CoeficienteUHono", "Coef. Unitario Honorarios");
					Errores = Errores.replace("ImporteBoletaMin", "Importe de Boleta Mínimo");
					Errores = Errores.replace("AbonoAPB", "Abono A.P.B.");
					Errores = Errores.replace("PorcCobertura", "porcentaje de Cobertura");
					Errores = Errores.replace("Porcentaje", "Porcentaje");
					Errores = Errores.replace("Condicion", "Condición");
					Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
					$.bigBox({
						title : "Error",
						content : "Asegúrese que completó todos los campo requeridos. <br>"+Errores+"<br><br>",
						color : "#C46A69",
						timeout: 8000,
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
		"Id": $("#list_mutuales [value='" + $("#buscar_mutual").val() + "']").data("value"),
		"Codigo": $("#codigo").val().substr(0,4),
		"Nombre": $("#nombre").val(),
		"AbonoDomicilio": $("#abona-domicilio").val(),
		"PMO": $("#pmo").val(),
		"CobroCoseguro": $("#cobra-coseguro").val(),
		"ServicioCortado": $("#servicios-cortados").val(),
		"INOSReducido": $("#inos-reducido").val(),
		"Reconoce677": $("#reconoce-677").val(),
		"NomenCompleto": $("#nomen-completo").val(),
		"ValorA": $("#valor-a").val(),
		"ValorB": $("#valor-b").val(),
		"ValorC": $("#valor-c").val(),
		"ValorNBU": $("#valor-nbu").val(),
		"CoeficienteUGastos": $("#coeficiente-gastos").val(),
		"CoeficienteUHono": $("#coeficiente-honorarios").val(),
		"ImporteBoletaMin": $("#importe-boleta").val(),
		"AbonoAPB": $("#abona-apb").val(),			
		"PorcCobertura": $("#porc-cobertura").val().substr(0,3),
		"Comentarios": $("#comentarios").val(),
		"ComentariosInternos": $("#comentarios-int").val(),
		"Porcentaje": $("#porcentaje").val(),
		"Condicion": $("#condicion").val(),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar_mutual").focus();
			key.preventDefault();
		}
	}
});

$("#Codigo").keypress(function(key){
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

$("#porc-cobertura").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#importe-boleta").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#porcentaje").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#coeficiente-gastos").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#coeficiente-honorarios").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-a").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-b").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-c").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-nbu").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#codigo").on("input", function(){
	habilitarModificar();
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

$("#porc-cobertura").on("input", function(){
	habilitarModificar();
});

$("#importe-boleta").on("input", function(){
	habilitarModificar();
});

$("#abona-apb").on("input", function(){
	habilitarModificar();
});

$("#abona-domicilio").on("input", function(){
	habilitarModificar();
});

$("#pmo").on("input", function(){
	habilitarModificar();
});

$("#cobra-coseguro").on("input", function(){
	habilitarModificar();
});

$("#servicios-cortados").on("input", function(){
	habilitarModificar();
});

$("#nomen-completo").on("input", function(){
	habilitarModificar();
});

$("#reconoce-677").on("input", function(){
	habilitarModificar();
});

$("#porcentaje").on("input", function(){
	habilitarModificar();
});

$("#condicion").on("input", function(){
	habilitarModificar();
});
modificar
function habilitarModificar(){
	if ($("#codigo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#porc-cobertura").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#importe-boleta").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#abona-apb").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#abona-domicilio").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#pmo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#cobra-coseguro").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#servicios-cortados").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nomen-completo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#reconoce-677").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#porcentaje").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#condicion").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}