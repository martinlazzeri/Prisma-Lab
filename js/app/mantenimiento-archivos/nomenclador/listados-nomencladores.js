$(document).ready(function(){
	actualizarNomencladores(1);		
});

$("#body-nomencladores").css("cursor", "pointer");

$("#buscar").click(function(e){		
	actualizarNomencladores(1);
	e.preventDefault();
});

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarNomencladores(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarNomencladores(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

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

function actualizarNomencladores(offset){
	$("#buscar").prop("disabled", true);
	if ($("#todos").is(":checked"))
	{
		$.ajax({
			type: "POST",
			contentType: "application/json",
			url: "api/nomencladores",
			dataType: "json",
			data: JSON.stringify({"Offset": offset}),
			beforeSend: function(xhr){
				$("#body-nomencladores").empty();
				$("#spinner").show();
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "No se encontraron datos.")
					{
						$.bigBox({
							title : "Error",
							content : "No se encontraron nomencladores registrados.",
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
					$("#body-nomencladores").empty();
					var rows = "";
					$.each(response.data, function(index, item){
						item.INOSReducido === 0 ? inosR = "No" : inosR = "Sí";
						item.NoNomenclada === 0 ? noNomen = "No" : noNomen = "Sí";
						rows += "<tr id=\""+item.Id+"\">"+
									"<td>"+item.Codigo+"</td>"+
									"<td>"+item.Nombre+"</td>"+
									"<td>"+inosR+"</td>"+
									"<td>"+noNomen+"</td>"+
									"<td>"+item.Area+"</td>"+
									"<td>"+item.Complejidad+"</td>"+
									"<td>"+item.UHonorarios+"</td>"+
									"<td>"+item.UGastos+"</td>"+
									"<td>"+item.NBUCodigo+"</td>"+
									"<td>"+item.Nivel+"</td>"+
								"</tr>";
					});
					$("#body-nomencladores").append(rows);
					$("#spinner").hide()
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
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
	if ($("#alfabetico").is(":checked"))
	{
		$.ajax({
			type: "POST",
			contentType: "application/json",
			url: "api/nomencladores/alfabetico",
			dataType: "json",
			data: JSON.stringify({"Offset": offset}),
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
							content : "No se encontraron nomencladores registrados.",
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
					$("#body-nomencladores").empty();
					var rows = "";
					$.each(response.data, function(index, item){
						item.INOSReducido === 0 ? inosR = "No" : inosR = "Sí";
						item.NoNomenclada === 0 ? noNomen = "No" : noNomen = "Sí";
						rows += "<tr id=\""+item.Id+"\">"+
									"<td>"+item.Codigo+"</td>"+
									"<td>"+item.Nombre+"</td>"+
									"<td>"+inosR+"</td>"+
									"<td>"+noNomen+"</td>"+
									"<td>"+item.Area+"</td>"+
									"<td>"+item.PMO+"</td>"+
									"<td>"+item.UHonorarios+"</td>"+
									"<td>"+item.UGastos+"</td>"+
									"<td>"+item.Codigo+"</td>"+
									"<td>"+item.Nivel+"</td>"+
								"</tr>";
					});
					$("#body-nomencladores").append(rows);
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
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
	$("#buscar").prop("disabled", false);
}

$(document).unbind("click").on("click", "tr", function(e){
	var fila = e.currentTarget;

	mostrarNomenclador("seleccionar nomenclador", fila);
});

function mostrarNomenclador(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladores/"+$(fila).prop("id"),
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
						content : "El nomenclador indicado, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				var complejidad;
				switch(response.data[0].Complejidad) 
				{
				    case 0:
				        complejidad = "No considerar";
				        break;
				    case 1:
				        complejidad = "Mediana";
				        break;
				    case 2:
				        complejidad = "Compuesta";
				        break;
				    case 3:
				        complejidad = "Baja";
				        break;
				    case 4:
				        complejidad = "Alta";
				        break;
				}

				var inosReducido;
				switch(response.data[0].INOSReducido) 
				{
				    case 0:
				        inosReducido = "No";
				        break;
				    case 1:
				        inosReducido = "Si";
				        break;
				}

				var noNomenclada;
				switch(response.data[0].NoNomenclada) 
				{
				    case 0:
				        noNomenclada = "No";
				        break;
				    case 1:
				        noNomenclada = "Si";
				        break;
				}

				var ria;
				switch(response.data[0].RIA) 
				{
				    case 0:
				        ria = "No";
				        break;
				    case 1:
				        ria = "Si";
				        break;
				}

				var nbuFrecuencia;
				switch(response.data[0].NBUFrecuencia) 
				{
				    case 0:
				        nbuFrecuencia = "Alta";
				        break;
				    case 1:
				        nbuFrecuencia = "Baja";
				        break;
				    case 2:
				        nbuFrecuencia = "PMOE";
				        break;
				}

				$(".modal-body #codigo").text(response.data[0].Codigo);
				$(".modal-body #nombre").text(response.data[0].Nombre);
				$(".modal-body #inos").text(response.data[0].INOS);
				$(".modal-body #_677").text(response.data[0]._677);
				$(".modal-body #u-gastos").text(response.data[0].UGastos);
				$(".modal-body #u-honorarios").text(response.data[0].UHonorarios);
				$(".modal-body #area").text(response.data[0].Area);
				$(".modal-body #complejidad").text(complejidad);
				$(".modal-body #inos-reducido").text(inosReducido);
				$(".modal-body #no-nomenclada").text(noNomenclada);
				$(".modal-body #tiempo-realizacion").text(response.data[0].TiempoRealizacion);
				$(".modal-body #id-muestra").text(response.data[0].IdMuestra);
				$(".modal-body #proceso").text(response.data[0].Proceso);
				$(".modal-body #lista").text(response.data[0].Lista);
				$(".modal-body #codigo-nomen-faba").text(response.data[0].CodigoFABA);
				$(".modal-body #nivel").text(response.data[0].Nivel);
				$(".modal-body #ria").text(ria);
				$(".modal-body #nbu-frecuencia").text(nbuFrecuencia);
				$(".modal-body #nbu-codigo").text(response.data[0].NBUCodigo);
				$(".modal-body #cantidad").text(response.data[0].Cantidad);				

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
					content : "No se puede obtener el nomenclador.",
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