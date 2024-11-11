<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>)"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="<?php echo get_post_type_archive_link('program') ?>
    " class="btn btn--large btn--blue">Find Your Major</a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

      <?php
      // This object will now contain an array of TWO 'event' posts.
      $today = date('Ymd');
      $homepageEvents = new WP_Query(array(
        'posts_per_page' => 2,
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
          )
        )
      ));

      while ($homepageEvents->have_posts()) {
        $homepageEvents->the_post();
        // get_template_part function takes 2 arguments; the second is optional
        // in order to use the second argument, the file must be named using the convention 'blank-blank'
        // the first argument is the name before the dash and the second is the name after the dash.
        // this can be useful when making the second argument dynamic using a function for instance.
        // point to the folder and then the file in the folder. We don't even need to put the
        // '.php' of the file - we only need the slug name of the file.
        get_template_part('template-parts/content-event');
      }
      ?>

      <p class="t-center no-margin">
        <a href="<?php echo get_post_type_archive_link('event') ?>"
          class="btn btn--blue">View All Events
        </a>
      </p>
    </div>
  </div>
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
      <?php
      // creates a custom object named 'homepagePosts' that is an instance of the WP_Query object
      // we cna then take the WP_Query object instance in homepagePosts and tell it to get only
      // return 2 posts per page.
      // homepagePosts will be an array containing our blog posts.
      $homepagePosts = new WP_Query(array(
        'posts_per_page' => 2, // here we tell our object to return only 2 posts per page
        // 'category_name' => 'awards' // this would return only posts of the category 'awards'
      ));


      // we can then run the function have_posts only on our custom homepagePosts object and tell 
      // instead of all posts that exist in our WP page. WE do the same with the the_title function
      while ($homepagePosts->have_posts()) {
        $homepagePosts->the_post(); ?>
        <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>
          ">
            <span class="event-summary__month"><?php the_time('M') ?>
            </span>
            <span class="event-summary__day"><?php the_time('d') ?>
            </span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>
            "><?php the_title() ?>
              </a></h5>
            <!-- print to the page the result of the get_the_content function, limited to the
            first 18 words (by the wp_trim_words function) -->
            <!-- the_excerpt() function prints to the page the excerpt for this blog post created in the admin dashboard  -->
            <p>
              <?php
              if (has_excerpt()) {
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              ?>
              <a href="<?php the_permalink() ?>"
                class="nu gray">Read more</a>
            </p>
          </div>
        </div>
      <?php }
      wp_reset_postdata(); // resets WP data and global variables back to default

      ?>



      <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>
      " class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/bus.jpg') ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/apples.jpg') ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/bread.jpg') ?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>

<?php
get_footer();

?>