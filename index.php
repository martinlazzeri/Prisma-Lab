<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/plugins/js-cookie/js.cookie.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="assets/plugins/moment-with-locales.min.js"></script>

<script>
	if($.cookie('UserId') == undefined){
	  $(window).attr('location', 'login.php');
	} 	
</script>

<?php
//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
/*---------------- PHP Custom Scripts ---------
YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */
$page_title = "Escritorio";
/* ---------------- END PHP Custom Scripts ------------- */
//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
include("inc/header.php");
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["dashboard"]["active"] = true;
include("inc/nav.php");
?>

<div id="main" role="main">
	<?php
		include("inc/ribbon.php");
	?>
	<div id="content">		
		<?php include_once("inicio/inicio.php") ?>
	</div>
</div>
<?php
	include("inc/footer.php");
?>
<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>
<script>
	$('#perfil-image').append('<img src="assets/img/users/'+$.cookie('AvatarUrl')+'" alt="" class="online" height="28" width="25"/>'+ 
														'<span id="username">'+$.cookie('Firstname')+' '+$.cookie('Lastname')+'</span>');
</script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/js/login/refresh-token.js"></script>
<script src="assets/js/login/logout.js"></script>
<script src="assets/js/globals-functions.js"></script>
<script>	
	function LoadContent(type){
		$("li")	.removeClass("active");

		switch(type)
		{
			// Sección Inicio
			case 0:
					$("li")	.removeClass("active");
					$("#content").fadeIn("slow").load("inicio/inicio.php");
					$("#Inicio").addClass("active");
					$("#ribbon-breadcrum").text("Inicio");
					document.title = $.cookie("NombreLab")+" - Inicio";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			// Fin Sección Inicio
			
			// Sección Ingresos
			case 100:
					$("#ribbon-breadcrum").text("Procesos de Ingresos");
					break;
			case 101:
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes");
					break;
			case 102:
					$("#content").fadeIn("slow").load("views/entries/add-entry.html");
					$("#IngresoNormal").addClass("active");					
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Ingreso Normal");
					document.title = $.cookie("NombreLab")+" - Ingreso Normal de Pacientes";
					break;
			case 103:
					$("#content").fadeIn("slow").load("app/ingresos/pacientes/ingreso-paciente-uno-uno.php");
					$("#IngresoUnoUno").addClass("active");					
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Ingreso Uno A Uno");
					document.title = $.cookie("NombreLab")+" - Ingreso Uno a Uno de Pacientes";
					break;
			case 104:
					$("#content").fadeIn("slow").load("app/ingresos/pacientes/modificacion-paciente.php");
					$("#ReingresoPaciente").addClass("active");					
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Modificación Pacientes");
					document.title = $.cookie("NombreLab")+" - Modificación de Pacientes";
					break;
			case 105:
					$("#content").fadeIn("slow").load("app/ingresos/pacientes/borrado-paciente-uno-uno.php");
					$("#BorradoUnoUno").addClass("active");					
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Borrado Pacientes");
					document.title = $.cookie("NombreLab")+" - Borrado de Pacientes";
					break;
			case 106:
					$("#content").fadeIn("slow").load("app/ingresos/pacientes/listado-pacientes-normal.php");
					$("#ListadoNormal").addClass("active");				
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Pacientes";
					break;
			case 107:
					$("#content").fadeIn("slow").load("app/ingresos/pacientes/certificados/certificado-asistencia.php");
					$("#CertificadoNormal").addClass("active");					
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Pacientes / Certificado de Asistencia");
					document.title = $.cookie("NombreLab")+" - Certificado de Asistencia";
					break;
			// Fin Sección Ingresos

			// Sección Planillas de Trabajo
			case 108:
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Planillas de Trabajo");
					break;
			case 109:
					$("#content").fadeIn("slow").load("app/ingresos/planillas-trabajo/planilla-por-seccion.php");
					$("#PlanillaPorSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Planillas de Trabajo / Por Sección");
					document.title = $.cookie("NombreLab")+" - Ingreso de Planillas Por Sección";
					break;
			case 110:
					$("#content").fadeIn("slow").load("app/ingresos/planillas-trabajo/planilla-por-paciente.php");
					$("#PlanillaPorPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Planillas de Trabajo / Por Paciente");
					document.title = $.cookie("NombreLab")+" - Ingreso de Planillas Por Paciente";
					break;
			case 111:
					$("#content").fadeIn("slow").load("app/ingresos/planillas-trabajo/planilla-por-practica.php");
					$("#PlanillaPorPractica").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Planillas de Trabajo / Por Práctica");
					document.title = $.cookie("NombreLab")+" - Ingreso de Planillas Por Práctca";
					break;
			case 112:
					$("#content").fadeIn("slow").load("app/ingresos/planillas-trabajo/planilla-por-practicas-diarias.php");
					$("#PlanillaPorPracticasDiarias").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Planillas de Trabajo / Por Prácticas Diarias");
					document.title = $.cookie("NombreLab")+" - Ingreso de Planillas Por Prácticas Diarias";
					break;
			// Fin Sección Planillas de Trabajo

			// Sección Ingreso Resultados
			case 113:
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Ingreso de Resultados");
					break;		
			case 114:
					$("#content").fadeIn("slow").load("app/ingresos/resultados/ingreso-por-seccion.php");
					$("#ResultadoPorSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Ingreso de Resultados / Por Sección");
					document.title = $.cookie("NombreLab")+" - Ingreso de Resultados Por Sección";
					break;
			case 115:
					$("#content").fadeIn("slow").load("app/ingresos/resultados/ingreso-por-paciente.php");
					$("#ResultadoPorPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Ingreso de Resultados / Por Paciente");
					document.title = $.cookie("NombreLab")+" - Ingreso de Resultados Por Paciente";
					break;
			case 116:
					$("#content").fadeIn("slow").load("app/ingresos/resultados/ingreso-por-practica.php");
					$("#ResultadoPorPractica").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Ingreso de Resultados / Por Práctica");
					document.title = $.cookie("NombreLab")+" - Ingreso de Resultados Por Práctica";
					break;
			case 117:
					$("#FormulaHemograma").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Ingreso de Resultados / Fórmula de Hemograma");
					document.title = $.cookie("NombreLab")+" - Ingreso de Resultados Fórmula Hemograma";
					break;
			// Fin Sección Ingreso Resultados

			// Sección Patologías
			case 118:
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Patologías");
					break;
			case 119:
					$("#AnalisisAnteriores").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Patologías / Pacientes con Análisis Anteriores");
					document.title = $.cookie("NombreLab")+" - Ingreso de Patologías Pacientes Análisis Anteriores";
					break;
			case 120:
					$("#ProtocolosAnteriores").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Ingresos / Patologías / Protocolos Anteriores");
					document.title = $.cookie("NombreLab")+" - Ingreso de Patologías Protocolos Anteriores";
					break;
			// Fin Sección Patologías

			// Sección Consulta y Corrección
			case 200:
					$("#ribbon-breadcrum").text("Consulta y Corrección");
					break;
			case 201:
					$("#ribbon-breadcrum").text("Consulta y Corrección / Consulta de Resultados");
					break;
			case 202:
					$("#content").fadeIn("slow").load("app/consulta-correccion/consulta-resultados-paciente.php");
					$("#ResultadosPacientes").addClass("active");
					$("#ribbon-breadcrum").text("Consulta y Corrección / Consulta de Resultados / Por Pacientes");
					document.title = $.cookie("NombreLab")+" - Consulta de Resultados por Pacientes";
					break;
			case 203:
					$("#content").fadeIn("slow").load("app/consulta-correccion/calculo-presupuestos.php");
					$("#CalculoPresupuestos").addClass("active");
					$("#ribbon-breadcrum").text("Consulta y Corrección / Cálculo de Presupuestos");
					document.title = $.cookie("NombreLab")+" - Consulta de Resultados Cálculo de Presupuestos";
					break;
			case 204:
					$("#content").fadeIn("slow").load("app/consulta-correccion/correccion-resultados.php");
					$("#CorreccionResultados").addClass("active");
					$("#ribbon-breadcrum").text("Consulta y Corrección / Corrección de Resultados");
					document.title = $.cookie("NombreLab")+" - Consulta de Resultados Corrección de Resultados";
					break;
			case 205: // NO VA MÁS
					$("#ConsultaProtocolosComprimidos").addClass("active");
					$("#ribbon-breadcrum").text("Consulta y Corrección / Consulta de Índices de Protocolos Comprimidos");
					document.title = $.cookie("NombreLab")+" - Consulta de Resultados Protocolos Comprimidos";
					break;
			// Fin Sección Consulta y Correción

			// Sección Emisión Protocolos
			case 300:
					$("#ribbon-breadcrum").text("Emisión de Protocolos");
					break;
			case 301:
					$("#content").fadeIn("slow").load("app/protocolos/protocolos-terminados.php");
					$("#ProtocolosTerminados").addClass("active");
					$("#ribbon-breadcrum").text("Emisión de Protocolos / Protocolos Terminados");
					document.title = $.cookie("NombreLab")+" - Emisión de Protocolos Terminados";
					break;
			case 302:
					$("#content").fadeIn("slow").load("app/protocolos/protocolos-uno-a-uno.php");
					$("#ProtocolosUnoUno").addClass("active");
					$("#ribbon-breadcrum").text("Emisión de Protocolos / Protocolos Uno a Uno");
					document.title = $.cookie("NombreLab")+" - Emisión de Protocolos Uno a Uno";
					break;
			case 303:
					$("#content").fadeIn("slow").load("app/protocolos/entrega-protocolos.php");
					$("#EntregaProtocolos").addClass("active");
					$("#ribbon-breadcrum").text("Emisión de Protocolos / Entrega de Protocolos");
					document.title = $.cookie("NombreLab")+" - Emisión de Protocolos Entrega";
					break;
			case 304:
					$("#content").fadeIn("slow").load("app/protocolos/reemision-protocolos.php");
					$("#ReemisionProtocolos").addClass("active");
					$("#ribbon-breadcrum").text("Emisión de Protocolos / Reemisión de Protocolos");
					document.title = $.cookie("NombreLab")+" - Reemisión de Protocolos";
					break;
			// Fin Sección Emisión Protocolos

			// Sección Procesos de Cierre
			case 400:
					$("#ribbon-breadcrum").text("Procesos de Cierre");
					break;
			case 401:
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Diario");
					break;
			case 402:
					$("#AlfabeticoPacientes").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Diario / Listado Alfabético de Pacientes");
					document.title = $.cookie("NombreLab")+" - Cierre Diario Alfabético de Pacientes";
					break;
			case 403:
					$("#ListadoPendientes").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Diario / Listado de Pendientes");
					document.title = $.cookie("NombreLab")+" - Cierre Diario Pendientes";
					break;
			case 404:
					$("#ListadosProtocolosComprimidos").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Diario / Listado de Protocolos Comprimidos");
					document.title = $.cookie("NombreLab")+" - Cierre Diario Protocolos Comprimidos";
					break;					
			case 405:
					$("#ListadoCajaDiaria").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Diario / Listado de Caja Diaria");
					document.title = $.cookie("NombreLab")+" - Cierre Diario de Caja";
					break;
			case 406:
					$("#CierreMensual").addClass("active");
					$("#ribbon-breadcrum").text("Procesos de Cierre / Cierre Mensual");
					document.title = $.cookie("NombreLab")+" - Cierre Mensual";
					break;
			// Fin Sección Procesos de Cierre
			
			// Sección Nomenclador y Nomenclador Ex-Inos
			case 500:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos");
					break;
			case 501:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomenclador");
					break;
			case 502:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/nomenclador/alta-nomenclador.php");
					$("#AltaNomenclador").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomenclador / Alta Nomenclador");
					document.title = $.cookie("NombreLab")+" - Alta de Nomenclador";
					break;
			case 503:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/nomenclador/modificacion-nomenclador.php");
					$("#ModificacionNomenclador").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomenclador / Modificación Nomenclador");
					document.title = $.cookie("NombreLab")+" - Modificación de Nomenclador";
					break;
			case 504:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/nomenclador/borrado-nomenclador.php");
					$("#BorradoNomenclador").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomenclador / Borrado Nomenclador");
					document.title = $.cookie("NombreLab")+" - Borrado de Nomenclador";
					break;
			case 505:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/nomenclador/listados-nomencladores.php");
					$("#ListadoNomenclador").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomenclador / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Nomenclador";
					break;
				
			// Sección Secciones
			case 511:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Secciones");
					break;
			case 512:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/secciones/alta-seccion.php");
					$("#AltaSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Secciones / Alta Sección");
					document.title = $.cookie("NombreLab")+" - Alta de Sección";
					break;
			case 513:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/secciones/modificacion-seccion.php");
					$("#ModificacionSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Secciones / Modificación Sección");
					document.title = $.cookie("NombreLab")+" - Modificación de Sección";
					break;
			case 514:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/secciones/borrado-seccion.php");
					$("#BorradoSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Secciones / Borrado Sección");
					document.title = $.cookie("NombreLab")+" - Borrado de Sección";
					break;
			case 515:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/secciones/listado-secciones.php");
					$("#ListadoSeccion").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Secciones / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Sección";
					break;
			// Fin Sección Secciones
			
			// Sección Titulos
			case 516:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Títulos");
					break;
			case 517:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/titulos/alta-titulo.php");
					$("#AltaTitulo").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Títulos / Alta Título");
					document.title = $.cookie("NombreLab")+" - Alta de Título";
					break;
			case 518:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/titulos/modificacion-titulo.php");
					$("#ModificacionTitulo").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Títulos / Modificación Título");
					document.title = $.cookie("NombreLab")+" - Modificación de Título";
					break;
			case 519:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/titulos/borrado-titulo.php");
					$("#BorradoTitulo").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Títulos / Borrado Título");
					document.title = $.cookie("NombreLab")+" - Borrado de Título";
					break;
			case 520:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/titulos/listado-titulo.php");
					$("#ListadoTitulos").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Títulos / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Título";
					break;
			// Fin Sección Titulos
			
			// Seccion Validacion de Archivos
			case 521:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Validación de Archivos");
					break;
			case 522:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Validación de Archivos / Validación Nomenclador-Sección");
					$.ajax({
						type: "GET",
						contentType: "application/json",
						url: "api/validacion/nomencladorseccion",
						dataType: "json",
						beforeSend: function(xhr){
							xhr.setRequestHeader("Authorization", $.cookie("ApiKey"));
						},
						success: function(response){
							if (response.error === true)
							{
								if (response.data === "La validación es incorrecta") 
								{
									$.bigBox({
										title : "Error",
										content : "La validación de archivos para nomencladores y secciones es incorrecta.",
										color : "#C46A69",
										timeout: 8000,
										icon : "fa fa-warning shake animated"
									});
								}								
							}
							else
							{
								$.bigBox({
									title : "Éxito",
									content : "La validación de nomencladores sobre secciones es correcta.",
									color : "#739E73",
									timeout: 5000,
									icon : "fa fa-check"					
								});
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
									content : "No se pueden obtener los datos para validar.",
									color : "#C46A69",
									timeout: 8000,
									icon : "fa fa-warning shake animated"
								});
							}
						}
					});
					$("#ValidacionNomencladorSeccion").addClass("active");
					document.title = $.cookie("NombreLab")+" - Validación Nomenclador-Sección";
					break;
			case 523:
					$("#ValidacionNomencladorTitulo").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Validación de Archivos / Validación Nomenclador-Título");
					document.title = $.cookie("NombreLab")+" - Validación Nomenclador-Título";
					break;
			// Fin Sección Validación de Archivos

			// Sección Nemotécnicos
			case 524:
					$("#Nemotecnicos").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nemotécnicos");
					document.title = $.cookie("NombreLab")+" - Nemotécnicos";
					break;
			// Fin Sección Nemotécnicos
			
			// Sección Obras Sociales
			case 525:
					$("#ribbon-breadcrum").text("Obras Sociales");
					break;
			case 526:
					$("#content").fadeIn("slow").load("views/welfares/add-welfare.html");
					$("#AltaObraSocial").addClass("active");
					$("#ribbon-breadcrum").text("Obras Sociales / Alta Obra Social");
					document.title = $.cookie("NombreLab")+" - Alta de Obra Social";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 527:
					$("#content").fadeIn("slow").load("views/welfares/edit-welfare.html");
					$("#ModificacionObraSocial").addClass("active");
					$("#ribbon-breadcrum").text("Obras Sociales / Modificación Obra Social");
					document.title = $.cookie("NombreLab")+" - Modificación de Obra Social";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 528:
					$("#content").fadeIn("slow").load("views/welfares/remove-welfare.html");
					$("#BorradoObraSocial").addClass("active");
					$("#ribbon-breadcrum").text("Obras Sociales / Borrado Obra Social");
					document.title = $.cookie("NombreLab")+" - Borrado de Obra Social";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 529:
					$("#content").fadeIn("slow").load("views/welfares/list-welfare.html");
					$("#ListadoObraSocial").addClass("active");
					$("#ribbon-breadcrum").text("Obras Sociales / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Obra Social";
					GetWelfaresByPaginated(0);
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			// Fin Sección Obras Sociales
			
			// Sección Nomencladores Especiales
			case 530:
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomencladores Especiales");
					break;
			case 531:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/practicas/alta-practica.php");
					$("#AltaPractica").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomencladores Especiales / Alta Nomenclador Especial");
					document.title = $.cookie("NombreLab")+" - Alta de Nomencladores Especiales";
					break;
			case 532:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/practicas/modificacion-practica.php");
					$("#ModificacionPractica").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomencladores Especiales / Modificación Nomenclador Especial");
					document.title = $.cookie("NombreLab")+" - Modificación de Nomencladores Especiales";
					break;
			case 533:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/practicas/borrado-practica.php");
					$("#BorradoPractica").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomencladores Especiales / Borrado Nomenclador Especial");
					document.title = $.cookie("NombreLab")+" - Borrado de Nomencladores Especiales";
					break;
			case 534:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/practicas/listado-practicas.php");
					$("#ListadoPracticas").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Nomencladores Especiales / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Nomencladores Especiales";
					break;
			// Fin Sección Nomencladores Especiales
				
			// Sección Cálculos
			case 540:
					$("#Calculos").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Cálculos");
					document.title = $.cookie("NombreLab")+" - Cálculos";
					break;
			// Fin Sección Cálculos

			// Sección Médicos
			case 541:
					$("#ribbon-breadcrum").text("Médicos");
					break;
			case 542:
					$("#content").fadeIn("slow").load("views/doctors/add-doctor.html");
					$("#AltaMedico").addClass("active");
					$("#ribbon-breadcrum").text("Médicos / Alta Médico");
					document.title = $.cookie("NombreLab")+" - Alta de Médico";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 543:
					$("#content").fadeIn("slow").load("views/doctors/edit-doctor.html");
					$("#ModificacionMedico").addClass("active");
					$("#ribbon-breadcrum").text("Médicos / Modificación Médico");
					document.title = $.cookie("NombreLab")+" - Modificación de Médico";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 544:
					$("#content").fadeIn("slow").load("views/doctors/remove-doctor.html");
					$("#BorradoMedico").addClass("active");
					$("#ribbon-breadcrum").text("Médicos / Borrado Médico");
					document.title = $.cookie("NombreLab")+" - Borrado de Médico";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 545:
					$("#content").fadeIn("slow").load("views/doctors/list-doctor.html");
					$("#ListadoMedicos").addClass("active");
					$("#ribbon-breadcrum").text("Médicos / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listado de Médico";
					GetDoctorsByPaginated(0);
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			// Fin Sección Médicos
			
			// Sección Valores de Unidades
			case 546:
					$("#content").fadeIn("slow").load("app/mantenimiento-archivos/valores-unidades/valores-unidades.php");
					$("#ValoresUnidades").addClass("active");
					$("#ribbon-breadcrum").text("Mantenimiento Archivos / Valores de Unidades en Uso");
					document.title = $.cookie("NombreLab")+" - Valores de Unidades en Uso";
					break;
			// Fin Sección Valores de Unidades

			// Sección Usuarios
			case 600:
					$("#ribbon-breadcrum").text("Usuarios");
					break;
			case 601:
					$("#ribbon-breadcrum").text("Usuarios / Altas");
					break;
			case 602:
					$("#content").fadeIn("slow").load("views/users/add-user.html");
					$("#AltaUsuario").addClass("active");
					$("#ribbon-breadcrum").text("Usuarios / Altas / Ingreso Normal");
					document.title = $.cookie("NombreLab")+" - Alta de Usuario";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 603:
					$("#ribbon-breadcrum").text("Usuarios / Modificaciones");
					break;
			case 604:
					$("#content").fadeIn("slow").load("views/users/edit-user.html");
					$("#ModificacionUsuario").addClass("active");
					$("#ribbon-breadcrum").text("Usuarios / Modificaciones / Modificación");
					document.title = $.cookie("NombreLab")+" - Modificación de Usuario";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 					break;
			case 605:
					$("#ribbon-breadcrum").text("Usuarios / Borrado");
					break;
			case 606:
					$("#content").fadeIn("slow").load("views/users/remove-user.html");
					$("#BorradoUsuario").addClass("active");
					$("#ribbon-breadcrum").text("Usuarios / Borrado / Borrado Normal");
					document.title = $.cookie("NombreLab")+" - Borrado de Usuario";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 607:	
					$("#ribbon-breadcrum").text("Usuarios / Listados");
					break;		
			case 608:
					$("#content").fadeIn("slow").load("views/users/list-user.html");
					$("#ListadoUsuario").addClass("active");
					$("#ribbon-breadcrum").text("Usuarios / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listados / Listado Normal";
					GetUsersByPaginated(0);
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			// Fin Sección Usuarios

			// Sección Pacientes
			case 800:
					$("#ribbon-breadcrum").text("Pacientes");
					break;
			case 801:
					$("#ribbon-breadcrum").text("Pacientes / Altas");
					break;
			case 802:
					$("#content").fadeIn("slow").load("views/patients/add-patient.html");
					$("#AltaPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Pacientes / Altas");
					document.title = $.cookie("NombreLab")+" - Alta de Paciente";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 803:
					$("#ribbon-breadcrum").text("Pacientes / Modificaciones");
					break;
			case 804:
					$("#content").fadeIn("slow").load("views/patients/edit-patient.html");
					$("#ModificacionPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Pacientes / Modificaciones / Modificación");
					document.title = $.cookie("NombreLab")+" - Modificación de Paciente";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 					break;
			case 805:
					$("#ribbon-breadcrum").text("Pacientes / Borrado");
					break;
			case 806:
					$("#content").fadeIn("slow").load("views/patients/remove-patient.html");
					$("#BorradoPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Pacientes / Borrado / Borrado Normal");
					document.title = $.cookie("NombreLab")+" - Borrado de Paciente";
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			case 807:	
					$("#ribbon-breadcrum").text("Pacientes / Listados");
					break;		
			case 808:
					$("#content").fadeIn("slow").load("views/patients/list-patient.html");
					$("#ListadoPaciente").addClass("active");
					$("#ribbon-breadcrum").text("Pacientes / Listado Normal");
					document.title = $.cookie("NombreLab")+" - Listados / Listado Normal";
					GetPatientsByPaginated(0);
				  if(mobile.Any()){
					  $("html").toggleClass("hidden-menu-mobile-lock");
						$("body").toggleClass("hidden-menu");
				  } 
					break;
			// Fin Sección Pacientes

			// Sección Configuraciones
			case 700:
					$("#ribbon-breadcrum").text("Configuraciones");					
					break;
			case 701:
					$("#content").fadeIn("slow").load("app/configuraciones/configuraciones-usuario.php");
					$("#ConfiguracionesUsuario").addClass("active");
					$("#ribbon-breadcrum").text("Configuraciones / Configuración de Usuario");
					document.title = $.cookie("NombreLab")+" - Configuraciones";
					break;
			// Fin Sección Configuraciones
		}
	};
	
	$(document).ready(function() {		
		setInterval(RefreshToken, 600000);
		
		/*
		$("#header").css("background-color", "#"+($.cookie("ColorEncabezado").substr(-6)));
		$("#ribbon").css("background-color", "#"+($.cookie("ColorEncabezadoCinta").substr(-6)));
		$("#left-panel").css("background-color", "#"+($.cookie("ColorMenuLateral").substr(-6)));
		$("#page-footer").css("background-color", "#"+($.cookie("ColorPiePagina").substr(-6)));
		$("#content").css("background-color", "#"+($.cookie("ColorFondo").substr(-6)));*/
		$.cookie("NombreLab") == "" ? $("#nombre-laboratorio").text("JJLab") : $("#nombre-laboratorio").text($.cookie("NombreLab"));		

		/*
		 * PAGE RELATED SCRIPTS
		 */	
		$(".js-status-update a").click(function() {
			var selText = $(this).text();
			var $this = $(this);
			$this.parents(".btn-group").find(".dropdown-toggle").html(selText + " <span class='caret'></span>");
			$this.parents(".dropdown-menu").find("li").removeClass("active");
			$this.parent().addClass("active");
		});
		/*
		* TODO: add a way to add more todo"s to list
		*/
		// initialize sortable
		$(function() {
			$("#sortable1, #sortable2").sortable({
				handle : ".handle",
				connectWith : ".todo",
				update : countTasks
			}).disableSelection();
		});
		// check and uncheck
		$(".todo .checkbox > input[type='checkbox']").click(function() {
			var $this = $(this).parent().parent().parent();
			if ($(this).prop("checked")) {
				$this.addClass("complete");
				// remove this if you want to undo a check list once checked
				//$(this).attr("disabled", true);
				$(this).parent().hide();
				// once clicked - add class, copy to memory then remove and add to sortable3
				$this.slideUp(500, function() {
					$this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
					$this.remove();
					countTasks();
				});
			} else {
				// insert undo code here...
			}
		})
		// count tasks
		function countTasks() {
			$(".todo-group-title").each(function() {
				var $this = $(this);
				$this.find(".num-of-tasks").text($this.next().find("li").size());
			});
		}
		/*
		* RUN PAGE GRAPHS
		*/
		/* TAB 1: UPDATING CHART */
		// For the demo we use generated data, but normally it would be coming from the server
		var data = [], totalPoints = 200, $UpdatingChartColors = $("#updating-chart").css("color");
		function getRandomData() {
			if (data.length > 0)
				data = data.slice(1);
			// do a random walk
			while (data.length < totalPoints) {
				var prev = data.length > 0 ? data[data.length - 1] : 50;
				var y = prev + Math.random() * 10 - 5;
				if (y < 0)
					y = 0;
				if (y > 100)
					y = 100;
				data.push(y);
			}
			// zip the generated y values with the x values
			var res = [];
			for (var i = 0; i < data.length; ++i)
				res.push([i, data[i]])
			return res;
		}
		// setup control widget
		var updateInterval = 1500;
		$("#updating-chart").val(updateInterval).change(function() {
			var v = $(this).val();
			if (v && !isNaN(+v)) {
				updateInterval = +v;
				$(this).val("" + updateInterval);
			}
		});		
		/* live switch */
		$("input[type='checkbox']#start_interval").click(function() {
			if ($(this).prop("checked")) {
				$on = true;
				updateInterval = 1500;
				update();
			} else {
				clearInterval(updateInterval);
				$on = false;
			}
		});
		function update() {
			if ($on == true) {
				plot.setData([getRandomData()]);
				plot.draw();
				setTimeout(update, updateInterval);
			} else {
				clearInterval(updateInterval)
			}
		}
		var $on = false;
		/*end updating chart*/
		/* TAB 2: Social Network  */		
		// END TAB 2
		// TAB THREE GRAPH //
		/* TAB 3: Revenew  */
		$(function() {
			var trgt = [[1354586000000, 153], [1364587000000, 658], [1374588000000, 198], [1384589000000, 663], [1394590000000, 801], [1404591000000, 1080], [1414592000000, 353], [1424593000000, 749], [1434594000000, 523], [1444595000000, 258], [1454596000000, 688], [1464597000000, 364]], prft = [[1354586000000, 53], [1364587000000, 65], [1374588000000, 98], [1384589000000, 83], [1394590000000, 980], [1404591000000, 808], [1414592000000, 720], [1424593000000, 674], [1434594000000, 23], [1444595000000, 79], [1454596000000, 88], [1464597000000, 36]], sgnups = [[1354586000000, 647], [1364587000000, 435], [1374588000000, 784], [1384589000000, 346], [1394590000000, 487], [1404591000000, 463], [1414592000000, 479], [1424593000000, 236], [1434594000000, 843], [1444595000000, 657], [1454596000000, 241], [1464597000000, 341]], toggles = $("#rev-toggles"), target = $("#flotcontainer");
			var data = [{
				label : "Target Profit",
				data : trgt,
				bars : {
					show : true,
					align : "center",
					barWidth : 30 * 30 * 60 * 1000 * 80
				}
			}, {
				label : "Actual Profit",
				data : prft,
				color : "#3276B1",
				lines : {
					show : true,
					lineWidth : 3
				},
				points : {
					show : true
				}
			}, {
				label : "Actual Signups",
				data : sgnups,
				color : "#71843F",
				lines : {
					show : true,
					lineWidth : 1
				},
				points : {
					show : true
				}
			}]
			var options = {
				grid : {
					hoverable : true
				},
				tooltip : true,
				tooltipOpts : {
					//content: "%x - %y",
					//dateFormat: "%b %y",
					defaultTheme : false
				},
				xaxis : {
					mode : "time"
				},
				yaxes : {
					tickFormatter : function(val, axis) {
						return "$" + val;
					},
					max : 1200
				}
			};
			plot2 = null;
			function plotNow() {
				var d = [];
				toggles.find(":checkbox").each(function() {
					if ($(this).is(":checked")) {
						d.push(data[$(this).attr("name").substr(4, 1)]);
					}
				});
				if (d.length > 0) {
					if (plot2) {
						plot2.setData(d);
						plot2.draw();
					} else {
						plot2 = $.plot(target, d, options);
					}
				}
			};
			toggles.find(":checkbox").on("change", function() {
				plotNow();
			});
			plotNow()
		});
		/*
		 * VECTOR MAP
		 */
		data_array = {
			"US" : 4977,
			"AU" : 4873,
			"IN" : 3671,
			"BR" : 2476,
			"TR" : 1476,
			"CN" : 146,
			"CA" : 134,
			"BD" : 100
		};
		$("#vector-map").vectorMap({
			map : "world_mill_en",
			backgroundColor : "#fff",
			regionStyle : {
				initial : {
					fill : "#c4c4c4"
				},
				hover : {
					"fill-opacity" : 1
				}
			},
			series : {
				regions : [{
					values : data_array,
					scale : ["#85a8b6", "#4d7686"],
					normalizeFunction : "polynomial"
				}]
			},
			onRegionLabelShow : function(e, el, code) {
				if ( typeof data_array[code] == "undefined") {
					e.preventDefault();
				} else {
					var countrylbl = data_array[code];
					el.html(el.html() + ": " + countrylbl + " visits");
				}
			}
		});
		/*
		 * FULL CALENDAR JS
		 */
		if ($("#calendar").length) {
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			var calendar = $("#calendar").fullCalendar({
				editable : true,
				draggable : true,
				selectable : false,
				selectHelper : true,
				unselectAuto : false,
				disableResizing : false,
				header : {
					left : "title", //,today
					center : "prev, next, today",
					right : "month, agendaWeek, agenDay" //month, agendaDay,
				},
				select : function(start, end, allDay) {
					var title = prompt("Event Title:");
					if (title) {
						calendar.fullCalendar("renderEvent", {
							title : title,
							start : start,
							end : end,
							allDay : allDay
						}, true // make the event "stick"
						);
					}
					calendar.fullCalendar("unselect");
				},
				events : [{
					title : "All Day Event",
					start : new Date(y, m, 1),
					description : "long description",
					className : ["event", "bg-color-greenLight"],
					icon : "fa-check"
				}, {
					title : "Long Event",
					start : new Date(y, m, d - 5),
					end : new Date(y, m, d - 2),
					className : ["event", "bg-color-red"],
					icon : "fa-lock"
				}, {
					id : 999,
					title : "Repeating Event",
					start : new Date(y, m, d - 3, 16, 0),
					allDay : false,
					className : ["event", "bg-color-blue"],
					icon : "fa-clock-o"
				}, {
					id : 999,
					title : "Repeating Event",
					start : new Date(y, m, d + 4, 16, 0),
					allDay : false,
					className : ["event", "bg-color-blue"],
					icon : "fa-clock-o"
				}, {
					title : "Meeting",
					start : new Date(y, m, d, 10, 30),
					allDay : false,
					className : ["event", "bg-color-darken"]
				}, {
					title : "Lunch",
					start : new Date(y, m, d, 12, 0),
					end : new Date(y, m, d, 14, 0),
					allDay : false,
					className : ["event", "bg-color-darken"]
				}, {
					title : "Birthday Party",
					start : new Date(y, m, d + 1, 19, 0),
					end : new Date(y, m, d + 1, 22, 30),
					allDay : false,
					className : ["event", "bg-color-darken"]
				}, {
					title : "Smartadmin Open Day",
					start : new Date(y, m, 28),
					end : new Date(y, m, 29),
					className : ["event", "bg-color-darken"]
				}],
				eventRender : function(event, element, icon) {
					if (!event.description == "") {
						element.find(".fc-event-title").append("<br/><span class='ultra-light'>" + event.description + "</span>");
					}
					if (!event.icon == "") {
						element.find(".fc-event-title").append("<i class='air air-top-right fa ' + event.icon + ' '></i>");
					}
				}
			});
		};
		/* hide default buttons */
		$(".fc-header-right, .fc-header-center").hide();
		// calendar prev
		$("#calendar-buttons #btn-prev").click(function() {
			$(".fc-button-prev").click();
			return false;
		});
		// calendar next
		$("#calendar-buttons #btn-next").click(function() {
			$(".fc-button-next").click();
			return false;
		});
		// calendar today
		$("#calendar-buttons #btn-today").click(function() {
			$(".fc-button-today").click();
			return false;
		});
		// calendar month
		$("#mt").click(function() {
			$("#calendar").fullCalendar("changeView", "month");
		});
		// calendar agenda week
		$("#ag").click(function() {
			$("#calendar").fullCalendar("changeView", "agendaWeek");
		});
		// calendar agenda day
		$("#td").click(function() {
			$("#calendar").fullCalendar("changeView", "agendaDay");
		});
		/*
		 * CHAT
		 */
		$.filter_input = $("#filter-chat-list");
		$.chat_users_container = $("#chat-container > .chat-list-body");
		$.chat_users = $("#chat-users");
		$.chat_list_btn = $("#chat-container > .chat-list-open-close");
		/*
		* LIST FILTER (CHAT)
		*/
		// custom css expression for a case-insensitive contains()
		jQuery.expr[":"].Contains = function(a, i, m) {
			return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
		};		
		// open chat list
		$.chat_list_btn.click(function() {
			$(this).parent("#chat-container").toggleClass("open");
		});
	});
</script>
<script src="assets/js/users/list-user.js"></script>
<script src="assets/js/doctors/list-doctor.js"></script>
<script src="assets/js/welfares/list-welfare.js"></script>
<script src="assets/js/patients/list-patient.js"></script>
<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>