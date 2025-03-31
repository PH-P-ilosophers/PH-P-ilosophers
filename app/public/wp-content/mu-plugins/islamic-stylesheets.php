<?php

function islamicStylesheets()
{
    wp_enqueue_style("livestream", get_theme_file_uri("/css/livestream-page.css"));
    wp_enqueue_style("posts", get_theme_file_uri("/css/post-pages.css"));
    wp_enqueue_style("event", get_theme_file_uri("/css/event-pages.css"));


}

add_action('wp_enqueue_scripts', 'islamicStylesheets');

?>