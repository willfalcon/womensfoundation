<?php 
    get_header();
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
    if ($prk_hook_options['autoplay_blog']=="1")
    {
        $hook_autoplay="true";
    }
    else
    {
        $hook_autoplay="false";
    }
    if (get_field('no_slider')=="1"){
        $hook_slider_class="";
    }
    $hook_featured_css=" post_without_media";
    if (get_field('video_2')!="") {
        $hook_featured_css=" post_with_video";
    }
    else {
        if (get_field('skip_featured')=="" && has_post_thumbnail($post->ID)) {
            $hook_featured_css=" post_with_media";
        }
        else {
            for ($hook_count=2;$hook_count<11;$hook_count++)
            {
                if (get_field('image_'.$hook_count)!="") {
                    $hook_featured_css=" post_with_media";
                    $hook_count=11;
                }
            }
        }
    }
    $hook_header_position=$prk_hook_options['header_align_blog'];
    while (have_posts()) : the_post();
        if (get_field('featured_color')!="" && $prk_hook_options['use_custom_colors']=="1") {
            $hook_featured_color=get_field('featured_color');
            $hook_featured_class=' featured_color';
        }
        else {
            $hook_featured_color="default";
            $hook_featured_class="";
        }
        if (has_post_thumbnail($post->ID) && (get_field('featured_header')=="featured_100" || get_field('featured_header')=="featured")) {
            $hook_header_class=" hook_featured_header";
        } 
        else {
            $hook_header_class=" hook_forced_menu";
        }     
        ?>
        <div id="hook_ajax_inner" class="hook_blog_single row<?php echo esc_attr($hook_header_class.$hook_featured_class); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
            <?php
                hook_sticky_blog($post->ID);
                if ($hook_header_class==" hook_featured_header") {
                    if (get_field('featured_header')=="featured_100") {
                        $hook_header_position.=" forced_row vertical_forced_row hook_first_row";
                        ?>
                        <div class="featured_owl owl_parallaxed">
                            <div class="per_init owl-carousel hook_shortcode_slider super_height" data-navigation="true" data-autoplay="<?php echo esc_attr($hook_autoplay); ?>" data-delay="<?php echo esc_attr($prk_hook_options['delay_blog']); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                                <?php
                    }
                    else {
                        $hook_header_position.=" unforced_row";
                        ?>
                        <div class="featured_owl owl_parallaxed">
                            <div class="per_init owl-carousel hook_shortcode_slider" data-navigation="true" data-autoplay="<?php echo esc_attr($hook_autoplay); ?>" data-delay="<?php echo esc_attr($prk_hook_options['delay_blog']); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                        <?php
                    }
                                $hook_ext_count=0;
                                if (get_field('skip_featured')=="") {
                                    $hook_vt_image = vt_resize(get_post_thumbnail_id($post->ID),'',0 , 0, false , $hook_retina_device );
                                    $hook_parallaxy=' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 400px;" style="background-image: url('.esc_url($hook_vt_image['url']).');"';
                                    echo '<div id="hook_slide_'.esc_attr($hook_ext_count).'" class="item"'.($hook_parallaxy).'>';
                                    echo '<img class="hook_vsbl" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" data-or_w="'.esc_attr($hook_vt_image['width']).'" data-or_h="'.esc_attr($hook_vt_image['height']).'"  alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                                    echo '</div>';
                                    $hook_ext_count=1;
                                }
                                for ($hook_count=2;$hook_count<11;$hook_count++) {
                                    if (get_field('image_'.$hook_count)!="") {
                                        $hook_in_image=wp_get_attachment_image_src(get_field('image_'.$hook_count),'full');
                                        $hook_vt_image = vt_resize( '', $hook_in_image[0] , 0, 0, false , $hook_retina_device);
                                        $hook_parallaxy=' data-0-top-top="background-position: 50% 0px;" data-0-top-bottom="background-position: 50% 400px;" style="background-image: url('.esc_url($hook_vt_image['url']).');"';
                                        echo '<div id="hook_slide_'.esc_attr($hook_ext_count).'" class="item"'.($hook_parallaxy).'>';
                                        echo '<img class="hook_vsbl" src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" data-or_w="'.esc_attr($hook_vt_image['width']).'" data-or_h="'.esc_attr($hook_vt_image['height']).'"  alt="'.esc_attr(hook_alt_tag(true,get_field('image_'.$hook_count))).'" />';
                                        echo '</div>';
                                        $hook_ext_count++;
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <div id="single_blog_info" class="<?php echo esc_attr($hook_header_position); ?>">
                <div class="small-12 columns prk_inner_block small-centered">
                    <div class="wpb_column column_container">
                        <h1 id="single_blog_title" class="<?php echo esc_attr($prk_hook_options['headings_align']); ?> header_font zero_color prk_break_word">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>
                <div id="single_post_teaser" class="small-12 columns prk_inner_block small-centered <?php echo esc_attr($prk_hook_options['headings_align']); ?>">
                    <div id="single_blog_meta" class="header_font prk_heavier_600 small_headings_color hook_blog_uppercased prk_85_em">
                        <div class="single_blog_meta_div">
                            <?php
                                $hook_line_counter=0;
                                if (is_sticky()) {
                                    $hook_line_counter++;
                                    ?>
                                        <div class="prk_lf sticky_text">
                                            <?php echo esc_attr($hook_translated['sticky_text']); ?>
                                        </div>
                                    <?php
                                }
                                if ($prk_hook_options['show_date_blog']=="1") {
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    $hook_line_counter++;
                                    echo '<div class="prk_lf">';
                                    echo the_time(get_option('date_format'));
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        <?php
                        if ($prk_hook_options['categoriesby_blog']=="1")
                        {
                            ?>
                            <div class="single_blog_meta_div">
                                <?php 
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    $hook_line_counter++;
                                ?>
                                <div class="prk_lf hook_anchor">
                                    <?php 
                                        //the_category(', '); 
                                        if (get_the_term_list(get_the_ID(),'focus')!="") {
                                            $hook_terms=wp_get_object_terms(get_the_ID(),'focus');
                                            $hook_count=count($hook_terms);
                                            if ($hook_count>0) {
                                                $hook_in_count=0;
                                                echo '<span class="">';
                                                foreach ( $hook_terms as $hook_term ) {
                                                    if ($hook_in_count>0)
                                                        echo ", ";
                                                    echo '' . $hook_term->name . '';
                                                    $hook_in_count++;
                                                }
                                                echo '</span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        if (comments_open()) {
                            ?>
                            <div class="single_blog_meta_div hide_much_later">
                                <?php 
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    $hook_line_counter++;
                                ?>
                                <div class="prk_lf hook_colored_link">
                                    <a href="<?php comments_link(); ?>" class="hook_anchor">        
                                        <?php 
                                            comments_number($hook_translated['comments_no_response'], $hook_translated['comments_one_response'], '% '.$hook_translated['comments_oneplus_response']);
                                        ?> 
                                    </a>
                                </div>
                            </div>
                          <?php
                        }
                        if ($prk_hook_options['postedby_blog']=="1") {
                            ?>
                            <div class="single_blog_meta_div hide_later">
                                <?php 
                                    if ($hook_line_counter>0) {
                                        echo '<div class="pir_divider">'.esc_attr($prk_hook_options['theme_divider']).'</div>';
                                    }
                                    $hook_line_counter++;
                                ?>
                                <div class="prk_lf hook_colored_link">
                                    <?php echo esc_attr($hook_translated['posted_by_text']); ?>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="hook_anchor not_zero_color"><?php echo get_the_author(); ?></a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div> 
                </div>
                <?php
                    if ($hook_header_class!=" hook_forced_menu") {
                        ?>
                        <div class="hook_read">
                            <a href="#hook_content" class="hook_anchor zero_color">
                                <i class="mdi-chevron-down"></i>
                            </a>
                        </div>
                        <?php
                    }
                    else {
                        if ($hook_featured_css==" post_with_video") {
                            echo '<div id="not_slider" class="small-12 columns prk_inner_block small-centered">';
                                $hook_el_class='prk-video-container';
                                if (strpos(get_field('video_2'),'soundcloud.com') !== false) {
                                    $hook_el_class= 'soundcloud-container';
                                }
                                echo '<div class="'.esc_attr($hook_el_class).'">'.get_field('video_2').'</div>';
                            echo '</div>';
                        }
                        if ($hook_featured_css==" post_with_media") {
                            ?>
                            <div class="featured_owl small-12 columns prk_inner_block small-centered">
                                <div class="per_init owl-carousel hook_shortcode_slider" data-navigation="true" data-autoplay="<?php echo esc_attr($hook_autoplay); ?>" data-delay="<?php echo esc_attr($prk_hook_options['delay_blog']); ?>" data-color="<?php echo esc_attr($hook_featured_color); ?>">
                                    <?php
                                        $hook_ext_count=0;
                                        if (get_field('skip_featured')=="" && has_post_thumbnail($post->ID)) {
                                            $hook_image=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'');
                                            echo '<div id="hook_slide_'.esc_attr($hook_ext_count).'" class="item">';
                                            echo '<img class="hook_vsbl abc" src="'.esc_url($hook_image[0]).'" alt="'.esc_attr(hook_alt_tag(true,get_post_thumbnail_id($post->ID))).'" />';
                                            echo '</div>';
                                            $hook_ext_count=1;
                                        }
                                        for ($hook_count=2;$hook_count<11;$hook_count++) {
                                            if (get_field('image_'.$hook_count)!="") {
                                                echo '<div id="hook_slide_'.esc_attr($hook_ext_count).'" class="item">';
                                                    $hook_in_image=wp_get_attachment_image_src(get_field('image_'.$hook_count),'full');
                                                    $hook_vt_image = vt_resize( '', $hook_in_image[0] , 0, 0, false , $hook_retina_device);
                                                    echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(true,get_field('image_'.$hook_count))).'" />';
                                                echo '</div>';
                                                $hook_ext_count++;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div> 
            <div id="hook_content" class="small-12 columns prk_inner_block small-centered">
                <div class="row">
                    <div class="<?php if ($hook_show_sidebar) {echo "small-9 columns prk_bordered_right prk_extra_r_pad"; } else {echo "small-12 columns";} ?>">
                        <article id="single_blog_inner" <?php post_class('blog_limited_width'.esc_attr($hook_featured_class)); ?> data-color="<?php echo esc_attr($hook_featured_color); ?>">                
                            <div id="single_post_content" class="on_colored prk_no_composer prk_break_word<?php if(!has_shortcode(get_the_content(),'vc_row')) {echo " prk_composer_extra";} ?>">
                                <?php
                                    the_content();
                                    wp_link_pages('before=<p class="hook_anchor">&after=</p>');
                                    if (get_the_tags()!="") {
                                        ?>
                                        <div id="prk_tags" class="twelve prk_heavier_500 header_font">
                                            <div id="prk_tag_heading">
                                                <div class="zero_color prk_heavier_600 hook_anchor">
                                                    <?php echo esc_attr($hook_translated['tags_text']); ?>
                                                </div>
                                            </div>
                                            <div id="prk_tags_inner" class="prk_buttons_list">
                                                <?php the_tags('<div class="theme_button prk_tiny">','</div><div class="theme_button prk_tiny">','</div>'); ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php
                                    }
                                    if ($prk_hook_options['share_blog']=="1") {
                                        hook_output_share($post->ID,'blog');
                                    }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                                <?php 
                                    if ($prk_hook_options['show_blog_nav']=="1" && false) {
                                        ?>
                                        <div id="single_meta_header">
                                            <div class="simple_line"></div>
                                            <div class="hook_navigation_singles header_font small_headings_color hook_anchor">
                                                <?php
                                                    $hook_adj_post_id=next_post_link_plus(array(
                                                        'order_by' => 'menu_order',
                                                        'in_same_cat' => false,
                                                        'return' => 'id')
                                                    );
                                                    $hook_adj_color=$hook_adj_class="";
                                                    if (get_field('featured_color',$hook_adj_post_id)!="" && $prk_hook_options['use_custom_colors']=="1") {
                                                        $hook_adj_color=' data-color="'.get_field('featured_color',$hook_adj_post_id).'"';
                                                        $hook_adj_class=' blog_entry_li featured_color';
                                                    }
                                                ?>
                                                <div class="navigation-previous-blog prk_lf hook_colored_link<?php echo esc_attr($hook_adj_class); ?>"<?php echo esc_attr($hook_adj_color); ?>>
                                                    <?php
                                                        $hook_next_post=get_next_post(false);
                                                        if (!empty($hook_next_post)) {
                                                            next_post_link_plus( array(
                                                            'order_by' => 'menu_order',
                                                            'in_same_cat' => false,
                                                            'format' => '%link',
                                                            'link' => '<div class="prk_lf"><div class="special_heading prk_heavier_600 prk_75_em">'.esc_attr($hook_translated['older_single']).'</div><div class="prk_heavier_600">'.$hook_next_post->post_title.'</div></div>'
                                                            ));
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                                    $hook_adj_post_id=previous_post_link_plus(array(
                                                        'order_by' => 'menu_order',
                                                        'in_same_cat' => false,
                                                        'return' => 'id')
                                                    );
                                                    $hook_adj_color=$hook_adj_class="";
                                                    if (get_field('featured_color',$hook_adj_post_id)!="" && $prk_hook_options['use_custom_colors']=="1") {
                                                        $hook_adj_color=' data-color="'.get_field('featured_color',$hook_adj_post_id).'"';
                                                        $hook_adj_class=' blog_entry_li featured_color';
                                                    }
                                                ?>
                                                <div class="navigation-next-blog prk_rf hook_right_align hook_colored_link<?php echo esc_attr($hook_adj_class); ?>"<?php echo esc_attr($hook_adj_color); ?>>
                                                    <?php
                                                        $hook_prev_post=get_previous_post(false);
                                                        if (!empty($hook_prev_post)) {
                                                            previous_post_link_plus( array(
                                                            'order_by' => 'menu_order',
                                                            'in_same_cat' => false,
                                                            'format' => '%link',
                                                            'link' => '<div class="prk_lf"><div class="special_heading prk_heavier_600 prk_75_em">'.esc_attr($hook_translated['newer_single']).'</div><div class="prk_heavier_600">'.$hook_prev_post->post_title.'</div></div>'
                                                            ));
                                                        }
                                                    ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php
                                    }
                                ?>
                            <?php
                                $hook_auth_array=get_user_by('slug', get_the_author_meta('user_nicename'));
                                if ($prk_hook_options['related_author']=="1" && isset($hook_auth_array->description) && $hook_auth_array->description!="") {
                                    ?>
                                    <div id="author_area">
                                        <div class="simple_line"></div>
                                        <?php 
                                            if (function_exists('get_avatar')) { 
                                                echo "<div class='prk_author_avatar'>";
                                                echo '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="hook_anchor">';
                                                if (get_the_author_meta('prk_author_custom_avatar')!="") {
                                                    $hook_vt_image=vt_resize( '', get_the_author_meta('prk_author_custom_avatar') ,200,0 , false , false );
                                                    echo '<img src="'.esc_url($hook_vt_image['url']).'" width="'.esc_attr($hook_vt_image['width']).'" height="'.esc_attr($hook_vt_image['height']).'" alt="'.esc_attr(hook_alt_tag(false,get_the_author_meta('prk_author_custom_avatar'))).'" />';
                                                }
                                                else {
                                                    if (get_avatar(get_the_author_meta('email'),'216')) {
                                                        echo get_avatar(get_the_author_meta('email'),'216');
                                                    }
                                                }
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                        ?>
                                        <div class="author_info">
                                            <div class="header_font">
                                                <h4 class="zero_color prk_heavier_600 small hook_anchor">
                                                    <?php echo the_author_posts_link(); ?>
                                                </h4>
                                                <?php
                                                if (get_the_author_meta('prk_subheading')!="") {
                                                    echo '<div id="single_page_teaser" class="prk_85_em small_headings_color">'.esc_attr(get_the_author_meta('prk_subheading')).'</div>';
                                                }
                                                ?>
                                            </div>
                                            <?php 
                                                echo '<div class="author_description body_colored prk_9_em">'.nl2br($hook_auth_array->description).'</div>'; 
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                            ?>
                        </article>
                    </div>
                    <?php 
                        if ($hook_show_sidebar) 
                        {
                            ?>
                            <aside id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
                                <div class="theiaStickySidebar">
                               <?php get_sidebar(); ?>
                                </div>
                            </aside>
                            <?php
                       }
                    ?>
                    </div>
            </div>
            <div class="clearfix"></div>
            <?php
                comments_template();
                //hook_related_posts($post->ID);
            ?>
        </div>
<?php endwhile; ?>
<?php get_footer(); ?>