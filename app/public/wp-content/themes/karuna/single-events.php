<?php

get_header();

$image = get_field("event-image");
$size = 'large';
$title = get_the_title();
$content = get_the_content();
echo "<h1>" . $title . "</h1>";
echo "<h3> Description </h3>";
echo "<p>" . $content. "</p>";

if ($image)
    echo wp_get_attachment_image($image, $size);

get_sidebar();
get_footer();
?>