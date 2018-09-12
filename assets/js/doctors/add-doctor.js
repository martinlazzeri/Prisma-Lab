$(document).ready(function(){
  $("#enrollment").focus();
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
                          'firstname': $('#firstname').val(),
                          'lastname' : $('#lastname').val(),
                          'address': $('#address').val(),
                          'phone': $('#phone').val()}),
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