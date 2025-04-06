<?php
get_header();

global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$query = new WP_Query(array(
    'posts_per_page' => 4,
    'paged' => $paged,
    "post_type" => "livestreaming",
    "meta_key" => "livestream-date",
    "orderby" => "meta_value",
    "order" => "ASC",
));

$tmp_query = $wp_query;

$wp_query = null;

$wp_query = $query;
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



        }
    }

    ?>
</div>

<?php
echo "<div class = 'posts-pagination-container'><div class = 'posts-pagination-links'>" . paginate_links() . "</div></div>";

$wp_query = $tmp_query;
wp_reset_postdata();


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
