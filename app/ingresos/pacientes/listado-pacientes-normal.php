<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
			<div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
				<div role="content">
					<div class="widget-body no-padding">
						<form class="smart-form" method="post" target="_blank" id="form-listado" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/listado-pacientes-normal-pdf.php'; ?>">
							<fieldset>
								<section>
									<label class="label">Filtros de listado</label>
									<div id="form-radio" class="inline-group">
										<label class="radio">
											<input id="todos" type="radio" name="radio-inline" checked="checked">
											<i></i>Todos</label>
										<label class="radio">
											<input id="fechas" type="radio" name="radio-inline">
											<i></i>Entre fechas</label>
										<label class="radio">
											<input id="pendientes" type="radio" name="radio-inline">
											<i></i>Pendientes</label>
										<input type="submit" name="listado-normal" class="btn btn-primary" id="crearpdf" value="Generar PDF">
									</div>
								</section>	
							</fieldset>
							<fieldset id="entreFechas">
								<section class="col col-3">
									<label class="label">Fecha Desde</label>
									<label class="input">
										<input type="date" id="desde" value="<?php echo date('Y-m') . '-01';?>">
									</label>									
								</section>
								<section class="col col-3">
									<label class="label">Fecha Hasta</label>
									<label class="input">
										<input type="date" id="hasta" value="<?php echo date('Y-m-d');?>">
									</label>									
								</section>
							</fieldset>
							<footer id="footer">
								<input type="button" class="btn btn-primary" id="buscar" value="Buscar">
							</footer>
						</form>
					</div>
				</div>
			</div>			
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
				<article class="col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">						
						<header>
							<h2>Listado de Ingresos</h2>							
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
											<th>N° de Paciente</th>
											<th>Nombre y Apellido</th>
											<th>D.N.I.</th>
											<th>E-Mail</th>
											<th>Obra Social 1</th>
											<th>Obra Social 2</th>
										</tr>
									</thead>
									<tbody id="pacientes-body"></tbody>
								</table>
								<div class="text-center">
									<hr>
									<ul class="pagination no-margin">
										<li id="li-anterior">
											<a href="#" id="anterior">Anterior</a>
										</li>
										<li id="li-num-pagina" class="active">
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
<script src="js/app/ingresos/pacientes/listado-pacientes-normal.js"></script>