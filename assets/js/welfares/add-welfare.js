$(document).ready(function(){
  $("#code").focus();
});

$("#check-inos").on("change", function(){
  if ($("#check-inos").is(":checked")){
    $("#form-inos").fadeIn("slow");
    $("#inosReducido").focus();
  }
  else { $("#form-inos").fadeOut("slow");}
});

$("#check-faba").on("change", function(){
  if ($("#check-faba").is(":checked")){
    $("#form-faba").fadeIn("slow");
    $("#aValue").focus();
  }
  else { $("#form-faba").fadeOut("slow");}
});

$("#check-nbu").on("change", function(){
  if ($("#check-nbu").is(":checked")){
    $("#form-nbu").fadeIn("slow");
    $("#nbuValue").focus();
  }
  else { $("#form-nbu").fadeOut("slow");}
});

$('#btn-addNewWelfare').on('click', function(){
  setTimeout(function(){ $('#code').focus(); }, 180);
});

function AddWelfare(){

  $.ajax({
    type: 'POST',
    url: 'api/welfares/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'code': $('#code').val(),
                          'name': $('#name').val(),
                          'payAtHome': $('#payAtHome').val(),
                          'pmo': $('#pmo').val(),
                          'coinsurance': $('#coinsurance').val(),
                          'serviceAvailable': $('#serviceAvailable').val(),
                          'disposableMaterial': $('#disposableMaterial').val(),
                          'completeNomenclator': $('#completeNomenclator').val(),
                          'minimumAmount' : $('#minimumAmount').val(),
                          'coveragePercentage': $('#coveragePercentage').val(),
                          'percentage': $('#percentage').val(),
                          'inosReducido' : $('#inosReducido').val(),
                          'aValue': $('#aValue').val(),
                          'bValue': $('#bValue').val(),
                          'cValue': $('#cValue').val(),
                          'nbuValue': $('#nbuValue').val(),
                          'comments': $('#comments').val(),
                          'internalComments': $('#internalComments').val()}),
    success: function(response) {
        $.bigBox({
          title : "Éxito",
          content : "La obra social se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });
        CleanWelfareForm('addWelfare');
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

function AddModalWelfare(){
  var code = $('#code').val();
  var name = $('#name').val();

  $.ajax({
    type: 'POST',
    url: 'api/welfares/userId/'+$.cookie('UserId'),
    headers: { "Content-Type": "application/json",
               "Authorization": $.cookie('token_type') + ' ' + $.cookie('access_token')},
    dataType: 'json',
    data: JSON.stringify({'code': $('#code').val(),
                          'name': $('#name').val(),
                          'payAtHome': $('#payAtHome').val(),
                          'pmo': $('#pmo').val(),
                          'coinsurance': $('#coinsurance').val(),
                          'serviceAvailable': $('#serviceAvailable').val(),
                          'disposableMaterial': $('#disposableMaterial').val(),
                          'completeNomenclator': $('#completeNomenclator').val(),
                          'minimumAmount' : $('#minimumAmount').val(),
                          'coveragePercentage': $('#coveragePercentage').val(),
                          'percentage': $('#percentage').val(),
                          'inosReducido' : $('#inosReducido').val(),
                          'aValue': $('#aValue').val(),
                          'bValue': $('#bValue').val(),
                          'cValue': $('#cValue').val(),
                          'nbuValue': $('#nbuValue').val(),
                          'comments': $('#comments').val(),
                          'internalComments': $('#internalComments').val()}),
    success: function(response) {
        $.bigBox({
          title : "Éxito",
          content : "La obra social se ha creado correctamente.",
          color : "#739E73",
          timeout: 5000,
          icon : "fa fa-check"          
        });

        CleanWelfareForm('addModalWelfare');
        $.cookie('welfareId', response.Data);
        $('#search-welfare').val(code+ " - "+ name);
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