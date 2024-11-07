<?php

// used to display POSTS
get_header();

while (have_posts()) {
  the_post(); ?>
  <div class="page-banner">

    <div class="page-banner__bg-image"
      style="background-image: url(<?php $pageBannerImage = get_field('page_banner_background_image'); echo $pageBannerImage['sizes']['pageBanner'] ?>)">
    </div>

    <div class="page-banner__content container container--narrow">
      
      <h1 class="page-banner__title"><?php the_title() ?> </h1>

      <div class="page-banner__intro">
        <p><?php the_field('page_banner_subtitle') ?>
        </p>
      </div>

    </div>

  </div>

  <div class="container container--narrow page-section">


    <div class="generic-content">
      <div class="row group">

        <div class="one-third">
          <!-- the nickname of a custom image size from functions.php file -->
          <?php the_post_thumbnail('professorPortrait'); ?>
        </div>

        <div class="two-thirds">
          <?php the_content(); ?>
        </div>

      </div>

    </div>

    <?php

    $relatedPrograms = get_field('related_programs');

    if ($relatedPrograms) {

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium" >Subject(s) Taught</h2>';
      echo '<ul class="link-list min-list">';
      // Here we basically just say we are going to refer to the variable relatedPrograms and
      // refer to it as program in this loop.  It’s a convenient way to work with each item
      // individually without having to access it by index or key directly.
      // within each loop cycle, $program represents the current item from $relatedPrograms vs
      // having to say $relatedPrograms[i] and use the index position to refer to the given index
      // of the array contained in $relatedPrograms
      foreach ($relatedPrograms as $program) { ?>
        <li>
          <a href="<?php echo get_the_permalink($program) ?>">
            <?php echo get_the_title($program); ?>
          </a>
        </li>
    <?php }
      echo '</ul>';
    }

    ?>

  </div>
<?php }

get_footer();
?>