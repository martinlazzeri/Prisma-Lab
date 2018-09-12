<?php
//initilize the page
require_once("inc/init.php");
require_once("inc/config.ui.php");

$page_title = "Iniciar Sesión";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");
?>

<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/plugins/js-cookie/js.cookie.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>

<script>
	if($.cookie('Username') !== undefined){
		if($.cookie('RoleId') == 1){
			$(window).attr('location', 'http://entity-studio.com/old/prismalab/');
		}
	}
</script>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
</header>
<div id="main" role="main">
	<!-- MAIN CONTENT -->
	<div id="content" class="container">
		<div class="row">
			<div class="col-xs-1 col-sm-12 col-md-5 col-lg-4">
			</div>
			<div class="col-xs-10 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					<form action="" id="FormularioLogin" class="smart-form client-form">
						<header>
							Entrada
						</header>
						<fieldset>
							<section>
								<label class="label">Nombre de Usuario</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" id="username" autofocus>
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor, ingrese su nombre de usuario</b></label>
							</section>
							<section>
								<label class="label">Contraseña</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" id="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Ingrese su contraseña</b> </label>								
							</section>
						</fieldset>
						<footer>
							<div>
								<button type="submit" class="btn btn-primary" id="btn-login"> Entrar </button>
								<div class="note">
									<a href="<?php echo APP_URL; ?>/forgotpassword.php">¿Olvidó su contraseña?</a>
									<?php //echo md5(sha1('admin'))?>
								</div>								
							</div>							
						</footer>
					</form>
				</div>							
			</div>
			<div class="col-xs-1 col-sm-12 col-md-5 col-lg-4">
			</div>
		</div>
	</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
	<script src="assets/js/login/login.js"></script>

<?php 
	//include required scripts
	include("inc/scripts.php");
?>
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<script type="text/javascript">	
	runAllForms();		
	$(document).ready(function(){	
		$('#username').focus();

		$('#Entrar').click(function(e){
			e.preventDefault();
			$.ajax({
				type : 'POST',
				contentType : 'application/json',
				url : 'api/usuarios/login',
				dataType: 'json',
				data : FormToJSON(),
				success: function(response){				
					$.cookie('Id', response.data['Id']);
					$.cookie('ApiKey',response.data['ApiKey']);					
					$.cookie('NombreUsuario', response.data['NombreUsuario']);
					$.cookie('Nombre', response.data['Nombre']);
					$.cookie('Apellido', response.data['Apellido']);
					$.cookie('Email', response.data['Email']);
					$.cookie('RoleId', response.data['RoleId']);
					$.cookie('UrlParcialImagen', response.data['Imagen']);
					$.cookie('UrlParcialLogo', response.data['Logo']);
					$.cookie('ColorEncabezado', response.data['ColorEncabezado']);
					$.cookie('ColorEncabezadoCinta', response.data['ColorEncabezadoCinta']);
					$.cookie('ColorMenuLateral', response.data['ColorMenuLateral']);
					$.cookie('ColorPiePagina', response.data['ColorPiePagina']);
					$.cookie('ColorFondo', response.data['ColorFondo']);
					$.cookie('NombreLab', response.data['NombreLab']);
					$.cookie('LemaLab', response.data['LemaLab']);
					$.cookie('SinConexion', response.data['SinConexion']);
					$.post( "session.php", { "ApiKey": response.data['ApiKey'],
											 "Id": response.data['Id'],
											 "NombreUsuario": response.data['NombreUsuario'],
											 "Nombre": response.data['Nombre'],
											 "Apellido": response.data['Apellido'],
											 "Email": response.data['Email'],
											 "RolId": response.data['RoleId'],
											 "RolDescrip": response.data['Descripcion'],
											 "Imagen": response.data['Imagen'],
											 "Logo": response.data['Logo'],
											 "NombreLab": response.data['NombreLab'],
											 "LemaLab": response.data['LemaLab'],
											 "SinConexion": response.data['SinConexion']});					

					$(window).attr('location', 'index.php');
				},
				error: function(error){
					if (error.status === 500) 
					{
						$.bigBox({
							title : "Error",
							content : 'Ha ocurrido un error crítico y su solicitud no pudo ser procesada.',
							color : "#C46A69",
							timeout: 8000,
							icon : "fa fa-warning shake animated"
						});
					}
					if (error.status === 401) 
					{
						$.bigBox({
							title : "Error de ingreso.",
							content : "Usuario y/o contraseña incorrectos. <br>Por favor, intente nuevamente.",
							color : "#C46A69",
							timeout: 5000,
							icon : "fa fa-warning shake animated"
						});
						$('#NombreUsuario').val('');
					$('#Contrasena').val('');
					}

					arr = ['NombreUsuario', 'Contrasena'];
					Errores = '';
					j = 0;
					for (var i = 0; i < arr.length; i++) {
						if(j < 3){
							if (error.responseJSON.message.indexOf(arr[i]) > 0)
							{
								Errores += arr[i].toString()+', ';
								j++;
							}
						}
					};
					Errores = Errores.replace('NombreUsuario', 'nombre de usuario');
					Errores = Errores.replace('Contrasena', 'contraseña');					
					Errores = 'Campo(s) requerido(s) '+Errores+' vacío(s) o nulo(s).';
					$.bigBox({
						title : "Error",
						content : 'Asegúrese que completó todos los campo requeridos. <br>'+Errores+'<br><br>',
						color : "#C46A69",
						timeout: 5000,
						icon : "fa fa-warning shake animated"
					});
				}
			});
		});
	});
	function FormToJSON(){
		return JSON.stringify({
        	"NombreUsuario": $('#NombreUsuario').val(),
        	"Contrasena": $('#Contrasena').val()        	
        });
	}
	$(function() {
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				username : {
					required : true,
				},
				password : {
					required : true,
				}
			},
			// Messages for form validation
			messages : {
				username : {
					required : 'Por favor ingrese su nombre de usuario'
				},
				password : {
					required : 'Por favor ingrese su contraseña'
				}
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>