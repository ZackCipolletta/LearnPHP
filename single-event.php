<?php

// used to display POSTS
get_header();

while (have_posts()) {
  the_post(); ?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title() ?> </h1>
      <div class="page-banner__intro">
        <p>DON'T FORGET TO REPLACE ME LATER</p>
      </div>
    </div>
  </div>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          Events Home
        </a>
        <span class="metabox__main">
          <?php the_title() ?>

        </span>
      </p>
    </div>

    <div class="generic-content"><?php the_content(); ?></div>


    <?php

    $relatedPrograms = get_field('related_programs');

    // Here we basically just say we are going to refer to the variable relatedPrograms and
    // refer to it as program in this loop.  It’s a convenient way to work with each item
    // individually without having to access it by index or key directly.
    // within each loop cycle, $program represents the current item from $relatedPrograms vs
    // having to say $relatedPrograms[i] and use the index position to refer to the given index
    // of the array contained in $relatedPrograms
    foreach($relatedPrograms as $program) {
      echo get_the_title($program);
    }


    ?>


  </div>
<?php }

get_footer();
?>