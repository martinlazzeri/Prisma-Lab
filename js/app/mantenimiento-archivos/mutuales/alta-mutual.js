$(document).ready(function(){
	$("#Codigo").focus();
});

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	e.preventDefault();
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/mutuales/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if(response.error == true)
			{
				$.bigBox({
					title : "Error",
					content : "El código de obra social ingresado, ya se corresponde con una existente.<br> Por favor, ingrese otro",									   
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "La obra social se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-mutual").get(0).reset();
				$("#Codigo").focus();				
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
				Errores = Errores.replace("PorcRecargo", "Procentaje de Recargo");
				Errores = Errores.replace("ImporteBoletaMin", "Importe de Boleta Mínimo");
				Errores = Errores.replace("AbonoAPB", "Abono A.P.B.");
				Errores = Errores.replace("PorcCobertura", "porcentaje de cobertura");
				Errores = Errores.replace("Porcentaje", "porcentaje");
				Errores = Errores.replace("Condicion", "condición");
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
	$("#ingresar").prop("disabled", false);
});
function FormToJSON(){			
	return JSON.stringify({
		"Codigo": $("#Codigo").val(),
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
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

function actualizarFormINOS(){
	$("#coeficiente-gastos").val("");
	$("#coeficiente-honorarios").val("");
	$("#inos-reducido").prop("selected-index", "");
}

function actualizarFormFABA(){
	$("#valor-a").val("");
	$("#valor-b").val("");
	$("#valor-c").val("");
}

function actualizarFormNBU(){
	$("#valor-nbu").val("");
	$("#comentarios").val("");
	$("#comentarios-int").val("");
}

$("#check-inos").on("change", function(){
	if ($("#check-inos").is(":checked")) 
	{
		$("#form-inos").fadeIn("slow");
		actualizarFormINOS();
		$("#coeficiente-gastos").focus();
	}
	else
	{
		$("#form-inos").fadeOut("slow");
		actualizarFormINOS();
	}
});

$("#check-faba").on("change", function(){
	if ($("#check-faba").is(":checked")) 
	{
		$("#form-faba").fadeIn("slow");
		actualizarFormFABA();
		$("#valor-a").focus();
	}
	else
	{
		$("#form-faba").fadeOut("slow");
		actualizarFormFABA();
	}
});

$("#check-nbu").on("change", function(){
	if ($("#check-nbu").is(":checked")) 
	{
		$("#form-nbu").fadeIn("slow");
		actualizarFormNBU();
		$("#valor-nbu").focus();
	}
	else
	{
		$("#form-nbu").fadeOut("slow");
		actualizarFormNBU();
	}
});

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#Codigo").focus();
		key.preventDefault();
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

$("#Codigo").on("input", function(){
	habilitarIngresar();
});

$("#nombre").on("input", function(){
	habilitarIngresar();
});

$("#porc-cobertura").on("input", function(){
	habilitarIngresar();
});

$("#importe-boleta").on("input", function(){
	habilitarIngresar();
});

$("#abona-apb").on("input", function(){
	habilitarIngresar();
});

$("#abona-domicilio").on("input", function(){
	habilitarIngresar();
});

$("#pmo").on("input", function(){
	habilitarIngresar();
});

$("#cobra-coseguro").on("input", function(){
	habilitarIngresar();
});

$("#servicios-cortados").on("input", function(){
	habilitarIngresar();
});

$("#nomen-completo").on("input", function(){
	habilitarIngresar();
});

$("#reconoce-677").on("input", function(){
	habilitarIngresar();
});

$("#porcentaje").on("input", function(){
	habilitarIngresar();
});

$("#condicion").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#Codigo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#porc-cobertura").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#importe-boleta").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#abona-apb").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#abona-domicilio").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#pmo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#cobra-coseguro").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#servicios-cortados").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nomen-completo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#reconoce-677").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#porcentaje").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#condicion").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}