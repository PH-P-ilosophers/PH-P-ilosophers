<?php
get_header();

?>


    <?php
    while (have_posts()): the_post();
        $title = get_the_title(); ?>
        
        <h2><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h2>
        <br>
        <?php
    endwhile;
    ?>
</div>

<?php

get_sidebar();
get_footer();
