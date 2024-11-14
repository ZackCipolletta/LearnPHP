<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
  // takes 3 arguments; 1 the name space, 2 the route (the ending part of the URL)
  // 3 (associative) array that describes what should happen when someone visits the url
  register_rest_route('university/v1', 'search', array(
    'methods' => 'GET',
    'callback' => 'universitySearchResults'
  ));

};


function universitySearchResults () {
  return 'Congratulations, you created a custom route.';
}