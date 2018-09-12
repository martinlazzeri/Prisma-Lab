<?php
session_start();
?>
<div id="content">
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">					
				<center id="logo-inicio">
					<img src="<?php echo $_SESSION['UrlParcialLogo']?>">
					<footer>
						<label class="center" style="font-weight: bold">
							<strong>
								<?php echo $_SESSION['LemaLab']; ?>
							</strong>
						</label>
					</footer>
				</center>
			</article>
		</div>
	</section>
</div>