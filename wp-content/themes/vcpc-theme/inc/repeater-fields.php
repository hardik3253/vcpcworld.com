<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shared repeater field renderer.
 * Saves values as a JSON encoded array of rows in post meta or option.
 */
function vcpc_render_repeater( $name, $fields, $existing_rows, $is_option = false ) {
	$rows = [];
	if ( ! empty( $existing_rows ) ) {
		if ( is_string( $existing_rows ) ) {
			$rows = json_decode( $existing_rows, true );
		} elseif ( is_array( $existing_rows ) ) {
			$rows = $existing_rows;
		}
	}
	if ( ! is_array( $rows ) ) {
		$rows = [];
	}

	$field_id = esc_attr( $name );
	$input_name = $is_option ? esc_attr( $name ) : 'vcpc_fields[' . esc_attr( $name ) . ']';
	$json_value = ! empty( $rows ) ? wp_json_encode( $rows, JSON_UNESCAPED_UNICODE ) : '';
	?>
	<div class="vcpc-repeater" data-field-name="<?php echo $field_id; ?>">
		<input type="hidden" class="vcpc-repeater-value" id="<?php echo $field_id; ?>" name="<?php echo $input_name; ?>" value="<?php echo esc_attr( $json_value ); ?>" />
		
		<div class="vcpc-repeater-rows">
			<?php if ( ! empty( $rows ) ) : ?>
				<?php foreach ( $rows as $index => $row_data ) : ?>
					<div class="vcpc-repeater-row" data-index="<?php echo $index; ?>">
						<div class="vcpc-repeater-drag-handle">☰</div>
						<div class="vcpc-repeater-row-fields">
							<?php foreach ( $fields as $field_key => $field_config ) : 
								$val = isset( $row_data[ $field_key ] ) ? $row_data[ $field_key ] : '';
								$input_id = $field_id . '_' . $index . '_' . $field_key;
								?>
								<div class="vcpc-repeater-field-wrapper type-<?php echo esc_attr( $field_config['type'] ); ?>">
									<label for="<?php echo $input_id; ?>"><?php echo esc_html( $field_config['label'] ); ?></label>
									<?php if ( 'textarea' === $field_config['type'] ) : ?>
										<textarea class="vcpc-repeater-input" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>"><?php echo esc_textarea( $val ); ?></textarea>
									<?php elseif ( 'media' === $field_config['type'] ) : ?>
										<div class="vcpc-media-uploader">
											<input type="hidden" class="vcpc-repeater-input vcpc-media-id" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>" value="<?php echo esc_attr( $val ); ?>" />
											<div class="vcpc-media-preview">
												<?php 
												if ( $val ) {
													echo wp_get_attachment_image( $val, 'thumbnail' );
												}
												?>
											</div>
											<button type="button" class="button vcpc-media-upload-btn"><?php _e( 'Select Image', 'vcpc' ); ?></button>
											<button type="button" class="button vcpc-media-remove-btn" style="<?php echo $val ? '' : 'display:none;'; ?>"><?php _e( 'Remove', 'vcpc' ); ?></button>
										</div>
									<?php else : ?>
										<input type="<?php echo esc_attr( $field_config['type'] ); ?>" class="vcpc-repeater-input" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>" value="<?php echo esc_attr( $val ); ?>" />
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
						<button type="button" class="button vcpc-repeater-delete-row">Delete</button>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<button type="button" class="button button-primary vcpc-repeater-add-row"><?php _e( 'Add Row', 'vcpc' ); ?></button>

		<template class="vcpc-repeater-template">
			<div class="vcpc-repeater-row" data-index="__INDEX__">
				<div class="vcpc-repeater-drag-handle">☰</div>
				<div class="vcpc-repeater-row-fields">
					<?php foreach ( $fields as $field_key => $field_config ) : 
						$input_id = $field_id . '__INDEX__' . $field_key;
						?>
						<div class="vcpc-repeater-field-wrapper type-<?php echo esc_attr( $field_config['type'] ); ?>">
							<label for="<?php echo $input_id; ?>"><?php echo esc_html( $field_config['label'] ); ?></label>
							<?php if ( 'textarea' === $field_config['type'] ) : ?>
								<textarea class="vcpc-repeater-input" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>"></textarea>
							<?php elseif ( 'media' === $field_config['type'] ) : ?>
								<div class="vcpc-media-uploader">
									<input type="hidden" class="vcpc-repeater-input vcpc-media-id" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>" value="" />
									<div class="vcpc-media-preview"></div>
									<button type="button" class="button vcpc-media-upload-btn"><?php _e( 'Select Image', 'vcpc' ); ?></button>
									<button type="button" class="button vcpc-media-remove-btn" style="display:none;"><?php _e( 'Remove', 'vcpc' ); ?></button>
								</div>
							<?php else : ?>
								<input type="<?php echo esc_attr( $field_config['type'] ); ?>" class="vcpc-repeater-input" data-field="<?php echo esc_attr( $field_key ); ?>" id="<?php echo $input_id; ?>" value="" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button vcpc-repeater-delete-row">Delete</button>
			</div>
		</template>
	</div>
	<?php
}
