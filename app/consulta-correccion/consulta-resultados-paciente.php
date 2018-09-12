<section id="widget-grid" class="">
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">						
				<header>							
					<h2>Consulta de Resultados por Paciente</h2>
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
						<form id="form-resultados" class="form-horizontal" autocomplete="off">
							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label">Búsqueda de pacientes</label>
									<div class="col-md-5">
										<input class="form-control" type="text" id="buscar-paciente" placeholder="N° Paciente / Apellido / Nombre">
									</div>
								</div>
								<div id="div-campos" hidden>
									<div class="form-group">
										<label class="col-md-2 control-label">Protocolo N°</label>
										<div class="col-md-5">
											<label style="color: red; font-weight: bold;" id="protocolo" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Apellido y Nombre</label>
										<div class="col-md-5">
											<label style="font-weight: bold;" id="apellido-nombre" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Dr./a</label>
										<div class="col-md-5">
											<label style="font-weight: bold;" id="medico" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Edad</label>
										<div class="col-md-5">
											<label style="font-weight: bold;" id="edad" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Sexo</label>
										<div class="col-md-5">
											<label style="font-weight: bold;" id="sexo" class="control-label"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Origen</label>
										<div class="col-md-5">
											<label style="font-weight: bold;" id="origen" class="control-label"></label>
										</div>
									</div>
									<legend>Prácticas</legend>
									<divclass="form-group">
										<div id="practicas">
										</div>									
									</div>
								</div>
							</fieldset>								
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
<div class="modal fade" id="modal-ingresos">
	<div class="modal-dialog">
	    <div class="modal-content">
    	  	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	        	<h4 class="modal-title">Ingresos Existentes</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-2">N° Paciente</th>
									<th class="col-md-3">Apellido y Nombre</th>
									<th class="col-md-2">D.N.I.</th>
									<th class="col-md-2">Médico</th>
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
<script src="js/app/consulta-correccion/consulta-resultados/consulta-resultados-paciente.js"></script>