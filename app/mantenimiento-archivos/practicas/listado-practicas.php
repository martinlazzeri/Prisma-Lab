<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
			<div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
				<div role="content">
					<div class="widget-body no-padding">
						<form id="form-listado" class="smart-form" method="post" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/listado-nomencladores-especiales-pdf.php'; ?>" target="_blank">
							<fieldset>
								<section>
									<label class="label">Filtros de listado</label>
									<div id="form-radio" class="inline-group">
										<label class="radio">
											<input id="todos" type="radio" name="radio-inline" checked="checked" tabindex="0">
											<i></i>Todas (por orden alfábetico)
										</label>
										<label class="radio">
											<input id="por-mutual" type="radio" name="radio-inline" tabindex="1">
											<i></i>Por Mutual
										</label>
										<input type="submit" name="listado-nomencladores-especiales" class="btn btn-primary" id="crearpdf" value="Generar PDF">
										<div id="form-mutual" hidden>
											<label class="col-md-1">Mutuales</label>
											<input id="buscar_mutual" class="col-md-3" placeholder="Nombre mutual" type="text" list="list_mutuales" tabindex="2">
											<datalist id="list_mutuales"></datalist>
										</div>
									</div>
								</section>	
							</fieldset>
							<footer id="botonBuscar">
								<input type="button" class="btn btn-primary" id="buscar" value="Buscar" tabindex="3">
							</footer>
						</form>
					</div>
				</div>
			</div>			
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">						
						<header>
							<h2>Listado de Nomenclador Especial</h2>							
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
											<th>A</th>											
											<th>Nombre</th>
											<th>Código</th>
											<th>Unidad Gasto</th>
											<th>Unidad Honorario</th>
											<th>Nivel</th>
										</tr>
									</thead>
									<tbody id="body-practicas"></tbody>									
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
	        	<h4 class="modal-title">Info Nomenclador Especial</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
	    	    		<div class="form-group">
							<label class="col-md-5 control-label">Mutual</label>
							<div class="col-md-5">
								<label class="col-md-10 control-label" id="nombre-mutual"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Nombre Práctica</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nombre"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">A</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="a"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Código</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="codigo"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Unidad Gasto</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="unidad-gasto"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Unidad Honorario</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="unidad-honorario"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Nivel</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nivel"></label>
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
<script src="js/app/mantenimiento-archivos/practicas/listado-practicas.js"></script>