	<div id="ribbon">
		<ol class="breadcrumb">
			<?php
				foreach ($breadcrumbs as $display => $url) {
					$breadcrumb = $url != "" ? '<a href="'.$url.'">'.$display.'</a>' : $display;
					echo '<li>'.$breadcrumb.'</li>';
				}
				echo '<li id="ribbon-breadcrum">'.$page_title.'</li>';
			?>
		</ol>
	</div>