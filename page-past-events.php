<?php

get_header();
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.'
));
?>

<div class="container container--narrow page-section">
  <?php
  $today = date('Ymd');
  $pastEvents = new WP_Query(array(
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
      array(),
      'key' => 'event_date',
      'compare' => '<',
      'value' => $today,
      'type' => 'numeric'
    )
  ));

  // the '->' tells WP to look only within the preceding object. In this instance we are telling
  // WP to look inside the pastEvents object and and while it has posts, do the following.
  // the same for the the_post function: look in the pastEvents function and get the post(s) then 
  // do the following stuff with it.
  while ($pastEvents->have_posts()) {
    $pastEvents->the_post();
    get_template_part('template-parts/content-event');
  }
  echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
  ));

  ?>

</div>

<?php
get_footer();
?>