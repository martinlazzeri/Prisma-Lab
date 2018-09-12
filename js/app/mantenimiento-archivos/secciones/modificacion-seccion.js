$(document).ready(function(){
	$("#div_determinaciones").focus();
	
	resetDeterminaciones();
});

function resetDeterminaciones(){
	var count_div = $("#div_determinaciones :input").length;
	
	$("#div_determinaciones").empty();
	$("#div_determinaciones").append("<div class=\"form-group\" data-div=\"divisor\">"+
										"<label class=\"col-md-2 control-label\">"+(count_div + 1)+"</label>"+
										"<div class=\"col-md-2\">"+
											"<input data-id=\""+(count_div)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\" disabled>"+
											"<button onclick=\"borrarDeterminacion("+count_div+");\" disabled>X</button>"+
										"</div>"+
									"</div>");
}

$("#buscar_secciones").on("keypress", function(key){
	if ($(this).val() !== "")
	{
		if (key.which === 13)
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/secciones/buscarporcodigo",
				dataType: "json",
				data: JSON.stringify({"Codigo": $(this).val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos")
						{
							$.bigBox({
								title : "Error",
								content : "No se encontraron secciones que coincidan con los datos ingresados.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
					}
					else
					{
						if (response.cantidad == 1)
						{
							$("#codigo").val(response.data[0].Codigo);
							$("#codigo").attr("data-id", response.data[0].Id);
							$("#nombre").val(response.data[0].Nombre);							

							$.each(response.determinaciones, function(index, item){
								if (index == 0)
								{
									$(".det").val(item.Codigo);
									$(".det").attr("data-nomenclador", item.PracticaId);
									$(".det").attr("data-sp", item.Id);
								}
								else
								{
									agregarDeterminacion();
									$(".det[data-id="+index+"]").attr("data-nomenclador", item.PracticaId);
									$(".det[data-id="+index+"]").attr("data-sp", item.Id);
									$(".det[data-id="+index+"]").val(item.Codigo);
								}
							});
							$(":input").prop("disabled", false);
						}
						else
						{
							$("#body_secciones").empty();
							$.each(response.data, function(index, item){
								$("#body_secciones").append("<tr id=\""+item.Id+"\">"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.Nombre+"</td>"+
															"</tr>");
							});
							$("#modal_secciones").modal("show");
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
							content : "No se puede obtener la sección.",
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

function agregarDeterminacion(){
	var count_div = $("#div_determinaciones input").length;

	if (count_div == 24)
	{
		$.bigBox({
			title : "Error",
			content : "No es posible agregar mas de 24 determinaciones por sección.",
			color : "#C46A69",
			icon : "fa fa-warning shake animated",
			number : "1",
			timeout : 5000
		});
		return;
	}

	$("#div_determinaciones").append("<div class=\"form-group\" data-div=\"divisor\">"+
										"<label class=\"col-md-2 control-label\">"+ (count_div + 1) +"</label>"+
										"<div class=\"col-md-2\">"+
											"<input data-id=\""+(count_div)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\" data-nomenclador=\"0\" data-sp=\"0\">"+
											"<button onclick=\"borrarDeterminacion("+count_div+");\" disabled>X</button>"+
										"</div>"+
									"</div>");
	$(".det[data-id="+(count_div + 1)+"]").focus();

	$(".det").bind("keypress", enterPress);
	$(".det").bind("blur", focusOut);
}

$(".det").bind("keypress", enterPress);
$(".det").bind("blur", focusOut);

function borrarDeterminacion(id){
	var count_div = $("[data-div=divisor]");
	
	if (count_div.length == 1)
	{
		$.bigBox({
			title : "Error",
			content : "No se puede borrar. Debe haber al menos una determinación.",
			color : "#C46A69",
			icon : "fa fa-warning shake animated",
			timeout : 5000
		});
	}

	$(count_div[id]).remove();

	event.preventDefault();
}

function enterPress(key){
	var id = $(this).attr("data-id");
	if ($(this).val() !== "")
	{
		if (key.which === 13)
		{			
			$.ajax({
				type: 'POST',
				contentType: 'application/json',
				url: 'api/nomencladores/buscarpornombre',
				dataType: 'json',
				data: JSON.stringify({"Nombre": $(this).val()}),
				headers: {"Authorization": $.cookie('ApiKey')},
				success: function(response){
					if (response.error === true)
					{
						if (response.data === "No se encontraron datos.")
						{

						}
					}
					else
					{						
						if (response.cantidad === 1)
						{
							$(".det[data-id="+id+"]").attr("data-nomenclador", response.data[0].Id);
							$(".det[data-id="+id+"]").val(response.data[0].Codigo);
						}
						else
						{
							$("#modal_nomencladores").attr("data-id", id);
							$("#body_nomencladores").empty();
							$.each(response.data, function(index, item){
								$("#body_nomencladores").append("<tr id=\""+item.Id+"\">"+
																	"<td>"+item.Codigo+"</td>"+
																	"<td>"+item.Nombre+"</td>"+
																"</tr>");
							});
							$("#modal_nomencladores").modal("show");
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
							content : "No se pueden obtener las determinaciones.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});		

			key.preventDefault();
		}
	}
}

function focusOut(){
	var id = $(this).attr("data-id");
	var codigo = $(this).val();
	var nomenclador = $(this).attr("data-nomenclador");

	if (codigo !== "" && nomenclador == undefined)
	{		
		$.ajax({
			type: 'POST',
			contentType: 'application/json',
			url: 'api/nomencladores/buscarpornombre',
			dataType: 'json',
			data: JSON.stringify({"Nombre": codigo}),
			headers: {"Authorization": $.cookie('ApiKey')},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "No se encontraron datos.")
					{
						$.bigBox({
							title : "Error",
							content : "El nomenclador seleccionado ya no existe. Por favor seleccione otro.",
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
						$(".det[data-id="+id+"]").attr("data-id", response.data[0].Id);
						$(".det[data-id="+id+"]").val(response.data[0].Codigo);
					}
					else
					{
						$("#modal_nomencladores").attr("data-id", id);
						$("#body_nomencladores").empty();
						$.each(response.data, function(index, item){
							$("#body_nomencladores").append("<tr id=\""+item.Id+"\">"+
																"<td>"+item.Codigo+"</td>"+
																"<td>"+item.Nombre+"</td>"+
															"</tr>");
						});
						$("#modal_nomencladores").modal("show");
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
						content : "No se pueden obtener las determinaciones.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
}

$("#body_nomencladores").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	seleccionarNomenclador(fila.id, $("#modal_nomencladores").attr("data-id"));
	$("#modal_nomencladores").modal("hide");
	$(".det[data-id="+$("#modal_nomencladores").attr("data-id")+"]").focus();
});

$("#body_secciones").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	seleccionarSeccion(fila.id, $("#modal_secciones").attr("data-id"));
	$("#modal_secciones").modal("hide");
	$(".det[data-id="+$("#modal_secciones").attr("data-id")+"]").focus();
});

function seleccionarNomenclador(id, index){
	$.ajax({
		type: 'GET',
		contentType: 'application/json',
		url: 'api/practicas/'+id,
		dataType: 'json',
		headers: {"Authorization": $.cookie('ApiKey')},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos.")
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador seleccionado ya no existe. Por favor seleccione otro.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{	
				$(".det[data-id="+index+"]").attr("data-sp", 0);
				$(".det[data-id="+index+"]").attr("data-nomenclador", response.data[0].Id);
				$(".det[data-id="+index+"]").val(response.data[0].Codigo);
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
					content : "No se pueden obtener las determinaciones.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

function seleccionarSeccion(id){
	$.ajax({
		type: 'GET',
		contentType: 'application/json',
		url: 'api/secciones/'+id,
		dataType: 'json',
		headers: {"Authorization": $.cookie('ApiKey')},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos para secciones Id.")
				{
					$.bigBox({
						title : "Error",
						content : "La sección que eligió ya no existe. Por favor seleccione otra.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{				
				$("#codigo").val(response.data[0].Codigo);
				$("#codigo").attr("data-id", response.data[0].Id);
				$("#nombre").val(response.data[0].Nombre);							

				$.each(response.determinaciones, function(index, item){
					if (index == 0)
					{
						$(".det").val(item.Codigo);
						$(".det").attr("data-nomenclador", item.PracticaId);
						$(".det").attr("data-sp", item.Id);
					}
					else
					{
						agregarDeterminacion();
						$(".det[data-id="+index+"]").attr("data-sp", item.Id);
						$(".det[data-id="+index+"]").attr("data-nomenclador", item.PracticaId);
						$(".det[data-id="+index+"]").val(item.Codigo);
					}
				});
				$(":input").prop("disabled", false);
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
					content : "No se puede obtener la sección.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#modificar").click(function(e){
	//$("#modificar").prop("disabled", true);

	var div = $("#div_determinaciones :input[type=text]");

	for (var i = 0; i < div.length; i++) 
	{
		if ($(div)[i].value === "")
		{
			$.bigBox({
				title : "Error",
				content : "Una o más determinaciones están vacías. Asegúrese de completar los datos antes de continuar.",
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
		url: "api/secciones/modificar",
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
						content : "La sección que intenta modificar ya no existe.<br>Por favor, seleccione otra.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					actualizarSecciones();
					$("#form-secciones :input").prop("disabled", true);
					$("#form-secciones").get(0).reset();
					$("#buscar-secciones").prop("disabled", false);
				}
				if (response.data === "Código de sección repetido")
				{
					$.bigBox({
						title : "Error",
						content : "El código de sección ingresado está repetido.<br>Por favor, ingrese otro.",
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
					content : "La sección se ha modificó correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				$("#div_determinaciones").empty();
				resetDeterminaciones();
				$("#form-secciones :input").prop("disabled", true);
				$("#buscar_secciones").prop("disabled", false);
				$("#form-secciones").get(0).reset();
				$("#buscar_secciones").focus();
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
				arr = ["Codigo", "Nombre"];
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
	e.preventDefault();
})

function FormToJSON(){
	var determinaciones = [];
	var array_det = $("#div_determinaciones :input");
	
	for (var i = 0; i < array_det.length; i++) 
	{
		if ($(array_det)[i].attributes[5])
		{
			var determinacion = [];

			determinacion.push($(array_det)[i].attributes[6].value);
			determinacion.push($(array_det)[i].attributes[5].value);
			determinaciones.push(determinacion);
		}
	}

	return JSON.stringify({
		"Id": $("#codigo").attr("data-id"),
		"Codigo": $("#codigo").val(),
		"Nombre": $("#nombre").val(),
		"Determinaciones": determinaciones,
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#modificar").on("keydown", function(key){
	if ($("#modificar").prop("disabled") === false)
	{
		if (key.which === 9) 
		{
			$("#buscar-secciones").focus();
			key.preventDefault();
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

$("#buscar-secciones").on("input", function(){
	habilitarModificar();
});

$("#codigo").on("input", function(){
	habilitarModificar();
});

$("#nombre").on("input", function(){
	habilitarModificar();
});

function habilitarModificar(){
	if ($("#buscar-secciones").val() === "")
	{
		$("#modificar").prop("disabled", true);
		return;
	}
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

	$("#modificar").prop("disabled", false);
}