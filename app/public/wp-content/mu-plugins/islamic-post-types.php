<?php
function islamicPostTypes()
{
    register_post_type('Livestream', array(
        'supports' => array('title', 'editor', "custom-fields"),
        'rewrite' => array('slug' => 'livestreams'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Livestreams",
            'add_new_item' => 'Add New Livestream',
            'edit_item' => 'Edit Livestream',
            'all_items' => 'All Livestreams',
            'singular_name' => "Livestream  "
        ),
        'menu_icon' => 'dashicons-video-alt2'
    ));

    register_post_type('Events', array(
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Events",
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => "Event  "
        ),
        'menu_icon' => 'dashicons-groups'
    ));
}
add_action("init", "islamicPostTypes");
?>