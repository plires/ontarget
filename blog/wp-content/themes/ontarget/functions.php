<?php
/**
 * ontarget functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ontarget
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'ontarget_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ontarget_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ontarget, use a find and replace
		 * to change 'ontarget' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ontarget', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'ontarget' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ontarget_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'ontarget_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ontarget_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ontarget_content_width', 640 );
}
add_action( 'after_setup_theme', 'ontarget_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ontarget_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ontarget' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ontarget' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ontarget_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ontarget_scripts() {
	wp_enqueue_style( 'ontarget-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-normalize', get_stylesheet_uri() . '../../../../../../node_modules/normalize.css/normalize.css', array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-fontawesome', get_stylesheet_uri() . '../../../../../../node_modules/@fortawesome/fontawesome-free/css/all.css', array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-bootstrap', get_stylesheet_uri() . '../../../../../../node_modules/bootstrap/dist/css/bootstrap.min.css', array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-aos', get_stylesheet_uri() . '../../../../../../node_modules/aos/dist/aos.css', array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-modales', get_stylesheet_uri() . '../../../../../../css/modales-compartidos-front-back.css', array(), _S_VERSION );

	wp_enqueue_style( 'ontarget-app', get_stylesheet_uri() . '../../../../../../css/app.css', array(), _S_VERSION );


	wp_enqueue_script( 'ontarget-jquery', get_template_directory_uri() . '../../../../../node_modules/jquery/dist/jquery.min.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-bootstrap-bundle', get_template_directory_uri() . '../../../../../node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-axios', get_template_directory_uri() . '../../../../../node_modules/axios/dist/axios.min.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-vue', get_template_directory_uri() . '../../../../../node_modules/vue/dist/vue.min.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-aos', get_template_directory_uri() . '../../../../../node_modules/aos/dist/aos.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-app', get_template_directory_uri() . '../../../../../js/app.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'ontarget-slick', get_template_directory_uri() . '../../../../../js/nav/vue-nav.js', array(), _S_VERSION, true );



	// wp_style_add_data( 'ontarget-style', 'rtl', 'replace' );

	// wp_enqueue_script( 'ontarget-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
add_action( 'wp_enqueue_scripts', 'ontarget_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Changing excerpt length
function new_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'new_excerpt_length');
 
// Changing excerpt more
function new_excerpt_more($more) {
	return '... <a class="more-link" href="'. get_permalink().'">ver m??s </a>';
}
add_filter('excerpt_more', 'new_excerpt_more');



