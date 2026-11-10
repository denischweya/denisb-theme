<?php
/**
 * Fallback for posts, pages, archives and search, in the product page style.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'pages' ) );
?>
<main>
<?php if ( is_singular() ) : ?>
	<?php the_post(); ?>
<div class="hero">
<h1 class="display"><?php the_title(); ?></h1>
</div>
<div class="entry"><?php the_content(); ?></div>
<?php elseif ( have_posts() ) : ?>
<div class="hero">
<h1 class="display"><?php echo is_home() ? esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ? get_the_title( (int) get_option( 'page_for_posts' ) ) : __( 'Writing', 'denisb' ) ) : wp_kses_post( get_the_archive_title() ); ?></h1>
</div>
<section>
<div class="grid2">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
<a class="card" href="<?php the_permalink(); ?>"><span class="mono"><?php echo esc_html( get_the_date() ); ?></span><h3><?php the_title(); ?></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?></p></a>
	<?php endwhile; ?>
</div>
<div class="btns"><?php the_posts_navigation(); ?></div>
</section>
<?php else : ?>
<div class="hero">
<h1 class="display"><?php esc_html_e( 'Nothing here', 'denisb' ); ?></h1>
<p class="lead"><?php esc_html_e( 'The page you were looking for has moved or never existed.', 'denisb' ); ?></p>
<div class="btns"><a class="btn primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the homepage', 'denisb' ); ?></a></div>
</div>
<?php endif; ?>
</main>
<?php
get_footer( null, array( 'nav' => 'pages' ) );
