<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading        = vcpc_field( 'join_heading', '' );
$sublines_json  = vcpc_field( 'join_sublines', '' );
$audience_json  = vcpc_field( 'join_audience_options', '' );
$submit_label   = vcpc_field( 'join_submit_label', '' );

$sublines = [];
if ( $sublines_json ) {
	$sublines = json_decode( $sublines_json, true );
}
if ( ! is_array( $sublines ) ) {
	$sublines = [];
}

$audience_options = [];
if ( $audience_json ) {
	$audience_options = json_decode( $audience_json, true );
}
if ( ! is_array( $audience_options ) ) {
	$audience_options = [];
}

// Show section only if data exists
if ( ! empty( $heading ) || ! empty( $submit_label ) ) :
	$bg_image_id  = vcpc_field( 'join_background_image', 0 );
	$bg_style = '';
	if ( $bg_image_id ) {
		$bg_url = wp_get_attachment_image_url( $bg_image_id, 'full' );
		if ( $bg_url ) {
			$bg_style = ' style="background-image: url(' . esc_url( $bg_url ) . ');"';
		}
	}
	?>
	<section class="section section--join parallax-bg" id="join"<?php echo $bg_style; ?>>
		<?php if ( $bg_image_id ) : ?>
			<div class="join__overlay"></div>
		<?php endif; ?>
		<div class="section__inner join__inner">
			<div class="join__grid">
				<div class="join__info" data-anim="fade-up">
					<?php if ( ! empty( $heading ) ) : ?>
						<h2 class="section__heading"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $sublines ) ) : ?>
						<div class="join__sublines">
							<?php foreach ( $sublines as $row ) : 
								if ( empty( $row['line'] ) ) continue;
								?>
								<p class="join__subline"><?php echo esc_html( $row['line'] ); ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="join__form-container" data-anim="fade-up">
					<form id="vcpc-journey-form" class="vcpc-form">
						<!-- Spam Honeypot -->
						<div style="display:none;">
							<input type="text" name="website" id="website" tabindex="-1" autocomplete="off" />
						</div>

						<?php
						$fields_json = vcpc_field( 'join_form_fields', '' );
						$fields = [];
						if ( $fields_json ) {
							$fields = json_decode( $fields_json, true );
						}

						// Fallback to default fields structure if admin hasn't edited fields yet
						if ( empty( $fields ) || ! is_array( $fields ) ) {
							$fields = [
								[ 'field_name' => 'first_name', 'field_label' => 'First Name *', 'field_type' => 'text', 'field_required' => 'yes' ],
								[ 'field_name' => 'last_name', 'field_label' => 'Last Name *', 'field_type' => 'text', 'field_required' => 'yes' ],
								[ 'field_name' => 'email', 'field_label' => 'Email Address *', 'field_type' => 'email', 'field_required' => 'yes' ],
								[ 'field_name' => 'mobile', 'field_label' => 'Mobile Number *', 'field_type' => 'tel', 'field_required' => 'yes' ],
								[ 'field_name' => 'country', 'field_label' => 'Country *', 'field_type' => 'text', 'field_required' => 'yes' ],
								[ 'field_name' => 'audience', 'field_label' => 'I am a *', 'field_type' => 'select', 'field_required' => 'yes' ],
							];
						}

						$indexed_fields = [];
						foreach ( $fields as $f ) {
							if ( ! empty( $f['field_name'] ) ) {
								$indexed_fields[ $f['field_name'] ] = $f;
							}
						}

						if ( ! function_exists( 'vcpc_render_form_field' ) ) {
							function vcpc_render_form_field( $field, $audience_options ) {
								if ( empty( $field ) ) return;
								$field_name = $field['field_name'];
								$safe_id = 'vcpc_' . sanitize_key( $field_name );
								$label = esc_html( $field['field_label'] );
								$type = esc_attr( $field['field_type'] );
								$required = ( ! empty( $field['field_required'] ) && strtolower( $field['field_required'] ) === 'yes' ) ? ' required' : '';
								?>
								<div class="form-group">
									<label for="<?php echo esc_attr( $safe_id ); ?>"><?php echo $label; ?></label>
									<?php if ( 'select' === $type ) : ?>
										<select name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( $safe_id ); ?>"<?php echo $required; ?>>
											<option value=""><?php _e( 'Select option...', 'vcpc' ); ?></option>
											<?php foreach ( $audience_options as $row ) : 
												if ( empty( $row['label'] ) ) continue;
												?>
												<option value="<?php echo esc_attr( $row['label'] ); ?>"><?php echo esc_html( $row['label'] ); ?></option>
											<?php endforeach; ?>
										</select>
									<?php else : ?>
										<input type="<?php echo $type; ?>" name="<?php echo esc_attr( $field_name ); ?>" id="<?php echo esc_attr( $safe_id ); ?>"<?php echo $required; ?> />
									<?php endif; ?>
									<span class="error-msg" id="err-<?php echo esc_attr( $field_name ); ?>"></span>
								</div>
								<?php
							}
						}
						?>

						<div class="form-row">
							<?php 
							if ( isset( $indexed_fields['first_name'] ) ) {
								vcpc_render_form_field( $indexed_fields['first_name'], $audience_options ); 
							}
							if ( isset( $indexed_fields['last_name'] ) ) {
								vcpc_render_form_field( $indexed_fields['last_name'], $audience_options ); 
							}
							?>
						</div>

						<div class="form-row">
							<?php 
							if ( isset( $indexed_fields['email'] ) ) {
								vcpc_render_form_field( $indexed_fields['email'], $audience_options ); 
							}
							?>
						</div>

						<div class="form-row">
							<?php 
							if ( isset( $indexed_fields['mobile'] ) ) {
								vcpc_render_form_field( $indexed_fields['mobile'], $audience_options ); 
							}
							if ( isset( $indexed_fields['country'] ) ) {
								vcpc_render_form_field( $indexed_fields['country'], $audience_options ); 
							}
							?>
						</div>

						<div class="form-row">
							<?php 
							if ( isset( $indexed_fields['audience'] ) ) {
								vcpc_render_form_field( $indexed_fields['audience'], $audience_options ); 
							}
							?>
						</div>

						<?php
						$explicit_keys = [ 'first_name', 'last_name', 'email', 'mobile', 'country', 'audience' ];
						foreach ( $fields as $f ) {
							if ( ! empty( $f['field_name'] ) && ! in_array( $f['field_name'], $explicit_keys, true ) ) {
								echo '<div class="form-row">';
								vcpc_render_form_field( $f, $audience_options );
								echo '</div>';
							}
						}
						?>

						<div class="form-submit-row">
							<button type="submit" id="vcpc-submit-btn" class="btn btn--primary btn--full">
								<span class="btn-text"><?php echo esc_html( $submit_label ); ?></span>
								<span class="btn-spinner" style="display:none;"></span>
							</button>
						</div>

						<div class="form-status-msg" id="form-general-msg"></div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
