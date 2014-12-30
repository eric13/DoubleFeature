<?

// New version of function without author

function twentyten_posted_on() {
        printf( __( '<span class="%1$s">Posted on</span> %2$s ', 'twentyten' ),
                'meta-prep meta-prep-author',
                sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                        get_permalink(),
                        esc_attr( get_the_time() ),
                        get_the_date()
                )              
        );
}

// Custom functions for displaying chapter times

/* For Custom Field Template */
function gc($key, $echo = TRUE) {
	global $post;
	$custom_field = get_post_meta($post->ID, $key, true);
	if ($echo == FALSE) return $custom_field;
	echo $custom_field;
}

function gc_return($key, $echo = TRUE) {
	global $post;
	$custom_field = get_post_meta($post->ID, $key, true);
	if ($echo == FALSE) return $custom_field;
	return $custom_field;
}

/* For Custom Field Template */
function getCustomField($theField) {
	global $post;
	$block = get_post_meta($post->ID, $theField);
	if($block){
		foreach(($block) as $blocks) {
			echo $blocks;
		}
	}
}


?>