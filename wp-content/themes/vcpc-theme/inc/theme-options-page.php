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

	// Metabox Location settings (holds allowed page IDs for each metabox section)
	register_setting( 'vcpc_theme_settings_group', 'vcpc_metabox_locations', [
		'sanitize_callback' => 'vcpc_sanitize_metabox_locations',
		'default'           => '',
	] );

	// Email Notification Settings
	register_setting( 'vcpc_theme_settings_group', 'vcpc_email_to', [
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_email_from', [
		'sanitize_callback' => 'vcpc_sanitize_email_from',
		'default'           => '',
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_email_subject', [
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	] );

	register_setting( 'vcpc_theme_settings_group', 'vcpc_email_body', [
		'sanitize_callback' => 'sanitize_textarea_field',
		'default'           => '',
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

function vcpc_sanitize_metabox_locations( $raw ) {
	if ( ! is_array( $raw ) ) {
		return wp_json_encode( [] );
	}
	$sanitized = [];
	foreach ( $raw as $metabox_id => $page_ids ) {
		$sanitized[ sanitize_key( $metabox_id ) ] = array_filter( array_map( 'absint', (array) $page_ids ) );
	}
	return wp_json_encode( $sanitized );
}

function vcpc_sanitize_email_from( $raw ) {
	if ( empty( $raw ) ) {
		return '';
	}
	$raw = wp_unslash( $raw );
	// Temporarily replace brackets so sanitize_text_field doesn't treat it as HTML
	$escaped = str_replace( [ '<', '>' ], [ '[lt]', '[gt]' ], $raw );
	$sanitized = sanitize_text_field( $escaped );
	return str_replace( [ '[lt]', '[gt]' ], [ '<', '>' ], $sanitized );
}

function vcpc_get_metabox_allowed_pages( $metabox_id ) {
	$locations_json = get_option( 'vcpc_metabox_locations', '' );
	if ( '' === $locations_json ) {
		// Default to static front page if no options have been configured/saved
		$front_id = (int) get_option( 'page_on_front' );
		return $front_id ? [ $front_id ] : [];
	}
	$locations = json_decode( $locations_json, true );
	if ( is_array( $locations ) ) {
		if ( isset( $locations[ $metabox_id ] ) ) {
			return $locations[ $metabox_id ];
		}
		// If page rules exist but this section is unselected, return empty so it remains disabled
		return [];
	}
	return [];
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

			$locations_json = get_option( 'vcpc_metabox_locations', '' );
			$locations = $locations_json ? json_decode( $locations_json, true ) : [];
			if ( ! is_array( $locations ) ) {
				$locations = [];
			}

			// Get all pages to select in locations
			$pages = get_pages();
			$sections = [
				'hero'         => 'Section: Hero',
				'philosophy'   => 'Section: Philosophy',
				'milan_teaser' => 'Section: From Milan Teaser',
				'coming_soon'  => 'Section: Coming Soon',
				'join'         => 'Section: Join the Journey',
				'story'        => 'Section: Story',
				'milan_full'   => 'Section: From Milan Full',
				'contact'      => 'Section: Contact'
			];
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

					<!-- Metabox Location Rules -->
					<tr>
						<th scope="row"><label><strong><?php _e( 'Metabox Locations (ACF Rules Style)', 'vcpc' ); ?></strong></label></th>
						<td>
							<p class="description" style="margin-bottom:15px;"><?php _e( 'Choose one or more specific pages where each landing section metabox should display. Keep unselected or choose "No pages selected" to disable.', 'vcpc' ); ?></p>
							<div style="background:#f6f7f7; border:1px solid #ccd0d4; padding:15px; max-width:800px;">
								<?php foreach ( $sections as $id => $title ) : 
									$selected = isset( $locations[ $id ] ) ? (array) $locations[ $id ] : [];
									?>
									<div style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #dcdcde;">
										<strong style="display:inline-block; width:220px;"><?php echo esc_html( $title ); ?>:</strong>
										<select name="vcpc_metabox_locations[<?php echo esc_attr( $id ); ?>][]" multiple style="width: 300px; height: 100px; vertical-align: middle;">
											<option value="" <?php selected( empty( $selected ) ); ?>><?php _e( '— No pages selected (Disabled) —', 'vcpc' ); ?></option>
											<?php foreach ( $pages as $p ) : ?>
												<option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( in_array( (int) $p->ID, $selected, true ) ); ?>>
													<?php echo esc_html( $p->post_title ); ?> (ID: <?php echo $p->ID; ?>)
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								<?php endforeach; ?>
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

					<!-- Email Notification Settings -->
					<tr>
						<th scope="row" colspan="2"><h2 style="margin-top:30px; border-bottom:1px solid #ccd0d4; padding-bottom:10px;"><?php _e( 'Lead Notification Email Settings', 'vcpc' ); ?></h2></th>
					</tr>
					<tr>
						<th scope="row"><label for="vcpc_email_to"><?php _e( 'To', 'vcpc' ); ?></label></th>
						<td>
							<input type="text" id="vcpc_email_to" name="vcpc_email_to" value="<?php echo esc_attr( get_option( 'vcpc_email_to', get_option( 'admin_email' ) ) ); ?>" class="large-text" />
							<p class="description"><?php _e( 'Recipient email address (e.g. inquiry@vipulchudasama.com).', 'vcpc' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="vcpc_email_from"><?php _e( 'From', 'vcpc' ); ?></label></th>
						<td>
							<input type="text" id="vcpc_email_from" name="vcpc_email_from" value="<?php echo esc_attr( get_option( 'vcpc_email_from', 'VCPC <' . get_option( 'admin_email' ) . '>' ) ); ?>" class="large-text" />
							<p class="description"><?php _e( 'From header (e.g. VCPC <info@vcpcworld.com>).', 'vcpc' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="vcpc_email_subject"><?php _e( 'Subject', 'vcpc' ); ?></label></th>
						<td>
							<input type="text" id="vcpc_email_subject" name="vcpc_email_subject" value="<?php echo esc_attr( get_option( 'vcpc_email_subject', 'Thank you for your interest in VCPC!' ) ); ?>" class="large-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="vcpc_email_body"><?php _e( 'Message Body', 'vcpc' ); ?></label></th>
						<td>
							<textarea id="vcpc_email_body" name="vcpc_email_body" rows="12" class="large-text" style="font-family:monospace;"><?php echo esc_textarea( get_option( 'vcpc_email_body', "A new registration request has been submitted with the following fields:\n\n[fields_content]" ) ); ?></textarea>
							<p class="description"><?php _e( 'Customize the body content. Use tags in square brackets matching your form field names (e.g. [first_name], [last_name], [email], [mobile], [country], [audience]) or use [fields_content] to output all fields.', 'vcpc' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
