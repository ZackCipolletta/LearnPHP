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
              <a href="<?php the_permalink() ?>"><?php the_title() ?>
              </a>
            </h5>
            <p>
              <?php
              if (has_excerpt()) {
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              ?>
              <a href="<?php the_permalink() ?>"
                class="nu gray">Learn more</a>
            </p>
          </div>
        </div>