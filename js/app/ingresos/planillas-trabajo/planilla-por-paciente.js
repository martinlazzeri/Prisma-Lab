$("#form-planillas").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

$(document).ready(function(){
	var hoy = new Date(); 
	var ano = hoy.getFullYear().toString().substr(3);
	var mes = hoy.getMonth();
	mes = parseInt(mes) + 1;
	mes = ("0" + (mes).toString()).substr(-2);
	var dia = ("0" + hoy.getDate()).substr(-2);
	prefijoNumPaciente = (ano + mes + dia);	

	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: 'api/planillas/obtenernumeros',
		dataType: 'json',
		data: JSON.stringify({"Num_Actual": prefijoNumPaciente}),
		headers: {"Authorization": $.cookie('ApiKey')},
		success: function(response){
			if (response.error === false)
			{
				$("#desdePaciente").val(response.Primero['NumPaciente']);
				$("#desdePaciente").attr('data-id', response.Primero['Id']);
				$("#hastaPaciente").val(response.Ultimo['NumPaciente']);
				$("#hastaPaciente").attr('data-id', response.Ultimo['Id']);
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
					content : "No se puede obtener el paciente especificado.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});
});
