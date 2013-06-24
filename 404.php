<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.7
 *
 * Last Revised: January 22, 2012
 */
get_header(); ?>


      
<!-- Masthead
================================================== -->
<div class="page-bg">
  <div class="container page-body">
    <div class="row">
      <div class="span12">
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>
    <header class="page-title">
  <center>
      	<h1 class="bigBoy">404: Page Not Found</h1>
      	<p class="bigBoySub">Well this is embarrassing, we can't seem to find what you were looking for. Try searching again below.</p>
      </center>
    </header>
    <div class="row-fluid">
      <div class="span12">
      	<div class="search404">
       		<?php get_search_form(); ?>
       	</div>
      </div>
    </div>    
  </div>
</div>


<?php get_footer(); ?>