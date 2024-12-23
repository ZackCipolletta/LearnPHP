<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
  // takes 3 arguments; 1 the name space, 2 the route (the ending part of the URL)
  // 3 (associative) array that describes what should happen when someone visits the url
  register_rest_route('university/v1', 'search', array(
    'methods' => 'GET',
    'callback' => 'universitySearchResults'
  ));
};

function universitySearchResults($data)
{
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
    // s stands for search
    's' => sanitize_text_field($data['term'])
  ));

  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );

  // however many number of posts are in the collection of the 'professors' object is however
  // many times the loop should run
  while ($mainQuery->have_posts()) {
    // this gets all the data from the relevant post ready and accessible
    $mainQuery->the_post();

    if (get_post_type() === 'post' || get_post_type() === 'page') {
      // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author()
      ));
    }

    if (get_post_type() === 'professor') {
      // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
      array_push($results['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        // get_the_post_thumbnail_url takes 2 arguments: 1 which post you want to get the thumbnail
        // image for (0 means the current post), 2 the size
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    }

    if (get_post_type() === 'program') {
      $relatedCampuses = get_field('related_campus');

      if($relatedCampuses) {
        foreach($relatedCampuses as $campus){
          array_push($results['campuses'], array(
            'title' => get_the_title($campus),
            'permalink' => get_the_permalink($campus),

          ));
        }
      }
      
      // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
      array_push($results['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_ID()
      ));
    }

    if (get_post_type() === 'campus') {
      // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
      array_push($results['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }

    if (get_post_type() === 'event') {
      // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
      $eventDate = new DateTime(get_field('event_date'));
      $description = null;
      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }
      array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => $description
      ));
    }
  }

  if ($results['programs']) {
    $programsMetaQuery = array('relation' => 'OR');

    foreach ($results['programs'] as $item) {
      // takes 2 arguments: 1 the array you want to add on to, 2 what you want to add on to the array
      array_push($programsMetaQuery,  array(
        'key' => 'related_programs',
        'compare' => 'LIKE',
        'value' => '"' . $item['id'] . '"'
      ));
    }

    $programRelationshipQuery = new WP_Query(
      array(
        'post_type' => array('professor', 'event'),
        // This array inside another array let's us search related programs. Inside the nested array we are
        // searching the custom field we want to look in - in this case related_programs - in WP (the key) 
        // and using the compare and value keys to refine any results from the related_programs 
        'meta_query' => $programsMetaQuery
      )
    );

    while ($programRelationshipQuery->have_posts()) {
      $programRelationshipQuery->the_post();

      if (get_post_type() === 'event') {
        // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
        $eventDate = new DateTime(get_field('event_date'));
        $description = null;
        if (has_excerpt()) {
          $description = get_the_excerpt();
        } else {
          $description = wp_trim_words(get_the_content(), 18);
        }
        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $eventDate->format('M'),
          'day' => $eventDate->format('d'),
          'description' => $description
        ));
      }

      if (get_post_type() === 'professor') {

        // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
        array_push($results['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          // get_the_post_thumbnail_url takes 2 arguments: 1 which post you want to get the thumbnail
          // image for (0 means the current post), 2 the size
          'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));
      }
    };

    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
  }

  return $results;
}
