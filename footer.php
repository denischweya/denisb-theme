<?php
/**
 * Contact band and footer.
 *
 * @package DenisB_Theme
 */

$denisb_nav    = $args['nav'] ?? ( is_front_page() ? 'home' : ( is_singular( 'db_project' ) ? 'case' : 'pages' ) );
$denisb_left   = denisb_option( 'footer_left', '© ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ) );
$denisb_credit = denisb_option_lines( 'footer_credit' )[0] ?? null;

if ( 'pages' === $denisb_nav ) :
	?>
<footer><span><?php echo esc_html( $denisb_left ); ?></span><?php if ( $denisb_credit ) : ?><span><?php echo esc_html( $denisb_credit['before'] ); ?> <a href="<?php echo esc_url( $denisb_credit['url'] ); ?>"><?php echo esc_html( $denisb_credit['label'] ); ?></a></span><?php endif; ?></footer>
	<?php
else :
	get_template_part( 'template-parts/contact', null, array( 'nav' => $denisb_nav ) );
	?>

  <footer style="max-width:1440px;margin:0 auto;display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;padding:40px clamp(20px,5vw,56px);font-size:15px;color:var(--muted)">
    <span><?php echo esc_html( $denisb_left ); ?></span>
	<?php if ( 'case' === $denisb_nav ) : ?>
    <a href="<?php echo esc_url( home_url( '/#work' ) ); ?>" style="color:var(--fg2)"><?php esc_html_e( '← Back to all work', 'denisb' ); ?></a>
	<?php elseif ( $denisb_credit ) : ?>
    <span><?php echo esc_html( $denisb_credit['before'] ); ?> <a href="<?php echo esc_url( $denisb_credit['url'] ); ?>" style="color:var(--fg2)"><?php echo esc_html( $denisb_credit['label'] ); ?></a></span>
	<?php endif; ?>
  </footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
