<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Planilla de Trabajo por Sección</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-planillas" method="post" target="_blank" action="app/ingresos/planillas-trabajo/generar-pdf/planilla-trabajo-por-seccion-pdf.php">
							<fieldset>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Pendientes o Normales</label>
										<label class="select" name="pendiente">
											<select>												
												<option value="0">Pendientes</option>
												<option value="1">Normales</option>	
											</select>
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Desde la Sección</label>
										<label class="input">
											<input id="desdeSeccion" name="desdeSeccion" type="text" maxlength="2">
											<!-- Primera sección válida en el sistema-->
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Hasta la Sección</label>
										<label class="input">
											<input id="hastaSeccion" name="hastaSeccion" type="text" maxlength="2">
											<!-- última sección válida en el sistema-->
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Desde el Paciente</label>
										<label class="input">
											<input id="desdePaciente" name="desdePaciente" type="text" maxlength="8">
											
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Hasta el Paciente</label>
										<label class="input">
											<input id="hastaPaciente" name="hastaPaciente" type="text" maxlength="8">
											
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">¿Imprime Subtítulos?</label>
										<label class="select">
											<select>
												<option value="0">Si</option>
												<option selected="" value="1">No</option>	
											</select>
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Indique qué origen (T = Todos)</label>
										<label class="input">
											<input id="origen" name="origen" type="text" maxlength="1" value="T">
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
							</fieldset>
							<footer>
								<button type="submit" id="crear" class="btn btn-primary">
									Generar Planilla
								</button>								
							</footer>
						</form>
					</div>
				</div>
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>
<script src="js/app/ingresos/planillas-trabajo/planilla-por-seccion.js"></script>