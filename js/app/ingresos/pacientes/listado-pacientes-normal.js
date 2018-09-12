$(document).ready(function(){				
	$("#entreFechas").hide();
	$("#footer").hide();		
	actualizarPacientes(1);		
});

$("#buscar").click(function(e){		
	actualizarPacientes(1);
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

function actualizarPacientes(offset){
	$("#buscar").prop("disabled", true);		
	if ($("#todos").is(":checked"))
	{					
		$.ajax({
			type: "POST",
			contentType: "application/json",
			url: "api/ingresos/",
			dataType: "json",
			data: JSON.stringify({"Offset": offset}),
			headers: {"Authorization": $.cookie("ApiKey")},
			success: function(response){
				if (response.error == true) 
				{										
					if (response.data = "No se encontraron datos") 
					{							
						$.bigBox({
							title : "Error",
							content : "No existen ingresos registrados.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
					}					
				}
				else
				{
					$("#pacientes-body").empty();
					offset < 1 ? $("#num-pagina").text(1) : $("#num-pagina").text(offset);
					SwitchAnterior(parseInt($("#num-pagina").text()));
					SwitchSiguiente(response.ultimaPag);
					var rows = "";
					$.each(response.data, function(index, item){					
						rows += "<tr id="+item.IngresoIdId+">"+
									"<td>"+item.NumPaciente+"</td>"+
			 						"<td>"+item.ApellidoNombre+"</td>"+
									"<td>"+item.NumDocumento+"</td>"+
									"<td>"+item.Mail+"</td>"+
									"<td>"+item.NombreMutual1+"</td>"+
									"<td>"+item.NombreMutual2+"</td>"+
							    "</tr>";	
						rows = rows.replace(null, "No posee");
						rows = rows.replace(null, "No posee");
						rows = rows.replace(null, "No posee");
						rows = rows.replace(null, "No posee");
					});			
					$("#pacientes-body").append(rows);
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
						content : "No se pueden obtener los pacientes.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
	if ($("#fechas").is(":checked"))
	{				
		if ($("#desde").val() !== "" && $("#hasta").val() !== "" && $("#desde").val() <= $("#hasta").val())
		{
			$.ajax({
				type: "POST",
				contentType: "application/json",
				url: "api/ingresos/porfecha",
				dataType: "json",
				data: JSON.stringify({
						"Offset": offset,
						"Desde": $("#desde").val(),
						"Hasta": $("#hasta").val()}),
				headers: {"Authorization": $.cookie("ApiKey")},
				success: function(response){
					if (response.error == true) 
					{
						if (response.data == "No se encontraron datos") 
						{							
							$.bigBox({
								title : "Error",
								content : "No existen pacientes cargados.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
						}
						if (response.data == "No se indicó una fecha de inicio") 
						{							
							$.bigBox({
								title : "Error",
								content : "Fecha de inicio incompleta. <br>Por favor, ingrese la fecha de inicio para listar.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
						}		
						if (response.data == "No se indicó una fecha límite") 
						{
							$.bigBox({
								title : "Error",
								content : "Fecha límite incompleta. <br>Por favor, ingrese la fecha límite para listar.",
								color : "#C46A69",
								timeout: 5000,
								icon : "fa fa-warning shake animated"
							});
						}		
					}
					else
					{
						$("#pacientes-body").empty();
						offset < 1 ? $("#num-pagina").text(1) : $("#num-pagina").text(offset);
						SwitchAnterior($("#num-pagina").text());
						SwitchSiguiente(response.ultimaPag);
						var rows = "";
						$.each(response.data, function(index, item){					
							rows += "<tr id="+item.IngresoId+">"+
				 						"<td>"+item.NumPaciente+"</td>"+
				 						"<td>"+item.ApellidoNombre+"</td>"+
										"<td>"+item.NumDocumento+"</td>"+
										"<td>"+item.Mail+"</td>"+
										"<td>"+item.NombreMutual1+"</td>"+
										"<td>"+item.NombreMutual2+"</td>"+
								    "</tr>";	
							rows = rows.replace(null, "No posee");
							rows = rows.replace(null, "No posee");
							rows = rows.replace(null, "No posee");
							rows = rows.replace(null, "No posee");
						});			
						$("#pacientes-body").append(rows);
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
						arr = ["Desde", "Hasta"];		
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
						Errores = Errores.replace("Desde", "fecha de inicio");
						Errores = Errores.replace("Hasta", "fecha límite");
						Errores = "Campo(s) requerido(s) "+Errores+" vacío(s) o nulo(s).";
						$.bigBox({
							title : "Error",
							content : "Asegúrese que completó todos los campos requeridos. <br>"+Errores,
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
		else
		{
			if ($("#desde").val() === "")
			{
				$.bigBox({
					title : "Error",
					content : "La fecha de inicio se encuentra vacía, por favor complétela para listar.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
			if ($("#hasta").val() === "") 
			{
				$.bigBox({
					title : "Error",
					content : "La fecha límite se encuentra vacía, por favor complétela para listar.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
			if ($("#desde").val() > $("#hasta").val())
			{
				$.bigBox({
					title : "Error",
					content : "La fecha de inicio es mayor a la fecha límite, por favor asegúrese que sea igual o menor.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}		
		}			
	}
	$("#buscar").prop("disabled", false);	
}	

$("#anterior").click(function(e){
	if ($("#li-anterior").prop("class") !== "disabled")
	{
		actualizarPacientes(parseInt($("#num-pagina").text()) - 1);			
	}		
	e.preventDefault();
});

$("#siguiente").click(function(e){
	if ($("#li-siguiente").prop("class") !== "disabled")
	{
		actualizarPacientes(parseInt($("#num-pagina").text()) + 1);			
	}	
	e.preventDefault();
});

$("input[name='radio-inline']").on("click", function () {
	$("#footer").show();
    switch (this.id){
    	case "fechas": $("#entreFechas").show();
    				 break;
    	default:
    		$("#entreFechas").hide();
    }
});

$("#form-listado").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});