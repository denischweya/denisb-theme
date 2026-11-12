<?php
/**
 * Denis B theme setup.
 *
 * A block theme: layout lives in templates/ and parts/, content in the
 * editor, and the design in block style variations (assets/css/variations.css).
 *
 * @package DenisB_Theme
 */

defined( 'ABSPATH' ) || exit;

define( 'DENISB_THEME_VERSION', '2.0.0' );

add_action(
	'after_setup_theme',
	static function () {
		load_theme_textdomain( 'denisb', get_template_directory() . '/languages' );
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/css/base.css', 'assets/css/variations.css', 'assets/css/mega-menu.css', 'assets/css/editor.css' ) );
	}
);

/**
 * Whether the current view is a product page or the products catalogue,
 * which use the original "pages" stylesheet.
 *
 * @param int|null $post_id Post to check. Defaults to the queried object.
 */
function denisb_is_product_view( ?int $post_id = null ): bool {
	$post_id = $post_id ?? ( is_singular() ? get_queried_object_id() : 0 );
	return $post_id && 'page-product' === get_page_template_slug( $post_id );
}

/**
 * Google Fonts stylesheet used on the site and in the editor canvas.
 */
function denisb_fonts_url(): string {
	return 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&family=Instrument+Serif:ital@0;1&display=swap';
}

add_action(
	'wp_enqueue_scripts',
	static function () {
		$uri = get_template_directory_uri() . '/assets';
		$ver = DENISB_THEME_VERSION;

		wp_enqueue_style( 'denisb-fonts', denisb_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query.
		wp_enqueue_style( 'denisb-base', "$uri/css/base.css", array( 'denisb-fonts' ), $ver );
		if ( denisb_is_product_view() ) {
			wp_enqueue_style( 'denisb-pages', "$uri/css/pages.css", array( 'denisb-base' ), $ver );
			wp_enqueue_style( 'denisb-blocks', "$uri/css/blocks.css", array( 'denisb-pages' ), $ver );
		}
		wp_enqueue_style( 'denisb-variations', "$uri/css/variations.css", array( 'denisb-base' ), $ver );
		wp_enqueue_style( 'denisb-mega-menu', "$uri/css/mega-menu.css", array( 'denisb-base' ), $ver );

		if ( is_front_page() || is_singular( 'sfcore_project' ) ) {
			wp_enqueue_script( 'denisb-motion', "$uri/js/motion.js", array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
		}
		wp_enqueue_script( 'denisb-rotate', "$uri/js/rotate.js", array(), $ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
	},
	20
);

/*
 * Editor canvas: the site fonts, and the "pages" stylesheet for product pages.
 */
add_action(
	'enqueue_block_assets',
	static function () {
		if ( ! is_admin() ) {
			return;
		}
		wp_enqueue_style( 'denisb-fonts', denisb_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Google Fonts URLs are versioned by their query.
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $post_id && denisb_is_product_view( $post_id ) ) {
			$uri = get_template_directory_uri() . '/assets';
			wp_enqueue_style( 'denisb-pages', "$uri/css/pages.css", array(), DENISB_THEME_VERSION );
			wp_enqueue_style( 'denisb-blocks', "$uri/css/blocks.css", array( 'denisb-pages' ), DENISB_THEME_VERSION );
		}
	}
);

add_filter(
	'body_class',
	static function ( array $classes ): array {
		$classes[] = denisb_is_product_view() ? 'denisb-pages' : 'denisb-site';
		return $classes;
	}
);

/*
 * Block style variations. The styles live in assets/css/variations.css.
 */
add_action(
	'init',
	static function () {
		$styles = array(
			'core/group'                       => array(
				'db-hero'         => __( 'Hero', 'denisb' ),
				'db-case-hero'    => __( 'Case study hero', 'denisb' ),
				'db-panel'        => __( 'Panel', 'denisb' ),
				'db-browser'      => __( 'Browser window', 'denisb' ),
				'db-browser-lg'   => __( 'Browser window (large)', 'denisb' ),
				'db-facts'        => __( 'Facts grid', 'denisb' ),
				'db-fact'         => __( 'Fact', 'denisb' ),
				'db-vetted'       => __( 'Link row', 'denisb' ),
				'db-bottom'       => __( 'Align bottom', 'denisb' ),
				'db-middle'       => __( 'Align middle', 'denisb' ),
				'db-nav'          => __( 'Site header', 'denisb' ),
				'db-contact'      => __( 'Contact band', 'denisb' ),
				'db-footer'       => __( 'Site footer', 'denisb' ),
				'db-page'         => __( 'Page', 'denisb' ),
			),
			'core/paragraph'                   => array(
				'db-label'    => __( 'Label', 'denisb' ),
				'db-label-sm' => __( 'Small label', 'denisb' ),
				'db-meta'     => __( 'Mono note', 'denisb' ),
				'db-badge'    => __( 'Availability badge', 'denisb' ),
				'db-intro'    => __( 'Intro', 'denisb' ),
				'db-body'     => __( 'Body', 'denisb' ),
				'db-body-narrow' => __( 'Body (narrow)', 'denisb' ),
				'db-copy'     => __( 'Long copy', 'denisb' ),
				'db-case-tagline' => __( 'Case study tagline', 'denisb' ),
				'db-note'     => __( 'Section note', 'denisb' ),
				'db-tagline'  => __( 'Tagline', 'denisb' ),
				'db-host'     => __( 'Browser bar', 'denisb' ),
			),
			'core/heading'                     => array(
				'db-display'       => __( 'Display', 'denisb' ),
				'db-feature-title' => __( 'Featured title', 'denisb' ),
				'db-spot-title'    => __( 'Spotlight title', 'denisb' ),
				'db-h2'            => __( 'Section heading', 'denisb' ),
				'db-case-h2'       => __( 'Case study heading', 'denisb' ),
			),
			'core/post-title'                  => array(
				'db-case-title'  => __( 'Case study title', 'denisb' ),
				'db-page-title'  => __( 'Page title', 'denisb' ),
			),
			'core/list'                        => array(
				'db-chips'      => __( 'Tags', 'denisb' ),
				'db-chips-mono' => __( 'Tags (mono)', 'denisb' ),
			),
			'core/quote'                       => array(
				'db-quote'    => __( 'Inline quote', 'denisb' ),
				'db-quote-lg' => __( 'Large quote', 'denisb' ),
			),
			'core/image'                       => array(
				'db-avatar'      => __( 'Avatar', 'denisb' ),
				'db-scroll'      => __( 'Scrolling screenshot', 'denisb' ),
				'db-scroll-card' => __( 'Scrolling screenshot card', 'denisb' ),
			),
			'core/button'                      => array(
				'db-lime'    => __( 'Lime', 'denisb' ),
				'db-dark'    => __( 'Dark', 'denisb' ),
				'db-outline' => __( 'Outline', 'denisb' ),
				'db-black'   => __( 'Black', 'denisb' ),
				'db-small'   => __( 'Header button', 'denisb' ),
				'db-back'    => __( 'Back link', 'denisb' ),
			),
			'core/navigation'                  => array(
				'db-links' => __( 'Header links', 'denisb' ),
			),
			'core/site-title'                  => array(
				'db-brand' => __( 'Brand', 'denisb' ),
			),
			'swishfolio-core/features'         => array(
				'db-numbered' => __( 'Numbered list', 'denisb' ),
				'db-cards'    => __( 'Link cards', 'denisb' ),
				'db-services' => __( 'Service cards', 'denisb' ),
				'db-built'    => __( 'Built cards', 'denisb' ),
				'db-steps'    => __( 'Process steps', 'denisb' ),
			),
			'swishfolio-core/swish-links'      => array(
				'db-vetted' => __( 'Underlined links', 'denisb' ),
			),
			'swishfolio-core/swish-cv'         => array(
				'db-experience' => __( 'Experience list', 'denisb' ),
			),
			'swishfolio-core/testimonials'     => array(
				'db-quotes' => __( 'Quote cards', 'denisb' ),
			),
			'swishfolio-core/faq'              => array(
				'db-faq' => __( 'Minimal', 'denisb' ),
			),
			'swishfolio-core/portfolio'        => array(
				'db-worklist' => __( 'Work list', 'denisb' ),
			),
		);
		foreach ( $styles as $block => $variations ) {
			foreach ( $variations as $name => $label ) {
				register_block_style(
					$block,
					array(
						'name'  => $name,
						'label' => $label,
					)
				);
			}
		}
	}
);

/*
 * Ask for the plugin pair when it is missing.
 */
add_action(
	'admin_notices',
	static function () {
		if ( defined( 'DENISB_VERSION' ) || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'The Denis B theme needs the Denis B and Swishfolio Core plugins for its blocks.', 'denisb' ) . '</p></div>';
	}
);
