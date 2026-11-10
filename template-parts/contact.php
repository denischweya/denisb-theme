<?php
/**
 * The lime "Have a product in mind?" contact band.
 *
 * @package DenisB_Theme
 */

$denisb_case  = 'case' === ( $args['nav'] ?? '' );
$denisb_email = denisb_option( 'contact_email', (string) get_option( 'admin_email' ) );
?>
<section id="contact" data-screen-label="Contact" style="scroll-margin-top:80px;margin-top:<?php echo $denisb_case ? 'clamp(72px,9vw,128px)' : 'clamp(80px,10vw,140px)'; ?>;width:100%;padding:clamp(72px,10vw,140px) clamp(20px,5vw,56px);background:#d4f36b;color:#0e0e0d;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:24px;text-align:center">
  <h2 style="font-family:'Bebas Neue',sans-serif;font-weight:400;font-size:clamp(56px,8vw,112px);line-height:.92;<?php echo $denisb_case ? '' : 'letter-spacing:.005em;'; ?>margin:0"><?php echo esc_html( denisb_option( 'contact_title', __( 'Have a product in mind?', 'denisb' ) ) ); ?></h2>
  <p style="font-size:18px;line-height:1.55;margin:0;max-width:48ch;color:#2a2e17"><?php echo esc_html( denisb_option( 'contact_text' ) ); ?></p>
  <a class="h-6f8b6b" href="<?php echo esc_url( 'mailto:' . $denisb_email ); ?>" style="display:inline-flex;align-items:center;justify-content:center;gap:12px;min-height:56px;padding:0 28px;border-radius:999px;background:#0e0e0d;color:#ecebe6;font-size:18px;font-weight:500"><?php echo esc_html( denisb_option( 'contact_label', __( 'Lets Talk!', 'denisb' ) ) ); ?> <?php echo denisb_icon( 'out', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
</section>
