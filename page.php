<?php
// used to display PAGES
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

    <?php
    $theParent = wp_get_post_parent_id(get_the_ID());
    // Will only run if the current page is a child page
    // If the current page does not have a parent, the ID will default to 0 (false)
    if ($theParent) { ?>

      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title() ?></span>
        </p>
      </div>

    <?php }
    ?>



    <?php 
    // get_pages() is instructed to return an array containing all child pages of the 
    // current page. The id of the current page is retrieved using the get_the_id() function.
    $testArray = get_pages(array(
      'child_of' => get_the_ID()
    )); 

    // if the current page has a parent or if it IS a parent then show the div
    if ($theParent or $testArray) { ?>

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>
      "><?php echo get_the_title($theParent) ?>
          </a></h2>
        <ul class="min-list">
          <?php
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_ID();
          }

          // displays an array of child pages of the current page
          // by default WP arranges pages in alphabetical order
          wp_list_pages(array(
            'title_li' => null,
            'child_of' => $findChildrenOf,
            // allows you to set the order number manually using the UI menu 
            // by adjusting the 'order' number of a given page
            'sort_column' => 'menu_order'
          ));
          ?>

        </ul>
      </div>

    <?php   } ?>


    <div class="generic-content">
      <?php the_content(); ?>
    </div>
  </div>

<?php }

get_footer();

?>