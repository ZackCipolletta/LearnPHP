<?php
// used to display PAGES
get_header();

while (have_posts()) {
  the_post();

  pageBanner();
?>

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
      <!-- by default a form will submit itself to it's own url. But my adding the action and a url
      it will ihnstead submit to the specified url page.
      By Echoing out the site URL and a '/' it will submit to the homepage url for hte WP installation -->
      <form method="get" action="<?php echo esc_url(site_url('/')); ?>
      ">
        <input type="search" name="s">
        <input type="submit" value="Search">
      </form>


    </div>
  </div>

<?php }

get_footer();

?>