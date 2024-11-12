<?php

function pageBanner($args = NULL)
{
  if (!isset($args['title'])) {
    $args['title'] = get_the_title();
  }

  if (!isset($args['subtitle'])) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }

  if (!isset($args['photo'])) {
    if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }

?>
  <div class="page-banner">

    <div class="page-banner__bg-image"
      style="background-image: url(<?php echo $args['photo']; ?>)">
    </div>

    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title'] ?> </h1>

      <div class="page-banner__intro">
        <p><?php echo $args['subtitle'] ?>
        </p>
      </div>

    </div>

  </div>

<?php

}


function university_files()
{
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY, NULL, '1.0', true);
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
  /* takes 2 args (first name or nickname for main stylesheet, 2nd is location
  that points to file. in this case this wp function performs the action).
  */
}

add_action('wp_enqueue_scripts', 'university_files');
/* first arg is type of instruction (in the form of a function) (in this 
case css or js files), second arg is name of a function to run.
This function tells WP to run the university_files function right before it runs any scripts in the head of the document. (In this case at least that is the wp_head() function). So, just before running the function wp_head(), run the university_files function.
*/

function university_features()
{
  // The first argument is the name we give for this particular menu location
  // The second argument is the text that will show up in the WP admin screen

  // register_nav_menu('headerMenuLocation', 'Header Menu Location');
  // register_nav_menu('footerLocationOne', 'Footer Location One');
  // register_nav_menu('footerLocationTwo', 'Footer Location Two');

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  // creates a custom image size of any uploaded photo. Nickname for image size, Width, Height
  // crop image or not (default false).
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
  // only runs if you are on the front end (not in admin) and you are on the 'program' 
  // archive page AND only if this is the main query (url)
  if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('post_per_page', -1);
  }

  // the function is_main_query() is a failsafe to ensure the if statement only runs if the query
  // being run is the default URL based query (the one that searches for /events or /blog, etc)
  // this way the function won't run for the admin for something unintended
  if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {
  $api['key'] = GOOGLE_MAPS_API_KEY;
  return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');