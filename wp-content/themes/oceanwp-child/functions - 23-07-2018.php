<?php 
function snssimen_child_enqueue_styles() {
    wp_enqueue_style( 'oceanwp-child-style', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'snssimen_child_enqueue_styles', 100000 );


?>