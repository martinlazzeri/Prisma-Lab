$(document).ready(function(){
	actualizarMutuales();
	$("#buscar_mutual").focus();
});

function resetForm(){
	$("#form-borrado").get(0).reset();
	$("#form-borrado :input").prop("disabled", true);
	$("#buscar_mutual").prop("disabled", false);
}

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
				if (response.data === "No se han encontrado datos") 
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
				$("#list_mutuales").empty();
				$.each(response.data, function(index, item){
					$("#list_mutuales").append("<option data-value=\""+item.Id+"\" value=\""+item.Nombre+" - COD: "+item.Codigo+"\"></option>");
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
					content : "No se pudieron obtener las obras sociales.",
					color : "#C46A69",
					timeout : 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
}

$("#buscar_mutual").on("input", function(){
	var val = this.value;
	if ($("#list_mutuales option").filter(function(){
		return this.value === val;
	}).length)
	{
		if ($("#buscar_mutual").val() === "") 
		{
			resetForm();
		}
		else
		{
			var mutual = $("#buscar_mutual").val();
			$.ajax({
				type: "GET",
				contentType: "application/json",
				url: "api/mutuales/"+$("#list_mutuales [value='"+mutual+"']").data("value"),
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
								content : "No se encontraron datos para la obra social elegida.",
								color : "#C46A69",
								timeout : 8000,
								icon : "fa fa-warning shake animated"
							});
							resetForm();
							actualizarMutuales();
						}
					}
					else
					{
						$("#codigo").val(response.data[0].Codigo);
						$("#nombre").val(response.data[0].Nombre);
						$("#abona-domicilio").val(response.data[0].AbonoDomicilio);
						$("#pmo").val(response.data[0].PMO);
						$("#cobra-coseguro").val(response.data[0].CobroCoseguro);
						$("#servicios-cortados").val(response.data[0].ServicioCortado);
						$("#inos-reducido").val(response.data[0].INOSReducido);
						$("#reconoce-677").val(response.data[0].Reconoce677);
						$("#nomen-completo").val(response.data[0].NomenCompleto);
						$("#valor-a").val(response.data[0].ValorA);
						$("#valor-b").val(response.data[0].ValorB);
						$("#valor-c").val(response.data[0].ValorC);
						$("#valor-nbu").val(response.data[0].ValorNBU);
						$("#coeficiente-gastos").val(response.data[0].CoeficienteUGastos);
						$("#coeficiente-honorarios").val(response.data[0].CoeficienteUHono);							
						$("#importe-boleta").val(response.data[0].ImporteBoletaMin);
						$("#abona-apb").val(response.data[0].AbonoAPB);							
						$("#porc-cobertura").val(response.data[0].PorcCobertura);
						$("#comentarios").val(response.data[0].Comentarios);
						$("#comentarios-int").val(response.data[0].ComentariosInternos);
						$("#porcentaje").val(response.data[0].Porcentaje);
						$("#condicion").val(response.data[0].Condicion);
						
						$("#eliminar").prop("disabled", false);
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
							content : "No se pudo obtener la obra social.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
					}
				}
			});
		}
	}
	else
	{

	}		
});

$("#buscar_mutual").change(function(){
	if ($("#buscar_mutual").val() === "")
	{
		resetForm();
	}
});

$("#buscar_mutual").blur(function(){
	if ($("#buscar_mutual").val() === "")
	{
		resetForm();
	}
});

$("#eliminar").click(function(e){
	$("#eliminar").prop("disabled", true);
	if($("#buscar_mutual").val() !== "")
	{
		$.ajax({
			type : "DELETE",
			contentType: "application/json",
			url: "api/mutuales/eliminar",
			dataType: "json",
			data: FormToJSON(),
			beforeSend: function(xhr){
				xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
			},
			success: function(response){
				if(response.error === true)
				{
					if (response.data === "La mutual no existe.")
					{
						$.bigBox({
							title : "Error",
							content : "La obra social elegida ya no existe. <br>Por favor seleccione otra.",
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
						resetForm();
						actualizarMutuales();
					}
					if (response.data === "La mutual no se puede borrar porque tiene pacientes asociados.") 
					{
						$.bigBox({
							title : "Error",
							content : "No se pudo eliminar la obra social.<br> Existen pacientes asociados a la obra social "+ 
										"que se quiere eliminar, y mientras existan no la podrá eliminar.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#eliminar").prop("disabled", false);
					}
					if (response.data === "La mutual no se puede borrar porque tiene prácticas asociadas.") 
					{
						$.bigBox({
							title : "Error",
							content : "No se pudo eliminar la obra social.<br> Existen prácticas asociadas a la obra social "+ 
										"que se quiere eliminar, y mientras existan no la podrá eliminar.",
							color : "#C46A69",
							timeout : 8000,
							icon : "fa fa-warning shake animated"
						});
						$("#eliminar").prop("disabled", false);
					}
				}
				else
				{
					$.bigBox({
						title : "Éxito",
						content : "La obra social se ha eliminado correctamente.",
						color : "#739E73",
						timeout: 5000,
						icon : "fa fa-check"					
					});
					resetForm();
					actualizarMutuales();
					$("#buscar_mutual").focus();
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
					$.bigBox({
						title : "Error",
						content : "No se pudo eliminar la obra social.",
						color : "#C46A69",
						timeout : 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	}
	e.preventDefault();
});

function FormToJSON(){
	return JSON.stringify({
		"Id": $("#list_mutuales [value='"+$("#buscar_mutual").val()+"']").data("value"),
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#eliminar").on("keydown", function(key){
	if ($("#eliminar").prop("disabled") === false)
	{
		if (key.which === 9) 
		{	
			$("#buscar_mutual").focus();
			key.preventDefault();
		}
	}
});