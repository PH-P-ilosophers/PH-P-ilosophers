<?php

get_header();

$image = get_field("event-image");
$size = 'large';
$title = get_the_title();
$content = get_the_content();
echo "<h1>" . $title . "</h1>";
echo "<h3> Description </h3>";
echo "<p>" . $content . "</p>";

if ($image)
    echo wp_get_attachment_image($image, $size);



$event_types = get_field('event-type');
?>
<br>
<br>

<hr>
<div>
    <h4>Event Types</h4>
</div>
<?php
if ($event_types) {
    foreach ($event_types as $event_type) { ?>
        <a style="font-size:20px;" href=<?php echo the_permalink($event_type) ?>><?php echo get_the_title($event_type) ?></a>
        <?php
    }
}else
{
    echo '<h5>None</h5>';
}
get_sidebar();
get_footer();
?>