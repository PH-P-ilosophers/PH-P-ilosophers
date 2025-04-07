<?php
get_header();

$query = new WP_Query(array(
    "post_type" => "hadith-selection",
    "orderby" => "post_date",
    "order" => "DESC",
));

?>

<div>
    <h2>Hadith Selections</h2>
    <br>
    <?php
    $num_posts = 0;

    while ($query->have_posts()):
        $query->the_post();
        $title = get_the_title();
        $num_posts++; ?>
        <h2><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h2>
        <p>-<?php the_field('hadith_writer') ?></p>
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