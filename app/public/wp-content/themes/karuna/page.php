<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Karuna
 */

get_header(); ?>



<?php
while (have_posts()):
	the_post();
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			$theParent = wp_get_post_parent_ID(get_the_ID());
			if ($theParent) { ?>
				<div class="metabox metabox--position-up metabox--with-home-link">
					<p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
							<i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> >
						<span class="metabox__main"><?php echo the_title(); ?> </span>
					</p>
				</div>
				<?php
			}


			get_template_part('components/page/content', 'page');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()):
				comments_template();
			endif;

endwhile; // End of the loop.
?>

	</main>
</div>
<?php
get_sidebar();
get_footer();