<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Calculo de Importes</h2>				
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
						<form id="form-calculo-presupuesto" class="smart-form" autocomplete="off" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/calculo-presupuestos/calculo-presupuesto-pdf.php'; ?>" method="POST" target="_blank">
							<fieldset>							
								<div class="row">									
									<section class="col col-5">
										<label class="label">Apellido y Nombre</label>
										<label class="input">
											<input type="text" name="nombre" id="nombre" placeholder="Apellido y nombre del paciente" data-value="">												
										</label>
									</section>
								</div>
							</fieldset>
							<fieldset>
								<!--<legend>Datos de la/s Mutual/es</legend>-->
								<div class="row">
									<section class="col col-3">
										<label class="label">Mutual 1</label>
										<label class="input">
											<input name="obra1" placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra1" data-value="">												
										</label>
									</section>
									<div class="row" id="form-mutual1" hidden>
										<section class="col col-2">
											<label class="label">¿Debe la orden?</label>
											<label class="select">
													<select name="debe-orden1" id="debe-orden1">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="1">Si</option>
														<option value="0">No</option>	
													</select>
											</label>
										</section>
										<section class="col col-2">
											<label class="label">N. Afiliado</label>
											<label class="input">
												<input name="num-afiliado1" id="num-afiliado1" type="text" maxlength="30">
											</label>
										</section>
										<section class="col col-2">
											<label class="label">Tipo</label>
											<label class="select">
													<select name="tipo-afiliado1" id="tipo-afiliado1">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">Obligatorio</option>
														<option value="1">Voluntario</option>	
													</select>
											</label>
										</section>
										<section class="col col-1">
											<label class="label">% Cobertura</label>
											<label class="input">
												<input name="porc-cobertura1" id="porc-cobertura1" type="text" disabled>
											</label>
										</section>
										<section class="col col-1">
											<label class="label">Abona APB</label>
											<label class="select">
												<select name="abona-apb1" id="abona-apb1" disabled>														
													<option value="0">No</option>
													<option value="1">Sí</option>	
												</select>
											</label>
										</section>
									</div>
								</div>								
								<div class="row">
									<section class="col col-3">
										<label class="label">Mutual 2</label>
										<label class="input">
											<input name="obra2" placeholder="Nombre Obra Social - COD: XXXX" type="text" id="obra2" data-value="">
										</label>
									</section>
									<div class="row" id="form-mutual2" hidden>
										<section class="col col-2">
											<label class="label">¿Debe la orden?</label>
											<label class="select">
												<select name="debe-orden-2" id="debe-orden2">
													<option selected="" disabled="">Seleccione una opción</option>
													<option value="1">Si</option>
													<option value="0">No</option>	
												</select>
											</label>
										</section>
										<section class="col col-2">
											<label class="label">N. Afiliado</label>
											<label class="input">
												<input name="num-afiliado2" id="num-afiliado2" type="text" maxlength="20">
											</label>
										</section>
										<section class="col col-2">
											<label class="label">Tipo</label>
											<label class="select">
													<select name="tipo-afiliado2" id="tipo-afiliado2">
														<option selected="" disabled="">Seleccione una opción</option>
														<option value="0">Obligatorio</option>
														<option value="1">Voluntario</option>	
													</select>
											</label>
										</section>
										<section class="col col-1">
											<label class="label">% Cobertura</label>
											<label class="input">
												<input name="porc-cobertura2" id="porc-cobertura2" type="text" disabled>
											</label>
										</section>
										<section class="col col-1">
											<label class="label">Abona APB</label>
											<label class="select">
												<select name="abona-apb2" id="abona-apb2" disabled>														
													<option value="0">No</option>
													<option value="1">Sí</option>	
												</select>
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
											<input name="factor" id="factor" type="text" maxlength="3" placeholder="1.0">
										</label>
									</section>
									<section class="col col-1">
										<label class="label" for="acto-prof">A. P. B.</label>
										<label class="select">
											<select name="acto-prof" id="acto-prof">			
												<option selected value="1">1</option>										
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
							<fieldset>
								<div class="col col-md-4"></div>
								<div class="col col-md-4">
									<div class="col col-md-5">
										<label class="label">Importe Boleta   $</label>
										<label class="label">Importe Mutual 1 $</label>
										<label class="label">Importe Mutual 2 $</label>
										<label class="label">Importe Paciente $</label>
										<label class="label">Importe APB      $</label>
										<label class="label">Total a Abonar   $</label>
									</div>
									<div class="col col-md-2">
										<label class="label" style="font-weight: bold;" id="importe-boleta">0.00</label>
										<label class="label" style="font-weight: bold;" id="importe-mutual1">0.00</label>
										<label class="label" style="font-weight: bold;" id="importe-mutual2">0.00</label>
										<label class="label" style="font-weight: bold;" id="importe-paciente">0.00</label>
										<label class="label" style="font-weight: bold;" id="importe-apb">0.00</label>
										<label class="label" style="font-weight: bold;" id="total">0.00</label>
									</div>
									<input name="importe-boleta" id="input-importe-boleta" hidden type="text">
									<input name="importe-mutual1" id="input-importe-mutual1" hidden type="text">
									<input name="importe-mutual2" id="input-importe-mutual2" hidden type="text">
									<input name="importe-paciente" id="input-importe-paciente" hidden type="text">
									<input name="importe-apb" id="input-importe-apb" hidden type="text">
									<input name="total" id="input-total" hidden type="text">
									<input id="input-p1" name="p1" hidden>
									<input id="input-p2" name="p2" hidden>
									<input id="input-p3" name="p3" hidden>
									<input id="input-p4" name="p4" hidden>
									<input id="input-p5" name="p5" hidden>
									<input id="input-p6" name="p6" hidden>
									<input id="input-p7" name="p7" hidden>
									<input id="input-p8" name="p8" hidden>
									<input id="input-p9" name="p9" hidden>
									<input id="input-p10" name="p10" hidden>
									<input id="input-p11" name="p11" hidden>
									<input id="input-p12" name="p12" hidden>
									<input id="input-p13" name="p13" hidden>
									<input id="input-p14" name="p14" hidden>
									<input id="input-p15" name="p15" hidden>
									<input id="input-p16" name="p16" hidden>
									<input id="input-p17" name="p17" hidden>
									<input id="input-p18" name="p18" hidden>
									<input id="input-p19" name="p19" hidden>
									<input id="input-p20" name="p20" hidden>
								</div>
								<div class="col col-md-4"></div>
							</fieldset>
							<footer>
								<input type="submit" id="imprimir" class="btn btn-primary" value="Imprimir Comprobante" disabled>
							</footer>					
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
									<th class="col-md-2">Abona APB</th>
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
									<th class="col-md-2">Abona APB</th>
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
<script src="js/app/consulta-correccion/calculo-presupuestos.js"></script>