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
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          All Programs
        </a>
        <span class="metabox__main">
          <?php the_title() ?>

        </span>
      </p>
    </div>

    <div class="generic-content"><?php the_content(); ?> </div>

    <?php
    $relatedProfessors = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'professor',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        // If the array of array of related_programs contains (or LIKE) the ID number of the
        // current program post, that is what we are looking for, add it to the 
        // $homepageEvents array. 
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          // this is basically PHPs way of concatenating double quotes onto the result of
          // get_the_ID(). instead of " + get_the_ID + ". This way PHP knows we are searching
          // for the string value of the ID, so it doesn't return a false positive.
          'value' => '"' . get_the_ID() . '"'
        ),
      )
    ));

    if ($relatedProfessors->have_posts()) {

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

      echo '<ul class="professor-cards">';
      while ($relatedProfessors->have_posts()) {
        $relatedProfessors->the_post(); ?>
        <li class="professor-card__list-item">
          <a class="professor-card" href="<?php the_permalink(); ?>">
          <img class="professor-card__image" 
          src="<?php the_post_thumbnail_url('professorLandscape') ?> ">
          <span class="professor-card__name"><?php the_title(); ?>
          </span>
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

    // This object will now contain an array of TWO 'event' posts.
    $today = date('Ymd');
    $homepageEvents = new WP_Query(array(
      'posts_per_page' => 2,
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        ),
        // If the array of array of related_programs contains (or LIKE) the ID number of the
        // current program post, that is what we are looking for, add it to the 
        // $homepageEvents array. 
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          // this is basically PHPs way of concatenating double quotes onto the result of
          // get_the_ID(). instead of " + get_the_ID + ". This way PHP knows we are searching
          // for the string value of the ID, so it doesn't return a false positive.
          'value' => '"' . get_the_ID() . '"'
        ),
      )
    ));

    if ($homepageEvents->have_posts()) {

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

      while ($homepageEvents->have_posts()) {
        $homepageEvents->the_post(); ?>
        <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month">
              <?php
              // get_field (or the_field) function comes from SCF plugin which allows us to create
              // custom fields. In this case we created a custom event date field with a date picker.
              // Here we are using the get_field function to get the 'event_date' field and provide
              // us w/the value in teh event_date field (the date we selected).
              $eventDate = new DateTime(get_field('event_date'));
              echo $eventDate->format('M')
              ?>
            </span>
            <span class="event-summary__day">
              <?php echo $eventDate->format('d') ?>
            </span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny">
              <a href="<?php the_permalink() ?>"><?php the_title() ?>
              </a>
            </h5>
            <p>
              <?php
              if (has_excerpt()) {
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              ?>
              <a href="<?php the_permalink() ?>"
                class="nu gray">Learn more</a>
            </p>
          </div>
        </div>

    <?php }
    }

    ?>

  </div>
<?php }


get_footer();
?>