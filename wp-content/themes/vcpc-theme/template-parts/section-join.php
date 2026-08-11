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
	?>
	<section class="section section--join" id="join">
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

						foreach ( $fields as $f ) :
							if ( empty( $f['field_name'] ) ) continue;
							$field_name = $f['field_name'];
							// Keep `name` attribute as admin-configured field identifier (used by REST handler),
							// but generate a safe `id` for label association.
							$safe_id = 'vcpc_' . sanitize_key( $field_name );
							$label = esc_html( $f['field_label'] );
							$type = esc_attr( $f['field_type'] );
							$required = ( ! empty( $f['field_required'] ) && strtolower( $f['field_required'] ) === 'yes' ) ? ' required' : '';
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
						<?php endforeach; ?>

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
