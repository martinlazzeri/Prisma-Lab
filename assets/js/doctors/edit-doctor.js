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
		GetDoctorById(ui.item.value);
	}
});

function EditDoctor(){
	$.ajax({
		type: 'PUT',
		url: 'api/doctors/'+$('#search-user').val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
    data: JSON.stringify({'typeEnrollment': $('#typeEnrollment').val(),
                          'firstname': $('#firstname').val(),
                          'lastname' : $('#lastname').val(),
                          'address': $('#address').val(),
                          'phone': $('#phone').val()}),
		success: function(response){
	    CleanDoctorForm('editDoctor');

			$.bigBox({
				title : "Éxito",
				content : "El medico se ha modificado correctamente.",
				color : "#739E73",
				timeout: 5000,
				icon : "fa fa-check"					
			});
		},
		error: function(error){
      if(error.status == 400){
        $.bigBox({
          title : "Error",
          content : "Asegúrese que completó todos los campos requeridos.",
          color : "#C46A69",
          timeout: 8000,
          icon : "fa fa-warning shake animated"
        });
      }
		}
	});
}