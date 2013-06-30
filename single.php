<?php
/**
 * The template for displaying all posts.
 *
 * Default Post Template
 *
 * Page template with a fixed 940px container and right sidebar layout
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="row">
  <div class="container">
    <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
  </div><!--/.container -->
</div><!--/.row -->

 <div class="container">
    <header class="post-title">
      <h1><?php the_title();?></h1>
    </header>

      <div class="row content">
        <div class="span8">
           <p class="meta"><?php the_date();?></p>
          <?php the_content();?>
          <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
          <?php endwhile; // end of the loop. ?>
          <hr />
           <?php comments_template(); ?>

        </div><!-- /.span8 -->

        <?php get_sidebar('blog'); ?>


<?php get_footer(); ?>