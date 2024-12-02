<?php

// used to display POSTS
get_header();

while (have_posts()) {
  the_post(); 
  pageBanner();
  ?>
  
  <div class="container container--narrow page-section">

    <div class="generic-content">
      <div class="row group">

        <div class="one-third">
          <!-- the nickname of a custom image size from functions.php file -->
          <?php the_post_thumbnail('professorPortrait'); ?>
        </div>

        <div class="two-thirds">
          <span class="like-box">
            <i class="fa fa-heart-o" aria-hidden="true"></i>
            <i class="fa fa-heart" aria-hidden="true"></i>
            <span class="like-count">3</span>
          </span>
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