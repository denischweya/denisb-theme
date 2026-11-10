<?php
/**
 * Document head and the site navigation.
 *
 * Three navigation layouts from the original design:
 * - "home": section links, Products menu, theme switcher and contact button.
 * - "case": a back link to the work list.
 * - "pages": the product pages' navigation.
 *
 * @package DenisB_Theme
 */

$denisb_nav  = $args['nav'] ?? ( is_front_page() ? 'home' : ( is_singular( 'db_project' ) ? 'case' : 'pages' ) );
$denisb_name = denisb_option( 'name', get_bloginfo( 'name' ) );
$denisb_cta  = denisb_option( 'nav_cta', __( 'Get in touch', 'denisb' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( 'pages' === $denisb_nav ) : ?>
<nav class="nav" aria-label="<?php esc_attr_e( 'Main', 'denisb' ); ?>"><div class="nav-in">
<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $denisb_name ); ?></a>
<div class="links"><a href="<?php echo esc_url( home_url( '/#work' ) ); ?>"><?php esc_html_e( 'Work', 'denisb' ); ?></a><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Services', 'denisb' ); ?></a><?php echo denisb_mega_menu( is_post_type_archive( 'db_product' ) || is_singular( 'db_product' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the function. ?><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'denisb' ); ?></a></div>
<?php denisb_theme_toggle( 'pages' ); ?>

<a class="cta-nav" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php echo esc_html( $denisb_cta ); ?></a>
</div></nav>
<?php else : ?>
<nav style="position:sticky;top:0;z-index:10;background:var(--nav-bg);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid var(--line)">
  <div style="max-width:1440px;margin:0 auto;padding:16px clamp(20px,5vw,56px);display:flex;align-items:center;gap:28px;flex-wrap:wrap;row-gap:10px">
	<?php if ( 'home' === $denisb_nav ) : ?>
    <a href="#top" style="font-weight:500;font-size:17px;letter-spacing:-.01em;margin-right:auto"><?php echo esc_html( $denisb_name ); ?></a>
    <div style="display:flex;gap:24px;font-size:16px;color:var(--muted);flex-wrap:wrap">
      <a class="h-aad9ba" href="#work" style="color:var(--muted)"><?php esc_html_e( 'Work', 'denisb' ); ?></a>
      <a class="h-aad9ba" href="#services" style="color:var(--muted)"><?php esc_html_e( 'Services', 'denisb' ); ?></a>
      <a class="h-aad9ba" href="#process" style="color:var(--muted)"><?php esc_html_e( 'Process', 'denisb' ); ?></a>
      <?php echo denisb_mega_menu(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in the function. ?>

      <a class="h-aad9ba" href="#faq" style="color:var(--muted)"><?php esc_html_e( 'FAQ', 'denisb' ); ?></a>
    </div>
	<?php else : ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-weight:500;font-size:17px;letter-spacing:-.01em;margin-right:auto"><?php echo esc_html( $denisb_name ); ?></a>
    <a class="h-aad9ba" href="<?php echo esc_url( home_url( '/#work' ) ); ?>" style="display:flex;align-items:center;gap:8px;font-size:16px;color:var(--muted)"><?php echo denisb_icon( 'back', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'All work', 'denisb' ); ?></a>
	<?php endif; ?>
    <?php denisb_theme_toggle( 'site' ); ?>
    <a class="h-312738" href="#contact" style="font-size:16px;font-weight:500;background:var(--fg);color:var(--bg);padding:9px 16px;border-radius:999px"><?php echo esc_html( $denisb_cta ); ?></a>
  </div>
</nav>
<?php endif; ?>
