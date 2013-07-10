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

<div class="page-body">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>

    <?php
    global $wp_query;
    $cat_id = get_category_by_slug($wp_query->query['category_name'])->term_id; 

    $args = array( 'post_type' => 'project', 'posts_per_page' => 10, 'cat' => $cat_id);
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
    
    <header class="page-title">
      <h1><?php single_cat_title('', true) ?></h1>
    </header>
    <div class="row-fluid content">
      <div class="span12">
        <h2><?php the_title(); ?></h2>
        <?php the_content();?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
