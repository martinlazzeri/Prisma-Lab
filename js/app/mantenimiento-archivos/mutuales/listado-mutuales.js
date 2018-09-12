$(document).ready(function(){
	actualizarMutuales(1);
});

$("#body-mutuales").css("cursor", "pointer");

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

function actualizarMutuales(offset){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/mutuales/",
		dataType: "json",
		data: JSON.stringify({"Offset": offset}),
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
						content : "No se encontraron obras sociales.",
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
				$("#body-mutuales").empty();
				var row = "";
				$.each(response.data, function(index, item){
					var abonodom = ""; item.AbonoDomicilio === 1 ? abonodom = "Sí" : abonodom = "No";
					var pmo = ""; item.PMO === 1 ? pmo = "Sí" : pmo = "No";
					var coseguro = ""; item.CobroCoseguro === 1 ? coseguro = "Sí" : coseguro = "No";
					var servicio = ""; item.ServicioCortado === 1 ? servicio = "Sí" : servicio = "No";
					var inos = ""; item.INOSReducido === 1 ? inos = "Sí" : inos = "No";
					var _677 = ""; item.Reconoce677 === 1 ? _677 = "Sí" : _677 = "No";
					var nomen = ""; item.NomenCompleto === 1 ? nomen = "Sí" : nomen = "No";
					var abonoapb = ""; item.AbonoAPB === 1 ? abonoapb = "Sí" : abonoapb = "No";
					row += "<tr id="+item.Id+">"+
								"<td>"+item.Codigo+"</td>"+
								"<td>"+item.Nombre+"</td>"+
								"<td>"+abonodom+"</td>"+
								"<td>"+pmo+"</td>"+
								"<td>"+coseguro+"</td>"+
								"<td>"+servicio+"</td>"+
								"<td>"+inos+"</td>"+
								"<td>"+_677+"</td>"+
								"<td>"+nomen+"</td>"+
								"<td>"+item.ValorA+"</td>"+
								"<td>"+item.ValorB+"</td>"+
								"<td>"+item.ValorC+"</td>"+
								"<td>"+item.ValorNBU+"</td>"+
								"<td>"+item.CoeficienteUGastos+"</td>"+
								"<td>"+item.CoeficienteUHono+"</td>"+
								"<td>"+item.ImporteBoletaMin+"</td>"+
								"<td>"+abonoapb+"</td>"+
								"<td>"+item.PorcCobertura+"%"+"</td>"+
						   "</tr>";	
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
				});					
				$("#body-mutuales").append(row);
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
					content : "No se pudieron obtener las mutuales",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarMutuales(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarMutuales(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

$(document).unbind("click").on("click", "tr", function(e){
	var fila = e.currentTarget;

	mostrarMutual("seleccionar mutual", fila);
});

function mostrarMutual(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/mutuales/"+$(fila).prop("id"),
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
						content : "La mutual idicada, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$(".modal-body #codigo").val(response.data[0].Codigo);
				$(".modal-body #nombre").val(response.data[0].Nombre);
				$(".modal-body #porc-cobertura").val(response.data[0].PorcCobertura);
				$(".modal-body #importe-boleta").val(response.data[0].ImporteBoletaMin);
				$(".modal-body #abona-apb").val(response.data[0].AbonoAPB);
				$(".modal-body #abona-domicilio").val(response.data[0].AbonoDomicilio);
				$(".modal-body #pmo").val(response.data[0].PMO);
				$(".modal-body #cobra-coseguro").val(response.data[0].CobroCoseguro);
				$(".modal-body #servicios-cortados").val(response.data[0].ServicioCortado);
				$(".modal-body #nomen-completo").val(response.data[0].NomenCompleto);
				$(".modal-body #reconoce-677").val(response.data[0].Reconoce677);
				//nomenclador inos
				response.data[0].CoeficienteUGastos == null ? $(".modal-body #coeficiente-gastos").val("No especifica") : $(".modal-body #coeficiente-gastos").val(response.data[0].CoeficienteUGastos);
				response.data[0].CoeficienteUHono == null ? $(".modal-body #coeficiente-honorarios").val("No especifica") : $(".modal-body #coeficiente-honorarios").val(response.data[0].CoeficienteUHono);
				response.data[0].INOSReducido == null ? $(".modal-body #inos-reducido").prop("selectedIndex", "") : $(".modal-body #inos-reducido").val(response.data[0].INOSReducido);
				//nomenclador faba
				response.data[0].ValorA == null ? $(".modal-body #valor-a").val("No especifica") : $(".modal-body #valor-a").val(response.data[0].ValorA);
				response.data[0].ValorB == null ? $(".modal-body #valor-b").val("No especifica") : $(".modal-body #valor-b").val(response.data[0].ValorB);
				response.data[0].ValorC == null ? $(".modal-body #valor-c").val("No especifica") : $(".modal-body #valor-c").val(response.data[0].ValorC);
				//nomenclador nbu
				response.data[0].ValorNBU == null ? $(".modal-body #valor-nbu").val("No especifica") : $(".modal-body #valor-nbu").val(response.data[0].ValorNBU);
				response.data[0].Comentarios == "" ? $(".modal-body #comentarios").val("No especifica") : $(".modal-body #comentarios").val(response.data[0].Comentarios);
				response.data[0].ComentariosInternos == "" ? $(".modal-body #comentarios-internos").val("No especifica") : $(".modal-body #comentarios-internos").val(response.data[0].ComentariosInternos);
				$(".modal-body #porcentaje").val(response.data[0].Porcentaje);
				$(".modal-body #condicion").val(response.data[0].Condicion);

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
					content : "No se puede obtener la mutual.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}