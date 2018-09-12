<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Planillas de Trabajo por Sección</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-planillas" method="post" target="_blank" action="planilla-trabajo-por-pacientes-pdf.php">
							<fieldset>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Desde el Paciente</label>
										<label class="input">
											<input id="desdePaciente" name="desdePaciente" type="text">
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Hasta el Paciente</label>
										<label class="input">
											<input id="hastaPaciente" name="hastaPaciente" type="text">
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">¿Fichas Individuales?</label>
										<label class="select">
											<select name="fichas-individuales" id="fichas-individuales">
												<option value="0">No</option>	
												<option value="1">Si</option>
											</select>
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
<script src="js/app/ingresos/planillas-trabajo/planilla-por-paciente.js"></script>