<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Reusable Metabox Handler class to create clean native meta boxes.
 */
class VCPC_Metabox {
	protected $id;
	protected $title;
	protected $prefix = '_vcpc_';
	protected $fields = [];

	protected $allowed_pages = [];

	public function __construct( $id, $title, $fields ) {
		$this->id     = $id;
		$this->title  = $title;
		$this->fields = $fields;

		add_action( 'add_meta_boxes', [ $this, 'register_metabox' ] );
		add_action( 'save_post', [ $this, 'save_metabox' ] );
	}

	public function register_metabox( $post_type, $post = null ) {
		if ( ! $post ) {
			global $post;
		}
		if ( ! $post ) {
			return;
		}

		if ( 'layout_settings' !== $this->id ) {
			// Retrieve allowed pages dynamically on runtime execution
			$allowed = vcpc_get_metabox_allowed_pages( $this->id );

			// Verify allowed rules match current post ID
			if ( ! empty( $allowed ) && ! in_array( (int) $post->ID, $allowed, true ) ) {
				return;
			}
		}

		add_meta_box(
			'vcpc_section_' . $this->id,
			$this->title,
			[ $this, 'render_metabox' ],
			'page',
			'normal',
			'high'
		);
	}

	public function render_metabox( $post ) {
		wp_nonce_field( 'vcpc_save_nonce_' . $this->id, 'vcpc_nonce_' . $this->id );

		foreach ( $this->fields as $field_key => $field_config ) {
			$meta_key = $this->prefix . $field_key;
			$val = get_post_meta( $post->ID, $meta_key, true );

			echo '<div class="vcpc-field-row" style="margin-bottom: 20px;">';
			echo '<label style="display:block; font-weight:bold; margin-bottom:5px;" for="' . esc_attr( $meta_key ) . '">' . esc_html( $field_config['label'] ) . '</label>';

			switch ( $field_config['type'] ) {
				case 'text':
					echo '<input type="text" class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $val ) . '" />';
					break;
				case 'textarea':
					echo '<textarea class="widefat" rows="4" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">' . esc_textarea( $val ) . '</textarea>';
					break;
				case 'media':
					$image_url = '';
					if ( $val ) {
						$image_url = wp_get_attachment_image_url( $val, 'thumbnail' );
					}
					echo '<div class="vcpc-single-media-uploader">';
					echo '<input type="hidden" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $val ) . '" />';
					echo '<div id="' . esc_attr( $meta_key ) . '-preview" class="vcpc-media-preview">';
					if ( $image_url ) {
						echo '<img src="' . esc_url( $image_url ) . '" style="max-width:150px; height:auto; display:block; margin-bottom:10px;" />';
					}
					echo '</div>';
					echo '<button type="button" class="button vcpc-single-media-upload-btn" data-target="' . esc_attr( $meta_key ) . '">' . esc_html__( 'Select Media', 'vcpc' ) . '</button> ';
					echo '<button type="button" class="button vcpc-single-media-remove-btn" data-remove-target="' . esc_attr( $meta_key ) . '" style="' . ( $val ? '' : 'display:none;' ) . '">' . esc_html__( 'Remove', 'vcpc' ) . '</button>';
					echo '</div>';
					break;
				case 'wysiwyg':
					wp_editor( $val, $meta_key, [
						'textarea_name' => $meta_key,
						'media_buttons' => false,
						'textarea_rows' => 6,
						'quicktags'     => true,
					] );
					break;
				case 'repeater':
					vcpc_render_repeater( $meta_key, $field_config['fields'], $val );
					break;
			}

			if ( ! empty( $field_config['desc'] ) ) {
				echo '<p class="description">' . esc_html( $field_config['desc'] ) . '</p>';
			}
			echo '</div>';
		}
	}

	public function save_metabox( $post_id ) {
		if ( ! isset( $_POST['vcpc_nonce_' . $this->id] ) || ! wp_verify_nonce( $_POST['vcpc_nonce_' . $this->id], 'vcpc_save_nonce_' . $this->id ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( $this->fields as $field_key => $field_config ) {
			$meta_key = $this->prefix . $field_key;
			
			if ( 'repeater' === $field_config['type'] ) {
				$raw_data = isset( $_POST['vcpc_fields'][ $meta_key ] ) ? $_POST['vcpc_fields'][ $meta_key ] : '';
				if ( empty( $raw_data ) ) {
					delete_post_meta( $post_id, $meta_key );
					continue;
				}

				$rows = json_decode( wp_unslash( $raw_data ), true );
				if ( ! is_array( $rows ) ) {
					delete_post_meta( $post_id, $meta_key );
					continue;
				}

				$sanitized_rows = [];
				foreach ( $rows as $row ) {
					$sanitized_row = [];
					foreach ( $field_config['fields'] as $sub_key => $sub_config ) {
						$sub_val = isset( $row[ $sub_key ] ) ? $row[ $sub_key ] : '';
						if ( 'media' === $sub_config['type'] ) {
							$sanitized_row[ $sub_key ] = absint( $sub_val );
						} elseif ( 'email' === $sub_config['type'] ) {
							$sanitized_row[ $sub_key ] = sanitize_email( $sub_val );
						} else {
							$sanitized_row[ $sub_key ] = wp_kses_post( $sub_val );
						}
					}
					$sanitized_rows[] = $sanitized_row;
				}

				update_post_meta( $post_id, $meta_key, wp_slash( wp_json_encode( $sanitized_rows, JSON_UNESCAPED_UNICODE ) ) );

			} else {
				if ( ! isset( $_POST[ $meta_key ] ) ) {
					continue;
				}

				$raw = wp_unslash( $_POST[ $meta_key ] );
				if ( 'media' === $field_config['type'] ) {
					$clean = absint( $raw );
				} else {
					$clean = wp_kses_post( $raw );
				}

				update_post_meta( $post_id, $meta_key, $clean );
			}
		}
	}
}
