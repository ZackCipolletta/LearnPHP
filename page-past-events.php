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
    $pastEvents->the_post(); ?>
    <div class="event-summary">
      <a class="event-summary__date t-center" href="#">
        <span class="event-summary__month">
          <?php
          // get_field (or the_field) function comes from SCF plugin which allows us to create
          // custom fields. In this case we created a custom event date field with a date picker.
          // Here we are using the get_field function to get the 'event_date' field and provide
          // us w/the value in teh event_date field (the date we selected).
          $eventDate = new DateTime(get_field('event_date'));
          echo $eventDate->format('M')
          ?>
        </span>
        <span class="event-summary__day">
          <?php echo $eventDate->format('d') ?>
        </span>
      </a>
      <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny">
          <a href="<?php the_permalink() ?>">
            <?php the_title() ?>
          </a>
        </h5>
        <p>
          <?php echo wp_trim_words(get_the_content(), 18) ?>
          <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a>
        </p>
      </div>
    </div>

  <?php }
  echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
  ));

  ?>

</div>

<?php
get_footer();
?>