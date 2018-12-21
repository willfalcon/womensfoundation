<?php 

/* Template Name: Listed Grants */

get_header();

$hook_show_sidebar=$prk_hook_options['right_sidebar'];

if ($hook_show_sidebar=="1") {
  $hook_show_sidebar=true;
} else {
  $hook_show_sidebar=false;
}

if (get_field('show_sidebar')=="yes") {
  $hook_show_sidebar=true;
}

if (get_field('show_sidebar')=="no") {
  $hook_show_sidebar=false;
}

$hook_show_title=true;

if (get_field('show_title')=="no") {
  $hook_show_title=false;
}

$hook_show_slider=get_field('featured_slider');

if (get_field('featured_slider_autoplay')=="1") {
    $hook_autoplay="true";
} else {
  $hook_autoplay="false";
}

$hook_delay=get_field('featured_slider_delay');

if (get_field('featured_slider_supersize')=="1") {
  $hook_fill_height="super_height";
} else {
  $hook_fill_height="";
}

if (get_field('featured_slider_arrows')=="1") {
  $hook_navigation="true";
} else {
  $hook_navigation="false";
}

if (get_field('featured_slider_parallax')=="1") {
  $hook_parallax="owl_parallaxed";
} else {
  $hook_parallax="owl_regular";
}

if (get_field('featured_slider_dots')=="1") {
  $hook_pagination="true";
} else {
  $hook_pagination="false";
}

if (get_field('featured_slider_anim')!="") {
  $hook_slider_anim=get_field('featured_slider_anim');
}

if (get_field('featured_header')=="1") {
  $hook_featured_style='';
} else {
  $hook_featured_style=' class="hook_forced_menu"';
}

$hook_inside_filter="";

if (get_field('slide_filter')!="") {
  $hook_filter=get_field('slide_filter');
  foreach ($hook_filter as $hook_child) {
    $hook_inside_filter.=$hook_child->slug.", ";
  }
}

?>

<?php if (get_field('dots_navigation')=="1" && has_nav_menu('prk_main_navigation')) : ?>
  <div id="dotted_navigation" class="header_font unstyled prk_11_em prk_heavier_600">
    <?php
      if (isset($post->ID) && get_post_meta($post->ID,'top_menu',true)!="" && get_post_meta($post->ID,'top_menu',true)!="null") {
        wp_nav_menu(
          array(
            'menu' => get_post_meta($post->ID,'top_menu',true),  
            'menu_class' => 'hook-mn sf-vertical '.$prk_hook_options['menu_font'],
            'link_after' => '',
            'walker' => new rc_scm_walker
          )
        );
      } else {
        wp_nav_menu(
          array(
            'theme_location' => 'prk_main_navigation', 
            'menu_class' => 'hook_dotted unstyled',
            'link_after' => '',
            'walker' => new rc_scm_walker
          )
        );
      }
    ?>
  </div>
<?php endif; ?>

<div id="hook_ajax_inner"<?php echo hook_output().$hook_featured_style; ?>>
  <div id="hook_content">
    <?php
      if ($hook_show_title==true) {
        $hook_uppercase="";
        if (get_field('uppercase_title')=="1") {
          $hook_uppercase=" uppercased_title";
        }
        echo '<div id="classic_title_wrapper">';
        echo '<div class="small-centered columns prk_inner_block'.esc_attr($hook_uppercase).'">';
        hook_output_title();
        echo '</div>';
        echo '</div>';
      }
       
      if ($hook_show_slider=="yes") {
        if (get_field('limited_slider')=="1") {
          echo '<div class="clearfix bt_3x"></div>';
          echo '<div class="prk_inner_block small-12 small-centered columns">';
        }
        echo '<div id="owl-row" class="featured_owl '.esc_attr($hook_parallax).'">'; 
        echo do_shortcode('[prk_slider id="hook_slider-'.get_the_ID().'" category="'.esc_attr($hook_inside_filter).'" autoplay="'.esc_attr($hook_autoplay).'" delay="'.esc_attr($hook_delay).'" sl_size="'.esc_attr($hook_fill_height).'" pagination="'.esc_attr($hook_pagination).'" navigation="'.esc_attr($hook_navigation).'" parallax_effect="'.esc_attr($hook_parallax).'" featured_slider_anim="'.esc_attr($hook_slider_anim).'"]');
        if (get_field('featured_slider_down_arrow')=="1") {
          $custom_color="default";
          if (get_field('featured_arrow_color')!="") {
            $custom_color=get_field('featured_arrow_color');
          }
          echo '<a href="#" class="site_background_colored hook_anchor" data-color="'.get_field('featured_arrow_color').'"><div class="hook_next_arrow hook_sp_arrow"><i class="mdi-chevron-down"></i></div></a>';
        }
        echo '</div>';
        if (get_field('limited_slider')=="1") {
          echo '</div>';
        }
      }
      if ($hook_show_slider=="revolution") {
        echo '<div class="prk_rv">'; 
        echo do_shortcode('[rev_slider '.esc_attr(get_field('revolution_slider')).']');
        echo '</div><div id="mobile_sizer"></div>';
      }
    ?>

    <?php if ($hook_show_sidebar) : ?>
      <div class="small-centered columns prk_inner_block small-12 row">
        <div class="row">
          <div class="small-9 columns prk_bordered_right prk_extra_r_pad">
    <?php else : ?>
      <div id="s_sec_wp">
        <div id="hook_super_sections">
          <div id="s_sec_inner" class="row">
    <?php endif; ?>
            <?php while ( have_posts() ) : the_post(); ?>
              <?php
                if(has_shortcode(get_the_content(),'vc_row') && HOOK_VC_ON==true) {
                  the_content();
                } else {
                  if (HOOK_VC_ON==true && (has_shortcode(get_the_content(),'woocommerce_cart') || has_shortcode(get_the_content(),'woocommerce_checkout') || has_shortcode(get_the_content(),'woocommerce_pay') || has_shortcode(get_the_content(),'woocommerce_thankyou') || has_shortcode(get_the_content(),'woocommerce_order_tracking') || has_shortcode(get_the_content(),'woocommerce_my_account') || has_shortcode(get_the_content(),'woocommerce_edit_address') || has_shortcode(get_the_content(),'woocommerce_view_order') || has_shortcode(get_the_content(),'woocommerce_change_password') || has_shortcode(get_the_content(),'woocommerce_lost_password') || has_shortcode(get_the_content(),'woocommerce_logout'))) {
                    echo do_shortcode('[vc_row][vc_column][vc_column_text]'.get_the_content().'[/vc_column_text][/vc_column][/vc_row]');
                  } else {
                    the_content();
                    echo '<div class="clearfix bt_4x"></div>';
                  }
                }
                wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>'));
              ?>
            <?php endwhile; ?>
              
            <?php if (comments_open()) : ?>
              <?php if ($hook_show_sidebar) : ?>
                <?php comments_template(); ?>
              <?php else : ?>
                <div id="hook_comments" class="small-centered columns prk_inner_block small-12 row">
                  <?php comments_template(); ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>
            <div class="clearfix"></div>
          </div>

          <?php if ($hook_show_sidebar) : ?>
            <div id="hook_sidebar" class="<?php echo HOOK_SIDEBAR_CLASSES; ?>">
              <?php get_sidebar(); ?>
            </div>
            <div class="clearfix"></div>
          <?php endif; ?>

        </div>
      </div>

      <?php get_template_part( 'listed-grants' ); ?>

  </div>
</div>
<?php get_footer(); ?>