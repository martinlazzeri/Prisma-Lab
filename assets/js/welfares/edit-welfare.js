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
					};
				}));
			},
			error:function(error){
				if(error.status == 404){
					$.bigBox({
						title : "Error",
						content : "No existen obras sociales creadas.",
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
		$('#search-welfare').removeClass('ui-autocomplete-loading');
		GetWelfareById(ui.item.value);
	}
});

function EditWelfare(){
	$.ajax({
		type: 'PUT',
		url: 'api/welfares/'+$('#search-welfare').val()+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
    data: JSON.stringify({'payAtHome': $('#payAtHome').val(),
                          'pmo': $('#pmo').val(),
                          'coinsurance': $('#coinsurance').val(),
                          'serviceAvailable': $('#serviceAvailable').val(),
                          'disposableMaterial': $('#disposableMaterial').val(),
                          'completeNomenclator': $('#completeNomenclator').val(),
                          'minimumAmount' : $('#minimumAmount').val(),
                          'coveragePercentage': $('#coveragePercentage').val(),
                          'percentage': $('#percentage').val(),
                          'inosReducido' : $('#inosReducido').val(),
                          'aValue': $('#aValue').val(),
                          'bValue': $('#bValue').val(),
                          'cValue': $('#cValue').val(),
                          'nbuValue': $('#nbuValue').val(),
                          'comments': $('#comments').val(),
                          'internalComments': $('#internalComments').val()}),
		success: function(response){
	    CleanWelfareForm('editWelfare');
	    
			$.bigBox({
				title : "Éxito",
				content : "La obra social se ha modificado correctamente.",
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