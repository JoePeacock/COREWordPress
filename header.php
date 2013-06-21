<?php
/**
 *
 * Default Page Header
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: August 15, 2012
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
   <title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'bootstrapwp' ), max( $paged, $page ) );

  ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php bloginfo( 'template_url' );?>/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo( 'template_url' );?>/ico/apple-touch-icon-57-precomposed.png">
  <!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <?php wp_head(); ?>
      </head>
  <body <?php body_class(); ?>  data-spy="scroll" data-target=".bs-docs-sidebar" data-offset="10">
    <div class="navi-header">
      <div class="container">
        <div class="span8">
           <div class="top-menu pull-left">
            <?php
             wp_nav_menu( array(
                'menu'            => 'Top Menu',
                'container_class' => 'nav-collapse',
                'menu_class'      => 'top-menu-links',
                'fallback_cb'     => '',
                'menu_id'          => 'Top Menu', 
                'walker' => new Bootstrapwp_Walker_Nav_Menu()
            ) ); ?>              
          </div>
        </div>
        <div class="span3">
          <div class="pull-right slogan">
            <?php echo bloginfo('description'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="main-navbar">
      <div class="container">
        <div class="span4">
          <a class="brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="http://127.0.0.1/wordpress/wp-content/uploads/2013/06/logo.png"></a>
        </div>
        <div class="span7">
            <?php
             /** Loading WordPress Custom Menu  **/
             wp_nav_menu( array(
                'menu'            => 'Primary',
                'menu_class'      => 'navi pull-right',
                'menu_id'          => 'primary', 
                'walker' => new Bootstrapwp_Walker_Nav_Menu()
            ) ); ?>
        </div>
      </div>
    </div>
    <!-- End Header -->


<div class="page-bg">




<!-- begin CONTENT -->