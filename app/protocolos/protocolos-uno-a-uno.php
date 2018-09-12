<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget col-lg-12" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Protocolos Uno a Uno</h2>		
				</header>
				<div>
					<div class="widget-body no-padding">
						<form class="smart-form" id="form-protocolos" method="post" target="_blank" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/protocolos-uno-a-uno/protocolo-uno-uno-pdf.php'; ?>">
							<fieldset>
								<input type="hidden" id="ingresoId" name="ingresoId">
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
							<fieldset id="datos-paciente" style="display:none">								
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
									<section class="col col-3">
										<div class="form-group">
											<label class="col-md-3 control-label">Paciente</label>
											<div class="col-md-3 label">
												<label style="font-weight: bold;" id="apellido-nombre" class="control-label"></label>
											</div>
										</div>
									</section>
								</div>
							</fieldset>
							<fieldset id="cuerpo-protocolo" style="display:none">
								<div class="row" id="practicas">
								</div>
								<div class="row">
									<section class="col col-4"></section>
									<section class="col col-1">
										<label class="label"><strong>Estado: </strong></label>										
									</section>
									<section class="col col-3" id="estadoProtocolo">										
									</section>
									<section class="col col-4"></section>
								</div>
							</fieldset>
							<fieldset id="datos-controlador" style="display:none">
								<legend>Búsqueda de Controlador</legend>
								<div class="row">									
									<section class="col col-4"></section>
									<section class="col col-4">
										<label class="label">Ingrese el código del Controlador</label>
										<label class="input">											
											<input type="text" id="buscar-controlador" placeholder="Código de Controlador" autocomplete="off">												
										</label>
									</section>
									<section class="col col-4"></section>
								</div>
							</fieldset>
							<footer id="footer" style="display:none">
								<button type="submit" id="emitir-protocolo" class="btn btn-primary" disabled>
									Emitir Protocolo
								</button>
							</footer>
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

<div class="modal fade" id="modal-controladores">
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
									<th class="col-md-1">Código</th>
									<th class="col-md-3">Nombre</th>
									<th class="col-md-3">Apellido</th>
								</tr>
							</thead>
							<tbody id="body-controladores" style="cursor: pointer;">
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
<script src="js/app/protocolos/protocolos-uno-a-uno.js"></script>