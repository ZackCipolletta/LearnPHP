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
  $professors = new WP_Query(array(
    'post_type' => 'professor',
    // s stands for search
    's' => sanitize_text_field($data['term'])
  ));

  $professorResults = array();

  // however many number of posts are in the collection of the 'professors' object is however
  // many times the loop should run
  while ($professors->have_posts()) {
    // this gets all the data from the relevant post ready and accessible
    $professors->the_post();
    // takes 2 arguments: 1 the array you want to add onto, 2 what you want to add on to the array
    array_push($professorResults, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink()
    ));
  }

  return $professorResults;
}
