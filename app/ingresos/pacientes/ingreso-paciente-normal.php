<?php
$page_title = "Pacientes";
?>
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Ingreso de Pacientes Normal</h2>				
				</header>
				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
					<!-- widget content -->
					<div class="widget-body no-padding">	
						<form id="form-pacientes" class="smart-form" autocomplete="off">							
							<fieldset>						
								<div class="row">									
									<section class="col col-3">
										<label class="label">Nombre</label>
										<label class="input">
											<input type="text" id="firstname" placeholder="Nombre del paciente" data-value="">												
										</label>
									</section>
									<section class="col col-2">
										<label class="label">D.N.I.</label>
										<label class="input">
											<input id="numero-doc" type="text" maxlength="10">
										</label>
									</section>									
									<section class="col col-3">						
										<label class="label">Fecha Nacimiento</label>
										<label class="input">
											<input type="date" id="fecha-nac">
										</label>
									</section>
									<section class="col col-2">						
										<label class="label">Edad</label>
										<label class="input">
											<input type="number" id="edad" maxlength="3">
										</label>
									</section>
									<section class="col col-1">						
										<label class="label">Sexo</label>
										<label class="select">
											<select id="sexo">
												<option selected="" disabled="">Elija</option>
												<option value="0">M</option>
												<option value="1">F</option>	
											</select>
										</label> 
									</section>
									<section class="col col-1">
										<label class="label" for="origen">Origen</label>
										<label class="input">
											<input id="origen" type="text" maxlength="1">
										</label>
									</section>
								</div>				
								<div class="row">																		
									<section class="col col-1">
										<label class="label">Cuenta</label>										
										<label class="input">
											<input id="cuenta" type="text" maxlength="4">
										</label>
									</section>
									<section class="col col-1">
										<label class="label">Cama</label>										
										<label class="input">
											<input id="cama" type="text" maxlength="4">
										</label>
									</section>
									<section class="col col-1">
										<label class="label">Dirección</label>										
										<label class="input">
											<input id="direccion" type="text" maxlength="50">
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Teléfono</label>
										<label class="input">
											<input id="telefono" type="number" maxlength="100">
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Celular</label>
										<label class="input">
											<input id="celular" type="number" maxlength="100">
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Lugar</label>
										<label class="input">
											<input id="lugar" type="text" maxlength="100">
										</label>
									</section>
									<section class="col col-3">
										<label class="label">Email</label>
										<label class="input">
											<input id="email" type="email" maxlength="100">
										</label>
									</section>
								</div>
							</fieldset>
							<fieldset>								
								<div class="row">									
									<section class="col col-4">
										<label class="label">Matrícula</label>
										<label class="input">
											<input placeholder="Apellido Nombre - MAT: XXXXXX" type="text" id="matricula" data-value="">
										</label>										
									</section>
									<section class="col col-4">
										<button type="button" id="agregar-medico" class="btn btn-primary" data-toggle="modal" data-target="#modal-alta-medico">Agregar Médico</button>
									</section>
								</div>
							</fieldset>
							<fieldset>								
								<div class="row">
									<section class="col col-4">
										<label class="label">Mutual 1</label>
										<label class="input">
											<input placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra1" data-value="">												
										</label>
									</section>
									<div class="row" id="form-mutual1" hidden>
										<section class="col col-2">
											<label class="label">¿Debe la orden?</label>
											<label class="select">
													<select id="debe-orden1">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="1">Si</option>
														<option value="0">No</option>	
													</select>
											</label>
										</section>
										<section class="col col-2">
											<label class="label">N. Afiliado</label>
											<label class="input">
												<input id="num-afiliado1" type="text" maxlength="30">
											</label>
										</section>
										<section class="col col-2">
											<label class="label">Tipo</label>
											<label class="select">
													<select id="tipo-afiliado1">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">Obligatorio</option>
														<option value="1">Voluntario</option>	
													</select>
											</label>
										</section>
										<section class="col col-1">
											<label class="label">% Cobertura</label>
											<label class="input">
												<input id="porc-cobertura1" type="text" disabled>
											</label>
										</section>
									</div>
								</div>								
								<div class="row">
									<section class="col col-4">
										<label class="label">Mutual 2</label>
										<label class="input">
											<input placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra2" data-value="">
										</label>
									</section>
									<div class="row" id="form-mutual2" hidden>
									<section class="col col-2">
										<label class="label">¿Debe la orden?</label>
										<label class="select">
											<select id="debe-orden2">
												<option selected="" disabled="">Seleccione una opción</option>
												<option value="1">Si</option>
												<option value="0">No</option>	
											</select>
										</label>
									</section>
									<section class="col col-2">
										<label class="label">N. Afiliado</label>
										<label class="input">
											<input id="num-afiliado2" type="text" maxlength="20">
										</label>
									</section>
									<section class="col col-2">
										<label class="label">Tipo</label>
										<label class="select">
												<select id="tipo-afiliado2">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="0">Obligatorio</option>
													<option value="1">Voluntario</option>	
												</select>
										</label>
									</section>
									<section class="col col-1">
										<label class="label">% Cobertura</label>
										<label class="input">
											<input id="porc-cobertura2" type="text" disabled>
										</label>
									</section>
								</div>
								</div>																
							</fieldset>
							<fieldset>
								<div class="row">
									<section class="col col-1">
										<label class="label">Factor</label>
										<label class="input">
											<input id="factor" type="text" maxlength="3" placeholder="1.0">
										</label>
									</section>
									<section class="col col-1">
										<label class="label" for="acto-prof">A. P. B.</label>
										<label class="select">
											<select id="acto-prof">			
												<option value="1">1</option>										
												<option value="0">0</option>
											</select>
										</label>
									</section>
								</div>
							</fieldset>
							<fieldset>
								<legend>Prácticas</legend>
								<section>	
									<table id="tabla-practicas" class="display projects-table table table-striped table-bordered table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
					        			<thead>
											<tr role="row">
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>1</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>2</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>3</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>4</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>5</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>6</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>7</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>8</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>9</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>10</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>11</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>12</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>13</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>14</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>15</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>16</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>17</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>18</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>19</bold></center></th>
												<th tabindex="-1" aria-controls="example" rowspan="1" colspan="1" style="width: 10px;"><center><bold>20</bold></center></th>
											</tr>
										</thead>
										<tbody id="body-practicas">
											<tr id="row-practicas">
											</tr>
										</tbody>
									</table>
								</section>
								<div class="row">
									<section class="col col-md-4">
										<label class="label">Práctica</label>
										<label class="input">
											<input placeholder="Busca una práctica..." type="text" id="practica" data-id="" data-tipo="">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-md-4">
										<label class="label"><span id="span-nomen-trabajo" hidden>Nomenclador de trabajo</span><span id="span-nomen-especial" hidden>Nomenclador especial</span></label>
										<label class="label"><span id="span-costo" hidden>Costo: $</span><span id="costo-parcial" hidden></span></label>
										<label class="label"><span id="span-codigo-nomen" hidden></span></label>
									</section>
								</div>								
								<div class="row">
									<section class="col col-md-4">
										<button id="finalizar" class="btn btn-primary">Finalizar Ingreso de Prácticas</button>
									</section>
								</div>
							</fieldset>
							<section id="div-final" hidden>
								<fieldset>
									<div class="row">
										<section class="col col-3" id="div-sin-cargo">
											<label class="label">¿Paciente sin cargo?</label>
											<label class="select">
												<select id="sin-cargo">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="0">No</option>
													<option value="1">Si</option>
												</select>
											</label>
										</section>
										<section class="col col-3">
											<div id="div-abono-sena" hidden>
												<label class="label">¿Cuánto abona o seña?</label>
												<label class="input">
													<input id="abono-sena" type="number">
												</label>
											</div>
										</section>
										<section class="col col-3">
											<div id="div-realiza-descuentos" hidden>
												<label class="label">¿Realiza descuentos?</label>
												<label class="select">
													<select id="realiza-descuentos">
														<option selected="" disabled="">Seleccione una opción</option>														
														<option value="0">No</option>
														<option value="1">Si</option>
													</select>
												</label>
											</div>
										</section>
										<section class="col col-3">
											<div id="div-reajuste-importe" hidden>
												<label class="label">¿Reajusta Importe?</label>
												<label class="select">
													<select id="reajuste-importe">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">No</option>
														<option value="1">Si</option>
													</select>
												</label>
											</div>
										</section>										
									</div>
									<div class="row">										
										<section class="col col-3">
											<label class="label">A cuenta/seña $</label>
											<label id="label-cuenta-sena" class="label">0</label>
										</section>
										<section class="col col-3">
											<label class="label">Saldo pendiente de pago $</label>
											<label id="label-saldo-pendiente" class="label"></label>
										</section>								
										<section class="col col-3">
											<label class="label">Total a abonar $</label>
											<label id="label-total" class="label">0</label>
										</section>
									</div>								
								</fieldset>
								<fieldset>
									<div class="row">
										<section class="col col-6">
											<label class="label" for="comentarios">Comentarios</label>
											<label class="textarea">
												<textarea class="form-control" id="comentarios" maxlength="500" placeholder="Comentarios" rows="4"></textarea>
											</label>
										</section>
									</div>
								</fieldset>
								<footer>
									<input type="button" class="btn btn-primary" id="ingresar" value="Grabar" disabled>
								</footer>
							</section>							
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
<div class="modal fade" id="modal-alta-medico">
		<div class="modal-dialog">
		    <div class="modal-content">
	    	  	<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        	<h4 class="modal-title">Agregar Médico</h4>
		      	</div>
		      	<div class="modal-body">
	    	    	<section>
	    	    		<div class="row">
							<div class="form-group col col-md-6">
							    <label for="matricula">Matrícula</label>
							    <input type="text" class="form-control" id="matricula" placeholder="Matrícula del médico" maxlenght="6">
							</div>
							<div class="form-group col col-md-6">
							    <label for="tipo-matricula">Tipo de Matrícula</label>						    
								<select class="form-control" id="tipo-matricula">
									<option selected="" disabled="">Seleccione una opción</option>
									<option value="0">Provincial</option>
									<option value="1">Nacional</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col col-md-6">
							    <label for="apellido-med">Apellido</label>
							    <input type="text" class="form-control" id="apellido-med" placeholder="Apellido de médico" maxlenght="6">
							</div>
							<div class="form-group col col-md-6">
							    <label for="nombre-med">Nombre</label>
							    <input type="text" class="form-control" id="nombre-med" placeholder="Nombre de médico" maxlenght="6">
							</div>
						</div>
					</section>
	        	</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-danger" id="confirmar-agregar-medico">Agregar</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	      		</div>
	    	</div>
	    </div>
	</div>
<div class="modal fade" id="modal-pacientes">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Pacientes existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<div class="col col-md-10">
							<label class="col-md-4">Apellido y Nombre</label>							
							<input class="col-md-8" type="text" id="buscar-paciente" placeholder="Apellido y nombre del paciente" list="modal_pacientes_list">
								<datalist id="modal_pacientes_list"></datalist>							
						</div>
					</div>					
				</section>
				<span id="error-paciente" style="" hidden>Error. Datos de pacientes incorrectos</span>
        	</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-danger" id="seleccionar-paciente">Seleccionar</button>
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      		</div>
    	</div>
    </div>
</div>
<div class="modal fade" id="modal-pacientes-por-apellido">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Pacientes Por Apellido y Nombre</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Apellido Nombre</th>
									<th class="col-md-2">D.N.I.</th>
								</tr>
							</thead>
							<tbody id="body-pacientes" style="cursor: pointer;">
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
<div class="modal fade" id="modal-pacientes-por-dni">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Pacientes Por D.N.I.</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Apellido Nombre</th>
									<th class="col-md-2">D.N.I.</th>
								</tr>
							</thead>
							<tbody id="body-pacientes-dni" style="cursor: pointer;">
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
<div class="modal fade" id="modal-medicos">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Médicos Existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Apellido, Nombre</th>
									<th class="col-md-2">Matrícula</th>
								</tr>
							</thead>
							<tbody id="body-medicos" style="cursor: pointer;">
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
<div class="modal fade" id="modal-mutuales">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Mutuales Existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Nombre Mutual</th>
									<th class="col-md-2">Código</th>
									<th class="col-md-2">% Cobertura</th>
								</tr>
							</thead>
							<tbody id="body-mutuales" style="cursor: pointer;">
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
<div class="modal fade" id="modal-mutuales2">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Mutuales Existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Nombre Mutual</th>
									<th class="col-md-2">Código</th>
									<th class="col-md-2">% Cobertura</th>
								</tr>
							</thead>
							<tbody id="body-mutuales2" style="cursor: pointer;">
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
<div class="modal fade" id="modal-practicas">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Prácticas</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-xs-1">Código</th>
									<th class="col-xs-2">Nombre</th>
									<th class="col-xs-1">Tipo</th>
								</tr>
							</thead>
							<tbody id="body-practicas-modal" style="cursor: pointer;">
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
<script src="js/app/ingresos/pacientes/ingreso-paciente-normal.js"></script>