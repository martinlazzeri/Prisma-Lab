<section id="widget-grid" class="">
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">						
				<header>							
					<h2>Borrado de Nomenclador Especial</h2>
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
						<form class="form-horizontal" id="form-practicas">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Mutual</label>
									<div class="col-md-5">
										<input id="buscar_mutual" class="form-control" placeholder="Código: XXXX - Nombre" type="text" disabled>										
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Prácticas existentes</label>
									<div class="col-md-5">
										<input id="buscar_practica" class="form-control" placeholder="Nombre: XXX - Mutual" type="text" list="list_practicas">
										<datalist id="list_practicas"></datalist>
									</div>
								</div>								
								<div class="form-group">
									<label class="col-md-2 control-label">Nombre Práctica</label>
									<div class="col-md-2">
										<input id="nombre" class="form-control" placeholder="XXX" maxlength="3" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">A</label>
									<div class="col-md-2">			
										<input id="a" class="form-control" placeholder="X" type="text" maxlength="1" disabled> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Código</label>
									<div class="col-md-2">
										<input id="codigo" class="form-control" type="text" maxlength="10" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Unidad Gasto</label>
									<div class="col-md-2">
										<input id="unidad-gasto" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Unidad Honorario</label>
									<div class="col-md-2">
										<input id="unidad-honorario" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nivel</label>
									<div class="col-md-2">
										<input id="nivel" class="form-control" type="text" disabled>
									</div>
								</div>
							</fieldset>									
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="eliminar" value="Borrar Nomenclador Especial" disabled>
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
<script src="js/app/mantenimiento-archivos/practicas/borrado-practica.js"></script>