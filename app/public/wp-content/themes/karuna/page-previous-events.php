<?php
get_header();
date_default_timezone_set('EST');

$date = date("Ymd");
$query = new WP_Query(array(
    'posts_per_page' => -1,
    "post_type" => "Events",
    "meta_key" => "event-date",
    "meta_value" => $date,
    "meta_compare" => "<",
    'paged' => $paged,
    "orderby" => "meta_value",
    "order" => "DESC",
));

?>

<div>
    <h1>Previous Events</h1>
    <?php
    $num_posts = 0;

    while ($query->have_posts()):
        $query->the_post();
        $title = get_the_title();
        $num_posts++; ?>
        <h2><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h2>
        <?php the_content() ?>
        <br>
        <?php
        the_field("event-date");
    endwhile;

    if ($num_posts == 0)
        echo "<p>There have been no previous events</p>"
            ?>
    </div>

    <?php

    get_sidebar();
    get_footer();

    ?>