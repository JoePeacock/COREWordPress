<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Default Page
 * Description: Page template with a content container and right sidebar
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
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>
    <header class="page-title">
      <h1><?php the_title();?></h1>
    </header>
    <div class="row-fluid content">
      <div class="span8">
        <?php the_content();?>
        <?php endwhile; ?>
      </div>
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>


<?php get_footer(); ?>
