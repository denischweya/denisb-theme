<?php
/**
 * The products catalogue.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'pages' ) );

$denisb_items = denisb_flagged( 'db_product', 'in_grid' );
$denisb_count = array(
	'all'    => count( $denisb_items ),
	'theme'  => 0,
	'plugin' => 0,
);
foreach ( $denisb_items as $denisb_item ) {
	$denisb_type = denisb_meta( 'product_type', $denisb_item );
	if ( isset( $denisb_count[ $denisb_type ] ) ) {
		++$denisb_count[ $denisb_type ];
	}
}
?>
<main>
<div class="hero">
<h1 class="display"><?php echo esc_html( denisb_option( 'products_title', __( 'Products', 'denisb' ) ) ); ?></h1>
<p class="lead"><?php echo esc_html( denisb_option( 'products_lead' ) ); ?></p>
<div class="filters" role="group" aria-label="<?php esc_attr_e( 'Filter products by type', 'denisb' ); ?>">
<button type="button" data-f="all" aria-pressed="true"><?php echo esc_html( sprintf( /* translators: %d: number of products. */ __( 'All (%d)', 'denisb' ), $denisb_count['all'] ) ); ?></button>
<button type="button" data-f="theme" aria-pressed="false"><?php echo esc_html( sprintf( /* translators: %d: number of themes. */ __( 'Themes (%d)', 'denisb' ), $denisb_count['theme'] ) ); ?></button>
<button type="button" data-f="plugin" aria-pressed="false"><?php echo esc_html( sprintf( /* translators: %d: number of plugins. */ __( 'Plugins (%d)', 'denisb' ), $denisb_count['plugin'] ) ); ?></button>
</div>
<p class="count" id="count" role="status"><?php echo esc_html( sprintf( /* translators: %d: number of products. */ __( 'Showing %d products', 'denisb' ), $denisb_count['all'] ) ); ?></p>
</div>
<ul class="products">
<?php
foreach ( $denisb_items as $denisb_i => $denisb_item ) :
	$denisb_ext   = denisb_meta( 'external_url', $denisb_item );
	$denisb_style = denisb_meta( 'thumb_style', $denisb_item );
	$denisb_img   = denisb_image_url( denisb_meta( 'thumb_image', $denisb_item ) );
	$denisb_img   = $denisb_img ? $denisb_img : denisb_meta( 'thumb_url', $denisb_item );
	$denisb_title = denisb_meta( 'grid_name', $denisb_item ) ? denisb_meta( 'grid_name', $denisb_item ) : get_the_title( $denisb_item );
	$denisb_load  = $denisb_i < 4 ? 'eager' : 'lazy';
	$denisb_label = denisb_meta( 'link_label', $denisb_item );
	if ( 'letter' === $denisb_style || ! $denisb_img ) {
		$denisb_thumb = '<span class="letter" aria-hidden="true">' . esc_html( denisb_meta( 'letter', $denisb_item ) ? denisb_meta( 'letter', $denisb_item ) : mb_substr( $denisb_title, 0, 1 ) ) . '</span>';
	} elseif ( 'icon' === $denisb_style ) {
		/* translators: %s: product name. */
		$denisb_thumb = sprintf( '<img class="icon" src="%s" alt="%s" width="96" height="96" loading="%s">', esc_url( $denisb_img ), esc_attr( sprintf( __( '%s plugin icon', 'denisb' ), $denisb_title ) ), $denisb_load );
	} else {
		/* translators: %s: product name. */
		$denisb_thumb = sprintf( '<img class="shot" src="%s" alt="%s" width="640" height="480" loading="%s">', esc_url( $denisb_img ), esc_attr( sprintf( __( '%s theme screenshot', 'denisb' ), $denisb_title ) ), $denisb_load );
	}
	printf(
		'<li data-type="%1$s"><a class="product" href="%2$s"><div class="thumb">%3$s</div><div class="pbody"><span class="mono">%4$s</span><h3>%5$s</h3><p>%6$s</p><span class="go">%7$s</span></div></a></li>' . "\n",
		esc_attr( denisb_meta( 'product_type', $denisb_item ) ),
		esc_url( $denisb_ext ? $denisb_ext : get_permalink( $denisb_item ) ),
		$denisb_thumb, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
		esc_html( denisb_meta( 'grid_kind', $denisb_item ) ),
		esc_html( $denisb_title ),
		esc_html( denisb_meta( 'grid_desc', $denisb_item ) ),
		esc_html( $denisb_label ? $denisb_label : __( 'Details and downloads →', 'denisb' ) )
	);
endforeach;
?>
</ul>
</main>
<?php
get_footer( null, array( 'nav' => 'pages' ) );
