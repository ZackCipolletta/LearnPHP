<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset') ?>
    ">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left">
        <a href="<? echo site_url() ?>"><strong>Fictional</strong> University</a>
      </h1>
      <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">

          <!-- <?php
                wp_nav_menu(array(
                  'theme_location' => 'headerMenuLocation'
                ))
                ?> -->

          <ul>
            <!-- Highlights the the corresponding nav link in yellow for 
              the current page and its child pages. 

              In the function wp_get_post_parent_id() WordPress understands 0
              to mean the current page so we don't need to pass the function
              get_the_ID() as an argument (which would be harder to follow and be messy).

              If the function wp_get_post_parent_id() evaluates to 15 (the id of the about us page) or if the current page's parent is the about us page then echo out the class.
              -->

            <li
              <?php if (is_page('about-us') or wp_get_post_parent_id(0) === 15) echo 'class="current-menu-item" ' ?>>
              <a href="<? echo site_url('/about-us') ?>">About Us</a>
            </li>
            <li <?php
                if (get_post_type() == 'program') echo 'class="current-menu-item"'
                ?>>
              <a href="<?php echo get_post_type_archive_link('program') ?> ">Programs</a>
            </li>
            <li <?php
                if (get_post_type() == 'event' or is_page('past-events'))
                  echo 'class="current-menu-item" '
                ?>>
              <a href="<?php echo get_post_type_archive_link('event') ?>">Events</a>
            </li>
            <li <?php if (get_post_type() === 'campus') echo 'class="current-menu-item" '  ?> 
            >
              <a href="<?php echo get_post_type_archive_link('campus') ?> ">Campuses</a>
            </li>
            <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>>
              <a href="<?php echo site_url('/blog') ?>">Blog</a>
            </li>
          </ul>
        </nav>
        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        </div>
      </div>
    </div>
  </header>