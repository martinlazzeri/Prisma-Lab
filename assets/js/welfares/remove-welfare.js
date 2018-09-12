$(document).ready(function(){
	$("#search-welfare").focus();
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
						value : welfare.id
					}
				}));
			}
		});
	},
	minLength : 2,
	select : function(event, ui) {
		$('#search-welfare').removeClass('ui-autocomplete-loading');
		GetWelfareById(ui.item.value);
	}
});

function RemoveWelfare(){
	$.ajax({
		type: 'DELETE',
		url: 'api/welfares/'+$("#search-welfare").val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
	    CleanWelfareForm('removeWelfare');

			$.bigBox({
				title : "Éxito",
				content : "La obre social se ha eliminado correctamente.",
				color : "#739E73",
				timeout: 5000,
				icon : "fa fa-check"					
			});
		},
		error: function(error){}
	});
}