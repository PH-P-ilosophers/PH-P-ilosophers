<?php

get_header();


$query = new WP_Query(array(
    'posts_per_page' => -1,
    "post_type" => "Events",
    "order" => "DESC",
    'meta_query' => array(
        array(
            'key' => 'event-type',
            'compare' => 'LIKE',
            'value' => "" . get_the_ID() . ""
        )
    )
));

$title = get_the_title();
$content = get_the_content();
echo "<h1>" . $title . "</h1>";
echo "<h3> Description </h3>";
echo "<p>" . $content . "</p>";



?>
<br>
<br>

<hr>
<div>
    <h4>Related Events</h4>
</div>
<?php
if (!$query->have_posts()) {
    echo '<h5>None</h5>';
} else {
    while ($query->have_posts()) {
        $query->the_post();
        $image = get_field("event-image");
        $size = array(500, 300);
        ?>
        <div class="event-posts-container">
            <div class="event-card">

                <div class="tooltip">
                    <a style="font-size:20px;" href=<?php echo the_permalink() ?>>

                        <div class="tooltiptext"><?php the_title() ?></div>

                        <?php echo wp_get_attachment_image($image, $size); ?>
                    </a>
                </div>

            </div>
        </div>
        <?php
    }
    wp_reset_postdata();


}

get_sidebar();
get_footer();
?>