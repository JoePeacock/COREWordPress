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

get_header(); 

$category = get_the_category();
var_dump($category[0]);
$category_id = $category->cat_ID;

$args = array( 'post_type' => 'project', 'posts_per_page' => 10, 'cat' => $category_id);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
  the_title();
  echo '<div class="entry-content">';
  the_content();
  echo '</div>'; ?>

<?php endwhile; ?>


<?php while ( have_posts() ) : the_post(); ?> 
<div class="page-body">
  <div class="container">
    <div class="row">
      <div class="span12">
        <?php if ( function_exists( 'breadcrumbs' ) ) breadcrumbs(); ?>
      </div>
    </div>
    <header class="page-title">
      <h1><?php single_cat_title(); ?></h1>
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
