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

	habilitarModificar();

	e.preventDefault();
});

function eliminarDet(id){		
	var sections = $("#row-determinaciones #section");
	if (sections.length > 1)
	{
		$(sections[id-1]).remove();
		habilitarModificar();
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
													"<input id=\"determinacion\" class=\"form-control\" placeholder=\"XXX\" type=\"text\" disabled>"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<label class=\"col-md-1 control-label\">Sección</label>"+
												"<div class=\"col-md-1\">"+
													"<input id=\"seccion\" class=\"form-control\" type=\"text\" placeholder=\"X0\" disabled>"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<label class=\"col-md-1 control-label\">Orden</label>"+
												"<div class=\"col-md-1\">"+
													"<input id=\"orden\" class=\"form-control\" type=\"number\" disabled>"+
												"</div>"+
											"</div>"+
											"<div class=\"col col-3\">"+
												"<button type=\"button\" onclick=\"eliminarDet(1);\" disabled>X</button>"+
											"</div>"+
										"</section>");
}

$("#buscar-nomenclador").keypress(function(key){
	if ($("#buscar-nomenclador").val() !== "")
	{
		if (key.which === 13)
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/nomencladores/pornombre",
				dataType: "json",
				data: JSON.stringify({"Nombre": $("#buscar-nomenclador").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos.")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron nomencladores de trabajo que coincidan con los datos ingresados.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
							$("#buscar-nomenclador").val();
						}
					}
					else
					{
						if (response.cantidad === 1)
						{
							$("#form-nomencladores :input").prop("disabled", false);

							$("#buscar-nomenclador").attr("data-id", response.data[0].Id);
							$("#codigo").val(response.data[0].Codigo);
							$("#nombre").val(response.data[0].Nombre);
							$("#inos").val(response.data[0].INOS);
							$("#_677").val(response.data[0]._677);
							$("#u-gastos").val(response.data[0].UGastos);
							$("#u-honorarios").val(response.data[0].UHonorarios);
							$("#area").val(response.data[0].Area);
							$("#complejidad").val(response.data[0].Complejidad);
							$("#inos-reducido").val(response.data[0].INOSReducido);
							$("#no-nomenclada").val(response.data[0].NoNomenclada);
							$("#tiempo-realizacion").val(response.data[0].TiempoRealizacion);
							$("#id-muestra").val(response.data[0].IdMuestra);
							$("#proceso").val(response.data[0].Proceso);
							$("#lista").val(response.data[0].Lista);
							$("#codigo-nomen-faba").val(response.data[0].CodigoFABA);
							$("#nivel").val(response.data[0].Nivel);
							$("#ria").val(response.data[0].RIA);
							$("#nbu-frecuencia").val(response.data[0].NBUFrecuencia);
							$("#nbu-codigo").val(response.data[0].NBUCodigo);
							$("#cantidad").val(response.data[0].Cantidad);

							$("#row-determinaciones").empty();
							
							if (response.determinaciones)
							{
								$.each(response.determinaciones, function(index, item){
									$("#agregar-determinacion").click();

									var determinacion = $("#row-determinaciones section")[index];
									//console.log(determinacion);
									$(determinacion).find("#determinacion").attr("data-id", item.Id);
									$(determinacion).find("#determinacion").val(item.NombreDeterminacion);
									$(determinacion).find("#seccion").val(item.Seccion);
									$(determinacion).find("#orden").val(item.Orden);
								});								
							}
						}
						else
						{
							$("#body-nomencladores").empty();
							$.each(response.data, function(index, item){
								$("#body-nomencladores").append("<tr id=\""+item.Id+"\">"+
																	"<td>"+item.Codigo+"</td>"+
																	"<td>"+item.Nombre+"</td>"+
																"</tr>");
							});
							$("#modal-nomencladores").modal("show");
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
							content : "No se pueden obtener los nomencladores.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			})
			key.preventDefault();
		}
	}
});

$("#body-nomencladores").unbind("click").click(function(e){
	var fila = e.target.parentElement;
	
	seleccionarNomenclador(fila.id);
	$("#modal-nomencladores").modal("hide");
});

function seleccionarNomenclador(id){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladores/"+id,
		dataType: "json",		
		headers: {"Authorization": $.cookie("ApiKey")},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "")
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador de trabajo elegido, ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					$("#buscar-nomenclador").val();
					$("#buscar-nomenclador").attr("data-id", "");
				}
			}
			else
			{
				$("#form-nomencladores :input").prop("disabled", false);
				$("#modificar").prop("disabled", true);

				$("#buscar-nomenclador").attr("data-id", response.data[0].Id);
				$("#codigo").val(response.data[0].Codigo);
				$("#nombre").val(response.data[0].Nombre);
				$("#inos").val(response.data[0].INOS);
				$("#_677").val(response.data[0]._677);
				$("#u-gastos").val(response.data[0].UGastos);
				$("#u-honorarios").val(response.data[0].UHonorarios);
				$("#area").val(response.data[0].Area);
				$("#complejidad").val(response.data[0].Complejidad);
				$("#inos-reducido").val(response.data[0].INOSReducido);
				$("#no-nomenclada").val(response.data[0].NoNomenclada);
				$("#tiempo-realizacion").val(response.data[0].TiempoRealizacion);
				$("#id-muestra").val(response.data[0].IdMuestra);
				$("#proceso").val(response.data[0].Proceso);
				$("#lista").val(response.data[0].Lista);
				$("#codigo-nomen-faba").val(response.data[0].CodigoFABA);
				$("#nivel").val(response.data[0].Nivel);
				$("#ria").val(response.data[0].RIA);
				$("#nbu-frecuencia").val(response.data[0].NBUFrecuencia);
				$("#nbu-codigo").val(response.data[0].NBUCodigo);
				$("#cantidad").val(response.data[0].Cantidad);

				if (response.determinaciones)
				{
					$.each(response.determinaciones, function(index, item){
						$("#agregar-determinacion").click();

						var determinacion = $("#row-determinaciones section")[index];
						//console.log(determinacion);
						$(determinacion).find("#determinacion").attr("data-id", item.Id);
						$(determinacion).find("#determinacion").val(item.NombreDeterminacion);
						$(determinacion).find("#seccion").val(item.Seccion);
						$(determinacion).find("#orden").val(item.Orden);
					});			
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
					content : "No se pueden obtener el nomenclador.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#modificar").click(function(e){
	$("#modificar").prop("disabled", true);

	var determinaciones = $("#row-determinaciones #determinacion");	
	var secciones = $("#row-determinaciones #seccion");
	var ordenes = $("#row-determinaciones #orden");
	for (var i = 0; i < determinaciones.length; i++) 
	{
		if (determinaciones[i].value === "" || secciones[i].value === "" || ordenes[i].value === "")
		{
			$.bigBox({
				title : "Error",
				content : "Asegúrese de completar todos los campos de determinaciones que existen antes de continuar.",
				color : "#C46A69",
				timeout: 8000,
				icon : "fa fa-warning shake animated"
			});
			$("#modificar").prop("disabled", false);
			return;
		}
	}

	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/nomencladores/modificar",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				$("#modificar").prop("disabled", false);
				if (response.data === "No existe el nomenclador.")
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador que trata de modificar ya no existe.<br>Por favor, seleccione otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					actualizarNomencladores();
					$("#form-nomencladores").get(0).reset();
					$("#form-nomencladores :input").prop("disabled", true);
					$("#buscar-nomenclador").prop("disabled", false);
					$("#buscar-nomenclador").focus();
				}
				if (response.data === "Código de nomenclador repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El código de nomenclador ingresado está repetido.<br>Por favor, ingrese otro.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
					$("#codigo").val("");
					$("#codigo").focus();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "El nomenclador se ha modificado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});				
				$("#form-nomencladores").get(0).reset();
				$("#form-nomencladores :input").prop("disabled", true);
				$("#buscar-nomenclador").prop("disabled", false);
				$("#buscar-nomenclador").focus();
				resetDeterminaciones();
			}
		},
		error: function(error){
			$("#modificar").prop("disabled", false);
			console.log(error);
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
				arr = ["Nombre", "INOS", "_677", "UGastos", "UHonorarios", "Area", "Complejidad", "INOSReducido", "NoNomenclada", "TiempoRealizacion", "IdMuestra", "Proceso", "Lista", "CodigoFABA", "Nivel", "RIA", "NBUFrecuencia", "NBUCodigo", "Cantidad"];		
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
				Errores = Errores.replace("Nombre", "nombre de nomenclador");
				Errores = Errores.replace("_677", "677");
				Errores = Errores.replace("UGastos", "unidad de gastos");
				Errores = Errores.replace("UHonorarios", "unidad de honorarios");
				Errores = Errores.replace("INOSReducido", "INOS reducido");
				Errores = Errores.replace("NoNomenclada", "no nomenclada");
				Errores = Errores.replace("TiempoRealizacion", "tiempo de realización");
				Errores = Errores.replace("IdMuestra", "id de muestra");
				Errores = Errores.replace("CodigoFABA", "código de nomenclador FABA");
				Errores = Errores.replace("NBUFrecuencia", "frecuencia NBU");
				Errores = Errores.replace("NBUCodigo", "código NBU");
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
	$("#modificar").prop("disabled", false);
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
		det.push(section.childNodes[0].childNodes[1].childNodes[0].attributes[4].value);
		det.push(section.childNodes[0].childNodes[1].childNodes[0].value);
		det.push(section.childNodes[1].childNodes[1].childNodes[0].value);
		det.push(section.childNodes[2].childNodes[1].childNodes[0].value);

		determinaciones.push(det);
	}		

	return JSON.stringify({
		"Id": $("#buscar-nomenclador").data("id"),
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
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar-nomenclador").focus();				
		}
	}
});

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
	habilitarModificar();
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

$("#inos").on("input", function(){
	habilitarModificar();
});

$("#_677").on("input", function(){
	habilitarModificar();
});

$("#u-gastos").on("input", function(){
	habilitarModificar();
});

$("#u-honorarios").on("input", function(){
	habilitarModificar();
});

$("#area").on("input", function(){
	habilitarModificar();
});

$("#complejidad").on("input", function(){
	habilitarModificar();
});

$("#inos-reducido").on("input", function(){
	habilitarModificar();
});

$("#tiempo-realizacion").on("input", function(){
	habilitarModificar();
});

$("#id-muestra").on("input", function(){
	habilitarModificar();
});

$("#proceso").on("input", function(){
	habilitarModificar();
});

$("#lista").on("input", function(){
	habilitarModificar();
});

$("#codigo-nomen-faba").on("input", function(){
	habilitarModificar();
});

$("#nivel").on("input", function(){
	habilitarModificar();
});

$("#ria").on("input", function(){
	habilitarModificar();
});

$("#nbu-frecuencia").on("input", function(){
	habilitarModificar();
});

$("#nbu-codigo").on("input", function(){
	habilitarModificar();
});

$("#cantidad").on("input", function(){
	habilitarModificar();
});

$("#row-determinaciones #determinacion").on("input", function(){
	habilitarModificar();
});

$("#row-determinaciones #seccion").on("input", function(){
	habilitarModificar();
});

$("#row-determinaciones #orden").on("input", function(){
	habilitarModificar();
});

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
	if ($("#inos").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#_677").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#u-gastos").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#u-honorarios").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#area").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#complejidad").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#inos-reducido").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#tiempo-realizacion").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#id-muestra").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#proceso").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#lista").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#codigo-nomen-faba").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nivel").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#ria").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nbu-frecuencia").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#nbu-codigo").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if ($("#cantidad").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	var determinaciones = $("#row-determinaciones #determinacion");
	var secciones = $("#row-determinaciones #secciones");
	var ordenes = $("#row-determinaciones #ordenes");

	if (determinaciones.val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if (secciones.val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
	if (ordenes.val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}

	$("#modificar").prop("disabled", false);
}