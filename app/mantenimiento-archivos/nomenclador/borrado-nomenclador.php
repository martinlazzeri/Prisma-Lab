<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Borrado de Nomenclador</h2>		
				</header>
				<div>
					<div class="widget-body">
						<form class="form-horizontal" id="form-nomencladores">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Buscar nomenclador</label>
									<div class="col-md-5">
										<input class="form-control" type="text" placeholder="Código: XXX - Nombre: ---" id="buscar-nomenclador" list="nomencladores_list">
										<datalist id="nomencladores_list"></datalist>
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
										<input class="form-control" type="text" placeholder="99" id="tiempo-realizacion" disabled>
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
							<fieldset>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">1 - Determinación</label>
										<div class="col-md-1">
											<input id="det0" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion0" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden0" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">2 - Determinación</label>
										<div class="col-md-1">
											<input id="det1" class="form-control" placeholder="XXX" type="text" disabled>
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion1" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden1" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">3 - Determinación</label>
										<div class="col-md-1">
											<input id="det2" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion2" class="form-control" type="text" placeholder="X0" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden2" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">4 - Determinación</label>
										<div class="col-md-1">
											<input id="det3" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion3" class="form-control" type="text" placeholder="X0" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden3" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">5 - Determinación</label>
										<div class="col-md-1">
											<input id="det4" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion4" class="form-control" type="text" placeholder="X0" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden4" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">6 - Determinación</label>
										<div class="col-md-1">
											<input id="det5" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion5" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden5" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">7 - Determinación</label>
										<div class="col-md-1">
											<input id="det6" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion6" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden6" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">8 - Determinación</label>
										<div class="col-md-1">
											<input id="det7" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion7" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden7" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">9 - Determinación</label>
										<div class="col-md-1">
											<input id="det8" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion8" class="form-control" type="text" placeholder="X0" disabled>							
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden8" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">10 - Determinación</label>
										<div class="col-md-1">
											<input id="det9" class="form-control" placeholder="XXX" type="text" disabled>
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion9" class="form-control" type="text" placeholder="X0" disabled>
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden9" class="form-control" type="number" disabled>
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">11 - Determinación</label>
										<div class="col-md-1">
											<input id="det10" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion10" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden10" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">12 - Determinación</label>
										<div class="col-md-1">
											<input id="det11" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion11" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden11" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">13 - Determinación</label>
										<div class="col-md-1">
											<input id="det12" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion12" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden12" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">14 - Determinación</label>
										<div class="col-md-1">
											<input id="det13" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion13" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden13" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">15 - Determinación</label>
										<div class="col-md-1">
											<input id="det14" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion14" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden14" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">16 - Determinación</label>
										<div class="col-md-1">
											<input id="det15" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion15" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden15" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">17 - Determinación</label>
										<div class="col-md-1">
											<input id="det16" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion16" class="form-control" type="text" placeholder="X0" disabled>							
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden16" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">18 - Determinación</label>
										<div class="col-md-1">
											<input id="det17" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion17" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden17" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">19 - Determinación</label>
										<div class="col-md-1">
											<input id="det18" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion18" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden18" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">20 - Determinación</label>
										<div class="col-md-1">
											<input id="det19" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion19" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden19" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">21 - Determinación</label>
										<div class="col-md-1">
											<input id="det20" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion20" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden20" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">22 - Determinación</label>
										<div class="col-md-1">
											<input id="det21" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion21" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden21" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">23 - Determinación</label>
										<div class="col-md-1">
											<input id="det22" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion22" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden22" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">24 - Determinación</label>
										<div class="col-md-1">
											<input id="det23" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion23" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden23" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">25 - Determinación</label>
										<div class="col-md-1">
											<input id="det24" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion24" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden24" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">26 - Determinación</label>
										<div class="col-md-1">
											<input id="det25" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion25" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden25" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">27 - Determinación</label>
										<div class="col-md-1">
											<input id="det26" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion26" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden26" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">28 - Determinación</label>
										<div class="col-md-1">
											<input id="det27" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion27" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden27" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">29 - Determinación</label>
										<div class="col-md-1">
											<input id="det28" class="form-control" placeholder="XXX" type="text"disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion28" class="form-control" type="text" placeholder="X0"disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden28" class="form-control" type="number" disabled>
										</div>
									</section>
								</div>
								<div class="form-group">
									<section class="col col-4">
										<label class="col-md-2 control-label">30 - Determinación</label>
										<div class="col-md-1">
											<input id="det29" class="form-control" placeholder="XXX" type="text" disabled>										
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Sección</label>
										<div class="col-md-1">
											<input id="seccion29" class="form-control" type="text" placeholder="X0" disabled>									
										</div>
									</section>
									<section class="col col-4">
										<label class="col-md-1 control-label">Orden</label>
										<div class="col-md-1">
											<input id="orden29" class="form-control" type="number" disabled>										
										</div>
									</section>
								</div>
							</fieldset>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="eliminar" value="Borrar Nomenclador">											
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
<div class="modal fade" id="modal-nomenclador">
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
<script src="js/app/mantenimiento-archivos/nomenclador/borrado-nomenclador.js"></script>