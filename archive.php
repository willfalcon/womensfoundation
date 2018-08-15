<?php
get_header();
$hook_nav_type="ajaxed";
$hook_layout_type="masonry";
wp_reset_postdata();
//APPLY FILTERS FOR CATEGORY IF NEEDED
$hook_cat_selector="";
if (get_query_var('cat')!="") {
    $hook_cat=get_category(get_query_var('cat'));
    if (!($hook_cat)!=1)
    {
        $hook_cat_selector=$hook_cat->slug;
    }
}
//APPLY FILTERS FOR TAG IF NEEDED     
$hook_tag_selector="";
$hook_tag_name=get_query_var('tag');
if ($hook_tag_name!="") {
    $hook_tag_selector=$hook_tag_name;
}
$hook_paged=(get_query_var('paged')) ? get_query_var('paged') : 1;
$hook_post_counter=($hook_paged-1)*$posts_per_page;
$hook_month_num=(get_query_var('monthnum')) ? get_query_var('monthnum') : "";
$hook_year_num=(get_query_var('year')) ? get_query_var('year') : "";
if ($hook_paged>1) {
    $hook_excluder=get_option("sticky_posts");
}
else {
    $hook_excluder="";
}
$hook_query_args=array( 
    'post_type'=>'post',
    'paged' => $hook_paged,
    'category_name'=>$hook_cat_selector,
    'posts_per_page'=>9999,
    'tag'=>$hook_tag_name,
    'year'=>$hook_year_num,
    'monthnum'=>$hook_month_num
    );
$hook_query=new WP_Query();
$hook_query->query($hook_query_args);
//MASONRY LAYOUT
if ($prk_hook_options['archives_type']=="masonry") {
    $hook_show_sidebar=$prk_hook_options['right_sidebar'];
    if ($hook_show_sidebar=="1")
        $hook_show_sidebar=true;
    else
        $hook_show_sidebar=false;
    if (get_field('show_sidebar')=="yes") {
        $hook_show_sidebar=true;
    }
    //WF
    $hook_show_sidebar=false;
    if (get_field('show_sidebar')=="no") {
        $hook_show_sidebar=false;
    }
    $hook_show_title=true;
    if (get_field('hide_title')=="1") {
        $hook_show_title=false;
    }
    $hook_show_slider=get_field('featured_slider');
    if (get_field('featured_slider_autoplay')=="1")
      $hook_autoplay="true";
  else
      $hook_autoplay="false";
  $hook_delay=get_field('featured_slider_delay');
  if (get_field('featured_slider_supersize')=="1")
      $hook_fill_height="super_height";
  else
      $hook_fill_height="";
  if (get_field('featured_slider_arrows')=="1")
      $hook_navigation="true";
  else
      $hook_navigation="false";
  if (get_field('featured_slider_parallax')=="1")
      $hook_parallax="owl_parallaxed";
  else
      $hook_parallax="owl_regular";
  if (get_field('featured_slider_dots')=="1")
      $hook_pagination="true";
  else
      $hook_pagination="false";
  $hook_inside_filter="";
  if (get_field('slide_filter')!="") {
      $hook_filter=get_field('slide_filter');
      foreach ($hook_filter as $hook_child)
      {
        $hook_inside_filter.=$hook_child->slug.", ";
    }
}
if (get_field('featured_header')=="1") {
    $hook_featured_style='';
}
else {
    $hook_featured_style=' hook_forced_menu';
}
?>
<div id="hook_ajax_inner" class="page-prk-blog-masonry<?php echo esc_attr($hook_featured_style); ?>"> 
    <div id="hook_content">
        <?php
        if ($hook_show_title==true) {
            $hook_uppercase="";
            if (get_field('uppercase_title')=="1") {
                $hook_uppercase=" uppercased_title";
            }
            echo '<div id="classic_title_wrapper">';
            echo '<div id="classic_title_container">';
            echo '<div class="small-12 small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
            hook_output_title();
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        else {
            wp_reset_postdata();
            if ($hook_show_slider=="yes") {
                echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
                echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
                echo '</div>';
          }
          if ($hook_show_slider=="revolution") {
              echo '<div class="prk_rv">'; 
              echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
              echo '</div><div id="mobile_sizer"></div>';
          }
          if (get_the_content()!=="" && is_page()==true) {
            while (have_posts()) : the_post();
            if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                echo '<div id="s_sec_inner" class="row">';
                the_content();
                echo '</div>';
            }
            else {
                echo '<div class="row">'; 
                if (HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                    echo '</div>';
                }
                else {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix bt_2x"></div>';
            }
            endwhile;
        }
    }
    ?>
    <div id="hook_content_inner">
        <div class="small-12 small-centered columns row <?php if (true) {echo "prk_inner_block";}else{echo "hook_unblog";} ?>">
            <?php
            if ($hook_show_title==true) {
                wp_reset_postdata();
                if ($hook_show_slider=="yes") {
                  echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
                  echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
                  echo '</div>';
              }
              if ($hook_show_slider=="revolution") {
                  echo '<div class="prk_rv">'; 
                  echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
                  echo '</div><div id="mobile_sizer"></div>';
              }
              if (get_the_content()!=="" && is_page()==true) {
                while (have_posts()) : the_post();
                if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                else {
                    echo '<div class="row">'; 
                    if (HOOK_VC_ON==true) {
                        echo '<div id="s_sec_inner" class="row">';
                        echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                        echo '</div>';
                    }
                    else {
                        echo '<div id="s_sec_inner" class="row">';
                        the_content();
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="clearfix bt_2x"></div>';
                }
                endwhile;
            }
        }
        if ($hook_show_sidebar==true) {
            echo '<div class="row">';
            echo '<div class="small-9 columns prk_bordered_right prk_extra_r_pad">';
        }
        else {
            echo '<div class="hook_wider">';
        }
        wp_reset_postdata();
        echo do_shortcode('[wf_selectors]');
        if (is_page()) {
            if(is_front_page()) {
                $hook_paged=(get_query_var('page')) ? get_query_var('page') : 1;
            }
            else { 
                $hook_paged=(get_query_var('paged')) ? get_query_var('paged') : 1;
            }
            $hook_query=new WP_Query();
            $hook_inside_filter="";
            if (get_field('blog_filter')!="") {
                $hook_filter=get_field('blog_filter');
                foreach ($hook_filter as $hook_child) {
                    $hook_inside_filter.=$hook_child->slug.", ";
                }
            }
            $hook_page_title=get_the_title();
            $hook_nav_type=get_field('navigation_type');
            if ($hook_nav_type=="ajaxed") {
                $hook_query_number="999";
            }
            else {
                $hook_query_number=get_query_var('posts_per_page');
            }
            $posts_per_page=get_query_var('posts_per_page');
            $hook_query_args=array( 
                'post_type' => 'post', 
                'paged'=>$hook_paged,
                'category_name'=>$hook_inside_filter,
                'posts_per_page' => $hook_query_number,
                );
            $hook_query->query($hook_query_args);
        }
        if ($hook_query->have_posts()) : 
            $hook_post_counter=1;
        $hook_stop_flag=true;
        if (get_field('thumbs_margin')!="") {
            $hook_thumbs_margin=get_field('thumbs_margin');
        }
        else {
            $hook_thumbs_margin=18;
        }
        $hook_out='<div class="row" data-items="'.esc_attr($posts_per_page).'">';
        $hook_terms=get_terms("category");
        $hook_count=count($hook_terms);
        if (get_field('show_filter')=="1") {
            $hook_filter_array=explode(",",$hook_inside_filter);
            $hook_filter_array=array_filter(array_map('trim', $hook_filter_array));
            $hook_out.='<div class="filter_blog">';
            $hook_out.='<div class="hook_blog_filter '.esc_attr(get_field('filter_align')).'">';
            $hook_out.='<ul class="header_font hook_blog_uppercased clearfix small_headings_color prk_heavier_600">';
            $hook_out.='<li class="active small b_filter">';
            $hook_out.='<a class="all" data-filter="b_all" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($hook_translated['all_text']).'</a>';
            $hook_out.='</li>';
            if ($hook_count > 0) {
                foreach ( $hook_terms as $term ) {
                    if (in_array($term->slug, $hook_filter_array) !== false || $hook_inside_filter=="")
                        $hook_out.='<li class="small b_filter"><a class="'.$term->slug.'" data-filter="'.$term->slug.'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.$term->name.'</a></li>';
                }
            }
            $hook_out.='</ul>';
            $hook_out.='</div>';
            $hook_out.='</div>';
        }
        //WF
        $hook_out.='<div class="recentposts_ul_shortcode per_init prk_section clearfix">';
        $hook_out.='<div class="grid-sizer"></div>';
        while ($hook_query->have_posts()) : $hook_query->the_post();
        if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
            $hook_featured_color=get_field('featured_color');
            $hook_featured_class=" featured_color ";
        }
        else {
            $hook_featured_color="default";
            $hook_featured_class="";
        }
        if (!has_post_thumbnail($post->ID) && get_field('video_2')=="") {
            $hook_featured_class.=" hook_no_img";
        } 
        $hook_category=get_the_category();
        $hook_filters=" b_all";
        foreach($hook_category as $inner) { 
            $hook_filters.=" ".$inner->slug;
        }
        if ($hook_post_counter<=$posts_per_page) {
            $hook_out.='<div class="columns small-3">';
            $hook_out.='<div id="post-'.$post->ID.'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint clearfix'.esc_attr($hook_featured_class.$hook_filters).'" data-id="id-'.esc_attr($hook_post_counter).'" data-color="'.esc_attr($hook_featured_color).'">';
            $hook_out.='<div class="masonry_inner">';
            if (has_post_thumbnail($post->ID)) {
                $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
                $hook_out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="masonr_img_wp">';
                $hook_out.='<div class="blog_fader_grid centerized_father_blog">';
                $hook_out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
                $hook_out.='</div>';
                    $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , 700, 700, true , $hook_retina_device );
                    $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$post->ID.'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                    $hook_out.='</div>';
                    $hook_out.='</a>';
                }
                else {
                    if (get_field('video_2')!="")
                    {
                        $hook_el_class='video-container';
                        if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                            $hook_el_class= 'soundcloud-container';
                        }
                        $hook_out.='<div class="'.esc_attr($hook_el_class).'">';
                        $hook_out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
                        $hook_out.='</div>';
                    }
                }
                $hook_out.='<div class="hook_inn_wf">';
                $hook_out.='<div class="header_font prk_mini_meta small">';
                $hook_out.='<div class="entry_title prk_lf">';
                $hook_out.='<h5 class="prk_heavier_600 big">';
                $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.=get_the_title();
                $hook_out.='</a>';
                $hook_out.='</h5>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='<div class="hook_blog_meta prk_75_em hook_blog_uppercased prk_heavier_600 small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                $hook_divide_me=false;
                if (is_sticky()) {
                    $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
                    $hook_out.=esc_attr($hook_translated['sticky_text']);
                    $hook_out.='</div>';
                    $hook_divide_me=true;
                }
                if ($prk_hook_options['show_date_blog']=="1") {
                    if ($hook_divide_me==false) {
                        $hook_divide_me=true;
                    }
                    else {
                        $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                    }

                    $hook_out.='<div class="prk_lf">';
                    $hook_out.=get_the_time(get_option('date_format'));
                    $hook_out.='</div>';
                }
                if ($prk_hook_options['categoriesby_blog']=="1") {
                    if ($hook_divide_me==false) {
                        $hook_divide_me=true;
                    }
                    else {
                        $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                    }
                    $hook_out.='<div class="prk_lf hook_anchor">';
                    $hook_out.='<div class="prk_lf blog_categories">';
                    $hook_arra=get_the_category($post->ID);
                    if(!empty($hook_arra)) {
                        $hook_count_cats=0;
                        foreach($hook_arra as $hook_s_cat) {
                            if ($hook_count_cats>0)
                                $hook_out.=', ';
                            $hook_out.='<a href="'.get_category_link($hook_s_cat->term_id).'" title="View all posts">'.$hook_s_cat->cat_name.'</a>';
                            $hook_count_cats++;
                        }
                    }
                    $hook_out.='</div>';
                    $hook_out.='</div>';
                }
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='<div class="on_colored entry_content prk_break_word">';
                $hook_out.='<div class="wpb_text_column">';
                $hook_cat_helper=$post->ID;
                $hook_out.=hook_excerpt_dynamic(18,$post->ID);
                $hook_out.='<div class="hook_anchor prk_lf">';
                    $hook_out.='<a href="'.get_permalink($cat_helper).'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
                        $hook_out.=$hook_translated['read_more'].' &rarr;';
                    $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                /*$hook_out.='<div class="blog_lower prk_bordered_top header_font prk_75_em small_headings_color hook_blog_uppercased prk_heavier_600">';
                $hook_out.='<div class="small-12">';
                if ($prk_hook_options['postedby_blog']=="1") {
                    if (function_exists('get_avatar')) { 
                        $hook_out.='<div class="prk_author_avatar prk_lf">';
                        $hook_out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                        if (get_the_author_meta('prk_author_custom_avatar')!="") {
                            $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                            $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                        }
                        else {
                            if (get_avatar(get_the_author_meta('email'),'216')) {
                                $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                            }
                        }
                        $hook_out.='</a>';
                        $hook_out.='</div>';
                    }
                    $hook_out.='<div class="hook_anchor prk_lf hook_colored_link">';
                    $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                    $hook_out.='</div>';
                }
                $hook_out.='<div class="prk_rf hook_anchor">';
                $hook_out.='<a href="'.get_permalink($hook_cat_helper).'" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_content=get_post_field('post_content',$post->ID);
                $hook_count=round(str_word_count(strip_tags($hook_content))/200);
                if ($hook_count==0)
                    $hook_count=1;
                $hook_out.=esc_attr($hook_count.' '.$hook_translated['min_read_text']);
                $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='</div>';*/
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
            }
            else if ($hook_nav_type=='ajaxed') {
                if ($hook_stop_flag==true) {
                    $hook_out.='</div>';
                    $hook_out.='<div class="blog_appender hide_now">';
                    $hook_stop_flag=false;
                }
                $hook_out.='<div class="columns small-3">';
                $hook_out.='<div id="post-'.$post->ID.'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint clearfix'.esc_attr($hook_featured_class.$hook_filters).'" data-id="id-'.esc_attr($hook_post_counter).'" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="masonry_inner">';
                if (has_post_thumbnail($post->ID)) {
                    $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
                    $hook_out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.esc_attr($hook_featured_color).'">';
                    $hook_out.='<div class="masonr_img_wp">';
                    $hook_out.='<div class="blog_fader_grid centerized_father_blog">';
                    $hook_out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
                    $hook_out.='</div>';
                    $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , 700, 700, true , $hook_retina_device );
                    $hook_out.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$post->ID.'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                    $hook_out.='</div>';
                    $hook_out.='</a>';
                }
                else {
                    if (get_field('video_2')!="") {
                        $hook_el_class='video-container';
                        if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                            $hook_el_class='soundcloud-container';
                        }
                        $hook_out.='<div class="'.esc_attr($hook_el_class).'">';
                        $hook_out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
                        $hook_out.='</div>';
                    }
                }
                $hook_out.='<div class="hook_inn_wf">';
                $hook_out.='<div class="header_font prk_mini_meta small">';
                $hook_out.='<div class="entry_title prk_lf">';
                $hook_out.='<h4 class="prk_heavier_600 big">';
                $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.=get_the_title();
                $hook_out.='</a>';
                $hook_out.='</h4>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='<div class="hook_blog_meta prk_75_em hook_blog_uppercased prk_heavier_600 small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
                $hook_divide_me=false;
                if (is_sticky()) {
                    $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
                    $hook_out.=esc_attr($hook_translated['sticky_text']);
                    $hook_out.='</div>';
                    $hook_divide_me=true;
                }
                if ($prk_hook_options['show_date_blog']=="1") {
                    if ($hook_divide_me==false) {
                        $hook_divide_me=true;
                    }
                    else {
                        $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                    }

                    $hook_out.='<div class="prk_lf">';
                    $hook_out.=get_the_time(get_option('date_format'));
                    $hook_out.='</div>';
                }
                if ($prk_hook_options['categoriesby_blog']=="1") {
                    if ($hook_divide_me==false) {
                        $hook_divide_me=true;
                    }
                    else {
                        $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                    }
                    $hook_out.='<div class="prk_lf hook_anchor">';
                    $hook_out.='<div class="prk_lf blog_categories">';
                    $hook_arra=get_the_category($post->ID);
                    if(!empty($hook_arra)) {
                        $hook_count_cats=0;
                        foreach($hook_arra as $hook_s_cat) {
                            if ($hook_count_cats>0)
                                $hook_out.=', ';
                            $hook_out.='<a href="'.get_category_link($hook_s_cat->term_id).'" title="View all posts">'.$hook_s_cat->cat_name.'</a>';
                            $hook_count_cats++;
                        }
                    }
                    $hook_out.='</div>';
                    $hook_out.='</div>';
                }
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='<div class="on_colored entry_content prk_break_word">';
                $hook_out.='<div class="wpb_text_column">';
                $hook_cat_helper=$post->ID;
                $hook_out.=hook_excerpt_dynamic(18,$post->ID);
                $hook_out.='<div class="hook_anchor prk_lf">';
                    $hook_out.='<a href="'.get_permalink($cat_helper).'" class="prk_heavier_700 zero_color" data-color="'.$featured_color.'">';
                        $hook_out.=$hook_translated['read_more'].' &rarr;';
                    $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='<div class="blog_lower prk_bordered_top header_font prk_75_em small_headings_color hook_blog_uppercased prk_heavier_600">';
                $hook_out.='<div class="small-12">';
                if ($prk_hook_options['postedby_blog']=="1") {
                    if (function_exists('get_avatar')) { 
                        $hook_out.='<div class="prk_author_avatar prk_lf">';
                        $hook_out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                        if (get_the_author_meta('prk_author_custom_avatar')!="") {
                            $hook_vt_image=vt_resize('', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                            $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                        }
                        else {
                            if (get_avatar(get_the_author_meta('email'),'216')) {
                                $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                            }
                        }
                        $hook_out.='</a>';
                        $hook_out.='</div>';
                    }
                    $hook_out.='<div class="hook_anchor prk_lf hook_colored_link">';
                    $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
                    $hook_out.='</div>';
                }
                $hook_out.='<div class="prk_rf hook_anchor">';
                $hook_out.='<a href="'.get_permalink($hook_cat_helper).'" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_content=get_post_field('post_content',$post->ID);
                $hook_count=round(str_word_count(strip_tags($hook_content))/200);
                if ($hook_count==0)
                    $hook_count=1;
                $hook_out.=esc_attr($hook_count.' '.$hook_translated['min_read_text']);
                $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
            }
            $hook_post_counter++;
            endwhile;
            $hook_out.='</div>';
            if ($hook_stop_flag==false) {
                $hook_out.='<div class="outer_load_more">';
                $hook_out.='<div class="blog_load_more theme_button" data-no_more="'.esc_attr($hook_translated['no_more']).'">';
                $hook_out.='<a href="#">';
                $hook_out.=esc_attr($hook_translated['load_more']);
                $hook_out.='</a>';
                $hook_out.='<i class="hook_button_arrow hook_fa-chevron-down not_zero_color"></i>';
                $hook_out.='</div>';
                $hook_out.='<div id="ajax_spinner" class="spinner-icon"></div>';
                $hook_out.='</div>';
            }
            else if ($hook_nav_type=='ajaxed') {
                $hook_out.='<div class="clearfix bt_4x"></div><div class="clearfix bt_4x"></div>';
            }
            endif; 
            if ($hook_query->max_num_pages>1 && $hook_nav_type!='ajaxed') {
                $hook_out.='<div id="entries_navigation_blog" class="row hook_blog_uppercased prk_bordered_top">';
                $hook_out.='<div class="small-12 small-centered">';
                $hook_out.='<div id="prk_nav_inner" class="hook_anchor">';
                $hook_out.='<div class="small-12 header_font small_headings_color prk_heavier_600">';
                $hook_out.=get_next_posts_link('<div class="prk_lf navigation-previous-blog"><i class="prk_lf hook_fa-chevron-left prk_lf"></i><div class="prk_lf"><div class="blog_naver_left">'.esc_attr($hook_translated['older']).'</div></div></div>',$hook_query->max_num_pages);
                $hook_out.=get_previous_posts_link('<div class="prk_rf hook_right_align navigation-next-blog"><div class="prk_lf"><div class="blog_naver_right">'.esc_attr($hook_translated['newer']).'</div></div><i class="hook_fa-chevron-right prk_lf"></i></div>',$hook_query->max_num_pages);
                $hook_out.='</div>';
                $hook_out.='<div class="clearfix"></div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                $hook_out.='</div>';
            }
            echo hook_output().$hook_out;
            ?>
        </div>
    </div>
    <?php 
    if ($hook_show_sidebar) {
        ?>
        <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
            <?php get_sidebar(); ?>
        </aside>
        <?php
        echo '</div>';
        echo '</div>';
    }
    ?>
    <div class="clearfix"></div>
</div>
</div>
</div>
</div>
<?php
}
//GRID LAYOUT
else if ($prk_hook_options['archives_type']=="grid") {
    $hook_show_sidebar=$prk_hook_options['right_sidebar'];
    if ($hook_show_sidebar=="1")
        $hook_show_sidebar=true;
    else
        $hook_show_sidebar=false;
    if (get_field('show_sidebar')=="yes") 
    {
        $hook_show_sidebar=true;
    }
    if (get_field('show_sidebar')=="no") 
    {
        $hook_show_sidebar=false;
    }
    $hook_show_title=true;
    if (get_field('hide_title')=="1") 
    {
        $hook_show_title=false;
    }
    $hook_show_slider=get_field('featured_slider');
    if (get_field('featured_slider_autoplay')=="1")
      $hook_autoplay="true";
  else
      $hook_autoplay="false";
  $hook_delay=get_field('featured_slider_delay');
  if (get_field('featured_slider_supersize')=="1")
      $hook_fill_height="super_height";
  else
      $hook_fill_height="";
  if (get_field('featured_slider_arrows')=="1")
      $hook_navigation="true";
  else
      $hook_navigation="false";
  if (get_field('featured_slider_parallax')=="1")
      $hook_parallax="owl_parallaxed";
  else
      $hook_parallax="owl_regular";
  if (get_field('featured_slider_dots')=="1")
      $hook_pagination="true";
  else
      $hook_pagination="false";
  $hook_inside_filter="";
  if (get_field('slide_filter')!="")
  {
    $hook_filter=get_field('slide_filter');
    foreach ($hook_filter as $hook_child)
    {
        $hook_inside_filter.=$hook_child->slug.", ";
    }
}
if (get_field('featured_header')=="1") {
    $hook_featured_style='';
}
else {
    $hook_featured_style=' hook_forced_menu';
}
$hook_grid_align=get_field('grid_align');
$hook_feature_first=get_field('feature_first');
?>
<div id="hook_ajax_inner" class="page-prk-blog-grid<?php echo esc_attr($hook_featured_style); ?>"> 
    <div id="hook_content">
        <?php
        if ($hook_show_title==true)
        {
            $hook_uppercase="";
            if (get_field('uppercase_title')=="1") {
                $hook_uppercase=" uppercased_title";
            }
            echo '<div id="classic_title_wrapper">';
            echo '<div id="classic_title_container">';
            echo '<div class="small-12 small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
            hook_output_title();
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        else {
            wp_reset_postdata();
            if ($hook_show_slider=="yes")
            {
              echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
              echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
              echo '</div>';
          }
          if ($hook_show_slider=="revolution")
          {
              echo '<div class="prk_rv">'; 
              echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
              echo '</div><div id="mobile_sizer"></div>';
          }
          if (get_the_content()!=="" && is_page()==true) {
            while (have_posts()) : the_post();
            if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                echo '<div id="s_sec_inner" class="row">';
                the_content();
                echo '</div>';
            }
            else {
                echo '<div class="row">'; 
                if (HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                    echo '</div>';
                }
                else {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix bt_2x"></div>';
            }
            endwhile;
        }
    }
    ?>
    <div id="hook_content_inner">
        <div class="small-12 small-centered columns row <?php if (get_field('limit_width')==1 || $hook_show_sidebar==true) {echo "prk_inner_block";}else{echo "hook_unblog";} ?>">
            <?php
            if ($hook_show_title==true)
            {
                wp_reset_postdata();
                if ($hook_show_slider=="yes")
                {
                  echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
                  echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
                  echo '</div>';
              }
              if ($hook_show_slider=="revolution")
              {
                  echo '<div class="prk_rv">'; 
                  echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
                  echo '</div><div id="mobile_sizer"></div>';
              }
              if (get_the_content()!=="" && is_page()==true) {
                while (have_posts()) : the_post();
                if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                else {
                    echo '<div class="row">'; 
                    if (HOOK_VC_ON==true) {
                        echo '<div id="s_sec_inner" class="row">';
                        echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                        echo '</div>';
                    }
                    else {
                        echo '<div id="s_sec_inner" class="row">';
                        the_content();
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="clearfix bt_2x"></div>';
                }
                endwhile;
            }
        }
        if ($hook_show_sidebar==true) 
        {
            echo '<div class="row">';
            echo '<div class="small-9 columns prk_bordered_right prk_extra_r_pad">';
        }
        else
        {
            echo '<div class="hook_wider">';
        }
        wp_reset_postdata();
        if (is_page()) {
            if(is_front_page())
            {
                $hook_paged=(get_query_var('page')) ? get_query_var('page') : 1;
            }
            else
            { 
                $hook_paged=(get_query_var('paged')) ? get_query_var('paged') : 1;
            }
            $hook_query=new WP_Query();
            $hook_inside_filter="";
            if (get_field('blog_filter')!="")
            {
                $hook_filter=get_field('blog_filter');
                foreach ($hook_filter as $hook_child)
                {
                    $hook_inside_filter.=$hook_child->slug.", ";
                }
            }
            $hook_layout_type=get_field('grid_layout');
            $hook_page_title=get_the_title();
            $hook_nav_type=get_field('navigation_type');
            if ($hook_nav_type=="ajaxed") {
                $hook_query_number="999";
            }
            else {
                $hook_query_number=get_query_var('posts_per_page');
            }
            $posts_per_page=get_query_var('posts_per_page');
            $hook_query_args=array( 
                'post_type' => 'post', 
                'paged'=>$hook_paged,
                'category_name'=>$hook_inside_filter,
                'posts_per_page' => $hook_query_number,
                );
            $hook_query->query($hook_query_args);
        }
        if ($hook_query->have_posts()) : 
            $hook_post_counter=1;
        $hook_stop_flag=true;
        if (get_field('thumbs_margin')!="") {
            $hook_thumbs_margin=get_field('thumbs_margin');
        }
        else {
            $hook_thumbs_margin=0;
        }
        $hook_out='<div id="blog_masonry_father" class="row" data-items="'.esc_attr($posts_per_page).'">';
        $hook_terms=get_terms("category");
        $hook_count=count($hook_terms);
        if (get_field('show_filter')=="1") {
            $hook_filter_array=explode(",",$hook_inside_filter);
            $hook_filter_array=array_filter(array_map('trim', $hook_filter_array));
            $hook_out.='<div class="filter_blog">';
            $hook_out.='<div class="hook_blog_filter '.esc_attr(get_field('filter_align')).'">';
            $hook_out.='<ul class="header_font hook_blog_uppercased clearfix small_headings_color prk_heavier_600">';
            $hook_out.='<li class="active small b_filter">';
            $hook_out.='<a class="all" data-filter="b_all" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($hook_translated['all_text']).'</a>';
            $hook_out.='</li>';
            if ($hook_count > 0)
            {
                foreach ( $hook_terms as $term ) {
                    if (in_array($term->slug, $hook_filter_array) !== false || $hook_inside_filter=="")
                        $hook_out.='<li class="small b_filter"><a class="'.$term->slug.'" data-filter="'.$term->slug.'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.$term->name.'</a></li>';
                }
            }
            $hook_out.='</ul>';
            $hook_out.='</div>';
            $hook_out.='</div>';
        }
        $hook_out.='<div class="masonry_blog per_init prk_section clearfix" data-margin="'.esc_attr($hook_thumbs_margin).'">';
        $hook_out.='<div class="grid-sizer"></div>';
        while ($hook_query->have_posts()) : $hook_query->the_post();
        if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
            $hook_featured_color=get_field('featured_color');
            $hook_featured_class=" featured_color ";
        }
        else {
            $hook_featured_color="default";
            $hook_featured_class="";
        }
        $hook_category=get_the_category();
        $hook_filters=" b_all";
        foreach($hook_category as $inner) { 
            $hook_filters.=" ".$inner->slug;
        }
        if (has_post_thumbnail($post->ID)) {
            if ($hook_post_counter<=$posts_per_page) {
                $hook_forced_w=680;
                if ($hook_post_counter==1 && $hook_feature_first==1) {
                    $hook_featured_class.=" forced_100";
                    $hook_forced_w=$prk_hook_options['custom_width'];
                }
                $hook_out.='<div id="post-'.$post->ID.'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint clearfix '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-id="id-'.esc_attr($hook_post_counter).'" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="masonry_inner">';
                $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
                $hook_out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="lower_blog_grid body_bk_color header_font">';
                $hook_out.='<div class="small-12 hook_blog_uppercased prk_heavier_600">'.get_the_date('M j, Y').'</div>';
                $hook_out.='<div class="small-12 hook_grid_title"><h4 class="big">';
                $hook_out.=get_the_title();
                $hook_out.='</h4></div>';
                if ($prk_hook_options['postedby_blog']=="1") {
                    if (function_exists('get_avatar')) { 
                        $hook_out.='<div class="prk_author_avatar prk_lf">';
                        if (get_the_author_meta('prk_author_custom_avatar')!="") {
                            $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                            $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                        }
                        else {
                            if (get_avatar(get_the_author_meta('email'),'216')) {
                                $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                            }
                        }
                        $hook_out.='</div>';
                    }
                    $hook_out.='<div class="hook_anchor prk_lf hook_blog_uppercased">';
                    $hook_out.=esc_attr($hook_translated['posted_by_text']).' '.get_the_author();
                    $hook_out.='</div>';
                }
                $hook_out.='</div>';
                $hook_out.='<div class="masonr_img_wp">';
                $hook_out.='<div class="blog_fader_grid hook_gridy"></div>';
                if ($hook_layout_type=="masonry") {
                    $hook_forced_h=0;
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                }
                else if ($hook_layout_type=="squares")
                {
                    $hook_forced_h=$hook_forced_w;
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                else if ($hook_layout_type=="grid_vertical")
                {
                    $hook_forced_h=floor($hook_forced_w*3/2);
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                else 
                {
                    $hook_forced_h=floor($hook_forced_w*2/3);
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$post->ID.'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                $hook_out.='</div>';
                $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                //END POST
            }
            else if ($hook_nav_type=='ajaxed') {
                if ($hook_stop_flag==true)
                {
                    $hook_out.='</div>';
                    $hook_out.='<div class="blog_appender hide_now">';
                    $hook_stop_flag=false;
                }
                $hook_forced_w=680;
                if ($hook_post_counter==1 && $hook_feature_first==1) {
                    $hook_featured_class.=" forced_100";
                    $hook_forced_w=$prk_hook_options['custom_width'];
                }
                $hook_out.='<div id="post-'.$post->ID.'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint clearfix '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-id="id-'.esc_attr($hook_post_counter).'" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="masonry_inner">';
                $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
                $hook_out.='<a href="'.get_permalink().'" class="hook_anchor blog_hover" data-color="'.esc_attr($hook_featured_color).'">';
                $hook_out.='<div class="lower_blog_grid body_bk_color header_font">';
                $hook_out.='<div class="small-12 hook_blog_uppercased prk_heavier_600">'.get_the_date('M j, Y').'</div>';
                $hook_out.='<div class="small-12 hook_grid_title"><h4 class="big">';
                $hook_out.=get_the_title();
                $hook_out.='</h4></div>';
                if ($prk_hook_options['postedby_blog']=="1") {
                    if (function_exists('get_avatar')) { 
                        $hook_out.='<div class="prk_author_avatar prk_lf">';
                        if (get_the_author_meta('prk_author_custom_avatar')!="") {
                            $hook_vt_image=vt_resize('', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                            $hook_out.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                        }
                        else {
                            if (get_avatar(get_the_author_meta('email'),'216')) {
                                $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                            }
                        }
                        $hook_out.='</div>';
                    }
                    $hook_out.='<div class="hook_anchor prk_lf hook_blog_uppercased">';
                    $hook_out.=esc_attr($hook_translated['posted_by_text']).' '.get_the_author();
                    $hook_out.='</div>';
                }
                $hook_out.='</div>';
                $hook_out.='<div class="masonr_img_wp">';
                $hook_out.='<div class="blog_fader_grid hook_gridy"></div>';
                if ($hook_layout_type=="masonry") {
                    $hook_forced_h=0;
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, false , $hook_retina_device );
                }
                else if ($hook_layout_type=="squares")
                {
                    $hook_forced_h=$hook_forced_w;
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                else if ($hook_layout_type=="grid_vertical")
                {
                    $hook_forced_h=floor($hook_forced_w*3/2);
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                else 
                {
                    $hook_forced_h=floor($hook_forced_w*2/3);
                    $hook_vt_image=vt_resize( '', $hook_image[0] , $hook_forced_w, $hook_forced_h, true , $hook_retina_device );
                }
                $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.$post->ID.'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                $hook_out.='</div>';
                $hook_out.='</a>';
                $hook_out.='</div>';
                $hook_out.='</div>';
                //END POST
            }
            $hook_post_counter++;
        }
        endwhile;
        $hook_out.='</div>';
        if ($hook_stop_flag==false) {
            $hook_out.='<div class="outer_load_more">';
            $hook_out.='<div class="blog_load_more theme_button" data-no_more="'.esc_attr($hook_translated['no_more']).'">';
            $hook_out.='<a href="#">';
            $hook_out.=esc_attr($hook_translated['load_more']);
            $hook_out.='</a>';
            $hook_out.='<i class="hook_button_arrow hook_fa-chevron-down not_zero_color"></i>';
            $hook_out.='</div>';
            $hook_out.='<div id="ajax_spinner" class="spinner-icon"></div>';
            $hook_out.='</div>';
        }
        else if ($hook_nav_type=='ajaxed') {
            $hook_out.='<div class="clearfix bt_4x"></div><div class="clearfix bt_4x"></div>';
        }
        endif; 
        //SHOW NAVIGATION
        if ($hook_query->max_num_pages>1 && $hook_nav_type!='ajaxed') {
            $hook_out.='<div id="entries_navigation_blog" class="row hook_blog_uppercased prk_bordered_top">';
            $hook_out.='<div class="small-12 small-centered">';
            $hook_out.='<div id="prk_nav_inner" class="hook_anchor">';
            $hook_out.='<div class="small-12 header_font small_headings_color prk_heavier_600">';
            $hook_out.=get_next_posts_link('<div class="prk_lf navigation-previous-blog"><i class="prk_lf hook_fa-chevron-left prk_lf"></i><div class="prk_lf"><div class="blog_naver_left">'.esc_attr($hook_translated['older']).'</div></div></div>',$hook_query->max_num_pages);
            $hook_out.=get_previous_posts_link('<div class="prk_rf hook_right_align navigation-next-blog"><div class="prk_lf"><div class="blog_naver_right">'.esc_attr($hook_translated['newer']).'</div></div><i class="hook_fa-chevron-right prk_lf"></i></div>',$hook_query->max_num_pages);
            $hook_out.='</div>';
            $hook_out.='<div class="clearfix"></div>';
            $hook_out.='</div>';
            $hook_out.='</div>';
            $hook_out.='</div>';
        }
        echo hook_output().$hook_out;
        ?>
    </div>
</div>
<?php 
if ($hook_show_sidebar) {
    ?>
    <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
        <?php get_sidebar(); ?>
    </aside>
    <?php
    echo '</div>';
    echo '</div>';
}
?>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
<?php
}
//BIG IMAGES LAYOUT
else if ($prk_hook_options['archives_type']=="classic") {
    $hook_show_sidebar=$prk_hook_options['right_sidebar'];
    if ($hook_show_sidebar=="1")
        $hook_show_sidebar=true;
    else
      $hook_show_sidebar=false;
  if (get_field('show_sidebar')=="yes") 
  {
    $hook_show_sidebar=true;
}
if (get_field('show_sidebar')=="no") 
{
    $hook_show_sidebar=false;
}
$hook_show_title=true;
if (get_field('hide_title')=="1") 
{
    $hook_show_title=false;
}
$hook_show_slider=get_field('featured_slider');
if (get_field('featured_slider_autoplay')=="1")
  $hook_autoplay="true";
else
  $hook_autoplay="false";
$hook_delay=get_field('featured_slider_delay');
if (get_field('featured_slider_supersize')=="1")
  $hook_fill_height="super_height";
else
  $hook_fill_height="";
if (get_field('featured_slider_arrows')=="1")
  $hook_navigation="true";
else
  $hook_navigation="false";
if (get_field('featured_slider_parallax')=="1")
  $hook_parallax="owl_parallaxed";
else
  $hook_parallax="owl_regular";
if (get_field('featured_slider_dots')=="1")
  $hook_pagination="true";
else
  $hook_pagination="false";
$hook_inside_filter="";
if (get_field('slide_filter')!="")
{
    $hook_filter=get_field('slide_filter');
    foreach ($hook_filter as $hook_child) {
      $hook_inside_filter.=$hook_child->slug.", ";
  }
}
if (get_field('featured_header')=="1") {
    $hook_featured_style='';
}
else {
    $hook_featured_style=' hook_forced_menu';
}
$hook_grid_align=get_field('grid_align');
?>    
<div id="hook_ajax_inner" class="page-prk-blog-full<?php echo esc_attr($hook_featured_style); ?>">
    <div id="hook_content">
        <?php
        if ($hook_show_title==true)
        {
            $hook_uppercase="";
            if (get_field('uppercase_title')=="1") {
                $hook_uppercase=" uppercased_title";
            }
            echo '<div id="classic_title_wrapper">';
            echo '<div class="small-12 small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
            hook_output_title();
            echo '</div>';
            echo '</div>';
        }
        else
        {
            wp_reset_postdata();
            if ($hook_show_slider=="yes")
            {
              echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
              echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
              echo '</div>';
          }
          if ($hook_show_slider=="revolution")
          {
              echo '<div class="prk_rv">'; 
              echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
              echo '</div><div id="mobile_sizer"></div>';
          }
          if (get_the_content()!=="" && is_page()==true) {
            while (have_posts()) : the_post();
            if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                echo '<div id="s_sec_inner" class="row">';
                the_content();
                echo '</div>';
            }
            else {
                echo '<div class="row">'; 
                if (HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                    echo '</div>';
                }
                else {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix bt_2x"></div>';
            }
            endwhile;
        }
    }
    ?>
    <div id="hook_content_inner">
        <div class="small-12 small-centered columns row <?php if (get_field('limit_width')==1 || $hook_show_sidebar==true) {echo "prk_inner_block";}else{echo "hook_unblog";} ?>">
            <?php
            if ($hook_show_title==true)
            {
                if ($hook_show_slider=="yes")
                {
                  echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
                  echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
                  echo '</div>';
              }
              if ($hook_show_slider=="revolution")
              {
                  echo '<div class="prk_rv">'; 
                  echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
                  echo '</div><div id="mobile_sizer"></div>';
              }
              if (get_the_content()!=="" && is_page()==true) {
                while (have_posts()) : the_post();
                if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                else {
                    echo '<div class="row">'; 
                    if (HOOK_VC_ON==true) {
                        echo '<div id="s_sec_inner" class="row">';
                        echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                        echo '</div>';
                    }
                    else {
                        echo '<div id="s_sec_inner" class="row">';
                        the_content();
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="clearfix bt_2x"></div>';
                }
                endwhile;
            }
        }
        if ($hook_show_sidebar) 
        {
            echo '<div id="parent_blog_inner" class="small-12 columns small-centered prk_inner_block">';
            echo '<div class="row">';
            echo '<div class="small-9 columns prk_bordered_right prk_extra_r_pad">';
        }
        else
        {
            echo '<div id="hook_classic_blog" class="small-12">';
        }
        wp_reset_postdata();
        if (is_page()) {
            if(is_front_page())
            {
              $hook_paged=(get_query_var('page')) ? get_query_var('page') : 1;
          }
          else
          { 
              $hook_paged=(get_query_var('paged')) ? get_query_var('paged') : 1;
          }
          $hook_query=new WP_Query();
          $hook_inside_filter="";
          if (get_field('blog_filter')!="") {
              $hook_filter=get_field('blog_filter');
              foreach ($hook_filter as $hook_child) {
                $hook_inside_filter.=$hook_child->slug.", ";
            }
        }
        $hook_page_title=get_the_title();
        $hook_nav_type=get_field('navigation_type');
        if ($hook_nav_type=="ajaxed") {
            $hook_query_number="999";
        }
        else {
            $hook_query_number=get_query_var('posts_per_page');
        }
        $posts_per_page=get_query_var('posts_per_page');
        $hook_query_args=array( 
            'post_type' => 'post', 
            'paged'=>$hook_paged,
            'category_name'=>$hook_inside_filter,
            'posts_per_page' => $hook_query_number,
        );
        $hook_query->query($hook_query_args);
    }
    if ($hook_query->have_posts()) : 
        $hook_post_counter=1;
    $hook_stop_flag=true;
    $hook_out='<div class="classic_blog_section" data-items="'.esc_attr($posts_per_page).'">';
    $hook_terms=get_terms("category");
    $hook_count=count($hook_terms);
    if (get_field('show_filter')=="1") {
        $hook_filter_array=explode(",",$hook_inside_filter);
        $hook_filter_array=array_filter(array_map('trim', $hook_filter_array));
        $hook_out.='<div class="filter_blog">';
        $hook_out.='<div class="hook_blog_filter '.esc_attr(get_field('filter_align')).'">';
        $hook_out.='<ul class="header_font hook_blog_uppercased clearfix small_headings_color prk_heavier_600">';
        $hook_out.='<li class="active small b_filter">';
        $hook_out.='<a class="all" data-filter="b_all" href="#" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($hook_translated['all_text']).'</a>';
        $hook_out.='</li>';
        if ($hook_count > 0)
        {
            foreach ( $hook_terms as $term ) {
                if (in_array($term->slug, $hook_filter_array) !== false || $hook_inside_filter=="")
                    $hook_out.='<li class="small b_filter"><a class="'.$term->slug.'" data-filter="'.$term->slug.'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.$term->name.'</a></li>';
            }
        }
        $hook_out.='</ul>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="blog_entries unstyled">';
    $hook_out.='<div class="grid-sizer"></div>';
    while ($hook_query->have_posts()) : $hook_query->the_post(); 
    if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
    {
      $hook_featured_color=get_field('featured_color');
      $hook_featured_class=" featured_color";
  }
  else
  {
      $hook_featured_color="default";
      $hook_featured_class="";
  }
  $hook_category=get_the_category();
  $hook_filters=" b_all";
  foreach($hook_category as $inner) { 
    $hook_filters.=" ".$inner->slug;
}
if ($hook_post_counter<=$posts_per_page) {
    $hook_out.='<div id="post-'.get_the_ID().'" class="blog_entry_li blog_hover wpb_animate_when_almost_visible wpb_hook_fade_waypoint prk_bordered '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_ext_count=0;
    $hook_imgs_width=$prk_hook_options['custom_width']+80*2;
    if (has_post_thumbnail($post->ID))
    {
        $hook_ext_count=1;
        $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
        $hook_out.='<a href="'.get_permalink().'" class="hook_anchor">';
        $hook_out.='<div class="blog_top_image">';
        $hook_out.='<div class="blog_fader_grid">';
        $hook_out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
        $hook_out.='</div>';
        $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , $hook_imgs_width, 0, false , $hook_retina_device );
        $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.get_the_ID().'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
        $hook_out.='</div>';
        $hook_out.='</a>';
    }
    else
    {
        if (get_field('video_2')!="") {
            $hook_el_class='video-container';
            if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                $hook_el_class= 'soundcloud-container';
            }
            $hook_out.='<a href="'.get_permalink().'" class="hook_anchor">';
            $hook_out.='<div class="'.esc_attr($hook_el_class).'">';
            $hook_out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
            $hook_out.='</div>';
            $hook_out.='</a>';
        }
    }
    $hook_out.='<div class="hook_post_info">';
    $hook_out.='<div class="hook_inn">';
    $hook_content=get_post_field('post_content',$post->ID);
    $hook_out.='<div class="entry_title header_font">';
    $hook_out.='<h3 class="small">';
    $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.=get_the_title();
    $hook_out.='</a>';
    $hook_out.='</h3>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="single_blog_meta_class hook_blog_uppercased prk_heavier_600 prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
    $hook_divide_me=false;
    if (is_sticky()) {
        $hook_divide_me=true;
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
        $hook_out.=esc_attr($hook_translated['sticky_text']);
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['show_date_blog']=="1") {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_out.=get_the_time(get_option('date_format'));
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_arra=get_the_category($post->ID);
    if ($prk_hook_options['categoriesby_blog']=="1" && !empty($hook_arra)) {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf blog_categories">';
        $hook_count_cats=0;
        foreach($hook_arra as $hook_s_cat) {
            if ($hook_count_cats>0)
                $hook_out.=', ';
            $hook_out.='<a href="'.get_category_link( $hook_s_cat->term_id ).'" title="View all posts" class="hook_anchor">'.$hook_s_cat->cat_name.'</a>';
            $hook_count_cats++;
        }
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if (comments_open()){
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_num_comments=get_comments_number();
        if ( $hook_num_comments == 0 ) {
            $comments=$hook_translated['comments_no_response'];
        } elseif ( $hook_num_comments > 1 ) {
            $comments=$hook_num_comments.' '.$hook_translated['comments_oneplus_response'];
        } else {
            $comments=$hook_translated['comments_one_response'];
        }
        $hook_out.='<a href="' . get_comments_link() .'" class="hook_anchor">'.esc_attr($comments).'</a>';      
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['postedby_blog']=="1") { 
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_colored_link">';
        $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor not_zero_color">'.get_the_author().'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="pirenko_box small-12">';
    $hook_out.='<div class="on_colored entry_content prk_break_word">';
    $hook_out.='<div class="wpb_text_column">';
    $hook_cat_helper=$post->ID;
    $hook_out.= hook_excerpt_dynamic(70,$post->ID);
    $hook_out.='<div class="clearfix bt_12"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    if (hook_is_big_excerpt(70,$post->ID))
    {
        $hook_out.='<a href="'.get_permalink($hook_cat_helper).'" class="prk_heavier_700 zero_color hook_anchor" data-color="'.esc_attr($hook_featured_color).'">';
        $hook_out.=esc_attr($hook_translated['read_more']).' &rarr;';
        $hook_out.='</a>';
    }
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    //END POST
} else if ($hook_nav_type=='ajaxed') {
    if ($hook_stop_flag==true)
    {
        $hook_out.='</div>';
        $hook_out.='<div class="blog_appender hide_now">';
        $hook_stop_flag=false;
    }
    $hook_out.='<div id="post-'.get_the_ID().'" class="blog_entry_li blog_hover wpb_animate_when_almost_visible wpb_hook_fade_waypoint prk_bordered '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_ext_count=0;
    $hook_imgs_width=$prk_hook_options['custom_width']+80*2;
    if (has_post_thumbnail($post->ID))
    {
        $hook_ext_count=1;
        $hook_image=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );
        $hook_out.='<a href="'.get_permalink().'" class="hook_anchor">';
        $hook_out.='<div class="blog_top_image">';
        $hook_out.='<div class="blog_fader_grid">';
        $hook_out.='<div class="mdi-link-variant titled_link_icon body_bk_color"></div>';
        $hook_out.='</div>';
        $hook_vt_image=vt_resize( get_post_thumbnail_id($post->ID), '' , $hook_imgs_width, 0, false , $hook_retina_device );
        $hook_out.='<img src="'.get_template_directory_uri().'/images/spacer.gif" data-src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" id="home_fader-'.get_the_ID().'" class="custom-img grid_image" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
        $hook_out.='</div>';
        $hook_out.='</a>';
    }
    else
    {
        if (get_field('video_2')!="")
        {
            $hook_el_class='video-container';
            if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                $hook_el_class= 'soundcloud-container';
            }
            $hook_out.='<a href="'.get_permalink().'" class="hook_anchor">';
            $hook_out.='<div class="'.esc_attr($hook_el_class).'">';
            $hook_out.=str_replace('autoplay=1','autoplay=0',get_field('video_2'));
            $hook_out.='</div>';
            $hook_out.='</a>';
        }
    }
    $hook_out.='<div class="hook_post_info">';
    $hook_out.='<div class="hook_inn">';
    $hook_content=get_post_field('post_content',$post->ID);
    $hook_out.='<div class="entry_title header_font">';
    $hook_out.='<h3 class="small">';
    $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.=get_the_title();
    $hook_out.='</a>';
    $hook_out.='</h3>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="single_blog_meta_class hook_blog_uppercased prk_heavier_600 prk_75_em small_headings_color '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
    $hook_divide_me=false;
    if (is_sticky())
    {
        $hook_divide_me=true;
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
        $hook_out.=esc_attr($hook_translated['sticky_text']);
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['show_date_blog']=="1") {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_out.=get_the_time(get_option('date_format'));
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_arra=get_the_category($post->ID);
    if ($prk_hook_options['categoriesby_blog']=="1" && !empty($hook_arra)) {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf blog_categories">';
        $hook_count_cats=0;
        foreach($hook_arra as $hook_s_cat) {
            if ($hook_count_cats>0)
                $hook_out.=', ';
            $hook_out.='<a href="'.get_category_link( $hook_s_cat->term_id ).'" title="View all posts" class="hook_anchor">'.$hook_s_cat->cat_name.'</a>';
            $hook_count_cats++;
        }
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if (comments_open()){
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_num_comments=get_comments_number();
        if ( $hook_num_comments == 0 ) {
            $comments=$hook_translated['comments_no_response'];
        } elseif ( $hook_num_comments > 1 ) {
            $comments=$hook_num_comments.' '.$hook_translated['comments_oneplus_response'];
        } else {
            $comments=$hook_translated['comments_one_response'];
        }
        $hook_out.='<a href="'.get_comments_link().'" class="hook_anchor">'.esc_attr($comments).'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['postedby_blog']=="1") { 
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_colored_link">';
        $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor not_zero_color">'.get_the_author().'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="pirenko_box small-12">';
    $hook_out.='<div class="on_colored entry_content prk_break_word">';
    $hook_out.='<div class="wpb_text_column">';
    $hook_cat_helper=$post->ID;
    $hook_out.= hook_excerpt_dynamic(70,$post->ID);
    $hook_out.='<div class="clearfix bt_12"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    if (hook_is_big_excerpt(70,$post->ID))
    {
        $hook_out.='<a href="'.get_permalink($hook_cat_helper).'" class="prk_heavier_700 zero_color hook_anchor" data-color="'.esc_attr($hook_featured_color).'">';
        $hook_out.=esc_attr($hook_translated['read_more']).' &rarr;';
        $hook_out.='</a>';
    }
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    //END POST
}
$hook_post_counter++;
endwhile;
$hook_out.='</div>';
if ($hook_stop_flag==false) {
    $hook_out.='<div class="outer_load_more">';
    $hook_out.='<div class="blog_load_more theme_button" data-no_more="'.esc_attr($hook_translated['no_more']).'">';
    $hook_out.='<a href="#">';
    $hook_out.=esc_attr($hook_translated['load_more']);
    $hook_out.='</a>';
    $hook_out.='<i class="hook_button_arrow hook_fa-chevron-down not_zero_color"></i>';
    $hook_out.='</div>';
    $hook_out.='<div id="ajax_spinner" class="spinner-icon"></div>';
    $hook_out.='</div>';
}
else if ($hook_nav_type=='ajaxed') {
    $hook_out.='<div class="clearfix bt_4x"></div><div class="clearfix bt_4x"></div>';
}
endif; 
//SHOW NAVIGATION
if ($hook_query->max_num_pages>1 && $hook_nav_type!='ajaxed')
{
    $hook_out.='<div id="entries_navigation_blog" class="row hook_blog_uppercased prk_bordered_top">';
    $hook_out.='<div class="small-12 small-centered">';
    $hook_out.='<div id="prk_nav_inner" class="hook_anchor">';
    $hook_out.='<div class="small-12 header_font small_headings_color prk_heavier_600">';
    $hook_out.=get_next_posts_link('<div class="prk_lf navigation-previous-blog"><i class="prk_lf hook_fa-chevron-left prk_lf"></i><div class="prk_lf"><div class="blog_naver_left">'.esc_attr($hook_translated['older']).'</div></div></div>',$hook_query->max_num_pages);
    $hook_out.=get_previous_posts_link('<div class="prk_rf hook_right_align navigation-next-blog"><div class="prk_lf"><div class="blog_naver_right">'.esc_attr($hook_translated['newer']).'</div></div><i class="hook_fa-chevron-right prk_lf"></i></div>',$hook_query->max_num_pages);
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
}
$hook_out.='</div>';
$hook_out.='</div>';
echo hook_output().$hook_out;
if ($hook_show_sidebar) 
{
    ?>
    <aside id="hook_sidebar" class="prk_blogged <?php echo HOOK_SIDEBAR_CLASSES; ?> on_single">
        <div class="simple_line show_later"></div>
        <?php get_sidebar(); ?>
    </aside>
    <?php
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
</div>
</div>
<?php
}
else
{
    //STACKED LAYOUT
    $hook_show_sidebar=$prk_hook_options['right_sidebar'];
    if ($hook_show_sidebar=="1")
        $hook_show_sidebar=true;
    else
      $hook_show_sidebar=false;
    if (get_field('show_sidebar')=="yes") 
    {
    $hook_show_sidebar=true;
    }
    if (get_field('show_sidebar')=="no") 
    {
        $hook_show_sidebar=false;
    }
    $hook_show_title=true;
    if (get_field('hide_title')=="1") 
    {
        $hook_show_title=false;
    }
    $hook_show_slider=get_field('featured_slider');
    if (get_field('featured_slider_autoplay')=="1")
      $hook_autoplay="true";
  else
      $hook_autoplay="false";
  $hook_delay=get_field('featured_slider_delay');
  if (get_field('featured_slider_supersize')=="1")
      $hook_fill_height="super_height";
  else
      $hook_fill_height="";
  if (get_field('featured_slider_arrows')=="1")
      $hook_navigation="true";
  else
      $hook_navigation="false";
  if (get_field('featured_slider_parallax')=="1")
      $hook_parallax="owl_parallaxed";
  else
      $hook_parallax="owl_regular";
  if (get_field('featured_slider_dots')=="1")
      $hook_pagination="true";
  else
      $hook_pagination="false";
  $hook_inside_filter="";
  if (get_field('slide_filter')!="")
  {
      $hook_filter=get_field('slide_filter');
      foreach ($hook_filter as $hook_child) {
        $hook_inside_filter.=$hook_child->slug.", ";
    }
}
if (get_field('featured_header')=="1") {
    $hook_featured_style='';
}
else {
    $hook_featured_style=' hook_forced_menu';
}
$hook_grid_align=get_field('grid_align');
?>    
<div id="hook_ajax_inner" class="page-prk-blog-stacked<?php echo esc_attr($hook_featured_style); ?>">
    <div id="hook_content">
        <?php
        if ($hook_show_title==true) {
            $hook_uppercase="";
            if (get_field('uppercase_title')=="1") {
                $hook_uppercase=" uppercased_title";
            }
            echo '<div id="classic_title_wrapper">';
            echo '<div class="small-12 small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
            hook_output_title();
            echo '</div>';
            echo '</div>';
        }
        else
        {
            wp_reset_postdata();
            if ($hook_show_slider=="yes")
            {
              echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
              echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
              echo '</div>';
          }
          if ($hook_show_slider=="revolution")
          {
              echo '<div class="prk_rv">'; 
              echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
              echo '</div><div id="mobile_sizer"></div>';
          }
          if (get_the_content()!=="" && is_page()==true) {
            while (have_posts()) : the_post();
            if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                echo '<div id="s_sec_inner" class="row">';
                the_content();
                echo '</div>';
            }
            else {
                echo '<div class="row">'; 
                if (HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                    echo '</div>';
                }
                else {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix bt_2x"></div>';
            }
            endwhile;
        }
    }
    ?>
    <div id="hook_content_inner">
        <div class="small-12 small-centered columns row <?php if (get_field('limit_width')==1 || $hook_show_sidebar==true) {echo "prk_inner_block";}else{echo "hook_unblog";} ?>">
            <?php
            if ($hook_show_title==true)
            {
                if ($hook_show_slider=="yes")
                {
                  echo '<div class="featured_owl '.esc_attr($hook_parallax).'">'; 
                  echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'"]');
                  echo '</div>';
              }
              if ($hook_show_slider=="revolution")
              {
                  echo '<div class="prk_rv">'; 
                  echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
                  echo '</div><div id="mobile_sizer"></div>';
              }
              wp_reset_postdata();
              if (get_the_content()!=="" && is_page()==true) {
                while (have_posts()) : the_post();
                if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                    echo '<div id="s_sec_inner" class="row">';
                    the_content();
                    echo '</div>';
                }
                else {
                    echo '<div class="row">'; 
                    if (HOOK_VC_ON==true) {
                        echo '<div id="s_sec_inner" class="row">';
                        echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                        echo '</div>';
                    }
                    else {
                        echo '<div id="s_sec_inner" class="row">';
                        the_content();
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="clearfix bt_2x"></div>';
                }
                endwhile;
            }
        }
        if ($hook_show_sidebar) 
        {
            echo '<div id="parent_blog_inner" class="small-12 columns small-centered prk_inner_block">';
            echo '<div class="row">';
            echo '<div class="small-9 columns prk_bordered_right prk_extra_r_pad">';
        }
        else
        {
            echo '<div class="hook_wider">';
        }
        wp_reset_postdata();
        if (is_page()) {
            if(is_front_page())
            {
              $hook_paged=(get_query_var('page')) ? get_query_var('page') : 1;
          }
          else
          { 
              $hook_paged=(get_query_var('paged')) ? get_query_var('paged') : 1;
          }
          $hook_query=new WP_Query();
          $hook_inside_filter="";
          if (get_field('blog_filter')!="")
          {
              $hook_filter=get_field('blog_filter');
              foreach ($hook_filter as $hook_child) {
                $hook_inside_filter.=$hook_child->slug.", ";
            }
        }
        $hook_page_title=get_the_title();
        $hook_nav_type=get_field('navigation_type');
        if ($hook_nav_type=="ajaxed") {
            $hook_query_number="999";
        }
        else {
            $hook_query_number=get_query_var('posts_per_page');
        }
        $posts_per_page=get_query_var('posts_per_page');
        $hook_query_args=array( 
            'post_type' => 'post', 
            'paged'=>$hook_paged,
            'category_name'=>$hook_inside_filter,
            'posts_per_page' => $hook_query_number,
            );
        $hook_query->query($hook_query_args);
    }
    if ($hook_query->have_posts()) : 
        $hook_post_counter=1;
    $hook_stop_flag=true;
    $hook_out='<div class="classic_blog_section" data-items="'.esc_attr($posts_per_page).'">';
    $hook_terms=get_terms("category");
    $hook_count=count($hook_terms);
    if (get_field('show_filter')=="1") {
        $hook_filter_array=explode(",",$hook_inside_filter);
        $hook_filter_array=array_filter(array_map('trim', $hook_filter_array));
        $hook_out.='<div class="filter_blog">';
        $hook_out.='<div class="hook_blog_filter '.esc_attr(get_field('filter_align')).'">';
        $hook_out.='<ul class="header_font hook_blog_uppercased clearfix small_headings_color prk_heavier_600">';
        $hook_out.='<li class="active small b_filter">';
        $hook_out.='<a class="all" data-filter="b_all" href="#" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.esc_attr($hook_translated['all_text']).'</a>';
        $hook_out.='</li>';
        if ($hook_count > 0)
        {
            foreach ( $hook_terms as $term ) {
                if (in_array($term->slug, $hook_filter_array) !== false || $hook_inside_filter=="")
                    $hook_out.='<li class="small b_filter"><a class="'.$term->slug.'" data-filter="'.$term->slug.'" href="javascript:void(0)" data-color="'.esc_attr($prk_hook_options['bd_headings_color']).'">'.$term->name.'</a></li>';
            }
        }
        $hook_out.='</ul>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="blog_entries unstyled">';
    $hook_out.='<div class="grid-sizer"></div>';
    while ($hook_query->have_posts()) : $hook_query->the_post(); 
    if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1")
    {
      $hook_featured_color=get_field('featured_color');
      $hook_featured_class=" featured_color";
  }
  else
  {
      $hook_featured_color="default";
      $hook_featured_class="";
  }
  $hook_category=get_the_category();
  $hook_filters=" b_all";
  foreach($hook_category as $inner) { 
    $hook_filters.=" ".$inner->slug;
}
$hook_imgs_width=$prk_hook_options['custom_width']+80*2;
if ($hook_post_counter<=$posts_per_page) {
    $hook_out.='<div id="post-'.get_the_ID().'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint prk_bordered_bottom '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.='<div class="hook_post_info">';
    $hook_out.='<div class="entry_title header_font prk_lf">';
    $hook_out.='<h3 class="small">';
    $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.=get_the_title();
    $hook_out.='</a>';
    $hook_out.='</h3>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="single_blog_meta_class small_headings_color hook_blog_uppercased prk_75_em prk_heavier_600 '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
    $hook_divide_me=false;
    if (is_sticky())
    {
        $hook_divide_me=true;
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
        $hook_out.=esc_attr($hook_translated['sticky_text']);
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['show_date_blog']=="1") {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_out.=get_the_time(get_option('date_format'));
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_arra=get_the_category($post->ID);
    if ($prk_hook_options['categoriesby_blog']=="1" && !empty($hook_arra)) {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf blog_categories">';
        $hook_count_cats=0;
        foreach($hook_arra as $hook_s_cat) {
            if ($hook_count_cats>0)
                $hook_out.=', ';
            $hook_out.='<a href="'.get_category_link( $hook_s_cat->term_id ).'" title="View all posts" class="hook_anchor">'.$hook_s_cat->cat_name.'</a>';
            $hook_count_cats++;
        }
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if (comments_open()){
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_num_comments=get_comments_number();
        if ( $hook_num_comments == 0 ) {
            $comments=$hook_translated['comments_no_response'];
        } elseif ( $hook_num_comments > 1 ) {
            $comments=$hook_num_comments.' '.$hook_translated['comments_oneplus_response'];
        } else {
            $comments=$hook_translated['comments_one_response'];
        }
        $hook_out.='<a href="'. get_comments_link() .'" class="hook_anchor">'.esc_attr($comments).'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="pirenko_box">';
    $hook_out.='<div class="on_colored entry_content prk_break_word body_colored regular_font">';
    $hook_out.='<div class="wpb_text_column">';
    $hook_cat_helper=$post->ID;
    $hook_out.= hook_excerpt_dynamic(64,$post->ID);
    $hook_out.='<div class="clearfix bt_12"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    if ($prk_hook_options['postedby_blog']=="1") {
        if (function_exists('get_avatar')) {
            $hook_out.='<div class="low_wrp">';
            $hook_out.='<div class="prk_author_avatar prk_lf">';
            $hook_out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
            if (get_the_author_meta('prk_author_custom_avatar')!="") {
                $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
            }
            else {
                if (get_avatar(get_the_author_meta('email'),'216')) {
                    $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                }
            }
            $hook_out.='</a>';
            $hook_out.='</div>';
        }
        $hook_out.='<div class="hook_blog_uppercased prk_75_em prk_heavier_600 header_font hook_anchor prk_lf hook_colored_link">';
        $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='</div>';
    //END POST
} else if ($hook_nav_type=='ajaxed') {
    if ($hook_stop_flag==true)
    {
        $hook_out.='</div>';
        $hook_out.='<div class="blog_appender hide_now">';
        $hook_stop_flag=false;
    }
    $hook_out.='<div id="post-'.get_the_ID().'" class="blog_entry_li wpb_animate_when_almost_visible wpb_hook_fade_waypoint prk_bordered_bottom '.esc_attr($hook_grid_align.$hook_featured_class.$hook_filters).'" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.='<div class="hook_post_info">';
    $hook_out.='<div class="entry_title header_font prk_lf">';
    $hook_out.='<h3 class="small">';
    $hook_out.='<a href="'.get_permalink().'" class="hook_anchor zero_color prk_break_word" data-color="'.esc_attr($hook_featured_color).'">';
    $hook_out.=get_the_title();
    $hook_out.='</a>';
    $hook_out.='</h3>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="single_blog_meta_class small_headings_color hook_blog_uppercased prk_75_em prk_heavier_600 '.esc_attr($prk_hook_options['main_subheadings_font']).'">';
    $hook_divide_me=false;
    if (is_sticky())
    {
        $hook_divide_me=true;
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf hook_sticky not_zero_color">';
        $hook_out.=esc_attr($hook_translated['sticky_text']);
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if ($prk_hook_options['show_date_blog']=="1") {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_out.=get_the_time(get_option('date_format'));
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_arra=get_the_category($post->ID);
    if ($prk_hook_options['categoriesby_blog']=="1" && !empty($hook_arra)) {
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf blog_categories">';
        $hook_count_cats=0;
        foreach($hook_arra as $hook_s_cat) {
            if ($hook_count_cats>0)
                $hook_out.=', ';
            $hook_out.='<a href="'.get_category_link( $hook_s_cat->term_id ).'" title="View all posts" class="hook_anchor">'.$hook_s_cat->cat_name.'</a>';
            $hook_count_cats++;
        }
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    if (comments_open()){
        if ($hook_divide_me==false) {
            $hook_divide_me=true;
        }
        else {
            $hook_out.='<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
        }
        $hook_out.='<div class="single_blog_meta_div">';
        $hook_out.='<div class="prk_lf">';
        $hook_num_comments=get_comments_number();
        if ( $hook_num_comments == 0 ) {
            $comments=$hook_translated['comments_no_response'];
        } elseif ( $hook_num_comments > 1 ) {
            $comments=$hook_num_comments.' '.$hook_translated['comments_oneplus_response'];
        } else {
            $comments=$hook_translated['comments_one_response'];
        }
        $hook_out.='<a href="'. get_comments_link() .'" class="hook_anchor">'.esc_attr($comments).'</a>';      
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='<div class="pirenko_box">';
    $hook_out.='<div class="on_colored entry_content prk_break_word body_colored regular_font">';
    $hook_out.='<div class="wpb_text_column">';
    $hook_cat_helper=$post->ID;
    $hook_out.= hook_excerpt_dynamic(64,$post->ID);
    $hook_out.='<div class="clearfix bt_12"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    if ($prk_hook_options['postedby_blog']=="1") {
        if (function_exists('get_avatar')) {
            $hook_out.='<div class="low_wrp">';
            $hook_out.='<div class="prk_author_avatar prk_lf">';
            $hook_out.='<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
            if (get_the_author_meta('prk_author_custom_avatar')!="") {
                $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar'), 56, 0, false, false);
                $hook_out.='<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
            }
            else {
                if (get_avatar(get_the_author_meta('email'),'216')) {
                    $hook_out.=get_avatar(get_the_author_meta('email'),'216');
                }
            }
            $hook_out.='</a>';
            $hook_out.='</div>';
        }
        $hook_out.='<div class="hook_blog_uppercased prk_75_em prk_heavier_600 header_font hook_anchor prk_lf hook_colored_link">';
        $hook_out.=esc_attr($hook_translated['posted_by_text']).' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="not_zero_color">'.get_the_author().'</a>';
        $hook_out.='</div>';
        $hook_out.='</div>';
    }
    $hook_out.='</div>';
}
$hook_post_counter++;
endwhile;
$hook_out.='</div>';
if ($hook_stop_flag==false) {
    $hook_out.='<div class="outer_load_more">';
    $hook_out.='<div class="blog_load_more theme_button" data-no_more="'.esc_attr($hook_translated['no_more']).'">';
    $hook_out.='<a href="#">';
    $hook_out.=esc_attr($hook_translated['load_more']);
    $hook_out.='</a>';
    $hook_out.='<i class="hook_button_arrow hook_fa-chevron-down not_zero_color"></i>';
    $hook_out.='</div>';
    $hook_out.='<div id="ajax_spinner" class="spinner-icon"></div>';
    $hook_out.='</div>';
}
else if ($hook_nav_type=='ajaxed') {
    $hook_out.='<div class="clearfix bt_4x"></div><div class="clearfix bt_4x"></div>';
}
endif; 
//SHOW NAVIGATION
if ($hook_query->max_num_pages>1 && $hook_nav_type!='ajaxed') {
    $hook_out.='<div id="entries_navigation_blog" class="row hook_blog_uppercased prk_bordered_top">';
    $hook_out.='<div class="small-12 small-centered">';
    $hook_out.='<div id="prk_nav_inner" class="hook_anchor">';
    $hook_out.='<div class="small-12 header_font small_headings_color prk_heavier_600">';
    $hook_out.=get_next_posts_link('<div class="prk_lf navigation-previous-blog"><i class="prk_lf hook_fa-chevron-left prk_lf"></i><div class="prk_lf"><div class="blog_naver_left">'.esc_attr($hook_translated['older']).'</div></div></div>',$hook_query->max_num_pages);
    $hook_out.=get_previous_posts_link('<div class="prk_rf hook_right_align navigation-next-blog"><div class="prk_lf"><div class="blog_naver_right">'.esc_attr($hook_translated['newer']).'</div></div><i class="hook_fa-chevron-right prk_lf"></i></div>',$hook_query->max_num_pages);
    $hook_out.='</div>';
    $hook_out.='<div class="clearfix"></div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
    $hook_out.='</div>';
}
$hook_out.='</div>';
$hook_out.='</div>';
echo hook_output().$hook_out;
if ($hook_show_sidebar) 
{
    ?>
    <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
        <div class="simple_line show_later"></div>
        <?php get_sidebar(); ?>
    </aside>
    <?php
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
</div>
</div>
<?php
}
?> 
<?php get_footer(); ?>