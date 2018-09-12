<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Alta</h2>		
				</header>
				<div>
					<div class="widget-body">
						<form class="form-horizontal" id="form-nomencladores">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Código de Práctica</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="XXX" id="codigo" maxlength="3">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nombre</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="nombre" maxlength="50">
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">INOS</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="0000" id="inos" maxlenght="4">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">677</label>
									<div class="col-md-5">
										<input class="form-control" type="number" value="1" placeholder="1" id="_677">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">U. Gastos</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="u-gastos">
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">U. Honorarios</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="u-honorarios">
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Area</label>
									<div class="col-md-5">
										<input class="form-control" type="text" maxlength="2" value="T" placeholder="T" id="area">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">Complejidad</label>
									<div class="col-md-5">	
										<select class="form-control" list="complejidad" id="complejidad">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="4">Alta</option>
											<option value="3">Baja</option>
											<option value="2">Compuesta</option>
											<option value="1">Mediana</option>
											<option value="0">No Considerar</option>
										</select> 										
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">INOS Reducido</label>
									<div class="col-md-5">	
										<select class="form-control" list="complejidad" id="inos-reducido">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Si</option>
											<option value="0">No</option>											
										</select> 										
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">No Nomenclada</label>
									<div class="col-md-5">	
										<select class="form-control" list="complejidad" id="no-nomenclada">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Si</option>
											<option value="0">No</option>
										</select>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Tiempo de Realización</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="99" id="tiempo-realizacion">
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Id. Muestra</label>
									<div class="col-md-5">
										<input class="form-control" type="text" maxlength="2" placeholder="0" id="id-muestra">
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Días de Procesamiento</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="proceso">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Lista</label>
									<div class="col-md-5">
										<input class="form-control" type="text" value="A" placeholder="A" id="lista">
										<p class="note">Indique la lista correspondiente al nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Código</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="0000" id="codigo-nomen-faba">
										<p class="note">Indique el código correspondiente al nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nivel</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="999.0" id="nivel">
										<p class="note">Indique la cantidad de unidades según el nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">RIA</label>
									<div class="col-md-5">	
										<select class="form-control" id="ria">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Si</option>
											<option value="0">No</option>
										</select>
										<p class="note">Práctica definida por RIA por nomenclador</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">NBU Frecuencia</label>
									<div class="col-md-5">	
										<select class="form-control" id="nbu-frecuencia">
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="0">Alta</option>
											<option value="1">Baja</option>
											<option value="2">PMOE</option>
										</select>
										<p class="note">Definición frecuenta para NBU</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">NBU Código</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="000000" id="nbu-codigo">
										<p class="note">Indique el código de la práctica según el NBU</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Cantidad</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="cantidad">
										<p class="note">Indique la cantidad de unidades para la práctica según el NBU</p>
									</div>
								</div>								
							</fieldset>
							<fieldset>
								<legend>Determinaciones</legend>
							</fieldset>
							<fieldset id="determinaciones">
								<div class="row" id="row-determinaciones">
								</div>
								<div class="row">
								  	<div class="col-md-3 col-md-offset-7">
								  		<input type="button" value="Agregar Determinación" id="agregar-determinacion" class="btn btn-primary" style="horizontal-align: rigth;">
								  	</div>
								</div>								
							</fieldset>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-primary" type="button" id="ingresar" disabled>
											Ingresar
										</button>										
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
<script src="js/app/mantenimiento-archivos/nomenclador/alta-nomenclador.js"></script>