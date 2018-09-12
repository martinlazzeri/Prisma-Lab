$(document).ready(function(){
	actualizarTitulos(1);
});

$("#body-titulos").css("cursor", "pointer");

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

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarTitulos(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarTitulos(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

function actualizarTitulos(offset){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/titulos",
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
						content : "No hay títulos registrados.",
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
				var rows = "";
				$.each(response.data, function(index, item){						
					item.ValorMinimo == "" ? valMin = "No especifica" : valMin = item.ValorMinimo;
					item.ValorMaximo == "" ? valMax = "No especifica" : valMax = item.ValorMaximo;
					rows += "<tr id=\""+item.Id+"\">"+
								"<td>"+item.Codigo+"</td>"+
								"<td>"+item.Descripcion+"</td>"+
								"<td>"+item.Tipo+"</td>"+
								"<td>"+item.Unidades+"</td>"+
								"<td>"+item.Rango+"</td>"+
								"<td>"+item.LineaTexto1+"</td>"+
								"<td>"+item.LineaTexto2+"</td>"+
								"<td>"+item.LineaTexto3+"</td>"+
								"<td>"+item.LineaTexto4+"</td>"+
								"<td>"+item.ValoresReferenciaAmpliados+"</td>"+
								"<td>"+valMin+"</td>"+
								"<td>"+valMax+"</td>"+									
							"</tr>";
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");
							rows = rows.replace(null, "No especifica");															
				});
				$("#body-titulos").append(rows);
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
					content : "No se pueden obtener los títulos.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$(document).unbind("click").on("click", "tr", function(e){
	var fila = e.currentTarget;

	mostrarTitulo("seleccionar titulo", fila);
});

function mostrarTitulo(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/titulos/"+$(fila).prop("id"),
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
						content : "El título indicado, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$(".modal-body #codigo").val(response.data[0].Codigo);
				response.data[0].Descripcion == null ? $(".modal-body #descripcion").val("No especifica") : $(".modal-body #descripcion").val(response.data[0].Descripcion);
				response.data[0].Tipo == null ? $(".modal-body #tipo-titulo").prop("selectedIndex", "") : $(".modal-body #tipo-titulo").val(response.data[0].Tipo);
				response.data[0].Unidades == null ? $(".modal-body #unidades").val("No especifica") : $(".modal-body #unidades").val(response.data[0].Unidades);
				response.data[0].Rango == null ? $(".modal-body #rango").val("No especifica") : $(".modal-body #rango").val(response.data[0].Rango);
				response.data[0].LineaTexto1 == null ? $(".modal-body #linea1").val("No especifica") : $(".modal-body #linea1").val(response.data[0].LineaTexto1);
				response.data[0].LineaTexto2 == null ? $(".modal-body #linea2").val("No especifica") : $(".modal-body #linea2").val(response.data[0].LineaTexto2);
				response.data[0].LineaTexto3 == null ? $(".modal-body #linea3").val("No especifica") : $(".modal-body #linea3").val(response.data[0].LineaTexto3);
				response.data[0].LineaTexto4 == null ? $(".modal-body #resultado").val("No especifica") : $(".modal-body #resultado").val(response.data[0].LineaTexto4);
				response.data[0].ValoresReferenciaAmpliados == null ? $(".modal-body #valores-referencia").val("No especifica") : $(".modal-body #valores-referencia").val(response.data[0].ValoresReferenciaAmpliados);
				response.data[0].ValorMinimo == "" ? $(".modal-body #valor-minimo").val("No especifica") : $(".modal-body #valor-minimo").val(response.data[0].ValorMinimo);
				response.data[0].ValorMaximo == "" ? $(".modal-body #valor-maximo").val("No especifica") : $(".modal-body #valor-maximo").val(response.data[0].ValorMaximo);

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
					content : "No se puede obtener el título.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#form-listado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});