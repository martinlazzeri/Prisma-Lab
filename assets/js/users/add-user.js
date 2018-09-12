$(document).ready(function(){
  $("#firstname").focus();
});

function AddUser(){
  var avatarUrl = "";

  if ($("input[type=file]")[0].files[0] !== undefined){
    avatarUrl = $("input[type=file]")[0].files[0].name;
  }

  $.ajax({
    type: 'POST',
    url: 'api/users/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'firstname': $('#firstname').val(),
                          'lastname': $('#lastname').val(),
                          'email': $('#email').val(),
                          'birthdate' : $('#birthdate').val(),
                          'username': $('#user-username').val(),
                          'password': $('#password').val(),
                          'role': $('#roleId').val(),
                          'avatarUrl': avatarUrl}),
    success: function(response) {
      var inputImagen = new FormData($("input[name^='upload']"));

      $.each($("input[name^='upload']")[0].files, function(index, item) {
        inputImagen.append(index, item);
      });  

      $.ajax({
          url: "subir_img.php",
          type: "POST",
          data: inputImagen,
          enctype: "multipart/form-data",
          processData: false,
          contentType: false,
          success: function(response){},
          error: function(error){}
        });
        $.bigBox({
          title : "Éxito",
          content : "El usuario se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });
        CleanUserForm('addUser');
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