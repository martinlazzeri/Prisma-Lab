$(document).ready(function(){
	actualizarPracticas();
	$("#buscar_practica").focus();
});

function actualizarPracticas(){
	$.ajax({
		type: "GET",
		contentType: "application/json",
		url: "api/nomencladoresespeciales/",
		dataType: "json",
		beforeSend: function(xhr){
			xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
		},
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "No se encontraron datos de prácticas") 
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
				$("#list_practicas").empty();
				$.each(response.data, function(index, item){
					$("#list_practicas").append("<option data-value=\""+item.Id+"\" value=\""+item.Nombre+" - "+item.NombreMutual+"\"></option>");
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
					content : "No se pudieron obtener los nomencladores especiales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}	

$("#buscar_practica").on("input", function(){
	var val = this.value;
	if ($("#list_practicas option").filter(function(){
		return this.value === val;
	}).length)
	{
		$.ajax({
			type: "GET",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/"+$("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value"),
			dataType: "json",
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
							content : "No se encontraron datos del nomenclador especial elegido.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_practica").val("");
						actualizarPracticas();
					}
				}
				else
				{											
					$("#eliminar").prop("disabled", false);
					$("#buscar_mutual").val(response.data[0].CodMutual+" - "+response.data[0].NombreMutual);
					$("#nombre").val(response.data[0].Nombre);
					$("#a").val(response.data[0].A);
					$("#codigo").val(response.data[0].Codigo);
					$("#unidad-gasto").val(response.data[0].UnidadGasto);
					$("#unidad-honorario").val(response.data[0].UnidadHonorario);
					$("#nivel").val(response.data[0].Nivel);
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
						content : "No se pudo obtener el nomenclador especial.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	if ($("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value") !== undefined && $("#buscar_practica").val() !== "") 
	{
		$.ajax({
			type: "DELETE",
			contentType: "application/json",
			url: "api/nomencladoresespeciales/eliminar",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if (response.error === true)
				{
					if (response.data === "La práctica no existe")
					{
						$.bigBox({
							title : "Error",
							content : "El nomenclador especial elegido ya no existe.<br>Por favor, seleccione otro.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#buscar_practica").val("");
						$("#buscar_practica").focus();
						actualizarPracticas();
					}						
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "El nomenclador especial se ha eliminado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});	
					$("#eliminar").prop("disabled", true);						
					$("#form-practicas").get(0).reset();
					actualizarPracticas();						
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
					arr = ["Id", "MutualId", "Nombre", "A", "Codigo", "UnidadGasto", "UnidadHonorario", "Nivel"];
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
					Errores = Errores.replace("MutualId", "id de mutual");
					Errores = Errores.replace("UnidadGasto", "unidad de gasto");
					Errores = Errores.replace("UnidadHonorario", "unidad de honorario");
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
	}
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#list_practicas [value='"+$("#buscar_practica").val()+"']").data("value"),			
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false) 
	{
		if (key.which === 9) 
		{
			$("#buscar_practica").focus();
			key.preventDefault();
		}
	}
});