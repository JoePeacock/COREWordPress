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

<div class="bgs">
  <div class="container page-body callout">
    <div class="row-fluid ">
      <div class="span8">
        <div class="slogan">
          <h4>We are a full service environmental consulting firm, 
          committed to finding environmental solutions for our clients.</h4>
        </div>
      </div>
      <div class="span4">
        <div class="pull-right">
          <div class="btn btn-success btn-large">Learn More.</div>
        </div>
      </div>
    </div>
  </div>

<div class="container">
  <div class="row-fluid">
    <div class="span12">
      <?php 
       $slides = new WP_Query( array( 'post_type' => 'home_slider', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); 
       if( $slides->have_posts() ) : ?>
      
        <?php while( $slides->have_posts() ) : $slides->the_post(); ?>

          <?php $image = get_post_meta($post->ID, '_nectar_slider_image', true); ?>
            
            <article class="page-body" style="background-image: url('<?php echo $image; ?>'); height:350px; background-repeat:no-repeat; background-size:cover; min-height:0;">

              <div class="caption">
                <h2><?php 
                $caption = get_post_meta($post->ID, '_nectar_slider_caption', true);
                  echo $caption; ?></h2>
              </div>

              <?php 
                  $button = get_post_meta($post->ID, '_nectar_slider_button', true);
                  $button_url = get_post_meta($post->ID, '_nectar_slider_button_url', true);
                  
                  if(!empty($button)) { ?>
                    <a href="<?php echo $button_url; ?>" class="uppercase"><?php echo $button; ?></a>
              <?php } ?>
                     
            </article>

        <?php endwhile; ?>
        <?php else: ?>

      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>



  <div class="container page-body homeContent">
    <div class="row-fluid">
        <div class="span12">
          <h2>Welcome to CORE Environmental</h2>
        
           <?php
          $include = get_pages('include=46');
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
