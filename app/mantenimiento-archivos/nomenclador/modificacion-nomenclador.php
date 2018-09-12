<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Modificación Nomenclador</h2>		
				</header>
				<div>
					<div class="widget-body">
						<form class="form-horizontal" id="form-nomencladores" autocomplete="off">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Buscar nomenclador</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="Búsqueda por código o nombre" id="buscar-nomenclador" data-id="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Código de Práctica</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="codigo" maxlength="3" disabled>										
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nombre</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="nombre" maxlength="50" disabled>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">INOS</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="0000" id="inos" maxlenght="4" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">677</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="1" id="_677" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">U. Gastos</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="u-gastos" disabled>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">U. Honorarios</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="u-honorarios" disabled>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Area</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="T" id="area" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">Complejidad</label>
									<div class="col-md-5">	
										<select class="form-control" list="complejidad" id="complejidad" disabled>											
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
										<select class="form-control" list="complejidad" id="inos-reducido" disabled>											
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Si</option>
											<option value="0">No</option>											
										</select> 										
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">No Nomenclada</label>
									<div class="col-md-5">	
										<select class="form-control" list="complejidad" id="no-nomenclada" disabled>
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Si</option>
											<option value="0">No</option>
										</select>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Tiempo de Realización</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="tiempo-realizacion" disabled>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Id. Muestra</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="0" id="id-muestra" disabled>
									</div>
								</div>
								<div class="form-group">				
									<label class="col-md-2 control-label">Proceso</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="proceso" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Lista</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="A" id="lista" disabled>
										<p class="note">Indique la lista correspondiente al nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Código</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="0000" id="codigo-nomen-faba" disabled>
										<p class="note">Indique el código correspondiente al nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nivel</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="999.0" id="nivel" disabled>
										<p class="note">Indique la cantidad de unidades según el nomenclador FABA</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">RIA</label>
									<div class="col-md-5">	
										<select class="form-control" id="ria" disabled>
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
										<select class="form-control" id="nbu-frecuencia" disabled>
											<option selected="" disabled="">Seleccione una opción</option>
											<option value="1">Alta</option>
											<option value="0">Baja</option>
										</select>
										<p class="note">Definición frecuenta para NBU</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">NBU Código</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="000000" id="nbu-codigo" disabled>
										<p class="note">Indique el código de la práctica según el NBU</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Cantidad</label>
									<div class="col-md-5">
										<input class="form-control" type="number" placeholder="999.0" id="cantidad" disabled>
										<p class="note">Indique la cantidad de unidades para la práctica según el NBU</p>
									</div>
								</div>								
							</fieldset>
							<legend>Determinaciones</legend>
							<fieldset id="determinaciones">
								<div class="row" id="row-determinaciones">
								</div>
								<div class="row">
								  	<div class="col-md-3 col-md-offset-7">
								  		<input type="button" value="Agregar Determinación" id="agregar-determinacion" class="btn btn-primary" style="horizontal-align: rigth;" disabled>
								  	</div>
								</div>						
							</fieldset>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="modificar" value="Modificar Nomenclador" disabled>											
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
<div class="modal fade" id="modal-nomencladores">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Nomencladores de Trabajo</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-xs-1">Código</th>
									<th class="col-xs-2">Nombre</th>									
								</tr>
							</thead>
							<tbody id="body-nomencladores" style="cursor: pointer;">
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
<script src="js/app/mantenimiento-archivos/nomenclador/modificacion-nomenclador.js"></script>