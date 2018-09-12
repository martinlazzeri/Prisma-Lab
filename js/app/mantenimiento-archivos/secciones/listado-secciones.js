$(document).ready(function(){
	actualizarSecciones(1);
});

$("#body-secciones").css("cursor", "pointer");

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
		actualizarSecciones(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarSecciones(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

function actualizarSecciones(offset){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/secciones",
		dataType: "json",
		data: JSON.stringify({"Offset": offset}),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data = "No se encontraron datos para secciones en general.")
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron secciones registradas.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				offset < 1 ? $("#num-pagina").text(1) : $("#num-pagina").text(offset);
				SwitchAnterior($("#num-pagina").text());
				SwitchSiguiente(response.ultimaPag);
				$("#body-secciones").empty();
				var rows = "";
				$.each(response.data, function(index, item){

					rows += "<tr id=\""+item.Id+"\">"+
								"<td>"+item.Codigo+"</td>"+
								"<td>"+item.Nombre+"</td>";
								if (item.determinaciones)
								{
									$.each(item.determinaciones, function(ind, itm){
										rows += "<td>"+itm.Codigo+"</td>";
									});

									for (var i = item.determinaciones.length; i < 24; i++) {
										rows += "<td>-</td>";
									};
								}
								else
								{
									rows += "<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>"+
											"<td>-</td>";
								}
					rows += "</tr>";
				});
				$("#body-secciones").append(rows);
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
					content : "No se pudieron obtener las secciones.",
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

	mostrarSeccion("seleccionar seccion", fila)
});

function mostrarSeccion(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/secciones/"+$(fila).prop("id"),
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
						content : "La sección indicada, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$(".modal-body #nombre").text(response.data[0].Nombre);

				if (response.determinaciones)
				{
					alert("entro en determinaciones");
					$.each(response.determinaciones, function(index, item){
						var det = "#det"+index;
						alert(det);
						$(det).text(item.Codigo);
					});

					for (var i = response.determinaciones.length; i < 24; i++) 
					{
						$("#det"+i).text("---");
					};
				}
				else
				{
					alert("entro en el else");
					for (var i = 1; i < 25; i++) {
						$("#det"+i).text("---");
					};
				}

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
					content : "No se puede obtener la sección.",
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