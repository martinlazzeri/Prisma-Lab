<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Protocolos Uno a Uno</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-protocolos" method="post" target="_blank" action="">
							<fieldset>
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
							<fieldset>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Ingrese Protocolo o Nombre del paciente</label>
										<label class="input">
											<input id="hastaPaciente" type="text">
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
							</fieldset>
							<fieldset>
								<div class="row">
									<div class="form-group">
										<label class="col-md-2 control-label">Protocolo N°</label>
										<div class="col-md-5">
											<label id="protocolo" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Apellido y Nombre</label>
										<div class="col-md-5">
											<label id="apellido-nombre" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Dr./a</label>
										<div class="col-md-5">
											<label id="medico" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Telefono</label>
										<div class="col-md-5">
											<label id="telefono" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Celular</label>
										<div class="col-md-5">
											<label id="celular" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Domicilio</label>
										<div class="col-md-5">
											<label id="domicilio" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Origen</label>
										<div class="col-md-5">
											<label id="origen" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Afiliado</label>
										<div class="col-md-5">
											<select id="sexo">
												<option selected="" value="0">Obligatorio</option>
												<option value="1">Voluntario</option>	
											</select>
										</div>
									</div>
									
									<legend>Prácticas</legend>
									<divclass="form-group">
										<div id="practicas">
											<!--LISTADO DE LAS PRACTICAS QUE TIENE, SOLO EL CODIGO DE ELLAS-->
										</div>									
									</div>
							</fieldset>
							<fieldset>
								<div class="row">
									<div class="form-group">
										<label class="col-md-2 control-label">Mutual</label>
										<div class="col-md-5">
											<label id="mutual" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Reintegro</label>
										<div class="col-md-5">
											<label id="reintegro" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">IVA</label>
										<div class="col-md-5">
											<label id="iva" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Paciente</label>
										<div class="col-md-5">
											<label id="paciente" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">A Cuenta</label>
										<div class="col-md-5">
											<label id="aCuenta" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Resta Pagar</label>
										<div class="col-md-5">
											<label id="restaPagar" class="control-label"></label>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Observaciones</label>
									<div class="col-md-5">
										<label id="observaciones" class="control-label"></label>
									</div>
								</div>
							</fieldset>
							<footer>
								<fieldset>
									<section>	
										<table id="tabla-practicas" class="display projects-table table table-striped table-bordered table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
						        			<thead>										
												<tr role="row">
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F1</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F2</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F3</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F4</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F5</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F6</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F7</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F8</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F9</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>F11</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>CTRL + F1</bold></center></th>													
												</tr>
											</thead>
											<tbody id="body-practicas">
												<tr>
													<td>Ingresar Pago</td>
													<td>Realizar Descuentos</td>
													<td>Reintegro Importes</td>
													<td>Transfiere $</td>
													<td>Retira Protocolo</td>
													<td>Entrega Mutual 1</td>
													<td>Entrega Mutual 2</td>
													<td>Sin Cargo</td>
													<td>Edita Observaciones</td>
													<td>Tipo Afil. Mutual 1</td>
													<td>Reajuste $</td>
												</tr>
											</tbody>
										</table>
									</section>
								</fieldset>								
							</footer>
						</form>
					</div>
				</div>
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>
<script src="js/app/protocolos/entrega-protocolos.js"></script>