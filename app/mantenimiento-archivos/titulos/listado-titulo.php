<section id="widget-grid" class="">
			<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">
						<header>
							<h2>Listado de Títulos</h2>
							<form id="form-listado" method="POST" target="_blank" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/listado-titulos-pdf.php'; ?>">
								<button type="submit" id="generar-pdf" class="btn btn-default">Generar PDF</button>
							</form>
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
											<th>Descripción</th>
											<th>Tipo</th>
											<th>Unidades</th>											
											<th>Rango</th>
											<th>Linea 1</th>
											<th>Linea 2</th>
											<th>Linea 3</th>
											<th>Linea 4</th>
											<th>Ref. Ext.</th>
											<th>Val. Mín.</th>
											<th>Val. Máx.</th>											
										</tr>
									</thead>
									<tbody id="body-titulos"></tbody>									
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
	        	<h4 class="modal-title">Info Título</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
	    	    		<div class="form-group">
							<label class="col-md-5 control-label">Código</label>
							<div class="col-md-5">
								<input id="codigo" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Descripción Abreviada</label>
							<div class="col-md-5">
								<input id="descripcion" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="tipo-titulo">Tipo</label>
							<div class="col-md-5">			
								<select class="form-control" id="tipo-titulo" disabled>
									<option selected="" disabled="">Seleccione una opción</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Unidades</label>
							<div class="col-md-5">
								<input id="unidades" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Rango</label>
							<div class="col-md-5">
								<input id="rango" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Línea de Texto 1 (Resaltada)</label>
							<div class="col-md-5">
								<input id="linea1" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Línea de Texto 2</label>
							<div class="col-md-5">
								<input id="linea2" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Línea de Texto 3</label>
							<div class="col-md-5">
								<input id="linea3" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Resultado</label>
							<div class="col-md-5">
								<input id="resultado" class="form-control" type="text" disabled> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">Valores de Referencia Ampliados</label>
							<div class="col-md-5">
								<textarea id="valores-referencia" class="form-control" disabled style="resize: none;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="tipo-matricula">Valor Mínimo Aceptable</label>
							<div class="col-md-5">			
								<input id="valor-minimo" class="form-control" type="text" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label" for="tipo-matricula">Valor Máximo Aceptable</label>
							<div class="col-md-5">			
								<input id="valor-maximo" class="form-control" type="text" disabled>
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
<script src="js/app/mantenimiento-archivos/titulos/listado-titulo.js"></script>