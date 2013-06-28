<?php
/**
 *
 * @Author Joseph Peacock
 * @Author URL www.japeacock.com
 * @package COREWordPress 
 *
 * Last Updated: June 13, 2013
 */

if (!defined('BOOTSTRAPWP_VERSION'))
define('BOOTSTRAPWP_VERSION', '.90');

if ( ! isset( $content_width ) )
  $content_width = 770; /* pixels */

require_once('admin/options.php');

/* Hide Posts In Admin Menu 
 * (Still display custom post_types)
------------------------------------------------- */
add_action( 'admin_menu', 'hide_posts_admin_menu' );

  function hide_posts_admin_menu() {
    remove_menu_page('edit.php');
}


/* Setup Theme
------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'bootstrapwp_theme_setup' );
if ( ! function_exists( 'bootstrapwp_theme_setup' ) ):
function bootstrapwp_theme_setup() {
  add_theme_support( 'automatic-feed-links' );
  /**
   * Adds custom menu with wp_page_menu fallback
   */
  register_nav_menus( array(
    'main-menu' => __( 'Main Menu', 'bootstrapwp' ),
  ) );
  add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ) );
  /**
   * Declaring the theme language domain
   */
   load_theme_textdomain('bootstrapwp', get_template_directory() . '/lang');
}
endif;


/*  Loading All CSS Stylesheets
-------------------------------------------------- */

function bootstrapwp_css_loader() {
    wp_enqueue_style('bootstrapwp', get_template_directory_uri().'/css/bootstrapwp.css', false ,'0.90', 'all' );
/*    wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.css');
    wp_enqueue_style('font-awesome2', get_template_directory_uri().'/css/font-awesome-ie7.css');*/
    wp_enqueue_style('prettify', get_template_directory_uri().'/js/google-code-prettify/prettify.css', false ,'1.0', 'all' );
    wp_enqueue_style('styles', get_template_directory_uri().'/style.css' );
    wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300');
}

add_action('wp_enqueue_scripts', 'bootstrapwp_css_loader');


/*  Loading All JS Files 
-------------------------------------------------- */

function bootstrapwp_js_loader() {
       wp_enqueue_script('bootstrapjs', get_template_directory_uri().'/js/bootstrap.js', array('jquery'),'0.90', true );
       wp_enqueue_script('prettifyjs', get_template_directory_uri().'/js/google-code-prettify/prettify.js', array('jquery'),'1.0', true );
       wp_enqueue_script('demojs', get_template_directory_uri().'/js/bootstrapwp.demo.js', array('jquery'),'0.90', true );
       wp_enqueue_script('dds', 'http://coreenv.com/js/jquery.DDSlider.min.js', array('jquery'),'0.90', true );

}

add_action('wp_enqueue_scripts', 'bootstrapwp_js_loader');


/* Top Navigation Bar Customization
------------------------------------------------------------------- */

function bootstrapwp_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'bootstrapwp_page_menu_args' );

include 'includes/class-bootstrapwp_walker_nav_menu.php';


/* Registering Widget Sections
------------------------------------------------------------------- */

function bootstrapwp_widgets_init() {
  register_sidebar( array(
    'name' => 'Page Sidebar',
    'id' => 'sidebar-page',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ) );

  register_sidebar( array(
    'name' => 'Posts Sidebar',
    'id' => 'sidebar-posts',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>',
  ) );

    register_sidebar(array(
    'name' => 'Footer Content',
    'id'   => 'footer-content',
    'description'   => 'Footer text or acknowledgements',
    'before_widget' => '<div id="%1$s" class="span4">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4>',
    'after_title'   => '</h4>'
  ));
}

add_action( 'init', 'bootstrapwp_widgets_init' );


/* Adding Breadcrumbs
------------------------------------------------------------------- */

function breadcrumbs() {

  $delimiter = '<span class="divider">/</span>';
  $home = 'Home'; // text for the 'Home' link
  $before = '<li class="active">'; // tag before the current crumb
  $after = '</li>'; // tag after the current crumb

  if ( !is_home() && !is_front_page() || is_paged() ) {

    echo '<ul class="breadcrumb">';

    global $post;
    $homeLink = home_url();
    echo '<li><a href="' . $homeLink . '">' . $home . '</a></li> ' . $delimiter . ' ';

    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;

    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;

    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;

    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;

    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page', 'bootstrapwp') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</ul>';

  }
} 

/* Custom Meta Types for Image Slider
------------------------------------------------------- */

function add_custom_meta_boxes() {

  // Define Custom Image Uploader for Image Slider Post Type
	add_meta_box(
		'wp_custom_attachment',
		'Image Slider Background',
		'wp_custom_attachment',
		'image_slider',
		'side'
	);	
  
} 

add_action('add_meta_boxes', 'add_custom_meta_boxes');


/* Custom Post Types
------------------------------------------------------- */

/* Projects Post Type
--------------------------------------- */

function projects_post_register() {
  $labels = array(
    'name' => 'Projects',  
    'singular_name' => 'Project',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Project',
    'edit_item' => 'Edit Project',
    'new_item' => 'New Project',
    'all_items' => 'All Projects',
    'view_item' => 'View Project',
    'search_items' => 'Search Projects',
    'not_found' =>  'No projects found',
    'not_found_in_trash' => 'No projects found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Projects'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'project' ),
    'capability_type' => 'post',
    'taxonomies' => array('category'),
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 

        register_post_type( 'project', $args );
}

add_action( 'init', 'projects_post_register' );

#-----------------------------------------------------------------#
# Post meta
#-----------------------------------------------------------------#

function enqueue_media(){
  
  //enqueue the correct media scripts for the media library 
  $wp_version = floatval(get_bloginfo('version'));
  
  if ( $wp_version < "3.5" ) {
      wp_enqueue_script(
          'redux-opts-field-upload-js', 
          Redux_OPTIONS_URL . 'fields/upload/field_upload_3_4.js', 
          array('jquery', 'thickbox', 'media-upload'),
          time(),
          true
      );
      wp_enqueue_style('thickbox');// thanks to https://github.com/rzepak
  } else {
      wp_enqueue_script(
          'redux-opts-field-upload-js', 
          Redux_OPTIONS_URL . 'fields/upload/field_upload.js', 
          array('jquery'),
          time(),
          true
      );
      wp_enqueue_media();
  }
  
}

//post meta styling
function  nectar_metabox_styles() {
  wp_enqueue_style('nectar_meta_css', '/wp-content/themes/COREWordPress/css/nectar-meta.css');
}

//post meta scripts
function nectar_metabox_scripts() {
  wp_register_script('nectar-upload', '/wp-content/themes/COREWordPress/js/nectar-meta.js', array('jquery','media-upload','thickbox'));
  wp_enqueue_script('nectar-upload');
  wp_localize_script('redux-opts-field-upload-js', 'redux_upload', array('url' => Redux_OPTIONS_URL .'fields/upload/blank.png'));
}

add_action('admin_enqueue_scripts', 'nectar_metabox_scripts');
add_action('admin_print_styles', 'nectar_metabox_styles');
add_action('admin_print_styles', 'enqueue_media');

#-----------------------------------------------------------------#
# Post audio
#-----------------------------------------------------------------#

if ( !function_exists( 'nectar_audio' ) ) {
    function nectar_audio($postid) {
  
      $mp3 = get_post_meta($postid, '_nectar_audio_mp3', TRUE);
      $ogg = get_post_meta($postid, '_nectar_audio_ogg', TRUE);
      
    ?>
    
        <script type="text/javascript">
    
          jQuery(document).ready(function($){
  
            if( $().jPlayer ) {
              $("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
                ready: function () {
                  $(this).jPlayer("setMedia", {
                      <?php if($mp3 != '') : ?>
                    mp3: "<?php echo $mp3; ?>",
                    <?php endif; ?>
                    <?php if($ogg != '') : ?>
                    oga: "<?php echo $ogg; ?>",
                    <?php endif; ?>
                    end: ""
                  });
                },
                <?php if( !empty($poster) ) { ?>
                size: {
                        width: "<?php echo $width; ?>px",
                        height: "<?php echo $height . 'px'; ?>"
                    },
                    <?php } ?>
                swfPath: "<?php echo get_template_directory_uri(); ?>/js",
                cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
                supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3, <?php endif; ?> all"
              });
          
            }
          });
        </script>
    
          <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-audio"></div>

            <div class="jp-audio-container">
                <div class="jp-audio">
                    <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                        <ul class="jp-controls">
                            <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                            <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                            <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                            <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                        </ul>
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                        <div class="jp-volume-bar-container">
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <?php 
    }
}


#-----------------------------------------------------------------#
# Post video
#-----------------------------------------------------------------#

if ( !function_exists( 'nectar_video' ) ) {
    function nectar_video($postid) {
  
      $m4v = get_post_meta($postid, '_nectar_video_m4v', true);
      $ogv = get_post_meta($postid, '_nectar_video_ogv', true);
      $poster = get_post_meta($postid, '_nectar_video_poster', true);

    ?>
    <script type="text/javascript">
      jQuery(document).ready(function($){
    
        if( $().jPlayer ) {
          $("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
            ready: function () {
              $(this).jPlayer("setMedia", {
                <?php if($m4v != '') : ?>
                m4v: "<?php echo $m4v; ?>",
                <?php endif; ?>
                <?php if($ogv != '') : ?>
                ogv: "<?php echo $ogv; ?>",
                <?php endif; ?>
                <?php if ($poster != '') : ?>
                poster: "<?php echo $poster; ?>"
                <?php endif; ?>
              });
            },
            size: {
                width: "100%",
                height: "auto"
              },
            swfPath: "<?php echo get_template_directory_uri(); ?>/js",
            cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
            supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv, <?php endif; ?> all"
          });
        }
      });
    </script>

    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-video"></div>

    <div class="jp-video-container">
        <div class="jp-video">
            <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                <ul class="jp-controls">
                  <li><div class="seperator-first"></div></li>
                    <li><div class="seperator-second"></div></li>
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-bar-container">
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php }
}

#-----------------------------------------------------------------#
# Post gallery
#-----------------------------------------------------------------#

if ( !function_exists( 'nectar_gallery' ) ) {
    function nectar_gallery($postid) { 
          
      if (class_exists('MultiPostThumbnails')) { ?>
       
      <div class="flex-gallery"> 
          <ul class="slides">
          <?php if ( has_post_thumbnail() ) { echo '<li>' . get_the_post_thumbnail($postid, 'full', array('title' => '')) . '</li>'; } ?>
         
          <?php 
           if(MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'second-slide')) { echo '<li>' . MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'second-slide') . '</li>'; }
           if(MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'third-slide')) { echo '<li>' . MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'third-slide') . '</li>'; }
           if(MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'fourth-slide')) { echo '<li>' . MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'fourth-slide') . '</li>'; }
           if(MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'fifth-slide')) { echo '<li>' . MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'fifth-slide') . '</li>'; }
           if(MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'sixth-slide')) { echo '<li>' . MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'sixth-slide') . '</li>'; }
            ?>
           
           </ul>
       </div><!--/gallery-->
    <?php } 
      
    }
    
}


#-----------------------------------------------------------------#
# Create admin slider section
#-----------------------------------------------------------------# 
function slider_register() {  
    
  $labels = array(
    'name' => _x( 'Slides', 'taxonomy general name', NECTAR_THEME_NAME),
    'singular_name' => _x( 'Slide', NECTAR_THEME_NAME),
    'search_items' =>  __( 'Search Slides', NECTAR_THEME_NAME),
    'all_items' => __( 'All Slides', NECTAR_THEME_NAME),
    'parent_item' => __( 'Parent Slide', NECTAR_THEME_NAME),
    'edit_item' => __( 'Edit Slide', NECTAR_THEME_NAME),
    'update_item' => __( 'Update Slide', NECTAR_THEME_NAME),
    'add_new_item' => __( 'Add New Slide', NECTAR_THEME_NAME),
      'menu_name' => __( 'Image Slider', NECTAR_THEME_NAME)
   );
   
   $args = array(
      'labels' => $labels,
      'singular_label' => __('Image Slider', NECTAR_THEME_NAME),
      'public' => true,
      'show_ui' => true,
      'hierarchical' => false,
      'menu_position' => 10,
      'exclude_from_search' => true,
      'supports' => false
       );  
   
    register_post_type( 'home_slider' , $args );  
}  

add_action('init', 'slider_register');


#-----------------------------------------------------------------#
# Custom slider columns
#-----------------------------------------------------------------# 

add_filter('manage_edit-home_slider_columns', 'edit_columns_home_slider');  

function edit_columns_home_slider($columns){  
  $column_thumbnail = array( 'thumbnail' => 'Thumbnail' );
  $column_caption = array( 'caption' => 'Caption' );
  $columns = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
  $columns = array_slice( $columns, 0, 2, true ) + $column_caption + array_slice( $columns, 2, NULL, true );
  return $columns;
}  
  
  
add_action('manage_posts_custom_column',  'home_slider_custom_columns', 10, 2);  

function home_slider_custom_columns($portfolio_columns, $post_id){  

  switch ($portfolio_columns) {
      case 'thumbnail':
          $thumbnail = get_post_meta($post_id, '_nectar_slider_image', true);
          
          if( !empty($thumbnail) ) {
              echo '<a href="'.get_admin_url() . 'post.php?post=' . $post_id.'&action=edit"><img class="slider-thumb" src="' . $thumbnail . '" /></a>';
          } else {
              echo '<a href="'.get_admin_url() . 'post.php?post=' . $post_id.'&action=edit"><img class="slider-thumb" src="' . get_template_directory() . 'assets/img/slider-default-thumb.jpg" /></a>' .
                   '<strong><a class="row-title" href="'.get_admin_url() . 'post.php?post=' . $post_id.'&action=edit">No image added yet</a></strong>';
          }
      break; 
    
    case 'caption':
      $caption = get_post_meta($post_id, '_nectar_slider_caption', true);
          echo $caption;
      break;  
    
       
    default:
      break;
  }  
}  






function nectar_slider_enqueue_scripts() {
  wp_enqueue_script( 'jquery-ui-sortable' );
}


add_action( 'wp_ajax_nectar_update_slide_order', 'nectar_update_slide_order' );

//slide order ajax callback 
function nectar_update_slide_order() {
  
      global $wpdb;
   
      $post_type     = $_POST['postType'];
      $order        = $_POST['order'];
    
    if (  !isset($_POST['nectar_meta_box_nonce']) || !wp_verify_nonce( $_POST['nectar_meta_box_nonce'], basename( __FILE__ ) ) )
      return;
    
      foreach( $order as $menu_order => $post_id ) {
          $post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
          $menu_order     = intval($menu_order);
      
          wp_update_post( array( 'ID' => stripslashes(htmlspecialchars($post_id)), 'menu_order' => stripslashes(htmlspecialchars($menu_order)) ) );
      }
 
      die( '1' );
}


//order the default home slider page correctly 
function set_home_slider_admin_order($wp_query) {  
  if (is_admin()) {  
  
    $post_type = $wp_query->query['post_type'];  
  
    if ( $post_type == 'home_slider') {  
   
      $wp_query->set('orderby', 'menu_order');  
      $wp_query->set('order', 'ASC');  
    }  
  }  
}  

add_filter('pre_get_posts', 'set_home_slider_admin_order'); 


#-----------------------------------------------------------------#
# Home slider meta
#-----------------------------------------------------------------# 

include("admin/home-slider-meta.php");
include("admin/meta-config.php");
include("admin/post-meta.php");

#-----------------------------------------------------------------#
# Custom page header
#-----------------------------------------------------------------#

if ( !function_exists( 'nectar_page_header' ) ) {
    function nectar_page_header($postid) {
    
    global $options;
    global $post;
    
      $bg = get_post_meta($postid, '_nectar_header_bg', true);
      $title = get_post_meta($postid, '_nectar_header_title', true);
      $subtitle = get_post_meta($postid, '_nectar_header_subtitle', true);
    $height = get_post_meta($postid, '_nectar_header_bg_height', true);
    $page_template = get_post_meta($postid, '_wp_page_template', true); 
    
    //incase no title is entered for portfolio, still show the filters
    if( $page_template == 'page-portfolio.php' && empty($title)) $title = get_the_title($post->ID);
      
    if( !empty($bg) ) { 
    ?>
      
      <div id="page-header-bg" data-height="<?php echo (!empty($height)) ? $height : '350'; ?>" style="background-image: url(<?php echo $bg; ?>); height: <?php echo $height;?>px;">
      <div class="container"> 
        <div class="row">
          <div class="col span_6">
            <h1><?php echo $title; ?></h1>
            <span class="subheader"><?php echo $subtitle; ?></span>
          </div>
          
          <?php // portfolio filters
          if( $page_template == 'page-portfolio.php') { ?>
          <div id="portfolio-filters">
            <a href="#" id="sort-portfolio"><?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] :'Sort Portfolio'; ?></a>
            <ul>
               <li><a href="#" data-filter="*"><?php echo __('All', NECTAR_THEME_NAME); ?></a></li>
                       <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
            </ul>
          </div>
          <?php } ?>
          
        </div>
      </div>
    </div>
     
  
      <?php } else if( !empty($title) ) { ?>
        
        <div class="row page-header-no-bg">
          <div class="container"> 
          <div class="col span_12 section-title">
            <h1><?php echo $title; ?><?php if(!empty($subtitle)) echo '<span>' . $subtitle . '</span>'; ?></h1>
            
            <?php // portfolio filters
            if( $page_template == 'page-portfolio.php') { ?>
            <div id="portfolio-filters">
              <a href="#" id="sort-portfolio"><?php echo (!empty($options['portfolio-sortable-text'])) ? $options['portfolio-sortable-text'] :'Sort Portfolio'; ?></a>
              <ul>
                 <li><a href="#" data-filter="*"><?php echo __('All', NECTAR_THEME_NAME); ?></a></li>
                         <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
              </ul>
            </div>
            <?php } ?>
            
          </div>
        </div>
      </div>
        
     <?php }
     
    }
}
