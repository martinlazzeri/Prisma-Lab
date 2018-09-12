<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
			<div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
				<div role="content">
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-listado" method="post" target="_blank" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/listado-nomencladores-pdf.php'; ?>">
							<fieldset>
								<section>
									<label class="label">Filtros de listado</label>
									<div id="form-radio" class="inline-group">
										<label class="radio">
											<input id="todos" type="radio" name="radio-inline" checked="checked">
											<i></i>Todos
										</label>
										<label class="radio">
											<input id="alfabetico" type="radio" name="radio-inline">
											<i></i>Orden Alfabético
										</label>
										<label class="radio">
											<input type="radio" name="radio-inline">
											<i></i>Orden Alfabético Nomenclador Reducido
										</label>
										<label class="radio">
											<input type="radio" name="radio-inline">
											<i></i>Orden Alfabético de Pérfiles por Código
										</label>
										<input type="submit" name="listado-nomencladores" class="btn btn-primary" id="crearpdf" value="Generar PDF">
									</div>
								</section>	
							</fieldset>
							<footer id="botonBuscar">
								<input type="button" class="btn btn-primary" id="buscar" value="Buscar" tabindex="43">
							</footer>
						</form>
					</div>
				</div>
			</div>			
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">						
						<header>
							<h2>Listado de Nomencladores</h2>							
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
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Código</th>											
											<th>Nombre</th>
											<th>Inos Reducido</th>
											<th>No Nomenclada</th>
											<th>Area</th>
											<th>PMO</th>
											<th>U. Honorarios</th>
											<th>U. Gastos</th>
											<th>NBU Codigo</th>
											<th>Nivel</th>
										</tr>
									</thead>
									<tbody id="body-nomencladores">
										<div id="spinner" style="display:none" align="center">
											<center>
												<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
											</center>
										</div>										
									</tbody>	
								</table>
								<div class="text-center">
									<hr>
									<ul class="pagination no-margin">
										<li id="li-anterior">
											<a href="#" id="anterior">Anterior</a>
										</li>
										<li class="active">
											<a href="#" id="num-pagina">1</a>
										</li>
										<li id="li-siguiente">
											<a href="#" id="siguiente">Siguiente</a>
										</li>
									</ul>
									<br>
									<br>										
								</div>
							</div>
							<!-- end widget content -->
						</div>
						<!-- end widget div -->
					</div>
					<!-- end widget -->
				</article>
			</div>
		</article>
	</div>
</section>
<div class="modal fade" id="mostrar-info">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Info Nomenclador</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
	    	    		<div class="form-group">
							<label class="col-md-5 control-label">Código de Práctica</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="codigo"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Nombre</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nombre"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">INOS</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="inos"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">677</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="_677"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">U. Gastos</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="u-gastos"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">U. Honorarios</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="u-honorarios"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">Area</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="area"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="select-1">Complejidad</label>
							<div class="col-md-5">	
								<label class="col-md-5 control-label" id="complejidad"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="select-1">INOS Reducido</label>
							<div class="col-md-5">	
								<label class="col-md-5 control-label" id="inos-reducido"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="select-1">No Nomenclada</label>
							<div class="col-md-5">	
								<label class="col-md-5 control-label" id="no-nomenclada"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">Tiempo de Realización</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="tiempo-realizacion"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">Id. Muestra</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="id-muestra"></label>
							</div>
						</div>
						<div class="form-group">				
							<label class="col-md-5 control-label">Proceso</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="proceso"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Lista</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="lista"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Código</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="codigo-nomen-faba"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Nivel</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nivel"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="select-1">RIA</label>
							<div class="col-md-5">	
								<label class="col-md-5 control-label" id="ria"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="select-1">NBU Frecuencia</label>
							<div class="col-md-5">	
								<label class="col-md-5 control-label" id="nbu-frecuencia"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">NBU Código</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nbu-codigo"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Cantidad</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="cantidad"></label>
							</div>
						</div>						
					</div>
				</section>
        	</div>
      		<div class="modal-footer">	      			
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>		        	
      		</div>
    	</div>
    </div>
</div>
<script src="js/app/mantenimiento-archivos/nomenclador/listados-nomencladores.js"></script>