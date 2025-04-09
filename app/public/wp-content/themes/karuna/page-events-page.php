<?php
get_header();

$query = new WP_Query(array(
    "post_type" => "event-type",
    "orderby" => "title",
    "order" => "ASC",
));

?>

<div>
    <h2>Events</h2>
    <br>
    <h3>Overview</h3>
    <p>The Masjid hosts several types of events throughout the year for the benefit of the community</p>
    <hr>
    <h3>Type of events</h3>
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

    endwhile;

    if ($num_posts == 0)
        echo "<p>There have been no previous events</p>"
            ?>
    </div>

    <?php
    echo "<div class = 'posts-pagination-container'><div class = 'posts-pagination-links'>" . paginate_links() . "</div></div>";


    get_sidebar();
    get_footer();

    ?>