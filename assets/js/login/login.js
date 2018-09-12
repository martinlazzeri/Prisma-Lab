$('#btn-login').click(function(e) {
  var user = $('#username').val();
  var pass = $('#password').val();

  if ($.cookie('access_token') == undefined) {
    $.ajax({
      async: false,
      type: 'POST',
      contentType: 'application/json',
      url: 'api/token',
      dataType: 'json',
      data: JSON.stringify({ 'grant_type': 'password',
                             'client_id': 'prismapp',
                             'client_secret': 'abcdef',
                             'username': user,
                             'password': pass }),
      success: function(response) {
        Cookies.set('access_token', response.access_token, {expires: 365});
        Cookies.set('expires_in', (response.expires_in), {expires: 365});
        Cookies.set('token_type', response.token_type, {expires: 365});
        Cookies.set('refresh_token', response.refresh_token, {expires: 365});
      },
      error: function(error) {
        if (error.status === 500){
          $.bigBox({
            title : "Error",
            content : 'Ha ocurrido un error crítico y su solicitud no pudo ser procesada.',
            color : "#C46A69",
            timeout: 8000,
            icon : "fa fa-warning shake animated"
          });
          $('#username').focus();
        }
        if (error.status === 401){
          $.bigBox({
            title : "Error de ingreso.",
            content : "Usuario y/o contraseña incorrectos. <br>Por favor, intente nuevamente.",
            color : "#C46A69",
            timeout: 5000,
            icon : "fa fa-warning shake animated"
          });
          $('#username').val('');
          $('#password').val('');
          $('#username').focus();
        }
        
        if(error.status === 400){
          $.bigBox({
            title : "Error",
            content : 'Asegúrese que completó todos los campo requeridos.',
            color : "#C46A69",
            timeout: 5000,
            icon : "fa fa-warning shake animated"
          });
          $('#username').focus();
        }
      }
    });
  }

  if ($.cookie('access_token') !== undefined) {
    $.ajax({
      async: false,
      type: 'POST',
      url: 'api/login/',
      headers: { "Content-Type": "application/json", 
                 "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token') },
      dataTyoe: 'json',
      data: JSON.stringify({ 'username': user, 'password':pass }),
      success: function(response) {
        var user = JSON.parse(response.Data);
        
        Cookies.set('AvatarUrl', user.avatarUrl, {expires: 365});
        Cookies.set('UserId', user.id, {expires: 365});
        Cookies.set('Firstname', user.firstname, {expires: 365});
        Cookies.set('Lastname', user.lastname, {expires: 365});
        Cookies.set('Email', user.email, {expires: 365});
        Cookies.set('Birthdate', user.birthdate, {expires: 365});
        Cookies.set('Username', user.username, {expires: 365});
        Cookies.set('RoleId', user.roleId, {expires: 365});
        Cookies.set('RoleName', user.roleName, {expires: 365});
        $(window).attr('location', 'http://entity-studio.com/old/prismalab/');
      },
      error: function(error){}
    });
  }
  e.preventDefault();
});