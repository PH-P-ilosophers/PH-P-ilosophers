<?php
get_header();

$date = date("Ymd");
$query = new WP_Query(array(
    "post_type" => "islamicreminders",
    "meta_key" => "reminder-date",
    'paged' => $paged,
    "orderby" => "meta_value",
    "order" => "DESC",
));

?>


<?php
while ($query->have_posts()):
    $query->the_post();
    $title = get_the_title(); ?>

    <h2><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h2>
    <br>
    <?php
endwhile;
?>
</div>

<?php
echo "<div class = 'posts-pagination-container'><div class = 'posts-pagination-links'>" . paginate_links() . "</div></div>";


get_sidebar();
get_footer();
