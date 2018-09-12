$(document).ready(function(){
	$("#search-doctor").focus();
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
						value : doctor.id
					}
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-doctor').removeClass('ui-autocomplete-loading');
		GetDoctorById(ui.item.value);
	}
});

function RemoveDoctor(){
	var id = $("#datalist-doctors [value='" + $("#search-doctor").val() + "']").data("value");

	$.ajax({
		type: 'DELETE',
		url: 'api/doctors/'+$("#search-doctor").val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
	    CleanDoctorForm('removeDoctor');

			$.bigBox({
				title : "Éxito",
				content : "El médico se ha eliminado correctamente.",
				color : "#739E73",
				timeout: 5000,
				icon : "fa fa-check"					
			});
		},
		error: function(error){}
	});
}