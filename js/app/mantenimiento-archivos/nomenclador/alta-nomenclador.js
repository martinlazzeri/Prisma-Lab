$(document).ready(function(){
	resetDeterminaciones();
	$("#codigo").focus();
});

$("#agregar-determinacion").click(function(e){
	var count_section = $("#row-determinaciones section").length;

	if (count_section == 30) 
	{
		$.bigBox({
			title : "Error",
			content : "Sólo se permiten hasta 30 determinaciones por nomenclador.",
			color : "#C46A69",
			timeout: 5000,
			icon : "fa fa-warning shake animated"
		});
		return;
	}
	
	var section = 	"<section class=\"form-group\" id=\"section\">"+
						"<div class=\"col col-3\">"+
							"<label class=\"col-md-2 control-label\">"+(count_section + 1)+" - Determinación</label>"+
							"<div class=\"col-md-1\">"+
								"<input id=\"determinacion\" class=\"form-control\" placeholder=\"XXX\" type=\"text\">"+
							"</div>"+
						"</div>"+
						"<div class=\"col col-3\">"+
							"<label class=\"col-md-1 control-label\">Sección</label>"+
							"<div class=\"col-md-1\">"+
								"<input id=\"seccion\" class=\"form-control\" type=\"text\" placeholder=\"X0\">"+
							"</div>"+
						"</div>"+
						"<div class=\"col col-3\">"+
							"<label class=\"col-md-1 control-label\">Orden</label>"+
							"<div class=\"col-md-1\">"+
								"<input id=\"orden\" class=\"form-control\" type=\"number\">"+
							"</div>"+
						"</div>"+
						"<div class=\"col col-3\">"+
							"<button type=\"button\" onclick=\"eliminarDet("+(count_section + 1)+");\">X</button>"+
						"</div>"+
					"</section>";

	$("#row-determinaciones").append(section);

	var section = $("#row-determinaciones #section");
	section[count_section].childNodes[0].childNodes[1].childNodes[0].focus();

	habilitarIngresar();

	e.preventDefault();
});

function eliminarDet(id){		
	var sections = $("#row-determinaciones #section");
	if (sections.length > 1)
	{
		$(sections[id-1]).remove();
		habilitarIngresar();
	}
	else
	{
		$.bigBox({
			title : "Error",
			content : "No se puede eliminar. Debe existir al menos una determinación.",
			color : "#C46A69",
			timeout: 5000,
			icon : "fa fa-warning shake animated"
		});
	}
}

function resetDeterminaciones(){
	$("#row-determinaciones").empty();
	$("#row-determinaciones").append(	"<section class=\"form-group\" id=\"section\">"+
											"<div class=\"col col-3\">"+
												"<label class=\"col-md-2 control-label\">1 - Determinación</label>"+
												"<div class=\"col-md-1\">"+
													"<input id=\"determinacion\" class=\"form-control\" placeholder=\"XXX\" type=\"text\">"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<label class=\"col-md-1 control-label\">Sección</label>"+
												"<div class=\"col-md-1\">"+
													"<input id=\"seccion\" class=\"form-control\" type=\"text\" placeholder=\"X0\">"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<label class=\"col-md-1 control-label\">Orden</label>"+
												"<div class=\"col-md-1\">"+
													"<input id=\"orden\" class=\"form-control\" type=\"number\">"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<button type=\"button\" onclick=\"eliminarDet(1);\">X</button>"+
											"</div>"+
										"</section>");
}

$("#ingresar").click(function(e){
	$("#ingresar").prop("disabled", true);
	var count_section = $("#row-determinaciones section").length;
	var array_determinaciones = $("#row-determinaciones section");
	for (var i = 0; i < count_section; i++) 
	{				
			var section = array_determinaciones[i];
			if(section.childNodes[0].childNodes[1].childNodes[0].value == "" || section.childNodes[1].childNodes[1].childNodes[0].value == "" || section.childNodes[2].childNodes[1].childNodes[0].value == "")
			{
				$.bigBox({
					title : "Error",
					content : "Uno o mas campos de las determinaciones están vacíos. Asegúrese de completarlos antes de enviar.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
				$("#ingresar").prop("disabled", false);
				return;
			}
	}
	
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/nomencladores/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error == true) 
			{
				if (response.data = "Código de nomenclador repetido.") 
				{
					$.bigBox({
						title : "Error",
						content : "El código del nomenclador ingresado está repetido.<br> Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}		
				if (response.data = "No existen determinaciones.") 
				{
					$.bigBox({
						title : "Error",
						content : "No se enviaron determinaciones, por favor ingrese al menos una.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}					
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El nomenclador se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				resetDeterminaciones();
				$("#form-nomencladores").get(0).reset();
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
				//arreglo con todos los posibles campos con error
				arr = ["Codigo", "Nombre", " INOS", "_677", "UGastos", "UHonorarios", "Area", "Complejidad", "INOSReducido", "NoNomenclada", "TiempoRealizacion", "IdMuestra", "Proceso", "Lista", "CodigoFABA", "Nivel", "RIA", "NBUFrecuencia", "NBUCodigo", "Cantidad"];
				//arreglo con los errores actuales
				var Errores = error.responseJSON.message.split(", ");
				//saco principio del mensaje de error asi obtengo solo el nombre del primer campo con error
				Errores[0] = Errores[0].substr(22);
				//saco final del mensaje de error asi obtengo solo el nombre del ultimo campo con error
				Errores[Errores.length-1] = Errores[Errores.length-1].substr(0, Errores[Errores.length-1].indexOf(" "));
				//contador de errores a 0
				var j = 0;
				//mensaje a mostrar vacío
				mensaje = "";
				$.each(Errores, function(index, itemErr)
				{
					if(j < 3)
					{
						$.each(arr, function(index, itemArr){
							if(itemErr === itemArr)
							{
								mensaje += itemArr+", ";
								j++;
							}
						});
					}
				});
				mensaje = mensaje.replace("Codigo", "Código de nomenclador");
				mensaje = mensaje.replace("UGastos", "UGastos");
				mensaje = mensaje.replace("UHonorarios", "UHonorarios");
				mensaje = mensaje.replace("NoNomenclada", "No nomenclada");
				mensaje = mensaje.replace("TiempoRealizacion", "Tiempo de realización");
				mensaje = mensaje.replace("IdMuestra", "Id de muestra");
				mensaje = mensaje.replace("CodigoFABA", "Código de nomenclador FABA");
				mensaje = mensaje.replace("NBUFrecuencia", "Frecuencia de NBU");
				mensaje = mensaje.replace("NBUCodigo", "Código de NBU");
				mensaje = "Campo(s) requerido(s) "+mensaje+" vacío(s) o nulo(s).";
				$.bigBox({
					title : "Error",
					content : "Asegúrese que completó todos los campo requeridos. <br>"+mensaje+"<br><br>",
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
	var count_section = $("#row-determinaciones section").length;
	var array_determinaciones = $("#row-determinaciones section");
	var determinaciones = [];
	for (var i = 0; i < count_section; i++) 
	{				
		var det = [];
		var section = array_determinaciones[i];
		det.push(section.childNodes[0].childNodes[1].childNodes[0].value);
		det.push(section.childNodes[1].childNodes[1].childNodes[0].value);
		det.push(section.childNodes[2].childNodes[1].childNodes[0].value);

		determinaciones.push(det);
	}		

	return JSON.stringify({
		"Codigo": $("#codigo").val(),
		"Nombre": $("#nombre").val(),
		"INOS": $("#inos").val(),
		"_677": $("#_677").val(),
		"UGastos": $("#u-gastos").val(),
		"UHonorarios": $("#u-honorarios").val(),
		"Area": $("#area").val(),
		"Complejidad": $("#complejidad").val(),
		"INOSReducido": $("#inos-reducido").val(),
		"NoNomenclada": $("#no-nomenclada").val(),
		"TiempoRealizacion": $("#tiempo-realizacion").val(),
		"IdMuestra": $("#id-muestra").val(),
		"Proceso": $("#proceso").val(),
		"Lista": $("#lista").val(),
		"CodigoFABA": $("#codigo-nomen-faba").val(),
		"Nivel": $("#nivel").val(),
		"RIA": $("#ria").val(),
		"NBUFrecuencia": $("#nbu-frecuencia").val(),
		"NBUCodigo": $("#nbu-codigo").val(),
		"Cantidad": $("#cantidad").val(),
		"Determinaciones": determinaciones,
		"CreadoPor": $.cookie("NombreUsuario")
	});
}

$("#codigo").keypress(function(key){
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

$("#inos").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#_677").keypress(function(key){
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

$("#area").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#tiempo-realizacion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#id-muestra").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#proceso").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#lista").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#codigo-nomen-faba").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nivel").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#nbu-codigo").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#cantidad").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#determinacion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#seccion").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#orden").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$("#codigo").on("input", function(){
	habilitarIngresar();
});

$("#nombre").on("input", function(){
	habilitarIngresar();
});

$("#inos").on("input", function(){
	habilitarIngresar();
});

$("#_677").on("input", function(){
	habilitarIngresar();
});

$("#u-gastos").on("input", function(){
	habilitarIngresar();
});

$("#u-honorarios").on("input", function(){
	habilitarIngresar();
});

$("#area").on("input", function(){
	habilitarIngresar();
});

$("#complejidad").on("input", function(){
	habilitarIngresar();
});

$("#inos-reducido").on("input", function(){
	habilitarIngresar();
});

$("#tiempo-realizacion").on("input", function(){
	habilitarIngresar();
});

$("#id-muestra").on("input", function(){
	habilitarIngresar();
});

$("#proceso").on("input", function(){
	habilitarIngresar();
});

$("#lista").on("input", function(){
	habilitarIngresar();
});

$("#codigo-nomen-faba").on("input", function(){
	habilitarIngresar();
});

$("#nivel").on("input", function(){
	habilitarIngresar();
});

$("#ria").on("input", function(){
	habilitarIngresar();
});

$("#nbu-frecuencia").on("input", function(){
	habilitarIngresar();
});

$("#nbu-codigo").on("input", function(){
	habilitarIngresar();
});

$("#cantidad").on("input", function(){
	habilitarIngresar();
});

$("#row-determinaciones #determinacion").on("input", function(){
	habilitarIngresar();
});

$("#row-determinaciones #seccion").on("input", function(){
	habilitarIngresar();
});

$("#row-determinaciones #orden").on("input", function(){
	habilitarIngresar();
});

function habilitarIngresar(){
	if ($("#codigo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nombre").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#inos").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#_677").val() === "")
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
	if ($("#area").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#complejidad").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#inos-reducido").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#tiempo-realizacion").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#id-muestra").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#proceso").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#lista").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#codigo-nomen-faba").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nivel").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#ria").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nbu-frecuencia").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#nbu-codigo").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}
	if ($("#cantidad").val() === "")
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	var determinaciones = $("#row-determinaciones #determinacion");
	var secciones = $("#row-determinaciones #seccion");
	var ordenes = $("#row-determinaciones #orden");

	if (determinaciones.length === 0)
	{
		$("#ingresar").prop("disabled", true);
		return;
	}

	for (var i = 0; i < determinaciones.length; i++) {
		if (determinaciones[i].value === "" || secciones[i].value === "" || ordenes[i].value === "")
		{
			console.log(determinaciones[i].value);
			console.log(secciones[i].value);
			console.log(ordenes[i].value);
			$("#ingresar").prop("disabled", true);
			return;
		}
	}

	$("#ingresar").prop("disabled", false);
}