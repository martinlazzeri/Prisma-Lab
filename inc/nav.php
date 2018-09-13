<aside id="left-panel">
	<div class="login-info">
		<span>
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<div id="perfil-image"></div>
			</a> 
		</span>
	</div>
	<nav>
		<ul>
			<?php
				foreach ($page_nav as $key => $nav_item) {
					//process parent nav
					$nav_htm = '';							
					$url = isset($nav_item["url"]) ? $nav_item["url"] : "#";

					$type = isset($nav_item["type"]) ? 'onclick="LoadContent('. $nav_item["type"] .')"' : '';							
					
					$url_target = isset($nav_item["url_target"]) ? 'target="'.$nav_item["url_target"].'"' : "";
					$icon_badge = isset($nav_item["icon_badge"]) ? '<em>'.$nav_item["icon_badge"].'</em>' : '';
					$icon = isset($nav_item["icon"]) ? '<i class="fa fa-lg fa-fw '.$nav_item["icon"].'">'.$icon_badge.'</i>' : "";
					$nav_title = isset($nav_item["title"]) ? $nav_item["title"] : "(No Name)";
					$label_htm = isset($nav_item["label_htm"]) ? $nav_item["label_htm"] : "";
					$nav_htm .= '<a href="'.$url.'" '.$url_target.' title="'.$nav_title.'" '. $type .'>'.$icon.' <span class="menu-item-parent">'.$nav_title.'</span>'.$label_htm.'</a>';
					if (isset($nav_item["sub"]) && $nav_item["sub"])
						$nav_htm .= Process_Sub_Nav($nav_item["sub"]);
					echo '<li '.(isset($nav_item["active"]) ? 'class = "active"' : '').' >'.$nav_htm.'</li>';
				}
				function Process_Sub_Nav($nav_item) {
					$sub_item_htm = "";
					if (isset($nav_item["sub"]) && $nav_item["sub"]) {
						$sub_nav_item = $nav_item["sub"];
						$sub_item_htm = Process_Sub_Nav($sub_nav_item);
					} else {
						$sub_item_htm .= '<ul>';
						foreach ($nav_item as $key => $sub_item) {
							$url = isset($sub_item["url"]) ? $sub_item["url"] : "#";
							$type = isset($sub_item["type"]) ? 'onclick="LoadContent('. $sub_item["type"] .')"' : '';
							$id = isset($sub_item["id"]) ? 'id="'. $sub_item["id"] .'"' : '';
							$url_target = isset($sub_item["url_target"]) ? 'target="'.$sub_item["url_target"].'"' : "";
							$icon = isset($sub_item["icon"]) ? '<i class="fa fa-lg fa-fw '.$sub_item["icon"].'"></i>' : "";
							$nav_title = isset($sub_item["title"]) ? $sub_item["title"] : "(No Name)";
							$label_htm = isset($sub_item["label_htm"]) ? $sub_item["label_htm"] : "";
							$sub_item_htm .= 
								'<li '.(isset($sub_item["active"]) ? 'class = "active"' : '').' '. $id .'>
									<a href="'.$url.'" '.$url_target.' '. $type .' ">'.$icon.' '.$nav_title.$label_htm.'</a>
									'.(isset($sub_item["sub"]) ? Process_Sub_Nav($sub_item["sub"]) : '').'
								</li>';
						}
						$sub_item_htm .= '</ul>';
					}
					return $sub_item_htm;
				}
			?>
		</ul>
	</nav>
	<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>