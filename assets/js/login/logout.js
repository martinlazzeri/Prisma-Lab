$('#link-logout').click(function(e){           
  $.SmartMessageBox({
      title : "<i class='fa fa-sign-out icon-logout'></i>Cerrar Sesión en <strong class='icon-logout'>PrismaLab</strong>",
      content : $.cookie('Firstname')+" "+$.cookie('Lastname')+", desea salir de la aplicación ?",
      buttons : "[No][Sí]"
  }, function(ButtonPressed) {
      if (ButtonPressed === "Sí") {
        $.removeCookie('access_token', { path: '/' });
        $.removeCookie('expires_in', { path: '/' });
        $.removeCookie('token_type', { path: '/' });
        $.removeCookie('refresh_token', { path: '/' });
        $.removeCookie('AvatarUrl', { path: '/' });
        $.removeCookie('UserId', { path: '/' });
        $.removeCookie('Birthdate', { path: '/' });
        $.removeCookie('Firstname', { path: '/' });
        $.removeCookie('Lastname', { path: '/' });
        $.removeCookie('Email', { path: '/' });
        $.removeCookie('Username', { path: '/' });
        $.removeCookie('RoleId', { path: '/' });
        $.removeCookie('RoleName', { path: '/' });
        $.removeCookie('cantPage');
        $.removeCookie('patientId');
        $.removeCookie('doctorId');
        $.removeCookie('welfareId');
        $(window).attr('location', 'login.php');
      }           
  });
  e.preventDefault();
});