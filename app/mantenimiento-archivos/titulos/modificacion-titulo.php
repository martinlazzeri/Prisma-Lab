<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">						
				<header>							
					<h2>Modificar Título</h2>
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<!-- widget content -->
					<div class="widget-body">
						<form id="form-titulo" class="form-horizontal">
							<fieldset>
								<div class="form-group">					
									<label class="col-md-2 control-label">Buscar Título</label>
									<div class="col-md-6">
										<input id="buscar-titulos" class="form-control" placeholder="XXX - Descripción abreviada de título" type="text" list="titulos">
										<datalist id="titulos"></datalist>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Código</label>
									<div class="col-md-6">
										<input id="codigo" class="form-control" placeholder="XXX" type="text" maxlength="3" disabled style='text-transform:uppercase'>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Descripción Abreviada</label>
									<div class="col-md-6">
										<input id="descripcion" class="form-control" placeholder="Descripción Abreviada" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="tipo-titulo">Tipo</label>
									<div class="col-md-6">			
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
									<label class="col-md-2 control-label">Unidades</label>
									<div class="col-md-6">
										<input id="unidades" class="form-control" placeholder="Unidades" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Rango</label>
									<div class="col-md-6">
										<input id="rango" class="form-control" placeholder="Rango" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Línea de Texto 1 (Resaltada)</label>
									<div class="col-md-6">
										<input id="linea1" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Línea de Texto 2</label>
									<div class="col-md-6">
										<input id="linea2" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Línea de Texto 3</label>
									<div class="col-md-6">
										<input id="linea3" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Resultado</label>
									<div class="col-md-6">
										<input id="resultado" class="form-control" type="text" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Valores de Referencia Ampliados</label>
									<div class="col-md-6">
										<textarea id="valores-referencia" class="form-control" rows="4" disabled style="resize: none;"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="tipo-matricula">Valor Mínimo Aceptable</label>
									<div class="col-md-4">			
										<input id="valor-minimo" class="form-control" placeholder="0000.00" type="number" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="tipo-matricula">Valor Máximo Aceptable</label>
									<div class="col-md-4">			
										<input id="valor-maximo" class="form-control" placeholder="0000.00" type="number" disabled>
									</div>
								</div>
							</fieldset>									
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input class="btn btn-primary" type="button" id="modificar" value="Grabar Cambios" disabled>											
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- end widget content -->
				</div>
			</div>
		</article>
	</div>
</section>
<script src="js/app/mantenimiento-archivos/titulos/modificacion-titulo.js"></script>