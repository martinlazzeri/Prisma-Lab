$(document).ready(function(){
  $("#search-patient").focus();
});

$('#btn-addPatient').on('click', function(){
  setTimeout(function(){ $('#dni').focus(); }, 180);
});

function AddPatient(){
  var dni = $('#dni').val();
  var firstname = $('#firstname').val();
  var lastname = $('#lastname').val();

  $.ajax({
    type: 'POST',
    url: 'api/patients/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'dni': $('#dni').val(),
                          'firstname': $('#firstname').val(),
                          'lastname': $('#lastname').val(),
                          'birthdate' : $('#birthdate').val(),
                          'sex': $('#sex').val(),
                          'address': $('#address').val(),
                          'phone': $('#phone').val(),
                          'email': $('#email').val()}),
    success: function(response) {
        $.bigBox({
          title : "Éxito",
          content : "El paciente se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });

        CleanPatientForm('addModalPatient');
        $.cookie('patientId', response.Data);
        $('#search-patient').val(dni+" - "+ firstname+" "+lastname);
        setTimeout(function(){ $('#search-doctor').focus(); }, 500);
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
      if(error.status == 409){
        $.bigBox({
            title : "Error",
            content : "El email es incorrecto. Verifique el formato de email que ingresó.",
            color : "#C46A69",
            timeout: 8000,
            icon : "fa fa-warning shake animated"
        });
        $('#email').focus();
      }
    }
  });
}