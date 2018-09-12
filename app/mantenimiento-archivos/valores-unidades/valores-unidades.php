<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">						
				<header>							
					<h2>Valores de unidades en uso</h2>
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
						<form class="form-horizontal">
							<legend>Números en uso</legend>
							<fieldset>
								<div class="form-group">
									<!--<label class="col-md-2 control-label">AMMDDNNN</label>-->
									<label class="col-md-2 control-label" for="numero-uso-arranque">Arranque</label>
									<div class="col-md-5">
										<input id="numero-uso-arranque" class="form-control" placeholder="XXXXXX" type="number" maxlength="6" min="1">
									</div>
								</div>								
							</fieldset>
							<legend>Valores FABA</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">A</label>
									<div class="col-md-5">
										<input id="valor-faba-a" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">B</label>
									<div class="col-md-5">
										<input id="valor-faba-b" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">C</label>
									<div class="col-md-5">
										<input id="valor-faba-c" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
							</fieldset>

							<legend>Valores NBU</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Alta Frecuencia</label>
									<div class="col-md-5">
										<input id="valor-nbu-af" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Baja Frecuencia</label>
									<div class="col-md-5">
										<input id="valor-nbu-bf" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">PMO</label>
									<div class="col-md-5">
										<input id="pmo" class="form-control" type="number" placeholder="XXXX.XX">
									</div>
								</div>
							</fieldset>

							<legend>Valores unidades</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Gastos</label>
									<div class="col-md-5">
										<input id="u-gastos" class="form-control" type="number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Honorarios</label>
									<div class="col-md-5">
										<input id="u-honorarios" class="form-control" type="number">
									</div>
								</div>
							</fieldset>
							<legend>Recibos, tarjetas y etiquetas</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Recibos</label>
									<div class="col-md-5">
										<input id="recibos" class="form-control" type="text" maxlength="50">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Etiquetas</label>
									<div class="col-md-5">
										<input id="etiquetas" class="form-control" type="text" maxlength="50">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Tarjetas</label>
									<div class="col-md-5">
										<input id="tarjetas" class="form-control" type="text" maxlength="50">
									</div>
								</div>
							</fieldset>
							<legend>Valor práctica mínima</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Costo</label>
									<div class="col-md-5">
										<input id="valor-practica-minima" class="form-control" type="number" maxlength="10" min="1" max="9999999999">
									</div>
								</div>
							</fieldset>	
							<legend>Extracción a domicilio</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Costo</label>
									<div class="col-md-5">
										<input id="extraccion-domicilio" class="form-control" type="number" maxlength="10" min="1" max="9999999999">
									</div>
								</div>
							</fieldset>
							<legend>Acto profesional bioquímico</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Costo</label>
									<div class="col-md-5">
										<input id="acto-profesional-bioquimico" class="form-control" type="number" maxlength="10" min="1" max="9999999999">
									</div>
								</div>
							</fieldset>	
							<legend>Valor monto máximo</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Valor</label>
									<div class="col-md-5">
										<input id="valor-monto-maximo" class="form-control" type="number" maxlength="10" min="1" max="9999999999">
									</div>
								</div>
							</fieldset>		
							<legend>Numerador derivaciones</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Derivaciones</label>
									<div class="col-md-5">										
										<input id="numerador-derivaciones" class="form-control" placeholder="XXXXXX" type="number" maxlength="8" min="1">
									</div>
								</div>
							</fieldset>
							<legend>Fórmula del Hemograma</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Sección</label>
									<div class="col-md-5">										
										<input id="buscar_seccion" class="form-control" type="text" placeholder="XX - Nombre" list="list_secciones">
											<datalist id="list_secciones"></datalist>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Posición donde comienza</label>
									<div class="col-md-5">										
										<select class="form-control" id="posicion-seccion">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">01</option>
											<option value="2">02</option>
											<option value="3">03</option>
											<option value="4">04</option>
											<option value="5">05</option>
											<option value="6">06</option>
											<option value="7">07</option>
											<option value="8">08</option>
											<option value="9">09</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
										</select> 
									</div>
								</div>
							</fieldset>					
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="ingresar" value="Insertar" disabled>
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
<script src="js/app/mantenimiento-archivos/valores-unidades/valores-unidades.js"></script>