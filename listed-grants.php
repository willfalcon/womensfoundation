<?php
  $listed_grant_focus_query = array(
    'taxonomy' => 'listed_grant_focus'
  );

  $listed_grant_focus = get_terms( $listed_grant_focus_query );
?>

<?php foreach ($listed_grant_focus as $focus) : ?>

  <?php 
    $focus_id = $focus->term_id;
    $bgColor = hexToRgb(get_field( 'background_color', 'term_' . $focus_id ), .45);
  ?>

  <div class="cd-focus" style="background-color: <?php echo $bgColor; ?>">
    <h2 class="cd-focus__title"><?php echo $focus->name; ?></h2>
    <p class="cd-focus__description"><?php echo $focus->description; ?></p>

    <div class="cd-focus__wrapper">

      <?php 
        $listed_grants_args = array(
          'post_type' => 'listed_grant',
          'tax_query' => array(
            array(
              'taxonomy' => 'listed_grant_focus',
              'terms' => $focus_id
            )
          ),
        );
        $listed_grants_query = new WP_Query( $listed_grants_args );
      ?>

      <?php while ( $listed_grants_query->have_posts() ) : $listed_grants_query->the_post(); ?>

        <div class="cd-grant">
          <div class="cd-grant__image-wrap">
            <?php $grant_image = get_field( 'image' ); ?>
            <img class="cd-grant__image" src="<?php echo $grant_image['sizes']['medium']; ?>" alt="<?php echo $grant_image['alt']; ?>" />
          </div>
          <h3 class="cd-grant__title"><?php the_title(); ?></h3>
          <p class="cd-grant__location"><?php the_field( 'location' ); ?>
          <div class="cd-grant__content"><?php the_content(); ?></div>
        </div>

      <?php endwhile; ?>

    </div>
  </div>

<?php endforeach; ?>