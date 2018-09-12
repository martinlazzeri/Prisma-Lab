$(document).ready(function(){
	actualizarMedicos(1);
});

$("#body-medicos").css("cursor", "pointer");

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

function actualizarMedicos(offset){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/medicos/",
		dataType: "json",
		data: JSON.stringify({"Offset": offset}),
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se han encontrado datos") 
				{
					$.bigBox({
						title : "Error",
						content : "No se encontraron médicos.",
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
				$("#body-medicos").empty();
				var row = "";
				$.each(response.data, function(index, item){
					var tipoMat = "";
					item.TipoMatricula === 0 ? tipoMat = "Nacional" : tipoMat = "Provincial";
					row += "<tr id="+item.Id+">"+
								"<td>"+item.Nombre+"</td>"+
								"<td>"+item.Apellido+"</td>"+
								"<td>"+item.Matricula+"</td>"+
								"<td>"+tipoMat+"</td>"+
								"<td>"+item.Domicilio1+"</td>"+
								"<td>"+item.Telefono1+"</td>"+
								"<td>"+item.Domicilio2+"</td>"+
								"<td>"+item.Telefono2+"</td>"+
						   "</tr>";
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
					row = row.replace(null, "No especifica");
				});					
				$("#body-medicos").append(row);
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
					content : "No se pudieron obtener los médicos.",
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
		actualizarMedicos(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarMedicos(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

$(document).unbind("click").on("click", "tr", function(e){
	var fila = e.currentTarget;

	mostrarMedico("seleccionar medico", fila);
});

function mostrarMedico(origin, fila){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/medicos/"+$(fila).prop("id"),
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
						content : "El médico indicado, no existe.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{
				$(".modal-body #matricula").val(response.data[0].Matricula);
				$(".modal-body #tipo-matricula").val(response.data[0].TipoMatricula);
				$(".modal-body #nombre").val(response.data[0].Nombre);
				$(".modal-body #apellido").val(response.data[0].Apellido);
				response.data[0].Domicilio1 == null ? $(".modal-body #domicilio1").val("No especifica") : $(".modal-body #domicilio1").val(response.data[0].Domicilio1);
				response.data[0].Telefono1 == null ? $(".modal-body #telefono1").val("No especifica") : $(".modal-body #telefono1").val(response.data[0].Telefono1);
				response.data[0].Domicilio2 == null ? $(".modal-body #domicilio2").val("No especifica") : $(".modal-body #domicilio2").val(response.data[0].Domicilio2);
				response.data[0].Telefono2 == null ? $(".modal-body #telefono2").val("No especifica") : $(".modal-body #telefono2").val(response.data[0].Telefono2);				

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
					content : "No se puede obtener el médico.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}