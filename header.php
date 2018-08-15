<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<link rel="stylesheet" type="text/css" href="wp-content/themes/womensfoundation-theme/fonts/yummo/stylesheet.css">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri().'/images/icon.ico'; ?>">
		<?php
			$prk_hook_options=hook_options();
			$hook_retina_device=hook_retiner(true);
			hook_header();
			wp_head();
		?>
	</head>
	<body <?php body_class(); ?>>
		<div id="hook_main_wrapper" class="prk_loading_page prk_wait <?php echo esc_attr(hook_wrapper_classes()); ?>" data-trans="<?php echo esc_attr($prk_hook_options['page_transition']); ?>">
			<div id="prk_pint" data-media="" data-desc=""></div>
			<div id="body_hider"></div>
			<div id="hook_overlayer"></div>
			<div id="hook_loader_block"></div>
			<div id="hook_ajax_portfolio"<?php if ($prk_hook_options['share_portfolio']=="1" && $prk_hook_options['persistent_folio']=="1") {echo ' class="hook_stk"';} ?>>
				<div id="hook_ajax_pf_inner"></div>
				<div id="hook_close_portfolio" class="prk_grid-button prk_rearrange">
                    <span class="prk_grid"></span>
                </div>
			</div>
			<?php
				hook_preloader();
				if (isset($post->ID)) {
					hook_hidden_elements($post->ID);
				}
				else {
					hook_hidden_elements();
				}
			?>
			<div id="wf_donate">
				<div id="wf_donate_inner" class="extra_font">
					<!-- <a href="http://www.womensfoundationms.org/gamechanger/donate.php" target="_blank">DONATE</a> -->
					<a href="<?php bloginfo('url'); ?>/donations">DONATE</a>

				</div>
			</div>
			<div id="hook_header_section">
				<div id="hook_header_inner">
					<div class="small-12 columns small-centered <?php if ($prk_hook_options['top_bar_limited_width']==1) {echo "prk_inner_block";} else {echo "prk_extra_pad";} ?>">
						<?php
							if (isset($prk_hook_options['hook_wpml_menu']) && $prk_hook_options['hook_wpml_menu']==1 && function_exists('icl_object_id')) {
								hook_wpml_output();
							}
						?>
						<div id="hook_intro">
						<?php
							echo hook_logo();
						?>
						<div id="prk_blocks_wrapper" class="header_font <?php echo esc_attr($prk_hook_options['menu_text_only']); ?>">
			  				<div class="prk_menu_block prk_bl1"></div>
			  				<div class="prk_menu_block prk_bl2"></div>
			  				<div class="prk_menu_block prk_bl3"></div>
			  			</div>
			  			<div id="hook_side_menu">
				  			<?php
				  				if (isset($prk_hook_options['menu_align']) && $prk_hook_options['menu_align']!="st_menu_under") {
					  				if ($prk_hook_options['show_hidden_sidebar']=="1") {
					  					$hook_extra_class="";
					  					if (has_nav_menu('prk_main_navigation') && $prk_hook_options['menu_display']=="st_regular_menu") {
					  						$hook_extra_class=' prk_smaller_trigger"';
					  					}
					  					?>
					  					<div id="prk_sidebar_trigger" class="header_font <?php echo esc_attr($prk_hook_options['menu_text_only_sb'].$hook_extra_class); ?>" data-color="<?php echo esc_attr($prk_hook_options['menu_active_color']); ?>">
				  							<div class="prk_menu_block prk_bl1"></div>
				  							<div class="prk_menu_block prk_bl2"></div>
				  							<div class="prk_menu_block prk_bl3"></div>
					  					</div>
					  					<?php
					  				}
					  				if ($prk_hook_options['top_search']=="1") {
					  					echo '<div id="prk_menu_loupe" class="hook_fa-search prk_lf hook_fa-flip-horizontal" data-color="'.esc_attr($prk_hook_options['menu_active_color']).'"></div>';
					  				}
					  				hook_menu_icons("menu_social_nets","prk_less_opacity");
					  			}
					  		?>
			  			</div>
			  			<?php
			  				if ($prk_hook_options['menu_display']=="st_regular_menu") {
			  					?>
								<div id="hook_main_menu">
									<div id="hook_mm_inner">
									<?php
										if (isset($post->ID) && get_post_meta($post->ID,'top_menu',true)!="" && get_post_meta($post->ID,'top_menu',true)!="null") {
						  					wp_nav_menu(array(
												'menu' => get_post_meta($post->ID,'top_menu',true),
												'menu_class' => 'hook-mn sf-vertical '.$prk_hook_options['menu_font'],
												'link_after' => '',
												'walker' => new rc_scm_walker)
						  					);
										}
										else if (has_nav_menu('prk_main_navigation')) {
						  					wp_nav_menu(array(
												'theme_location' => 'prk_main_navigation',
												'menu_class' => 'hook-mn sf-vertical '.$prk_hook_options['menu_font'],
												'link_after' => '',
												'walker' => new rc_scm_walker)
						  					);
						  				}
					  					if (isset($prk_hook_options['menu_align']) && $prk_hook_options['menu_align']=="st_menu_under") {
		  					  				if ($prk_hook_options['show_hidden_sidebar']=="1") {
		  					  					$hook_extra_class="";
		  					  					if (has_nav_menu('prk_main_navigation') && $prk_hook_options['menu_display']=="st_regular_menu") {
		  					  						$hook_extra_class=' class="prk_smaller_trigger"';
		  					  					}
		  					  					?>
		  					  					<div id="prk_sidebar_trigger"<?php echo esc_attr($hook_extra_class); ?> data-color="<?php echo esc_attr($prk_hook_options['menu_active_color']); ?>">
		  				  							<div class="prk_menu_block prk_bl1"></div>
		  				  							<div class="prk_menu_block prk_bl2"></div>
		  				  							<div class="prk_menu_block prk_bl3"></div>
		  					  					</div>
		  					  					<?php
		  					  				}
		  					  				if ($prk_hook_options['top_search']=="1") {
		  					  					echo '<div id="prk_menu_loupe" class="hook_fa-search prk_lf hook_fa-flip-horizontal" data-color="'.esc_attr($prk_hook_options['menu_active_color']).'"></div>';
		  					  				}
		  					  				hook_menu_icons("menu_social_nets","prk_less_opacity");
		  					  			}
		  					  		?>
		  					  		</div>
		  					  	</div>
		  					  	<?php
				  			}
						?>
						</div>
					</div>
				</div>
			</div>
			<?php hook_extra_feature(); ?>
			<div id="hook_header_background"></div>
			<div id="hook_ajax_container">
