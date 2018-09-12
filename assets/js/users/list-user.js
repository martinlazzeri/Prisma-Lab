function GetUsersByPaginated($page) {
	var numPage;
	var offset;

	if($page == 6 && $('#page'+$page).text() != $.cookie('cantPage')){
	  numPage = $('#page6').text();

	} else if($page == 1 && $('#page'+$page).text() > 1) {
	  numPage = $('#page1').text();

	} else if($page != 0 ) {
		numPage = $('#page'+$page).text();
	}

	if( $page == 0){
		offset = (1 * 15) - 15;
		numPage = 1;
	} else {
		offset = (numPage * 15) - 15;
	}
	
	$('#paginated').empty();

	$.ajax({
		type: 'GET',
		url: 'api/users/userId/'+$.cookie('UserId')+'?offset=' + offset + '&limit=15',
  	headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
  	dataType: 'json',
		success: function(response) {
			var total = response.Total;
			var cantPage = Math.ceil((total/15));
			
			if(cantPage > 1){
				if($.cookie('cantPage') != undefined && cantPage != $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreateUserPagination(cantPage, $page, 'distinto');
			    } else {
			      CreateUserPagination(6, $page, 'distinto');
			    }
				} else if($.cookie('cantPage') != undefined && cantPage == $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreateUserPagination(cantPage, $page, 'igual');
			    } else {
			      CreateUserPagination(6, $page, 'igual');
			    }
				} else {
			    if(cantPage > 1 && cantPage <= 6){
			      CreateUserPagination(cantPage, $page, 'distinto');
			    } else {
			      CreateUserPagination(6, $page, 'distinto');
			    }
				}
			}

			$.cookie('cantPage', cantPage);
			$('#paginated').append("<div class= dataTables_info id= data-table-default_info role= status aria-live= polite >Mostrando página "+ numPage +" de "+ cantPage +" sobre un total de "+ total +" resultados</div>");
			$('#listUser').empty();

			$.each(response.Users, function(index, users) {
    		var user = JSON.parse(users);

      	$('#listUser').append("<tr>"+
          											"<td>" + user.firstname + "</td>"+
                        				"<td>" + user.lastname + "</td>"+
          											"<td>" + user.username + "</td>"+
          											"<td>" + user.email + "</td>"+
          											"<td>" + user.birthdate + "</td>"+
                        				"<td>" + user.roleName + "</td>"+
							  							"</tr>");   				
 			});
		},
		error: function(error){}
	});
}

function CreateUserPagination($cantPage, $page, $string){
	if($string == 'distinto'){
		$('#btn-page').empty();
		$('#btn-page').append('<li class="paginate_button  disabled" id="BeginBtnUser">'+
	                         	'<a href="#" id="pageBegin" onclick="beginBtnUser();"> << </a>'+
	                        '</li>');
		$('#btn-page').append('<li class="paginate_button active" tabindex="1" id="btn1">'+
	                        	'<a href="#" onclick="GetUsersByPaginated(1, '+"null"+')" id="page1" aria-controls="data-table-default" data-dt-idx="1" tabindex="1" >1</a>'+
	                        '</li>');

		for (var i = 2; i <= $cantPage; i++) {
			$('#btn-page').append('<li class="paginate_button" tabindex="'+i+'" id="btn'+i+'">'+
		                        	'<a href="#" onclick="GetUsersByPaginated('+i+', '+"null"+')" id="page'+i+'" aria-controls="data-table-default" data-dt-idx="'+i+'" tabindex="'+i+'" >'+i+'</a>'+
		                        '</li>');
		}

		$('#btn-page').append('<li class="paginate_button" id="LastBtnUser">'+
	                         	'<a href="#" id="pageLast" onclick="lastBtnUser();"> >> </a>'+
	                        '</li>');
	}

/******************************************************************************************************************/

	if($page == 1 && $('#page'+$page).text() == 1){
		$('#beginBtnUser').removeClass('disabled');
		$('#beginBtnUser').addClass('disabled');
		$('#lastBtnUser').removeClass('disabled');

	} else if($page == 6 && $('#page'+$page).text() == $.cookie('cantPage')){
		$('#lastBtnUser').addClass('disabled');
		$('#beginBtnUser').removeClass('disabled');		

	} else if($('#page'+$page).text() > 1 && $('#page'+$page).text() < parseInt($.cookie('cantPage'))){
		$('#lastBtnUser').removeClass('disabled');
		$('#beginBtnUser').removeClass('disabled');				
	}

	if($page == 6 && $('#page'+$page).text() != $.cookie('cantPage')){

		$('#btn-page li a').each(function(index,element){
			if($(this).attr('id') != 'pageBegin'){
				if($(this).attr('id') != 'pageLast'){

					var num = parseInt($(this).text());
					
						$(this).empty();
						$(this).append(num + 1);
				}
			}  
		})

	 $('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		})

	 $('#btn5').addClass('active');

	} else if($page == 1 && $('#page'+$page).text() > 1) {
		$('#btn-page li a').each(function(index,element){
			if($(this).attr('id') != 'pageBegin'){
				
				if($(this).attr('id') != 'pageLast'){
					var num = parseInt($(this).text());
					
					$(this).empty();
					$(this).append(num - 1);
				}
			}  
		})

	 $('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		})

	 $('#btn2').addClass('active');

	} else if($page != 0 ) {

		$('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		})

		$('#btn'+$page).addClass('active');
	}
}


function BeginBtnUser(){
	var lastPage = 1;

	$('#btn-page li a').each(function(index,element){
		if($(this).attr('id') != 'pageBegin'){

			if($(this).attr('id') != 'pageLast'){
				$(this).empty();
				$(this).append(lastPage++);
			}
		}
	})

 $('#btn-page li').each(function(index,element){
		$(this).removeClass('active');
	})

 $('#btn1').addClass('active');
 GetUsersByPaginated(0);
 $('#lastBtnUser').removeClass('disabled');
 $('#beginBtnUser').addClass('disabled');
}

function LastBtnUser(){
	if($.cookie('cantPage') <= 6){
		var lastPage = 1;
	} else {
		var lastPage = $.cookie('cantPage') - 5;
	}

	$('#btn-page li a').each(function(index,element){
		if($(this).attr('id') != 'pageBegin'){

			if($(this).attr('id') != 'pageLast'){
				$(this).empty();
				$(this).append(lastPage++);
			}
		}
	})

 $('#btn-page li').each(function(index,element){
		$(this).removeClass('active');
	})

	if($.cookie('cantPage') <= 6){
		$('#btn'+$.cookie('cantPage')).addClass('active');
 		GetUsersByPaginated($.cookie('cantPage'));
	} else {
		$('#btn6').addClass('active');
 		GetUsersByPaginated(6);
	}

 $('#lastBtnUser').addClass('disabled');
 $('#beginBtnUser').removeClass('disabled');
}