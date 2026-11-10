<?php
/**
 * A case study.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'case' ) );
the_post();

$denisb_live   = denisb_meta( 'live_url' );
$denisb_repo   = denisb_meta( 'repo_url' );
$denisb_scroll = denisb_meta( 'scroll_duration' );
$denisb_host   = denisb_meta( 'host' ) ? denisb_meta( 'host' ) : denisb_host( $denisb_live );
$denisb_quote  = denisb_meta( 'quote' );

// The next case study, wrapping around to the first.
$denisb_all  = denisb_posts( 'db_project' );
$denisb_ids  = wp_list_pluck( $denisb_all, 'ID' );
$denisb_pos  = array_search( get_the_ID(), $denisb_ids, true );
$denisb_next = $denisb_all ? $denisb_all[ ( false === $denisb_pos ? 0 : $denisb_pos + 1 ) % count( $denisb_all ) ] : null;
?>

<main style="max-width:1440px;margin:0 auto;padding:0 clamp(20px,5vw,56px)">

  <section data-screen-label="Case hero" style="padding:clamp(64px,10vw,136px) 0 clamp(40px,6vw,72px);display:flex;flex-direction:column;gap:32px">
    <div style="display:flex;gap:12px;flex-wrap:wrap;font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)">
      <span style="color:var(--accent)"><?php echo esc_html( denisb_meta( 'kicker' ) ); ?></span><span>·</span><span><?php echo esc_html( denisb_meta( 'category' ) ); ?></span>
    </div>
    <h1 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(72px,12vw,184px);line-height:.86;letter-spacing:.005em;margin:0;overflow-wrap:anywhere"><?php the_title(); ?></h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,420px),1fr));gap:32px clamp(32px,5vw,72px);align-items:end">
      <p style="font-size:clamp(20px,2vw,28px);line-height:1.35;letter-spacing:-.015em;margin:0;max-width:30ch"><?php echo esc_html( denisb_meta( 'tagline' ) ); ?></p>
      <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:flex-end">
	<?php if ( $denisb_live ) : ?>
        <a class="h-9dfd38" href="<?php echo esc_url( $denisb_live ); ?>" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;background:#d4f36b;color:#0e0e0d;padding:14px 22px;border-radius:999px;white-space:nowrap"><?php esc_html_e( 'Visit live site', 'denisb' ); ?> <?php echo denisb_icon( 'out' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
	<?php endif; ?>
	<?php if ( $denisb_repo ) : ?>
          <a class="h-abfd66" href="<?php echo esc_url( $denisb_repo ); ?>" target="_blank" rel="noopener" style="font-size:17px;font-weight:500;border:1px solid var(--line2);padding:14px 22px;border-radius:999px;white-space:nowrap"><?php esc_html_e( 'Source on GitHub', 'denisb' ); ?></a>
	<?php endif; ?>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:1px;background:var(--line);border:1px solid var(--line);border-radius:16px;overflow:hidden">
	<?php foreach ( denisb_meta_lines( 'meta' ) as $denisb_m ) : ?>
        <div style="background:var(--bg);padding:20px;display:flex;flex-direction:column;gap:6px"><span style="font-family:'Geist Mono',monospace;font-size:13px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php echo esc_html( $denisb_m['k'] ); ?></span><span style="font-size:18px"><?php echo esc_html( $denisb_m['v'] ); ?></span></div>
	<?php endforeach; ?>
    </div>
  </section>

  <a class="h-b28574" href="<?php echo esc_url( $denisb_live ? $denisb_live : get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Open the live site', 'denisb' ); ?>" style="display:block;border-radius:24px;overflow:hidden;border:1px solid var(--line);background:var(--surface)">
    <div style="display:flex;align-items:center;gap:7px;padding:12px 16px;border-bottom:1px solid var(--line)">
      <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
      <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
      <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
      <span style="margin-left:12px;font-family:'Geist Mono',monospace;font-size:14px;color:var(--muted)"><?php echo esc_html( $denisb_host ); ?></span>
    </div>
    <div class="<?php echo $denisb_scroll ? 'project-scroll-frame' : ''; ?>" style="aspect-ratio:16/9;overflow:hidden;--project-scroll-duration:<?php echo esc_attr( $denisb_scroll ? $denisb_scroll : '7s' ); ?>"><img class="case-hero-image <?php echo $denisb_scroll ? 'project-scroll-image' : ''; ?>" src="<?php echo esc_url( (string) get_the_post_thumbnail_url( null, 'full' ) ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s: project name. */ __( '%s screenshot', 'denisb' ), get_the_title() ) ); ?>" loading="lazy"></div>
  </a>

  <section data-screen-label="Overview" style="padding:clamp(72px,9vw,128px) 0 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr));gap:40px clamp(32px,5vw,72px)">
    <div style="display:flex;flex-direction:column;gap:16px">
      <span style="font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php esc_html_e( 'The brief', 'denisb' ); ?></span>
      <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(40px,4.4vw,60px);line-height:.95;margin:0"><?php esc_html_e( 'The challenge', 'denisb' ); ?></h2>
      <p style="font-size:18px;line-height:1.65;margin:0;color:var(--body);max-width:56ch"><?php echo esc_html( denisb_meta( 'challenge' ) ); ?></p>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px">
      <span style="font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php esc_html_e( 'What I did', 'denisb' ); ?></span>
      <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(40px,4.4vw,60px);line-height:.95;margin:0"><?php esc_html_e( 'The approach', 'denisb' ); ?></h2>
      <p style="font-size:18px;line-height:1.65;margin:0;color:var(--body);max-width:56ch"><?php echo esc_html( denisb_meta( 'approach' ) ); ?></p>
    </div>
  </section>

  <section data-screen-label="Built" style="padding:clamp(72px,9vw,128px) 0 0">
    <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(44px,5.6vw,76px);line-height:.92;margin:0 0 36px"><?php esc_html_e( 'What I built', 'denisb' ); ?></h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:16px">
	<?php foreach ( denisb_meta_lines( 'features' ) as $denisb_i => $denisb_f ) : ?>
        <div style="padding:28px;border-radius:20px;background:var(--surface);display:flex;flex-direction:column;gap:12px">
          <span style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--accent)"><?php echo esc_html( sprintf( '%02d', $denisb_i + 1 ) ); ?></span>
          <h3 style="font-weight:500;font-size:21px;letter-spacing:-.015em;margin:0"><?php echo esc_html( $denisb_f['t'] ); ?></h3>
          <p style="font-size:17px;line-height:1.6;margin:0;color:var(--body)"><?php echo esc_html( $denisb_f['d'] ); ?></p>
        </div>
	<?php endforeach; ?>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:28px">
	<?php foreach ( denisb_meta_lines( 'tech' ) as $denisb_t ) : ?>
        <span style="font-family:'Geist Mono',monospace;font-size:15px;padding:8px 14px;border:1px solid var(--line2);border-radius:999px;color:var(--fg2)"><?php echo esc_html( $denisb_t['name'] ); ?></span>
	<?php endforeach; ?>
    </div>
  </section>

<?php if ( $denisb_quote ) : ?>
    <section data-screen-label="Quote" style="padding:clamp(72px,9vw,128px) 0 0">
      <figure style="margin:0;padding:clamp(28px,5vw,64px);border-radius:28px;border:1px solid var(--line);display:flex;flex-direction:column;gap:28px">
        <blockquote style="margin:0;font-family:'Instrument Serif',serif;font-size:clamp(28px,3.4vw,46px);line-height:1.2;max-width:28ch">“<?php echo esc_html( $denisb_quote ); ?>”</blockquote>
        <figcaption style="font-size:17px;color:var(--muted)"><?php echo esc_html( denisb_meta( 'quote_by' ) ); ?></figcaption>
      </figure>
    </section>
<?php endif; ?>

<?php if ( $denisb_next ) : ?>
  <section data-screen-label="Next" style="padding:clamp(72px,9vw,128px) 0 0">
    <a class="h-bb2b0e" href="<?php echo esc_url( get_permalink( $denisb_next ) ); ?>" style="display:flex;flex-direction:column;gap:14px;padding:clamp(28px,5vw,56px) 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
      <span style="font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php esc_html_e( 'Next case study', 'denisb' ); ?></span>
      <span style="display:flex;justify-content:space-between;align-items:center;gap:24px">
        <span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(56px,9vw,136px);line-height:.88"><?php echo esc_html( get_the_title( $denisb_next ) ); ?></span>
        <?php echo denisb_icon( 'arrow', 56, 'big' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </span>
    </a>
  </section>
<?php endif; ?>

</main>

<?php
get_footer( null, array( 'nav' => 'case' ) );
