<?php
/**
 * Denis B theme setup.
 *
 * @package DenisB_Theme
 */

defined( 'ABSPATH' ) || exit;

define( 'DENISB_THEME_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/template-tags.php';

add_action(
	'after_setup_theme',
	static function () {
		load_theme_textdomain( 'denisb', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/css/pages.css', 'assets/css/blocks.css', 'assets/css/editor.css' ) );
	}
);

/**
 * Which stylesheet family the current view uses: "site" for the homepage and
 * case studies, "pages" for everything else.
 */
function denisb_view(): string {
	return ( is_front_page() || is_singular( 'db_project' ) ) ? 'site' : 'pages';
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		$uri = get_template_directory_uri() . '/assets';
		$ver = DENISB_THEME_VERSION;

		wp_enqueue_style( 'denisb-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&family=Instrument+Serif:ital@0;1&display=swap', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query.
		if ( 'site' === denisb_view() ) {
			wp_enqueue_style( 'denisb-site', "$uri/css/site.css", array( 'denisb-fonts' ), $ver );
		} else {
			wp_enqueue_style( 'denisb-pages', "$uri/css/pages.css", array( 'denisb-fonts' ), $ver );
			wp_enqueue_style( 'denisb-blocks', "$uri/css/blocks.css", array( 'denisb-pages' ), $ver );
		}
		wp_enqueue_style( 'denisb-mega-menu', "$uri/css/mega-menu.css", array(), $ver );

		wp_enqueue_script( 'denisb-theme', "$uri/js/theme.js", array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
		if ( is_front_page() || is_singular( 'db_project' ) ) {
			wp_enqueue_script( 'denisb-motion', "$uri/js/motion.js", array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
		}
		if ( is_post_type_archive( 'db_product' ) ) {
			wp_enqueue_script( 'denisb-products', "$uri/js/products.js", array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
		}

	},
	20
);

/**
 * Removes core block CSS. The design supplies every style it needs, and blocks
 * enqueue their styles while rendering, so this runs again before footer styles.
 */
function denisb_dequeue_core_styles(): void {
	foreach ( wp_styles()->queue as $handle ) {
		if ( str_starts_with( $handle, 'wp-block-' ) || in_array( $handle, array( 'classic-theme-styles', 'global-styles', 'core-block-supports' ), true ) ) {
			wp_dequeue_style( $handle );
		}
	}
}
add_action( 'wp_print_styles', 'denisb_dequeue_core_styles', 1 );
add_action( 'wp_print_footer_scripts', 'denisb_dequeue_core_styles', 1 );

/*
 * Apply the saved colour theme before first paint.
 */
add_action(
	'wp_head',
	static function () {
		echo "<script>try{var t=localStorage.getItem('dbTheme');if(t&&t!=='system')document.documentElement.setAttribute('data-theme',t)}catch(e){}</script>\n";
	},
	1
);

add_action(
	'init',
	static function () {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		register_block_style( 'core/button', array( 'name' => 'primary', 'label' => __( 'Primary', 'denisb' ) ) );
		// Keep core block and global styles off the front end; blocks.css styles block output.
		if ( ! is_admin() ) {
			remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
			remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
		}
		// Group blocks render as plain wrappers so the original grid and card CSS applies directly.
		remove_filter( 'render_block_core/group', 'wp_restore_group_inner_container', 10 );
	}
);

/*
 * Document titles: SEO title fields override the defaults.
 */
add_filter(
	'pre_get_document_title',
	static function ( string $title ) {
		if ( ! function_exists( 'denisb_option' ) ) {
			return $title;
		}
		if ( is_front_page() ) {
			return denisb_option( 'seo_title', $title );
		}
		if ( is_singular( 'db_product' ) && denisb_meta( 'seo_title' ) ) {
			return denisb_meta( 'seo_title' );
		}
		if ( is_singular( 'db_project' ) ) {
			return get_the_title() . ' | ' . denisb_option( 'name', get_bloginfo( 'name' ) );
		}
		if ( is_post_type_archive( 'db_product' ) && denisb_option( 'products_seo' ) ) {
			return denisb_option( 'products_seo' );
		}
		return $title;
	}
);

add_action( 'wp_head', 'denisb_seo_tags', 2 );

/**
 * Prints the description, canonical, Open Graph and JSON-LD tags.
 */
function denisb_seo_tags(): void {
	if ( ! function_exists( 'denisb_option' ) ) {
		return;
	}
	$desc   = '';
	$image  = '';
	$schema = '';
	if ( is_front_page() ) {
		$desc = denisb_option( 'seo_desc' );
	} elseif ( is_singular( 'db_product' ) ) {
		$desc   = denisb_meta( 'seo_desc' );
		$image  = denisb_image_url( denisb_meta( 'banner' ) );
		$schema = denisb_meta( 'schema' );
	} elseif ( is_singular( 'db_project' ) ) {
		$desc  = denisb_meta( 'tagline' );
		$image = (string) get_the_post_thumbnail_url( null, 'large' );
	} elseif ( is_post_type_archive( 'db_product' ) ) {
		$desc = denisb_option( 'products_seo_desc' );
	}
	if ( ! $desc ) {
		return;
	}
	$title = wp_get_document_title();
	$url   = is_post_type_archive( 'db_product' ) ? get_post_type_archive_link( 'db_product' ) : ( is_front_page() ? home_url( '/' ) : get_permalink() );
	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta name=\"robots\" content=\"index,follow,max-image-preview:large\">\n" );
	printf( "<meta property=\"og:type\" content=\"website\">\n<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( denisb_option( 'name', get_bloginfo( 'name' ) ) ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n<meta property=\"og:description\" content=\"%s\">\n<meta property=\"og:url\" content=\"%s\">\n", esc_attr( $title ), esc_attr( $desc ), esc_url( (string) $url ) );
	printf( "<meta name=\"twitter:card\" content=\"%s\">\n<meta name=\"twitter:title\" content=\"%s\">\n<meta name=\"twitter:description\" content=\"%s\">\n", $image ? 'summary_large_image' : 'summary', esc_attr( $title ), esc_attr( $desc ) );
	if ( $image ) {
		printf( "<meta property=\"og:image\" content=\"%1\$s\">\n<meta name=\"twitter:image\" content=\"%1\$s\">\n", esc_url( $image ) );
	}
	if ( $schema && null !== json_decode( $schema ) ) {
		echo '<script type="application/ld+json">' . wp_json_encode( json_decode( $schema ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}

/*
 * Without the Denis B plugin the theme has no content to show.
 */
add_action(
	'admin_notices',
	static function () {
		if ( function_exists( 'denisb_option' ) || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'The Denis B theme needs the Denis B plugin for its content. Install and activate it.', 'denisb' ) . '</p></div>';
	}
);

add_filter(
	'body_class',
	static function ( array $classes ) {
		$classes[] = 'denisb-' . denisb_view();
		return $classes;
	}
);
