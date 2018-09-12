<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Register";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page");
include("inc/header.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->		
		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">					
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
						<div class="well no-padding">

							<form action="php/demo-register.php" id="FormularioRegistro" class="smart-form client-form">
								<header>
									Registro de Usuarios
								</header>

								<fieldset>
									<section>
										<label class="input"> <i class="icon-append fa fa-user"></i>
											<input type="text" name="NombreUsuario" id="NombreUsuario" placeholder="Nombre de Usuario" maxlength="50">
											<b class="tooltip tooltip-bottom-right">Necesario para entrar en el sitio.</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											<input type="email" name="Email" id="Email" placeholder="Dirección de Email" maxlength="50">
											<b class="tooltip tooltip-bottom-right">Necesario para verificar tu cuenta.</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="Contrasena" id="Contrasena" placeholder="Contraseña" maxlength="50">
											<b class="tooltip tooltip-bottom-right">Necesario para entrar en el sitio.</b> </label>
									</section>

									<section>
										<label class="input"> <i class="icon-append fa fa-lock"></i>
											<input type="password" name="RepetirContrasena" id="RepetirContrasena" placeholder="Repetir la contraseña" maxlength="50">
											<b class="tooltip tooltip-bottom-right">Necesario para entrar en el sitio.</b> </label>
									</section>	
									
									<section>
											<label class="select">
												<select name="Role" id="Role">
													<option value="0" selected="" disabled="">Rol</option>
													<option value="1">Administrador</option>
													<option value="2">Auditor</option>
													<option value="3">Director</option>
													<option value="4">Secretaria</option>
												</select> <i></i> </label>
									</section>					
								</fieldset>

								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="input">
												<input type="text" name="Nombre" id="Nombre" placeholder="Nombre" maxlength="50">
											</label>
										</section>
										<section class="col col-6">
											<label class="input">
												<input type="text" name="Apellido" id="Apellido" placeholder="Apellido" maxlength="50">
											</label>
										</section>
									</div>

									<div class="row">
										<section class="col col-6">
											<label class="select">
												<select name="genero" id="genero">
													<option value="0" selected="" disabled="">Género</option>
													<option value="1">Masculino</option>
													<option value="2">Femenino</option>
													<option value="3">Prefiero no responder</option>
												</select> <i></i> </label>
										</section>
										<section class="col col-6">
											<label class="input"> <i class="icon-append fa fa-calendar"></i>
												<input type="text" name="FechaNacimiento" id="FechaNacimiento" placeholder="Fecha de Nacimiento" class="datepicker" data-dateformat='dd/mm/yy'>
											</label>
										</section>																			
									</div>									
								</fieldset>
								<footer>
									<button type="submit" class="btn btn-primary" id="Registrar">
										Registrar
									</button>
								</footer>

								<div class="message">
									<i class="fa fa-check"></i>
									<p>
										Gracias por tu registro!
									</p>
								</div>
							</form>

						</div>						
					</div>
				</div>
			</div>

			<div class="modal modal-danger" id="ModalExitoRegistro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								×
							</button>
							<h4 class="modal-title" id="myModalLabel">Usuario registrado exitosamente</h4>
						</div>						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
									Continuar
							</button>					
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-exito-registro -->				
			</div>
			<div class="modal modal-danger" id="ModalErrorRegistroRepetido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								×
							</button>
							<h4 class="modal-title" id="myModalLabel">Error en el registro.
								Nombre de usuario y/o email repetidos. Intente nuevamente.</h4>
						</div>						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
									Reintentar
							</button>					
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-error-registro -->
			</div>
			<div class="modal modal-danger" id="ModalErrorRegistro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								×
							</button>
							<h4 class="modal-title" id="myModalLabel">Error en el registro.
								Asegúrese de completar todos los campos.
								Por favor, intente nuevamente.</h4>
						</div>						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
									Reintentar
							</button>					
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-error-registro -->
			</div>
		</div><!-- end main content-->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">

	$(document).ready(function(){
		$('#Registrar').on("click", function(e){
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				contentType: 'application/json',
				url: '../../api/usuarios/crear',
				dataType: 'json',
				data: FormToJSON(),
				success: function(response){
					if (response.error == false) 
					{
						alert('usuario creado: ' + response.data);
						$('#ModalExitoRegistro').modal({show: true});
						$('#NombreUsuario').val('');
						$('#Email').val('');
						$('#Contrasena').val('');
						$('#RepetirContrasena').val('');
						$('#Role').val(0);
						$('#Nombre').val('');
						$('#Apellido').val('');
						$('#genero').val('');
						$('#FechaNacimiento').val('');
					}			
					else
					{
						$('#ModalErrorRegistroRepetido').modal({show: true});
						$('#NombreUsuario').val('');
						$('#Email').val('');
					}		
				},
				error: function(error){
					alert(error.data);
					$('#ModalErrorRegistro').modal({show: true});
				}
			});	
		});
	});
	
	function FormToJSON(){

		return JSON.stringify({
        	"NombreUsuario": $('#NombreUsuario').val(),
        	"Contrasena": $('#Contrasena').val(),
        	"Nombre": $('#Nombre').val(),
        	"Apellido": $('#Apellido').val(),
        	"Email": $('#Email').val(),
        	"FechaNacimiento": $('#FechaNacimiento').val(),
        	"RoleId": $('#Role').val()
        });
	}

	runAllForms();
	
	// Model i agree button
	$("#i-agree").click(function(){
		$this=$("#terms");
		if($this.checked) {
			$('#myModal').modal('toggle');
		} else {
			$this.prop('checked', true);
			$('#myModal').modal('toggle');
		}
	});
	
	// Validation
	$(function() {
		// Validation
		$("#smart-form-register").validate({

			// Rules for form validation
			rules : {
				username : {
					required : true
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					required : true,
					minlength : 3,
					maxlength : 20,
					equalTo : '#password'
				},
				firstname : {
					required : true
				},
				lastname : {
					required : true
				},
				gender : {
					required : true
				},
				terms : {
					required : true
				}
			},

			// Messages for form validation
			messages : {
				login : {
					required : 'Please enter your login'
				},
				email : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				},
				passwordConfirm : {
					required : 'Please enter your password one more time',
					equalTo : 'Please enter the same password as above'
				},
				firstname : {
					required : 'Please select your first name'
				},
				lastname : {
					required : 'Please select your last name'
				},
				gender : {
					required : 'Please select your gender'
				},
				terms : {
					required : 'You must agree with Terms and Conditions'
				}
			},

			// Ajax form submition
			submitHandler : function(form) {
				$(form).ajaxSubmit({
					success : function() {
						$("#smart-form-register").addClass('submited');
					}
				});
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