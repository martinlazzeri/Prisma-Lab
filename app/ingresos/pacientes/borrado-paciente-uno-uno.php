<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Borrado de Pacientes Uno a Uno</h2>		
				</header>
				<div>
					<legend>Buscar paciente por número de documento o nombre y apellido</legend>
					<div class="widget-body">
						<form class="form-horizontal" id="form-borrado" autocomplete="off">
							<fieldset>
								<div class="form-group">				
									<label class="col-md-2 control-label">Buscar Ingreso Paciente</label>
									<div class="col-md-5">
										<input class="form-control" placeholder="Apellido y Nombre / D.N.I. / N° de paciente" type="text" id="buscar-pacientes" tabindex="1">
									</div>
								</div>
							</fieldset>
							<div id="form-campos" hidden>
								<fieldset>
									<div class="form-group">
										<label class="col-md-2 control-label">Apellido y Nombre</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="nombre" maxlength="100" disabled>
										</div>
									</div>								
									<div class="form-group">
										<label class="col-md-2 control-label">Fecha de Nacimiento</label>
										<div class="col-md-5">
											<input class="form-control" type="date" id="fecha-nac" disabled>
										</div>									
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Edad</label>
										<div class="col-md-5">
											<input class="form-control" type="number" id="edad" disabled>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="select-1">Sexo</label>
										<div class="col-md-5">	
											<select class="form-control" disabled id="sexo" tabindex="5">
												<option selected="" disabled="">Seleccione una opción</option>
												<option value="0">Masculino</option>
												<option value="1">Femenino</option>	
											</select> 
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Origen</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="origen" maxlength="1" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Cuenta</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="cuenta" maxlength="4" disabled>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Cama</label>										
										<div class="col-md-5">
											<input class="form-control" id="cama" type="text" disabled>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Dirección</label>										
										<div class="col-md-5">
											<input class="form-control" id="direccion" type="text" maxlength="50" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Número de Documento</label>
										<div class="col-md-5">
											<input class="form-control" type="number" maxlength="10" id="numero-doc" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Teléfono</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="telefono" maxlength="50" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Celular</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="celular" maxlength="50" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Lugar de Residencia</label>
										<div class="col-md-5">
											<input class="form-control" type="text" id="lugar" malxength="100" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">E-mail</label>
										<div class="col-md-5">
											<input class="form-control" type="email" id="email" maxlength="100" disabled>
										</div>
									</div>								
								</fieldset>
								<legend>Datos del Médico</legend>
								<fieldset>
									<div class="form-group">				
										<label class="col-md-2 control-label">Matrícula</label>
										<div class="col-md-5">
											<input class="form-control" placeholder="Apellido Nombre - MAT: XXXXXX" type="text" id="matricula-medico" disabled>
										</div>
									</div>								
								</fieldset>
								<legend>Datos de la Obra Social</legend>
								<fieldset>
									<div class="form-group">				
										<label class="col-md-2 control-label">Obra Social 1</label>
										<div class="col-md-5">
											<input class="form-control" placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra1" disabled>
										</div>
									</div>
									<div class="form-group" id="form-mutual1" hidden>
										<section class="col col-12">
											<label class="col-md-1 control-label">¿Debe la orden?</label>
											<div class="col-md-2">
													<select class="form-control" id="debe-orden1" disabled>
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="1">Si</option>
														<option value="0">No</option>	
													</select>
											</div>
											<label class="col-md-1 control-label">N. Afiliado</label>
											<div class="col-md-3">
												<input class="form-control" id="num-afiliado1" type="text" maxlength="20" disabled>
											</div>
											<label class="col-md-1 control-label">Tipo</label>
											<div class="col-md-2">
													<select class="form-control" id="tipo-afiliado1" disabled>
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">Obligatorio</option>
														<option value="1">Voluntario</option>	
													</select>
											</div>
											<div class="col-md-2">
												<label class="control-label">% Cobertura</label>
												<label class="input">
													<label id="porc-cobertura1"></label>
											</div>
										</section>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">Obra Social 2</label>
										<div class="col-md-5">
											<input class="form-control" placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra2" disabled>
										</div>
									</div>
									<div class="form-group" id="form-mutual2" hidden>
										<section class="col col-12">
											<label class="col-md-1 control-label">¿Debe la orden?</label>
											<div class="col-md-2">
													<select class="form-control" id="debe-orden2" disabled>
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="1">Si</option>
														<option value="0">No</option>	
													</select>
											</div>
											<label class="col-md-1 control-label">N. Afiliado</label>
											<div class="col-md-3">
												<input class="form-control" id="num-afiliado2" type="text" maxlength="20" disabled>
											</div>
											<label class="col-md-1 control-label">Tipo</label>
											<div class="col-md-2">
													<select class="form-control" id="tipo-afiliado2" disabled>
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">Obligatorio</option>
														<option value="1">Voluntario</option>	
													</select>
											</div>
											<div class="col-md-2">
												<label class="control-label">% Cobertura</label>
												<label class="input">
													<label id="porc-cobertura2"></label>
											</div>
										</section>
									</div>
								</fieldset>
								<fieldset>
									<div class="form-group">				
										<label class="col-md-2 control-label">Factor</label>
										<div class="col-md-5">
											<input id="factor" class="form-control" type="text" maxlenght="3" value="1.0" disabled>
										</div>
									</div>
									<div class="form-group">				
										<label class="col-md-2 control-label">A.P.B.</label>
										<div class="col-md-5">										
											<select class="form-control" id="acto-prof" disabled>
												<option selected="" disabled="">Seleccione una opción</option>
												<option value="0">0</option>
												<option value="1">1</option>	
											</select>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<legend>Prácticas</legend>
									<section>	
										<table id="tabla-practicas" class="display projects-table table table-striped table-bordered table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
						        			<thead>										
												<tr role="row">
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>1</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>2</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>3</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>4</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>5</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>6</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>7</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>8</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>9</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>10</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>11</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>12</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>13</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>14</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>15</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>16</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>17</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>18</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>19</bold></center></th>
													<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>20</bold></center></th>
												</tr>
											</thead>
											<tbody id="body-practicas">
												<tr id="row-practicas">
												</tr>
											</tbody>
										</table>
									</section>
								</fieldset>	
								<div id="div-final" hidden>	
									<br>					
									<section>	
										<div class="form-group" id="div-sin-cargo">
											<label class="col-md-2 control-label">¿Paciente sin cargo?</label>
											<div class="col-md-3">
												<select id="sin-cargo" class="form-control" disabled taborder="28">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="1">Si</option>
													<option value="0">No</option>	
												</select>
											</div>
											<label class="col-md-2 control-label">¿Cuánto abona o seña?</label>
											<div class="col-md-3">
												<input id="abono-sena" class="form-control col-md-3" type="number" disabled taborder="29">
											</div>
										</div>
										<div class="form-group" id="div-abono-sena">
											<label class="col-md-2 control-label">¿Realiza descuentos?</label>
											<div class="col-md-3">
												<select id="realiza-descuentos" class="form-control col-md-3" disabled taborder="30">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="1">Si</option>
													<option value="0">No</option>	
												</select>
											</div>
											<label class="col-md-2 control-label">¿Reajusta Importe?</label>
											<div class="col-md-3">
												<select id="reajuste-importe" class="form-control col-md-3" disabled taborder="31">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="1">Si</option>
													<option value="0">No</option>	
												</select>
											</div>
										</div>
									</section>
									<section>
										<div class="form-group">									
											<label class="control-label col-md-2">A cuenta/seña $</label>
											<div class="col-md-2">
												<label class="control-label" id="label-cuenta-sena"></label>
											</div>
											
											<label class="control-label col-md-2">Saldo pendiente $</label>
											<div class="col-md-2">
												<label class="control-label" id="label-saldo-pendiente"></label>
											</div>
											
											<label class="control-label col-md-2">Total a abonar $</label>
											<div class="col-md-2">
												<label class="control-label" id="label-total"></label>
											</div>
										</div>
									</section>
									<section>
										<div class="row">
											<section class="col col-6">
												<label class="label" for="comentarios">Comentarios</label>
												<label class="textarea">
													<textarea class="form-control" id="comentarios" disabled maxlength="500" placeholder="Comentarios" rows="4" style="width: 400px; resize: none;"></textarea>
												</label>
											</section>
										</div>
									</section>							
									<div class="form-actions">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-primary" type="button" id="eliminar" disabled>
													<i class="fa fa-save"></i>
													Eliminar Paciente
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>
<div class="modal fade" id="modal-ingresos">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Ingresos de Pacientes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">N° Paciente</th>
									<th class="col-md-2">Apellido Nombre</th>									
								</tr>
							</thead>
							<tbody id="body-ingresos" style="cursor: pointer;">
							</tbody>
						</table>
					</div>					
				</section>				
        	</div>
      		<div class="modal-footer">        		
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div>
    </div>
</div>
<script src="js/app/ingresos/pacientes/borrado-paciente-uno-uno.js"></script>