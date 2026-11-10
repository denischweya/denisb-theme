<?php
/**
 * Template helpers.
 *
 * @package DenisB_Theme
 */

defined( 'ABSPATH' ) || exit;

/*
 * Safe fallbacks so templates never fatal when the plugin is inactive.
 */
if ( ! function_exists( 'denisb_option' ) ) {
	/**
	 * Fallback for the plugin's settings helper.
	 *
	 * @param string $key     Setting key.
	 * @param string $default Default value.
	 */
	function denisb_option( string $key, string $default = '' ): string { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.defaultFound
		unset( $key );
		return $default;
	}
	/**
	 * Fallback for the plugin's lines helper.
	 *
	 * @param string $key Setting key.
	 */
	function denisb_option_lines( string $key ): array {
		unset( $key );
		return array();
	}
	/**
	 * Fallback for the plugin's posts helper.
	 *
	 * @param string $type Post type.
	 * @param array  $args Arguments.
	 */
	function denisb_posts( string $type, array $args = array() ): array {
		unset( $type, $args );
		return array();
	}
	/**
	 * Fallback for the plugin's flagged posts helper.
	 *
	 * @param string $type Post type.
	 * @param string $flag Meta key.
	 */
	function denisb_flagged( string $type, string $flag ): array {
		unset( $type, $flag );
		return array();
	}
	/**
	 * Fallback for the plugin's meta helper.
	 *
	 * @param string           $key  Meta key.
	 * @param int|WP_Post|null $post Post.
	 */
	function denisb_meta( string $key, $post = null ): string {
		$post = get_post( $post );
		return $post ? (string) get_post_meta( $post->ID, $key, true ) : '';
	}
	/**
	 * Fallback for the plugin's meta lines helper.
	 *
	 * @param string           $key  Meta key.
	 * @param int|WP_Post|null $post Post.
	 */
	function denisb_meta_lines( string $key, $post = null ): array {
		unset( $key, $post );
		return array();
	}
	/**
	 * Fallback for the plugin's image helper.
	 *
	 * @param int|string $id   Attachment ID.
	 * @param string     $size Size.
	 */
	function denisb_image_url( $id, string $size = 'full' ): string {
		$id = absint( $id );
		return $id ? (string) wp_get_attachment_image_url( $id, $size ) : '';
	}
	/**
	 * Fallback for the plugin's host helper.
	 *
	 * @param string $url URL.
	 */
	function denisb_host( string $url ): string {
		return preg_replace( '/^www\./', '', (string) wp_parse_url( $url, PHP_URL_HOST ) );
	}
}

/**
 * Returns an inline SVG icon from the original design.
 *
 * @param string $name Icon name: arrow, out, back, chevron.
 * @param int    $size Width and height.
 * @param string $extra Extra attributes.
 */
function denisb_icon( string $name, int $size = 15, string $extra = '' ): string {
	$paths = array(
		'arrow'   => 'M5 12h14M13 6l6 6-6 6',
		'out'     => 'M7 17 17 7M8 7h9v9',
		'back'    => 'M19 12H5M11 18l-6-6 6-6',
		'chevron' => 'm6 9 6 6 6-6',
	);
	$width = 'chevron' === $name ? '2.4' : ( 'big' === $extra ? '1.5' : '2' );
	$extra = 'big' === $extra ? ' style="flex:none"' : $extra;
	return sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round"%3$s><path d="%4$s"></path></svg>',
		$size,
		$width,
		$extra,
		$paths[ $name ] ?? $paths['arrow']
	);
}

/**
 * Prints the light and dark theme switcher.
 *
 * @param string $variant "site" for inline-styled pages, "pages" for class-styled pages.
 */
function denisb_theme_toggle( string $variant ): void {
	$buttons = array(
		'system' => array( __( 'System', 'denisb' ), __( 'System theme', 'denisb' ), '<rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8M12 17v4"></path>' ),
		'light'  => array( __( 'Light', 'denisb' ), __( 'Light theme', 'denisb' ), '<circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>' ),
		'dark'   => array( __( 'Dark', 'denisb' ), __( 'Dark theme', 'denisb' ), '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>' ),
	);
	$svg = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">%s</svg>';
	if ( 'site' === $variant ) {
		echo '<div role="group" aria-label="' . esc_attr__( 'Colour theme', 'denisb' ) . '" data-tt="inline" style="display:flex;gap:2px;padding:3px;border:1px solid var(--line2);border-radius:999px">' . "\n";
		foreach ( $buttons as $key => list( $title, $label, $icon ) ) {
			$on = 'system' === $key;
			printf(
				'      <button type="button" data-t="%1$s" aria-pressed="%2$s" title="%3$s" aria-label="%4$s" style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;border:0;border-radius:999px;cursor:pointer;background:%5$s;color:%6$s">%7$s</button>' . "\n",
				esc_attr( $key ),
				$on ? 'true' : 'false',
				esc_attr( $title ),
				esc_attr( $label ),
				$on ? 'var(--surface3)' : 'transparent',
				$on ? 'var(--fg)' : 'var(--muted)',
				sprintf( $svg, $icon ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup.
			);
		}
		echo "    </div>\n";
		return;
	}
	echo '<div class="tt" role="group" aria-label="' . esc_attr__( 'Colour theme', 'denisb' ) . '">';
	foreach ( $buttons as $key => list( $title, $label, $icon ) ) {
		printf(
			'<button type="button" data-t="%1$s" aria-pressed="false" title="%2$s" aria-label="%3$s">%4$s</button>',
			esc_attr( $key ),
			esc_attr( $title ),
			esc_attr( $label ),
			sprintf( $svg, $icon ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup.
		);
	}
	echo '</div>';
}

/**
 * Returns the Products mega menu.
 *
 * @param bool $current Whether a products page is being viewed.
 */
function denisb_mega_menu( bool $current = false ): string {
	$archive = (string) get_post_type_archive_link( 'db_product' );
	$items   = denisb_flagged( 'db_product', 'in_menu' );
	usort( $items, static fn( $a, $b ) => (int) denisb_meta( 'menu_order_n', $a ) <=> (int) denisb_meta( 'menu_order_n', $b ) );

	$html  = '<div class="mm">';
	$html .= sprintf(
		'<a class="mm-trigger" href="%s"%s>%s%s</a>',
		esc_url( $archive ),
		$current ? ' aria-current="page"' : '',
		esc_html__( 'Products', 'denisb' ),
		'<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>'
	);
	$html .= '<div class="mm-panel"><div class="mm-inner"><div class="mm-grid">';
	foreach ( $items as $item ) {
		$url    = denisb_meta( 'menu_url', $item ) ? denisb_meta( 'menu_url', $item ) : get_permalink( $item );
		$name   = denisb_meta( 'menu_name', $item ) ? denisb_meta( 'menu_name', $item ) : get_the_title( $item );
		$icon   = denisb_image_url( denisb_meta( 'menu_icon', $item ) ? denisb_meta( 'menu_icon', $item ) : denisb_meta( 'thumb_image', $item ) );
		$letter = denisb_meta( 'letter', $item );
		$badge  = denisb_meta( 'menu_badge', $item );
		$ico    = ( 'letter' === denisb_meta( 'thumb_style', $item ) || ! $icon )
			? '<span class="mm-ico mm-letter" aria-hidden="true">' . esc_html( $letter ? $letter : mb_substr( $name, 0, 1 ) ) . '</span>'
			: '<img class="mm-ico" src="' . esc_url( $icon ) . '" alt="" width="44" height="44" loading="lazy">';
		$html  .= sprintf(
			'<a class="mm-item" href="%1$s">%2$s<span class="mm-txt"><span class="mm-kind">%3$s</span><span class="mm-name">%4$s%5$s</span><span class="mm-desc">%6$s</span></span></a>',
			esc_url( $url ),
			$ico,
			esc_html( denisb_meta( 'menu_kind', $item ) ),
			esc_html( $name ),
			$badge ? '<span class="mm-new">' . esc_html( $badge ) . '</span>' : '',
			esc_html( denisb_meta( 'menu_desc', $item ) )
		);
	}
	$html .= sprintf(
		'</div><div class="mm-foot"><span>%s</span><a href="%s">%s</a></div></div></div></div>',
		esc_html( denisb_option( 'menu_note' ) ),
		esc_url( $archive ),
		esc_html__( 'All products →', 'denisb' )
	);
	return $html;
}

/**
 * Converts 1–39 to lower-case Roman numerals, for process steps.
 *
 * @param int $n Number.
 */
function denisb_roman( int $n ): string {
	$map = array( 'x' => 10, 'ix' => 9, 'v' => 5, 'iv' => 4, 'i' => 1 );
	$out = '';
	foreach ( $map as $r => $v ) {
		while ( $n >= $v ) {
			$out .= $r;
			$n   -= $v;
		}
	}
	return $out;
}

/**
 * Returns the URL of a section on the homepage.
 *
 * @param string $id Section ID.
 */
function denisb_home_anchor( string $id ): string {
	return is_front_page() ? '#' . $id : home_url( '/#' . $id );
}

/**
 * Returns the text of a post's content as plain paragraphs, without blocks.
 *
 * @param WP_Post $post Post.
 */
function denisb_plain( WP_Post $post ): string {
	return trim( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
}
