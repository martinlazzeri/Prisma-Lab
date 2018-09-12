$(document).ready(function(){
  $("#enrollment").focus();
});

$('#btn-addnewDoctor').on('click', function(){
  setTimeout(function(){ $('#enrollment').focus(); }, 180);
});

function AddDoctor(){

  $.ajax({
    type: 'POST',
    url: 'api/doctors/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'enrollment': $('#enrollment').val(),
                          'typeEnrollment': $('#typeEnrollment').val(),
                          'firstname': $('#doctor-firstname').val(),
                          'lastname' : $('#doctor-lastname').val(),
                          'address': $('#doctor-address').val(),
                          'phone': $('#doctor-phone').val()}),
    success: function(response) {
        $.bigBox({
          title : "Éxito",
          content : "El médico se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });
        CleanDoctorForm('addDoctor');
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

function AddModalDoctor(){
  var enrollment = $('#enrollment').val();
  var firstname = $('#doctor-firstname').val();
  var lastname = $('#doctor-lastname').val();

  $.ajax({
    type: 'POST',
    url: 'api/doctors/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'enrollment': $('#enrollment').val(),
                          'typeEnrollment': $('#typeEnrollment').val(),
                          'firstname': $('#doctor-firstname').val(),
                          'lastname' : $('#doctor-lastname').val(),
                          'address': $('#doctor-address').val(),
                          'phone': $('#doctor-phone').val()}),
    success: function(response) {
        $.bigBox({
          title : "Éxito",
          content : "El médico se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });

        CleanDoctorForm('addModalDoctor');
        $.cookie('doctorId', response.Data);
        $('#search-doctor').val(enrollment+ " - "+ firstname+" "+lastname);
        setTimeout(function(){ $('#search-welfare').focus(); }, 500);
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