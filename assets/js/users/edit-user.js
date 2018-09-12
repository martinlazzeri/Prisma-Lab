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

function EditUser(){
	var avatarUrl = "";

	if ($("input[type=file]")[0].files[0] !== undefined){
		avatarUrl = $("input[type=file]")[0].files[0].name;
	}		

	$.ajax({
		type: 'PUT',
		url: 'api/users/'+$('#search-user').val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
    data: JSON.stringify({'firstname': $('#firstname').val(),
		                      'lastname': $('#lastname').val(),
		                      'email': $('#email').val(),
		                      'birthdate' : $('#birthdate').val(),
		                      'username': $('#user-username').val(),
		                      'role': $('#roleId').val(),
		                      'avatarUrl': avatarUrl}),
		success: function(response){
			var data1 = new FormData($("input[name^='upload']"));
        
      $.each($("input[name^='upload']")[0].files, function(index, item) {
      	data1.append(index, item);
      });

	    $.ajax({
	      	url: "subir_img.php",
	      	type: "POST",
	      	data: data1,
	      	enctype: "multipart/form-data",
	      	processData: false,
	      	contentType: false					    
	    });	

	    CleanUserForm('editUser');

			$.bigBox({
				title : "Éxito",
				content : "El usuario se ha modificado correctamente.",
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