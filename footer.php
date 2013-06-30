<?php
/**
 * Default Footer
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: July 16, 2012
 */
?>
    <!-- End Template Content -->
<footer>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="copyright">
					<p>Copyright © 2011 - <?php the_time('Y') ?> CORE Environmental All Rights Reserved<bR>
						Designed & Developed by <a href="http://www.japeacock.com" target="_blank">Joseph Peacock</a></p>
				</div>
		</div>
		</div>
	</div>
	<div class="footerBg">
		<div class="container">
			<div class="row">
				<div class="span4">
					<a class="brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo( 'template_url' );?>/img/logo.png"></a>
				</div>
				<div class="span8">
					<ul class="footer-links pull-right">
						<?php $args = array(
								'depth'        => 1,
								'child_of'     => 0,
								'title_li'     => __(''),
								'echo'         => 1,
								'sort_column'  => 'menu_order',
								'post_type'    => 'page',
							    'post_status'  => 'publish' 
							);

							wp_list_pages( $args ); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>


<!-- 					<p class="pull-right"><a href="#">Back to top</a></p>
 -->
<?php wp_footer(); ?>

  </body>
</html>