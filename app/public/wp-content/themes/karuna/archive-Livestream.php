<?php
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$query = new WP_Query(array(
    'posts_per_page' => 4,
    "post_type" => "livestream",
    "meta-key" => "livestream-date",
    'paged' => $paged,
    "orderby" => "meta_value",
    "order" => "DESC",
    'meta-value' => array(

    )
));
?>
<h1>Livestreams</h1>
<div class="livestream-posts-container">
    <?php
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $permalink = get_the_permalink();
            $title = get_the_title();
            $video_url = get_field("livestream-embed", false, false);
            $videoId = getYouTubeVideoId($video_url);
            $thumbnailUrl = "https://i.ytimg.com/vi/" . $videoId . "/mqdefault.jpg";

            ?>
            <div class="livestream-card"><a href="<?php echo $permalink ?>">
                    <h2 class="livestream-title"> <?php echo $title ?> </h2>
                    <div class="livestream-card-detail-area">
                        <div class="livestream-card-details">
                            <p class="date-text"><?php the_field("livestream-date") ?></p>
                            <p class="author-text">Author: <?php the_author() ?></p>
                        </div>
                        <div class="livestream-thumbnail-area">
                            <img class="livestream-thumbnail" src="<?php echo $thumbnailUrl ?>">
                        </div>
                    </div>
                </a>
            </div>


            <?php
            echo paginate_links();


        }
    }
    ?>
    <nav>
        <ul>
            <li><?php previous_posts_link('&laquo; PREV', $query->max_num_pages) ?></li>
            <li><?php next_posts_link('NEXT &raquo;', $query->max_num_pages) ?></li>
        </ul>
    </nav>
    <?php
    wp_reset_postdata();
    ?>
</div>
<?php



get_sidebar();
get_footer();
?>

<?php

function getYouTubeVideoId($pageVideUrl)
{
    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
    }
    $youtubeID = $video_id[1];
    if (empty($video_id[1]))
        $video_id = explode("/v/", $link);
    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        return $youtubeVideoID;
    } else {
        return false;
    }
}
