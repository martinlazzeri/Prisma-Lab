function RefreshToken(){
  $.ajax({
    async: false,
    type: 'POST',
    contentType: 'application/json',
    url: 'api/token',
    dataType: 'json',
    data: JSON.stringify({ 'grant_type': 'refresh_token',
                           'client_id': 'prismapp',
                           'client_secret': 'abcdef',
                           'refresh_token': $.cookie('refresh_token') }),
    success: function(response) {
      Cookies.set('access_token', response.access_token, {expires: 365});
      Cookies.set('expires_in', (response.expires_in), {expires: 365});
      Cookies.set('token_type', response.token_type, {expires: 365});
      Cookies.set('refresh_token', response.refresh_token, {expires: 365});
    },
    error: function(error) {
    }
  });
}