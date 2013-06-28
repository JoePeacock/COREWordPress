<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.6
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