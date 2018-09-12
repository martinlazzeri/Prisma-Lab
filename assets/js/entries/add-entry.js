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
						label : patient.dni + " - " + patient.firstname + " " + patient.lastname,
						value : patient.dni + " - " + patient.firstname + " " + patient.lastname,
						value2 : patient.id
					};
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-patient').removeClass('ui-autocomplete-loading');
		$.cookie('patientId', ui.item.value2);
	}
});

$("#search-welfare").autocomplete({
	source : function(request, response) {
		$.ajax({
			type: 'POST',
			url : 'api/welfares/search/userId/'+$.cookie('UserId'),
			headers: {"Content-Type": "application/json",
								"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
			dataType: 'json',
			data: JSON.stringify({'searchCriteria': $('#search-welfare').val()}),
			success : function(data){
				response($.map(data.Welfares, function(item) {
					var welfare = JSON.parse(item);

					return {
						label : welfare.code + " - " + welfare.name,
						value : welfare.code + " - " + welfare.name,
						value2 : welfare.id
					}
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-welfare').removeClass('ui-autocomplete-loading');
		$.cookie('welfareId', ui.item.value2);
	}
});

$("#search-doctor").autocomplete({
	source : function(request, response) {
		$.ajax({
			type: 'POST',
			url : 'api/doctors/search/userId/'+$.cookie('UserId'),
			headers: {"Content-Type": "application/json",
								"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
			dataType: 'json',
			data: JSON.stringify({'searchCriteria': $('#search-doctor').val()}),
			success : function(data){
				response($.map(data.Doctors, function(item) {
					var doctor = JSON.parse(item);

					return {
						label : doctor.enrollment + " - " + doctor.firstname +" " + doctor.lastname,
						value : doctor.enrollment + " - " + doctor.firstname +" " + doctor.lastname,
						value2 : doctor.id
					}
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-doctor').removeClass('ui-autocomplete-loading');
		$.cookie('doctorId', ui.item.value2);
	}
});