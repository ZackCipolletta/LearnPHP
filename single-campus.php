<?php

// used to display POSTS
get_header();

while (have_posts()) {
  the_post();
  pageBanner();
?>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          All Campuses
        </a>
        <span class="metabox__main">
          <?php the_title() ?>

        </span>
      </p>
    </div>

    <div class="generic-content"><?php the_content(); ?> </div>

    <?php
    $mapLocation = get_field('map_location');
    ?>

    <div class="acf-map">
      <div class="marker"
        data-lat="<?php echo $mapLocation['lat'] ?>"
        data-lng="<?php echo $mapLocation['lng']; ?>">

        <h3> <?php the_title(); ?> </h3>

        <?php echo $mapLocation['address']; ?>
      </div>
    </div>

    <?php
    $relatedPrograms = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'program',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        // If the array of array of related_programs contains (or LIKE) the ID number of the
        // current program post, that is what we are looking for, add it to the 
        // $homepageEvents array. 
        array(
          'key' => 'related_campus',
          'compare' => 'LIKE',
          // this is basically PHPs way of concatenating double quotes onto the result of
          // get_the_ID(). instead of " + get_the_ID + ". This way PHP knows we are searching
          // for the string value of the ID, so it doesn't return a false positive.
          'value' => '"' . get_the_ID() . '"'
        ),
      )
    ));

    if ($relatedPrograms->have_posts()) {

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Programs Available At This Campus</h2>';

      echo '<ul class="min-list link-list">';
      while ($relatedPrograms->have_posts()) {
        $relatedPrograms->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
          </a>
        </li>

    <?php }
      echo '</ul>';
    }

    // wp_reset_postdata() resets the global 'post' object back to the default URL based query.
    // whenever you run multiple custom queries on a single page, run the reset postdata function
    // between the queries to reset everything back to default. Otherwise WP will refer to the last
    // custom query ran as the post it references (so things like the_title or the_ID will refer to 
    // the last custom query instead of the URL query for instance).
    wp_reset_postdata();

    ?>

  </div>
<?php }


get_footer();
?>