<?php
function islamicPostTypes()
{
    register_post_type('livestreaming', array(
        'supports' => array('title', 'editor', "custom-fields"),
        'rewrite' => array('slug' => 'livestreaming'),
        'has_archive' => true,
        "publicly_queryable" => true,
        'public' => true,
        'labels' => array(
            'name' => "Livestreaming",
            'add_new_item' => 'Add New Livestream',
            'edit_item' => 'Edit Livestream',
            'all_items' => 'All Livestreams',
            'singular_name' => "Livestream  "
        ),
        'menu_icon' => 'dashicons-video-alt2'
    ));



    register_post_type('event-type', array(
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        "show_in_rest" => true,
        "publicly_queryable" => true,
        'labels' => array(
            'name' => "Event Types",
            'add_new_item' => 'Add New Event Type',
            'edit_item' => 'Edit Event Type',
            'all_items' => 'All Event Types',
            'singular_name' => "Event Type  "
        ),
        'menu_icon' => 'dashicons-groups'
    ));

    register_post_type('events', array(
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        "show_in_rest" => true,
        "publicly_queryable" => true,
        'labels' => array(
            'name' => "Events",
            'add_new_item' => 'Add New Event ',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => "Event  "
        ),
        'menu_icon' => 'dashicons-groups'
    ));


    register_post_type('Ramadan Insights', array(
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
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
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
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

    register_post_type('Prayer Times', array(
        'supports' => array('title', 'editor', "custom-fields"),
        'rewrite' => array('slug' => 'prayer-times'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Prayer Times",
            'add_new_item' => 'Add New Prayer Time',
            'edit_item' => 'Edit Prayer Time',
            'all_items' => 'All Prayer Times',
            'singular_name' => "Prayer Time  "
        ),
        'menu_icon' => 'dashicons-clock'
    ));
    register_post_type('Islamic Reminders', array(
        'supports' => array('title', 'editor', "excerpt", "custom-fields"),
        'rewrite' => array('slug' => 'islamic-reminders'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => "Islamic Reminders",
            'add_new_item' => 'Add New Islamic Reminder',
            'edit_item' => 'Edit Islamic Reminder',
            'all_items' => 'All Islamic Reminders',
            'singular_name' => "Islamic Reminder"
        ),
        'menu_icon' => 'dashicons-bell'
    ));
}
add_action("init", "islamicPostTypes");


?>