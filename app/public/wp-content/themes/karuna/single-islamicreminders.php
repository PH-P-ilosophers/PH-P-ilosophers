<?php

get_header();

$image = get_field("reminder-image");
$size = 'large';
$title = get_the_title();
echo "<h1>" . $title . "</h1>";

if ($image)
    echo wp_get_attachment_image($image, $size);


get_sidebar();
get_footer();
?>