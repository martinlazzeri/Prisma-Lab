<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Ingreso de Resultados por Prácticas</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-resultados">
							<fieldset>
								<legend>Búsqueda de Pacientes</legend>
								<div class="row">
									<section class="col col-6">
										<label class="label">Buscar por</label>
										<div class="inline-group">
											<label class="radio">
												<input type="radio" name="radio-inline" id="por-apellido-nombre" checked="checked">
												<i></i>Nombre y Apellido</label>
											<label class="radio">
												<input type="radio" name="radio-inline" id="por-num-paciente">
												<i></i>Número de paciente</label>
											<label class="radio">
												<input type="radio" name="radio-inline" id="por-dni">
												<i></i>D.N.I.</label>
										</div>
									</section>
									<section class="col col-4">
										<label class="label">Paciente</label>
										<label class="input">											
											<input type="text" id="buscar-paciente" placeholder="Apellido y Nombre / D.N.I / N° de paciente">												
										</label>
									</section>
								</div>
							</fieldset>
							
							<div id="form-campos" hidden>
								<fieldset>
									<legend>Datos del Paciente</legend>
									<div class="row">
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-4 control-label">Protocolo</label>
												<div class="col-md-5 label">
													<label style="color: red; font-weight: bold;" id="protocolo" class="control-label"></label>
												</div>
											</div>
										</section>
										<section class="col col-5">
											<div class="form-group">
												<label class="col-md-5 control-label">Número de Documento</label>
												<div class="col-md-3 label">
													<label style="font-weight: bold;" id="numero-doc" class="control-label"></label>
												</div>
											</div>
										</section>
									</div>
									<div class="row">
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-3 control-label">Paciente</label>
												<div class="col-md-3 label">
													<label style="font-weight: bold;" id="apellido-nombre" class="control-label"></label>
												</div>
											</div>
										</section>
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-2 control-label">Edad</label>
												<div class="col-md-1 label">
													<label style="font-weight: bold;" id="edad" class="control-label"></label>
												</div>
											</div>
										</section>
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-2 control-label">Sexo</label>
												<div class="col-md-3 label">
													<label style="font-weight: bold;" id="sexo" class="control-label"></label>
												</div>
											</div>
										</section>
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-3 control-label">Origen</label>
												<div class="col-md-1 label">
													<label style="font-weight: bold;" id="origen" class="control-label"></label>
												</div>
											</div>
										</section>
									</div>
									<div class="row">
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-3 control-label">Sección</label>
												<div class="col-md-1 label">
													<label style="font-weight: bold;" id="seccion" class="control-label"></label>
												</div>
											</div>
										</section>
										<section class="col col-3">
											<div class="form-group">
												<label class="col-md-3 control-label">Dr/a</label>
												<div class="col-md-1 label">
													<label style="font-weight: bold;" id="doctor" class="control-label"></label>
												</div>
											</div>
										</section>
									</div>
								</fieldset>
								<fieldset>
									<legend>Ingreso de Resultados</legend>
									<section id="resultado">
										<section align="left" class="col col-10">
											<div class="row">
												<section class="col col-5">
													<div class="form-group">
														<label class="col-md-4 control-label">Determinación</label>
														<div class="col-md-2 label">
															<label class="label" style="font-weight: bold;" id="determinacion"></label>
														</div>
													</div>
												</section>
											</div>
											<div class="row">
												<section class="col col-5">
													<div class="form-group">
														<label class="col-md-4 control-label">Descripción</label>
														<div class="col-md-1 label">
															<label class="label" style="font-weight: bold;" id="descripcion"></label>
														</div>
													</div>
												</section>
											</div>
											<div class="row">
												<section class="col col-md-5">
													<div class="form-group">
														<label class="col-md-4 control-label">Resultado</label>
														<div class="input-group col col-4">
															<input class="form-control" type="text" id="resultado-practica">
															<span class="input-group-addon" id="unidades"></span>
														</div>
													</div>
												</section>
											</div>
											<div class="row">
												<ul class="pagination no-margin">
													<li id="li-anterior">
														<a id="anterior">Anterior</a>
													</li>
													<li id="li-num-pagina" class="active">
														<a id="num-pagina">1</a>
													</li>
													<li id="li-siguiente">
														<a id="siguiente">Siguiente</a>
													</li>
												</ul>
											</div>
										</section>
										<section id="antecedentes" align="right" class="col col-2">
											<div class="row">
												<div class="form-group">
													<label></label>
												</div>												
											</div>
										</section>
									</section>
								</fieldset>
								<fieldset>
									<section>
										<legend>Valores de Referencia</legend>
										<div class="row">
											<section class="col col-2">
												<div class="form-group">
													<div class="col-md-2 label">
														<label class="label" style="font-weight: bold;" id="valores-referencias"></label>
													</div>
												</div>
											</section>
										</div>
									</section>
									<section>
										<legend></legend>
										<div class="row">
											<section class="col col-5">
												<div class="form-group">
													<label class="col-md-3 control-label">Obs:</label>
													<div class="col-md-2 label">
														<label class="label" style="font-weight: bold;" id="observaciones"></label>
													</div>
												</div>
											</section>
										</div>
										<div>
											<section>
												<table id="tabla-practicas" class="display projects-table table table-striped table-bordered table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
								        			<thead>
														<tr role="row">
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 5px;"><center><bold>Resultados<br/> Anteriores</bold></center></th>
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 10px;"><center><bold>Fecha<br/> Resultado</bold></center></th>
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 10px;"><center><bold></bold></center></th>
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 10px;"><center><bold></bold></center></th>
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 10px;"><center><bold></bold></center></th>
															<th tabindex="-1" rowspan="1" colspan="1" style="width: 10px;"><center><bold></bold></center></th>
														</tr>
													</thead>
													<tbody id="body-practicas">
														<tr id="row-practicas">
														</tr>
													</tbody>
												</table>
											</section>
										</div>
									</section>
								</fieldset>
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
<script src="js/app/ingresos/resultados/ingreso-por-seccion.js"></script>