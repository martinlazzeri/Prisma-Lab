$(document).ready(function(){
	$("#codigo").focus();
	
	resetDeterminaciones();
});

function resetDeterminaciones(){
	var count_div = $("#div_determinaciones :input").length;
	
	$("#div_determinaciones").empty();
	$("#div_determinaciones").append("<div class=\"form-group\">"+
										"<label class=\"col-md-2 control-label\">"+(count_div + 1)+"</label>"+
										"<div class=\"col-md-1\">"+
											"<input data-id=\""+(count_div + 1)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\">"+
										"</div>"+
									"</div>");
}

function agregarDeterminacion(){
	$("#agregar_det").click();
}

$("#agregar_det").on("click", function(){
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

	$("#div_determinaciones").append("<div class=\"form-group\">"+
										"<label class=\"col-md-2 control-label\">"+ (count_div + 1) +"</label>"+
										"<div class=\"col-md-1\">"+
											"<input data-id=\""+(count_div + 1)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\">"+
										"</div>"+
									"</div>");

	$(".det[data-id="+(count_div + 1)+"]").focus();

	$(".det").bind("keypress", enterPress);
	$(".det").bind("blur", focusOut);
});

$(".det").bind("keypress", enterPress);
$(".det").bind("blur", focusOut);

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


$("#ingresar").click(function(e){
	var array_det = $("#div_determinaciones :input");
	
	for (var i = 0; i < array_det.length; i++) 
	{
		if($(array_det)[i].value == "")
		{
			$.bigBox({
				title : "Error",
				content : "No se completaron los campos de determinación. Asegúrese de completar todos los campos.",
				color : "#C46A69",
				timeout: 8000,
				icon : "fa fa-warning shake animated"
			});
			return;
		}
	};

	$("#ingresar").prop("disabled", true);
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/secciones/crear",
		dataType: "json",
		data: FormToJSON(),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){				
			if (response.error == true) 
			{
				if (response.data == "Código de sección repetido") 
				{
					$.bigBox({
						title : "Error",
						content : "El código ingresado, ya se corresponde a una sección existente. <br>Por favor, ingrese otro.",
						color : "#C46A69",
						icon : "fa fa-warning shake animated",
						number : "1",
						timeout : 5000
					});
					$("#codigo").val("");
					$("#codigo").focus();
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "La sección se ha creado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				resetDeterminaciones();
				$("#form-secciones").get(0).reset();
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
	$("#ingresar").prop("disabled", false);
	e.preventDefault();
});

function FormToJSON(){
	var determinaciones = [];
	var array_det = $("#div_determinaciones input");
	
	for (var i = 0; i < array_det.length; i++) 
	{
		if ($(array_det)[i].attributes[5])
		{
			determinaciones.push($(array_det)[i].attributes[5].value);
		}
	}
	//console.log(determinaciones);
	//return;

	return JSON.stringify({
		"Codigo": $("#codigo").val(),
		"Nombre": $("#nombre").val(),
		"Determinaciones": determinaciones,
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

$("#nombre").keypress(function(key){
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

	$("#ingresar").prop("disabled", false);
}