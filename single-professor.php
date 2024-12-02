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
          <?php
          $likeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(
              // we are looking for a 'liked prof id' which is 'equal' to the value of the page ID (in this case the professor ID)
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));

          $existStatus = 'no';

          $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
              // we are looking for a 'liked prof id' which is 'equal' to the value of the page ID (in this case the professor ID)
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));

          if ($existQuery->found_posts) {
            $existStatus = 'yes';
          }

          ?>

          <span class="like-box" data-exists="<?php echo $existStatus; ?>">
            <i class="fa fa-heart-o" aria-hidden="true"></i>
            <i class="fa fa-heart" aria-hidden="true"></i>
            <!-- looks inside the likeCount object for the number of posts (in this case each post is just a professor ID. So,  we are looking for the number of posts that match a given professor ID, then echoing that out to the page.) -->
            <span class="like-count"><?php echo $likeCount->found_posts; ?>
            </span>
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