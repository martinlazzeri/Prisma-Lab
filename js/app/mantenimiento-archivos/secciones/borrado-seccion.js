$(document).ready(function(){
	$("#buscar_secciones").focus();
	
	resetDeterminaciones();
});

function resetDeterminaciones(){
	var count_div = $("#div_determinaciones :input").length;
	
	$("#div_determinaciones").empty();
	$("#div_determinaciones").append("<div class=\"form-group\">"+
										"<label class=\"col-md-2 control-label\">"+(count_div + 1)+"</label>"+
										"<div class=\"col-md-1\">"+
											"<input data-id=\""+(count_div)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\" disabled>"+
										"</div>"+
									"</div>");
}



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

	$("#div_determinaciones").append("<div class=\"form-group\">"+
										"<label class=\"col-md-2 control-label\">"+ (count_div + 1) +"</label>"+
										"<div class=\"col-md-1\">"+
											"<input data-id=\""+(count_div)+"\" class=\"form-control det\" type=\"text\" placeholder=\"XXX\" maxlength=\"3\" disabled>"+
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
									$(".det").attr("data-nomenclador", item.Id);
								}
								else
								{
									agregarDeterminacion();
									$(".det[data-id="+index+"]").attr("data-nomenclador", item.Id);
									$(".det[data-id="+index+"]").val(item.Codigo);
								}
							});
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

$("#body_secciones").unbind("click").click(function(e){
	var fila = e.target.parentElement;

	seleccionarSeccion(fila.id, $("#modal_secciones").attr("data-id"));
	$("#modal_secciones").modal("hide");
	$(".det[data-id="+$("#modal_secciones").attr("data-id")+"]").focus();
});

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
						$(".det").attr("data-nomenclador", item.Id);
					}
					else
					{
						agregarDeterminacion();
						$(".det[data-id="+index+"]").attr("data-nomenclador", item.Id);
						$(".det[data-id="+index+"]").val(item.Codigo);
					}
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
					content : "No se puede obtener la sección.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	$.ajax({
		type: "DELETE",
		contentType: "application/json",
		url: "api/secciones/eliminar",
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
						content : "La sección que intenta eliminar ya no existe.<br>Por favor, seleccione otra.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
					actualizarSecciones();
					$("#eliminar").prop("disabled", true);
					$("#form-secciones").get(0).reset();
					$("#codigo").val("");
				}
			}
			else
			{
				$.bigBox({
					title : "Éxito",
					content : "La sección se ha eliminó correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});
				resetDeterminaciones();
				$("#eliminar").prop("disabled", true);					
				$("#form-secciones").get(0).reset();
				$("#buscar_secciones").focus();
			}
		},
		error: function(error){
			$("#eliminar").prop("disabled", false);
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
				arr = ["Id", "ModificadoPor"];
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
	return JSON.stringify({
		"Id": $("#codigo").attr("data-id"),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#codigo").focus();
			key.preventDefault();
		}
	}
});