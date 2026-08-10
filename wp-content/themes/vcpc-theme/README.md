# VCPC WordPress Theme

Hand-coded, one-page landing theme. No page builder, no ACF, no form plugin —
plain WordPress template hierarchy + a native meta box for editable copy.

## Install

1. Zip the `vcpc-theme` folder (or upload as-is) and install via
   **Appearance → Themes → Add New → Upload Theme**, then **Activate**.
2. Create a new Page (e.g. titled "Home") — content doesn't matter, the
   template ignores the editor body and renders `front-page.php` instead.
3. Go to **Settings → Reading → Your homepage displays → A static page**,
   and set that new Page as the homepage.
4. Reload the site — the full VCPC landing page renders.
5. Edit copy: open that same Page in wp-admin — you'll see a
   **"VCPC Landing Page Content"** box below the editor with every section's
   text as plain fields. No ACF required, it's a native custom meta box.
6. Form submissions land in **wp-admin → Journey Signups** (a private CPT),
   and also trigger an email to the site admin address.

## Notes

- GSAP is loaded from cdnjs for the scroll animations. If you need a fully
  offline/self-hosted build, download GSAP + ScrollTrigger into
  `assets/js/vendor/` and update the `wp_enqueue_script` URLs in
  `inc/enqueue.php`.
- Add real photography/video into `assets/images/` and reference it in the
  section templates (`section-hero.php`, `section-milan-teaser.php`, etc.) —
  currently those sections use CSS gradients as placeholders so the layout
  works before final assets arrive.
- Fonts: currently system serif/sans stack (`var(--font-display)` /
  `var(--font-body)` in `assets/css/main.css`). Swap in the brand's
  actual typeface — self-host the `.woff2` files rather than pulling
  from Google Fonts, for performance and privacy.
- CRM/ESP integration (Mailchimp, Klaviyo, etc.): hook into
  `do_action( 'vcpc_lead_saved', $lead_id, $data )` in `inc/rest-api.php`.
