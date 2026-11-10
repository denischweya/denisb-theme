<?php
/**
 * The homepage.
 *
 * Markup and inline styles follow the original design exactly; text and lists
 * come from Denis B settings and content types.
 *
 * @package DenisB_Theme
 */

get_header( null, array( 'nav' => 'home' ) );

$denisb_mono   = "font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)";
$denisb_h2     = "font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(44px,5.6vw,76px);line-height:.92;letter-spacing:.005em;margin:0";
$denisb_words  = wp_list_pluck( denisb_option_lines( 'rotating_words' ), 'word' );
$denisb_words  = $denisb_words ? $denisb_words : array( __( 'products', 'denisb' ) );
$denisb_avatar = denisb_image_url( denisb_option( 'avatar' ) );
?>

<main id="top" style="max-width:1440px;margin:0 auto;padding:0 clamp(20px,5vw,56px)">

  <section data-screen-label="Hero" style="padding:clamp(72px,12vw,160px) 0 clamp(56px,8vw,96px);display:flex;flex-direction:column;gap:40px">
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
	<?php if ( denisb_option( 'show_avatar' ) && $denisb_avatar ) : ?>
        <img src="<?php echo esc_url( $denisb_avatar ); ?>" alt="<?php echo esc_attr( denisb_option( 'name' ) ); ?>" style="width:48px;height:48px;border-radius:50%;object-fit:cover;background:var(--surface3)">
	<?php endif; ?>
      <div style="display:flex;flex-direction:column;gap:2px">
        <span style="font-size:17px;font-weight:500"><?php echo esc_html( denisb_option( 'name', get_bloginfo( 'name' ) ) ); ?></span>
        <span style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--muted);white-space:nowrap"><?php echo esc_html( denisb_option( 'tagline', get_bloginfo( 'description' ) ) ); ?></span>
      </div>
	<?php if ( denisb_option( 'available' ) ) : ?>
        <span style="display:flex;align-items:center;gap:8px;font-size:15px;color:var(--accent);border:1px solid var(--badge-line);background:var(--badge-bg);padding:6px 12px;border-radius:999px;white-space:nowrap;flex:none"><span style="width:7px;height:7px;border-radius:50%;background:var(--accent);animation:pulse 2s ease-in-out infinite;display:block"></span><?php echo esc_html( denisb_option( 'available_text' ) ); ?></span>
	<?php endif; ?>
    </div>
    <h1 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(64px,11vw,168px);line-height:.88;letter-spacing:.005em;margin:0;max-width:12ch"><?php echo esc_html( denisb_option( 'headline_before', 'I build' ) ); ?> <span style="display:inline-block;color:var(--accent);min-width:4.6em;position:relative"><span class="rot" data-words="<?php echo esc_attr( wp_json_encode( array_values( $denisb_words ) ) ); ?>" style="display:inline-grid;overflow:clip;overflow-clip-margin:.08em;vertical-align:bottom;padding-bottom:.04em"><span style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)"><?php echo esc_html( implode( ', ', $denisb_words ) ); ?></span><span class="rot-word" aria-hidden="true" style="grid-area:1/1;display:inline-flex;white-space:nowrap">
	<?php
	foreach ( mb_str_split( $denisb_words[0] ) as $denisb_i => $denisb_char ) {
		printf( '<span style="display:inline-block;animation:chIn .7s cubic-bezier(.65,0,.15,1) both;animation-delay:%dms">%s</span>', (int) $denisb_i * 38, esc_html( $denisb_char ) );
	}
	?>
</span></span></span><br><?php echo esc_html( denisb_option( 'headline_after' ) ); ?></h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr));gap:32px;align-items:end">
      <p style="font-size:clamp(17px,1.5vw,20px);line-height:1.55;margin:0;max-width:46ch;color:var(--body)"><?php echo esc_html( denisb_option( 'intro' ) ); ?></p>
      <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:flex-end">
        <a class="h-9dfd38" href="<?php echo esc_url( denisb_option( 'cta_url', '#contact' ) ); ?>" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;background:#d4f36b;color:#0e0e0d;padding:14px 22px;border-radius:999px;white-space:nowrap;flex:none"><?php echo esc_html( denisb_option( 'cta_label', __( 'Start a project', 'denisb' ) ) ); ?> <?php echo denisb_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
      </div>
    </div>
    <div style="display:flex;gap:clamp(20px,4vw,48px);flex-wrap:wrap;padding-top:28px;border-top:1px solid var(--line);font-size:16px;color:var(--muted)">
      <span style="font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.04em;text-transform:uppercase"><?php echo esc_html( denisb_option( 'vetted_label' ) ); ?></span>
	<?php foreach ( denisb_option_lines( 'vetted_links' ) as $denisb_link ) : ?>
      <a class="vetted-link" href="<?php echo esc_url( $denisb_link['url'] ); ?>"><?php echo esc_html( $denisb_link['label'] ); ?></a>
	<?php endforeach; ?>
    </div>
  </section>

<?php
$denisb_feat = get_post( (int) denisb_option( 'featured_project' ) );
if ( $denisb_feat && 'publish' === $denisb_feat->post_status ) :
	$denisb_link  = denisb_option_lines( 'featured_link' )[0] ?? null;
	$denisb_shot  = denisb_image_url( denisb_option( 'featured_image' ) );
	$denisb_shot  = $denisb_shot ? $denisb_shot : (string) get_the_post_thumbnail_url( $denisb_feat, 'full' );
	$denisb_feats = denisb_meta_lines( 'features', $denisb_feat );
	?>
  <section id="<?php echo esc_attr( $denisb_feat->post_name ); ?>" data-screen-label="Featured: <?php echo esc_attr( get_the_title( $denisb_feat ) ); ?>" style="scroll-margin-top:80px;background:var(--surface);border:1px solid var(--line);border-radius:28px;padding:clamp(24px,4vw,56px);display:flex;flex-direction:column;gap:clamp(28px,4vw,48px)">
    <div style="display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;font-family:'Geist Mono',monospace;font-size:14px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)">
      <span style="color:var(--accent)"><?php echo esc_html( denisb_option( 'featured_label' ) ); ?></span>
      <span><?php echo esc_html( denisb_option( 'featured_note' ) ); ?></span>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,520px),1fr));gap:clamp(24px,4vw,64px);align-items:end">
      <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(72px,10vw,160px);line-height:.85;letter-spacing:.005em;margin:0;min-width:0;overflow-wrap:anywhere"><?php echo esc_html( get_the_title( $denisb_feat ) ); ?></h2>
      <div style="display:flex;flex-direction:column;gap:18px">
        <p style="font-size:clamp(20px,1.9vw,26px);line-height:1.3;letter-spacing:-.015em;margin:0"><?php echo esc_html( denisb_meta( 'tagline', $denisb_feat ) ); ?></p>
        <p style="font-size:18px;line-height:1.6;margin:0;color:var(--body)"><?php echo esc_html( denisb_option( 'featured_desc' ) ); ?></p>
        <div style="display:flex;gap:10px;flex-wrap:wrap"><a class="h-9dfd38" href="<?php echo esc_url( get_permalink( $denisb_feat ) ); ?>" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;background:#d4f36b;color:#0e0e0d;padding:13px 20px;border-radius:999px;white-space:nowrap"><?php esc_html_e( 'Read case study', 'denisb' ); ?> <?php echo denisb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php if ( $denisb_link ) : ?><a class="h-312738" href="<?php echo esc_url( $denisb_link['url'] ); ?>" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;background:var(--fg);color:var(--bg);padding:13px 20px;border-radius:999px"><?php echo esc_html( $denisb_link['label'] ); ?> <?php echo denisb_icon( 'out' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endif; ?></div>
      </div>
    </div>
    <figure style="margin:0;border-radius:16px;overflow:hidden;border:1px solid var(--line2);background:var(--surface3)">
      <div style="display:flex;align-items:center;gap:7px;padding:12px 16px;border-bottom:1px solid var(--line2)">
        <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
        <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
        <span style="width:10px;height:10px;border-radius:50%;background:var(--line2)"></span>
        <span style="margin-left:12px;font-family:'Geist Mono',monospace;font-size:14px;color:var(--muted)"><?php echo esc_html( denisb_option( 'featured_host', denisb_host( denisb_meta( 'live_url', $denisb_feat ) ) ) ); ?></span>
      </div>
      <div class="project-scroll-frame" style="aspect-ratio:16/9;--project-scroll-duration:<?php echo esc_attr( denisb_option( 'featured_scroll', '9s' ) ); ?>">
        <img class="project-scroll-image" src="<?php echo esc_url( $denisb_shot ); ?>" alt="<?php echo esc_attr( denisb_option( 'featured_alt' ) ); ?>" loading="lazy">
      </div>
    </figure>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:1px;background:var(--line);border:1px solid var(--line);border-radius:16px;overflow:hidden">
	<?php foreach ( denisb_option_lines( 'featured_facts' ) as $denisb_fact ) : ?>
      <div style="background:var(--surface);padding:20px;display:flex;flex-direction:column;gap:6px"><span style="font-family:'Geist Mono',monospace;font-size:13px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php echo esc_html( $denisb_fact['k'] ); ?></span><span style="font-size:17px"><?php echo esc_html( $denisb_fact['v'] ); ?></span></div>
	<?php endforeach; ?>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:clamp(28px,3vw,40px)">
	<?php foreach ( $denisb_feats as $denisb_i => $denisb_f ) : ?>
      <div style="display:flex;flex-direction:column;gap:10px"><span style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--accent)"><?php echo esc_html( sprintf( '%02d', $denisb_i + 1 ) ); ?></span><h3 style="font-weight:500;font-size:19px;letter-spacing:-.01em;margin:0"><?php echo esc_html( $denisb_f['t'] ); ?></h3><p style="font-size:18px;line-height:1.6;margin:0;color:var(--body)"><?php echo esc_html( $denisb_f['d'] ); ?></p></div>
	<?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php
$denisb_spot = get_post( (int) denisb_option( 'spot_project' ) );
if ( $denisb_spot && 'publish' === $denisb_spot->post_status ) :
	$denisb_link = denisb_option_lines( 'spot_link' )[0] ?? null;
	$denisb_shot = denisb_image_url( denisb_option( 'spot_image' ) );
	$denisb_shot = $denisb_shot ? $denisb_shot : (string) get_the_post_thumbnail_url( $denisb_spot, 'full' );
	$denisb_name = get_the_title( $denisb_spot );
	?>
  <section id="work" data-screen-label="Case study: <?php echo esc_attr( $denisb_name ); ?>" style="scroll-margin-top:80px;padding:clamp(80px,10vw,140px) 0 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,420px),1fr));gap:clamp(32px,5vw,72px);align-items:center">
    <a href="<?php echo esc_url( get_permalink( $denisb_spot ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: project name. */ __( 'Read the %s case study', 'denisb' ), $denisb_name ) ); ?>" class="project-scroll-frame h-b28574" style="display:block;aspect-ratio:4/3;--project-scroll-duration:<?php echo esc_attr( denisb_option( 'spot_scroll', '6s' ) ); ?>;border-radius:20px;border:1px solid var(--line);background:var(--surface);align-self:center">
      <img class="project-scroll-image" src="<?php echo esc_url( $denisb_shot ); ?>" alt="<?php echo esc_attr( denisb_option( 'spot_alt' ) ); ?>" loading="lazy">
    </a>
    <div style="display:flex;flex-direction:column;gap:24px">
      <span style="<?php echo esc_attr( $denisb_mono ); ?>"><?php echo esc_html( denisb_option( 'spot_label' ) ); ?></span>
      <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(52px,7vw,96px);line-height:.92;letter-spacing:.005em;margin:0"><?php echo esc_html( $denisb_name ); ?></h2>
      <p style="font-size:18px;line-height:1.6;margin:0;color:var(--body);max-width:48ch"><?php echo esc_html( denisb_option( 'spot_desc' ) ); ?></p>
      <div style="display:flex;gap:10px;flex-wrap:wrap"><a class="h-312738" href="<?php echo esc_url( get_permalink( $denisb_spot ) ); ?>" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;background:var(--fg);color:var(--bg);padding:12px 20px;border-radius:999px;white-space:nowrap"><?php esc_html_e( 'Read case study', 'denisb' ); ?> <?php echo denisb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php if ( $denisb_link ) : ?><a class="h-abfd66" href="<?php echo esc_url( $denisb_link['url'] ); ?>" style="display:flex;align-items:center;gap:10px;font-size:17px;font-weight:500;border:1px solid var(--line2);padding:12px 20px;border-radius:999px;white-space:nowrap"><?php echo esc_html( $denisb_link['label'] ); ?> <?php echo denisb_icon( 'out' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endif; ?></div>
      <div style="display:flex;flex-wrap:wrap;gap:8px">
	<?php foreach ( denisb_option_lines( 'spot_tags' ) as $denisb_tag ) : ?>
        <span style="font-size:16px;padding:8px 14px;border:1px solid var(--line2);border-radius:999px"><?php echo esc_html( $denisb_tag['tag'] ); ?></span>
	<?php endforeach; ?>
      </div>
	<?php if ( denisb_option( 'spot_quote' ) ) : ?>
      <blockquote style="margin:8px 0 0;padding:20px 0 0;border-top:1px solid var(--line);font-family:'Instrument Serif',serif;font-size:22px;line-height:1.35;color:var(--fg2)">“<?php echo esc_html( denisb_option( 'spot_quote' ) ); ?>”<span style="display:block;margin-top:12px;font-family:'Geist',sans-serif;font-size:16px;color:var(--muted)"><?php echo esc_html( denisb_option( 'spot_by' ) ); ?></span></blockquote>
	<?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<?php
$denisb_shipped = denisb_flagged( 'db_product', 'on_home' );
usort( $denisb_shipped, static fn( $a, $b ) => (int) denisb_meta( 'home_order', $a ) <=> (int) denisb_meta( 'home_order', $b ) );
?>
<?php if ( $denisb_shipped ) : ?>
  <section data-screen-label="Products" style="padding:clamp(80px,10vw,140px) 0 0">
    <div style="display:flex;justify-content:space-between;align-items:end;gap:24px;flex-wrap:wrap;margin-bottom:36px">
      <h2 style="<?php echo esc_attr( $denisb_h2 ); ?>"><?php echo esc_html( denisb_option( 'shipped_title' ) ); ?></h2>
      <p style="font-size:17px;margin:0;color:var(--muted);max-width:38ch"><?php echo esc_html( denisb_option( 'shipped_desc' ) ); ?></p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:16px">
	<?php foreach ( $denisb_shipped as $denisb_p ) : ?>
      <a class="h-1b90cf" href="<?php echo esc_url( denisb_meta( 'home_url', $denisb_p ) ? denisb_meta( 'home_url', $denisb_p ) : get_permalink( $denisb_p ) ); ?>" style="display:flex;flex-direction:column;gap:14px;padding:28px;border:1px solid var(--line);border-radius:20px;background:var(--surface2);min-height:260px">
        <span style="font-family:'Geist Mono',monospace;font-size:13px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)"><?php echo esc_html( denisb_meta( 'home_kind', $denisb_p ) ); ?></span>
        <h3 style="font-weight:500;font-size:24px;letter-spacing:-.02em;margin:0"><?php echo esc_html( denisb_meta( 'home_name', $denisb_p ) ? denisb_meta( 'home_name', $denisb_p ) : get_the_title( $denisb_p ) ); ?></h3>
        <p style="font-size:18px;line-height:1.6;margin:0;color:var(--body);flex:1"><?php echo esc_html( denisb_meta( 'home_desc', $denisb_p ) ); ?></p>
        <span style="font-size:16px;color:var(--accent)"><?php echo esc_html( denisb_meta( 'home_link', $denisb_p ) ? denisb_meta( 'home_link', $denisb_p ) : __( 'Details and downloads →', 'denisb' ) ); ?></span>
      </a>
	<?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php $denisb_work = denisb_flagged( 'db_project', 'in_work_list' ); ?>
<?php if ( $denisb_work ) : ?>
  <section data-screen-label="Client work" style="padding:clamp(80px,10vw,140px) 0 0">
    <div style="display:flex;justify-content:space-between;align-items:end;gap:24px;flex-wrap:wrap;margin-bottom:24px">
      <h2 style="<?php echo esc_attr( $denisb_h2 ); ?>"><?php echo esc_html( denisb_option( 'work_title' ) ); ?></h2>
      <p style="font-size:17px;margin:0;color:var(--muted);max-width:38ch"><?php echo esc_html( denisb_option( 'work_desc' ) ); ?></p>
    </div>
    <div style="display:flex;flex-direction:column;border-top:1px solid var(--line)">
	<?php
	foreach ( $denisb_work as $denisb_p ) :
		$denisb_thumb = denisb_image_url( denisb_meta( 'list_image', $denisb_p ) );
		$denisb_thumb = $denisb_thumb ? $denisb_thumb : (string) get_the_post_thumbnail_url( $denisb_p, 'full' );
		?>
        <a class="cw-row h-710813" href="<?php echo esc_url( get_permalink( $denisb_p ) ); ?>" style="display:grid;grid-template-columns:96px minmax(0,1fr) auto;gap:clamp(16px,3vw,32px);align-items:center;padding:18px 0;border-bottom:1px solid var(--line)">
          <div class="cw-thumb" style="width:96px;height:64px;border-radius:10px;overflow:hidden;background:var(--surface3)"><img src="<?php echo esc_url( $denisb_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $denisb_p ) ); ?>" style="width:100%;height:100%;object-fit:cover;object-position:top"></div>
          <div style="display:flex;flex-direction:column;gap:4px;min-width:0">
            <span class="cw-name" style="font-size:clamp(18px,2vw,24px);letter-spacing:-.02em"><?php echo esc_html( get_the_title( $denisb_p ) ); ?></span>
            <span class="cw-stack" style="font-size:16px;color:var(--muted)"><?php echo esc_html( denisb_meta( 'stack', $denisb_p ) ); ?></span>
          </div>
          <span class="cw-client" style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--muted);text-align:right"><span class="cw-client-name"><?php echo esc_html( denisb_meta( 'client', $denisb_p ) ); ?></span> <span class="cw-arrow">→</span></span>
        </a>
	<?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

  <section id="services" data-screen-label="Services" style="scroll-margin-top:80px;padding:clamp(80px,10vw,140px) 0 0">
    <h2 style="<?php echo esc_attr( $denisb_h2 ); ?> 0 36px"><?php echo esc_html( denisb_option( 'services_title' ) ); ?></h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:16px">
	<?php foreach ( denisb_posts( 'db_service' ) as $denisb_i => $denisb_s ) : ?>
      <div style="padding:28px;border-radius:20px;background:var(--surface);display:flex;flex-direction:column;gap:14px"><span style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--accent)"><?php echo esc_html( sprintf( '%02d', $denisb_i + 1 ) ); ?></span><h3 style="font-weight:500;font-size:22px;letter-spacing:-.02em;margin:0"><?php echo esc_html( get_the_title( $denisb_s ) ); ?></h3><p style="font-size:18px;line-height:1.6;margin:0;color:var(--body)"><?php echo esc_html( denisb_plain( $denisb_s ) ); ?></p></div>
	<?php endforeach; ?>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:28px">
	<?php foreach ( denisb_option_lines( 'stack' ) as $denisb_s ) : ?>
        <span style="font-family:'Geist Mono',monospace;font-size:15px;padding:8px 14px;border:1px solid var(--line2);border-radius:999px;color:var(--fg2)"><?php echo esc_html( $denisb_s['name'] ); ?></span>
	<?php endforeach; ?>
    </div>
  </section>

  <section id="process" data-screen-label="Process" style="scroll-margin-top:80px;padding:clamp(80px,10vw,140px) 0 0">
    <h2 style="<?php echo esc_attr( $denisb_h2 ); ?> 0 36px"><?php echo esc_html( denisb_option( 'process_title' ) ); ?></h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,230px),1fr));gap:clamp(24px,3vw,40px)">
	<?php foreach ( denisb_posts( 'db_step' ) as $denisb_i => $denisb_s ) : ?>
      <div style="display:flex;flex-direction:column;gap:12px;padding-top:20px;border-top:1px solid var(--line2)"><span style="font-family:'Instrument Serif',serif;font-size:44px;line-height:1;color:var(--accent)"><?php echo esc_html( denisb_roman( $denisb_i + 1 ) . '.' ); ?></span><h3 style="font-weight:500;font-size:19px;margin:0"><?php echo esc_html( get_the_title( $denisb_s ) ); ?></h3><p style="font-size:18px;line-height:1.6;margin:0;color:var(--body)"><?php echo esc_html( denisb_plain( $denisb_s ) ); ?></p></div>
	<?php endforeach; ?>
    </div>
  </section>

  <section data-screen-label="Experience" style="padding:clamp(80px,10vw,140px) 0 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr));gap:32px clamp(32px,5vw,72px)">
    <h2 style="<?php echo esc_attr( $denisb_h2 ); ?>"><?php echo esc_html( denisb_option( 'exp_title' ) ); ?></h2>
    <div style="display:flex;flex-direction:column;border-top:1px solid var(--line)">
	<?php foreach ( denisb_posts( 'db_experience' ) as $denisb_e ) : ?>
        <div style="display:grid;grid-template-columns:minmax(0,1fr) auto;gap:4px 24px;padding:18px 0;border-bottom:1px solid var(--line)">
          <span style="font-size:17px;font-weight:500"><?php echo esc_html( get_the_title( $denisb_e ) ); ?></span>
          <span style="font-family:'Geist Mono',monospace;font-size:14px;color:var(--muted);text-align:right;padding-top:4px"><?php echo esc_html( denisb_meta( 'when', $denisb_e ) ); ?></span>
          <span style="font-size:16px;color:var(--body);grid-column:1/-1"><?php echo esc_html( denisb_meta( 'role', $denisb_e ) ); ?></span>
          <p style="font-size:14px;line-height:1.55;color:var(--muted);grid-column:1/-1;margin:6px 0 0"><?php echo esc_html( denisb_plain( $denisb_e ) ); ?></p>
        </div>
	<?php endforeach; ?>
    </div>
  </section>

<?php $denisb_quotes = denisb_posts( 'db_testimonial' ); ?>
<?php if ( $denisb_quotes ) : ?>
  <section data-screen-label="Testimonials" style="padding:clamp(80px,10vw,140px) 0 0">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:16px">
	<?php foreach ( $denisb_quotes as $denisb_q ) : ?>
      <figure style="margin:0;padding:32px;border-radius:20px;border:1px solid var(--line);display:flex;flex-direction:column;justify-content:space-between;gap:28px">
        <blockquote style="margin:0;font-family:'Instrument Serif',serif;font-size:24px;line-height:1.3">“<?php echo esc_html( denisb_plain( $denisb_q ) ); ?>”</blockquote>
        <figcaption style="font-size:16px;color:var(--muted)"><?php echo esc_html( denisb_meta( 'cite', $denisb_q ) ); ?></figcaption>
      </figure>
	<?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

  <section id="faq" data-screen-label="FAQ" style="scroll-margin-top:80px;padding:clamp(80px,10vw,140px) 0 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr));gap:32px clamp(32px,5vw,72px)">
    <h2 style="<?php echo esc_attr( $denisb_h2 ); ?>"><?php echo esc_html( denisb_option( 'faq_title' ) ); ?></h2>
    <div style="display:flex;flex-direction:column;border-top:1px solid var(--line)">
	<?php foreach ( denisb_posts( 'db_faq' ) as $denisb_f ) : ?>
        <details style="border-bottom:1px solid var(--line)">
          <summary class="h-bb2b0e" style="display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 0;font-size:17px;font-weight:500"><?php echo esc_html( get_the_title( $denisb_f ) ); ?><span class="faq-plus" style="font-size:22px;font-weight:300;line-height:1;color:var(--accent);transition:transform .2s">+</span></summary>
          <p style="font-size:18px;line-height:1.65;margin:0;padding:0 0 22px;max-width:60ch;color:var(--body)"><?php echo esc_html( denisb_plain( $denisb_f ) ); ?></p>
        </details>
	<?php endforeach; ?>
    </div>
  </section>

</main>

<?php
get_footer( null, array( 'nav' => 'home' ) );
