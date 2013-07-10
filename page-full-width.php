<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Default Page
 * Description: Page template with a content container and right sidebar
 * Author: Joseph Peacock
 *
 * @package WordPress
 *
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?> 
<div class="page-body">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>
    <header class="page-title">
      <h1><?php the_title();?></h1>
    </header>
    <div class="row-fluid content">
      <div class="span12">
        <?php the_content();?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>



<?php get_footer(); ?>