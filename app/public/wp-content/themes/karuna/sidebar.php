<?php

if (is_page()) {
	global $post;

	if ($post && isset($post->post_name)) {
		$current_page_slug = $post->post_name;

		$page_relationships = array(
			'about' => array('goals', 'history'),
			'goals' => array('about', 'history'),
			'history' => array('about', 'goals'),
			'events' => array('previous-events', 'upcoming-events'),
			'islamic-reminders' => array('events', 'livestreaming'),
			'livestreaming' => array('events', 'islamic-reminders'),
			'zakaat' => array('zakaat-application', 'zakaat-calculator'),
			'zakaat-application' => array('zakaat', 'zakaat-calculator'),
			'zakaat-calculator' => array('zakaat-application', 'zakaat')
		);

		if (isset($page_relationships[$current_page_slug]) && !empty($page_relationships[$current_page_slug])) {
			echo '<aside id = "secondary" class="widget-area">';
			echo '<h3>Suggested Pages</h3>'; //
			echo '<ul class="related-pages">';

			foreach ($page_relationships[$current_page_slug] as $related_slug) {

				$related_pages = get_posts(array(
					'name' => $related_slug,
					'post_type' => 'page',
					'numberposts' => 1
				));

				if (!empty($related_pages)) {
					$related_page = $related_pages[0];
					echo '<li class="related-page-item">';
					echo '<a href="' . get_permalink($related_page->ID) . '">' . $related_page->post_title . '</a>';
					echo '</li>';
				}
			}

			echo '</ul>';
			echo '</aside>';
		}
	}
}
?>

<style>
	.context-nav {
		margin: 20px 0;
	}

	.context-nav h3 {
		margin-bottom: 10px;
	}

	.context-nav .related-pages {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.context-nav .related-page-item {
		padding: 10px 15px;
		background-color: #6c5ce7;
		margin-bottom: 5px;
		border-radius: 3px;
	}

	.context-nav .related-page-item a {
		color: #fff;
		text-decoration: none;
		display: block;
		font-weight: bold;
	}

	.context-nav .related-page-item:hover {
		background-color: #5649c0;
	}
</style>