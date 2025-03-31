<?php
get_header();

$date = date("Ymd");
$query = new WP_Query(array(
    'posts_per_page' => -1,
    "post_type" => "Events",
    "meta_key" => "event-date",
    "meta_value" => $date,
    "meta_compare" => ">=",
    'paged' => $paged,
    "orderby" => "meta_value",
    "order" => "ASC",
));

?>

<div>
    <h1>Upcoming Events</h1>
    <?php
    $num_posts = 0;
    while ($query->have_posts()):
        $query->the_post();
        $unformatted_date = DateTime::createFromFormat("Ymd",get_field("event-date"));
        $date = $unformatted_date->format("F j, Y");
        $title = get_the_title();
        $num_posts++; ?>
        <h2><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h2>
        <?php echo $date?>
        <br>
        <?php
    endwhile;

    if ($num_posts == 0)
        echo "<p>There are no upcoming events</p>"
            ?>
    </div>

    <?php

    get_sidebar();
    get_footer();

    ?>