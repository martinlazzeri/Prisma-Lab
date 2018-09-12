<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Alta de Sección</h2>		
				</header>
				<div>
					<div class="widget-body">
						<form class="form-horizontal" id="form-secciones">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Código de la Sección</label>
									<div class="col-md-1">
										<input class="form-control" type="text" placeholder="XX" id="codigo" maxlength="2">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nombre</label>
									<div class="col-md-4">
										<input class="form-control" type="text" id="nombre" maxlength="50">
									</div>
								</div>
								
								<div id="div_determinaciones">
									
								</div>
								<button id="agregar_det" type="button" class="btn btn-primary">Agregar Determinacion</button>
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
<div class="modal fade" id="modal_nomencladores">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Nomencladores existentes</h4>
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
							<tbody id="body_nomencladores" style="cursor: pointer;">
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
<script src="js/app/mantenimiento-archivos/secciones/alta-seccion.js"></script>