<?php
    //PLACE YOUR CUSTOM FUNCTIONS HERE
	//MIGRATION NOTES
	//NEED TO CHANGE THE EXTRA FONT URL PATH


	//UNCOMMENT THIS CODE TO OVERRIDE THE THEME main-min.js FILE
	add_action( 'wp_enqueue_scripts', 'prk_overwrite_scripts', 101 );
	function prk_overwrite_scripts() {
		if (function_exists('wp_get_theme')) {
		    $prk_theme = wp_get_theme();
		} 
		else {
		    $prk_theme->Version="1";
		}
	    /*wp_deregister_script('hook_main');
	    wp_enqueue_script('hook_main', get_stylesheet_directory_uri() . '/js/main-min.js', array('jquery'), $prk_theme->Version, true );
	    $prk_hook_options=hook_options();
	    $prk_hook_options['active_visual_composer']=HOOK_VC_ON;	    
	    wp_localize_script('hook_main', 'theme_options', $prk_hook_options);*/
	    wp_enqueue_script('rwdImageMaps', get_stylesheet_directory_uri() . '/js/jquery.rwdImageMaps.min.js', array('jquery'), $prk_theme->Version, true );
	}
	/*
	UNCOMMENT THIS CODE TO LOAD TRANSLATIONS FROM THE CHILD THEME
	// Load translation files from your child theme instead of the parent theme
	function hook_theme_locale() {
	    load_child_theme_textdomain( 'hook', get_stylesheet_directory() . '/languages' );
	}
	add_action( 'after_setup_theme', 'hook_theme_locale' );
	*/

	function hook_hidden_elements($page_id="") {
	    $prk_hook_options=hook_options();
	    $hook_translated=hook_translations();
	    if ($prk_hook_options['menu_display']=="st_hidden_menu") {
	        ?>
	        <div id="prk_hidden_menu" class="<?php echo esc_attr($prk_hook_options['overlay_align']); ?>">
	        <div id="prk_hidden_menu_inner">
	            <?php
	                if($prk_hook_options['overlay_page_id']!="") {
	                    ?>
	                    <div id="prk_hidden_menu_page">
	                        <?php echo do_shortcode(get_post_field( 'post_content', $prk_hook_options['overlay_page_id'], 'raw' )); ?>
	                    </div>
	                    <?php
	                }
	                else {
	                    if (has_nav_menu('prk_main_navigation')) {
	                        wp_nav_menu(array(
	                            'theme_location' => 'prk_main_navigation', 
	                            'menu_class' => 'unstyled prk_popper_menu prk_menu_sized '.$prk_hook_options['menu_font'],
	                            'link_after' => '',
	                            'walker' => new rc_scm_walker)
	                        );
	                    }
	                }
	            ?>
	        </div>
	        <?php
	            if ($prk_hook_options['overlay_footer_text']!="") {
	                $hook_html=array('a' => array('href' => array(),'title' => array(),'style'=>array()),'p' => array('style'=>array()),'br' => array('style'=>array()),'em' => array('style'=>array()),'strong' => array('style'=>array()));
	                ?>
	                <div id="prk_hidden_menu_footer">
	                    <?php echo wp_kses($prk_hook_options['overlay_footer_text'],$hook_html); ?>
	                </div>
	                <?php
	            }
	        ?>
	        </div>
	        <?php
	    }
	    if ($prk_hook_options['show_hidden_sidebar']=="1") {
	        ?>
	        <div id="prk_hidden_bar" class="small-12">
	            <div id="prk_hidden_bar_scroller">
	                <div id="prk_hidden_bar_inner" class="<?php echo hook_output().$prk_hook_options['sidebar_align']; ?>">
	                    <?php
	                        $hook_hidden_sidebar_id='sidebar-hidden';
	                        if (get_field('hidden_sidebar_id')!="") {
	                            $hook_hidden_sidebar_id=get_field('hidden_sidebar_id');
	                        }
	                        if (is_active_sidebar($hook_hidden_sidebar_id)) {
	                            if (function_exists('dynamic_sidebar') && dynamic_sidebar($hook_hidden_sidebar_id)) : 
	                            endif;
	                        }
	                    ?>
	                    <div class="clearfix"></div>
	                </div>
	            </div>
	        <?php
	            if ($prk_hook_options['sidebar_footer_id']!="" && is_active_sidebar($prk_hook_options['sidebar_footer_id'])) {
	                echo '<div id="hidden_bar_footer" class="small-12 '.esc_attr($prk_hook_options['sidebar_align']).'">';
	                if (function_exists('dynamic_sidebar') && dynamic_sidebar($prk_hook_options['sidebar_footer_id'])) : 
	                endif;
	                echo '<div class="clearfix"></div></div>';
	            }
	        ?>
	        </div>
	        <?php
	    }
	    if ($prk_hook_options['top_search']=="1") {
	        ?>
	        <div id="search_hider"></div>
	        <div id="searchform_top" class="top_sform_wrapper" data-url="<?php echo hook_clean_url(); ?>">
	            <form method="get" class="form-search" action="<?php echo esc_url(home_url('/')); ?>">
	                <div class="sform_wrapper">
	                    <input type="text" value="" name="s" id="hook_search_top" class="search-query pirenko_highlighted" placeholder="<?php echo esc_attr($hook_translated['search_tip_text']); ?>" />
	                </div>
	            </form>
	            <div id="top_form_close">
	                <div class="mfp-close_inner"></div>
	            </div>
	        </div>
	        <?php
	    }
	    ?>
	    <div id="prk_mobile_bar" class="small-12">
	        <div id="prk_mobile_bar_scroller">
	            <div id="prk_mobile_bar_inner" class="<?php echo esc_attr($prk_hook_options['right_bar_align']); ?>">
	                <?php
	                    if ($prk_hook_options['append_mobile_logo']=="mobile_logo_bef") {
	                        $hook_retina_device=hook_retiner(false);
	                        if ($hook_retina_device==true && isset($prk_hook_options['logo_retina']) && $prk_hook_options['logo_retina']['url']!="") {
	                            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_retina']['url'],2);
	                            ?>
	                                <div id="hook_mobile_logo">
	                                    <img src="<?php echo esc_url($prk_hook_options['logo_retina']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_retina']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_retina']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
	                            <?php
	                        }
	                        else {
	                            if (isset($prk_hook_options['logo']) && $prk_hook_options['logo']['url']!="") {
	                                $hook_logo_dims=hook_dimensions($prk_hook_options['logo']['url'],1);
	                                ?>
	                                    <div id="hook_mobile_logo">
	                                        <img src="<?php echo esc_url($prk_hook_options['logo']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
	                                <?php
	                            }
	                        }
	                    }
	                    else if ($prk_hook_options['append_mobile_logo']=="mobile_logo_aft") {
	                        $hook_retina_device=hook_retiner(false);
	                        if ($hook_retina_device==true && isset($prk_hook_options['logo_collapsed_retina']) && $prk_hook_options['logo_collapsed_retina']['url']!="")  {
		                        $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed_retina']['url'],2);
		                        ?>
		                            <div id="hook_mobile_logo">
		                                <img src="<?php echo esc_url($prk_hook_options['logo_collapsed_retina']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed_retina']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_collapsed_retina']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
		                        <?php
		                    }
		                    else {
		                        if (isset($prk_hook_options['logo_collapsed']) && $prk_hook_options['logo_collapsed']['url']!="") {
		                            $hook_logo_dims=hook_dimensions($prk_hook_options['logo_collapsed']['url'],1);
		                            ?>
		                                <div id="hook_mobile_logo">
		                                    <img src="<?php echo esc_url($prk_hook_options['logo_collapsed']['url']); ?>" alt="<?php echo esc_attr(hook_alt_tag(false,$prk_hook_options['logo_collapsed']['url'])); ?>" data-width="<?php echo esc_attr($prk_hook_options['logo_collapsed']['width']); ?>" <?php echo hook_output().$hook_logo_dims; ?> /></div>
		                            <?php
		                        }
		                    }
	                    }
	                    ?>
	                    <div id="wf_mobile_header">
                    		<div id="wf_mobile_donate">
                    			<a href="#">DONATE</a>
                    		</div>
                    		<div id="wf_mobile_loupe">
                    			<i class="hook_fa-search hook_fa-flip-horizontal"></i>
                    		</div>
                    		<div id="wf_mobile_close">
                    			<i class="hook_fa-times"></i>
                    		</div>
	                    </div>
	                    <?php
	                    //MOBILE MENU
	                    if ($prk_hook_options['menu_display']!="st_without_menu") {
	                        ?>
	                        <div class="header_stack prk_mainer">
	                            <?php
	                                if (isset($page_id) && get_post_meta($page_id,'top_menu',true)!="" && get_post_meta($page_id,'top_menu',true)!="null") {
	                                        wp_nav_menu(array(
	                                            'menu' => get_post_meta($page_id,'top_menu',true),  
	                                            'menu_class' => 'mobile-menu-ul '.$prk_hook_options['menu_font'],
	                                            'link_after' => '',
	                                            'walker' => new rc_scm_walker)
	                                        );
	                                }
	                                else {
	                                    if (has_nav_menu('prk_mobile_navigation')) {
	                                        wp_nav_menu(array(
	                                            'theme_location' => 'prk_mobile_navigation', 
	                                            'menu_class' => 'mobile-menu-ul '.$prk_hook_options['menu_font'],
	                                            'link_after' => '',
	                                            'walker' => new rc_scm_walker)
	                                        );
	                                    }
	                                }
	                            ?>
	                        </div>
	                        <div class="clearfix"></div>
	                        <?php
	                    }
	                    if (is_active_sidebar('sidebar-mobile')) {
	                        echo '<div id="hook_mobile_sidebar" class="header_stack">';
	                        if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-mobile')) : 
	                        endif;
	                        echo '</div>';
	                    }
	                ?>
	            </div>
	        </div>
	    </div>
	    <?php
	}

	add_action( 'init', 'wf_scodes' );

	function wf_scodes() {
		//LAST CPT's
		function pirenko_last_cpts_shortcode( $atts, $content = null ) {
			$prk_hook_options=hook_options();
			$prk_translated=$prk_hook_options;
			$hook_retina_device=hook_retiner(false);
			$atts=shortcode_atts(array(
				'images' => '',
				'cpt' => 'post',
				'items_number' => '3',
				'cols_number' => '3',
				'layout_type_folio' => 'text_under',
				'category' => '',
			), $atts);
			if ($atts['thumbs_low_type']=="")
				$atts['thumbs_low_type']="hook_low_both";
			if ($atts['thumbs_roll_type']=="")
				$atts['thumbs_roll_type']="hook_roll_both";
	        switch ($atts['cols_number']) {
	            case '5':
	                $col_width="20";
	            break;
	            case '4':
	                $col_width="25";
	            break;
	            default:
	            	$col_width="100";
	            break;
	        }
			$slider_class="";
			if ($atts['layout_type_folio']=="text_aside") {
				$slider_class="owl-carousel hook_shortcode_slider anim-fade per_init";
			}
			wp_reset_query();
			$my_home_query = new WP_Query();
			if ($atts['cpt']=="grant") {
				$args = array(
					'post_type' => $atts['cpt'],
					'showposts' => $atts['items_number'],
				);
			}
			else {
				$args = array(
					'post_type' => $atts['cpt'],
					'showposts' => $atts['items_number'],
					'subject'	=> $atts['category'],
				);
			}
			$my_home_query->query($args);
			if ($my_home_query->have_posts()) {
				$rand_nbr=rand(1, 5000);
				$out = '';
	            $out.='<div class="small-12 hook_cpts hook-'.$atts['layout_type_folio'].' '.$atts['thumbs_roll_type'].' '.$atts['thumbs_low_type'].' cpt-'.$atts['cpt'].'">';
		                $out.='<div id="hook_cpt-'.$rand_nbr.'" class="'.$slider_class.'" data-columns="'.$cols_number.'" data-margin='.$thumbs_mg.'" data-autoplay="false" data-navigation="true" data-pagination="false" data-delay="5000" data-anim="fade">';
		                	$ins=0;
		                	$alt_flag=true;
	                        while ($my_home_query->have_posts()) : $my_home_query->the_post();
	                        	if ($atts['layout_type_folio']=="text_aside") {
	                        		if (has_post_thumbnail()) {
	                        			$image=wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
	                        			$out.='<div class="item">';
			                        		$out.='<div id="hook-'.rand(1, 100000).'" class="small-12 hook_super_width wpb_row vc_row-o-equal-height vc_row-flex vc_row hook_row vc_row-fluid">';
			                        			$out.='<div class="hook_outer_row">';
					                        		$out.='<div class="row">';
						                        		$out.='<div class="vc_col-sm-6 columns vc_column_container">';
						                        			$out.='<div class="wpb_wrapper" style="padding-left:12.5%;padding-right:12.5%;margin-left:auto;margin-right:auto;">';
						                        				$out.='<div class="hook_spacer clearfix" style="height:118px;"></div>';
						                        				$out.='<div class="prk_shortcode-title prk_break_word hook_left_align h4_sized"><div class="header_font zero_color prk_vc_title" style="margin-bottom:18px;"><h4 style="font-weight:600;">'.get_the_title().'</h4></div><div class="clearfix"></div></div>';
						                        				$out.='<div class="wpb_text_column wpb_content_element zero_color" style="margin-bottom:26px;">';
						                        					$out.='<div class="wpb_wrapper">';
						                        						$out.=get_the_excerpt();
						                        					$out.='</div>';
						                        				$out.='</div>';
						                        				$out.='<div class="hook_spacer clearfix" style="height:178px;"></div>';
						                        			$out.='</div>';
					                        			$out.='</div>';
					                        			$out.='<div class="vc_col-sm-6 columns vc_column_container" style="background-image:url('.$image[0].');">';
					                        					$out.='<div class="wpb_wrapper"></div>';
					                        			$out.='</div>';
					                        		$out.='</div>';
				                        		$out.='</div>';
			                        		$out.='</div>';
			                        	$out.='</div>';
	                        		}
	                        	} 
	                        	else {
		                        	if (has_post_thumbnail()) {
		                                $magnific_image=$image=wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
										$extra_mfp="";
										$extra_style="";
										if (get_field('featured_color',$my_home_query->post->ID)!="") {
											$extra_style=' style="background-color:'.get_field('featured_color',$my_home_query->post->ID).';"';
										}
		                                $out.='<div class="hook_cpt prk_lf" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'" style="width:'.$col_width.'%;">';
		                                    $out.='<div class="grid_image_wrapper">';
		                                    	if ($atts['cpt']!="grant") {
	                                    			$out.='<a href="'.get_permalink().'" data-mfp-src="'.$magnific_image[0].'" data-title="'.get_the_title().'">';
	                                    		}
	                                        		$out.='<div class="hook_cpt_text hook_single_title body_bk_color">';
	                                        		$out.='<h4 class="header_font small">'.get_the_title().'</h4>';
	                                        		if ($atts['cpt']=="grant") {
	                                        			if (get_the_term_list($my_home_query->post->ID,'focus')!="") {
	                                        			    $hook_terms=wp_get_object_terms($my_home_query->post->ID,'focus');
	                                        			    $hook_count=count($hook_terms);
	                                        			    if ($hook_count>0) {
	                                        			        $hook_in_count=0;
	                                        			        $out.='<div><span>Focus: </span><span>';
	                                        			        foreach ( $hook_terms as $hook_term ) {
	                                        			            if ($hook_in_count>0)
	                                        			                $out.=", ";
	                                        			            $out.= $hook_term->name;
	                                        			            $hook_in_count++;
	                                        			        }
	                                        			        $out.='</span></div>';
	                                        			    }
	                                        			}
	                                        		}
	                                        		$out.='</div>';
													$forced_w=480;
													if ($layout_type_folio=="masonry") {
														$forced_h=0;
														$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, false , $hook_retina_device );
													}
													else if ($layout_type_folio=="squares") {
														$forced_h=480;
														$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $hook_retina_device );
													}
													else {
														$forced_h=300;
														$vt_image = vt_resize( '', $image[0] , $forced_w, $forced_h, true , $hook_retina_device );
													}
	                                            	$out.='<img src="'.$vt_image['url'].'" width="'. $vt_image['width'] .'" height="'. $vt_image['height'] .'" />';
	                                            	$out.='<div class="grid_colored_block"'.$extra_style.'></div>';
	                                            if ($atts['cpt']!="grant") {
	                                            	$out.='</a>';
	                                            }
		                                    $out.='</div>';
		                                    $out.='<div class="hook_cpt_text body_bk_color grant_text_box"'.$extra_style.'>';
			                                    $out.='<a href="'.get_permalink().'">';
			                                    	$out.='<div class="hook_lower_title zero_color"><h4 class="header_font small">'.get_the_title().'</h4></div> ';
			                                    $out.='</a>';
			                                    if ($atts['cpt']!="grant") {
			                                    	$out.='<div class="ft_lower_excerpt prk_9_em">'.hook_excerpt_dynamic(85,$my_home_query->post->ID).'</div>';
			                                    }
			                                    else {
			                                    	$out.='<div class="ft_lower_excerpt prk_9_em">'.do_shortcode(get_the_content($my_home_query->post->ID)).'</div>';
			                                    	if (get_field('external_link')!="") {
			                                    		$out.='<a href="'.get_field('external_link').'">';
			                                    	}
			                                    	else {
			                                    		$out.='<a href="'.get_permalink().'">';
			                                    	}
			                                    		$out.='<div class="hook_anchor prk_lf prk_heavier_700">Read More →</div> ';
			                                    	$out.='</a>';
			                                    }
			                                $out.='</div>';
		                                $out.='</div>';
		                                $ins++;
		                        	}
		                        }
	                        endwhile;
		            $out.='</div>';
				$out.='</div>';
				$out.='<div class="clearfix"></div>';
	       	}
	        else
	        {
				$out.= '<h2 class="hook_shortcode_warning">No content was found!</h2>';		
			}
			wp_reset_query();
			return $out;
		}
		add_shortcode('pirenko_last_cpts', 'pirenko_last_cpts_shortcode');
	}
	function pirenko_last_posts_shortcode( $atts, $content=null ) {
		$prk_hook_options=hook_options();
		$hook_retina_device=hook_retiner(false);
		$hook_translated=scodes_translate();
		extract(shortcode_atts(array(
			'title'    	 => '',
			'items_number'		 => '',
			'rows_number'		 => '',
			'cat_filter'	=> '',
			'css_animation' => '',
			'el_class' => ''
		), $atts));
		if (isset($atts['title']) && $atts['title']!="")
			$title=$atts['title'];
		else
			$title="";
		if (isset($atts['items_number']) && $atts['items_number']!="")
			$items_number=$atts['items_number'];
		else
			$items_number="3";
		if (isset($atts['rows_number']) && $atts['rows_number']!="")
			$rows_number=$atts['rows_number'];
		else
			$rows_number="1";
		if (isset($atts['cat_filter']) && $atts['cat_filter']!="")
			$cat_filter=$atts['cat_filter'];
		else
			$cat_filter="";
		if (isset($atts['bg_color']) && $atts['bg_color']!="")
			$bg_color=' style="background-color:'.$atts['bg_color'].'"';
		else
			$bg_color="";
		if (isset($atts['general_style']) && $atts['general_style']!="")
			$general_style=$atts['general_style'];
		else
			$general_style="classic";
		wp_reset_query();
		$custom_query=new WP_Query();
		if (isset($atts['not_in'])) {
			$args=array (	
				'post_type=posts', 
				'showposts' => $items_number,
				'category_name'=>$cat_filter,
				'post__not_in' => array($atts['not_in']),
				'orderby' => 'rand',
			);
		}
		else {
			$args=array (	
				'post_type=posts', 
				'showposts' => $items_number,
				'category_name'=>$cat_filter,
			);
		}
		$custom_query->query($args);
		$cols_number=floor($items_number/$rows_number);
		$columnizer=floor(12/$cols_number);
		$rand_nbr=rand(1, 500);
		$i=0;
		$out='';
		if ($custom_query->have_posts()) {
			if ($cols_number>=$custom_query->post_count) 
				$main_classes="";
			else
				$main_classes=" extra_spaced";
			if (isset($atts['css_animation']) && $atts['css_animation']!="") {
				$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
			}
			if (isset($atts['css_delay']) && $atts['css_delay']!="") {
		    	$main_classes.=" delay-".$atts['css_delay'];
		    }
			if (isset($atts['el_class']) && $atts['el_class']!="") {
				$main_classes.=" ".$atts['el_class'];
			}
			if ($general_style=="slider") {
	            $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_shortcode'.$main_classes.'">';
	                $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_slider per_init hook_no_nbr" data-navigation="true">';
	                    while ($custom_query->have_posts()) : $custom_query->the_post();
	                    if ($i<$items_number)
	                    {
                            if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
		                  	{
		                    	$featured_color=get_field('featured_color');
		                    	$featured_class=" featured_color";
		                  	}
		                  	else
		                  	{
		                  		$featured_color="default";
		                    	$featured_class="";
		                  	}
		                	$out.='<div class="blog_entry_li item clearfix'.$featured_class.'" data-color="'.$featured_color.'">';
		                	$out.='<div class="masonry_inner">';
		                	if (has_post_thumbnail())
							{
								$image=wp_get_attachment_image_src(get_post_thumbnail_id(),'');
		                    	$out.='<a href="'.get_permalink().'" class="fade_anchor blog_hover">';
		                            $out.='<div class="masonr_img_wp">';
		                            	$out.='<div class="blog_fader_grid">';
	                                    	    $out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
	                                    	$out.='</div>';
		                                $hook_vt_image=vt_resize( '', $image[0] , 700 , 700, true , $hook_retina_device );
		                                $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" class="custom-img grid_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id()).'" />';
		                            $out.='</div>';
		                        $out.='</a>';
							}
							else
							{
								//CHECK IF THERE'S A VIDEO TO SHOW
		                       	if (get_field('video_2')!="")
		                        {
		                        	$out.= "<div class='video-container'>";
		                           	$out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
									$out.= "</div>";
		                      	}
							}
							$out.='<div class="header_font prk_mini_meta small">';
                            $out.='<div class="entry_title prk_lf">';
                            $out.='<h5 class="prk_heavier_600 big">';
                                $out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.$featured_color.'">';
                                $out.=get_the_title();
                                $out.='</a>';
                            $out.='</h5>';
                            $out.='</div>';
                            $out.='<div class="clearfix"></div>';
                            $out.='<div class="hook_blog_uppercased prk_heavier_600 hook_blog_meta prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                            $hook_divide_me=false;
                            if (is_sticky()) {
                                $out.='<div class="prk_lf hook_sticky not_zero_color">';
                                $out.=$hook_translated['sticky_text'];
                                $out.='</div>';
                                $hook_divide_me=true;
                            }
                            if ($prk_hook_options['show_date_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }
                                
                                $out.='<div class="prk_lf">';
                                $out.=get_the_time(get_option('date_format'));
                                $out.='</div>';
                            }
                            if ($prk_hook_options['postedby_blog']=="1") {
                                if ($hook_divide_me==false) {
                                    $hook_divide_me=true;
                                }
                                else {
                                    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                }
                                $out.='<div class="hook_anchor prk_lf hook_colored_link">';
                                $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                                $out.='</div>';
                            }
                            $out.='</div>';
                            $out.='</div>';
                            $out.='<div class="clearfix wf_trick"></div>'; 
                    		$out.='<div class="on_colored prk_break_word entry_content">';
                    			$out.='<div class="wpb_text_column">';
                    				$cat_helper=$custom_query->post->ID;
									$out.=hook_excerpt_dynamic(18,$custom_query->post->ID);
									$out.='<div class="clearfix"></div>';
									$out.='<div class="fade_anchor prk_lf">';
                                        $out.='<a href="'.get_permalink().'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
                                            $out.=$hook_translated['read_more'].' &rarr;';
                                        $out.='</a>';
                                    $out.='</div>'; 
								$out.='</div>';
							$out.='</div>';
							$out.='<div class="simple_line hide_now"></div>';
							/*$out.='<div class="blog_lower prk_bordered_top prk_heavier_600 header_font prk_75_em small_headings_color hook_blog_uppercased">';
                                $out.='<div class="small-12">';
                                        if ($prk_hook_options['categoriesby_blog']=="1")
                                        {
                                            $out.='<div class="prk_lf hook_anchor">';
                                                $out.='<div class="prk_lf blog_categories">';
                                                    $arra=get_the_category($custom_query->post->ID);
                                                    if(!empty($arra)) {
                                                        $count_cats=0;
                                                        foreach($arra as $s_cat) 
                                                        {
                                                            if ($count_cats>0)
                                                                $out.=', ';
                                                            $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
                                                            $count_cats++;
                                                        }
                                                    }
                                                $out.='</div>';
                                            $out.='</div>';
                                        }
                                        if ($prk_hook_options['postedby_blog']=="1") {
                                            if (function_exists('get_avatar')) { 
                                                $out.='<div class="prk_author_avatar prk_lf">';
                                                $out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                                                if (get_the_author_meta('prk_author_custom_avatar')!="") {
                                                    $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                                                    $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                                                }
                                                else {
                                                	if (get_avatar(get_the_author_meta('email'),'216')) {
                                                	    $out.=get_avatar(get_the_author_meta('email'),'216');
                                                	}
                                                }
                                                $out.='</a>';
                                                $out.='</div>';
                                            }
                                            $out.='<div class="hook_anchor prk_lf hook_colored_link hook_author">';
                                            $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                                            $out.='</div>';
                                        }
                                        $out.='<div class="prk_rf hook_anchor">';
                                        $out.='<a href="'.get_permalink($cat_helper).'" data-color="'.$featured_color.'">';
                                            $content=get_post_field('post_content',$custom_query->post->ID);
                                            $count=round(str_word_count(strip_tags($content))/200);
                                            if ($count==0)
                                                $count=1;
                                            $out.=$count.' '.$hook_translated['min_read_text'];
                                        $out.='</a>';
                                        $out.='</div>';
                                $out.='</div>';
                                $out.='<div class="clearfix"></div>';
                            $out.='</div>';*/
				            $out.='</div>';
				            $out.='</div>';
	                    }
	                    $i++;
	                    endwhile;
	                $out.='</div>';
	            $out.='</div>';
	        } 
	        if ($general_style=="classic") {
	            $out.='<div id="prk_shortcode_latest_posts_'.rand(1, 500).'" class="recentposts_ul_wp row'.$main_classes.'">';
	                $out.='<div id="recent_blog-'.$rand_nbr.'" class="recentposts_ul_shortcode hook_left_align" data-columns='.$cols_number.' data-rows='.$rows_number.'>';
	                    while ($custom_query->have_posts()) : $custom_query->the_post();
	                    if ($i<$items_number) {
                            $image=wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                            if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
                          	{
                            	$featured_color=get_field('featured_color');
                            	$featured_class=" featured_color";
                          	}
                          	else
                          	{
                          		$featured_color="default";
                            	$featured_class="";
                          	}
                            $out.='<div class="columns small-'.$columnizer.'">';
                            $out.='<div class="blog_entry_li'.$featured_class.'" data-color="'.$featured_color.'">';
								$out.='<div class="masonry_inner">';
	                                if (has_post_thumbnail($custom_query->post->ID)):
	                                    //GET THE FEATURED IMAGE
	                                    $image=wp_get_attachment_image_src( get_post_thumbnail_id( $custom_query->post->ID ), '' );
	                                else :
	                                    //THERE'S NO FEATURED IMAGE
	                                endif; 
	                                if (has_post_thumbnail($custom_query->post->ID)) { 
	                                    $out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.$featured_color.'">';
	                                        $out.='<div class="masonr_img_wp">';
	                                            $out.='<div class="blog_fader_grid centerized_father_blog">';
	                                                $out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
	                                            $out.='</div>';
	                                            $hook_vt_image=vt_resize( get_post_thumbnail_id($custom_query->post->ID), '' , 700, 700, true , $hook_retina_device );
	                                            $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$custom_query->post->ID.'" class="custom-img grid_image" alt="'.hook_alt_tag(true,get_post_thumbnail_id($custom_query->post->ID)).'" />';
	                                        $out.='</div>';
	                                    $out.='</a>';
	                                }
	                                else
	                                {
	                                    //CHECK IF THERE'S A VIDEO TO SHOW
	                                    if (get_field('video_2')!="")
	                                    {
	                                        $el_class='video-container';
	                                        if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
	                                            $el_class= 'soundcloud-container';
	                                        }
	                                        $out.='<div class="'.esc_attr($el_class).'">';
	                                        $out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
	                                        $out.='</div>';
	                                    }
	                                }
	                                $out.='<div class="header_font prk_mini_meta small">';
	                                $out.='<div class="entry_title prk_lf">';
	                                $out.='<h5 class="prk_heavier_600 big">';
	                                    $out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.$featured_color.'">';
	                                    $out.=get_the_title();
	                                    $out.='</a>';
	                                $out.='</h5>';
	                                $out.='</div>';
	                                $out.='<div class="clearfix"></div>';
	                                $out.='<div class="hook_blog_uppercased prk_heavier_600 hook_blog_meta prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
	                                $hook_divide_me=false;
	                                if (is_sticky()) {
	                                    $out.='<div class="prk_lf hook_sticky not_zero_color">';
	                                    $out.=$hook_translated['sticky_text'];
	                                    $out.='</div>';
	                                    $hook_divide_me=true;
	                                }
	                                if ($prk_hook_options['show_date_blog']=="1") {
	                                    if ($hook_divide_me==false) {
	                                        $hook_divide_me=true;
	                                    }
	                                    else {
	                                        $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
	                                    }
	                                    
	                                    $out.='<div class="prk_lf">';
	                                    $out.=get_the_time(get_option('date_format'));
	                                    $out.='</div>';
	                                }
	                                if ($prk_hook_options['categoriesby_blog']=="1") {
	                                	if ($hook_divide_me==false) {
	                                	    $hook_divide_me=true;
	                                	}
	                                	else {
	                                	    $out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
	                                	}
	                                    $out.='<div class="prk_lf hook_anchor">';
	                                        $out.='<div class="prk_lf blog_categories">';
	                                            $arra=get_the_category($custom_query->post->ID);
	                                            if(!empty($arra)) {
	                                                $count_cats=0;
	                                                foreach($arra as $s_cat) 
	                                                {
	                                                    if ($count_cats>0)
	                                                        $out.=', ';
	                                                    $out.='<a href="'.get_category_link( $s_cat->term_id ).'" title="View all posts">'.$s_cat->cat_name.'</a>';
	                                                    $count_cats++;
	                                                }
	                                            }
	                                        $out.='</div>';
	                                    $out.='</div>';
	                                }
	                                $out.='</div>';
	                                $out.='</div>';
	                                $out.='<div class="clearfix wf_trick"></div>';
	                                    $out.='<div class="on_colored entry_content prk_break_word">';
	                                        $out.='<div class="wpb_text_column">';
	                                                $cat_helper=$custom_query->post->ID;
	                                                $out.=hook_excerpt_dynamic(18,$custom_query->post->ID);
	                                            $out.='<div class="hook_anchor prk_lf">';
	                                                $out.='<a href="'.get_permalink($cat_helper).'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
	                                                    $out.=$hook_translated['read_more'].' &rarr;';
	                                                $out.='</a>';
	                                            $out.='</div>';
	                                            $out.='<div class="clearfix"></div>';
	                                        $out.='</div>';
	                                    $out.='</div>';
	                                    $out.='<div class="simple_line hide_now"></div>';
	                                    /*$out.='<div class="blog_lower prk_bordered_top prk_heavier_600 header_font prk_75_em small_headings_color hook_blog_uppercased">';
	                                        $out.='<div class="small-12">';
	                                        		if ($prk_hook_options['postedby_blog']=="1") {
	                                        		    if (function_exists('get_avatar')) { 
	                                        		        $out.='<div class="prk_author_avatar prk_lf">';
	                                        		        $out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
	                                        		        if (get_the_author_meta('prk_author_custom_avatar')!="") {
	                                        		            $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
	                                        		            $out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
	                                        		        }
	                                        		        else {
	                                        		            if (get_avatar(get_the_author_meta('email'),'216')) {
	                                        		                $out.=get_avatar(get_the_author_meta('email'),'216');
	                                        		            }
	                                        		        }
	                                        		        $out.='</a>';
	                                        		        $out.='</div>';
	                                        		    }
	                                        		    $out.='<div class="hook_anchor prk_lf hook_colored_link hook_author">';
	                                        		    $out.=$hook_translated['posted_by_text'].' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
	                                        		    $out.='</div>';
	                                        		}
	                                                $out.='<div class="prk_rf hook_anchor">';
	                                                $out.='<a href="'.get_permalink($cat_helper).'" data-color="'.$featured_color.'">';
	                                                    $content=get_post_field('post_content',$custom_query->post->ID);
	                                                    $count=round(str_word_count(strip_tags($content))/200);
	                                                    if ($count==0)
	                                                        $count=1;
	                                                    $out.=$count.' '.$hook_translated['min_read_text'];
	                                                $out.='</a>';
	                                                $out.='</div>';
	                                        $out.='</div>';
	                                        $out.='<div class="clearfix"></div>';
	                                    $out.='</div>';*/
	                                $out.='</div>';
					            $out.='</div>';
					        $out.='</div>';
	                    }
	                    $i++;
						if ($i%$cols_number==0 && $i<$items_number)
						{
							$out.='<div class="clearfix bt_3x"></div>';
						}
	                    endwhile;
	                $out.='</div>';
	            $out.='</div>';
	        }
       	}
        else
        {
			$out.='<div id="prk_shortcode_latest_posts" class="recentposts_ul_wp small-12">';
                $out.='<div class="shortcode-title">'.$title.'</div>';
                $out.='<div class="simple_line"></div>';
			 $out.= '<h2 class="hook_shortcode_warning">No posts were found!</h2>';	
			 $out.='</div>';	
		}
		wp_reset_query();
		return $out;
	}

	function prk_member_shortcode( $atts, $content=null ) {
		$hook_translated=scodes_translate();
		$prk_hook_options=hook_options();
		$hook_retina_device=hook_retiner(false);
		$atts=shortcode_atts(array(
			'items_number' => '999',
			'category' => 'show_all',
			'columns' =>'3',
			'member_spacing' => 'cl_mode',
			'text_align' => 'hook_center_align',
			'css_delay' =>'',
			'general_style' =>'classic',
			'css_animation' =>'',
			'el_class' =>'',
		),$atts);
		if ($atts['category']=="show_all") {
			$category="";
		}
		else {
			$category=$atts['category'];
		}
		$items_number=$atts['items_number'];
		//DEFAULT VALUES
		$columns=3;
		$main_classes="small-4 columns";
		if ($atts['columns']==1) {
	      $main_classes="small-12 columns";
	  	}
	    if ($atts['columns']==2) {
	      $main_classes="small-6 columns";
	  	}
	    if ($atts['columns']==3) {
	      $main_classes="small-4 columns";
	  	}
	    if ($atts['columns']==4) {
	      $main_classes="small-3 columns";
	  	}
	    if ($atts['columns']==6) {
	      $columns=$atts['columns'];
	  	}
	  	$columns=$atts['columns'];
	  	$hook_forced_w=ceil($prk_hook_options['custom_width']/$atts['columns']);
	  	if ($hook_forced_w<780);
	  		$hook_forced_w=780;
	  	if ($atts['css_animation']!="") {
			$main_classes.=" wpb_animate_when_almost_visible wpb_".$atts['css_animation'];
		}
		if ($atts['css_delay']!="") {
	    	$main_classes.=" delay-".$atts['css_delay'];
	    }
		if ($atts['el_class']!="") {
			$main_classes.=" ".$atts['el_class'];
		}
		$args=array(	
			'post_type' => 'pirenko_team_member',
			'showposts' => $items_number,
			'order_by' => 'menu_order',
			'pirenko_member_group' => $category
		);
		$loop=new WP_Query( $args );
		$out='';
		$i=0;
		$relative=1;
		$general_style=$atts['general_style'];
		if ($general_style=='classic') {
			$out.='<div class="row prk_row">';
			$out.='<ul class="member_ul unstyled '.$atts['member_spacing'].' '.$atts['text_align'].'">';
				$mb_code=$mobile_desc="";
				while ( $loop->have_posts() ) : $loop->the_post();
					if (get_field('member_job')!="")
						$member_job=get_field('member_job');
					else
						$member_job="";
					if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
				    {
				        $featured_color=get_field('featured_color');
				        $featured_class='featured_color';
				    }
				    else
				    {
				        $featured_color="default";
				        $featured_class="";
				    }
				    $wf_pos=$i+1;
					$out.='<li class="'.$main_classes.' sh_member_wrapper" data-color="'.$featured_color.'" data-pos="'.$wf_pos.'">';
						if (get_field('show_member_link')=="1")
						{
							$out.='<div class="member_colored_block hook_linked" data-link="'.get_permalink().'">';
						}
						else
						{
							$out.='<div class="member_colored_block">';
						}
						$out.='<div class="sh_member_desc">';
						if (get_field('member_byline')!="") {
							$out.='<h5 class="header_font sh_member_trg">'.get_field('member_byline').'</h5>';
						}
						else {
							$out.='<h5 class="header_font sh_member_trg">'.get_the_title().'</h5>';
						}
						$out.='<div class="sh_member_trg">';
						//WF
						//$out.=hook_excerpt_dynamic(24,$loop->post->ID);
						$out.='</div>';
						$out.='</div>';
						$out.='<div class="member_colored_block_in">';
						$out.='</div>';
						$out.=wp_get_attachment_image( get_post_thumbnail_id( get_the_ID()), array($hook_forced_w,''),'0' );
						$out.='<div class="hook_member_links">';
						$out.='<div class="hook_member_links_inner">';
						if (get_field('member_email')!="")
						{
						$out.='<div class="member_lnk">';
							$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
								$out.= '<div class="hook_socialink hook_fa-envelope-o">';
                                $out.='</div>';
							$out.=' </a>';
						$out.='</div>';
						}
						if (get_field('member_social_1')!="none" && get_field('member_social_1')!="") {
                            if (get_field('member_social_1_link')!="")
                                $in_link=get_field('member_social_1_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_1')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_1')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if (get_field('member_social_2')!="none" && get_field('member_social_2')!="") {
                            if (get_field('member_social_2_link')!="")
                                $in_link=get_field('member_social_2_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_2')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_2')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if (get_field('member_social_3')!="none" && get_field('member_social_3')!="") {
                            if (get_field('member_social_3_link')!="")
                                $in_link=get_field('member_social_3_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_3')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_3')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if (get_field('member_social_4')!="none" && get_field('member_social_4')!="") {
                            if (get_field('member_social_4_link')!="")
                                $in_link=get_field('member_social_4_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_4')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_4')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if (get_field('member_social_5')!="none" && get_field('member_social_5')!="") {
                            if (get_field('member_social_5_link')!="")
                                $in_link=get_field('member_social_5_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_5')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_5')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        if (get_field('member_social_6')!="none" && get_field('member_social_6')!="") {
                            if (get_field('member_social_6_link')!="")
                                $in_link=get_field('member_social_6_link');
                            else
                                $in_link="";            
                            $out.='<div class="member_lnk">';
                                $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_6')).'">';
                                    $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_6')).'">';
                                    $out.='</div>';
                                $out.='</a>';
                            $out.='</div>';
                        }
                        $out.='</div>';
						$out.='</div>';
						$out.='</div>';
						//WF
						/*$out.='<div class="sh_member_name zero_color header_font">';
						if (get_field('show_member_link')=="1") {
							$out.='<a href="'.get_permalink().'" class="hook_anchor">';
								$out.=get_the_title();
							$out.=' </a>';
						}
						else {
							$out.=get_the_title();
						}
						$out.='</div>';*/
						$mb_code.='<li id="wf_member_desc-'.$wf_pos.'" class="wf_member_desc small-12 hide_now wf_member_desktop"><div><h5 class="prk_heavier_600 header_font zero_color">'.get_the_title().'</h5>'.do_shortcode(get_the_content()).'</div></li>';

						$out.='<div class="clearfix"></div>';
						$out.='<div class="sh_member_function small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
						$out.=$member_job;
						$out.='</div>';								
						$out.='<div class="clearfix"></div>';
					$out.='</li>';
					//MOBILE MODE DESCRIPTION
					$mobile_desc.='<li id="wf_mobile_desc-'.$wf_pos.'" class="wf_member_desc small-12 hide_now wf_member_mobile"><div><h5 class="prk_heavier_600 header_font zero_color">'.get_the_title().'</h5>'.do_shortcode(get_the_content()).'</div></li>';
					$i++;
					if ($i%$columns==2) {
						$out.=$mobile_desc;
						$mobile_desc="";
					}
					if ($i%$columns==0 || $i==$loop->post_count) {
						$out.='<li class="clearfix"></li>';
						$out.=$mb_code;
						$out.='<li class="clearfix"></li>';
						$mb_code="";
					}
				endwhile;
		 	$out.='</ul></div>';
		}
		else {
			$out.='<div class="'.$atts['text_align'].'">';
			$touch_enable="false";
			if (isset($prk_hook_options['touch_enable']) && $prk_hook_options['touch_enable']=="1") {
				$touch_enable="true";
			}
			$out.='<div class="member_ul_slider per_init" data-navigation="true" data-touch='.$touch_enable.'>';
				while ( $loop->have_posts() ) : $loop->the_post();
					if (get_field('member_job')!="")
						$member_job=get_field('member_job');
					else
						$member_job="";
					if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
				    {
				        $featured_color=get_field('featured_color');
				        $featured_class='featured_color';
				    }
				    else
				    {
				        $featured_color="default";
				        $featured_class="";
				    }
					if (has_post_thumbnail( $loop->post->ID ) ){
						//GET THE FEATURED IMAGE
						$hook_vt_image=vt_resize(get_post_thumbnail_id($loop->post->ID), '' ,$hook_forced_w ,0 , false , $hook_retina_device );
						$image_caption=hook_alt_tag(true,get_post_thumbnail_id($loop->post->ID));
					}
					else {
							//THERE'S NO FEATURED IMAGE SO LET'S LOAD A DEFAULT IMAGE
							$image[0]=get_bloginfo('template_directory')."/images/sample/user.png";
							$image_caption=hook_alt_tag(false,$image[0]);
					}
						$out.='<div class="item sh_member_wrapper" data-color="'.$featured_color.'">';
							if (get_field('show_member_link')=="1")
							{
								$out.='<div class="member_colored_block hook_linked" data-link="'.get_permalink().'">';
							}
							else
							{
								$out.='<div class="member_colored_block">';
							}
							$out.='<div class="sh_member_desc">';
							if (get_field('member_byline')!="") {
								$out.='<h4 class="header_font sh_member_trg">'.get_field('member_byline').'</h4>';
							}
							else {
								$out.='<h4 class="header_font sh_member_trg">'.get_the_title().'</h4>';
							}
							$out.='<div class="sh_member_trg">';
							$out.=hook_excerpt_dynamic(24,$loop->post->ID);
							$out.='</div>';
							$out.='</div>';
							$out.='<div class="member_colored_block_in">';
							$out.='</div>';
							$out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.$image_caption.'" />';
							$out.='<div class="hook_member_links">';
							$out.='<div class="hook_member_links_inner">';
							if (get_field('member_email')!="")
							{
							$out.='<div class="member_lnk">';
								$out.='<a href="mailto:'.antispambot(get_field('member_email')).'">';
									$out.= '<div class="hook_socialink hook_fa-envelope-o">';
                                    $out.='</div>';
								$out.=' </a>';
							$out.='</div>';
							}
							if (get_field('member_social_1')!="none" && get_field('member_social_1')!="")
                            {
                                if (get_field('member_social_1_link')!="")
                                    $in_link=get_field('member_social_1_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_1')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_1')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            if (get_field('member_social_2')!="none" && get_field('member_social_2')!="")
                            {
                                if (get_field('member_social_2_link')!="")
                                    $in_link=get_field('member_social_2_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_2')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_2')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            if (get_field('member_social_3')!="none" && get_field('member_social_3')!="")
                            {
                                if (get_field('member_social_3_link')!="")
                                    $in_link=get_field('member_social_3_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_3')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_3')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            if (get_field('member_social_4')!="none" && get_field('member_social_4')!="")
                            {
                                if (get_field('member_social_4_link')!="")
                                    $in_link=get_field('member_social_4_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_4')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_4')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            if (get_field('member_social_5')!="none" && get_field('member_social_5')!="")
                            {
                                if (get_field('member_social_5_link')!="")
                                    $in_link=get_field('member_social_5_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_5')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_5')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            if (get_field('member_social_6')!="none" && get_field('member_social_6')!="")
                            {
                                if (get_field('member_social_6_link')!="")
                                    $in_link=get_field('member_social_6_link');
                                else
                                    $in_link="";            
                                $out.='<div class="member_lnk">';
                                    $out.='<a href="'.$in_link.'" target="_blank" data-color="'.hook_social_color(get_field('member_social_6')).'">';
                                        $out.='<div class="hook_socialink '.hook_social_icon(get_field('member_social_6')).'">';
                                        $out.='</div>';
                                    $out.='</a>';
                                $out.='</div>';
                            }
                            $out.='</div>';
							$out.='</div>';
							$out.='</div>';
							$out.='<div class="sh_member_name zero_color header_font">';
							if (get_field('show_member_link')=="1")
							{
								$out.='<a href="'.get_permalink().'" class="hook_anchor">';
									$out.=get_the_title();
								$out.=' </a>';
							}
							else
							{
								$out.=get_the_title();
							}
							$out.='</div>';
							$out.='<div class="clearfix"></div>';
							$out.='<div class="sh_member_function small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
							$out.=$member_job;
							$out.='</div>';								
							$out.='<div class="clearfix"></div>';
							
						$out.='</div>';
						$i++;
				endwhile;
		 	$out.='</div></div>';
		}
		wp_reset_query();
	  	return $out;
	}
	function wf_selectors_func ($atts, $content=null) {
		//echo get_site_url();
		?>
			<div id="wf_search_archives" class="row">
				<?php
					$count_posts = wp_count_posts();
					$published_posts = $count_posts->publish;
				    /*if (get_query_var('monthnum')=="") {
				        $month_placeholder="Select Month";
				    }
				    else {
				        $monthNum=get_query_var('monthnum');
				        $dateObj=DateTime::createFromFormat('!m', $monthNum);
				        $month_placeholder=$dateObj->format('F')." ".get_query_var('year');
				    }
				    
				    <select id="lc_months" class="wf_custom_select" name="archive-dropdown" data-placeholder="<?php echo $month_placeholder; ?>">
				        <?php wp_get_archives('type=monthly&format=option'); ?>
				    </select>*/
				?>
				<div class="small-4 columns">
					<div class="wf_archive_header prk_heavier_600">CATEGORY</div>
					<select id="lc_cats_select" class="wf_custom_select" name="event-dropdown"  data-placeholder="All">
					    <option value="<?php echo get_site_url(); ?>/news/">ALL (<?php echo $published_posts; ?>)</option>
					 <?php

					  $categories = get_categories(); 
					  foreach ($categories as $category) {
					    $option = '<option value="'.get_site_url().'/category/'.$category->category_nicename.'">';
					    $option .= $category->cat_name;
					    $option .= ' ('.$category->category_count.')';
					    $option .= '</option>';
					    echo $option;
					  }
					 ?>
					</select>
				</div>
				<div class="small-4 columns">
					<div class="wf_archive_header prk_heavier_600">DATE</div>
					<?php
						//data-placeholder="<?php if (get_query_var('year')=="") {echo "Select Year";}else {echo get_query_var('year');}
					?>
					<select id="lc_years" class="wf_custom_select" name="archive-dropdown" data-placeholder="All">
						<option value="<?php echo get_site_url(); ?>/news/">ALL (<?php echo $published_posts; ?>)</option>
					    <?php wp_get_archives('type=yearly&format=option&show_post_count=true'); ?>
					</select>
				</div>
				<div class="small-4 columns">
					<div class="wf_archive_header hook_invsbl prk_heavier_600">SEARCH</div>
					<?php $hook_translated=hook_translations(); ?>
						<form method="get" class="form-search hook_searchform" action="<?php echo esc_url(home_url('/')); ?>" data-url="<?php echo esc_url(hook_clean_url()); ?>">
							<div class="hook_swrapper">
						  		<input type="text" value="" name="s" id="hook_search" class="search-query pirenko_highlighted prk_heavier_500" placeholder="<?php echo esc_attr($hook_translated['search_tip_text']); ?>" />
						      <div class="colored_theme_button">
						        <input type="submit" id="searchsubmit" value="<?php echo esc_attr( 'GO', 'submit button' ); ?>" />
						      </div>
						  		<div class="hook_lback per_init">
						  			<i class="hook_fa-search"></i>
						  		</div>
						    </div>
						</form>
				</div>
			</div>
	    <?php
	    return '';
	}
	add_shortcode('wf_selectors', 'wf_selectors_func');
?>