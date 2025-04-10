<?php
/**
 * components functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Karuna
 */

if (!function_exists('karuna_setup')):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the aftercomponentsetup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function karuna_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on components, use a find and replace
		 * to change 'karuna' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('karuna', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		add_image_size('karuna-featured-image', 685, 9999);
		add_image_size('karuna-hero', 2000, 9999);
		add_image_size('karuna-grid', 342, 228, true);
		add_image_size('karuna-thumbnail-avatar', 100, 100, true);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_html__('Header', 'karuna'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Add theme support for custom logos
		add_theme_support(
			'custom-logo',
			array(
				'width' => 1000,
				'height' => 200,
				'flex-width' => true,
				'flex-height' => true,
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('karuna_custom_background_args', array(
			'default-color' => 'ffffff',
		)));
	}
endif;
add_action('after_setup_theme', 'karuna_setup');

/**
 * Return early if Custom Logos are not available.
 */
function karuna_the_custom_logo()
{
	if (!function_exists('the_custom_logo')) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function karuna_content_width()
{
	$GLOBALS['content_width'] = apply_filters('karuna_content_width', 685);
}
add_action('after_setup_theme', 'karuna_content_width', 0);


/*
 * Adjust $content_width for full-width and front-page.php templates
 */

if (!function_exists('karuna_adjusted_content_width')):

	function karuna_adjusted_content_width()
	{
		global $content_width;

		if (is_page_template('templates/full-width-page.php') || is_page_template('front-page.php') || is_active_sidebar('sidebar-5') || is_active_sidebar('sidebar-4')) {
			$content_width = 1040; //pixels
		}
	}
	add_action('template_redirect', 'karuna_adjusted_content_width');

endif; // if ! function_exists( 'karuna_adjusted_content_width' )

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function karuna_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Sidebar', 'karuna'),
		'id' => 'sidebar-1',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Full-Width Header', 'karuna'),
		'id' => 'sidebar-4',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Full-Width Footer', 'karuna'),
		'id' => 'sidebar-5',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer 1', 'karuna'),
		'id' => 'sidebar-2',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer 2', 'karuna'),
		'id' => 'sidebar-3',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer 3', 'karuna'),
		'id' => 'sidebar-6',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer 4', 'karuna'),
		'id' => 'sidebar-7',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}
add_action('widgets_init', 'karuna_widgets_init');

/**
 * Register Google Fonts
 */
function karuna_fonts_url()
{
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Karla, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$karla = esc_html_x('on', 'Karla font: on or off', 'karuna');

	if ('off' !== $karla) {
		$font_families = array();
		$font_families[] = 'Karla:400,400italic,700,700italic';

		$query_args = array(
			'family' => urlencode(implode('|', $font_families)),
			'subset' => urlencode('latin,latin-ext'),
		);

		$fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
	}

	return $fonts_url;

}

/**
 * Enqueue scripts and styles.
 */
function karuna_scripts()
{
	wp_enqueue_style('karuna-style', get_stylesheet_uri());

	wp_enqueue_style('karuna-fonts', karuna_fonts_url(), array(), null);

	wp_enqueue_style('genericons', get_template_directory_uri() . '/assets/fonts/genericons/genericons.css', array(), '3.4.1');

	wp_enqueue_script('karuna-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true);

	wp_enqueue_script('karuna-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);

	wp_enqueue_script('karuna-functions', get_template_directory_uri() . '/assets/js/functions.js', array('jquery'), '20160531', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'karuna_scripts');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
if (!function_exists('karuna_excerpt_more')):
	function karuna_excerpt_more($more)
	{
		$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url(get_permalink(get_the_ID())),
			/* translators: %s: Name of current post */
			sprintf(esc_html__('Continue reading %s', 'karuna'), '<span class="screen-reader-text">' . get_the_title(get_the_ID()) . '</span>')
		);
		return ' &hellip; ' . $link;
	}
	add_filter('excerpt_more', 'karuna_excerpt_more');
endif;

/**
 * Custom header support
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}



/**
 * Load plugin enhancement file to display admin notices.
 */
require get_template_directory() . '/inc/plugin-enhancements.php';

function redirectSubscribers()
{
	$currUser = wp_get_current_user();
	$currUserRoles = count($currUser->roles);
	$userRole = $currUser->roles[0];
	if ($currUserRoles == 1 && $userRole == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}
function adminBarSubscribers()
{
	if (!is_user_logged_in()) {
		return;
	}

	$currUser = wp_get_current_user();
	if ($currUser && !empty($currUser->roles) && is_array($currUser->roles)) {
		$userRole = $currUser->roles[0];
		if ($userRole == 'subscriber') {
			show_admin_bar(false);
		}
	}
}

function register_question_post_type()
{
	register_post_type('question', array(
		'labels' => array(
			'name' => 'Questions',
			'singular_name' => 'Question',
			'add_new_item' => 'Ask a Question'
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'questions'),
		'supports' => array('title', 'editor', 'author', 'comments'),
		'menu_icon' => 'dashicons-editor-help'
	));
}

add_action('init', 'register_question_post_type');

add_action('admin_init', 'redirectSubscribers');
add_action('wp_loaded', 'adminBarSubscribers');