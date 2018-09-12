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
						<form class="smart-form" id="form-protocolos" method="post" target="_blank" action="">
							<fieldset>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">Desde el protocolo número</label>
										<label class="input">
											<input id="desdePaciente" type="text">
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Hasta el protocolo número</label>
										<label class="input">
											<input id="hastaPaciente" type="text">
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
								<div class="row">
									<section class="col col-4">
									</section>
									<section class="col col-4">
										<label class="label">¿Imprime en Hoja A4?</label>
										<label class="select">
											<select>												
												<option value="0">Si</option>
												<option selected="selected" value="1">No</option>	
											</select>
										</label>
									</section>
									<section class="col col-4">
									</section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Indique Origen (T = Todos)</label>
										<label class="input">
											<input id="hastaPaciente" type="text" value="T">
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Código del Controlador</label>
										<label class="input">
											<input id="hastaPaciente" type="text">
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
<script src="js/app/protocolos/protocolos-terminados.js"></script>