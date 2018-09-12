<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Planillas de Trabajo por Práctica</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-planillas" method="post" target="_blank" action="">
							<fieldset>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Desde el Paciente</label>
										<label class="input">
											<input id="desdePaciente" type="text" maxlength="8">
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
											<input id="hastaPaciente" type="text" maxlength="8">
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Indique la Práctica</label>
										<label class="input">
											<input id="practica" type="text" placeholder="Escriba la practica y presione enter">
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Indique el Origen (T = Todos)</label>
										<label class="input">
											<input id="origen" type="text" maxlength="1" value="T">
										</label>
									</section>
									<section class="col col-4"></section>
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
<script src="js/app/ingresos/planillas-trabajo/planilla-por-practica.js"></script>