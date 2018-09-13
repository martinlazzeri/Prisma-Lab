function GetPatientsByPaginated($page) {
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
		url: 'api/patients/userId/'+$.cookie('UserId')+'?offset=' + offset + '&limit=15',
  	headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
  	dataType: 'json',
		success: function(response) {
			var total = response.Total;
			var cantPage = Math.ceil((total/15));

			if(cantPage > 1){
				if($.cookie('cantPage') != undefined && cantPage != $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreatePatientPagination(cantPage, $page, 'distinto');
			    } else {
			      CreatePatientPagination(6, $page, 'distinto');
			    }
				} else if($.cookie('cantPage') != undefined && cantPage == $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreatePatientPagination(cantPage, $page, 'igual');
			    } else {
			      CreatePatientPagination(6, $page, 'igual');
			    }
				} else {
			    if(cantPage > 1 && cantPage <= 6){
			      CreatePatientPagination(cantPage, $page, 'distinto');
			    } else {
			      CreatePatientPagination(6, $page, 'distinto');
			    }
				}
			}

			$.cookie('cantPage', cantPage);
			$('#paginated').append("<div class= dataTables_info id= data-table-default_info role= status aria-live= polite >Mostrando página "+ numPage +" de "+ cantPage +" sobre un total de "+ total +" resultados</div>");
			$('#listPatient').empty();

			$.each(response.Patients, function(index, patients) {
    		var patient = JSON.parse(patients);

      	$('#listPatient').append("<tr>"+
		          											"<td>" + patient.dni + "</td>"+
		                        				"<td>" + patient.firstname + "</td>"+
		          											"<td>" + patient.lastname + "</td>"+
		          											"<td>" + moment(patient.birthdate).locale("es").format('DD[-]MM[-]YYYY') + "</td>"+
		                        				"<td>" + patient.sex + "</td>"+
		          											"<td>" + patient.address + "</td>"+
		                        				"<td>" + patient.phone + "</td>"+
		          											"<td>" + patient.email + "</td>"+
							  									"</tr>");   				
 			});
		},
		error: function(error){}
	});
}

function CreatePatientPagination($cantPage, $page, $string){
	if($string == 'distinto'){
		$('#btn-page').empty();
		$('#btn-page').append('<li class="paginate_button  disabled" id="beginBtn">'+
	                         	'<a href="#" id="pageBegin" onclick="BeginBtn();"> << </a>'+
	                        '</li>');
		$('#btn-page').append('<li class="paginate_button active" tabindex="1" id="btn1">'+
	                        	'<a href="#" onclick="GetPatientsByPaginated(1, '+"null"+')" id="page1" aria-controls="data-table-default" data-dt-idx="1" tabindex="1" >1</a>'+
	                        '</li>');

		for (var i = 2; i <= $cantPage; i++) {
			$('#btn-page').append('<li class="paginate_button" tabindex="'+i+'" id="btn'+i+'">'+
		                        	'<a href="#" onclick="GetPatientsByPaginated('+i+', '+"null"+')" id="page'+i+'" aria-controls="data-table-default" data-dt-idx="'+i+'" tabindex="'+i+'" >'+i+'</a>'+
		                        '</li>');
		}

		$('#btn-page').append('<li class="paginate_button" id="lastBtn">'+
	                         	'<a href="#" id="pageLast" onclick="LastBtn();"> >> </a>'+
	                        '</li>');
	}

/******************************************************************************************************************/

	if($page == 1 && $('#page'+$page).text() == 1){
		$('#beginBtn').removeClass('disabled');
		$('#beginBtn').addClass('disabled');
		$('#lastBtn').removeClass('disabled');

	} else if($page == 6 && $('#page'+$page).text() == $.cookie('cantPage')){
		$('#lastBtn').addClass('disabled');
		$('#beginBtn').removeClass('disabled');		

	} else if($('#page'+$page).text() > 1 && $('#page'+$page).text() < parseInt($.cookie('cantPage'))){
		$('#lastBtn').removeClass('disabled');
		$('#beginBtn').removeClass('disabled');				
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
		});

	 $('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		});

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
		});

	 $('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		});

	 $('#btn2').addClass('active');

	} else if($page != 0 ) {

		$('#btn-page li').each(function(index,element){
			$(this).removeClass('active');
		});

		$('#btn'+$page).addClass('active');
	}
}


function BeginBtn(){
	var lastPage = 1;

	$('#btn-page li a').each(function(index,element){
		if($(this).attr('id') != 'pageBegin'){

			if($(this).attr('id') != 'pageLast'){
				$(this).empty();
				$(this).append(lastPage++);
			}
		}
	});

 $('#btn-page li').each(function(index,element){
		$(this).removeClass('active');
	});

 $('#btn1').addClass('active');
 GetPatientsByPaginated(0);
 $('#lastBtn').removeClass('disabled');
 $('#beginBtn').addClass('disabled');
}

function LastBtn(){
	var lastPage;

	if($.cookie('cantPage') <= 6){
		lastPage = 1;
	} else {
	  lastPage = $.cookie('cantPage') - 5;
	}

	$('#btn-page li a').each(function(index,element){
		if($(this).attr('id') != 'pageBegin'){

			if($(this).attr('id') != 'pageLast'){
				$(this).empty();
				$(this).append(lastPage++);
			}
		}
	});

 $('#btn-page li').each(function(index,element){
		$(this).removeClass('active');
	});

	if($.cookie('cantPage') <= 6){
		$('#btn'+$.cookie('cantPage')).addClass('active');
 		GetPatientsByPaginated($.cookie('cantPage'));
	} else {
		$('#btn6').addClass('active');
 		GetPatientsByPaginated(6);
	}

 $('#lastBtn').addClass('disabled');
 $('#beginBtn').removeClass('disabled');
}