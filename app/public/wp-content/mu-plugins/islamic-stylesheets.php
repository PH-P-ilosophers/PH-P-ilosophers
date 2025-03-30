<?php

function islamicStylesheets()
{
    wp_enqueue_style("livestream", get_theme_file_uri("/css/livestream-page.css"));

}

add_action('wp_enqueue_scripts', 'islamicStylesheets');

?>