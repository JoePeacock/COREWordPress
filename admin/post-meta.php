<?php 

add_action('add_meta_boxes', 'nectar_metabox_posts');
function nectar_metabox_posts(){
    
	#-----------------------------------------------------------------#
	# Gallery
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-post-gallery',
		'title' =>  __('Gallery Settings', NECTAR_THEME_NAME),
		'description' => __('Please use the sections that have appeared under the Featured Image block labeled "Second Slide, Third Slide..." etc to add images to your gallery.', NECTAR_THEME_NAME),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		
		)
	);
	$callback = create_function( '$post,$meta_box', 'nectar_create_meta_box( $post, $meta_box["args"] );' );
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
    
	#-----------------------------------------------------------------#
	# Quote
	#-----------------------------------------------------------------# 
    $meta_box = array(
		'id' => 'nectar-metabox-post-quote',
		'title' =>  __('Quote Settings', NECTAR_THEME_NAME),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('Quote Content', NECTAR_THEME_NAME),
					'desc' => __('Please type the text for your quote here.', NECTAR_THEME_NAME),
					'id' => '_nectar_quote',
					'type' => 'textarea',
                    'std' => ''
				)
		)
	);
    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	#-----------------------------------------------------------------#
	# Link
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-post-link',
		'title' =>  __('Link Settings', NECTAR_THEME_NAME),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
					'name' =>  __('Link URL', NECTAR_THEME_NAME),
					'desc' => __('Please input the URL for your link. I.e. http://www.themenectar.com', NECTAR_THEME_NAME),
					'id' => '_nectar_link',
					'type' => 'text',
					'std' => ''
				)
		)
	);
    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
    
	#-----------------------------------------------------------------#
	# Video
	#-----------------------------------------------------------------# 
    $meta_box = array(
		'id' => 'nectar-metabox-post-video',
		'title' => __('Video Settings', 'nectar'),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => __('M4V File URL', NECTAR_THEME_NAME),
					'desc' => __('Please enter in the URL to your .m4v video file', NECTAR_THEME_NAME),
					'id' => '_nectar_video_m4v',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('OGV File URL', NECTAR_THEME_NAME),
					'desc' => __('Please enter in the URL to your .ogv video file', NECTAR_THEME_NAME),
					'id' => '_nectar_video_ogv',
					'type' => 'text',
					'std' => ''
				),
			array( 
					'name' => __('Preview Image', NECTAR_THEME_NAME),
					'desc' => __('This will be the image displayed when the video has not been played yet. The image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_poster',
					'type' => 'file',
					'std' => ''
				),
			array(
					'name' => __('Embedded Code', NECTAR_THEME_NAME),
					'desc' => __('If the video is an embed rather than self hosted, enter in a Youtube or Vimeo embed code here. The width should be a minimum of 670px.', NECTAR_THEME_NAME),
					'id' => '_nectar_video_embed',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	#-----------------------------------------------------------------#
	# Audio
	#-----------------------------------------------------------------# 
	$meta_box = array(
		'id' => 'nectar-metabox-post-audio',
		'title' =>  __('Audio Settings', NECTAR_THEME_NAME),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
				'name' => __('MP3 File URL', NECTAR_THEME_NAME),
				'desc' => __('Please enter in the URL to the .mp3 file', NECTAR_THEME_NAME),
				'id' => '_nectar_audio_mp3',
				'type' => 'text',
				'std' => ''
			),
			array( 
					'name' => __('OGA File URL', NECTAR_THEME_NAME),
					'desc' => __('Please enter in the URL to the .ogg or .oga file', NECTAR_THEME_NAME),
					'id' => '_nectar_audio_ogg',
					'type' => 'text',
					'std' => ''
				)
		)
	);
	add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
}

?>