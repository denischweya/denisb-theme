<?php
/**
 * A product landing page. The hero comes from the product's fields and the
 * sections below it from the block editor.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'pages' ) );
the_post();

$denisb_banner = (int) denisb_meta( 'banner' );
$denisb_meta   = $denisb_banner ? wp_get_attachment_metadata( $denisb_banner ) : array();
?>
<main>
<div class="hero">
<nav class="crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'denisb' ); ?>"><ol><li><a href="<?php echo esc_url( (string) get_post_type_archive_link( 'db_product' ) ); ?>"><?php esc_html_e( 'Products', 'denisb' ); ?></a></li><li><?php the_title(); ?></li></ol></nav>
<p class="mono" style="margin:0 0 16px"><?php echo esc_html( denisb_meta( 'eyebrow' ) ? denisb_meta( 'eyebrow' ) : get_the_title() ); ?></p>
<h1 class="display"><?php echo esc_html( denisb_meta( 'headline' ) ? denisb_meta( 'headline' ) : get_the_title() ); ?></h1>
<?php if ( denisb_meta( 'lead' ) ) : ?>
<p class="lead"><?php echo esc_html( denisb_meta( 'lead' ) ); ?></p>
<?php endif; ?>
<?php $denisb_buttons = denisb_meta_lines( 'hero_buttons' ); ?>
<?php if ( $denisb_buttons ) : ?>
<div class="btns">
	<?php foreach ( $denisb_buttons as $denisb_b ) : ?>
<a class="btn<?php echo 'primary' === $denisb_b['style'] ? ' primary' : ''; ?>" href="<?php echo esc_url( $denisb_b['url'] ); ?>"><?php echo esc_html( $denisb_b['label'] ); ?></a>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ( $denisb_banner ) : ?>
<img class="banner" src="<?php echo esc_url( denisb_image_url( $denisb_banner ) ); ?>" alt="<?php echo esc_attr( denisb_meta( 'banner_alt' ) ); ?>" width="<?php echo (int) ( $denisb_meta['width'] ?? 1544 ); ?>" height="<?php echo (int) ( $denisb_meta['height'] ?? 500 ); ?>" fetchpriority="high">
<?php endif; ?>
</div>
<?php the_content(); ?>
</main>
<?php
get_footer( null, array( 'nav' => 'pages' ) );
