<?php

// used to display POSTS
get_header();

while (have_posts()) {
  the_post(); 
  pageBanner()
  ?>

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

    if ($relatedPrograms) {

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium" >Related Program(s)</h2>';
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