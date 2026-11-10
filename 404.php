<?php
/**
 * Not found.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'pages' ) );
?>
<main>
<div class="hero">
<p class="mono" style="margin:0 0 16px">404</p>
<h1 class="display"><?php esc_html_e( 'Nothing here', 'denisb' ); ?></h1>
<p class="lead"><?php esc_html_e( 'The page you were looking for has moved or never existed.', 'denisb' ); ?></p>
<div class="btns"><a class="btn primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the homepage', 'denisb' ); ?></a><a class="btn" href="<?php echo esc_url( (string) get_post_type_archive_link( 'db_product' ) ); ?>"><?php esc_html_e( 'Browse products', 'denisb' ); ?></a></div>
</div>
</main>
<?php
get_footer( null, array( 'nav' => 'pages' ) );
