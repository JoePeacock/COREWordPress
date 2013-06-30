<?php


#-----------------------------------------------------------------#
# Create the Portfolio meta boxes
#-----------------------------------------------------------------# 

add_action('add_meta_boxes', 'nectar_metabox_portfolio');
function nectar_metabox_portfolio(){
    
	
	#-----------------------------------------------------------------#
	# Custom Thumbnail
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-custom-thummbnail',
		'title' =>  __('Project Thumbnail', NECTAR_THEME_NAME),
		'description' => __('If you would like to have a separate thumbnail for your portfolio item, upload it here. <br/> If left blank, a cropped version of your featured image will be automatically used instead.', NECTAR_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array( 
				'name' => __('Custom Thumbnail Image', NECTAR_THEME_NAME),
				'desc' => __('The recommended dimensions are 600px by 403px.', NECTAR_THEME_NAME),
				'id' => '_nectar_portfolio_custom_thumbnail',
				'type' => 'file',
				'std' => ''
			),
		)
	);
	$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );

	
	#-----------------------------------------------------------------#
	# Extra Content
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-portfolio-extra',
		'title' =>  __('Extra Content', NECTAR_THEME_NAME),
		'description' => __('Please use this section to place any extra content you would like to appear in the main content area under your portfolio item.', NECTAR_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array( 
				'name' => '',
				'desc' => '',
				'id' => '_nectar_portfolio_extra_content',
				'type' => 'editor',
				'std' => ''
			),
		)
	);
	

	//only show the extra editor is it's enabled
	$options = get_option('salient'); 
	if(!empty($options['portfolio_extra_content']) && $options['portfolio_extra_content'] == 1) {
		add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	}

    #-----------------------------------------------------------------#
	# Video 
	#-----------------------------------------------------------------#
    $meta_box = array(
		'id' => 'nectar-metabox-portfolio-video',
		'title' => __('Video Settings', NECTAR_THEME_NAME),
		'description' => __('If you have a video, please fill out the fields below.', NECTAR_THEME_NAME),
		'post_type' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('M4V File URL', NECTAR_THEME_NAME),
					'desc' => __('Enter in the URL to the .m4v video file', NECTAR_THEME_NAME),
					'id' => '_nectar_video_m4v',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGV File URL', NECTAR_THEME_NAME),
					'desc' => __('Enter in the URL to the .ogv video file', NECTAR_THEME_NAME),
					'id' => '_nectar_video_ogv',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Video Height', NECTAR_THEME_NAME),
					'desc' => __('This only needs to be filled out if your self hosted video is not in a 16:9 aspect ratio. Enter your height based on an 845px width. This is used to calculate the iframe height for the "Watch Video" link. <br/> <strong>Don\'t include "px" in the string. e.g. 480</strong>', NECTAR_THEME_NAME),
					'id' => '_nectar_video_height',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Preview Image', NECTAR_THEME_NAME),
					'desc' => __('Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_poster',
					'type' => 'file',
					'std' => ''
				),
			array(
					'name' => __('Embedded Code', NECTAR_THEME_NAME),
					'desc' => __('If the video is an embed rather than self hosted, enter in a Youtube or Vimeo embed code here. The width should be a minimum of 670px with any height.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_embed',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );


}