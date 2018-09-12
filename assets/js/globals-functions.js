/*
 * Spinners
 */
$("#spinner").spinner();
$("#spinner-decimal").spinner({
	step : 0.01,
	numberFormat : "n"
});

$("#spinner-currency").spinner({
	min : 5,
	max : 2500,
	step : 25,
	start : 1000,
	numberFormat : "C"
});


var mobile = {
  Android: function() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function() {
    return navigator.userAgent.match(/IEMobile/i);
  },
  Any: function() {
    return (mobile.Android() || mobile.BlackBerry() || mobile.iOS() || mobile.Opera() || mobile.Windows());
  }
};

//Users
function ReadURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$("#ShowImage").attr("src", e.target.result);
			$("#ShowImage").attr("width", 200);
			$("#ShowImage").attr("height", 200);
		};
		
		reader.readAsDataURL(input.files[0]);
	}
}

$("#image").change(function(){
	readURL(this);
});

function CleanUserForm($name){
	if($name == 'addUser'){
		$("#form-addUsers").get(0).reset();
		$('#firstname').focus();
	} else if($name == 'editUser'){
		$("#form-editUsers").get(0).reset();
		$("#form-editUsers :input").prop("disabled", true); 
	} else if($name == 'removeUser'){
		$("#form-removeUsers").get(0).reset();
	} 

	$("#ShowImage").prop("src", "app/usuarios/imagenes-perfil/avatar.gif");
	$("#search-user").prop("disabled", false);
	$("#search-user").focus();
}

function CheckUserInputs($checkName, $name){
	if($('#'+$name).val() != ''){

	  $.ajax({
	    type: 'GET',
	    url: 'api/users/'+$checkName+'/'+$('#'+$name).val()+'/userId/'+$.cookie('UserId'),
	    headers: { "Content-Type": "application/json",
	             "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
	    dataType: 'json',
	    success: function(response) {
	    	$('.error-'+$checkName).empty();

	    	if(response.Message != undefined){
	    		$('.error-'+$checkName).append('<p>'+response.Message+'</p>');
	    		$('#'+$name).focus();
	    	}
	    },
	    error: function(error){}
	  });
	} else {
		$('.error-'+$checkName).empty();
	}
}

function GetUserById($id){
	$.ajax({
		type: 'GET',
		url: 'api/users/'+$id+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
			var user = JSON.parse(response.Data);

			$("#form-editUsers :input").prop("disabled", false);	
			$('#user-username').prop("disabled", true);
			$('#email').prop("disabled", true);
			$("#firstname").focus();	
			$('#firstname').val(user.firstname);
			$('#lastname').val(user.lastname);
			$('#user-username').val(user.username);
			$('#email').val(user.email);
			$('#birthdate').val(user.birthdate);
			$('#roleId').val(user.roleId);

			if(user.avatarUrl != ''){
				$("#ShowImage").prop("src", "assets/img/users/"+user.avatarUrl);
			}
		},
		error: function(error){
			CleanUserForm('editUser');
		}
	});
}

/*************************************************************************************************************/

//Doctors
function CleanDoctorForm($name){
	if($name == 'addDoctor'){
		$("#form-addDoctors").get(0).reset();
		$('#enrollment').focus();
	} else if($name == 'editDoctor'){
		$("#form-editDoctors").get(0).reset();
		$("#form-editDoctors :input").prop("disabled", true); 
		$("#search-doctor").prop("disabled", false);
	  $("#search-doctor").focus();
	} else if($name == 'removeDoctor'){
		$("#form-removeDoctors").get(0).reset();
		$("#search-doctor").prop("disabled", false);
	  $("#search-doctor").focus();
	} else if ($name == 'addModalDoctor'){
		$("#form-addModalDoctors").get(0).reset();
		$('#modalDoctor').modal('hide');
	}
}

function CheckDoctorInputs($checkName, $name){
	if($('#'+$name).val() != ''){

	  $.ajax({
	    type: 'GET',
	    url: 'api/doctors/'+$checkName+'/'+$('#'+$name).val()+'/userId/'+$.cookie('UserId'),
	    headers: { "Content-Type": "application/json",
	             "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
	    dataType: 'json',
	    success: function(response) {
	    	$('.error-'+$checkName).empty();

	    	if(response.Message != undefined){
	    		$('.error-'+$checkName).append('<p>'+response.Message+'</p>');
	    		$('#'+$name).focus();
	    	}
	    },
	    error: function(error){}
	  });
	} else {
		$('.error-'+$checkName).empty();
	}
}

function GetDoctorById($id){
	$.ajax({
		type: 'GET',
		url: 'api/doctors/'+$id+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
			var doctor = JSON.parse(response.Data);

			$("#form-editDoctors :input").prop("disabled", false);	
			$('#enrollment').prop("disabled", true);
			$("#firstname").focus();	
			$('#enrollment').val(doctor.enrollment);
			$('#firstname').val(doctor.firstname);
			$('#lastname').val(doctor.lastname);
			$('#typeEnrollment').val(doctor.typeEnrollment);
			$('#address').val(doctor.address);
			$('#phone').val(doctor.phone);
		},
		error: function(error){
			CleanDoctorForm('editDoctor');
		}
	});
}
/*************************************************************************************************************/

//Welfares
function CleanWelfareForm($name){
	if($name == 'addWelfare'){
		$("#form-addWelfares").get(0).reset();
		$('#code').focus();
	} else if($name == 'editWelfare'){
		$("#form-editWelfares").get(0).reset();
		$("#form-editWelfares :input").prop("disabled", true); 
	} else if($name == 'removeWelfare'){
		$("#form-removeWelfares").get(0).reset();
	} 

	$("#search-welfare").prop("disabled", false);
	$("#search-welfare").focus();
}

function CheckWelfareInputs($checkName, $name){
	if($('#'+$name).val() != ''){

	  $.ajax({
	    type: 'GET',
	    url: 'api/welfares/'+$checkName+'/'+$('#'+$name).val()+'/userId/'+$.cookie('UserId'),
	    headers: { "Content-Type": "application/json",
	             "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
	    dataType: 'json',
	    success: function(response) {
	    	$('.error-'+$checkName).empty();

	    	if(response.Message != undefined){
	    		$('.error-'+$checkName).append('<p>'+response.Message+'</p>');
	    		$('#'+$name).focus();
	    	}
	    },
	    error: function(error){}
	  });
	} else {
		$('.error-'+$checkName).empty();
	}
}

function GetWelfareById($id){
	$.ajax({
		type: 'GET',
		url: 'api/welfares/'+$id+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
			var welfare = JSON.parse(response.Data);

			$("#form-editWelfares :input").prop("disabled", false);	
			$('#code').prop("disabled", true);
			$('#name').prop("disabled", true);
			$("#coveragePercentage").focus();	
			$('#code').val(welfare.code);
			$('#name').val(welfare.name);
			$('#payAtHome').val(welfare.payAtHome);
			$('#pmo').val(welfare.pmo);
			$('#coinsurance').val(welfare.coinsurance);
			$('#serviceAvailable').val(welfare.serviceAvailable);
			$('#disposableMaterial').val(welfare.disposableMaterial);
			$('#completeNomenclator').val(welfare.completeNomenclator);
			$('#minimumAmount').val(welfare.minimumAmount);
			$('#coveragePercentage').val(welfare.coveragePercentage);
			$('#percentage').val(welfare.percentage);
			$('#inosReducido').val(welfare.inosReducido);
			$('#aValue').val(welfare.aValue);
			$('#bValue').val(welfare.bValue);
			$('#cValue').val(welfare.cValue);
			$('#nbuValue').val(welfare.nbuValue);
			$('#comments').val(welfare.comments);
			$('#internalComments').val(welfare.internalComments);
		},
		error: function(error){
			CleanWelfareForm('editWelfare');
		}
	});
}

/*************************************************************************************************************/

//Patients
function CleanPatientForm($name){
	if($name == 'addModalPatient'){
		$("#form-addModalPatients").get(0).reset();
		$('#modalPatient').modal('hide');
	} else if($name == 'editPatient'){
		$("#form-editPatients").get(0).reset();
		$("#form-editPatients :input").prop("disabled", true); 
	} else if($name == 'removePatient'){
		$("#form-removePatients").get(0).reset();
	} 
}

function CheckPatientInputs($checkName, $name){
	if($('#'+$name).val() != ''){

	  $.ajax({
	    type: 'GET',
	    url: 'api/patients/'+$checkName+'/'+$('#'+$name).val()+'/userId/'+$.cookie('UserId'),
	    headers: { "Content-Type": "application/json",
	             	 "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
	    dataType: 'json',
	    success: function(response) {
	    	$('.error-'+$checkName).empty();

	    	if(response.Message != undefined){
	    		$('.error-'+$checkName).append('<p>'+response.Message+'</p>');
	    		$('#'+$name).focus();
	    	}
	    },
	    error: function(error){}
	  });
	} else {
		$('.error-'+$checkName).empty();
	}
}

function GetPatientById($id){
	$.ajax({
		type: 'GET',
		url: 'api/patients/'+$id+'/userId/'+$.cookie('UserId'),
		headers: {"Content-Type": "application/json",
							"Authorization": $.cookie('token_type') + ' '+ $.cookie('access_token')},
		dataType: 'json',
		success: function(response){
			var welfare = JSON.parse(response.Data);

			$("#form-editPatients :input").prop("disabled", false);	
			$('#dni').prop("disabled", true);
			$('#dni').val(welfare.dni);
			$("#firstname").focus();	
			$('#lastname').val(welfare.lastname);
			$('#birthdate').val(welfare.birthdate);
			$('#sex').val(welfare.sex);
			$('#address').val(welfare.address);
			$('#phone').val(welfare.phone);
			$('#email').val(welfare.email);
		},
		error: function(error){
			CleanPatientForm('editPatient');
		}
	});
}