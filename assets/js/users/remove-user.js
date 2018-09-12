$(document).ready(function(){
	$("#search-user").focus();
});

$("#search-user").autocomplete({
	source : function(request, response) {
		$.ajax({
			type: 'POST',
			url : 'api/users/search/userId/'+$.cookie('UserId'),
			headers: {"Content-Type": "application/json",
								"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
			dataType: 'json',
			data: JSON.stringify({'searchCriteria': $('#search-user').val()}),
			success : function(data){
				response($.map(data.Users, function(item) {
					var user = JSON.parse(item);

					return {
						label : user.username + " - " + user.firstname + " "+ user.lastname,
						value : user.id
					}
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-user').removeClass('ui-autocomplete-loading');
		GetUserById(ui.item.value);
	}
});

function RemoveUser(){
	$.ajax({
		type: 'DELETE',
		url: 'api/users/'+$("#search-user").val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
	    CleanUserForm('removeUser');

			$.bigBox({
				title : "Éxito",
				content : "El usuario se ha eliminado correctamente.",
				color : "#739E73",
				timeout: 5000,
				icon : "fa fa-check"					
			});
		},
		error: function(error){}
	});
}