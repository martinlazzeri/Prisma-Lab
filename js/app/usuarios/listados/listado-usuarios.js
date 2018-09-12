$(document).ready(function(){
	actualizarUsuarios(1);
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

function actualizarUsuarios(offset){
	$.ajax({
		type: "POST",
		contentType: "application/json",
		url: "api/usuarios",
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
						content : "No existen usuarios registrados.",
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
				$("#body-usuarios").empty();
				var row = "";
				$.each(response.data, function(index, item){
					row += "<tr id=\""+item.Id+"\">"+
								"<td>"+item.Nombre+"</td>"+
								"<td>"+item.Apellido+"</td>"+
								"<td>"+item.NombreUsuario+"</td>"+
								"<td>"+item.Email+"</td>"+
								"<td>"+item.FechaNacimiento+"</td>"+
								"<td>"+item.Descripcion+"</td>"+
						   "</tr>";
				});
				$("#body-usuarios").append(row);
			}
		},
		error: function(error){
			$.bigBox({
				title : "Error",
				content : "Ha ocurrido un error crítico y su solicitud no pudo ser procesada.",
				color : "#C46A69",
				timeout: 8000,
				icon : "fa fa-warning shake animated"
			});
		}
	});
}

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarUsuarios(parseInt($("#num-pagina").text()) - 1);
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarUsuarios(parseInt($("#num-pagina").text()) + 1);
	}		
	e.preventDefault();
});

$("#form-listado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});