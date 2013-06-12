<?php
/**
 *
 * Description: Default Index template to display loop of blog posts
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>

<div class="container">
  <div class="row">
    <div class="span12">
       <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        query_posts( array( 'post_type' => 'post', 'paged'=>$paged, 'showposts'=>0) );
        if (have_posts()) : while ( have_posts() ) : the_post(); ?>

        <div <?php post_class(); ?>>
          <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
          <p class="meta"><?php echo bootstrapwp_posted_on();?></p>
          <div class="row">
            <div class="span12">
              <?php the_excerpt();?>
            </div>
          </div><!-- /.row -->
          <hr />
        </div><!-- /.post_class -->
        <?php endwhile; endif;?>
    </div>
  </div>
</div>

<?php get_footer(); ?>