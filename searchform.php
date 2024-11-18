<!-- by default a form will submit itself to it's own url. But my adding the action and a url
it will ihnstead submit to the specified url page.
By Echoing out the site URL and a '/' it will submit to the homepage url for hte WP installation -->
<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
  <label class="headline headline--medium" for="s">Perform a New Search:</label>
  <div class="search-form-row">
    <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s">
    <input class="search-submit" type="submit" value="Search">
  </div>
</form>