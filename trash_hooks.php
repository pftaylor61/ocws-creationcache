<?php

add_action( 'trash_[custom]', 'my_trash_callback' );
function my_trash_callback( $postID ) {
    // Party hard!
}

add_action( 'untrash_post', 'my_untrash_callback' );
function my_untrash_callback( $postID ) {
    if ( get_post( $postID )->post_type === '[custom]' ) {
        // Party hard!
    }
}

function my_wp_trash_post ($post_id) {
    $post_type = get_post_type( $post_id );
    $post_status = get_post_status( $post_id );
    if( $post_type == 'mycpt' && in_array($post_status, array('publish','draft','future')) ) {
        // do your stuff
    }
}
add_action('wp_trash_post', 'my_wp_trash_post');

?>