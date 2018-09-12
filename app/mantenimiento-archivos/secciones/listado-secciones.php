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
							<h2>Listado de Secciones</h2>
							<form id="form-listado" method="POST" target="_blank" action="<?php echo dirname($_SERVER['PHP_SELF']) . '/pdf/listado-secciones-pdf.php'; ?>">
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
											<th>Cód. Sección</th>
											<th>Nombre</th>
											<th>1</th>
											<th>2</th>
											<th>3</th>
											<th>4</th>
											<th>5</th>
											<th>6</th>
											<th>7</th>
											<th>8</th>
											<th>9</th>
											<th>10</th>
											<th>11</th>
											<th>12</th>
											<th>13</th>
											<th>14</th>
											<th>15</th>
											<th>16</th>
											<th>17</th>
											<th>18</th>
											<th>19</th>
											<th>20</th>
											<th>21</th>
											<th>22</th>
											<th>23</th>
											<th>24</th>
										</tr>
									</thead>
									<tbody id="body-secciones"></tbody>									
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
	        	<h4 class="modal-title">Info Sección</h4>
	      	</div>
	      	<div class="modal-body">
    	    	<section>
    	    		<div class="row">
	    	    		<div class="form-group">
							<label class="col-md-5 control-label">Nombre</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="nombre"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">1</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det1"></label>
							</div>
							<label class="col-md-5 control-label">2</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det2"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">3</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det3"></label>
							</div>
							<label class="col-md-5 control-label">4</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det4"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">5</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det5"></label>
							</div>
							<label class="col-md-5 control-label">6</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det6"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">7</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det7"></label>
							</div>
							<label class="col-md-5 control-label">8</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det8"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">9</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det9"></label>
							</div>
							<label class="col-md-5 control-label">10</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det10"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">11</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det11"></label>
							</div>
							<label class="col-md-5 control-label">12</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det12"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">13</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det13"></label>
							</div>
							<label class="col-md-5 control-label">14</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det14"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">15</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det15"></label>
							</div>
							<label class="col-md-5 control-label">16</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det16"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">17</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det17"></label>
							</div>
							<label class="col-md-5 control-label">18</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det18"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">19</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det19"></label>
							</div>
							<label class="col-md-5 control-label">20</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det20"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">21</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det21"></label>
							</div>
							<label class="col-md-5 control-label">22</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det22"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-5 control-label">23</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det23"></label>
							</div>
							<label class="col-md-5 control-label">24</label>
							<div class="col-md-5">
								<label class="col-md-5 control-label" id="det24"></label>
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
<script src="js/app/mantenimiento-archivos/secciones/listado-secciones.js"></script>