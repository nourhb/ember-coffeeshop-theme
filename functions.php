<?php
/**
 * Ember theme setup.
 *
 * @package Ember
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup: supports, menus, widget areas.
 */
function ember_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'ember' ),
			'footer'  => __( 'Footer Menu', 'ember' ),
		)
	);

	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'after_setup_theme', 'ember_setup' );

/**
 * Enqueue front-end assets.
 */
function ember_assets() {
	wp_enqueue_style( 'ember-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Nunito+Sans:wght@400;600;700&display=swap', array(), '1.0.0' );
	wp_enqueue_style( 'ember-style', get_stylesheet_uri(), array(), '1.0.0' );
	wp_enqueue_script( 'ember-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'ember_assets' );

/**
 * Register footer widget area.
 */
function ember_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'ember' ),
			'id'            => 'footer',
			'description'   => __( 'Widgets shown in the site footer.', 'ember' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'ember_widgets' );

/**
 * Custom block styles.
 */
function ember_block_styles() {
	register_block_style( 'core/button', array( 'name' => 'outline-caramel', 'label' => __( 'Outline Caramel', 'ember' ) ) );
	register_block_style( 'core/group', array( 'name' => 'menu-card', 'label' => __( 'Menu Card', 'ember' ) ) );
	register_block_style( 'core/image', array( 'name' => 'rounded-warm', 'label' => __( 'Rounded Warm', 'ember' ) ) );
	register_block_style( 'core/quote', array( 'name' => 'roast-note', 'label' => __( 'Roast Note', 'ember' ) ) );
	register_block_style( 'core/heading', array( 'name' => 'menu-title', 'label' => __( 'Menu Title', 'ember' ) ) );
}
add_action( 'init', 'ember_block_styles' );

/**
 * Register the "ember" block pattern category.
 */
function ember_pattern_category() {
	register_block_pattern_category( 'ember', array( 'label' => __( 'Ember', 'ember' ) ) );
}
add_action( 'init', 'ember_pattern_category' );

/**
 * Trim excerpts to a friendly length.
 *
 * @param int $length Default length.
 * @return int
 */
function ember_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'ember_excerpt_length' );

/**
 * Inline SVG helper for coffee-themed icons.
 *
 * @param string $name Icon name: cup, bean, location, clock, star.
 * @return string
 */
function ember_icon( $name ) {
	$paths = array(
		'cup'      => '<path d="M4 8h12v6a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8z"/><path d="M16 9h2a2.5 2.5 0 0 1 0 5h-2"/><path d="M7 4c0 1 1 1 1 2M11 4c0 1 1 1 1 2"/>',
		'bean'     => '<ellipse cx="12" cy="12" rx="6" ry="9" transform="rotate(20 12 12)"/><path d="M9 5c3 4 3 10 6 14"/>',
		'location' => '<path d="M12 21s-6-5.5-6-10a6 6 0 0 1 12 0c0 4.5-6 10-6 10z"/><circle cx="12" cy="11" r="2.2"/>',
		'clock'    => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3.5 2"/>',
		'star'     => '<path d="M12 3l2.7 5.8 6.3.8-4.6 4.3 1.2 6.1L12 17l-5.6 3 1.2-6.1L3 9.6l6.3-.8z"/>',
	);
	$d = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['cup'];
	return '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
}
