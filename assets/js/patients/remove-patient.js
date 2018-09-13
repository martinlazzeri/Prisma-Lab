$(document).ready(function(){
	$("#search-patient").focus();
});

$("#search-patient").autocomplete({
	source : function(request, response) {
		$.ajax({
			type: 'POST',
			url : 'api/patients/search/userId/'+$.cookie('UserId'),
			headers: {"Content-Type": "application/json",
								"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
			dataType: 'json',
			data: JSON.stringify({'searchCriteria': $('#search-patient').val()}),
			success : function(data){
				response($.map(data.Patients, function(item) {
					var patient = JSON.parse(item);

					return {
						label : patient.dni + " - " + patient.firstname +" " + patient.lastname,
						value : patient.id
					};
				}));
			},
			error:function(error){
				if(error.status == 404){
					$.bigBox({
						title : "Error",
						content : "No existen pacientes creados.",
						color : "#C46A69",
						timeout: 8000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-patient').removeClass('ui-autocomplete-loading');
		GetPatientById(ui.item.value);
		$('#btn-removePatient').removeAttr('disabled');
	}
});

function RemovePatient(){

	$.ajax({
		type: 'DELETE',
		url: 'api/patients/'+$("#search-patient").val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
	    CleanPatientForm('removePatient');

			$.bigBox({
				title : "Éxito",
				content : "El paciente se ha eliminado correctamente.",
				color : "#739E73",
				timeout: 5000,
				icon : "fa fa-check"					
			});
		},
		error: function(error){}
	});
}