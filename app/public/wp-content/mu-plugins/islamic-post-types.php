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

    register_post_type('Ramadan Insights', array(
        'supports' => array('title', 'editor',"excerpt","custom-fields"),
        'rewrite' => array('slug' => 'ramadan-insights'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Ramadan Insights",
            'add_new_item' => 'Add New Ramadan Insight',
            'edit_item' => 'Edit Ramadan Insight',
            'all_items' => 'All Ramadan Insights',
            'singular_name' => "Ramadan Insight  "
        ),
        'menu_icon' => 'dashicons-format-quote'
    ));
    
    register_post_type('Ramadan Years', array(
        'supports' => array('title', 'editor',"excerpt","custom-fields"),
        'rewrite' => array('slug' => 'ramadan-year'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Ramadan Years",
            'add_new_item' => 'Add New Ramadan Year',
            'edit_item' => 'Edit Ramadan Year',
            'all_items' => 'All Ramadan Years',
            'singular_name' => "Ramadan Year  "
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}
add_action("init", "islamicPostTypes");
?>