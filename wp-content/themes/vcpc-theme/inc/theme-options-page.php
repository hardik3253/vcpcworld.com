<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Site-wide Options settings page "VCPC Theme Settings"
 * Registered via Settings API and stored in wp_options table.
 */
function vcpc_register_theme_settings_page() {
	add_menu_page(
		__( 'VCPC Theme Settings', 'vcpc' ),
		__( 'VCPC Settings', 'vcpc' ),
		'manage_options',
		'vcpc-theme-settings',
		'vcpc_render_theme_settings_page',
		'dashicons-admin-appearance',
		59
	);
}
add_action( 'admin_menu', 'vcpc_register_theme_settings_page' );

function vcpc_register_theme_settings() {
	register_setting( 'vcpc_theme_settings_group', 'vcpc_site_logo', [
		'sanitize_callback' => 'absint',
		'default'           => 0,
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_footer_tagline', [
		'sanitize_callback' => 'vcpc_sanitize_footer_tagline',
		'default'           => '',
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_social_links', [
		'sanitize_callback' => 'vcpc_sanitize_social_links',
		'default'           => '',
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_copyright_text', [
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '© VCPC',
	] );
}
add_action( 'admin_init', 'vcpc_register_theme_settings' );

function vcpc_sanitize_footer_tagline( $raw ) {
	if ( empty( $raw ) ) return '';
	$rows = json_decode( wp_unslash( $raw ), true );
	if ( ! is_array( $rows ) ) return '';
	
	$sanitized = [];
	foreach ( $rows as $row ) {
		if ( isset( $row['line'] ) ) {
			$sanitized[] = [ 'line' => sanitize_text_field( $row['line'] ) ];
		}
	}
	return wp_json_encode( $sanitized );
}

function vcpc_sanitize_social_links( $raw ) {
	if ( empty( $raw ) ) return '';
	$rows = json_decode( wp_unslash( $raw ), true );
	if ( ! is_array( $rows ) ) return '';

	$sanitized = [];
	foreach ( $rows as $row ) {
		$sanitized[] = [
			'platform' => isset( $row['platform'] ) ? sanitize_text_field( $row['platform'] ) : '',
			'url'      => isset( $row['url'] ) ? esc_url_raw( $row['url'] ) : '',
			'icon'     => isset( $row['icon'] ) ? absint( $row['icon'] ) : 0,
		];
	}
	return wp_json_encode( $sanitized );
}

function vcpc_render_theme_settings_page() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'vcpc_theme_settings_group' );
			do_settings_sections( 'vcpc-theme-settings' );
			
			$logo_id = get_option( 'vcpc_site_logo', 0 );
			$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

			$footer_tagline = get_option( 'vcpc_footer_tagline', '' );
			$social_links = get_option( 'vcpc_social_links', '' );
			$copyright = get_option( 'vcpc_copyright_text', '© VCPC' );
			?>

			<table class="form-table" role="presentation">
				<tbody>
					<!-- Site Logo -->
					<tr>
						<th scope="row"><label><?php _e( 'Site Logo', 'vcpc' ); ?></label></th>
						<td>
							<div class="vcpc-single-media-uploader">
								<input type="hidden" id="vcpc_site_logo" name="vcpc_site_logo" value="<?php echo esc_attr( $logo_id ); ?>" />
								<div id="vcpc_site_logo-preview" class="vcpc-media-preview">
									<?php if ( $logo_url ) : ?>
										<img src="<?php echo esc_url( $logo_url ); ?>" style="max-width:150px; height:auto; display:block; margin-bottom:10px;" />
									<?php endif; ?>
								</div>
								<button type="button" class="button vcpc-single-media-upload-btn" data-target="vcpc_site_logo"><?php _e( 'Select Logo', 'vcpc' ); ?></button>
								<button type="button" class="button vcpc-single-media-remove-btn" data-remove-target="vcpc_site_logo" style="<?php echo $logo_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove', 'vcpc' ); ?></button>
							</div>
						</td>
					</tr>

					<!-- Footer Tagline -->
					<tr>
						<th scope="row"><label><?php _e( 'Footer Tagline Lines', 'vcpc' ); ?></label></th>
						<td>
							<?php
							vcpc_render_repeater( 'vcpc_footer_tagline', [
								'line' => [ 'label' => __( 'Line text', 'vcpc' ), 'type' => 'text' ]
							], $footer_tagline, true );
							?>
						</td>
					</tr>

					<!-- Social Links -->
					<tr>
						<th scope="row"><label><?php _e( 'Social Links', 'vcpc' ); ?></label></th>
						<td>
							<?php
							vcpc_render_repeater( 'vcpc_social_links', [
								'platform' => [ 'label' => __( 'Platform Name', 'vcpc' ), 'type' => 'text' ],
								'url'      => [ 'label' => __( 'URL', 'vcpc' ), 'type' => 'url' ],
								'icon'     => [ 'label' => __( 'Icon (Optional)', 'vcpc' ), 'type' => 'media' ],
							], $social_links, true );
							?>
						</td>
					</tr>

					<!-- Copyright Text -->
					<tr>
						<th scope="row"><label for="vcpc_copyright_text"><?php _e( 'Copyright Text', 'vcpc' ); ?></label></th>
						<td>
							<input type="text" id="vcpc_copyright_text" name="vcpc_copyright_text" value="<?php echo esc_attr( $copyright ); ?>" class="regular-text" />
							<p class="description"><?php _e( 'The current year will be appended automatically in code.', 'vcpc' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
