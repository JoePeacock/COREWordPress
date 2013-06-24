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


<div id="featured" data-bg-color="<?php if(!empty($options['slider-bg-color'])) echo $options['slider-bg-color']; ?>" data-slider-height="<?php if(!empty($options['slider-height'])) echo $options['slider-height']; ?>" data-animation-speed="<?php if(!empty($options['slider-animation-speed'])) echo $options['slider-animation-speed']; ?>" data-advance-speed="<?php if(!empty($options['slider-advance-speed'])) echo $options['slider-advance-speed']; ?>" data-autoplay="<?php echo $options['slider-autoplay'];?>"> 
  
  <?php 
   $slides = new WP_Query( array( 'post_type' => 'home_slider', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); 
   if( $slides->have_posts() ) : ?>
  
    <?php while( $slides->have_posts() ) : $slides->the_post(); ?>
      <div class="slide orbit-slide">
        
        <?php $image = get_post_meta($post->ID, '_nectar_slider_image', true); ?>
        <article style="background-image: url('<?php echo $image; ?>')">
          <div class="container">
            <div class="col span_12">
              <div class="post-title">
                <h2><span>
                  <?php 
                  $caption = get_post_meta($post->ID, '_nectar_slider_caption', true);
                      echo $caption; ?>
                </span></h2>
                
              <?php 
                  $button = get_post_meta($post->ID, '_nectar_slider_button', true);
                  $button_url = get_post_meta($post->ID, '_nectar_slider_button_url', true);
                  
                  if(!empty($button)) { ?>
                    <a href="<?php echo $button_url; ?>" class="uppercase"><?php echo $button; ?></a>
                 <?php } ?>
                 
              </div><!--/post-title-->
            </div>
          </div>
        </article>
      </div>
    <?php endwhile; ?>
    <?php else: ?>

  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</div>

<div class="row-fluid bg">
  <div class="container callout">
    <div class="span12">
      <div class="span8">
        <div class="slogan">
          <h4>"We are a full service environmental consulting firm, 
          committed to finding environmental solutions for our clients."</h4>
        </div>
      </div>
      <div class="span4">
        <div class="pull-right">
          <div class="btn btn-success btn-large">Learn More.</div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="bgs">
  <div class="container page-body homeContent">
    <div class="row-fluid">
        <div class="span12">
          <h2>Welcome to CORE Environmental</h2>
          <br>
           <?php
          $include = get_pages('include=16');
          $content = apply_filters('the_content',$include[0]->post_content);
          echo $content;
        ?> 
      </div>
    </div>    
    <br>
    <div class="row-fluid">
        <div class="span4">
          <h3>About Us</h3>
          <p>CORE is a multi-disciplinary environmental consulting firm specializing in asbestos containing material survey, design, and abatement project monitoring, lead paint abatement oversight, soil and... Read More »</p>
      </div>        
      <div class="span4">
        <h3>Projects</h3>
          <p>CORE is providing asbestos testing, technical inspection, design. Project monitoring and construction inspection services for the MTA facilities in the five boroughs of New York City... Read More »</p>
      </div>        
      <div class="span4">
        <h3>Careers</h3>
           <p>CORE is always looking for qualified, highly motivated employees to fill a variety of positions. Candidates should have demonstrated experience or success along with motivation in the classroom. Experience on projects for state agencies and... Read More »</p>
      </div>
    </div>
  </div>
</div>



<?php get_footer(); ?>
