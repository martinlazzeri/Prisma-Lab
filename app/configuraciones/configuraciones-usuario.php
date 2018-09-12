<?php
	session_start();
?>
<section id="widget-grid" class="">
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">						
				<header>							
					<h2>Configuraciones de Usuarios</h2>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
					<!-- widget content -->
					<div class="widget-body">
						<form id="form-medico" class="form-horizontal" enctype="multipart/form-data" method="post">
							<fieldset>
								<?php
									if ($_SESSION['RolId'] == 1) 
									{
										?>
											<div class="form-group">
												<label class="col-md-2 control-label">Nombre del Laboratorio</label>
												<div class="col-md-10">
													<input id="nombre-lab" type="text">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Lema</label>
												<div class="col-md-10">
													<textarea id="lema-lab" rows="4" style="resize: none;"></textarea>
												</div>
											</div>
										<?php
									}
								?>								
								<div class="form-group">
									<label class="col-md-2 control-label">Colores Predeterminados</label>
									<div class="col-md-10">
										<input type="button" id="colores-default" value="Colores Predeterminados">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Color de Encabezado</label>
									<div class="col-md-10">
										<input id="color-encabezado" type="color">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Color de Encabezado Cinta</label>
									<div class="col-md-10">
										<input id="color-encabezado-cinta" type="color">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Color de Menú Lateral</label>
									<div class="col-md-10">
										<input id="color-menu-lateral" type="color">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Color de Pie de Página</label>
									<div class="col-md-10">
										<input id="color-pie-pagina" type="color">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Color de Fondo</label>
									<div class="col-md-10">
										<input id="color-fondo" type="color">
									</div>
								</div>
								<?php
									if ($_SESSION['RolId'] == 1) 
									{
										?>
											<div class="form-group">
												<label class="col-md-2 control-label">Logo del Laboratorio</label>
												<div class="col-md-10">
													<input id="logo-lab" name="logo-lab" type="file" class="btn btn-default" accept="image/*">
													<p class="help-block">
														Seleccione una imagen para el logo
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Previsualización</label>
												<div class="col-md-10">
													<img id="logo-lab-prev" src="<?php echo $_SESSION['UrlParcialLogo']?>" style="width:200px;heigth:200px">										
												</div>
											</div>											
											<!--
											<div class="form-group">
												<label class="col-md-2 control-label">Logo del Laboratorio(Cabecera)</label>
												<div class="col-md-10">
													<input id="logo-lab" name="logo-lab" type="file" class="btn btn-default" accept="image/*">
													<p class="help-block">
														Seleccione una imagen para el logo
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Previsualización</label>
												<div class="col-md-10">
													<img id="logo-lab-prev" src="<?php echo $_SESSION['UrlParcialLogo']?>" style="width:200px;heigth:200px">										
												</div>
											</div>
											-->
										<?php
									}
								?>								
								<div class="form-group">
									<label class="col-md-2 control-label">Imagen de perfil</label>
									<div class="col-md-10">
										<input id="imagen-perfil" name="imagen-perfil" type="file" class="btn btn-default" accept="image/*">
										<p class="help-block">
											Seleccione una imagen para el usuario
										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Previsualización</label>
									<div class="col-md-10">
										<img id="imagen-perfil-prev" src="<?php echo $_SESSION['UrlParcialImagen']?>" style="width:200px;heigth:200px">										
									</div>
								</div>
								<?php
									if ($_SESSION['RolId'] == 1) {
									?>
										<div class="form-group">
											<label class="col-md-2 control-label">Trabajar sin conexión</label>
											<div class="col-md-10">
												<div class="checkbox">
													<input type="checkbox" id="sin-conexion">
												</div>
											</div>
										</div>
									<?php
									}
								?>
								<!--<div class="form-group">
									<label class="col-md-2 control-label">Mostrar la frase del día</label>
									<div class="col-md-10">
										<div class="checkbox">
											<input type="checkbox" id="mostrar-frase">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Frase personalizada</label>
									<div class="col-md-10">
										<textarea id="frase-personalizada" rows="6" cols="100" style="resize: none;"></textarea>
									</div>
								</div>-->
							</fieldset>									
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="guardar" value="Guardar Configuración">
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>
<script src="js/app/configuraciones/configuraciones-usuario.js"></script>