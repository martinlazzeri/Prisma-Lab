$(document).ready(function(){
	$("#color-encabezado").val($.cookie("ColorEncabezado"));
	$("#color-encabezado-cinta").val($.cookie("ColorEncabezadoCinta"));
	$("#color-menu-lateral").val($.cookie("ColorMenuLateral"));
	$("#color-pie-pagina").val($.cookie("ColorPiePagina"));
	$("#color-fondo").val($.cookie("ColorFondo"));
	$("#lema-lab").val($.cookie("LemaLab"));
	$("#nombre-lab").val($.cookie("NombreLab"));
	$.cookie("SinConexion") === 1 ? $("#sin-conexion").prop("checked", true) : $("#sin-conexion").prop("checked", false);
});	

$("#colores-default").click(function(e){		
	$("#color-encabezado").val("#E7E7E7");
	$("#color-encabezado-cinta").val("#474544");
	$("#color-menu-lateral").val("#3A3633");
	$("#color-pie-pagina").val("#2A2725");
	$("#color-fondo").val("#F3F3F3");
	e.preventDefault();
});

function readURL(input) {
    if (input.files && input.files[0]) {        	
        var reader = new FileReader();
        
        reader.onload = function (e) {
        	if(input.id === "logo-lab")
        	{
    			$("#logo-lab-prev").attr("src", e.target.result);
                $("#logo-lab-prev").attr("width", 200);
                $("#logo-lab-prev").attr("height", 200);
    		}
    		if (input.id === "imagen-perfil")
    		{
    			$("#imagen-perfil-prev").attr("src", e.target.result);
                $("#imagen-perfil-prev").attr("width", 200);
                $("#imagen-perfil-prev").attr("height", 200);
    		}                
        }            
        reader.readAsDataURL(input.files[0]);
    }
}

$("#logo-lab").change(function(){
    readURL(this);
});    

$("#imagen-perfil").change(function(){
    readURL(this);
});	

$("#guardar").click(function(e){
	$("#guardar").prop("disabled", true);
	$.ajax({
		type: "PUT",
		contentType: "application/json",
		url: "api/configuraciones/modificar",
		dataType: "json",			
		data: FormToJSON(),
		headers: {"Authorization": $.cookie("ApiKey")},			
		success: function(response){
			if (response.error === true)
			{
				if (response.data === "La configuración no existe")
				{
					$.bigBox({
						title : "Error",
						content : "La configuración de usuario que intenta modificar ya no existe.",
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			}
			else
			{	//subo la imagen de logo de laboratorio
				var inputLogo = new FormData($("input[name^='logo-lab']"));
		        $.each($("input[name^='logo-lab']")[0].files, function(index, item) {
		        	inputLogo.append(index, item);
		        });        

				$.ajax({
			      	url: "subir_logo.php",
			      	type: "POST",
			      	data: inputLogo,
			      	enctype: "multipart/form-data",
			      	processData: false,
			      	contentType: false,
			      	success: function(respuesta){

			      	},
			      	error: function(err){

			      	}
			    });

				//subo la imagen de perfil de usuario
			    var inputImagen = new FormData($("input[name^='imagen-perfil']"));
		        $.each($("input[name^='imagen-perfil']")[0].files, function(index, item) {
		        	inputImagen.append(index, item);
		        });        

				$.ajax({
			      	url: "subir_img.php",
			      	type: "POST",
			      	data: inputImagen,
			      	enctype: "multipart/form-data",
			      	processData: false,
			      	contentType: false,
			      	success: function(respuesta){

			      	},
			      	error: function(err){

			      	}
			    });

				$.bigBox({
					title : "Éxito",
					content : "La configuración se ha modificado correctamente.",
					color : "#739E73",
					timeout: 5000,
					icon : "fa fa-check"					
				});

				//cambio el color de los items sin recargar la pagina
				$("#header").css("background-color", $("#color-encabezado").val());
				$("#ribbon").css("background-color", $("#color-encabezado-cinta").val());
				$("#left-panel").css("background-color", $("#color-menu-lateral").val());
				$("#page-footer").css("background-color", $("#color-pie-pagina").val());
				$("#content").css("background-color", $("#color-fondo").val());					

				//actualizo las cookies de color
				$.cookie("ColorEncabezado", "#"+($("#color-encabezado").val().substr(-6)));
				$.cookie("ColorEncabezadoCinta", "#"+($("#color-encabezado-cinta").val().substr(-6)));
				$.cookie("ColorMenuLateral", "#"+($("#color-menu-lateral").val().substr(-6)));
				$.cookie("ColorPiePagina", "#"+($("#color-pie-pagina").val().substr(-6)));
				$.cookie("ColorFondo", "#"+($("#color-fondo").val().substr(-6)));
				$("sin-conexion").is(":checked") ? $.cookie("SinConexion", 1) : $.cookie("SinConexion", 0);
				$("#nombre-lab").val() !== "" ? $.cookie("NombreLab", $("#nombre-lab").val()) : $.cookie("NombreLab", "JJLab");
				document.title = $.cookie("NombreLab")+" - Configuraciones";
				$("#nombre-laboratorio").text($.cookie("NombreLab"));

				$("#lema-lab").val() !== "" ? $.cookie("LemaLab", $("#lema-lab").val()) : $.cookie("LemaLab", "");

				//si hay logo seleccionado, actualizo la cookie de Logo de laboratorio y el logo sin recargar la pagina
				if ($("input[type=file]")[0].files[0] !== undefined)
				{
					$.cookie("UrlParcialLogo", "img/logo/"+$("input[type=file]")[0].files[0].name);
					$("#logo img").prop("src", $.cookie("UrlParcialLogo"));
				}

				//si hay imagen de usuario seleccionada, actualizo la cookie de imagen de usuario y la imagen sin recargar la pagina
				if ($("input[type=file]")[1].files[0] !== undefined)
				{
					$.cookie("UrlParcialImagen", "usuarios/imagenes-perfil/"+$("input[type=file]")[1].files[0].name);
					$("#show-shortcut img").prop("src", $.cookie("UrlParcialImagen"));
				}
				
				//llamo a session.php para actualizar las variables de sesión
				$.post("session.php", {"UrlParcialLogo": $.cookie("UrlParcialLogo"),
									   "UrlParcialImagen": $.cookie("UrlParcialImagen"),
									   "NombreLab": $.cookie("NombreLab"),
									   "LemaLab": $.cookie("LemaLab"),
									   "SinConexion": $.cookie("SinConexion")});
			}
		},
		error: function(error){
			if (error.status === 500)
			{
				$.bigBox({
					title : "Error",
					content : "Ha ocurrido un error crítico y su solicitud no pudo ser procesada.",
					color : "#C46A69",
					timeout: 8000,
					icon : "fa fa-warning shake animated"
				});
			}
			else
			{
				$.bigBox({
					title : "Error",
					content : "No se pudo modificar la configuración del usuario.",
					color : "#C46A69",
					timeout: 5000,
					icon : "fa fa-warning shake animated"
				});
			}
		}
	});	
	$("#guardar").prop("disabled", false);
	e.preventDefault();
});

function FormToJSON(){
	var logolab = "";
	var imgusuario = "";

	if ($("input[type=file]")[0].files[0] !== undefined)
	{
		logolab = $("input[type=file]")[0].files[0].name;
	}

	if ($("input[type=file]")[1].files[0] !== undefined)
	{
		imgusuario = $("input[type=file]")[1].files[0].name;
	}

	$("#sin-conexion").is(":checked") ? sinconex = 1 : sinconex = 0
	return JSON.stringify({
		"IdUsuario": $.cookie("Id"),
		"ColorEncabezado": $("#color-encabezado").val(),
		"ColorEncabezadoCinta": $("#color-encabezado-cinta").val(),
		"ColorMenuLateral": $("#color-menu-lateral").val(),
		"ColorPiePagina": $("#color-pie-pagina").val(),
		"ColorFondo": $("#color-fondo").val(),
		"LogoLab": logolab,
		"Imagen": imgusuario,
		"NombreLab": $("#nombre-lab").val(),
		"LemaLab": $("#lema-lab").val(),
		"TrabajarSinConexion": sinconex,
		"ModificadoPor": $.cookie("NombreUsuario")
	});
}

$("#nombre-lab").keypress(function(key){
	if (key.which === 13)
	{
		key.preventDefault();
	}
});

