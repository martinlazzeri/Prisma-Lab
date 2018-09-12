<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Borrado de Sección</h2>		
				</header>
				<div>
					<div class="widget-body">
						<form class="form-horizontal" id="form-secciones" autocomplete="off">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Buscar Código de la Sección</label>
									<div class="col-md-4">
										<input class="form-control" type="text" placeholder="Código XX - Nombre de sección" id="buscar_secciones">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Codigo</label>
									<div class="col-md-4">
										<input class="form-control" type="text" id="codigo" maxlength="3" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nombre</label>
									<div class="col-md-4">
										<input class="form-control" type="text" id="nombre" maxlength="50" disabled>
									</div>
								</div>
								<div id="div_determinaciones">
									
								</div>								
							</fieldset>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="eliminar" value="Borrar Sección">											
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
<div class="modal fade" id="modal_secciones">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Secciones existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Código</th>
									<th class="col-md-3">Nombre</th>
								</tr>
							</thead>
							<tbody id="body_secciones" style="cursor: pointer;">
							</tbody>
						</table>
					</div>					
				</section>				
        	</div>
      		<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      		</div>
    	</div>
    </div>
</div>
<script src="js/app/mantenimiento-archivos/secciones/borrado-seccion.js"></script>