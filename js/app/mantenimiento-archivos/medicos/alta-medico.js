$(document).ready(function(){
	$("#matricula").focus();
});

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);			
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/medicos/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error == true) 
			{
				$.bigBox({
					title : "Error",
					content : "La matrícula ingresada, ya se corresponde con un médico existente. <br>Por favor, ingrese otra.",
					color : "#C46A69",
					icon : "fa fa-warning shake animated",
					timeout : 5000
				});
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
				$("#form-medico").get(0).reset();
				$("#ingresar").prop("disabled", true);
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
				arr = ["Matricula", "TipoMatricula", "AbonoDomicilio", "Nombre", "Apellido", "Domicilio1", "Telefono1"];
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
				Errores = Errores.replace("Domicilio1", "Domicilio N° 1");
				Errores = Errores.replace("Telefono1", "Teléfono N° 1");
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
	$("#ingresar").prop("disabled", false);
	e.preventDefault();
});
function FormToJSON(){						
	return JSON.stringify({
		"Matricula": $("#matricula").val(),
		"TipoMatricula": $("#tipo-matricula").val(),
		"Nombre": $("#nombre").val(),
		"Apellido": $("#apellido").val(),
		"Domicilio1": $("#domicilio1").val(),
		"Telefono1": $("#telefono1").val(),
		"Domicilio2": $("#domicilio2").val(),
		"Telefono2": $("#telefono2").val(),
		"CreadoPor": $.cookie("NombreUsuario")
	});
}	
$("#matricula").blur(function(){
	if ($("#matricula").val().length > 6)
	{
		$("#matricula").val($("#matricula").val().substr(0, 6));
	}
});

$("#ingresar").on("keydown", function(key){
	if (key.which === 9) 
	{
		$("#matricula").focus();
		key.preventDefault();
	}
});

$("#matricula").keypress(function(key){
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

$("#apellido").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#domicilio1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#telefono1").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#domicilio2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#telefono2").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#matricula").on("input", function(){
	habilitarIngresar();
});

$("#tipo-matricula").on("input", function(){
	habilitarIngresar();
});

$("#nombre").on("input", function(){
	habilitarIngresar();
});

$("#apellido").on("input", function(){
	habilitarIngresar();
});

$("#domicilio1").on("input", function(){
	habilitarIngresar();
});

$("#telefono1").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#matricula").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#tipo-matricula").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#apellido").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#domicilio1").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#telefono1").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	$("#ingresar").prop("disabled", false);
}