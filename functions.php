<?php
function university_files()
{
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
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
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
