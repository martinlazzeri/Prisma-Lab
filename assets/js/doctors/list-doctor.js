function GetDoctorsByPaginated($page) {
	var numPage;
	var offset;
	var typeEnrollment;
	var address;
	var phone;

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
		url: 'api/doctors/userId/'+$.cookie('UserId')+'?offset=' + offset + '&limit=15',
  	headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
  	dataType: 'json',
		success: function(response) {
			var total = response.Total;
			var cantPage = Math.ceil((total/15));
			
			if(cantPage > 1){
				if($.cookie('cantPage') != undefined && cantPage != $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreateDoctorPagination(cantPage, $page, 'distinto');
			    } else {
			      CreateDoctorPagination(6, $page, 'distinto');
			    }
				} else if($.cookie('cantPage') != undefined && cantPage == $.cookie('cantPage')){
			    if(cantPage > 1 && cantPage <= 6){
			      CreateDoctorPagination(cantPage, $page, 'igual');
			    } else {
			      CreateDoctorPagination(6, $page, 'igual');
			    }
				} else {
			    if(cantPage > 1 && cantPage <= 6){
			      CreateDoctorPagination(cantPage, $page, 'distinto');
			    } else {
			      CreateDoctorPagination(6, $page, 'distinto');
			    }
				}
			}

			$.cookie('cantPage', cantPage);
			$('#paginated').append("<div class= dataTables_info id= data-table-default_info role= status aria-live= polite >Mostrando página "+ numPage +" de "+ cantPage +" sobre un total de "+ total +" resultados</div>");
			$('#listDoctor').empty();

			$.each(response.Doctors, function(index, doctors) {
    		var doctor = JSON.parse(doctors);

    		if(doctor.address == null){
    			address = '';
    		} else {
    			address = doctor.address;
    		}

    		if(doctor.phone == null){
    			phone = '';
    		} else {
    			phone = doctor.phone;
    		}

    		if(doctor.typeEnrollment == 1){
    			typeEnrollment = 'Nacional';
    		} else {
    			typeEnrollment = 'Provincial';
    		}

      	$('#listDoctor').append("<tr>"+
          											"<td>" + doctor.firstname + "</td>"+
                        				"<td>" + doctor.lastname + "</td>"+
          											"<td>" + doctor.enrollment + "</td>"+
          											"<td>" + typeEnrollment + "</td>"+
          											"<td>" + address + "</td>"+
                        				"<td>" + phone + "</td>"+
							  							"</tr>");   				
 			});
		},
		error: function(error){}
	});
}

function CreateDoctorPagination($cantPage, $page, $string){
	if($string == 'distinto'){
		$('#btn-page').empty();
		$('#btn-page').append('<li class="paginate_button  disabled" id="beginBtn">'+
	                         	'<a href="#" id="pageBegin" onclick="BeginBtn();"> << </a>'+
	                        '</li>');
		$('#btn-page').append('<li class="paginate_button active" tabindex="1" id="btn1">'+
	                        	'<a href="#" onclick="GetDoctorsByPaginated(1, '+"null"+')" id="page1" aria-controls="data-table-default" data-dt-idx="1" tabindex="1" >1</a>'+
	                        '</li>');

		for (var i = 2; i <= $cantPage; i++) {
			$('#btn-page').append('<li class="paginate_button" tabindex="'+i+'" id="btn'+i+'">'+
		                        	'<a href="#" onclick="GetDoctorsByPaginated('+i+', '+"null"+')" id="page'+i+'" aria-controls="data-table-default" data-dt-idx="'+i+'" tabindex="'+i+'" >'+i+'</a>'+
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
 GetDoctorsByPaginated(0);
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
 		GetDoctorsByPaginated($.cookie('cantPage'));
	} else {
		$('#btn6').addClass('active');
 		GetDoctorsByPaginated(6);
	}

 $('#lastBtn').addClass('disabled');
 $('#beginBtn').removeClass('disabled');
}