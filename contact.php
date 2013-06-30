<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Contact
 * Description: Page template for the Contact Page
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: July 16, 2012
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?> 
<div class="page-bg">
  <div class="container page-body">
    <div class="row">
      <div class="span12">
        <div id="map_canvas" style="height:400px; margin-top:-10px; margin-bottom:5px; border-bottom:1px solid #bbb"></div>
      </div>
    </div>

    <div class="row">
      <div class="span12">
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>
    <header class="page-title">
      <h1><?php the_title();?></h1>
    </header>
    <div class="row-fluid content">
      <div class="span6">
        <?php echo do_shortcode('[contact-form-7 id="100" title="Contact form 1"]') ?>
        
      </div>
      <div class="span5">
        <?php the_content();?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var _this = this;
  setTimeout(function() { _this.renderMap() }, 0);

  function renderMap() {
      var buf = new google.maps.LatLng(42.956916, -78.708054);

      var maspeth = new google.maps.LatLng(40.731606, -73.921304);

      var center = new google.maps.LatLng(40.731606, -73.921304);

    var mapOptions = {
      center: center,
      zoom: 13,
      disableDefaultUI: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    var buffalo = new google.maps.Marker({
      position: buf,
      map: map,
    });

    var nyc = new google.maps.Marker({
      position: maspeth,
      map: map,
    });
  }
</script>

<?php get_footer(); ?>
