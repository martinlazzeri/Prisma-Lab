$(document).ready(function(){
	$("#codigo").focus();
});

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/titulos/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				//mensajes de error en status 200
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El título se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#form-titulo").get(0).reset();
				$("#codigo").focus();
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
				arr = ["Codigo", "CreadoPor"];
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
				Errores = Errores.replace("Codigo", "código de título");
				Errores = Errores.replace("CreadoPor", "usuario que lo creó");
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
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"Codigo": $("#codigo").val().substr(0,3),
		"Descripcion": $("#descripcion").val(),
		"Tipo": $("#tipo-titulo").val(),
		"Unidades": $("#unidades").val(),
		"Rango": $("#rango").val(),
		"LineaTexto1": $("#linea1").val(),
		"LineaTexto2": $("#linea2").val(),
		"LineaTexto3": $("#linea3").val(),
		"LineaTexto4": $("#resultado").val(),
		"ValoresReferenciaAmpliados": $("#valores-referencia").val(),
		"ValorMinimo": $("#valor-minimo").val(),
		"ValorMaximo": $("#valor-maximo").val(),			
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#codigo").focus();
		key.preventDefault();
	}
});

$("#codigo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#descripcion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#unidades").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#rango").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#linea3").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#resultado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-minimo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#valor-maximo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#codigo").on("input", function(){
	habilitarIngresar();
});

$("#descripcion").on("input", function(){
	habilitarIngresar();
});

$("#tipo-titulo").on("input", function(){
	habilitarIngresar();
});

$("#unidades").on("input", function(){
	habilitarIngresar();
});

$("#rango").on("input", function(){
	habilitarIngresar();
});

$("#linea1").on("input", function(){
	habilitarIngresar();
});

$("#linea2").on("input", function(){
	habilitarIngresar();
});

$("#linea3").on("input", function(){
	habilitarIngresar();
});

$("#resultado").on("input", function(){
	habilitarIngresar();
});

$("#valores-referencia").on("input", function(){
	habilitarIngresar();
});

$("#valor-minimo").on("input", function(){
	habilitarIngresar();
});

$("#valor-maximo").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#codigo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#descripcion").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#tipo-titulo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#unidades").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#rango").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#linea1").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#linea2").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#linea3").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#resultado").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valores-referencia").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-minimo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#valor-maximo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}