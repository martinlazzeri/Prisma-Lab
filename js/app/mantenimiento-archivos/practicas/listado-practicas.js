$(document).ready(function(){
	actualizarPracticas(1);
	actualizarMutuales();
});

$("#body-practicas").css("cursor", "pointer");

function SwitchAnterior(pagina){
	switch (parseInt(pagina)){
		case 1: $("#li-anterior").prop("class", "disabled");
			break;			
		default:
			$("#li-anterior").prop("class", "");				
	}
}

function SwitchSiguiente(ultimaPag){
	switch (ultimaPag){
		case true: $("#li-siguiente").prop("class", "disabled");
			break;			
		default:
			$("#li-siguiente").prop("class", "");				
	}
}

$("#buscar").click(function(e){
	$("#buscar").prop("disabled", true);
	actualizarPracticas(1);
	e.preventDefault();
	$("#buscar").prop("disabled", false);
});	

function actualizarPracticas(offset){
	if ($("#todos").is(":checked")) 
	{
		$.ajax({
			type: "POST",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/",
			dataType: "json",
			data: JSON.stringify({"Offset": offset}),
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
							content : "No se encontraron nomencladores especiales registrados.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
				else
				{
					offset < 1 ? $("#num-pagina").text(1) : $("#num-pagina").text(offset);
					SwitchAnterior($("#num-pagina").text());
					SwitchSiguiente(response.ultimaPag);
					$("#body-practicas").empty();
					var row = "";
					$.each(response.data, function(index, item){						
						row += "<tr id="+item.Id+">"+
									"<td>"+item.A+"</td>"+
									"<td>"+item.Nombre+"</td>"+
									"<td>"+item.Codigo+"</td>"+
									"<td>"+item.UnidadGasto+"</td>"+
									"<td>"+item.UnidadHonorario+"</td>"+
									"<td>"+item.Nivel+"</td>"+									
							   "</tr>";						
					});					
					$("#body-practicas").append(row);
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
						content : "No se pudieron obtener los nomencladores especiales.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
	if ($("#por-mutual").is(":checked"))
	{
		if ($("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value") !== undefined && $("#buscar_mutual").val() !== "")
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/nomencladoresespeciales/nomenpormutual",
				dataType: "json",
				data: JSON.stringify({"MutualId": $("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value"),
									  "Offset": offset}),
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
								content : "No se encontraron nomencladores especiales asociados a la mutual elegida.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
						}
						if (response.data === "La mutual no existe")
						{
							$.bigBox({
								title : "Error",
								content : "La mutual elegida ya no existe.<br>Por favor, seleccione otra.",
								color : "#C46A69",
								timeout: 8000,
								icon : "fa fa-warning shake animated"
							});
							$("#buscar_mutual").val("");
							$("#buscar_mutual").focus();
							actualizarMutuales();
						}
					}
					else
					{
						$("#body-practicas").empty();
						row = "";
						$.each(response.data, function(index, item){
							row += "<tr id="+item.Id+">"+
									"<td>"+item.A+"</td>"+
									"<td>"+item.Nombre+"</td>"+
									"<td>"+item.Codigo+"</td>"+
									"<td>"+item.UnidadGasto+"</td>"+
									"<td>"+item.UnidadHonorario+"</td>"+
									"<td>"+item.Nivel+"</td>"+									
							   "</tr>";		
						});
						$("#body-practicas").append(row);
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
							content : "No se pudieron obtener los nomencladores especiales.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			})
		}
		else
		{
			$.bigBox({
				title : "Error",
				content : "Para listar nomencladores especiales por mutual, asegúrese que el campo de mutual no está vacío y que contiene datos reales.",
				color : "#C46A69",
				timeout : 8000,
				icon : "fa fa-warning shake animated"
			});
		}
	}		
}

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarPracticas(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarPracticas(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

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
				if (response.data === "No se han econtrado datos") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron mutuales registradas.",
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
					$("#list_mutuales").append("<option data-value=\""+item.Id+"\" value=\""+item.Nombre+"\"></option>");
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
					content : "No se pudieron obtener las mutuales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("input[name='radio-inline']").on("click", function () {
	$("#footer").show();
    switch (this.id){
    	case "por-mutual": $("#form-mutual").show();
    					   $("#buscar_mutual").val("");
    				 break;
    	default:
    		$("#form-mutual").hide();
    }
});

$(document).unbind("click").on("click", "tr", function(e){
	var fila = e.currentTarget;

	mostrarPractica("seleccionar practica", fila);
});

function mostrarPractica(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladoresespeciales/"+$(fila).prop("id"),
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true) 
			{
				if (response.data === "No se encontraron datos.")
				{
					$.bigBox({
						title : "Error",
						content : "El nomenclador especial indicado, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$(".modal-body #nombre-mutual").text(response.data[0].CodMutual+" - "+response.data[0].NombreMutual);
				$(".modal-body #nombre").text(response.data[0].Nombre);
				$(".modal-body #a").text(response.data[0].A);
				$(".modal-body #codigo").text(response.data[0].Codigo);
				$(".modal-body #unidad-gasto").text(response.data[0].UnidadGasto);
				$(".modal-body #unidad-honorario").text(response.data[0].UnidadHonorario);
				$(".modal-body #nivel").text(response.data[0].Nivel);

				$("#mostrar-info").modal("show");
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
					content : "No se puede obtener el nomenclador especial.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar_mutual").on("keypress", function(key){
	if (key.which === 13) 
	{
		if ($("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value") !== undefined && $("#buscar_mutual").val() !== "")
		{
			$("#buscar").click();
		}
	}
	key.preventDefault();
});

$("#form-listado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});